<?php

//namespace app\control\base;
use Adianti\Base\TStandardList;
use Adianti\Control\TAction;
use Adianti\Core\AdiantiCoreTranslator;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TAlert;
use Adianti\Widget\Dialog\TMessage;
//use Exception;

/**
 * Eduardo Soares
 * Arquivo: TStandardFormListWAM.php
 * Projeto: sobcontrole
 * Alterado em 05/12/2015, 16:47
 */



class TStandardListWAM extends TStandardList
{
    protected $form;      // formulário de cadastro
    //protected $datagrid;  // listagem
    //protected $loaded;
    //protected $pageNavigation;  // pagination component


    public function __construct()
    {
        parent::__construct();
    }

    public function onInlineEdit($param)
    {
        try
        {
            // get the parameter $key
            $field = $param['field'];
            $key   = $param['key'];
            $value = $param['value'];

            // open a transaction with database
            TTransaction::open($this->database);

            // instantiates object {ACTIVE_RECORD}
            $class = $this->activeRecord;

            // instantiates object
            $object = new $class($key);

            // deletes the object from the database
            $object->{$field} = $value;
            $object->store();

            // close the transaction
            TTransaction::close();

            // reload the listing
            $this->onReload($param);
            // shows the success message
            parent::add(new TAlert('info', AdiantiCoreTranslator::translate('Record updated')));

        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }

    public function Delete($param)
    {
        try
        {
            // get the parameter $key
            $key=$param['key'];
            // open a transaction with database
            TTransaction::open($this->database);

            $class = $this->activeRecord;

            // instantiates object
            $object = new $class($key, FALSE);

            // deletes the object from the database
            $object->delete();

            // close the transaction
            TTransaction::close();

            // reload the listing
            $this->onReload( $param );
            // shows the success message

            //new TMessage('info', AdiantiCoreTranslator::translate('Record deleted'));
            parent::add(new TAlert('info', AdiantiCoreTranslator::translate('Record deleted')));

        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }

    public function deleteCollection($param)
    {
        // decode json with record id's
        $selected = json_decode($param['selected']);

        try
        {
            TTransaction::open($this->database);
            if ($selected)
            {
                // delete each record from collection
                foreach ($selected as $id)
                {
                    $class = $this->activeRecord;
                    $object = new $class;
                    $object->delete( $id );
                }
                $posAction = new TAction(array($this, 'onReload'));
                $posAction->setParameters( $param );
                parent::add(new TAlert('info', AdiantiCoreTranslator::translate('Records deleted'), $posAction));
            }
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
}
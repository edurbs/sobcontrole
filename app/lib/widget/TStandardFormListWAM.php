<?php
/**
 * Eduardo Soares
 * Arquivo: TStandardFormListWAM.php
 * Projeto: sobcontrole
 * Alterado em 05/12/2015, 16:47
 */



class TStandardFormListWAM extends TStandardFormList
{
    protected $form;      // formulário de cadastro
    protected $datagrid;  // listagem
    protected $loaded;
    protected $pageNavigation;  // pagination component


    public function __construct()
    {
        parent::__construct();
    }

    public function onSave()
    {
        try
        {
            // open a transaction with database
            TTransaction::open($this->database);

            // get the form data
            $object = $this->form->getData($this->activeRecord);

            // validate data
            $this->form->validate();

            // stores the object
            $object->store();

            // fill the form with the active record data
            $this->form->setData($object);

            // close the transaction
            TTransaction::close();

            // shows the success message
            //new TMessage('info', AdiantiCoreTranslator::translate('Record saved'));
            parent::add(new TAlert('info', AdiantiCoreTranslator::translate('Record saved')));

            // reload the listing
            $this->onReload();

            return $object;
        }
        catch (Exception $e) // in case of exception
        {
            // get the form data
            $object = $this->form->getData($this->activeRecord);

            // fill the form with the active record data
            $this->form->setData($object);

            // shows the exception error message
            new TMessage('error', $e->getMessage());

            // undo all pending operations
            TTransaction::rollback();
        }
    }
}
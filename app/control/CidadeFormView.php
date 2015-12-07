<?php


use Adianti\Database\TTransaction;
use Adianti\Validator\TRequiredValidator;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Wrapper\TDBSeekButton;

class CidadeFormView extends TStandardFormWAM
{
    protected $form;
    protected $nomeuf;

    function __construct()
    {
        parent::__construct();

        parent::setDatabase(APPLICATION_NAME);
        parent::setActiveRecord('cidade');

        $this->form = new \Adianti\Widget\Wrapper\TQuickForm('form_cidade');
        $this->form->class = 'tform';
        $this->form->style = 'width: 100%';

        $this->form->setFormTitle('Cadastro Estados (Cidade)');

        $id = new \Adianti\Widget\Form\TEntry('idcidade');
        $nome= new \Adianti\Widget\Form\TEntry('nome');

        //*******
        //Entry com resultado da busca
        $nomeuf  = new TEntry('nomeuf');

        //*******
        //Entry com botão de busca
        $iduf    = new TDBSeekButton('iduf', 'sobcontrole', $this->form->getName(), 'uf', 'nome', 'iduf', 'nomeuf');


        $id->setEditable(FALSE);
        $iduf->setEditable(TRUE);
        $nomeuf->setEditable(FALSE);


        $iduf->addValidation('UF', new TRequiredValidator);

        $this->form->addQuickField('ID',$id,100);
        $this->form->addQuickField('Nome',$nome, 100);
        $this->form->addQuickField('UF',$iduf,100);
        $this->form->addQuickField('Estado',$nomeuf,100);

        $this->form->addQuickAction('Salvar',new \Adianti\Control\TAction(array($this,'onSave')),'ico_save.png');
        $this->form->addQuickAction('Novo',new \Adianti\Control\TAction(array($this,'onClear')),'ico_new.png');
        $this->form->addQuickAction('Listar',new \Adianti\Control\TAction(array('CidadeDataGrid','onReload')),'ico_datagrid.png');

        $vbox = new \Adianti\Widget\Container\TVBox();
        $vbox->add(new \Adianti\Widget\Util\TXMLBreadCrumb('menu.xml',__CLASS__));
        $vbox->add($this->form);

        parent::add($vbox);

        $this->nomeuf=$nomeuf;
    }

    function onEdit($param)
    {
        try
        {
            TTransaction::open(APPLICATION_NAME);

            if (isset($param['key']))
            {
                //recebe codigo
                $key = $param['key'];

                //abre cidade com codigo recebido
                $cidade = new cidade($key);
                $this->form->setData($cidade); // fill the form with the active record data

                //abre UF com codigo da UF da cidade
                $uf=$cidade->get_uf();

                //exibe o nome da UF no formulário
                $this->nomeuf->setValue($uf->nome);

                //$this->onReload( $param ); // reload sale items list
                TTransaction::close(); // close transaction
            }
            else
            {
                $this->form->clear();

                //$this->onReload( $param );
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', '<b>Error</b> ' . $e->getMessage());
            TTransaction::rollback();
        }
    }
}
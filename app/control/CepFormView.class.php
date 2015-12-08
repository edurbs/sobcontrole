<?php


use Adianti\Database\TTransaction;
use Adianti\Validator\TRequiredValidator;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Wrapper\TDBSeekButton;

class CepFormView extends TStandardFormWAM
{
    protected $form;
    protected $logradouro;
    protected $cidade;

    function __construct()
    {
        parent::__construct();

        parent::setDatabase(APPLICATION_NAME);
        parent::setActiveRecord('cep');

        $this->form = new \Adianti\Widget\Wrapper\TQuickForm('form_cep');
        $this->form->class = 'tform';
        $this->form->style = 'width: 100%';

        $this->form->setFormTitle('Cadastro CEP');

        $cep = new \Adianti\Widget\Form\TEntry('idcep');

        $logradouro= new \Adianti\Widget\Form\TEntry('logradouro');
        $idtipologradouro= new TDBSeekButton('idtipologradouro', 'sobcontrole', $this->form->getName(), 'tipologradouro', 'descricao', 'idtipologradouro', 'logradouro');
        $idtipologradouro->addValidation('idtipologradouro', new TRequiredValidator);
        $idtipologradouro->setSize(50);
        $logradouro->setEditable(FALSE);

        $bairro= new \Adianti\Widget\Form\TEntry('bairro');

        $cidade= new \Adianti\Widget\Form\TEntry('cidade');
        $cidade->setEditable(FALSE);
        //$idcidade= new TDBSeekButton('idcidade', 'sobcontrole', $this->form->getName(), 'cidade', 'cidade', 'idcidade', 'cidade');
        $idcidade= new TDBSeekButton2('idcidade', 'sobcontrole', $this->form->getName(), 'cidade', 'cidade', 'idcidade', 'cidade', NULL, 'uf->nome');
        $idcidade->addValidation('idcidade', new TRequiredValidator);
        $idcidade->setSize(50);

        $this->form->addQuickField('CEP',$cep,50);
        $this->form->addQuickFields('Tipo Logradouro',array($idtipologradouro, $logradouro));
        $this->form->addQuickField('Bairro',$bairro,100);
        $this->form->addQuickFields('Cidade',array($idcidade, $cidade));

        $this->form->addQuickAction('Salvar',new \Adianti\Control\TAction(array($this,'onSave')),'ico_save.png');
        $this->form->addQuickAction('Novo',new \Adianti\Control\TAction(array($this,'onClear')),'ico_new.png');
        $this->form->addQuickAction('Listar',new \Adianti\Control\TAction(array('CepDataGrid','onReload')),'ico_datagrid.png');

        $vbox = new \Adianti\Widget\Container\TVBox();
        $vbox->add(new \Adianti\Widget\Util\TXMLBreadCrumb('menu.xml',__CLASS__));
        $vbox->add($this->form);

        parent::add($vbox);

        $this->logradouro=$logradouro;
        $this->cidade=$cidade;
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

                //abre cep com codigo recebido
                $cep = new cep($key);
                $this->form->setData($cep); // fill the form with the active record data

                //abre cidade com codigo da cidade da tabela cep e
                //exibe o nome da UF no formulário
                $this->cidade->setValue($cep->get_cidade()->nome);

                $this->logradouro->setValue($cep->get_tipologradouro()->descricao);

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
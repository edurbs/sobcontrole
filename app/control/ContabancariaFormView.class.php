<?php


use Adianti\Database\TTransaction;
use Adianti\Validator\TRequiredValidator;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Wrapper\TDBSeekButton;

class ContabancariaFormView extends TStandardFormWAM
{
    protected $form, $nomebanco, $nomecidade, $descricaotipocontabancaria;

    function __construct()
    {
        parent::__construct();

        // @todo verificar se APPLICATION_NAME realmente não funciona no hostinger
        parent::setDatabase(APPLICATION_NAME);
        parent::setActiveRecord('contabancaria');

        $this->form = new \Adianti\Widget\Wrapper\TQuickForm('form_contabancaria');
        $this->form->class = 'tform';
        $this->form->style = 'width: 100%';

        $this->form->setFormTitle('Cadastro Contas Bancárias)');

        $id = new \Adianti\Widget\Form\TEntry('idcontabancaria');
        $id->setEditable(FALSE);

        $agencia= new \Adianti\Widget\Form\TEntry('agencia');
        $agencia->addValidation('agencia', new TRequiredValidator);
        $conta= new \Adianti\Widget\Form\TEntry('conta');
        $conta->addValidation('conta', new TRequiredValidator);

        $banco_idbanco= new TDBSeekButton('banco_idbanco', 'sobcontrole', $this->form->getName(), 'banco', 'nome', 'banco_idbanco', 'nomebanco');
        $banco_idbanco->setSize(50);
        $banco_idbanco->addValidation('banco', new TRequiredValidator);
        $nomebanco = new TEntry('nomebanco');
        $nomebanco->setEditable(FALSE);

        $tipocontabancaria_idtipocontabancaria= new TDBSeekButton('tipocontabancaria_idtipocontabancaria', 'sobcontrole', $this->form->getName(), 'tipocontabancaria', 'descricao', 'tipocontabancaria_idtipocontabancaria', 'descricaotipocontabancaria');
        $tipocontabancaria_idtipocontabancaria->setSize(50);
        $tipocontabancaria_idtipocontabancaria->addValidation('tipocontabancaria', new TRequiredValidator);
        $descricaotipocontabancaria = new TEntry('descricaotipocontabancaria');
        $descricaotipocontabancaria->setEditable(FALSE);

        $titular= new \Adianti\Widget\Form\TEntry('titular');


        //Entry com botão de busca de cidade
        $idcidade= new TDBSeekButton('idcidade', 'sobcontrole', $this->form->getName(), 'cidade', 'nome', 'idcidade', 'nomecidade');
        $idcidade->setSize(50);
        //$idcidade->addValidation('cidade', new TRequiredValidator);
        //Entry com resultado da buscade cidade
        $nomecidade  = new TEntry('nomecidade');
        $nomecidade->setEditable(FALSE);

        $this->form->addQuickField('ID',$id);
        $this->form->addQuickField('Agência',$agencia);
        $this->form->addQuickField('Conta',$conta);
        $this->form->addQuickFields('Banco',array($banco_idbanco, $nomebanco));
        $this->form->addQuickFields('Tipo Conta',array($tipocontabancaria_idtipocontabancaria, $descricaotipocontabancaria));
        $this->form->addQuickField('Titular nº',$titular, 50);
        $this->form->addQuickFields('Cidade',array($idcidade, $nomecidade));

        $this->form->addQuickAction('Salvar',new \Adianti\Control\TAction(array($this,'onSave')),'ico_save.png');
        $this->form->addQuickAction('Novo',new \Adianti\Control\TAction(array($this,'onClear')),'ico_new.png');
        $this->form->addQuickAction('Listar',new \Adianti\Control\TAction(array('ContabancariaDataGrid','onReload')),'ico_datagrid.png');

        $vbox = new \Adianti\Widget\Container\TVBox();
        $vbox->add(new \Adianti\Widget\Util\TXMLBreadCrumb('menu.xml',__CLASS__));
        $vbox->add($this->form);

        parent::add($vbox);


        $this->nomecidade=$nomecidade;
        $this->descricaotipocontabancaria=$descricaotipocontabancaria;
        $this->nomebanco=$nomebanco;
    }

    function onEdit($param)
    {
        try
        {
            TTransaction::open(APPLICATION_NAME);

            if (isset($param['key']))
            {
                //abre contabancaria com codigo recebido da listagem
                $contabancaria = new contabancaria($param['key']);

                $this->form->setData($contabancaria); // fill the form with the active record data

                //exibe FK no formulario
                $this->nomecidade->setValue($contabancaria->get_cidade()->nome);
                $this->nomebanco->setValue($contabancaria->get_banco()->nome);
                $this->descricaotipocontabancaria->setValue($contabancaria->get_tipocontabancaria()->descricao);

                TTransaction::close(); // close transaction
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', '<b>Error</b> ' . $e->getMessage());
            TTransaction::rollback();
        }
    }
}
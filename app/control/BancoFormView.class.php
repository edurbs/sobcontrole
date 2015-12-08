<?php


class BancoFormView extends TStandardFormWAM
{
    protected $form;

    function __construct()
    {
        parent::__construct();

        parent::setDatabase('sobcontrole');
        parent::setActiveRecord('banco');

        $this->form = new \Adianti\Widget\Wrapper\TQuickForm('form_banco');
        $this->form->class = 'tform';
        $this->form->style = 'width: 100%';

        $this->form->setFormTitle('Cadastro Banco');
        $id = new \Adianti\Widget\Form\TEntry('idbanco');
        $id->addValidation('ID', new TRequiredValidator);
        //$id->setEditable(FALSE);

        $nome= new \Adianti\Widget\Form\TEntry('nome');
        $nome->addValidation('nome', new TRequiredValidator);

        $sigla = new \Adianti\Widget\Form\TEntry('sigla');
        $sigla->addValidation('sigla', new TRequiredValidator);


        $this->form->addQuickField('ID',$id,50);
        $this->form->addQuickField('Nome',$nome, 250);
        $this->form->addQuickField('Sigla',$sigla, 100);


        $this->form->addQuickAction('Salvar',new \Adianti\Control\TAction(array($this,'onSave')),'ico_save.png');
        $this->form->addQuickAction('Novo',new \Adianti\Control\TAction(array($this,'onClear')),'ico_new.png');
        $this->form->addQuickAction('Listar',new \Adianti\Control\TAction(array('BancoDataGrid','onReload')),'ico_datagrid.png');

        $vbox = new \Adianti\Widget\Container\TVBox();
        $vbox->add(new \Adianti\Widget\Util\TXMLBreadCrumb('menu.xml',__CLASS__));
        $vbox->add($this->form);

        parent::add($vbox);
    }
}
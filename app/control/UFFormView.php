<?php


class UFFormView extends TStandardFormWAM
{
    protected $form;

    function __construct()
    {
        parent::__construct();

        parent::setDatabase('sobcontrole');
        parent::setActiveRecord('uf');

        $this->form = new \Adianti\Widget\Wrapper\TQuickForm('form_uf');
        $this->form->class = 'tform';
        $this->form->style = 'width: 100%';

        $this->form->setFormTitle('Cadastro Estados (UF)');

        $id = new \Adianti\Widget\Form\TEntry('iduf');
        $nome= new \Adianti\Widget\Form\TEntry('nome');
        //$id->setEditable(FALSE);



        $this->form->addQuickField('UF',$id,100);
        $this->form->addQuickField('Nome',$nome, 100);

        $this->form->addQuickAction('Salvar',new \Adianti\Control\TAction(array($this,'onSave')),'ico_save.png');
        $this->form->addQuickAction('Novo',new \Adianti\Control\TAction(array($this,'onClear')),'ico_new.png');
        $this->form->addQuickAction('Listar',new \Adianti\Control\TAction(array('UFDataGrid','onReload')),'ico_datagrid.png');

        $vbox = new \Adianti\Widget\Container\TVBox();
        $vbox->add(new \Adianti\Widget\Util\TXMLBreadCrumb('menu.xml',__CLASS__));
        $vbox->add($this->form);

        parent::add($vbox);
    }
}
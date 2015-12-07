<?php


class TipoContaBancariaFormView extends TStandardFormWAM
{
    protected $form;

    function __construct()
    {
        parent::__construct();

        parent::setDatabase('sobcontrole');
        parent::setActiveRecord('tipocontabancaria');

        $this->form = new \Adianti\Widget\Wrapper\TQuickForm('TipoContaBancariaFormView');
        $this->form->class = 'tform';
        $this->form->style = 'width: 500px';

        $this->form->setFormTitle('Cadastro Tipos de Conta Bancária');

        $id = new \Adianti\Widget\Form\TEntry('idtipocontabancaria');
        $descricao= new \Adianti\Widget\Form\TEntry('descricao');        
        $id->setEditable(FALSE);

        $this->form->addQuickField('ID',$id,100);
        $this->form->addQuickField('Descrição',$descricao, 100);        
        $this->form->addQuickAction('Salvar',new \Adianti\Control\TAction(array($this,'onSave')),'ico_save.png');
        $this->form->addQuickAction('Novo',new \Adianti\Control\TAction(array($this,'onClear')),'ico_new.png');
        $this->form->addQuickAction('Listar',new \Adianti\Control\TAction(array('TipoContaBancariaDataGrid','onReload')),'ico_datagrid.png');

        $vbox = new \Adianti\Widget\Container\TVBox();
        $vbox->add(new \Adianti\Widget\Util\TXMLBreadCrumb('menu.xml',__CLASS__));
        $vbox->add($this->form);

        parent::add($vbox);
    }
}
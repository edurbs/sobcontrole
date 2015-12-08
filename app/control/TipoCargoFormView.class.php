<?php


class TipoCargoFormView extends TStandardFormWAM
{
    protected $form;

    function __construct()
    {
        parent::__construct();

        parent::setDatabase('sobcontrole');
        parent::setActiveRecord('tipocargo');

        $this->form = new \Adianti\Widget\Wrapper\TQuickForm('TipoCargoFormView');
        $this->form->class = 'tform';
        $this->form->style = 'width: 500px';

        $this->form->setFormTitle('Cadastro Tipos de Cargo');

        $id = new \Adianti\Widget\Form\TEntry('idtipocargo');
        $id->setEditable(FALSE);
        $descricao= new \Adianti\Widget\Form\TEntry('descricao');
        $descricao->addValidation('descricao', new TRequiredValidator);


        $this->form->addQuickField('ID',$id,100);
        $this->form->addQuickField('Descrição',$descricao, 100);        
        $this->form->addQuickAction('Salvar',new \Adianti\Control\TAction(array($this,'onSave')),'ico_save.png');
        $this->form->addQuickAction('Novo',new \Adianti\Control\TAction(array($this,'onClear')),'ico_new.png');
        $this->form->addQuickAction('Listar',new \Adianti\Control\TAction(array('TipoCargoDataGrid','onReload')),'ico_datagrid.png');

        $vbox = new \Adianti\Widget\Container\TVBox();
        $vbox->add(new \Adianti\Widget\Util\TXMLBreadCrumb('menu.xml',__CLASS__));
        $vbox->add($this->form);

        parent::add($vbox);
    }
}
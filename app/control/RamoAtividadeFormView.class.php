<?php


class RamoAtividadeFormView extends TStandardFormWAM
{
    protected $form;

    function __construct()
    {
        parent::__construct();

        parent::setDatabase('sobcontrole');
        parent::setActiveRecord('ramoatividade');

        $this->form = new \Adianti\Widget\Wrapper\TQuickForm('RamoAtividadeFormView');
        $this->form->class = 'tform';
        $this->form->style = 'width: 500px';

        $this->form->setFormTitle('Cadastro Ramos de atividade');

        $id = new \Adianti\Widget\Form\TEntry('idramoatividade');
        $id->setEditable(FALSE);
        $descricao= new \Adianti\Widget\Form\TEntry('descricao');
        $descricao->addValidation('descricao', new TRequiredValidator);


        $this->form->addQuickField('ID',$id,100);
        $this->form->addQuickField('Descrição',$descricao, 100);        
        $this->form->addQuickAction('Salvar',new \Adianti\Control\TAction(array($this,'onSave')),'ico_save.png');
        $this->form->addQuickAction('Novo',new \Adianti\Control\TAction(array($this,'onClear')),'ico_new.png');
        $this->form->addQuickAction('Listar',new \Adianti\Control\TAction(array('RamoAtividadeDataGrid','onReload')),'ico_datagrid.png');

        $vbox = new \Adianti\Widget\Container\TVBox();
        $vbox->add(new \Adianti\Widget\Util\TXMLBreadCrumb('menu.xml',__CLASS__));
        $vbox->add($this->form);

        parent::add($vbox);
    }
}
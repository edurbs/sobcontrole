<?php
use Adianti\Base\TStandardList;

class RamoAtividadeDataGrid extends TStandardListWAM
{
    protected $form;
    protected $datagrid;
    protected $pageNavigation;


    public function __construct()
    {
        parent::__construct();
        
        parent::setDatabase('sobcontrole');
        parent::setActiveRecord('ramoatividade');
        parent::setFilterField('descricao');
        parent::setDefaultOrder('descricao','asc');

        /** @var TQuickForm $this */
        $this->form = new \Adianti\Widget\Wrapper\TQuickForm('RamoAtividadeDataGrid');
        $this->form->setFormTitle('Cadastro Ramos de atividade');
        $this->form->class='tform';

        $descricao = new \Adianti\Widget\Form\TEntry('descricao');
        $this->form->addQuickField('Descrição: ', $descricao, 100);
        $this->form->addQuickAction('Buscar',new \Adianti\Control\TAction(array($this, 'onSearch')),'ico_find.png');
        $this->form->addQuickAction('Novo',new \Adianti\Control\TAction(array('RamoAtividadeFormView','onClear')),'ico_new.png');

        $this->form->setData(\Adianti\Registry\TSession::getValue('ramoatividade_filtro'));

        $this->datagrid = new \Adianti\Widget\Wrapper\TQuickGrid;
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(230);

        $this->datagrid->addQuickColumn('ID','idramoatividade','right',40,new \Adianti\Control\TAction(array($this,'onReload')),array('order','idramoatividade'));
        $this->datagrid->addQuickColumn('Descrição','descricao','right',40,new \Adianti\Control\TAction(array($this,'onReload')),array('order','descricao'));
        $this->datagrid->addQuickAction('Editar',new \Adianti\Widget\Datagrid\TDataGridAction(array('RamoAtividadeFormView','onEdit')),'idramoatividade','ico_edit.png');
        $this->datagrid->addQuickAction('Excluir',new \Adianti\Widget\Datagrid\TDataGridAction(array($this,'onDelete')),'idramoatividade','ico_delete.png');

        $this->datagrid->createModel();

        $this->pageNavigation = new \Adianti\Widget\Datagrid\TPageNavigation;
        $this->pageNavigation->setAction(new \Adianti\Control\TAction(array($this,'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $vbox= new TVBox;
        $vbox->add(new \Adianti\Widget\Util\TXMLBreadCrumb('menu.xml','RamoAtividadeFormView'));
        $vbox->add($this->form);
        $vbox->add($this->datagrid);
        $vbox->add($this->pageNavigation);

        parent::add($vbox);

    }
    
}


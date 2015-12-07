<?php
use Adianti\Base\TStandardList;

class CidadeDataGrid extends TStandardListWAM
{
    protected $form;
    protected $datagrid;
    protected $pageNavigation;


    public function __construct()
    {
        parent::__construct();
        
        parent::setDatabase(APPLICATION_NAME);
        parent::setActiveRecord('cidade');
        parent::setFilterField('nome');
        parent::setDefaultOrder('nome','asc');

        /** @var TQuickForm $this */
        $this->form = new \Adianti\Widget\Wrapper\TQuickForm('CidadeDataGrid');
        $this->form->setFormTitle('Cadastro Cidades');
        $this->form->class='tform';

        $nome = new \Adianti\Widget\Form\TEntry('nome');
        $this->form->addQuickField('Nome: ', $nome, 100);
        $this->form->addQuickAction('Buscar',new TAction(array($this, 'onSearch')),'ico_find.png');
        $this->form->addQuickAction('Novo',new TAction(array('CidadeFormView','onClear')),'ico_new.png');

        $this->form->setData(\Adianti\Registry\TSession::getValue('cidade_filtro'));

        $this->datagrid = new \Adianti\Widget\Wrapper\TQuickGrid;
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(230);

        //$this->datagrid->addQuickColumn('ID','idcidade','right',40,new TAction(array($this,'onReload')),array('order','idcidade'));
        $this->datagrid->addQuickColumn('Nome','nome','right',40,new TAction(array($this,'onReload')),array('order','nome'));
        //$this->datagrid->addQuickColumn('UF','iduf','right',40,new TAction(array($this,'onReload')),array('order','iduf'));

        $this->datagrid->addQuickColumn('Estado','uf->nome','right',40,new TAction(array($this,'onReload')),array('order','uf->nome'));

        $this->datagrid->addQuickAction('Editar',new TDataGridAction(array('CidadeFormView','onEdit')),'idcidade','ico_edit.png');
        $this->datagrid->addQuickAction('Excluir',new TDataGridAction(array($this,'onDelete')),'idcidade','ico_delete.png');

        $this->datagrid->createModel();

        $this->pageNavigation = new \Adianti\Widget\Datagrid\TPageNavigation;
        $this->pageNavigation->setAction(new \Adianti\Control\TAction(array($this,'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $vbox= new TVBox;
        $vbox->add(new \Adianti\Widget\Util\TXMLBreadCrumb('menu.xml',__CLASS__));
        $vbox->add($this->form);
        $vbox->add($this->datagrid);
        $vbox->add($this->pageNavigation);

        parent::add($vbox);

    }
    
}


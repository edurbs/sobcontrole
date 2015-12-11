<?php

class PessoaDataGrid extends TStandardListWAM
{
    protected $form;
    protected $datagrid;
    protected $pageNavigation;


    public function __construct()
    {
        parent::__construct();
        
        parent::setDatabase(APPLICATION_NAME);
        parent::setActiveRecord('pessoa');
        parent::setFilterField('nome');
        parent::setDefaultOrder('nome','asc');

        /** @var TQuickForm $this */
        $this->form = new \Adianti\Widget\Wrapper\TQuickForm('PessoaDataGrid');
        $this->form->setFormTitle('Cadastro de Pessoas');
        $this->form->class='tform';

        $nome = new \Adianti\Widget\Form\TEntry('nome');
        $this->form->addQuickField('Nome: ', $nome, 300);
        $this->form->addQuickAction('Buscar',new TAction(array($this, 'onSearch')),'ico_find.png');
        $this->form->addQuickAction('Novo',new TAction(array('PessoaFormView','onClear')),'ico_new.png');

        $this->form->setData(\Adianti\Registry\TSession::getValue('pessoa_filtro'));

        $this->datagrid = new \Adianti\Widget\Wrapper\TQuickGrid;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(230);

        //$this->datagrid->addQuickColumn('ID','idpessoa','right',40,new TAction(array($this,'onReload')),array('order','idpessoa'));
        $this->datagrid->addQuickColumn('Nome','nome','right',300,new TAction(array($this,'onReload')),array('order','nome'));
        $this->datagrid->addQuickColumn('Natureza','natureza','right',50,new TAction(array($this,'onReload')),array('order','natureza'));
        $this->datagrid->addQuickColumn('Dt.Cadastro','dtcadastro','right',40,new TAction(array($this,'onReload')),array('order','dtcadastro'));
        $this->datagrid->addQuickColumn('Dt.Nascimento','dtnascimento','right',40,new TAction(array($this,'onReload')),array('order','dtnascimento'));
        $this->datagrid->addQuickColumn('Ramo Atividade','ramoatividade->descricao','right',100,new TAction(array($this,'onReload')),array('order','ramoatividade->descricao'));

        $this->datagrid->addQuickAction('Editar',new TDataGridAction(array('PessoaFormView','onEdit')),'idpessoa','ico_edit.png');
        $this->datagrid->addQuickAction('Excluir',new TDataGridAction(array($this,'onDelete')),'idpessoa','ico_delete.png');

        $this->datagrid->createModel();

        $this->pageNavigation = new \Adianti\Widget\Datagrid\TPageNavigation;
        $this->pageNavigation->setAction(new \Adianti\Control\TAction(array($this,'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $vbox= new TVBox;
        $vbox->add(new \Adianti\Widget\Util\TXMLBreadCrumb('menu.xml','PessoaFormView'));
        $vbox->add($this->form);
        $vbox->add($this->datagrid);
        $vbox->add($this->pageNavigation);

        parent::add($vbox);

    }
    
}


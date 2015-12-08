<?php
use Adianti\Base\TStandardList;

class ContabancariaDataGrid extends TStandardListWAM
{
    protected $form;
    protected $datagrid;
    protected $pageNavigation;


    public function __construct()
    {
        parent::__construct();
        
        parent::setDatabase(APPLICATION_NAME);
        parent::setActiveRecord('contabancaria');
        parent::setFilterField('conta');
        parent::setDefaultOrder('conta','asc');

        /** @var TQuickForm $this */
        $this->form = new \Adianti\Widget\Wrapper\TQuickForm('ContabancariaDataGrid');
        $this->form->setFormTitle('Cadastro Contas Bancárias');
        $this->form->class='tform';

        $conta = new \Adianti\Widget\Form\TEntry('conta');
        $this->form->addQuickField('Conta: ', $conta, 100);
        $this->form->addQuickAction('Buscar',new TAction(array($this, 'onSearch')),'ico_find.png');
        $this->form->addQuickAction('Novo',new TAction(array('ContabancariaFormView','onClear')),'ico_new.png');

        $this->form->setData(\Adianti\Registry\TSession::getValue('contabancaria_filtro'));

        $this->datagrid = new \Adianti\Widget\Wrapper\TQuickGrid;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(230);

        //$this->datagrid->addQuickColumn('ID','idcontabancaria','right',40,new TAction(array($this,'onReload')),array('order','idcontabancaria'));
        $this->datagrid->addQuickColumn('Agência','agencia','right',40,new TAction(array($this,'onReload')),array('order','agencia'));
        $this->datagrid->addQuickColumn('Conta','conta','right',100,new TAction(array($this,'onReload')),array('order','conta'));
        $this->datagrid->addQuickColumn('Banco','banco->nome','right',200,new TAction(array($this,'onReload')),array('order','banco->nome'));
        $this->datagrid->addQuickColumn('Tipo Conta','tipocontabancaria->descricao','right',120,new TAction(array($this,'onReload')),array('order','tipocontabancaria->descricao'));
        $this->datagrid->addQuickColumn('Titular','titular','right',40,new TAction(array($this,'onReload')),array('order','titular'));
        $this->datagrid->addQuickColumn('Cidade','cidade->nome','right',100,new TAction(array($this,'onReload')),array('order','cidade->nome'));

        $this->datagrid->addQuickAction('Editar',new TDataGridAction(array('ContabancariaFormView','onEdit')),'idcontabancaria','ico_edit.png');
        $this->datagrid->addQuickAction('Excluir',new TDataGridAction(array($this,'onDelete')),'idcontabancaria','ico_delete.png');

        $this->datagrid->createModel();

        $this->pageNavigation = new \Adianti\Widget\Datagrid\TPageNavigation;
        $this->pageNavigation->setAction(new \Adianti\Control\TAction(array($this,'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $vbox= new TVBox;
        $vbox->add(new \Adianti\Widget\Util\TXMLBreadCrumb('menu.xml','ContabancariaFormView'));
        $vbox->add($this->form);
        $vbox->add($this->datagrid);
        $vbox->add($this->pageNavigation);

        parent::add($vbox);

    }
    
}


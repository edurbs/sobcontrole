<?php
use Adianti\Base\TStandardList;
use Adianti\Control\TAction;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Wrapper\TQuickForm;

class CepDataGrid extends TStandardListWAM
{
    protected $form;
    protected $datagrid;
    protected $pageNavigation;


    public function __construct()
    {
        parent::__construct();
        
        parent::setDatabase(APPLICATION_NAME);
        parent::setActiveRecord('cep');
        parent::setFilterField('cep');
        parent::setDefaultOrder('cep','asc');

        /** @var TQuickForm $this */
        $this->form = new \Adianti\Widget\Wrapper\TQuickForm('CepDataGrid');
        $this->form->setFormTitle('Cadastro CEP');
        $this->form->class='tform';

        $cep = new \Adianti\Widget\Form\TEntry('cep');
        $this->form->addQuickField('CEP: ', $cep, 100);
        $this->form->addQuickAction('Buscar',new TAction(array($this, 'onSearch')),'ico_find.png');
        $this->form->addQuickAction('Novo',new TAction(array('CepFormView','onClear')),'ico_new.png');

        $this->form->setData(\Adianti\Registry\TSession::getValue('cep_filtro'));

        $this->datagrid = new \Adianti\Widget\Wrapper\TQuickGrid;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(230);

        $this->datagrid->addQuickColumn('CEP','cep','right',40,new TAction(array($this,'onReload')),array('order','cep'));
        $this->datagrid->addQuickColumn('Tipo Logradouro','tipologradouro->descricao','right',100,new TAction(array($this,'onReload')),array('order','tipologradouro->descricao'));
        $this->datagrid->addQuickColumn('Logradouro','logradouro','right',200,new TAction(array($this,'onReload')),array('order','logradouro'));
        $this->datagrid->addQuickColumn('Bairro','bairro','right',120,new TAction(array($this,'onReload')),array('order','bairro'));
        $this->datagrid->addQuickColumn('Cidade','cidade->nome','right',100,new TAction(array($this,'onReload')),array('order','cidade->nome'));
        $this->datagrid->addQuickColumn('UF','cidade->iduf','right',100,new TAction(array($this,'onReload')),array('order','cidade->iduf'));

        $this->datagrid->addQuickAction('Editar',new TDataGridAction(array('CepFormView','onEdit')),'idcep','ico_edit.png');
        $this->datagrid->addQuickAction('Excluir',new TDataGridAction(array($this,'onDelete')),'idcep','ico_delete.png');

        $this->datagrid->createModel();

        $this->pageNavigation = new \Adianti\Widget\Datagrid\TPageNavigation;
        $this->pageNavigation->setAction(new \Adianti\Control\TAction(array($this,'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $vbox= new TVBox;
        $vbox->add(new \Adianti\Widget\Util\TXMLBreadCrumb('menu.xml','CepFormView'));
        $vbox->add($this->form);
        $vbox->add($this->datagrid);
        $vbox->add($this->pageNavigation);

        parent::add($vbox);

    }
    
}


<?php
use Adianti\Base\TStandardList;

class UFDataGrid extends TStandardListWAM
{
    protected $form;
    protected $datagrid;
    protected $pageNavigation;


    public function __construct()
    {
        parent::__construct();
        
        parent::setDatabase('sobcontrole');
        parent::setActiveRecord('uf');
        parent::setFilterField('nome');
        parent::setDefaultOrder('nome','asc');

        /** @var TQuickForm $this */
        $this->form = new \Adianti\Widget\Wrapper\TQuickForm('UFDataGrid');
        $this->form->setFormTitle('Cadastro Estados (UF)');
        $this->form->class='tform';

        $nome = new \Adianti\Widget\Form\TEntry('nome');
        $this->form->addQuickField('Nome: ', $nome, 100);
        $this->form->addQuickAction(
            'Buscar',
            new \Adianti\Control\TAction(array($this, 'onSearch')),
            'ico_find.png'
        );
        $this->form->addQuickAction(
            'Novo',
            new \Adianti\Control\TAction(
                array(
                    'UFFormView',
                    'onClear'
                )
            ),
            'ico_new.png'
        );

        $this->form->setData(
            \Adianti\Registry\TSession::getValue('uf_filtro')
        );

        $this->datagrid = new \Adianti\Widget\Wrapper\TQuickGrid;
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(230);

        $this->datagrid->addQuickColumn(
            'UF',
            'iduf',
            'right',
            40,
            new \Adianti\Control\TAction(
                array(
                    $this,
                    'onReload'
                )
            ),
            array(
                'order',
                'iduf'
            )
        );


        $this->datagrid->addQuickColumn(
            'Nome',
            'nome',
            'right',
            40,
            new \Adianti\Control\TAction(
                array(
                    $this,
                    'onReload'
                )
            ),
            array(
                'order',
                'nome'
            )
        );

        $this->datagrid->addQuickAction(
            'Editar',
            new \Adianti\Widget\Datagrid\TDataGridAction(
                array(
                    'UFFormView',
                    'onEdit'
                )
            ),
            'iduf',
            'ico_edit.png'
        );

        $this->datagrid->addQuickAction(
            'Excluir',
            new \Adianti\Widget\Datagrid\TDataGridAction(
                array(
                    $this,
                    'onDelete'
                )
            ),
            'iduf',
            'ico_delete.png'
        );

        $this->datagrid->createModel();

        $this->pageNavigation = new \Adianti\Widget\Datagrid\TPageNavigation;
        $this->pageNavigation->setAction(new \Adianti\Control\TAction(array($this,'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $vbox= new TVBox;
        $vbox->add(new \Adianti\Widget\Util\TXMLBreadCrumb('menu.xml','UFFormView'));
        $vbox->add($this->form);
        $vbox->add($this->datagrid);
        $vbox->add($this->pageNavigation);

        parent::add($vbox);

    }
    
}


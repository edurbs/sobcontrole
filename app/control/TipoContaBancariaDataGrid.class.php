<?php
use Adianti\Base\TStandardList;

class TipoContaBancariaDataGrid extends TStandardListWAM
{
    protected $form;
    protected $datagrid;
    protected $pageNavigation;


    public function __construct()
    {
        parent::__construct();
        
        parent::setDatabase('sobcontrole');
        parent::setActiveRecord('tipocontabancaria');
        parent::setFilterField('descricao');
        parent::setDefaultOrder('descricao','asc');

        /** @var TQuickForm $this */
        $this->form = new \Adianti\Widget\Wrapper\TQuickForm('TipoContaBancariaDataGrid');
        $this->form->setFormTitle('Cadastro Tipos de Conta Bancária');
        $this->form->class='tform';

        $descricao = new \Adianti\Widget\Form\TEntry('descricao');
        $this->form->addQuickField('Descrição: ', $descricao, 100);
        $this->form->addQuickAction(
            'Buscar',
            new \Adianti\Control\TAction(array($this, 'onSearch')),
            'ico_find.png'
        );
        $this->form->addQuickAction(
            'Novo',
            new \Adianti\Control\TAction(
                array(
                    'TipoContaBancariaFormView',
                    'onClear'
                )
            ),
            'ico_new.png'
        );

        $this->form->setData(
            \Adianti\Registry\TSession::getValue('tipocontabancaria_filtro')
        );

        $this->datagrid = new \Adianti\Widget\Wrapper\TQuickGrid;
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(230);

        $this->datagrid->addQuickColumn(
            'ID',
            'idtipocontabancaria',
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
                'idtipocontabancaria'
            )
        );


        $this->datagrid->addQuickColumn(
            'Descrição',
            'descricao',
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
                'descricao'
            )
        );

        $this->datagrid->addQuickAction(
            'Editar',
            new \Adianti\Widget\Datagrid\TDataGridAction(
                array(
                    'TipoContaBancariaFormView',
                    'onEdit'
                )
            ),
            'idtipocontabancaria',
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
            'idtipocontabancaria',
            'ico_delete.png'
        );

        $this->datagrid->createModel();

        $this->pageNavigation = new \Adianti\Widget\Datagrid\TPageNavigation;
        $this->pageNavigation->setAction(new \Adianti\Control\TAction(array($this,'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $vbox= new TVBox;
        $vbox->add(new \Adianti\Widget\Util\TXMLBreadCrumb('menu.xml','TipoContaBancariaFormView'));
        $vbox->add($this->form);
        $vbox->add($this->datagrid);
        $vbox->add($this->pageNavigation);

        parent::add($vbox);

    }
    
}


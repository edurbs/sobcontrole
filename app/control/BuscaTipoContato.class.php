<?php
use Adianti\Control\TAction;
use Adianti\Control\TWindow;
use Adianti\Database\TCriteria;
use Adianti\Database\TFilter;
use Adianti\Database\TRepository;
use Adianti\Database\TTransaction;
use Adianti\Registry\TSession;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TPageNavigation;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TForm;
use Adianti\Widget\Wrapper\TQuickForm;
use Adianti\Widget\Wrapper\TQuickGrid;

/**
 * Eduardo Soares
 * Arquivo: BuscaTipoContato.php
 * Projeto: sobcontrole
 * Alterado em 11/12/2015, 13:31
 */

class BuscaTipoContato extends TWindow
{
    private $form;      // form
    private $datagrid;  // datagrid
    private $pageNavigation;
    private $loaded;

    /**
     * Class constructor
     * Creates the page, the search form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        parent::setSize(700, 500);
        parent::setTitle('Search record');
        new TSession;

        // creates the form
        $this->form = new TQuickForm('form_busca_tipocontato');
        $this->form->class = 'tform';
        $this->form->setFormTitle('Tipos Contato');

        // create the form fields
        $name   = new TEntry('descricao');
        $name->setValue(TSession::getValue('tipocontato_descricao'));

        // add the form fields
        $this->form->addQuickField('Descricao', $name,  200);

        // define the form action
        $this->form->addQuickAction('Buscar', new TAction(array($this, 'onSearch')), 'ico_find.png');

        // creates a DataGrid
        $this->datagrid = new TQuickGrid;
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(230);
        //$this->datagrid->enablePopover('Title', 'Name {name}');

        // creates the datagrid columns
        $this->datagrid->addQuickColumn('Id', 'idtipocontato', 'right', 40);
        $this->datagrid->addQuickColumn('Descrição', 'descricao', 'left', 340);

        // creates two datagrid actions
        $this->datagrid->addQuickAction('Seleciona', new TDataGridAction(array($this, 'onSelect')), 'idtipocontato', 'ico_apply.png');

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        // creates a container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add($this->form);
        $container->add($this->datagrid);
        $container->add($this->pageNavigation);

        // add the container inside the page
        parent::add($container);
    }

    /**
     * method onSearch()
     * Register the filter in the session when the user performs a search
     */
    function onSearch()
    {
        // get the search form data
        $data = $this->form->getData();

        // check if the user has filled the form
        if (isset($data->descricao))
        {
            // creates a filter using what the user has typed
            $filter = new TFilter('descricao', 'like', "%{$data->name}%");

            // stores the filter in the session
            TSession::setValue('tipocontato_filtro', $filter);
            TSession::setValue('tipocontato_descricao',   $data->name);

            // fill the form with data again
            $this->form->setData($data);
        }

        // redefine the parameters for reload method
        $param=array();
        $param['offset']    =0;
        $param['first_page']=1;
        $this->onReload($param);
    }

    /**
     * Load the datagrid with the database objects
     */
    function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'samples'
            TTransaction::open('sobcontrole');

            // creates a repository for City
            $repository = new TRepository('tipocontato');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;

            // default order
            if (!isset($param['order']))
            {
                $param['order'] = 'idtipocontato';
                $param['direction'] = 'asc';
            }

            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);

            if (TSession::getValue('tipocontato_filtro'))
            {
                // add the filter stored in the session to the criteria
                $criteria->add(TSession::getValue('tipocontato_filtro'));
            }

            // load the objects according to the criteria
            $tiposdecontato = $repository->load($criteria);
            $this->datagrid->clear();
            if ($tiposdecontato)
            {
                foreach ($tiposdecontato as $tipocontato)
                {
                    // add the object inside the datagrid
                    $this->datagrid->addItem($tipocontato);
                }
            }

            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);

            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($limit); // limit

            // close the transaction
            TTransaction::close();
            $this->loaded = true;
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }

    /**
     * Executed when the user chooses the record
     */
    public function onSelect($param)
    {
        try
        {
            $key = $param['key'];
            TTransaction::open('sobcontrole');

            // load the active record
            $tipocontato = new tipocontato($key);

            //var_dump($tipocontato);

            // closes the transaction
            TTransaction::close();

            $object = new StdClass;
            $object->tipocontato_idtipocontato   = $tipocontato->idtipocontato;
            $object->tipocontato_descricao = $tipocontato->descricao;

            TForm::sendData('form_seek_sample', $object);
            parent::closeWindow(); // closes the window
        }
        catch (Exception $e) // em caso de exceção
        {
            // clear fields
            $object = new StdClass;
            $object->tipocontato_idtipocontato   = '';
            $object->tipocontato_descricao = '';
            TForm::sendData('form_seek_sample', $object);

            // undo pending operations
            TTransaction::rollback();
        }
    }

    /**
     * Shows the page
     */
    function show()
    {
        // if the datagrid was not loaded yet
        if (!$this->loaded)
        {
            $this->onReload();
        }
        parent::show();
    }
}
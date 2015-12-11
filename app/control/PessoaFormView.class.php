<?php
use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Validator\TRequiredValidator;
use Adianti\Widget\Container\TNotebook;
use Adianti\Widget\Container\TTable;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TButton;
use Adianti\Widget\Form\TDate;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TForm;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Form\TMultiField;
use Adianti\Widget\Form\TRadioGroup;
use Adianti\Widget\Form\TSeekButton;
use Adianti\Widget\Form\TText;
use Adianti\Widget\Util\TXMLBreadCrumb;
use Adianti\Widget\Wrapper\TDBCombo;
use Adianti\Widget\Wrapper\TDBSeekButton;

/**
 * Eduardo Soares
 * Arquivo: PessoaFormView.php
 * Projeto: sobcontrole
 * Alterado em 10/12/2015, 09:40
 */
class PessoaFormView extends TPage
{
    private $form; // form

    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        // creates the form
        $this->form = new TForm('form_pessoa');

        // creates a table
        $table_data    = new TTable;
        $table_contato = new TTable;

        $notebook = new TNotebook(500, 250);
        // add the notebook inside the form
        $this->form->add($notebook);

        $notebook->appendPage('Dados Principais', $table_data);
        $notebook->appendPage('Contatos', $table_contato);

        // create the form fields
        $idpessoa           = new TEntry('idpessoa');
        $nome           = new TEntry('nome');
        $dtcadastro          = new TDate('dtcadastro');
        $dtnascimento          = new TDate('dtnascimento');
        $natureza         = new TRadioGroup('natureza');
        $idramoatividade    = new TDBCombo('idramoatividade', 'sobcontrole', 'ramoatividade', 'idramoatividade', 'descricao');
        $obs        = new TText('obs');

        // add field validators
        $nome->addValidation('Nome', new TRequiredValidator);
        $dtcadastro->addValidation('Data Cadastro', new TRequiredValidator);
        $dtnascimento->addValidation('Data Nascimento', new TRequiredValidator);
        $idramoatividade->addValidation('Ramo de Atividade', new TRequiredValidator);
        $natureza->addValidation('Natureza', new TRequiredValidator);

        $itemNatureza = array();
        $itemNatureza['F'] = 'Física';
        $itemNatureza['J'] = 'Jurídica';

        // add the combo options
        $natureza->addItems($itemNatureza);
        $natureza->setLayout('horizontal');

        // define some properties for the form fields
        $idpessoa->setEditable(FALSE);
        $idpessoa->setSize(100);
        $nome->setSize(320);
        $obs->setSize(320);
        $dtcadastro->setSize(90);
        $dtnascimento->setSize(90);
        $natureza->setSize(70);
        $idramoatividade->setSize(120);

        // add a row for the field code
        $table_data->addRowSet(new TLabel('ID:'), array($idpessoa, new TLabel('Natureza:'), $natureza));
        $table_data->addRowSet(new TLabel('Nome/Fantasia:'), $nome);
        $table_data->addRowSet(new TLabel('Data Cadastro:'), $dtcadastro);
        $table_data->addRowSet(new TLabel('Data Nascimento/Início:'), $dtnascimento);
        $table_data->addRowSet(new TLabel('Ramo de Atividade:'), $idramoatividade);
        $table_data->addRowSet(new TLabel('Observações:'), $obs);



        $row=$table_contato->addRow(); // adiciona linha
        $cell=$row->addCell(new TLabel('<b>Contatos</b>')); // adiciona celular na linha
        $cell->valign = 'top'; // define alinhamento

        $listacontatos  = new TMultiField('listacontatos'); // cria multifield

        // com TDBSeekButton
        //$idtipocontato= new TDBSeekButton('idtipocontato', 'sobcontrole', $this->form->getName(), 'tipocontato', 'descricao', 'listacontatos_idtipocontato', 'listacontatos_descricaotipocontato');

        // com  TSeekButton
        /*$idtipocontato= new TSeekButton('idtipocontato');
        $auxidtipocontato = new BuscaTipoContato;
        $auxaction= new TAction(array($auxidtipocontato,'onReload'));
        $idtipocontato->setAction($auxaction);*/

        $idtipocontato= new TDBCombo('idtipocontato', 'sobcontrole', 'tipocontato', 'idtipocontato', 'descricao', 'descricao');



        $descricaotipocontato=new \Adianti\Widget\Form\THidden('tipocontato->descricao');
        //$descricaotipocontato->setEditable(false);

        $valorcontato=new TEntry('valorcontato');

        $listacontatos->setClass('contato'); // define the returning class

        // colunas do multifield

        // coluna do ID do tipo de contato (1->email, 2->telefone, etc...)
        $listacontatos->addField('idtipocontato',  'ID: ',  $idtipocontato, 40);

        // coluna da descricao do tipo de contato
        //                        desta forma o grid OK
        $listacontatos->addField('tipocontato->descricao', '', $descricaotipocontato, 200);
        //                        desta forma o TDBSeekButton fica OK.
        //$listacontatos->addField('descricaotipocontato', 'Descrição Tipo Contato: ', $descricaotipocontato, 200);



        // coluna com o valor do contato, número do telefone, celular, etc.
        $listacontatos->addField('descricao', 'Valor Contato: ', $valorcontato, 200);
        $listacontatos->setHeight(250);

        $row=$table_contato->addRow();
        $row->addCell($listacontatos);

        // create an action button
        $button1=new TButton('action1');
        $button1->setAction(new TAction(array($this, 'onSave')), 'Salvar');
        $button1->setImage('ico_save.png');

        // create an action button (go to list)
        $button2=new TButton('list');
        $button2->setAction(new TAction(array('PessoaDataGrid', 'onReload')), 'Listar');
        $button2->setImage('ico_datagrid.gif');

        $button0=new TButton('new');
        $button0->setAction(new TAction(array($this, 'onClear')), 'Novo');
        $button0->setImage('ico_new.png');

        // define wich are the form fields
        $this->form->setFields(array($idpessoa, $nome, $dtcadastro, $dtnascimento, $natureza, $idramoatividade, $obs,
            $listacontatos, $button0, $button1, $button2));

        $subtable = new TTable;
        $row = $subtable->addRow();
        $row->addCell($button0);
        $row->addCell($button1);
        $row->addCell($button2);

        // wrap the page content
        $vbox = new TVBox;
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);
        $vbox->add($subtable);

        // add the form inside the page
        parent::add($vbox);
    }

    /**
     * method onSave
     * Executed whenever the user clicks at the save button
     */
    function onSave()
    {
        try
        {
            // open a transaction with database 'samples'
            TTransaction::open('sobcontrole');

            $this->form->validate();
            // read the form data and instantiates an Active Record
            $pessoa = $this->form->getData('pessoa');

            if ($pessoa->listacontatos)
            {
                foreach ($pessoa->listacontatos as $contato)
                {
                    // add the contact to the customer
                    $pessoa->addContato($contato);
                }
            } else {
                echo "lista de contato vazia";
            }

            // stores the object in the database
            $pessoa->store();
            $this->form->setData($pessoa);

            // shows the success message
            new TMessage('info', 'Record saved');

            TTransaction::close(); // close the transaction
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', '<b>Error</b>: ' . $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }

    /**
     * method onEdit
     * Edit a record data
     */
    function onEdit($param)
    {
        try
        {
            if (isset($param['key']))
            {
                // open a transaction with database 'samples'
                TTransaction::open('sobcontrole');

                // load the Active Record according to its ID
                $pessoa= new pessoa($param['key']);
                // load the contacts (composition)
                $pessoa->listacontatos=$pessoa->getContatos();

                // fill the form with the active record data
                $this->form->setData($pessoa);

                // close the transaction
                TTransaction::close();
            }
            else
            {

                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', '<b>Error</b>' . $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }

    function onClear(){
        $this->form->clear();
    }

}
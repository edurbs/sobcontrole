<?php
class pessoa extends TRecord
{
    const TABLENAME = 'pessoa';
    const PRIMARYKEY = 'idpessoa';
    const IDPOLICY = 'serial';

    private $ramoatividade;
    private $enderecos;
    private $contatos;
    
    /**
     * Constructor method
     * @param $id Primary key to be loaded (optional)
    */
    public function __construct($id=NULL)
    {
        parent::__construct($id);
        parent::addAttribute('idpessoa');
        parent::addAttribute('nome');
        parent::addAttribute('obs');
        parent::addAttribute('dtcadastro');
        parent::addAttribute('dtnascimento');
        parent::addAttribute('natureza'); // F (fisica) ou J (Jurídica)
        parent::addAttribute('foto');
        parent::addAttribute('idramoatividade'); //FK
    }


    public function get_ramoatividade()
    {
        if(empty($this->ramoatividade))
            $this->ramoatividade = new ramoatividade($this->idramoatividade);

        return $this->ramoatividade;
    }

    public function set_ramoatividade(ramoatividade $obj)
    {
        $this->ramoatividade = $obj;
        $this->ramoatividade->idramoatividade = $obj->idramoatividade;
    }


    public function addEndereco(endereco $obj){
        $this->enderecos[]=$obj;
    }

    public function getEnderecos(){
        return $this->enderecos;
    }

    public function addContato(contato $obj){
        $this->contatos[]=$obj;
    }

    public function getContatos(){
        return $this->contatos;
    }

    public function clearParts(){
        $this->enderecos = array();
        $this->contatos = array();
    }

    public function load($id)
    {
        //$this->enderecos = parent::loadComposite('endereco','idpessoa');
        $this->contatos = parent::loadComposite('contato','idpessoa',$id);

        return parent::load($id);
    }

    public function store()
    {
        parent::store();

        //parent::saveComposite('endereco','idpessoa',$this->idpessoa,$this->enderecos);
        parent::saveComposite('contato','idpessoa',$this->idpessoa,$this->contatos);
    }

    public function delete($id=NULL)
    {
        parent::deleteComposite('endereco','idpessoa',$id);
        parent::deleteComposite('contato','idpessoa',$id);

        parent::delete($id);
    }

}

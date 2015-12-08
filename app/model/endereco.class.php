<?php
class endereco extends TRecord
{
    const TABLENAME = 'endereco';
    const PRIMARYKEY = 'idendereco';
    //const IDPOLICY = 'serial';

    private $tipologradouro;
    //private $cep;
    private $cidade;
    private $uf;

    
    /**
     * Constructor method
     * @param $id Primary key to be loaded (optional)
    */
    public function __construct($id=NULL)
    {
        parent::__construct($id);
        parent::addAttribute('idendereco');
        parent::addAttribute('obs');
        parent::addAttribute('idtipologradouro'); //FK
        parent::addAttribute('logradouro');
        parent::addAttribute('numero');
        parent::addAttribute('complemento');
        parent::addAttribute('bairro');
        parent::addAttribute('cep'); // FK (sem criar entidade)
        parent::addAttribute('idcidade'); //FK
        parent::addAttribute('iduf'); //FK
    }

    public function get_cidade()
    {
        if(empty($this->cidade))
            $this->cidade = new cidade($this->idcidade);

        return $this->cidade;
    }

    public function set_cidade(cidade $obj)
    {
        $this->cidade = $obj;
        $this->cidade->idcidade = $obj->idcidade;
    }

    public function get_uf()
    {
        if(empty($this->uf))
            $this->uf = new uf($this->iduf);

        return $this->uf;
    }

    public function set_uf(uf $obj)
    {
        $this->uf = $obj;
        $this->uf->iduf = $obj->iduf;
    }

    public function get_tipologradouro()
    {
        if(empty($this->tipologradouro))
            $this->tipologradouro = new tipologradouro($this->idtipologradouro);

        return $this->tipologradouro;
    }

    public function set_tipologradouro(tipologradouro $obj)
    {
        $this->tipologradouro = $obj;
        $this->tipologradouro->idtipologradouro = $obj->idtipologradouro;
    }
    
}

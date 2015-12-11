<?php
class endereco extends TRecord
{
    const TABLENAME = 'endereco';
    const PRIMARYKEY = 'idendereco';
    //const IDPOLICY = 'serial';

    //private $tipologradouro;
    //private $cep;
    private $cidade;
    private $uf;
    private $pessoa;

    
    /**
     * Constructor method
     * @param $id Primary key to be loaded (optional)
    */
    public function __construct($id=NULL)
    {
        parent::__construct($id);
        //parent::addAttribute('idendereco');
        parent::addAttribute('obs');
        parent::addAttribute('tipologradouro');
        parent::addAttribute('logradouro');
        parent::addAttribute('numero');
        parent::addAttribute('complemento');
        parent::addAttribute('bairro');
        parent::addAttribute('cep');
        parent::addAttribute('idcidade'); //FK
        parent::addAttribute('iduf'); //FK
        parent::addAttribute('idpessoa'); //FK
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

    public function set_pessoa(pessoa $obj)
    {
        $this->pessoa = $obj;
        $this->pessoa->idpessoa = $obj->idpessoa;
    }

    public function get_pessoa()
    {
        if(empty($this->pessoa))
            $this->pessoa = new pessoa($this->idpessoa);

        return $this->pessoa;
    }

}

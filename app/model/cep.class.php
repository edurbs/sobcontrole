<?php
class cep extends TRecord
{
    const TABLENAME = 'cep';
    const PRIMARYKEY = 'cep';
    //const IDPOLICY = 'serial';

    private $tipologradouro;
    private $cidade;
    
    /**
     * Constructor method
     * @param $id Primary key to be loaded (optional)
    */
    public function __construct($id=NULL)
    {
        parent::__construct($id);
        parent::addAttribute('cep');
        parent::addAttribute('idtipologradouro'); //FK
        parent::addAttribute('logradouro');
        parent::addAttribute('bairro');
        parent::addAttribute('idcidade'); //FK
    }

    /**
     * @return mixed
     */
    public function get_cidade()
    {
        if(empty($this->cidade))
            $this->cidade = new cidade($this->idcidade);

        return $this->cidade;
    }

    /**
     * @param mixed $cidade
     */
    public function set_cidade(cidade $obj)
    {
        $this->cidade = $obj;
        $this->cidade->idcidade=$obj->idcidade;

    }

    /**
     * @return mixed
     */
    public function get_tipologradouro()
    {
        if(empty($this->tipologradouro))
            $this->tipologradouro = new tipologradouro($this->tipocep_idtipologradouro);

        return $this->tipologradouro;
    }

    /**
     * @param mixed $tipocep
     */
    public function set_tipologradouro(tipologradouro $obj)
    {
        $this->tipologradouro = $obj;

        $this->logradouro->idtipologradouro = $obj->idtipologradouro;
    }
    
}

<?php
class contabancaria extends TRecord
{
    const TABLENAME = 'contabancaria';
    const PRIMARYKEY = 'idcontabancaria';
    const IDPOLICY = 'serial';

    private $banco, $cidade, $tipocontabancaria;
    
    /**
     * Constructor method
     * @param $id Primary key to be loaded (optional)
    */
    public function __construct($id=NULL)
    {
        parent::__construct($id);
        parent::addAttribute('idcontabancaria');
        parent::addAttribute('agencia');
        parent::addAttribute('conta');
        parent::addAttribute('banco_idbanco'); //FK
        parent::addAttribute('tipocontabancaria_idtipocontabancaria'); //FK
        parent::addAttribute('titular');
        parent::addAttribute('idcidade'); //FK
    }


    /**
     * @return mixed
     */
    public function get_banco()
    {
        if(empty($this->banco))
            $this->banco = new banco($this->banco_idbanco);

        return $this->banco;
    }

    /**
     * @param mixed $banco_idbanco
     */
    public function set_banco(banco $obj)
    {
        $this->banco = $obj;
        $this->banco_idbanco = $obj->idbanco;
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
    public function get_tipocontabancaria()
    {
        if(empty($this->tipocontabancaria))
            $this->tipocontabancaria = new tipocontabancaria($this->tipocontabancaria_idtipocontabancaria);

        return $this->tipocontabancaria;
    }

    /**
     * @param mixed $tipocontabancaria
     */
    public function set_tipocontabancaria(tipocontabancaria $obj)
    {
        $this->tipocontabancaria = $obj;

        $this->tipocontabancaria_idtipocontabancaria = $obj->idtipocontabancaria;
    }
    
}

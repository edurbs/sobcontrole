<?php
class cidade extends TRecord
{
    const TABLENAME = 'cidade';
    const PRIMARYKEY = 'idcidade';
    const IDPOLICY = 'serial';

    private $uf;
    
    /**
     * Constructor method
     * @param $id Primary key to be loaded (optional)
    */
    public function __construct($id=NULL)
    {
        parent::__construct($id);
        //parent::addAttribute('idcidade');
        parent::addAttribute('nome');
        parent::addAttribute('iduf');
    }

    public function set_uf(uf $obj)
    {
        $this->uf = $obj;
        $this->uf->iduf = $obj->iduf;
    }

    public function get_uf()
    {
        if(empty($this->uf))
            $this->uf = new uf($this->iduf);

        return $this->uf;
    }
    
}

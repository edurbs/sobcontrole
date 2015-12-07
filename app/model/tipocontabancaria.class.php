<?php
class tipocontabancaria extends TRecord
{
    const TABLENAME = 'tipocontabancaria';
    const PRIMARYKEY = 'idtipocontabancaria';
    const IDPOLICY = 'serial';
    
    /**
     * Constructor method
     * @param $id Primary key to be loaded (optional)
    */
    public function __construct($id=NULL)
    {
        parent::__construct($id);
        parent::addAttribute('idtipocontabancaria');
        parent::addAttribute('descricao');
    }
    
}

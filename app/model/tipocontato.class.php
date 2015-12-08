<?php
class tipocontato extends TRecord
{
    const TABLENAME = 'tipocontato';
    const PRIMARYKEY = 'idtipocontato';
    const IDPOLICY = 'serial';
    
    /**
     * Constructor method
     * @param $id Primary key to be loaded (optional)
    */
    public function __construct($id=NULL)
    {
        parent::__construct($id);
        parent::addAttribute('idtipocontato');
        parent::addAttribute('descricao');
    }
    
}

<?php
class uf extends TRecord
{
    const TABLENAME = 'uf';
    const PRIMARYKEY = 'iduf';
    //const IDPOLICY = '';
    
    /**
     * Constructor method
     * @param $id Primary key to be loaded (optional)
    */
    public function __construct($id=NULL)
    {
        parent::__construct($id);
        //parent::addAttribute('iduf');
        parent::addAttribute('nome');        
    }
    
}

<?php
class banco extends TRecord
{
    const TABLENAME = 'banco';
    const PRIMARYKEY = 'idbanco';
    const IDPOLICY = 'serial';
    
    /**
     * Constructor method
     * @param $id Primary key to be loaded (optional)
    */
    public function __construct($id=NULL)
    {
        parent::__construct($id);
        //parent::addAttribute('idbanco');
        parent::addAttribute('sigla');
        parent::addAttribute('nome');        
    }
    
}

<?php
class tipologradouro extends TRecord
{
    const TABLENAME = 'tipologradouro';
    const PRIMARYKEY = 'idtipologradouro';
    const IDPOLICY = 'serial';
    
    /**
     * Constructor method
     * @param $id Primary key to be loaded (optional)
    */
    public function __construct($id=NULL)
    {
        parent::__construct($id);
        parent::addAttribute('idtipologradouro');
        parent::addAttribute('descricao');
    }
    
}

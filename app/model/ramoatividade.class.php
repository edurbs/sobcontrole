<?php
class ramoatividade extends TRecord
{
    const TABLENAME = 'ramoatividade';
    const PRIMARYKEY = 'idramoatividade';
    const IDPOLICY = 'serial';
    
    /**
     * Constructor method
     * @param $id Primary key to be loaded (optional)
    */
    public function __construct($id=NULL)
    {
        parent::__construct($id);
        parent::addAttribute('idramoatividade');
        parent::addAttribute('descricao');
    }
    
}

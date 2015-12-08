<?php
class tipocargo extends TRecord
{
    const TABLENAME = 'tipocargo';
    const PRIMARYKEY = 'idtipocargo';
    const IDPOLICY = 'serial';
    
    /**
     * Constructor method
     * @param $id Primary key to be loaded (optional)
    */
    public function __construct($id=NULL)
    {
        parent::__construct($id);
        parent::addAttribute('idtipocargo');
        parent::addAttribute('descricao');
    }
    
}

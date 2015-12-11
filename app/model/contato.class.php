<?php
class contato extends TRecord
{

    const TABLENAME = 'contato';
    const PRIMARYKEY = 'idcontato';
    const IDPOLICY = 'serial';

    private $pessoa;
    private $tipocontato;
    
    /**
     * Constructor method
     * @param $id Primary key to be loaded (optional)
    */
    public function __construct($id=NULL)
    {
        parent::__construct($id);
        parent::addAttribute('idtipocontato');
        parent::addAttribute('idpessoa');
        parent::addAttribute('descricao');
    }

    public function set_pessoa(pessoa $obj)
    {
        $this->pessoa = $obj;
        $this->pessoa->idpessoa = $obj->idpessoa;
    }

    public function get_pessoa()
    {
        if(empty($this->pessoa))
            $this->pessoa = new pessoa($this->idpessoa);

        return $this->pessoa;
    }

    public function set_tipocontato(tipocontato $obj)
    {
        $this->tipocontato = $obj;
        $this->tipocontato->idtipocontato = $obj->idtipocontato;
    }

    public function get_tipocontato()
    {
        if(empty($this->tipocontato))
            $this->tipocontato = new tipocontato($this->idtipocontato);

        return $this->tipocontato;
    }

}

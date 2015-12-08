<?php
class pessoa extends TRecord
{
    const TABLENAME = 'pessoa';
    const PRIMARYKEY = 'idpessoa';
    //const IDPOLICY = 'serial';

    private $ramoatividade;
    
    /**
     * Constructor method
     * @param $id Primary key to be loaded (optional)
    */
    public function __construct($id=NULL)
    {
        parent::__construct($id);
        parent::addAttribute('idpessoa');
        parent::addAttribute('nome');
        parent::addAttribute('obs');
        parent::addAttribute('dtcadastro');
        parent::addAttribute('dtnascimento');
        parent::addAttribute('natureza'); // F (fisica) ou J (Jurídica)
        parent::addAttribute('foto');
        parent::addAttribute('idramoatividade'); //FK
    }


    public function get_ramoatividade()
    {
        if(empty($this->ramoatividade))
            $this->ramoatividade = new ramoatividade($this->idramoatividade);

        return $this->ramoatividade;
    }

    public function set_ramoatividade(ramoatividade $obj)
    {
        $this->ramoatividade = $obj;
        $this->ramoatividade->idramoatividade = $obj->idramoatividade;
    }

}

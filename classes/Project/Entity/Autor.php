<?php

namespace Project\Entity;

class Autor extends \Ninja\Entity
{
    public function __construct(\Ninja\DatabaseTable $table)
    {
        //Chama o construtor da classe Pai
        parent::__construct($table);
    }

    public function getRecursos()
    {
        //constructArgs[0] conterá o objeto DatabaseTable representando a lista de recursos
        return $this->constructArgs[0]->read('autor_id', $this->id);
    }

    public function addRecurso()
    {
        
    }
}

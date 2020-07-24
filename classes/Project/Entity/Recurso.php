<?php

namespace Project\Entity;

class Recurso extends \Ninja\Entity
{
    public function __construct(\Ninja\DatabaseTable $table)
    {
        //Chama o construtor da classe Pai
        parent::__construct($table);
    }
}

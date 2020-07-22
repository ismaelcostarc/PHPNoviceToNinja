<?php

namespace Ninja;

class Entity
{
    private $table;

    public function __construct(DatabaseTable $table)
    {
        $this->table = $table;

        //Ao criar qualquer Entidade, automaticamente o objeto terá como propriedades
        //as colunas da tabela dada
        $columns = $table->columns();
        foreach ($columns as $column) {
            $this->{$column};
        }
    }
}

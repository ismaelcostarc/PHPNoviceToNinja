<?php

namespace Ninja;

class Entity
{
    protected $table;
    protected $constructArgs;

    public function __construct(DatabaseTable $table)
    {
        $this->table = $table;
        $this->constructArgs = $this->table->constructArgs;

        //Ao criar qualquer Entidade, automaticamente o objeto terá como propriedades
        //as colunas da tabela dada
        $columns = $table->columns();
        foreach ($columns as $column) {
            $this->{$column};
        }
    }
}
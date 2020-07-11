<?php

namespace Project;

class AutoresController {
    private $autoresTabela;

    public function __construct(\Ninja\DatabaseTable $autoresTabela)
    {
        $this->autoresTabela = $autoresTabela;
    }

    public function adicionar() {

    }
}
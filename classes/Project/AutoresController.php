<?php

class AutoresController {
    private $autoresTabela;

    public function __construct(DatabaseTable $autoresTabela)
    {
        $this->autoresTabela = $autoresTabela;
    }
}
<?php

class Main
{
    protected $pdo;
    protected $table = '';

    public function __construct()
    {
        $this->pdo = MSQL::getInstance();
    }
}
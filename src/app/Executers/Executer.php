<?php

namespace App\Executers;

class Executer {

    protected $container;

    public function __construct ($container) {
        $this->container = $container;
    }
    
}
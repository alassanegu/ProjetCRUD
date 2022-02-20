<?php

abstract class AbstractEntite
{
    protected $persistant;

    public function getPersistant(): bool{
        return $this->persistant;
    }

    public function setPersistant(bool $p){
        $this->persistant = $p;
    }
}
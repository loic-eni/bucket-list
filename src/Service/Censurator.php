<?php

namespace App\Service;

class Censurator
{

    /**
     * @var array|string[]
     */
    private array $FORBIDDEN_WORDS;

    public function __construct(){
        $this->FORBIDDEN_WORDS = ['fuck', 'dick', 'macron','elon musk'];
    }
    public function purify(string $string){
        return str_replace($this->FORBIDDEN_WORDS, '****', $string);
    }
}
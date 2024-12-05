<?php

namespace App\Service;

class Censurator
{

    const FORBIDDEN_WORDS = ['fuck', 'dick', 'macron','elon musk'];

    public function __construct(){
        $this->FORBIDDEN_PATTERNS = $this->getForbidenPatterns(self::FORBIDDEN_WORDS);
    }
    public function purify(string $string){
        return preg_replace_callback($this->FORBIDDEN_PATTERNS, function($match){
            return str_repeat('*', strlen($match[0]));
        }, $string);
    }

    private function getForbidenPatterns($words){
        return array_map(function ($word){return '#' . $word . '#i';}, $words);
    }
}
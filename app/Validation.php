<?php

namespace App;

class Validation
{

    public function __construct()
    {
    }
    public static function validerStr($chaine, $regexp): string
    {
        if(preg_match($regexp, $chaine)) {
            return 'true';
        }
        else {
            return 'false';
        }
    }
}

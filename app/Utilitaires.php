<?php

declare(strict_types=1);

namespace App;

use \PDO;
use eftec\bladeone\Bladeone;


class Utilitaires
{
    private function __construct()
    {
    }

    public static function validerStr($valeur, $regexp): App
    {
        return preg_match($regexp, $valeur);
    }
}
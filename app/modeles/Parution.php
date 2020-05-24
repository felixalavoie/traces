<?php

namespace App\modeles;

use App\App;
use \PDO;

class Parution
{
//    Un atttribut pour chaque ligne de la table
    private $id;
    private $etat;

    public function __construct()
    {
    }

    public static function trouverTout(): array
    {
        $pdo = App::getInstance()->getPDO();
        $sql = "SELECT * FROM parutions";
        $requete = $pdo->prepare($sql);
        $requete->setFetchMode(PDO::FETCH_CLASS, Parution::class);
        $requete->execute();
        $parutions = $requete->fetchAll();
        return $parutions;
    }

    public static function trouver($unIdParution){
        $pdo = App::getInstance()->getPDO();
        $sql = "SELECT * 
                FROM parutions
                WHERE id={$unIdParution}";
        $requete = $pdo->prepare($sql);
        $requete->setFetchMode(PDO::FETCH_CLASS, Parution::class);
        $requete->execute();
        $parution = $requete->fetch();
        return $parution;
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

}
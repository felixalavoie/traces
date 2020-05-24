<?php

namespace App\modeles;

use App\App;
use \PDO;

class Actualites
{
//    Un atttribut pour chaque ligne de la table
private $id;
private $date;
private $titre;
private $texte;
private $id_auteur;

    public function __construct()
    {
    }

    public static function trouverTout(){
        //On demande le PDO a la classe App
        $pdo = App::getInstance()->getPDO();
        //on fait la requete SQL
        $sql = "SELECT * FROM actualites";
        $requete = $pdo->prepare($sql);
        $requete->setFetchMode(PDO::FETCH_CLASS, Actualites::class);
        $requete->execute();
        $actualite = $requete->fetchAll();
        return $actualite;
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
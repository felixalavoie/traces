<?php

namespace App\modeles;

use App\App;
use \PDO;

class Collection

{
    //    Un atttribut pour chaque ligne de la table
    private $id;
    private $nom;
    private $description;

    public function __construct()
    {
    }

    public static function trouverTout(): array
    {
        $pdo = App::getInstance()->getPDO();
        $sql = "SELECT * FROM collections";
        $requete = $pdo->prepare($sql);
        $requete->setFetchMode(PDO::FETCH_CLASS, Collection::class);
        $requete->execute();
        $collection = $requete->fetchAll();
        return $collection;
    }

    public static function trouver($unIdCollection)
    {
        $pdo = App::getInstance()->getPDO();
        $sql = "SELECT * 
                FROM collections INNER JOIN livres ON collections.id = livres.collection_id
                WHERE livres.collection_id=:id";
        $requete = $pdo->prepare($sql);
        $requete->bindParam(":id", $unIdCollection, PDO::PARAM_INT);
        $requete->setFetchMode(PDO::FETCH_CLASS, Editeur::class);
        $requete->execute();
        $collection = $requete->fetch();
        //print_r($collection);
        return $collection;
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
<?php

namespace App\modeles;

use App\App;
use \PDO;

class Editeur

{
//    Un atttribut pour chaque ligne de la table
    private $id;
    private $nom;
    private $url;

    public function __construct()
    {
    }

    public static function trouverTout(): array
    {
        $pdo = App::getInstance()->getPDO();
        $sql = "SELECT * FROM editeurs";
        $requete = $pdo->prepare($sql);
        $requete->setFetchMode(PDO::FETCH_CLASS, Editeur::class);
        $requete->execute();
        $maisonEdition = $requete->fetchAll();
        return $maisonEdition;
    }
    public static function trouver($unIdEditeur){
        $pdo = App::getInstance()->getPDO();
        $sql = "SELECT * 
                FROM editeurs INNER JOIN editeurs_livres ON editeurs.id = editeurs_livres.editeur_id
                WHERE editeurs_livres.livre_id=:id";
        $requete = $pdo->prepare($sql);
        $requete->bindParam(":id",$unIdEditeur,PDO::PARAM_INT);
        $requete->setFetchMode(PDO::FETCH_CLASS, Editeur::class);
        $requete->execute();
        $editeurs = $requete->fetch();
        //print_r($editeurs);
        return $editeurs;
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

<?php

namespace App\modeles;

use App\App;
use \PDO;

class Auteur
{
//    Un atttribut pour chaque ligne de la table
    private $id;
    private $nom;
    private $prenom;
    private $biographie;
    private $url_blogue;

    public function __construct()
    {
    }

    public static function trouverTout(): array
    {
        $pdo = App::getInstance()->getPDO();
        $sql = "SELECT * FROM auteur";
        $requete = $pdo->prepare($sql);
        $requete->setFetchMode(PDO::FETCH_CLASS, Auteur::class);
        $requete->execute();
        $parutions = $requete->fetchAll();
        return $parutions;
    }

    public static function trouver($unIdLivre){
        $pdo = App::getInstance()->getPDO();
        $sql = "SELECT * 
                FROM auteurs INNER JOIN auteurs_livres ON auteurs.id = auteurs_livres.auteur_id
                WHERE auteurs_livres.livre_id=:id";
        $requete = $pdo->prepare($sql);
        $requete->bindParam(":id",$unIdLivre,PDO::PARAM_INT);
        $requete->setFetchMode(PDO::FETCH_CLASS, Auteur::class);
       $requete->execute();
        $auteurs = $requete->fetchAll();
        return $auteurs;
    }

    public function getNomPrenom(){
        return $this->nom.", " . $this->prenom;
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
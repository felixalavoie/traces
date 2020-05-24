<?php

namespace App\modeles;

use App\App;
use \PDO;

class Adresse
{
//    Un atttribut pour chaque ligne de la table
    private $id_adresse;
    private $nom;
    private $prenom;
    private $adresse;
    private $ville;
    private $code_postal;
    private $est_default;
    private $type;
    private $abbr_province;
    private $id_client;

    public function __construct()
    {
    }

    public static function getAdresse($id) {
        //On demande le PDO a la classe App
        $pdo = App::getInstance()->getPDO();
        //on fait la requete SQL
        $sql = "SELECT * FROM t_adresse WHERE id_client =".$id;
        $requete = $pdo->prepare($sql);
        $requete->setFetchMode(PDO::FETCH_CLASS, Adresse::class);
        $requete->execute();
        $adresse = $requete->fetch();
        return $adresse;
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
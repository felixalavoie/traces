<?php


namespace App\modeles;

use App\App;
use \PDO;

class Client
{
    private $id_client = null;
    private $prenom = null;
    private $nom = null;
    private $courriel = null;
    private $telephone = null;
    private $mot_de_passe = null;

    public function __construct()
    {

    }

    public static function creerClient($tclient){
        $pdo = App::getInstance()->getPDO();
        $sql = "INSERT INTO t_client (prenom, nom, courriel, telephone, mot_de_passe) 
                VALUES (:prenom, :nom, :courriel, :telephone, :motdepasse)";
        $requete = $pdo->prepare($sql);
        $requete->setFetchMode(PDO::FETCH_CLASS, Client::class);
        $requete->bindParam(":prenom", $tclient["prenom"]["valeur"]);
        $requete->bindParam(":nom", $tclient["nom"]["valeur"]);
        $requete->bindParam(":courriel", $tclient["courriel"]["valeur"]);
        $requete->bindParam(":telephone", $tclient["telephone"]["valeur"]);
        $requete->bindParam(":motdepasse", $tclient["motDePasse"]["valeur"]);
        $requete->execute();
    }

    public static function getClient($id) {
        $pdo = App::getInstance()->getPDO();
        $sql = "SELECT *
                FROM t_client
                WHERE id_client = :id";
        $requete = $pdo->prepare($sql);
        $requete->setFetchMode(PDO::FETCH_CLASS, Client::class);

        $requete->bindParam(":id", $id);
        $requete->execute();
        $client = $requete->fetch();
        return $client;
    }

    public static function verifierConnexion($unEmail){
        $pdo = App::getInstance()->getPDO();
        $sql = "SELECT * FROM t_client WHERE courriel = :courriel";
        $requete = $pdo->prepare($sql);
        $requete->setFetchMode(PDO::FETCH_CLASS, Client::class);
        $requete->bindParam(":courriel",$unEmail);
        $requete->execute();
        $client = $requete->fetch();
        return $client;
    }

    public function __get($property)
    {
        if(property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if(property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}
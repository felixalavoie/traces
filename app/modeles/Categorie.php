<?php

namespace App\modeles;

use App\App;
use \PDO;

class Categorie
{
//    Un atttribut pour chaque ligne de la table
    public $id;
    public $nom_fr;
    public $nom_en;

    public function __construct()
    {
    }

    public static function toutCategories(): array
    {
        $pdo = App::getInstance()->getPDO();
        $sql = "SELECT *
            FROM categories
            ORDER BY nom_fr";
        $requete = $pdo->prepare($sql);
        $requete->setFetchMode(PDO::FETCH_CLASS, Categorie::class);
        $requete->execute();
        $categories = $requete->fetchAll();
        return $categories;
    }
}


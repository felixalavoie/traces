<?php

namespace App\modeles;

use App\App;
use \PDO;
use App\modeles\Parution;
use App\modeles\Auteur;

class Livre
{
//    Un atttribut pour chaque ligne de la table
    private $id;
    private $nbre_pages;
    private $est_illustre;
    private $annee_publication;
    private $langue;
    private $prix;
    private $titre;
    private $sous_titre;
    private $mots_cles;
    private $isbn;
    private $description;
    private $autres_caracte;
    private $est_coup_de_coeur;
    private $parution_id;
    private $collection_id;
    private $url;

public function __construct()
{
}

public static function livresDefault(): array
{
    $pdo = App::getInstance()->getPDO();
    $sql = "SELECT livres.id, livres.prix, livres.titre
            FROM livres
            ORDER BY livres.prix
            LIMIT 12";
    $requete = $pdo->prepare($sql);
    $requete->setFetchMode(PDO::FETCH_CLASS, Livre::class);
    $requete->execute();
    $livres = $requete->fetchAll();
    return $livres;
}

// Fonction page catalogue
public static function catalogue($nbrLivre, $page, $triage, $arrCategories) {

}

public static function trouverPage(): array
    {
//        À changer lors de l'implantation des Cookies
//        $langue = $_COOKIE["langue"];
        $langue = 'FR';

//        On va chercher les variables dans sessions
        $arrFiltres = App::getInstance()->getSession()->getItem('arrFiltrage');

        $categories = $arrFiltres['tFiltrage']['categories'];

        $strCategories = '';
        if(count($categories)!= array('empty')){
            $copyCategories = $categories;
            array_pop($copyCategories);
            $strCategories = implode(", ", $copyCategories);
        }

        $page = $arrFiltres['tFiltrage']['page'];

        $livresParPage = $arrFiltres['tFiltrage']['livresParPage'];
        $livreStart = (int)$page * (int)$livresParPage;

        $modeTriage = $arrFiltres['tFiltrage']['triage'];

//  ---------- REQUETE ----------
        $pdo = App::getInstance()->getPDO();

        $sql="";

        if (count($categories)>1){
            $sql = "SELECT DISTINCT livres.id, titre, isbn, prix, '' as url
                FROM livres INNER JOIN categories_livres ON livres.id = categories_livres.livre_id
                WHERE categories_livres.categorie_id IN (".$strCategories.") AND livres.langue = :langue
                ORDER BY 
                    CASE WHEN :modeTriage = 'prixAsc' THEN prix END ASC,
                    CASE WHEN :modeTriage = 'prixDesc' THEN prix END DESC,
                    CASE WHEN :modeTriage = 'titreAsc' THEN titre END ASC,
                    CASE WHEN :modeTriage = 'titreDesc' THEN titre END DESC
                LIMIT :offset, :livresParPage";
        }
        else {
            $sql = "SELECT id, titre, isbn, prix, '' as url
                FROM livres
                WHERE langue = :langue
                ORDER BY
                    CASE WHEN :modeTriage = 'prixAsc' THEN prix END ASC,
                    CASE WHEN :modeTriage = 'prixDesc' THEN prix END DESC,
                    CASE WHEN :modeTriage = 'titreAsc' THEN titre END ASC,
                    CASE WHEN :modeTriage = 'titreDesc' THEN titre END DESC
                LIMIT :offset, :livresParPage";
        }

        $requete = $pdo->prepare($sql);
        $requete->setFetchMode(PDO::FETCH_CLASS, Livre::class);

        if (count($categories)>1){
            $requete -> bindParam(':categories', $strCategories);
        }
        $requete -> bindParam(':langue', $langue, PDO::PARAM_STR);
        $requete -> bindParam(':modeTriage', $modeTriage, PDO::PARAM_STR);
        $requete -> bindParam(':livresParPage', $livresParPage, PDO::PARAM_INT);
        $requete -> bindParam(':offset', $livreStart, PDO::PARAM_INT);

        $requete->execute();
        $livres = $requete->fetchAll();
        return $livres;
    }

//    -----------------------------------------------------------------------------------------------------------------------------------------
//    -----------------------------------------------------------------------------------------------------------------------------------------
//    -----------------------------------------------------------------------------------------------------------------------------------------

    public static function trouverCount()
    {
        //        À changer lors de l'implantation des Cookies
//        $langue = $_COOKIE["langue"];
        $langue = 'FR';

//        On va chercher les variables dans sessions
        $arrFiltres = App::getInstance()->getSession()->getItem('arrFiltrage');

        $categories = $arrFiltres['tFiltrage']['categories'];

        $strCategories = '';
        if(count($categories)>1){
            $copyCategories = $categories;
            array_pop($copyCategories);
            $strCategories = implode(", ", $copyCategories);
        }
        else {
            $strCategories = "SELECT id FROM categories";
        }

        $page = $arrFiltres['tFiltrage']['page'];

        $livresParPage = $arrFiltres['tFiltrage']['livresParPage'];
        $livreStart = (int)$page * (int)$livresParPage;

        $modeTriage = $arrFiltres['tFiltrage']['triage'];

//  ---------- REQUETE ----------
        $pdo = App::getInstance()->getPDO();

        $sql="";

        if (count($categories)>1){
            $sql = "SELECT count(*) as total
                FROM livres INNER JOIN categories_livres ON livres.id = categories_livres.livre_id
                WHERE categories_livres.categorie_id IN (".$strCategories.") AND livres.langue = :langue
                ORDER BY 
                    CASE WHEN :modeTriage = 'prixAsc' THEN prix END ASC,
                    CASE WHEN :modeTriage = 'prixDesc' THEN prix END DESC,
                    CASE WHEN :modeTriage = 'titreAsc' THEN titre END ASC,
                    CASE WHEN :modeTriage = 'titreDesc' THEN titre END DESC";
        }
        else {
            $sql = "SELECT count(*) as total
                FROM livres
                WHERE langue = :langue
                ORDER BY
                    CASE WHEN :modeTriage = 'prixAsc' THEN prix END ASC,
                    CASE WHEN :modeTriage = 'prixDesc' THEN prix END DESC,
                    CASE WHEN :modeTriage = 'titreAsc' THEN titre END ASC,
                    CASE WHEN :modeTriage = 'titreDesc' THEN titre END DESC";
        }

        $requete = $pdo->prepare($sql);

        if (count($categories)>1){
            $requete -> bindParam(':categories', $strCategories, PDO::PARAM_STR);
        }
        $requete -> bindParam(':langue', $langue, PDO::PARAM_STR);
        $requete -> bindParam(':modeTriage', $modeTriage, PDO::PARAM_STR);
        $requete -> bindParam(':livresParPage', $livresParPage, PDO::PARAM_INT);
        $requete -> bindParam(':offset', $livreStart, PDO::PARAM_INT);

        $requete->execute();
        $total = $requete->fetch();
        return $total;
    }

    public static function trouverCoupCoeur(){
        //On demande le PDO a la classe App
        $pdo = App::getInstance()->getPDO();
        //on fait la requete SQL
        $sql = "SELECT *, '' as url FROM livres WHERE est_coup_de_coeur = 1";
        $requete = $pdo->prepare($sql);
        $requete->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        $requete->execute();
        $coupCoeur = $requete->fetchAll();
        return $coupCoeur;
    }

public function getParution()
{
   return Parution::trouver($this->parution_id);
}

public function getAuteur($id)
{
       return Auteur::trouver($id);

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

    public static function trouverNouveautes(){
        //On demande le PDO a la classe App
        $pdo = App::getInstance()->getPDO();
        //on fait la requete SQL
        $sql = "SELECT * FROM livres ORDER BY annee_publication DESC LIMIT 1, 3";
        $requete = $pdo->prepare($sql);
        $requete->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        $requete->execute();
        $nouveaute = $requete->fetchAll();
        return $nouveaute;

    }

    public static function ISBNToEAN ($strISBN)
    {
        $myFirstPart = $mySecondPart = $myEan = $myTotal = "";
        if ($strISBN == "")
            return false;
        $strISBN = str_replace("-", "", $strISBN);
        // ISBN-10
        if (strlen($strISBN) == 10) {
            $myEan = "978" . substr($strISBN, 0, 9);
            $myFirstPart = intval(substr($myEan, 1, 1)) + intval(substr($myEan, 3, 1)) + intval(substr($myEan, 5, 1)) + intval(substr($myEan, 7, 1)) + intval(substr($myEan, 9, 1)) + intval(substr($myEan, 11, 1));
            $mySecondPart = intval(substr($myEan, 0, 1)) + intval(substr($myEan, 2, 1)) + intval(substr($myEan, 4, 1)) + intval(substr($myEan, 6, 1)) + intval(substr($myEan, 8, 1)) + intval(substr($myEan, 10, 1));
            $tmp = intval(substr((3 * $myFirstPart + $mySecondPart), -1));
            $myControl = ($tmp == 0) ? 0 : 10 - $tmp;

            return $myEan . $myControl;
        } // ISBN-13
        else if (strlen($strISBN) == 13) return $strISBN;
        // Autre
        else return false;
    }

    public static function trouverUnLivre($id){
    $pdo = App::getInstance()->getPDO();
    $requete = "SELECT * from livres where id = :id";
    $requetePrep = $pdo->prepare($requete);
    $requetePrep->bindParam(":id", $id);
    $requetePrep->setFetchMode(PDO::FETCH_CLASS, Livre::class);
    $requetePrep->execute();
    $leLivre = $requetePrep->fetch();
    return $leLivre;
    }

    public static function trouverUnisbn($isbn){
        $pdo = App::getInstance()->getPDO();
        $requete = "SELECT * from livres where isbn = :isbn";
        $requetePrep = $pdo->prepare($requete);
        $requetePrep->bindParam(":isbn", $isbn);
        $requetePrep->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        $requetePrep->execute();
        $leLivre = $requetePrep->fetch();
        return $leLivre;
    }
}


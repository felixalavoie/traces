<?php

namespace App\controleurs;

use App\modeles\Auteur;
use App\modeles\Collection;
use App\modeles\Livre;
use App\modeles\Categorie;
use App\App;
use App\sessions\SessionItem;
use \DateTime;
use App\modeles\Editeur;

class ControleurPanier
{
    private $blade = null;

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
    }

    public function ajouterItem()
    {

        if (isset($_POST["quantite"])) {
//echo $_POST["quantite"];
                $quantite = $_POST["quantite"];
//             else {
//                $quantite = -1;
//            }
        }
        if (isset($_GET["isbn"])) {
            $regExp = "#^[0-9]-[0-9]{5,}-[0-9]{2,}-[0-9A-z]$#";
            if (preg_match($regExp, $_GET["isbn"])) {
                $isbn = $_GET["isbn"];
            } else {
                $isbn = "";
            }
            //var_dump($isbn);
        }

        $panier = App::getInstance()->getSessionPanier();
        $panier->ajouterItem(Livre::trouverUnisbn($isbn), (int) $quantite);
        header("location:index.php?controleur=livre&action=fiche&isbn={$isbn}");
        exit;
    }

    public function fiche()
    {
            $panier = App::getInstance()->getSession()->getItem("panier");
            $tDonnees = array("panier" => $panier);
            echo $this->blade->run("panier.fiche", $tDonnees);
    }

    public function supprimerItem()
    {
       // var_dump("appelle de suppression");
        $panier = App::getInstance()->getSession()->getItem("panier");
        $panier->supprimerItemPanier((string) $_POST["isbn"]);
        $this->fiche();
    }

    public function MAJ()
    {
        $panier = App::getInstance()->getSession()->getItem("panier");
        $panier->setQuantiteItem($_POST["isbn"], $_POST["quantite"]);
        $this->fiche();
    }

    public function MAJAjax(){
        $panier = App::getInstance()->getSession()->getItem("panier");
        $panier->setQuantiteItem($_POST["isbn"], $_POST["quantite"]);
        $taxes = $panier->getMontantTPS();
        $soustotal = $panier->getMontantSousTotal();
        $frais = $panier->getMontantTPS();
        $totalfinal = $panier->getMontantTotal();
        $tDonnePayment =array_merge(
            array ("taxes" => $taxes),
            array ("soustotal" => $soustotal),
            array ("frais" => $frais),
            array ("totalfinal" => $totalfinal)
        );
        echo json_encode($tDonnePayment);



}



}
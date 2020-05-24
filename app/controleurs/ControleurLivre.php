<?php

namespace App\controleurs;

use App\FilAriane;
use App\modeles\Auteur;
use App\modeles\Collection;
use App\modeles\Livre;
use App\modeles\Categorie;
use App\App;
use \DateTime;
use App\modeles\Editeur;

class ControleurLivre
{
    private $blade = null;

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
    }

    public function index(): void
    {
//        Fil d'Ariane
        $filAriane = array('filAriane' => App::getInstance()->getFilAriane()->getFil('livres'));

//       SET les parametres de la requete (page, livres/page, mode de triage) avec une valeur par défault changer si ISSET
        $arrFiltresSession = App::getInstance()->getSession()->getItem('arrFiltrage');
        App::getInstance()->getSession()->supprimerItem('arrFiltrage');


        $categories = array('empty');
        if ($arrFiltresSession != 'clef inexistante') {
            if ($arrFiltresSession['tFiltrage']['categories'] != '') {
                $categories = $arrFiltresSession['tFiltrage']['categories'];
            }
        }
        if (isset($_POST['categories'])) {
            $categories = $_POST['categories'];
        }

// Pages default =0
            $page = 0;
            if ($arrFiltresSession['tFiltrage']['page'] != '') {
                $page = $arrFiltresSession['tFiltrage']['page'];
            }
            if (isset($_GET['page'])) {
                $page = (int)$_GET['page'];
//            $categories = $arrFiltresSession['tFiltrage']['categories'];
            }

            if(isset($_POST['categories'])) {
                if ($arrFiltresSession['tFiltrage']['categories'] != $_POST['categories']) {
                    $page = 0;
                }
            }
            //        par default = 12 livres/page, si demandeé autrement on change
            $livresParPage = 12;
            if ($arrFiltresSession['tFiltrage']['livresParPage'] != '') {
                $livresParPage = $arrFiltresSession['tFiltrage']['livresParPage'];
            }
            if (isset($_POST['livresParPage'])) {
                $livresParPage = (int)$_POST['livresParPage'];
            }

//        Par defaut, on trie en order alphabetique Desc, on change si demandé autrement
            $modeTriage = "titreAsc";
            if ($arrFiltresSession['tFiltrage']['triage'] != '') {
                $modeTriage = $arrFiltresSession['tFiltrage']['triage'];
            }
            if (isset($_POST['triage'])) {
                $modeTriage = $_POST['triage'];
            }
            else {
                $modeTriage = "titreAsc";
            }

        $arrFiltreCategories = array('categories' => $categories);
        $arrFiltrePage = array('page' => $page);
        $arrFiltreLivres = array('livresParPage' => $livresParPage);
        $arrFiltreTriage = array('triage' => $modeTriage);

        $arrFiltrage = array_merge($arrFiltrePage, $arrFiltreLivres);
        $arrFiltrage = array_merge($arrFiltrage, $arrFiltreTriage);
        $arrFiltrage = array_merge($arrFiltrage, $arrFiltreCategories);
        $tFiltrage = array('tFiltrage' => $arrFiltrage);

        App::getInstance()->getSession()->setItem('arrFiltrage', $tFiltrage);
        //        Trouve les livres pour la page actuelle
        $livres = Livre::trouverPage();
        // -----------------------------------------------------------------------------------------------------------

//      Changement du isbn10 en isbn13 et on affect le isbn13 à la colonne vide "url" ajoutée dans la requete
        foreach ($livres as $livre) {
            $isbn16 = Livre::ISBNToEAN($livre->isbn);

            if (file_exists("./liaisons/images/L" . $isbn16 . "1.jpg")) {
                $livre->url = "./liaisons/images/L" . $isbn16 . "1.jpg";
            } else {
                $livre->url = "./liaisons/images/placeholder.svg";
            }
        }
        $tLivres = array("livres" => $livres);

//        Setup de la pagination
        $nbrLivres = Livre::trouverCount()['total'];
        $tNbrLivres = array("nbrLivres" => $nbrLivres);
        $tPage = array("numeroPage" => $page);
        $url = array("urlPagination" => "./index.php?controleur=livre&action=index");
        $nbrPages = floor((int)$nbrLivres / (int)$livresParPage);
        $tNbrPages = array("nombreTotalPages" => $nbrPages);

//        Va chercher tout les nom des categories
        $sqlCategories = Categorie::toutCategories();
        $tCategories = array("categories" => $sqlCategories);

        $tDonnees = array("nomPage" => "Livres");

        $tDonnees = array_merge($tDonnees, $tLivres);
        $tDonnees = array_merge($tDonnees, $tNbrLivres);
        $tDonnees = array_merge($tDonnees, $tPage);
        $tDonnees = array_merge($tDonnees, $url);
        $tDonnees = array_merge($tDonnees, $tNbrPages);
        $tDonnees = array_merge($tDonnees, $tCategories);
        $tDonnees = array_merge($tDonnees, $tFiltrage);
        $tDonnees = array_merge($tDonnees, $filAriane);
        echo $this->blade->run("livres", $tDonnees); // /ressource/vues/accueil.blade.php doit exister...
    }

//Début de la page fiche
    public function fiche(): void
    {

        $idLivre = $_GET["isbn"];
        $livre = Livre::trouverUnisbn($idLivre);

        //        Fil d'Ariane
        $filAriane = array('filAriane' => App::getInstance()->getFilAriane()->getFil('special', $livre->titre));
// Aller chercher les auteurs
        $auteurs = Auteur::trouver($idLivre);
        $arrAuteurs = array('tAuteurs' => $auteurs);
// Aller chercher l'editeur
        $editeurs = Editeur::trouver($idLivre);
        $arrEditeur = array('tEditeur' => $editeurs);
        // Aller chercher la collection
        $collection = Collection::trouver($idLivre);
        $arrCollection = array('tCollection' => $collection);

// Fusion des donnees
        $tDonnes = array("livre" => $livre);
        $tDonnes = array_merge($tDonnes, $arrAuteurs);
        $tDonnes = array_merge($tDonnes, $arrEditeur);
        $tDonnes = array_merge($tDonnes, $arrCollection);
        $tDonnes = array_merge($tDonnes, $filAriane);
        echo $this->blade->run("fiche", $tDonnes);


    }
//
//
//
//    public static function getDonneeFragmentPiedDePage()
//    {
//        $date = new DateTime();
//        return array("dateDuJour" => $date->format('d M Y'));
//    }
}

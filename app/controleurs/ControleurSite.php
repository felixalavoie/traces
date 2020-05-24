<?php
declare(strict_types=1);

namespace App\controleurs;

use App\App;
use \PDO;
use App\modeles\Actualites;
use App\modeles\Livre;
use \DateTime;

class ControleurSite
{

    private $blade = null;

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
    }

    public function accueil(): void
    {
        //        Fil d'Ariane
        $filAriane = array('filAriane' => App::getInstance()->getFilAriane()->getFil('accueil'));

        //on va chercher les livres qui sont marqués comme coup de coeurs/nouveau
        $coupCoeurs = Livre::trouverCoupCoeur();
        $nouveautes = Livre::trouverNouveautes();
        $actualites = Actualites::trouverTout();

        shuffle($coupCoeurs);

        //on crée les tableaux de donnés nécessaires
        $tNouveautes = array("nouveautes"=>$nouveautes);
        $tCoupCoeurs = array("coupCoeurs"=>$coupCoeurs);

        //Tronquature et ajout des articles
        foreach ($actualites as $nouvelle){
            $tnouvelle = explode(" ", $nouvelle->texte);
            array_splice($tnouvelle, 55 );
            $nouvelleTronquee = implode(" ", $tnouvelle);
            $nouvelle->texte = $nouvelleTronquee;
        }

        $tActualite = array("actualite"=>$actualites);

        //on converti le isbn
        foreach ($coupCoeurs as $livre){
            $url =  Livre::ISBNToEAN($livre->isbn);
            $livre->url = $url;
        }

        foreach ($nouveautes as $livre){
            $url = Livre::ISBNToEAN($livre->isbn);
            $livre->url = $url;
        }
        $tDonnees = array("nomPage"=>"Accueil");

        //on mélange nos tableaux
        $tDonnees = array_merge($tDonnees, $tCoupCoeurs);
        $tDonnees = array_merge($tDonnees, $tNouveautes);
        $tDonnees = array_merge($tDonnees, $tActualite);
        $tDonnees = array_merge($tDonnees, ControleurSite::getDonneeFragmentPiedDePage());
        $tDonnees = array_merge($tDonnees, $filAriane);
        echo $this->blade->run("accueil",$tDonnees); // /ressource/vues/accueil.blade.php doit exister...
    }

    public function apropos():void
    {
        $tDonnees = array("nomPage"=>"À propos");
        $tDonnees = array_merge($tDonnees, ControleurSite::getDonneeFragmentPiedDePage());
        echo $this->blade->run("apropos",$tDonnees); // /ressource/vues/accueil.blade.php doit exister...
    }


    public static function getDonneeFragmentPiedDePage()
    {
        $date = new DateTime();
        return array("dateDuJour" => $date->format('d M Y'));
    }

    public function recherche()
    {
        $value = $_GET['value'];

        //Nouvelle valeur
        $pdo = App::getInstance()->getPDO();
        $resultats = $pdo->query("SELECT CONCAT(nom, ' ', prenom) AS nomcomplet FROM auteurs WHERE nom LIKE '".$value."%' ORDER BY nom");
        $auteurs = $resultats->fetchAll();
        $resultats->closeCursor();

        $ul = '<ul>';

        foreach($auteurs as $item) {
            $li = '<li>';
            $li .= $item['nomcomplet'];
            $li .= '</li>';
            $ul .= $li;
        }
        $ul .= '</ul>';

        //Retour
        echo $ul;
    }
}


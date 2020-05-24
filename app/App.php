<?php

declare(strict_types=1);

namespace App;

use App\controleurs\ControleurClient;
use App\controleurs\ControleurSite;
use App\controleurs\ControleurLivre;
use App\controleurs\ControleurPanier;
use App\controleurs\ControleurTransaction;
use App\sessions\SessionPanier;
use \PDO;
use eftec\bladeone\BladeOne;


class App
{
    private static $instance = null;
    private $pdo = null;
    private $blade = null;
    private $session = null;
    private $filAriane = null;

    private function __construct()
    {
    }

    public static function getInstance(): App
    {
        if (App::$instance === null) {
            App::$instance = new App();
        }
        return App::$instance;
    }

    public function demarrer(): void
    {
        $this->configurerEnvironnement();
        $this->routerLaRequete();
    }

    private function configurerEnvironnement(): void
    {
        if ($this->getServeur() === 'serveur-local') {
            error_reporting(E_ALL | E_STRICT);
        }
        date_default_timezone_set('America/Montreal');

    }


    public function getPDO(): PDO
    {
        // C'est plus performant en ram de récupérer toujours la même connexion PDO dans toute l'application.
        if ($this->pdo === null) {
            if ($this->getServeur() === 'serveur-local') {
                $maConnexionBD = new ConnexionBD('localhost', 'root', 'root', 'traces');
                $this->pdo = $maConnexionBD->getNouvelleConnexionPDO();
            } else if ($this->getServeur() === 'serveur-production') {
                $maConnexionBD = new ConnexionBD('localhost', '19_soupgang', 'poulenoire', '19_rpni3_soupgang');
                $this->pdo = $maConnexionBD->getNouvelleConnexionPDO();
            }
        }
        return $this->pdo;
    }


    public function getBlade(): BladeOne
    {
        if ($this->blade === null) {
            $cheminDossierVues = '../ressources/vues';
            $cheminDossierCache = '../ressources/cache';
            $this->blade = new BladeOne($cheminDossierVues, $cheminDossierCache, BladeOne::MODE_AUTO);
        }
        return $this->blade;
    }


    public function getServeur(): string
    {
        // Vérifier la nature du serveur (local VS production)
        $env = 'null';
        if ((substr($_SERVER['HTTP_HOST'], 0, 9) == 'localhost') ||
            (substr($_SERVER['HTTP_HOST'], 0, 7) == '192.168') ||
            (substr($_SERVER['SERVER_ADDR'], 0, 7) == '192.168')) {
            $env = 'serveur-local';
        } else {
            $env = 'serveur-production';
        }
        return $env;
    }

    public function getSession(): Session
    {
        if ($this->session === null) {
            $this->session = new Session();
            $this->session->demarrer();
        }
        return $this->session;
    }

    public function getSessionPanier():?SessionPanier
    {
        $monPanier = $this->getSession()->getItem("panier");
        if ($monPanier == null) {
            $monPanier = new SessionPanier();
        }
        return $monPanier;
    }

    public function getCookie(): Cookie
    {
        if ($this->cookie === null) {
            $this->cookie = new Cookie();
        }
        return $this->cookie;
    }

    public function getFilAriane(): FilAriane
    {
        if ($this->filAriane === null) {
            $this->filAriane = new FilAriane();
        }
        return $this->filAriane;
    }

    public function routerLaRequete(): void
    {
        $controleur = null;
        $action = null;

        // Déterminer le controleur responsable de traiter la requête
        if (isset($_GET['controleur'])) {
            $controleur = $_GET['controleur'];
        } else {
            $controleur = 'site';
        }

        // Déterminer l'action du controleur
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        } else {
            $action = 'accueil';
        }

        // Instantier le bon controleur selon la page demandée
        if ($controleur === 'site') {
            $this->monControleur = new ControleurSite();
            switch ($action) {
                case 'accueil':
                    $this->monControleur->accueil();
                    break;
                case 'apropos':
                    $this->monControleur->aPropos();
                    break;
                case 'recherche':
                    $this->monControleur->recherche();
                    break;
                default:
                    echo 'Erreur 404';
            }
        } else if ($controleur === 'livre') {
            $this->monControleur = new ControleurLivre();
            switch ($action) {
                case 'index':
                    $this->monControleur->index();
                    break;

                case 'fiche' :
                    $this->monControleur->fiche();
                    break;
                default:
                    echo 'Erreur 404';
            }
        } else if ($controleur === 'panier') {
            $this->monControleur = new ControleurPanier();
            switch ($action) {
                case 'ajouterItem':
                    $this->monControleur->ajouterItem();
                    break;
                case 'fiche':
                    $this->monControleur->fiche();
                    break;

                case 'supprimerItem':
                    $this->monControleur->supprimerItem();
                    break;

                case 'MAJ':
                    $this->monControleur->MAJ();
                    break;

                case 'MAJAjax':
                    $this->monControleur->MAJajax();
                    break;
                default:
                    echo 'Erreur 404';
            }

        }
        else if($controleur === "transaction"){
            $this->monControleur = new ControleurTransaction();
            switch ($action){
                case 'connexion':
                    $this->monControleur->connexion();
                    break;
                case 'inscription':
                    $this->monControleur->inscription();
                    break;
                case 'livraison':
                    $this->monControleur->livraison();
                    break;
                case 'validerLivraison':
                    $this->monControleur->validerLivraison();
                    break;
                case 'validerFacturation':
                    $this->monControleur->validerFacturation();
                    break;
                case 'validation':
                    $this->monControleur->validation();
                    break;
;               case 'facturation':
                    $this->monControleur->facturation();
                    break;
                case 'insertion':
                    $this->monControleur->insertionCommande();
                    break;
                default:
                    echo 'Erreur 404';
            }
        }
        else if($controleur === "client"){
            $this->monControleur = new ControleurClient();
            switch ($action){
                case 'connexion':
                    $this->monControleur->connexion();
                    break;
                case 'inscription':
                    $this->monControleur->inscription();
                    break;
                case 'validerInscription':
                    $this->monControleur->validerInscription();
                    break;
                case 'validerConnexion':
                    $this->monControleur->validerConnexion();
                    break;
                case 'verifierCourriel':
                    $this->monControleur->verifierCourriel();
                    break;
                case 'deconnexion':
                    $this->monControleur->deconnexion();
                    break;
                default:
                    echo 'Erreur 404';
            }
        }
        else {
            echo 'Erreur 404';
        }
    }

}
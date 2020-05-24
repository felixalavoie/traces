<?php


namespace App\controleurs;


use App\App;
use App\modeles\Client;
use App\Validation;

class ControleurClient
{
    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
    }
    public function connexion(){
        $tvalidation = App::getInstance()->getSession()->getItem("validations");
        App::getInstance()->getSession()->supprimerItem("validations");
        $tDonnees = array("validation"=>$tvalidation);
        echo $this->blade->run("transaction.connexion",$tDonnees);
    }

    public function deconnexion(){
        App::getInstance()->getSession()->supprimerItem("userId");
        header('Location: index.php?controleur=site&action=accueil');
        exit;
    }

    public function inscription(){
        $tvalidation = App::getInstance()->getSession()->getItem("validations");
        App::getInstance()->getSession()->supprimerItem("validations");
        $tDonnees = array("validation"=>$tvalidation);
        echo $this->blade->run("transaction.inscription",$tDonnees);
    }
    public function validerInscription()
    {
        $contenuBruteFichierJson = file_get_contents("../ressources/liaisons/json/objMessages.json");
        $tMessages = json_decode($contenuBruteFichierJson, true);
        $elementsValide = 0;

        //on va chercher les elements en post dans un array
        $elements = array(
            "prenom" => ["valeur" => $_POST["prenom"], "valide" => null, "message" => ""],
            "nom" => ["valeur" => $_POST["nom"], "valide" => null, "message" => ""],
            "courriel" => ["valeur" => $_POST["courriel"], "valide" => null, "message" => ""],
            "telephone" => ["valeur" => $_POST["telephone"], "valide" => null, "message" => ""],
            "motDePasse" => ["valeur" => $_POST["motDePasse"], "valide" => null, "message" => ""],);

        $elements["telephone"] = preg_replace("#-#", "", $elements['telephone']);

        //on valide chaque element un par un

        //validation du prenom
        $regexpNomPrenom = "#[A-ÿ-]+$#";
        if ($elements["prenom"]["valeur"] != "") {
            if (preg_match($regexpNomPrenom, $elements["prenom"]["valeur"])) {
                $elements["prenom"]["valide"] = '1';
            } else {
                $elements["prenom"]["message"] = $tMessages["prenom"]["erreurs"]["motif"];
                $elements["prenom"]["valide"] = '0';
            }
        } else {
            $elements["prenom"]["message"] = $tMessages["prenom"]["erreurs"]["vide"];
            $elements["prenom"]["valide"] = '0';
        }

        //validation du nom
        if ($elements["nom"]["valeur"] != "") {
            if (preg_match($regexpNomPrenom, $elements["nom"]["valeur"])) {
                $elements["nom"]["valide"] = '1';
            } else {
                $elements["nom"]["message"] = $tMessages["nom"]["erreurs"]["motif"];
                $elements["nom"]["valide"] = '0';
            }
        } else {
            $elements["nom"]["message"] = $tMessages["nom"]["erreurs"]["vide"];
            $elements["nom"]["valide"] = '0';
        }

        //validation du mot de passe
        $regexpMdp = "#^[a-zA-ÿ0-9]{6,20}$#";
        if ($elements["motDePasse"]["valeur"] != "") {
            if (preg_match($regexpMdp, $elements["motDePasse"]["valeur"])) {
                $elements["motDePasse"]["valide"] = '1';
            } else {
                $elements["motDePasse"]["message"] = $tMessages["motDePasse"]["erreurs"]["motif"];
                $elements["motDePasse"]["valide"] = '0';
            }
        } else {
            $elements["motDePasse"]["message"] = $tMessages["motDePasse"]["erreurs"]["vide"];
            $elements["motDePasse"]["valide"] = '0';
        }

        //validation du no de telephone
        $regexpTel = "#^[0-9]{10}$#";
        if ($elements["telephone"]["valeur"] != "") {
            if (preg_match($regexpTel, $elements["telephone"]["valeur"])) {
                $elements["telephone"]["valide"] = '1';
            } else {
                $elements["telephone"]["message"] = $tMessages["telephone"]["erreurs"]["motif"];
                $elements["telephone"]["valide"] = '0';
            }
        } else {
            $elements["telephone"]["message"] = $tMessages["telephone"]["erreurs"]["vide"];
            $elements["telephone"]["valide"] = '0';
        }

        //validation du courriel
        if ($elements["courriel"]["valeur"] != "") {
            //
            $courriel = $elements['courriel']['valeur'];
            $client = Client::verifierConnexion($courriel);
            if ($client == null){
                if (filter_var($elements["courriel"]["valeur"], FILTER_VALIDATE_EMAIL)) {
                    $elements["courriel"]["valide"] = '1';
                } else {
                    $elements["courriel"]["message"] = $tMessages["courriel"]["erreurs"]["motif"];
                    $elements["courriel"]["valide"] = '0';
                }
            }
            else{
                $elements["courriel"]["message"] = $tMessages["courriel"]["erreurs"]["dejaPris"];
                $elements["courriel"]["valide"] = '0';
            }
        } else {
            $elements["courriel"]["message"] = $tMessages["courriel"]["erreurs"]["vide"];
            $elements["courriel"]["valide"] = '0';
        }

        $champsValide = 0;
        foreach ($elements as $champ) {
            if ($champ["valide"] == true) {
                $champsValide = $champsValide + 1;
            }
        }
        if ($champsValide == count($elements)){
            $toutesLesEntreesSontValides = true;
        }
        else{
            $toutesLesEntreesSontValides = false;
        }

        if ($toutesLesEntreesSontValides){
            $this->creerClient($elements);
        }
        else{
            App::getInstance()->getSession()->setItem("validations", $elements);
            header('Location: index.php?controleur=client&action=inscription');
            exit;
        }
    }

    public function validerConnexion(){
        $elements = array(
            "courriel"=>["valeur"=>$_POST["courriel"],"valide"=>null, "message"=>""],
            "motDePasse"=>["valeur"=>$_POST["motDePasse"],"valide"=>null, "message"=>""]
        );
        $client = Client::verifierConnexion($_POST["courriel"]);
        if ($elements["courriel"]["valeur"] != "") {
            if (filter_var($elements["courriel"]["valeur"], FILTER_VALIDATE_EMAIL)) {
                if ($client != null) {
                    $elements["courriel"]["valide"] = "1";
                }
                else{
                    $elements["courriel"]["message"] = "aucun n'utilisateur n'est enregistré a cette adresse";
                    $elements["courriel"]["valide"] = "0";
                }
            }else{
                $elements["courriel"]["message"] = "courriel invalide";
                $elements["courriel"]["valide"] = "0";
            }
        }else
            {
                $elements["courriel"]["message"] = "veuillez remplir ce champ";
            $elements["courriel"]["valide"] = "0";
        }
            $regexpMdp = "#^[a-zA-ÿ0-9]{6,20}$#";
            if ($elements["motDePasse"]["valeur"] != ""){
                if (preg_match($regexpMdp, $elements["motDePasse"]["valeur"])){
                    $elements["motDePasse"]["valide"] = "1";
                }
                else{
                    $elements["motDePasse"]["message"] = "mot de passe invalide";
                    $elements["motDePasse"]["valide"] = "0";
                }
            }else{
                $elements["motDePasse"]["message"] = "veuillez remplir ce champ";
                $elements["motDePasse"]["valide"] = "0";
            }
            $champsValide = 0;
            foreach($elements as $champ){
                if ($champ["valide"] == "1") {
                    $champsValide = $champsValide + 1;
                }
            }
            if ($champsValide == count($elements)){
                if ($client != null && $client->mot_de_passe == $elements["motDePasse"]["valeur"]){
                    App::getInstance()->getSession()->setItem("userId", $client->id_client);
                    header('Location: index.php?controleur=panier&action=fiche');
                    exit;
                }
                else{
                    $elements["courriel"]["message"] = "cette combinaison n'existe pas";
                    $elements["courriel"]["valide"] = "0";
                    App::getInstance()->getSession()->setItem("validations", $elements);
                    header('Location: index.php?controleur=client&action=connexion');
                    exit;
                }
            }
            else{
                App::getInstance()->getSession()->setItem("validations", $elements);
                header('Location: index.php?controleur=client&action=connexion');
                exit;
            }

    }

    public function verifierCourriel(){
        $courriel = $_POST['courriel'];
        $client = Client::verifierConnexion($courriel);
        if ($client == null) {
            echo "1";
        }
        else {
            echo "0";
        }
    }

    public function creerClient($unclient){
        Client::creerClient($unclient);
        header('Location: index.php?controleur=client&action=connexion');
        exit;

    }
}
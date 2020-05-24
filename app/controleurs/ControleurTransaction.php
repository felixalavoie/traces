<?php

namespace App\controleurs;


use App\App;
use App\modeles\Adresse;
use App\modeles\Client;
use App\controleurs\ControleurClient;
use App\Validation;
use DateTime;

class ControleurTransaction
{
    private $arrMessages = array();

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
    }

// Redirige selon comment on est arrivé ici
    public function transaction(): void
    {
        if(isset($_POST['btnContinuerFacturation'])) {
            $this->facturation();
        }
        else if(isset($_POST['btnContinuerValidation'])) {
            $this->validation();
        }
        else {
            $this->livraison();
        }
    }


    public function livraison(): void
    {
//        Vérifie que l'utilisateur est connecté ======================================================================================
//        À enlever une fois la connexion implémentée

        if(App::getInstance()->getSession()->getItem('userId') == ''){
            header('Location: index.php?controleur=client&action=connexion');
        }

//            Préparation de la vue  ==================================================================================================
        $tDonnees = array('page'=>'livraison');
        $tDonnees = array_merge($tDonnees, array('formValidation'=>App::getInstance()->getSession()->getItem('formValidation')));
        echo $this->blade->run("transaction.livraison",$tDonnees);
    }

//    Arrive ici seulement après que validerLivraison() ait tout validé sans erreur
    public function facturation(): void
    {
        $id = App::getInstance()->getSession()->getItem('userId');

        $client = Client::getClient($id);

        $infosClient = array(
            'telephone'=>$client->__get('telephone'),
            'email'=>$client->__get('courriel'),
        );
        $arrClient = array('infosClient'=>$infosClient);

        $arrFormValidation = App::getInstance()->getSession()->getItem('formValidation');
        $arrInfosLivraison = App::getInstance()->getSession()->getItem('infosLivraison');
        $tDonnees = array('formValidation'=> $arrFormValidation);
        $tDonnees = array_merge($tDonnees, array('infosLivraison'=>$arrInfosLivraison));
        $tDonnees = array_merge($tDonnees, $arrClient);

        echo $this->blade->run("transaction.facturation", $tDonnees);
    }

//    Arrive ici seulement après que validerFacturation ait tout validé sans erreur
    public function validation(): void
    {
        $arrLivraison = array('infosLivraison'=>App::getInstance()->getSession()->getItem('infosLivraison'));
        $arrFacturation = array('infosFacturation'=>App::getInstance()->getSession()->getItem('infosFacturation'));

        $panier = App::getInstance()->getSession()->getItem('panier');
        $items = $panier->getItems();
        $arrPanier = array('panier'=>$panier);

        $tDonnees = array('page' => 'validation');
        $tDonnees = array_merge($tDonnees, $arrLivraison);
        $tDonnees = array_merge($tDonnees, $arrFacturation);
        $tDonnees = array_merge($tDonnees, $arrPanier);

        echo $this->blade->run("transaction.validation", $tDonnees);
    }

    private function confirmation() {
//        Ici serait le code si mandat A l'avait fait.
    }

//  Appelé par le formulaire de la page livraison. Valide puis A) Si il y a une erreur, met en session le tableau de validation et renvoi à livraison(). B) Si tout passe, met en session les infos en session et envoi à facturation()
    public function validerLivraison()  {
        $contenuBruteFichierJson = file_get_contents("../ressources/liaisons/json/objMessages.json");
        $tMessages = json_decode($contenuBruteFichierJson, true);

        $boolValide= true;
//        retire le Post du bouton
        $arrPost = $_POST;
        array_pop($arrPost);
        $arrValidation = array();


        foreach ($arrPost as $key => $value) {
            if($key == 'adresseDefault' || $key == 'adresseFacturation') {
                $arrObj = array(
                    "nom" => $key,
                    "valeur" => 'true',
                    "valide" => 'true',
                    "message" => ""
                );
            }
            else {
                $regexp='';

                switch ($key) {
                    case 'prenom':
                    case 'nom':
                    case 'ville':
                        $regexp = '#^[a-zA-ZÀ-ÿ -]{2,35}$#';
                        break;
                    case 'adresse':
                        $regexp = '#^[a-zA-ZÀ-ÿ0-9 -]{2,35}$#';
                        break;
                    case 'province':
                        $regexp = '#^[A-Z]{2}$#';
                        break;
                    case 'codepostal':
                        $regexp = '#^[A-Za-z][0-9][A-Za-z] ?[0-9][A-Za-z][0-9]$#';
                        break;
                    default:
                        echo 'Error 404';
                }

                $strIsValide = Validation::validerStr($value, $regexp);

                $arrObj = array(
                    "nom" => $key,
                    "valeur" => $value,
                    "valide" => $strIsValide,
                    "message" => ""
                );

//            On change le message si la valeur de passe pas la regex
                if ($arrObj["valide"] == "false") {
                    $boolValide = false;
                    if (trim($arrObj["valeur"]) == "") {
                        $arrObj["message"] = "c'est vide";
                        $arrObj["message"] = $tMessages[$key]['erreurs']['vide'];
                    } else {
                        $arrObj["message"] = "c'est mal";
                        $arrObj["message"] = $tMessages[$key]['erreurs']['motif'];
                    }
                }
            }
            $arrValidation[$key] = $arrObj;
        }
//        ==========================================================================================================
        if($boolValide == false){
            App::getInstance()->getSession()->setItem('formValidation', $arrValidation);
            header('Location: index.php?controleur=transaction&action=livraison');
        }
        else {
            App::getInstance()->getSession()->supprimerItem('formValidation');

            $infosLivraison = array(
                'prenom' => $arrValidation['prenom']['valeur'],
                'nom' => $arrValidation['nom']['valeur'],
                'adresse' => $arrValidation['adresse']['valeur'],
                'ville' => $arrValidation['ville']['valeur'],
                'province' => $arrValidation['province']['valeur'],
                'codepostal' => $arrValidation['codepostal']['valeur'],
            );

            App::getInstance()->getSession()->setItem('infosLivraison', $infosLivraison);
            header('Location: index.php?controleur=transaction&action=facturation');
        }
    }

    //  Appelé par le formulaire de la page facturation. Valide puis A) Si il y a une erreur, met en session le tableau de validation et renvoi à facturation(). B) Si tout passe, met en session les infos en session et envoi à validation()
    public function validerFacturation() {
        $contenuBruteFichierJson = file_get_contents("../ressources/liaisons/json/objMessages.json");
        $tMessages = json_decode($contenuBruteFichierJson, true);

        $boolValide= true;
//        retire le Post du bouton
        $arrPost = $_POST;
        array_pop($arrPost);
        $arrValidation = array();

        foreach ($arrPost as $key => $value) {
                $regexp='';

                switch ($key) {
                    case 'nom':
                        $regexp = '#^[a-zA-ZÀ-ÿ -]{2,35}$#';
                        break;
                    case 'code':
                        $regexp = '#^[0-9]{3}$#';
                        break;
                    case 'radioPaiement':
                        $regexp = '#^[A-Za-z ]{2,20}$#';
                        break;
                    case 'numero':
                        $regexp = '#^[0-9]{3,4}[ ]?[0-9]{4}[ ]?[0-9]{4}[ ]?[0-9]{4}$#';
                        break;
                    case 'expirationMois':
                        $regexp = '#^[0-9]{2}$#';
                        break;
                    case 'expirationAnnee':
                        $regexp = '#^[0-9]{4}$#';
                        break;
                    default:
                        echo 'Error 404';
                }

                $strIsValide = Validation::validerStr($value, $regexp);

                $arrObj = array(
                    "nom" => $key,
                    "valeur" => $value,
                    "valide" => $strIsValide,
                    "message" => ""
                );

//            On change le message si la valeur de passe pas la regex
                if ($arrObj["valide"] == "false") {
                    $boolValide = false;
                    if (trim($arrObj["valeur"]) == "") {
                        $arrObj["message"] = "c'est vide";
                        $arrObj["message"] = $tMessages[$key]['erreurs']['vide'];
                    } else {
                        $arrObj["message"] = "c'est mal";
                        $arrObj["message"] = $tMessages[$key]['erreurs']['motif'];
                    }
                }
            $arrValidation[$key] = $arrObj;
            }
//        ==========================================================================================================
        if($boolValide == false){
            App::getInstance()->getSession()->setItem('formValidation', $arrValidation);
            header('Location: index.php?controleur=transaction&action=facturation');
        }
        else {
            App::getInstance()->getSession()->supprimerItem('formValidation');

            $infosFacturation = array(
                'mode' => $arrValidation['radioPaiement']['valeur'],
                'nom' => $arrValidation['nom']['valeur'],
                'numeroCarte' => ($arrValidation['numero']['valeur']),
                'code' => $arrValidation['code']['valeur'],
                'expirationMois' => $arrValidation['expirationMois']['valeur'],
                'expirationAnnee' => $arrValidation['expirationAnnee']['valeur'],
            );

            App::getInstance()->getSession()->setItem('infosFacturation', $infosFacturation);

            header('Location: index.php?controleur=transaction&action=validation');
        }
    }

//    Appelé par le petit formulaire à la fin de la page validation, va chercher les infos en session et fait les insertions dans la BD
    public function insertionCommande() {
//        Cumul des données
        $arrLivraison = App::getInstance()->getSession()->getItem('infosLivraison');
        $arrFacturation = App::getInstance()->getSession()->getItem('infosFacturation');

        $panier = App::getInstance()->getSession()->getItem('panier');
        $items = $panier->getItems();
        $arrPanier = array('panier'=>$items);

        $idClient = App::getInstance()->getSession()->getItem('userId');

        $client = Client::getClient($idClient);

        $infosClient = array(
            'telephone'=>$client->__get('telephone'),
            'email'=>$client->__get('courriel'),
        );
        $arrClient = array('infosClient'=>$infosClient);

        $tDonnees = array('page' => 'insertion');
        $tDonnees = array_merge($tDonnees, $arrLivraison);
        $tDonnees = array_merge($tDonnees, $arrFacturation);
        $tDonnees = array_merge($tDonnees, $arrPanier);

// Insertion adresse =============================================================================================================================
        $adressePrenom = $arrLivraison['prenom'];
        $adresseNom = $arrLivraison['nom'];
        $adresse = $arrLivraison['adresse'];
        $adresseVille = $arrLivraison['ville'];
        $adresseProvince = $arrLivraison['province'];
        $adresseCodepostal = $arrLivraison['codepostal'];

        $pdo = App::getInstance()->getPDO();
        $sqlAdresseLivraison = "INSERT INTO t_adresse (prenom, nom, adresse, ville, code_postal, est_defaut, type, abbr_province, id_client)
                                VALUES (:adressePrenom, :adresseNom, :adresse, :adresseVille, :adresseCodepostal, 0, 'livraison', :adresseProvince, :idClient)";
        $requeteAdresseLivraison = $pdo->prepare($sqlAdresseLivraison);

        $requeteAdresseLivraison->bindparam(':adressePrenom', $adressePrenom);
        $requeteAdresseLivraison->bindparam(':adresseNom', $adresseNom);
        $requeteAdresseLivraison->bindparam(':adresse', $adresse);
        $requeteAdresseLivraison->bindparam(':adresseVille', $adresseVille);
        $requeteAdresseLivraison->bindparam(':adresseCodepostal', $adresseCodepostal);
        $requeteAdresseLivraison->bindparam(':adresseProvince', $adresseProvince);
        $requeteAdresseLivraison->bindparam(':idClient', $idClient);

        $requeteAdresseLivraison->execute();
        $id_adresse_livraison = $pdo->lastInsertId();
        $requeteAdresseLivraison->closeCursor();

//        --------------------------------------------------------------------------------------------------------------------------------------------

        $sqlAdresseFacturation = "INSERT INTO t_adresse (prenom, nom, adresse, ville, code_postal, est_defaut, type, abbr_province, id_client)
                                  VALUES (:adressePrenom, :adresseNom, :adresse, :adresseVille, :adresseCodepostal, 0, 'facturation', :adresseProvince, :idClient)";
        $requeteAdresseFacturation = $pdo->prepare($sqlAdresseFacturation);

        $requeteAdresseFacturation->bindparam(':adressePrenom', $adressePrenom);
        $requeteAdresseFacturation->bindparam(':adresseNom', $adresseNom);
        $requeteAdresseFacturation->bindparam(':adresse', $adresse);
        $requeteAdresseFacturation->bindparam(':adresseVille', $adresseVille);
        $requeteAdresseFacturation->bindparam(':adresseCodepostal', $adresseCodepostal);
        $requeteAdresseFacturation->bindparam(':adresseProvince', $adresseProvince);
        $requeteAdresseFacturation->bindparam(':idClient', $idClient);

        $requeteAdresseFacturation->execute();
        $id_adresse_facturation = $pdo->lastInsertId();
        $requeteAdresseFacturation->closeCursor();

// Insertion mode_paiement =============================================================================================================================
        $est_paypal = 0;
        if($arrFacturation['mode'] == 'paypal') {
            $est_paypal = 1;
        }
        $nom_complet = $arrFacturation['nom'];
        $no_carte = (string)$arrFacturation['numeroCarte'];
        $no_carte = str_replace(" ","",$no_carte);
        $type_carte = $arrFacturation['mode'];
        $date_expiration_carte= new DateTime("{$arrFacturation['expirationAnnee']}-{$arrFacturation['expirationMois']}-01");
        $date_expiration_carte = $date_expiration_carte->format('Y-m-d h-m-s');
        $code = $arrFacturation['code'];

        $sqlPaiement = "INSERT INTO t_mode_paiement (est_paypal, nom_complet, no_carte, type_carte, date_expiration_carte, code, est_defaut, id_client)
                        VALUES (:est_paypal, :nom_complet, :no_carte, :type_carte, :date_expiration_carte, :code, 0, :idClient)";

        $requetePaiement = $pdo->prepare($sqlPaiement);

        $requetePaiement->bindparam(':est_paypal', $est_paypal);
        $requetePaiement->bindparam(':nom_complet', $nom_complet);
        $requetePaiement->bindparam(':no_carte', $no_carte);
        $requetePaiement->bindparam(':type_carte', $type_carte);
        $requetePaiement->bindparam(':date_expiration_carte', $date_expiration_carte);
        $requetePaiement->bindparam(':code', $code);
        $requetePaiement->bindparam(':idClient', $idClient);

        $requetePaiement->execute();
        $id_mode_paiement = $pdo->lastInsertId();
        $requetePaiement->closeCursor();

// Insertion de la commande =============================================================================================================================
        $etat = 'en traitement';
        $date = new DateTime();
        $date = $date->format('Y-m-d h-m-s');
        $telephone = $arrClient['infosClient']['telephone'];
        $courriel = $arrClient['infosClient']['email'];
        $id = $idClient;

        //      mode_livraison et taux non intégrés/programmé par mandat C, j'utilise donc les premières occurences déja dans la BD'
        $id_mode_livraison =7;
        $id_taux =2;

        $sqlCommande = "INSERT INTO t_commande (etat, date, telephone, courriel, id_client, id_adresse_livraison, id_adresse_facturation, id_mode_paiement, id_mode_livraison, id_taux)
                        VALUES ('{$etat}', '{$date}', '{$telephone}', '{$courriel}', '{$idClient}', {$id_adresse_livraison}, {$id_adresse_facturation}, {$id_mode_paiement}, {$id_mode_livraison}, {$id_taux})";
        $requeteCommande = $pdo->prepare($sqlCommande);

        $requeteCommande->bindparam(':etat', $etat);
        $requeteCommande->bindparam(':date', $date);
        $requeteCommande->bindparam(':telephone', $telephone);
        $requeteCommande->bindparam(':courriel', $courriel);
        $requeteCommande->bindparam(':idClient', $idClient);
        $requeteCommande->bindparam(':id_adresse_livraison', $id_adresse_livraison);
        $requeteCommande->bindparam(':id_adresse_facturation', $id_adresse_facturation);
        $requeteCommande->bindparam(':id_mode_paiement', $id_mode_paiement);
        $requeteCommande->bindparam(':id_mode_livraison', $id_mode_livraison);
        $requeteCommande->bindparam(':id_taux', $id_taux);

        $requeteCommande->execute();
        $id_commande = $pdo->lastInsertId();
        $requeteCommande->closeCursor();

// Insertion lignes de commande =============================================================================================================================
        foreach($items as $item) {
            $isbn = $item->livre->__get('isbn');
            $prix = $item->livre->__get('prix');
            $qte = $item->quantite;
            

            $sqlLigneCommande = "INSERT INTO t_ligne_commande (isbn, prix, quantite, id_commande)
                                 VALUES (:isbn, :prix, :qte, :id_commande)";
            $requeteLigneCommande = $pdo->prepare($sqlLigneCommande);

            $requeteLigneCommande->bindparam(':isbn', $isbn);
            $requeteLigneCommande->bindparam(':prix', $prix);
            $requeteLigneCommande->bindparam(':qte', $qte);
            $requeteLigneCommande->bindparam(':id_commande', $id_commande);

            $requeteLigneCommande->execute();
            $requeteLigneCommande->closeCursor();
        }

//        C'est ici que j'appellerais la page de confirmation si elle était fait par le mandat A, alors je renvois à l'accueil
        header('Location: index.php?');
    }
}




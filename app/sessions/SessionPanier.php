<?php
declare(strict_types=1);

namespace App\sessions;

use App\modeles\Livre;
use App\App;
use App\sessions\SessionItem;

class SessionPanier
{

    private $items = [];

    public function __construct()
    {
    }


    // Ajoute un item au panier avec la qantité X
    // Attention: Si l'item existe déjà dans le panier alors mettre à jour la quantité (la quantité maximum est de 10 à valider...)
    public function ajouterItem(Livre $unLivre, int $uneQte): void
    {
        if ($this->items["{isbn}"] != null) {
            $isbn = $this->items["{isbn}"];
        } else {
            $isbn = $_GET["isbn"];
        }
        //var_dump($isbn);
        // var_dump($this->items->livre->__get("isbn"));
        if (isset($this->items[$unLivre->isbn])) {
            $quantiteExistante = $this->items[$unLivre->isbn]->quantite;
            $nouvelleQuantite = $quantiteExistante + $uneQte;
            if ($nouvelleQuantite >= 10) {
                $nouvelleQuantite = 10;
            }
            //var_dump($isbn);
            $this->setQuantiteItem($isbn, $nouvelleQuantite);;

        } else {
            $this->items[$unLivre->isbn] = new SessionItem($unLivre, $uneQte);
        }
        $this->sauvegarder();
        // var_dump($this->items[$unLivre->isbn]);
    }

    // Supprimer un item du panier
    public function supprimerItemPanier(string $isbn): void
    {
        unset($this->items[$isbn]);
        $this->sauvegarder();

    }

    // Retourner le tableau d'items du panier
    public function getItems(): array
    {
        return $this->items;
    }

    // Mettre à jour la quantité d'un item
    public function setQuantiteItem(string $isbn, int $uneQte): void
    {
        $this->items[$isbn]->quantite = $uneQte;
        $this->sauvegarder();

    }

    // Retourner la quantité d'un item
    public function getQuantiteItem(string $isbn): int
    {
        // À faire...
    }


    // Retourner le nombre d'item différents (unique) dans le panier
    public function getNombreTotalItemsDifferents($isbn): int
    {
        $nbrLivres = 0;
        foreach ($this->items["{isbn}"] as $valeur) {
            $nbrLivres = $nbrLivres + 1;
            return $nbrLivres;
        }
    }

    // Retourner le nombre de livres total dans le panier (somme de la quantité de chaque item)
    public function getNombreTotalItems(): string
    {

    }


    // Retourner le montant sousTotal du panier (somme des montantTotals de chaque item)
    public function getMontantSousTotal(): string
    {
        if ($this->items != null) {
            $sousTotal = 0;

            foreach ($this->items as $valeur) {
                $sousTotal = $sousTotal + $valeur->livre->prix * $valeur->quantite;
                $prixFormater = number_format($sousTotal, 2);
            }
            return $prixFormater;
        }
    }


    // Retourner de montant de la TPS
    // TPS = 5%
    public function getMontantTPS(): float
    {
        $montantTaxes = 0;
        $sousTotal = $this->getMontantSousTotal();
        $montantTaxes = $sousTotal / 100 * 5;
        $prixFormater = number_format($montantTaxes, 2);
        return floatval($prixFormater);
    }


    // Retourner le montant des frais de livraison
    // Frais de livraison (base=4$ + taux par item=3,50$) Exemple, 1livre=7,50$, 2livres=11$ etc.
    // Il n’y a pas de taxes sur les frais de livraison. Ils s’ajoutent en dernier.
    public function getMontantFraisLivraison(): string
    {
        $montantLivraison = 4;
        foreach ($this->items as $valeur) {
            $montantLivraison = $montantLivraison + $valeur->quantite * 3.50;
            $prixFormater = number_format($montantLivraison, 2);
        }
        return $prixFormater;
    }

    // Retourner le montant total de la commande (montant sous-total + TPS + montant livraison)
    public function getMontantTotal(): string
    {
        $montantTaxe = $this->getMontantTPS();
        $sousTotal = $this->getMontantSousTotal();
        $montantLivraisons = $this->getMontantFraisLivraison();
        $grandTotal = $montantTaxe + $sousTotal + $montantTaxe;
        $prixFormater = number_format($grandTotal, 2);
        return $prixFormater;
    }


    // Sauvegarder le panier en variable sessions nommée: panier
    public function sauvegarder(): void
    {
        App::getInstance()->getSession()->setItem("panier", $this);
    }

    // Supprimer le panier en variable sessions nommée: panier
    public function supprimer()
    {
        // À faire...
    }

}

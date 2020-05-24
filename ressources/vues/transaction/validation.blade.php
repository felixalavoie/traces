@extends('gabarit')

@section('contenu')
    <div class="conteneur">
        <h1 class="h2 centerThis">Validation</h1>

        <div class="barreProgression">
            <div class="etape etapeComplete" >
                <a href="index.php?controleur=transaction&action=livraison">1. Livraison</a>
            </div>
            <div class="etape etapeComplete">
                <a href="">2. Facturation</a>
            </div>
            <div class="etape etapeActive">
                <a href="">3. Confirmation</a>
            </div>
        </div>

        <div class="infosPanier">
            <h3 class="panier__titre">Panier :</h3>
            @include('transaction.panier')
        </div>

        <div class="infosLivraison">
            <h3 class="infosLivraison__titre">Informations de livraison :</h3>

            <div class="uneinfos">
                <span class="infosLivraison__label infosLivraison__label--nom">
                    Nom:
                </span>
                <span class="infosLivraison__text infosLivraison__text--nom">
                    {{ $infosLivraison['nom'] }}
                </span>
            </div>

            <div class="uneinfos">
                <span class="infosLivraison__label infosLivraison__label--prenom">
                    Prénom:
                </span>
                <span class="infosLivraison__text infosLivraison__text--prenom">
                    {{ $infosLivraison['prenom'] }}
                </span>
            </div>

            <div class="uneinfos">
                <span class="infosLivraison__label infosLivraison__label--adresse">
                    Adresse:
                </span>
                <span class="infosLivraison__text infosLivraison__text--adresse">
                    {{ $infosLivraison['adresse'] }}
                </span>
            </div>

            <div class="uneinfos">
                <span class="infosLivraison__label infosLivraison__label--ville">
                    Ville:
                </span>
                <span class="infosLivraison__text infosLivraison__text--ville">
                    {{ $infosLivraison['ville'] }}
                </span>
            </div>

            <div class="uneinfos">
                <span class="infosLivraison__label infosLivraison__label--province">
                    Province:
                </span>
                <span class="infosLivraison__text infosLivraison__text--province">
                    {{ $infosLivraison['province'] }}
                </span>
            </div>

            <div class="uneinfos">
                <span class="infosLivraison__label infosLivraison__label--codepostal">
                    Code postal:
                </span>
                <span class="infosLivraison__text infosLivraison__text--codepostal">
                    {{ $infosLivraison['codepostal'] }}
                </span>
            </div>

            <button>Modifier</button>
        </div>

        <div class="infosFacturation">
            <h3 class="infosFacturation__titre">Informations de facturation :</h3>

            <div class="uneinfos">
                <span class="infosFacturation__label infosFacturation__label--modePaiement">
                    Mode de paiement:
                </span>
                <span class="infosFacturation__text infosFacturation__text--modePaiement">
                    {{ $infosFacturation['mode'] }}
                </span>
            </div>

            <div class="uneinfos">
                <span class="infosFacturation__label infosFacturation__label--nom">
                    Nom:
                </span>
                <span class="infosFacturation__text infosFacturation__text--nom">
                    {{ $infosFacturation['nom'] }}
                </span>
            </div>

            <div class="uneinfos">
                <span class="infosFacturation__label infosFacturation__label--code">
                    Code de sécurité:
                </span>
                <span class="infosFacturation__text infosFacturation__text--code">
                    {{ $infosFacturation['code'] }}
                </span>
            </div>

            <div class="uneinfos">
                <span class="infosFacturation__label infosFacturation__label--numero">
                    Numéro de carte:
                </span>
                <span class="infosFacturation__text infosFacturation__text--numero">
                    {{ $infosFacturation['numeroCarte'] }}
                </span>
            </div>

            <div class="uneinfos">
                <span class="infosFacturation__label infosFacturation__label--expiration">
                    Expiration :
                </span>
                <span class="infosFacturation__text infosFacturation__text--expiration">
                    {{ $infosFacturation['expirationMois'] }} / {{ $infosFacturation['expirationAnnee'] }}
                </span>
            </div>

            <button>Modifier</button>
        </div>
    </div>

    <form action="index.php?controleur=transaction&action=insertion" method="post">
        <input type="submit">
    </form>
@endsection

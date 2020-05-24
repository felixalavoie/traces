@extends('gabarit')

@section('contenu')
    <div class="conteneur">
        <h1 class="screen-reader-only">Facturation</h1>

        <div class="barreProgression">
            <div class="etape etapeComplete" >
                <a href="index.php?controleur=transaction&action=livraison">1. Livraison</a>
            </div>
            <div class="etape etapeActive">
                <a href="">2. Facturation</a>
            </div>
            <div class="etape etapeInactive">
                <a href="">3. Confirmation</a>
            </div>
        </div>

        <form action="index.php?controleur=transaction&action=validerFacturation" method="post" class="formFacturation">
            <fieldset class="formFacturation_fieldset">
                <legend class="formFacturation__legend"<h2 class="h2">Informations de paiement</h2></legend>
                <div>
                    <h3>Mode de paiement</h3>
                    <div class="flexContainer__paiement">
                        <div class="flexItem__paiement paypal formFacturation__div">
                            <input type="radio" class="paiement_mode formFacturation__input formFacturation__label--paypal" name="radioPaiement" id="radioPaypal" value="paypal"
                            @if($formValidation['radioPaiement']['valeur']=='paypal')checked @endif>
                            <label for="radioPaypal">
                                <img src="./liaisons/images/logo_Paypal.jpg" class="icone_paiement icone_paiement--paypal icone_carte" alt="logo paypal">
                                <span class="screen-reader-only">Paypal</span>
                            </label>
                        </div>
                        <div class="flexItem__paiement credit visa">
                            <input type="radio" class="paiement_mode formFacturation__input formFacturation__input--visa" name="radioPaiement" id="visa" value="VISA"
                                   @if($formValidation['radioPaiement']['valeur']=='VISA')checked @endif
                            @if(isset($formValidation['radioPaiement']['valeur'])== false)checked @endif>
                            <label for="" class="credit__label credit__label--visa">
                                <span class="screen-reader-only">Visa</span>
                                <img src="./liaisons/images/logo_visa.gif" alt="logo visa" class="icone_carte">
                            </label>
                        </div>
                        <div class="flexItem__paiement credit mastercard">
                            <input type="radio" class="paiement_mode formFacturation__input formFacturation__input--mastercard" name="radioPaiement" id="mastercard" value="Master Card"
                                   @if($formValidation['radioPaiement']['valeur']=='Master Card')checked @endif>
                            <label for="" class="credit__label credit__label--visa">
                                <span class="screen-reader-only">Master Card</span>
                                <img src="./liaisons/images/logo_mc.png" alt="logo mastercard" class="icone_carte">
                            </label>
                        </div>
                        <div class="flexItem__paiement credit amex">
                            <input type="radio" class="paiement_mode formFacturation__input formFacturation__input--amex" name="radioPaiement" id="Amex" value="American Express"
                                   @if($formValidation['radioPaiement']['valeur']=='American Express')checked @endif>
                            <label for="" class="credit__label credit__label--visa">
                                <span class="screen-reader-only">American Express</span>
                                <img src="./liaisons/images/logo_amex.png" alt="logo american express" class="icone_carte">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="infos">
                    <div class="infos__div infos_nom">
                        <label class="infos__label infos__label--nom" for="infos_nom">Nom</label>
                        <input type="text" id="infos__nom" class="infos__input infos__input--nom" name="nom"
                        value="{{ $formValidation['nom']['valeur'] }}">
                        <p class="messageErreur">
                            {{ $formValidation['nom']['message'] }}
                        </p>
                    </div>

                    <div class="infos__div infos_numero">
                        <label class="infos__label infos__label--numero" for="infos__numero">Numéro de la carte</label>
                        <input type="text" id="infos__numero" class="infos__input infos__input--numero" name="numero"
                               value="{{ $formValidation['numero']['valeur'] }}">
                        <p class="messageErreur">
                            {{ $formValidation['numero']['message'] }}
                        </p>
                    </div>

                    <div class="infos__div infos_code">
                        <label class="infos__label infos__label--code" for="infos__code">Code de sécurité</label>
                        <input type="text" id="infos__code" class="infos__input infos__input--code" name="code"
                               value="{{ $formValidation['code']['valeur'] }}">
                        <p class="messageErreur">
                            {{ $formValidation['code']['message'] }}
                        </p>
                    </div>

                    <fieldset class="infos__expiration">
                        <legend class="infos__expiration--legend">Date d'expiration <span class="italique">MM AAAA</span></legend>

                        <div class="unSelect">
                                <label class="infos__label infos__label--expiration-mois" for="infos_expiration-mois"><span class="screen-reader-only">Mois</span></label>
                                <select name="expirationMois" id="infos_expiration-mois" class="infos__select infos__select--mois">
                                    <option value="">Mois</option>
                                    <option value="00"
                                    @if($formValidation['expirationMois']['valeur']=="00") selected @endif>01</option>
                                    <option value="01"
                                            @if($formValidation['expirationMois']['valeur']=="01") selected @endif>02</option>
                                    <option value="02"
                                            @if($formValidation['expirationMois']['valeur']=="02") selected @endif>03</option>
                                    <option value="03"
                                            @if($formValidation['expirationMois']['valeur']=="03") selected @endif>04</option>
                                    <option value="04"
                                            @if($formValidation['expirationMois']['valeur']=="04") selected @endif>05</option>
                                    <option value="05"
                                            @if($formValidation['expirationMois']['valeur']=="05") selected @endif>06</option>
                                    <option value="06"
                                            @if($formValidation['expirationMois']['valeur']=="06") selected @endif>07</option>
                                    <option value="07"
                                            @if($formValidation['expirationMois']['valeur']=="07") selected @endif>08</option>
                                    <option value="08"
                                            @if($formValidation['expirationMois']['valeur']=="08") selected @endif>09</option>
                                    <option value="09"
                                            @if($formValidation['expirationMois']['valeur']=="09") selected @endif>10</option>
                                    <option value="10"
                                            @if($formValidation['expirationMois']['valeur']=="10") selected @endif>11</option>
                                    <option value="11"
                                            @if($formValidation['expirationMois']['valeur']=="11") selected @endif>12</option>
                                </select>
                        </div>
                            <div class="unSelect unSelect__annee">
                                <label class="infos__label infos__label--expiration-annee" for="infos_expiration-annee"><span class="screen-reader-only">Année</span></label>
                                <select name="expirationAnnee" id="infos_expiration-annee" class="infos__select infos__select--annee">
                                    <option value="">Année</option>
                                    <?php
                                    for($i = date('Y'); $i<=date('Y')+5; $i++) {
                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                    </fieldset>
                    <p class="messageErreur">
                        {{ $formValidation['expirationMois']['message'] }}<br/>
                        {{ $formValidation['expirationAnnee']['message'] }}
                    </p>
                </div>
            </fieldset>

            <div class="adresseFacturation">
                <h3 class="adresseFacturation adresseFacturation__titre">
                    Adresse de facturation
                </h3>
                <span class="adresseFacturation__ligne adresseFacturation__nom">
                    {{ $infosLivraison['nom'] }} {{ $infosLivraison['prenom'] }}
                </span>
                <span class="adresseFacturation__ligne adresseFacturation__adresse">
                    {{ $infosLivraison['adresse'] }}
                </span>
                <span class="adresseFacturation__ligne adresseFacturation__ville">
                    {{ $infosLivraison['ville'] }}, {{ $infosLivraison['province'] }}
                </span>
                <span class="adresseFacturation__ligne adresseFacturation__codepostal">
                    {{ $infosLivraison['codepostal'] }}
                </span>

                <button class="adresseFacturation__btn">
                    Modifier
                </button>
            </div>

            <div class="infosFacturation">
                <h3 class="infosFacturation infosFacturation__titre">
                    Adresse de facturation
                </h3>
                <span class="infosFacturation__ligne infosFacturation__email">
                    {{ $infosClient['email'] }}
                </span>
                <span class="infosFacturation__ligne infosFacturation__telephone">
                    {{ $infosClient['telephone'] }}
                </span>

                <button class="infosFacturation__btn">
                    Modifier
                </button>
            </div>

            <button type="submit" value="continuer" name="btnContinuerValidation" class="btn btnAppliquer clearfix">Continuer</button>
        </form>
    </div>
@endsection

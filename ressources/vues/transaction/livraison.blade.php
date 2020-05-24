@extends('gabarit')

@section('contenu')
    <div class="conteneur">
        <h1 class="h2 centerThis">Livraison</h1>
        <div class="barreProgression">
            <div class="etape etapeActive" >
                <a href="index.php?controleur=transaction&action=livraison">1. Livraison</a>
            </div>
            <div class="etape etapeInactive">
                <a href="">2. Facturation</a>
            </div>
            <div class="etape etapeInactive">
                <a href="">3. Confirmation</a>
            </div>
        </div>
        <form action="index.php?controleur=transaction&action=validerLivraison" method="post" class="formTransaction">
            <div class="flexContainerLivraison">
                <div class="formTransaction__div">
                    <label for="prenom" class="formTransaction__label formTransaction__label--prenom">Prenom</label>
                    <input type="text" id="prenom" name="prenom" class="formTransaction__input formTransaction__input--prenom"
                           value="{{ $formValidation['prenom']['valeur'] }}">
                    <p class="messageErreur">
                        {{ $formValidation['prenom']['message'] }}
                    </p>
                </div>
                <div class="formTransaction__div">
                    <label for="nom" class="formTransaction__label formTransaction__label--nom">Nom</label>
                    <input type="text" id="nom" name="nom" class="formTransaction__input formTransaction__input--nom"
                           value="{{ $formValidation['nom']['valeur'] }}">
                    <p class="messageErreur">
                        {{ $formValidation['nom']['message'] }}
                    </p>
                </div>
                <div class="formTransaction__div">
                    <label for="adresse" class="formTransaction__label formTransaction__label--adresse">Adresse</label>
                    <input type="text" id="adresse" name="adresse" class="formTransaction__input formTransaction__input--adresse"
                           value="{{ $formValidation['adresse']['valeur'] }}">
                    <p class="messageErreur">
                        {{ $formValidation['adresse']['message'] }}
                    </p>
                </div>
                <div class="formTransaction__div">
                    <label for="ville" class="formTransaction__label formTransaction__label--ville">Ville</label>
                    <input type="text" id="ville" name="ville" class="formTransaction__input formTransaction__input--ville"
                           value="{{ $formValidation['ville']['valeur'] }}">
                    <p class="messageErreur">
                        {{ $formValidation['ville']['message'] }}
                    </p>
                </div>
                <div class="formTransaction__div">
                    <label for="province" class="formTransaction__label formTransaction__label--province">Province</label>
                    <select name="province" class="formTransaction__input formTransaction__input--province formTransaction__select">
                        <option value=""
                                @if ($formValidation['province']['valeur'] == '')
                                selected
                                @endif >Sélectionnez un province</option>
                        <option value="AB"
                                @if ($formValidation['province']['valeur'] == 'AB')
                                selected
                                @endif >Alberta</option>
                        <option value="BC"
                                @if ($formValidation['province']['valeur'] == 'BC')
                                selected
                                @endif >Colombie-Britannique</option>
                        <option value="MB"
                                @if ($formValidation['province']['valeur'] == 'MB')
                                selected
                                @endif >Manitoba</option>
                        <option value="NB"
                                @if ($formValidation['province']['valeur'] == 'NB')
                                selected
                                @endif >Nouveau-Brunswick</option>
                        <option value="NL"
                                @if ($formValidation['province']['valeur'] == 'NL')
                                selected
                                @endif >Terre-Neuve-et-Labrador</option>
                        <option value="NS"
                                @if ($formValidation['province']['valeur'] == 'NS')
                                selected
                                @endif >Nouvelle-Écosse</option>
                        <option value="NT"
                                @if ($formValidation['province']['valeur'] == 'NT')
                                selected
                                @endif >Territoires du Nord-Ouest et Nunavut</option>
                        <option value="ON"
                                @if ($formValidation['province']['valeur'] == 'ON')
                                selected
                                @endif >Ontario</option>
                        <option value="PE"
                                @if ($formValidation['province']['valeur'] == 'PE')
                                selected
                                @endif >Île-du-Prince-Édouard</option>
                        <option value="QC"
                                @if ($formValidation['province']['valeur'] == 'QC')
                                selected
                                @endif >Québec</option>
                        <option value="SK"
                                @if ($formValidation['province']['valeur'] == 'SK')
                                selected
                                @endif >Saskatchewan</option>
                        <option value="YT"
                                @if ($formValidation['province']['valeur'] == 'YT')
                                selected
                                @endif >Yukon</option>
                    </select>
                    <p class="messageErreur">
                        {{ $formValidation['province']['message'] }}
                    </p>
                </div>
                <div class="formTransaction__div">
                    <label for="codepostal" class="formTransaction__label formTransaction__label--codepostal">Code Postal</label>
                    <input type="text" id="codepostal" name="codepostal" class="formTransaction__input formTransaction__input--codepostal"
                           value="{{ $formValidation['codepostal']['valeur'] }}">
                    <p class="messageErreur">
                        {{ $formValidation['codepostal']['message'] }}
                    </p>
                </div>
                <div class="checkboxes formTransaction__div">
                    <div>
                        <input type="checkbox" id="adresseDefault" name="adresseDefault" class="formTransaction__checkbox" @if (isset($formValidation['adresseDefault']))
                        checked @endif>
                        <label for="adresseDefault" class="formTransaction__label formTransaction__label--adresse">Adresse de livraison par default</label>
                    </div>
                    <div>
                        <input type="checkbox" id="adresseFacturation" name="adresseFacturation" class="formTransaction__checkbox" @if (isset($formValidation['adresseFacturation']))
                        checked @endif>
                        <label for="adresseFacturation" class="formTransaction__label formTransaction__label--adresse">Utiliser comme adresse de facturation</label>
                    </div>
                </div>
            </div>
            <button type="submit" value="Continuer" name="btnContinuerFacturation" class="btn clearfix">Continuer</button>
        </form>
    </div>
@endsection

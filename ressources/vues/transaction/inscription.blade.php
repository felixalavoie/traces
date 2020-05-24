@extends('gabarit')

@section('contenu')
    <div class="conteneur">
        <h2>inscription</h2>
        <div class="formulaire">
            <form action="index.php?controleur=client&action=validerInscription" method="post" novalidate>
                <div class="nomPrenom__conteneur">
                    <div class="nomPrenom">
                        <label for="prenom">Prenom</label>
                        <input type="text" id="prenom" name="prenom" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$"
                               value="{{$validation["prenom"]["valeur"]}}" class="form__input prenom
                               @if($validation["prenom"]["valide"] == "0")
                                error
                               @endif">
                    <p class="error" id="erreurPrenom">{{$validation["prenom"]["message"]}}</p>
                    </div>

                    <div class="nomPrenom">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" value="{{$validation["nom"]["valeur"]}}" class="form__input nom
                           @if($validation["nom"]["valide"] == "0")
                                error
                               @endif">
                    <p class="error" id="erreurNom">{{$validation["nom"]["message"]}}</p>
                    </div>
                </div>

                <p>
                    <label for="courriel">Adresse Courriel</label>
                    <input type="email" id="courriel" required value="{{$validation["courriel"]["valeur"]}}" name="courriel" class="form__input
                           @if($validation["courriel"]["valide"] == "0")
                           error
                           @endif
                    ">
                <p class="error" id="errorCourriel">{{$validation["courriel"]["message"]}}</p>
                </p>
                <p>
                    <label for="telephone">Telephone</label>
                    <p class="screen-reader-only">exemple: 418-563-1088</p>
                    <input type="tel" id="telephone" pattern="\d{3}[\-]\d{3}[\-]\d{4}" name="telephone" value="{{$validation["telephone"]["valeur"]}}" class="form__input
                           @if($validation["telephone"]["valide"] == "0")
                           error
                           @endif">
                    <br/>
                    <small>ex:418-563-1088</small>
                <p class="error" id="errorTelephone">{{$validation["telephone"]["message"]}}</p>
                </p>
                <p>
                    <label for="motDePasse">Mot de passe</label>
                    <input type="password" id="motDePasse" pattern="[a-zA-ÿ0-9]{6,20}" name="motDePasse" class="form__input
                           @if($validation["motDePasse"]["valide"] == "0")
                           error
                           @endif">
                <p class="error" id="errorMotDePasse">{{$validation["motDePasse"]["message"]}}</p>
                </p>
                <p class="flex flex__mdp">
                    <input type="checkbox" class="showMdp" id="montrerMdp" name="montrerMdp">
                    <label for="montrerMdp">Afficher le mot de passe</label>
                </p>
                <div class="bt_liens_button">
                    <button>S'inscrire</button>
                </div>

                <br/>
                <a href="index.php?controleur=client&action=connexion" class="lienForm">deja inscrit? connectez-vous!</a>
            </form>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="liaisons/js/ajaxCourriel.js"></script>
    <script type="text/javascript" src="liaisons/js/validationClient.js"></script>
@endsection

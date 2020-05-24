@extends('gabarit')

@section('contenu')
    <div class="conteneur">
        <h2>Connexion</h2>
        <div class="formulaire__connexion">
            <form action="index.php?controleur=client&action=validerConnexion" novalidate method="post">
                <p>
                    <label for="Courriel">Courriel</label>
                    <input type="email" id="courriel" name="courriel" class="form__input
                    @if($validation["courriel"]["valide"]=="0")
                            error"
                    @endif
                            value="{{$validation["courriel"]["valeur"]}}">
                </p>
                <p class="error" id="errorCourriel">{{$validation["courriel"]["message"]}}</p>
                <p>
                    <label for="motDePasse">Mot de passe</label>
                    <input type="password" id="motDePasse" pattern="[a-zA-ÿ0-9]{6,20}" name="motDePasse" class="form__input
                    @if($validation["courriel"]["valide"]=="0")
                            error"
                            @endif
                    value="{{$validation["motDePasse"]["valeur"]}}">
                </p>
                <p class="error" id="errorMotDePasse">{{$validation["motDePasse"]["message"]}}</p>
                <div class="bt_liens_button bt_liens_button_connexion">
                    <button>Se connecter</button>
                </div>
                <br/>
            </form>
            <a href="index.php?controleur=client&action=inscription" class="lienForm">vous n'avez pas de compte? inscrivez vous</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="liaisons/js/validationClient.js"></script>
@endsection

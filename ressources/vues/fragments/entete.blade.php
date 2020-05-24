
<div class="entete">
<div class="conteneur">
    <img class="logo" src="liaisons/images/logo_traces.svg" alt="Logo Traces">
    <div class="navEntete">
        <div class="flex-entete">
            <?php if ($_SESSION['userId'] == null){ ?>
            <a href="index.php?controleur=client&action=connexion">
                <span class="icone icone__connexion"></span>
            </a>
            <?php }else{ ?>
                <a href="index.php?controleur=client&action=deconnexion">
                    <span class="icone icone__deconnexion"></span>
                </a>
            <?php } ?>
            <a href="index.php?controleur=panier&action=fiche">
                <span class="icone icone__panier"></span>
            </a>
{{--            <div class="hamburger">--}}
{{--                <div class="ligne"></div>--}}
{{--                <div class="ligne"></div>--}}
{{--                <div class="ligne"></div>--}}
{{--            </div>--}}
        </div>
        @include('fragments.recherche')
    </div>
</div>

</div>
<ul class="navigation">
    <li><a href="index.php?controleur=site&action=accueil">Accueil</a></li>
    <li><a href="index.php?controleur=livre&action=index">Livres</a></li>
    <li><a href="#">Meilleur Vendeurs</a></li>
    <li><a href="#">Decouvrir Traces</a></li>
    <li><a href="#">Auteurs</a></li>
    <li><a href="#">À Propos</a></li>
</ul>



@extends('gabarit')

@section('contenu')
        <div>
            <div class="conteneur__coupCoeur">
                <div class="flex flex__titre">
                    <div class="titre">
                        <h2>Coups de Coeur</h2>
                    </div>
                </div>
                <div class="flex lesCoupDeCoeurs">
                    @for($cpt = 0 ; $cpt <= 3 ; $cpt++)
                        <div class="coupCoeur">
                            <a href="index.php?controleur=livre&action=fiche&isbn={{ $coupCoeurs[$cpt]->isbn }}" class="coupCoeur__image">
                                <img class="couvertureLivre" src="./liaisons/images/L{{$coupCoeurs[$cpt]->url}}1.jpg"
                                     alt="couverture du livre{{$coupCoeurs[$cpt]->titre}}">
                                <div class="consulter">
                                    <span>{{$coupCoeurs[$cpt]->titre}}</span>
                                    <img class="consulter consulter_icone" src="./liaisons/images/consulter.svg" alt="">
                                </div>

                            </a>
                        </div>
                    @endfor
                </div>

            </div>
        </div>
        <div class="conteneur">
        <div>
            <h2>Nouveautés</h2>
            <ul class="flex__nouveaute">
                @foreach($nouveautes as $nouveaute)
                    <li class="nouveaute">
                        <div class="conteneurNouveaute">
                            <a href="index.php?controleur=livre&action=fiche&isbn={{ $nouveaute->isbn }}" class="conteneur__filtre">
                                <img src="./liaisons/images/L{{$nouveaute->url}}1.jpg"
                                     alt="couverture du livre{{$nouveaute->titre}}">
                            </a>
                        </div>

                    </li>
                @endforeach
            </ul>
            <div class="bt_liens centerThis">
                <a href="" class="">Consulter les nouveautés</a>
            </div>


        </div>
        <div>
            <h2>Actualités</h2>
            <div class="flex__articles ">
                @for($cpt = 0; $cpt<=1; $cpt++)
                    <div class="articles">
                        <img src="./liaisons/images/article1.png" alt="">
                        <h3 class="article__titre">{{$actualite[$cpt]->titre}}</h3>
                        <p>{{$actualite[$cpt]->texte}}...</p>
                        <div class="bt_liens centerThis">
                            <a href="" >consulter l'article</a>
                        </div>

                    </div>
                @endfor
            </div>
        </div>
        </div>
        @endsection




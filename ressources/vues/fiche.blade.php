@extends("gabarit")

@section("contenu")
    <div class="conteneur">
        <div class="divAriane">
            <span class="divAriane__fil"><?php echo html_entity_decode($filAriane) ?></span>
        </div>
        {{--        @if($_POST["ajoute"])--}}
        {{--            <div>Votre Livre à été ajouter au panier</div>--}}
        {{--        @endif--}}
        <div class="titre_fiche">
            <p class="span_1"></p>
            <h1 class="h1 h1_fiche">
                {{$livre->titre}}
            </h1>
        </div>

        <div class="contenu">
            <p class="span_1"></p>
            <div class="couverture span_4"><img src="{{$livre->url}}" alt=""></div>
            <ul class="fiche span_6">
                <li class="auteurs"><span class="gras">Par :</span>
                    <ul>
                        @foreach($tAuteurs as $auteurs)
                            <li>
                                <p class="auteur">{{$auteurs->prenom}} {{$auteurs->nom}}</p>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li><span class="gras">Nombre de page :</span> {{$livre->nbre_pages}} pages</li>
                <li><span class="gras">Année de parution :</span> {{$livre->annee_publication}}  </li>
                <li><span class="gras">Description : </span>{{$livre->description}} </li>
                @if($livre->autres_caracteristiques != "")
                    <li><span class="gras">Autre caractèristique : </span> {{$livre->autres_caracteristiques}} </li>

                @endif
                @if($livre->id_collection != "")
                    <li class="gras">Collection : {{$tCollection->nom}} </li>

                @endif
                <li><span class="gras">Maison d'édition :</span> {{$tEditeur->nom}} </li>
                <li><span class="gras">Parution :</span> {{$livre->getParution()->etat}} </li>
                <li><span class="gras"> ISBN :</span> {{$livre->isbn}} </li>
                @if(strpos($livre->prix, ".") == false)
                    <li><span class="gras"> Prix :</span> {{$livre->prix}}.00$</li>
                @else
                    <li><span class="gras"> Prix : </span>{{$livre->prix}}$</li>
                @endif

                <div class="retour"><a href="index.php?controleur=livre&action=index&page=1">Continuer à magasiner</a>
                </div>
                <form action="index.php?controleur=panier&action=ajouterItem&isbn={{$livre->isbn}}" method="post">
                    <input type="hidden" value="{{$livre->isbn}}">
                    {{--            <input type="hidden" value="ajoute">--}}

                    <h3>Acheter ce livre:</h3>
                    {{$livre->titre}}
                    @foreach($tAuteurs as $auteurs)
                        <li>{{$auteurs->prenom}} {{$auteurs->nom}}</li>
                    @endforeach
                    <label for="quantite">Quantité :</label>
                    <select name="quantite" id="quantite">
                        @for($cpt = 1; $cpt<=10; $cpt ++)
                            <option value="{{$cpt}}">{{$cpt}}</option>
                        @endfor
                    </select>
                    <button class="bt_liens" type="submit">Ajouter au panier</button>
                </form>
            </ul>
        </div>

    </div>

    <div class="commentaires">
        <div class="flex">
            <div class="h2_fiche">
                <h2 class="h2">Commentaires</h2>
            </div>
        </div>


        <div class="monCommentaire centerThis">
            <img src="" alt="">
            <input type="text">
            <button class="bt_liens">Envoyer</button>
        </div>
        <div class="unCommentaire centerThis">
            <img src="" alt="">
            <p class="commentaire_nom">Davis Botosh</p>
            <p class="texteCommentaire">Ce livre à complètement changer mon point de vue.</p>
        </div>
        <div class="unCommentaire centerThis">
            <img src="" alt="">
            <p class="commentaire_nom">Savannah Lane</p>
            <p class="texteCommentaire">Mon point de vue en deux mot?<br><br><br>
                Juste WOW!!</p>
        </div>
        <div class="unCommentaire centerThis">
            <img src="" alt="">
            <p class="commentaire_nom">Robert Fox</p>
            <p class="texteCommentaire">Ce livre n’était pas vraiment bien aligné avec mes intérets.</p>
        </div>
    </div>

@endsection
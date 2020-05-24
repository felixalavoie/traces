
    <div class="conteneur">
        <h1 class="h1">Votre panier</h1>
        {{--    {{$panier}}--}}
        @if($panier == null)
            <p>Votre panier est vide.</p>
            <p>Consultez notre <a href="index.php?controleur=livre&action=index&page=1">catalogue</a>.</p>

        @else

            @foreach($panier->getItems () as $Item)

                <div class="unItemPanier">
                    <ul class="panier">
                        <li class="panier_titre"> {{$Item->livre->titre}}</li>
                        @foreach($Item->livre->getAuteur($Item->livre->id) as $auteurs)
                            <li>
                                {{$auteurs->prenom}} {{$auteurs->nom}}
                            </li>
                        @endforeach
                        @if(strpos($Item->livre->prix, ".") == false)
                            <li> Prix : {{$Item->livre->prix}}.00 $</li>
                        @else
                            <li> Prix : {{$Item->livre->prix}} $</li>
                        @endif


                        <li>
                            <form action="index.php?controleur=panier&action=MAJ" method="post">
                                <input type="hidden" name="isbn" id="isbn" value="{{$Item->livre->isbn}}">
                                <input type="number" min="1" max="10" name="quantite" id="quantite" class="quantite"
                                       value="{{$Item->quantite}}">

                                <button type="submit">Recalculer total</button>
                            </form>
                        </li>

                        <li>total: {{number_format($Item->livre->prix * $Item->quantite)}} $</li>
                        {{--            retirer du panier--}}
                        <li>
                            <form action="index.php?controleur=panier&action=supprimerItem" method="post">
                                <input type="hidden" name="isbn" id="isbn" value="{{$Item->livre->isbn}}">
                                <input type="submit" value="retirer du panier">
                            </form>
                        </li>

                    </ul>
                </div>
            @endforeach
            <ul>
                @if($_GET["action"] != "supprimerItem")
                    <li id="soustotal">Sous-total: {{$panier->getMontantSousTotal()}} $</li>
                    <li id="frais">Frais de livrason : {{$panier->getMontantFraisLivraison()}} $</li>
                    <li id="tps">Taxes: {{$panier->getMontantTPS()}} $</li>
                    <li id="totalfinal">Total: {{$panier->getMontantTotal()}} $</li>
                @endif

            </ul>
            @if($_GET["action"] == "supprimerItem")
                <p>Votre panier est vide.</p>
                <p>Consultez notre <a href="index.php?controleur=livre&action=index&page=1">catalogue</a>.</p>
            @endif


        @endif

    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="liaisons/js/ajaxPanier.js"></script>
@extends('gabarit')

@section('contenu')
    {{--    // Fichier : ressources/vues/livres/index.blade.php--}}
    <div class="conteneur">
        <div class="divAriane">
            <span class="divAriane__fil"><?php echo html_entity_decode($filAriane) ?></span>
        </div>

        <form class="filtre" action="" method="POST" novalidate>
            <div class="filtre_categories colonneGauche clearfix">
                <h3 class="h3 titreCategorie">Categories</h3>
                <ul class="conteneurCategories">
                    @foreach($categories as $categorie)
    {{--                    <a href="index.php?controleur=livre&action=index&categorie={{ $categorie->id }}"--}}
    {{--                       class="@if ($_GET['categorie'] == $categorie->nom_fr) categorieActive @endif">--}}
    {{--                        {{ $categorie->nom_fr }}--}}
    {{--                    </a><br/>--}}
                                        <li class="uneCategorie">
                                            <input class="checkboxCategories"
                                                   @if(array_search($categorie->id, $tFiltrage['categories']) !== false)
                                                           checked
                                                   @endif
                                                   type="checkbox"
                                                   name="categories[]"
                                                   id="categorie_{{ $categorie->id }}"
                                                   value="{{ $categorie->id }}">
                                            <label class="categorieLabel" for="categorie_{{ $categorie->id }}">
                                                {{ $categorie->nom_fr }}
                                            </label>
                                        </li>
                    @endforeach
                        <li>
                            <input class="checkboxCategories visuallyhidden"
                                   aria-hidden="true"
                                   checked
                                   type="checkbox"
                                   name="categories[]"
                                   id="endChecker"
                                   value="empty">
                            <label for="endChecker" class="visuallyhidden" aria-hidden="true">
                                ignore this, its for things
                            </label>
                        </li>
                </ul>
            </div>

            <div class="colonneDroite">
                <div class="filtre_livresParPage">
                    <label for="filtre_livresParPage--label">Résultats par parge </label>
                    <select name="livresParPage" class="filtre_livresParPage--select select" id="livresParPage">
                        <option value="12" class="filtre_livresParPage--option" @if($tFiltrage['livresParPage'] == '12') selected @endif>12</option>
                        <option value="24" class="filtre_livresParPage--option" @if($tFiltrage['livresParPage'] == '24') selected @endif>24</option>
                        <option value="48" class="filtre_livresParPage--option" @if($tFiltrage['livresParPage'] == '48') selected @endif>48</option>
                        <option value="96" class="filtre_livresParPage--option" @if($tFiltrage['livresParPage'] == '96') selected @endif>96</option>
                    </select>
                </div>

                <div class="filtre_triage">
                    <label for="triage">Trier par </label>
                    <select name="triage" class="filtre_triage--select" id="triage">
                        <option value="titreAsc" class="filtre_triage--option" @if($tFiltrage['triage'] == 'titreAsc') selected @endif>A-Z</option>
                        <option value="titreDesc" class="filtre_triage--option" @if($tFiltrage['triage'] == 'titreDesc') selected @endif>Z-A</option>
                        <option value="prixAsc" class="filtre_triage--option" @if($tFiltrage['triage'] == 'prixAsc') selected @endif>$-$$$</option>
                        <option value="prixDesc" class="filtre_triage--option" @if($tFiltrage['triage'] == 'prixDesc') selected @endif>$$$-$</option>
                    </select>
                </div>

                <div class="bt_liens_button div_btAppliquer">
                    <button type="submit" value="Appliquer" name="btnAppliquer" class="btn btnAppliquer clearfix">Appliquer</button>
                </div>

{{--                <input type="submit" value="Appliquer" name="btnAppliquer" class="btn btnAppliquer">--}}
            </div>

        </form>

        <div class="catalogue colonneDroite">
            <div class="pagination paginationHaut">
                @include('fragments.pagination')
            </div>

            <ul class="conteneurFlex">
                @foreach($livres as $livre)
                    <li class="itemFlex">
                        <a href="index.php?controleur=livre&action=fiche&isbn={{ $livre->isbn }}">
                            <div class="itemflex_couverture">
                                <img class="itemFlex_couverture-image centerThis" src="{{ $livre->url }}">
                            </div>
                            <span class="itemFlex_titre">
                                {{ $livre -> titre }}
                            </span>
                            <span class="itemFlex_prix">
                                {{ $livre-> prix }}$
                            </span>
                        </a>
                    </li> @endforeach
            </ul>

            <div class="pagination paginationBas">
                @include('fragments.pagination')
            </div>
        </div>
    </div>
    <script>
        let title = $('.titreCategorie');
        let ul = $('.conteneurCategories');
        let arrli = $('.uneCategorie');

        arrli.addClass('uneCategorieJS');
        ul.addClass('listeJS');

        title.on('click', function () {
            arrli.toggleClass('uneCategorieJS');
            ul.toggleClass('openUl');
            title.toggleClass('openTitle')
        });
    </script>

@endsection
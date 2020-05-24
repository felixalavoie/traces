<div class="recherche">
    <form action="" class="recherche">
        <label for="" class="recherche__label recherche__label--select screen-reader-only">
            Recherché par:
        </label>
        <select name="" id="" class="recherche__select">
            <option value="auteur">Auteur</option>
            <option value="titre">Titre</option>
            <option value="categorie">Categorie</option>
            <option value="motsclef">Mots clef</option>
        </select>
        <label for="champRecherche" class="recherche__label recherche__label--text screen-reader-only">
            Recherché selon:
        </label>

        <input type="text" name="champRecherche" id="champRecherche" class="recherche__input recherche__input--texte">
        <div class="recherche__suggestions" style="max-height: 150px; overflow: scroll;">
            {{--  Se rempli par Ajax --}}
        </div>
        <input type="submit" name="btnRecherche" value="Chercher" class="btnRecherche">
    </form>
    <script type="text/javascript" src="liaisons/js/rechercheAJAX.js"></script>
</div>
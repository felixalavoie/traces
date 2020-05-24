// Félix-Antoine Lavoie - mandat B
console.log('dans ajax');
$('#champRecherche').on('keyup', executerAjax);
function showResultats(data, textStatus, jqXHR) {
    console.log(data);
    $('.recherche__suggestions').html(data);
}
function executerAjax() {
    var value = $('.recherche__input--texte').val();
    $.ajax({
        url: 'index.php?controleur=site&action=recherche',
        data: { 'value': value },
        type: 'GET'
    })
        .done(function (data, textStatus, jqXHR) {
        showResultats(data, textStatus, jqXHR);
    });
}
//# sourceMappingURL=rechercheAJAX.js.map
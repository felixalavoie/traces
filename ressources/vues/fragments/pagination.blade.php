  <!-- Si on est pas sur la première page et s'il y a plus d'une page -->
    @if ($numeroPage > 0)
        <a href= "{!! $urlPagination . "&page=" . 0  !!}" class="pagination_icon pagination_gauche pagination_double pagination_active"></a>
    @else
        <span style="color:#999" class="pagination_icon pagination_gauche pagination_double pagination_inactive"></span> <!-- Bouton premier inactif -->
    @endif

    &nbsp;&nbsp;

    @if ($numeroPage > 0)
        <a href="{!! $urlPagination . "&page=" . (htmlspecialchars($numeroPage) - 1) !!}" class="pagination_icon pagination pagination_gauche pagination_single pagination_active"></a>
    @else
        <span style="color:#999" class="pagination_icon pagination_gauche pagination_single pagination_inactive"></span><!-- Bouton précédent inactif -->
    @endif

    &nbsp;&nbsp;

    <!-- Statut de progression: page 9 de 99 -->
    {{"Page " . ($numeroPage + 1) . " de " . ($nombreTotalPages + 1)}}

    &nbsp;&nbsp;

    <!-- Si on est pas sur la dernière page et s'il y a plus d'une page -->
    @if ($numeroPage < $nombreTotalPages)
        <a href="{!! $urlPagination . "&page=" . (htmlspecialchars($numeroPage) + 1)  !!}" class="pagination_icon pagination pagination_droite pagination_single pagination_active"></a>
    @else
        <span style="color:#999" class="pagination_icon pagination_droite pagination_single pagination_inactive"></span><!-- Bouton suivant inactif -->
    @endif

    &nbsp;&nbsp;

    @if ($numeroPage < $nombreTotalPages)
        <a href="{!! $urlPagination . "&page=" . htmlspecialchars($nombreTotalPages) !!}" class="pagination_icon pagination pagination_droite pagination_double pagination_active"></a>
    @else
        <span style="color:#999" class="pagination_icon pagination pagination_droite pagination_double pagination_inactive"></span><!-- Bouton dernier inactif -->
    @endif




<!DOCTTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="liaisons/css/styles.css">
        <title>Trace - Librarie de Soup Gang</title>
    </head>
    <body class="no_margin">
        <script src="../node_modules/jquery/dist/jquery.min.js"></script>
        <header >
            @include('fragments.entete')
        </header>

        <main>
            @yield('contenu')
        </main>

        <footer>
            @include('fragments.pieddepage')
        </footer>
    </body>
</html>





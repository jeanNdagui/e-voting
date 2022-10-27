<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/public/css/style.css">
    <title>Application de vote en ligne</title>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="/tp-vote/">Home</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php if($_SERVER["REDIRECT_URL"] === "/tp-vote/result"): ?> active <?php endif ?> " href="/tp-vote/result">Résultat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($_SERVER["REDIRECT_URL"] === "/tp-vote/voter_list"): ?> active <?php endif ?>" href="/tp-vote/voter_list">Électeurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($_SERVER["REDIRECT_URL"] === "/tp-vote/candidate_list"): ?> active <?php endif ?>" href="/tp-vote/candidate_list">Candidats</a>
                    </li>
                </ul>
                <div class="navbar-nav ml-auto">

                    <?php if ($session->has("voter_statut")) : ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if($_SERVER["REDIRECT_URL"] === "/tp-vote/cast"): ?> active <?php endif ?> " href="/tp-vote/cast">voter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($_SERVER["REDIRECT_URL"] === "/tp-vote/profil"): ?> active <?php endif ?>" href="/tp-vote/profil">profil</a>
                        </li>
                    <?php endif  ?>

                    <?php if ($session->has("admin_statut") || $session->has("voter_statut")) : ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if($_SERVER["REDIRECT_URL"] === "/tp-vote/deconnection"): ?> active <?php endif ?>" href="/tp-vote/deconnection">se déconnecter</a>
                        </li>
                    <?php else : ?>

                        <li class="nav-item">
                            <a class="nav-link <?php if($_SERVER["REDIRECT_URL"] === "/tp-vote/create_user"): ?> active <?php endif ?>" href="/tp-vote/create_user">S'enregistrer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($_SERVER["REDIRECT_URL"] === "/tp-vote/login"): ?> active <?php endif ?>" href="/tp-vote/login">se connecter</a>
                        </li>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </nav>

       <?= $content ?>
    <footer class="mt-5">
        <p class="text-center">TP-SÉCURITÉ INFORMATIQUE GROUPE 14</p>
    </footer>
    <script src="src/public/js/bootstrap.min.js"></script>
    <!-- <script src="src/public/js/custom.js"></script> -->

</body>

</html>
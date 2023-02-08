<?php 
require_once 'config.php';
require_once 'Connexion.php';

$pageName = "Résultat de la partie";
$title = "Résultat de la partie";

$ratioFrame = $_SESSION["nb-tries"] / $_SESSION["nb-tries-max"] * 10;
$ratioFrame = round($ratioFrame, 0, PHP_ROUND_HALF_DOWN);

if(!isset($_SESSION["J1"]) || !isset($_SESSION["J2"]) || !isset($_SESSION["mot"])) {
    header("Location: index.php");
}

require_once 'header.php' ?>
    <div class="container">
        <h1>Le mot était : <?= $_SESSION["mot"] ?></h1>
        <div class="container container-half">
            <div class="col-sm">
                <?php
                if($_GET['winner'] == "J1") {
                    echo "
                        <h2>Joueur 1 : " . $_SESSION["J1"] . "</h2>
                        <div class=\"alert alert-success\" role=\"alert\">
                            Vous avez gagné ! Le joueur 2 n'a pas trouvé le mot.
                        </div>
                        <h2>Joueur 2 : " . $_SESSION["J2"] . "</h2>
                        <div class=\"alert alert-danger\" role=\"alert\">
                            Vous avez perdu ! Vous avez dépassé le nombre de coups autorisés.
                        </div>
                    ";
                } else {
                    echo "
                        <h2>Joueur 1 : " . $_SESSION["J1"] . "</h2>
                        <div class=\"alert alert-danger\" role=\"alert\">
                            Vous avez perdu ! Le joueur 2 a trouvé le mot.
                        </div>
                        <h2>Joueur 2 : " . $_SESSION["J2"] . "</h2>
                        <div class=\"alert alert-success\" role=\"alert\">
                            Vous avez gagné ! Vous avez réussi à trouver le mot en " . $_SESSION["nb-tries"] . " coups.
                        </div>
                    ";
                }

                $connexion = Connexion::getInstance()->getBdd();
                $query = $connexion->prepare("INSERT INTO partie (nom_joueur1, nom_joueur2, mot, victoire, nb_coup) VALUES (:joueur1, :joueur2, :mot, :victoire, :nb_coup)");    
                $query->execute([
                    "joueur1" => $_SESSION["J1"],
                    "joueur2" => $_SESSION["J2"],
                    "mot" => $_SESSION["mot"],
                    "victoire" => $_GET['winner'] == "J1" ? 1 : 2,
                    "nb_coup" => $_SESSION["nb-tries"]
                ]);

                session_destroy();
                ?>

                <a href="index.php" class="btn btn-primary">Retourner à l'accueil</a>
            </div>
            <div class="col-sm">
                <img src="img/frame<?= $ratioFrame ?>.png" alt="pendu" width="50%">
            </div>
        </div>
    </div>
<?php require_once 'footer.php' ?>
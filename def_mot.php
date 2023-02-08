<?php 
require_once 'config.php';
require_once 'Connexion.php';

if(isset($_POST['action']) && $_POST['action'] == 'initPlayer') {
    $_SESSION["J1"] = $_POST['nom_joueur1'];
    $_SESSION["J2"] = $_POST['nom_joueur2'];
} else if(isset($_POST['action']) && $_POST['action'] == 'initWord') {
    $word = strtolower($_POST['mot']);
    $connexion = Connexion::getInstance()->getBdd();
    $query = $connexion->prepare('SELECT * FROM lexique WHERE ortho = :word');
    $query->execute(['word' => $word]);
    $result = $query->fetch();

    if($result) {
        $_SESSION["mot"] = $word;
        $_SESSION["nb_coups"] = $_POST['nb_coups'];
        $_SESSION["mot_j2"] = str_repeat("_", strlen($_POST['mot']));
        $_SESSION["mot"] = $_POST['mot'];
        $_SESSION["nb-tries"] = 0;
        $_SESSION["nb-tries-max"] = $_POST['nb_coups'];
        $_SESSION["already-tried"] = "";
        header('Location: jeu.php');
    } else {
        echo '<div class="alert alert-danger" role="alert">
                Le mot n\'existe pas dans le dictionnaire
            </div>';
    }
}

$pageName = "Choix du mot";
$title = "Choix du mot";

require_once 'header.php' ?>
    <div class="container">
        <form action="def_mot.php" method="POST">
            <h1>Définition du mot</h1>
            <div class="row">
                <h2>Joueur 1 : <?= $_SESSION["J1"] ?></h2>
            </div>
            <div class="form-group">
                <label for="mot_joueur1">Choisissez un mot</label>
                <input type="text" class="form-control" id="mot" name="mot" placeholder="Entrez le mot à faire deviner">
            </div>
            <div class="form-group">
                <label for="nb_coups">Choisissez le nombre de coups</label>
                <input type="number" class="form-control" id="nb_coups" name="nb_coups" placeholder="Entrez le nombre de coups">
            </div>
            <div class="row btn-container">
                <a href="joueurs.php" class="btn btn-danger">Retour</a>
                <input type="hidden" name="action" value="initWord">
                <button type="submit" class="btn btn-primary">Jouer</button>
            </div>
        </form>
        
    </div>
<?php require_once 'footer.php' ?>
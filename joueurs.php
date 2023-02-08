<?php 
require_once 'config.php';

$pageName = "Définition des joueurs";
$title = "Définition des joueurs";

require_once 'header.php' ?>
    <div class="container">
        <form action="def_mot.php" method="POST">
            <div class="form-group">
                <label for="nom_joueur1">Nom du joueur 1</label>
                <input type="text" class="form-control" id="nom_joueur1" name="nom_joueur1" placeholder="Entrez le nom du J1">
            </div>
            <div class="form-group">
                <label for="nom_joueur2">Nom du joueur 2</label>
                <input type="text" class="form-control" id="nom_joueur2" name="nom_joueur2" placeholder="Entrez le nom du J2">
            </div>
                
            <div class="row btn-container">
                <a href="index.php" class="btn btn-danger">Retour</a>
                <input type="hidden" name="action" value="initPlayer">
                <button type="submit" class="btn btn-primary">Choix du mot</button>
            </div>
        </form>
    </div>
<?php require_once 'footer.php' ?>
<?php 
require_once 'config.php';
require_once 'Connexion.php';

$pageName = "Parties jouées";
$title = "Parties jouées";

require_once 'header.php' ?>

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Identifiant</th>
                    <th scope="col">Joueur 1</th>
                    <th scope="col">Joueur 2</th>
                    <th scope="col">Mot</th>
                    <th scope="col">Victoire</th>
                    <th scope="col">Nombre de coups</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Use the $connexion variable to query the database
                    $connexion = Connexion::getInstance()->getBdd();
                    $query = $connexion->query('SELECT * FROM partie');
                        
                    foreach($query as $row) {
                        $winner = $row['victoire'] == 1 ? $row['nom_joueur1'] : $row['nom_joueur2'];
                        $color = $row['victoire'] == 1 ? "danger" : "success";
                        echo '<tr class="table-' . $color . '">';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['nom_joueur1'] . '</td>';
                        echo '<td>' . $row['nom_joueur2'] . '</td>';
                        echo '<td>' . $row['mot'] . '</td>';
                        echo '<td>' . $winner . '</td>';
                        echo '<td>' . $row['nb_coup'] . '</td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
        <br>
        <a href="joueurs.php" class="btn btn-primary">Lancer une nouvelle partie</a>
    </div>
<?php require_once 'footer.php' ?>
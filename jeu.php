<?php require_once 'config.php';

if (isset($_POST['action']) && $_POST['action'] == 'try') {

    $letter = $_POST['letter-choice'];
    $mot = $_SESSION["mot"];

    if(strpos($_SESSION["already-tried"], strtolower($letter)) !== false) {
        $alert = "<div class=\"alert alert-info\" role=\"alert\">
                    La lettre '$letter' a déjà été essayée, essayez-en une autre.
                </div>";
    } else {
        $_SESSION["already-tried"] .= strtolower($letter);

        $found = false;
        for ($i = 0; $i < strlen($mot); $i++) {
            if (strtolower($mot[$i]) == strtolower($letter)) {
                $found = true;
                $_SESSION["mot_j2"][$i] = $mot[$i];
            }
        }
        if (!$found) {
            $_SESSION["nb-tries"]++;
            echo "<div class=\"alert alert-danger\" role=\"alert\">
                        La lettre $letter n'est pas dans le mot
                    </div>";
        } else {
            echo "<div class=\"alert alert-success\" role=\"alert\">
                        La lettre $letter est dans le mot
                    </div>";
        }
    
        if($_SESSION["nb-tries"] > $_SESSION["nb-tries-max"]-1) {
            header("Location: final.php?winner=J1");
            exit;
        } else if ($_SESSION["mot_j2"] == $_SESSION["mot"]) {
            header("Location: final.php?winner=J2");
            exit;
        }
    }
}

$ratioFrame = $_SESSION["nb-tries"] / $_SESSION["nb-tries-max"] * 10;
$ratioFrame = round($ratioFrame, 0, PHP_ROUND_HALF_DOWN);

$pageName = "Recherche du mot";
$title = "Recherche du mot";

require_once 'header.php' ?>
    <div class="container container-half">
        <form method="POST">
            <div class="col-sm">
                <div class="row">
                    <h2>Joueur 2 : <?= $_SESSION["J2"] ?></h2>
                </div>
                <div class="form-group">
                    <h2>Mot à deviner :</h2>
                    <div class="row letters-container">
                        <?php for ($i = 0; $i < strlen($_SESSION["mot"]); $i++) { ?>
                            <div class="col-1">
                                <h3><?= $_SESSION["mot_j2"][$i] ?></h3>
                            </div>
                        <?php } ?>
                    </div>

                </div>

                <div class="form-group">
                    <h2>Lettres déjà essayées :</h2>
                    <div class="row letters-container">
                        <?php for ($i = 0; $i < strlen($_SESSION["already-tried"]); $i++) { ?>
                            <div class="col-1">
                                <h3><?= $_SESSION["already-tried"][$i] ?></h3>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="row">
                    <h3>Nombre d'essais : <?= $_SESSION["nb-tries"] . "/" . $_SESSION["nb-tries-max"] ?></h3>
                </div>

                <div class="form-group">
                    <label for="mot_joueur2">Proposez une lettre</label>
                    <input type="text" class="form-control" id="letter_j2" name="letter-choice" style="text-transform: uppercase; font-size: 2em; text-align: center; max-width: 60px;">
                </div>


                <div class="row btn-container">
                    <a href="index.php" class="btn btn-danger">Retour</a>
                    <input type="hidden" name="action" value="try">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </form>
        </div>
        <div class="col-sm"  id="img-container">
            <img src="img/frame<?= $ratioFrame ?>.png" alt="pendu" width="50%">
        </div>
        
    </div>
<?php require_once 'footer.php' ?>

<script>
    // Allow only one char in letter_j2. If more than one, only the last one is kept
    $("#letter_j2").on("input", function() {
        var input = $(this);
        var last = input.val().substr(input.val().length - 1);
        input.val(last);
    });
</script>
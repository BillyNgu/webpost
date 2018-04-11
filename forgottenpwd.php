<?php
/*
 * Auteur : Nguyen Billy
 * Date : 2018-01-31
 * Titre : Forum
 * Description : Forum PHP
 */
require_once './dao/dao.php';

$message = GetFlashMessage();

if (isset($_POST['remember'])) {
    $Nickname = trim(filter_input(INPUT_POST, 'Nickname', FILTER_SANITIZE_STRING));
    $Email = filter_input(INPUT_POST, 'Email', FILTER_VALIDATE_EMAIL);
    $Phone = filter_input(INPUT_POST, 'Phone', FILTER_SANITIZE_NUMBER_INT);

    if ((!empty($Nickname) && !empty($Email)) || (!empty($Nickname) && !empty($Phone))) {
        CreateUser($FirstName, $LastName, strtolower($Nickname), $Email, $Pwd, $Date);
        SetFlashMessage("Mot de passe réinitialisé.");
        header("location:index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Webpost</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <script src="js/jquery-1.11.0.min.js"></script>
        <script src="js/jquery-migrate-1.2.1.min.js"></script>
    </head>
    <body>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Webpost</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Index<span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Inscription</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <form action="index.php" method="post">
                <h3>Mot de passe oublié </h3>
                <p>Veuillez entrer votre identifiant et votre email</p>
                <div class="form-group">
                    <?php if (!empty($message)) : ?>
                        <p><?= $message ?></p>
                    <?php endif; ?>
                    <label for="exampleInputNickname">Identifiant :</label>
                    <input type="text" name="Nickname" class="form-control col-3" id="exampleInputNickname" placeholder="Pseudo">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail">Email :</label>
                    <input type="email" name="Email" class="form-control col-3" id="exampleInputEmail" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPhone">Numéro de téléphone :</label>
                    <input type="tel" name="Phone" class="form-control col-3" id="exampleInputPhone" placeholder="Phone">
                </div>
                <button class="btn btn-primary" href="index.php">Retour</button>
                <button type="submit" name="remember" class="btn btn-primary">Réinitialiser</button>
            </form>
        </div>
        <script type="text/javascript" src="js/bootstrap.js"></script>
    </body>
</html>

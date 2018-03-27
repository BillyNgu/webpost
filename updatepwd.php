<?php
require_once './dao/dao.php';


if (isset($_POST['validchangepwd'])) {
    $nickname = $_SESSION['Nickname'];



    $passwordatm = filter_input(INPUT_POST, 'pwdatm', FILTER_SANITIZE_STRING);

    $passwordatm = sha1("$passwordatm" . getSaltFromUser($nickname));

    $newpassword = filter_input(INPUT_POST, 'newpwd', FILTER_SANITIZE_STRING);
    $newpasswordrepeat = filter_input(INPUT_POST, 'confirmnewpwd', FILTER_SANITIZE_STRING);

    $errors = [];

    if (empty($passwordatm)) {
        $errors['pwdatm'] = 'Le actuel n\'est pas correct.';
    }
    if ($newpassword !== $newpasswordrepeat) {
        $errors['confirmnewpwd'] = 'Les mots de passe ne sont pas identiques.';
    }
    if (empty($errors)) {
        updatePassword($nickname, $passwordatm, $newpassword);
        SetFlashMessage("Mot de passe modifié.");
        header("location:login.php");
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
                        <li class="nav-item">
                            <a class="navbar-brand">Bienvenue <?= $_SESSION['Nickname'] ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="post.php">Poster</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Mon profil</a>
                            <div class="dropdown-menu dropdown" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="login.php">Accueil profil</a>
                                <a class="dropdown-item" href="updatepwd.php">Changer le mot de passe</a>
                                <a class="dropdown-item" href="logout.php">Se déconnecter</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <form action="updatepwd.php" method="post">
                <div class="form-group">
                    <label for="change_password_atm">Mot de passe actuel :</label>
                    <input required="" type="password" name="pwdatm" class="form-control col-3" id="change_password_atm">
                </div>
                <div class="form-group">
                    <label for="change_password_new">Nouveau mot de passe :</label>
                    <input required="" type="password" name="newpwd" class="form-control col-3" id="change_password_new">
                    
                    <label for="change_password_new_confirm">Confirmation nouveau mot de passe :</label>
                    <input required="" type="password" name="confirmnewpwd" class="form-control col-3" id="change_password_new_confirm">
                </div>
                <a class="btn btn-primary" href="login.php">Retour</a>
                <input class="btn btn-primary" type="submit" value="Confirmer" name="validchangepwd" />
            </form>
        </div>
        <script type="text/javascript" src="js/bootstrap.js"></script>
    </body>
</html>
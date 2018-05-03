<?php
/*
 * Auteur : Nguyen Billy
 * Date : 2018-01-31
 * Titre : Forum
 * Description : Forum PHP
 */
require_once './dao/dao.php';

if (isset($_POST['register'])) {
    $FirstName = trim(filter_input(INPUT_POST, 'FirstName', FILTER_SANITIZE_STRING));
    $LastName = trim(filter_input(INPUT_POST, 'LastName', FILTER_SANITIZE_STRING));
    $Nickname = trim(filter_input(INPUT_POST, 'Nickname', FILTER_SANITIZE_STRING));
    $Email = trim(filter_input(INPUT_POST, 'Email', FILTER_VALIDATE_EMAIL));
// pas de filtre, parce que hashage prochainement
    $Pwd = filter_input(INPUT_POST, 'Password');
    $PwdRepeat = filter_input(INPUT_POST, 'PasswordConfirmation');
    $Date = date("Y-m-d H:i:s");

    $errors = [];

    if (empty($FirstName)) {
        $errors['FirstName'] = 'Le prénom ne peut pas être vide.';
    }
    if (empty($LastName)) {
        $errors['LastName'] = 'Le nom ne peut pas être vide.';
    }
    if (empty($Nickname)) {
        $errors['Nickname'] = 'Le pseudo ne peut pas être vide.';
    }
    if (empty($Email)) {
        $errors['Email'] = 'L\'email ne peut pas être vide.';
    }
    if (empty($Pwd)) {
        $errors['Password'] = 'Le mot de passe ne peut pas être vide.';
    }
    if (empty($PwdRepeat)) {
        $errors['PasswordConfirmation'] = 'La confirmation du mot de passe ne peut pas être vide.';
    }

    if ($Pwd !== $PwdRepeat) {
        $errors['PasswordConfirmation'] = 'Les mots de passe ne sont pas identiques.';
    }
    if (empty($errors)) {
        CreateUser($FirstName, $LastName, strtolower($Nickname), $Email, $Pwd, $Date);
        SetFlashMessage("Utilisateur ajouté.");
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
                <a class="navbar-brand">Webpost</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Index<span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link">Inscription</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <form action="register.php" method="post">
                <h3>Inscription</h3>
                <div class="form-group">
                    <label for="firstname_login">Prénom :</label>
                    <input type="text" name="FirstName" class="form-control col-3" id="firstname_login" value="<?php
                    if (!empty($FirstName)) {
                        echo $FirstName;
                    }
                    ?>">
                           <?php
                           if (!empty($errors['FirstName'])) {
                               echo $errors['FirstName'];
                           }
                           ?>
                </div>
                <div class="form-group">
                    <label for="lastname_login">Nom :</label>
                    <input type="text" name="LastName" class="form-control col-3" id="lastname_login" value="<?php
                    if (!empty($LastName)) {
                        echo $LastName;
                    }
                    ?>">
                           <?php
                           if (!empty($errors['LastName'])) {
                               echo $errors['LastName'];
                           }
                           ?>
                </div>
                <div class="form-group">
                    <label for="nickname_login">Pseudo :</label>
                    <input type="text" name="Nickname" class="form-control col-3" id="nickname_login" value="<?php
                    if (!empty($Nickname)) {
                        echo $Nickname;
                    }
                    ?>">
                           <?php
                           if (!empty($errors['Nickname'])) {
                               echo $errors['Nickname'];
                           }
                           ?>
                </div>
                <div class="form-group">
                    <label for="email_login">Email :</label>
                    <input type="email" name="Email" class="form-control col-3" id="email_login" value="<?php
                    if (!empty($Email)) {
                        echo $Email;
                    }
                    ?>">
                           <?php
                           if (!empty($errors['Email'])) {
                               echo $errors['Email'];
                           }
                           ?>
                </div>
                <div class="form-group">
                    <label for="password_login">Mot de passe :</label>
                    <input type="password" name="Password" class="form-control col-3" id="password_login">
                    <?php
                    if (!empty($errors['Password'])) {
                        echo $errors['Password'];
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="passwordconfirmation_login">Confirmer mot de passe :</label>
                    <input type="password" name="PasswordConfirmation" class="form-control col-3" id="passwordconfirmation_login">
                    <?php
                    if (!empty($errors['PasswordConfirmation'])) {
                        echo $errors['PasswordConfirmation'];
                    }
                    ?>
                </div>
                <input class="btn btn-primary" name="register" type="submit">
                <a class="btn btn-primary" href="index.php">Retour</a>
            </form>
        </div>
        <script type="text/javascript" src="js/bootstrap.js"></script>
    </body>
</html>

<?php
/*
 * Auteur : Nguyen Billy
 * Date : 2018-01-31
 * Titre : Forum
 * Description : Forum PHP
 */
require_once './dao/flashmessage.php';
require_once './dao/dao.php';

//session_start();
$posts = getAllPosts();
$message = GetFlashMessage();

if (isset($_POST['connection'])) {
    $Nickname = trim(filter_input(INPUT_POST, 'Nickname', FILTER_SANITIZE_STRING));
    $Pwd = filter_input(INPUT_POST, 'Password', FILTER_SANITIZE_STRING);

    CheckLogin(strtolower($Nickname), $Pwd);
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
                        <li class="nav-item active">
                            <a class="nav-link">Index<span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Inscription</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="row">
                <div class="col">
                    <form action="index.php" method="post">
                        <div class="form-group">
                            <?php if (!empty($message)) : ?>
                                <p><?= $message ?></p>
                            <?php endif; ?>
                            <label for="exampleInputNickname">Identifiant :</label>
                            <input type="text" name="Nickname" class="form-control col-5" id="exampleInputNickname" placeholder="Entrez votre pseudo">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mot de passe :</label>
                            <input type="password" name="Password" class="form-control col-5" id="exampleInputPassword1" placeholder="Entrez votre mot de passe">
                            <a href="forgottenpwd.php">Mot de passe oublié ?</a>
                        </div>
                        <button type="submit" name="connection" class="btn btn-primary">Se connecter</button>
                    </form>
                </div>
                <div class="col">
                    <section>
                        <?php
                        if (!empty($posts)):
                            foreach ($posts as $key => $value):
                                $hours = date('H:i', strtotime($value['datePost']));
                                $date = date('d-m-Y', strtotime($value['datePost']));
                                $nickname = getUserNicknameFromId($value['idUser']);
                                $file = getNameMediaInPostByIdPost($value['idComment']);
                                ?>
                                <article>
                                    <div class="card-deck" style="width: 20rem;">
                                        <?php if (!empty($file)): ?>
                                            <div class="card mt-3">
                                                <?php
                                                $extension = substr($file, -3);
                                                switch ($extension):
                                                    case 'png':
                                                        ?>
                                                        <img class = "card-img-top" alt = "" src = "./uploaded_files/<?= $file; ?>">
                                                        <?php
                                                        break;
                                                    case 'jpg':
                                                        ?>
                                                        <img class = "card-img-top" alt = "" src = "./uploaded_files/<?= $file; ?>">
                                                        <?php
                                                        break;
                                                    case 'peg':
                                                        ?>
                                                        <img class = "card-img-top" alt = "" src = "./uploaded_files/<?= $file; ?>">
                                                        <?php
                                                        break;
                                                    case 'mp3':
                                                        ?>
                                                        <audio class = "card-img-top" controls="">
                                                            <source src="./uploaded_files/<?= $file; ?>" type="audio/mpeg">
                                                        </audio>
                                                        <?php
                                                        break;
                                                    case 'mp4':
                                                        ?>
                                                        <video class = "card-img-top" autoplay="" loop="" controls="">
                                                            <source src="./uploaded_files/<?= $file; ?>" type="video/mp4">
                                                        </video>
                                                        <?php break;
                                                    case 'gif':
                                                        ?>
                                                        <img class = "card-img-top" alt = "" src = "./uploaded_files/<?= $file; ?>">
                                                    <?php
                                                    default:
                                                        break;
                                                endswitch;
                                                ?>
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= $value['titleComment'] ?></h5>
                                                    <p class="card-text"><?= $value['commentary'] ?></p>
                                                    <p class="card-subtitle">
                                                        <small class="text-muted">
                                                            Posté le <?= $date; ?> à <?= $hours; ?> par <?= $nickname; ?>
                                                        </small>
                                                    </p>
                                                </div>
                                            </div>
        <?php else: ?>
                                            <div class="card mt-3">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= $value['titleComment'] ?></h5>
                                                    <p class="card-text"><?= $value['commentary'] ?></p>
                                                    <p class="card-subtitle">
                                                        <small class="text-muted">
                                                            Posté le <?= $date; ?> à <?= $hours; ?> par <?= $nickname; ?>
                                                        </small>
                                                    </p>
                                                </div>
                                            </div>
        <?php endif; ?>
                                    </div>
                                </article>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </section>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="js/bootstrap.js"></script>
    </body>
</html>

<?php
require_once './dao/flashmessage.php';
require_once './dao/dao.php';

$idComment = filter_input(INPUT_GET, 'idComment', FILTER_VALIDATE_INT);
$posts = getPost($idComment);

if (isset($_POST['modify']) && !empty($_POST['title'])) {
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
    
    modifyComment($title, $comment, $idComment);
    header('location:login.php');
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
                <a class="navbar-brand" href="login.php">Webpost</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="navbar-brand">Bienvenue <?= $_SESSION['Nickname'] ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="post.php">Poster</a>
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
            <div class="col">
                <form action="modifyPost.php?idComment=<?= $idComment?>" class="form center-block" method="post" enctype="multipart/form-data">
                    <?php foreach ($posts as $key => $value): ?>
                        <div class="form-group">
                            <h3><label for="post_title">Titre :</label></h3>
                            <input id="post_title" autofocus="" class="form-control col-3" value="<?php
                            if (!empty($posts)) {
                                echo $value['titleComment'];
                            }
                            ?>" type="text" name="title" placeholder="Entrez un titre">
                        </div>
                        <div class="form-group">
                            <h3><label for="post_commentary">Commentaire :</label></h3>
                            <textarea id="post_commentary" name="comment" class="form-control input-lg col-4" autofocus="" placeholder="Que voulez-vous partager ?"><?php
                                if (!empty($posts)) {
                                    echo $value['commentary'];
                                }
                                ?></textarea>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Modifier" name="modify">
                        <a class="btn btn-primary" href="login.php">Annuler</a>
                    <?php endforeach; ?>
                </form>
            </div>
        </div>
        <script type="text/javascript" src="js/bootstrap.js"></script>
    </body>
</html>

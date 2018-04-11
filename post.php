<?php
/*
 * Auteur : Nguyen Billy
 * Date : 2018-01-31
 * Titre : Forum
 * Description : Forum PHP
 */
require_once './dao/flashmessage.php';
require_once './dao/dao.php';

// Check if image file is a actual image or fake image
if (isset($_POST['post']) && !empty($_POST['title'])) {
    $uploadOk = 1;
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
    $nickname = $_SESSION['Nickname'];
    $idUser = getUserIdFromNickname($nickname);

// Check if an image is ready to upload
    if (!empty($_FILES['fileup'])) {
        for ($index = 0; $index < count($_FILES['fileup']['name']); $index++) {
            $target_dir = "./uploaded_files/";
            $target_file = $target_dir . basename($_FILES["fileup"]["name"][$index]);
            $FileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Allow certain file formats
            if ($FileType != "jpg" && $FileType != "png" && $FileType != "jpeg" && $FileType != "gif" &&
                    $FileType != "mp3" && $FileType != "mp4" && $FileType != "avi") {
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            // Add a comment without images

            if ($uploadOk == 0) {
                addComment($title, $comment, $idUser);
                header('location:login.php');
//                echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                addComment($title, $comment, $idUser);

                $fileType = $_FILES["fileup"]["type"][$index];
                $fileName = $_FILES["fileup"]["name"][$index];
                $tmpName = $_FILES["fileup"]["tmp_name"][$index];

                addMedia($fileType, $fileName, $tmpName);

                header('location:login.php');
            }
        }
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
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mon profil</a>
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
                <form action="post.php" class="form center-block" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <h3><label for="post_title">Titre :</label></h3>
                        <input id="post_title" autofocus="" class="form-control col-3" value="<?php
                        if (!empty($title)) {
                            echo $title;
                        }
                        ?>" type="text" name="title" placeholder="Entrez un titre">
                    </div>
                    <div class="form-group">
                        <h3><label for="post_commentary">Commentaire :</label></h3>
                        <textarea id="post_commentary" name="comment" class="form-control input-lg col-4" autofocus="" placeholder="Que voulez-vous partager ?"></textarea>
                    </div>
                    <ul class="pull-left list-inline">
                        <li>
                            <div class="custom-file col-5">
                                <input name="fileup[]" type="file" id="customFile" multiple accept="image/*,audio/*,video/*">
                                <label for="customFile">Choisissez un fichier</label>
                            </div>
                        </li>
                    </ul>
                    <input class="btn btn-primary" type="submit" value="Poster" name="post">
                    <a class="btn btn-primary" href="login.php">Annuler</a>
                </form>
            </div>
        </div>
        <script type="text/javascript" src="js/bootstrap.js"></script>
    </body>
</html>

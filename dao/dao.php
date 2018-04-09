<?php

require_once './dao/dbUtilFunction.php';
require_once './dao/flashmessage.php';

function CreateUser($FirstName, $LastName, $Nickname, $Email, $Pwd, $Date) {
    $sql = "INSERT INTO `users`(`firstname`, `lastname`, `nickname`, `email`, `password`, `salt`)" .
            "SELECT :FirstName, :LastName, :Nickname, :Email, :Password, SHA1(NOW())";
    $query = myPdo()->prepare($sql);
    $query->execute(array(
        'FirstName' => $FirstName,
        'LastName' => $LastName,
        'Nickname' => strtolower($Nickname),
        'Email' => strtolower($Email),
        'Password' => sha1("$Pwd" . sha1("$Date"))
    ));
}

function CheckLogin($Nickname, $Pwd) {
    $salt = getSaltFromUser($Nickname);

    $query = myPdo()->prepare("SELECT nickname, password "
            . "FROM users "
            . "WHERE nickname = :Nickname "
            . "AND password = :Password ");
    $Pwd = sha1("$Pwd" . "$salt");

    $query->bindParam(':Nickname', $Nickname, PDO::PARAM_STR);
    $query->bindParam(':Password', $Pwd, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($Nickname === $user['nickname'] && $Pwd === $user['password']) {
        $_SESSION['Nickname'] = $Nickname;
//        $_SESSION['idUser'] = $idUser;

        header('Location:login.php');
    } else {
        $_SESSION['Nickname'] = "";
    }
}

function updatePassword($Nickname, $oldpwd, $newpwd) {
    $salt = getSaltFromUser($Nickname);

    $sql = "UPDATE `users` SET `password` = :pwd WHERE `nickname` = :Nickname";
    $query = myPdo()->prepare($sql);
    $query->bindParam(':Nickname', $Nickname, PDO::PARAM_STR);
    $newpwd = sha1("$newpwd" . "$salt");
    $query->bindParam(":pwd", $newpwd, PDO::PARAM_STR);
    $query->execute();
}

function getSaltFromUser($Nickname) {
    $sql = "SELECT `salt` from users WHERE `nickname` = :Nickname";
    $query = myPdo()->prepare($sql);
    $query->bindParam(':Nickname', $Nickname, PDO::PARAM_STR);
    $query->execute();
    return $query->fetch()[0];
}

function getPwdFromUser($nickname) {
    $sql = "SELECT `password` from `users` WHERE `nickname` = :Nickname";
    $query = myPdo()->prepare($sql);
    $query->bindParam(':Nickname', $nickname, PDO::PARAM_STR);
    $query->execute();
    return $query->fetch()[0];
}

function getUserIdFromNickname($nickname) {
    $sql = "SELECT `idUser` FROM `users` WHERE `nickname` = :nickname";
    $query = myPdo()->prepare($sql);
    $query->bindParam(':nickname', $nickname, PDO::PARAM_STR);
    $query->execute();
    return $query->fetch()[0];
}

function getUserNicknameFromId($id) {
    $sql = "SELECT `nickname` FROM `users` WHERE `idUser` = :id";
    $query = myPdo()->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->execute();
    return $query->fetch()[0];
}

function addComment($title, $comment, $idUser) {
    $sql = "INSERT INTO `comment`(`titleComment`, `commentary`, `idUser`) VALUES (:title, :comment, :id)";
    $query = myPdo()->prepare($sql);
    $query->bindParam(':title', $title, PDO::PARAM_STR);
    $query->bindParam(':comment', $comment, PDO::PARAM_STR);
    $query->bindParam(':id', $idUser, PDO::PARAM_INT);
    $query->execute();
}

function modifyComment($title, $comment, $idComment) {
    $sql = "UPDATE `comment` SET `titleComment`= :title , `commentary`= :comment WHERE `idComment` = :idComment";
    $query = myPdo()->prepare($sql);
    $query->bindParam(':title', $title, PDO::PARAM_STR);
    $query->bindParam(':comment', $comment, PDO::PARAM_STR);
    $query->bindParam(':idComment', $idComment, PDO::PARAM_INT);
    $query->execute();
}

function addMedia($typeMedia, $nameMedia, $tmpName) {
    $lastRecordId = getLastRecordIDFromComment();
    $target_dir = "./uploaded_files/";
    $target_file = $target_dir . $lastRecordId . '-' . basename($nameMedia);

    $sql = "INSERT INTO `media`(`typeMedia`, `nameMedia`, `idComment`) VALUES (:fileup, :nameMedia, :idComment)";
    $query = myPdo()->prepare($sql);
    $query->bindParam(':fileup', $typeMedia, PDO::PARAM_STR);
    $nameMedia = $lastRecordId . '-' . $nameMedia;
    $query->bindParam(':nameMedia', $nameMedia, PDO::PARAM_STR);
    $query->bindParam(':idComment', $lastRecordId, PDO::PARAM_INT);
    $query->execute();

    move_uploaded_file($tmpName, $target_file);
}

function addMediaWithId($typeMedia, $nameMedia, $tmpName, $idComment) {

    $target_dir = "./uploaded_files/";
    $target_file = $target_dir . $idComment . '-' . basename($nameMedia);

    $sql = "INSERT INTO `media`(`typeMedia`, `nameMedia`, `idComment`) VALUES (:fileup, :nameMedia, :idComment)";
    $query = myPdo()->prepare($sql);
    $query->bindParam(':fileup', $typeMedia, PDO::PARAM_STR);
    $nameMedia = $idComment . '-' . $nameMedia;
    $query->bindParam(':nameMedia', $nameMedia, PDO::PARAM_STR);
    $query->bindParam(':idComment', $idComment, PDO::PARAM_INT);
    $query->execute();

    move_uploaded_file($tmpName, $target_file);
}

function modifyMedia($typeMedia, $nameMedia, $tmpName, $idComment) {
    deleteMedia($idComment, getNameMediaInPostByIdPost($idComment));

    $sql = "UPDATE `media` SET `typeMedia`=:typeMedia,`nameMedia`=:nameMedia WHERE `idComment`= :idComment";
    $query = myPdo()->prepare($sql);
    $query->bindParam(':typeMedia', $typeMedia, PDO::PARAM_STR);

    $target_dir = "./uploaded_files/";
    $target_file = $target_dir . $idComment . '-' . basename($nameMedia);
    $nameMedia = $idComment . '-' . $nameMedia;

    $query->bindParam(':nameMedia', $nameMedia, PDO::PARAM_STR);
    $query->bindParam(':idComment', $idComment, PDO::PARAM_INT);

    $query->execute();
    move_uploaded_file($tmpName, $target_file);
}

function getIdMediaFromIdPost($idComment) {
    $sql = "SELECT `idMedia`, `typeMedia`, `nameMedia`, `idComment` FROM `media` WHERE `idComment` = :idComment";
    $query = myPdo()->prepare($sql);
    $query->bindParam(':idComment', $idComment, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function deletePost($id, $mediaName) {
    $target_dir = "./uploaded_files/";
    $target_file = $target_dir . $mediaName;

    $sql = "DELETE FROM `comment` WHERE `idComment` = :id";
    $query = myPdo()->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();

    if (!empty($mediaName)) {
        $sql2 = "DELETE FROM `media` WHERE `idComment` = :id";
        $query2 = myPdo()->prepare($sql2);
        $query2->bindParam(':id', $id, PDO::PARAM_INT);
        $query2->execute();

        opendir($target_dir);
        unlink($target_file);
        closedir($target_dir);
    }
}

function deleteMedia($idComment, $mediaName) {
    $target_dir = "./uploaded_files/";
    $target_file = $target_dir . $mediaName;

    $sql = "DELETE FROM `media` WHERE `idComment` = :idComment";
    $query = myPdo()->prepare($sql);
    $query->bindParam(':idComment', $idComment, PDO::PARAM_INT);
    $query->execute();

    opendir($target_dir);
    unlink($target_file);
    closedir($target_dir);
}

function getPost($id) {
    $sql = "SELECT `titleComment`,`commentary` FROM `comment` WHERE `idComment` = :id";
    $query = myPdo()->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getAllPosts() {
    $sql = "SELECT * FROM `comment` ORDER BY `datePost` DESC";
    $query = myPdo()->prepare($sql);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getAllPostsByIDUser($id) {
    $sql = "SELECT * FROM `comment` WHERE `idUser` = :id ORDER BY `datePost` ASC";
    $query = myPdo()->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getNameMediaInPostByIdPost($id) {
    $sql = "SELECT `nameMedia` FROM `media` WHERE `idComment` = :id";
    $query = myPdo()->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch()[0];
}

function getLastRecordIDFromComment() {
    $sql = "SELECT `idComment` FROM `comment` WHERE `idComment` = (SELECT MAX(`idComment`) FROM `comment`)";
    $query = myPdo()->prepare($sql);
    $query->execute();
    return $query->fetch()[0];
}

function SendReinitMessage($Email, $URL) {
    
}

function SendReinitSMS($SMS, $URL) {
    
}

function startPwdReinitialisation($Nickname) {
    $csvValue = [];
//    $testcsv = array("test","test2");
    $key = generateRandomString($length = 10);
    $sql = "INSERT INTO `reinitkey`(`keyValue`, `ExpirationDate`) VALUES (:Key, DATEADD(minute, 2, GETDATE()))";
    $query = myPdo()->prepare($sql);
    $query->bindParam(":Key", $key, PDO::PARAM_STR);
    $query->execute();
    $handle = fopen("message_email.csv", "a");
    fputcsv($handle, $csvValue);
}

function checkKey($key) {
    
}

function checkKeyWithNickname($Nickname, $key) {
    
}

function updatePwdWithKey($Nickname, $key, $newPwd) {
    
}

function generateRandomString($length) {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

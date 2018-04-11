<?php
/*
 * Auteur : Nguyen Billy
 * Date : 2018-01-31
 * Titre : Forum
 * Description : Forum PHP
 */
require_once './dao/dao.php';

$id = filter_input(INPUT_GET, 'idComment', FILTER_VALIDATE_INT);
$nameMediaPost = getNameMediaInPostByIdPost($id);

if (!empty($nameMediaPost)) {
    deletePost($id, $nameMediaPost);
} else {
    deletePost($id, NULL);
}

header("Location:login.php");

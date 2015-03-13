<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.03.2015
 * Time: 12:59
 */
include '../classes/Db.php';
include '../includes/config.php';
//echo DB_HOST.'<br>'.DB_LOGIN.'<br>'.DB_PASSWORD.'<br>'.DB_NAME.'<br>';
Db::connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);

if (!empty($_POST)){
//    echo '<pre>';
//    print_r($_POST);
//    echo '</pre><br>';
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $type = $_POST['type'];

    $query = "INSERT INTO `users`(`type`, `login`, `email`, `tel`) VALUES ('{$type}','{$login}', '{$email}', null)";
//    echo $query.'<br>';
    Db::query($query) or die(mysql_error());
    $id = Db::getInsertId();
//    echo $id.'<br>';
    $query = "INSERT INTO `authorization`(`id_user`, `pswd`) VALUES ($id, '{$password}')";
    Db::query($query) or die(mysql_error());
}
include '../views/vReg.php';
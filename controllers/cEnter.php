<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.03.2015
 * Time: 13:49
 */
include '../classes/Db.php';
include '../includes/config.php';
//echo DB_HOST.'<br>'.DB_LOGIN.'<br>'.DB_PASSWORD.'<br>'.DB_NAME.'<br>';
Db::connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);

if (!empty($_POST)){
    $login = $_POST['login'];
    $password = md5($_POST['password']);
    $query = "SELECT `pswd` FROM `authorization` as `a`
              LEFT JOIN `users` as `u` ON `a`.`id_user` = `u`.`id`
              WHERE `u`.`login` = '{$login}'";
//    echo $query.'<br>';
    $res = Db::getValue($query);
//    echo $res.'<br>';
    if ($password == $res){
        header("Location: /index.php");
    }
}


include "../views/vEnter.php";
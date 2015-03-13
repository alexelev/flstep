<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.03.2015
 * Time: 13:49
 */
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>FL-STEP</title>
        <link rel="stylesheet" href="../assets/css/reset.css">
        <link rel="stylesheet" href="../assets/css/main.css">
    </head>
    <body>
        <div class="main_menu">
            <a class="logo" href="../index.php"><img src="../assets/img/logo.png" alt=""></a>
        </div>
        <div class="form">
            <span>Не зарегистрированы?</span> <a href="../controllers/cReg.php">Регистрация</a>
            <form action="../controllers/cEnter.php" method="post" class="tableReg">
                <div class="table-row">
                    <label for="login">Логин</label>
                    <input type="text" name="login" required/>
                </div>
                <div class="table-row">
                    <label for="pass">Пароль</label>
                    <input type="password" name="password" required/>
                </div>
                <input type="submit" value="ВОЙТИ"/>
            </form>
        </div>
    </body>
</html>
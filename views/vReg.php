<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.03.2015
 * Time: 12:58
 */

//echo 'vReg is here!';
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
            <span>Уже зарегистрированы?</span> <a href="../controllers/cEnter.php">Войдите</a>
            <form action="../controllers/cReg.php" method="post" class="tableReg">
                <div class="table-row">
                    <label for="login">Логин</label>
                    <input type="text" name="login" required/>
                </div>
                <div class="table-row">
                    <label for="email">Email</label>
                    <input type="text" name="email" required/>
                </div>
                <div class="table-row">
                    <label for="pass">Пароль</label>
                    <input type="password" name="password" required/>
                </div>
                <div class="table-row">
                    <input type="radio" name="type" value="dev"/>
                    <label for="type">Я - разработчик</label>
                </div>
                <div class="table-row">
                    <input type="radio" name="type" value="cus"/>
                    <label for="type">Я - заказчик</label>
                </div>
                <input type="submit" value="ЗАРЕГИСТРИРОВАТЬСЯ"/>
            </form>
        </div>
    </body>
</html>
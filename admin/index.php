<?php
//require "../includes/config.php";
//require "../media/libs/rb.php";
require "db_admin.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Панель администратора</title>

</head>
<body>

<?php
if (isset($_SESSION['logged_user'])) : ?>
<strong>Авторизован!<br>
Привет, <?php echo $_SESSION['logged_user']->login ?>
<hr></strong>
<a href="logout.php">Выйти</a>
<br>
<?php else : ?>
    <strong>Вы не авторизированы! </strong>
<hr>
<a href="login.php">Авторизироваться</a><br>
<a href="signup.php">Регистрация</a>
<?php endif; ?>

</body>

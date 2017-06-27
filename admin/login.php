<?php
/**
 * Created by PhpStorm.
 * User: User.2012.12
 * Date: 26.06.2017
 * Time: 23:01
 */
require "db_admin.php";

$data = $_POST;

if (isset($data['do_login'])) {
    $errors = array();
    $user = R::findOne('users', 'login = ?', array($data['login']));

    if($user) {
        //логин существует, проверка пароля
        if (password_verify($data['password'], $user->password)){
            // Все хорошо, логиним и запоминаем пользователя
            $_SESSION['logged_user'] = $user;
            echo '<span style="color: green; font-weight: bold; margin-bottom: 10px; display: block;">Вы авторизованы! <a href="index.php">Перейти на главную страницу</a></span>';

        } else {
            $errors[] = 'Неправильно введен пароль!';
        }
    } else {
        $errors[] = 'Пользователь с таким логином не найден!';
    }
    if (! empty($errors)){ //вывод ошибок
        echo '<span style="color: red; font-weight: bold; margin-bottom: 10px; display: block;">' . array_shift($errors) . '</span>';

    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Панель администратора</title>

</head>
<body>

<h2>Авторизация пользователя</h2>

<form action="login.php" name="form_login" method="POST">
    <p>
    <p><strong>Логин</strong>: </p>
    <input type="text" name="login" value="<?php echo @$data['login']; ?>">
    </p>

    <p>
    <p><strong>Ваш пароль</strong>: </p>
    <input type="password" name="password" value="<?php echo @$data['password']; ?>">
    </p>

    <p>
        <button type="submit" name="do_login">Войти</button>
    </p>



</form>

</body>


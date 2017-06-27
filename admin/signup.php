<?php
/**
 * Created by PhpStorm.
 * User: User.2012.12
 * Date: 26.06.2017
 * Time: 23:01
 * Используется подгружаемая библиотека RedBeanPHP и ООП
 */
require "db_admin.php";

$data = $_POST;

if (isset($data['do_signup'])){
    //проверка заполнения формы
    $errors = array();
    if (trim($data['login'])==''){
        $errors[] = 'Введите логин!';
    }
    if (trim($data['email'])==''){
        $errors[] = 'Введите Email!';
    }
    if ($data['password']==''){
        $errors[] = 'Введите пароль!';
    }
    if ($data['password_2'] != $data['password']){
        $errors[] = 'Повторный пароль введен неверно!';
    }

    //Проверка существования пользователя в БД с введенными login и Email
    if (R::count('users', "login = ?", array($data['login'])) > 0){
        $errors[] = 'Пользователь с таким login уже существует!';
    }
    if (R::count('users', "email = ?", array($data['email'])) > 0){
        $errors[] = 'Пользователь с таким Email уже существует!';
    }


    //процесс регистрации
    if (empty($errors)){ //массив ошибок пуст - можно регистрировать
        $user = R::dispense('users');
        $user->login = $data['login'];
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        R::store($user);
        echo '<span style="color: green; font-weight: bold; margin-bottom: 10px; display: block;">Вы успешно зарегистрированы!</span>';


    } else {  //вывод ошибки
        echo '<span style="color: red; font-weight: bold; margin-bottom: 10px; display: block;">' . array_shift($errors) . '</span>';
    //array_shift($errors) - выбор первого элемента массива
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

<h2>Регистрация пользователя</h2>

<form action="signup.php" method="POST">
    <p>
    <p><strong>Ваш логин</strong>: </p>
    <input type="text" name="login" value="<?php echo @$data['login']; ?>">
    </p>

    <p>
    <p><strong>Ваш Email</strong>: </p>
    <input type="email" name="email" value="<?php echo @$data['email']; ?>">
    </p>

    <p>
    <p><strong>Ваш пароль</strong>: </p>
    <input type="password" name="password" value="<?php echo @$data['password']; ?>">
    </p>

    <p>
    <p><strong>Введите Ваш пароль еще раз</strong>: </p>
    <input type="password" name="password_2" value="<?php echo @$data['password_2']; ?>">
    </p>

    <p>
    <button type="submit" name="do_signup">Зарегистрироваться</button>
    </p>



</form>

</body>

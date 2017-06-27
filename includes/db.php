<?php

//$connection = mysqli_connect('127.0.0.1', 'root', '', 'test_db');
$connection = mysqli_connect(
    $config['db']['server'],
    $config['db']['username'],
    $config['db']['password'],
    $config['db']['name']
);
//Сервер, Имя пользователя, пароль, название БД

mysqli_set_charset($connection, "utf8"); //установка кодировки

if($connection == false)
{
	echo 'Не удалось подключиться к БД!<br>';
	echo mysqli_connect_error();
	exit();  //Скрипт завершиться в этой точке
} 


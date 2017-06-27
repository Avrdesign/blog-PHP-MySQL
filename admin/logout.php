<?php
/**
 * Created by PhpStorm.
 * User: User.2012.12
 * Date: 27.06.2017
 * Time: 15:56
 */

require "db_admin.php";

unset($_SESSION['logged_user']); //Очистка ячейки массива $_SESSION - Выход пользователя

header('location: index.php');


?>


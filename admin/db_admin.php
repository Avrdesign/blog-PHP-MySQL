<?php
/**
 * Created by PhpStorm.
 * User: User.2012.12
 * Date: 26.06.2017
 * Time: 23:06
 */
require "../media/libs/rb.php";

R::setup( 'mysql:host=localhost;dbname=test_db',
    'root', '' ); //rb.php - for both mysql or mariaDB

session_start(); //для запоминания пользователя


<?php
//Настройки сайта
$config = array(
  'title' => 'Блог Тест PHP Хауди Хо',
   'fb_url' => 'https://www.facebook.com/avrametsdesign/',
   'db' => array(
       'server' => 'localhost', // или можно 127.0.0.1
       'username' => 'root',
       'password' => '',
       'name' => 'test_db'
   )
);

require 'db.php';
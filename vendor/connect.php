<?php
// Ссылка на сайт
$site_url = "http://cybersibsiu/";

// Подключение к БД: 'host', 'user', 'password', 'database'
$connect = mysqli_connect('localhost', 'root', '', 'cybersibsiu_local');

if (!$connect){
    die('Error connect to DataBase');
}
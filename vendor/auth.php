<?php
session_start();
require_once 'connect.php';

$login = $_POST['login'];
$password = md5($_POST['password']);

$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE (('$login' = `nickname`) OR ('$login' = `mail`)) AND ('$password' = `password`)");
if (mysqli_num_rows($check_user) > 0){
    $user = mysqli_fetch_assoc($check_user);
    $_SESSION['user'] = [
        "id" => $user['ID_user'],
        "nickname" => $user['nickname'],
        "vk" => $user['vk'],
        "steam" => $user['steam'],
        "telephone" => $user['telephone'],
        "mail" => $user['mail']
    ];
    header('Location: /');
} else {
    $_SESSION['message'] = 'Неверный логин или пароль';
    header('Location: ../login-register.php');
}
?>
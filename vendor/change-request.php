<?php
session_start();
require_once 'connect.php';

//Данные с формы изменения информации о пользователе
$nickname = $_POST['nickname'];
$vk = $_POST['vk'];
$steam = $_POST['steam'];
$telephone = $_POST['telephone'];
$mail = $_POST['mail'];
$password = md5($_POST['password']);
$password_confirm = md5($_POST['password-confirm']);

//Данные этого же пользователя из сессии
$user_id = $_SESSION['user']['id'];

if ($password === $password_confirm){
    $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE (('$user_id' = `ID_user`) AND ('$password' = `password`))");
    if (mysqli_num_rows($check_user) > 0) {
        //Отправляем запрос
        mysqli_query($connect, "UPDATE `users` SET `nickname`='$nickname', `vk` = '$vk', `steam` = '$steam', `telephone` = '$telephone', `mail`='$mail', `password`='$password' WHERE `ID_user`='$user_id'");
        $_SESSION['message'] = 'Данные успешно изменены';
        header('Location: ../user-profile-settings.php');
    } else {
        $_SESSION['message'] = 'Ошибка. Пользователь не найден';
        header('Location: ../user-profile-settings.php');
    };
} else {
    $_SESSION['message'] = 'Ошибка. Введённые пароли не совпадают';
    header('Location: ../user-profile-settings.php');
}

?>
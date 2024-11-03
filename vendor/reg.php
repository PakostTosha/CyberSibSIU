<?php
session_start();
require_once 'connect.php';

$username = htmlspecialchars(trim($_POST['username']));
$vk = htmlspecialchars(trim($_POST['vk']));
$steam = htmlspecialchars(trim($_POST['steam']));
$mail = htmlspecialchars(trim($_POST['email']));
$tel = htmlspecialchars(trim($_POST['telephone']));
$password = htmlspecialchars(trim($_POST['password']));
$password_confirm = htmlspecialchars(trim($_POST['password-confirm']));

// Правила полей регистрации
try {
    // Ник не повторяется
    if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `users` WHERE `nickname` = '$username'")) > 0) {
        throw new Exception('Такой никнейм уже существует');
    }
    // Почта не повторяется
    if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `users` WHERE `mail` = '$mail'")) > 0) {
        throw new Exception('Такая почта уже зарегистрирована');
    }
    // Логин 4-20 латинских символов $username
    if (strlen($username) < 4 || strlen($username) > 20 || (!preg_match('/^[A-Za-z0-9]+$/', $username))) {
        throw new Exception('Логин должен быть из 4-20 латинских символов без пробелов');
    }
    // Телефон $tel
    if (!(preg_match('/^(?:\+|\d)[\d\-\(\) ]{9,}\d/', $tel))) {
        throw new Exception('Телефон состоит из набора 11 цифр, начинающегося с 8');
    }
    // Пароли совпадают $password, $password_confirm
    if ($password === $password_confirm) {
        $password = md5($password);
        if (mysqli_query($connect, "INSERT INTO `users`(`ID_user`, `nickname`, `vk`, `steam`, `telephone`, `mail`, `password`, `pass_key`) VALUES (NULL,'$username','$vk','$steam','$tel','$mail','$password', NULL)")) {
            $_SESSION['message'] = 'Регистрация прошла успешна. Пожалуйста, авторизируйтесь';
            header('Location: ../login-register.php');
            exit();
        } else {
            throw new Exception ('Ошибка отправки запроса: '.strval(mysqli_errno()));
        }
    } else {
        throw new Exception('Не удалось зарегистрироваться. Пароли не совпадают');
    }
} catch (Exception $e) {
    $_SESSION['message'] = $e->getMessage();
    header('Location: ../login-register.php');
}


?>
<!-- Если сессия авторизована - выводить "Мой профиль", если не авторизована - "Войти" -->
<?php
session_start();
require('vendor/connect.php');

$profile_text_link = 'Войти';

//Проверка: авторизовался ли пользователь
if (isset($_SESSION['user'])) {
    $isAuth = true;
} else {
    $isAuth = false;
}

//Если авторизовался ($isAuth = true), то выводить данные в шапке и менять адресацию ссылок
if ($isAuth) {
    $profile_text_link = $_SESSION['user']['nickname'];

    //Есть ли уведомления и сколько
    $count_notice = 0;
    $id = $_SESSION['user']['id'];
    $check_notice = mysqli_query($connect, "SELECT * FROM `notices` WHERE `ID_user` = '$id'");
    if (mysqli_num_rows($check_notice) > 0) {
        $count_notice = mysqli_num_rows($check_notice);
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,regular,500,600,700,900&display=swap"
        rel="stylesheet" />
    <!-- Шапка -->
    <link rel="stylesheet" href="/css/header.css">

    <!-- Заявка участия в турнире -->
    <link rel="stylesheet" href="/css/request-join.css">

    <!-- Главная страница -->
    <link rel="stylesheet" href="/css/main.css">

    <!-- О турнире -->
    <link rel="stylesheet" href="/css/tournament.css">

    <!-- Новости -->
    <link rel="stylesheet" href="/css/news.css">

    <!-- Игры-учатсники -->
    <link rel="stylesheet" href="/css/games.css">

    <!-- Логин/регистрация -->
    <!-- Стили подключены в "login-register.php" из-за конфликтов стилей на странице "user-profile.php" -->

    <!-- Мой профиль -->
    <link rel="stylesheet" href="../css/user-profile.css">

    <!-- Уведомления -->
    <link rel="stylesheet" href="../css/notices.css">

    <!-- Забыли/изменить пароль -->
    <link rel="stylesheet" href="css/forgot-change-pass.css">

    <!-- Попап -->
    <link rel="stylesheet" href="../css/popup.css">



    <!-- Заголовок страницы -->
    <title>
        <?= $page_title ?>
    </title>
</head>

<body>
    <div class="wrapper">
        <header class="header container">
            <div class="header__container ">
                <div class="logo__img">
                    <a href="/index.php"><img src="../src/img/header/logo-div.svg" alt=""></a>
                </div>
                <nav class="header__menu menu">
                    <ul class="menu__list">
                        <li class="menu__item">
                            <a href="/tournament.php" class="menu__link">
                                <img src="../src/img/header/about.svg" alt="О турнире" class="menu__icon" width="20px">
                                <div class="menu__text">О турнире</div>
                            </a>
                        </li>
                        <li class="menu__item">
                            <a href="/news.php" class="menu__link">
                                <img src="../src/img/header/news.svg" alt="Новости" class="menu__icon" width="25px">
                                <div class="menu__text">Новости</div>
                            </a>
                        </li>
                        <li class="menu__item">
                            <a href="/games.php" class="menu__link">
                                <img src="../src/img/header/games.svg" alt="Игры" class="menu__icon" width="35px">
                                <div class="menu__text">Игры-участники</div>
                            </a>
                        </li>
                        <li class="menu__item">

                            <?php if ($isAuth): ?>
                                <a href="../user-profile-settings.php" class="menu__link user-page">
                                <?php else: ?>
                                    <a href="../login-register.php" class="menu__link user-page">
                                    <?php endif; ?>

                                    <img src="../src/img/header/user.svg" alt="Пользователь" class="menu__icon"
                                        width="30px">
                                    <div class="menu__text">
                                        <?= $profile_text_link ?>
                                    </div>
                                </a>
                        </li>

                        <?php if ($isAuth): ?>
                            <li class="menu__item notice-link">
                                <a href="../user-profile-notices.php" class="menu__link bell">
                                    <img src="/src/img/header/bell.svg" alt="Уведомления" class="menu__icon" width="35px">

                                        <div class="count">
                                            <?= $count_notice ?>
                                        </div>

                                </a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </nav>
            </div>
        </header>
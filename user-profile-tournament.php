<?php
$page_title = 'Мой профиль';
require('components/header.php');

if(!$isAuth){
    header('Location: login-register.php');
}

// Создать массив данных о пользователе и заполнить его из БД. После этого вставить значения столбцов в инпуты

?>

<main class="page container">
    <!-- Секция окна настроек -->
    <section class="page__settings-window settings">
        <!-- Заголовок окна -->
        <div class="settings__title">
            <h2>Личный кабинет</h2>
        </div>
        <div class="settings__container">
            <!-- Разделы настроек -->
            <ul class="settings__list">
                <a class="settings__link user-settings " href="user-profile-settings.php">
                    <li class="settings__section">Настройки пользователя</li>
                </a>
                <a class="settings__link tournament selected" href="user-profile-tournament.php">
                    <li class="settings__section">Турнир</li>
                </a>
                <a class="settings__link team" href="user-profile-team.php">
                    <li class="settings__section">Команда</li>
                </a>
                <a class="settings__link notice" href="user-profile-notices.php">
                    <li class="settings__section">Уведомления</li>
                </a>
                <a class="btn logout-btn" href="/vendor/logout.php">
                    <li>Выйти из аккаунта</li>
                </a>
            </ul>
            <!-- Опции соответсвующего раздела -->
            <div class="settings__form">
                <!-- Турнир -->
                <div class="form tournament__options selected">
                    <div class="invite-status">
                        <div class="status-title">Статус:</div>
                        <div id="status-value" class="status-value">проводится этап регистрации до 13 февраля
                        </div>
                    </div>
                    <a href="request-join.php" class="request-link btn">Создать команду</a>
                </div>
            </div>
        </div>
    </section>
</main>
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
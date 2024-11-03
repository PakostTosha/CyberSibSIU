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
                <a class="settings__link user-settings selected" href="user-profile-settings.php">
                    <li class="settings__section">Настройки пользователя</li>
                </a>
                <a class="settings__link tournament" href="user-profile-tournament.php">
                    <li class="settings__section">Турнир</li>
                </a>
                <a class="settings__link team" href="user-profile-team.php">
                    <li class="settings__section">Команда</li>
                </a>
                <a class="settings__link notice" href="user-profile-notices.php">
                    <li class="settings__section">Уведомления</li>
                </a>
                <a class="btn logout-btn" href="vendor/logout.php">
                    <li>Выйти из аккаунта</li>
                </a>
            </ul>
            <!-- Опции соответсвующего раздела -->
            <div class="settings__form">

                <!-- Настройки пользователя -->
                <div class="form user-settings__options selected">
                    <h2 class="user-settings__title">Настройки:</h2>
                    <form action="vendor/change-request.php" method="post" class="form-box">
                        <div class="input-box">
                            <input id="nickname" type="text" name="nickname" placeholder="Ник пользователя" required value="<?php echo $_SESSION['user']['nickname'] ?>">
                            <label for="nickname"><ion-icon name="person-outline"></ion-icon></label>
                        </div>
                        <div class="input-box">
                            <input id="vk" type="url" name="vk" placeholder="Ссылка на страницу VK" required value="<?php echo $_SESSION['user']['vk'] ?>">
                            <label for="vk"><ion-icon name="logo-vk"></ion-icon></label>
                        </div>
                        <div class="input-box">
                            <input id="steamID" type="text" name="steam" placeholder="Ссылка на аккаунт Steam" required value="<?php echo $_SESSION['user']['steam'] ?>">
                            <label for="steamID"><ion-icon name="logo-steam"></ion-icon></label>
                        </div>
                        <div class="input-box">
                            <input id="tel" type="tel" name="telephone" placeholder="Телефон: 8XXXXXXXXXX" required value="<?php echo $_SESSION['user']['telephone'] ?>">
                            <label for="tel"><ion-icon name="call-outline"></ion-icon></label>
                        </div>
                        <div class="input-box">
                            <input id="email" type="email" name="mail" placeholder="Электронная почта" required value="<?php echo $_SESSION['user']['mail'] ?>">
                            <label for="email"><ion-icon name="mail-outline"></ion-icon></label>
                        </div>
                        <div class="input-box">
                            <input id="password" type="password" name="password" required placeholder="Введите текущий пароль">
                            <label for="password"><ion-icon name="lock-closed-outline"></ion-icon></label>
                        </div>
                        <div class="input-box">
                            <input id="repeat-password" type="password" name="password-confirm" placeholder="Повторите текущий пароль" required >
                            <label for="repeat-password"><ion-icon name="document-lock-outline"></ion-icon></label>
                        </div>
                        <!-- Блок ошибки -->
                        <button class="btn change-btn" type="submit">Изменить</button>
                    </form>

                    <?php
                    if (isset($_SESSION['message'])) {
                        echo '<p class="msg">' . $_SESSION['message'] . '</p>';
                    }
                    unset($_SESSION['message']);
                    ?>

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
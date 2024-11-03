<?php
$page_title = 'Вход';
require('components/header.php');

if ($isAuth) {
    header('Location: user-profile-settings.php');
}
?>

<link rel="stylesheet" href="../../css/login-register.css">
<main class="page container">
    <div class="wrapper-form">
        <div class="login">
            <div class="upper-line">
                <h2>Вход в профиль</h2>
            </div>
            <div class="form-box">
                <form action="vendor/auth.php" method="post">
                    <div class="input-box">
                        <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                        <input name="login" type="text" required placeholder="Логин">
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                        <input name="password" id="password-input" type="password" required placeholder="Пароль">
                        <span class="password-control" onclick="return show_hide_password(this);"></span>
                    </div>
                    <div class="forgot-password">
                        <a href="forgot-pass.php">Забыли пароль?</a>
                    </div>

                    <?php
                    if (isset($_SESSION['message'])) {
                        echo '<p class="msg">' . $_SESSION['message'] . '</p>';
                    }
                    unset($_SESSION['message']);
                    ?>

                    <div class="buttons">
                        <button class="login-button btn" type="submit">Войти</button>
                        <div class="login-register"><a class="register-link">Ещё нет аккаунта? Регистрация</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="registration">
            <div class="upper-line">
                <h2>Регистрация</h2>
            </div>
            <div class="form-box">
                <form action="vendor/reg.php" method="post" onsubmit="">
                    <div class="input-box">
                        <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                        <input name="username" type="text" required
                            placeholder="Ник пользователя (4-20 латинских букв)">
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="logo-vk"></ion-icon></span>
                        <input name="vk" type="url" required placeholder="Ссылка на страницу VK">
                    </div>

                    <div class="input-box">
                        <span class="icon"><ion-icon name="logo-steam"></ion-icon></span>
                        <input name="steam" type="url" required placeholder="Ссылка на профиль Steam">
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                        <input name="email" type="email" required placeholder="Электронная почта">
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="call-outline"></ion-icon></span>
                        <input name="telephone" type="tel" required placeholder="Номер телефона: 8XXXXXXXXXX">
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                        <input name="password" type="password" required placeholder="Придумайте пароль">
                    </div>

                    <div class="input-box">
                        <span class="icon"><ion-icon name="document-lock-outline"></ion-icon></span>
                        <input name="password-confirm" type="password" required placeholder="Повторите пароль">
                    </div>

                    <!-- Блок ошибки -->
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo '<p class="msg">' . $_SESSION['message'] . '</p>';

                    }
                    unset($_SESSION['message']);
                    ?>
                    
                    <div class="buttons">
                        <button class="login-button btn" type="submit">Зарегистрироваться</button>
                        <div class="login-register"><a class="login-link">Уже есть профиль? Авторизуйтесь</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
</div>

<script src="js/login-register.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
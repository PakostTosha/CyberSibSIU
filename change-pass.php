<?php
$page_title = 'Забыли пароль';
require('components/header.php');

// Если пользователь авторизован или ключа нет
if (isset($_SESSION['user']) || !isset($_GET['key'])) {
    header('Location: /');
} else {
    // Если ключ есть
    $key = $_GET['key'];
    // Находим пользователя по ключу
    $user = mysqli_query($connect, "SELECT * FROM `users` WHERE `pass_key` = '$key'");
    // Если не найден, то на гл.страницу
    if (mysqli_num_rows($user) <= 0) {
        header('Location: /');
    }
}

if (isset($_GET['change'])) {
    // Вытаскиваем пароль
    $new_pass = md5($_GET['pass']);
    // Меняем пароль на введённый, удаляем временный ключ
    mysqli_query($connect, "UPDATE `users` SET `pass_key`= NULL, `password`='$new_pass' WHERE `pass_key` = '$key'");
    $_SESSION['message'] = 'Пароль успешно изменён. Авторизуйтесь';
    header('Location: login-register.php');
}


// 
// НЕОБХОДИМО ИЗМЕНИТЬ ЗАПРОСЫ В ТАБЛИЦУ ЮЗЕР, УКАЗАВ ПОЛЕ КЛЮЧА
// 
?>

<main class="page container">
    <section class="forgot-box">
        <div class="upper-line">
            <h2 class="upper-line__title">Изменить пароль</h2>
        </div>
        <form class="change-form" action="change-pass.php" method="get">
            <input type="password" name="pass" placeholder="Введите новый пароль" required>
            <input type="hidden" name="key" value="<?php echo $_GET['key']; ?>">
            <button class="btn" type="submit" name="change">Изменить пароль</button>
        </form>
    </section>
</main>
</div>
</body>

</html>
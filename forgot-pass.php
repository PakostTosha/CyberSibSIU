<?php
$page_title = 'Забыли пароль';
require('components/header.php');


// 
// НЕОБХОДИМО ИЗМЕНИТЬ ЗАПРОСЫ В ТАБЛИЦУ ЮЗЕР, УКАЗАВ ПОЛЕ КЛЮЧА
// 

if (isset($_POST['forgot'])) {
    // Найдём пользователя по email
    $input_email = trim($_POST['email']);
    $user = mysqli_query($connect, "SELECT * FROM `users` WHERE `mail` = '$input_email'");
    // Пользователь нашёлся или нет
    if (mysqli_num_rows($user) > 0) {
        $user = mysqli_fetch_assoc($user);
        // Генерируем ключ
        $key = md5($user['nickname'].rand(1000,9999));
        // Отправляем ключ в БД к пользователю
        mysqli_query($connect, "UPDATE `users` SET `pass_key`='$key' WHERE `mail` = '$input_email'");

        // Ссылка для перехода
        $url = $site_url.'change-pass.php?key='.$key;
        // Письмо
        $message = 'Уважаемый пользователь '.$user['nickname'].', был выполнен запрос на изменение пароля. \r\n Для изменения перейдите по ссылке: '.$url.'\n \n Если это были не вы, то советуем вам изменить ваш пароль!';
        // Отправка письма на почту пользователя
        mail($input_email, 'Подтвердите действие!', $message);
        $_SESSION['message'] = 'Письмо отправлено на почту';
        header('Location: login-register.php');
        exit();
    } else {
        $_SESSION['forgot-error'] = 'Пользователь не найден';
        header('Location: forgot-pass.php');
        exit();
    }
}
?>

<main class="page container">
    <section class="forgot-box">
        <div class="upper-line">
            <h2 class="upper-line__title">Забыли пароль?</h2>
        </div>
        <form class="forgot-form" action="forgot-pass.php" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <button class="btn" type="submit" name="forgot">Отправить ссылку на почту</button>
            <?php
            if (isset($_SESSION['forgot-error'])) {
                echo '<div class="error">' . $_SESSION['forgot-error'] . '</div>';
            }
            unset($_SESSION['forgot-error']);
            ?>
        </form>
    </section>
</main>
</div>
</body>

</html>
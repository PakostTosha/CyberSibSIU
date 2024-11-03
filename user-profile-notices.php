<?php
$page_title = 'Мой профиль';
require('components/header.php');
require 'vendor/connect.php';

if (!$isAuth) {
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
                <a class="settings__link tournament" href="user-profile-tournament.php">
                    <li class="settings__section">Турнир</li>
                </a>
                <a class="settings__link team" href="user-profile-team.php">
                    <li class="settings__section">Команда</li>
                </a>
                <a class="settings__link notice selected" href="user-profile-notices.php">
                    <li class="settings__section">Уведомления</li>
                </a>
                <a class="btn logout-btn" href="vendor/logout.php">
                    <li>Выйти из аккаунта</li>
                </a>
            </ul>

            <!-- Опции соответсвующего раздела -->
            <div class="settings__form">
                <!-- Уведомления -->
                <div class="form notice__options selected">
                    <div class="notice">
                        <h2 class="notice__title">История уведомлений:</h2>
                        <ul class="notice__list">
                            <?php
                            $id_user = $_SESSION['user']['id'];
                            $check_notices = mysqli_query($connect, "SELECT * FROM `notices` WHERE `ID_user` = '$id_user' ORDER BY `notices`.`ID_notice` DESC");
                            if (mysqli_num_rows($check_notices) > 0) {

                                for ($i = 0; $i < mysqli_num_rows($check_notices); $i++)
                                    $notices[$i] = mysqli_fetch_assoc($check_notices);
                                // $notices ( 
                                //     [ID_notice] => 18 
                                //     [ID_user] => 4 
                                //     [ID_from] => 8 
                                //     [ID_team] => 16 
                                //     [text] => Вам отправлено приглашение на вступление в команду GG от её капитана - gelik. 
                                //                 Вы можете принять приглашение и вступить в команду или отклонить запрос. 
                                //     [title] => Вступление в команду GG!
                                //     [type] => invite )
                            
                                foreach ($notices as $cur_notice): ?>
                                    <!-- Уведомление о приглашении в команду -->
                                    <?php if ($cur_notice['type'] == 'invite'): ?>
                                        <li class="notice__item item notice-invite">
                                            <h3 class="item__title">
                                                <?= $cur_notice['title'] ?>
                                            </h3>
                                            <div class="item__text">
                                                <?= $cur_notice['text'] ?>
                                            </div>
                                            <div class="item__button">
                                                <a href="vendor/team/accept-invite.php?
                                                iduser=<?= $cur_notice['ID_user'] ?>&
                                                idteam=<?= $cur_notice['ID_team'] ?>&
                                                idnotice=<?= $cur_notice['ID_notice'] ?>" class="accept-btn">Принять
                                                    приглашение</a>
                                                <a href="vendor/team/delete-invite.php?
                                                idnotice=<?= $cur_notice['ID_notice'] ?>" class="delete-btn">Отклонить
                                                    приглашение</a>
                                            </div>
                                        </li>
                                        <!-- Уведомление, информирующее об операции -->
                                    <?php elseif ($cur_notice['type'] == 'info'): ?>
                                        <li class="notice__item item notice-info">
                                            <h3 class="item__title">
                                                <?= $cur_notice['title'] ?>
                                            </h3>
                                            <div class="item__text">
                                                <?= $cur_notice['text'] ?>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <!-- Очистить все уведомления -->
                                <a href="vendor/team/clearnotices.php?iduser=<?= $cur_notice['ID_user'] ?>"
                                    class="btn clear-all">Удалить все уведомления и приглашения</a>
                            <?php
                            } else
                                echo '<div>У вас нет уведомлений</div>';
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Попап с информацией о приглашении -->
    <?php if (isset($_SESSION['accept-invite-error']) || isset($_SESSION['accept-invite-succes']) || isset($_SESSION['delete-invite-succes'])) {

        if (isset($_SESSION['accept-invite-error'])) {
            $info_text = $_SESSION['accept-invite-error'];
            require 'components/popup.php';
            unset($_SESSION['accept-invite-error']);

        } else if (isset($_SESSION['accept-invite-succes'])) {
            $info_text = $_SESSION['accept-invite-succes'];
            require 'components/popup.php';
            unset($_SESSION['accept-invite-succes']);

        } else if (isset($_SESSION['delete-invite-succes'])) {
            $info_text = $_SESSION['delete-invite-succes'];
            require 'components/popup.php';
            unset($_SESSION['delete-invite-succes']);
        }
    } ?>
</main>
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
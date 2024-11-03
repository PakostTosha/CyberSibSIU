<?php
$page_title = 'Мой профиль';
require('components/header.php');

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
                    <li class="settings__section">Настройки <br> пользователя</li>
                </a>
                <a class="settings__link tournament" href="user-profile-tournament.php">
                    <li class="settings__section">Турнир</li>
                </a>
                <a class="settings__link team selected" href="user-profile-team.php">
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
                <!-- Команда -->
                <div class="form team__options selected">

                    <!-- Попап с информацией об операции -->
                    <?php if (
                        isset($_SESSION['invite-error']) || isset($_SESSION['invite-succes']) ||
                        isset($_SESSION['delete-team-succes']) || isset($_SESSION['exit-succes']) ||
                        isset($_SESSION['send-team-error']) || isset($_SESSION['send-team-succes'])
                    ) {
                        if (isset($_SESSION['invite-error'])) {
                            $invite_text = $_SESSION['invite-error'];
                            require 'components/popup-team.php';
                            unset($_SESSION['invite-error']);

                        } else if (isset($_SESSION['invite-succes'])) {
                            $invite_text = $_SESSION['invite-succes'];
                            require 'components/popup-team.php';
                            unset($_SESSION['invite-succes']);

                        } else if (isset($_SESSION['delete-team-succes'])) {
                            $invite_text = $_SESSION['delete-team-succes'];
                            require 'components/popup-team.php';
                            unset($_SESSION['delete-team-succes']);

                        } else if (isset($_SESSION['exit-succes'])) {
                            $invite_text = $_SESSION['exit-succes'];
                            require 'components/popup-team.php';
                            unset($_SESSION['exit-succes']);

                        } else if (isset($_SESSION['send-team-error'])) {
                            $invite_text = $_SESSION['send-team-error'];
                            require 'components/popup-team.php';
                            unset($_SESSION['send-team-error']);

                        } else if (isset($_SESSION['send-team-succes'])) {
                            $invite_text = $_SESSION['send-team-succes'];
                            require 'components/popup-team.php';
                            unset($_SESSION['send-team-succes']);
                        }
                    } ?>

                    <!-- Если игрок найден в таблице команд, то отображать информацию о команде и её членах -->
                    <?php
                    require_once 'vendor/connect.php';
                    $id_user = $_SESSION['user']['id'];
                    $check_is_in_team = mysqli_query(
                        $connect,
                        "SELECT `users`.`ID_user`, `teams`.`ID_team`, `games`.`ID_game`, `roles`.`ID_role`, 
                        `users`.`nickname`, `teams`.`team_name`, `games`.`name_of_game`, `roles`.`name_role`, `team_join`.`date_join`, `team_join`.`status` FROM `team_join` 
                        INNER JOIN `users` on `team_join`.`ID_user` = `users`.`ID_user`
                        INNER JOIN `teams` on `team_join`.`ID_team` = `teams`.`ID_team`
                        INNER JOIN `roles` on `team_join`.`ID_role` = `roles`.`ID_role`
                        INNER JOIN `games` on `team_join`.`ID_game` = `games`.`ID_game`
                        WHERE `users`.`ID_user` = '$id_user'"
                    );
                    if (mysqli_num_rows($check_is_in_team) > 0) {
                        //Пользователь состоит в команде
                        // если i = 1 - в одной команде, если i = 2 - в двух командах
                        // Создаём массив со всеми вхождениями пользователя в команды (1 строка = член одной команды)
                        for ($i = 1; $i <= mysqli_num_rows($check_is_in_team); $i++) {
                            $user_team_rows[$i] = mysqli_fetch_assoc($check_is_in_team);
                        }
                        // user_team_rows ( 
                        // [1] => $team ( 
                        //     [ID_user] => 4 
                        //     [ID_team] => 8 
                        //     [ID_game] => 2 
                        //     [ID_role] => 2 
                        //     [nickname] => anton 
                        //     [team_name] => dotawin 
                        //     [name_of_game] => dota2 
                        //     [name_role] => Игрок 
                        //     [date_join] => 2023-04-21 
                        //     [status] => 0 ) 
                    
                        // [2] => $team ( 
                        //     [ID_user] => 4 
                        //     [ID_team] => 7 
                        //     [ID_game] => 1 
                        //     [ID_role] => 1 
                        //     [nickname] => anton 
                        //     [team_name] => test_sucsess 
                        //     [name_of_game] => csgo 
                        //     [name_role] => Капитан 
                        //     [date_join] => 2023-04-20 
                        //     [status] => 0 ) )
                    

                        foreach ($user_team_rows as $team): ?>
                            <div class="team">
                                <!-- Создаём n-ое количество команд с информацией о каждой из массива -->
                                <div class="team__title">Информация о команде:</div>
                                <ul class="team__info">

                                    <li class="team__game">Игра:
                                        <b>
                                            <?= $team['name_of_game'] ?>
                                        </b>
                                    </li>

                                    <li class="team__name">Название:
                                        <b>
                                            <?= $team['team_name'] ?>
                                        </b>
                                    </li>

                                    <li class="team__status">Статус:
                                        <b>
                                            <?php
                                            $id_team = $team['ID_team'];
                                            $team_ready = $team_formed = false;
                                            if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `team_join` WHERE `ID_team` = '$id_team' AND `status` = '0'")) === 5) {
                                                $team_ready = true;
                                            }
                                            if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `team_join` WHERE `ID_team` = '$id_team' AND `status` = '1'")) === 5) {
                                                $team_formed = true;
                                            }
                                            if ($team_formed): ?>
                                                <p style="color: green">сформирована</p>, команда примет участие в турнире
                                            <?php else: ?>
                                                <p style="color: red">не сформирована</p>, команда не примет участие в турнире
                                            <?php endif; ?>
                                        </b>
                                    </li>

                                </ul>

                                <?php
                                // Запрос в текущую команду с сопоставлением её капитана и ID польз.сессии
                                $id_cur_team = $team['ID_team'];
                                $cap_check = mysqli_query(
                                    $connect,
                                    "SELECT `team_join`.`ID_user` 
                                    FROM `team_join` 
                                    WHERE `team_join`.`ID_team` = '$id_cur_team' AND `team_join`.`ID_role` = '1'"
                                );
                                if (mysqli_num_rows($cap_check) > 0) {
                                    $cap_check = mysqli_fetch_array($cap_check)['ID_user'];
                                    if ($_SESSION['user']['id'] === $cap_check) {
                                        $isCap = true;
                                        $idCap = $cap_check;
                                    } else {
                                        $isCap = false;
                                    }
                                }
                                // Создать запрос по id команды и текущей игре, чтобы вытащить из неё игроков. 
                                // Сортируем по дате по возрастанию (первый игрок вступил раньше - он же капитан, последний - позже)
                                $cur_team = $team['ID_team']; //ID текущей команды в цикле
                                $pl_in_team = mysqli_query(
                                    $connect,
                                    "SELECT `team_join`.`ID_team`, `team_join`.`ID_user`, `team_join`.`ID_role`, `roles`.`name_role`, `users`.`nickname`, `team_join`.`date_join`, `users`.`steam`, `users`.`vk` 
                                    FROM `team_join` 
                                    INNER JOIN `users` on `team_join`.`ID_user` = `users`.`ID_user` 
                                    INNER JOIN `roles` on `team_join`.`ID_role` = `roles`.`ID_role` 
                                    WHERE `team_join`.`ID_team` = '$cur_team'"
                                );
                                if (mysqli_num_rows($pl_in_team) > 0) {
                                    for ($i = 1; $i <= mysqli_num_rows($pl_in_team); $i++) {
                                        $players_of_team[$i] = mysqli_fetch_assoc($pl_in_team);
                                    }
                                } else {
                                    echo 'Ошибка! (стр.162)';
                                }

                                ?>

                                <div class="invite-status-container">
                                    <div class="status__title">Список игроков:</div>
                                    <div class="status-container">
                                        <div class="status in-team">|В команде
                                            <?= mysqli_num_rows($pl_in_team) ?> из 5 |
                                        </div>

                                        <?php
                                        $ID_team = $players_of_team['1']['ID_team'];
                                        $check_counst_invite = mysqli_query($connect, "SELECT * FROM `notices` WHERE `ID_team` = '$ID_team'");
                                        $counst_invite = mysqli_num_rows($check_counst_invite);
                                        ?>

                                        <div class="status in-process">|Ожидают ответа
                                            <?= $counst_invite ?> инвайта(ов)|
                                        </div>
                                    </div>
                                </div>

                                <!-- Кнопка только у капитана -->
                                <?php if ($isCap): ?>
                                    <?php if (!$team_formed): ?>
                                        <a href="invite-in-team.php?team=<?= $team['team_name'] ?>&idfrom=<?= $idCap ?>"
                                            class="invite-btn btn">Пригласить игрока</a>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <!-- Список игроков в команде -->
                                <ul class="team__players">
                                    <!-- // $players_of_team ( 
                                            //     $[1] => Array ( 
                                            //         [ID_team] => 7 
                                            //         [ID_user] => 4 
                                            //         [ID_role] => 1 
                                            //         [name_role] => Капитан 
                                            //         [nickname] => anton 
                                            //         [date_join] => 2023-04-20 
                                            //         [steam] => https://steamcommunity.com/id/chubrikazimov/ 
                                            //         [vk] => https://vk.com/a_pakost ) 
                                            //     $[2] => Array ( 
                                            //         [ID_team] => 7 
                                            //         [ID_user] => 8 
                                            //         [ID_role] => 2 
                                            //         [name_role] => Игрок 
                                            //         [nickname] => gelik 
                                            //         [date_join] => 2023-04-24 
                                            //         [steam] => https://steamcommunity.com/id/muzamoon 
                                            //         [vk] => https://vk.com/shatalova.galina )
                                            // ) -->
                                    <?php foreach ($players_of_team as $player): ?>
                                        <?php if ($player['ID_role'] == 1): ?>
                                            <!-- Капитан -->
                                            <li class="player captain">
                                                <div class="player__nick">Капитан команды:<p class="player__value">
                                                        <?= $player['nickname'] ?>
                                                    </p>
                                                </div>
                                                <div class="player__url">
                                                    <a href="<?= $player['steam'] ?>">
                                                        <img src="src/img/main/user-profile-team/iconmonstr-steam-3.svg" alt="Steam">
                                                    </a>
                                                    <a href="<?= $player['vk'] ?>">
                                                        <img src="src/img/main/user-profile-team/iconmonstr-vk-3.svg" alt="VK">
                                                    </a>
                                                </div>
                                            </li>
                                        <?php else: ?>
                                            <!-- Игрок -->
                                            <li class="player">
                                                <div class="player__info">
                                                    <div class="player__nick">Игрок:
                                                        <p class="player__value">
                                                            <?= $player['nickname'] ?>
                                                        </p>
                                                    </div>
                                                    <div class="player__url">
                                                        <a href="<?= $player['steam'] ?>">
                                                            <img src="src/img/main/user-profile-team/iconmonstr-steam-3.svg"
                                                                alt="Steam">
                                                        </a>
                                                        <a href="<?= $player['vk'] ?>">
                                                            <img src="src/img/main/user-profile-team/iconmonstr-vk-3.svg" alt="VK">
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- Кнопка только у капитана -->
                                                <?php if ($isCap): ?>
                                                    <div class="player__action">
                                                        <a href="vendor/team/kickfromteam.php?id=<?= $player['ID_user'] ?>&id_team=<?= $team['ID_team'] ?>&team_name=<?= $team['team_name'] ?>"
                                                            class="kick btn">Исключить</a>
                                                    </div>
                                                <?php endif; ?>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>

                                <!-- Проверка на количество игроков в команде -->
                                <?php
                                if ($isCap): ?>
                                    <?php if ($team_ready): ?>
                                        <a href="vendor/team/send-team.php?idteam=<?= $team['ID_team'] ?>" class="btn team-reg">Принять
                                            участие в турнире</a>
                                    <?php endif; ?>
                                    <a href="vendor/team/deleteteam.php?idteam=<?= $id_cur_team ?>"
                                        class="btn destroy-team">Распустить команду</a>
                                <?php else: ?>
                                    <a href="vendor/team/exitfromteam.php?id=<?= $_SESSION['user']['id'] ?>&id_team=<?= $team['ID_team'] ?>"
                                        class="btn destroy-team">Покинуть команду</a>
                                <?php endif; ?>

                            </div>
                        <?php endforeach;


                    } else {
                        echo '<div class="team__title">К сожалению, вы не состоите ни в одной команде</div>';
                        exit();
                    } ?>
                </div>
            </div>
        </div>
    </section>
</main>
</div>


<script src="../js/jquery.min.js"></script>
<script src="../js/popup.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
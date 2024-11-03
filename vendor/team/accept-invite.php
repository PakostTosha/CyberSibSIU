<?php
require('../connect.php');
session_start();

$id_user = $_GET['iduser'];
$id_team = $_GET['idteam'];
$date = date('Y-m-d');
$id_game = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `ID_game` FROM `team_join` WHERE `ID_team` = '$id_team'"))['ID_game'];
$id_notice = $_GET['idnotice'];

// Состоит ли пользователь в данной команде или в команде по этой игре
$check_pl = mysqli_query($connect, "SELECT * FROM `team_join` 
WHERE (`ID_team` = '$id_team' AND `ID_user` = '$id_user') OR (`ID_user` = '$id_user' AND `ID_game` = '$id_game')");
if (!mysqli_num_rows($check_pl) > 0) {
    // Проверить, есть ли место в данной команде
    $check_place_team = mysqli_query($connect, "SELECT * FROM `team_join` WHERE `ID_team` = '$id_team'");
    if (mysqli_num_rows($check_place_team) > 0 && mysqli_num_rows($check_place_team) < 5) {
        // Место есть, значит добавить в таблицу запись об участнике 
        mysqli_query(
            $connect,
            "INSERT INTO `team_join`(`ID_user`, `ID_team`, `ID_role`, `date_join`, `ID_game`, `status`) 
            VALUES ('$id_user','$id_team','2','$date','$id_game','0')"
        );
        $_SESSION['accept-invite-succes'] = 'Вы успешно добавлены в команду. Подробнее в личном кабинете в разделе "команда"';
        header('Location: ../../user-profile-notices.php');
        // Удалить приглашение
        mysqli_query($connect, "DELETE FROM `notices` WHERE `ID_notice` = '$id_notice'");
        exit();
    } else {
        // Места в команде нет
        $_SESSION['accept-invite-error'] = 'Вы не можете принять приглашение, потому что нет свободного места или команда не существует.';
        header('Location: ../../user-profile-notices.php');
        exit();
    }
} else {
    // Игрок уже состоит в данной команде
    $_SESSION['accept-invite-error'] = 'Вы не можете принять приглашение, потому что уже состоите в данной команде или команде по этой игре.';
    header('Location: ../../user-profile-notices.php');
    exit();
}


?>
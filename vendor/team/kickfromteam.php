<?php
require('../connect.php');

$id_pl_on_exit = $_GET['id'];
$id_t_f_exit = $_GET['id_team'];
$id_user_from = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `ID_user` FROM `team_join` WHERE `ID_team` = '$id_t_f_exit' AND `ID_role` = '1'"))['ID_user'];
$team_name = $_GET['team_name'];
$team_id = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `ID_team` FROM `teams` WHERE `team_name` = '$team_name'"))['ID_team'];
$title = 'Исключение из команды';
$type = 'info';
$text = 'Вы были исключены из команды ' . $team_name . ' её капитаном';


// Создать запрос об исключении пользователя с ID=... из команды с ID=...
mysqli_query($connect, "DELETE FROM `team_join` WHERE `ID_user` = '$id_pl_on_exit' AND `ID_team` = '$id_t_f_exit'");
// Обновление статуса команды с 1 на 0
$cur_date = date('Y-m-d');
mysqli_query($connect, "UPDATE `team_join` SET `date_join`='$cur_date', `status`='0' WHERE `ID_team` = '$id_t_f_exit'");

// Отправить уведомление игроку с ID об исключении из команды с названием (найти по ID)
mysqli_query(
    $connect,
    "INSERT INTO `notices`(`ID_notice`, `ID_user`, `ID_from`, `ID_team`, `text`, `title`, `type`) 
    VALUES (NULL,'$id_pl_on_exit','$id_user_from','$team_id','$text', '$title' ,'$type')"
);

header('Location: /user-profile-team.php');
?>
<?php
require '../connect.php';
session_start();

$user = $_GET['id'];
$team = $_GET['id_team'];

// Удалить записи в данной команде о данном игроке и изменить статус
$cur_date = date('Y-m-d');
mysqli_query($connect, "UPDATE `team_join` SET `date_join`='$cur_date', `status`='0' WHERE `ID_team` = '$team'");

mysqli_query($connect, "DELETE FROM `team_join` WHERE `ID_user` = '$user' AND `ID_team` = '$team'");
// Отправить уведомление капитана, что участник покинул команду

$teamname = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `team_name` FROM `teams` WHERE `ID_team` = '$team'"))['team_name'];

// Залочено из-за возможных повторений уведомлений 

$idto = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `ID_user` FROM `team_join` WHERE `ID_team` = '$team' AND `ID_role` = '1'"))['ID_user'];
$username = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `nickname` FROM `users` WHERE `ID_user` = '$user'"))['nickname'];
$text = 'К сожалению, игрок под никнеймом ' . $username . ' покинул команду - ' . $teamname;
$title = 'Изменение состава команды';
$type = 'info';
mysqli_query(
    $connect,
    "INSERT INTO `notices`(`ID_notice`, `ID_user`, `ID_from`, `ID_team`, `text`, `title`, `type`) 
    VALUES (NULL,'$idto','$user','$team','$text','$title','$type')"
);

// Информация, что вышел
$_SESSION['exit-succes'] = 'Вы успешно покинули команду ' . $teamname;
header('Location: ../../user-profile-team.php');
exit();
?>
<?php
require '../connect.php';
session_start();

$id_team = $_GET['idteam'];

// Удаление команды из списка команд `teams`
mysqli_query($connect, "DELETE FROM `teams` WHERE `ID_team` = '$id_team'");
// Удаление строк с ID команды из уведомлений `notices`
mysqli_query($connect, "DELETE FROM `notices` WHERE `ID_team` = '$id_team'");
// Удаление всех записей по ID команды в таблице участников `team_join`
mysqli_query($connect, "DELETE FROM `team_join` WHERE `ID_team` = '$id_team'");

$_SESSION['delete-team-succes'] = 'Команда успешно распущена';
header('Location: ../../user-profile-team.php');
exit();
?>
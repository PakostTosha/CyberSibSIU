<?php
require('../connect.php');
session_start();

$id_notice = $_GET['idnotice'];
// Чтобы отклонить приглашение - нужно удалить его из таблицы уведомлений
mysqli_query($connect, "DELETE FROM `notices` WHERE `ID_notice` = '$id_notice'");
$_SESSION['delete-invite-succes'] = 'Вы отклонили приглашение в команду.';
header('Location: ../../user-profile-notices.php');
exit();

?>
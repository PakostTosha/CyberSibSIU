<?php
session_start();
require_once '../connect.php';

$id_user = $_GET['iduser'];
// Удаляем все приглашения
mysqli_query($connect, "DELETE FROM `notices` WHERE `ID_user` = '$id_user'");
$_SESSION['delete-invite-succes'] = 'Список уведомлений и приглашений очищен.';
header('Location: ../../user-profile-notices.php');
exit();

?>
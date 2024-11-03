<?php
require '../connect.php';
session_start();

$id_team = $_GET['idteam'];
$cur_date = date('Y-m-d');
// Проверка, сколько участников в команде (если = 5, то продолжить, иначе - выход)
$check_count_pl = mysqli_query($connect, "SELECT * FROM `team_join` WHERE `ID_team` = '$id_team'");
if (mysqli_num_rows($check_count_pl) > 0) {
    if (mysqli_num_rows($check_count_pl) === 5) {

        // Меняем статус команды с 0 на 1 и добавляем дату принятия участия в турнире (т.е. команда примет участие в турнире)
        mysqli_query($connect, "UPDATE `team_join` SET `date_join`='$cur_date', `status`='1' WHERE `ID_team` = '$id_team'");
        // Удалить все отправленные приглашения по ID команды
        mysqli_query($connect, "DELETE FROM `notices` WHERE `ID_team` = '$id_team'");
        $_SESSION['send-team-succes'] = 'Команда по выбранной игре сформирована и добавлена в таблицу участников. 
        Ожидайте информации о начале турнира и список команд-участников в разделе "О турнире". 
        <br>
        <br> Желаем успехов!';
        header('Location: ../../user-profile-team.php');
        exit();

    } else {
        $_SESSION['send-team-error'] = 'В составе команды не 5 игроков';
        mysqli_query($connect, "UPDATE `team_join` SET `date_join`='$cur_date', `status`='0' WHERE `ID_team` = '$id_team'");
        header('Location: ../../user-profile-team.php');
        exit();
    }
} else {
    $_SESSION['send-team-error'] = 'Не удалось найти ни одного игрока';
    header('Location: ../../user-profile-team.php');
    exit();
}
?>
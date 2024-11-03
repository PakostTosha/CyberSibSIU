<?php
require('../connect.php');
session_start();

$nick_to = trim($_POST['pl-nickname']);
$id_user_from = $_POST['ID_from'];
$name_user_from = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `nickname` FROM `users` WHERE `ID_user` = '$id_user_from'"))['nickname'];
$team_name_to = $_POST['to_team_name'];
$team_id_to = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `ID_team` FROM `teams` WHERE `team_name` = '$team_name_to'"))['ID_team'];
$type = 'invite';

$id_of_game = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `ID_game` FROM `team_join` WHERE `ID_team` = '$team_id_to'"))['ID_game'];
$name_of_game = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `name_of_game` FROM `games` WHERE `ID_game` = '$id_of_game'"))['name_of_game'];



//Сформирована ли команда?
$check_team = mysqli_query($connect, "SELECT * FROM `team_join` WHERE `ID_team` = '$team_id_to' AND `status` = '1'");
if (mysqli_num_rows($check_team) > 0 && mysqli_num_rows($check_team) >= 5) {
    $_SESSION['invite-error'] = 'Ошибка. Команда уже сформирована';
    header('Location: ../../user-profile-team.php');
    exit();
} else {
    //Команда не сформирована, но есть ли в ней место?
    $check_place_team = mysqli_query($connect, "SELECT * FROM `team_join` WHERE `ID_team` = '$team_id_to'");
    if (mysqli_num_rows($check_place_team) >= 5) {
        $_SESSION['invite-error'] = 'Ошибка. Команда переполнена';
        header('Location: ../../user-profile-team.php');
        exit();
    } else {
        // Если ник совпадает с ником авторизованного пользователя - ошибка "нельзя оотправить самому себе"
        if (!($nick_to === $_SESSION['user']['nickname'])) {
            //В команде есть место, существует ли такой пользователь?
            $check_user_to = mysqli_query($connect, "SELECT `ID_user` FROM `users` WHERE `nickname` = '$nick_to'");
            if (mysqli_num_rows($check_user_to) === 0) {
                $_SESSION['invite-error'] = 'Ошибка. Пользователь с таким ником не найден';
                header('Location: ../../user-profile-team.php');
                exit();
            } else {
                //Пользователь найден
                //Нельзя отправить несколько одинаковых приглашений одному игроку
                $id_user_to = mysqli_fetch_array($check_user_to)['ID_user'];
                $check_count_invites = mysqli_query(
                    $connect,
                    "SELECT `ID_user`, `ID_from`, `ID_team`, `type` FROM `notices` 
                WHERE `ID_user` = '$id_user_to' AND `ID_from` = '$id_user_from' AND `ID_team` = '$team_id_to' AND `type` = 'invite'"
                );
                if (mysqli_num_rows($check_count_invites) < 1) {
                    $text = 'Вам отправлено приглашение на вступление в команду ' . $team_name_to . ' по игре '.$name_of_game.' от её капитана - ' . $name_user_from . '. 
                Вы можете принять приглашение и вступить в команду или отклонить запрос.';
                    $title = 'Вступление в команду '.$team_name_to.'!';
                    mysqli_query(
                        $connect,
                        "INSERT INTO `notices`(`ID_notice`, `ID_user`, `ID_from`, `ID_team`, `text`, `title`, `type`) 
                        VALUES (NULL,'$id_user_to','$id_user_from','$team_id_to','$text', '$title' ,'$type')"
                    );
                    $_SESSION['invite-succes'] = 'Успех. Приглашение в команду отправлено игроку ' . $nick_to;
                    header('Location: ../../user-profile-team.php');
                    exit();
                } else {
                    $_SESSION['invite-error'] = 'Ошибка. Приглашение данному пользователю уже отправлено';
                    header('Location: ../../user-profile-team.php');
                    exit();
                }
            }
        } else {
            $_SESSION['invite-error'] = 'Ошибка. Нельзя отправить приглашение самому себе';
            header('Location: ../../user-profile-team.php');
            exit();
        }
    }
}
?>
<?php
session_start();
require_once '../connect.php';


//Получение необходимых данных
$id_user = $_SESSION['user']['id'];
$selected_game = $_POST['game'];
$team_name = trim($_POST['team-name']);
// 1 - csgo
// 2 - dota2
if ($selected_game === 'csgo') {
    $id_selected_game = 1;
} else if ($selected_game === 'dota2') {
    $id_selected_game = 2;
} else
    die('Ошибка с выбором id игры');

//Состоит ли игрок в команде?
$check_is_in_team = mysqli_query(
    $connect,
    "SELECT `users`.`ID_user`, `users`.`nickname`, `teams`.`team_name`, `games`.`name_of_game` FROM team_join 
INNER JOIN users ON team_join.ID_user = users.ID_user
INNER JOIN teams ON team_join.ID_team = teams.ID_team
INNER JOIN games ON team_join.ID_game = games.ID_game
WHERE `users`.`ID_user` = '$id_user' AND `games`.`name_of_game` = '$selected_game'"
);

if (mysqli_num_rows($check_is_in_team) > 0) {
    //Игрок уже в команде
    $_SESSION['is_in_team'] = 'Вы не можете создать команду по выбранной игре, потому что являетесь членом другой команды. Более подробно во вкладке: "Команда"';
    header('Location: ../../request-join.php');
    exit();
} else {
    //Проверить название команды на уникальность перед созданием
    $check_team_name = mysqli_query($connect, "SELECT * FROM `teams` WHERE `team_name` = '$team_name'");
    if (mysqli_num_rows($check_team_name) > 0) {
        //Имя команды не уникально
        $_SESSION['check_team_name'] = 'Команда с таким названием уже существует, придумайте другое';
        header('Location: ../../request-join.php');
        exit();
    } else {
        //Создание команды
        mysqli_query($connect, "INSERT INTO `teams`(`ID_team`, `team_name`, `win_count`) VALUES (NULL,'$team_name','0')");
        //Узнаём ID создавшейся команды
        $id_new_team = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `ID_team` FROM `teams` WHERE `team_name` = '$team_name'"))['ID_team'];

        //Добавление капитана команды в таблицу с фиксацией даты
        $invite_date = date('Y-m-d');
        mysqli_query(
            $connect,
            "INSERT INTO `team_join`(`ID_user`, `ID_team`, `ID_role`, `date_join`, `ID_game`, `status`) VALUES ('$id_user','$id_new_team','1','$invite_date','$id_selected_game', '0')"
        );
        $_SESSION['create_team'] = 'Команда успешно создана, можете отправить приглашения игрокам в личном кабинете во вкладке: "Команда" ';
        header('Location: ../../request-join.php');
        exit();
    }
}
?>
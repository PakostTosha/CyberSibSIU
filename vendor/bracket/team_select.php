<?php
require_once '../connect.php';

// Получение ассоц.массива доступных игр с ID и названием
$games_q = mysqli_query($connect, "SELECT * FROM `games`");
for ($i = 1; $i <= mysqli_num_rows($games_q); $i++) {
    $games[$i] = mysqli_fetch_assoc($games_q);
}


// Перебор по каждой игре
foreach ($games as $game) {

    // $game
    // (
    //     [ID_game] => 1
    //     [name_of_game] => csgo
    // )

    // Запрос команд со статусом "1" по текущей игре
    $id_cur_game = $game['ID_game'];
    $query_teams = mysqli_query($connect, "SELECT * FROM `team_join` WHERE `ID_role`= '1' AND `status` = '1' AND `ID_game` = '$id_cur_game'");

    // Найденный строк больше =4?
    if (mysqli_num_rows($query_teams) >= 4) {
        // Количество найденных строк =8?
        if (mysqli_num_rows($query_teams) >= 8) {
            // Да, 8. Значит составить сетку первого этапа из 8 команд
            $query_join = mysqli_query($connect, "SELECT `ID_team` FROM `team_join` WHERE `ID_role` = '1' AND `status` = '1' ORDER BY `date_join`, `ID_team` ASC");
            for ($i = 1; $i <= 8; $i++) {
                $teams[$i] = mysqli_fetch_assoc($query_join)['ID_team'];
            }
            // 1) Сформировать 4 пары
            for ($i = 1; $i <= count($teams); $i += 2) {
                $team1 = $teams[$i];
                $team2 = $teams[$i + 1];
                // Составить пару
                mysqli_query($connect, "INSERT INTO `couple_team`(`ID_couple_team`, `ID_team1`, `ID_team2`) VALUES (NULL,'$team1','$team2')");
                // Получить массив ID пар
                $query_couple = mysqli_query($connect, "SELECT `ID_couple_team` FROM `couple_team` WHERE `ID_team1` = '$team1' AND `ID_team2` = '$team2'");
                $couples[] = mysqli_fetch_assoc($query_couple)['ID_couple_team'];
            }
            // 2) Добавить 4 пары по ID в таблицу сетки с указанием необходимых данных
            $cur_date = date('Y-m-d');
            $date_start_tournament = '2023-05-31';
            // Определить ID сетки
            $query_bracket_id = mysqli_query($connect, "SELECT `ID_bracket` FROM `tournament_bracket` ORDER BY `ID_bracket` DESC LIMIT 1;");
            if (mysqli_num_rows($query_bracket_id) > 0) {
                $ID_bracket = mysqli_fetch_assoc($query_bracket_id)['ID_bracket'];
            } else {
                $ID_bracket = 1;
            }
            // Вставить значения
            for ($i = 0; $i < count($couples); $i++) {
                $cur_couple = $couples[$i];
                mysqli_query($connect, "INSERT INTO `tournament_bracket`(`ID_bracket`, `ID_game`, `ID_phase`, `date_phases`, `ID_couple_team`, `date_start_tournament`) 
                VALUES ('$ID_bracket','$id_cur_game','1','$cur_date','$cur_couple','$date_start_tournament')");
            }
            echo 'Операции успешно выполнены. ID игры: '.$id_cur_game;
            exit();

        } else {
            // Нет, их меньше 8, но больше/равно 4. Значит составляем сетку первого этапа из 4 команд
            $query_join = mysqli_query($connect, "SELECT `ID_team` FROM `team_join` WHERE `ID_role` = '1' AND `status` = '1' ORDER BY `date_join`, `ID_team` ASC");
            for ($i = 1; $i <= 4; $i++) {
                $teams[$i] = mysqli_fetch_assoc($query_join)['ID_team'];
            }
            // 1) Сформировать 2 пары
            for ($i = 1; $i <= count($teams); $i += 2) {
                $team1 = $teams[$i];
                $team2 = $teams[$i + 1];
                // Составить пару
                mysqli_query($connect, "INSERT INTO `couple_team`(`ID_couple_team`, `ID_team1`, `ID_team2`) VALUES (NULL,'$team1','$team2')");
                // Получить массив ID пар
                $query_couple = mysqli_query($connect, "SELECT `ID_couple_team` FROM `couple_team` WHERE `ID_team1` = '$team1' AND `ID_team2` = '$team2'");
                $couples[] = mysqli_fetch_assoc($query_couple)['ID_couple_team'];
            }
            // 2) Добавить 2 пары по ID в таблицу сетки с указанием необходимых данных
            $cur_date = date('Y-m-d');
            $date_start_tournament = '2023-05-31';
            // Определить ID сетки
            $query_bracket_id = mysqli_query($connect, "SELECT `ID_bracket` FROM `tournament_bracket` ORDER BY `ID_bracket` DESC LIMIT 1;");
            if (mysqli_num_rows($query_bracket_id) > 0) {
                $ID_bracket = mysqli_fetch_assoc($query_bracket_id)['ID_bracket'];
            } else {
                $ID_bracket = 1;
            }
            // Вставить значения
            for ($i = 0; $i < count($couples); $i++) {
                $cur_couple = $couples[$i];
                mysqli_query($connect, "INSERT INTO `tournament_bracket`(`ID_bracket`, `ID_game`, `ID_phase`, `date_phases`, `ID_couple_team`, `date_start_tournament`) 
                VALUES ('$ID_bracket','$id_cur_game','3','$cur_date','$cur_couple','$date_start_tournament')");
            }
            echo 'Операции успешно выполнены. ID игры: '.$id_cur_game;
            exit();
        }
        // иначе вывести информацию об продлении этапа регистрации
    } else {
        echo '<center>Необходимо продлить этап регистрации по игре: "' . $game['name_of_game'] . '" с ID: ' . $game['ID_game'] . '.
            <br> На данный момент количество сформированных команд по этой игре составляет: ' . mysqli_num_rows($query_teams) . '<br><br></center>';
    }

}

?>
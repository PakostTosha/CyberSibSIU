<?php
$page_title = 'Участие в турнире';
require('components/header.php');

?>



<main class="page container">
    <link rel="stylesheet" href="../css/request-join.css">
    <section class="request-container">
        <div class="request-upper-line">Создать команду для участия в турнире</div>

        <form action="vendor/team/createteam.php" class="request-form" method="post">
            <input id="captain" type="checkbox" name="iscaptain" required>
            <label for="captain">Стать капитаном команды</label>

            <fieldset class="team-rq">
                <div class="team__select-game">
                    <p>Игра:</p>
                    <input type="radio" name="game" id="cs:go" value="csgo" required>
                    <label for="cs:go">CS:GO</label>
                    <input type="radio" name="game" id="dota2" value="dota2" required>
                    <label for="dota2">Dota 2</label>
                    <p class="info">Выберите одну из предложенных игр</p>
                </div>
                <div class="team__name-container">
                    <input name="team-name" class="team__name-in" type="text" placeholder="Введите название команды:"
                        required>
                </div>

                <button type="submit" class="btn accept-request">Создать команду</button>
                <!-- Попап с инфо для пользователя -->
                <?php
                if (isset($_SESSION['is_in_team'])) { //В команде ли?
                    //вывод
                    $info_text = $_SESSION['is_in_team'];
                    require 'components/popup.php';
                    unset($_SESSION['is_in_team']);
                } else if (isset($_SESSION['check_team_name'])) { //Уникально ли название команды?
                    //вывод
                    $info_text = $_SESSION['check_team_name'];
                    require 'components/popup.php';
                    unset($_SESSION['check_team_name']);
                } else if (isset($_SESSION['create_team'])) { //Создана команда
                    //вывод
                    $info_text = $_SESSION['create_team'];
                    require 'components/popup.php';
                    unset($_SESSION['create_team']);
                }
                ?>


            </fieldset>
        </form>
    </section>
</main>
</div>

</body>

</html>
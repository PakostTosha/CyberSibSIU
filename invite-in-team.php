<?php
$page_title = 'Приглашение';
require('components/header.php');
?>

<main class="page container">
    <!-- Попап с формой приглашения -->
    <div class="popup-bg-invite">
        <div class="popup-invite">
            <form action="vendor/team/inviteplayer.php" method="post">
                <div class="popup__title-invite">
                    <h2>Приглашение игрока в команду <?= $_GET['team'] ?></h2>
                </div>
                <div class="popup__form-invite">
                    <label for="pl-nickname">Введите никнейм, кого хотите пригласить:</label>
                    <input id="pl-nickname" type="text" class="pl-nickname" name="pl-nickname" placeholder="Никнейм"
                        required>
                    <input type="hidden" name="ID_from" value="<?= $_GET['idfrom'] ?>">
                    <input type="hidden" name="to_team_name" value="<?= $_GET['team'] ?>">
                    <button type="submit" class="btn">Отправить приглашение</button>
                    <a href="user-profile-team.php" class="btn">Назад</a>
                </div>
            </form>
        </div>
    </div>
</main>
</div>
</body>

</html>
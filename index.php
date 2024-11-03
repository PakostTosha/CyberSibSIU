<?php
$page_title = 'CyberSibSIU';
require ('components/header.php');
// require('components/main.php');
?>

<main class="page container">
    <section class="page__content-invite">
        <div class="content__invite">
            <h1 class="content__invite-title">Стань №1 в мире Киберспорта</h1>

            <?php if ($isAuth): ?>
            <a href="request-join.php" class="content__button-invite button-invite">Принять участие</a>
            <?php else: ?>
            <a href="login-register.php" class="content__button-invite button-invite">Принять участие</a>
            <?php endif; ?>
            
        </div>
    </section>
    <section class="page__content-news">
        <div class="content__news news">
            <div class="news__block--left"></div>
            <div class="news__block--right text">
                <div class="text__reg">Регистрация до 25 мая 2023 года</div>
                <div class="text__step">1 этап</div>
                <div class="text__tournament">Киберспортивная школьная лига</div>
                <div class="text__start">Старт 1 этапа: 30 мая 2023 года</div>
                <div class="text__all-news"><a href="news.php">Все новости</a></div>
            </div>
        </div>
    </section>
    <section class="page__tournament-info">
        <div class="tournament-info">
            <div class="tournament-info__img">
                <img class="tournament-info__img--csgo" src="src/img/main/tournament-info/cs.png" alt="CS:GO">
                <img class="tournament-info__img--dota" src="src/img/main/tournament-info/dota.png" alt="Dota 2">
            </div>
            <div class="tournament-info__text">
                <h2 class="tournament-info__text-title">Покажи свои навыки в командной игре</h2>
                <p class="tournament-info__text-info">Соревнования проводятся в двух играх: DOTA 2, CS:GO.
                    Участвуют только команды, поэтому успей создать <br> команду и подать заявку до 25 мая 2023г.</p>
            </div>
        </div>
    </section>
    <section class="page__tournament-rules">
        <div class="page__tournament-rules--case rules">
            <h2 class="rules__title">Основные правила:</h2>
            <ol class="rules__list">
                <li class="rules__item">К Соревнованиям допускаются команды Образовательных организаций, в
                    состав которых входят лица, достигшие 16 лет и не достигшие 25 лет на момент 25.05.2023.</li>
                <li class="rules__item">Учащиеся могут выступать только за Образовательную организацию, в
                    которой они
                    обучались по состоянию на 25.05.2023, в составе одной команды в одном виде программы.</li>
                <li class="rules__item">Каждая Образовательная организация может представлять до двух команд.
                </li>
            </ol>
        </div>
        <div class="page__tournament-rules--button">
            <?php if ($isAuth): ?>
            <a href="request-join.php" class="button-invite">Принять участие</a>
            <?php else: ?>
            <a href="login-register.php" class="button-invite">Принять участие</a>
            <?php endif; ?>
        </div>
    </section>
</main>
</div>
</body>
</html>
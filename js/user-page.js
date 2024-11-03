//Сброс класса selected
function selected_reset() {
    const selected = document.querySelectorAll('.selected');
    for (let i = 0; i < selected.length; i++) {
        const element = selected[i];
        element.classList.remove('selected');
    }
    return;
}

// Настройки пользователя
const settingsLink = document.querySelector('.user-settings');
const settingsForm = document.querySelector('.user-settings__options');
settingsLink.addEventListener('click', () => {
    selected_reset();
    settingsLink.classList.add('selected');
    settingsForm.classList.add('selected');
})


// Турнир
const tournamentLink = document.querySelector('.tournament');
const tournamentForm = document.querySelector('.tournament__options');
tournamentLink.addEventListener('click', () => {
    selected_reset();
    tournamentLink.classList.add('selected');
    tournamentForm.classList.add('selected');
})


// Команда
const teamLink = document.querySelector('.team');
const teamForm = document.querySelector('.team__options');
teamLink.addEventListener('click', () => {
    selected_reset();
    teamLink.classList.add('selected');
    teamForm.classList.add('selected');
})


// Уведомления
const noticeLink = document.querySelector('.notice');
const noticeForm = document.querySelector('.notice__options');
noticeLink.addEventListener('click', () => {
    selected_reset();
    noticeLink.classList.add('selected');
    noticeForm.classList.add('selected');
})


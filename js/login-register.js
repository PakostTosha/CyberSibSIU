//Смена форм "Вход" и "Регистрация"
const wrapper = document.querySelector('.wrapper-form');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');

registerLink.addEventListener('click', ()=> {
    wrapper.classList.add('active');
})
loginLink.addEventListener('click', ()=> {
    wrapper.classList.remove('active');
})

//Показывать пароль при нажатии и удержании на глаз
function show_hide_password(target){
	var input = document.getElementById('password-input');
	if (input.getAttribute('type') == 'password') {
		target.classList.add('view');
		input.setAttribute('type', 'text');
	} else {
		target.classList.remove('view');
		input.setAttribute('type', 'password');
	}
	return false;
}
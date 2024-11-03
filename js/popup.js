// Информация о создании команды
$('.open-popup').click(function(e) {
    e.preventDefault();
    $('.popup-bg').fadeIn(600);
});
$('.close-popup').click(function() {
    $('.popup-bg').fadeOut(600);
});


// Подтверждение об исключении
$('.open-popup-kick').click(function(e) {
    e.preventDefault();
    $('.popup-bg-kick').fadeIn(600);
});
$('.close-popup-kick').click(function() {
    $('.popup-bg-kick').fadeOut(600);
});


// Информация о создании команды
$('.open-popup').click(function(e) {
    e.preventDefault();
    $('.popup-bg').fadeIn(600);
});
$('.close-popup').click(function() {
    $('.popup-bg-team').fadeOut(600);
});

// Уничтожение команды
// $('.destroy-team').click(function(e) {
//     e.preventDefault();
//     $('.popup-bg-delete').fadeIn(600);
// });
// $('.close-popup').click(function() {
//     $('.popup-bg-delete').fadeOut(600);
// });
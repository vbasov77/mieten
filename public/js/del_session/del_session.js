function delSession(event) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/del_session',
        type: 'get',
    });
}

window.addEventListener('visibilitychange', delSession);// Удалим если закрыли вкладку браузера
window.addEventListener('beforeunload', delSession);// Удалим, если обновим вкладку

//Отменим удаление, если нажата кнопка сохранить.
document.querySelector("#submit").onclick = function () {
    window.removeEventListener('visibilitychange', delSession);
    window.removeEventListener('beforeunload', delSession);
    document.getElementById('someInputId').value = array;
};
var card = document.getElementById("card");
var cardBody = document.getElementById("card-body");
var cardFooter = document.getElementById("card-footer");

// card.className = cardName;
// cardBody.className = cardBodyName;
// cardFooter.className = cardFooterName;

document.querySelectorAll('.card').forEach(el => el.className = cardName);
document.querySelectorAll('.card-body').forEach(el => el.className = cardBodyName);
document.querySelectorAll('.card-footer').forEach(el => el.className = cardFooterName);


function rowM() {
    document.querySelectorAll('.card').forEach(el => el.className = 'rowM');
    document.querySelectorAll('.card-body').forEach(el => el.className = 'rowM-body');
    document.querySelectorAll('.card-footer').forEach(el => el.className = 'rowM-footer');
    var data = {
        'cardName': 'rowM',
        'cardBodyName': 'rowM-body',
        'cardFooterName': 'rowM-footer',
    };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/add_session',
        type: 'POST',
        data: data,
        dataType: "html", //формат данных
    });
}


function cardM() {
    document.querySelectorAll('.rowM').forEach(el => el.className = 'card');
    document.querySelectorAll('.rowM-body').forEach(el => el.className = 'card-body');
    document.querySelectorAll('.rowM-footer').forEach(el => el.className = 'card-footer');
    const data = {
        'cardName': 'card',
        'cardBodyName': 'card-body',
        'cardFooterName': 'card-footer',
    };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/add_session',
        type: 'POST',
        data: data,
        dataType: "html", //формат данных
    });
}


    var card = document.getElementById("card");
    var cardBody = document.getElementById("card-body");
    var cardFooter = document.getElementById("card-footer");

    card.className = cardName;
    cardBody.className = cardBodyName;
    cardFooter.className = cardFooterName;

    function rowM() {
        card.classList.remove('card');
        cardBody.classList.remove('card-body');
        cardFooter.classList.remove('card-footer');
        card.classList.add('rowM');
        cardBody.classList.add('rowM-body');
        cardFooter.classList.add('rowM-footer');
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
        cardBody.classList.remove('rowM-body');
        cardFooter.classList.remove('rowM-footer');
        card.classList.remove('rowM');
        card.classList.add('card');
        cardBody.classList.add('card-body');
        cardFooter.classList.add('card-footer');
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

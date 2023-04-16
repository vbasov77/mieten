const escapeHtml = (unsafe) => {
    return unsafe.replaceAll('&', '&amp;').replaceAll('<', '&lt;').replaceAll('>', '&gt;').replaceAll('"', '&quot;').replaceAll("'", '&#039;');
};
$('.messages').animate({ scrollTop: $('.messages ul').height() }, "fast");
function newMessage() {
    var message = $('.message-input input').val();
    data = {
        "to_user_id": to_user_id,
        "from_user_id": from_user_id,
        "obj_id": obj_id,
        "body": message,

    };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/add_message',
        type: 'post',
        data: data,
        dataType: 'json',
        success: function (res) {
            console.log(res);
            let date = new Date(res.date);

            if($.trim(message) == '') {
                message = $('.message-input .emoji-wysiwyg-editor').html();
                if($.trim(message) == '') {
                    return false;
                }
            }

            $(`<div data-id="` + res.id + `" style="float: right; font-size: 17px" class="messageBlock"><button data-id="` + res.id + `" type="button" class="close"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                ${res.body}<br>
                <small  style="font-size: 10px" class="mb-0 text-left">${date.toLocaleString()}</small >
                </div>`).appendTo($('.messages ul'));

            $('.message-input input').val('');
            // $('.message-input .emoji-wysiwyg-editor').html('');
            $('.messages').animate({ scrollTop: $('.messages ul').height() }, "fast");


        }
    });



};

$('.submit').click(function() {
    newMessage();
});

$('#framechat .content .message-input ').on('keydown', function(e) {
    if (e.which == 13) {
        newMessage();
        return false;
    }
});

$('body').on('click', '.close', function () {
    if (!confirm('Подтвердите удаление')) return false;
    let $this = $(this);
    data = {'id': $this.data('id')};
    $.ajax({
        url: '/delete_message',
        type: 'get',
        data: data,
        dataType: 'json',

        success: function (res) {
            const removeItems = (number) => {
                let elements = document.querySelectorAll(`div[data-id="${number}"]`);
                elements.forEach((e) => {
                    e.remove()
                });
            };

            if (res.answer === 'ok') {
                removeItems($this.data('id'));
            }
        }
    });

});

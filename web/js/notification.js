$(document).ready(function() {
    function req(link, object, cont,id){
        $.ajax({
            url: `/web/${cont}/${link}${object}`,
            method: 'GET',
            data: {id: id},
            success: function (){
                console.log('suc');
            },
            error: function (error){
                console.log(error);
            },
        });
    }

    $('#addnotif').click(function (){
        $(this).html('Отменить заявку');
        $(this).attr("id","deletefrend");
        req('add', 'notification', 'profile',$(this).data('content'));
    });
    $('#deletenotif').click(function (){
        $(this).html('Добавить в друзья');
        $(this).attr("id","addfrend");
        req('delete', 'notification', 'profile',$(this).data('content'));
    });

    $('#addfrend').click(function (){
        req('add', 'frend', 'notification',$(this).data('content'));
    });

    $('#deletefrend').click(function (){
        req('delete', 'frend', 'notification',$(this).data('content'));
    });

    $('#decline').click(function (){
        req();
    });

    $('#w0-collapse').children("a.not").append(`<div id="count"></div>`);

    setInterval(function (){
        $.ajax({
            url: `/web/notification/unreadnot`,
            method: 'GET',
            dataType: 'json',
            success: function (data){
                $('#count').html(data.count);
                $.pjax.reload({container:"#navbar_pjax"});
                console.log(data);
            },
            error: function (error){
                console.log(error);
            },


        });
    }, 3000);
});
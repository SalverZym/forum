$(document).ready(function (){
    let date= new Date();
    let params = new URL(document.location).searchParams;
    let id = params.get("id");
    function show(id){
        $.ajax({
            url: `/web/messenger/show?id=${id}`,
            method: $(this).attr('method'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function (data){
                console.log(data);
            },
            error: function (){
                console.log('error');
            },
        });
    }

    /*setInterval(function(){
        $.ajax({
            url: `/web/messenger/show`,
            method: 'GET',
            data: {id: id},
            success: function (data){
                console.log('suc');
                $.pjax({
                    type       : 'GET',
                    url        : '/web/messenger/show',
                    container  : '#select_pjax2',
                    data       : {id: id},
                    push       : true,
                    replace    : false,
                    timeout    : 1000000000,
                    "scrollTo" : false
                });
            },
            error: function (error){
                console.log(error);
            },
        });
    }, 3000);*/

    $('#target').on('beforeSubmit', function (){
        show(id);
    });

    $('.user-container').click(function (){
        let id_user=$(this).data('id');
        $.ajax({
            url: `/web/messenger/show`,
            method: 'GET',
            data: {id: id_user},
            success: function (data){
                console.log('suc');
                $.pjax({
                    type       : 'GET',
                    url        : '/web/messenger/show',
                    container  : '#select_pjax1',
                    data       : {id: id_user},
                    push       : true,
                    replace    : false,
                    timeout    : 1000000000,
                    "scrollTo" : false
                });
            },
            error: function (error){
                console.log(error);
            },
        });
    });
});
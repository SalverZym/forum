$(document).ready(function() {
    $('.plus').on('click', function (){
        let id=$(this).data('id');
        let change=0;
        let tread_id=$(this).data('content');
        let number = $(this).next('div');
        if($(this).hasClass('active')){
             --change;
             $(this).removeClass('active');
             number.html(Number(number.html())-1);
        }else{
             ++change;
            $(this).addClass('active');
            number.html(Number(number.html())+1);
        }


        $.ajax({
            url:'/web/news/change',
            method: 'get',
            data:{id: id, change: change, treadid: tread_id},
            success: function(change){
                console.log(change);
            },
            error: function(change){
                console.log(change);

            }
        });
    });

});
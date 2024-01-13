$(document).ready(function (){
    $('#news_form').on('beforeSubmit',function (){
        $.ajax({
            url: `/web/news/news`,
            method: $(this).attr('method'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function (){
                console.log('successfull');
                $.pjax.reload('#news_form');
            },
            error: function (){
                console.log('error');
            },
        });
    });
});
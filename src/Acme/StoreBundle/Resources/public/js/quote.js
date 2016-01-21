$(function(){
    $('a#quote_block_refresh').on('click', function(e){
        e.preventDefault();
        var url, id = $('.quote_block input[type=hidden]').val();
        url = $(this).data('url');
        //console.log(url);
        $.post(url,{'id': id},function(data){
            $('.quote_block-container').html(data);
        });
    });
    
    $('#quote_author').autocompleter({
    url_list: $('#quote').parent().find('input[type=submit]').data('url'),
    url_get: $('#url_get_author').data('url')
});
});



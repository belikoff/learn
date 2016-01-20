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

    //quote_author
    //console.log($('#quote').parent().find('input[type=submit]').data('url'));
    $( "#quote_author" ).autocomplete({
      source: $('#quote').parent().find('input[type=submit]').data('url'),
      minLength: 2,
        select: function( event, ui ) {
            $('#' + $this.data('id')).val(ui.item.id);
        }
    });
});



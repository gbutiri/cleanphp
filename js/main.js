$(document).on('click','.checkme',function(e) {
    // form controls
    $this = $(this);
    if ($this.hasClass('fa-square-o')) {
        $this.removeClass('fa-square-o').addClass('fa-check-square-o');
        $('input[name="' + $this.attr('data-name') + '"]').val('on');
    } else {
        $this.removeClass('fa-check-square-o').addClass('fa-square-o');
        $('input[name="' + $this.attr('data-name') + '"]').val('off');
    }
});

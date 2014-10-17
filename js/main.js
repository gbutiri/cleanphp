var _autosave_value = '';
$(document).on('click','.checkme',function(e) {
    // form controls
    $this = $(this);
    if ($this.hasClass('fa-square-o')) {
        $this.removeClass('fa-square-o').addClass('fa-check-square-o');
        $('input[name="' + $this.attr('data-name') + '"]').prop('checked',true);
    } else {
        $this.removeClass('fa-check-square-o').addClass('fa-square-o');
        $('input[name="' + $this.attr('data-name') + '"]').prop('checked',false);
    }
}).on('click','.radiome',function(e) {
    // form controls
    $this = $(this);
    $this.parent().find('input').prop('checked',true);
    $this.parent().parent().find('.fa').removeClass('fa-check-circle').addClass('fa-circle-o');
    $this.removeClass('fa-circle-o').addClass('fa-check-circle');
});
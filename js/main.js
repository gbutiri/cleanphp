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
}).on('focus','.autoheight',function(e) {
    var $this = $(this);
    _autosave_value = $this.html();
}).on('blur','.autoheight',function(e) {
    var $this = $(this);
    $this.addClass('saving');
    // The text is here. Do whatever you want with it.
    //console.log($this.html());
    if ($this.html() != _autosave_value || $this.hasClass('error')) {
        // below code is for example only.
        var _action = $this.attr('data-action');
        $.ajax({
            url: '/modules/site/site-ajax.php?action=' + _action,
            data: 'data=' + $this.html(),
            type: 'post',
            datatype: 'json',
            success: function (d) {
                console.log(d.indexOf('does not exist'));
                if (d.indexOf('does not exist') === -1) {
                    $this.removeClass('saving').addClass('saved');
                } else {
                    $this.removeClass('saving').addClass('error');
                }
                var k = setTimeout(function () {$this.removeClass('saved error')},1000);
            }
        });
    } else {
        $this.removeClass('saving');
    }
});
(function($){
	var g_vboxlevel = 0;
	$(document).on('click','.vbox-close, .fuzz',function(e) {
		e.preventDefault();
		$.fn.vbox('close');
	}).on('click','.vbox',function(e){
		e.stopPropagation();
	}).on('keyup',function(e) {
        if (e.keyCode == 27) {
            if (g_vboxlevel > 0) {
                $.fn.vbox('close');
            }
        }
    });
    $.fn.vbox = function (action,content) {
        
        switch (action) {
            case "open":
                g_vboxlevel++;
                $('body').css({'overflow':'hidden'}).append('<div class="fuzz" id="vbox_'+g_vboxlevel+'"><table align="center" class="vbox-table"><tr><td class="vbox-cell"><div class="vbox"><div class="vbox-content">'+content+'</div><a href="#" class="vbox-close">&times;</a></div></td></tr></table></div>');
                $(document).find('#vbox_'+g_vboxlevel).animate({opacity:1},100,function() {});
                break;
            case "close":
                $(document).find('#vbox_'+g_vboxlevel).animate({opacity:0},100,function() {
                    g_vboxlevel--;
                    $(this).remove();
                    if (g_vboxlevel == 0) {
                        $('body').css({'overflow':'auto'});
                    }
                });
                break;
            case "closeall":
                $('.fuzz').remove();
                g_vboxlevel = 0;
                break;
        }
    };
}(jQuery));
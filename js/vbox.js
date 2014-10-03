(function($){
	var g_vboxlevel = 0;
	$(document).on('click','.vbox-close, .fuzz',function(e) {
		e.stopPropagation();
		e.preventDefault();
		$.fn.vbox('close');
	}).on('click','.vbox-content',function(e){
		e.stopPropagation();
	}).on('keyup',function(e) {
        if (e.keyCode == 27) {
            if (g_vboxlevel > 0) {
                $.fn.vbox('close');
            }
        }
    });
	$(window).on('resize',function(){
		$.fn.vbox('resize');
	});
	$.fn.vbox = function (action,options) {
		var settings = $.extend({
			ajaxLink: false,
			content: 'sample',
			speed: 100
		},options);
		
		
		var win = $(window);
		var winH = win.height();
		var winW = win.width();
		
		if (action == 'count') {
			return g_vboxlevel;
		}
		if (action == 'open') {
			g_vboxlevel++;
			if (settings.ajaxLink !== false) {
				$.ajax({
					url: settings.ajaxLink,
					type: 'GET',
					success: function (data) {
						settings.content = data;
						$('body').append('<div class="fuzz" id="vbox_'+g_vboxlevel+'"><div class="vbox"><div class="vbox-content"><div class="inner-content">'+settings.content+'<a data-id="'+g_vboxlevel+'" href="#" class="vbox-close">&times;</a></div></div></div></div>');
						$thisbox = $(document).find('#vbox_'+g_vboxlevel);
						settings.ajaxLink = false;
						$thisbox.animate({opacity:1},settings.speed,function(){
							$.fn.vbox('resize',settings);
						});
						$('body').find('.loading_circle').fadeOut(100,function(){$(this).remove()});
					}
				});
			};
		};
		if (action == 'close') {
			$(document).find('#vbox_'+g_vboxlevel).animate({opacity:0},settings.speed,function() {
				$(this).remove();
			});
			g_vboxlevel--;
		};
		if (action == 'closeall') {
			$(document).find('.fuzz').remove();
			g_vboxlevel = 0;
		};
		if (action == 'resize') {
			$thisbox = $(document).find('#vbox_'+g_vboxlevel);
			$thisbox.find('.inner-content, .resizable').css({'max-width':(winW - 100) + 'px'});
			$thisbox.find('.inner-content, .resizable').css({'max-height':(winH - 100) + 'px'});
		}
		
	}
}(jQuery));
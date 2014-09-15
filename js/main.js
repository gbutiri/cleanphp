$(document).on('click','.tmbtn',function(e) {
	e.preventDefault();
	var $this = $(this);
	if (!$this.hasClass('active')) {
		var _data = '';
		var _action = 'bad_call';
		var _module = 'site';
		if (typeof($this.attr('data-data')) !== 'undefined') {
			_data = $this.attr('data-data');
		}
		if (typeof($this.attr('data-action')) !== 'undefined') {
			_action = $this.attr('data-action');
		}
		if (typeof($this.attr('data-module')) !== 'undefined') {
			_module = $this.attr('data-module');
		}
		console.log($this.hasClass('isvbox'));
		if ($this.hasClass('isvbox')) {
			$.fn.vbox('open',{ajaxLink:'/modules/' + _module + '/' + _module + '-ajax.php?action='+_action});
		} else {
			$.ajax({
				url: '/modules/' + _module + '/' + _module + '-ajax.php?action='+_action,
				dataType: 'json',
				data: _data,
				type: 'post',
				success: function (data) {
					//console.log(data);
					//console.log($this.hasClass('isvbox'));
					if ($this.hasClass('isvbox')) {
						//console.log('vbox',data);
					} else {
						//console.log('notvbox',data);
						postAjax(data);
					}
				}
			});
		}
	}
});

function postAjax(d) {
	for(el in d.htmls) {
		$(el).html(d.htmls[el]);
	}
	for(el in d.appends) {
		$(el).append(d.appends[el]);
	}
	for(el in d.prepends) {
		$(el).prepend(d.prepends[el]);
	}
	for(el in d.appendsto) {
		$(el).appendTo(d.appendsto[el]);
	}
	for(el in d.updatables) {
		$(el).html(d.updatables[el]);
	}
	for(el in d.replaceables) {
		$(el).replaceWith(d.replaceables[el]);
	}
	for(el in d.removes) {
		$(document).find(d.removes[el]).remove();
	}
	for(el in d.afters) {
		$(el).after(d.afters[el]);
	}
	for(el in d.attrremoves) {
		$(el).removeAttr(d.attrremoves[el]);
	}
	for(el in d.attrchanges) {
		for (value in d.attrchanges[el]) {
			$(el).prop(value,d.attrchanges[el][value]);
		}
	}
	for(el in d.classRemoves) {
		$(el).removeClass(d.classRemoves[el]);
	}
	for(el in d.classAdds) {
		$(el).addClass(d.classAdds[el]);
	}
	if (typeof(d.closevbox) !== 'undefined') {
		$.fn.vbox('close');
	}
	if (typeof(d.js) !== 'undefined') {
		try { 
			eval(d.js);
		} catch(e) {}
	}
	if (typeof(d.redirect) !== 'undefined') {
		if (d.redirect != '') {
			window.location.href = d.redirect;
		}
	}
	
	try { 
		eval($action)(d);
	} catch(e) {
		// do nothing as the function doesn't exist.
	};
}

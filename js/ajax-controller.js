function postAjax(d) {
	for(el in d.htmls) {$(el).html(d.htmls[el]);}
	for(el in d.appends) {$(el).append(d.appends[el]);}
	for(el in d.prepends) {$(el).prepend(d.prepends[el]);}
	for(el in d.appendsto) {$(el).appendTo(d.appendsto[el]);}
	for(el in d.updatables) {$(el).html(d.updatables[el]);}
	for(el in d.replaceables) {$(el).replaceWith(d.replaceables[el]);}
	for(el in d.removes) {$(document).find(d.removes[el]).remove();}
	for(el in d.afters) {$(el).after(d.afters[el]);}
	for(el in d.attrremoves) {$(el).removeAttr(d.attrremoves[el]);}
	for(el in d.attrchanges) {for (value in d.attrchanges[el]) {$(el).prop(value,d.attrchanges[el][value]);}}
	for(el in d.classRemoves) {$(el).removeClass(d.classRemoves[el]);}
	for(el in d.classAdds) {$(el).addClass(d.classAdds[el]);}
	if (typeof(d.closevbox) !== 'undefined') {$.fn.vbox('close');}
	if (typeof(d.js) !== 'undefined') {try { eval(d.js);} catch(e) {}}
	if (typeof(d.redirect) !== 'undefined') {if (d.redirect != '') {window.location.href = d.redirect;}}
	try {eval($action)(d);} catch(e) {};
}

$(document).on('doAjaxController',function(e,$this) {
    
    var _data = '';
    var _action = 'bad_call';
    var _module = 'site';
    if (typeof($this.attr('data-data')) !== 'undefined') {_data = $this.attr('data-data');}
    if (typeof($this.attr('data-action')) !== 'undefined') {_action = $this.attr('data-action');}
    if (typeof($this.attr('data-module')) !== 'undefined') {_module = $this.attr('data-module');}

    if ($this.hasClass('ajaxform')) {
        _data = $this.serialize();
    } else {
        _data = $this.attr('data-data') ? $this.attr('data-data') : '';
    };
    var _isvbox = $this.hasClass('isvbox') ? true : false;

    $.ajax({
        url: '/modules/' + _module + '/' + _module + '-ajax.php?action='+_action,
        type: 'post',
        data: _data,
        dataType: 'json',
        success: function(data) {
            if (data.vbox) {$.fn.vbox('open',data.vbox);};
            if (data.vboxclose) {$.fn.vbox('close');};
            postAjax(data);
        }
    });
}).on('click','.tmbtn',function (e) {
    e.preventDefault();
    $(document).trigger('doAjaxController',[$(this)]);
}).on('submit','.ajaxform',function (e) {
    e.preventDefault();
    $(document).trigger('doAjaxController',[$(this)]);
});
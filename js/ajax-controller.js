var _autosave_value = '';

// function added to make jquery selects faster. (2.5x faster)
// #element find .class is much faster.
function el_split(el) {
    if (el.indexOf(" ") !== -1) {
        _split = el.split(" ");
        _first = _split[0];
        _rest = _split.slice(1).join(" ");
        return $(_first).find(_rest);
    } else {
        return $(el);
    }
}

function postAjax(d) {
	for(el in d.htmls) {el_split(el).html(d.htmls[el]);}
	for(el in d.appends) {el_split(el).append(d.appends[el]);}
	for(el in d.prepends) {el_split(el).prepend(d.prepends[el]);}
    for(el in d.appendsto) {el_split(el).appendTo(d.appendsto[el]);}
	for(el in d.replaceables) {el_split(el).replaceWith(d.replaceables[el]);}
	for(el in d.removes) {$(document).find(d.removes[el]).remove();}
	for(el in d.afters) {el_split(el).after(d.afters[el]);}
	for(el in d.attrremoves) {el_split(el).removeAttr(d.attrremoves[el]);}
	for(el in d.attrchanges) {for (value in d.attrchanges[el]) {$(el).prop(value,d.attrchanges[el][value]);}}
	for(el in d.classRemoves) {el_split(el).removeClass(d.classRemoves[el]);}
	for(el in d.classAdds) {el_split(el).addClass(d.classAdds[el]);}
    for(el in d.csselems) {el_split(el).css(d.csselems[el][0], d.csselems[el][1]);};
	if (typeof(d.closevbox) !== 'undefined') {$.fn.vbox('close');}
	if (typeof(d.js) !== 'undefined') {try { eval(d.js);} catch(e) {}}
	if (typeof(d.redirect) !== 'undefined') {if (d.redirect != '') {window.location.href = d.redirect;}}
}

$(document).on('doAjaxController',function(e,$this) {
    var _data = '';
    var _action = 'bad_call';
    var _module = 'site';
    var _do_ajax = true;
    
    if (typeof($this.attr('data-data')) !== 'undefined') {_data = $this.attr('data-data');}
    if (typeof($this.attr('data-action')) !== 'undefined') {_action = $this.attr('data-action');}
    if (typeof($this.attr('data-module')) !== 'undefined') {_module = $this.attr('data-module');}
    
    // loading circle
    $('body').append('<div id="loading-circle"><i class="fa fa-spinner fa-spin"></i><div class="loading-circle-message-wrapper"><div class="loading-circle-message">Loading...</div></div></div>');
    if (typeof($this.attr('data-loadmsg')) !== 'undefined') {_loadmsg = $this.attr('data-loadmsg');}else{_loadmsg = 'Processing ...';}
    $(document).find('#loading-circle').find('.loading-circle-message').html(_loadmsg);
    
    if ($this.hasClass('ajaxform')) {
        // if it's an ajax form
        _data = $this.serialize();
        $this.find('.err').html('');
    } else if ($this.hasClass('autosave')) {
        // if it's an autosave field...
        _data = $this.attr('name') + '=' + $this.text();
        $this.addClass('saving');
        if ($this.html() !== _autosave_value || $this.hasClass('error')) {
        } else {
            $this.removeClass('saving');
            _do_ajax = false;
        }
    } else {
        // Just an AJAX post. Get the data from data-data attribute
        _data = $this.attr('data-data') ? $this.attr('data-data') : '';
    };

    if (_do_ajax) {
        $.ajax({
            url: '/modules/' + _module + '/' + _module + '-ajax.php?action=' + _action,
            type: 'post',
            data: _data,
            dataType: 'json',
            success: function(data) {
                $('#loading-circle').remove();
                if (data.vbox) {$.fn.vbox('open',data.vbox);};
                if (data.vboxclose) {$.fn.vbox('close');};
                if ($this.hasClass('autosave')) {
                    if (!data.error) {
                        $this.removeClass('saving error').addClass('saved');
                        var k = setTimeout(function () {$this.removeClass('saved error')},500);
                         $this.parent().find('.err').html('');
                    } else {
                        $this.removeClass('saving').addClass('error');
                        $this.parent().find('.err').html(data.error);
                    }
                } else {
                    postAjax(data);
                }
            }/*,
            error: function () {
                // remove the loading circle during an error;
                $('#loading-circle').remove();
            }
            */
        });
    } else {
        $('#loading-circle').remove();
    }
}).on('click','.tmbtn',function (e) {
    e.preventDefault();
    $(document).trigger('doAjaxController',[$(this)]);
}).on('submit','.ajaxform',function (e) {
    e.preventDefault();
    $(document).trigger('doAjaxController',[$(this)]);
}).on('focus','.autosave',function(e) {
    var $this = $(this);
    _autosave_value = $this.html();
}).on('blur','.autosave',function (e) {
    e.preventDefault();
    $(document).trigger('doAjaxController',[$(this)]);
});
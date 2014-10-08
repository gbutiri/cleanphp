<!DOCTYPE html>
<html>
<head>
    <?php
    $more_css = '';
    $more_js = '';
    if (strrpos($_SERVER['SCRIPT_FILENAME'],'/modular.php') !== false) {
        // module was built in the modular.php file.
        $more_css .= ',/modules/'.$module.'/'.$module.'-main.css';
        $more_js .= ',/modules/'.$module.'/'.$module.'-main.js';
    }
    ?>
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/cache.css-/css/vbox.css,/css/main.css<?php echo $more_css; ?>" />
    
	<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src="/cache.js-/js/vbox.js,/js/ajax-controller.js,/js/main.js<?php echo $more_js; ?>"></script>
</head>

<body>
<div class="header">
	<nav>
		<ul>
			<li><a href="/">Home</a></li>
			<li><a href="/about">About</a></li>
			<li><a href="/tools/home">New Home Module</a></li>
			<li><a class="tmbtn" data-action="show_login" href="#">Login</a></li>
			<li><a class="tmbtn" data-action="show_register" data-loadmsg="Loading Registration Form" href="#">Register</a></li>
			<div class="clearfix"></div>
		</ul>
	</nav>
</div>
<div class="page">
	<div class="main-content">
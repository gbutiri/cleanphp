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
    <?php 
    //var_dump($_SERVER['SCRIPT_FILENAME']);
    $strpos_slash = strrpos($_SERVER['SCRIPT_FILENAME'],"/");
    $strpos_dot = strrpos($_SERVER['SCRIPT_FILENAME'],".");
    $length = $strpos_dot - $strpos_slash;
    $class = substr($_SERVER['SCRIPT_FILENAME'],$strpos_slash+1,$length-1);
    //var_dump($class);
    ?>
	<nav class="<?php echo $class; ?>">
		<a class="index" href="/">Home</a>
        <a class="about" href="/about">About</a>
        <a class="modular" href="/tools/home">New Home Module</a>
        
        <?php if (_USERNAME == '') { ?>
        <a class="tmbtn" data-action="show_login" href="#">Login</a>
        <a class="tmbtn" data-action="show_register" data-loadmsg="Loading Registration Form" href="#">Register</a>
        <?php } else { ?>
        <a class="profile" href="/<?php echo _USERNAME; ?>">My Profile</a>
        <a class="tmbtn" data-action="logout" href="#">Logout</a>
        <?php } ?>
        <div class="clearfix"></div>
	</nav>
</div>
<div class="page">
	<div class="main-content">
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/config.php'); /* Site Configuration */

$action = isset($_GET['action']) ? $_GET['action'] : 'bad_call';
if(function_exists($action)){call_user_func($action);}else{echo $action . " does not exist.";exit(0);}

function sample_function() {
    
    // will need to render something from templates
	include(_DOCROOT.'/modules/site/site-templates.php');
    ob_start();
    renderSampleContent();
    $htmlBack = ob_get_contents();
    ob_end_clean();
    
	echo json_encode(array(
		'success' => true,
		'message' => 'Action one',
        'htmls' => array(
            '#stuff-coming-back' => $htmlBack,
        ),
	));
}

function install() {
    global $dbi;
    include(_DOCROOT.'/inc/sql-core.php');
    include(_DOCROOT.'/html/pre-header.php');
    
    $sql = "CREATE TABLE IF NOT EXISTS signup (
        `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `email` VARCHAR(255),
        `username` VARCHAR(20),
        `password` VARCHAR(255),
        `token` VARCHAR(255),
        `salt` VARCHAR(255),
        `fname` VARCHAR(40),
        `lname` VARCHAR(40),
        `bday` TIMESTAMP,
        `created` INT,
        `lastloggedin` INT
    );";
    
    sqlRun($sql,'',array());
    
    $sql = "SELECT * FROM signup WHERE id = 1;";
    $user = sqlGet($sql,'',array());
    
	echo json_encode(array(
        'message' => 'good',
        'user' => $user,
	));
}

function sample_modal() {
	include(_DOCROOT.'/modules/site/site-templates.php');
    ob_start();
	renderSampleModal();
    $htmlBack = ob_get_contents();
    ob_end_clean();
	echo json_encode(array(
        'vbox' => $htmlBack,
	));
}

function show_form_sample () {
	include(_DOCROOT.'/modules/site/site-templates.php');
    ob_start();
	renderSampleForm();
    $htmlBack = ob_get_contents();
    ob_end_clean();
	echo json_encode(array(
        'vbox' => $htmlBack,
	));
}

function submit_sample_form () {
    
    // check for errors: example.
    $htmlsErr = array();
    if (!isset($_POST['agree'])) {
        $htmlsErr['#agree_err'] = 'You need to agree to the terms before we can continue!';
    }
    
    if (count($htmlsErr) == 0) {
        echo json_encode(array(
            'vals_out' => $_POST,
            'vboxclose' => true,
        ));
    } else {
        echo json_encode(array(
            'htmls' => $htmlsErr,
        ));
    }
}

function show_register () {
	include(_DOCROOT.'/modules/site/site-templates.php');
    ob_start();
	renderRegisterForm();
    $htmlBack = ob_get_contents();
    ob_end_clean();
	echo json_encode(array(
        'vbox' => $htmlBack,
	));
}

function show_login () {
	include(_DOCROOT.'/modules/site/site-templates.php');
    ob_start();
	renderLoginForm();
    $htmlBack = ob_get_contents();
    ob_end_clean();
	echo json_encode(array(
        'vbox' => $htmlBack,
	));
}
function process_login () {
	echo json_encode(array(
        'closevbox' => true,
        'redirect' => '/gbutiri'
	));
}

function bad_call() {
	echo json_encode(array(
		'success' => false,
		'message' => 'no function specified'
	));
}
?>
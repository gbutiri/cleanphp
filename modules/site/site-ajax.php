<?php include($_SERVER['DOCUMENT_ROOT'].'/config.php'); /* Site Configuration */

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
	echo json_encode(array(
        'vals_out' => $_POST,
        'vboxclose' => true,
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
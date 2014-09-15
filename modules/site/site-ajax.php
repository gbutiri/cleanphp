<?php include($_SERVER['DOCUMENT_ROOT'].'/config.php'); /* Site Configuration */

$action = isset($_GET['action']) ? $_GET['action'] : 'bad_call';
call_user_func($action);

function sample_function() {
	echo json_encode(array(
		'success' => true,
		'message' => 'Action one'
	));
}

function sample_modal() {
	include(_DOCROOT.'/modules/site/site-templates.php');
	renderSampleModal();
}

function bad_call() {
	echo json_encode(array(
		'success' => false,
		'message' => 'no function specified'
	));
}
?>
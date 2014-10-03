<?php include($_SERVER['DOCUMENT_ROOT'].'/config.php'); /* Site Configuration */

$action = isset($_GET['action']) ? $_GET['action'] : 'bad_call';
if(function_exists($action)){call_user_func($action);}else{echo $action . " does not exist.";exit(0);}

function bad_call() {
	echo json_encode(array(
		'success' => false,
		'message' => 'no function specified'
	));
}
?>
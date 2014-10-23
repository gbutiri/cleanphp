<?php 
include($_SERVER['DOCUMENT_ROOT'].'/config.php'); /* Site Configuration */

$action = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : 'bad_call';
if(function_exists($action)){call_user_func($action);}else{echo json_encode(array('error' => $action . " does not exist."));exit(0);}

function load_module_text () {
    echo json_encode(array(
        'htmls' => array (
            '#replace-me' => 'New stuff!'
        ),
    ));
}

function bad_call() {
	echo json_encode(array(
		'success' => false,
		'message' => 'no function specified'
	));
}
?>
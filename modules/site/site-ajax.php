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
    
    $sql_ue = '';
    
    foreach ($_POST as $key => $posted_item) {
        if ($key == 'username_email') {
            $ue = explode('_',$posted_item);
            foreach ($ue as $uei) {
                $sql_ue .= " `".$uei."` VARCHAR(255), ";
            }
        }
    }
    
    $sql_chk = array();
    if (isset($_POST['options'])) {
        foreach ($_POST['options'] as $key => $option) {
            //var_dump($key, $option);
            $parts = explode("|",$key);
            $parts2 = explode("_",$parts[0]);
            foreach ($parts2 as $part2) {
                $sql_chk[] = "`" . $part2 . "` " . $parts[1];
            }
        }
    }
    $sql_chk_string = implode(",",$sql_chk);
    
    $sql = "CREATE TABLE IF NOT EXISTS signup (
        `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        ".$sql_ue."
        `password` VARCHAR(255),
        ".$sql_chk_string."
    );";
    
    sqlRun($sql,'',array());
    unlink(_DOCROOT.'/install.php');
    
	echo json_encode(array(
        'message' => 'good',
        'sql' => $sql,
        'options' => $_POST['options'],
        'redirect' =>  '/',
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
function process_registration () {
    // check value fields.
    // create user folder.
    // create salt / tokens.
    // insert into database.
    // send out email.
    // display success message (check email, enter verification code).
    
	echo json_encode(array(
        'closevbox' => true,
        'redirect' => '/gbutiri'
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
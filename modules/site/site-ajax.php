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
    include(_DOCROOT.'/inc/sql-core.php');
    include(_DOCROOT.'/html/pre-header.php');
	include(_DOCROOT.'/inc/functions.class.php');
    $fn = new Functions();
    
    $err = false;
    
    // 1. check value fields.
    $email_check = $fn->checkEmail($_POST['email']);
    if ($email_check === false) {
        $err = true;
        $htmls['#email_err'] = 'Invalid format. Use something similar to username@domain.com';
    }
    
    $un_check = $fn->checkUsername($_POST['username']);
    if ($un_check != "") {
        $err = true;
        $htmls['#username_err'] = $un_check;
    }
    
    $pw_check = $fn->checkUsername($_POST['password']);
    if ($pw_check != "") {
        $err = true;
        $htmls['#password_err'] = $pw_check;
    }
    
    // 2. create user folder.
    
    
    // 3. create salt / tokens.
    $salt = md5($_POST['username'].time());
    $token = md5($_POST['email'].$salt);
    
    // 4. insert into database.
    $sql_u = "INSERT INTO signup (
            email,
            username,
            `password`,
            token,
            salt,
            fname,
            lname,
            bday,
            created,
            lastloggedin
        ) VALUES (
            ?,?,?,?,?,?,?,?,?,?
        )";
    sqlRun($sql_u,'ssssssssii',array(
        trim($_POST['email']),
        trim($_POST['username']),
        md5(trim($_POST['password'])),
        $token,
        $salt,
        "",
        "",
        "",
        time(),
        time()
    ));
    
    // 5. send out email.
    $to      = trim($_POST['email']);
    $subject = "Your Website Registration";
    $message = "Click this link to validate your email. Or, copy / paste this code";
    $headers = 'From: webmaster@mypersonalwebsite.com' . "\r\n" .
        'Reply-To: webmaster@mypersonalwebsite.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    //mail($to, $subject, $message, $headers);
    
    if ($err) {
        echo json_encode(array(
            'htmls' => $htmls,
        ));
    } else {
        // 6. display success message (check email or check email and enter verification code).
        
        echo json_encode(array(
            'closevbox' => true,
            'redirect' => '/gbutiri'
        ));
    }
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
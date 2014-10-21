<?php 
include($_SERVER['DOCUMENT_ROOT'].'/config.php'); /* Site Configuration */

$action = isset($_GET['action']) ? $_GET['action'] : 'bad_call';
if(function_exists($action)){call_user_func($action);}else{echo json_encode(array('error' => $action . " does not exist."));exit(0);}

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

function sample_function_split() {
	$dataBack = "Split Data";
	echo json_encode(array(
        'htmls' => array(
            '#stuff-coming-back-split .value' => $dataBack,
        ),
	));
}

function sample_function_append() {
	$dataBack = " Appended Data";
	echo json_encode(array(
        'appends' => array(
            '#stuff-coming-back-append .value' => $dataBack,
        ),
	));
}

function sample_function_prepend() {
	$dataBack = "Prepend me Data ";
	echo json_encode(array(
        'prepends' => array(
            '#stuff-coming-back-prepend .value' => $dataBack,
        ),
	));
}

function sample_function_appendto() {
	echo json_encode(array(
        'appendsto' => array(
            '#stuff-coming-back-appendthis .value' => '#stuff-coming-back-appendto',
        ),
	));
}

function sample_function_replaceable() {
	$dataBack = '<div class="solid"> Rplaceables me Data</div>';
	echo json_encode(array(
        'replaceables' => array(
            '#stuff-coming-back-replaceable .value' => $dataBack,
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
    // used for testing
    //sleep(1);
    
    $username = strtolower(trim($_POST['username']));
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    include(_DOCROOT.'/inc/sql-core.php');
    include(_DOCROOT.'/html/pre-header.php');
	include(_DOCROOT.'/inc/functions.class.php');
	include(_DOCROOT.'/modules/site/site-data.php');
    $fn = new Functions();
    
    $err = false;
    
    // 1. check value fields.
    $email_check = $fn->checkEmail($email);
    if ($email_check === false) {
        $err = true;
        $htmls['#email_err'] = 'Invalid format. Use something similar to username@domain.com';
    }
    
    $un_check = $fn->checkUsername($username);
    if ($un_check != "") {
        $err = true;
        $htmls['#username_err'] = $un_check;
    }
    
    $pw_check = $fn->checkUsername($password);
    if ($pw_check != "") {
        $err = true;
        $htmls['#password_err'] = $pw_check;
    }
    
    $existingUser = getUserByUsername($username);
    if (count($existingUser) > 0) {
        $err = true;
        $htmls['#username_err'] = "Username already exists. Try a different name.";
    }
    
    $existingUser = getUserByEmail($email);
    if (count($existingUser) > 0) {
        $err = true;
        $htmls['#email_err'] = "This email is already registered. Try a different one.";
    }
    
    
    if ($err) {
        echo json_encode(array(
            'htmls' => $htmls,
        ));
    } else {
        
        // 2. create user folder.
        $fn->makeUserFolder(strtolower($username));
        
        // 3. create salt / tokens.
        $salt = md5($username.time());
        $token = md5($email.$salt);
        
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
            $email,
            $username,
            md5($password),
            $token,
            $salt,
            "",
            "",
            "",
            time(),
            time()
        ));
        
        // 5. send out email.
        $to      = $email;
        $subject = "Your Website Registration";
        $message = "Click this link to validate your email. Or, copy / paste this code";
        $headers = 'From: webmaster@mypersonalwebsite.com' . "\r\n" .
            'Reply-To: webmaster@mypersonalwebsite.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        //mail($to, $subject, $message, $headers);
        
        // 6. Set session variables.
        $_SESSION['site_user_username'] = $username;
        $_SESSION['site_user_salt'] = $salt;
        $_SESSION['site_user_token'] = $token;

        // 7. display success message (check email or check email and enter verification code).
        echo json_encode(array(
            'closevbox' => true,
            'redirect' => $username
        ));
        /*
        echo json_encode(array(
            'closevbox' => true,
            'redirect' => strtolower(trim($_POST['username']))
        ));
        */
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
    
    $username = strtolower(trim($_POST['username']));
    $password = trim($_POST['password']);
    
    include(_DOCROOT.'/inc/sql-core.php');
    include(_DOCROOT.'/html/pre-header.php');
	include(_DOCROOT.'/inc/functions.class.php');
	include(_DOCROOT.'/modules/site/site-data.php');
    
    $fn = new Functions();
    
    $err = false;
    
    // 1. check value fields.
    $existingUser = getUserByUsernameOrEmailAndPassword($username, $password);
    if (count($existingUser) == 0) {
        $err = true;
        $htmls['#username_err'] = "Username or email and password incorrect";
    } else {
        $existingUser = $existingUser[0];
    }
    
    if ($err) {
        echo json_encode(array(
            'htmls' => $htmls,
        ));
    } else {
        $salt = md5($username.time());
        $token = md5($existingUser['email'].$salt);
        
        $_SESSION['site_user_username'] = $username;
        $_SESSION['site_user_salt'] = $salt;
        $_SESSION['site_user_token'] = $token;
        
        if (isset($_POST['rememberme']) && $_POST['rememberme'] == 'true') {
            setcookie('site_user_username', $_SESSION['site_user_username'],(10*365*24*60*60),'/') ;
            setcookie('site_user_salt', $_SESSION['site_user_salt'],(10*365*24*60*60),'/') ;
            setcookie('site_user_token', $_SESSION['site_user_token'],(10*365*24*60*60),'/') ;
        }
        
        $sql_t = "UPDATE signup SET salt = ?, token = ? WHERE username LIKE ?";
        sqlRun($sql_t,'sss',array($salt, $token, $username));
        
        
        // exit(0);
        echo json_encode(array(
            'closevbox' => true,
            'redirect' => '/'.$username
        ));
    }
}

function logout() {
    session_destroy();
    setcookie('site_user_username', '', -1000, '/');
    setcookie('site_user_salt', '', -1000, '/');
    setcookie('site_user_token', '', -1000, '/');
    echo json_encode(array(
        'redirect' => '/'
    ));
}

function bad_call() {
	echo json_encode(array(
		'success' => false,
		'message' => 'no function specified'
	));
}

function save_large_textarea() {
    echo json_encode(array(
        'saved' => true
    ));
}
?>
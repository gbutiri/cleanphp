<?php
global $dbi;
$dbi = mysqli_connect(_DBHOST,_DBUSER,_DBPASS,_DBNAME);

if (_USERNAME != '') {
    // check session token.
    $sql_s = "SELECT * FROM signup WHERE username LIKE ? AND token LIKE ?";
    $user = sqlGet($sql_s,'ss',array($_SESSION['site_user_username'],$_SESSION['site_user_token']));
    // if not equal with what's in database, redirect.
    // if equal what's in db, carry on!
    //var_dump($user);
    if (count($user) == 0) {
        session_destroy();
        setcookie("site_user_username", "", time()-3600);
        setcookie("site_user_salt", "", time()-3600);
        setcookie("site_user_token", "", time()-3600);
        header('Location: /');
    }
    //exit(0);
}
//exit(0);
?>
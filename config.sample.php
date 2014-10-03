<?php 
global $config;
define("_ENV",'local');

define("_DBHOST",'localhost');
define("_DBUSER",'root');
define("_DBPASS",'');
define("_DBNAME",'dbname');

define ("_SITE",'http://local.cleanphp.com');
define ("_DOCROOT",$_SERVER['DOCUMENT_ROOT']);
if (isset($_SESSION['site_username']) && $_SESSION['site_username'] != '') {
	define("_USERNAME",$_SESSION['site_username']);
} else {
	define("_USERNAME",null);
}
?>
<?php 
global $config;
define("_ENV",'local');

define("_DBHOST",'localhost');
define("_DBUSER",'username');
define("_DBPASS",'password');
define("_DBNAME",'dbname');

define ("_SITE",'http://dev.site.com');
define ("_DOCROOT",$_SERVER['DOCUMENT_ROOT']);
if (isset($_SESSION['site_username']) && $_SESSION['site_username'] != '') {
	define("_USERNAME",$_SESSION['actingshowcase_cdp_username']);
} else {
	define("_USERNAME",null);
}

?>
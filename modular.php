<?php include($_SERVER['DOCUMENT_ROOT'].'/config.php'); /* Site Configuration */ ?>
<?php include(_DOCROOT.'/inc/sql-core.php'); /* Database stuff */ ?>
<?php include(_DOCROOT.'/html/pre-header.php'); /* Pre Processing (logins, logouts, etc) */ ?>
<?php 
$query = $_GET['query'];
$queryBits = explode("/",$query);

$module = isset($queryBits[0]) ? $queryBits[0] : 'home';
?>
<?php include(_DOCROOT.'/html/header.php'); /* page header <head> <html> */ ?>
<?php
include (_DOCROOT.'/modules/'.$module.'/'.$module.'-index.php');
?>

<?php include(_DOCROOT.'/html/footer.php'); ?>
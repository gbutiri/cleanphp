<?php include($_SERVER['DOCUMENT_ROOT'].'/config.php'); /* Site Configuration */ ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/inc/sql-core.php'); /* Database stuff */ ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/html/pre-header.php'); /* Pre Processing (logins, logouts, etc) */ ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/html/header.php'); /* page header <head> <html> */ ?>

<h2>Profile: <?php echo $_GET['un'];?></h2>

<p>You are logged in as <?php echo _USERNAME; ?></p>

<?php include($_SERVER['DOCUMENT_ROOT'].'/html/footer.php'); ?>
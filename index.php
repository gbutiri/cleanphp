<?php 
include($_SERVER['DOCUMENT_ROOT'].'/config.php'); /* Site Configuration */ 
include($_SERVER['DOCUMENT_ROOT'].'/inc/sql-core.php'); /* Database stuff */
include($_SERVER['DOCUMENT_ROOT'].'/html/pre-header.php'); /* Pre Processing (logins, logouts, etc) */
include($_SERVER['DOCUMENT_ROOT'].'/html/header.php'); /* page header <head> <html> */
?>

<h2>Home</h2>

<a href="#" class="tmbtn isvbox" data-action="sample_modal">Try a modal with ajax</a>
<div></div>
<a href="#" class="tmbtn" data-action="sample_function">Add some dynamic content in the box below</a>
<h2>These are things</h2>
<p id="stuff-coming-back"></p>

<?php include($_SERVER['DOCUMENT_ROOT'].'/html/footer.php'); ?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/config.php'); /* Site Configuration */ ?>
<?php include(_DOCROOT.'/inc/sql-core.php'); /* Database stuff */ ?>
<?php include(_DOCROOT.'/html/pre-header.php'); /* Pre Processing (logins, logouts, etc) */ ?>
<?php include(_DOCROOT.'/html/header.php'); /* page header <head> <html> */ ?>

<h2>About</h2>

    <span class="trigger-wrapper" data-trigger="toggle">
        <a href="" class="tmbtn trigger hidden" data-action="test_toggle"><i class="fa fa-toggle-on"></i> Active</a>
        <a href="" class="tmbtn trigger" data-action="test_toggle"><i class="fa fa-toggle-off"></i> Inactive</a>
    </span>

    <div class="trigger-wrapper" data-trigger="dropdown">
        <a href="" class="tmbtn trigger" data-action="test_toggle"><i class="fa fa-ellipsis-h"></i></a>
        <div class="target hidden">
            [Content]
        </div>
    </div>


    <div class="trigger-wrapper" data-trigger="dropdown-toggle">
        <a href="" class="tmbtn trigger hidden" data-action="test_toggle"><i class="fa fa-chevron-up"></i> Show Less </a>
        <a href="" class="tmbtn trigger" data-action="test_toggle"><i class="fa fa-chevron-down"></i> Show More </a>
        <div class="target hidden">
            [Content]
        </div>
    </div>

    <div class="trigger-wrapper" data-trigger="dropdown-toggle">
        <a href="" class="tmbtn trigger hidden" data-action="test_toggle"><i class="fa fa-minus"></i> Show Less </a>
        <a href="" class="tmbtn trigger" data-action="test_toggle"><i class="fa fa-plus"></i> Show More </a>
        <div class="target hidden">
            [Content]
        </div>
    </div>


<?php include(_DOCROOT.'/html/footer.php'); ?>
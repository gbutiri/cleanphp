<?php 
include($_SERVER['DOCUMENT_ROOT'].'/config.php'); /* Site Configuration */ 
include(_DOCROOT.'/inc/sql-core.php'); /* Database stuff */
include(_DOCROOT.'/html/pre-header.php'); /* Pre Processing (logins, logouts, etc) */
include(_DOCROOT.'/html/header.php'); /* page header <head> <html> */
?>
<form class="ajaxform" data-action="install">
        <h3>Create DB</h3>
        

        <p>Will your account creation be based on: </p>
        <div class="row">
            <div class="radio">
                <input type="radio" name="username_email" value="username" checked class="hidden" />
                <i class="fa radiome fa-check-circle" data-name="username_email"></i>
                <label>Username?</label>
            </div>
            <div class="radio">
                <input type="radio" name="username_email" value="email" class="hidden" />
                <i class="fa radiome fa-circle-o" data-name="username_email"></i>
                <label>Email?</label>
            </div>
            <div class="radio">
                <input type="radio" name="username_email" value="username_email" class="hidden" />
                <i class="fa radiome fa-circle-o" data-name="username_email"></i>
                <label>Both username and email?</label>
            </div>
            <div class="err" id="radio_awesome_err"></div>
        </div>
        

        <p>Chose the features you'd like on your site: </p>
        <div class="row">
            <div class="checkbox">
                <input type="checkbox" name="options[salt_token|VARCHAR(255)]" checked value="true" class="hidden">
                <i class="fa checkme fa-check-square-o" data-name="options[salt_token|VARCHAR(255)]"></i>
                <label>Salt and Token authentication (Highly recommended)</label>
            </div>
            <div class="checkbox">
                <input type="checkbox" name="options[fname|VARCHAR(40)]" value="true" class="hidden" />
                <i class="fa checkme fa-square-o" data-name="options[fname|VARCHAR(40)]"></i>
                <label>User First Name</label>
            </div>
            <div class="checkbox">
                <input type="checkbox" name="options[lname|VARCHAR(40)]" value="true" class="hidden" />
                <i class="fa checkme fa-square-o" data-name="options[lname|VARCHAR(40)]"></i>
                <label>User Last Name</label>
            </div>
            <div class="checkbox">
                <input type="checkbox" name="options[bday|TIMESTAMP]" value="true" class="hidden" />
                <i class="fa checkme fa-square-o" data-name="options[bday|TIMESTAMP]"></i>
                <label>Birthday</label>
            </div>
            <div class="checkbox">
                <input type="checkbox" name="options[created|INT]" value="true" class="hidden" />
                <i class="fa checkme fa-square-o" data-name="options[created|INT]"></i>
                <label>Created Field</label>
            </div>
            <div class="checkbox">
                <input type="checkbox" name="options[lastloggedin|INT]" value="true" class="hidden" />
                <i class="fa checkme fa-square-o" data-name="options[lastloggedin|INT]"></i>
                <label>Last Logged In Field</label>
            </div>
            <div class="err" id="likes_err"></div>
        </div>
        <div class="row">
            <div class="">
                <input type="submit" value="Run!" />
            </div>
        </div>

</form>
<?php 

include($_SERVER['DOCUMENT_ROOT'].'/html/footer.php'); 

?>

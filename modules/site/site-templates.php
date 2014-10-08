<?php 
function renderSampleModal() {
	?>
	<h3>I have been rendered</h3>
	<?php
}

function renderSampleContent() {
    ?>
    <h3>Stuff Header</h3>
    <p>This is the content that will appear while trying to ajax it in.</p>
    <?php
}

function renderRegisterForm() {
    ?>
    <form class="ajaxform w285" data-action="process_registration" data-loadmsg="Signing you up... Please wait.">
        <h3>Register</h3>
        <div class="row">
            <div class="field-wrapper">
                <label class="arrow-right"><i class="fa fa-envelope"></i></label>
                <input type="text" placeholder="email" name="email" />
                <div class="err" id="email_err"></div>
            </div>
        </div>
        <div class="row">
            <div class="field-wrapper">
                <label class="arrow-right"><i class="fa fa-user"></i></label>
                <input type="text" placeholder="username" name="username" />
                <div class="err" id="username_err"></div>
            </div>
        </div>
        <div class="row">
            <div class="field-wrapper">
                <label class="arrow-right"><i class="fa fa-lock"></i></label>
                <input type="password" placeholder="password" name="password" />
                <div class="err" id="password_err"></div>
            </div>
        </div>
        <div class="row">
            <div class="">
                <input type="submit" value="Register" />
            </div>
        </div>
    </form>
    <?php
}

function renderLoginForm() {
    ?>
    <form class="ajaxform w285" data-action="process_login">
        <h3>Login</h3>
        <div class="row">
            <div class="field-wrapper">
                <label class="arrow-right"><i class="fa fa-user"></i></label>
                <input type="text" placeholder="username" name="username" />
                <div class="err" id="username_err"></div>
            </div>
        </div>
        <div class="row">
            <div class="field-wrapper">
                <label class="arrow-right"><i class="fa fa-lock"></i></label>
                <input type="password" placeholder="password" name="password" />
                <div class="err" id="password_err"></div>
            </div>
        </div>
        <div class="row">
            <div class="checkbox">
                <input type="checkbox" name="rememberme" value="true" class="hidden" />
                <i class="fa checkme fa-square-o" data-name="rememberme"></i>
                <label>Remember me!</label>
            </div>
        </div>
        <div class="row">
            <div class="">
                <input type="submit" value="Login" />
            </div>
        </div>
    </form>
    <?php
}

function renderSampleForm() {
    ?>
    <form class="ajaxform w285" data-action="submit_sample_form">
        <h3>Form Header</h3>
        <p>This is the content that will appear while trying to ajax it in.</p>
        <div class="row">
            <div class="field-wrapper">
                <label class="arrow-right"><i class="fa fa-user"></i></label>
                <input type="text" placeholder="text field sample" name="textfield" />
                <div class="err" id="username_err"></div>
            </div>
        </div>
        <div class="row">
            <div class="field-wrapper">
                <label class="arrow-right"><i class="fa fa-lock"></i></label>
                <input type="password" placeholder="password" name="password" />
                <div class="err" id="password_err"></div>
            </div>
        </div>
        <div class="row">
            <div class="field-wrapper">
                <label class="arrow-right"><i class="fa fa-file-text"></i></label>
                <textarea placeholder="description" name="description"></textarea>
                <div class="err" id="description_err"></div>
            </div>
        </div>
        <div class="row">
            <div class="field-wrapper">
                <label class="arrow-right"><i class="fa fa-list"></i></label>
                <select name="selectone">
                    <option value=""> - Make your selection - </option>
                    <option value="1">Clear</option>
                    <option value="2">Blue Hint</option>
                    <option value="3">Sky is falling</option>
                </select>
                <div class="err" id="selectone_err"></div>
            </div>
        </div>
        <p>Do you like... </p>
        <div class="row">
            <div class="checkbox">
                <input type="checkbox" name="likes['reading']" value="true" class="hidden">
                <i class="fa checkme fa-square-o" data-name="likes['reading']"></i>
                <label>Reading?</label>
            </div>
            <div class="checkbox">
                <input type="checkbox" name="likes['writing']" value="true" class="hidden" />
                <i class="fa checkme fa-square-o" data-name="likes['writing']"></i>
                <label>Writing?</label>
            </div>
            <div class="checkbox">
                <input type="checkbox" name="likes['singing']" value="true" class="hidden" />
                <i class="fa checkme fa-square-o" data-name="likes['singing']"></i>
                <label>Singing?</label>
            </div>
            <div class="err" id="likes_err"></div>
        </div>
        <p>Are you awesome?</p>
        <div class="row">
            <div class="radio">
                <input type="radio" name="radio_awesome" value="Yes" class="hidden" />
                <i class="fa radiome fa-circle-o" data-name="radio_awesome"></i>
                <label>Yes</label>
            </div>
            <div class="radio">
                <input type="radio" name="radio_awesome" value="No" class="hidden" />
                <i class="fa radiome fa-circle-o" data-name="radio_awesome"></i>
                <label>No</label>
            </div>
            <div class="radio">
                <input type="radio" name="radio_awesome" value="Maybe" class="hidden" />
                <i class="fa radiome fa-circle-o" data-name="radio_awesome"></i>
                <label>Maybe</label>
            </div>
            <div class="err" id="radio_awesome_err"></div>
        </div>
        <p>Terms and conditions. <a href="#">Click to read.</a></p>
        <div class="row">
            <div class="checkbox">
                <input type="checkbox" name="agree" value="true" class="hidden" />
                <i class="fa checkme fa-square-o" data-name="agree"></i>
                <label>I have read them and agree!</label>
                <div class="err" id="agree_err"></div>
            </div>
        </div>
        <p>Would you like us to remember you next time?</p>
        <div class="row">
            <div class="checkbox">
                <input type="checkbox" name="rememberme" value="true" class="hidden" />
                <i class="fa checkme fa-square-o" data-name="rememberme"></i>
                <label>Remember me!</label>
                <div class="err" id="rememberme_err"></div>
            </div>
        </div>
        <div class="row">
            <div class="">
                <input type="submit" value="Do Action" />
            </div>
        </div>
    </form>
    <?php
}
?>
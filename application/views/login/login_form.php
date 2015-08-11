<p><?= $this->session->flashdata('errmsg'); ?></p>
<?= $success == true ? 'Registration has been successful!' : '' ?>
        <div id="login">
            <fieldset><legend>Login</legend>
                
                <?= form_open('login/validate'); ?>
                <?= form_input('username'); ?>
                <?= form_password('password'); ?>
                <?= form_submit('submit', 'Login'); ?>
                <?= form_close(); ?>
                
                <?= validation_errors('<p class="validation_err">','</p>'); ?>
            </fieldset>
            <?= anchor('login/register', 'Create new account'); ?>
        </div>



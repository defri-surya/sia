<div class="wrapper">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div>
            <img src="<?php echo THEMES_BACKEND . '/images/' . CONFIG_SITE['logo_login']; ?>" <?php  ?> id="icon" <?php echo CONFIG_SITE['style_logo_login']; ?> />
            <h1 style="font-size: 20px; font-weight: bold;">LOGIN ADMINISTRATOR</h1>
        </div>

        <!-- Login Form -->
        <form name="login_form" action="<?php echo base_url() . _login_uri; ?>/verify" method="post">
            <?php
            if (isset($_SESSION['confirmation'])) {
                echo '<div id="alert-confirm" class="alert alert-danger" style="width: 85%; margin: 5px auto; text-align: left;">' . $_SESSION['confirmation'] . '</div>';
            }
            if (isset($redirect_url)) {
                if (!empty($redirect_url)) {
                    echo '<input type="hidden" name="redirect_url" value="' . $_SESSION['redirect_url'] . '">';
                }
            }
            ?>
            <input type="text" placeholder="Username" name="username" value="<?php echo $this->session->flashdata('username') != NULL ? $this->session->flashdata('username') : 'superuser'; ?>" data-validation="required">
            <input type="password" placeholder="Password" name="password" data-validation="required" value="admin">
            <?php if (ENVIRONMENT !== 'development') : ?>
                <div>
                    <img id="captcha_image" src="<?php echo site_url(_login_uri . '/captcha'); ?>" style="width:70%; margin: 5px auto;" data-validation="required">
                </div>
                <a id="captcha_reload" title="Ganti Kode Unik">
                    <i class="fa fa-refresh" style="position: absolute; bottom: 205px; right:45px; cursor:pointer;"></i>
                </a>
                <input type="text" placeholder="Kode Unik" name="captcha" id="kodeunik" autocomplete="off" aria-haspopup="true" role="textbox" data-validation="required">
            <?php endif; ?>
            <input type="submit" value="Log In">
        </form>

        <!-- Remind Passowrd -->
        <div id="formFooter">
            Copyright &copy; <?php echo date('Y') ?> <a href="#" class="underlineHover" target="_blank"><strong>PT KALA CITRA NUSWANTARA</strong></a><br>All rights reserved.
        </div>

    </div>
</div>
<div class="page-title">
    <div class="title_left">
        <h3>Ubah Password Saya</h3>
    </div>
</div>
<div class="clearfix"></div>
<?php
if ($data_profile) {
    ?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Form Ubah Password</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="response-message" class="fade in" role="alert" style="display:none"></div>
                    <form class="form-horizontal form-label-left" data-url="<?php echo site_url('profile/systems/act_password'); ?>">
                    
                        <?php
                        if ($this->session->userdata('administrator_group_type') != 'superuser') {
                            ?>
<!--                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="old_password">Old Password <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="password" name="old_password" data-validation="required length" data-validation-length="6-12" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>-->
                            <?php
                        }
                        ?>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">New Password <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="password" name="password" data-validation="required length" data-validation-length="6-12" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password_conf">Repeat New Password <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="password" name="password_conf" data-validation="required confirmation" data-validation-confirm="password" data-validation-error-msg="must be match with new password column" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Save Password</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--form validator-->
    <script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

    <script>
        $(document).ready(function () {
            
            $('form').on('submit', function (e) {
                $('form button[type="submit"]').attr('disabled', 'disabled');
                e.preventDefault();

                var urlForm = $(this).attr('data-url');
                $.ajax({
                    type: 'POST',
                    url: urlForm,
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (res) {
                        if (res.status == 200) {
                            $('form button[type="submit"]').removeAttr('disabled');
                            var message_class = 'alert alert-success';

                            $("#response-message").finish();

                            $("#response-message").addClass(message_class);
                            $("#response-message").slideDown("fast");
                            $("#response-message").html(res.data);
                            $("#response-message").delay(10000).slideUp(1000, function () {
                                $("#response-message").removeClass(message_class);
                            });
                        } else {
                            $('form button[type="submit"]').removeAttr('disabled');
                            var message_class = 'alert alert-danger';

                            $("#response-message").finish();

                            $("#response-message").addClass(message_class);
                            $("#response-message").slideDown("fast");
                            $("#response-message").html(res.msg);
                            $("#response-message").delay(10000).slideUp(1000, function () {
                                $("#response-message").removeClass(message_class);
                            });
                        }
                    },
                    error: function (err) {
                        $('form button[type="submit"]').removeAttr('disabled');
                        console.log(err);
                    }
                });
            });
            
        });
        $.validate({
            modules: 'security',
            lang: 'id'
        });
    </script>
    <?php
} else {
    echo '<div class="error alert alert-danger"><p>Sorry, data is not available.</p></div>';
}
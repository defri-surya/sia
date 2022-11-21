<div class="page-title">
    <div class="title_left">
        <h3>Ubah Profil Saya</h3>
    </div>
</div>
<div class="clearfix"></div>
<?php
if ($data_profile) {
    ?>
<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel" style="margin-bottom: 70px">
                <div class="x_title">
                    <h2>Form Ubah Profil</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="response-message" class="fade in" role="alert" style="display:none"></div>
                    <form class="form-horizontal form-label-left" data-url="<?php echo site_url('profile/systems/act_profile'); ?>">
                        <input type="hidden" name="old_image" value="<?php echo $data_profile->administrator_image; ?>">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">Username <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="username" data-validation="required alphanumeric length" data-validation-length="6-15" data-validation-allowing="-_" data-validation-help="use a-z, 0-9, minus sign and underscore" class="form-control col-md-7 col-xs-12" value="<?php echo $data_profile->administrator_username; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="name" data-validation="required" class="form-control col-md-7 col-xs-12" value="<?php echo $data_profile->administrator_name; ?>" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mobilephone">Mobile Phone <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="mobilephone" data-validation="required number length" data-validation-length="10-13" data-validation-help="example : 081234567890" class="form-control col-md-7 col-xs-12" value="<?php echo $data_profile->administrator_mobilephone; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="email" data-validation="email" data-validation-optional="true" class="form-control col-md-7 col-xs-12" value="<?php echo $data_profile->administrator_email; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Profile Picture
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <img id="preview-image" src="" border="0" alt="image" style="max-width: 250px; max-height: 250px; margin: auto; display: block">
                                <br>
                                <input type="file" name="image" id="btn-upload" data-validation="mime size" data-validation-max-size="1M" class="form-control col-md-7 col-xs-12" data-validation-allowing="jpg, jpeg, png, gif" accept=".gif, .jpg, .jpeg, .png">
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Save Profile</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        let siteUrl = '<?php echo site_url(); ?>';
        $(document).ready(function () {
            $("#btn-upload").change(function () {
                readURL(this);
            });
            
            let administrator_image = '<?php echo $data_profile->administrator_image;?>';
            let path = '<?php echo $data_profile->administrator_image_path; ?>';

            if (administrator_image !== '') {
                $('#preview-image').attr('src', `${siteUrl}${path}${administrator_image}`);
            } else {
                $('#preview-image').attr('src', '<?php echo THEMES_BACKEND . '/images/no-img.jpg'; ?>');
            }
            
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

        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#preview-image').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <!--form validator-->
    <script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

    <script>
            $.validate({
                modules: 'file',
                lang: 'id'
            });
    </script>
    <?php
} else {
    echo '<div class="error alert alert-danger"><p>Sorry, data is not available.</p></div>';
}
?>
<div class="page-title">
    <div class="title_left">
        <h3><?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div id="response_message" style="display:none;"></div>
        <table id="gridview" style="display:none;"></table>
    </div>
</div>

<?php if(privilege_view('add', $this->menu_privilege)): ?>
<!-- Modal Add -->
<div id="modal-add" class="modal fade" role="dialog">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Tambah <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></h4>
            </div>
            <form id="form-add" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body">
                    <div id="modal-response-message-add" class="alert alert-danger alert-dismissible fade in" role="alert" style="display:none"></div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="administrator_group_id">Grup <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="administrator_group_id" data-validation="required" class="form-control my-select2">
                                <option value="">--Pilih Grup--</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="username">Username <span class="required">*</span>
                        </label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" name="username" data-validation="required alphanumeric length" data-validation-length="6-15" data-validation-allowing="-_" data-validation-help="gunakan a-z, 0-9, tanda minus atau underscore" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="password">Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="password" name="password" data-validation="required length" data-validation-length="6-12" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="password_conf">Ulangi Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="password" name="password_conf" data-validation="required confirmation" data-validation-confirm="password" data-validation-error-msg="harus sama dengan kolom password" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Nama User <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" name="name" data-validation="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="mobilephone">Nomor Handphone <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" name="mobilephone" data-validation="required number length" data-validation-length="10-13" data-validation-help="example : 081234567890" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="email">Email
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" name="email" data-validation="email" data-validation-optional="true" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="image">Gambar Profil
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <img id="preview-image-add" src="" border="0" alt="image" style="max-width: 250px; max-height: 250px; margin: auto; display: block">
                            <br>
                            <input type="file" name="image" id="btn-upload-add" data-validation="mime size" data-validation-max-size="1M" class="form-control col-md-7 col-xs-12" data-validation-allowing="jpg, jpeg, png, gif" accept=".gif, .jpg, .jpeg, .png">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Simpan <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end modal add-->
<?php endif; ?>

<?php if(privilege_view('update', $this->menu_privilege)): ?>
<!-- Modal edit -->
<div id="modal-edit" class="modal fade" role="dialog">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Ubah <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></h4>
            </div>
            <form id="form-edit" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body">
                    <div id="modal-response-message-edit" class="alert alert-danger alert-dismissible fade in" role="alert" style="display:none"></div>
                    
                    <input type="hidden" name="id">
                    <input type="hidden" name="old_image">

                    <div class="form-group" id="input-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="administrator_group_id">Grup <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="administrator_group_id" data-validation="required" class="form-control col-md-7 col-xs-12 my-select2">
                                <option value="">--Pilih Grup--</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="username">Username <span class="required">*</span>
                        </label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" name="username" data-validation="required alphanumeric length" data-validation-length="6-15" data-validation-allowing="-_" data-validation-help="gunakan a-z, 0-9, tanda minus atau underscore" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Nama User <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" name="name" data-validation="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="mobilephone">Nomor Handphone <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" name="mobilephone" data-validation="required number length" data-validation-length="10-13" data-validation-help="example : 081234567890" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="email">Email
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" name="email" data-validation="email" data-validation-optional="true" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="image">Profile Picture
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <img id="preview-image-edit" src="" border="0" alt="image" style="max-width: 250px; max-height: 250px; margin: auto; display: block">
                            <br>
                            <input type="file" name="image" id="btn-upload-edit" data-validation="mime size" data-validation-max-size="1M" class="form-control col-md-7 col-xs-12" data-validation-allowing="jpg, jpeg, png, gif" accept=".gif, .jpg, .jpeg, .png">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Simpan <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end modal edit-->
<?php endif; ?>

<?php if(privilege_view('update_password', $this->menu_privilege)): ?>
<!-- Modal password -->
<div id="modal-password" class="modal fade" role="dialog">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Ubah Password <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></h4>
            </div>
            <form id="form-password" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body">
                    <div id="modal-response-message-password" class="alert alert-danger alert-dismissible fade in" role="alert" style="display:none">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <div></div>
                    </div>

                    <input type="hidden" name="id">

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="username">Username
                        </label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" name="username" class="form-control col-md-7 col-xs-12" readonly="readonly">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Nama User
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" name="name" class="form-control col-md-7 col-xs-12" readonly="readonly">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="password">Password Baru <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="password" name="password" data-validation="required length" data-validation-length="6-12" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="password_conf">Ulangi Password Baru <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="password" name="password_conf" data-validation="required confirmation" data-validation-confirm="password" data-validation-error-msg="harus sama dengan kolom password" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Simpan Password <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end modal password-->
<?php endif; ?>

<!--form validator-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<script>
    var siteUrl = '<?php echo site_url();?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    
    <?php if(privilege_view(array('add', 'update'), $this->menu_privilege)): ?>
        function readURL(input, id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview-image-' + id).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // function generate select2
        function generateSelect2(element = '.select2', data = [], nameValue, nameText, selectedValue = false, selectedName = '', placeHolder = false, placeHolderValue = '') {
            let option = placeHolder === false ? '' : `<option value="${placeHolderValue}">${placeHolder}</option>`;
            data.forEach(function (item, index){
                let strSelected = '';
                if(selectedValue !== false){
                    if (item[selectedName] == selectedValue) {
                        strSelected = `selected="selected"`;
                    }
                }
                option += `<option value="${item[nameValue]}" ${strSelected}>${item[nameText]}</option>`;
            });
            $(element).html(option).select2();
            return $(element);
        }

        // function request with ajax
        function ajaxRequest(url, method = 'GET', data = '', callback){
            $.ajax({
                url: siteUrl + url,
                method: method,
                data: data,
                dataType: 'json',
                success: function (res) {
                    callback(res);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    let res = {
                        status: 400,
                        msg: 'Gagal mendapatkan data.'
                    }
                    callback(res);
                }
            });
        }
    <?php
    endif;

    if(privilege_view('add', $this->menu_privilege)): ?>
        function addAdministrator() {
            $('#form-add').trigger("reset");
            $('#form-add').attr('data-url', siteUrl + 'administrator/user/act_add');
            $('#preview-image-add').attr('src', '<?php echo THEMES_BACKEND . '/images/no-img.jpg'; ?>');
            ajaxRequest('common/general/option/group_list', 'GET', '', function (res){
                generateSelect2('#modal-add select[name="administrator_group_id"]', res.data.results, 'administrator_group_id', 'administrator_group_title', false, '', '--Pilih Grup--', '');
            });
            $('#modal-add').modal({
                backdrop: 'static',
                keyboard: false
            }, 'show');
            $("#modal-response-message-add").finish();
        }
    <?php
    endif;

    if($is_superuser || isset($action['update'])): ?>
        function editAdministrator(id) {
            $('#form-edit').trigger("reset");
            $('#form-edit').attr('data-url', siteUrl + 'administrator/user/act_update');
            ajaxRequest('common/general/administrator/user/get_detail', 'GET', {id: id}, function(res) {
                if(res.status == 200){
                    let user = res.data;
                    $('#modal-edit input[name="id"]').val(user.administrator_id);
                    $('#modal-edit input[name="old_image"]').val(user.administrator_image);
                    $('#modal-edit input[name="username"]').val(user.administrator_username);
                    $('#modal-edit input[name="name"]').val(user.administrator_name);
                    $('#modal-edit input[name="mobilephone"]').val(user.administrator_mobilephone);
                    $('#modal-edit input[name="email"]').val(user.administrator_email);

                    if(user.administrator_id == <?php echo $_SESSION['administrator_id']; ?>){
                        $('#modal-edit input[name="administrator_group_id"]').val(user.administrator_group_id);
                        $('#input-group').hide();
                    }else{
                        $('#modal-edit input[name="administrator_group_id"]').val(user.administrator_group_id);
                        $('#input-group').show();
                        ajaxRequest('common/general/option/group_list', 'GET', '', function (res){
                            generateSelect2('#modal-edit select[name="administrator_group_id"]', res.data.results, 'administrator_group_id', 'administrator_group_title', user.administrator_group_id, 'administrator_group_id', '--Pilih Grup--', '');
                        });
                    }

                    if (user.administrator_image) {
                        $.get('<?php echo site_url(); ?>' + 'media/' + user.administrator_image_path + '250/250/' + user.administrator_image)
                        .done(function() { 
                            $('#preview-image-edit').attr('src', '<?php echo site_url(); ?>' + 'media/' + user.administrator_image_path + '250/250/' + user.administrator_image);
                        }).fail(function() { 
                            $('#preview-image-edit').attr('src', '<?php echo THEMES_BACKEND . '/images/no-img.jpg'; ?>');
                        })
                    } else {
                        $('#preview-image-edit').attr('src', '<?php echo THEMES_BACKEND . '/images/no-img.jpg'; ?>');
                    }
                    
                    $("#modal-response-message-edit").finish();
                    $('#modal-edit').modal({
                        backdrop: 'static',
                        keyboard: false
                    }, 'show');
                }else{
                    alert(res.msg);
                }
            });
        }
    <?php
    endif;

    if(privilege_view('update_password', $this->menu_privilege)): ?>
        function editPassword(id) {
            $('#form-password').trigger("reset");
            $('#form-password').attr('data-url', '<?php echo site_url('administrator/user/act_update_password'); ?>');
            ajaxRequest('common/general/administrator/user/get_detail', 'GET', {id: id}, function(res) {
                if(res.status == 200){
                    let user = res.data;
                    $('#modal-password input[name="id"]').val(user.administrator_id);
                    $('#modal-password input[name="username"]').val(user.administrator_username);
                    $('#modal-password input[name="name"]').val(user.administrator_name);
                    $('#input-group').show();
                    $("#modal-response-message-password").finish();
                    $('#modal-password').modal({
                        backdrop: 'static',
                        keyboard: false
                    }, 'show');
                }else{
                    alert(res.msg);
                }
            });
        }
    <?php endif; ?>

    $(document).ready(function () {
        $('.my-select2').select2();
        
        <?php if(privilege_view(array('add', 'update'), $this->menu_privilege)): ?>

            $('#modal-add').on('shown.bs.modal', function () {
                $('#modal-add select[name="administrator_group_id"]').select2('open');
            });

            $('#modal-edit').on('shown.bs.modal', function () {
                var userId = $('#modal-edit input[name="id"]').val();
                if(userId != <?php echo $_SESSION['administrator_id']; ?>){
                    $('#modal-edit select[name="administrator_group_id"]').select2('open');
                }else{
                    $('#modal-edit input[name="username"]').focus();
                }
            });

            $('#modal-add select[name="administrator_group_id"], #modal-edit select[name="administrator_group_id"]').on('change',function () {
                var value = $(this).val();
                if(value){
                    $(this).next().children('.selection').children('.select2-selection')
                        .removeClass('valid').removeClass('error').css('border-color', '');
                    $(this).next().next().remove();
                }
            });
        <?php
        endif;

        if(privilege_view('add', $this->menu_privilege)): ?>
            $("#btn-upload-add").change(function () {
                readURL(this, 'add');
            });

            $('#form-add').on('submit', function (e) {
                $('#form-add button[type="submit"]').attr('disabled', 'disabled');
                e.preventDefault();

                var urlForm = $('#form-add').attr('data-url');
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
                            $('#modal-add').modal('hide');
                            $('#form-add button[type="submit"]').removeAttr('disabled');
                            $('#gridview').flexReload();
                            var message_class = 'response_confirmation alert alert-success';

                            $("#response_message").finish();

                            $("#response_message").addClass(message_class);
                            $("#response_message").slideDown("fast");
                            $("#response_message").html(res.data);
                            $("#response_message").delay(10000).slideUp(1000, function () {
                                $("#response_message").removeClass(message_class);
                            });
                        } else {
                            $('#form-add button[type="submit"]').removeAttr('disabled');
                            $("#modal-response-message-add").finish();

                            $("#modal-response-message-add").slideDown("fast");
                            $('#modal-response-message-add').html(res.msg);
                            $("#modal-response-message-add").delay(10000).slideUp(1000);
                        }
                    },
                    error: function (err) {
                        $('#form-add button[type="submit"]').removeAttr('disabled');
                        console.log(err);
                    }
                });
            });
        <?php
        endif;

        if(privilege_view('update', $this->menu_privilege)): ?>
             $("#btn-upload-edit").change(function () {
                readURL(this, 'edit');
            });

            $('#form-edit').on('submit', function (e) {
                $('#form-edit button[type="submit"]').attr('disabled', 'disabled');
                e.preventDefault();

                var urlForm = $('#form-edit').attr('data-url');
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
                            $('#modal-edit').modal('hide');
                            $('#form-edit button[type="submit"]').removeAttr('disabled');
                            $('#gridview').flexReload();
                            var message_class = 'response_confirmation alert alert-success';

                            $("#response_message").finish();

                            $("#response_message").addClass(message_class);
                            $("#response_message").slideDown("fast");
                            $("#response_message").html(res.data);
                            $("#response_message").delay(10000).slideUp(1000, function () {
                                $("#response_message").removeClass(message_class);
                            });
                        } else {
                            $('#form-edit button[type="submit"]').removeAttr('disabled');
                            $("#modal-response-message-edit").finish();

                            $("#modal-response-message-edit").slideDown("fast");
                            $('#modal-response-message-edit').html(res.msg);
                            $("#modal-response-message-edit").delay(10000).slideUp(1000);
                        }
                    },
                    error: function (err) {
                        $('#form-edit button[type="submit"]').removeAttr('disabled');
                        console.log(err);
                    }
                });
            });
        <?php
        endif;

        if(privilege_view('update_password', $this->menu_privilege)): ?>
            $('#modal-password').on('shown.bs.modal', function () {
                $('#modal-password input[name="password"]').focus();
            });

            $('#form-password').on('submit', function (e) {
                $('#form-password button[type="submit"]').attr('disabled', 'disabled');
                e.preventDefault();

                var urlForm = $('#form-password').attr('data-url');
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
                            $('#modal-password').modal('hide');
                            $('#form-password button[type="submit"]').removeAttr('disabled');
                            $('#gridview').flexReload();
                            var message_class = 'response_confirmation alert alert-success';

                            $("#response_message").finish();

                            $("#response_message").addClass(message_class);
                            $("#response_message").slideDown("fast");
                            $("#response_message").html(res.data);
                            $("#response_message").delay(10000).slideUp(1000, function () {
                                $("#response_message").removeClass(message_class);
                            });
                        } else {
                            $('#form-password button[type="submit"]').removeAttr('disabled');
                            $("#modal-response-message-password").finish();

                            $("#modal-response-message-password").slideDown("fast");
                            $('#modal-response-message-password').html(res.msg);
                            $("#modal-response-message-password").delay(10000).slideUp(1000);
                        }
                    },
                    error: function (err) {
                        $('#form-password button[type="submit"]').removeAttr('disabled');
                        console.log(err);
                    }
                });
            });
        <?php endif; ?>
    });

    $("#gridview").flexigrid({
        url: '<?php echo site_url("administrator/user/get_data"); ?>',
        dataType: 'json',
        colModel: [
        <?php
        if (privilege_view('update', $this->menu_privilege)):
            echo "{display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false},";
        endif;
        if(privilege_view('update_password', $this->menu_privilege)):
            echo "{display: 'Password', name: 'password', width: 60, sortable: false, align: 'center', datasource: false},";
        endif;
        echo "
            {display: 'Status', name: 'administrator_is_active', width: 40, sortable: true, align: 'center'},
            {display: 'Username', name: 'administrator_username', width: 120, sortable: true, align: 'left'},
            {display: 'Nama', name: 'administrator_name', width: 200, sortable: true, align: 'left'},
            {display: 'Mobilephone', name: 'administrator_mobilephone', width: 120, sortable: true, align: 'left'},
            {display: 'E-Mail', name: 'administrator_email', width: 150, sortable: true, align: 'left'},
            {display: 'Grup', name: 'administrator_group_title', width: 150, sortable: true, align: 'left'},
            {display: 'Terakhir Login', name: 'administrator_last_login', width: 180, sortable: true, align: 'center'},
            ";
        ?>
        ],
        buttons: [
        <?php
        if(privilege_view('add', $this->menu_privilege)):
            echo "
                {display: 'Tambah User', name: 'add', bclass: 'add', onpress: addAdministrator},
                {separator: true},";
        endif;
        if(privilege_view(array('activate', 'deactivate', 'delete'), $this->menu_privilege)):
            echo "
                {display: 'Pilih Semua', name: 'selectall', bclass: 'selectall', onpress: check},
                {separator: true},
                {display: 'Hapus Pilihan', name: 'selectnone', bclass: 'selectnone', onpress: check},
                ";
        endif;
        if(privilege_view('activate', $this->menu_privilege)):
            echo "
                {separator: true},
                {display: 'Aktifkan', name: 'publish', bclass: 'publish', onpress: act_show, urlaction: '" . site_url("administrator/user/act_activate") . "'},";
        endif;

        if(privilege_view('deactivate', $this->menu_privilege)):
            echo "
                {separator: true},
                {display: 'Nonaktifkan', name: 'unpublish', bclass: 'unpublish', onpress: act_show, urlaction: '" . site_url("administrator/user/act_deactivate") . "'},";
        endif;

        if(privilege_view('delete', $this->menu_privilege)):
            echo "
                {separator: true},
                {display: 'Hapus User', name: 'delete', bclass: 'delete', onpress: act_show, urlaction: '" . site_url("administrator/user/act_delete") . "'},";
        endif;
        ?>
        ],
        searchitems: [
            {display: 'Status', name: 'administrator_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif'},
            {display: 'Username', name: 'administrator_username', type: 'text', isdefault: true},
            {display: 'Nama', name: 'administrator_name', type: 'text'},
            <?php if($is_superuser || $user_group == "administrator_company"):
                echo "{display: 'Grup', name: 'administrator_group_id', type: 'text'},";
            endif; ?>
            {display: 'Login Terakhir', name: 'administrator_last_login', type: 'date'},
        ],
        sortname: "administrator_id",
        sortorder: "desc",
        usepager: true,
        title: '',
        useRp: true,
        rp: 10,
        showTableToggleBtn: false,
        showToggleBtn: true,
        width: 'auto',
        height: '300',
        resizable: false,
        singleSelect: false
    });
    
    $.validate({
        modules: 'file, security',
         lang: 'id'
    });
</script>
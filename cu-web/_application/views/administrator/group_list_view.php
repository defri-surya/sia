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

<?php if(privilege_view(array('add', 'update'), $this->menu_privilege)): ?>
<!-- Modal-->
<div id="modal" class="modal fade" role="dialog">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <form id="form" class="form-horizontal form-label-left" data-url="">
                
                <input type="hidden" name="administrator_group_id">
                
                <div class="modal-body" style="overflow-y: auto; height: calc(100vh - 200px);">
                    <div id="modal-response-message" class="alert alert-danger alert-dismissible fade in" role="alert" style="display:none"></div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">Nama Grup <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="title" data-validation="required length" data-validation-length="max20" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    
                    <?php if($is_superuser || $user_group == 'administrator_company'): ?>
                        <div id="block_superuser">
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="type">Tipe Grup <span class="required">*</span>
                                </label>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <select id="input-group-type" name="type" data-validation="required" class="form-control my-select2">
                                        <option value="">--Pilih Grup--</option>
                                        <option value="administrator_company">Administrator Perusahaan</option>
                                        <option value="administrator_branch">Administrator Unit</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" id="container-branch">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="branch">Nama Unit <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="group-branch" name="branch" data-validation="required" class="form-control my-select2">
                                        <option value="">--Pilih Unit--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div id="privilege_menu" class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="allitem">Hak Akses
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="checkbox">
                                <label>
                                    <?php echo form_checkbox(array('name' => 'allmenu', 'checked' => false, 'value' => true, 'id' => 'allmenu')); ?> <strong>Select All</strong>
                                </label>
                            </div>
                            <?php
                            // cari root menu
                            if (array_key_exists('0', $arr_menu_privilege)) {
                                echo '<div id="block_menu">';

                                // urutkan root menu berdasarkan menu_order_by
                                ksort($arr_menu_privilege[0]);

                                // ekstrak root menu
                                foreach ($arr_menu_privilege[0] as $rootmenu_sort => $rootmenu_value) {

                                    $rootmenu_checkbox_data = array();
                                    $rootmenu_checkbox_data['name'] = 'menu[]';
                                    $rootmenu_checkbox_data['id'] = 'menu_' . $rootmenu_value->administrator_menu_id ;
                                    $rootmenu_checkbox_data['value'] = $rootmenu_value->administrator_menu_id;
                                    $rootmenu_checkbox_data['checked'] = FALSE;
                                    $rootmenu_checkbox_data['class'] = 'menu_item menu-lev-1';

                                    echo '<div class="checkbox" style="margin:10px 0 10px 25px;"><label>' . form_checkbox($rootmenu_checkbox_data) . '&nbsp;<strong style="color: #26b99a;">' . $rootmenu_value->administrator_menu_title . '</strong></label></div>';

                                    // cari submenu 1
                                    if (array_key_exists($rootmenu_value->administrator_menu_id, $arr_menu_privilege)) {
                                        echo '<div id="block_menu_' . $rootmenu_value->administrator_menu_id . '">';

                                        // urutkan submenu 1 berdasarkan menu_order_by
                                        ksort($arr_menu_privilege[$rootmenu_value->administrator_menu_id]);

                                        // ekstrak submenu 1 yang par_id adalah menu_id dari root menu
                                        foreach ($arr_menu_privilege[$rootmenu_value->administrator_menu_id] as $submenu_1_sort => $submenu_1_value) {

                                            $submenu_1_checkbox_data = array();
                                            $submenu_1_checkbox_data['name'] = 'menu[]';
                                            $submenu_1_checkbox_data['id'] = 'menu_' . $submenu_1_value->administrator_menu_id;
                                            $submenu_1_checkbox_data['value'] = $submenu_1_value->administrator_menu_id;
                                            $submenu_1_checkbox_data['checked'] = FALSE;
                                            $submenu_1_checkbox_data['class'] = 'menu_item menu-lev-2';

                                            echo '<div class="checkbox" style="margin:0 0 5px 50px;"><label>' . form_checkbox($submenu_1_checkbox_data) . '&nbsp;<strong style="color: #26b99a;">' . $submenu_1_value->administrator_menu_title . '</strong></label></div>';
                                            
                                            // cari submenu 2
                                            if (array_key_exists($submenu_1_value->administrator_menu_id, $arr_menu_privilege)) {
                                                echo '<div id="block_menu_' . $submenu_1_value->administrator_menu_id . '">';

                                                // urutkan submenu 2 berdasarkan menu_order_by
                                                ksort($arr_menu_privilege[$submenu_1_value->administrator_menu_id]);

                                                // ekstrak submenu 2 yang par_id adalah menu_id dari sub menu 1
                                                foreach ($arr_menu_privilege[$submenu_1_value->administrator_menu_id] as $submenu_2_sort => $submenu_2_value) {

                                                    $submenu_2_checkbox_data = array();
                                                    $submenu_2_checkbox_data['name'] = 'menu[]';
                                                    $submenu_2_checkbox_data['id'] = 'menu_' . $submenu_2_value->administrator_menu_id;
                                                    $submenu_2_checkbox_data['value'] = $submenu_2_value->administrator_menu_id;
                                                    $submenu_2_checkbox_data['checked'] = FALSE;
                                                    $submenu_2_checkbox_data['class'] = 'menu_item';

                                                    echo '<div class="checkbox" style="margin:0 0 5px 75px;"><label>' . form_checkbox($submenu_2_checkbox_data) . '&nbsp;<strong style="color: #26b99a;">' .  $submenu_2_value->administrator_menu_title . '</strong></label></div>';

                                                    // cari submenu 3
                                                    if (array_key_exists($submenu_2_value->administrator_menu_id, $arr_menu_privilege)) {
                                                        echo '<div id="block_menu_' . $submenu_2_value->administrator_menu_id . '">';

                                                        // urutkan submenu 3 berdasarkan menu_order_by
                                                        ksort($arr_menu_privilege[$submenu_2_value->administrator_menu_id]);

                                                        // ekstrak submenu 3 yang par_id adalah menu_id dari sub menu 2
                                                        foreach ($arr_menu_privilege[$submenu_2_value->administrator_menu_id] as $submenu_3_sort => $submenu_3_value) {
                                                            $submenu_3_checkbox_data = array();
                                                            $submenu_3_checkbox_data['name'] = 'menu[]';
                                                            $submenu_3_checkbox_data['id'] = 'menu_' . $submenu_3_value->administrator_menu_id;
                                                            $submenu_3_checkbox_data['value'] = $submenu_3_value->administrator_menu_id;
                                                            $submenu_3_checkbox_data['checked'] = FALSE;
                                                            $submenu_3_checkbox_data['class'] = 'menu_item menu-lev-2';

                                                            echo '<div class="checkbox" style="margin:0 0 5px 100px;"><label>' . form_checkbox($submenu_3_checkbox_data) . '&nbsp;<strong style="color: #26b99a;">' .  $submenu_3_value->administrator_menu_title . '</strong></label></div>';
                                                            
                                                            $arr_act = array();
                                                            $arr_act = json_decode($submenu_3_value->results);

                                                            $str_html_act = '';
                                                            if (!empty($arr_act)) {
                                                                $str_html_act .= '<div id="block_act_menu_' . $submenu_3_value->administrator_menu_id . '" class="act_block"><div class="checkbox" style="margin:0 0 5px 125px;">';

                                                                $tag_br = '';
                                                                $no = 0;
                                                                foreach ($arr_act as $key => $value) {
                                                                    $checkbox_act = array();
                                                                    $checkbox_act['name'] = 'action[' . $submenu_3_value->administrator_menu_id . '][]';
                                                                    $checkbox_act['id'] = 'action-' . $submenu_3_value->administrator_menu_id . '-' . $no;
                                                                    $checkbox_act['value'] = $value->name;
                                                                    $checkbox_act['checked'] = FALSE;
                                                                    $checkbox_act['class'] = 'act_menu_item menu-lev-3';

                                                                    $str_html_act .= $tag_br . '<label>' . form_checkbox($checkbox_act) . '&nbsp;' . $value->title . '</label>';
                                                                    $tag_br = '<br>';
                                                                    $no++;
                                                                }
                                                                $str_html_act .= '</div></div>';
                                                            }
                                                            echo $str_html_act;
                                                        }
                                                        echo '</div>';
                                                    } else {
                                                        $arr_act = array();
                                                        $arr_act = json_decode($submenu_2_value->results);

                                                        $str_html_act = '';
                                                        if (!empty($arr_act)) {
                                                            $str_html_act .= '<div id="block_act_menu_' . $submenu_2_value->administrator_menu_id . '" class="act_block"><div class="checkbox" style="margin:0 0 5px 100px;">';

                                                            $tag_br = '';
                                                            $no = 0;
                                                            foreach ($arr_act as $key => $value) {
                                                                $checkbox_act = array();
                                                                $checkbox_act['name'] = 'action[' . $submenu_2_value->administrator_menu_id . '][]';
                                                                $checkbox_act['id'] = 'action-' . $submenu_2_value->administrator_menu_id . '-' . $no;
                                                                $checkbox_act['value'] = $value->name;
                                                                $checkbox_act['checked'] = FALSE;
                                                                $checkbox_act['class'] = 'act_menu_item menu-lev-3';

                                                                $str_html_act .= $tag_br . '<label>' . form_checkbox($checkbox_act) . '&nbsp;' . $value->title . '</label>';
                                                                $tag_br = '<br>';
                                                                $no++;
                                                            }
                                                            $str_html_act .= '</div></div>';
                                                        }
                                                        echo $str_html_act;
                                                    }
                                                }
                                                echo '</div>';
                                            }else{
                                                $arr_act = array();
                                                $arr_act = json_decode($submenu_1_value->results);

                                                $str_html_act = '';
                                                if (!empty($arr_act)) {
                                                    $str_html_act .= '<div id="block_act_menu_' . $submenu_1_value->administrator_menu_id . '" class="act_block"><div class="checkbox" style="margin:0 0 5px 75px;">';

                                                    $tag_br = '';
                                                    $no = 0;
                                                    foreach ($arr_act as $key => $value) {
                                                        $checkbox_act = array();
                                                        $checkbox_act['name'] = 'action[' . $submenu_1_value->administrator_menu_id . '][]';
                                                        $checkbox_act['id'] = 'action-' . $submenu_1_value->administrator_menu_id . '-' . $no;
                                                        $checkbox_act['value'] = $value->name;
                                                        $checkbox_act['checked'] = FALSE;
                                                        $checkbox_act['class'] = 'act_menu_item menu-lev-3';

                                                        $str_html_act .= $tag_br . '<label>' . form_checkbox($checkbox_act) . '&nbsp;' . $value->title . '</label>';
                                                        $tag_br = '<br>';
                                                        $no++;
                                                    }
                                                    $str_html_act .= '</div></div>';
                                                }
                                                echo $str_html_act;
                                            }
                                        }
                                        echo '</div>';
                                    }else{
                                        $arr_act = array();
                                        $arr_act = json_decode($rootmenu_value->results);

                                        $str_html_act = '';
                                        if (!empty($arr_act)) {
                                            $str_html_act .= '<div id="block_act_menu_' . $rootmenu_value->administrator_menu_id . '" class="act_block"><div class="checkbox" style="margin:0 0 5px 50px;">';

                                            $tag_br = '';
                                            $no = 0;
                                            foreach ($arr_act as $key => $value) {
                                                $checkbox_act = array();
                                                $checkbox_act['name'] = 'action[' . $rootmenu_value->administrator_menu_id . '][]';
                                                $checkbox_act['id'] = 'action-' . $rootmenu_value->administrator_menu_id . '-' . $no;
                                                $checkbox_act['value'] = $value->name;
                                                $checkbox_act['checked'] = FALSE;
                                                $checkbox_act['class'] = 'act_menu_item menu-lev-3';

                                                $str_html_act .= $tag_br . '<label>' . form_checkbox($checkbox_act) . '&nbsp;' . $value->title . '</label>';
                                                $tag_br = '<br>';
                                                $no++;
                                            }
                                            $str_html_act .= '</div></div>';
                                        }
                                        echo $str_html_act;
                                    }
                                }
                                echo '</div>';
                            }
                            ?>
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
<!--end modal-->
<?php endif; ?>

<!--form validator-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<script>
    var siteUrl = '<?php echo site_url();?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    
    <?php if (privilege_view('add', $this->menu_privilege)) : ?>
        function addAdministratorGroup() {
            $('#form').trigger("reset");
            $('select[name="type"]').val('').change();
            $('select[name="branch"]').val('').change();
            $('input:checkbox').removeAttr('checked');
            $('input.act_menu_item').prop('checked', false).removeAttr('disabled');
            $('#modal .modal-title').text('Form Tambah ' + menuName);
            $("#response_message").finish();
            $('#container-branch').hide();
            $('.act_block').hide();
            $('#form').attr('data-url', siteUrl + 'administrator/group/act_add');
            $('#privilege_menu').show();
            <?php if($is_superuser || $user_group == "administrator_company"): ?>
                ajaxRequest('common/general/option/branch', 'GET', {id: 1}, function(res_branch) {
                    generateSelect2('select[name="branch"]', res_branch.data.results, 'branch_id', 'branch_name', false, '', '--Pilih Unit--', placeHolderValue = '');
                });
                $('#block_superuser').show();
            <?php endif; ?>
            $('#modal').modal({
                backdrop: 'static',
                keyboard: false
            }, 'show');
        }
    <?php endif;

    if (privilege_view('update', $this->menu_privilege)) : ?>

        function editAdministratorGroup(id) {
            $('#form').trigger("reset");
            $('select[name="type"]').val('').change();
            $('select[name="branch"]').val('').change();
            $('input:checkbox').removeAttr('checked');
            $('input.act_menu_item').prop('checked', false).removeAttr('disabled');
            $('#modal .modal-title').text('Form Ubah ' + menuName);
            $('#form input[name="administrator_group_id"]').val(id);
            $('#form').attr('data-url', siteUrl + 'administrator/group/act_update');
            $("#response_message").finish();
            $('.act_block').hide();
            <?php if($is_superuser || $user_group == 'administrator_company') : ?>
                $('#block_superuser').show();
            <?php endif; ?>
            ajaxRequest('common/general/administrator/group/get_detail', 'GET', {id: id}, function(res) {
                if(res.status == 200){
                    let group = res.data.data;
                    $('#modal input[name="title"]').val(group.administrator_group_title);
                    <?php if($is_superuser || $user_group == 'administrator_company'): ?>
                        if(group.administrator_group_type !== 'superuser' || group.administrator_group_type !== 'administrator_company'){
                            $('#block_superuser').show();
                            $('select[name="type"]').val(group.administrator_group_type).change();
                            ajaxRequest('common/general/option/branch', 'GET', {id: group.administrator_group_company_id}, function(res_branch) {
                                generateSelect2('select[name="branch"]', res_branch.data.results, 'branch_id', 'branch_name', group.administrator_group_branch_id, 'branch_id', '--Pilih Unit--', placeHolderValue = '');
                            });
                        }else{
                            $('#block_superuser').hide();
                        }
                    <?php endif; ?>
                        
                    if(group.administrator_group_id == <?php echo $_SESSION['administrator_group_id']; ?>){
                        $('#privilege_menu').hide();
                        $('#block_superuser').hide();
                    }else{
                        if(res.data.arr_checked_menu.length > 0){
                            $.each(res.data.arr_checked_menu, function (key, value) {
                                $('#menu_' + value.id).prop('checked', true);
                                if(value.act){
                                    $.each(value.act, function (k, v) {
                                        if(v === 'show'){
                                            $('#block_act_menu_' + value.id + ' input[type="checkbox"][value="' + v + '"]').prop('checked', true).attr('disabled', 'disabled');
                                        }else{
                                            $('#block_act_menu_' + value.id + ' input[type="checkbox"][value="' + v + '"]').prop('checked', true);
                                        }
                                    });
                                    $('#block_act_menu_' + value.id).show();
                                }
                            });
                        }
                        $('#privilege_menu').show();
                    }
                    $('#modal').modal({
                        backdrop: 'static',
                        keyboard: false
                    }, 'show');
                }else{
                    alert(res.msg);
                    $('#gridview').flexReload();
                }
            });
        }
    <?php endif; ?>

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

    $(document).ready(function () {
        $('.my-select2').select2({
//            dropdownParent: $('#modal')
        });
        
        <?php if (privilege_view(array('add', 'update'), $this->menu_privilege)) : ?>
            $('#modal').on('shown.bs.modal', function () {
                $('input[name="title"]').focus();
            });
        
            $("#privilege_menu .menu_item").on('change',function () {
                var id = $(this).attr('id');
                if ($("#" + id).is(':checked')) {
                    var parents = $(this).parent().parent().parent();

                    while (parents.attr('id') != 'block_menu' && id != 'block_menu') {
                        var parent_id = parents.attr('id');
                        $("#menu_" + parent_id.replace('block_menu_', '')).prop('checked', true);
                        parents = parents.parent();
                    }
                    //change child all item checked
                    $("#block_" + id + " .menu_item").prop('checked', true).change();
                    $('#block_act_'+id+' input[value="show"]').prop('checked', true).attr('disabled', 'disabled');
                    $('#block_act_'+id).show();
                } else {
                    var parents = $(this).parent().parent().parent();
                    if(parents.attr('id') != 'block_menu' && id != 'block_menu'){
                        var parent_id = parents.attr('id');
                        var countChild = $('#' + parent_id + ' .menu_item:checked').length;
                        if(countChild == 0){
                            $("#menu_" + parent_id.replace('block_menu_', '')).prop('checked', false);
                        }
                    }
                    //change child all item unchecked
                    $("#block_" + id + " .menu_item").prop('checked', false).change();
                    $('#block_act_'+id+' input').prop('checked', false).removeAttr('disabled');
                    $('#block_act_'+id).hide();
                }
            });
        
            $("#privilege_menu .act_menu_item").on('change',function () {
                var id = $(this).attr('id');
                var splitId = id.split('-');
                if ($("#" + id).is(':checked')) {
                        $("#menu_"+splitId[1]).prop('checked', true).change();
                        if($('#'+id).val() === 'show'){
                            $('#'+id).attr('disabled', 'disabled');
                        }

                        var parents = $("#menu_"+splitId[1]).parent().parent().parent();
                        while (parents.attr('id') != 'block_menu' && id != 'block_menu') {
                            var parent_id = parents.attr('id');
                            $("#menu_" + parent_id.replace('block_menu_', '')).prop('checked', true);
                            parents = parents.parent();
                        }

                } else {
                    $('#'+id).removeAttr('disabled');
                }
            });
        
            $("#allmenu").on('change',function () {
                $statusChecked =  $(this).is(':checked') ? true : false;
                $('#block_menu .menu_item').prop('checked', $statusChecked).change();
                $('#block_menu .act_menu_item').prop('checked', $statusChecked).change();
            });
            
            $("#privilege_menu .menu-lev-1").on('click', (event) => {
                $statusChecked =  $(event.currentTarget).is(':checked') ? true : false;
                $(event.currentTarget).closest('div').next().find('.menu-lev-2').prop('checked', $statusChecked).change();
                $(event.currentTarget).closest('div').next().find('.menu-lev-3').prop('checked', $statusChecked).change();
            });

            $("#privilege_menu .menu-lev-2").on('click', (event) => {
                $statusChecked =  $(event.currentTarget).is(':checked') ? true : false;
                $(event.currentTarget).closest('div').next().find('.menu-lev-3').prop('checked', $statusChecked).change();
            });
            
            
            $('#input-group-type').on('change', function() {
                $('#container-branch').hide();
                let value = $(this).val();
                if(value && value == 'administrator_branch'){
                    $('#container-branch').show();
                }
            });
        <?php endif;

        if ($is_superuser || $user_group == 'administrator_company') : ?>
            $('select[name="type"]').on('change',function () {
                let value = $(this).val();
                if(value){
                     $(this).next().children('.selection').children('.select2-selection')
                        .removeClass('valid').removeClass('error').css('border-color', '');
                    $(this).next().next().remove();
                }
            });
        
            $('select[name="branch"]').on('change',function () {
                let value = $(this).val();
                if(value){
                    $(this).next().children('.selection').children('.select2-selection')
                        .removeClass('valid').removeClass('error').css('border-color', '');
                    $(this).next().next().remove();
                }
            });
            
        <?php endif;

        if (privilege_view(array('add', 'update'), $this->menu_privilege)) : ?>
            $('#form').on('submit', function (e) {
                $('#form button[type="submit"]').attr('disabled', 'disabled');
                e.preventDefault();
                var urlForm = $(this).attr('data-url');
                $.ajax({
                    type: 'POST',
                    url: urlForm,
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: function (res) {
                        if (res.status == 200) {
                            $('#modal').modal('hide');
                            $('#form button[type="submit"]').removeAttr('disabled');
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
                            $('#modal').scrollTop('0px');
                            $('#form button[type="submit"]').removeAttr('disabled');
                            $("#modal-response-message").finish();

                            $("#modal-response-message").slideDown("fast");
                            $('#modal-response-message').html(res.msg);
                            $("#modal-response-message").delay(10000).slideUp(1000);
                        }
                    },
                    error: function (err) {
                        $('#form button[type="submit"]').removeAttr('disabled');
                        console.log(err);
                    }
                });
            });   
        <?php endif; ?>
    });
    
    $("#gridview").flexigrid({
        url: '<?php echo site_url("administrator/group/get_data"); ?>',
        dataType: 'json',
        colModel: [
            <?php if (privilege_view('update', $this->menu_privilege)):
                echo "{display: 'Ubah', name: 'edit', width: 40, sortable: false, datasource: false, align: 'center'},";
            endif;
            echo "  
                {display: 'Status', name: 'administrator_group_is_active', width: 40, sortable: true, align: 'center'},
                {display: 'Nama Grup', name: 'administrator_group_title', width: 250, sortable: true, align: 'left'},
                ";
            if($is_superuser || $user_group == 'administrator_company'):
                echo "{ display: 'Nama Unit', name: 'branch_name', width: 200, sortable: true, align: 'left'},";
            endif;
            if ($is_superuser || $user_group == 'administrator_company'):
                echo "{display: 'Tipe Grup', name: 'administrator_group_type', width: 150, sortable: true, align: 'center'},";
            endif; ?>
        ],
        buttons: [
            <?php if (privilege_view('add', $this->menu_privilege)):
                echo "
                    {display: 'Tambah Grup', name: 'add', bclass: 'add', onpress: addAdministratorGroup},
                    {separator: true },
                    ";
            endif;
            if (privilege_view(array('update', 'delete', 'activate', 'deactivate'), $this->menu_privilege)) :
                echo "
                    {display: 'Pilih Semua', name: 'selectall', bclass: 'selectall', onpress: check},
                    {separator: true},
                    {display: 'Hapus Pilihan', name: 'selectnone', bclass: 'selectnone', onpress: check},
                    ";
            endif;
            if (privilege_view('activate', $this->menu_privilege)):
                echo "
                    {separator: true},
                    {display: 'Aktifkan', name: 'publish', bclass: 'publish', onpress: act_show, urlaction: '" . site_url("administrator/group/act_activate") . "'},";
            endif;
            if(privilege_view('deactivate', $this->menu_privilege)):
                echo "
                    {separator: true},
                    {display: 'Nonaktifkan', name: 'unpublish', bclass: 'unpublish', onpress: act_show, urlaction: '" . site_url("administrator/group/act_deactivate") . "'},
                    ";
            endif;
            if (privilege_view('delete', $this->menu_privilege)):
                echo "
                    {separator: true},
                    {display: 'Hapus Grup', name: 'delete', bclass: 'delete', onpress: act_show, urlaction: '" . site_url("administrator/group/act_delete") . "'},";
            endif; ?>
        ],
        searchitems: [
            <?php
            echo "
                {display: 'Status', name: 'administrator_group_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif'},
                {display: 'Nama Grup', name: 'administrator_group_title', type: 'text'},
                ";
            if($is_superuser || $user_group == 'administrator_company'):
                echo "{display: 'Nama Unit', name: 'branch_name', type: 'text'},";
            endif;
            if ($is_superuser || $user_group == 'administrator_company'):
                $str_list_superuser = "";
                if($is_superuser){
                    $str_list_superuser = "superuser:Super User|";
                }
                echo "{display: 'Tipe Grup', name: 'administrator_group_type', type: 'select', option: '" . $str_list_superuser . "administrator_company:Administrator Perusahaan|administrator_branch:Administrator Unit'},";
            endif;
            ?>
        ],
        sortname: "administrator_group_id",
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
        modules: 'logic',
        lang: 'id'
    });
</script>

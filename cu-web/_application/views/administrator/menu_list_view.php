<div class="page-title">
    <div class="title_left">
        <h3 id="title"><?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div id="response_message" style="display:none;"></div>
        <div id="place-grid">
            <table id="gridview" style="display:none;"></table>
        </div>

    </div>
</div>

<?php if (privilege_view(array('add', 'update'), $this->menu_privilege)) : ?>
    <!-- Modal -->
    <div id="modal" class="modal fade" role="dialog">
        <div class="custom-loading"><span></span></div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <form id="form" class="form-horizontal form-label-left" data-url="">
                    <div class="modal-body">
                        <div id="modal-response-message" class="alert alert-danger alert-dismissible fade in" role="alert" style="display:none"></div>

                        <input type="hidden" name="par_id" value="">
                        <input type="hidden" name="id" value="">
                        <div id="choose-parent" class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="parent">Menu Parent <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="parent" data-validation="required" class="form-control">
                                    <option value="">--Choose Parent--</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">Menu Title <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="title" class="form-control" data-validation="required length" data-validation-length="max50">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="description">Description
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <textarea name="description" class="form-control" data-validation="length" data-validation-optional="true" data-validation-length="max255" data-validation-help="information when pointer hover"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="link">Menu Link <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" name="link" class="form-control" data-validation="required length" data-validation-length="max255">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="class">Icon Class
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12 row">
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                    <input type="text" name="class" class="form-control" data-validation="length" data-validation-optional="true" data-validation-length="max50" data-validation-help="example : fa fa-laptop">
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <span id="preview-class" class="text-center" style="font-size: 20px; display: block"><i class=""></i></span>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <u><a href="<?php echo site_url('administrator/menu/get_ref_class_icon'); ?>" target="_blank">icon class reference?</a></u>
                                </div>
                            </div>
                        </div>

                        <?php
                        if (!empty($query_action)) {
                        ?>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="action">Hak Akses
                                </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php
                                    foreach ($query_action as $value) {
                                    ?>
                                        <div class="checkbox col-md-6 col-sm-6 col-xs-12">
                                            <label><input id="action-<?php echo $value->name ?>" type="checkbox" name="action[]" value='{"name": "<?php echo $value->name ?>","title": "<?php echo $value->title ?>"}' <?php echo ($value->name == 'show' ? 'disabled="disabled" checked="checked"' : '') ?>>&nbsp;<?php echo $value->title ?></label>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

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

<script>
    //--------Globals----------
    var myTitle = '';
    //-------------------------

    function getMenu(id, title) {
        let uri = 'show';

        if (id > 0) {
            myTitle = 'Sub Menu';
            $('.breadcrumb .active').html('<a href="javascript:;" onclick="getMenu(0, \'<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>\')"><?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></a>').attr('class', '');
            $('.breadcrumb').append('<li class="active" id="bc-submenu">Sub Menu ' + title + '</li>');
            $('#title').text('Sub Menu "' + title + '"');
            <?php if (privilege_view(array('add', 'update'), $this->menu_privilege)) : ?>
                $('span.select2').remove();
                $('#choose-parent').show();
            <?php endif; ?>
            let strBtoa = `${id}||${title}`;
            uri = 'show?data=' + b64EncodeUnicode(strBtoa);
        } else {
            myTitle = 'Menu';
            $('#bc-submenu').remove();
            $('.breadcrumb li:last-child').attr('class', 'active').text('<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>');
            $('#title').text(title);
            <?php if (privilege_view(array('add', 'update'), $this->menu_privilege)) : ?>
                $('span.select2').remove();
                $('#choose-parent').hide();
            <?php endif; ?>
        }
        window.history.replaceState({}, '', uri);
        $('input[name="par_id"]').val(id);

        $('div.formModalFilter').remove();
        $("#place-grid").empty();
        $("#place-grid").append('<table id="gridview" style="display:none"></table>');

        var col = [
            <?php if (privilege_view('update', $this->menu_privilege)) : ?> {
                    display: 'Ubah',
                    name: 'edit',
                    width: 40,
                    sortable: false,
                    align: 'center',
                    datasource: false
                },
            <?php endif; ?> {
                display: 'Status',
                name: 'administrator_menu_is_active',
                width: 40,
                sortable: false,
                align: 'center'
            },
            {
                display: 'Icon',
                name: 'administrator_menu_class',
                width: 40,
                sortable: false,
                align: 'center',
                datasource: false
            },
            {
                display: 'Nama Menu',
                name: 'administrator_menu_title',
                width: 200,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Link',
                name: 'administrator_menu_link',
                width: 500,
                sortable: true,
                align: 'left'
            },
        ];
        if (id == 0) {
            col.splice(<?php echo (privilege_view('update', $this->menu_privilege)) ? '1' : '0'; ?>, 0, {
                display: 'Sub',
                name: 'submenu',
                width: 40,
                sortable: false,
                align: 'center',
                datasource: false
            });
        }

        $("#gridview").flexigrid({
            url: '<?php echo site_url('administrator/menu/get_data/'); ?>' + id,
            dataType: 'json',
            colModel: col,
            buttons: [
                <?php if (privilege_view('add', $this->menu_privilege)) : ?> {
                        display: 'Tambah Menu',
                        name: 'add',
                        bclass: 'add',
                        onpress: addMenu
                    },
                    {
                        separator: true
                    },
                <?php endif; ?> {
                    display: 'Pilih Semua',
                    name: 'selectall',
                    bclass: 'selectall',
                    onpress: check
                },
                {
                    separator: true
                },
                {
                    display: 'Hapus Pilihan',
                    name: 'selectnone',
                    bclass: 'selectnone',
                    onpress: check
                },
                {
                    separator: true
                },
                {
                    display: 'Aktifkan',
                    name: 'publish',
                    bclass: 'publish',
                    onpress: act_show,
                    urlaction: '<?php echo site_url('administrator/menu/act_activate'); ?>'
                },
                {
                    separator: true
                },
                {
                    display: 'Nonaktifkan',
                    name: 'unpublish',
                    bclass: 'unpublish',
                    onpress: act_show,
                    urlaction: '<?php echo site_url('administrator/menu/act_deactivate'); ?>'
                },
                <?php if (privilege_view('update', $this->menu_privilege)) : ?> {
                        separator: true
                    },
                    {
                        display: 'Up',
                        name: 'up',
                        bclass: 'sort_up',
                        onpress: act_sort,
                        urlaction: '<?php echo site_url('administrator/menu/act_update_up'); ?>'
                    },
                    {
                        separator: true
                    },
                    {
                        display: 'Down',
                        name: 'down',
                        bclass: 'sort_down',
                        onpress: act_sort,
                        urlaction: '<?php echo site_url('administrator/menu/act_update_down'); ?>'
                    },
                <?php endif;
                if (privilege_view('delete', $this->menu_privilege)) : ?> {
                        separator: true
                    },
                    {
                        display: 'Hapus Menu',
                        name: 'delete',
                        bclass: 'delete',
                        onpress: act_show,
                        urlaction: '<?php echo site_url('administrator/menu/act_delete'); ?>'
                    },
                <?php endif; ?>
            ],
            searchitems: [{
                    display: 'Nama Menu',
                    name: 'administrator_menu_title',
                    type: 'text',
                    isdefault: true
                },
                {
                    display: 'Status',
                    name: 'administrator_menu_is_active',
                    type: 'select',
                    option: '1:Aktif|0:Tidak Aktif'
                },
            ],
            sortname: "administrator_menu_order_by",
            sortorder: "asc",
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
    }


    $(document).ready(function() {

        // check url data
        let urlLocation = new URL(window.location);
        let params = new URLSearchParams(urlLocation.search);
        if (params.get('data') != null) {
            let dataUrl = params.get('data');
            if (isBase64(dataUrl)) {
                let b64decode = b64DecodeUnicode(dataUrl);
                let arrb64 = b64decode.split('||');
                getMenu(arrb64[0], arrb64[1]);
            } else {
                getMenu(0, '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>');
            }
        } else {
            getMenu(0, '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>');
        }

        <?php
        if (privilege_view(array('add', 'update'), $this->menu_privilege)) {
        ?>
            $('#modal').on('shown.bs.modal', function() {
                $('input[name="title"]').focus();
            });

            $('select[name="parent"]').on('change', function() {
                var typeVal = $(this).val();
                if (typeVal) {
                    $(this).next()
                        .children('.selection')
                        .children('.select2-selection')
                        .removeClass('valid')
                        .removeClass('error')
                        .css('border-color', '');
                    $(this).next().next().remove();
                }
            });

            $('input[name="class"]').on('keyup change', function() {
                var classValue = $(this).val();
                if (classValue.length > 0) {
                    $('#preview-class i').attr('class', classValue);
                } else {
                    $('#preview-class i').attr('class', '');
                }
            });

            $('#form').on('submit', function(e) {
                $('#form button[type="submit"]').attr('disabled', 'disabled');
                e.preventDefault();
                var urlForm = $('#form').attr('data-url');
                $.ajax({
                    type: 'POST',
                    url: urlForm,
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#modal').modal('hide');
                            $('#form button[type="submit"]').removeAttr('disabled');
                            $('#gridview').flexReload();
                            var message_class = 'response_confirmation alert alert-success';

                            $("#response_message").finish();

                            $("#response_message").addClass(message_class);
                            $("#response_message").slideDown("fast");
                            $("#response_message").html(res.data);
                            $("#response_message").delay(10000).slideUp(1000, function() {
                                $("#response_message").removeClass(message_class);
                            });
                        } else {
                            $('#form button[type="submit"]').removeAttr('disabled');
                            $("#modal-response-message").finish();

                            $("#modal-response-message").slideDown("fast");
                            $('#modal-response-message').html(res.msg);
                            $("#modal-response-message").delay(10000).slideUp(1000);
                        }
                    },
                    error: function(err) {
                        $('#form button[type="submit"]').removeAttr('disabled');
                        console.log(err);
                    }
                });
            });


        <?php
        }
        ?>

    });

    <?php
    if (privilege_view('add', $this->menu_privilege)) {
    ?>

        function addMenu() {
            $('#modal .modal-title').text("Form Add " + myTitle);
            $('#form').trigger("reset");
            $('#form').attr('data-url', '<?php echo site_url('administrator/menu/act_add'); ?>');
            $('#preview-class i').attr('class', '');
            getDataParent('add');
            $('#modal').modal({
                backdrop: 'static',
                keyboard: false
            }, 'show');
        }
    <?php
    }

    if (privilege_view('update', $this->menu_privilege)) {
    ?>

        function editMenu(id) {
            $('#modal .modal-title').text("Form Edit " + myTitle);
            $('#form').trigger("reset");
            $('#form').attr('data-url', '<?php echo site_url('administrator/menu/act_update'); ?>');
            $('#preview-class i').attr('class', '');
            getDataEdit(id);
        }

        function getDataEdit(id) {
            $.ajax({
                url: '<?php echo site_url('common/general/administrator/menu/get_detail'); ?>',
                method: 'GET',
                data: 'id=' + id,
                dataType: 'json',
                success: function(res) {
                    if (res.status == 200) {
                        let menu = res.data;
                        $('input[name="par_id"]').val(menu.administrator_menu_par_id);
                        $('input[name="id"]').val(menu.administrator_menu_id);
                        $('input[name="title"]').val(menu.administrator_menu_title);
                        $('textarea[name="description"]').val(menu.administrator_menu_description);
                        $('input[name="link"]').val(menu.administrator_menu_link);
                        $('input[name="class"]').val(menu.administrator_menu_class).keyup();

                        if (menu.administrator_menu_action) {
                            var action = JSON.parse(menu.administrator_menu_action);
                            $.each(action, function(key, value) {
                                if (value.name !== 'show') {
                                    $('#action-' + value.name).prop('checked', true);
                                }
                            });
                        }

                        getDataParent('edit');

                        $('#modal').modal({
                            backdrop: 'static',
                            keyboard: false
                        }, 'show');
                    } else {
                        alert(res.msg);
                        $('#gridview').flexReload();
                    }
                },
                error: function(err) {
                    alert('Data error');
                }
            });
        }
    <?php
    }

    if (privilege_view(array('update', 'add'), $this->menu_privilege)) {
    ?>

        function getDataParent(type) {
            $.ajax({
                url: '<?php echo site_url('common/general/administrator/menu/get_option_parent'); ?>',
                method: 'GET',
                data: '',
                dataType: 'json',
                success: function(res) {
                    if (res.status == 200) {
                        let parent = res.data;
                        if (type === 'edit' || type === 'add') {
                            var option = '<option value="">--Choose Parent--</option>';
                            var isSelected = '';
                            $.each(parent, function(key, value) {
                                isSelected = '';
                                if (value.id == $('input[name="par_id"]').val()) {
                                    isSelected = 'selected="selected"';
                                }
                                option += '<option value="' + value.id + '" ' + isSelected + '>' + value.title + '</option>';
                            });

                            $('select[name="parent"]').html(option).change().select2();
                        }


                        if (type === 'init') {
                            var option = '<option value="">--Choose Parent--</option>';
                            $.each(parent, function(key, value) {
                                option += '<option value="' + value.id + '">' + value.title + '</option>';
                            });

                            $('select[name="parent"]').html(option).select2();
                        }
                    } else {
                        alert(res.msg);
                    }
                },
                error: function(err) {
                    alert('Data error');
                }
            });
        }
    <?php
    }
    ?>
</script>

<!--form validator-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<script>
    // encode to b64
    function b64EncodeUnicode(str) {
        // first we use encodeURIComponent to get percent-encoded UTF-8,
        // then we convert the percent encodings into raw bytes which
        // can be fed into btoa.
        return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
            function toSolidBytes(match, p1) {
                return String.fromCharCode('0x' + p1);
            }));
    }

    // decode b64
    function b64DecodeUnicode(str) {
        // Going backwards: from bytestream, to percent-encoding, to original string.
        return decodeURIComponent(atob(str).split('').map(function(c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));
    }

    // check is base64 or not
    function isBase64(str) {
        try {
            return b64EncodeUnicode(b64DecodeUnicode(str)) == str;
        } catch (err) {
            return false;
        }
    }

    $.validate({
        lang: 'id'
    });
</script>
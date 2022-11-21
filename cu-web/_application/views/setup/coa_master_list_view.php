<link rel="stylesheet" href="<?php echo THEMES_BACKEND; ?>/js/fancytree/jquery.contextMenu.min.css" />
<link href="<?php echo THEMES_BACKEND; ?>/js/fancytree/skin-win8/ui.fancytree.css" rel="stylesheet" type="text/css">
<style>
    .fancytree-node{
        cursor: pointer;
    }
    table.fancytree-ext-table tbody tr:hover {
/*        background-color: rgba(255, 221, 85, 0.51);
        outline: 1px solid rgba(255, 221, 85, 0.51);*/
        background-color: #d5effc;
        outline: 1px solid #d5effc;
    }
    table.fancytree-ext-table tbody tr.fancytree-active:hover,
    table.fancytree-ext-table tbody tr.fancytree-selected:hover {
/*        background-color: rgba(255, 221, 85, 0.51);
        outline: 1px solid rgba(255, 221, 85, 0.51);*/
        background-color: #d5effc;
        outline: 1px solid #d5effc;
    }
    .fancytree-plain.fancytree-container.fancytree-treefocus span.fancytree-selected span.fancytree-title {
        /*background-color: rgba(255, 221, 85, 0.51);*/
        background: #d5effc url(<?php echo site_url('addons/flexigrid/css');?>/images/hl.png) repeat-x top;
        border-color: #d5effc;
    }
    table.fancytree-ext-table.fancytree-treefocus tbody tr.fancytree-active {
        /*background-color: rgba(255, 221, 85, 0.51);*/
        /*outline: 1px solid rgba(255, 221, 85, 0.51);*/
        background: #d5effc url(<?php echo site_url('addons/flexigrid/css');?>/images/hl.png) repeat-x top;
        outline: 1px solid #d5effc;
    }
    table.fancytree-ext-table.fancytree-treefocus tbody tr.fancytree-selected {
        /*background-color: rgba(255, 221, 85, 0.51);*/
        background: #d5effc url(<?php echo site_url('addons/flexigrid/css');?>/images/hl.png) repeat-x top;
    }
    table.fancytree-ext-table tbody tr.fancytree-selected {
        /*background-color: rgba(255, 221, 85, 0.51);*/
        background: #d5effc url(<?php echo site_url('addons/flexigrid/css');?>/images/hl.png) repeat-x top;
    }
    table.fancytree-ext-table tbody tr.fancytree-focused span.fancytree-title{
        outline: none;
    }
    .table-fancytree{
        font-family: verdana, tahoma, Arial, Helvetica, sans-serif;
        font-size: 11px;
        color: #222;
    }
    .table-fancytree thead tr{
        background: #fafafa url(<?php echo site_url('addons/flexigrid/css/images/fhbg.gif'); ?>) repeat-x bottom;
        border: 1px solid #ccc;
    }
    .table-fancytree thead tr th{
        border-right: 1px solid #ccc;
        padding: 5px;
        padding-left: 5px;
        font-weight: normal;
    }
    .table-fancytree thead tr:first-child th{
        background: #fafafa url(<?php echo site_url('addons/flexigrid/css/images/bg.gif'); ?>) repeat-x top;
        height: 29px; 
        border-bottom: 0px;
        padding: 0px;
        padding-left: 2px;
        padding-right: 2px;
    }
    .table-fancytree tbody tr{
        border: 1px solid #ccc;
        height: 26px;
    }
    .table-fancytree tbody tr td{
        padding-left: 5px;
    }
    table.fancytree-ext-table tbody tr td{
        border: 1px solid #ccc;
        border-top: 1px solid #fff; 
    }
    .table-fancytree .btn-action-left{
        float: left;
    }
    .table-fancytree .fbutton .add{
        background: url(<?php echo site_url('addons/flexigrid/button/images/add.png'); ?>) no-repeat scroll left center transparent;
    }
    .table-fancytree .fbutton .excel{
        background: url(<?php echo site_url('addons/flexigrid/button/images/page_excel.png'); ?>) no-repeat scroll left center transparent;
    }
    .table-fancytree .btn-action-right{
        float: right;
    }
    .table-fancytree .fbutton{
        background: transparent;
        float: left;
        display: block;
        cursor: pointer;
        padding: 3px;
        border: 1px solid transparent;
    }
    .table-fancytree .fbutton:hover{
        border: 1px solid #ccc;
    }
    .table-fancytree .fbutton span{
        padding: 3px;
        padding-left: 20px;
    }
    .table-fancytree .fbuttonseparator{
        float: left;
        height: 22px;
        border-left: 1px solid #ccc;
        border-right: 1px solid #fff;
        margin: 1px;
    }
</style>
<div class="page-title">
    <div class="title_left">
        <h3><?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div id="response_message" style="display:none;"></div>
        <ul id="container-tabs" class="nav nav-tabs" role="tablist" aria-orientation="vertical">
            <li class="active"><a data-toggle="tab" href="#tab-aktiva">Aktiva</a></li>
            <li><a data-toggle="tab" href="#tab-pasiva">Pasiva</a></li>
            <li><a data-toggle="tab" href="#tab-pendapatan">Pendapatan</a></li>
            <li><a data-toggle="tab" href="#tab-biaya">Biaya</a></li>
            <li><a data-toggle="tab" href="#tab-nominal">Nominal</a></li>
        </ul>
        <div class="tab-content">
            <div id="tab-aktiva" class="tab-pane fade in active">
                <table id="treegrid-aktiva" class="table-fancytree" style="width: 100%;">
                    <colgroup>
                        <col style="display: none;"></col>
                        <col width="35%"></col>
                        <col width="65%"></col>
                    </colgroup>
                    <thead>
                        <tr>
                            <th colspan="2">
                                <div class="btn-action-left">
                                    <div class="fbutton" onclick="addCoa('parent', 'aktiva')"><span class="add">Tambah Akun</span></div>
                                    <!--<div class="fbuttonseparator"></div>-->
                                </div>
                                <div class="btn-action-right">
                                    <div class="fbutton" onclick="exportCoa('aktiva')"><span class="excel">Export Excel</span></div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th style="display: none;"></th>
                            <th>No. Rekening</th>
                            <th>Nama Akun</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="display:none;"></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tab-pasiva" class="tab-pane fade">
                <table id="treegrid-pasiva" class="table-fancytree" style="width: 100%;">
                    <colgroup>
                        <col style="display: none;"></col>
                        <col width="35%"></col>
                        <col width="65%"></col>
                    </colgroup>
                    <thead>
                        <tr>
                            <th colspan="2">
                                <div class="btn-action-left">
                                    <div class="fbutton" onclick="addCoa('parent', 'pasiva')"><span class="add">Tambah Akun</span></div>
                                    <!--<div class="fbuttonseparator"></div>-->
                                </div>
                                <div class="btn-action-right">
                                    <div class="fbutton" onclick="exportCoa('pasiva')"><span class="excel">Export Excel</span></div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th style="display: none;"></th>
                            <th>No. Rekening</th>
                            <th>Nama Akun</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="display: none;"></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tab-pendapatan" class="tab-pane fade">
                <table id="treegrid-pendapatan" class="table-fancytree" style="width: 100%;">
                    <colgroup>
                        <col style="display: none;"></col>
                        <col width="35%"></col>
                        <col width="65%"></col>
                    </colgroup>
                    <thead>
                        <tr>
                            <th colspan="2">
                                <div class="btn-action-left">
                                    <div class="fbutton" onclick="addCoa('parent', 'pendapatan')"><span class="add">Tambah Akun</span></div>
                                    <!--<div class="fbuttonseparator"></div>-->
                                </div>
                                <div class="btn-action-right">
                                    <div class="fbutton" onclick="exportCoa('pendapatan')"><span class="excel">Export Excel</span></div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th style="display: none;"></th>
                            <th>No. Rekening</th>
                            <th>Nama Akun</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="display: none;"></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tab-biaya" class="tab-pane fade">
                <table id="treegrid-biaya" class="table-fancytree" style="width: 100%;">
                    <colgroup>
                        <col style="display: none;"></col>
                        <col width="35%"></col>
                        <col width="65%"></col>
                    </colgroup>
                    <thead>
                        <tr>
                            <th colspan="2">
                                <div class="btn-action-left">
                                    <div class="fbutton" onclick="addCoa('parent', 'biaya')"><span class="add">Tambah Akun</span></div>
                                    <!--<div class="fbuttonseparator"></div>-->
                                </div>
                                <div class="btn-action-right">
                                    <div class="fbutton" onclick="exportCoa('biaya')"><span class="excel">Export Excel</span></div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th style="display: none;"></th>
                            <th>No. Rekening</th>
                            <th>Nama Akun</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="display: none;"></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tab-nominal" class="tab-pane fade">
                <table id="treegrid-nominal" class="table-fancytree" style="width: 100%;">
                    <colgroup>
                        <col style="display: none;"></col>
                        <col width="35%"></col>
                        <col width="65%"></col>
                    </colgroup>
                    <thead>
                        <tr>
                            <th colspan="2">
                                <div class="btn-action-left">
                                    <?php if(privilege_view('add', $this->menu_privilege)): ?>
                                        <div class="fbutton" onclick="addCoa('parent', 'nominal')"><span class="add">Tambah Akun</span></div>
                                    <?php endif; ?>
                                    <!--<div class="fbuttonseparator"></div>-->
                                </div>
                                <div class="btn-action-right">
                                    <?php if(privilege_view('export', $this->menu_privilege)): ?>
                                        <div class="fbutton" onclick="exportCoa('nominal')"><span class="excel">Export Excel</span></div>
                                    <?php endif; ?>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th style="display: none;"></th>
                            <th>No. Rekening</th>
                            <th>Nama Akun</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="display: none;"></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

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

                    <div id="parent-group" class="form-group" style="display:none;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="coa-parent">Akun Parent <span class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="hidden" name="parent_id" id="coa-parent-id" class="form-control" value="0" readonly="readonly">
                            <input type="text" name="parent_name" id="coa-parent" class="form-control" readonly="readonly">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="coa-number">No. Rekening <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="coa-id" type="hidden" name="id" value="0">
                            <input tabindex="1" type="text" name="number" id="coa-number" class="form-control" data-validation="required alphanumeric">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="coa-title">Nama Akun<span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input tabindex="2" type="text" name="title" id="coa-title" class="form-control" data-validation="required">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="coa-is-positive">Tipe Saldo <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select tabindex="3" name="is_positive" id="coa-is-positive" class="form-control my-select2" data-validation="required">
                                <option value="">--Pilih Tipe Saldo--</option>
                                <option value="1">Positif</option>
                                <option value="0">Negatif</option>
                            </select>
                            <span>Jika Tipe Negatif, akan mengurangi saldo akun di tipe akun terpilih</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="coa-type">Tipe Akun <span class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="hidden" name="type" id="coa-type-hidden" class="form-control" value="" readonly="readonly">
                            <select tabindex="4" id="coa-type" class="form-control my-select2" data-validation="required">
                                <option value="">--Pilih Tipe Akun--</option>
                                <option value="aktiva">Aktiva</option>
                                <option value="pasiva">Pasiva</option>
                                <option value="pendapatan">Pendapatan</option>
                                <option value="biaya">Biaya</option>
                                <option value="nominal">Nominal</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="coa-tag">Tag Akun </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select tabindex="5" name="tag" id="coa-tag" class="form-control my-select2">
                                <option value="">--Pilih Tag Akun--</option>
                                <option value="biaya">Biaya</option>
                                <option value="likuid">Likuid</option>
                                <option value="pendapatan">Pendapatan</option>
                                <option value="asset">Asset</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button tabindex="6" type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Simpan <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end modal add-->

<!-- Modal Delete -->
<div id="modal-delete" class="modal" role="dialog">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Hapus <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></h4>
            </div>
            <form id="form-delete" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body">
                    <div id="modal-response-message-delete" class="alert alert-danger alert-dismissible fade in" role="alert" style="display:none"></div>
                    <div class="form-group">
                        <label id="label-hapus-akun" class="control-label col-md-11 col-sm-11 col-xs-11">Anda yakin ingin menghapus Akun ini?</label>
                        <label id="label-hapus-akun-info" class="control-label col-md-11 col-sm-11 col-xs-11"></label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button tabindex="1" type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp; Hapus <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end modal delete-->

<!--form validator-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<!-- TreeView Librabry -->
<script src="<?php echo THEMES_BACKEND; ?>/js/fancytree/jquery.fancytree.min.js" type="text/javascript"></script>
<script src="<?php echo THEMES_BACKEND; ?>/js/fancytree/jquery.fancytree.table.js" type="text/javascript"></script>

<!-- jquery-contextmenu (https://github.com/swisnl/jQuery-contextMenu) -->
<script src="<?php echo THEMES_BACKEND; ?>/js/fancytree/jquery.contextMenu.min.js"></script>
<script src="<?php echo THEMES_BACKEND; ?>/js/fancytree/jquery.fancytree.contextMenu.js" type="text/javascript"></script>

<script>
    var arrCoaIdDelete = [];
    var treegridAktiva;
    var treegridPasiva;
    var treegridPendapatan;
    var treegridBiaya;
    var treegridNominal;
    var contextMenuOptions = {
        selector: "fancytree-node",
        menu: {
            <?php if(privilege_view('add', $this->menu_privilege)):
                echo '"add": {"name": "Tambah Sub", "icon": "add"},';
            endif;
            if(privilege_view('update', $this->menu_privilege)):
                echo '"edit": {"name": "Ubah", "icon": "edit"},';
            endif;
            if(privilege_view('delete', $this->menu_privilege)):
                echo '"delete": {"name": "Hapus", "icon": "delete"},';
            endif;
            ?>
        },
        actions: function (node, action, options) {
            let parentTitle = '';
            if(typeof node.parent.data.code !== 'undefined'){
                parentTitle = node.parent.data.title + ' - ' + node.parent.coaName;
            }
            let thisTitle = node.title + ' - ' + node.data.coaName;
            switch (action) {
                case "add":
                    addCoa('child', node.data.coaType, node.key, thisTitle);
                    break;

                case "edit":
                    let type = 'child';
                    if(parentTitle == ''){
                        type = 'parent';
                    }
                    editCoa(type, node.key, node.title, node.data.coaName, node.data.coaType, node.data.isPositive, node.data.tag, parentTitle, node.data.parentId);
                    break;

                case "delete":
                    childSize = (node.children != null) ? node.children.length : 0;
                    if (childSize > 0) {
                        var message_class = 'response_confirmation alert alert-danger';
                        var data_msg = "<p>Gagal hapus data! Akun <b>"+ thisTitle +"</b> masih mempunyai akun sub</p>";

                        $("#response_message").finish();

                        $("#response_message").addClass(message_class);
                        $("#response_message").slideDown("fast");
                        $("#response_message").html(data_msg);
                        $("#response_message").delay(10000).slideUp(1000, function () {
                            $("#response_message").removeClass(message_class);
                        });
                    } else {
                        deleteCoa(node.key, thisTitle);
                    }

                    break;

                default:
            }
        }
    }
    
    function clearForm() {
        $('#form-add').trigger("reset");
        $('#coa-type-hidden').val('');
        $('#coa-tag').val(null).trigger('change');
        $('#coa-type').val(null).trigger('change');
        $('#coa-is-positive').val(null).trigger('change');
    }

    function addCoa(type, coaType, parentId = 0, parentTitle = '') {
        clearForm();
        $('#form-add').attr('data-url', '<?php echo site_url('setup/coa_master/act_add'); ?>');
        $('#coa-type-hidden').val(coaType);
        $('#coa-type').val(coaType).change().prop('disabled', false);
        $('#coa-parent-id').val(parentId);
        if (type == 'child') {
            $('#modal-add .modal-title').text('Form Tambah Sub <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>');
            $('#parent-group').show();
            $('#coa-type').prop('disabled', true);
            $('#coa-parent').val(parentTitle);
        } else {
            $('#modal-add .modal-title').text('Form Tambah <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>');
            $('#parent-group').hide();
        }
        $('#modal-add').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
    }
    
    function editCoa(type, coaId, coaNumber, coaName, coaType, isPositive, coaTag, parentTitle, parentId) {
        clearForm();
        $('#form-add').attr('data-url', '<?php echo site_url('setup/coa_master/act_update'); ?>');
        $('#coa-id').val(coaId);
        $('#coa-number').val(coaNumber);
        $('#coa-title').val(coaName)
        $('#coa-is-positive').val(isPositive).change();
        $('#coa-type-hidden').val(coaType);
        $('#coa-type').val(coaType).change().prop('disabled', true);
        $('#coa-tag').val(coaTag).change();
        $('#coa-parent-id').val(parentId);
        if (type == 'child') {
            $('#modal-add .modal-title').text('Form Ubah Sub <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>');
            $('#parent-group').show();
            $('#coa-parent').val(parentTitle);
        } else {
            $('#modal-add .modal-title').text('Form Ubah <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>');
            $('#parent-group').hide();
        }
        $('#modal-add').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
    }
    
    function deleteCoa(coaId, coaTitle){
        $('#form-delete').attr('data-url', '<?php echo site_url('setup/coa_master/act_delete'); ?>');
        arrCoaIdDelete = [];
        arrCoaIdDelete.push(coaId);
        $('#label-hapus-akun').html("Anda yakin ingin menghapus Akun <b>" + coaTitle + "</b>?");
        $('#label-hapus-akun-info').html("Setelah dihapus, Akun tidak dapat dikembalikan! Anda harus input ulang jika ingin menggunakan Akun ini kembali.");
        $('#label-hapus-akun-info').css({color:'red'});;
        $("#modal-response-message-delete").finish();

        $('#modal-delete').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
    }
    
    function exportCoa(type){
        let win = window.open('<?php echo site_url("setup/coa_master/export_data_coa/"); ?>' + type, '_blank');
        win.focus();
    }
    
    function loadTreegridAktiva(){
        if(typeof treegridAktiva == 'undefined'){
            treegridAktiva = $("#treegrid-aktiva").fancytree({
                extensions: ["table", "contextMenu"],
                checkbox: false,
                aria: true,
                table: {
                    indentation: 20,
                    nodeColumnIdx: 1,
                    checkboxColumnIdx: 0
                },
                source: {
                    url: '<?php echo site_url('setup/coa_master/get_data/aktiva'); ?>'
                },
                contextMenu: contextMenuOptions,
                renderColumns: function (e, data) {
                    let node = data.node;
                    $tdList = $(node.tr).find(">td");
                    $tdList.eq(1).text(node.data.title);
                    $tdList.eq(2).text(node.data.coaName).addClass("alignLeft");
                },
                init: function (event, data) {
                    if (data.tree.count() == 0) {
                        $('#treegrid-aktiva').find("tbody tr").remove();
                        $('#treegrid-aktiva').find("tbody").append(`
                                        <tr>
                                            <td colspan="2">Data belum ada.</td>
                                        <tr>
                                    `);
                    }
                }
            });
        }else{
            treegridAktiva.fancytree('option', 'source', {
                url: '<?php echo site_url('setup/coa_master/get_data/aktiva'); ?>',
                success: function (data) {
                    if (data.length === 0) {
                        $('#treegrid-aktiva').find("tbody tr").remove();
                        $('#treegrid-aktiva').find("tbody").append(`
                                        <tr>
                                            <td colspan="2">Data belum ada.</td>
                                        <tr>
                                    `);
                    } else {
                        $('#treegrid-aktiva').find("tbody tr").remove();
                    }
                }
            });
        }
        treegridAktiva.fancytree("getTree").visit(function (node) {
            node.setExpanded();
        });
    }
    
    function loadTreegridPasiva(){
        if(typeof treegridPasiva == 'undefined'){
            treegridPasiva = $("#treegrid-pasiva").fancytree({
                extensions: ["table", "contextMenu"],
                checkbox: false,
                aria: true,
                table: {
                    indentation: 20,
                    nodeColumnIdx: 1,
                    checkboxColumnIdx: 0
                },
                source: {
                    url: '<?php echo site_url('setup/coa_master/get_data/pasiva'); ?>'
                },
                contextMenu: contextMenuOptions,
                renderColumns: function (e, data) {
                    let node = data.node;
                    $tdList = $(node.tr).find(">td");
                    $tdList.eq(1).text(node.data.title);
                    $tdList.eq(2).text(node.data.coaName).addClass("alignLeft");
                },
                init: function (event, data) {
                    if (data.tree.count() == 0) {
                        $('#treegrid-pasiva').find("tbody tr").remove();
                        $('#treegrid-pasiva').find("tbody").append(`
                                        <tr>
                                            <td colspan="2">Data belum ada.</td>
                                        <tr>
                                    `);
                    }
                }
            });
        }else{
            treegridPasiva.fancytree('option', 'source', {
                url: '<?php echo site_url('setup/coa_master/get_data/pasiva'); ?>',
                success: function (data) {
                    if (data.length === 0) {
                        $('#treegrid-pasiva').find("tbody tr").remove();
                        $('#treegrid-pasiva').find("tbody").append(`
                                        <tr>
                                            <td colspan="2">Data belum ada.</td>
                                        <tr>
                                    `);
                    } else {
                        $('#treegrid-pasiva').find("tbody tr").remove();
                    }
                }
            });
        }
        treegridPasiva.fancytree("getTree").visit(function (node) {
            node.setExpanded();
        });
    }
    
    function loadTreegridPendapatan(){
        if(typeof treegridPendapatan == 'undefined'){
            treegridPendapatan = $("#treegrid-pendapatan").fancytree({
                extensions: ["table", "contextMenu"],
                checkbox: false,
                aria: true,
                table: {
                    indentation: 20,
                    nodeColumnIdx: 1,
                    checkboxColumnIdx: 0
                },
                source: {
                    url: '<?php echo site_url('setup/coa_master/get_data/pendapatan'); ?>'
                },
                contextMenu: contextMenuOptions,
                renderColumns: function (e, data) {
                    let node = data.node;
                    $tdList = $(node.tr).find(">td");
                    $tdList.eq(1).text(node.data.title);
                    $tdList.eq(2).text(node.data.coaName).addClass("alignLeft");
                },
                init: function (event, data) {
                    if (data.tree.count() == 0) {
                        $('#treegrid-pendapatan').find("tbody tr").remove();
                        $('#treegrid-pendapatan').find("tbody").append(`
                                        <tr>
                                            <td colspan="2">Data belum ada.</td>
                                        <tr>
                                    `);
                    }
                }
            });
        }else{
            treegridPendapatan.fancytree('option', 'source', {
                url: '<?php echo site_url('setup/coa_master/get_data/pendapatan'); ?>',
                success: function (data) {
                    if (data.length === 0) {
                        $('#treegrid-pendapatan').find("tbody tr").remove();
                        $('#treegrid-pendapatan').find("tbody").append(`
                                        <tr>
                                            <td colspan="2">Data belum ada.</td>
                                        <tr>
                                    `);
                    } else {
                        $('#treegrid-pendapatan').find("tbody tr").remove();
                    }
                }
            });
        }
        treegridPendapatan.fancytree("getTree").visit(function (node) {
            node.setExpanded();
        });
    }
    
    function loadTreegridBiaya(){
        if(typeof treegridBiaya == 'undefined'){
            treegridBiaya = $("#treegrid-biaya").fancytree({
                extensions: ["table", "contextMenu"],
                checkbox: false,
                aria: true,
                table: {
                    indentation: 20,
                    nodeColumnIdx: 1,
                    checkboxColumnIdx: 0
                },
                source: {
                    url: '<?php echo site_url('setup/coa_master/get_data/biaya'); ?>'
                },
                contextMenu: contextMenuOptions,
                renderColumns: function (e, data) {
                    let node = data.node;
                    $tdList = $(node.tr).find(">td");
                    $tdList.eq(1).text(node.data.title);
                    $tdList.eq(2).text(node.data.coaName).addClass("alignLeft");
                },
                init: function (event, data) {
                    if (data.tree.count() == 0) {
                        $('#treegrid-biaya').find("tbody tr").remove();
                        $('#treegrid-biaya').find("tbody").append(`
                                        <tr>
                                            <td colspan="2">Data belum ada.</td>
                                        <tr>
                                    `);
                    }
                }
            });
        }else{
            treegridBiaya.fancytree('option', 'source', {
                url: '<?php echo site_url('setup/coa_master/get_data/biaya'); ?>',
                success: function (data) {
                    if (data.length === 0) {
                        $('#treegrid-biaya').find("tbody tr").remove();
                        $('#treegrid-biaya').find("tbody").append(`
                                        <tr>
                                            <td colspan="2">Data belum ada.</td>
                                        <tr>
                                    `);
                    } else {
                        $('#treegrid-biaya').find("tbody tr").remove();
                    }
                }
            });
        }
        treegridBiaya.fancytree("getTree").visit(function (node) {
            node.setExpanded();
        });
    }
    
    function loadTreegridNominal(){
        if(typeof treegridNominal == 'undefined'){
            treegridNominal = $("#treegrid-nominal").fancytree({
                extensions: ["table", "contextMenu"],
                checkbox: false,
                aria: true,
                table: {
                    indentation: 20,
                    nodeColumnIdx: 1,
                    checkboxColumnIdx: 0
                },
                source: {
                    url: '<?php echo site_url('setup/coa_master/get_data/nominal'); ?>'
                },
                contextMenu: contextMenuOptions,
                renderColumns: function (e, data) {
                    let node = data.node;
                    $tdList = $(node.tr).find(">td");
                    $tdList.eq(1).text(node.data.title);
                    $tdList.eq(2).text(node.data.coaName).addClass("alignLeft");
                },
                init: function (event, data) {
                    if (data.tree.count() == 0) {
                        $('#treegrid-nominal').find("tbody tr").remove();
                        $('#treegrid-nominal').find("tbody").append(`
                                        <tr>
                                            <td colspan="2">Data belum ada.</td>
                                        <tr>
                                    `);
                    }
                }
            });
        }else{
            treegridNominal.fancytree('option', 'source', {
                url: '<?php echo site_url('setup/coa_master/get_data/nominal'); ?>',
                success: function (data) {
                    if (data.length === 0) {
                        $('#treegrid-nominal').find("tbody tr").remove();
                        $('#treegrid-nominal').find("tbody").append(`
                                        <tr>
                                            <td colspan="2">Data belum ada.</td>
                                        <tr>
                                    `);
                    } else {
                        $('#treegrid-nominal').find("tbody tr").remove();
                    }
                }
            });
        }
        treegridNominal.fancytree("getTree").visit(function (node) {
            node.setExpanded();
        });
    }

    function number_format(number, decimals, decPoint, thousandsSep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number;
        var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
        var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep;
        var dec = (typeof decPoint === 'undefined') ? '.' : decPoint;
        var s = '';

        var toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + (Math.round(n * k) / k).toFixed(prec);
        }

        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }

        return s.join(dec);
    }
    
    $(document).ready(function () {
        $('.my-select2').select2({
            dropdownParent: $('#modal-add .modal-body')
        });
        
        let urlLocation = new URL(window.location);
        let params = new URLSearchParams(urlLocation.search);
        if(params.get('page') != null){
            if(params.get('page') == 'pasiva'){
                $('#container-tabs a[data-toggle="tab"][href="#tab-pasiva"]').tab('show');
                loadTreegridPasiva();
            }
            if(params.get('page') == 'pendapatan'){
                $('#container-tabs a[data-toggle="tab"][href="#tab-pendapatan"]').tab('show');
                loadTreegridPendapatan();
            }
            if(params.get('page') == 'biaya'){
                $('#container-tabs a[data-toggle="tab"][href="#tab-biaya"]').tab('show');
                loadTreegridBiaya();
            }
            if(params.get('page') == 'nominal'){
                $('#container-tabs a[data-toggle="tab"][href="#tab-nominal"]').tab('show');
                loadTreegridNominal();
            }
        }else{
            $('#container-tabs a[data-toggle="tab"][href="#tab-aktiva"]').tab('show');
            loadTreegridAktiva();
        }
        $('#container-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var uri = 'show';
            var target = $(e.target).attr("href"); // activated tab
            if (target === '#tab-aktiva') {
                loadTreegridAktiva();
            } else if (target === '#tab-pasiva') {
                loadTreegridPasiva();
                uri = 'show?page=pasiva';
            } else if (target === '#tab-pendapatan') {
                loadTreegridPendapatan();
                uri = 'show?page=pendapatan';
            } else if (target === '#tab-biaya') {
                loadTreegridBiaya();
                uri = 'show?page=biaya';
            } else if (target === '#tab-nominal') {
                loadTreegridNominal();
                uri = 'show?page=nominal';
            }
            window.history.replaceState({}, '', uri);
        });
        
        $('#coa-type').on('change', function (){
           let value = $(this).val();
           $('#coa-type-hidden').val(value);
        });
        
        $('#form-add').on('submit', function (e) {
            e.preventDefault();
            $('#form-add button[type="submit"]').attr('disabled', 'disabled');

            var urlForm = $('#form-add').attr('data-url');
            var dataForm = new FormData(this);

            $.ajax({
                type: 'POST',
                url: urlForm,
                data: dataForm,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    if (res.status == 200) {
                        let coaType = $('#coa-type').val();
                        loadTreegridAktiva();
                        loadTreegridPasiva();
                        loadTreegridPendapatan();
                        loadTreegridBiaya();
                        loadTreegridNominal();
                        $('#container-tabs [href="#tab-' + coaType + '"]').tab('show');
                        $('#modal-add').modal('hide');
                        $('#form-add button[type="submit"]').removeAttr('disabled');
                        let message_class = 'response_confirmation alert alert-success';

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
                }
            });
        });
        
        $('#form-delete').on('submit', function (e) {
            e.preventDefault();
            $('#form-delete button[type="submit"]').attr('disabled', 'disabled');
            var urlForm = $('#form-delete').attr('data-url');
            $.ajax({
                type: 'POST',
                url: urlForm,
                data: {item: JSON.stringify(arrCoaIdDelete)},
                dataType: 'json',
                success: function (res) {
                    $('#form-delete button[type="submit"]').removeAttr('disabled');
                    if (res.status == 200) {
                        $('#modal-delete').modal('hide');
                        
                        loadTreegridAktiva();
                        loadTreegridBiaya();
                        loadTreegridNominal();
                        loadTreegridPasiva();
                        loadTreegridPendapatan();
                        
                        var message_class = 'response_confirmation alert alert-success';
                        $("#response_message").finish();
                        $("#response_message").addClass(message_class);
                        $("#response_message").slideDown("fast");
                        $("#response_message").html(res.data);
                        $("#response_message").delay(10000).slideUp(1000, function () {
                            $("#response_message").removeClass(message_class);
                        });

                    } else {
                        $("#modal-response-message-delete").finish();
                        $("#modal-response-message-delete").slideDown("fast");
                        $('#modal-response-message-delete').html(res.msg);
                        $("#modal-response-message-delete").delay(10000).slideUp(1000);
                    }
                },
                error: function (err) {
                    $('#form-delete button[type="submit"]').removeAttr('disabled');
                }
            });
        });
    });
    
    $.validate({
        modules: 'logic',
        lang: 'id'
    });
</script>
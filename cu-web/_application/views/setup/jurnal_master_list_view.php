<link href="<?php echo THEMES_BACKEND; ?>/js/fancytree/skin-win8/ui.fancytree.css" rel="stylesheet" type="text/css">
<style>
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
/*        background-color: rgba(255, 221, 85, 0.51);
        border-color: rgba(255, 221, 85, 0.51);*/
        background: #d5effc url(<?php echo site_url('addons/flexigrid/css');?>/images/hl.png) repeat-x top;
        border-color: #d5effc;
    }
    table.fancytree-ext-table.fancytree-treefocus tbody tr.fancytree-active {
/*        background-color: rgba(255, 221, 85, 0.51);
        outline: 1px solid rgba(255, 221, 85, 0.51);*/
        background: #d5effc url(<?php echo site_url('addons/flexigrid/css');?>/images/hl.png) repeat-x top;
        border-color: #d5effc;
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
    .table-like-flexigrid{
        font-family: verdana, tahoma, Arial, Helvetica, sans-serif;
        font-size: 11px;
        color: #222;
    }
    .table-like-flexigrid thead tr{
        background: #fafafa url(<?php echo site_url('addons/flexigrid/css/images/fhbg.gif'); ?>) repeat-x bottom;
        border: 1px solid #ccc;
        border-bottom: none;
    }
    .table-like-flexigrid thead tr th{
        border-right: 1px solid #ccc;
        padding: 5px;
        padding-left: 5px;
        padding-right: 5px;
        font-weight: normal;
    }
    .table-like-flexigrid thead tr.first th{
        background: #fafafa url(<?php echo site_url('addons/flexigrid/css/images/bg.gif'); ?>) repeat-x top;
        height: 29px; 
        border-bottom: 0px;
        padding: 0px;
        padding-left: 2px;
        padding-right: 2px;
    }
    .table-like-flexigrid tfoot tr th{
        border-right: 1px solid #ccc;
        padding: 5px;
        padding-left: 5px;
        padding-right: 5px;
        font-weight: normal;
    }
    .table-like-flexigrid tfoot tr{
        background: #fafafa url(<?php echo site_url('addons/flexigrid/css/images/fhbg.gif'); ?>) repeat-x bottom;
        border: 1px solid #ccc;
        border-top: none;
        border-bottom: none;
    }
    .table-like-flexigrid tbody tr{
        border: 1px solid #ccc;
        height: 26px;
    }
    .table-like-flexigrid tbody tr td{
        border: 1px solid #ccc;
        padding-left: 5px;
        padding-right: 5px;
    }
    .table-like-flexigrid tbody tr td.have-input{
        padding-left: 2px;
        padding-right: 2px;
    }
    .table-like-flexigrid tbody tr td input{
        padding-left: 5px;
        padding-right: 5px;
    }
    .table-like-flexigrid .fbutton .add{
        background: url(<?php echo site_url('addons/flexigrid/button/images/add.png'); ?>) no-repeat scroll left center transparent;
    }
    .table-like-flexigrid .fbutton .list{
        background: url(<?php echo site_url('addons/flexigrid/button/images/list.png'); ?>) no-repeat scroll left center transparent;
    }
    .table-like-flexigrid .fbutton .selectall{
        background: url(<?php echo site_url('addons/flexigrid/button/images/check-all.png'); ?>) no-repeat scroll left center transparent;
    }
    .table-like-flexigrid .fbutton .unselectall{
        background: url(<?php echo site_url('addons/flexigrid/button/images/check-none.png'); ?>) no-repeat scroll left center transparent;
    }
    .table-like-flexigrid .btn-action-right{
        float: right;
    }
    .table-like-flexigrid .fbutton{
        background: transparent;
        float: left;
        display: block;
        cursor: pointer;
        padding: 3px;
        border: 1px solid transparent;
    }
    .table-like-flexigrid .fbutton:hover{
        border: 1px solid #ccc;
    }
    .table-like-flexigrid .fbutton span{
        padding: 3px;
        padding-left: 20px;
    }
    .table-like-flexigrid .fbuttonseparator{
        float: left;
        height: 22px;
        border-left: 1px solid #ccc;
        border-right: 1px solid #fff;
        margin: 1px;
    }
    .tree-d-none{
        display: none;
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
        <table id="gridview" style="display:none;"></table>
    </div>
</div>

<!-- Modal -->
<div id="modal" class="modal fade" role="dialog">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Tambah <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></h4>
            </div>
            <form id="form" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body" style="overflow-y: auto; max-height: calc(100vh - 200px);">
                    <div id="modal-response-message" class="alert alert-danger alert-dismissible fade in" role="alert" style="display:none"></div>
                    <input type="hidden" name="id" id="jurnal-id" value="0">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label" for="jurnal-title">Nama Jurnal <span class="required">*</span></label>
                                    <input tabindex="1" type="text" name="title" id="jurnal-title" class="form-control" data-validation="required">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label" for="jurnal-type">Tipe Jurnal <span class="required">*</span></label>
                                    <select tabindex="2" name="type" id="jurnal-type" class="form-control my-select2" data-validation="required">
                                        <option value="">--Pilih Tipe Jurnal--</option>
                                        <option value="0">Memorial</option>
                                        <option value="1">Otomatis</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12" style="margin-top: 5px;">
                            <table style="width: 100%;" class="table-like-flexigrid">
                                <thead>
                                    <tr class="first">
                                        <th colspan="6">
                                            <div class="btn-action-right">
                                                <div class="fbutton" onclick="openModalChooseCoa()"><span class="list">Pilih Dari COA</span></div>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th style="width: 6%; text-align: center;">Hapus</th>
                                        <th style="width: 34%;">Nama Akun</th>
                                        <th style="width: 15%; text-align: right;">Debet (Rp)</th>
                                        <th style="width: 15%; text-align: right;">Kredit (Rp)</th>
                                        <th style="width: 30%;">Keterangan</th>
                                    </tr>
                                </thead>
                            </table>
                            <div id="table-body">
                                <table id="grid-jurnal-detail" class="table-like-flexigrid" style="width: 100%;">
                                    <tbody></tbody>
                                </table>
                            </div>
                            <table class="table-like-flexigrid" style="width: 100%;">
                                <tfoot>
                                    <tr>
                                        <th colspan="2" style="width: 40%; text-align: right; font-weight: bold;"> TOTAL</th>
                                        <th style="width: 15%; text-align: right; font-weight: bold;" id="total-debet">0</th>
                                        <th style="width: 15%; text-align: right; font-weight: bold;" id="total-kredit">0</th>
                                        <th style="width: 30%;"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button tabindex="3" type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Simpan <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end modal-->

<!-- Modal detail -->
<div id="modal-detail" class="modal fade" tabindex="-1" role="dialog">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detail <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></h4>
            </div>
            <div class="modal-body" overflow-y: auto; max-height: calc(100vh - 200px);>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                        <div class="row">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <label class="control-label" for="jurnal-title-detail">Nama Jurnal </label>
                                <input type="text" id="jurnal-title-detail" class="form-control" readonly="readonly">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <label class="control-label" for="jurnal-type-detail">Tipe Jurnal </label>
                                <input type="text" id="jurnal-type-detail" class="form-control" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12" style="margin-top: 5px;">
                        <table style="width: 100%;" class="table-like-flexigrid">
                            <thead>
                                <tr>
                                    <th style="width: 40%;">Nama Akun</th>
                                    <th style="width: 15%; text-align: right;">Debet (Rp)</th>
                                    <th style="width: 15%; text-align: right;">Kredit (Rp)</th>
                                    <th style="width: 30%;">Keterangan</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="table-body-detail">
                            <table id="grid-jurnal-detail-detail" class="table-like-flexigrid" style="width: 100%;">
                                <tbody></tbody>
                            </table>
                        </div>
                        <table class="table-like-flexigrid" style="width: 100%;">
                            <tfoot>
                                <tr>
                                    <th style="width: 40%; text-align: right; font-weight: bold;"> TOTAL</th>
                                    <th style="width: 15%; text-align: right; font-weight: bold;" id="total-debet-detail">0</th>
                                    <th style="width: 15%; text-align: right; font-weight: bold;" id="total-kredit-detail">0</th>
                                    <th style="width: 30%;"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!--end modal detail-->

<!-- Modal COA -->
<div id="modal-coa" class="modal fade" role="dialog">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="closeModalChooseCoa()">&times;</button>
                <h4 class="modal-title">Daftar COA</h4>
            </div>
            <div class="modal-body" style="overflow-y: auto; height: calc(100vh - 200px);">
                <div id="modal-response-message-coa" class="alert alert-danger alert-dismissible fade in" role="alert" style="display:none"></div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                        <ul id="container-tabs" class="nav nav-tabs bar_tabs" role="tablist">
                            <li class="active"><a data-toggle="tab" href="#tab-aktiva">Aktiva</a></li>
                            <li><a data-toggle="tab" href="#tab-pasiva">Pasiva</a></li>
                            <li><a data-toggle="tab" href="#tab-pendapatan">Pendapatan</a></li>
                            <li><a data-toggle="tab" href="#tab-biaya">Biaya</a></li>
                            <li><a data-toggle="tab" href="#tab-nominal">Nominal</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-aktiva" class="tab-pane fade in active">
                                <table id="treegrid-aktiva" class="table-like-flexigrid" style="width: 100%;">
                                    <colgroup>
                                        <col></col>
                                        <col width="35%"></col>
                                        <col width="65%"></col>
                                    </colgroup>
                                    <thead>
                                        <tr class="first">
                                            <th colspan="3">
                                                <div class="btn-action-left">
                                                    <div class="fbutton" onclick="selectAll('aktiva')"><span class="selectall">Pilih Semua</span></div>
                                                    <div class="fbuttonseparator"></div>
                                                    <div class="fbutton" onclick="unSelectAll('aktiva')"><span class="unselectall">Hapus Pilihan</span></div>
                                                    <div class="fbuttonseparator"></div>
                                                    <div class="fbutton" onclick="addToList('aktiva')"><span class="add">Tambahkan ke Daftar Jurnal</span></div>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th>No. Rekening</th>
                                            <th>Nama Akun</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="tab-pasiva" class="tab-pane fade">
                                <table id="treegrid-pasiva" class="table-like-flexigrid" style="width: 100%;">
                                    <colgroup>
                                        <col></col>
                                        <col width="35%"></col>
                                        <col width="65%"></col>
                                    </colgroup>
                                    <thead>
                                        <tr class="first">
                                            <th colspan="3">
                                                <div class="btn-action-left">
                                                    <div class="fbutton" onclick="selectAll('pasiva')"><span class="selectall">Pilih Semua</span></div>
                                                    <div class="fbuttonseparator"></div>
                                                    <div class="fbutton" onclick="unSelectAll('pasiva')"><span class="unselectall">Hapus Pilihan</span></div>
                                                    <div class="fbuttonseparator"></div>
                                                    <div class="fbutton" onclick="addToList('pasiva')"><span class="add">Tambahkan ke Daftar Jurnal</span></div>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th>No. Rekening</th>
                                            <th>Nama Akun</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="tab-pendapatan" class="tab-pane fade">
                                <table id="treegrid-pendapatan" class="table-like-flexigrid" style="width: 100%;">
                                    <colgroup>
                                        <col></col>
                                        <col width="35%"></col>
                                        <col width="65%"></col>
                                    </colgroup>
                                    <thead>
                                        <tr class="first">
                                            <th colspan="3">
                                                <div class="btn-action-left">
                                                    <div class="fbutton" onclick="selectAll('pendapatan')"><span class="selectall">Pilih Semua</span></div>
                                                    <div class="fbuttonseparator"></div>
                                                    <div class="fbutton" onclick="unSelectAll('pendapatan')"><span class="unselectall">Hapus Pilihan</span></div>
                                                    <div class="fbuttonseparator"></div>
                                                    <div class="fbutton" onclick="addToList('pendapatan')"><span class="add">Tambahkan ke Daftar Jurnal</span></div>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th>No. Rekening</th>
                                            <th>Nama Akun</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="tab-biaya" class="tab-pane fade">
                                <table id="treegrid-biaya" class="table-like-flexigrid" style="width: 100%;">
                                    <colgroup>
                                        <col></col>
                                        <col width="35%"></col>
                                        <col width="65%"></col>
                                    </colgroup>
                                    <thead>
                                        <tr class="first">
                                            <th colspan="3">
                                                <div class="btn-action-left">
                                                    <div class="fbutton" onclick="selectAll('biaya')"><span class="selectall">Pilih Semua</span></div>
                                                    <div class="fbuttonseparator"></div>
                                                    <div class="fbutton" onclick="unSelectAll('biaya')"><span class="unselectall">Hapus Pilihan</span></div>
                                                    <div class="fbuttonseparator"></div>
                                                    <div class="fbutton" onclick="addToList('biaya')"><span class="add">Tambahkan ke Daftar Jurnal</span></div>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th>No. Rekening</th>
                                            <th>Nama Akun</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="tab-nominal" class="tab-pane fade">
                                <table id="treegrid-nominal" class="table-like-flexigrid" style="width: 100%;">
                                    <colgroup>
                                        <col></col>
                                        <col width="35%"></col>
                                        <col width="65%"></col>
                                    </colgroup>
                                    <thead>
                                        <tr class="first">
                                            <th colspan="3">
                                                <div class="btn-action-left">
                                                    <div class="fbutton" onclick="selectAll('nominal')"><span class="selectall">Pilih Semua</span></div>
                                                    <div class="fbuttonseparator"></div>
                                                    <div class="fbutton" onclick="unSelectAll('nominal')"><span class="unselectall">Hapus Pilihan</span></div>
                                                    <div class="fbuttonseparator"></div>
                                                    <div class="fbutton" onclick="addToList('nominal')"><span class="add">Tambahkan ke Daftar Jurnal</span></div>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th>No. Rekening</th>
                                            <th>Nama Akun</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closeModalChooseCoa()">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!--end modal COA-->

<!--FORM VALIDATOR-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<!--MASK MONEY-->   
<script src="<?php echo THEMES_BACKEND; ?>/js/jquery.maskMoney.min.js"></script>

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    var arrCoa = [];
    
    let arrExcept = [];
    
    var treegridAktiva;
    var treegridPasiva;
    var treegridPendapatan;
    var treegridBiaya;
    var treegridNominal;
    
    function clearForm(){
        $('#form').trigger('reset');
        $('#jurnal-type').val('').change();
        arrCoa = [];
        arrExcept = [];
        insertToList();
    }
    
    function openModalAdd(){
        clearForm();
        $('#form').attr('data-url', siteUrl + 'setup/jurnal_master/act_add');
        $('#modal').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
    }
    
    function openModalEdit(id){
        clearForm();
        $('#form').attr('data-url',  siteUrl + 'setup/jurnal_master/act_update');
        ajaxRequest('common/general/setup/jurnal_master/get_detail', 'GET', {id:id}, function(res) {
            if(res.status == 200){
                let jurnal = res.data;
                let detail = jurnal.detail;
                $('#jurnal-id').val(jurnal.jurnal_master_id);
                $('#jurnal-title').val(jurnal.jurnal_master_title);
                $('#jurnal-type').val(jurnal.jurnal_master_type).change();
                if(detail.length > 0){
                    detail.forEach(function (item, index){
                        arrCoa.push({id:item.jurnal_master_detail_id , coa_master_id:item.coa_master_id, name:item.coa_master_title, number:item.coa_master_number, kredit:item.jurnal_master_detail_kredit, debet:item.jurnal_master_detail_debet, note:item.jurnal_master_detail_note});
                        arrExcept.push(item.coa_master_id);
                    });
                }
                insertToList();
                $('#modal').modal({
                    backdrop: 'static',
                    keyboard: false
                }, 'show');
            }else{
                alert(res.msg);
            }
        });
    }
    
    function openModalDetail(id){
        $('#jurnal-title-detail').val('');
        $('#jurnal-type-detail').val('');
        ajaxRequest('common/general/setup/jurnal_master/get_detail', 'GET', {id:id}, function(res) {
            if(res.status == 200){
                let jurnal = res.data;
                let detail = jurnal.detail;
                let arrJurnalType = [{name:'Memorial'}, {name:'Otomatis'}];
                $('#jurnal-title-detail').val(jurnal.jurnal_master_title);
                $('#jurnal-type-detail').val(arrJurnalType[jurnal.jurnal_master_type].name);
                let totalKredit = 0;
                let totalDebet = 0;
                let html = '';
                if(detail.length > 0){
                    detail.forEach(function (item, index){
                        html += `<tr>
                                    <td style="width: 40%;">${item.coa_master_number} - ${item.coa_master_title}</td>
                                    <td style="width: 15%; text-align: right;">${number_format(item.jurnal_master_detail_debet)}</td>
                                    <td style="width: 15%; text-align: right;">${number_format(item.jurnal_master_detail_kredit)}</td>
                                    <td style="width: 30%;">${item.jurnal_master_detail_note}</td>
                                </tr>`;
                        totalKredit = totalKredit + item.jurnal_master_detail_kredit;
                        totalDebet = totalDebet + item.jurnal_master_detail_debet;
                    });
                }else{
                     html += `<tr>
                                <td colspan="4">Belum ada data.</td>
                            </tr>`;
                }
                
                $('#table-body-detail tbody').html(html);
                $('#total-kredit-detail').text(number_format(totalKredit));
                $('#total-debet-detail').text(number_format(totalDebet));
                
                $('#modal-detail').modal('show');
            }else{
                alert(res.msg);
            }
        });
    }
    
    function openModalChooseCoa(){
        loadTreegridAktiva();
        loadTreegridPasiva();
        loadTreegridPendapatan();
        loadTreegridBiaya();
        loadTreegridNominal();
        $('#modal').modal('hide');
        $('#modal-coa').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
    }
    
    function closeModalChooseCoa(){
        $('#modal-coa').modal('hide');
        $('#modal').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
    }
    
    function addToList(type){
        let node = $('#treegrid-' + type).fancytree('getTree').getSelectedNodes();
        if(node.length > 0){
            let strMsgNotif = '';
            let strNameDuplicate = '';
            let comma = '';
            let success = 0;
            let failed = 0;
            node.forEach(function(item, index){
                let res = checkDuplicate({coa_master_id:item.key, name:item.data.coaName}); 
                if(res.isDuplicate){
                    strNameDuplicate += comma + res.name;
                    comma = ', '
                    failed++;
                }else{
                    arrCoa.push({coa_master_id:item.key, name:item.data.coaName, number:item.title, kredit:0, debet:0, note:''});
                    arrExcept.push(item.key);
                    success++;
                }
            });
            insertToList();
            if(success > 0){
                strMsgNotif = `Berhasil menambahkan Akun ke list Jurnal.`;
                if(failed > 0){
                    strMsgNotif += `\nAkun "${strNameDuplicate}" sudah ada pada list Jurnal. Pilih akun yang belum ada.`;
                }
                switch (type) {
                    case 'aktiva':
                        loadTreegridAktiva();
                        break;
                    case 'pasiva':
                        loadTreegridPasiva();
                        break;
                    case 'pendapatan':
                        loadTreegridPendapatan();
                        break;
                    case 'biaya':
                        loadTreegridBiaya();
                        break;
                    case 'nominal':
                        loadTreegridNominal();
                        break;
                }
            }else{
                strMsgNotif = `Akun "${strNameDuplicate}" sudah ada pada list Jurnal. Pilih akun yang belum ada.`;
            }
            if(failed > 0){
                alert(strMsgNotif);
            }
        }else{
            alert('Anda belum memilih data.');
        }
    }
    
    function checkDuplicate(data){
        let responseDuplicate = {isDuplicate: false, key: 0};
        arrCoa.forEach(function (item, index) {
            if (item.coa_master_id === data.coa_master_id) {
                responseDuplicate = {isDuplicate: true, name: data.name};
            }
        });
        return responseDuplicate;
    }
    
    function insertToList(){
        let html = '';
        if(arrCoa.length > 0){
            arrCoa.forEach(function (item, index){
                html += `<tr>
                            <td style="width: 6%; text-align:center;"><a href="javascript:;" onclick="deleteRow(${index})"><img src="${siteUrl}addons/flexigrid/button/images/close.png" border="0" alt="Hapus" title="Hapus" /></a></td>
                            <td style="width: 34%;">${item.number} - ${item.name}</td>
                            <td class="have-input" style="width: 15%; text-align: right;"><input onkeyup="insertValue(this, 'debet', ${index})" type="text" class="text-right input-curency" style="width: 100%" value="${number_format(item.debet)}"></td>
                            <td class="have-input" style="width: 15%; text-align: right;"><input onkeyup="insertValue(this, 'kredit', ${index})" type="text" class="text-right input-curency" style="width: 100%" value="${number_format(item.kredit)}"></td>
                            <td class="have-input" style="width: 30%;"><input onkeyup="insertValue(this, 'note', ${index})" type="text" style="width: 100%" value="${item.note}"></td>
                        </tr>`;
            });
        }else{
            html += `<tr>
                        <td colspan="5">Belum ada data. Silahkan klik tombol <strong>Pilih Dari Daftar Akun</strong> terlebih dahulu.</td>
                    </tr>`;
        }
        $('#table-body tbody').html(html);
        setMaskMoney('.input-curency');
        countTotal();
    }
    
    function insertValue(element, type, key){
        let value = $(element).val();
        switch (type) {
            case 'kredit':
                value = convertFormatRp(value);
                arrCoa[key].kredit = value;
                countTotal();
                break;
            case 'debet':
                value = convertFormatRp(value);
                arrCoa[key].debet = value;
                countTotal();
                break;
            case 'note':
                arrCoa[key].note = value;
                break;
        }
    }
    
    function countTotal(){
        let totalKredit = 0;
        let totalDebet = 0;
        if(arrCoa.length > 0){
            arrCoa.forEach(function (item, index){
                totalKredit = totalKredit + arrCoa[index].kredit;
                totalDebet = totalDebet + arrCoa[index].debet;
            });
        }
        $('#total-kredit').text(number_format(totalKredit));
        $('#total-debet').text(number_format(totalDebet));
    }
    
    function deleteRow(key){
        arrCoa.splice(key, 1);
        arrExcept.splice(key, 1);
        insertToList();
    }
    
    function deleteData(com, grid, urlaction){
        let grid_id = $(grid).attr('id');
        grid_id = grid_id.substring(grid_id.lastIndexOf('grid_') + 5);
        let totalSelected = $('.trSelected', grid).length;
        if (totalSelected > 0) {
            if(confirm(`Yakin akan menghapus ${totalSelected} jurnal ?\nData tidak dapat dikembalikan lagi!`)){
                let arrId = [];
                $('.trSelected', grid).each(function () {
                    let id = $(this).attr('data-id');
                    arrId.push(id);
                });
                ajaxRequest('setup/jurnal_master/act_delete', 'POST', {item: JSON.stringify(arrId)}, function(res){
                    $('#' + grid_id).flexReload();
                    let msgClass =  res.status == 200 ? 'response_confirmation alert alert-success' : 'response_confirmation alert alert-danger';
                    $("#response_message").finish();
                    $("#response_message").addClass(msgClass);
                    $("#response_message").slideDown("fast");
                    let msg = res.status == 200 ? res.data : res.msg;
                    $("#response_message").html(`<p>${msg}</p>`);
                    $("#response_message").delay(10000).slideUp(1000, function () {
                        $("#response_message").removeClass(msgClass);
                    });
                });
            }
        }else{
            alert('Pilih terlebih dahulu data yang ingin dihapus.');
        }
    }
    
    function selectAll(type){
        $('#treegrid-' + type).fancytree("getTree").visit(function(node){
            node.setSelected(true);
        });
    }
    
    function unSelectAll(type){
        $('#treegrid-' + type).fancytree("getTree").visit(function(node){
            node.setSelected(false);
        });
    }
    
    function loadTreegridAktiva(){
        if(typeof treegridAktiva == 'undefined'){
            treegridAktiva = $("#treegrid-aktiva").fancytree({
                extensions: ["table"],
                checkbox: true,
                aria: true,
                table: {
                    indentation: 20,
                    nodeColumnIdx: 1,
                    checkboxColumnIdx: 0
                },
                source: {
                    url: siteUrl + 'setup/jurnal_master/get_data_coa/aktiva?except=' + JSON.stringify(arrExcept)
                },
                renderColumns: function (e, data) {
                    let node = data.node;
                    if(node.data.isExcept){
                        $(node.tr).find(".fancytree-checkbox").remove();
                    }
                    $tdList = $(node.tr).find(">td");
                    $tdList.eq(1).text(node.data.title);
                    $tdList.eq(2).text(node.data.coaName).addClass("alignLeft");
                },
                init: function (event, data) {
                    if (data.tree.count() == 0) {
                        $('#treegrid-aktiva').find("tbody tr").remove();
                        $('#treegrid-aktiva').find("tbody").append(`
                                        <tr>
                                            <td colspan="3">Data belum ada.</td>
                                        <tr>
                                    `);
                    }
                }
            });
        }else{
            treegridAktiva.fancytree('option', 'source', {
                url: siteUrl + 'setup/jurnal_master/get_data_coa/aktiva?except=' + JSON.stringify(arrExcept),
                success: function (res) {
                    if (res.length === 0) {
                        $('#treegrid-aktiva').find("tbody tr").remove();
                        $('#treegrid-aktiva').find("tbody").append(`
                                        <tr>
                                            <td colspan="3">Data belum ada.</td>
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
                extensions: ["table"],
                checkbox: true,
                aria: true,
                table: {
                    indentation: 20,
                    nodeColumnIdx: 1,
                    checkboxColumnIdx: 0
                },
                source: {
                    url: siteUrl + 'setup/jurnal_master/get_data_coa/pasiva?except=' + JSON.stringify(arrExcept)
                },
                renderColumns: function (e, data) {
                    let node = data.node;
                    if(node.data.isExcept){
                        $(node.tr).find(".fancytree-checkbox").remove();
                    }
                    $tdList = $(node.tr).find(">td");
                    $tdList.eq(1).text(node.data.title);
                    $tdList.eq(2).text(node.data.coaName).addClass("alignLeft");
                },
                init: function (event, data) {
                    if (data.tree.count() == 0) {
                        $('#treegrid-pasiva').find("tbody tr").remove();
                        $('#treegrid-pasiva').find("tbody").append(`
                                        <tr>
                                            <td colspan="3">Data belum ada.</td>
                                        <tr>
                                    `);
                    }
                }
            });
        }else{
            treegridPasiva.fancytree('option', 'source', {
                url: siteUrl + 'setup/jurnal_master/get_data_coa/pasiva?except=' + JSON.stringify(arrExcept),
                success: function (data) {
                    if (data.length === 0) {
                        $('#treegrid-pasiva').find("tbody tr").remove();
                        $('#treegrid-pasiva').find("tbody").append(`
                                        <tr>
                                            <td colspan="3">Data belum ada.</td>
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
                extensions: ["table"],
                checkbox: true,
                aria: true,
                table: {
                    indentation: 20,
                    nodeColumnIdx: 1,
                    checkboxColumnIdx: 0
                },
                source: {
                    url: siteUrl + 'setup/jurnal_master/get_data_coa/pendapatan?except=' + JSON.stringify(arrExcept)
                },
                renderColumns: function (e, data) {
                    let node = data.node;
                    if(node.data.isExcept){
                        $(node.tr).find(".fancytree-checkbox").remove();
                    }
                    $tdList = $(node.tr).find(">td");
                    $tdList.eq(1).text(node.data.title);
                    $tdList.eq(2).text(node.data.coaName).addClass("alignLeft");
                },
                init: function (event, data) {
                    if (data.tree.count() == 0) {
                        $('#treegrid-pendapatan').find("tbody tr").remove();
                        $('#treegrid-pendapatan').find("tbody").append(`
                                        <tr>
                                            <td colspan="3">Data belum ada.</td>
                                        <tr>
                                    `);
                    }
                }
            });
        }else{
            treegridPendapatan.fancytree('option', 'source', {
                url: siteUrl + 'setup/jurnal_master/get_data_coa/pendapatan?except=' + JSON.stringify(arrExcept),
                success: function (data) {
                    if (data.length === 0) {
                        $('#treegrid-pendapatan').find("tbody tr").remove();
                        $('#treegrid-pendapatan').find("tbody").append(`
                                        <tr>
                                            <td colspan="3">Data belum ada.</td>
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
                extensions: ["table"],
                checkbox: true,
                aria: true,
                table: {
                    indentation: 20,
                    nodeColumnIdx: 1,
                    checkboxColumnIdx: 0
                },
                source: {
                    url: siteUrl + 'setup/jurnal_master/get_data_coa/biaya?except=' + JSON.stringify(arrExcept)
                },
                renderColumns: function (e, data) {
                    let node = data.node;
                    if(node.data.isExcept){
                        $(node.tr).find(".fancytree-checkbox").remove();
                    }
                    $tdList = $(node.tr).find(">td");
                    $tdList.eq(1).text(node.data.title);
                    $tdList.eq(2).text(node.data.coaName).addClass("alignLeft");
                },
                init: function (event, data) {
                    if (data.tree.count() == 0) {
                        $('#treegrid-biaya').find("tbody tr").remove();
                        $('#treegrid-biaya').find("tbody").append(`
                                        <tr>
                                            <td colspan="3">Data belum ada.</td>
                                        <tr>
                                    `);
                    }
                }
            });
        }else{
            treegridBiaya.fancytree('option', 'source', {
                url: siteUrl + 'setup/jurnal_master/get_data_coa/biaya?except=' + JSON.stringify(arrExcept),
                success: function (data) {
                    if (data.length === 0) {
                        $('#treegrid-biaya').find("tbody tr").remove();
                        $('#treegrid-biaya').find("tbody").append(`
                                        <tr>
                                            <td colspan="3">Data belum ada.</td>
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
                extensions: ["table"],
                checkbox: true,
                aria: true,
                table: {
                    indentation: 20,
                    nodeColumnIdx: 1,
                    checkboxColumnIdx: 0
                },
                source: {
                    url: siteUrl + 'setup/jurnal_master/get_data_coa/nominal?except=' + JSON.stringify(arrExcept)
                },
                renderColumns: function (e, data) {
                    let node = data.node;
                    if(node.data.isExcept){
                        $(node.tr).find(".fancytree-checkbox").remove();
                    }
                    $tdList = $(node.tr).find(">td");
                    $tdList.eq(1).text(node.data.title);
                    $tdList.eq(2).text(node.data.coaName).addClass("alignLeft");
                },
                init: function (event, data) {
                    if (data.tree.count() == 0) {
                        $('#treegrid-nominal').find("tbody tr").remove();
                        $('#treegrid-nominal').find("tbody").append(`
                                        <tr>
                                            <td colspan="3">Data belum ada.</td>
                                        <tr>
                                    `);
                    }
                }
            });
        }else{
            treegridNominal.fancytree('option', 'source', {
                url: siteUrl + 'setup/jurnal_master/get_data_coa/nominal?except=' + JSON.stringify(arrExcept),
                success: function (data) {
                    if (data.length === 0) {
                        $('#treegrid-nominal').find("tbody tr").remove();
                        $('#treegrid-nominal').find("tbody").append(`
                                        <tr>
                                            <td colspan="3">Data belum ada.</td>
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
    
    $("#gridview").flexigrid({
        url: siteUrl + 'setup/jurnal_master/get_data',
        dataType: 'json',
        colModel: [
            <?php if(privilege_view('update', $this->menu_privilege)):
                echo "{display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false},";
            endif; ?>
            {display: 'Detail', name: 'detail', width: 40, sortable: false, align: 'center', datasource: false},
            {display: 'Nama Jurnal', name: 'jurnal_master_title', width: 200, sortable: true, align: 'left'},
            {display: 'Tipe Jurnal', name: 'jurnal_master_type', width: 100, sortable: true, align: 'center'},
            {display: 'Terakhir Berubah', name: 'jurnal_master_last_update', width: 200, sortable: true, align: 'center'},
        ],
        buttons: [
            <?php if(privilege_view('add', $this->menu_privilege)):
                echo "{display: 'Tambah Template', name: 'add', bclass: 'add', onpress: openModalAdd},";
            endif;
            if(privilege_view('delete', $this->menu_privilege)):
                echo "
                    {separator: true},
                    {display: 'Pilih Semua', name: 'selectall', bclass: 'selectall', onpress: check},
                    {separator: true},
                    {display: 'Hapus Pilihan', name: 'selectnone', bclass: 'selectnone', onpress: check},
                    {separator: true},
                    {display: 'Hapus Jurnal', name: 'delete', bclass: 'delete', onpress: deleteData},
                    ";
            endif; ?>
        ],
        buttons_right: [
            <?php if(privilege_view('export', $this->menu_privilege)):
                echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("setup/jurnal_master/export_data_jurnal") . "'}";
            endif; ?>
        ],
        searchitems: [
            {display: 'Nama Jurnal', name: 'jurnal_master_title', type: 'text'},
            {display: 'Tipe Jurnal', name: 'jurnal_master_type', type: 'select', option:'0:Memorial|1:Otomatis'},
            {display: 'Terakhir Berubah', name: 'jurnal_master_last_update', type: 'date'},
        ],
        sortname: "jurnal_master_id",
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
    
    $(document).ready(function (){
        $('.my-select2').select2({
            dropdownParent: $('#modal')
        });
        
//        $('#table-body').slimScroll();
        
        $('#container-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href"); // activated tab
            if (target === '#tab-aktiva') {
                loadTreegridAktiva();
            } else if (target === '#tab-pasiva') {
                loadTreegridPasiva();
            } else if (target === '#tab-pendapatan') {
                loadTreegridPendapatan();
            } else if (target === '#tab-biaya') {
                loadTreegridBiaya();
            } else if (target === '#tab-nominal') {
                loadTreegridNominal();
            }
        });
        
        $('#form').on('submit', function (e) {
            e.preventDefault();
            $('#form button[type="submit"]').attr('disabled', 'disabled');

            var urlForm = $('#form').attr('data-url');
            var dataForm = new FormData(this);
            dataForm.append('arr_coa', JSON.stringify(arrCoa));

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
                        $('#form button[type="submit"]').removeAttr('disabled');
                        $('#modal').modal('hide');
                        $("#gridview").flexReload();
                        let message_class = 'response_confirmation alert alert-success';

                        $("#response_message").finish();

                        $("#response_message").addClass(message_class);
                        $("#response_message").slideDown("fast");
                        $("#response_message").html(res.data);
                        $("#response_message").delay(10000).slideUp(1000, function () {
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
                error: function (err) {
                    $('#form-add button[type="submit"]').removeAttr('disabled');
                }
            });
        });
    });
    
    // for set number format
    function number_format(number, decimals = 0, decPoint = ',', thousandsSep = '.') {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        let n = !isFinite(+number) ? 0 : +number;
        let prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
        let sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep;
        let dec = (typeof decPoint === 'undefined') ? '.' : decPoint;
        let s = '';

        let toFixedFix = function (n, prec) {
            let k = Math.pow(10, prec);
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

    // for convert format Rp in integer
    function convertFormatRp(currency) {
        let value = currency.replace('Rp. ', '');
        return parseInt(value.replace(/\./g, ''));
    }
    
    // for set maskmoney
    function setMaskMoney(element, prefix = '', allowNegative = false, precision = 0, allowZero = true) {
        $(element).maskMoney({
            prefix: prefix,
            suffix: '',
            allowNegative: allowNegative,
            thousands: '.',
            decimal: ',',
            affixesStay: true,
            precision: precision,
            allowZero: allowZero
        });
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
    
    $.validate({
        modules: 'logic',
        lang: 'id'
    });
</script>
<!-- TreeView Librabry -->
<script src="<?php echo THEMES_BACKEND; ?>/js/fancytree/jquery.fancytree.min.js" type="text/javascript"></script>
<script src="<?php echo THEMES_BACKEND; ?>/js/fancytree/jquery.fancytree.table.js" type="text/javascript"></script>
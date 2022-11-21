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
    .table-like-flexigrid thead tr.first.title th{
        background: rgba(29, 89, 162, 0.05);
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
    .table-like-flexigrid .fbutton .print{
        background: url(<?php echo site_url('addons/flexigrid/button/images/printer.png'); ?>) no-repeat scroll left center transparent;
    }
    .table-like-flexigrid .fbutton .search{
        background: url(<?php echo site_url('addons/flexigrid/button/images/magnifier.png'); ?>) no-repeat scroll left center transparent;
    }
    .table-like-flexigrid .fbutton .reset{
        background: url(<?php echo site_url('addons/flexigrid/button/images/undo.png'); ?>) no-repeat scroll left center transparent;
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
    .table-like-flexigrid .flabel{
        background: transparent;
        float: left;
        padding: 3px;
    }
    .table-like-flexigrid .fbutton span{
        padding: 3px;
        padding-left: 20px;
    }
    .table-like-flexigrid .fbutton.no-icon span{
        padding: 3px;
    }
    .table-like-flexigrid .fbuttonseparator{
        float: left;
        height: 22px;
        border-left: 1px solid #ccc;
        border-right: 1px solid #fff;
        margin: 1px;
    }
    .main_container .select2-selection--single{
        height: 32px !important;
        min-height: auto !important;
    }
    .main_container .select2-selection__rendered{
        padding-top: 2px !important;
    }
    .main_container .select2-selection__arrow{
        height: 32px !important;
    }
    .input-sm + span.select2-container--default span.select2-selection--single {
        height: 30px!important;
        min-height: 30px!important;
    }
    .input-sm + span.select2-container--default span.select2-selection--single span.select2-selection__arrow {
        height: 30px!important;
    }
    .input-sm + span.select2-container--default span.select2-selection--single span.select2-selection__rendered {
        line-height: 24px !important;
    }
    .ui-autocomplete {
         max-height: 200px;
         overflow-y: auto;
         overflow-x: hidden;
         padding-right: 20px;
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
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <table style="width: 100%;" class="table-like-flexigrid">
            <thead>
                <tr class="first title" style="border: 1px solid #ccc;">
                    <th>
                        <div class="btn-action-left">
                            <div class="fbutton" onclick="openModalAdd()"><span class="add">Input Jurnal Memorial</span></div>
                            <div class="fbuttonseparator"></div>
                            <div class="flabel"><span><strong>Cari berdasarkan:</strong></span></div>
                            <div class="flabel">
                                <select id="input-search-by" style="width: 110px;">
                                    <option value="date">Tgl Jurnal</option>
                                    <option value="trans_number">No Bukti</option>
                                    <option value="trans_number_manual">No Bukti Manual</option>
                                    <option value="coa_number">No. Rekening</option>
                                    <option value="coa_title">Nama Rekening</option>
                                    <option value="note">Keterangan</option>
                                </select>
                            </div>
                            <div class="flabel">
                                <input id="input-search" type="text" style="width: 200px; height: 17.2px;">
                            </div>
                            <div class="fbutton" onclick="searchJurnal()"><span class="search">CARI</span></div>
                            <div class="fbuttonseparator"></div>
                            <div class="fbutton" onclick="resetJurnal()"><span class="reset">RESET</span></div>
                            <div class="fbuttonseparator"></div>
                            <div class="flabel"><span><strong>Limit data:</strong></span></div>
                            <div class="flabel">
                                <select id="input-limit" style="width: 70px;">
                                    <option value="100">100</option>
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                </select>
                            </div>
                        </div>
                        <div class="btn-action-right">
                            <div class="fbutton" onclick="printJurnal()"><span class="print">Print</span></div>
                        </div>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div id="container-jurnal" class="row"></div>
    </div>
</div>

<!-- MODAL ADD -->
<div id="modal-add" class="modal fade" role="dialog">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Input Jurnal Memorial</h4>
            </div>
            <form id="form-add" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body" style="overflow-y: auto; height: calc(100vh - 200px);">
                    <div id="modal-response-message-add" class="alert alert-danger alert-dismissible fade in" role="alert" style="display:none"></div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="coa">Rekening </label>
                                    <div class="col-md-5 col-sm-5 col-xs-12">
                                        <input type="text" id="input-autocomplete-coa" class="input-sm form-control" placeholder="Ketikan nomor atau nama rekening">
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-12">
                                        <button type="button" class="btn btn-default btn-round btn-sm" onclick="openModalChooseCoa()">Lihat COA</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="ln_solid"></div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12">Tanggal <span class="required">*</span></label>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <input type="text" name="date" class="form-control input-sm my-input-mask" 
                                        data-inputmask="'alias':'date'"
                                        data-validation="required">
                                    </div>
                                </div>
                            </div>
                        </div>

<!--                        <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="jurnal-type">Jenis Jurnal </label>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <select name="jurnal_type" class="form-control my-select2 input-sm">
                                            <option>Laba Rugi</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>-->

                        <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                            <table style="width: 100%;" class="table-like-flexigrid">
                                <thead>
                                    <tr class="first">
                                        <th colspan="6">
                                            <div class="btn-action-left">
                                                <div class="fbutton" onclick="openModalChooseJurnal()"><span class="list">Ambil Dari Template</span></div>
                                                <div class="fbuttonseparator"></div>
                                                <div class="flabel"><span><strong>Nama Jurnal:</strong></span></div>
                                                <div class="flabel">
                                                    <input id="input-jurnal-title" type="text" name="title" style="width: 200px; height: 17.2px;">
                                                </div>
                                                <div class="flabel"><span><strong>Diisi bila jurnal ingin disimpan sebagai template, jika tidak maka dikosongkan.</strong></span></div>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th style="width: 4%; text-align: center"><a href="javascript:;" onclick="deleteRow('all')"><img src="<?php echo site_url('addons/flexigrid/button/images/close.png'); ?>" border="0" alt="Hapus Semua" title="Hapus Semua"></a></th>
                                        <th style="width: 25%;"><strong>No. Rekening</strong></th>
                                        <th style="width: 10%; text-align: center"><strong>No. Bukti Manual</strong></th>
                                        <th><strong>Keterangan</strong></th>
                                        <th style="width: 15%; text-align: right;"><strong>Debet (Rp)</strong></th>
                                        <th style="width: 15%; text-align: right;"><strong>Kredit (Rp)</strong></th>
                                    </tr>
                                </thead>
                            </table>
                            <div id="table-body">
                                <table id="grid-jurnal" class="table-like-flexigrid" style="width: 100%;">
                                    <tbody></tbody>
                                </table>
                            </div>
                            <table class="table-like-flexigrid" style="width: 100%;">
                                <tfoot>
                                    <tr>
                                        <th style="width: 4%;"></th>
                                        <th colspan="3" style="text-align: right; font-weight: bold;"> TOTAL</th>
                                        <th style="width: 15%; text-align: right; font-weight: bold;" id="total-debet">0</th>
                                        <th style="width: 15%; text-align: right; font-weight: bold;" id="total-kredit">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button tabindex="2" type="submit" class="btn btn-primary hide-on-detail"><i class="fa fa-save"></i>&nbsp; Simpan <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL ADD -->

<!-- MODAL TEMPLATE JURNAL -->
<div id="modal-master" class="modal" role="dialog">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Pilih Template Jurnal</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12" style="padding-right: 5px;">
                        <table id="gridview-master" style="display:none;"></table>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12" style="padding-left: 5px;">
                        <table id="gridview-detail" style="display:none;"></table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL TEMPLATE JURNAL -->

<!-- MODAL COA -->
<div id="modal-coa" class="modal fade" role="dialog">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
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
                <button type="button" class="btn btn-default" data-dismiss="modal"">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL COA -->

<!-- TREEVIEW LIBRARY -->
<script src="<?php echo THEMES_BACKEND; ?>/js/fancytree/jquery.fancytree.min.js" type="text/javascript"></script>
<script src="<?php echo THEMES_BACKEND; ?>/js/fancytree/jquery.fancytree.table.js" type="text/javascript"></script>

<!--FORM VALIDATOR-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<!--MASK MONEY-->   
<script src="<?php echo THEMES_BACKEND; ?>/js/jquery.maskMoney.min.js"></script>

<script>
    
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    let arrCoa = [];
    
    let arrCoaAutocompleteMaster = <?php echo json_encode($arr_data_autocomplete); ?>;
    let arrCoaAutocomplete = [];
    
    let arrExcept = [];
    
    var treegridAktiva;
    var treegridPasiva;
    var treegridPendapatan;
    var treegridBiaya;
    var treegridNominal;
    
    let searchByNow = '';
    let searchValueNow = '';
    
    function searchJurnal(){
        let searchBy = $('#input-search-by').val();
        let searchValue = $('#input-search').val();
        let limit = $('#input-limit').val();
        
        loadData(limit, searchBy, searchValue);
    }
    
    function resetJurnal(){
        $('#input-search-by').val('date').change();
        $('#input-search').val('');
        searchJurnal();
    }
    
    function printJurnal() {
        let arrSearchBy = {
            date: 'Tanggal',
            trans_number: 'Dengan No. Bukti',
            trans_number_manual: 'Dengan No. Bukti Manual',
            coa_number: 'Dengan Nomor Rekening',
            coa_title: 'Dengan Nama Rekening',
            note: 'Dengan Keterangan',
        };
        
        let newTab = window.open();
        let title = '';
        if(searchValueNow != '' && typeof arrSearchBy[searchByNow] != "undefined"){
            title = arrSearchBy[searchByNow] + ' ' + searchValueNow;
        }
        let html = `
            <title>List Jurnal ${title}<\/title>
            <style>
                table, th, td{
                    border-collapse: collapse;
                    border: 1px solid black;
                    font-size: 12px;
                }
            <\/style>
        `;
        html += $("#container-jurnal").html();

        $(newTab.document.body).html(html);
        newTab.print();
    }
    
    function loadData(limit = 100, searchBy = '', searchValue = ''){
        searchByNow = '';
        searchValueNow = '';
        if(searchValue != ''){
            searchByNow = searchBy;
            searchValueNow = searchValue;
        }
        
        let params = {
            limit: limit,
            search_by: searchBy,
            search_value: searchValue
        }
        ajaxRequest('accounting/jurnal/get_data', method = 'GET', params, function (res){
            if(res.status == 200){
                let result = res.data.results;
                let html = '';
                
                if(result.length > 0){
                    result.forEach(function(item, index){
                        let htmlBody = '';
                        if(item.data.length > 0){
                            item.data.forEach(function(itemData, indexData){
                                htmlBody += `
                                    <tr>
                                        <td style="text-align: center;">${moment(itemData.ledger_datetime).format("DD MMMM YYYY")}</td>
                                        <td style="text-align: center;">${itemData.ledger_trans_number}</td>
                                        <td style="text-align: center;">${itemData.ledger_trans_number_manually}</td>
                                        <td>${itemData.coa_master_number} - ${itemData.coa_master_title}</td>
                                        <td>${itemData.ledger_note}</td>
                                        <td style="text-align: right;">${number_format(itemData.ledger_debet)}</td>
                                        <td style="text-align: right;">${number_format(itemData.ledger_kredit)}</td>
                                    </tr>
                                `;
                            });
                        }
                        html += `
                            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px">
                                <table style="width: 100%;" class="table-like-flexigrid">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%; text-align: center;"><strong>TGL JURNAL</strong></th>
                                            <th style="width: 10%; text-align: center;"><strong>No. Bukti</strong></th>
                                            <th style="width: 10%; text-align: center;"><strong>No. Bukti Manual</strong></th>
                                            <th style="width: 12%; text-align: center;"><strong>NAMA REKENING</strong></th>
                                            <th style="text-align: center;"><strong>KETERANGAN</strong></th>
                                            <th style="width: 12%; text-align: center;"><strong>DEBET (Rp)</strong></th>
                                            <th style="width: 12%; text-align: center;"><strong>KREDIT (Rp)</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${htmlBody}
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" style="text-align: right;"><strong>TOTAL</strong></th>
                                            <th style="text-align: right;"><strong>${number_format(item.total.debet)}</strong></th>
                                            <th style="text-align: right;"><strong>${number_format(item.total.kredit)}</strong></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        `; 
                    });
                }else{
                    html += `
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px">
                            <p>Belum ada data.</p>
                        </div>
                    `;
                }
                
                $('#container-jurnal').html(html);
            }else{
                alert(res.msg);
            }
        });
    }
    
    function openModalAdd(){
        clearForm();
        $('#modal-add').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
    }
    
    function clearForm(){
        $('#form-add').trigger('reset');
//        $('#jurnal-type').val('').change();
        arrCoa = [];
        arrExcept = [];
        insertToList();
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
                    comma = ', ';
                    failed++;
                }else{
                    arrCoa.push({coa_master_id:item.key, name:item.data.coaName, number:item.title, kredit:0, debet:0, note:'', manual_code:''});
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
        arrCoaAutocomplete = [];
        arrCoaAutocompleteMaster.forEach(function(item, index){
            if(!arrExcept.includes(item.data.coa_master_id)){
                arrCoaAutocomplete.push(item);
            }
        });
        
        let html = '';
        if(arrCoa.length > 0){
            arrCoa.forEach(function (item, index){
                html += `
                    <tr>
                        <td style="width: 4%; text-align: center"><a href="javascript:;" onclick="deleteRow(${index})"><img src="${siteUrl}addons/flexigrid/button/images/close.png" border="0" alt="Hapus" title="Hapus"></a></td>
                        <td style="width: 25%;">${item.number} - ${item.name}</td>
                        <td class="have-input" style="width: 10%; text-align: center"><input onkeyup="insertValue(this, 'manual_code', ${index})" type="text" style="width: 100%" value="${item.manual_code}"></td>
                        <td class="have-input"><input onkeyup="insertValue(this, 'note', ${index})" type="text" style="width: 100%" value="${item.note}"></td>
                        <td class="have-input" style="width: 15%; text-align: right;"><input onkeyup="insertValue(this, 'debet', ${index})" type="text" class="text-right input-curency" style="width: 100%" value="${number_format(item.debet)}"></td>
                        <td class="have-input" style="width: 15%; text-align: right;"><input onkeyup="insertValue(this, 'kredit', ${index})" type="text" class="text-right input-curency" style="width: 100%" value="${number_format(item.kredit)}"></td>
                    </tr>
                `;
            });
        }else{
            html += `<tr>
                        <td colspan="6">Belum ada data. Silahkan klik tombol <strong>Pilih Dari Daftar Akun</strong> terlebih dahulu.</td>
                    </tr>`;
        }
        $('#grid-jurnal tbody').html(html);
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
            case 'manual_code':
                arrCoa[key].manual_code = value;
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
        $('#total-debet').text(number_format(totalDebet));
        $('#total-kredit').text(number_format(totalKredit));
    }
    
    function deleteRow(key){
        if(key == 'all'){
            if(arrCoa.length > 0){
                if(confirm('Yakin akan menghapus semua list jurnal?')){
                    arrCoa = [];
                    arrExcept = [];
                }
            }else{
                alert('Tidak ada data untuk dihapus.');
            }
        }else{
            arrCoa.splice(key, 1);
            arrExcept.splice(key, 1);
        }
        insertToList();
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
    
    function openModalChooseJurnal(){
        loadMaster();
        loadDetail(0);
        $('#modal-master').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
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
                    url: siteUrl + 'accounting/jurnal/get_data_coa/aktiva?except=' + JSON.stringify(arrExcept)
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
                url: siteUrl + 'accounting/jurnal/get_data_coa/aktiva?except=' + JSON.stringify(arrExcept),
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
                    url: siteUrl + 'accounting/jurnal/get_data_coa/pasiva?except=' + JSON.stringify(arrExcept)
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
                url: siteUrl + 'accounting/jurnal/get_data_coa/pasiva?except=' + JSON.stringify(arrExcept),
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
                    url: siteUrl + 'accounting/jurnal/get_data_coa/pendapatan?except=' + JSON.stringify(arrExcept)
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
                url: siteUrl + 'accounting/jurnal/get_data_coa/pendapatan?except=' + JSON.stringify(arrExcept),
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
                    url: siteUrl + 'accounting/jurnal/get_data_coa/biaya?except=' + JSON.stringify(arrExcept)
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
                url: siteUrl + 'accounting/jurnal/get_data_coa/biaya?except=' + JSON.stringify(arrExcept),
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
    
    function addToConfig(com, grid, urlaction){
        let grid_id = $(grid).attr('id');
        grid_id = grid_id.substring(grid_id.lastIndexOf('grid_') + 5);
        if ($('.trSelected', grid).length > 0) {
            let id = $('.trSelected', grid).attr('data-id');
            ajaxRequest('accounting/jurnal/get_jurnal_master_detail', 'GET', {jurnal_master_id: id}, function(res) {
                if(res.status == 200){
                    $('#jurnal-master-id').val(id);
                    let jurnalMasterDetail = res.data.results;
                    arrCoa = [];
                    arrExcept = [];
                    if(jurnalMasterDetail.length > 0){
                        jurnalMasterDetail.forEach(function(item, index){
                            arrCoa.push({coa_master_id:item.coa_master_id, name:item.coa_master_title, number:item.coa_master_number, kredit:item.jurnal_master_detail_kredit, debet:item.jurnal_master_detail_debet, note:item.jurnal_master_detail_note, manual_code:''});
                            arrExcept.push(item.coa_master_id);
                        });
                    }
                    insertToList();
                    $('#modal-master').modal('hide');
                }else{
                    alert(res.msg);
                }
            });
        }else{
            alert('Pilih data terlebih duahulu.');
        }
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
                    url: siteUrl + 'accounting/jurnal/get_data_coa/nominal?except=' + JSON.stringify(arrExcept)
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
                url: siteUrl + 'accounting/jurnal/get_data_coa/nominal?except=' + JSON.stringify(arrExcept),
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
    
    function loadMaster(){
        if(typeof gridMaster == 'undefined'){
            gridMaster = $("#gridview-master").flexigrid({
                url: siteUrl + 'accounting/jurnal/get_data_jurnal_master',
                dataType: 'json',
                colModel: [
                    {display: 'Nama Jurnal', name: 'jurnal_master_title', width: 230, sortable: true, align: 'left'},
                    {display: 'Tipe Jurnal Master', name: 'jurnal_master_type', width: 200, sortable: true, align: 'left'},
                ],
                buttons: [
                    <?php if(privilege_view('add', $this->menu_privilege)):
                        echo "{display: 'Tambahkan ke list Jurnal', name: 'add', bclass: 'add', onpress: addToConfig},";
                    endif; ?>
                ],
                searchitems: [
                    {display: 'Jurnal Master', name: 'jurnal_config_jurnal_master_id', type: 'text'},
                    {display: 'Nama Variabel Konfig', name: 'jurnal_config_name', type: 'text'},
                    {display: 'Nama Konfig Jurnal', name: 'jurnal_config_title', type: 'text'},
                ],
                sortname: "jurnal_master_id",
                sortorder: "desc",
                usepager: true,
                title: 'Data Jurnal Master',
                useRp: true,
                rp: 10,
                showTableToggleBtn: false,
                showToggleBtn: true,
                width: 'auto',
                height: '300',
                resizable: false,
                singleSelect: true
            });
        }else{
            $("#gridview-master").flexOptions({
                url: siteUrl + 'accounting/jurnal/get_data_jurnal_master',
            }).flexClearReload();
        }
    }
    
    function loadDetail(jurnalMasterId = 0){
        if(typeof gridDetail == 'undefined'){
            gridDetail = $("#gridview-detail").flexigrid({
                url: siteUrl + 'accounting/jurnal/get_data_jurnal_master_detail',
                params: [{"name": "jurnal_master_id", "value": jurnalMasterId}],
                dataType: 'json',
                colModel: [
                    {display: 'No Rekening', name: 'coa_master_number', width: 80, sortable: true, align: 'left'},
                    {display: 'Nama Akun', name: 'coa_master_title', width: 180, sortable: true, align: 'left'},
                    {display: 'Debet', name: 'jurnal_master_detail_debet', width: 120, sortable: true, align: 'right'},
                    {display: 'Kredit', name: 'jurnal_master_detail_kredit', width: 120, sortable: true, align: 'right'},
                    {display: 'Keterangan', name: 'jurnal_master_detail_note', width: 200, sortable: true, align: 'left'},
                ],
                searchitems: [
                    {display: 'Nama Akun', name: 'coa_master_title', type: 'text'},
                    {display: 'Debet', name: 'jurnal_master_detail_debet', type: 'num'},
                    {display: 'Kredit', name: 'jurnal_master_detail_kredit', type: 'num'},
                    {display: 'Keterangan', name: 'jurnal_master_detail_note', type: 'text'},
                ],
                sortname: "jurnal_master_detail_id",
                sortorder: "asc",
                usepager: true,
                title: 'Detail Jurnal Master',
                useRp: true,
                rp: 10,
                showTableToggleBtn: false,
                showToggleBtn: true,
                width: 'auto',
                height: '330',
                resizable: false,
                singleSelect: false
            });
        }else{
            $("#gridview-detail").flexOptions({
                url: siteUrl + 'accounting/jurnal/get_data_jurnal_master_detail',
                params: [{"name": "jurnal_master_id", "value": jurnalMasterId}],
            }).flexClearReload();
        }
    }
     
    $(document).ready(function () {
        
        $("#input-autocomplete-coa").autocomplete({
            minLength: 1,
            delay: 2,
            appendTo: "#modal-add .modal-body",
            source: function(request, resolve) {
                resolve($.ui.autocomplete.filter(arrCoaAutocomplete, request.term));
            },
            select: function (event, ui) {
                arrCoa.push(ui.item.data);
                arrExcept.push(ui.item.data.coa_master_id);
                insertToList();
                setTimeout(function () {
                    $("#input-autocomplete-coa").val('');
                }, 100);
            }
        });
        
        
        $('#input-search').daterangepicker({
            singleDatePicker: true,
            format: 'DD/MM/YYYY',
            showDropdowns: true,
        });
        
        $('#input-search-by').on('change', function (){
            let value = $(this).val();
            $('#input-search').val('');
            if(value == 'date'){
                $('#input-search').daterangepicker({
                    singleDatePicker: true,
                    format: 'DD/MM/YYYY',
                    showDropdowns: true,
                });
            }else{
                $('#input-search').data('daterangepicker').remove();
            }
        });
        
        $('#input-limit').on('change', function(){
            searchJurnal();
        });
        
        loadData();
        
        $('.my-select2').select2({
            dropdownParent: $('#modal-add')
        });
        
        $(".my-input-mask").inputmask({
            singleDatePicker: true,
            format: 'DD/MM/YYYY',
            
        });
        
        $('#gridview-master').on('click', function (e){
           let jurnalMasterId = $(e.target).closest( "tr.trSelected" ).data('id');
           if(jurnalMasterId == 'undefined'){
               jurnalMasterId = 0;
           }
           loadDetail(jurnalMasterId);
       });
        
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
        
        $('#form-add').on('submit', function (e) {
            e.preventDefault();
            $('#form-add button[type="submit"]').attr('disabled', 'disabled');

            var urlForm = 'accounting/jurnal/act_add';
            var dataForm = new FormData(this);
            dataForm.append('arr_coa', JSON.stringify(arrCoa));

            $.ajax({
                type: 'POST',
                url: siteUrl + urlForm,
                data: dataForm,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    if (res.status == 200) {
                        $('#form-add button[type="submit"]').removeAttr('disabled');
                        $('#modal-add').modal('hide');
                        loadData();
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
<!-- FORM INPUTMASK -->
<script src="<?php echo THEMES_BACKEND; ?>/js/jquery.inputmask.bundle.js"></script>
<script>
      $("#my-input-mask").inputmask({
            format: 'DD/MM/YYYY'
        });
</script>
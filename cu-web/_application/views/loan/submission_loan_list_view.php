<style>
    .modal-fullscreen .modal-dialog {
        width: 100%;
        height: 100%;
        margin: 0;
    }

    .x_panel {
        padding: 0;
    }

    .table-like-flexigrid {
        font-family: verdana, tahoma, Arial, Helvetica, sans-serif;
        font-size: 11px;
        color: #222;
    }

    .table-like-flexigrid thead tr {
        background: #fafafa url(<?php echo site_url('addons/flexigrid/css/images/fhbg.gif'); ?>) repeat-x bottom;
        border: 1px solid #ccc;
        border-bottom: none;
    }

    .table-like-flexigrid thead tr th {
        border-right: 1px solid #ccc;
        padding: 5px;
        padding-left: 5px;
        padding-right: 5px;
        font-weight: normal;
    }

    .table-like-flexigrid thead tr.first th {
        background: #fafafa url(<?php echo site_url('addons/flexigrid/css/images/bg.gif'); ?>) repeat-x top;
        height: 29px;
        border-bottom: 0px;
        padding: 0px;
        padding-left: 2px;
        padding-right: 2px;
    }

    .table-like-flexigrid tfoot tr th {
        border-right: 1px solid #ccc;
        padding: 5px;
        padding-left: 5px;
        padding-right: 5px;
        font-weight: normal;
    }

    .table-like-flexigrid tfoot tr {
        background: #fafafa url(<?php echo site_url('addons/flexigrid/css/images/fhbg.gif'); ?>) repeat-x bottom;
        border: 1px solid #ccc;
        border-top: none;
        border-bottom: none;
    }

    .table-like-flexigrid tbody tr {
        border: 1px solid #ccc;
        height: 26px;
    }

    .table-like-flexigrid tbody tr td {
        border: 1px solid #ccc;
        padding-left: 5px;
        padding-right: 5px;
    }

    .table-like-flexigrid tbody tr td.have-input {
        padding-left: 2px;
        padding-right: 2px;
    }

    .table-like-flexigrid tbody tr td input {
        padding-left: 5px;
        padding-right: 5px;
    }

    .table-like-flexigrid .fbutton .add {
        background: url(<?php echo site_url('addons/flexigrid/button/images/add.png'); ?>) no-repeat scroll left center transparent;
    }

    .table-like-flexigrid .fbutton .list {
        background: url(<?php echo site_url('addons/flexigrid/button/images/list.png'); ?>) no-repeat scroll left center transparent;
    }

    .table-like-flexigrid .fbutton .accounting {
        background: url(<?php echo site_url('addons/flexigrid/button/images/accounting.png'); ?>) no-repeat scroll left center transparent;
    }

    .table-like-flexigrid .fbutton .selectall {
        background: url(<?php echo site_url('addons/flexigrid/button/images/check-all.png'); ?>) no-repeat scroll left center transparent;
    }

    .table-like-flexigrid .fbutton .unselectall {
        background: url(<?php echo site_url('addons/flexigrid/button/images/check-none.png'); ?>) no-repeat scroll left center transparent;
    }

    .table-like-flexigrid .btn-action-right {
        float: right;
    }

    .table-like-flexigrid .fbutton {
        background: transparent;
        float: left;
        display: block;
        cursor: pointer;
        padding: 3px;
        border: 1px solid transparent;
    }

    .table-like-flexigrid .fbutton:hover {
        border: 1px solid #ccc;
    }

    .table-like-flexigrid .fbutton span {
        padding: 3px;
        padding-left: 20px;
    }

    .table-like-flexigrid .fbuttonseparator {
        float: left;
        height: 22px;
        border-left: 1px solid #ccc;
        border-right: 1px solid #fff;
        margin: 1px;
    }

    .table-like-flexigrid tbody tr th {
        background: #fafafa url(<?php echo site_url('addons/flexigrid/css/images/fhbg.gif'); ?>) repeat-x bottom;
        border: 1px solid #ccc;
        border-bottom: none;
    }

    .table-like-flexigrid tbody tr th {
        border-right: 1px solid #ccc;
        padding: 5px;
        padding-left: 5px;
        padding-right: 5px;
        font-weight: normal;
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

<!-- Modal choose Member-->
<div id="modal-choose-member" class="modal" role="dialog" style="overflow-y: auto">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Pengajuan Pinjaman</h4>
            </div>
            <div class="modal-body" style="overflow-y: auto; max-height: calc(100vh - 200px)">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 10px;">
                        <span><i class="fa fa-info-circle"></i>&nbsp;Tekan <span class="label label-info">ALT+A</span> untuk focus pada data anggota dan gunakan tombol <span class="label label-info"><i class="fa fa-arrow-up"></i>&nbsp;Up</span> atau <span class="label label-info"><i class="fa fa-arrow-down"></i>&nbsp;Down</span> untuk memilih. Kemudian tekan <span class="label label-info">Enter</span> untuk membuka tabungan.</span>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <table id="gridview-member" style="display:none;"></table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!--end Modal Choose Member-->

<?php if (privilege_view(['add'], $this->menu_privilege)) : ?>
    <!-- MODAL ADD-->
    <div id="modal-add" class="modal modal-fullscreen" role="dialog" style="overflow-y: auto;">
        <div class="custom-loading"><span></span></div>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Pengajuan Pinjaman</h4>
                </div>
                <form id="form-add" class="form-horizontal form-label-left" data-url="">
                    <div class="modal-body" style="overflow-y: auto; height: calc(100vh - 130px);">
                        <div id="modal-response-message" class="alert alert-danger alert-dismissible fade in" role="alert" style="display:none"></div>
                        <input id="member-id" type="hidden" name="member_id" value="">

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Pengajuan Pinjaman</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <ul id="container-tabs" class="nav nav-tabs bar_tabs" role="tablist">
                                            <li class="active"><a data-toggle="tab" href="#tab-submission">Informasi Pengajuan</a></li>
                                            <li><a data-toggle="tab" href="#tab-collateral-saving">Jaminan Tabungan</a></li>
                                            <li><a data-toggle="tab" href="#tab-collateral">Jaminan Fisik/Aset</a></li>
                                        </ul>
                                        <div class="tab-content" style="overflow-y: auto; height: calc(100vh - 300px);">
                                            <div id="tab-submission" class="tab-pane fade in active">
                                                <input type="hidden" id="product-loan-name" name="product_loan_name" value="">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12" for="product-loan">Pinjaman <span class="required">*</span>
                                                        </label>
                                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                            <select id="product-loan" name="product_loan_id" class="form-control my-select2" data-validation="required">
                                                                <option value="">--Pilih Pinjaman--</option>
                                                                <?php if (is_array($arr_list_product_loan) && !empty($arr_list_product_loan)) : ?>
                                                                    <?php foreach ($arr_list_product_loan as $row) : ?>
                                                                        <option value="<?php echo $row->product_loan_id; ?>" data-name="<?php echo $row->product_loan_name; ?>"><?php echo $row->product_loan_name . "(" . $row->product_loan_name_alias . ")"; ?></option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-5 col-md-7 col-sm-5 col-xs-12" for="plafon">Plafon <span class="required">*</span>
                                                        </label>
                                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                            <input type="text" name="plafon" id="plafon" class="form-control my-currency text-right" data-validation="required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12" for="tenor">Tenor <span class="required">*</span>
                                                        </label>
                                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                            <input type="text" name="tenor" id="tenor" class="form-control my-period text-right" data-validation="required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12" for="interest-percent">Bunga Bulanan (%) <span class="required">*</span>
                                                        </label>
                                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                            <input type="text" name="interest_percent" id="interest-percent" class="form-control my-percent text-right" data-validation="required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12" for="forfiet-percent">Denda (%) <span class="required">*</span>
                                                        </label>
                                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                            <input type="text" name="forfiet_percent" id="forfiet-percent" class="form-control my-percent text-right" data-validation="required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Tipe Bunga <span class="required">*</span>
                                                        </label>
                                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                            <label class="control-label interest-type" style="margin-right: 25px;"><input type="radio" checked="checked" value="0" name="interest_type"> Flat/Tetap</label>
                                                            <label class="control-label interest-type" style="margin-right: 25px;"><input type="radio" value="1" name="interest_type"> Efektif/Menurun</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12" for="collateral-value">Total Nilai Jaminan <span class="required">*</span>
                                                        </label>
                                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                            <input type="text" name="collateral_value" id="collateral-value" class="form-control my-currency text-right" data-validation="required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12" for="disbursement-date">Tanggal Kebutuhan Pencarian <span class="required">*</span>
                                                        </label>
                                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                            <input data-inputmask="'alias':'date'" type="text" name="disbursement_date" id="disbursement-date" class="form-control my-input-mask" data-validation="required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12" for="due-date">Tanggal Jatuh Tempo <span class="required">*</span>
                                                        </label>
                                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                            <input data-inputmask="'alias':'date'" type="text" name="due_date" id="due-date" class="form-control my-input-mask" data-validation="required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12" for="note">Catatan <span class="required">*</span>
                                                        </label>
                                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                            <textarea name="note" id="note" style="width: 100%;" data-validation="required"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="tab-collateral-saving" class="tab-pane fade">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <button type="button" onclick="addCollateralSaving('collateral-saving')" class="btn btn-dark btn-xs"><i class="fa fa-plus"></i>&nbsp;Tambah</button>
                                                </div>
                                                <div id="container-collateral-saving"></div>
                                            </div>
                                            <div id="tab-collateral" class="tab-pane fade">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <button type="button" onclick="addCollateralSaving('collateral')" class="btn btn-dark btn-xs"><i class="fa fa-plus"></i>&nbsp;Tambah</button>
                                                </div>
                                                <div id="container-collateral"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Informasi Simpanan</h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content" style="overflow-y: auto; padding: 5px;">
                                                <div style="overflow-y: hidden;">
                                                    <table id="saving-table" class="table-like-flexigrid" style="width: 100%;">
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                                <div>
                                                    <table class="table-like-flexigrid">
                                                        <tfoot>
                                                            <tr>
                                                                <th style="text-align: right; font-size: 12px; font-weight: bold;">TOTAL</th>
                                                                <th style="width: 100%; font-weight: bold;" class="text-right" id="total-saving"></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Informasi Pinjaman</h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content" style="overflow-y: auto; padding: 5px;">
                                                <div>
                                                    <table id="loan-table" class="table-like-flexigrid" style="width:100%;">
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                                <div style="overflow-y: auto;">
                                                    <table class="table-like-flexigrid" style="width: 100%;">
                                                        <tfoot>
                                                            <tr>
                                                                <th style="text-align: right; font-size: 12px; font-weight: bold;">TOTAL</th>
                                                                <th style="width: 50%; font-weight: bold;" class="text-right" id="total-loan"></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Informasi Anggota</h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content" style="overflow-y: auto; height: calc(100vh - 400px); padding: 5px;">
                                                <table class="table-like-flexigrid" style="width: 100%;">
                                                    <tbody>
                                                        <tr>
                                                            <th style="font-weight: bold; width: 30%;">Nomor Anggota</th>
                                                            <td style="width: 50%;" id="member-code"></td>
                                                            <td rowspan="5">
                                                                <img id="member-image" src="" style="width: 100%;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Nama</th>
                                                            <td id="member-name"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Unit</th>
                                                            <td id="member-unit"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Tanggal Bergabung</th>
                                                            <td id="member-registered-date"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Jenis Identitas</th>
                                                            <td id="member-identity-type"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Nomor Identitas</th>
                                                            <td colspan="2" id="member-identity-number"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Nama Ibu Kandung</th>
                                                            <td colspan="2" id="member-mother-name"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Jenis Kelamin</th>
                                                            <td colspan="2" id="member-gender"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Tempat, Tanggal Lahir</th>
                                                            <td colspan="2" id="member-birthplace-birthdate"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Alamat Domisili</th>
                                                            <td colspan="2" id="member-address"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Kelurahan</th>
                                                            <td colspan="2" id="member-kelurahan"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Kecamatan</th>
                                                            <td colspan="2" id="member-subdistrict"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Kabupaten/Kota</th>
                                                            <td colspan="2" id="member-city"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Provinsi</th>
                                                            <td colspan="2" id="member-province"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Telp Rumah/Kantor</th>
                                                            <td colspan="2" id="member-phone"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Handphone</th>
                                                            <td colspan="2" id="member-mobilephone"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Pekerjaan</th>
                                                            <td colspan="2" id="member-job"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Penghasilan Rata2</th>
                                                            <td colspan="2" id="member-average-income"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Status Pernikahan</th>
                                                            <td colspan="2" id="member-married"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Nama Suami/Istri</th>
                                                            <td colspan="2" id="member-husband-wife-name"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Nama Anak</th>
                                                            <td colspan="2" id="member-child-name"></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight: bold;">Ahli Waris</th>
                                                            <td colspan="2" id="member-heir"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    <!-- END MODAL ADD -->
<?php endif; ?>

<?php if (privilege_view(['upload'], $this->menu_privilege)) : ?>
    <!--MODAL UPLOAD-->
    <div id="modal-upload" class="modal" role="dialog" style="overflow-y: hidden">
        <div class="custom-loading"><span></span></div>
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Upload Survey</h4>
                </div>
                <form id="form-upload" class="form-horizontal form-label-left" data-url="">
                    <div class="modal-body" style="overflow-y: auto; max-height: calc(100vh - 200px)">
                        <input type="hidden" name="id" id="upload-submission-id" value="">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div id="modal-response-message-upload" class="alert alert-danger fade in" style="display:none"></div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="excel">Pilih File
                                    </label>
                                    <input type="file" name="survey" id="upload-file" class="form-control" accept=".pdf, .jpg, .jpeg, .png">
                                    <small>* Pastikan format file adalah .pdf, .jpg, .jpeg, atau .png dengan maksimal ukuran 2Mb</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i>&nbsp; Upload File</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--END MODAL UPLOAD-->
<?php endif; ?>

<!--FORM VALIDATOR-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<!--MASK MONEY-->
<script src="<?php echo THEMES_BACKEND; ?>/js/jquery.maskMoney.min.js"></script>

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';

    let arrCollateralSaving = [];
    let gridMember;

    function openModalChooseMember() {
        loadFlexigridMember();
        $('#modal-choose-member').modal('show');
    }

    function openModalAddSubmission(com, grid, urlaction) {
        $('#container-collateral-saving, #container-collateral').html('');
        $(`#container-tabs a[data-toggle="tab"][href="#tab-submission"]`).click();
        if ($('.trSelected', grid).length > 0) {
            let memberId = $('.trSelected', grid).attr('data-id');
            $('#member-id').val(memberId);
            $('.my-input-mask').val(moment().format('DD/MM/YYYY'));
            $('#product-loan').val(null).change();
            $('#form-add').trigger('reset');

            ajaxRequest('common/general/membership/member/get_detail', 'GET', {
                id: memberId
            }, function(res) {
                if (res.status == 200) {
                    let data = res.data;

                    $('#member-code').text(data.member_code);

                    let urlImage = siteUrl + 'themes/backend/gentelella/images/no-img.jpg';
                    if (data.member_photo_filename != '' && data.member_photo_filename != null) {
                        urlImage = siteUrl + data.member_photo_path + data.member_photo_filename;
                    }
                    $('#member-image').attr('src', urlImage);

                    $('#member-name').text(data.member_name);
                    $('#member-unit').text(data.branch_name);
                    $('#member-registered-date').text(moment(data.member_registered_date).format('DD/MM/YYYY'));
                    let arrTypeId = ['KTP', 'SIM', 'KK'];
                    $('#member-identity-type').text(arrTypeId[data.member_identity_type]);
                    $('#member-identity-number').text(data.member_identity_number);
                    $('#member-mother-name').text(data.member_mother_name);
                    let arrGender = ['Pria', 'Wanita'];
                    $('#member-gender').text(arrGender[data.member_gender]);
                    let birthplace = data.member_birthplace;
                    let birthdate = data.member_birthdate;
                    let strBirth = '';
                    if (birthplace != null && birthplace != '') {
                        strBirth += birthplace;
                        if (birthdate != null && birthplace != '') {
                            strBirth += ', ' + moment(birthdate).format('DD MMMM YYYY');
                        }
                    } else {
                        if (birthdate != null && birthplace != '') {
                            strBirth += moment(birthdate).format('DD MMMM YYYY');
                        }
                    }
                    $('#member-birthplace-birthdate').text(strBirth);
                    $('#member-address').text(data.member_address_domicile);
                    $('#member-kelurahan').text(data.member_domicile_kelurahan);
                    $('#member-subdistrict').text(data.member_domicile_subdistrict);
                    $('#member-city').text(data.member_domicile_city);
                    $('#member-province').text(data.member_domicile_province);
                    $('#member-phone').text(data.member_phone_number);
                    $('#member-mobilephone').text(data.member_mobilephone_number);
                    $('#member-job').text(data.member_job);
                    let arrAverageIncome = ['Tidak berpenghasilan', '< 1jt', '1jt - 3jt', '3jt - 5jt', '5jt - 10jt', '>10jt'];
                    $('#member-average-income').text(arrAverageIncome[data.member_average_income]);
                    let arrMarried = ['Belum Menikah', 'Sudah Menikah'];
                    $('#member-married').text(arrMarried[data.member_is_married]);
                    $('#member-husband-wife-name').text(data.member_husband_wife_name);

                    let arrChildName = data.member_child_name.split('#');
                    let strChildName = '';
                    if (arrChildName.length > 0 && arrChildName[0] != '') {
                        strChildName += `<ol>`;
                        arrChildName.forEach(child => strChildName += `<li>${child}</li>`);
                        strChildName += `</ol>`;
                    }
                    $('#member-child-name').html(strChildName);

                    let arrHeirName = data.member_heir_name.split('#');
                    let arrHeirStatus = data.member_heir_status.split('#');
                    let strHeir = '';
                    if (arrHeirName.length > 0 && arrHeirName[0] != '') {
                        strHeir += `<ol>`;
                        arrHeirName.forEach((heir, index) => {
                            let status = (typeof arrHeirStatus[index] != 'undefined' && arrHeirStatus[index] != '') ? `(${arrHeirStatus[index]})` : '';
                            strHeir += `<li>${heir} ${status}</li>`;
                        });
                        strHeir += `</ol>`;
                    }
                    $('#member-heir').html(strHeir);
                } else {
                    alert(res.msg);
                }
            });

            ajaxRequest('common/general/loan/submission/get_member_saldo', 'GET', {
                id: memberId
            }, function(res) {
                if (res.status == 200) {
                    let arrSaving = res.data.saving;
                    let arrLoan = res.data.loan;

                    let totalSaldoSaving = 0;
                    let totalSaldoLoan = 0;

                    let htmlSaving = '';
                    let htmlLoan = '';

                    arrCollateralSaving = []

                    if (arrSaving.length > 0) {
                        arrCollateralSaving = arrSaving;

                        arrSaving.forEach(function(item, index) {
                            totalSaldoSaving = totalSaldoSaving + item.balance;
                            htmlSaving += `
                                            <tr>
                                                <th style="font-weight: bold;">${item.name}</th>
                                                <td class="text-right"  style="width: 50%;">${number_format(item.balance)}</td>
                                            </tr>
                                        `;
                        });
                    } else {
                        htmlSaving += `
                                        <tr>
                                            <td colspan="2">Belum ada data.</td>
                                        </tr>
                                    `;
                    }

                    $('#total-saving').text(number_format(totalSaldoSaving));
                    $('#saving-table tbody').html(htmlSaving);

                    if (arrLoan.length > 0) {
                        arrLoan.forEach(function(item, index) {
                            totalSaldoLoan = totalSaldoLoan + item.balance;
                            htmlLoan += `
                                            <tr>
                                                <th style="font-weight: bold;">${item.name}</th>
                                                <td class="text-right"  style="width: 50%;">${number_format(item.balance)}</td>
                                            </tr>
                                        `;
                        });
                    } else {
                        htmlLoan += `
                                        <tr>
                                            <td colspan="2">Belum ada data.</td>
                                        </tr>
                                    `;
                    }

                    $('#total-loan').text(number_format(totalSaldoLoan));
                    $('#loan-table tbody').html(htmlLoan);
                } else {
                    alert(res.msg);
                }
            });

            $('#modal-add .modal-body').animate({
                scrollTop: '0px'
            }, 300);

            $('#modal-add').modal({
                backdrop: 'static',
                keyboard: false
            }, 'show');
        }
    }

    function resetFormLoan() {
        $('#plafon').val('0');
        $('#tenor').val('0 Bulan');
        $('#interest-percent').val('0,00');
        $('#forfiet-percent').val('0,00');
        $('#collateral-value').val('0');
    }

    function addCollateralSaving(type) {

        if (type == 'collateral-saving') {
            let countCollateralSaving = $('#container-collateral-saving .collateral-saving').length;

            let totalCollateralSaving = 0
            let htmlOptionSaving = '';
            if (arrCollateralSaving.length > 0) {
                arrCollateralSaving.forEach(function(item, index) {
                    if (item.id != 0) {
                        totalCollateralSaving++;
                        htmlOptionSaving += `
                            <option value="${item.id}">${item.name} (${item.alias}) [${item.code}]</option>
                        `;
                    }
                });
            }

            if ((countCollateralSaving + 1) > totalCollateralSaving) {
                alert('Data tidak boleh melebihi jumlah simpanan.');
                return false;
            }

            let index = 0;
            if (countCollateralSaving > 0) {
                index = countCollateralSaving;
            }

            let html = `
                <div class="collateral-saving">
                    <div class="col-md-7 col-sm-12 col-xs-12 row">
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">Tabungan <span class="required">*</span>
                            </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <select name="collateral_saving[${index}][id]" data-type="id" class="input-collateral-saving form-control my-select2" data-validation="required">
                                    <option value="">--Pilih Tabungan--</option>
                                    ${htmlOptionSaving}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 row">
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">Nominal Tabungan <span class="required">*</span>
                            </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" name="collateral_saving[${index}][collateral]" data-type="collateral" class="input-collateral-saving form-control my-currency text-right" data-validation="required">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-12 col-xs-12 row" style="margin-top: 32px;">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <button type="button" onclick="removeCollateralSaving(this, 'collateral-saving')" class="btn btn-danger btn-xs"><i class="fa fa-times"></i>&nbsp;</button>
                        </div>
                    </div>
                </div>
            `;

            $('#container-collateral-saving').append(html);

            $('.my-currency').maskMoney({
                prefix: '',
                suffix: '',
                allowNegative: false,
                thousands: '.',
                decimal: ',',
                affixesStay: true,
                precision: 0,
                allowZero: true
            });

            $('.my-select2').select2({
                dropdownParent: $('#modal-add')
            });

            autoArangeCollateralSaving();
        }

        if (type == 'collateral') {
            let countCollateral = $('#container-collateral .collateral').length;

            let index = 0;
            if (countCollateral > 0) {
                index = countCollateral;
            }

            let html = `
                <div class="collateral">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Jenis Jaminan <span class="required">*</span>
                            </label>
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                <select name="collateral[${index}][type]" data-type="type" onchange="setCollateralType(this, ${index})" class="form-control my-select2" data-validation="required">
                                    <option value="">--Pilih Jenis Jaminan--</option>
                                    <option value="0">BPKB</option>
                                    <option value="1">Sertifikat</option>
                                    <option value="2">Deposito</option>
                                    <option value="3">Lain-lain</option>
                                </select>
                            </div>
                            <div>
                                <button type="button" onclick="removeCollateralSaving(this, 'collateral')" class="btn btn-danger btn-xs"><i class="fa fa-times"></i>&nbsp;</button>
                            </div>
                        </div>
                    </div>
                    <div id="container-collateral-type-${index}" class="container-collateral-type"></div>
                </div>
            `;

            $('#container-collateral').append(html);

            //            $('.my-select2').select2({
            //                dropdownParent: $('#modal-add .modal-body')
            //            });
        }
    }

    function removeCollateralSaving(element, type) {

        if (type == 'collateral-saving') {
            $(element).closest('.collateral-saving').remove();
            autoArangeCollateralSaving();
        }

        if (type == 'collateral') {
            $(element).closest('.collateral').remove();
        }
    }

    function setCollateralType(element, index) {
        let value = $(element).val();
        $(`#container-collateral-type-${index}`).html('');
        if (value) {
            let html = '';
            switch (value) {
                case '0':
                    html += `
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Jenis Kendaraan <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][vehicle_type]" data-type="vehicle_type" class="form-control" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Merek Kendaraan <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][vehicle_brand]" data-type="vehicle_brand" class="form-control" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Tanggal Pembuatan <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][created_year]" data-type="created_year" class="form-control my-input-mask" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. Polisi <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][nopol]" data-type="nopol" class="form-control" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. BPKB <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][nobpkb]" data-type="nobpkb" class="form-control" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. Rangka <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][norangka]" data-type="norangka" class="form-control" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. Mesin <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][nomesin]" data-type="nomesin" class="form-control" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Nama STNK <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][stnk_name]" data-type="stnk_name" class="form-control" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Nama BPKB <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][bpkb_name]" data-type="bpkb_name" class="form-control" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Catatan <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <textarea name="collateral[${index}][note]" data-type="note" class="form-control" data-validation="required"></textarea>
                                </div>
                            </div>
                        </div>
                    `;
                    break;
                case '1':
                    html += `
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Nama Sertifikat <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][sertifikat_name]" data-type="sertifikat_name" class="form-control" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. Hak Milik <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][nohm]" data-type="nohm" class="form-control" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Luas Tanah/Bangunan <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][area_size]" data-type="area_size" class="form-control" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Atas Nama <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][atas_nama]" data-type="atas_name" class="form-control" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Lokasi Tanah/Bangunan <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][location]" data-type="location" class="form-control" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. Ukur <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][measuring_number]" data-type="measuring_number" class="form-control" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Catatan <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <textarea name="collateral[${index}][note]" data-type="note" class="form-control" data-validation="required"></textarea>
                                </div>
                            </div>
                        </div>
                    `;
                    break;
                case '2':
                    html += `
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Jenis Deposito <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][deposito_type]" data-type="deposito_type" class="form-control" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Deposito Atas Nama <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][deposito_name]" data-type="deposito_name" class="form-control" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Alamat Deposito <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][deposito_address]" data-type="deposito_address" class="form-control" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. Rekening Deposito <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][deposito_account_number]" data-type="deposito_account_number" class="form-control" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Tgl. Jatuh Tempo Deposito <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][deposito_due_date]" data-type="deposito_due_date" class="form-control my-input-mask" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Nominal Deposito <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="collateral[${index}][deposito_value]" data-type="deposito_value" class="form-control text-right my-currency" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Catatan <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <textarea name="collateral[${index}][note]" data-type="note" class="form-control" data-validation="required"></textarea>
                                </div>
                            </div>
                        </div>
                    `;
                    break;
                case '3':
                    html += `
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Catatan <span class="required">*</span>
                                </label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <textarea name="collateral[${index}][note]" data-type="note" class="form-control" data-validation="required"></textarea>
                                </div>
                            </div>
                        </div>
                    `;
                    break;
            }
            $(`#container-collateral-type-${index}`).html(html);

            $(".my-input-mask").inputmask({
                singleDatePicker: true,
                format: 'DD/MM/YYYY',

            });

            $('.my-currency').maskMoney({
                prefix: '',
                suffix: '',
                allowNegative: false,
                thousands: '.',
                decimal: ',',
                affixesStay: true,
                precision: 0,
                allowZero: true
            });
        }
    }

    function autoArangeCollateralSaving() {
        let countCollateralSaving = $('#container-collateral-saving .collateral-saving').length;

        if (countCollateralSaving > 0) {
            $('#container-collateral-saving .collateral-saving').each(function(index, element) {
                if ($('.input-collateral-saving', element).length > 0) {
                    $('.input-collateral-saving', element).each(function(indexInput, elementInput) {
                        let type = $(elementInput).attr('data-type');
                        $(elementInput).attr('name', `collateral_saving[${index}][${type}]`)
                    });
                }
            });
        }
    }

    function openModalUploadSurvey(com, grid, urlaction) {
        if ($('.trSelected', grid).length > 0) {
            let submissionId = $('.trSelected', grid).attr('data-id');

            $('#form-upload').trigger('reset');
            $('#upload-submission-id').val(submissionId);
            $('#modal-upload').modal('show');
        } else {
            alert('Anda belum memilih data.');
        }
    }

    function printSubmission(url) {
        openInNewTab(url);
        setTimeout(() => {
            $('#gridview').flexReload();
        }, 2000);
    }

    $(document).ready(function() {
        $('.my-select2').select2({
            dropdownParent: $('#modal-add')
        });

        $(".my-input-mask").inputmask({
            singleDatePicker: true,
            format: 'DD/MM/YYYY',

        });

        $('.my-currency').maskMoney({
            prefix: '',
            suffix: '',
            allowNegative: false,
            thousands: '.',
            decimal: ',',
            affixesStay: true,
            precision: 0,
            allowZero: true
        });
        $('.my-period').maskMoney({
            prefix: '',
            suffix: ' Bulan',
            allowNegative: false,
            thousands: '.',
            decimal: ',',
            affixesStay: true,
            precision: 0,
            allowZero: true
        });
        $('.my-percent').maskMoney({
            prefix: '',
            suffix: '',
            allowNegative: false,
            thousands: '.',
            decimal: ',',
            affixesStay: true,
            precision: 2,
            allowZero: true
        });

        $('#container-tabs a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            let related = $(e.relatedTarget).attr("href");
            let target = $(e.target).attr("href");

            let isError = false;

            $(`${related} input, ${related} select, ${related} textarea`).validate(function(valid, elem) {
                if (!valid) {
                    isError = true;
                }
            });
            if (isError) {
                setTimeout(function() {
                    $(`#container-tabs a[data-toggle="tab"][href="${related}"]`).click();
                    $('#modal-add .tab-content').animate({
                        scrollTop: '0px'
                    }, 300);
                }, 200);
            }
        });

        $('#product-loan').on('change', function() {
            let value = $(this).val();
            resetFormLoan();
            if (value) {
                let productName = $(`#product-loan option[value=${value}]`).attr('data-name');
                $('#product-loan-name').val(productName);
            }
        });

        $('#form-upload').on('submit', function(e) {
            e.preventDefault();

            $('#form-upload button[type="submit"]').attr('disabled', 'disabled');
            let urlForm = siteUrl + 'loan/submission_loan/act_upload';

            let formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: urlForm,
                data: formData,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(res) {
                    if (res.status == 200) {
                        $('#modal-upload').modal('hide');
                        $('#gridview').flexClearReload();
                        $('#form-upload button[type="submit"]').removeAttr('disabled');

                        let message_class = 'response_confirmation alert alert-success';

                        $("#response_message").finish();

                        $("#response_message").addClass(message_class);
                        $("#response_message").slideDown("fast");
                        $("#response_message").html(res.data);
                        $("#response_message").delay(10000).slideUp(1000, function() {
                            $("#response_message").removeClass(message_class);
                        });
                    } else {
                        $('#form-upload button[type="submit"]').removeAttr('disabled');
                        $("#modal-response-message-upload").finish();

                        $("#modal-response-message-upload").slideDown("fast");
                        $('#modal-response-message-upload').html(res.msg);
                        $("#modal-response-message-upload").delay(10000).slideUp(1000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#form-upload button[type="submit"]').removeAttr('disabled');
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });

        $('#form-add').on('submit', function(e) {
            e.preventDefault();
            $('#form-add button[type="submit"]').attr('disabled', 'disabled');
            let urlForm = siteUrl + 'loan/submission_loan/act_add';

            let formData = new FormData(this);

            let plafon = formData.get('plafon');
            let tenor = formData.get('tenor');
            let interest = formData.get('interest_percent');
            let forfiet = formData.get('forfiet_percent');
            let collateral = formData.get('collateral_value');

            formData.set('plafon', convertFormatRp(plafon));
            formData.set('tenor', convertFormatPeriod(tenor));
            formData.set('interest_percent', convertFormatPercent(interest));
            formData.set('forfiet_percent', convertFormatPercent(forfiet));
            formData.set('collateral_value', convertFormatRp(collateral));

            $.ajax({
                type: 'POST',
                url: urlForm,
                data: formData,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(res) {
                    if (res.status == 200) {
                        $('#form-add button[type="submit"]').removeAttr('disabled');
                        $('#modal-add').modal('hide');
                        $('#modal-choose-member').modal('hide');
                        $('#gridview').flexReload();
                        let message_class = 'response_confirmation alert alert-success';

                        $("#response_message").finish();

                        $("#response_message").addClass(message_class);
                        $("#response_message").slideDown("fast");
                        $("#response_message").html(res.data);
                        $("#response_message").delay(10000).slideUp(1000, function() {
                            $("#response_message").removeClass(message_class);
                        });
                    } else {
                        $('#modal-add .modal-body').animate({
                            scrollTop: '0px'
                        }, 300);
                        $('#form-add button[type="submit"]').removeAttr('disabled');
                        $("#modal-response-message").finish();

                        $("#modal-response-message").slideDown("fast");
                        $('#modal-response-message').html(res.msg);
                        $("#modal-response-message").delay(10000).slideUp(1000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#form-add button[type="submit"]').removeAttr('disabled');
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });
    });

    $("#gridview").flexigrid({
        url: siteUrl + 'loan/submission_loan/get_data',
        dataType: 'json',
        colModel: [
            <?php if (privilege_view('print', $this->menu_privilege)) :
                echo "{display: 'Print', name: 'action', width: 40, sortable: false, align: 'center', datasource: false},";
            endif; ?> {
                display: 'Status Pengajuan',
                name: 'submission_product_loan_status',
                width: 100,
                sortable: true,
                align: 'center'
            },
            {
                display: 'No. Anggota',
                name: 'member_code',
                width: 100,
                sortable: true,
                align: 'center'
            },
            {
                display: 'Nama Anggota',
                name: 'member_name',
                width: 200,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Nama Pinjaman',
                name: 'product_loan_name',
                width: 150,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Nama Alias Pinjaman',
                name: 'product_loan_name_alias',
                width: 150,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Plafon',
                name: 'submission_product_loan_plafon',
                width: 150,
                sortable: true,
                align: 'right'
            },
            {
                display: 'Tenor (Bulan)',
                name: 'submission_product_loan_tenor',
                width: 100,
                sortable: true,
                align: 'center'
            },
            {
                display: 'Bunga Bulanan (%)',
                name: 'submission_product_loan_interest_percent',
                width: 100,
                sortable: true,
                align: 'center'
            },
            {
                display: 'Tipe Jaminan',
                name: 'submission_product_loan_collateral_type',
                width: 200,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Total Nilai Jaminan',
                name: 'submission_product_loan_collateral_value',
                width: 150,
                sortable: true,
                align: 'right'
            },
            {
                display: 'Deskripsi Jaminan',
                name: 'submission_product_loan_collateral_description',
                width: 300,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Tanggal Kebutuhan Cair',
                name: 'submission_product_loan_disbursement_date',
                width: 180,
                sortable: true,
                align: 'center'
            },
            {
                display: 'Tanggal Jatuh Tempo',
                name: 'submission_product_loan_due_date',
                width: 180,
                sortable: true,
                align: 'center'
            },
            {
                display: 'Catatan Pengajuan',
                name: 'submission_product_loan_note',
                width: 200,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Waktu Input',
                name: 'submission_product_loan_input_datetime',
                width: 180,
                sortable: true,
                align: 'center',
                hide: true
            },
            {
                display: 'Username Admin Input',
                name: 'submission_product_loan_input_admin_username',
                width: 200,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'Nama Admin Input',
                name: 'submission_product_loan_input_admin_name',
                width: 200,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'Waktu Survey',
                name: 'submission_product_loan_status_surveyor_datetime',
                width: 180,
                sortable: true,
                align: 'center',
                hide: true
            },
            {
                display: 'Username Admin Survey',
                name: 'submission_product_loan_status_surveyor_admin_username',
                width: 200,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'Nama Admin Survey',
                name: 'submission_product_loan_status_surveyor_admin_name',
                width: 200,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'Data Admin Approve',
                name: 'submission_product_loan_status_approved',
                width: 200,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'Waktu Reject',
                name: 'submission_product_loan_status_rejected_datetime',
                width: 180,
                sortable: true,
                align: 'center',
                hide: true
            },
            {
                display: 'Username Admin Reject',
                name: 'submission_product_loan_status_rejected_admin_username',
                width: 200,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'Nama Admin Reject',
                name: 'submission_product_loan_status_rejected_admin_name',
                width: 200,
                sortable: true,
                align: 'left',
                hide: true
            },
        ],
        buttons: [
            <?php
            if (privilege_view('add', $this->menu_privilege)) :
                echo "{display: 'Tambah Pengajuan Pinjaman', name: 'add', bclass: 'add', onpress: openModalChooseMember},";
            endif;
            if (privilege_view('upload', $this->menu_privilege)) :
                echo "
                    {separator: true},
                    {display: 'Upload File Survey', name: 'upload', bclass: 'upload', onpress: openModalUploadSurvey, urlaction: '" . site_url("loan/approval_loan/act_upload") . "'},
                    ";
            endif;
            ?>
        ],
        buttons_right: [
            <?php if (privilege_view('export', $this->menu_privilege)) :
            //                echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("loan/submission_loan/export_data_submission_loan") . "'}";
            endif; ?>
        ],
        searchitems: [{
                display: 'Status Pengajuan',
                name: 'member_code',
                type: 'select',
                option: '0:Waiting|1:Surveyed|2:Approved|3:Rejected'
            },
            {
                display: 'No. Anggota',
                name: 'member_name',
                type: 'text'
            },
            {
                display: 'Nama Anggota',
                name: 'product_loan_name',
                type: 'text'
            },
            {
                display: 'Nama Pinjaman',
                name: 'product_loan_name_alias',
                type: 'text'
            },
            {
                display: 'Nama Alias Pinjaman',
                name: 'submission_product_loan_plafon',
                type: 'text'
            },
            {
                display: 'Plafon',
                name: 'submission_product_loan_tenor',
                type: 'num'
            },
            {
                display: 'Tenor (Bulan)',
                name: 'submission_product_loan_interest_percent',
                type: 'num'
            },
            {
                display: 'Bunga Bulanan (%)',
                name: 'submission_product_loan_interest_percent',
                type: 'num'
            },
            {
                display: 'Total Nilai Jaminan',
                name: 'submission_product_loan_collateral_value',
                type: 'text'
            },
            {
                display: 'Tanggal Kebutuhan Cair',
                name: 'submission_product_loan_note',
                type: 'date'
            },
            {
                display: 'Tanggal Jatuh Tempo',
                name: 'submission_product_loan_due_date',
                type: 'date'
            },
            {
                display: 'Catatan Pengajuan',
                name: 'submission_product_loan_status',
                type: 'text'
            },
            {
                display: 'Waktu Input',
                name: 'submission_product_loan_input_texttime',
                type: 'date'
            },
            {
                display: 'Username Admin Input',
                name: 'submission_product_loan_input_admin_username',
                type: 'text'
            },
            {
                display: 'Nama Admin Input',
                name: 'submission_product_loan_input_admin_name',
                type: 'text'
            },
            {
                display: 'Waktu Survey',
                name: 'submission_product_loan_status_surveyor_texttime',
                type: 'date'
            },
            {
                display: 'Username Admin Survey',
                name: 'submission_product_loan_status_surveyor_admin_username',
                type: 'text'
            },
            {
                display: 'Nama Admin Survey',
                name: 'submission_product_loan_status_surveyor_admin_name',
                type: 'text'
            },
            {
                display: 'Data Admin Approve',
                name: 'submission_product_loan_status_approved',
                type: 'text'
            },
            {
                display: 'Waktu Reject',
                name: 'submission_product_loan_status_rejected_texttime',
                type: 'date'
            },
            {
                display: 'Username Admin Reject',
                name: 'submission_product_loan_status_rejected_admin_username',
                type: 'text'
            },
            {
                display: 'Nama Admin Reject',
                name: 'submission_product_loan_status_rejected_admin_name',
                type: 'text'
            },
        ],
        sortname: "submission_product_loan_id",
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

    function loadFlexigridMember() {
        if (typeof gridMember == 'undefined') {
            gridMember = $('#gridview-member').flexigrid({
                url: siteUrl + 'loan/submission_loan/get_data_member',
                dataType: 'json',
                colModel: [{
                        display: 'No. Anggota',
                        name: 'member_code',
                        width: 80,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Nama',
                        name: 'member_name',
                        width: 200,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Status Keanggotaan',
                        name: 'member_status',
                        width: 150,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'No. Identitas',
                        name: 'member_identity_number',
                        width: 150,
                        sortable: true,
                        align: 'center',
                        hide: true
                    },
                    {
                        display: 'Tipe Identitas',
                        name: 'member_identity_type',
                        width: 80,
                        sortable: true,
                        align: 'center',
                        hide: true
                    },
                    {
                        display: 'Jenis Kelamin',
                        name: 'member_gender',
                        width: 80,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Tanggal Lahir',
                        name: 'member_birthdate',
                        width: 180,
                        sortable: true,
                        align: 'center',
                        hide: true
                    },
                    {
                        display: 'Tempat Lahir',
                        name: 'member_birthplace',
                        width: 100,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Alamat',
                        name: 'member_address',
                        width: 300,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Provinsi',
                        name: 'member_province',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Kota',
                        name: 'member_city',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Kecamatan',
                        name: 'member_subdistrict',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Kelurahan',
                        name: 'member_kelurahan',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'RT',
                        name: 'member_rt_number',
                        width: 50,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'RW',
                        name: 'member_rw_number',
                        width: 50,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Kode Pos',
                        name: 'member_zipcode',
                        width: 80,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Domisili',
                        name: 'member_address_domicile',
                        width: 300,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Provinsi Domisili',
                        name: 'member_domicile_province',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Kota Domisili',
                        name: 'member_domicile_city',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Kecamatan Domisili',
                        name: 'member_domicile_subdistrict',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Kelurahan Domisili',
                        name: 'member_domicile_kelurahan',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'RT Domisili',
                        name: 'member_domicile_rt_number',
                        width: 50,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'RW Domisili',
                        name: 'member_domicile_rw_number',
                        width: 50,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Kode Pos Domisili',
                        name: 'member_domicile_zipcode',
                        width: 80,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Telepon',
                        name: 'member_phone_number',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'No. Handphone',
                        name: 'member_mobilephone_number',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Pekerjaan',
                        name: 'member_job',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Rata-rata Penghasilan',
                        name: 'member_average_income',
                        width: 130,
                        sortable: true,
                        align: 'center',
                        hide: true
                    },
                    {
                        display: 'Pendidikan Terakhir',
                        name: 'member_last_education',
                        width: 100,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Agama',
                        name: 'member_religion',
                        width: 150,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Status Pernikahan',
                        name: 'member_is_married',
                        width: 110,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Nama Suami/Istri',
                        name: 'member_husband_wife_name',
                        width: 200,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Nama Anak',
                        name: 'member_child_name',
                        width: 200,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Nama Ibu Kandung',
                        name: 'member_mother_name',
                        width: 200,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Pernah Terdaftar di CU Lain',
                        name: 'member_is_registered_others_cu',
                        width: 80,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Nama CU Lain',
                        name: 'member_others_cu_name',
                        width: 100,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Nama Ahli Waris',
                        name: 'member_heir_name',
                        width: 200,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Status Ahli Waris',
                        name: 'member_heir_status',
                        width: 200,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Unit',
                        name: 'branch_name',
                        width: 150,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Waktu Daftar',
                        name: 'member_join_datetime',
                        width: 200,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Nama Administrator Input',
                        name: 'member_input_admin_name',
                        width: 200,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Waktu Administrator Input',
                        name: 'member_input_datetime',
                        width: 100,
                        sortable: true,
                        align: 'center',
                        hide: true
                    },
                ],
                buttons: [
                    <?php
                    if (privilege_view('add', $this->menu_privilege)) :
                        echo "
                            {display: 'P<u>i</u>lih Anggota', name: 'add', bclass: 'add', onpress: openModalAddSubmission},
                            ";
                    endif;
                    ?>
                ],
                searchitems: [{
                        display: 'Nama',
                        name: 'member_name',
                        type: 'text'
                    },
                    {
                        display: 'No. Anggota',
                        name: 'member_code',
                        type: 'text'
                    },
                    {
                        display: 'Alamat',
                        name: 'member_address',
                        type: 'text'
                    },
                    {
                        display: 'Provinsi',
                        name: 'member_province',
                        type: 'text'
                    },
                    {
                        display: 'Kota',
                        name: 'member_city',
                        type: 'text'
                    },
                    {
                        display: 'Kecamatan',
                        name: 'member_subdistrict',
                        type: 'text'
                    },
                    {
                        display: 'Kelurahan',
                        name: 'member_kelurahan',
                        type: 'text'
                    },
                    {
                        display: 'Domisili',
                        name: 'member_address_domicile',
                        type: 'text'
                    },
                    {
                        display: 'Provinsi Domisili',
                        name: 'member_domicile_province',
                        type: 'text'
                    },
                    {
                        display: 'Kota Domisili',
                        name: 'member_domicile_city',
                        type: 'text'
                    },
                    {
                        display: 'Kecamatan Domisili',
                        name: 'member_domicile_subdistrict',
                        type: 'text'
                    },
                    {
                        display: 'Kelurahan Domisili',
                        name: 'member_domicile_kelurahan',
                        type: 'text'
                    },
                ],
                sortname: "member_id",
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
                singleSelect: true
            });
        } else {
            $("#gridview-member").flexOptions({
                url: siteUrl + 'loan/submission_loan/get_data_member',
            }).flexClearReload();
        }
        $('.trSelected').focus();
    }

    // for set number format
    function number_format(number = 0, decimals = 0, decPoint = ',', thousandsSep = '.') {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        let n = !isFinite(+number) ? 0 : +number;
        let prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
        let sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep;
        let dec = (typeof decPoint === 'undefined') ? '.' : decPoint;
        let s = '';

        let toFixedFix = function(n, prec) {
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

    // function request with ajax
    function ajaxRequest(url, method = 'GET', data = '', callback, async = true) {
        $.ajax({
            async: async,
            url: siteUrl + url,
            method: method,
            data: data,
            dataType: 'json',
            success: function(res) {
                callback(res);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                let res = {
                    status: 400,
                    msg: 'Gagal mendapatkan data.'
                }
                callback(res);
            }
        });
    }

    // for convert format Rp in integer
    function convertFormatRp(str) {
        let value = str.replace('Rp. ', '');
        return parseInt(value.replace(/\./g, ''));
    }

    function convertFormatPeriod(str) {
        let value = str.replace(' Bulan', '');
        return parseInt(value.replace(/\./g, ''));
    }

    function convertFormatDecimal(str) {
        let value = str.replace('Rp. ', '');
        value = value.replace(/\./g, '');
        return parseFloat(value.replace(/\,/g, '.'));
    }

    function convertFormatPercent(str) {
        let value = str.replace(' %', '');
        value = value.replace(/\./g, '');
        return parseFloat(value.replace(/\,/g, '.'));
    }

    function openInNewTab(url) {
        window.open(url);
        window.focus();
    }

    $.validate({
        lang: 'id',
        onError: function() {
            $('#modal-add .tab-content').animate({
                scrollTop: '0px'
            }, 300);
        }
    });
</script>

<!-- FORM INPUTMASK -->
<script src="<?php echo THEMES_BACKEND; ?>/js/jquery.inputmask.bundle.js"></script>
<script>
    $("#my-input-mask").inputmask({
        format: 'DD/MM/YYYY'
    });
</script>
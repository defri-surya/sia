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

    img.no-file {
        -webkit-filter: opacity(30%);
        filter: opacity(30%);
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
        <ul id="container-tabs" class="nav nav-tabs bar_tabs" role="tablist">
            <li class="active"><a data-toggle="tab" href="#tab-submission">Diajukan</a></li>
            <li><a data-toggle="tab" href="#tab-approved">Disetujui</a></li>
            <li><a data-toggle="tab" href="#tab-rejected">Ditolak</a></li>
        </ul>

        <div class="tab-content">
            <div id="tab-submission" class="tab-pane fade in active">
                <table id="gridview" style="display:none;"></table>
            </div>
            <div id="tab-approved" class="tab-pane fade">
                <table id="gridview-approved" style="display:none;"></table>
            </div>
            <div id="tab-rejected" class="tab-pane fade">
                <table id="gridview-rejected" style="display:none;"></table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL-->
<div id="modal-detail" class="modal modal-fullscreen" role="dialog" style="overflow-y: hidden;">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <form id="form-detail" class="form-horizontal form-label-left" data-url="" data-type="">
                <div class="modal-body" style="overflow-y: auto; height: calc(100vh - 130px);">
                    <div id="modal-response-message-detail" class="alert alert-danger alert-dismissible fade in" role="alert" style="display:none"></div>
                    <input id="submission-id" type="hidden" name="id" value="">

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Pengajuan Pinjaman</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <ul id="tabs-form" class="nav nav-tabs bar_tabs" role="tablist">
                                        <li class="active"><a data-toggle="tab" href="#tab-submission-form">Informasi Pengajuan</a></li>
                                        <li><a data-toggle="tab" href="#tab-collateral-saving">Jaminan Tabungan</a></li>
                                        <li><a data-toggle="tab" href="#tab-collateral">Jaminan Fisik/Aset</a></li>
                                    </ul>
                                    <div class="tab-content" style="overflow-y: auto; height: calc(100vh - 334px);">
                                        <div id="tab-submission-form" class="tab-pane fade in active">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12" for="plafon">Plafon <span class="required">*</span>
                                                    </label>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <input type="text" name="plafon" id="plafon" class="form-control my-currency text-right" data-validation="required">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12" for="tenor">Tenor <span class="required">*</span>
                                                    </label>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <input type="text" name="tenor" id="tenor" class="form-control my-period text-right" data-validation="required">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12" for="interest-percent">Bunga Bulanan (%) <span class="required">*</span>
                                                    </label>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <input type="text" name="interest_percent" id="interest-percent" class="form-control my-percent text-right" data-validation="required">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12" for="forfiet-percent">Denda (%) <span class="required">*</span>
                                                    </label>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
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
                                                    <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12" for="collateral-value">Total Nilai Jaminan
                                                    </label>
                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                        <input type="text" id="collateral-value" class="form-control my-currency text-right" readonly="readonly">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12" for="disbursement-date">Tanggal Kebutuhan Pencarian <span class="required">*</span>
                                                    </label>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <input type="text" name="disbursement_date" id="disbursement-date" class="form-control my-date-picker" data-validation="required">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12" for="due-date">Tanggal Jatuh Tempo <span class="required">*</span>
                                                    </label>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <input type="text" name="due_date" id="due-date" class="form-control my-date-picker" data-validation="required">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12" for="forfeit-date">Tanggal Denda <span class="required">*</span>
                                                    </label>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <input type="text" name="forfiet_date" id="forfeit-date" class="form-control my-date-picker" data-validation="required">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Disertakan Daperma? <span class="required">*</span>
                                                    </label>
                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                        <label class="control-label is-daperma" style="margin-right: 25px;"><input type="radio" checked="checked" value="0" name="is_daperma"> Tidak</label>
                                                        <label class="control-label is-daperma" style="margin-right: 25px;"><input type="radio" value="1" name="is_daperma"> Ya</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12" for="note">Catatan
                                                    </label>
                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                        <textarea id="note" style="width: 100%;" readonly="readonly"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="tab-collateral-saving" class="tab-pane fade">
                                            <div id="container-collateral-saving"></div>
                                        </div>
                                        <div id="tab-collateral" class="tab-pane fade">
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
                                        <div class="x_content" style="overflow-y: auto; height: calc(100vh - 590px); padding: 5px;">
                                            <div style="overflow-y: scroll; height: 125px;">
                                                <table id="saving-table" class="table-like-flexigrid" style="width: 100%;">
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                            <div style="overflow-y: scroll;">
                                                <table class="table-like-flexigrid" style="width: 100%;">
                                                    <tfoot>
                                                        <tr>
                                                            <th style="text-align: right; font-size: 12px; font-weight: bold;">TOTAL</th>
                                                            <th style="width: 50%; font-weight: bold;" class="text-right" id="total-saving"></th>
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
                                        <div class="x_content" style="overflow-y: auto; height: calc(100vh - 590px); padding: 5px;">
                                            <div style="overflow-y: scroll; height: 125px;">
                                                <table id="loan-table" class="table-like-flexigrid" style="width: 100%;">
                                                    <tbody>
                                                </table>
                                            </div>
                                            <div style="overflow-y: scroll;">
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
                                        <div class="x_content" style="overflow-y: auto; height: calc(100vh - 465px); padding: 5px;">
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
                    <button id="btn-approve" type="submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp; Setujui Pinjaman</button>
                    <button id="btn-reject" type="submit" class="btn btn-danger"><i class="fa fa-times"></i>&nbsp; Tolak Pinjaman</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL DETAIL -->

<!--FORM VALIDATOR-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<!--MASK MONEY-->
<script src="<?php echo THEMES_BACKEND; ?>/js/jquery.maskMoney.min.js"></script>

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';

    let gridSubmission;
    let gridApproved;
    let gridRejected;

    function openModalApprove(com, grid, urlaction) {
        if ($('.trSelected', grid).length > 0) {
            let submissionId = $('.trSelected', grid).attr('data-id');

            ajaxRequest('common/general/loan/submission/get_detail', 'GET', {
                id: submissionId
            }, function(res) {
                if (res.status == 200) {
                    let data = res.data;
                    let collateralSaving = res.data.collateral_saving;
                    let collateral = res.data.collateral;

                    $('#container-collateral-saving, #container-collateral').html('');
                    $(`#tabs-form a[data-toggle="tab"][href="#tab-submission-form"]`).click();
                    $('#form-detail').trigger('reset');

                    $('#modal-detail .modal-title').text('Form Konfirmasi Persetujuan');
                    $('#form-detail').attr('data-url', urlaction);
                    $('#form-detail').attr('data-type', 'approve');
                    $('#btn-approve').show();
                    $('#btn-reject').hide();

                    $('#submission-id').val(data.submission_product_loan_id);
                    $('#product-loan').val(`${data.product_loan_name} (${data.product_loan_name_alias})`);
                    $('#plafon').val(number_format(data.submission_product_loan_plafon));
                    $('#tenor').val(`${number_format(data.submission_product_loan_tenor)} Bulan`);
                    $('#interest-percent').val(`${number_format(data.submission_product_loan_interest_percent, 2)} %`);
                    $('#forfiet-percent').val(`${number_format(data.submission_product_loan_forfiet_percent, 2)} %`);
                    $('#collateral-value').val(number_format(data.submission_product_loan_collateral_value));
                    $('#disbursement-date').val(moment(data.submission_product_loan_disbursement_date).format('DD/MM/YYYY'));
                    $('#due-date').val(moment(data.submission_product_loan_due_date).format('DD/MM/YYYY'));
                    $('#forfeit-date').val('');
                    $('#note').val(data.submission_product_loan_note);

                    let htmlCollateralSaving = '';
                    if (collateralSaving.length > 0) {
                        collateralSaving.forEach(function(item, index) {
                            htmlCollateralSaving += `
                                <div class="collateral-saving">
                                    <div class="col-md-7 col-sm-12 col-xs-12 row">
                                        <div class="form-group">
                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">Tabungan
                                            </label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <select class="form-control my-select2" readonly="readonly" disabled="disabled">
                                                    <option value="">${item.member_product_saving_name} (${item.member_product_saving_name_alias}) [${item.member_product_saving_account_number}]</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 row">
                                        <div class="form-group">
                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">Nominal Tabungan
                                            </label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" class="form-control text-right" readonly="readonly" value="${number_format(item.collateral_saving_value)}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        htmlCollateralSaving += 'Tidak ada data.';
                    }
                    $('#container-collateral-saving').html(htmlCollateralSaving);

                    let htmlCollateral = '';
                    if (collateral.length > 0) {
                        collateral.forEach(function(item, index) {
                            let strCollateralType = '';
                            let arrCollateralOption = ['BPKB', 'Sertifikat', 'Deposito', 'Lain-lain'];
                            let createdYear = item.collateral_created_year != '' && item.collateral_created_year != null ? moment(item.collateral_created_year).format('DD/MM/YYYY') : '';
                            switch (item.collateral_options) {
                                case '0':
                                    strCollateralType = `
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Jenis Kendaraan
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_vehicle_type}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Merek Kendaraan
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_vehicle_brand}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Tanggal Pembuatan
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${createdYear}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. Polisi
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_nopol}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. BPKB
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_nobpkb}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. Rangka
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_norangka}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. Mesin
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_nomesin}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Nama STNK
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_stnk_name}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Nama BPKB
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_bpkb_name}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Catatan
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <textarea class="form-control" readonly="readonly">${item.collateral_note}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                                    break;
                                case '1':
                                    strCollateralType = `
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Nama Sertifikat
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_sertifikat_name}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. Hak Milik
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_nohm}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Luas Tanah/Bangunan
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_area_size}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Atas Nama
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_atas_nama}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Lokasi Tanah/Bangunan
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_location}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. Ukur
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_measuring_number}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Catatan
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <textarea class="form-control" readonly="readonly">${item.collateral_note}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                                    break;
                                case '2':
                                    strCollateralType = `
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Jenis Deposito
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_deposito_type}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Deposito Atas Nama
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_deposito_name}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Alamat Deposito
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_deposito_address}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. Rekening Deposito
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_deposito_account_number}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Tgl. Jatuh Tempo Deposito
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control my-date-picker" value="${item.collateral_deposito_due_date}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Nominal Deposito
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control text-right my-currency" value="${number_format(item.collateral_deposito_value)}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Catatan
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <textarea class="form-control" readonly="readonly">${item.collateral_note}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                                    break;
                                case '3':
                                    strCollateralType = `
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Catatan
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <textarea class="form-control" readonly="readonly">${item.collateral_note}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                                    break;
                            }
                            htmlCollateral += `
                            <div class="collateral">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Jenis Jaminan
                                        </label>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                            <select class="form-control my-select2" disabled="disabled">
                                                <option value="">${arrCollateralOption[item.collateral_options]}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="container-collateral-type">
                                    ${strCollateralType}
                                </div>
                            </div>
                            `;
                        });
                    } else {
                        htmlCollateral += 'Tidak ada data.';
                    }
                    $('#container-collateral').html(htmlCollateral);

                    ajaxRequest('common/general/membership/member/get_detail', 'GET', {
                        id: data.submission_product_loan_member_id
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
                        id: data.submission_product_loan_member_id
                    }, function(res) {
                        if (res.status == 200) {
                            let arrSaving = res.data.saving;
                            let arrLoan = res.data.loan;

                            let totalSaldoSaving = 0;
                            let totalSaldoLoan = 0;

                            let htmlSaving = '';
                            let htmlLoan = '';
                            if (arrSaving.length > 0) {
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

                    $(".my-date-picker").daterangepicker({
                        singleDatePicker: true,
                        format: 'DD/MM/YYYY',
                        showDropdowns: true,
                    });

                    $('#modal-detail').modal('show');
                } else {
                    alert('Gagal mendapatkan data.');
                }
            });
        } else {

        }
    }

    function openModalReject(com, grid, urlaction) {
        if ($('.trSelected', grid).length > 0) {
            let submissionId = $('.trSelected', grid).attr('data-id');

            ajaxRequest('common/general/loan/submission/get_detail', 'GET', {
                id: submissionId
            }, function(res) {
                if (res.status == 200) {
                    let data = res.data;
                    let collateralSaving = res.data.collateral_saving;
                    let collateral = res.data.collateral;

                    $('#container-collateral-saving, #container-collateral').html('');
                    $(`#tabs-form a[data-toggle="tab"][href="#tab-submission-form"]`).click();
                    $('#form-detail').trigger('reset');

                    $('#modal-detail .modal-title').text('Form Konfirmasi Penolakan');
                    $('#form-detail').attr('data-url', urlaction);
                    $('#form-detail').attr('data-type', 'reject');
                    $('#btn-reject').show();
                    $('#btn-approve').hide();

                    $('#submission-id').val(data.submission_product_loan_id);
                    $('#product-loan').val(`${data.product_loan_name} (${data.product_loan_name_alias})`);
                    $('#plafon').val(number_format(data.submission_product_loan_plafon));
                    $('#tenor').val(`${number_format(data.submission_product_loan_tenor)} Bulan`);
                    $('#interest-percent').val(`${number_format(data.submission_product_loan_interest_percent, 2)} %`);
                    $('#forfiet-percent').val(`${number_format(data.submission_product_loan_forfiet_percent, 2)} %`);
                    //                    $('#collateral-type').val(data.submission_product_loan_collateral_type);
                    $('#collateral-value').val(number_format(data.submission_product_loan_collateral_value));
                    //                    $('#collateral-description').val(data.submission_product_loan_collateral_description);
                    $('#disbursement-date').val(moment(data.submission_product_loan_disbursement_date).format('DD/MM/YYYY'));
                    $('#due-date').val(moment(data.submission_product_loan_due_date).format('DD/MM/YYYY'));
                    $('#forfeit-date').val('');
                    $('#note').val(data.submission_product_loan_note);

                    let htmlCollateralSaving = '';
                    if (collateralSaving.length > 0) {
                        collateralSaving.forEach(function(item, index) {
                            htmlCollateralSaving += `
                                <div class="collateral-saving">
                                    <div class="col-md-7 col-sm-12 col-xs-12 row">
                                        <div class="form-group">
                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">Tabungan
                                            </label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <select class="form-control my-select2" disabled="disabled">
                                                    <option value="">${item.member_product_saving_name} (${item.member_product_saving_name_alias}) [${item.member_product_saving_account_number}]</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 row">
                                        <div class="form-group">
                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">Nominal Tabungan
                                            </label>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="text" class="form-control text-right" readonly="readonly" value="${number_format(item.collateral_saving_value)}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        htmlCollateralSaving += 'Tidak ada data.';
                    }
                    $('#container-collateral-saving').html(htmlCollateralSaving);

                    let htmlCollateral = '';
                    if (collateral.length > 0) {
                        collateral.forEach(function(item, index) {
                            let strCollateralType = '';
                            let arrCollateralOption = ['BPKB', 'Sertifikat', 'Deposito', 'Lain-lain'];
                            let createdYear = item.collateral_created_year != '' && item.collateral_created_year != null ? moment(item.collateral_created_year).format('DD/MM/YYYY') : '';
                            switch (item.collateral_options) {
                                case '0':
                                    strCollateralType = `
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Jenis Kendaraan
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_vehicle_type}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Merek Kendaraan
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_vehicle_brand}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Tanggal Pembuatan
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${createdYear}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. Polisi
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_nopol}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. BPKB
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_nobpkb}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. Rangka
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_norangka}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. Mesin
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_nomesin}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Nama STNK
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_stnk_name}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Nama BPKB
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_bpkb_name}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Catatan
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <textarea class="form-control" readonly="readonly">${item.collateral_note}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                                    break;
                                case '1':
                                    strCollateralType = `
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Nama Sertifikat
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_sertifikat_name}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. Hak Milik
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_nohm}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Luas Tanah/Bangunan
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_area_size}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Atas Nama
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_atas_nama}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Lokasi Tanah/Bangunan
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_location}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. Ukur
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_measuring_number}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Catatan
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <textarea class="form-control" readonly="readonly">${item.collateral_note}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                                    break;
                                case '2':
                                    strCollateralType = `
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Jenis Deposito
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_deposito_type}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Deposito Atas Nama
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_deposito_name}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Alamat Deposito
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_deposito_address}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">No. Rekening Deposito
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" value="${item.collateral_deposito_account_number}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Tgl. Jatuh Tempo Deposito
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control my-date-picker" value="${item.collateral_deposito_due_date}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Nominal Deposito
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control text-right my-currency" value="${number_format(item.collateral_deposito_value)}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Catatan
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <textarea class="form-control" readonly="readonly">${item.collateral_note}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                                    break;
                                case '3':
                                    strCollateralType = `
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Catatan
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <textarea class="form-control" readonly="readonly">${item.collateral_note}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                                    break;
                            }
                            htmlCollateral += `
                            <div class="collateral">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-12">Jenis Jaminan
                                        </label>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                            <select class="form-control my-select2" disabled="disabled">
                                                <option value="">${arrCollateralOption[item.collateral_options]}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="container-collateral-type">
                                    ${strCollateralType}
                                </div>
                            </div>
                            `;
                        });
                    } else {
                        htmlCollateral += 'Tidak ada data.';
                    }
                    $('#container-collateral').html(htmlCollateral);

                    ajaxRequest('common/general/membership/member/get_detail', 'GET', {
                        id: data.submission_product_loan_member_id
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
                        id: data.submission_product_loan_member_id
                    }, function(res) {
                        if (res.status == 200) {
                            let arrSaving = res.data.saving;
                            let arrLoan = res.data.loan;

                            let totalSaldoSaving = 0;
                            let totalSaldoLoan = 0;

                            let htmlSaving = '';
                            let htmlLoan = '';
                            if (arrSaving.length > 0) {
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

                    $(".my-date-picker").daterangepicker({
                        singleDatePicker: true,
                        format: 'DD/MM/YYYY',
                        showDropdowns: true,
                    });
                    $('#modal-detail').modal('show');
                } else {
                    alert('Gagal mendapatkan data.');
                }
            });
        } else {
            alert('Anda belum memilih data.');
        }
    }

    function downloadFileSurvey(filename) {
        openInNewTab(siteUrl + 'loan/approval_loan/get_file/' + filename);
    }

    $(document).ready(function() {

        let urlLocation = new URL(window.location);
        let params = new URLSearchParams(urlLocation.search);
        if (params.get('page') != null) {
            if (params.get('page') == 'approved') {
                $('#container-tabs a[data-toggle="tab"][href="#tab-approved"]').click();
                loadGridApproved();
            }
            if (params.get('page') == 'rejected') {
                $('#container-tabs a[data-toggle="tab"][href="#tab-rejected"]').click();
                loadGridRejected();
            }
        } else {
            $('#container-tabs a[data-toggle="tab"][href="#tab-submission"]').click();
            loadGridSubmission();
        }

        $('#container-tabs a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var uri = 'show';
            var target = $(e.target).attr("href"); // activated tab
            if (target === '#tab-submission') {
                loadGridSubmission();
            } else if (target === '#tab-approved') {
                loadGridApproved();
                uri = 'show?page=approved';
            } else if (target === '#tab-rejected') {
                loadGridRejected();
                uri = 'show?page=rejected';
            }
            window.history.replaceState({}, '', uri);
        });

        $('#tabs-form a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            let related = $(e.relatedTarget).attr("href");
            let target = $(e.target).attr("href");
            console.log(related);
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

        $('#form-upload').on('submit', function(e) {
            e.preventDefault();

            $('#form-upload button[type="submit"]').attr('disabled', 'disabled');
            let urlForm = siteUrl + 'loan/approval_loan/act_upload';

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

        $('#form-detail').on('submit', function(e) {
            e.preventDefault();
            $('#form-detail button[type="submit"]').attr('disabled', 'disabled');
            let urlForm = $(this).attr('data-url');

            let type = $(this).attr('data-type');

            if (type == 'approve') {
                let formData = new FormData(this);
                let plafon = formData.get('plafon');
                let tenor = formData.get('tenor');
                let interest = formData.get('interest_percent');
                let forfiet = formData.get('forfiet_percent');

                formData.set('plafon', convertFormatRp(plafon));
                formData.set('tenor', convertFormatPeriod(tenor));
                formData.set('interest_percent', convertFormatPercent(interest));
                formData.set('forfiet_percent', convertFormatPercent(forfiet));

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
                            $('#form-detail button[type="submit"]').removeAttr('disabled');
                            $('#modal-detail').modal('hide');
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
                            $('#modal-detail .tab-content').animate({
                                scrollTop: '0px'
                            }, 300);
                            $('#form-detail button[type="submit"]').removeAttr('disabled');
                            $("#modal-response-message-detail").finish();

                            $("#modal-response-message-detail").slideDown("fast");
                            $('#modal-response-message-detail').html(res.msg);
                            $("#modal-response-message-detail").delay(10000).slideUp(1000);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('#form-detail button[type="submit"]').removeAttr('disabled');
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                let arrId = [];
                let submissionId = $('#submission-id').val();
                arrId.push(submissionId);

                $.ajax({
                    type: 'POST',
                    url: urlForm,
                    data: 'item=' + JSON.stringify(arrId),
                    dataType: 'json',
                    success: function(res) {
                        if (res.status == 200) {
                            $('#form-detail button[type="submit"]').removeAttr('disabled');
                            $('#modal-detail').modal('hide');
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
                            $('#modal-detail .modal-body').animate({
                                scrollTop: '0px'
                            }, 300);
                            $('#form-detail button[type="submit"]').removeAttr('disabled');
                            $("#modal-response-message-detail").finish();

                            $("#modal-response-message-detail").slideDown("fast");
                            $('#modal-response-message-detail').html(res.msg);
                            $("#modal-response-message-detail").delay(10000).slideUp(1000);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('#form-detail button[type="submit"]').removeAttr('disabled');
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });

        $('.my-select2').select2({
            dropdownParent: $('#modal-add')
        });

        $(".my-date-picker").daterangepicker({
            singleDatePicker: true,
            format: 'DD/MM/YYYY',
            showDropdowns: true,
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
    });

    function loadGridSubmission() {
        if (typeof gridSubmission == 'undefined') {
            gridSubmission = $("#gridview").flexigrid({
                url: siteUrl + 'loan/approval_loan/get_data',
                params: [{
                    name: "status",
                    value: 'submission'
                }],
                dataType: 'json',
                colModel: [
                    <?php if (privilege_view('download', $this->menu_privilege)) :
                        echo "{display: 'File', name: 'download', width: 40, sortable: false, align: 'center', datasource: false},";
                    endif;
                    echo "
                    {display: 'Status Pengajuan', name: 'submission_product_loan_status', width: 100, sortable: true, align: 'center'},
                    {display: 'No. Anggota', name: 'member_code', width: 100, sortable: true, align: 'center'},
                    {display: 'Nama Anggota', name: 'member_name', width: 200, sortable: true, align: 'left'},
                    {display: 'Nama Pinjaman', name: 'product_loan_name', width: 150, sortable: true, align: 'left'},
                    {display: 'Nama Alias Pinjaman', name: 'product_loan_name_alias', width: 150, sortable: true, align: 'left'},
                    {display: 'Plafon', name: 'submission_product_loan_plafon', width: 150, sortable: true, align: 'right'},
                    {display: 'Tenor (Bulan)', name: 'submission_product_loan_tenor', width: 100, sortable: true, align: 'center'},
                    {display: 'Bunga Bulanan (%)', name: 'submission_product_loan_interest_percent', width: 110, sortable: true, align: 'center'},
                    {display: 'Total Nilai Jaminan', name: 'submission_product_loan_collateral_value', width: 150, sortable: true, align: 'right'},
                    {display: 'Tanggal Kebutuhan Cair', name: 'submission_product_loan_disbursement_date', width: 180, sortable: true, align: 'center'},
                    {display: 'Tanggal Jatuh Tempo', name: 'submission_product_loan_due_date', width: 180, sortable: true, align: 'center'},
                    {display: 'Catatan Pengajuan', name: 'submission_product_loan_note', width: 200, sortable: true, align: 'left'},
                    {display: 'Waktu Input', name: 'submission_product_loan_input_datetime', width: 180, sortable: true, align: 'center', hide: true},
                    {display: 'Username Admin Input', name: 'submission_product_loan_input_admin_username', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Nama Admin Input', name: 'submission_product_loan_input_admin_name', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Waktu Survey', name: 'submission_product_loan_status_surveyor_datetime', width: 180, sortable: true, align: 'center', hide: true},
                    {display: 'Username Admin Survey', name: 'submission_product_loan_status_surveyor_admin_username', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Nama Admin Survey', name: 'submission_product_loan_status_surveyor_admin_name', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Data Admin Approve', name: 'submission_product_loan_status_approved', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Waktu Reject', name: 'submission_product_loan_status_rejected_datetime', width: 180, sortable: true, align: 'center', hide: true},
                    {display: 'Username Admin Reject', name: 'submission_product_loan_status_rejected_admin_username', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Nama Admin Reject', name: 'submission_product_loan_status_rejected_admin_name', width: 200, sortable: true, align: 'left', hide: true},
                    ";
                    ?>
                ],
                buttons: [
                    <?php
                    if (privilege_view('approve', $this->menu_privilege)) :
                        echo "
                            {display: 'Setujui', name: 'approve', bclass: 'accept', onpress: openModalApprove, urlaction: '" . site_url("loan/approval_loan/act_approve") . "'},
                            ";
                    endif;
                    if (privilege_view('reject', $this->menu_privilege)) :
                        echo "
                            {separator: true},
                            {display: 'Tolak', name: 'reject', bclass: 'cross', onpress: openModalReject, urlaction: '" . site_url("loan/approval_loan/act_reject") . "'},
                            ";
                    endif;
                    ?>
                ],
                buttons_right: [
                    <?php if (privilege_view('export', $this->menu_privilege)) :
                    //                        echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("loan/approval_loan/export_data_approval_loan") . "'}";
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
                        name: 'submission_product_loan_collateral_description',
                        type: 'num'
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
                singleSelect: true
            });
        } else {
            $("#gridview").flexOptions({
                url: siteUrl + 'loan/approval_loan/get_data',
                params: [{
                    name: "status",
                    value: 'submission'
                }],
            }).flexClearReload();
        }
    }

    function loadGridApproved() {
        if (typeof gridApproved == 'undefined') {
            gridApproved = $("#gridview-approved").flexigrid({
                url: siteUrl + 'loan/approval_loan/get_data',
                params: [{
                    name: "status",
                    value: 'approved'
                }],
                dataType: 'json',
                colModel: [
                    <?php if (privilege_view('print', $this->menu_privilege)) :
                    //                        echo "{display: 'Print', name: 'print', width: 40, sortable: false, align: 'center', datasource: false},";
                    endif;
                    echo "
                    //{display: 'Status Pengajuan', name: 'submission_product_loan_status', width: 100, sortable: true, align: 'center'},
                    {display: 'No. Anggota', name: 'member_code', width: 100, sortable: true, align: 'center'},
                    {display: 'Nama Anggota', name: 'member_name', width: 200, sortable: true, align: 'left'},
                    {display: 'Nama Pinjaman', name: 'product_loan_name', width: 150, sortable: true, align: 'left'},
                    {display: 'Nama Alias Pinjaman', name: 'product_loan_name_alias', width: 150, sortable: true, align: 'left'},
                    {display: 'Plafon', name: 'submission_product_loan_plafon', width: 150, sortable: true, align: 'right'},
                    {display: 'Tenor (Bulan)', name: 'submission_product_loan_tenor', width: 80, sortable: true, align: 'center'},
                    {display: 'Bunga (%)', name: 'submission_product_loan_interest_percent', width: 80, sortable: true, align: 'center'},
                    {display: 'Tipe Jaminan', name: 'submission_product_loan_collateral_type', width: 200, sortable: true, align: 'left'},
                    {display: 'Total Nilai Jaminan', name: 'submission_product_loan_collateral_value', width: 150, sortable: true, align: 'right'},
                    {display: 'Deskripsi Jaminan', name: 'submission_product_loan_collateral_description', width: 300, sortable: true, align: 'left'},
                    {display: 'Tanggal Kebutuhan Cair', name: 'submission_product_loan_disbursement_date', width: 180, sortable: true, align: 'center'},
                    {display: 'Catatan Pengajuan', name: 'submission_product_loan_note', width: 200, sortable: true, align: 'left'},
                    {display: 'Waktu Input', name: 'submission_product_loan_input_datetime', width: 180, sortable: true, align: 'center', hide: true},
                    {display: 'Username Admin Input', name: 'submission_product_loan_input_admin_username', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Nama Admin Input', name: 'submission_product_loan_input_admin_name', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Waktu Survey', name: 'submission_product_loan_status_surveyor_datetime', width: 180, sortable: true, align: 'center', hide: true},
                    {display: 'Username Admin Survey', name: 'submission_product_loan_status_surveyor_admin_username', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Nama Admin Survey', name: 'submission_product_loan_status_surveyor_admin_name', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Waktu Approve', name: 'submission_product_loan_status_approved_datetime', width: 180, sortable: true, align: 'center', hide: true},
                    {display: 'Username Admin Approve', name: 'submission_product_loan_status_approved_admin_username', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Nama Admin Approve', name: 'submission_product_loan_status_approved_admin_name', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Waktu Reject', name: 'submission_product_loan_status_rejected_datetime', width: 180, sortable: true, align: 'center', hide: true},
                    {display: 'Username Admin Reject', name: 'submission_product_loan_status_rejected_admin_username', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Nama Admin Reject', name: 'submission_product_loan_status_rejected_admin_name', width: 200, sortable: true, align: 'left', hide: true},
                    "; ?>
                ],
                buttons_right: [
                    <?php if (privilege_view('export', $this->menu_privilege)) :
                    //                        echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("loan/approval_loan/export_data_approval_loan") . "'}";
                    endif; ?>
                ],
                searchitems: [
                    //                    {display: 'Status Pengajuan', name: 'member_code', type: 'select', option:'0:Waiting|1:Surveyed|2:Approved|3:Rejected'},
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
                        display: 'Persen Bunga',
                        name: 'submission_product_loan_collateral_type',
                        type: 'num'
                    },
                    {
                        display: 'Tipe Jaminan',
                        name: 'submission_product_loan_collateral_value',
                        type: 'text'
                    },
                    {
                        display: 'Total Nilai Jaminan',
                        name: 'submission_product_loan_collateral_description',
                        type: 'num'
                    },
                    {
                        display: 'Deskripsi Jaminan',
                        name: 'submission_product_loan_disbursement_text',
                        type: 'text'
                    },
                    {
                        display: 'Tanggal Kebutuhan Cair',
                        name: 'submission_product_loan_note',
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
                        display: 'Waktu Approve',
                        name: 'submission_product_loan_status_approved_texttime',
                        type: 'date'
                    },
                    {
                        display: 'Username Admin Approve',
                        name: 'submission_product_loan_status_approved_admin_username',
                        type: 'text'
                    },
                    {
                        display: 'Nama Admin Approve',
                        name: 'submission_product_loan_status_approved_admin_name',
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
        } else {
            $("#gridview-approved").flexOptions({
                url: siteUrl + 'loan/approval_loan/get_data',
                params: [{
                    name: "status",
                    value: 'approved'
                }],
            }).flexClearReload();
        }
    }

    function loadGridRejected() {
        if (typeof gridRejected == 'undefined') {
            gridRejected = $("#gridview-rejected").flexigrid({
                url: siteUrl + 'loan/approval_loan/get_data',
                params: [{
                    name: "status",
                    value: 'rejected'
                }],
                dataType: 'json',
                colModel: [
                    <?php if (privilege_view('print', $this->menu_privilege)) :
                    //                        echo "{display: 'Print', name: 'print', width: 40, sortable: false, align: 'center', datasource: false},";
                    endif;
                    echo "
                    //{display: 'Status Pengajuan', name: 'submission_product_loan_status', width: 100, sortable: true, align: 'center'},
                    {display: 'No. Anggota', name: 'member_code', width: 100, sortable: true, align: 'center'},
                    {display: 'Nama Anggota', name: 'member_name', width: 200, sortable: true, align: 'left'},
                    {display: 'Nama Pinjaman', name: 'product_loan_name', width: 150, sortable: true, align: 'left'},
                    {display: 'Nama Alias Pinjaman', name: 'product_loan_name_alias', width: 150, sortable: true, align: 'left'},
                    {display: 'Plafon', name: 'submission_product_loan_plafon', width: 150, sortable: true, align: 'right'},
                    {display: 'Tenor (Bulan)', name: 'submission_product_loan_tenor', width: 80, sortable: true, align: 'center'},
                    {display: 'Bunga (%)', name: 'submission_product_loan_interest_percent', width: 80, sortable: true, align: 'center'},
                    {display: 'Tipe Jaminan', name: 'submission_product_loan_collateral_type', width: 200, sortable: true, align: 'left'},
                    {display: 'Total Nilai Jaminan', name: 'submission_product_loan_collateral_value', width: 150, sortable: true, align: 'right'},
                    {display: 'Deskripsi Jaminan', name: 'submission_product_loan_collateral_description', width: 300, sortable: true, align: 'left'},
                    {display: 'Tanggal Kebutuhan Cair', name: 'submission_product_loan_disbursement_date', width: 180, sortable: true, align: 'center'},
                    {display: 'Catatan Pengajuan', name: 'submission_product_loan_note', width: 200, sortable: true, align: 'left'},
                    {display: 'Waktu Input', name: 'submission_product_loan_input_datetime', width: 180, sortable: true, align: 'center', hide: true},
                    {display: 'Username Admin Input', name: 'submission_product_loan_input_admin_username', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Nama Admin Input', name: 'submission_product_loan_input_admin_name', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Waktu Survey', name: 'submission_product_loan_status_surveyor_datetime', width: 180, sortable: true, align: 'center', hide: true},
                    {display: 'Username Admin Survey', name: 'submission_product_loan_status_surveyor_admin_username', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Nama Admin Survey', name: 'submission_product_loan_status_surveyor_admin_name', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Waktu Approve', name: 'submission_product_loan_status_approved_datetime', width: 180, sortable: true, align: 'center', hide: true},
                    {display: 'Username Admin Approve', name: 'submission_product_loan_status_approved_admin_username', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Nama Admin Approve', name: 'submission_product_loan_status_approved_admin_name', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Waktu Reject', name: 'submission_product_loan_status_rejected_datetime', width: 180, sortable: true, align: 'center', hide: true},
                    {display: 'Username Admin Reject', name: 'submission_product_loan_status_rejected_admin_username', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Nama Admin Reject', name: 'submission_product_loan_status_rejected_admin_name', width: 200, sortable: true, align: 'left', hide: true},
                    ";  ?>
                ],
                buttons_right: [
                    <?php if (privilege_view('export', $this->menu_privilege)) :
                    //                        echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("loan/approval_loan/export_data_approval_loan") . "'}";
                    endif; ?>
                ],
                searchitems: [
                    //                    {display: 'Status Pengajuan', name: 'member_code', type: 'select', option:'0:Waiting|1:Surveyed|2:Approved|3:Rejected'},
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
                        name: 'submisison_product_loan_plafon',
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
                        display: 'Persen Bunga',
                        name: 'submission_product_loan_collateral_type',
                        type: 'num'
                    },
                    {
                        display: 'Tipe Jaminan',
                        name: 'submission_product_loan_collateral_value',
                        type: 'text'
                    },
                    {
                        display: 'Total Nilai Jaminan',
                        name: 'submission_product_loan_collateral_description',
                        type: 'num'
                    },
                    {
                        display: 'Deskripsi Jaminan',
                        name: 'submission_product_loan_disbursement_text',
                        type: 'text'
                    },
                    {
                        display: 'Tanggal Kebutuhan Cair',
                        name: 'submission_product_loan_note',
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
                        display: 'Waktu Approve',
                        name: 'submission_product_loan_status_approved_texttime',
                        type: 'date'
                    },
                    {
                        display: 'Username Admin Approve',
                        name: 'submission_product_loan_status_approved_admin_username',
                        type: 'text'
                    },
                    {
                        display: 'Nama Admin Approve',
                        name: 'submission_product_loan_status_approved_admin_name',
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
        } else {
            $("#gridview-rejected").flexOptions({
                url: siteUrl + 'loan/approval_loan/get_data',
                params: [{
                    name: "status",
                    value: 'rejected'
                }],
            }).flexClearReload();
        }
    }

    // function request with ajax
    function ajaxRequest(url, method = 'GET', data = '', callback) {
        $.ajax({
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
            $('#modal-detail .tab-content').animate({
                scrollTop: '0px'
            }, 300);
        }
    });
</script>
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
        background-color: #eeeff1;
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
        background: #fafafa url(<?php echo site_url('addons/flexigrid/css/images/fhbg.gif');
                                ?>) repeat-x bottom;
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
        background: url(<?php echo site_url('addons/flexigrid/button/images/add.png');
                        ?>) no-repeat scroll left center transparent;
    }

    .table-like-flexigrid .fbutton .list {
        background: url(<?php echo site_url('addons/flexigrid/button/images/list.png');
                        ?>) no-repeat scroll left center transparent;
    }

    .table-like-flexigrid .fbutton .accounting {
        background: url(<?php echo site_url('addons/flexigrid/button/images/accounting.png');
                        ?>) no-repeat scroll left center transparent;
    }

    .table-like-flexigrid .fbutton .selectall {
        background: url(<?php echo site_url('addons/flexigrid/button/images/check-all.png');
                        ?>) no-repeat scroll left center transparent;
    }

    .table-like-flexigrid .fbutton .unselectall {
        background: url(<?php echo site_url('addons/flexigrid/button/images/check-none.png');
                        ?>) no-repeat scroll left center transparent;
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
        background: #fafafa url(<?php echo site_url('addons/flexigrid/css/images/fhbg.gif');
                                ?>) repeat-x bottom;
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
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="col-md-6 col-sm-2 col-xs-12 form-group">
                    <input id="input-filter-date" type="text" name="filter_date" class="form-control input-sm" placeholder="Filter Tanggal" value="" autocomplete="off" readonly="readonly" style="background-color:#fff; border-radius: 4px 0px 0px 4px;">
                </div>
                <div class="col-md-2 col-sm-3 col-xs-12">
                    <button type="button" class="btn btn-default btn-sm btn-round" onclick="filterByDate()"><i class="fa fa-search"></i> Filter</button>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-12">
                    <button type="button" class="btn btn-dark btn-sm btn-round" onclick="resetDate()"><i class="fa fa-refresh"></i> Reset</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div id="response_message" style="display:none;"></div>
        <table id="gridview" style="display:none;"></table>
    </div>
</div>

<!-- Modal choose Member-->
<div id="modal-choose-member" class="modal" role="dialog" tab-index="-1" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Pemutihan Angsuran Pinjaman</h4>
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

<!--MODAL PAYMENT LOAN-->
<div id="modal-payment-loan" class="modal modal-fullscreen" role="dialog" tab-index="-1" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Pemutihan Angsuran Pinjaman</h4>
            </div>
            <form id="form-payment-loan" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body" style="overflow-y: auto; max-height: calc(100vh - 130px)">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div id="modal-response-message-payment-loan" class="fade in" role="alert" style="display:none"></div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
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
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Informasi Jaminan</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content" style="overflow-y: auto; height: calc(100vh - 465px); padding: 5px;">
                                    <ul id="container-tab-collateral" class="nav nav-tabs bar_tabs" role="tablist">
                                        <li class="active"><a data-toggle="tab" href="#tab-collateral-saving">Tabungan</a></li>
                                        <li><a data-toggle="tab" href="#tab-collateral">Fisik/Aset</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="tab-collateral-saving" class="tab-pane fade in active">
                                            <div id="container-collateral-saving"></div>
                                        </div>
                                        <div id="tab-collateral" class="tab-pane fade">
                                            <div id="container-collateral"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 row">
                            <div class="form-group">
                                <label class="control-label col-md-12 col-sm-12 col-xs-12">Pilih Pinjaman <span class="required">*</span> </label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select id="input-loan" name="id" class="form-control my-select2" data-validation="required">
                                        <option value="">--Pilih Pinjaman--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" id="info-last-payment"></div>
                        <div class="col-md-12 col-sm-12 col-xs-12" id="info-due-date"></div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <ul id="container-tab-period" class="nav nav-tabs bar_tabs" role="tablist">
                                <li class="active"><a data-toggle="tab" href="#tab-payment">Pemutihan Angsuran Pinjaman</a></li>
                                <li><a data-toggle="tab" href="#tab-history-payment">Riwayat Angsuran Pinjaman</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="tab-payment" class="tab-pane fade in active">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <table id="table-installment" class="table-like-flexigrid" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="font-weight: bold; width: 5%;" rowspan="2">No.</th>
                                                        <th class="text-center" style="font-weight: bold; width: 5%;" rowspan="2"><input type="checkbox" id="check-select-all"></th>
                                                        <th class="text-center" style="font-weight: bold; width: 8%;" rowspan="2">Periode</th>
                                                        <th class="text-center" style="font-weight: bold; width: 10%;" rowspan="2">Bulan</th>
                                                        <th class="text-center" style="font-weight: bold; width: 18%;" colspan="2">Angsuran Pokok</th>
                                                        <th class="text-center" style="font-weight: bold; width: 18%;" colspan="2">Bunga</th>
                                                        <th class="text-center" style="font-weight: bold; width: 18%;" colspan="2">Denda</th>
                                                        <th class="text-center" style="font-weight: bold; width: 18%;" colspan="2">Total</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-right" style="font-weight: bold; width: 9%;">Nominal (Rp.)</th>
                                                        <th class="text-right" style="font-weight: bold; width: 9%;">Terbayar (Rp.)</th>
                                                        <th class="text-right" style="font-weight: bold; width: 9%;">Nominal (Rp.)</th>
                                                        <th class="text-right" style="font-weight: bold; width: 9%;">Terbayar (Rp.)</th>
                                                        <th class="text-right" style="font-weight: bold; width: 9%;">Nominal (Rp.)</th>
                                                        <th class="text-right" style="font-weight: bold; width: 9%;">Terbayar (Rp.)</th>
                                                        <th class="text-right" style="font-weight: bold; width: 9%;">Nominal (Rp.)</th>
                                                        <th class="text-right" style="font-weight: bold; width: 9%;">Terbayar (Rp.)</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                            <input id="input-member-id" type="hidden" name="member_id" value="0">
                                            <input id="input-period" type="hidden" name="period" value="0">
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nominal Pokok</label>
                                                <div class="col-md-5 col-sm-5 col-xs-12">
                                                    <input id="input-principal" type="text" name="principal" onchange="handlerChangeInput(this)" data-name="Nominal Pokok" class="form-control my-currency text-right readonlyable" data-max="0">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Bunga</label>
                                                <div class="col-md-5 col-sm-5 col-xs-12">
                                                    <input id="input-interest" type="text" name="interest" onchange="handlerChangeInput(this)" data-name="Bunga" class="form-control my-currency text-right readonlyable" data-max="0">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Denda</label>
                                                <div class="col-md-5 col-sm-5 col-xs-12">
                                                    <input id="input-forfeit" type="text" name="forfeit" onchange="handlerChangeInput(this)" data-name="Denda" class="form-control my-currency text-right readonlyable" data-max="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-history-payment" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <table id="table-history" class="table-like-flexigrid" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="font-weight: bold; width: 5%;">No.</th>
                                                        <th class="text-center" style="font-weight: bold; width: 16%;">Tgl Pelunasan</th>
                                                        <th class="text-center" style="font-weight: bold; width: 8%;">Periode</th>
                                                        <th class="text-center" style="font-weight: bold; width: 10%;">Bulan</th>
                                                        <th class="text-right" style="font-weight: bold; width: 14%;">Angsuran Pokok</th>
                                                        <th class="text-right" style="font-weight: bold; width: 14%;">Bunga</th>
                                                        <th class="text-right" style="font-weight: bold; width: 14%;">Denda</th>
                                                        <th class="text-right" style="font-weight: bold; width: 14%;">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="pull-left" style="font-size: 18px; font-weight: bold;">Total Pemutihan: Rp. <span id="total-payment"></span></span>
                    <button type="button" onclick="openModalConfirmation()" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp; Proses Pemutihan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END MODAL PAYMENT LOAN-->

<!-- MODAL CONFIRMATION-->
<div id="modal-confirmation" class="modal" role="dialog" tab-index="-1" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Konfirmasi Pemutihan Angsuran Pinjaman</h4>
            </div>
            <div class="modal-body" style="overflow-y: auto; max-height: calc(100vh - 200px)">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        Yakin akan melakukan Pemutihan angsuran pinjaman atas nama <span id="confirm-member-name"></span> ?
                        <br>
                        Dengan rincian sebagai berikut:
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <table id="table-confirmation" class="table-like-flexigrid" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="font-weight: bold; width: 5%;">No.</th>
                                    <th class="text-center" style="font-weight: bold; width: 8%;">Periode</th>
                                    <th class="text-center" style="font-weight: bold; width: 10%;">Bulan</th>
                                    <th class="text-right" style="font-weight: bold; width: 18%;">Angsuran Pokok</th>
                                    <th class="text-right" style="font-weight: bold; width: 18%;">Bunga</th>
                                    <th class="text-right" style="font-weight: bold; width: 18%;">Denda</th>
                                    <th class="text-right" style="font-weight: bold; width: 18%;">Total</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr style="font-size: 14px; font-weight: bold;">
                                    <td colspan="6" class="text-right">Total Pemutihan</td>
                                    <td id="confirm-total-payment" class="text-right"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="processConfirmation()" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp; Proses</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<!--END MODAL CONFIRMATION-->

<!-- MODAL SUCCESS PAYMENT-->
<div id="modal-success-payment" class="modal" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div id="modal-response-message-success-payment" class="fade in" role="alert" style="display:none"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<!--END MODAL SUCCESS PAYMENT-->

<!--FORM VALIDATOR-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<!--MASK MONEY-->
<script src="<?php echo THEMES_BACKEND; ?>/js/jquery.maskMoney.min.js"></script>

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';

    let gridMember;

    let arrInvoiceUnpaid = [];
    let arrInvoicePaid = [];

    let collateralSaving = [];
    let collateral = [];

    function openModalChooseMember() {
        loadFlexigridMember();
        $('#modal-choose-member').modal('show');
    }

    function chooseMember(com, grid, urlaction) {
        let grid_id = $(grid).attr('id');
        grid_id = grid_id.substring(grid_id.lastIndexOf('grid_') + 5);

        arrInvoiceUnpaid = [];
        arrInvoicePaid = [];
        collateralSaving = [];
        collateral = [];
        $('#info-last-payment').html('');
        $('#info-due-date').html('');
        $('#input-loan').html('<option value="">--Pilih Pinjaman--</option>');
        $('#input-member-id, #input-period').val(0);
        $('#container-tab-period a[data-toggle="tab"][href="#tab-payment"]').click();
        $('#container-tab-collateral a[data-toggle="tab"][href="#tab-collateral-saving"]').click();
        $('#confirm-member-name').text('');
        $('#modal-payment-loan .modal-body').animate({scrollTop: '0px'}, 300);

        if ($('.trSelected', grid).length > 0) {
            let memberId = $('.trSelected', grid).attr('data-id');
            ajaxRequest('common/general/membership/member/get_detail', 'GET', {
                id: memberId
            }, function(res) {
                if (res.status == 200) {
                    let data = res.data;
                    $('#input-member-id').val(memberId);
                    $('#confirm-member-name').text(data.member_name);

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

                    ajaxRequest('common/general/transaction/loan/get_option_loan', 'GET', {
                        member_id: memberId
                    }, function(resLoan) {
                        if (resLoan.status == 200) {
                            let dataLoan = resLoan.data;

                            let htmlOption = '';
                            dataLoan.forEach(loan => {
                                htmlOption += `
                                    <option value="${loan.id}">${loan.name} (${loan.name_alias}) [${loan.code}]</option>
                                `;
                            });
                            $('#input-loan').html(htmlOption).change();

                            createHtmlTable();
                            createHtmlTableHistory();
                            createHtmlCollateral();
                            $('#modal-payment-loan').modal({backdrop: 'static'},'show');
                        } else {
                            alert(resLoan.msg);
                        }
                    });
                } else {
                    alert(res.msg);
                }
            });
        } else {
            alert('Pilih Anggota terlebih dahulu.');
            setTimeout(function() {
                $('#grid_gridview-member .trSelected').removeClass('trSelected');
                $('#grid_gridview-member tr[tabindex="1"].control-row:visible').addClass('trSelected').focus();
            }, 200);
        }
    }

    function filterByDate() {
        let dates = $('#input-filter-date').val();
        if (dates != '') {
            let arrSplit = dates.split("s/d");
            startDate = arrSplit[0].trim();
            endDate = arrSplit[1].trim();
            $("#gridview").flexOptions({
                url: siteUrl + 'transaction/writeoff/get_data',
                params: [{
                    name: "start_date",
                    value: startDate
                }, {
                    name: "end_date",
                    value: endDate
                }],
            }).flexClearReload();
        } else {
            alert('Inputkan tanggal terlebih dahulu.');
        }
    }

    function resetDate() {
        $('#input-filter-date').val('');
        startDate = '';
        endDate = '';
        $("#gridview").flexOptions({
            url: siteUrl + 'transaction/writeoff/get_data',
            params: [{
                name: "start_date",
                value: startDate
            }, {
                name: "end_date",
                value: endDate
            }],
        }).flexClearReload();
    }

    function handlerCheckbox(element) {
        let isChecked = $(element).is(":checked");
        let dataIndex = parseInt($(element).attr('data-index'));

        $('.row-checkbox').each(function(index, checkbox) {
            $('#check-select-all').prop('checked', false);
            let dataIndexCheckbox = parseInt($(checkbox).attr('data-index'));
            if (isChecked) {
                if (dataIndexCheckbox <= dataIndex) {
                    $(checkbox).prop('checked', true);
                } else {
                    $(checkbox).prop('checked', false);
                }
            } else {
                if (dataIndexCheckbox < dataIndex) {
                    $(checkbox).prop('checked', true);
                } else {
                    $(checkbox).prop('checked', false);
                }
            }
        });
        calculateAllCheck();
    }

    function calculateAllCheck() {
        $('.readonlyable').prop('readonly', false);
        $('#input-period').val(0);

        let countRowCheck = $('.row-checkbox:checked').length;

        if (countRowCheck > 0) {
            $('#input-period').val(countRowCheck);
        }

        let totalPrincipal = 0;
        let totalInterest = 0;
        let totalForfeit = 0;

        $('.row-checkbox:checked').each(function(index, element) {
            let dataIndex = $(element).attr('data-index');
            let dataPrincipal = $(element).attr('data-principal');
            let dataInterest = $(element).attr('data-interest');
            let dataForfeit = $(element).attr('data-forfeit');

            let dataPrincipalPaid = $(element).attr('data-principal-paid');
            let dataInterestPaid = $(element).attr('data-interest-paid');
            let dataForfeitPaid = $(element).attr('data-forfeit-paid');

            let dataPrincipalPay = parseInt(dataPrincipal) - parseInt(dataPrincipalPaid);
            let dataInterestPay = parseInt(dataInterest) - parseInt(dataInterestPaid);
            let dataForfeitPay = parseInt(dataForfeit) - parseInt(dataForfeitPaid);
            
            totalPrincipal += dataPrincipalPay;
            totalInterest += dataInterestPay;
            totalForfeit += dataForfeitPay;
        });

        $('#input-principal').val(number_format(totalPrincipal)).attr('data-max', totalPrincipal);
        $('#input-interest').val(number_format(totalInterest)).attr('data-max', totalInterest);
        $('#input-forfeit').val(number_format(totalForfeit)).attr('data-max', totalForfeit);

        if (countRowCheck > 1 || countRowCheck == 0) {
            $('.readonlyable').prop('readonly', true);
        }

        $('#total-payment').text(number_format(totalPrincipal + totalInterest + totalForfeit));
    }

    function createHtmlTable() {
        let htmlTable = '';
        if (arrInvoiceUnpaid.length > 0) {
            arrInvoiceUnpaid.forEach((invoice, index) => {
                htmlTable += `
                    <tr>
                        <td>${index + 1}</td>
                        <td class="text-center">
                            <input type="checkbox" name="period[]" class="row-checkbox" onchange="handlerCheckbox(this)" 
                            data-index="${index}" 
                            data-period="${invoice.period}" 
                            data-due-date="${invoice.due_date}" 
                            data-principal="${invoice.principal_value}" 
                            data-principal-paid="${invoice.principal_paid}" 
                            data-interest="${invoice.interest_value}" 
                            data-interest-paid="${invoice.interest_paid}" 
                            data-forfeit="${invoice.forfeit_value}"
                            data-forfeit-paid="${invoice.forfeit_paid}" value="1">
                        </td>
                        <td class="text-center">${invoice.period}</td>
                        <td class="text-center">${moment(invoice.due_date).format('MMMM YYYY')}</td>
                        <td class="text-right">${number_format(invoice.principal_value)}</td>
                        <td class="text-right">${number_format(invoice.principal_paid)}</td>
                        <td class="text-right">${number_format(invoice.interest_value)}</td>
                        <td class="text-right">${number_format(invoice.interest_paid)}</td>
                        <td class="text-right">${number_format(invoice.forfeit_value)}</td>
                        <td class="text-right">${number_format(invoice.forfeit_paid)}</td>
                        <td class="text-right">${number_format(invoice.total_value)}</td>
                        <td class="text-right">${number_format(invoice.total_paid)}</td>
                    </tr>
                `;
            });
        } else {
            htmlTable += `
                    <tr><td colspan="12">Belum ada tagihan. Silahkan pilih pinjaman terlebih dahulu.</td></tr>
            `;
        }
        $('#table-installment tbody').html(htmlTable);
        calculateAllCheck();
    }

    function createHtmlTableHistory() {
        let htmlTable = '';
        if (arrInvoicePaid.length > 0) {
            arrInvoicePaid.forEach((invoice, index) => {
                htmlTable += `
                    <tr>
                        <td>${index + 1}</td>
                        <td class="text-center">${moment(invoice.paid_datetime).format('DD MMMM YYYY')}</td>
                        <td class="text-center">${invoice.period}</td>
                        <td class="text-center">${moment(invoice.due_date).format('MMMM YYYY')}</td>
                        <td class="text-right">${number_format(invoice.principal_paid)}</td>
                        <td class="text-right">${number_format(invoice.interest_paid)}</td>
                        <td class="text-right">${number_format(invoice.forfeit_paid)}</td>
                        <td class="text-right">${number_format(invoice.total_paid)}</td>
                    </tr>
                `;
            });
        } else {
            htmlTable += `
                    <tr><td colspan="8">Belum ada riwayat pembayaran.</td></tr>
            `;
        }
        $('#table-history tbody').html(htmlTable);
    }

    function createHtmlTableConfirmation() {
        let countRowCheck = $('.row-checkbox:checked').length;

        let totalPrincipal = 0;
        let totalInterest = 0;
        let totalForfeit = 0;

        let htmlTable = '';
        if (countRowCheck > 0) {
            if(countRowCheck > 1){
                $('.row-checkbox:checked').each(function(index, element) {
                    let dataPeriod = $(element).attr('data-period');
                    let dataPrincipal = $(element).attr('data-principal');
                    let dataInterest = $(element).attr('data-interest');
                    let dataForfeit = $(element).attr('data-forfeit');
                    let dataDueDate = $(element).attr('data-due-date');

                    let dataPrincipalPaid = $(element).attr('data-principal-paid');
                    let dataInterestPaid = $(element).attr('data-interest-paid');
                    let dataForfeitPaid = $(element).attr('data-forfeit-paid');

                    let dataPrincipalPay = parseInt(dataPrincipal) - parseInt(dataPrincipalPaid);
                    let dataInterestPay = parseInt(dataInterest) - parseInt(dataInterestPaid);
                    let dataForfeitPay = parseInt(dataForfeit) - parseInt(dataForfeitPaid);

                    let total = parseInt(dataPrincipalPay) + parseInt(dataInterestPay) + parseInt(dataForfeitPay);

                    totalPrincipal += parseInt(dataPrincipalPay);
                    totalInterest += parseInt(dataInterestPay);
                    totalForfeit += parseInt(dataForfeitPay);

                    htmlTable += `
                        <tr>
                            <td>${index + 1}</td>
                            <td class="text-center">${dataPeriod}</td>
                            <td class="text-center">${moment(dataDueDate).format('MMMM YYYY')}</td>
                            <td class="text-right">${number_format(dataPrincipalPay)}</td>
                            <td class="text-right">${number_format(dataInterestPay)}</td>
                            <td class="text-right">${number_format(dataForfeitPay)}</td>
                            <td class="text-right">${number_format(total)}</td>
                        </tr>
                    `;
                });
            }else{
                let dataPeriod = $('.row-checkbox:checked').attr('data-period');
                let dataDueDate = $('.row-checkbox:checked').attr('data-due-date');

                totalPrincipal += convertFormatRp($('#input-principal').val());
                totalInterest += convertFormatRp($('#input-interest').val());
                totalForfeit += convertFormatRp($('#input-forfeit').val());

                let total = parseInt(totalPrincipal) + parseInt(totalInterest) + parseInt(totalForfeit);

                htmlTable += `
                    <tr>
                        <td>1</td>
                        <td class="text-center">${dataPeriod}</td>
                        <td class="text-center">${moment(dataDueDate).format('MMMM YYYY')}</td>
                        <td class="text-right">${number_format(totalPrincipal)}</td>
                        <td class="text-right">${number_format(totalInterest)}</td>
                        <td class="text-right">${number_format(totalForfeit)}</td>
                        <td class="text-right">${number_format(total)}</td>
                    </tr>
                `;
            }
        } else {
            htmlTable += `
                    <tr><td colspan="7">Belum ada data.</td></tr>
            `;
        }
        $('#table-confirmation tbody').html(htmlTable);
        $('#confirm-total-payment').text(number_format(totalPrincipal + totalInterest + totalForfeit));
    }

    function openModalConfirmation(){
        let isError = false;
        $(`#form-payment-loan select`).validate(function (valid, elem){
            if (!valid) {
                isError = true;
            }
        });
        if (isError) {
            $('#modal-payment-loan .modal-body').animate({scrollTop: '0px'}, 300);
            return false;
        }
        let countRowCheck = $('.row-checkbox:checked').length;
        if(countRowCheck <= 0){
            alert('Pilih periode terlebih dahulu.');
            return false;
        }
        createHtmlTableConfirmation();
        $('#modal-confirmation').modal({backdrop: 'static'},'show');
    }

    function processConfirmation(){
        $('#form-payment-loan').submit();
    }

    function handlerChangeInput(element) {
        let value = convertFormatRp($(element).val());
        let dataMaximum = $(element).attr('data-max');
        let dataName = $(element).attr('data-name');

        if (value > dataMaximum) {
            alert(`${dataName} melebihi jumlah yang harus dibayarkan.`);
            $(element).val(number_format(dataMaximum));
        }

        let totalPrincipal = convertFormatRp($('#input-principal').val());
        let totalInterest = convertFormatRp($('#input-interest').val());
        let totalForfeit = convertFormatRp($('#input-forfeit').val());

        $('#total-payment').text(number_format(totalPrincipal + totalInterest + totalForfeit));
    }

    $(document).ready(function() {
        // $('#modal-payment-loan').modal('show');

        $('#input-loan').on('change', function() {
            let value = $(this).val();
            arrInvoiceUnpaid = [];
            arrInvoicePaid = [];
            collateralSaving = [];
            collateral = [];
            $('#info-last-payment').html('');
            $('#info-due-date').html('');
            if (value) {
                ajaxRequest('common/general/transaction/loan/get_data_invoice', 'GET', {
                    id: value
                }, function(res) {
                    if (res.status == 200) {
                        arrInvoiceUnpaid = res.data.unpaid;
                        arrInvoicePaid = res.data.paid;
                        collateralSaving = res.data.collateral_saving;
                        collateral = res.data.collateral;

                        if(res.data.last_paid_period != '' && res.data.last_paid_date != ''){
                            let strLastPaidDate = 'n/a';
                            let lastPaidDate = res.data.last_paid_date;
                            if (lastPaidDate) {
                                strLastPaidDate = moment(lastPaidDate).format('MMMM YYYY');
                            }
                            $('#info-last-payment').html(`Periode Terakhir bayar: ${res.data.last_paid_period} / ${strLastPaidDate}`);
                        }
                        
                        if(res.data.last_due_date != ''){
                            let strLastDueDate = 'n/a';
                            let lastDueDate = res.data.last_due_date;
                            if (lastDueDate) {
                                strLastDueDate = moment(lastDueDate).format('DD MMMM YYYY');
                            }
                            $('#info-due-date').html(`Tanggal Jatuh Tempo: ${strLastDueDate}`);
                        }
                    } else {
                        alert(res.msg);
                    }
                    createHtmlTable();
                    createHtmlTableHistory();
                    createHtmlCollateral();
                });
            } else {
                createHtmlTable();
                createHtmlTableHistory();
                createHtmlCollateral();
            }
        });

        $('#check-select-all').on('change', function(e) {
            let isChecked = $(this).is(":checked");
            if (isChecked) {
                $('.row-checkbox').prop('checked', true);
            } else {
                $('.row-checkbox').prop('checked', false);
            }
            calculateAllCheck();
        });

        $('#form-payment-loan').on('submit', function(e) {
            e.preventDefault();

            $('#form-payment-loan button[type="submit"]').attr('disabled', 'disabled');
            let urlForm = siteUrl + 'transaction/writeoff/act_add_paid';

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
                        $('#modal-payment-loan').modal('hide');
                        $('#modal-confirmation').modal('hide');
                        $('#modal-success-payment').modal({backdrop: 'static'}, 'show');
                        $('#form-payment-loan button[type="submit"]').removeAttr('disabled');

                        $('#gridview').flexClearReload();

                        let message_class = 'alert alert-success';

                        $("#modal-response-message-success-payment").addClass(message_class);
                        $("#modal-response-message-success-payment").slideDown("fast");
                        $("#modal-response-message-success-payment").html(res.data);
                    } else {
                        $('#form-payment-loan button[type="submit"]').removeAttr('disabled');
                        $('#modal-confirmation').modal('hide');

                        $('#modal-payment-loan .modal-body').animate({scrollTop: '0px'}, 300);
                        let message_class = 'alert alert-danger';
                        $("#modal-response-message-payment-loan").finish();
                        $("#modal-response-message-payment-loan").addClass(message_class);

                        $("#modal-response-message-payment-loan").slideDown("fast");
                        $('#modal-response-message-payment-loan').html(res.msg);
                        $("#modal-response-message-payment-loan").delay(10000).slideUp(1000, function (){
                            $("#modal-response-message-payment-loan").removeClass(message_class);
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#form-payment-loan button[type="submit"]').removeAttr('disabled');
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
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

    });

    function createHtmlCollateral(){
        let htmlCollateralSaving = '';
            if(collateralSaving.length > 0){
                collateralSaving.forEach(function (item, index){
                    htmlCollateralSaving += `
                        <div class="collateral-saving">
                            <div class="col-md-7 col-sm-12 col-xs-12 row">
                                <div class="form-group">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">Tabungan
                                    </label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" class="form-control" readonly="readonly" value="${item.member_product_saving_name} (${item.member_product_saving_name_alias}) [${item.member_product_saving_account_number}]">
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
            }else{
                htmlCollateralSaving += 'Belum ada data.';
            }
            $('#container-collateral-saving').html(htmlCollateralSaving);

            let htmlCollateral = '';
            if(collateral.length > 0){
                collateral.forEach(function (item, index){
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
                                    <input type="text" class="form-control" value="${arrCollateralOption[item.collateral_options]}" readonly="readonly">
                                </div>
                            </div>
                        </div>
                        <div class="container-collateral-type">
                            ${strCollateralType}
                        </div>
                    </div>
                    `;
                });
            }else{
                htmlCollateral += 'Belum ada data.';
            }
            $('#container-collateral').html(htmlCollateral);
    }

    $("#gridview").flexigrid({
        url: siteUrl + 'transaction/writeoff/get_data',
        params: [{name: "start_date", value: ""}, {name: "end_date", value: ""}],
        dataType: 'json',
        colModel: [
            {display: 'Tanggal Pembayaran', name: 'transaction_datetime', width: 160, sortable: true, align: 'center'},
            {display: 'Nama Anggota', name: 'member_name', width: 200, sortable: true, align: 'left', hide: true},
            {display: 'No. Anggota', name: 'member_code', width: 80, sortable: true, align: 'center'},
            {display: 'Debet (Rp)', name: 'transaction_debet', width: 120, sortable: true, align: 'right'},
            {display: 'Kredit (Rp)', name: 'transaction_kredit', width: 120, sortable: true, align: 'right'},
            {display: 'Keterangan', name: 'transaction_note', width: 500, sortable: true, align: 'left'},
            {display: 'Waktu Input Sistem', name: 'transaction_input_datetime', width: 200, sortable: true, align: 'center'},
            {display: 'Nama Admin', name: 'transaction_administrator_name', width: 200, sortable: true, align: 'left', hide: true},
            {display: 'Username Admin', name: 'transaction_administrator_username', width: 150, sortable: true, align: 'left', hide: true},
            //            {display: 'Unit', name: 'branch_name', width: 100, sortable: true, align: 'left', hide:true},
        ],
        buttons: [
            <?php
            if (privilege_view('add', $this->menu_privilege)) :
                echo "
                    {display: 'I<u>n</u>put Pemutihan Angsuran Pinjaman', name: 'payment', bclass: 'accounting', onpress: openModalChooseMember},
                    ";
            endif;
            ?>
        ],
        buttons_right: [
            <?php
            if (privilege_view('export', $this->menu_privilege)) :
                echo "{display: 'E<u>x</u>port Excel', name: 'excel', bclass: 'excel', onpress: act_show, urlaction: '" . site_url("transaction/payment/export_data_lkh") . "'}";
            endif;
            ?>
        ],
        searchitems: [
            {display: 'Tanggal Pembayaran', name: 'transaction_datetime', type: 'date'},
            {display: 'Nama Anggota', name: 'member_name', type: 'text'},
            {display: 'No. Anggota', name: 'member_code', type: 'text'},
            {display: 'Debet (Rp)', name: 'transaction_debet', type: 'num'},
            {display: 'Kredit (Rp)', name: 'transaction_kredit', type: 'num'},
            {display: 'Keterangan', name: 'transaction_note', type: 'text'},
            {display: 'Waktu Input', name: 'transaction_input_datetime', type: 'date'},
            {display: 'Nama Admin', name: 'transaction_administrator_name', type: 'text'},
            {display: 'Username Admin', name: 'transaction_administrator_username', type: 'text'},
        ],
        sortname: "transaction_id",
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
                url: siteUrl + 'transaction/writeoff/get_data_member',
                dataType: 'json',
                colModel: [
                    {display: 'No. Anggota', name: 'member_code', width: 80, sortable: true, align: 'center'},
                    {display: 'Nama', name: 'member_name', width: 200, sortable: true, align: 'left'},
                    {display: 'Status Keanggotaan', name: 'member_status', width: 150, sortable: true, align: 'center'},
                    {display: 'No. Identitas',name: 'member_identity_number', width: 150, sortable: true, align: 'center', hide: true},
                    {display: 'Tipe Identitas',name: 'member_identity_type', width: 80, sortable: true, align: 'center', hide: true},
                    {display: 'Jenis Kelamin', name: 'member_gender', width: 80, sortable: true, align: 'center'},
                    {display: 'Tanggal Lahir',name: 'member_birthdate', width: 180, sortable: true, align: 'center', hide: true},
                    {display: 'Tempat Lahir',name: 'member_birthplace', width: 100, sortable: true, align: 'left', hide: true},
                    {display: 'Alamat', name: 'member_address', width: 300, sortable: true, align: 'left'},
                    {display: 'Provinsi', name: 'member_province', width: 100, sortable: true, align: 'left'},
                    {display: 'Kota', name: 'member_city', width: 100, sortable: true, align: 'left'},
                    {display: 'Kecamatan', name: 'member_subdistrict', width: 100, sortable: true, align: 'left'},
                    {display: 'Kelurahan', name: 'member_kelurahan', width: 100, sortable: true, align: 'left'},
                    {display: 'RT',name: 'member_rt_number', width: 50, sortable: true, align: 'left', hide: true},
                    {display: 'RW',name: 'member_rw_number', width: 50, sortable: true, align: 'left', hide: true},
                    {display: 'Kode Pos',name: 'member_zipcode', width: 80, sortable: true, align: 'left', hide: true},
                    {display: 'Domisili', name: 'member_address_domicile', width: 300, sortable: true, align: 'left'},
                    {display: 'Provinsi Domisili', name: 'member_domicile_province', width: 100, sortable: true, align: 'left'},
                    {display: 'Kota Domisili', name: 'member_domicile_city', width: 100, sortable: true, align: 'left'},
                    {display: 'Kecamatan Domisili', name: 'member_domicile_subdistrict', width: 100, sortable: true, align: 'left'},
                    {display: 'Kelurahan Domisili', name: 'member_domicile_kelurahan', width: 100, sortable: true, align: 'left'},
                    {display: 'RT Domisili',name: 'member_domicile_rt_number', width: 50, sortable: true, align: 'left', hide: true},
                    {display: 'RW Domisili',name: 'member_domicile_rw_number', width: 50, sortable: true, align: 'left', hide: true},
                    {display: 'Kode Pos Domisili',name: 'member_domicile_zipcode', width: 80, sortable: true, align: 'left', hide: true},
                    {display: 'Telepon', name: 'member_phone_number', width: 100, sortable: true, align: 'left'},
                    {display: 'No. Handphone', name: 'member_mobilephone_number', width: 100, sortable: true, align: 'left'},
                    {display: 'Pekerjaan', name: 'member_job', width: 100, sortable: true, align: 'left'},
                    {display: 'Rata-rata Penghasilan',name: 'member_average_income', width: 130, sortable: true, align: 'center', hide: true},
                    {display: 'Pendidikan Terakhir',name: 'member_last_education', width: 100, sortable: true, align: 'left', hide: true},
                    {display: 'Agama', name: 'member_religion', width: 150, sortable: true, align: 'center'},
                    {display: 'Status Pernikahan', name: 'member_is_married', width: 110, sortable: true, align: 'center'},
                    {display: 'Nama Suami/Istri', name: 'member_husband_wife_name', width: 200, sortable: true, align: 'left'},
                    {display: 'Nama Anak', name: 'member_child_name', width: 200, sortable: true, align: 'left'},
                    {display: 'Nama Ibu Kandung', name: 'member_mother_name', width: 200, sortable: true, align: 'left'},
                    {display: 'Pernah Terdaftar di CU Lain',name: 'member_is_registered_others_cu', width: 80, sortable: true, align: 'left', hide: true},
                    {display: 'Nama CU Lain',name: 'member_others_cu_name', width: 100, sortable: true, align: 'left', hide: true},
                    {display: 'Nama Ahli Waris', name: 'member_heir_name', width: 200, sortable: true, align: 'left'},
                    {display: 'Status Ahli Waris', name: 'member_heir_status', width: 200, sortable: true, align: 'left'},
                    {display: 'Unit', name: 'branch_name', width: 150, sortable: true, align: 'left'},
                    {display: 'Waktu Daftar', name: 'member_join_datetime', width: 200, sortable: true, align: 'center'},
                    {display: 'Nama Administrator Input',name: 'member_input_admin_name', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Waktu Administrator Input',name: 'member_input_datetime', width: 100, sortable: true, align: 'center', hide: true},
                ],
                buttons: [
                    <?php
                    if (privilege_view('add', $this->menu_privilege)) :
                        echo "
                            {display: 'P<u>i</u>lih Anggota', name: 'add', bclass: 'add', onpress: chooseMember},
                            ";
                    endif;
                    ?>
                ],
                searchitems: [{display: 'Nama',name: 'namber_name',type: 'text'},
                    {display: 'No. Anggota',name: 'member_code',type: 'text'},
                    {display: 'Alamat',name: 'member_address',type: 'text'},
                    {display: 'Provinsi',name: 'member_province',type: 'text'},
                    {display: 'Kota',name: 'member_city',type: 'text'},
                    {display: 'Kecamatan',name: 'member_subdistrict',type: 'text'},
                    {display: 'Kelurahan',name: 'member_kelurahan',type: 'text'},
                    {display: 'Domisili',name: 'member_address_domicile',type: 'text'},
                    {display: 'Provinsi Domisili',name: 'member_domicile_province',type: 'text'},
                    {display: 'Kota Domisili',name: 'member_domicile_city',type: 'text'},
                    {display: 'Kecamatan Domisili',name: 'member_domicile_subdistrict',type: 'text'},
                    {display: 'Kelurahan Domisili',name: 'member_domicile_kelurahan',type: 'text'},
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
                url: siteUrl + 'transaction/writeoff/get_data_member',
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
        onError: function(){
            $('#modal-payment-loan .modal-body').animate({scrollTop: '0px'}, 300);
        }
    });
</script>
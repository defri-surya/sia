<style>
    .modal-fullscreen .modal-dialog {
        width: 100%;
        height: 100%;
        margin: 0;
    }
    #period-saving::selection, .my-currency::selection {
        background: rgba(51, 122, 183, 0.2);
        color: #000;
    }
    
    .x_panel{
        padding: 0; 
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
    .table-like-flexigrid .fbutton .accounting{
        background: url(<?php echo site_url('addons/flexigrid/button/images/accounting.png'); ?>) no-repeat scroll left center transparent;
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
    .table-like-flexigrid tbody tr th{
        background: #fafafa url(<?php echo site_url('addons/flexigrid/css/images/fhbg.gif'); ?>) repeat-x bottom;
        border: 1px solid #ccc;
        border-bottom: none;
    }
    .table-like-flexigrid tbody tr th{
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
<div id="modal-choose-member" class="modal" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Setoran</h4>
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

<!-- Modal Option Payment-->
<div id="modal-option-payment" class="modal modal-fullscreen" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Setoran</h4>
            </div>
            <form id="form-nominal" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body" style="overflow-y: auto; height: calc(100vh - 130px);">
                    <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="x_panel" style="padding: 0px;">
                                <div class="x_title">
                                    <h2>Form Pembayaran Setoran</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content" style="overflow-y: auto; height: calc(100vh - 210px);">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div id="modal-response-message" class="fade in" role="alert" style="display:none"></div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div id="payment-info" class="alert alert-info fade in" role="alert">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">No. Anggota</label>
                                                <input type="text" id="payment-member-code" class="form-control"  readonly="readonly" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Nama Anggota</label>
                                                <input type="text" id="payment-member-name" class="form-control"  readonly="readonly" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Tanggal Pembayaran</label>
                                                <input type="text" name="date" id="payment-date" class="form-control my-date-picker" placeholder="dd/mm/yyyy" readonly="readonly" value="" style="background: #fff;" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Pilih Jenis Setoran</label>
                                                <select tabindex="1" class="form-control my-select2" id="payment-type"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12" id="container-type-saving">
                                            <div class="form-group">
                                                <label class="control-label">Pilih Jenis Simpanan</label>
                                                <select tabindex="2" class="form-control my-select2" id="saving-type"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12" id="container-payment-member-account-number">
                                            <div class="form-group">
                                                <label class="control-label">No. Rekening</label>
                                                <input type="text" id="payment-member-account-number" class="form-control" readonly="readonly" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12" id="container-payment-history">
                                            <span class="label label-default" style="font-size: 12px; line-height: 2; width: 100%;">Saldo Terakhir: Rp. <span id="payment-saldo">0</span></span>
                                            <button id="btn-history-payment" type="button" class="btn btn-default btn-sm btn-round pull-right" onclick="openModalHistoryPayment()" style="margin-bottom: 0px; margin-right: 0px;"><i class="fa fa-list"></i>&nbsp;<u>L</u>ihat Riwayat</button>
                                        </div>
                                        <input type="hidden" name="member_id" id="payment-member-id" value="">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding-left: 0px;">Metode Pembayaran</label>
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <label class="control-label paid-method" style="margin-right: 25px;"><input tabindex="3" type="radio" checked="checked" value="0" name="payment-method"> Cash</label>
                                                    <label class="control-label paid-method" style="margin-right: 25px;"><input tabindex="3" type="radio" value="1" name="payment-method"> Transfer</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12" id="container-single-payment">
                                            <div class="form-group">
                                                <label class="control-label">Jumlah Setoran</label>
                                                <input tabindex="4" type="text" name="nominal_saving" id="nominal-saving-single" class="form-control my-currency text-right">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12" id="container-period-payment">
                                            <div class="row">
                                                <div class="form-group col-md-9 col-sm-9 col-xs-12">
                                                    <label class="control-label">Jumlah Setoran</label>
                                                    <input type="text" id="nominal-saving-period" readonly="readonly" class="form-control my-currency text-right">
                                                </div>
                                                <div class="form-group col-md-3 col-sm-3 col-xs-12">
                                                    <label class="control-label">Jumlah Periode</label>
                                                    <input tabindex="5" type="number" name="period" id="period-saving" class="form-control text-center" value="1" min="1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12 row">
                            <div class="col-md-12 col-sm-12 col-xs-12 row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="x_panel" style="padding: 0px;">
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
                                            <div style="">
                                                <table class="table-like-flexigrid" style="">
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
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="x_panel" style="padding: 0px;">
                                        <div class="x_title">
                                            <h2>Informasi Pinjaman</h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content" style="overflow-y: auto; padding: 5px;">
                                            <div style="">
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
                            <div class="col-md-12 col-sm-12 col-xs-12 row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel" style="padding: 0px;">
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
                                                        <td colspan="2"id="member-mobilephone"></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="font-weight: bold;">Pekerjaan</th>
                                                        <td colspan="2" id="member-job"></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="font-weight: bold;">Penghasilan Rata2</th>
                                                        <td colspan="2"id="member-average-income"></td>
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
                    <button tabindex="6" type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp; Proses Pembayaran</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end Modal Option Payment-->

<!-- Modal history Payment-->
<div id="modal-history-payment" class="modal" role="dialog" tabindex="-1">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Riwayat <span id="history-payment-title"></span></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="container-member-balance-log-monthly" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <table id="gridview-member-balance-log-monthly" style="display:none;"></table>
                    </div>
                    <div id="container-member-balance-log-annually" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <table id="gridview-member-balance-log-annually" style="display:none;"></table>
                    </div>
                    <div id="container-member-saving-log" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <table id="gridview-member-saving-log" style="display:none;"></table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!--end Modal history Payment-->

<!--form validator-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<!--MASK MONEY-->   
<script src="<?php echo THEMES_BACKEND; ?>/js/jquery.maskMoney.min.js"></script>

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    
    let gridMember;
    
    let gridMemberBalanceLogMonthly;
    let gridMemberBalanceLogAnnually;
    let gridMemberSavingLog;
    let startDate = '';
    let endDate = '';
    
    let globalsMemberCode = '';
    
    let arrOptionPayment = [];
    let arrOptionPaymentSaving = [];
    let paymentName = ''; //payment name like : obligation, social, saving, loan
    let paymentNameTitle = '';
    let paymentProductSavingId = ''; //payment specific for saving id, if choose saving
    let paymentMemberProductSavingId = '';
    let paymentProductSavingTitle = '';
    
    function openPayment(){
        loadFlexigridMember();
        $('#modal-choose-member').modal('show');
    }
    
    function filterByDate(){
        let dates = $('#input-filter-date').val();
        if(dates != ''){
            let arrSplit = dates.split("s/d");
            startDate = arrSplit[0].trim();
            endDate = arrSplit[1].trim();
            $("#gridview").flexOptions({
                url: siteUrl + 'transaction/payment/get_data',
                params: [{name: "start_date", value: startDate}, {name: "end_date", value: endDate}],
            }).flexClearReload();
        }else{
            alert('Inputkan tanggal terlebih dahulu.');
        }
    }
    
    function resetDate(){
        $('#input-filter-date').val('');
        startDate = '';
        endDate = '';
        $("#gridview").flexOptions({
            url: siteUrl + 'transaction/payment/get_data',
            params: [{name: "start_date", value: startDate}, {name: "end_date", value: endDate}],
        }).flexClearReload();
    }
    
    function setFormPayment(){
        $("#modal-response-message").finish();
        $('#container-period-payment').hide();
        $('#container-single-payment').hide();
        
        $('#container-payment-member-account-number').hide();
        $('#nominal-saving-single').val(0);
        $('#nominal-saving-period').val(0);
        $('#period-saving').val(1);
        $('#payment-date').val(moment().format('DD/MM/YYYY'));
//        console.log(arrOptionPayment);
        if(arrOptionPaymentSaving.length > 0 || arrOptionPayment.length > 0){
            $('#form-nominal').attr('data-url', siteUrl + 'transaction/payment/act_add_premium');
            $('#container-type-saving').hide();
            $('#container-period-payment').show();
            
            generateSelect2('#payment-type', '#modal-option-payment', arrOptionPayment, 'name', 'title');
            generateSelect2('#saving-type', '#modal-option-payment', arrOptionPaymentSaving, 'saving_id', 'label');
            
            $('#payment-saldo').text(number_format(arrOptionPayment[0].balance));
            $('#nominal-saving-period').val(number_format(arrOptionPayment[0].value));
            
            let name = $('#payment-type').val();
            paymentName = name;
            
            let indexPayment = arrOptionPayment.findIndex(item => item.name == paymentName);
            paymentNameTitle = arrOptionPayment[indexPayment].title;
            
            paymentProductSavingId = '';
            paymentMemberProductSavingId = '';
            paymentProductSavingTitle = '';
            
            $('#modal-option-payment').modal({
                backdrop: 'static',
            }, 'show');
        }else{
            alert('Data tidak ditemukan.');
            setTimeout(function (){
                $('#grid_gridview-member .trSelected').removeClass('trSelected');
                $('#grid_gridview-member tr[tabindex="1"].control-row:visible').addClass('trSelected').focus();
            }, 200);
        }
    }
    
    function openModalHistoryPayment(){
        $('#container-member-balance-log-monthly, #container-member-balance-log-annually, #container-member-saving-log').hide();
        let memberId = $('#payment-member-id').val();
        if(paymentName != 'saving' && paymentName != 'loan'){
            let indexPayment = arrOptionPayment.findIndex(item => item.name == paymentName);
            let period = arrOptionPayment[indexPayment].period;
            if(period == 'monthly'){
                loadGridMemberBalanceLogMonthly(memberId);
                $('#container-member-balance-log-monthly').show();
            }else{
                loadGridMemberBalanceLogAnnually(memberId);
                $('#container-member-balance-log-annually').show();
            }
            $('#history-payment-title').text(paymentNameTitle);
        }
        if(paymentName == 'saving'){
            $('#container-member-saving-log').show();
            $('#history-payment-title').text(paymentProductSavingTitle);
            loadGridMemberSavingLog(memberId);
        }
        $('#modal-history-payment').modal({
            backdrop: 'static',
        }, 'show');
    }
    
    function chooseMember(com, grid, urlaction){
        let grid_id = $(grid).attr('id');
        grid_id = grid_id.substring(grid_id.lastIndexOf('grid_') + 5);
        
        if ($('.trSelected', grid).length > 0) {
            let memberCode = $('.trSelected', grid).attr('data-id');
//            let memberCode = $(`#${grid_id}_row_${id} td[abbr="member_code"] span`).text();
            globalsMemberCode = memberCode;
            $('#payment-info').hide();
            ajaxRequest('common/general/transaction/payment/get_option_payment', 'GET', {member_code: memberCode}, function(res) {
                if(res.status == 200){
                    let member = res.data.detail_member;
                    let option = res.data.option_payment;
                    let info = res.data.info;
                    
                    if(info != ''){
                        $('#payment-info span').text(info);
                        $('#payment-info').show();
                    }
                    
                    $('#payment-member-id').val(member.member_id);
                    
                    $('#payment-member-code').val(member.member_code);
                    $('#payment-member-name').val(member.member_name);
                    
                    arrOptionPayment = option;
                    arrOptionPaymentSaving = option[option.length - 1].option; // defined saving option
                    setFormPayment();
                }else{
                    alert(res.msg);
                    setTimeout(function (){
                        $('#grid_gridview-member .trSelected').removeClass('trSelected');
                        $('#grid_gridview-member tr[tabindex="1"].control-row:visible').addClass('trSelected').focus();
                    }, 200);
                }
            });
            
            ajaxRequest('common/general/membership/member/get_detail', 'GET', {id: memberCode}, function (res){
                if(res.status == 200){
                    let data = res.data;
                            
                    $('#member-code').text(data.member_code);

                    let urlImage = siteUrl + 'themes/backend/gentelella/images/no-img.jpg';
                    if(data.member_photo_filename != '' && data.member_photo_filename != null){
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
                    if(birthplace != null && birthplace != ''){
                        strBirth += birthplace;
                        if(birthdate != null && birthplace != ''){
                            strBirth += ', ' + moment(birthdate).format('DD MMMM YYYY');
                        }
                    }else{
                        if(birthdate != null && birthplace != ''){
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
                    if(arrChildName.length > 0 && arrChildName[0] != ''){
                        strChildName += `<ol>`;
                        arrChildName.forEach(child => strChildName += `<li>${child}</li>`);
                        strChildName += `</ol>`;
                    }
                    $('#member-child-name').html(strChildName);

                    let arrHeirName = data.member_heir_name.split('#');
                    let arrHeirStatus = data.member_heir_status.split('#');
                    let strHeir = '';
                    if(arrHeirName.length > 0 && arrHeirName[0] != ''){
                        strHeir += `<ol>`;
                        arrHeirName.forEach((heir, index) => {
                            let status = (typeof arrHeirStatus[index] != 'undefined' && arrHeirStatus[index] != '') ? `(${arrHeirStatus[index]})` : '';
                            strHeir += `<li>${heir} ${status}</li>`;
                        });
                        strHeir += `</ol>`;
                    }
                    $('#member-heir').html(strHeir);
                }else{
                    alert(res.msg);
                }
            });
            
            ajaxRequest('common/general/loan/submission/get_member_saldo', 'GET', {id: memberCode}, function (res){
                if(res.status == 200){
                    let arrSaving = res.data.saving;
                    let arrLoan = res.data.loan;
                    
                    let totalSaldoSaving = 0;
                    let totalSaldoLoan = 0;
                    
                    let htmlSaving = '';
                    let htmlLoan = '';
                    
                    arrCollateralSaving = []
                    
                    if(arrSaving.length > 0){
                        arrCollateralSaving = arrSaving;
                        
                        arrSaving.forEach(function (item, index){
                            totalSaldoSaving = totalSaldoSaving + item.balance;
                            htmlSaving += `
                                            <tr>
                                                <th style="font-weight: bold;">${item.name}</th>
                                                <td class="text-right"  style="width: 50%;">${number_format(item.balance)}</td>
                                            </tr>
                                        `;
                        });
                    }else{
                        htmlSaving += `
                                        <tr>
                                            <td colspan="2">Belum ada data.</td>
                                        </tr>
                                    `;
                    }
                    
                    $('#total-saving').text(number_format(totalSaldoSaving));
                    $('#saving-table tbody').html(htmlSaving);
                    
                    if(arrLoan.length > 0){
                        arrLoan.forEach(function (item, index){
                            totalSaldoLoan = totalSaldoLoan + item.balance;
                            htmlLoan += `
                                            <tr>
                                                <th style="font-weight: bold;">${item.name}</th>
                                                <td class="text-right"  style="width: 50%;">${number_format(item.balance)}</td>
                                            </tr>
                                        `;
                        });
                    }else{
                        htmlLoan += `
                                        <tr>
                                            <td colspan="2">Belum ada data.</td>
                                        </tr>
                                    `;
                    }
                    
                    $('#total-loan').text(number_format(totalSaldoLoan));
                    $('#loan-table tbody').html(htmlLoan);
                }else{
                    alert(res.msg);
                }
            });
            
            $('#modal-option-payment .modal-body').animate({scrollTop: '0px'}, 300);
        }else{
            alert('Pilih Anggota terlebih dahulu.');
            setTimeout(function (){
                $('#grid_gridview-member .trSelected').removeClass('trSelected');
                $('#grid_gridview-member tr[tabindex="1"].control-row:visible').addClass('trSelected').focus();
            }, 200);
        }
    }
    
    let delay = (function(){
        let timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();
    
    $(document).ready(function(){
        
        $('body').on('hidden.bs.modal', '#gridview-member_formModalFilter, #modal-option-payment', function (){
            $('#grid_gridview-member .trSelected').removeClass('trSelected');
            $('#grid_gridview-member tr[tabindex="1"].control-row:visible').addClass('trSelected').focus();
        });
        
        $('body').on('hidden.bs.modal', '#gridview-member-balance-log-monthly_formModalFilter, #gridview-member-balance-log-annually_formModalFilter, #gridview-member-saving-log_formModalFilter', function (){
            $('#modal-history-payment').focus();
        });
        
        $('body').on('hidden.bs.modal', '#modal-history-payment', function (){
            $('#payment-type').focus();
        });
        
        $('#modal-choose-member').on('focusout', 'tr.control-row', function (e){
            if(($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
                if(($("#gridview-member_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                    $('#modal-choose-member').find('.trSelected').removeClass('trSelected');
                }else if(($("#modal-option-payment").data('bs.modal') || {isShown: false}).isShown){
                    $('#modal-choose-member').find('.trSelected').removeClass('trSelected');
                }else if(($("#modal-history-payment").data('bs.modal') || {isShown: false}).isShown){
                    $('#modal-choose-member').find('.trSelected').removeClass('trSelected');
                }
            }
        });
        
        $('#modal-choose-member').on('keyup', 'tr.control-row.trSelected', function (e){
            let keyboardCode = e.keyCode;
            let delegateId = e.delegateTarget.id;
            if(keyboardCode == 13 || keyboardCode == 38 || keyboardCode == 40){
                switch (keyboardCode) {
                    case 13:
                        if($(`#${delegateId} .trSelected`).length > 0){
                            $(`#${delegateId} .tDiv2 .fbutton > div:first`).click();
                        }
                        break;
                    case 38:
                        let $elementPrev = $(this).prev();
                        if($elementPrev.hasClass('control-row')){
                            $('.trSelected').removeClass('trSelected');
                            $elementPrev.addClass('trSelected');
                            $elementPrev.focus();
                        }
                        break;
                    case 40:
                        let $elementNext = $(this).next();
                        if($elementNext.hasClass('control-row')){
                            $('.trSelected').removeClass('trSelected');
                            $elementNext.addClass('trSelected');
                            $elementNext.focus();
                        }
                        break;
                }
            }
        });
        
        $(".my-date-picker").daterangepicker({
            singleDatePicker: true,
            format: 'DD/MM/YYYY',
            showDropdowns: true,
            maxDate: moment()
        });
        
        $('#input-filter-date').daterangepicker();
        
        $('#period-saving, .my-currency').on('focus', function(e){
            $(this).select();
        });
        
        $('#period-saving, .my-currency').on('keyup', function() {
            let element = this;
            delay(function(){
                $(element).select();
            }, 1500 );
        });

        $('#payment-type').on('change', function (){
            $('#container-period-payment').hide();
            $('#container-single-payment').hide();
            
            $('#container-payment-member-account-number').hide();
            $('#form-nominal').attr('data-url', siteUrl + 'transaction/payment/act_add_premium');
            paymentName = '';
            paymentNameTitle = '';
            paymentProductSavingId = '';
            paymentMemberProductSavingId = '';
            paymentProductSavingTitle = '';
            $('#container-type-saving').hide();
            let value = $(this).val();
            paymentName = value;
            if(paymentName == 'saving'){
                $('#form-nominal').attr('data-url', siteUrl + 'transaction/payment/act_add_saving');
                $('#container-single-payment').show();
                let memberSavingId = $('#saving-type').val();
                paymentMemberProductSavingId = memberSavingId;
                
                let indexProductSaving = arrOptionPaymentSaving.findIndex(item => item.saving_id == memberSavingId);
                console.log(indexProductSaving);
                if(typeof arrOptionPaymentSaving[indexProductSaving] != 'undefined'){
                    paymentProductSavingTitle = arrOptionPaymentSaving[indexProductSaving].name;
                    paymentProductSavingId = arrOptionPaymentSaving[indexProductSaving].id;
                    let minInitial = parseInt(arrOptionPaymentSaving[indexProductSaving].min_deposit);
                    let minDeposit = parseInt(arrOptionPaymentSaving[indexProductSaving].min_initial);
                    
                    if(minInitial > 0){
                        $('#nominal-saving-single').val(number_format(minInitial));
                    }else{
                        $('#nominal-saving-single').val(number_format(minDeposit));
                    }

                    $('#payment-member-account-number').val(arrOptionPaymentSaving[indexProductSaving].account_number);
                    $('#payment-saldo').text(number_format(arrOptionPaymentSaving[indexProductSaving].balance));

                    $('#container-payment-member-account-number').show();
                    $('#container-type-saving').show();
                }else{
                    alert("Anggota belum membuka simpanan.\nBuka simpanan terlebih dahulu di menu Buka Simpanan.");
                    
                    $('#payment-type').val('obligation').change();
                }
            }else{
                $('#form-nominal').attr('data-url', siteUrl + 'transaction/payment/act_add_premium');
                $('#container-period-payment').show();
                let indexPayment = arrOptionPayment.findIndex(item => item.name == paymentName);
                paymentNameTitle = arrOptionPayment[indexPayment].title;
                $('#payment-saldo').text(number_format(arrOptionPayment[indexPayment].balance));
                $('#nominal-saving-period').val(number_format(arrOptionPayment[indexPayment].value));
                $('#period-saving').val(1);
            }
        });
        
        $('#saving-type').on('change', function (){
            $('#form-nominal').attr('data-url', siteUrl + 'transaction/payment/act_add_saving');
            
            let memberSavingId = $(this).val();
            paymentMemberProductSavingId = memberSavingId;
            
            let indexProductSaving = arrOptionPaymentSaving.findIndex(item => item.saving_id == memberSavingId);
            paymentProductSavingTitle = arrOptionPaymentSaving[indexProductSaving].name;
            paymentProductSavingId = arrOptionPaymentSaving[indexProductSaving].id;
            
            $('#payment-member-account-number').val(arrOptionPaymentSaving[indexProductSaving].account_number);
            $('#payment-saldo').text(number_format(arrOptionPaymentSaving[indexProductSaving].balance));
            
        });
        
        $('#form-nominal').on('submit', function (e) {
            e.preventDefault();
            $('#form-nominal button[type="submit"]').attr('disabled', 'disabled');
            let urlForm = $(this).attr('data-url');

            let formData = new FormData(this);
            formData.append('name', paymentName);
            formData.append('saving_id', paymentMemberProductSavingId);

            $.ajax({
                type: 'POST',
                url: urlForm,
                data: formData,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    if (res.status == 200) {
                        $('#payment-info').hide();
                        ajaxRequest('common/general/transaction/payment/get_option_payment', 'GET', {member_code: globalsMemberCode}, function(res) {
                            if(res.status == 200){
                                let member = res.data.detail_member;
                                let option = res.data.option_payment;
                                let info = res.data.info;
                    
                                if(info != ''){
                                    $('#payment-info span').text(info);
                                    $('#payment-info').show();
                                }

                                $('#payment-member-id').val(member.member_id);

                                $('#payment-member-code').val(member.member_code);
                                $('#payment-member-name').val(member.member_name);

                                arrOptionPayment = option;
                                arrOptionPaymentSaving = option[option.length - 1].option; // defined saving option
                                $('#payment-type').change();
                            }else{
                                alert(res.msg);
                                $('#modal-option-payment').modal('hide');
                                $('#grid_gridview-member .trSelected').removeClass('trSelected');
                                $('#grid_gridview-member tr[tabindex="1"].control-row:visible').addClass('trSelected').focus();
                            }
                        });

                        $('#form-nominal button[type="submit"]').removeAttr('disabled');
                        $('#gridview').flexReload();
                        $('#modal-option-payment .modal-body').animate({scrollTop: '0px'}, 300);
                        $('#payment-type').focus();
                        let message_class = 'alert alert-success';

                        $("#modal-response-message").finish();

                        $("#modal-response-message").addClass(message_class);
                        $("#modal-response-message").slideDown("fast");
                        $("#modal-response-message").html(res.data);
                        $("#modal-response-message").delay(10000).slideUp(1000, function () {
                            $("#modal-response-message").removeClass(message_class);
                        });
                    } else {
                        $('#form-nominal button[type="submit"]').removeAttr('disabled');
                        $('#modal-option-payment .modal-body').animate({scrollTop: '0px'}, 300);
                        $('#payment-type').focus();
                        let message_class = 'alert alert-danger';
                        $("#modal-response-message").finish();
                        
                        $("#modal-response-message").addClass(message_class);
                        $("#modal-response-message").slideDown("fast");
                        $('#modal-response-message').html(res.msg);
                        $("#modal-response-message").delay(10000).slideUp(1000, function(){
                            $("#modal-response-message").removeClass(message_class);
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#form-nominal button[type="submit"]').removeAttr('disabled');
                    console.log(jqXHR, textStatus, errorThrown);
                    alert('Gagal menambahkan data.');
                }
            });
        });
        
    });
    
    $("#gridview").flexigrid({
        url: siteUrl + 'transaction/payment/get_data',
        params: [{name: "start_date", value: ""}, {name: "end_date", value: ""}],
        dataType: 'json',
        colModel: [
            {display: 'Tanggal Pembayaran', name: 'transaction_datetime', width: 160, sortable: true, align: 'center'},
            {display: 'Nama Anggota', name: 'member_name', width: 200, sortable: true, align: 'left', hide:true},
            {display: 'No. Anggota', name: 'member_code', width: 80, sortable: true, align: 'center'},
            {display: 'No. Bakal Anggota', name: 'member_temp_code', width: 110, sortable: true, align: 'center'},
            {display: 'Debet (Rp)', name: 'transaction_debet', width: 120, sortable: true, align: 'right'},
            {display: 'Kredit (Rp)', name: 'transaction_kredit', width: 120, sortable: true, align: 'right'},
            {display: 'Keterangan', name: 'transaction_note', width: 500, sortable: true, align: 'left'},
            {display: 'Waktu Input Sistem', name: 'transaction_input_datetime', width: 200, sortable: true, align: 'center'},
            {display: 'Nama Admin', name: 'transaction_administrator_name', width: 200, sortable: true, align: 'left', hide:true},
            {display: 'Username Admin', name: 'transaction_administrator_username', width: 150, sortable: true, align: 'left', hide:true},
//            {display: 'Unit', name: 'branch_name', width: 100, sortable: true, align: 'left', hide:true},
        ],
        buttons: [
            <?php
            if (privilege_view('add', $this->menu_privilege)):
                echo "
                    {display: 'I<u>n</u>put Setoran', name: 'payment', bclass: 'accounting', onpress: openPayment},
                    ";
            endif;
            ?>
        ],
        buttons_right: [
            <?php
            if (privilege_view('export', $this->menu_privilege)):
                echo "{display: 'E<u>x</u>port Excel', name: 'excel', bclass: 'excel', onpress: my_export_data, urlaction: '" . site_url("transaction/payment/export_data_lkh") . "'}";
            endif;
            ?>
        ],
        searchitems: [
            {display: 'Tanggal Pembayaran', name: 'transaction_datetime', type: 'date'},
            {display: 'Nama Anggota', name: 'member_name', type: 'text'},
            {display: 'No. Anggota', name: 'member_code', type: 'text'},
            {display: 'No. Bakal Anggota', name: 'member_temp_code', type: 'text'},
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
    
    function loadGridMemberBalanceLogMonthly(memberId){
        if(typeof gridMemberBalanceLogMonthly == 'undefined'){
            gridMemberBalanceLogMonthly = $("#gridview-member-balance-log-monthly").flexigrid({
                url: siteUrl + 'transaction/payment/get_member_balance_log/monthly',
                params: [{name: "member_id", value: memberId}, {name: "payment_name", value: paymentName}],
                dataType: 'json',
                colModel: [
                    {display: 'Tanggal Pembayaran', name: 'balance_log_datetime', width: 120, sortable: true, align: 'center'},
                    {display: 'Bulan Iuran', name: 'balance_log_month_year', width: 120, sortable: true, align: 'center'},
                    {display: 'Debet (Rp)', name: 'balance_log_debet', width: 120, sortable: true, align: 'right'},
                    {display: 'Kredit (Rp)', name: 'balance_log_kedit', width: 120, sortable: true, align: 'right'},
                    {display: 'Saldo Terakhir (Rp)', name: 'balance_log_last_balance', width: 120, sortable: true, align: 'right'},
                    {display: 'Waktu Input Sistem', name: 'balance_log_input_datetime', width: 200, sortable: true, align: 'center'},
                    {display: 'Nama Admin', name: 'balance_log_administrator_name', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Username Admin', name: 'balance_log_administrator_username', width: 200, sortable: true, align: 'left', hide: true},
                ],
                searchitems: [
                    {display: 'Tanggal Pembayaran', name: 'balance_log_datetime', type: 'date'},
                    {display: 'Bulan Iuran', name: 'balance_log_month_year', type: 'date'},
                    {display: 'Debet (Rp)', name: 'balance_log_debet', type: 'num'},
                    {display: 'Kredit (Rp)', name: 'balance_log_kedit', type: 'num'},
                    {display: 'Saldo Terakhir (Rp)', name: 'balance_log_last_balance', type: 'num'},
                    {display: 'Waktu Input Sistem', name: 'balance_log_input_datetime', type: 'date'},
                    {display: 'Nama Admin', name: 'balance_log_administrator_name', type: 'text'},
                    {display: 'Username Admin', name: 'balance_log_administrator_username', type: 'text'},
                ],
                sortname: "balance_log_id",
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
        }else{
            $("#gridview-member-balance-log-monthly").flexOptions({
                url: siteUrl + 'transaction/payment/get_member_balance_log/monthly',
                params: [{name: "member_id", value: memberId}, {name: "payment_name", value: paymentName}],
            }).flexClearReload();
        }
    }
    
    function loadGridMemberBalanceLogAnnually(memberId){
        if(typeof gridMemberBalanceLogAnnually == 'undefined'){
            gridMemberBalanceLogAnnually = $("#gridview-member-balance-log-annually").flexigrid({
                url: siteUrl + 'transaction/payment/get_member_balance_log/annually',
                params: [{name: "member_id", value: memberId}, {name: "payment_name", value: paymentName}],
                dataType: 'json',
                colModel: [
                    {display: 'Tanggal Pembayaran', name: 'balance_log_datetime', width: 120, sortable: true, align: 'center'},
                    {display: 'Tahun Iuran', name: 'balance_log_month_year', width: 80, sortable: true, align: 'center'},
                    {display: 'Debet (Rp)', name: 'balance_log_debet', width: 120, sortable: true, align: 'right'},
                    {display: 'Kredit (Rp)', name: 'balance_log_kedit', width: 120, sortable: true, align: 'right'},
                    {display: 'Saldo Terakhir (Rp)', name: 'balance_log_last_balance', width: 120, sortable: true, align: 'right'},
                    {display: 'Waktu Input Sistem', name: 'balance_log_input_datetime', width: 200, sortable: true, align: 'center'},
                    {display: 'Nama Admin', name: 'balance_log_administrator_name', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Username Admin', name: 'balance_log_administrator_username', width: 200, sortable: true, align: 'left', hide: true},
                ],
                searchitems: [
                    {display: 'Tanggal Pembayaran', name: 'balance_log_datetime', type: 'date'},
                    {display: 'Tahun Iuran', name: 'balance_log_month_year', type: 'date'},
                    {display: 'Debet (Rp)', name: 'balance_log_debet', type: 'num'},
                    {display: 'Kredit (Rp)', name: 'balance_log_kedit', type: 'num'},
                    {display: 'Saldo Terakhir (Rp)', name: 'balance_log_last_balance', type: 'num'},
                    {display: 'Waktu Input Sistem', name: 'balance_log_input_datetime', type: 'date'},
                    {display: 'Nama Admin', name: 'balance_log_administrator_name', type: 'text'},
                    {display: 'Username Admin', name: 'balance_log_administrator_username', type: 'text'},
                ],
                sortname: "balance_log_id",
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
        }else{
            $("#gridview-member-balance-log-annually").flexOptions({
                url: siteUrl + 'transaction/payment/get_member_balance_log/annually',
                params: [{name: "member_id", value: memberId}, {name: "payment_name", value: paymentName}],
            }).flexClearReload();
        }
    }
    
    function loadGridMemberSavingLog(memberId){
        if(typeof gridMemberSavingLog == 'undefined'){
            gridMemberSavingLog = $("#gridview-member-saving-log").flexigrid({
                url: siteUrl + 'transaction/payment/get_member_saving_log',
                params: [{name: "member_id", value: memberId}, {name: "saving_id", value: paymentMemberProductSavingId}],
                dataType: 'json',
                colModel: [
                    {display: 'Tanggal Pembayaran', name: 'member_product_saving_log_datetime', width: 200, sortable: true, align: 'center'},
                    {display: 'No. Bukti', name: 'member_product_saving_log_code', width: 120, sortable: true, align: 'center'},
                    {display: 'Debet (Rp)', name: 'member_product_saving_log_debet', width: 120, sortable: true, align: 'right'},
                    {display: 'Kredit (Rp)', name: 'member_product_saving_log_kredit', width: 120, sortable: true, align: 'right'},
                    {display: 'Saldo Terakhir (Rp)', name: 'member_product_saving_log_last_balance', width: 120, sortable: true, align: 'right'},
                    {display: 'Waktu Input Sistem', name: 'member_product_saving_log_input_datetime', width: 200, sortable: true, align: 'center'},
                    {display: 'Nama Admin', name: 'member_product_saving_log_input_admin_name', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Username Admin', name: 'member_product_saving_log_input_admin_username', width: 200, sortable: true, align: 'left', hide: true},
                ],
                searchitems: [
                    {display: 'Tanggal Pembayaran', name: 'member_product_saving_log_datetime', type: 'date'},
                    {display: 'No. Bukti', name: 'member_product_saving_log_code', type: 'text'},
                    {display: 'Debet (Rp)', name: 'member_product_saving_log_debet', type: 'num'},
                    {display: 'Kredit (Rp)', name: 'member_product_saving_log_kredit', type: 'num'},
                    {display: 'Saldo Terakhir (Rp)', name: 'member_product_saving_log_last_balance', type: 'num'},
                    {display: 'Waktu Input Sistem', name: 'member_product_saving_log_input_datetime', type: 'date'},
                    {display: 'Nama Admin', name: 'member_product_saving_log_input_admin_name', type: 'text'},
                    {display: 'Username Admin', name: 'member_product_saving_log_input_admin_username', type: 'text'},
                ],
                sortname: "member_product_saving_log_id",
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
        }else{
            $("#gridview-member-saving-log").flexOptions({
                url: siteUrl + 'transaction/payment/get_member_saving_log',
                params: [{name: "member_id", value: memberId}, {name: "saving_id", value: paymentMemberProductSavingId}],
            }).flexClearReload();
        }
    }
    
    function loadFlexigridMember(){
        if(typeof gridMember == 'undefined'){
            gridMember = $('#gridview-member').flexigrid({
                url: siteUrl + 'transaction/payment/get_data_member',
                dataType: 'json',
                colModel: [
                    {display: 'No. Anggota', name: 'member_code', width: 80, sortable: true, align: 'center'},
                    {display: 'No. Bakal Anggota', name: 'member_temp_code', width: 110, sortable: true, align: 'center'},
                    {display: 'Nama', name: 'member_name', width: 200, sortable: true, align: 'left'},
                    {display: 'Status Keanggotaan', name: 'member_status', width: 150, sortable: true, align: 'center'},
                    {display: 'No. Identitas', name: 'member_identity_number', width: 150, sortable: true, align: 'center', hide: true},
                    {display: 'Tipe Identitas', name: 'member_identity_type', width: 80, sortable: true, align: 'center', hide: true},
                    {display: 'Jenis Kelamin', name: 'member_gender', width: 80, sortable: true, align: 'center'},
                    {display: 'Tanggal Lahir', name: 'member_birthdate', width: 180, sortable: true, align: 'center', hide: true},
                    {display: 'Tempat Lahir', name: 'member_birthplace', width: 100, sortable: true, align: 'left', hide: true},
                    {display: 'Alamat', name: 'member_address', width: 300, sortable: true, align: 'left'},
                    {display: 'Provinsi', name: 'member_province', width: 100, sortable: true, align: 'left'},
                    {display: 'Kota', name: 'member_city', width: 100, sortable: true, align: 'left'},
                    {display: 'Kecamatan', name: 'member_subdistrict', width: 100, sortable: true, align: 'left'},
                    {display: 'Kelurahan', name: 'member_kelurahan', width: 100, sortable: true, align: 'left'},
                    {display: 'RT', name: 'member_rt_number', width: 50, sortable: true, align: 'left', hide: true},
                    {display: 'RW', name: 'member_rw_number', width: 50, sortable: true, align: 'left', hide: true},
                    {display: 'Kode Pos', name: 'member_zipcode', width: 80, sortable: true, align: 'left', hide: true},
                    {display: 'Domisili', name: 'member_address_domicile', width: 300, sortable: true, align: 'left'},
                    {display: 'Provinsi Domisili', name: 'member_domicile_province', width: 100, sortable: true, align: 'left'},
                    {display: 'Kota Domisili', name: 'member_domicile_city', width: 100, sortable: true, align: 'left'},
                    {display: 'Kecamatan Domisili', name: 'member_domicile_subdistrict', width: 100, sortable: true, align: 'left'},
                    {display: 'Kelurahan Domisili', name: 'member_domicile_kelurahan', width: 100, sortable: true, align: 'left'},
                    {display: 'RT Domisili', name: 'member_domicile_rt_number', width: 50, sortable: true, align: 'left', hide: true},
                    {display: 'RW Domisili', name: 'member_domicile_rw_number', width: 50, sortable: true, align: 'left', hide: true},
                    {display: 'Kode Pos Domisili', name: 'member_domicile_zipcode', width: 80, sortable: true, align: 'left', hide: true},
                    {display: 'Telepon', name: 'member_phone_number', width: 100, sortable: true, align: 'left'},
                    {display: 'No. Handphone', name: 'member_mobilephone_number', width: 100, sortable: true, align: 'left'},
                    {display: 'Pekerjaan', name: 'member_job', width: 100, sortable: true, align: 'left'},
                    {display: 'Rata-rata Penghasilan', name: 'member_average_income', width: 130, sortable: true, align: 'center', hide: true},
                    {display: 'Pendidikan Terakhir', name: 'member_last_education', width: 100, sortable: true, align: 'left', hide: true},
                    {display: 'Agama', name: 'member_religion', width: 150, sortable: true, align: 'center'},
                    {display: 'Status Pernikahan', name: 'member_is_married', width: 110, sortable: true, align: 'center'},
                    {display: 'Nama Suami/Istri', name: 'member_husband_wife_name', width: 200, sortable: true, align: 'left'},
                    {display: 'Nama Anak', name: 'member_child_name', width: 200, sortable: true, align: 'left'},
                    {display: 'Nama Ibu Kandung', name: 'member_mother_name', width: 200, sortable: true, align: 'left'},
                    {display: 'Pernah Terdaftar di CU Lain', name: 'member_is_registered_others_cu', width: 80, sortable: true, align: 'left', hide: true},
                    {display: 'Nama CU Lain', name: 'member_others_cu_name', width: 100, sortable: true, align: 'left', hide: true},
                    {display: 'Nama Ahli Waris', name: 'member_heir_name', width: 200, sortable: true, align: 'left'},
                    {display: 'Status Ahli Waris', name: 'member_heir_status', width: 200, sortable: true, align: 'left'},
                    {display: 'Unit', name: 'branch_name', width: 150, sortable: true, align: 'left'},
                    {display: 'Waktu Daftar', name: 'member_join_datetime', width: 200, sortable: true, align: 'center'},
                    {display: 'Nama Administrator Input', name: 'member_input_admin_name', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Waktu Administrator Input', name: 'member_input_datetime', width: 100, sortable: true, align: 'center', hide: true},
                ],
                buttons: [
                    <?php
                    if (privilege_view('add', $this->menu_privilege)):
                        echo "
                            {display: 'P<u>i</u>lih Anggota', name: 'add', bclass: 'add', onpress: chooseMember},
                            ";
                    endif;
                    ?>
                ],
                searchitems: [
                    {display: 'Nama', name: 'member_name', type:'text'},
                    {display: 'No. Anggota', name: 'member_code', type:'text'},
                    {display: 'No. Bakal Anggota', name: 'member_temp_code', type:'text'},
                    {display: 'Alamat', name: 'member_address', type:'text'},
                    {display: 'Provinsi', name: 'member_province', type:'text'},
                    {display: 'Kota', name: 'member_city', type:'text'},
                    {display: 'Kecamatan', name: 'member_subdistrict', type:'text'},
                    {display: 'Kelurahan', name: 'member_kelurahan', type:'text'},
                    {display: 'Domisili', name: 'member_address_domicile', type:'text'},
                    {display: 'Provinsi Domisili', name: 'member_domicile_province', type:'text'},
                    {display: 'Kota Domisili', name: 'member_domicile_city', type:'text'},
                    {display: 'Kecamatan Domisili', name: 'member_domicile_subdistrict', type:'text'},
                    {display: 'Kelurahan Domisili', name: 'member_domicile_kelurahan', type:'text'},
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
        }else{
            $("#gridview-member").flexOptions({
                url: siteUrl + 'transaction/payment/get_data_member',
            }).flexClearReload();
        }
        $('.trSelected').focus();
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
    
    // function generate select2
    function generateSelect2(element = '.select2', parentElement = 'body', data = [], nameValue, nameText, selectedValue = false, selectedName = '', placeHolder = false, placeHolderValue = '') {
        let option = placeHolder === false ? '' : `<option value="${placeHolderValue}">${placeHolder}</option>`;
        data.forEach(function (item, index) {
            let strSelected = '';
            if (selectedValue !== false) {
                if (item[selectedName] == selectedValue) {
                    strSelected = `selected="selected"`;
                }
            }
            option += `<option value="${item[nameValue]}" ${strSelected}>${item[nameText]}</option>`;
        });
        $(element).html(option).select2({
            dropdownParent: $(parentElement)
        });
        return $(element);
    }

    // function request with ajax
    function ajaxRequest(url, method = 'GET', data = '', callback, async = true) {
        $.ajax({
            async: async,
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
    
    // for set number format
    function number_format(number = 0, decimals = 0, decPoint = ',', thousandsSep = '.') {
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
    
    function my_export_data(com, grid, urlaction) {
        var arr_column_name = [{}];
        var arr_column_title = [{}];
        var arr_column_show = [{}];
        var arr_column_align = [{}];
        var qselectused = false;
        var optionused = false;
        var selectedoption = '';
        var option = '';
        $(".sDiv .qselect", grid).each(function () {
            var id = $(this).attr('id');
            var show = $("#" + id).is(':hidden');
            if (show == false) {
                qselectused = true;
                selectedoption = $("#" + id + " select[name=qoption] option:selected").val();
            }
        });

        if (qselectused == true) {
            option = selectedoption;
            optionused = true;
        } else {
            option = '';
            optionused = false;
        }

        var querys = [];
        $('.querys').each(function () {
            if ($(this).val() != '') {
                if ($(this).hasClass('querys_text')) {
                    querys.push({
                        filter_type: 'querys_text',
                        filter_field: $(this).attr('param'),
                        filter_value: $(this).val()
                    });
                } else if ($(this).hasClass('querys_num')) {
                    console.log($(this));
                    querys.push({
                        filter_type: 'querys_num',
                        filter_field: $(this).attr('param'),
                        filter_value: $(this).val()
                    });
                } else if ($(this).hasClass('querys_option')) {
                    querys.push({
                        filter_type: 'querys_option',
                        filter_field: $(this).attr('param'),
                        filter_value: $(this).val()
                    });
                } else if ($(this).hasClass('querys_date')) {
                    querys.push({
                        filter_type: 'querys_date',
                        filter_field: $(this).attr('param'),
                        filter_value: $(this).val()
                    });
                }
            }
        });
        querys = JSON.stringify(querys);

        var query = $(".sDiv input[name=q]", grid).val();
        var date_start = $(".sDiv input[name=qdatestart]", grid).val();
        var date_end = $('.sDiv input[name=qdateend]', grid).val();
        var qtype = $(".sDiv select[name=qtype]", grid).val();
        var rp = $(".pDiv select[name=rp]", grid).val();
        var page = $(".pDiv #current_page", grid).val();
        var total_data = $(".pDiv #total_data", grid).html();
        var sortname = $(grid).attr('data-sortname');
        var sortorder = $(grid).attr('data-sortorder');

        var i = 0;
        $('.hDiv tr th', grid).each(function () {
            var column_name = $(this).attr('abbr');
            var column_title = $(this).children('div:first-child').html();
            var attr_hidden = $(this).attr('hidden');
            var attr_align = $(this).attr('align');

            arr_column_name[i] = column_name;
            arr_column_title[i] = column_title;

            if ((typeof attr_hidden !== 'undefined' && attr_hidden !== false) || $(this).hasClass('no_datasource')) {
                arr_column_show[i] = false;
            } else {
                arr_column_show[i] = true;
            }

            if (typeof attr_align !== 'undefined' && attr_align !== false) {
                arr_column_align[i] = attr_align;
            } else {
                arr_column_align[i] = 'left';
            }
            i++;
        });

        if (urlaction == '') {
            urlaction = 'export_data';
        }

        $form = $("<form target='_blank' method='post' action='" + urlaction + "'></form>");
        $form.append("<input type='hidden' name='start_date' value='" + startDate + "' />");
        $form.append("<input type='hidden' name='end_date' value='" + endDate + "' />");
        $form.append("<input id='export_column_name' type='hidden' name='column[name]' value='" + JSON.stringify(arr_column_name) + "' />");
        $form.append("<input id='export_column_title' type='hidden' name='column[title]' value='" + JSON.stringify(arr_column_title) + "' />");
        $form.append("<input id='export_column_show' type='hidden' name='column[show]' value='" + JSON.stringify(arr_column_show) + "' />");
        $form.append("<input id='export_column_align' type='hidden' name='column[align]' value='" + JSON.stringify(arr_column_align) + "' />");
        $form.append("<input id='export_sortname' type='hidden' name='sortname' value='" + sortname + "' />");
        $form.append("<input id='export_sortorder' type='hidden' name='sortorder' value='" + sortorder + "' />");
        $form.append("<input id='export_query' type='hidden' name='query' value='" + query + "' />");
        $form.append("<input id='export_querys' type='hidden' name='querys' value='" + querys + "' />");
        $form.append("<input id='export_optionused' type='hidden' name='optionused' value='" + optionused + "' />");
        $form.append("<input id='export_option' type='hidden' name='option' value='" + option + "' />");
        $form.append("<input id='export_date_start' type='hidden' name='date_start' value='" + date_start + "' />");
        $form.append("<input id='export_date_end' type='hidden' name='date_end' value='" + date_end + "' />");
        $form.append("<input id='export_qtype' type='hidden' name='qtype' value='" + qtype + "' />");
        $form.append("<input id='export_total_data' type='hidden' name='total_data' value='" + total_data + "' />");
        $form.append("<input id='export_rp' type='hidden' name='rp' value='" + rp + "' />");
        $form.append("<input id='export_page' type='hidden' name='page' value='" + page + "' />");
        $(grid).after($form);
        $form.submit();
    }
    
    $.validate({
        lang: 'id',
        onError: function(){
            $('.modal .modal-body').animate({scrollTop: '0px'}, 300);
        }
    });
    
    // ======== keyboard shortcut ====================================================
    
    // input setoran
    $.key('alt+n', function() {
        if(!($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            $('#grid_gridview .tDiv2 .fbutton > div:first').click();
        }
    });
    
    //export excell
    $.key('alt+x', function() {
        if(!($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            $('#grid_gridview .tDiv2_right .fbutton_right > div:first').click();
        }
    });
    
    //pencarian
    $.key('alt+c', function() {
        if(!($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            if(($("#gridview_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                $('#gridview_search').click();
            }else{
                $('#gridview_pSearch').click();
            }
        }
        
        if(($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            if(!($("#modal-option-payment").data('bs.modal') || {isShown: false}).isShown){
                if(($("#gridview-member_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                    $('#gridview-member_search').click();
                }else{
                    $('#gridview-member_pSearch').click();
                }
            }
        }
        
        if(($("#modal-history-payment").data('bs.modal') || {isShown: false}).isShown){
            if(paymentName != 'saving' && paymentName != 'loan'){
                let indexPayment = arrOptionPayment.findIndex(item => item.name == paymentName);
                let period = arrOptionPayment[indexPayment].period;
                if(period == 'monthly'){
                    if(($("#gridview-member-balance-log-monthly_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                        $('#gridview-member-balance-log-monthly_search').click();
                    }else{
                        $('#gridview-member-balance-log-monthly_pSearch').click();
                    }
                }else{
                    if(($("#gridview-member-balance-log-annually_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                        $('#gridview-member-balance-log-annually_search').click();
                    }else{
                        $('#gridview-member-balance-log-annually_pSearch').click();
                    }
                }
            }
            
            if(paymentName == 'saving'){
                if(($("#gridview-member-saving-log_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                    $('#gridview-member-saving-log_search').click();
                }else{
                    $('#gridview-member-saving-log_pSearch').click();
                }
            }
        }
    });
    
    //previous
    $.key('alt+<', function() {
        if(!($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            $('#grid_gridview .pDiv2 .pPrev.pButton span').click();
        }
        
        if(($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            if(!($("#modal-option-payment").data('bs.modal') || {isShown: false}).isShown){
               $('#grid_gridview-member .pDiv2 .pPrev.pButton span').click();
            }
        }
        
        if(($("#modal-history-payment").data('bs.modal') || {isShown: false}).isShown){
            if(paymentName != 'saving' && paymentName != 'loan'){
                let indexPayment = arrOptionPayment.findIndex(item => item.name == paymentName);
                let period = arrOptionPayment[indexPayment].period;
                if(period == 'monthly'){
                    if(!($("#gridview-member-balance-log-monthly_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                        $('#grid_gridview-member-balance-log-monthly .pDiv2 .pPrev.pButton span').click();
                    }
                }else{
                    if(!($("#gridview-member-balance-log-annually_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                        $('#grid_gridview-member-balance-log-annually .pDiv2 .pPrev.pButton span').click();
                    }
                }
            }
            
            if(paymentName == 'saving'){
                if(!($("#gridview-member-saving-log_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                    $('#grid_gridview-member-saving-log .pDiv2 .pPrev.pButton span').click();
                }
            }
        }
    });
    
    //next
    $.key('alt+>', function() {
        if(!($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            $('#grid_gridview .pDiv2 .pNext.pButton span').click();
        }
        
        if(($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            if(!($("#modal-option-payment").data('bs.modal') || {isShown: false}).isShown){
                $('#grid_gridview-member .pDiv2 .pNext.pButton span').click();
            }
        }
        
        if(($("#modal-history-payment").data('bs.modal') || {isShown: false}).isShown){
            if(paymentName != 'saving' && paymentName != 'loan'){
                let indexPayment = arrOptionPayment.findIndex(item => item.name == paymentName);
                let period = arrOptionPayment[indexPayment].period;
                if(period == 'monthly'){
                    if(!($("#gridview-member-balance-log-monthly_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                        $('#grid_gridview-member-balance-log-monthly .pDiv2 .pNext.pButton span').click();
                    }
                }else{
                    if(!($("#gridview-member-balance-log-annually_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                        $('#grid_gridview-member-balance-log-annually .pDiv2 .pNext.pButton span').click();
                    }
                }
            }
            
            if(paymentName == 'saving'){
                if(!($("#gridview-member-saving-log_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                    $('#grid_gridview-member-saving-log .pDiv2 .pNext.pButton span').click();
                }
            }
        }
    });
    
    //reload
    $.key('alt+r', function() {
        if(!($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            if(($("#gridview_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                $('#gridview_reset').click();
            }else{
                $('#grid_gridview .pDiv2 .pReload.pButton span').click();
            }
        }
        
        if(($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            if(!($("#modal-option-payment").data('bs.modal') || {isShown: false}).isShown){
                if(($("#gridview-member_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                    $('#gridview-member_reset').click();
                }else{
                    $('#grid_gridview-member .pDiv2 .pReload.pButton span').click();
                }
            }
        }
        
        if(($("#modal-history-payment").data('bs.modal') || {isShown: false}).isShown){
            if(paymentName != 'saving' && paymentName != 'loan'){
                let indexPayment = arrOptionPayment.findIndex(item => item.name == paymentName);
                let period = arrOptionPayment[indexPayment].period;
                if(period == 'monthly'){
                    if(!($("#gridview-member-balance-log-monthly_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                        $('#grid_gridview-member-balance-log-monthly .pDiv2 .pReload.pButton span').click();
                    }
                }else{
                    if(!($("#gridview-member-balance-log-annually_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                        $('#grid_gridview-member-balance-log-annually .pDiv2 .pReload.pButton span').click();
                    }
                }
            }
            
            if(paymentName == 'saving'){
                if(!($("#gridview-member-saving-log_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                    $('#grid_gridview-member-saving-log .pDiv2 .pReload.pButton span').click();
                }
            }
        }
    });
    
    //focus di input nomor halaman
    $.key('alt+h', function() {
        if(!($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            $('#grid_gridview .pDiv2 input').focus();
        }
        
        if(($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            if(!($("#modal-option-payment").data('bs.modal') || {isShown: false}).isShown){
                $('#grid_gridview-member .trSelected').removeClass('trSelected');
                $('#grid_gridview-member .pDiv2 input').focus();
            }
        }
        
        if(($("#modal-history-payment").data('bs.modal') || {isShown: false}).isShown){
            if(paymentName != 'saving' && paymentName != 'loan'){
                let indexPayment = arrOptionPayment.findIndex(item => item.name == paymentName);
                let period = arrOptionPayment[indexPayment].period;
                if(period == 'monthly'){
                    if(!($("#gridview-member-balance-log-monthly_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                        $('#grid_gridview-member-balance-log-monthly .pDiv2 input').focus();
                    }
                }else{
                    if(!($("#gridview-member-balance-log-annually_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                        $('#grid_gridview-member-balance-log-annually .pDiv2 input').focus();
                    }
                }
            }
            
            if(paymentName == 'saving'){
                if(!($("#gridview-member-saving-log_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                    $('#grid_gridview-member-saving-log .pDiv2 input').focus();
                }
            }
        }
    });
    
    //focus di range per halaman
    $.key('alt+p', function() {
        if(!($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            $('#grid_gridview .pDiv2 select').focus();
        }
        
        if(($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            if(!($("#modal-option-payment").data('bs.modal') || {isShown: false}).isShown){
                $('#grid_gridview-member .trSelected').removeClass('trSelected');
                $('#grid_gridview-member .pDiv2 select').focus();
            }
        }
        
        if(($("#modal-history-payment").data('bs.modal') || {isShown: false}).isShown){
            if(paymentName != 'saving' && paymentName != 'loan'){
                let indexPayment = arrOptionPayment.findIndex(item => item.name == paymentName);
                let period = arrOptionPayment[indexPayment].period;
                if(period == 'monthly'){
                    if(!($("#gridview-member-balance-log-monthly_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                        $('#grid_gridview-member-balance-log-monthly .pDiv2 select').focus();
                    }
                }else{
                    if(!($("#gridview-member-balance-log-annually_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                        $('#grid_gridview-member-balance-log-annually .pDiv2 select').focus();
                    }
                }
            }
            
            if(paymentName == 'saving'){
                if(!($("#gridview-member-saving-log_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                    $('#grid_gridview-member-saving-log .pDiv2 select').focus();
                }
            }
        }
    });
    
    //pilih anggota
    $.key('alt+i', function() {
        if(($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            if(!($("#modal-option-payment").data('bs.modal') || {isShown: false}).isShown){
               $('#grid_gridview-member .tDiv2 .fbutton > div:first').click();
            }
        }
    });
    
    //lihat riwayat
    $.key('alt+l', function() {
        if(($("#modal-option-payment").data('bs.modal') || {isShown: false}).isShown){
            if(!($("#modal-history-payment").data('bs.modal') || {isShown: false}).isShown){
               $('#btn-history-payment').click();
            }
        }
    });
    
    //focus di list pilih anggota
    $.key('alt+a', function() {
        if(($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            if(!($("#modal-option-payment").data('bs.modal') || {isShown: false}).isShown){
                $('#grid_gridview-member .trSelected').removeClass('trSelected');
                $('#grid_gridview-member tr[tabindex="1"].control-row:visible').addClass('trSelected').focus();
            }
        }
    });
</script>
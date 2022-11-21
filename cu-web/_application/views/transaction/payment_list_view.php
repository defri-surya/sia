<style>
    #period-saving::selection, .my-currency::selection {
        background: rgba(51, 122, 183, 0.2);
        color: #000;
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

<!-- Modal Input Code payment-->
<div id="modal-payment-input-code" class="modal" role="dialog" tabindex="-1">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Setoran</h4>
            </div>
            <form id="form-payment-input-code" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label">No. Anggota</label>
                                <input tabindex="1" id="payment-code-member-code" type="text" name="member_code" class="form-control input-sm">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button tabindex="2" type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp; Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end Modal Input Code payment-->

<!-- Modal Input Code withdrawal-->
<div id="modal-withdrawal-input-code" class="modal" role="dialog" tabindex="-1">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Penarikan</h4>
            </div>
            <form id="form-withdrawal-input-code" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label">No. Anggota</label>
                                <input tabindex="1" id="withdrawal-code-member-code" type="text" name="member_code" class="form-control input-sm">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button tabindex="2" type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp; Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end Modal Input Code withdrawal-->

<!-- Modal Option Payment-->
<div id="modal-option-payment" class="modal" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Setoran</h4>
            </div>
            <form id="form-nominal" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body" style="overflow-y: auto; max-height: calc(100vh - 200px)">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div id="modal-response-message" class="fade in" role="alert" style="display:none"></div>
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
                            <button type="button" class="btn btn-default btn-sm btn-round pull-right" onclick="openModalHistoryPayment()" style="margin-bottom: 0px; margin-right: 0px;"><i class="fa fa-list"></i>&nbsp;Lihat Riwayat</button>
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
                <div class="modal-footer">
                    <button tabindex="6" type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp; Proses Pembayaran</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end Modal Option Payment-->

<!-- Modal Option Withdrawal-->
<div id="modal-option-withdrawal" class="modal" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Penarikan</h4>
            </div>
            <form id="form-nominal-withdrawal" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body" style="overflow-y: auto; max-height: calc(100vh - 200px)">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div id="modal-response-message-withdrawal" class="fade in" role="alert" style="display:none"></div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label">No. Anggota</label>
                                <input type="text" id="withdrawal-member-code" class="form-control"  readonly="readonly" value="">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Nama Anggota</label>
                                <input type="text" id="withdrawal-member-name" class="form-control"  readonly="readonly" value="">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Tanggal Penarikan</label>
                                <input type="text" name="date" id="withdrawal-date" class="form-control my-date-picker" placeholder="dd/mm/yyyy" readonly="readonly" value="" style="background: #fff;" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Pilih Jenis Simpanan</label>
                                <select tabindex="1" class="form-control my-select2" id="withdrawal-saving-type"></select>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label">No. Rekening</label>
                                <input type="text" id="withdrawal-member-account-number" class="form-control" readonly="readonly" value="">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <span class="label label-default" style="font-size: 12px; line-height: 2; width: 100%;">Saldo Terakhir: Rp. <span id="withdrawal-saldo">0</span></span>
                            <button type="button" class="btn btn-default btn-sm btn-round pull-right" onclick="openModalHistoryWithdrawal()" style="margin-bottom: 0px; margin-right: 0px;"><i class="fa fa-list"></i>&nbsp;Lihat Riwayat</button>
                        </div>
                        <input type="hidden" name="member_id" id="withdrawal-member-id" value="">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Jumlah Penarikan</label>
                                <input tabindex="2" type="text" name="nominal_withdraw" id="nominal-withdraw" class="form-control my-currency text-right">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" id="container-withdrawal-fee">
                            <div class="form-group">
                                <label class="control-label">Biaya Penarikan <span id="withdrawal-fee-percent"></span></label>
                                <input type="text" id="withdrawal-fee" class="form-control text-right" readonly="readonly" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button tabindex="3" type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp; Proses</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end Modal Option Withdrawal-->

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

<!-- Modal history withdrawal-->
<div id="modal-history-withdrawal" class="modal" role="dialog" tabindex="-1">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Riwayat <span id="history-withdrawal-title"></span></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table id="gridview-member-saving-log-withdrawal" style="display:none;"></table>
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
    let gridMemberSavingLogWithdrawal;
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
    
    let arrOptionWithdrawal = [];
    let withdrawalSavingId = '';
    let withdrawalMemberSavingId = '';
    let withdrawalSavingTitle = '';
    let withdrawalFeePercent = 0;
    
    function openPayment(){
        $('#payment-code-member-code').val('');
        $('#modal-payment-input-code').modal({
            backdrop: 'static',
//            keyboard: false
        }, 'show');
    }
    
    function openWithdrawal(){
        $('#withdrawal-code-member-code').val('');
        $('#modal-withdrawal-input-code').modal({
            backdrop: 'static',
//            keyboard: false
        }, 'show');
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
            
            generateSelect2('#payment-type', arrOptionPayment, 'name', 'title');
            generateSelect2('#saving-type', arrOptionPaymentSaving, 'id', 'name_alias');
            
            $('#payment-saldo').text(number_format(arrOptionPayment[0].balance));
            $('#nominal-saving-period').val(number_format(arrOptionPayment[0].value));
            
            let name = $('#payment-type').val();
            paymentName = name;
            
            let indexPayment = arrOptionPayment.findIndex(item => item.name == paymentName);
            paymentNameTitle = arrOptionPayment[indexPayment].title;
            
            paymentProductSavingId = '';
            paymentMemberProductSavingId = '';
            paymentProductSavingTitle = '';
            
            $('#modal-payment-input-code').modal('hide');
            $('#modal-option-payment').modal({
                backdrop: 'static',
//                keyboard: false
            }, 'show');
        }else{
            alert('Data tidak ditemukan.');
        }
    }
    
    function setFormWithdrawal(){
        $("#modal-response-message-withdrawal").finish();
        $('#nominal-withdraw').val(0);
        $('#withdrawal-date').val(moment().format('DD/MM/YYYY'));
        
        if(arrOptionWithdrawal.length > 0){
            $('#form-nominal-withdrawal').attr('data-url', siteUrl + 'transaction/payment/act_add_withdrawal');
            
            generateSelect2('#withdrawal-saving-type', arrOptionWithdrawal, 'id', 'name_alias');
            
            $('#withdrawal-saldo').text(number_format(arrOptionWithdrawal[0].balance));
            $('#withdrawal-member-account-number').val(arrOptionWithdrawal[0].account_number);
            
            let id = $('#withdrawal-saving-type').val();
            withdrawalSavingId = id;
            
            let indexWithdrawal = arrOptionWithdrawal.findIndex(item => item.id == withdrawalSavingId);
            withdrawalMemberSavingId = arrOptionWithdrawal[indexWithdrawal].saving_id;
            if(arrOptionWithdrawal[indexWithdrawal].is_withdrawal_fee == 1){
                withdrawalFeePercent = parseFloat(arrOptionWithdrawal[indexWithdrawal].withdraw_fee_percent);
                $('#container-withdrawal-fee').show();
                $('#withdrawal-fee-percent').text(`(${number_format(withdrawalFeePercent, 2)} %)`);
                let nominal = convertFormatRp($('#nominal-withdraw').val());
                $('#withdrawal-fee').val(number_format(nominal * withdrawalFeePercent / 100));
            }else{
                $('#container-withdrawal-fee').hide();
            }
            withdrawalSavingTitle = arrOptionWithdrawal[indexWithdrawal].name;
            
            $('#modal-withdrawal-input-code').modal('hide');
            $('#modal-option-withdrawal').modal({
                backdrop: 'static',
//                keyboard: false
            }, 'show');
        }else{
            alert('Data tidak ditemukan.');
        }
    }
    
    function modalOptionPaymentClose(){
        $('#modal-option-payment').modal('hide');
        $('#payment-code-member-code').val('');
        $('#modal-payment-input-code').modal({
            backdrop: 'static',
//            keyboard: false
        }, 'show');
        $('#payment-code-member-code').focus();
    }
    
    function modalOptionWithdrawalClose(){
        $('#modal-option-withdrawal').modal('hide');
        $('#withdrawal-code-member-code').val('');
        $('#modal-withdrawal-input-code').modal({
            backdrop: 'static',
//            keyboard: false
        }, 'show');
        $('#withdrawal-code-member-code').focus();
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
        $('#modal-option-payment').modal('hide');
        $('#modal-history-payment').modal({
            backdrop: 'static',
//            keyboard: false
        }, 'show');
    }
    
    function openModalHistoryWithdrawal(){
        let memberId = $('#withdrawal-member-id').val();
        $('#history-withdrawal-title').text(withdrawalSavingTitle);
        loadGridMemberSavingLogWithdrawal(memberId);
        $('#modal-option-withdrawal').modal('hide');
        $('#modal-history-withdrawal').modal({
            backdrop: 'static',
//            keyboard: false
        }, 'show');
    }
    
    function modalHistoryPaymentClose(){
        $('#modal-history-payment').modal('hide');
        $('#modal-option-payment').modal({
            backdrop: 'static',
//            keyboard: false
        }, 'show');
        $('#payment-type').focus();
    }
    
    function modalHistoryWithdrawalClose(){
        $('#modal-history-withdrawal').modal('hide');
        $('#modal-option-withdrawal').modal({
            backdrop: 'static',
//            keyboard: false
        }, 'show');
        $('#withdrawal-saving-type').focus();
    }
    
    let delay = (function(){
        let timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();
    
    $(document).ready(function(){
        
//        $('#modal-option-payment').modal({
//            backdrop: 'static',
//            keyboard: false
//        }, 'show');
//        
        $('#modal-option-payment').on('hidden.bs.modal', function (){
            modalOptionPaymentClose();
        });
        
        $('#modal-option-withdrawal').on('hidden.bs.modal', function (){
            modalOptionWithdrawalClose();
        });
        
        $('#modal-history-payment').on('hidden.bs.modal', function (){
            modalHistoryPaymentClose();
        });
        
        $('#modal-history-withdrawal').on('hidden.bs.modal', function (){
            modalHistoryWithdrawalClose();
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
                let savingId = $('#saving-type').val();
                paymentProductSavingId = savingId;
                
                let indexProductSaving = arrOptionPaymentSaving.findIndex(item => item.id == savingId);
                
                if(typeof arrOptionPaymentSaving[indexProductSaving] != 'undefined'){
                    paymentProductSavingTitle = arrOptionPaymentSaving[indexProductSaving].name;
                    paymentMemberProductSavingId = arrOptionPaymentSaving[indexProductSaving].saving_id;
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
            
            let savingId = $(this).val();
            paymentProductSavingId = savingId;
            
            let indexProductSaving = arrOptionPaymentSaving.findIndex(item => item.id == savingId);
            paymentProductSavingTitle = arrOptionPaymentSaving[indexProductSaving].name;
            paymentMemberProductSavingId = arrOptionPaymentSaving[indexProductSaving].saving_id;
            
            $('#payment-member-account-number').val(arrOptionPaymentSaving[indexProductSaving].account_number);
            $('#payment-saldo').text(number_format(arrOptionPaymentSaving[indexProductSaving].balance));
            
        });
        
        $('#nominal-withdraw').on('keyup', function (){
            let nominal = convertFormatRp($(this).val());
            $('#withdrawal-fee').val(number_format(nominal * withdrawalFeePercent / 100));
        });
        
        $('#withdrawal-saving-type').on('change', function (){
            let savingId = $(this).val();
            withdrawalSavingId = savingId;
            
            let indexWithdrawal = arrOptionWithdrawal.findIndex(item => item.id == savingId);
            withdrawalSavingTitle = arrOptionWithdrawal[indexWithdrawal].name;
            withdrawalMemberSavingId = arrOptionWithdrawal[indexWithdrawal].saving_id;
            
            if(arrOptionWithdrawal[indexWithdrawal].is_withdrawal_fee == 1){
                withdrawalFeePercent = parseFloat(arrOptionWithdrawal[indexWithdrawal].withdraw_fee_percent);
                $('#container-withdrawal-fee').show();
                $('#withdrawal-fee-percent').text(`(${number_format(withdrawalFeePercent, 2)} %)`);
                let nominal = convertFormatRp($('#nominal-withdraw').val());
                $('#withdrawal-fee').val(number_format(nominal * withdrawalFeePercent / 100));
            }else{
                $('#container-withdrawal-fee').hide();
            }
            
            $('#withdrawal-member-account-number').val(arrOptionWithdrawal[indexWithdrawal].account_number);
            $('#withdrawal-saldo').text(number_format(arrOptionWithdrawal[indexWithdrawal].balance));
            
        });
        
        $('#form-payment-input-code').on('submit', function (e){
            e.preventDefault();
            let memberCode = $('#payment-code-member-code').val();
            globalsMemberCode = memberCode;
            ajaxRequest('common/general/transaction/payment/get_option_payment', 'GET', {member_code: memberCode}, function(res) {
//                console.log(res);
                if(res.status == 200){
                    let member = res.data.detail_member;
                    let option = res.data.option_payment;
                    
                    $('#payment-member-id').val(member.member_id);
                    
                    $('#payment-member-code').val(member.member_code);
                    $('#payment-member-name').val(member.member_name);
                    
                    arrOptionPayment = option;
                    arrOptionPaymentSaving = option[option.length - 1].option; // defined saving option
                    setFormPayment();
                }else{
                    alert(res.msg);
                    $('#payment-code-member-code').focus();
                }
            });
        });
        
        $('#form-withdrawal-input-code').on('submit', function (e){
            e.preventDefault();
            let memberCode = $('#withdrawal-code-member-code').val();
            globalsMemberCode = memberCode;
            ajaxRequest('common/general/transaction/withdrawal/get_option', 'GET', {member_code: memberCode}, function(res) {
                console.log(res);
                if(res.status == 200){
                    let member = res.data.detail_member;
                    let option = res.data.option_withdrawal;
                    
                    $('#withdrawal-member-id').val(member.member_id);
                    
                    $('#withdrawal-member-code').val(member.member_code);
                    $('#withdrawal-member-name').val(member.member_name);
                    
                    arrOptionWithdrawal = option;
                    setFormWithdrawal();
                }else{
                    alert(res.msg);
                    $('#withdrawal-code-member-code').focus();
                }
            });
        });
        
        $('#form-nominal').on('submit', function (e) {
            e.preventDefault();
            $('#form-nominal button[type="submit"]').attr('disabled', 'disabled');
            let urlForm = $(this).attr('data-url');

            let formData = new FormData(this);
            formData.append('name', paymentName);
            formData.append('product_id', paymentProductSavingId);

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
//                        $('#modal-option-payment').modal('hide');
//                        $('#payment-code-member-code').val('');
//                        $('#modal-payment-input-code').modal({
//                            backdrop: 'static',
//                            keyboard: false
//                        }, 'show');
                        ajaxRequest('common/general/transaction/payment/get_option_payment', 'GET', {member_code: globalsMemberCode}, function(res) {
            //                console.log(res);
                            if(res.status == 200){
                                let member = res.data.detail_member;
                                let option = res.data.option_payment;

                                $('#payment-member-id').val(member.member_id);

                                $('#payment-member-code').val(member.member_code);
                                $('#payment-member-name').val(member.member_name);

                                arrOptionPayment = option;
                                arrOptionPaymentSaving = option[option.length - 1].option; // defined saving option
                                $('#payment-type').change();
                            }else{
                                alert(res.msg);
                                $('#modal-option-payment').modal('hide');
                                $('#payment-code-member-code').val('');
                                $('#modal-payment-input-code').modal({
                                    backdrop: 'static',
//                                    keyboard: false
                                }, 'show');
                            }
                        });

                        $('#form-nominal button[type="submit"]').removeAttr('disabled');
                        $('#gridview').flexReload();
                        $('#modal-option-payment .modal-body').animate({scrollTop: '0px'}, 300);
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
        
        $('#form-nominal-withdrawal').on('submit', function (e) {
            e.preventDefault();
            $('#form-nominal-withdrawal button[type="submit"]').attr('disabled', 'disabled');
            let urlForm = $(this).attr('data-url');

            let formData = new FormData(this);
            formData.append('product_id', withdrawalSavingId);

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
//                        $('#modal-option-withdrawal').modal('hide');
//                        $('#withdrawal-code-member-code').val('');
//                        $('#modal-withdrawal-input-code').modal({
//                            backdrop: 'static',
//                            keyboard: false
//                        }, 'show');

                        ajaxRequest('common/general/transaction/withdrawal/get_option', 'GET', {member_code: globalsMemberCode}, function(res) {
//                            console.log(res);
                            if(res.status == 200){
                                let member = res.data.detail_member;
                                let option = res.data.option_withdrawal;

                                $('#withdrawal-member-id').val(member.member_id);

                                $('#withdrawal-member-code').val(member.member_code);
                                $('#withdrawal-member-name').val(member.member_name);

                                arrOptionWithdrawal = option;
                                $('#withdrawal-saving-type').change();
                            }else{
                                alert(res.msg);
                                $('#modal-option-withdrawal').modal('hide');
                                $('#withdrawal-code-member-code').val('');
                                $('#modal-withdrawal-input-code').modal({
                                    backdrop: 'static',
//                                    keyboard: false
                                }, 'show');
                            }
                        });
                        
                        $('#form-nominal-withdrawal button[type="submit"]').removeAttr('disabled');
                        $('#gridview').flexReload();
                        $('#modal-option-withdrawal .modal-body').animate({scrollTop: '0px'}, 300);
                        let message_class = 'alert alert-success';

                        $("#modal-response-message-withdrawal").finish();

                        $("#modal-response-message-withdrawal").addClass(message_class);
                        $("#modal-response-message-withdrawal").slideDown("fast");
                        $("#modal-response-message-withdrawal").html(res.data);
                        $("#modal-response-message-withdrawal").delay(10000).slideUp(1000, function () {
                            $("#modal-response-message-withdrawal").removeClass(message_class);
                        });
                    } else {
                        $('#form-nominal-withdrawal button[type="submit"]').removeAttr('disabled');
                        $('#modal-option-withdrawal .modal-body').animate({scrollTop: '0px'}, 300);
                        let message_class = 'alert alert-danger';
                        $("#modal-response-message-withdrawal").finish();
                        $("#modal-response-message-withdrawal").addClass(message_class);

                        $("#modal-response-message-withdrawal").slideDown("fast");
                        $('#modal-response-message-withdrawal').html(res.msg);
                        $("#modal-response-message-withdrawal").delay(10000).slideUp(1000, function (){
                            $("#modal-response-message-withdrawal").removeClass(message_class);
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#form-nominal-withdrawal button[type="submit"]').removeAttr('disabled');
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
                    {display: 'Input Setoran', name: 'payment', bclass: 'accounting', onpress: openPayment},
                    ";
            endif;
            ?>
        ],
        buttons_right: [
            <?php
            if (privilege_view('export', $this->menu_privilege)):
                echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: my_export_data, urlaction: '" . site_url("transaction/payment/export_data_lkh") . "'}";
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
    
    function loadGridMemberSavingLogWithdrawal(memberId){
        if(typeof gridMemberSavingLogWithdrawal == 'undefined'){
            gridMemberSavingLogWithdrawal = $("#gridview-member-saving-log-withdrawal").flexigrid({
                url: siteUrl + 'transaction/payment/get_member_saving_log',
                params: [{name: "member_id", value: memberId}, {name: "saving_id", value: withdrawalMemberSavingId}],
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
            $("#gridview-member-saving-log-withdrawal").flexOptions({
                url: siteUrl + 'transaction/payment/get_member_saving_log',
                params: [{name: "member_id", value: memberId}, {name: "saving_id", value: withdrawalMemberSavingId}],
            }).flexClearReload();
        }
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
    function generateSelect2(element = '.select2', data = [], nameValue, nameText, selectedValue = false, selectedName = '', placeHolder = false, placeHolderValue = '') {
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
        $(element).html(option).select2();
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
        lang: 'id'
    });
</script>
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

<!-- Modal choose Member-->
<div id="modal-choose-member" class="modal" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Penarikan</h4>
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
                            <button id="btn-history-withdrawal" type="button" class="btn btn-default btn-sm btn-round pull-right" onclick="openModalHistoryWithdrawal()" style="margin-bottom: 0px; margin-right: 0px;"><i class="fa fa-list"></i>&nbsp;<u>L</u>ihat Riwayat</button>
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
    
    let gridMemberSavingLogWithdrawal;
    let startDate = '';
    let endDate = '';
    
    let globalsMemberCode = '';
    
    let arrOptionWithdrawal = [];
    let withdrawalSavingId = '';
    let withdrawalMemberSavingId = '';
    let withdrawalSavingTitle = '';
    let withdrawalFeePercent = 0;
    
    function openWithdrawal(){
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
    
    function setFormWithdrawal(){
        $("#modal-response-message-withdrawal").finish();
        $('#nominal-withdraw').val(0);
        $('#withdrawal-date').val(moment().format('DD/MM/YYYY'));
        
        if(arrOptionWithdrawal.length > 0){
            $('#form-nominal-withdrawal').attr('data-url', siteUrl + 'transaction/payment/act_add_withdrawal');
            
            generateSelect2('#withdrawal-saving-type', '#modal-option-withdrawal', arrOptionWithdrawal, 'saving_id', 'label');
            
            $('#withdrawal-saldo').text(number_format(arrOptionWithdrawal[0].balance));
            $('#withdrawal-member-account-number').val(arrOptionWithdrawal[0].account_number);
            
            let memberSavingId = $('#withdrawal-saving-type').val();
            withdrawalMemberSavingId = memberSavingId;
            
            let indexWithdrawal = arrOptionWithdrawal.findIndex(item => item.saving_id == withdrawalMemberSavingId);
            withdrawalSavingId = arrOptionWithdrawal[indexWithdrawal].id;
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
            
            $('#modal-option-withdrawal').modal({
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
    
    function openModalHistoryWithdrawal(){
        let memberId = $('#withdrawal-member-id').val();
        $('#history-withdrawal-title').text(withdrawalSavingTitle);
        loadGridMemberSavingLogWithdrawal(memberId);
        $('#modal-history-withdrawal').modal({
            backdrop: 'static',
        }, 'show');
    }
    
    function chooseMember(com, grid, urlaction){
        let grid_id = $(grid).attr('id');
        grid_id = grid_id.substring(grid_id.lastIndexOf('grid_') + 5);
        
        if ($('.trSelected', grid).length > 0) {
            let memberCode = $('.trSelected', grid).attr('data-id');
            globalsMemberCode = memberCode;
            ajaxRequest('common/general/transaction/withdrawal/get_option', 'GET', {member_code: memberCode}, function(res) {
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
                    setTimeout(function (){
                        $('#grid_gridview-member .trSelected').removeClass('trSelected');
                        $('#grid_gridview-member tr[tabindex="1"].control-row:visible').addClass('trSelected').focus();
                    }, 200);
                }
            });
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
        
        $('body').on('hidden.bs.modal', '#gridview-member_formModalFilter, #modal-option-withdrawal', function (){
            $('#grid_gridview-member .trSelected').removeClass('trSelected');
            $('#grid_gridview-member tr[tabindex="1"].control-row:visible').addClass('trSelected').focus();
        });
        
        $('body').on('hidden.bs.modal', '#gridview-member-saving-log-withdrawal_formModalFilter', function (){
            $('#modal-history-withdrawal').focus();
        });
        
        $('body').on('hidden.bs.modal', '#modal-history-withdrawal', function (){
            $('#withdrawal-saving-type').focus();
        });
        
        $('#modal-choose-member').on('focusout', 'tr.control-row', function (e){
            if(($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
                if(($("#gridview-member_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                    $('#modal-choose-member').find('.trSelected').removeClass('trSelected');
                }else if(($("#modal-option-withdrawal").data('bs.modal') || {isShown: false}).isShown){
                    $('#modal-choose-member').find('.trSelected').removeClass('trSelected');
                }else if(($("#modal-history-withdrawal").data('bs.modal') || {isShown: false}).isShown){
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

        $('#nominal-withdraw').on('keyup', function (){
            let nominal = convertFormatRp($(this).val());
            $('#withdrawal-fee').val(number_format(nominal * withdrawalFeePercent / 100));
        });
        
        $('#withdrawal-saving-type').on('change', function (){
            let memberSavingId = $(this).val();
            withdrawalMemberSavingId = memberSavingId;
            
            let indexWithdrawal = arrOptionWithdrawal.findIndex(item => item.saving_id == memberSavingId);
            withdrawalSavingTitle = arrOptionWithdrawal[indexWithdrawal].name;
            withdrawalSavingId = arrOptionWithdrawal[indexWithdrawal].id;
            
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
        
        $('#form-nominal-withdrawal').on('submit', function (e) {
            e.preventDefault();
            $('#form-nominal-withdrawal button[type="submit"]').attr('disabled', 'disabled');
            let urlForm = $(this).attr('data-url');

            let formData = new FormData(this);
            formData.append('saving_id', withdrawalMemberSavingId);

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
                                $('#grid_gridview-member .trSelected').removeClass('trSelected');
                                $('#grid_gridview-member tr[tabindex="1"].control-row:visible').addClass('trSelected').focus();
                            }
                        });
                        
                        $('#form-nominal-withdrawal button[type="submit"]').removeAttr('disabled');
                        $('#gridview').flexReload();
                        $('#modal-option-withdrawal .modal-body').animate({scrollTop: '0px'}, 300);
                        $('#withdrawal-saving-type').focus();
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
                        $('#withdrawal-saving-type').focus();
                        let message_class = 'alert alert-danger';
                        $("#modal-response-message-withdrawal").finish();
                        $("#modal-response-message-withdrawal").addClass(message_class);

                        $("#modal-response-message-withdrawal").slideDown("fast");
                        $('#modal-response-message-withdrawal').html(res.msg);
                        $("#modal-response-message-withdrawal").delay(20000).slideUp(1000, function (){
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
        url: siteUrl + 'transaction/withdrawal/get_data',
        params: [{name: "start_date", value: ""}, {name: "end_date", value: ""}],
        dataType: 'json',
        colModel: [
            {display: 'Tanggal Pembayaran', name: 'transaction_datetime', width: 160, sortable: true, align: 'center'},
            {display: 'Nama Anggota', name: 'member_name', width: 200, sortable: true, align: 'left', hide:true},
            {display: 'No. Anggota', name: 'member_code', width: 110, sortable: true, align: 'center'},
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
                    {display: 'Pe<u>n</u>arikan Simpanan', name: 'payment', bclass: 'accounting', onpress: openWithdrawal},
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
    
    function loadGridMemberSavingLogWithdrawal(memberId){
        if(typeof gridMemberSavingLogWithdrawal == 'undefined'){
            gridMemberSavingLogWithdrawal = $("#gridview-member-saving-log-withdrawal").flexigrid({
                url: siteUrl + 'transaction/withdrawal/get_member_saving_log',
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
                url: siteUrl + 'transaction/withdrawal/get_member_saving_log',
                params: [{name: "member_id", value: memberId}, {name: "saving_id", value: withdrawalMemberSavingId}],
            }).flexClearReload();
        }
    }
    
    function loadFlexigridMember(){
        if(typeof gridMember == 'undefined'){
            gridMember = $('#gridview-member').flexigrid({
                url: siteUrl + 'transaction/withdrawal/get_data_member',
                dataType: 'json',
                colModel: [
                    {display: 'No. Anggota', name: 'member_code', width: 110, sortable: true, align: 'center'},
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
                url: siteUrl + 'transaction/withdrawal/get_data_member',
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
            if(!($("#modal-option-withdrawal").data('bs.modal') || {isShown: false}).isShown){
                if(($("#gridview-member_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                    $('#gridview-member_search').click();
                }else{
                    $('#gridview-member_pSearch').click();
                }
            }
        }
        
        if(($("#modal-history-withdrawal").data('bs.modal') || {isShown: false}).isShown){
            if(($("#gridview-member-saving-log-withdrawal_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                $('#gridview-member-saving-log-withdrawal_search').click();
            }else{
                $('#gridview-member-saving-log-withdrawal_pSearch').click();
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
        
        if(($("#modal-history-withdrawal").data('bs.modal') || {isShown: false}).isShown){
            if(!($("#gridview-member-saving-log-withdrawal_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                $('#grid_gridview-member-saving-log-withdrawal .pDiv2 .pPrev.pButton span').click();
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
        
        if(($("#modal-history-withdrawal").data('bs.modal') || {isShown: false}).isShown){
            if(!($("#gridview-member-saving-log-withdrawal_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                $('#grid_gridview-member-saving-log-withdrawal .pDiv2 .pNext.pButton span').click();
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
            if(!($("#modal-option-withdrawal").data('bs.modal') || {isShown: false}).isShown){
                if(($("#gridview-member_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                    $('#gridview-member_reset').click();
                }else{
                    $('#grid_gridview-member .pDiv2 .pReload.pButton span').click();
                }
            }
        }
        
        if(($("#modal-history-withdrawal").data('bs.modal') || {isShown: false}).isShown){
            if(!($("#gridview-member-saving-log-withdrawal_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                $('#grid_gridview-member-saving-log-withdrawal .pDiv2 .pNext.pButton span').click();
            }
        }
    });
    
    //focus di input nomor halaman
    $.key('alt+h', function() {
        if(!($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            $('#grid_gridview .pDiv2 input').focus();
        }
        
        if(($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            if(!($("#modal-option-withdrawal").data('bs.modal') || {isShown: false}).isShown){
                $('#grid_gridview-member .trSelected').removeClass('trSelected');
                $('#grid_gridview-member .pDiv2 input').focus();
            }
        }
        
        if(($("#modal-history-withdrawal").data('bs.modal') || {isShown: false}).isShown){
            if(!($("#gridview-member-saving-log-withdrawal_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                $('#grid_gridview-member-saving-log-withdrawal .pDiv2 input').focus();
            }
        }
    });
    
    //focus di range per halaman
    $.key('alt+p', function() {
        if(!($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            $('#grid_gridview .pDiv2 select').focus();
        }
        
        if(($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            if(!($("#modal-option-withdrawal").data('bs.modal') || {isShown: false}).isShown){
                $('#grid_gridview-member .trSelected').removeClass('trSelected');
                $('#grid_gridview-member .pDiv2 select').focus();
            }
        }
        
        if(($("#modal-history-withdrawal").data('bs.modal') || {isShown: false}).isShown){
            if(!($("#gridview-member-saving-log-withdrawal_formModalFilter").data('bs.modal') || {isShown: false}).isShown){
                $('#grid_gridview-member-saving-log-withdrawal .pDiv2 select').focus();
            }
        }
    });
    
    //pilih anggota
    $.key('alt+i', function() {
        if(($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            if(!($("#modal-option-withdrawal").data('bs.modal') || {isShown: false}).isShown){
               $('#grid_gridview-member .tDiv2 .fbutton > div:first').click();
            }
        }
    });
    
    //lihat riwayat
    $.key('alt+l', function() {
        if(($("#modal-option-withdrawal").data('bs.modal') || {isShown: false}).isShown){
            if(!($("#modal-history-withdrawal").data('bs.modal') || {isShown: false}).isShown){
               $('#btn-history-withdrawal').click();
            }
        }
    });
    
    //focus di list pilih anggota
    $.key('alt+a', function() {
        if(($("#modal-choose-member").data('bs.modal') || {isShown: false}).isShown){
            if(!($("#modal-option-withdrawal").data('bs.modal') || {isShown: false}).isShown){
                $('#grid_gridview-member .trSelected').removeClass('trSelected');
                $('#grid_gridview-member tr[tabindex="1"].control-row:visible').addClass('trSelected').focus();
            }
        }
    });
</script>
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

<?php if(privilege_view(['add', 'update'], $this->menu_privilege)): ?>
<!-- Modal -->
<div id="modal" class="modal fade" role="dialog" style="overflow-y: hidden;">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <form class="form-horizontal form-label-left" data-url="">
                <div class="modal-body" style="overflow-y: scroll; height: calc(100vh - 200px);">
                    <div id="modal-response-message" class="alert alert-danger alert-dismissible fade in" role="alert" style="display:none"></div>

                    <input id="input-id" type="hidden" name="id">
                    <input id="input-code" type="hidden" name="code">
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                             <div class="x_panel">
                                <div class="x_title">
                                    <h2>Informasi Umum</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="input-name">Nama Produk <span class="required">*</span>
                                                </label>
                                                <input tabindex="1" id="input-name" type="text" name="name" class="form-control" data-validation="required length" data-validation-length="max50">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="input-alias-name">Nama Alias <span class="required">*</span>
                                                </label>
                                                <input tabindex="2" id="input-alias-name" type="text" name="name_alias" class="form-control" data-validation="required length" data-validation-length="max50">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="input-collateral-type">Jenis Jaminan <span class="required">*</span>
                                                </label>
                                                <input tabindex="3" id="input-collateral-type" type="text" name="collateral_type" class="form-control" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Disertakan Perlindungan Daperma? <span class="required">*</span>
                                                </label>
                                                <div style="width: 100%;">
                                                    <label class="control-label input-is-daperma" style="margin-right: 18px;"><input tabindex="4" type="radio" checked="checked" value="0" name="is_daperma"> Tidak</label>
                                                    <label class="control-label input-is-daperma" style="margin-right: 18px;"><input tabindex="4" type="radio" value="1" name="is_daperma"> Ya</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                             <div class="x_panel">
                                <div class="x_title">
                                    <h2>Bunga</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="input-interest-percent">Bunga (%) <span class="required">*</span>
                                                </label>
                                                <input tabindex="5" id="input-interest-percent" type="text" name="interest_percent" class="form-control text-right percent-format" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Jenis Bunga <span class="required">*</span>
                                                </label>
                                                <div style="width: 100%;">
                                                    <label class="control-label input-interest-type" style="margin-right: 18px;"><input tabindex="6" type="radio" checked="checked" value="0" name="interest_type"> Flat/Tetap</label>
                                                    <label class="control-label input-interest-type" style="margin-right: 18px;"><input tabindex="6" type="radio" value="1" name="interest_type"> Efektif/Menurun</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                             <div class="x_panel">
                                <div class="x_title">
                                    <h2>Pinjaman</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="input-max-plafon">Maksimal Plafon Pinjaman <span class="required">*</span>
                                                </label>
                                                <input tabindex="7" id="input-max-plafon" type="text" name="max_plafon" class="form-control text-right currency" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="input-service-loan-percent1">Jasa Pinjaman 1 (%) <span class="required">*</span>
                                                </label>
                                                <input tabindex="8" id="input-service-loan-percent1" type="text" name="service_loan_percent1" class="form-control text-right percent-format" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="input-service-loan-percent2">Jasa Pinjaman Selanjutnya (%) <span class="required">*</span>
                                                </label>
                                                <input tabindex="9" id="input-service-loan-percent2" type="text" name="service_loan_percent2" class="form-control text-right percent-format" data-validation="required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                             <div class="x_panel">
                                <div class="x_title">
                                    <h2>Administrasi</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="input-service-percent">Jasa Pelayanan (%) <span class="required">*</span>
                                                </label>
                                                <input tabindex="10" id="input-service-percent" type="text" name="service_percent" class="form-control text-right percent-format" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="input-forfeit-percent">Denda (%) <span class="required">*</span>
                                                </label>
                                                <input tabindex="11" id="input-forfeit-percent" type="text" name="forfeit_percent" class="form-control text-right percent-format" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="input-pinalty-fee-percent">Biaya Pinalti (%) <span class="required">*</span>
                                                </label>
                                                <input tabindex="12" id="input-pinalty-fee-percent" type="text" name="pinalty_fee_percent" class="form-control text-right percent-format" data-validation="required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button tabindex="13" type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Simpan <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal -->
<?php endif; ?>

<!--FORM VALIDATOR-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<!--MASK MONEY-->   
<script src="<?php echo THEMES_BACKEND; ?>/js/jquery.maskMoney.min.js"></script>

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    
    function openModalEdit(id){
        $('.has-success').removeClass('has-success');
        $('.has-error').removeClass('has-error');
        ajaxRequest('common/general/product/product_loan/get_detail', 'GET', {id: id}, function(res){
            if(res.status == 200){
                let data = res.data;
                $('#form').trigger("reset");
                $('#modal .modal-title').text(`Form Ubah ${menuName}`);
                $('#form').attr('data-url', '<?php echo site_url('product/product_loan/act_update'); ?>');
                $("#modal-response-message").finish();
                
                $('#input-id').val(data.product_loan_id);
                $('#input-code').val(data.product_loan_code);
                $('#input-name').val(data.product_loan_name);
                $('#input-alias-name').val(data.product_loan_name_alias);
                
                $('#input-collateral-type').val(data.product_loan_collateral_type);
                
                $('.input-is-daperma input[type=radio][value='+data.product_loan_is_daperma+']').prop('checked', true);

                $('#input-interest-percent').val(number_format(data.product_loan_interest_percent, 2));

                $('.input-interest-type input[type=radio][value='+data.product_loan_interest_type+']').prop('checked', true);

                $('#input-max-plafon').val(number_format(data.product_loan_max_plafon));
                $('#input-service-loan-percent1').val(number_format(data.product_loan_service_loan_percent1, 2));
                $('#input-service-loan-percent2').val(number_format(data.product_loan_service_loan_percent2, 2));
                $('#input-service-percent').val(number_format(data.product_loan_service_percent, 2));
                $('#input-forfeit-percent').val(number_format(data.product_loan_forfeit_percent, 2));
                $('#input-pinalty-fee-percent').val(number_format(data.product_loan_pinalty_fee_percent, 2));
                
                $('#modal').modal({
                    backdrop: 'static',
                    keyboard: false
                }, 'show');
            }else{
                alert('Data tidak ditemukan.');
            }
        });
    }
    
    $(document).ready(function (){
        $('.currency').maskMoney({
            prefix: '',
            suffix: '',
            allowNegative: false,
            thousands: '.',
            decimal: ',',
            affixesStay: true,
            precision: 0,
            allowZero: true
        });
        
        $('.percent-format').maskMoney({
            prefix: '',
            suffix: '',
            allowNegative: false,
            thousands: '.',
            decimal: ',',
            affixesStay: true,
            precision: 2,
            allowZero: true
        });
        
        $('form').on('submit', function (e){
            e.preventDefault();
            $('form button[type="submit"]').attr('disabled', 'disabled');
            let form = this;
            $.each($(form).find('.currency'), function (index, element){
                let value = $(element).val();
                $(element).val(convertFormatRp(value));
            });
            
            $.each($(form).find('.percent-format'), function (index, element){
                let value = $(element).val();
                $(element).val(convertFormatPercent(value));
            });
            
            let formData = new FormData(form);
            
//            for (var pair of formData.entries()) {
//                console.log(pair[0] + ', ' + pair[1]);
//            }
            
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('product/product_loan/act_update') ?>',
                data: formData,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    let message_class = '';
                    if (res.status == 200) {
                        $('#gridview').flexReload();
                        $('form button[type="submit"]').removeAttr('disabled');
                        $('#modal').modal('hide');
                        message_class = 'alert alert-success';

                        $("#response_message").finish();

                        $("#response_message").addClass(message_class);
                        $("#response_message").slideDown("fast");
                        $("#response_message").html(res.data);
                        $("#response_message").delay(10000).slideUp(1000, function () {
                            $("#response_message").removeClass(message_class);
                        });

                    } else {
                        $.each($(form).find('.currency'), function (index, element){
                            let value = $(element).val();
                            $(element).val(number_format(value));
                        });
                        
                        $.each($(form).find('.percent-format'), function (index, element){
                            let value = $(element).val();
                            $(element).val(number_format(value, 2));
                        });
                        $('form button[type="submit"]').removeAttr('disabled');
                        $("#modal-response-message").finish();
                        
                        $("#modal-response-message").slideDown("fast");
                        $("#modal-response-message").html(res.msg);
                        $("#modal-response-message").delay(10000).slideUp(1000);
                    }
                },
                error: function (err) {
                    $.each($(form).find('.currency'), function (index, element){
                        let value = $(element).val();
                        $(element).val(number_format(value));
                    });
                    
                    $.each($(form).find('.percent-format'), function (index, element){
                        let value = $(element).val();
                        $(element).val(number_format(value, 2));
                    });
                    $('form button[type="submit"]').removeAttr('disabled');
                }
            });
        });
    });
    
    $("#gridview").flexigrid({
        url: siteUrl + 'product/product_loan/get_data',
        dataType: 'json',
        colModel: [
            <?php if(privilege_view('update', $this->menu_privilege)):
                echo "{display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false},";
            endif; ?>
            {display: 'Kode Produk', name: 'product_loan_code', width: 80, sortable: true, align: 'center'},
            {display: 'Nama Produk', name: 'product_loan_name', width: 300, sortable: true, align: 'left'},
            {display: 'Nama Alias', name: 'product_loan_name_alias', width: 200, sortable: true, align: 'left'},
            {display: 'Maks. Plafon Pinjaman', name: 'product_loan_max_plafon', width: 200, sortable: true, align: 'right'},
            {display: 'Jasa Pelayanan (%)', name: 'product_loan_service_percent', width: 200, sortable: true, align: 'right'},
            {display: 'Jasa Pinjaman 1 (%)', name: 'product_loan_service_loan_percent1', width: 200, sortable: true, align: 'right'},
            {display: 'Jasa Pinjaman 2 (%)', name: 'product_loan_service_loan_percent2', width: 200, sortable: true, align: 'right'},
            {display: 'Denda (%)', name: 'product_loan_forfeit_percent', width: 200, sortable: true, align: 'right'},
            {display: 'Bunga (%)', name: 'product_loan_interest_percent', width: 200, sortable: true, align: 'right'},
            {display: 'Jenis Bunga', name: 'product_loan_interest_type', width: 200, sortable: true, align: 'center'},
            {display: 'Biaya Pinalti (%)', name: 'product_loan_pinalty_fee_percent', width: 200, sortable: true, align: 'right'},
            {display: 'Jenis Jaminan', name: 'product_loan_collateral_type', width: 200, sortable: true, align: 'left'},
            {display: 'Disertakan Daperma', name: 'product_loan_is_daperma', width: 200, sortable: true, align: 'center'},
        ],
//        buttons_right: [
//            <?php if(privilege_view('export', $this->menu_privilege)):
                //echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("setup/jurnal_master/export_data_jurnal") . "'}";
            endif; ?>//
//        ],
//        searchitems: [
//            {display: 'Nama Jurnal', name: 'jurnal_master_title', type: 'text'},
//            {display: 'Tipe Jurnal', name: 'jurnal_master_type', type: 'select', option:'0:Memorial|1:Otomatis'},
//            {display: 'Terakhir Berubah', name: 'jurnal_master_last_update', type: 'date'},
//        ],
        sortname: "product_loan_id",
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
    
    $.validate({
        modules: 'logic',
        lang: 'id',
        onError: function(){
            $('#modal .modal-body').animate({scrollTop: '0px'}, 300);
        }
    });
</script>
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
                                                <label class="control-label" for="input-min-balance">Saldo Minimal <span class="required">*</span>
                                                </label>
                                                <input tabindex="3" id="input-min-balance" type="text" name="min_balance" class="form-control text-right currency" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Bisa Dijadikan Jaminan? <span class="required">*</span>
                                                </label>
                                                <div style="width: 100%;">
                                                    <label class="control-label input-is-loan-guarantee" style="margin-right: 18px;"><input tabindex="4" type="radio" checked="checked" value="0" name="is_loan_guarantee"> Tidak Bisa</label>
                                                    <label class="control-label input-is-loan-guarantee" style="margin-right: 18px;"><input tabindex="4" type="radio" value="1" name="is_loan_guarantee"> Bisa</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="title">Dapat Diasuransikan? <span class="required">*</span>
                                                </label>
                                                <div style="width: 100%;">
                                                    <label class="control-label input-is-insured" style="margin-right: 18px;"><input tabindex="5" type="radio" checked="checked" value="0" name="is_insured"> Tidak Bisa</label>
                                                    <label class="control-label input-is-insured" style="margin-right: 18px;"><input tabindex="5" type="radio" value="1" name="is_insured"> Bisa</label>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="title">Digunakan Untuk Registrasi? <span class="required">*</span>
                                                </label>
                                                <div style="width: 100%;">
                                                    <label class="control-label input-is-use-registration" style="margin-right: 18px;"><input tabindex="6" type="radio" checked="checked" value="0" name="is_use_registration"> Tidak</label>
                                                    <label class="control-label input-is-use-registration" style="margin-right: 18px;"><input tabindex="6" type="radio" value="1" name="is_use_registration"> Iya</label>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="title">Untuk Anggota diatas 17 tahun? <span class="required">*</span>
                                                </label>
                                                <div style="width: 100%;">
                                                    <label class="control-label input-is-under-age" style="margin-right: 18px;"><input tabindex="7" type="radio" checked="checked" value="0" name="is_under_age"> > 17 tahun</label>
                                                    <label class="control-label input-is-under-age" style="margin-right: 18px;"><input tabindex="7" type="radio" value="1" name="is_under_age"> < 17 tahun </label>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                             <div class="x_panel">
                                <div class="x_title">
                                    <h2>Balas Jasa Simpanan (BJS)</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="input-deposit-percent">Jasa Simpanan (%) <span class="required">*</span>
                                                </label>
                                                <input tabindex="8" id="input-deposit-percent" type="text" name="deposit_service_percent" class="form-control text-right percent-format" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="input-deposit-min">Saldo Minimal BJS <span class="required">*</span>
                                                </label>
                                                <input tabindex="9" id="input-deposit-min" type="text" name="deposit_service_min_balance" class="form-control text-right currency" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Metode BJS <span class="required">*</span>
                                                </label>
                                                <div style="width: 100%;">
                                                    <label class="control-label input-deposit-method" style="margin-right: 18px;"><input tabindex="10" type="radio" checked="checked" value="0" name="deposit_service_method"> Harian</label>
                                                    <label class="control-label input-deposit-method" style="margin-right: 18px;"><input tabindex="10" type="radio" value="1" name="deposit_service_method"> Bulanan</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Perhitungan BJS <span class="required">*</span>
                                                </label>
                                                <div style="width: 100%;">
                                                    <label class="control-label input-deposit-service-is-last-balance" style="margin-right: 18px;"><input tabindex="10" type="radio" checked="checked" value="0" name="deposit_service_is_last_balance"> Saldo Terakhir</label>
                                                    <label class="control-label input-deposit-service-is-last-balance" style="margin-right: 18px;"><input tabindex="10" type="radio" value="1" name="deposit_service_is_last_balance"> Saldo Terendah</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 row">
                                            <div class="form-group">
                                                <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12">Tipe BJS</label>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <select tabindex="11" id="input-bjs-type" class="form-control my-select2 input-sm">
                                                        <option value="">--Pilih Tipe BJS--</option>
                                                        <option value="nominal">Nominal</option>
                                                        <option value="period">Berjangka</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="container-config-bjs" class="col-md-12 col-sm-12 col-xs-12 row"></div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                             <div class="x_panel">
                                <div class="x_title">
                                    <h2>Setoran</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="input-deposit-initial">Setoran Awal Minimal <span class="required">*</span>
                                                </label>
                                                <input tabindex="12" id="input-deposit-initial" type="text" name="initial_deposit_value" class="form-control text-right currency" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="input-min-acc-deposit">Setoran Minimal <span class="required">*</span>
                                                </label>
                                                <input tabindex="13" id="input-min-acc-deposit" type="text" name="min_acc_deposit_value" class="form-control text-right currency" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="title">Setoran Maksimal Perbulan <span class="required">*</span>
                                                </label>
                                                <input tabindex="14" id="input-deposit-max-acc" type="text" name="max_acc_deposit_per_month_value" class="form-control text-right currency" data-validation="required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                             <div class="x_panel">
                                <div class="x_title">
                                    <h2>Penarikan</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="title">Ada Biaya Penarikan? <span class="required">*</span>
                                                </label>
                                                <div style="width: 100%;">
                                                    <label class="control-label input-is-withdrawal-fee" style="margin-right: 18px;"><input tabindex="14" type="radio" class="change-handler" checked="checked" value="0" name="is_withdrawal_fee"> Tidak Ada</label>
                                                    <label class="control-label input-is-withdrawal-fee" style="margin-right: 18px;"><input tabindex="14" type="radio" class="change-handler" value="1" name="is_withdrawal_fee"> Ada</label>
                                                </div>
                                            </div>
                                            <div class="form-group" id="container-is-withdrawal-fee">
                                                <label class="control-label" for="title">Biaya Penarikan (%) <span class="required">*</span>
                                                </label>
                                                <input tabindex="16" id="input-withdraw-fee-percent" type="text" name="withdraw_fee_percent" class="form-control input-sm text-right percent-format" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="title">Punya Jangka Waktu? <span class="required">*</span>
                                                </label>
                                                <div style="width: 100%;">
                                                    <label class="control-label input-is-period" style="margin-right: 18px;"><input tabindex="17" type="radio" class="change-handler" checked="checked" value="0" name="is_period"> Tidak Punya</label>
                                                    <label class="control-label input-is-period" style="margin-right: 18px;"><input tabindex="17" type="radio" class="change-handler" value="1" name="is_period"> Punya</label>
                                                </div>
                                            </div>
                                            <div class="form-group" id="container-is-period">
                                                <label class="control-label" for="title">Minimal Jangka Waktu <span class="required">*</span>
                                                </label>
                                                <input tabindex="18" id="input-minimum-period" type="text" name="minimum_period" class="form-control input-sm text-right number-format-period" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="title">Bisa Melakukan Penarikan? <span class="required">*</span>
                                                </label>
                                                <div style="width: 100%;">
                                                    <label class="control-label input-is-withdrawal" style="margin-right: 18px;"><input tabindex="19" type="radio" checked="checked" value="0" name="is_withdrawal"> Tidak Bisa</label>
                                                    <label class="control-label input-is-withdrawal" style="margin-right: 18px;"><input tabindex="19" type="radio" value="1" name="is_withdrawal"> Bisa</label>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="title">Penarikan Tabungan Bisa Diwakilkan? <span class="required">*</span>
                                                </label>
                                                <div style="width: 100%;">
                                                    <label class="control-label input-is-withdrawal-represented" style="margin-right: 18px;"><input tabindex="20" type="radio" checked="checked" value="0" name="is_withdrawal_represented"> Tidak Bisa</label>
                                                    <label class="control-label input-is-withdrawal-represented" style="margin-right: 18px;"><input tabindex="20" type="radio" value="1" name="is_withdrawal_represented"> Bisa</label>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
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
                                                <label class="control-label">Ada Biaya Bulanan? <span class="required">*</span>
                                                </label>
                                                <div style="width: 100%;">
                                                    <label class="control-label input-is-monthly-adm" style="margin-right: 18px;"><input tabindex="21" type="radio" class="change-handler" checked="checked" value="0" name="is_monthly_adm_fee"> Tidak Ada</label>
                                                    <label class="control-label input-is-monthly-adm" style="margin-right: 18px;"><input tabindex="21" type="radio" class="change-handler" value="1" name="is_monthly_adm_fee"> Ada</label>
                                                </div>
                                            </div>
                                            <div class="form-group" id="container-is-monthly-adm">
                                                <label class="control-label" for="input-monthly-adm">Biaya Administrasi Bulanan <span class="required">*</span>
                                                </label>
                                                <input tabindex="22" id="input-monthly-adm" type="text" name="monthly_adm_fee" class="form-control text-right input-sm currency" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="title">Biaya Ganti Buku Habis <span class="required">*</span>
                                                </label>
                                                <input tabindex="23" id="input-book-change" type="text" name="book_change_fee" class="form-control text-right currency" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="title">Biaya Ganti Buku Hilang/Rusak <span class="required">*</span>
                                                </label>
                                                <input tabindex="24" id="input-book-lost" type="text" name="book_lost_fee" class="form-control text-right currency" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="input-open">Administrasi Buka Rekening <span class="required">*</span>
                                                </label>
                                                <input tabindex="25" id="input-open" type="text" name="open_adm_fee" class="form-control text-right currency" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="input-closing">Administrasi Tutup Rekening <span class="required">*</span>
                                                </label>
                                                <input tabindex="26" id="input-closing" type="text" name="closing_adm_fee" class="form-control text-right currency" data-validation="required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button tabindex="27" type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Simpan <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></button>
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
    
    let arrConfigBjs = {};
    
    function openModalEdit(id){
        arrConfigBjs = {};
        $('#container-config-bjs').html('');
        $('#input-deposit-min').prop('readonly', false);
        $("#input-bjs-type").val('').trigger('change', 'handler');
        $('.has-success').removeClass('has-success');
        $('.has-error').removeClass('has-error');
        ajaxRequest('common/general/product/product_saving/get_detail', 'GET', {id: id}, function(res){
            if(res.status == 200){
                let results = res.data;
                $('#form').trigger("reset");
                $('#modal .modal-title').text(`Form Ubah ${menuName}`);
                $('#form').attr('data-url', '<?php echo site_url('product/product_saving/act_update'); ?>');
                $("#modal-response-message").finish();
                
                if(results.product_saving_config_json != ""){
                    let configBjs = JSON.parse(results.product_saving_config_json);
                    if(typeof configBjs.results.bjs != "undefined"){
                        let type = configBjs.results.bjs.type;
                        arrConfigBjs = configBjs.results.bjs;
                        if(type == "nominal"){
                            $('#input-deposit-min').prop('readonly', true);
                        }
                        $("#input-bjs-type").val(type).trigger('change', 'handler');
                        appendElement(type);
                    }
                }

                $('#input-id').val(results.product_saving_id);
                $('#input-code').val(results.product_saving_code);
                $('#input-name').val(results.product_saving_name);
                $('#input-alias-name').val(results.product_saving_name_alias);
                $('#input-principal').val(number_format(results.product_saving_principal_value));
                $('#input-obligation').val(number_format(results.product_saving_obligation_value));
                $('#input-deposit-percent').val(number_format(results.product_saving_deposit_service_percent, 2));
                
                $('.input-deposit-method input[type=radio][value='+results.product_saving_deposit_service_method+']').prop('checked', true);
                
                $('#input-deposit-min').val(number_format(results.product_saving_deposit_service_min_balance));
                $('#input-deposit-initial').val(number_format(results.product_saving_initial_deposit_value));
                $('#input-min-acc-deposit').val(number_format(results.product_saving_min_acc_deposit_value));
                $('#input-open').val(number_format(results.product_saving_open_adm_fee));
                $('#input-deposit-max-acc').val(number_format(results.product_saving_max_acc_deposit_per_month_value));
                $('#input-book-change').val(number_format(results.product_saving_book_change_fee));
                $('#input-book-lost').val(number_format(results.product_saving_book_lost_fee));
                $('#input-closing').val(number_format(results.product_saving_closing_adm_fee));
                
                $('.input-is-monthly-adm input[type=radio][value='+results.product_saving_is_monthly_adm_fee+']').prop('checked', true).change();
                
                $('.input-deposit-service-is-last-balance input[type=radio][value='+results.product_saving_deposit_service_is_last_balance+']').prop('checked', true);
                
                $('#input-monthly-adm').val(number_format(results.product_saving_monthly_adm_fee));
                $('#input-min-balance').val(number_format(results.product_saving_min_balance));
                
                $('.input-is-loan-guarantee input[type=radio][value='+results.product_saving_is_loan_guarantee+']').prop('checked', true);
                
                $('.input-is-withdrawal input[type=radio][value='+results.product_saving_is_withdrawal+']').prop('checked', true);
                
                $('.input-is-withdrawal-represented input[type=radio][value='+results.product_saving_is_withdrawal_represented+']').prop('checked', true);
                
                $('.input-is-withdrawal-fee input[type=radio][value='+results.product_saving_is_withdrawal_fee+']').prop('checked', true).change();
                
                $('#input-withdraw-fee-percent').val(number_format(results.product_saving_withdraw_fee_percent, 2));
                
                $('.input-is-period input[type=radio][value='+results.product_saving_is_period+']').prop('checked', true).change();
                
                $('#input-minimum-period').val(`${number_format(results.product_saving_minimum_period)} Bulan`);
                
                $('.input-is-insured input[type=radio][value='+results.product_saving_is_insured+']').prop('checked', true);
                $('.input-is-use-registration input[type=radio][value='+results.product_saving_is_use_registration+']').prop('checked', true);
                $('.input-is-under-age input[type=radio][value='+results.product_saving_is_under_age+']').prop('checked', true);
                
                $('#modal').modal({
                    backdrop: 'static',
                    keyboard: false
                }, 'show');
            }else{
                alert(res.msg);
            }
        });
    }
    
    function addElementBjs(type){
        if(type == "nominal"){
            let indexBefore = arrConfigBjs.range.length - 1;
            let maxBefore = arrConfigBjs.range[indexBefore].max;
            
            if(maxBefore > 0){
                arrConfigBjs.range.push({
                    min: maxBefore + 1,
                    max: maxBefore + 1,
                    value: 0,
                    type: "percent"
                });
                appendElement('nominal');
            }else{
                alert("Inputkan nilai maksimal terlebih dahulu.");
            }
        }
        
        if(type == "period"){
            let indexBefore = arrConfigBjs.range.length - 1;
            let periodBefore = arrConfigBjs.range[indexBefore].period;
            
            if(periodBefore > 0){
                if(periodBefore < 6){
                    arrConfigBjs.range.push({
                        period: periodBefore + 1,
                        value: 0,
                        type: "percent"
                    });
                }else if(periodBefore == 6){
                    arrConfigBjs.range.push({
                        period: periodBefore * 2,
                        value: 0,
                        type: "percent"
                    });
                }else{
                    arrConfigBjs.range.push({
                        period: periodBefore + 12,
                        value: 0,
                        type: "percent"
                    });
                }
                appendElement('period');
            }else{
                alert("Inputkan nilai periode terlebih dahulu.");
            }
        }
    }
    
    function deleteElementBjs(index, type){
        arrConfigBjs.range.splice(index, 1);
        appendElement(type);
    }
    
    function inputMin(element){
        let value = $(element).val();
        value = convertFormatRp(value);
        
        if(value < 0){
            alert('Nilai minimal tidak boleh minus.');
            $(element).val(0);
        }else{
            arrConfigBjs.range[0].min = value;
            $('#input-deposit-min').val(number_format(value));
            if(arrConfigBjs.range[0].max == 0){
                arrConfigBjs.range[0].max == value;
                appendElement('nominal');
            }
        }
    }
    
    function inputMax(element, index){
        let value = $(element).val();
        value = convertFormatRp(value);
        
        let valueMin = arrConfigBjs.range[index].min;
        if(value < valueMin){
            alert('Nilai maksimal tidak boleh kurang dari nilai minimal.');
            arrConfigBjs.range[index].max = valueMin;
            $(element).val(number_format(valueMin));
        }else{
            arrConfigBjs.range[index].max = value;
        }
    }
    
    function inputValue(element, index){
        let value = $(element).val();
        value = convertFormatPercent(value);
        
        arrConfigBjs.range[index].value = value;
    }
    
    function inputPeriod(element, index){
        let value = $(element).val();
        value = convertFormatPeriod(value);
        
        if(index == 0){
            if(value <= 0){
                alert('Periode tidak boleh kosong.');
                arrConfigBjs.range[index].period = 6;
                $(element).val('6 Bulan');
            }else{
                arrConfigBjs.range[index].period = value;
            }
        }else{
            let indexBefore = index - 1;
            let periodBefore = arrConfigBjs.range[indexBefore].period;
            if(value < periodBefore){
                alert('Periode tidak boleh kurang dari periode sebelumnya.');
                if(periodBefore < 6){
                    arrConfigBjs.range[index].period = periodBefore + 1;
                    $(element).val(`${periodBefore} Bulan`);
                }else if(periodBefore == 6){
                    arrConfigBjs.range[index].period = periodBefore * 2;
                    $(element).val(`${periodBefore} Bulan`);
                }else{
                    arrConfigBjs.range[index].period = periodBefore + 12;
                    $(element).val(`${periodBefore} Bulan`);
                }
            }else{
                arrConfigBjs.range[index].period = value;
            }
        }
    }
    
    function appendElement(type){
        $('#container-config-bjs').html('');
        
        if(type == 'nominal'){
             if(typeof arrConfigBjs.range != 'undefined'){
                let html = "";
                let button = "";
                let disableMin = "";
                let disableMax = "";
                let disableBtn = "";
                let attrOnchange = "";
                let countRange = arrConfigBjs.range.length;
                
                arrConfigBjs.range.forEach(function (item, index){
                    disableMin = '';
                    disableMax = '';
                    disableBtn = '';
                    attrOnchange = '';
                    if(countRange > 1){
                        if(index != countRange - 1){
                            disableMin = 'readonly="readonly"';
                            disableMax = 'readonly="readonly"';
                            disableBtn = 'disabled="disabled"';
                        }else{
                            disableMin = 'readonly="readonly"';
                        }
                    }else{
                        attrOnchange = 'onchange="inputMin(this)"';
                    }
                    
                    button = `<button type="button" class="btn btn-danger btn-sm" ${disableBtn} onclick="deleteElementBjs(${index}, 'nominal')"><i class="fa fa-trash"></i>&nbsp; Hapus</button>`;
                    if(index == 0){
                        button = `<button type="button" class="btn btn-dark btn-sm" onclick="addElementBjs('nominal')"><i class="fa fa-plus"></i>&nbsp;Tambah</button>`;
                    }
                    
                    html += `
                            <div class="col-md-12 col-sm-12 col-xs-12 row">
                                <div class="form-group col-md-3 col-sm-3 col-xs-12">
                                    <label class="control-label">Minimal
                                    </label>
                                    <input type="text" class="form-control text-right bjs-currency" ${disableMin} ${attrOnchange} value="${number_format(item.min)}">
                                </div>
                                <div class="form-group col-md-3 col-sm-3 col-xs-12">
                                    <label class="control-label">Maksimal
                                    </label>
                                    <input type="text" class="form-control text-right bjs-currency" ${disableMax} onchange="inputMax(this, ${index})" value="${number_format(item.max)}">
                                </div>
                                <div class="form-group col-md-2 col-sm-2 col-xs-12">
                                    <label class="control-label">Percent (%)
                                    </label>
                                    <input type="text" class="form-control text-right bjs-percent" onchange="inputValue(this, ${index})" value="${number_format(item.value, 2)}">
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12" style="margin-top: 28px;">
                                    ${button}
                                </div>
                            </div>
                        `;
                });
                
                $('#container-config-bjs').html(html);
            }
        }
        
        if(type == 'period'){
            if(typeof arrConfigBjs.range != 'undefined'){
                let html = "";
                let button = "";
                let disablePeriod = "";
                let disableBtn = "";
                let countRange = arrConfigBjs.range.length;
                arrConfigBjs.range.forEach(function (item, index){
                    disablePeriod = "";
                    disableBtn = "";
                    if(countRange > 1){
                        if(index != countRange - 1){
                            disablePeriod = 'readonly="readonly"';
                            disableBtn = 'disabled="disabled"';
                        }
                    }
                    
                    button = `<button type="button" class="btn btn-danger btn-sm" ${disableBtn} onclick="deleteElementBjs(${index}, 'period')"><i class="fa fa-trash"></i>&nbsp; Hapus</button>`;
                    if(index == 0){
                        button = `<button type="button" class="btn btn-dark btn-sm" onclick="addElementBjs('period')"><i class="fa fa-plus"></i>&nbsp;Tambah</button>`;
                    }
                    
                    html += `
                            <div class="col-md-12 col-sm-12 col-xs-12 row">
                                <div class="form-group col-md-3 col-sm-3 col-xs-12">
                                    <label class="control-label">Periode (Bulan)
                                    </label>
                                    <input type="text" class="form-control text-right bjs-period" ${disablePeriod} onchange="inputPeriod(this, ${index})" value="${item.period} Bulan">
                                </div>
                                <div class="form-group col-md-2 col-sm-2 col-xs-12">
                                    <label class="control-label">Percent (%)
                                    </label>
                                    <input type="text" class="form-control text-right bjs-percent" onchange="inputValue(this, ${index})" value="${number_format(item.value, 2)}">
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12" style="margin-top: 28px;">
                                    ${button}
                                </div>
                            </div>
                        `;
                });
                
                $('#container-config-bjs').html(html);
            }
        }
        setNumberFormatConfigBjs();
    }
    
    function setNumberFormatConfigBjs(){
        $('.bjs-period').maskMoney({
            prefix: '',
            suffix: ' Bulan',
            allowNegative: false,
            thousands: '.',
            decimal: ',',
            affixesStay: true,
            precision: 0,
            allowZero: true
        });
        $('.bjs-percent').maskMoney({
            prefix: '',
            suffix: '',
            allowNegative: false,
            thousands: '.',
            decimal: ',',
            affixesStay: true,
            precision: 2,
            allowZero: true
        });
        $('.bjs-currency').maskMoney({
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
    
    $(document).ready(function (){
        
        $('#input-bjs-type').on('change', function(e, handler){
            if(typeof handler == "undefined"){
                let value = $(this).val();
                let valueDepositMin = $('#input-deposit-min').val();
                valueDepositMin = convertFormatRp(valueDepositMin);

                $('#input-deposit-min').prop('readonly', false);

                arrConfigBjs = {};
                if(value){
                    if(value == 'nominal'){
                        $('#input-deposit-min').prop('readonly', true);

                        arrConfigBjs = {
                            type: "nominal",
                            range: [
                                {
                                    min: valueDepositMin,
                                    max: valueDepositMin,
                                    value: 0,
                                    type: "percent"
                                }
                            ]
                        }
                    }

                    if(value == 'period'){
                        arrConfigBjs = {
                            type: "period",
                            range: [
                                {
                                    period: 6,
                                    value: 0,
                                    type: "percent"
                                }
                            ]
                        }
                    }
                }
                appendElement(value);
            }
        });
        
        $('.my-select2').select2({
            dropdownParent: $('#modal')
        });
        
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
        $('.number-format-period').maskMoney({
            prefix: '',
            suffix: ' Bulan',
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
        
        $('.change-handler').on('change', function (){
            let name = $(this).attr('name');
            let value = $(this).val();
            if(name == 'is_monthly_adm_fee'){
                if(value == 1){
                    $('#container-is-monthly-adm').show();
                }else{
                    $('#container-is-monthly-adm').hide();
                }
            }
            if(name == 'is_withdrawal_fee'){
                if(value == 1){
                    $('#container-is-withdrawal-fee').show();
                }else{
                    $('#container-is-withdrawal-fee').hide();
                }
            }
            if(name == 'is_period'){
                if(value == 1){
                    $('#container-is-period').show();
                }else{
                    $('#container-is-period').hide();
                }
            }
        });
        
        $('form').on('submit', function (e){
            e.preventDefault();
            $('form button[type="submit"]').attr('disabled', 'disabled');
            let form = this;
            $.each($(form).find('.currency'), function (index, element){
                let value = $(element).val();
                $(element).val(convertFormatRp(value));
            });
            $.each($(form).find('.number-format-period'), function (index, element){
                let value = $(element).val();
                $(element).val(convertFormatPeriod(value));
            });
            $.each($(form).find('.percent-format'), function (index, element){
                let value = $(element).val();
                $(element).val(convertFormatPercent(value));
            });
            
            let formData = new FormData(form);
            
            let strConfigBjs = "";
            if(typeof arrConfigBjs.range != "undefined"){
                strConfigBjs = JSON.stringify({bjs: arrConfigBjs});
            }
            formData.append('config_json', strConfigBjs);
            
//            for (var pair of formData.entries()) {
//                console.log(pair[0] + ', ' + pair[1]);
//            }
            
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('product/product_saving/act_update') ?>',
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
                        $.each($(form).find('.number-format-period'), function (index, element){
                            let value = $(element).val();
                            $(element).val(`${number_format(value)} Bulan`);
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
                    $.each($(form).find('.number-format-period'), function (index, element){
                        let value = $(element).val();
                        $(element).val(`${number_format(value)} Bulan`);
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
        url: siteUrl + 'product/product_saving/get_data',
        dataType: 'json',
        colModel: [
            <?php if(privilege_view('update', $this->menu_privilege)):
                echo "{display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false},";
            endif; ?>
            {display: 'Kode Produk', name: 'product_saving_code', width: 80, sortable: true, align: 'center'},
            {display: 'Nama Produk', name: 'product_saving_name', width: 300, sortable: true, align: 'left'},
            {display: 'Nama Alias', name: 'product_saving_name_alias', width: 200, sortable: true, align: 'left'},
            {display: 'Jasa Simpanan (%)', name: 'product_saving_deposit_service_percent', width: 200, sortable: true, align: 'right'},
            {display: 'Metode BJS', name: 'product_saving_deposit_service_method', width: 80, sortable: true, align: 'center'},
            {display: 'Saldo Min. BJS (Rp)', name: 'product_saving_deposit_service_min_balance', width: 200, sortable: true, align: 'right'},
            {display: 'Perhitungan BJS', name: 'product_saving_deposit_service_is_last_balance', width: 100, sortable: true, align: 'center'},
            {display: 'Setoran Awal Min. (Rp)', name: 'product_saving_initial_deposit_value', width: 200, sortable: true, align: 'right'},
            {display: 'Setoran Minimal (Rp)', name: 'product_saving_min_acc_deposit_value', width: 200, sortable: true, align: 'right'},
            {display: 'Setoran Max. Perbulan (Rp)', name: 'product_saving_max_acc_deposit_per_month_value', width: 200, sortable: true, align: 'right'},
            {display: 'Ganti Buku Habis (Rp)', name: 'product_saving_book_change_fee', width: 200, sortable: true, align: 'right'},
            {display: 'Ganti Buku Hilang/Rusak (Rp)', name: 'product_saving_book_lost_fee', width: 200, sortable: true, align: 'right'},
            {display: 'Adm. Buka Rekening (Rp)', name: 'product_saving_open_adm_fee', width: 200, sortable: true, align: 'right'},
            {display: 'Adm. Tutup Rekening (Rp)', name: 'product_saving_closing_adm_fee', width: 200, sortable: true, align: 'right'},
            {display: 'Biaya Adm. Bulanan (Rp)', name: 'product_saving_monthly_adm_fee', width: 200, sortable: true, align: 'right'},
            {display: 'Ada Biaya Bulanan?', name: 'product_saving_is_monthly_adm_fee', width: 200, sortable: true, align: 'center', hide: true},
            {display: 'Saldo Minimal (Rp)', name: 'product_saving_min_balance', width: 200, sortable: true, align: 'right'},
            {display: 'Bisa Dijadikan Jaminan?', name: 'product_saving_is_loan_guarantee', width: 200, sortable: true, align: 'center', hide: true},
            {display: 'Bisa Melakukan Penarikan?', name: 'product_saving_is_withdrawal', width: 200, sortable: true, align: 'center', hide: true},
            {display: 'Penarikan Bisa Diwakilkan?', name: 'product_saving_is_withdrawal_represented', width: 200, sortable: true, align: 'center', hide: true},
            {display: 'Biaya penarikan (%)', name: 'product_saving_withdraw_fee_percent', width: 200, sortable: true, align: 'right'},
            {display: 'Ada Biaya Penarikan?', name: 'product_saving_is_withdrawal_fee', width: 200, sortable: true, align: 'center', hide: true},
            {display: 'Punya Jangka Waktu?', name: 'product_saving_is_period', width: 200, sortable: true, align: 'center', hide: true},
            {display: 'Minimal Jangka Waktu', name: 'product_saving_min_period', width: 200, sortable: true, align: 'right'},
            {display: 'Dapat Diasuransikan?', name: 'product_saving_is_insured', width: 200, sortable: true, align: 'center', hide: true},
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
        sortname: "product_saving_id",
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
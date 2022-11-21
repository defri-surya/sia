<div class="page-title">
    <div class="title_left">
        <h3><?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div id="response_message" style="display:none;"></div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?php
        if (!empty($results)):?>
            <div class="x_panel">
                <div class="x_title">
                    <h2>Form Konfigurasi Uang Pangkal</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div style="margin-left: auto; margin-right: auto; width: 50%;">
                        <div class="row">
                            <div class="col-md-12 col-md-12 col-sm-12 col-xs-12">
                                <div id="response-message" style="display:none"></div>
                            </div>
                            <div class="form-horizontal form-label-left">
                                <div class="form-group">
                                    <label class="control-label col-lg-6 col-md-6 col-sm-6 col-xs-12" for="entrance-fee-type">Tipe Uang Pangkal
                                    </label>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <select id="entrance-fee-type" class="form-control my-select2">
                                            <?php foreach ($results as $key => $value): ?>
                                                <option value="<?php echo $value->config_entrance_fee_type; ?>"><?php echo $value->config_entrance_fee_title; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php foreach ($results as $key => $value): ?>
                        <div id="container-<?php echo $value->config_entrance_fee_type; ?>" class="container-entrance" style="<?php echo $key > 0 ? 'display:none;' : ''; ?>">
                                <form class="form-horizontal form-label-left" data-container="<?php echo $value->config_entrance_fee_type; ?>">
                                    <div class="row">
                                        <div class="col-md-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <input type="hidden" name="id" value="<?php echo $value->config_entrance_fee_id; ?>">
                                                <?php foreach ($value->config_entrance_fee_json as $index => $config): ?>
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-6 col-md-6 col-sm-6 col-xs-12"><?php echo $config->title;?> <span class="required">*</span></label>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <input tabindex="<?php echo $index+1; ?>" type="text" name="<?php echo $config->name;?>" data-title="<?php echo $config->title;?>" class="form-control my-curency text-right" data-validation="required" value="<?php echo number_format($config->value, 0, ',', '.'); ?>">
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                                <button tabindex="<?php echo count($value->config_entrance_fee_json) + 1; ?>" type="submit" class="btn btn-primary pull-right" style="margin-right: 15px;"><i class="fa fa-save"></i>&nbsp;Simpan Uang Pangkal <?php echo $value->config_entrance_fee_title; ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!--FORM VALIDATOR-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<!--MASK MONEY-->   
<script src="<?php echo THEMES_BACKEND; ?>/js/jquery.maskMoney.min.js"></script>

<script>
    var arrResults = <?php echo !empty($results) ? json_encode($results) : '[]'; ?>;
    $(document).ready(function (){
        $('.my-select2').select2();
        $('#entrance-fee-type').on('change', function (){
            $('#response-message').finish();
            let value = $(this).val();
            $('.container-entrance').hide();
            $(`#container-${value}`).show();
        });
        $('form').on('submit', function (e){
            e.preventDefault();
            $('form button[type="submit"]').attr('disabled', 'disabled');
            
            let arrConfig = [];
            let id = 0;
            $.each($(this).find('input'), function (index, element){
                let name = $(element).attr('name');
                let title = $(element).attr('data-title');
                let value = $(element).val();
                if(name != 'id'){
                    arrConfig.push({name:name, title:title, value:convertFormatRp(value)});
                }else{
                    id = value;
                }
            });
            
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('config/entrance_fee/act_update') ?>',
                data: {id: id, config_entrance_fee_json: JSON.stringify(arrConfig)},
                dataType: 'json',
                success: function (res) {
                    let message_class = '';
                    if (res.status == 200) {
                        $('form button[type="submit"]').removeAttr('disabled');
                        message_class = 'alert alert-success';

                        $("#response-message").finish();

                        $("#response-message").addClass(message_class);
                        $("#response-message").slideDown("fast");
                        $("#response-message").html(res.data);
                        $("#response-message").delay(10000).slideUp(1000, function () {
                            $("#response-message").removeClass(message_class);
                        });

                    } else {
                        $('form button[type="submit"]').removeAttr('disabled');
                        message_class = 'alert alert-danger';
                        $("#response-message").finish();
                        
                        $("#response-message").addClass(message_class);
                        $("#response-message").slideDown("fast");
                        $("#response-message").html(res.msg);
                        $("#response-message").delay(10000).slideUp(1000, function (){
                            $("#response-message").removeClass(message_class);
                        });
                    }
                },
                error: function (err) {
                    $('#form button[type="submit"]').removeAttr('disabled');
                }
            });
        });
        
        $('.my-curency').maskMoney({
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
    
    // for convert format Rp in integer
    function convertFormatRp(currency) {
        let value = currency.replace('Rp. ', '');
        return parseInt(value.replace(/\./g, ''));
    }
    
    $.validate({
        modules: 'logic',
        lang: 'id'
    });
</script>
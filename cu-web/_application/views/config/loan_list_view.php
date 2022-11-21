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
        if (!empty($results)) : ?>
            <div class="x_panel">
                <div class="x_title">
                    <h2>Form Konfigurasi Pinjaman</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form class="form-horizontal form-label-left">
                        <input type="hidden" name="id" value="<?php echo $results->config_id; ?>">
                        <input type="hidden" name="name" value="<?php echo $results->config_name; ?>">
                        <div class="row">
                            <div class="form-group">
                                <label class="control-label col-lg-6 col-md-6 col-sm-6 col-xs-12">Maksimal Plafon <span class="required">*</span></label>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="" class="form-control my-curency text-right" data-validation="required" value="<?php echo number_format($results->config_json->loan->max_plafon, 0, ',', '.'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-6 col-md-6 col-sm-6 col-xs-12">Maksimal Pinjaman <span class="required">*</span></label>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="" class="form-control my-curency text-right" data-validation="required" value="<?php echo number_format($results->config_json->loan->max_loan_item, 0, ',', '.'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-6 col-md-6 col-sm-6 col-xs-12">Jenis Persetujuan <span class="required">*</span></label>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control my-select2">
                                        <option value="single">Satu Orang</option>
                                        <option value="all">Semua</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-6 col-md-6 col-sm-6 col-xs-12">Maksimal Persetujuan Plafon <span class="required">*</span></label>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="" class="form-control my-curency text-right" data-validation="required" value="<?php echo number_format($results->config_json->approval[0]->plafon_maximal, 0, ',', '.'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-6 col-md-6 col-sm-6 col-xs-12">Minimal Persetujuan Plafon <span class="required">*</span></label>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="" class="form-control my-curency text-right" data-validation="required" value="<?php echo number_format($results->config_json->approval[0]->plafon_minimal, 0, ',', '.'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-6 col-md-6 col-sm-6 col-xs-12">Nama User <span class="required">*</span></label>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control select-user my-select2" multiple="multiple">
                                        <option value="1">1</option>
                                        <!-- <option value="2">2</option>
                                        <option value="3">3</option> -->
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
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
    $(document).ready(function() {
        $('.my-select2').select2();

        $('.select-user').on('select2:close', function() {
            $('.select-user').html();
        });
    });
</script>
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

<!-- Modal Choose Product-->
<div id="modal-choose-saving" class="modal fade" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Buka Simpanan</h4>
            </div>
            <form id="form-choose-saving" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body" style="overflow-y: auto; max-height: calc(100vh - 200px)">
                    <div id="modal-response-message-choose-saving" class="alert alert-danger alert-dismissible fade in" style="display:none"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Data Simpanan Baru</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <input type="hidden" name="member_id" id="saving-member-id" value="0">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <?php if ($is_superuser || $user_group == "administrator_company"): ?>
                                                <div class="form-group">
                                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-branch-id">Unit <span class="required">*</span>
                                                    </label>
                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                        <select id="saving-branch-name" class="form-control my-select2" data-validation="required">
                                                            <option value="">--Pilih Unit--</option>
                                                            <?php if (is_array($arr_list_branch) && !empty($arr_list_branch)): ?>
                                                                <?php foreach ($arr_list_branch as $row): ?>
                                                                    <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name; ?></option>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </select>
                                                        <input type="hidden" name="branch_id" id="saving-branch-id" value="0">
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <input type="hidden" name="branch_id" value="<?php echo $_SESSION['administrator_group_branch_id']; ?>">
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-code">No. Anggota
                                                </label>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                    <input type="text" name="member_code" id="saving-member-code" class="form-control" readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Simpanan <span class="required">*</span>
                                                </label>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                    <select tabindex="1" name="product_saving_id" id="saving-name" class="form-control my-select2" data-validation="required">
                                                        <option value="">--Pilih Simpanan--</option>
                                                        <?php if (is_array($arr_list_product_saving) && !empty($arr_list_product_saving)): ?>
                                                            <?php foreach ($arr_list_product_saving as $row): ?>
                                                                <option value="<?php echo $row->product_saving_id; ?>" data-is-period="<?php echo $row->product_saving_is_period; ?>" data-initial-deposit="<?php echo $row->product_saving_initial_deposit_value; ?>"><?php echo $row->product_saving_name . ' ('. $row->product_saving_code .')'; ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
<!--                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-initial-deposit">Setoran Awal
                                                </label>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                    <input type="text" name="initial_deposit" id="saving-initial-deposit" readonly="readonly" class="form-control text-right">
                                                </div>
                                            </div>
                                        </div>-->
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="container-period">
                                            <div class="form-group">
                                                <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-period">Jangka Waktu
                                                </label>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                    <input tabindex="2" type="text" name="saving_period" id="saving-period" class="form-control period-format text-right">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Data Pribadi Anggota</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-name">Nama Lengkap
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="3" type="text" name="name" id="saving-member-name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-gender">Jenis Kelamin
                                            </label>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <label class="control-label saving-member-gender" style="margin-right: 25px;"><input tabindex="4" type="radio" checked="checked" value="0" name="gender"> Pria</label>
                                                <label class="control-label saving-member-gender" style="margin-right: 25px;"><input tabindex="4" type="radio" value="1" name="gender"> Wanita</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Tempat/Tanggal Lahir
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input tabindex="5" type="text" name="birthplace" id="saving-member-birthplace" class="form-control" placeholder="Tempat Lahir">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <input data-inputmask="'alias': 'date'" tabindex="6" type="text" name="birthdate" id="saving-member-birthdate" class="form-control" placeholder="dd/mm/yyyy">
                                            </div>
                                        </div>
                                        <div class="form-group member-young">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-address">Alamat
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="7" type="text" name="address" id="saving-member-address" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group member-young">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-school-name">Nama Sekolah
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="8" type="text" name="member_school_name" id="saving-member-school-name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group member-young">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-class-at-school">Kelas
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="9" type="text" name="class_at_school" id="saving-member-class-at-school" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group member-young">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-school-address">Alamat Sekolah
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="10" type="text" name="school_address" id="saving-member-school-address" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group member-adult">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-mother-name">Nama Ibu Kandung
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="11" type="text" name="mother_name" id="saving-member-mother-name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group member-adult">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-phone">No. Telp/HP/WA
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="12" type="text" name="mobilephone_number" id="saving-member-phone" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group member-adult">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-code">Jenis Identitas
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <label class="control-label saving-member-id-type" style="margin-right: 25px;"><input tabindex="13" type="radio" checked="checked" value="0" name="identity_type"> KTP</label>
                                                <label class="control-label saving-member-id-type" style="margin-right: 25px;"><input tabindex="13" type="radio" value="1" name="identity_type"> KK</label>
                                                <label class="control-label saving-member-id-type" style="margin-right: 25px;"><input tabindex="13" type="radio" value="2" name="identity_type"> SIM</label>
                                                <label class="control-label saving-member-id-type" style="margin-right: 25px;"><input tabindex="13" type="radio" value="3" name="identity_type"> KIA/KTM</label>
                                                <label class="control-label saving-member-id-type" style="margin-right: 25px;"><input tabindex="13" type="radio" value="4" name="identity_type"> Passport</label>
                                                <label class="control-label saving-member-id-type" style="margin-right: 25px;"><input tabindex="13" type="radio" value="5" name="identity_type"> Lainnya</label>
                                            </div>
                                        </div>
                                        <div class="form-group member-adult">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-id-number">No. Identitas
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="14" type="text" name="identity_number" id="saving-member-id-number" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group member-adult">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-taxpayer-number">No. NPWP
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="15" type="text" name="taxpayer_number" id="saving-member-taxpayer-number" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group member-adult">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-kk-number">No. KK
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="16" type="text" name="kk_number" id="saving-member-kk-number" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="x_panel member-young">
                                <div class="x_title">
                                    <h2>Data Keluarga Anggota</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-father-name">Nama Ayah
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="17" type="text" name="father_name" id="saving-member-father-name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-mother-name-young">Nama Ibu
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="18" type="text" name="mother_name" id="saving-member-mother-name-young" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-family-address">Alamat
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="19" type="text" name="family_address" id="saving-family-address" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-family-phone">No. Telp
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="20" type="text" name="family_phone_number" id="saving-member-family-phone" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-siblings">Jumlah Saudara
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="21" type="text" name="number_of_siblings" id="saving-member-siblings" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button tabindex="22" type="submit" class="btn btn-primary hide-on-detail"><i class="fa fa-save"></i>&nbsp; Buka Simpanan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end Modal Choose Product-->

<!--FORM VALIDATOR-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<!--MASK MONEY-->   
<script src="<?php echo THEMES_BACKEND; ?>/js/jquery.maskMoney.min.js"></script>

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    
    function openModalSaving(com, grid, urlaction){
        if ($('.trSelected', grid).length > 0) {
            let id = $('.trSelected', grid).attr('data-id');
            ajaxRequest('common/general/membership/member/get_detail', 'GET', {id: id}, function (res){
                if(res.status == 200){
                    let data = res.data;
                    $('#container-period').hide();
                    $('#form-choose-saving').trigger('reset');
                    
                    $('#saving-branch-name').val('').change();
                    $('#saving-name').val('').change();
                    $('#saving-period').val('0 Bulan');
                    
                    $("#form-choose-saving").attr('data-url', siteUrl + 'membership/open_saving/act_add_saving');
                    $('.member-adult, .member-young').hide();
        
                    $('span.form-error').remove();
                    $('.has-success').removeClass('has-success');
                    $('.has-error').removeClass('has-error');
                    $('.valid .error').removeClass('valid error').css('border-color', '');

                    $('#modal-choose-saving .modal-body').animate({scrollTop: '0px'}, 300);

                    $("#saving-member-id").val(data.member_id);
                    
                    let yearBirthdate = moment(data.member_birthdate).year();
                    let memberAge = moment().diff(yearBirthdate, 'years', false);

                    if(parseInt(memberAge) >= 17){
                        $('#saving-member-mother-name').val(data.member_mother_name);
                        $('.member-adult').show();
                        $('.saving-type-1').show();
                        $('.saving-type-1 input[value=1]').prop('checked', true);
                    }else{
                        $('#saving-member-mother-name-young').val(data.member_mother_name);
                        $('#saving-member-address').val(data.member_address);
                        $('.member-young').show();
                        $('.saving-type-2').show();
                        $('.saving-type-2 input[value=4]').prop('checked', true);
                    }
                    $('#saving-branch-name').val(data.branch_id).change();
                    $('#saving-branch-id').val(data.branch_id);
                    $('#saving-date').val('');
                    $('#saving-member-code').val(data.member_code);

                    $('#saving-member-name').val(data.member_name);

                    $('.saving-member-gender input[type=radio][value='+data.member_gender+']').prop('checked', true);

                    $('#saving-member-birthplace').val(data.member_birthplace);
                    if(data.member_birthdate != '' && data.member_birthdate != null && data.member_birthdate != '0000-00-00'){
                        $('#saving-member-birthdate').val(moment(data.member_birthdate).format('DD/MM/YYYY'));
                    }else{
                        $('#saving-member-birthdate').val('');
                    }

                    $('#saving-member-phone').val(data.member_mobilephone_number);

                    $('.saving-member-id-type input[type=radio][value='+data.member_identity_type+']').prop('checked', true);

                    $('#saving-member-id-number').val(data.member_identity_number);
                    $('#saving-member-taxpayer-number').val('');
                    $('#saving-member-kk-number').val('');

                    $('#modal-choose-saving').modal({
                        backdrop: 'static',
                        keyboard: false
                    }, 'show');
                }else{
                    alert('Gagal mendapatkan data.');
                }
            });
        }else{
            alert('Anda belum memilih anggota.')
        }
    }
    
    $(document).ready(function(){
        $('.my-select2').select2();
        
      
        
        $('#saving-name').on('change', function (){
            $('#container-period').hide();
            let value = $(this).val();
            if(value){
                let initialDeposit = $(this).find(`option[value=${value}]`).attr('data-initial-deposit');
                let isPeriod = $(this).find(`option[value=${value}]`).attr('data-is-period');
                if(isPeriod == 1){
                    $('#container-period').show();
                }
//                $('#saving-initial-deposit').val(number_format(initialDeposit));
            }
        });
        
        $('#form-choose-saving').on('submit', function (e) {
            e.preventDefault();
            $('#form-choose-saving button[type="submit"]').attr('disabled', 'disabled');
            let urlForm = $(this).attr('data-url');

            let formData = new FormData(this);

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
                        $('#modal-choose-saving').modal('hide');
                        $('#form-choose-saving button[type="submit"]').removeAttr('disabled');
                        $('#gridview').flexReload();
                        let message_class = 'response_confirmation alert alert-success';

                        $("#response_message").finish();

                        $("#response_message").addClass(message_class);
                        $("#response_message").slideDown("fast");
                        $("#response_message").html(res.data);
                        $("#response_message").delay(10000).slideUp(1000, function () {
                            $("#response_message").removeClass(message_class);
                        });
                    } else {
                        $('#modal-choose-saving .modal-body').animate({scrollTop: '0px'}, 300);
                        $('#form-choose-saving button[type="submit"]').removeAttr('disabled');
                        $("#modal-response-message-choose-saving").finish();

                        $("#modal-response-message-choose-saving").slideDown("fast");
                        $('#modal-response-message-choose-saving').html(res.msg);
                        $("#modal-response-message-choose-saving").delay(10000).slideUp(1000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#form-choose-saving button[type="submit"]').removeAttr('disabled');
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });
    });
    
    $("#gridview").flexigrid({
        url: siteUrl + 'membership/open_saving/get_data',
        dataType: 'json',
        colModel: [
            {display: 'No. Anggota', name: 'member_product_saving_member_code', width: 80, sortable: true, align: 'center'},
            {display: 'Nama Anggota', name: 'member_name', width: 300, sortable: true, align: 'left'},
            {display: 'Status Blokir', name: 'member_product_saving_is_blocked', width: 100, sortable: true, align: 'center'},
            {display: 'Status Aktif', name: 'member_product_saving_is_active', width: 100, sortable: true, align: 'center'},
            {display: 'No. Rekening', name: 'member_product_saving_account_number', width: 120, sortable: true, align: 'center'},
            {display: 'Saldo (Rp)', name: 'member_product_saving_member_balance', width: 120, sortable: true, align: 'right'},
            {display: 'Nama Simpanan', name: 'member_product_saving_name', width: 350, sortable: true, align: 'left'},
            {display: 'Nama Alias Simpanan', name: 'member_product_saving_name_alias', width: 200, sortable: true, align: 'left'},
            {display: 'Jangka Waktu', name: 'member_product_saving_period', width: 80, sortable: true, align: 'center'},
        ],
        buttons: [
            <?php
            if (privilege_view('add', $this->menu_privilege)):
                echo "
                    {display: 'Buka Simpanan', name: 'payment', bclass: 'accounting', onpress: openModalSaving},
                    ";
            endif;
            ?>
        ],
        buttons_right: [
            <?php
            if (privilege_view('export', $this->menu_privilege)):
                echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("membership/open_saving/export_data_saving") . "'}";
            endif;
            ?>
        ],
        searchitems: [
            {display: 'No. Anggota', name: 'member_product_saving_member_code', type: 'text'},
            {display: 'Nama Anggota', name: 'member_name', type: 'text'},
            {display: 'No. Rekening', name: 'member_product_saving_account_number', type: 'num'},
            {display: 'Saldo (Rp)', name: 'member_product_saving_member_balance', type: 'num'},
            {display: 'Nama Simpanan', name: 'member_product_saving_name', type: 'text'},
            {display: 'Nama Alias Simpanan', name: 'member_product_saving_name_alias', type: 'date'},
            {display: 'Jangka Waktu', name: 'member_product_saving_period', type: 'text'},
            {display: 'Status Blokir', name: 'member_product_saving_is_blocked', type: 'text'},
            {display: 'Status Aktif', name: 'member_product_saving_is_active', type: 'text'},
        ],
        sortname: "member_product_saving_id",
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
    
    // function arrayColumn
    function arrayColumn(array, columnName) {
        return array.map(function(value,index) {
            return value[columnName];
        });
    }
    
    $('.period-format').maskMoney({
        prefix: '',
        suffix: ' Bulan',
        allowNegative: false,
        thousands: '.',
        decimal: ',',
        affixesStay: true,
        precision: 0,
        allowZero: true
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
    
    function readURL(input, element) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(element).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $.validate({
        modules: 'logic, file, security',
        lang: 'id',
        onError: function(){
            $('#modal-edit .modal-body').animate({scrollTop: '0px'}, 300);
        }
    });
</script>

<!-- FORM INPUTMASK -->
<script src="<?php echo THEMES_BACKEND; ?>/js/jquery.inputmask.bundle.js"></script>
<script>
      $("#saving-member-birthdate").inputmask({
            format: 'DD/MM/YYYY'
        });
</script>
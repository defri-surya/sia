<style>
    .input-sm+span.select2-container--default span.select2-selection--single {
        height: 30px !important;
        min-height: 30px !important;
    }

    .input-sm+span.select2-container--default span.select2-selection--single span.select2-selection__arrow {
        height: 30px !important;
    }

    .input-sm+span.select2-container--default span.select2-selection--single span.select2-selection__rendered {
        line-height: 24px !important;
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

    .color-1 .form-group:nth-child(even) {
        background: #E6E6FA;
        padding: 5px;
    }

    .color-1 .form-group:nth-child(odd) {
        background-color: #fff;
    }
</style>
<div class="page-title">
    <div class="title_left">
        <!--<h3><?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></h3>-->
        <h3>Calon Anggota</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div id="response_message" style="display:none;"></div>
        <table id="gridview" style="display:none;"></table>
    </div>
</div>

<!-- Modal Registration-->
<div id="modal-registration" class="modal" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Registrasi Anggota</h4>
            </div>
            <form id="form-member" class="form-horizontal form-label-left " data-url="">
                <div class="modal-body" style="overflow-y: auto; height: calc(100vh - 200px)">
                    <div id="modal-response-message-registration" class="alert alert-danger alert-dismissible fade in" style="display:none"></div>
                    <div class="row">

                        <?php if ($is_superuser || $user_group == "administrator_company") : ?>

                            <!-- nav-tab -->

                            <ul id="container-tabs" class="nav nav-tabs" style="margin-left: 5px;">
                                <li class="active"><a data-toggle="tab" href="#data">Data Diri</a></li>
                                <li><a data-toggle="tab" href="#pk">Pekerjaan & Pendidikan</a></li>
                                <li><a data-toggle="tab" href="#tambah">Info Tambahan</a></li>

                            </ul>

                            <!-- tab-content -->

                            <div class="tab-content">
                                <div id="data" class="tab-pane fade in active color-1">
                                    <!-- form-group-data_diri-->
                                    <div class="form-group" style="margin-top: 8px;">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="branch-id">Unit <span class="required">*</span>
                                        </label>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <select tabindex="1" name="branch_id" id="branch-id" class="form-control my-select2 input-sm" data-validation="required">
                                                <option value="">--Pilih Unit--</option>
                                                <?php if (is_array($arr_list_branch) && !empty($arr_list_branch)) : ?>
                                                    <?php foreach ($arr_list_branch as $row) : ?>
                                                        <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name; ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>

                                <?php else : ?>
                                    <input type="hidden" name="branch_id" value="<?php echo $_SESSION['administrator_group_branch_id']; ?>">
                                <?php endif; ?>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-join-date">Tanggal Bergabung <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <input tabindex="2" type="text" name="join_datetime" id="member-join-date" class="form-control input-sm" placeholder="dd/mm/yyyy" readonly="readonly" style="background-color: #fff;" value="" data-validation="required">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-name">Nama Pemohon <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <input tabindex="3" type="text" name="name" id="member-name" class="form-control input-sm" data-validation="required" placeholder="Nama Pemohon, sesuai dengan KTP/SIM/Ijazah" value="Deddy Corbuzier">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-recomendation">Rekomendasi
                                    </label>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <input type="hidden" id="member-refferal-id" value="0">
                                        <textarea class="form-control" name="referal_member_id" id="member-recomendation"></textarea>
                                    </div>
                                </div>

                                <div class="form-group" style="margin-bottom: 5px;">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-obligation">Simpanan Wajib <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-bottom: 5px;">
                                        <input type="text" name="saving_obligation" id="saving-obligation" class="form-control input-sm currency text-right" value="20.000" data-validation="required">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-id-type">Identitas <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <select tabindex="4" name="identity_type" id="member-id-type" class="form-control my-select2 input-sm" data-validation="required">
                                            <option value="0">NIK</option>
                                            <option value="1">Passport</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                        <input tabindex="5" type="text" name="identity_number" id="member-id-number" class="form-control input-sm" placeholder="Nomor NIK/PASSPORT yang masih berlaku" value="3306124403910302" data-validation="required">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-kk-number">No. KK
                                    </label>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" name="nik_number" id="member-nik-number" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-mother-name">Ibu Kandung <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <input tabindex="40" type="text" name="mother_name" id="member-mother-name" class="form-control input-sm" placeholder="Nama Ibu Kandung" value="Awiek Lestari Rahayu" data-validation="required">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Jenis Kelamin
                                    </label>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <label class="control-label member-gender" style="margin-right: 25px;"><input tabindex="6" type="radio" checked="checked" value="0" name="gender"> Laki-laki</label>
                                        <label class="control-label member-gender" style="margin-right: 25px;"><input tabindex="6" type="radio" value="1" name="gender"> Perempuan</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-birthplace">Tempat, Tanggal Lahir <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                        <input tabindex="7" type="text" name="birthplace" id="member-birthplace" class="form-control input-sm" placeholder="Tempat lahir" value="Yogyakarta" data-validation="required">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <input data-inputmask="'alias': 'date'" tabindex="8" type="text" name="birthdate" id="member-birthdate" class="form-control input-sm" placeholder="Tgl/Bln/Thn" data-validation="required" style="background-color: #fff;" value="22/05/1986" data-validation="required">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Kewarganegaraan
                                    </label>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <label class="control-label member-nationality" style="margin-right: 25px;"><input tabindex="9" type="radio" checked="checked" value="0" name="nationality"> WNI</label>
                                        <label class="control-label member-nationality" style="margin-right: 25px;"><input tabindex="9" type="radio" value="1" name="nationality"> WNA</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-address">Alamat Lengkap
                                    </label>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="margin-bottom: 5px;">
                                        <input tabindex="10" type="text" name="address" id="member-address" class="form-control input-sm" placeholder="Alamat lengkap, sesuai dengan identitas" value="Jl. Balirejo I No.28, Banguntapan, Bantul, D.I. Yogyakarta">
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="margin-bottom: 5px;">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <select tabindex="11" name="province" id="member-province" class="form-control my-select2 input-sm" data-validation="">
                                                    <option value="">--Pilih Provinsi--</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <select tabindex="12" name="city" id="member-city" class="form-control my-select2 input-sm" data-validation="">
                                                    <option value="">--Pilih Kota/Kab--</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="margin-bottom: 5px;">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <select tabindex="13" name="subdistrict" id="member-subdistrict" class="form-control my-select2 input-sm" data-validation="">
                                                    <option value="">--Pilih Kecamatan--</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <select tabindex="14" name="kelurahan" id="member-kelurahan" class="form-control my-select2 input-sm" data-validation="">
                                                    <option value="">--Pilih Kelurahan--</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="margin-bottom: 5px;">
                                        <input tabindex="15" type="text" name="rt_number" id="member-rt" class="form-control input-sm" placeholder="RT" value="4" data-validation="number" data-validation-optional="true">
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <input tabindex="16" type="text" name="rw_number" id="member-rw" class="form-control input-sm" placeholder="RW" value="5" data-validation="number" data-validation-optional="true">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-right">
                                        <input tabindex="17" type="text" name="zipcode" id="member-zipcode" class="form-control input-sm" placeholder="Kode Pos" value="55431" data-validation="number" data-validation-optional="true">
                                    </div>
                                </div>

                                <div class="form-group" style="margin-bottom: 5px;">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-address-domicile">Alamat Domisili
                                    </label>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="margin-bottom: 5px;">
                                        <input tabindex="18" type="text" name="address_domicile" id="member-address-domicile" class="form-control input-sm" placeholder="Alamat domisili" value="Jl. Balirejo I No.28">
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="margin-bottom: 5px;">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <select tabindex="19" name="domicile_province" id="member-domicile-province" class="form-control my-select2 input-sm" data-validation="">
                                                    <option value="">--Pilih Provinsi--</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <select tabindex="20" name="domicile_city" id="member-domicile-city" class="form-control my-select2 input-sm" data-validation="">
                                                    <option value="">--Pilih Kota/Kab--</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="margin-bottom: 5px;">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <select tabindex="21" name="domicile_subdistrict" id="member-domicile-subdistrict" class="form-control my-select2 input-sm" data-validation="">
                                                    <option value="">--Pilih Kecamatan--</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <select tabindex="22" name="domicile_kelurahan" id="member-domicile-kelurahan" class="form-control my-select2 input-sm" data-validation="">
                                                    <option value="">--Pilih Kelurahan--</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="margin-bottom: 5px;">
                                        <input tabindex="23" type="text" name="domicile_rt_number" id="member-domicile-rt" class="form-control input-sm" placeholder="RT" value="4">
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <input tabindex="24" type="text" name="domicile_rw_number" id="member-domicile-rw" class="form-control input-sm" placeholder="RW" value="5">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-right">
                                        <input tabindex="25" type="text" name="domicile_zipcode" id="member-domicile-zipcode" class="form-control input-sm" placeholder="Kode Pos" value="55431">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Status Tempat Tinggal
                                    </label>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <label class="control-label member-residence-status" style="margin-right: 25px;"><input tabindex="26" type="radio" checked="checked" value="0" name="residence_status"> Tidak Diisi</label>
                                        <label class="control-label member-residence-status" style="margin-right: 25px;"><input tabindex="26" type="radio" value="1" name="residence_status"> Milik Sendiri</label>
                                        <label class="control-label member-residence-status" style="margin-right: 25px;"><input tabindex="26" type="radio" value="2" name="residence_status"> Sewa/Kontrak</label>
                                        <label class="control-label member-residence-status" style="margin-right: 25px;"><input tabindex="26" type="radio" value="3" name="residence_status"> Menumpang</label>
                                        <label class="control-label member-residence-status" style="margin-right: 25px;"><input tabindex="26" type="radio" value="4" name="residence_status"> Ikut Orang Tua</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-phone">Nomor Telepon
                                    </label>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <input tabindex="27" type="text" name="phone_number" id="member-phone" class="form-control input-sm" placeholder="Telepon Rumah/Kantor" value="0281998675" data-validation="number" data-validation-optional-if-answered="phone_number, mobilephone_number">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <input tabindex="28" type="text" name="mobilephone_number" id="member-mobilephone" class="form-control input-sm" placeholder="Handphone" value="08123456789" data-validation="number" data-validation-optional-if-answered="phone_number, mobilephone_number">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Agama
                                    </label>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <label class="control-label member-religion" style="margin-right: 25px;"><input tabindex="33" type="radio" checked="checked" value="0" name="religion"> Tidak Diisi</label>
                                        <label class="control-label member-religion" style="margin-right: 25px;"><input tabindex="33" type="radio" value="1" name="religion"> Islam</label>
                                        <label class="control-label member-religion" style="margin-right: 25px;"><input tabindex="33" type="radio" value="2" name="religion"> Katolik</label>
                                        <label class="control-label member-religion" style="margin-right: 25px;"><input tabindex="33" type="radio" value="3" name="religion"> Kristen</label>
                                        <label class="control-label member-religion" style="margin-right: 25px;"><input tabindex="33" type="radio" value="4" name="religion"> Hindu</label>
                                        <label class="control-label member-religion" style="margin-right: 25px;"><input tabindex="33" type="radio" value="5" name="religion"> Budha</label>
                                        <label class="control-label member-religion" style="margin-right: 25px;"><input tabindex="33" type="radio" value="6" name="religion"> Kong Hu Cu</label>
                                        <label class="control-label member-religion" style="margin-right: 25px;"><input tabindex="33" type="radio" value="7" name="religion"> Aliran Kepercayaan</label>
                                        <label class="control-label member-religion" style="margin-right: 25px;"><input tabindex="33" type="radio" value="8" name="religion"> Lainnya</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Golongan Darah
                                    </label>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <label class="control-label member-blood-type" style="margin-right: 25px;"><input tabindex="35" type="radio" checked="checked" value="0" name="blood_type"> Tidak Diisi</label>
                                        <label class="control-label member-blood-type" style="margin-right: 25px;"><input tabindex="35" type="radio" value="1" name="blood_type"> A</label>
                                        <label class="control-label member-blood-type" style="margin-right: 25px;"><input tabindex="35" type="radio" value="2" name="blood_type"> B</label>
                                        <label class="control-label member-blood-type" style="margin-right: 25px;"><input tabindex="35" type="radio" value="3" name="blood_type"> AB</label>
                                        <label class="control-label member-blood-type" style="margin-right: 25px;"><input tabindex="35" type="radio" value="4" name="blood_type"> O</label>
                                    </div>
                                </div>
                                </div>
                                <div id="pk" class="tab-pane fade color-1">
                                    <div class="form-group" style="margin-bottom: 5px;">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Pekerjaan
                                        </label>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            <label class="control-label member-job" style="margin-right: 25px;"><input tabindex="29" type="radio" class="change-handler" checked="checked" value="Tidak Bekerja" name="job"> Tidak Bekerja</label>
                                            <label class="control-label member-job" style="margin-right: 25px;"><input tabindex="29" type="radio" class="change-handler" value="Petani" name="job"> Petani</label>
                                            <label class="control-label member-job" style="margin-right: 25px;"><input tabindex="29" type="radio" class="change-handler" value="PNS" name="job"> PNS</label>
                                            <label class="control-label member-job" style="margin-right: 25px;"><input tabindex="29" type="radio" class="change-handler" value="Swasta/Karyawan" name="job"> Swasta/Karyawan</label>
                                            <label class="control-label member-job" style="margin-right: 25px;"><input tabindex="29" type="radio" class="change-handler" value="Pengacara" name="job"> Pengacara</label>
                                            <label class="control-label member-job" style="margin-right: 25px;"><input tabindex="29" type="radio" class="change-handler" value="Dokter" name="job"> Dokter</label>
                                            <label class="control-label member-job" style="margin-right: 25px;"><input tabindex="29" type="radio" class="change-handler" value="Buruh Kasar" name="job"> Buruh Kasar</label>
                                            <label class="control-label member-job" style="margin-right: 25px;"><input tabindex="29" type="radio" class="change-handler" value="Guru" name="job"> Guru</label>
                                            <label class="control-label member-job" style="margin-right: 25px;"><input tabindex="29" type="radio" class="change-handler" value="Ibu Rumah Tangga" name="job"> Ibu Rumah Tangga</label>
                                            <label class="control-label member-job" style="margin-right: 25px;"><input tabindex="29" type="radio" class="change-handler" value="Lain-lain" name="job"> Lain-lain</label>
                                            <input type="text" id="container-job-other" class="form-control input-sm" placeholder="Lain-lain" style="width: 200px; display: inline">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Detail Pekerjaan
                                        </label>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                            <textarea name="job_detail" id="member-job-detail" class="form-control" maxlength="250" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Bekerja di
                                        </label>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            <label class="control-label member-working-in" style="margin-right: 25px;"><input tabindex="30" type="radio" checked="checked" value="0" name="working_in"> Indonesia</label>
                                            <label class="control-label member-working-in" style="margin-right: 25px;"><input tabindex="30" type="radio" value="1" name="working_in"> Luar Negeri</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Penghasilan Rata2 Per Bulan
                                        </label>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            <label class="control-label member-income" style="margin-right: 25px;"><input tabindex="31" type="radio" checked="checked" value="0" name="average_income"> Belum Perpenghasilan</label>
                                            <label class="control-label member-income" style="margin-right: 25px;"><input tabindex="31" type="radio" value="1" name="average_income">
                                                < 1 Juta</label>
                                                    <label class="control-label member-income" style="margin-right: 25px;"><input tabindex="31" type="radio" value="2" name="average_income"> 1 Juta - 3 Juta</label>
                                                    <label class="control-label member-income" style="margin-right: 25px;"><input tabindex="31" type="radio" value="3" name="average_income"> 3 Juta - 5 Juta</label>
                                                    <label class="control-label member-income" style="margin-right: 25px;"><input tabindex="31" type="radio" value="4" name="average_income"> 5 Juta - 10 Juta</label>
                                                    <label class="control-label member-income" style="margin-right: 25px;"><input tabindex="31" type="radio" value="5" name="average_income"> > 10 Juta</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Pendidikan Terakhir
                                        </label>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            <label class="control-label member-last-education" style="margin-right: 18px;"><input tabindex="32" type="radio" checked="checked" value="0" name="last_education"> Tidak Sekolah</label>
                                            <label class="control-label member-last-education" style="margin-right: 18px;"><input tabindex="32" type="radio" value="1" name="last_education"> SD</label>
                                            <label class="control-label member-last-education" style="margin-right: 18px;"><input tabindex="32" type="radio" value="2" name="last_education"> SLTP</label>
                                            <label class="control-label member-last-education" style="margin-right: 18px;"><input tabindex="32" type="radio" value="3" name="last_education"> SMU/SMK</label>
                                            <label class="control-label member-last-education" style="margin-right: 18px;"><input tabindex="32" type="radio" value="4" name="last_education"> Diploma 1,2,3</label>
                                            <label class="control-label member-last-education" style="margin-right: 18px;"><input tabindex="32" type="radio" value="5" name="last_education"> S1</label>
                                            <label class="control-label member-last-education" style="margin-right: 18px;"><input tabindex="32" type="radio" value="6" name="last_education"> S2</label>
                                            <label class="control-label member-last-education" style="margin-right: 18px;"><input tabindex="32" type="radio" value="7" name="last_education"> S3</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="tambah" class="tab-pane fade color-1">
                                    <div class="form-group" style="margin-top: 8px;">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-ethnic-group">Nama Suku
                                        </label>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            <input tabindex="34" type="text" name="ethnic_group" id="member-ethnic-group" class="form-control input-sm" placeholder="Nama Suku" value="Jawa">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Ukuran Baju
                                        </label>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            <label class="control-label member-shirt-size" style="margin-right: 25px;"><input tabindex="36" type="radio" checked="checked" value="0" name="shirt_size"> Tidak Diisi</label>
                                            <label class="control-label member-shirt-size" style="margin-right: 25px;"><input tabindex="36" type="radio" value="1" name="shirt_size"> S</label>
                                            <label class="control-label member-shirt-size" style="margin-right: 25px;"><input tabindex="36" type="radio" value="2" name="shirt_size"> M</label>
                                            <label class="control-label member-shirt-size" style="margin-right: 25px;"><input tabindex="36" type="radio" value="3" name="shirt_size"> L</label>
                                            <label class="control-label member-shirt-size" style="margin-right: 25px;"><input tabindex="36" type="radio" value="4" name="shirt_size"> XL</label>
                                            <label class="control-label member-shirt-size" style="margin-right: 25px;"><input tabindex="36" type="radio" value="5" name="shirt_size"> XXL</label>
                                            <label class="control-label member-shirt-size" style="margin-right: 25px;"><input tabindex="36" type="radio" value="6" name="shirt_size"> XXXL</label>

                                            <label class="control-label member-shirt-size" style="margin-right: 25px;"><input tabindex="36" type="radio" value="7" name="shirt_size"> SA</label>
                                            <label class="control-label member-shirt-size" style="margin-right: 25px;"><input tabindex="36" type="radio" value="8" name="shirt_size"> MA</label>
                                            <label class="control-label member-shirt-size" style="margin-right: 25px;"><input tabindex="36" type="radio" value="9" name="shirt_size"> LA</label>
                                            <label class="control-label member-shirt-size" style="margin-right: 25px;"><input tabindex="36" type="radio" value="10" name="shirt_size"> XLA</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Status Pernikahan
                                        </label>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            <label class="control-label member-is-married" style="margin-right: 25px;"><input tabindex="37" type="radio" checked="checked" value="0" name="is_married"> Belum Menikah</label>
                                            <label class="control-label member-is-married" style="margin-right: 25px;"><input tabindex="37" type="radio" value="1" name="is_married"> Sudah Menikah</label>
                                            <label class="control-label member-is-married" style="margin-right: 25px;"><input tabindex="37" type="radio" value="2" name="is_married"> Janda Mati</label>
                                            <label class="control-label member-is-married" style="margin-right: 25px;"><input tabindex="37" type="radio" value="3" name="is_married"> Janda Cerai</label>
                                            <label class="control-label member-is-married" style="margin-right: 25px;"><input tabindex="37" type="radio" value="4" name="is_married"> Duda Mati</label>
                                            <label class="control-label member-is-married" style="margin-right: 25px;"><input tabindex="37" type="radio" value="5" name="is_married"> Duda Cerai</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-husband-wife-name">Nama Suami/Istri
                                        </label>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            <input tabindex="38" type="text" name="husband_wife_name" id="member-husband-wife-name" class="form-control input-sm" placeholder="Nama Suami/Istri" value="Anna Sri Dewi Sianto">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-child-name">Nama Anak
                                        </label>
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-9">
                                            <input tabindex="39" type="text" name="child_name[]" class="form-control input-sm" placeholder="Nama Anak">
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                            <button type="button" class="btn btn-block btn-dark btn-sm" onclick="addFormElement('child')"><i class="fa fa-plus"></i>&nbsp; Tambah</button>
                                        </div>
                                    </div>
                                    <div id="container-member-child"></div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Pernah Jadi Anggota CU?
                                        </label>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            <label class="control-label member-is-reg-others-cu" style="margin-right: 25px;"><input type="radio" class="change-handler" checked="checked" value="0" name="is_registered_others_cu"> Belum Pernah</label>
                                            <label class="control-label member-is-reg-others-cu" style="margin-right: 25px;"><input type="radio" class="change-handler" value="1" name="is_registered_others_cu"> Sudah Pernah</label>
                                            <input tabindex="41" type="text" name="others_cu_name" id="container-others-cu" class="form-control input-sm" placeholder="Nama CU" style="width: 200px; display: inline">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Pernah Pendidikan Dasar?
                                        </label>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            <label class="control-label member-is-diksar" style="margin-right: 25px;"><input type="radio" class="change-handler" checked="checked" value="0" name="member_is_diksar"> Belum Pernah</label>
                                            <label class="control-label member-is-diksar" style="margin-right: 25px;"><input type="radio" class="change-handler" value="1" name="member_is_diksar"> Sudah Pernah</label>
                                            <input data-inputmask="'alias': 'member_diksar_date'" tabindex="42" type="text" name="member_diksar_date" id="container-diksar-date" class="form-control input-sm" placeholder="Tgl/Bln/Thn" style="width: 200px; display: inline">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Nama Ahli Waris
                                        </label>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6">
                                            <input tabindex="43" type="text" name="heir_name[]" class="form-control input-sm" placeholder="Nama Ahli Waris">
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                            <input tabindex="44" type="text" name="heir_status[]" class="form-control input-sm" placeholder="Status">
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                            <button type="button" class="btn btn-block btn-dark btn-sm" onclick="addFormElement('heir')"><i class="fa fa-plus"></i>&nbsp; Tambah</button>
                                        </div>
                                    </div>

                                    <div id="container-heir"></div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label class="control-label" for="btn-upload-photo">Foto Pemohon
                                        </label>
                                        <img id="preview-member-photo" src="" border="0" alt="Foto Pemohon" style="max-width: 150px; max-height: 150px; margin: auto; display: block">
                                        <br>
                                        <input tabindex="45" type="file" name="img_photo" id="btn-upload-photo" data-validation="mime size" data-validation-max-size="1M" class="form-control" data-validation-allowing="jpg, jpeg, png, gif" accept=".gif, .jpg, .jpeg, .png">
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label class="control-label" for="btn-upload-photo">Foto Kartu Identitas
                                        </label>
                                        <img id="preview-member-id" src="" border="0" alt="Foto Kartu Identitas" style="max-width: 150px; max-height: 150px; margin: auto; display: block">
                                        <br>
                                        <input tabindex="46" type="file" name="img_id" id="btn-upload-id" data-validation="mime size" data-validation-max-size="1M" class="form-control" data-validation-allowing="jpg, jpeg, png, gif" accept=".gif, .jpg, .jpeg, .png">
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label class="control-label" for="btn-upload-photo">Tanda Tangan
                                        </label>
                                        <img id="preview-member-signature" src="" border="0" alt="Tanda Tangan" style="max-width: 150px; max-height: 150px; margin: auto; display: block">
                                        <br>
                                        <input tabindex="47" type="file" name="img_signature" id="btn-upload-signature" data-validation="mime size" data-validation-max-size="1M" class="form-control" data-validation-allowing="jpg, jpeg, png, gif" accept=".gif, .jpg, .jpeg, .png">
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button tabindex="48" type="submit" class="btn btn-primary hide-on-detail"><i class="fa fa-save"></i>&nbsp; Simpan <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end Modal Registration-->

<!-- Modal Choose Product-->
<div id="modal-choose-saving" class="modal" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Buka Tabungan</h4>
            </div>
            <form id="form-choose-saving" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body" style="overflow-y: auto; height: calc(100vh - 200px)">
                    <div id="modal-response-message-choose-saving" class="alert fade in" style="display:none"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Data Tabungan Anggota Baru</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <input type="hidden" name="member_id" id="saving-member-id" value="0">
                                    <div class="row">
                                        <?php if ($is_superuser || $user_group == "administrator_company") : ?>
                                            <div class="form-group">
                                                <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-branch-id">Unit <span class="required">*</span>
                                                </label>
                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                    <select tabindex="1" id="saving-branch-name" class="form-control my-select2" data-validation="required">
                                                        <option value="">--Pilih Unit--</option>
                                                        <?php if (is_array($arr_list_branch) && !empty($arr_list_branch)) : ?>
                                                            <?php foreach ($arr_list_branch as $row) : ?>
                                                                <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name; ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                    <input type="hidden" name="branch_id" id="saving-branch-id" value="0">
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <input type="hidden" name="branch_id" value="<?php echo $_SESSION['administrator_group_branch_id']; ?>">
                                        <?php endif; ?>
                                        <div class="form-group">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-code">No. Anggota
                                            </label>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" name="member_code" id="saving-member-code" class="form-control" readonly="readonly">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Jenis Tabungan
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" id="container-saving"></div>
                                        </div>
                                        <!--                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-12" for="saving-initial-deposit">Setoran Awal
                                                        </label>
                                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                            <input type="text" name="initial_deposit" id="saving-initial-deposit" readonly="readonly" class="form-control text-right">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
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
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-name">Nama Lengkap <span class="required">*</span>
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="2" type="text" name="name" id="saving-member-name" class="form-control change-handler-validation" data-validation="required" data-value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-gender">Jenis Kelamin
                                            </label>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <div>
                                                    <label class="control-label saving-member-gender" style="margin-right: 25px;"><input tabindex="3" type="radio" checked="checked" value="0" name="gender" class="change-handler-validation" data-value=""> Pria</label>
                                                    <label class="control-label saving-member-gender" style="margin-right: 25px;"><input tabindex="3" type="radio" value="1" name="gender" class="change-handler-validation" data-value=""> Wanita</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Tempat/Tanggal Lahir
                                            </label>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <input tabindex="4" type="text" name="birthplace" id="saving-member-birthplace" class="form-control change-handler-validation" placeholder="Tempat Lahir" data-validation="required" data-value="">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <input data-inputmask="'alias': 'date'" tabindex="5" type="text" name="birthdate" id="saving-member-birthdate" class="form-control change-handler-validation" placeholder="Tgl/Bln/Thn" data-value="">
                                            </div>
                                        </div>
                                        <div class="form-group member-young">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-address">Alamat
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="6" type="text" name="address" id="saving-member-address" class="form-control change-handler-validation" data-validation="required" data-value="">
                                            </div>
                                        </div>
                                        <div class="form-group member-young">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-school-name">Nama Sekolah
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="7" type="text" name="member_school_name" id="saving-member-school-name" class="form-control" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="form-group member-young">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-class-at-school">Kelas
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="8" type="text" name="class_at_school" id="saving-member-class-at-school" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group member-young">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-school-address">Alamat Sekolah
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="9" type="text" name="school_address" id="saving-member-school-address" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group member-adult">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-mother-name">Nama Ibu Kandung <span class="required">*</span>
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="10" type="text" name="mother_name" id="saving-member-mother-name" class="form-control change-handler-validation" data-value="" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="form-group member-adult">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-phone">No. Telp/HP/WA <span class="required">*</span>
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="11" type="text" name="mobilephone_number" id="saving-member-phone" class="form-control change-handler-validation" data-validation="required number" data-value="">
                                            </div>
                                        </div>
                                        <div class="form-group member-adult">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-code">Jenis Identitas
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <div>
                                                    <label class="control-label saving-member-id-type" style="margin-right: 25px;"><input tabindex="12" type="radio" checked="checked" value="0" name="identity_type" class="change-handler-validation" data-value=""> KTP</label>
                                                    <label class="control-label saving-member-id-type" style="margin-right: 25px;"><input tabindex="12" type="radio" value="1" name="identity_type" class="change-handler-validation" data-value=""> KK</label>
                                                    <label class="control-label saving-member-id-type" style="margin-right: 25px;"><input tabindex="12" type="radio" value="2" name="identity_type" class="change-handler-validation" data-value=""> SIM</label>
                                                    <label class="control-label saving-member-id-type" style="margin-right: 25px;"><input tabindex="12" type="radio" value="3" name="identity_type" class="change-handler-validation" data-value=""> KIA/KTM</label>
                                                    <label class="control-label saving-member-id-type" style="margin-right: 25px;"><input tabindex="12" type="radio" value="4" name="identity_type" class="change-handler-validation" data-value=""> Passport</label>
                                                    <label class="control-label saving-member-id-type" style="margin-right: 25px;"><input tabindex="12" type="radio" value="5" name="identity_type" class="change-handler-validation" data-value=""> Lainnya</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group member-adult">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-id-number">No. Identitas <span class="required">*</span>
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="13" type="text" name="identity_number" id="saving-member-id-number" class="form-control change-handler-validation" data-value="" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="form-group member-adult">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-taxpayer-number">No. NPWP
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="14" type="text" name="taxpayer_number" id="saving-member-taxpayer-number" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group member-adult">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-kk-number">No. KK
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="15" type="text" name="kk_number" id="saving-member-kk-number" class="form-control">
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
                                                <input tabindex="16" type="text" name="father_name" id="saving-member-father-name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-mother-name-young">Nama Ibu <span class="required">*</span>
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="17" type="text" name="mother_name" id="saving-member-mother-name-young" class="form-control change-handler-validation" data-value="" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-family-address">Alamat <span class="required">*</span>
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="18" type="text" name="family_address" id="saving-family-address" class="form-control" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-family-phone">No. Telp <span class="required">*</span>
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="19" type="text" name="family_phone_number" id="saving-member-family-phone" class="form-control" data-validation="required number">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="saving-member-siblings">Jumlah Saudara
                                            </label>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input tabindex="20" type="text" name="number_of_siblings" id="saving-member-siblings" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button tabindex="21" type="submit" class="btn btn-primary hide-on-detail"><i class="fa fa-save"></i>&nbsp; Simpan Aplikasi Tabungan Anggota</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end Modal Choose Product-->

<!-- Modal choose Member-->
<div id="modal-choose-member" class="modal" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Setoran</h4>
            </div>
            <div class="modal-body" style="overflow-y: auto; height: calc(100vh - 200px)">
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

<!--FORM VALIDATOR-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<!--MASK MONEY-->
<script src="<?php echo THEMES_BACKEND; ?>/js/jquery.maskMoney.min.js"></script>

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    let isDifferentDataMember = false;

    let gridMember;

    function addFormElement(type) {
        if (type == 'child') {
            $('#container-member-child').append(`<div class="form-group">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-9">
                    <input type="text" name="child_name[]" class="form-control input-sm" placeholder="Nama Anak">
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
                    <button type="button" class="btn btn-block btn-danger btn-sm" onclick="deleteFormElement(this)"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
                </div>
            </div>`);
        }
        if (type == 'heir') {
            $('#container-heir').append(`<div class="form-group">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6">
            <input type="text" name="heir_name[]" class="form-control input-sm" placeholder="Nama Ahli Waris">
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
            <input type="text" name="heir_status[]" class="form-control input-sm" placeholder="Status">
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
            <button type="button" class="btn btn-block btn-danger btn-sm" onclick="deleteFormElement(this)"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
        </div>
    </div>`);
        }
    }

    function deleteFormElement(element) {
        $(element).parent().parent().remove();
    }

    function openModalAdd() {
        $('#container-job-other, #container-others-cu, #container-diksar-date').hide();
        $('#container-job-other').removeAttr("name");
        $('span.form-error').remove();
        $('.has-success').removeClass('has-success');
        $('.has-error').removeClass('has-error');
        $('.valid .error').removeClass('valid error').css('border-color', '');
        $('#branch-id').val('').change();
        $('#modal-registration .modal-body').animate({
            scrollTop: '0px'
        }, 300);
        $('#form-member').trigger('reset');
        $('#container-member-child').html('');
        $('#container-heir').html('');
        $('#preview-member-photo').attr('src', '<?php echo THEMES_BACKEND . '/images/no-img.jpg'; ?>');
        $('#preview-member-id').attr('src', '<?php echo THEMES_BACKEND . '/images/no-img.jpg'; ?>');
        $('#preview-member-signature').attr('src', '<?php echo THEMES_BACKEND . '/images/no-img.jpg'; ?>');
        $('#member-join-date').val(moment().format('DD/MM/YYYY'));
        $('#modal-registration form').attr('data-url', siteUrl + 'membership/registration/act_add');
        generateSelect2('#member-province', [], '', '', false, '', '--Pilih Provinsi--', '').prop('disabled', true);
        generateSelect2('#member-city', [], '', '', false, '', '--Pilih Kota--', '').prop('disabled', true);
        generateSelect2('#member-subdistrict', [], '', '', false, '', '--Pilih Kecamatan--', '').prop('disabled', true);
        generateSelect2('#member-kelurahan', [], '', '', false, '', '--Pilih Kelurahan--', '').prop('disabled', true);

        generateSelect2('#member-domicile-province', [], '', '', false, '', '--Pilih Provinsi--', '').prop('disabled', true);
        generateSelect2('#member-domicile-city', [], '', '', false, '', '--Pilih Kota--', '').prop('disabled', true);
        generateSelect2('#member-domicile-subdistrict', [], '', '', false, '', '--Pilih Kecamatan--', '').prop('disabled', true);
        generateSelect2('#member-domicile-kelurahan', [], '', '', false, '', '--Pilih Kelurahan--', '').prop('disabled', true);

        ajaxRequest('membership/registration/get_code', 'GET', '', function(res) {
            if (res.status == 200) {
                $('#member-code').val(res.data);
            } else {
                alert('Gagal mendapatkan bakal nomor anggota.');
            }
        });

        ajaxRequest('common/general/option/province', 'GET', '', function(res_province) {
            if (res_province.status == 200) {
                let dataProvince = res_province.data.results;
                generateSelect2('#member-province', dataProvince, 'province_id', 'province_name', false, '', '--Pilih Provinsi--', '').prop('disabled', false);
            } else {
                alert(res_province.msg);
            }
        });

        ajaxRequest('common/general/option/province', 'GET', '', function(res_province) {
            if (res_province.status == 200) {
                let dataProvince = res_province.data.results;
                generateSelect2('#member-domicile-province', dataProvince, 'province_id', 'province_name', false, '', '--Pilih Provinsi--', '').prop('disabled', false);
            } else {
                alert(res_province.msg);
            }
        });

        $('#modal-registration').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
    }

    function openModalSaving(data) {
        isDifferentDataMember = false;
        $('.different-data').css('background-color', '');
        $('.member-adult, .member-young').hide();

        $('span.form-error').remove();
        $('.has-success').removeClass('has-success');
        $('.has-error').removeClass('has-error');
        $('.valid .error').removeClass('valid error').css('border-color', '');

        $('#modal-choose-saving .modal-body').animate({
            scrollTop: '0px'
        }, 300);
        $("#form-choose-saving").attr('data-url', siteUrl + 'membership/registration/act_add_saving');

        $("#saving-member-id").val(data.member_id);

        let html = '';
        if (data.option_product.length > 0) {
            data.option_product.forEach(function(item, index) {
                let checked = '';
                if (index == 0) {
                    checked = 'checked="checked"';
                    //                   $('#saving-initial-deposit').val(number_format(item.min_deposit));
                }
                html += `<label class="control-label saving-id" style="margin-right: 25px;"><input type="radio" ${checked} value="${item.product_saving_id}" name="product_saving_id" onchange="changeSaving(this)" data-min-deposit="${item.min_deposit}"> ${item.product_saving_name_alias}</label>`
            })
        }

        $('#container-saving').html(html);

        if (parseInt(data.member_age) >= 17) {
            $('#saving-member-mother-name').val(data.member_mother_name).attr('data-value', data.member_mother_name);
            $('.member-adult').show();
            $('.saving-type-1').show();
            $('.saving-type-1 input[value=1]').prop('checked', true);
        } else {
            $('#saving-member-mother-name-young').val(data.member_mother_name).attr('data-value', data.member_mother_name);
            $('#saving-member-address').val(data.member_address).attr('data-value', data.member_address);
            $('.member-young').show();
            $('.saving-type-2').show();
            $('.saving-type-2 input[value=4]').prop('checked', true);
        }
        $('#saving-branch-name').val(data.member_branch_id).change();
        $('#saving-branch-id').val(data.member_branch_id);
        //        $('#saving-date').val('');
        $('#saving-member-code').val(data.member_code);

        $('#saving-member-name').val(data.member_name).attr('data-value', data.member_name);

        $('.saving-member-gender input[type=radio][value=' + data.member_gender + ']').prop('checked', true);
        $('.saving-member-gender input[type=radio]').attr('data-value', data.member_gender);

        $('#saving-member-birthplace').val(data.member_birthplace).attr('data-value', data.member_birthplace);
        $('#saving-member-birthdate').val(moment(data.member_birthdate).format('DD/MM/YYYY')).attr('data-value', moment(data.member_birthdate).format('DD/MM/YYYY'));

        $('#saving-member-phone').val(data.member_mobilephone_number).attr('data-value', data.member_mobilephone_number);

        $('.saving-member-id-type input[type=radio][value=' + data.member_identity_type + ']').prop('checked', true);
        $('.saving-member-id-type input[type=radio]').attr('data-value', data.member_identity_type);
        $('#saving-member-id-number').val(data.member_identity_number).attr('data-value', data.member_identity_number);
        $('#saving-member-taxpayer-number').val('');
        $('#saving-member-kk-number').val(data.member_nik_number).attr('data-value', data.member_nik_number);

        $('#modal-choose-saving').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
    }

    function changeSaving(element) {
        let value = $('.saving-id input[type="radio"]:checked').val();
        let minDeposit = $('.saving-id input[type="radio"][value="' + value + '"]').attr('data-min-deposit');
        //        $('#saving-initial-deposit').val(number_format(minDeposit));
    }

    function chooseMember(com, grid, urlaction) {
        let grid_id = $(grid).attr('id');
        grid_id = grid_id.substring(grid_id.lastIndexOf('grid_') + 5);

        if ($('.trSelected', grid).length > 0) {
            let data = JSON.parse($('.trSelected', grid).attr('data-id'));
            $('#member-recomendation').val(data.text);
            $('#member-refferal-id').val(data.id);

            $('#modal-choose-member').modal('hide');
        } else {
            alert('Pilih Anggota terlebih dahulu.');
            setTimeout(function() {
                $('#grid_gridview-member .trSelected').removeClass('trSelected');
                $('#grid_gridview-member tr[tabindex="1"].control-row:visible').addClass('trSelected').focus();
            }, 200);
        }
    }

    $(document).on('ready', function() {
        //        $('#modal-choose-saving').modal({
        //            backdrop: 'static',
        //            keyboard: false
        //        }, 'show');

        $('#member-recomendation').on('click', function() {
            loadFlexigridMember();
            $('#modal-choose-member').modal('show');
        });

        $('#member-recomendation').on('keyup', function() {
            let value = $(this).val();
            if (value == '') {
                $('#modal-choose-member').modal('show');
                $('#member-refferal-id').val(0);
            }
        });

        $('#container-tabs a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            let target = $(e.target).attr("href"); // activated tab
            if (target == '#pk' || target == '#tambah') {
                let isError = false;

                $("#form-member input, #form-member select").validate(function(valid, elem) {
                    if (!valid) {
                        isError = true;
                    }
                });
                if (isError) {
                    setTimeout(function() {
                        $('#container-tabs a[data-toggle="tab"][href="#data"]').click();
                        $('#modal-registration .modal-body').animate({
                            scrollTop: '0px'
                        }, 300);
                    }, 200);
                }
            }
        });

        $('.change-handler-validation').on('change keyup', function() {
            isDifferentDataMember = false;
            $.each($('.change-handler-validation:visible'), function(index, element) {
                let value = '';
                let dataValue = '';
                let isRadio = $(element).attr('type') == 'radio' ? true : false;
                if (!isRadio) {
                    value = $(element).val();
                    dataValue = $(element).attr('data-value');
                    if (value != dataValue) {
                        $(element).addClass('different-data').css('background-color', '#ffd1d1');
                        isDifferentDataMember = true;
                    } else {
                        $(element).addClass('different-data').css('background-color', '');
                    }
                    //                    console.log(value, dataValue);
                } else {
                    if ($(element).is(':checked')) {
                        value = $(element).val();
                        dataValue = $(element).attr('data-value');
                        if (value != dataValue) {
                            $(element).parent().parent().addClass('different-data').css('background-color', '#ffd1d1');
                            isDifferentDataMember = true;
                        } else {
                            $(element).parent().parent().addClass('different-data').css('background-color', '');
                        }
                        //                        console.log(value, dataValue);
                    }
                }
            });
        });

        $('.change-handler').on('change', function() {
            let name = $(this).attr('name');
            let value = $(this).val();
            if (name == 'job') {
                if (value == 'Lain-lain') {
                    $('#container-job-other').show();
                    $('#container-job-other').attr("name", "job");
                } else {
                    $('#container-job-other').hide();
                    $('#container-job-other').removeAttr("name");
                }
            }
            if (name == 'is_registered_others_cu') {
                if (value == 1) {
                    $('#container-others-cu').show();
                    $('#container-job-other').attr("name", "job");
                } else {
                    $('#container-others-cu').hide();
                    $('#container-job-other').removeAttr("name");
                }
            }
            if (name == 'member_is_diksar') {
                if (value == 1) {
                    $('#container-diksar-date').show();
                    $('#container-job-other').attr("name", "job");
                } else {
                    $('#container-diksar-date').hide();
                    $('#container-job-other').removeAttr("name");
                }
            }
        });

        $('#btn-upload-photo, #btn-upload-id, #btn-upload-signature').on('change', function() {
            let elementId = $(this).attr("id");
            switch (elementId) {
                case 'btn-upload-photo':
                    readURL(this, '#preview-member-photo');
                    break;
                case 'btn-upload-id':
                    readURL(this, '#preview-member-id');
                    break;
                case 'btn-upload-signature':
                    readURL(this, '#preview-member-signature');
                    break;
            }
        });

        $('.my-select2').select2();

        $('#form-member').on('submit', function(e) {
            e.preventDefault();

            $('#form-member button[type="submit"]').attr('disabled', 'disabled');
            let urlForm = $(this).attr('data-url');

            let formData = new FormData(this);

            let provinceValue = $('#member-province').val();
            let cityValue = $('#member-city').val();
            let subdistrictValue = $('#member-subdistrict').val();
            let villageValue = $('#member-kelurahan').val();

            let provinceValueDomicile = $('#member-domicile-province').val();
            let cityValueDomicile = $('#member-domicile-city').val();
            let subdistrictValueDomicile = $('#member-domicile-subdistrict').val();
            let villageValueDomicile = $('#member-domicile-kelurahan').val();

            formData.set('province', '');
            formData.set('city', '');
            formData.set('subdistrict', '');
            formData.set('village', '');
            if (provinceValue) {
                formData.set('province', $('#member-province option[value="' + provinceValue + '"]').text());
                formData.set('city', $('#member-city option[value="' + cityValue + '"]').text());
                formData.set('subdistrict', $('#member-subdistrict option[value="' + subdistrictValue + '"]').text());
                formData.set('kelurahan', $('#member-kelurahan option[value="' + villageValue + '"]').text());
            }

            formData.set('domicile_province', '');
            formData.set('domicile_city', '');
            formData.set('domicile_subdistrict', '');
            formData.set('domicile_kelurahan', '');
            if (provinceValue) {
                formData.set('domicile_province', $('#member-domicile-province option[value="' + provinceValueDomicile + '"]').text());
                formData.set('domicile_city', $('#member-domicile-city option[value="' + cityValueDomicile + '"]').text());
                formData.set('domicile_subdistrict', $('#member-domicile-subdistrict option[value="' + subdistrictValueDomicile + '"]').text());
                formData.set('domicile_kelurahan', $('#member-domicile-kelurahan option[value="' + villageValueDomicile + '"]').text());
            }

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
                        $('#modal-registration').modal('hide');
                        $('#form-member button[type="submit"]').removeAttr('disabled');
                        $('#gridview').flexReload();
                        openModalSaving(res.data);
                        $('#modal-choose-saving .modal-body').animate({
                            scrollTop: '0px'
                        }, 300);
                        let message_class = 'alert-success';

                        $("#modal-response-message-choose-saving").finish();

                        $("#modal-response-message-choose-saving").addClass(message_class);
                        $("#modal-response-message-choose-saving").slideDown("fast");
                        $("#modal-response-message-choose-saving").html("<p>Berhasil mendaftarkan Anggota dengan nama " + formData.get('name') + ".</p><p>Selanjutnya, silahkan mengisi form buka tabungan baru dibawah ini.</p>");
                        $("#modal-response-message-choose-saving").delay(10000).slideUp(1000, function() {
                            $("#modal-response-message-choose-saving").removeClass(message_class);
                        });
                    } else {
                        $('#modal-registration .modal-body').animate({
                            scrollTop: '0px'
                        }, 300);
                        $('#form-member button[type="submit"]').removeAttr('disabled');
                        $("#modal-response-message-registration").finish();

                        $("#modal-response-message-registration").slideDown("fast");
                        $('#modal-response-message-registration').html(res.msg);
                        $("#modal-response-message-registration").delay(10000).slideUp(1000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#form-member button[type="submit"]').removeAttr('disabled');
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });

        $('#form-choose-saving').on('submit', function(e) {
            e.preventDefault();
            //            $('#saving-initial-deposit').val(convertFormatRp($('#saving-initial-deposit').val()));
            if (isDifferentDataMember) {
                if (!confirm("PERINGATAN!\nData anggota terdeteksi berbeda dengan data registrasi anggota.\nYakin akan mengubah data anggota dan melanjutkan buka tabungan?")) {
                    return false;
                }
            }

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
                success: function(res) {
                    if (res.status == 200) {
                        $('#modal-choose-saving').modal('hide');
                        $('#form-choose-saving button[type="submit"]').removeAttr('disabled');
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
                        $('#modal-choose-saving .modal-body').animate({
                            scrollTop: '0px'
                        }, 300);
                        //                        $('#saving-initial-deposit').val(number_format($('#saving-initial-deposit').val()));
                        $('#form-choose-saving button[type="submit"]').removeAttr('disabled');
                        let message_class = 'alert-danger';

                        $("#modal-response-message-choose-saving").finish();

                        $("#modal-response-message-choose-saving").addClass(message_class);
                        $("#modal-response-message-choose-saving").slideDown("fast");
                        $("#modal-response-message-choose-saving").html(res.msg);
                        $("#modal-response-message-choose-saving").delay(10000).slideUp(1000, function() {
                            $("#modal-response-message-choose-saving").removeClass(message_class);
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#form-choose-saving button[type="submit"]').removeAttr('disabled');
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });

        $('#member-province').on('change', function(e) {
            let provinceId = $(this).val();
            if (provinceId) {
                ajaxRequest('common/general/option/city', 'GET', {
                    province_id: provinceId
                }, function(res) {
                    if (res.status == 200) {
                        let dataCity = res.data.results;
                        generateSelect2('#member-city', dataCity, 'city_id', 'city_name', false, '', '--Pilih Kota--', '')
                            .prop('disabled', false).attr('data-validation', 'required').prev().find('span').text('*');
                        $('span.form-error').remove();
                        $('.has-success').removeClass('has-success');
                        $('.valid .error').removeClass('valid error').css('border-color', '');
                        generateSelect2('#member-subdistrict', [], '', '', false, '', '--Pilih Kecamatan--', '')
                            .prop('disabled', true).attr('data-validation', '').prev().find('span').text('*');
                        generateSelect2('#member-kelurahan', [], '', '', false, '', '--Pilih Kelurahan--', '')
                            .prop('disabled', true).attr('data-validation', '').prev().find('span').text('*');
                    } else {
                        alert(res.msg);
                    }
                });
            } else {
                $('span.form-error').remove();
                $('.has-success').removeClass('has-success');
                $('.valid .error').removeClass('valid error').css('border-color', '');

                generateSelect2('#member-city', [], '', '', false, '', '--Pilih Kota--', '')
                    .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
                generateSelect2('#member-subdistrict', [], '', '', false, '', '--Pilih Kecamatan--', '')
                    .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
                generateSelect2('#member-kelurahan', [], '', '', false, '', '--Pilih Kelurahan--', '')
                    .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
            }
        });

        $('#member-city').on('change', function(e) {
            let cityId = $(this).val();
            if (cityId) {
                ajaxRequest('common/general/option/subdistrict', 'GET', {
                    city_id: cityId
                }, function(res) {
                    if (res.status == 200) {
                        let dataSubdistrict = res.data.results;
                        generateSelect2('#member-subdistrict', dataSubdistrict, 'subdistrict_id', 'subdistrict_name', false, '', '--Pilih Kecamatan--', '')
                            .prop('disabled', false).attr('data-validation', 'required').prev().find('span').text('*');
                        $('span.form-error').remove();
                        $('.has-success').removeClass('has-success');
                        $('.valid .error').removeClass('valid error').css('border-color', '');
                        generateSelect2('#member-kelurahan', [], '', '', false, '', '--Pilih Kelurahan--', '')
                            .prop('disabled', true).attr('data-validation', '').prev().find('span').text('*');
                    } else {
                        alert(res.msg);
                    }
                });
            } else {
                $('span.form-error').remove();
                $('.has-success').removeClass('has-success');
                $('.valid .error').removeClass('valid error').css('border-color', '');

                generateSelect2('#member-subdistrict', [], '', '', false, '', '--Pilih Kecamatan--', '')
                    .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
                generateSelect2('#member-kelurahan', [], '', '', false, '', '--Pilih Kelurahan--', '')
                    .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
            }
        });

        $('#member-subdistrict').on('change', function(e) {
            let subdistrictId = $(this).val();
            if (subdistrictId) {
                ajaxRequest('common/general/option/village', 'GET', {
                    subdistrict_id: subdistrictId
                }, function(res) {
                    if (res.status == 200) {
                        let dataVillage = res.data.results;
                        generateSelect2('#member-kelurahan', dataVillage, 'village_id', 'village_name', false, '', '--Pilih Kelurahan--', '')
                            .prop('disabled', false).attr('data-validation', 'required').prev().find('span').text('*');
                        $('span.form-error').remove();
                        $('.has-success').removeClass('has-success');
                        $('.valid .error').removeClass('valid error').css('border-color', '');
                    } else {
                        alert(res.msg);
                    }
                });
            } else {
                $('span.form-error').remove();
                $('.has-success').removeClass('has-success');
                $('.valid .error').removeClass('valid error').css('border-color', '');

                generateSelect2('#member-kelurahan', [], '', '', false, '', '--Pilih Kelurahan--', '')
                    .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
            }
        });

        $('#member-domicile-province').on('change', function(e) {
            let provinceId = $(this).val();
            if (provinceId) {
                ajaxRequest('common/general/option/city', 'GET', {
                    province_id: provinceId
                }, function(res) {
                    if (res.status == 200) {
                        let dataCity = res.data.results;
                        generateSelect2('#member-domicile-city', dataCity, 'city_id', 'city_name', false, '', '--Pilih Kota--', '')
                            .prop('disabled', false).attr('data-validation', 'required').prev().find('span').text('*');
                        $('span.form-error').remove();
                        $('.has-success').removeClass('has-success');
                        $('.valid .error').removeClass('valid error').css('border-color', '');
                        generateSelect2('#member-domicile-subdistrict', [], '', '', false, '', '--Pilih Kecamatan--', '')
                            .prop('disabled', true).attr('data-validation', '').prev().find('span').text('*');
                        generateSelect2('#member-domicile-kelurahan', [], '', '', false, '', '--Pilih Kelurahan--', '')
                            .prop('disabled', true).attr('data-validation', '').prev().find('span').text('*');
                    } else {
                        alert(res.msg);
                    }
                });
            } else {
                $('span.form-error').remove();
                $('.has-success').removeClass('has-success');
                $('.valid .error').removeClass('valid error').css('border-color', '');

                generateSelect2('#member-domicile-city', [], '', '', false, '', '--Pilih Kota--', '')
                    .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
                generateSelect2('#member-domicile-subdistrict', [], '', '', false, '', '--Pilih Kecamatan--', '')
                    .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
                generateSelect2('#member-domicile-kelurahan', [], '', '', false, '', '--Pilih Kelurahan--', '')
                    .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
            }
        });

        $('#member-domicile-city').on('change', function(e) {
            let cityId = $(this).val();
            if (cityId) {
                ajaxRequest('common/general/option/subdistrict', 'GET', {
                    city_id: cityId
                }, function(res) {
                    if (res.status == 200) {
                        let dataSubdistrict = res.data.results;
                        generateSelect2('#member-domicile-subdistrict', dataSubdistrict, 'subdistrict_id', 'subdistrict_name', false, '', '--Pilih Kecamatan--', '')
                            .prop('disabled', false).attr('data-validation', 'required').prev().find('span').text('*');
                        $('span.form-error').remove();
                        $('.has-success').removeClass('has-success');
                        $('.valid .error').removeClass('valid error').css('border-color', '');
                        generateSelect2('#member-domicile-kelurahan', [], '', '', false, '', '--Pilih Kelurahan--', '')
                            .prop('disabled', true).attr('data-validation', '').prev().find('span').text('*');
                    } else {
                        alert(res.msg);
                    }
                });
            } else {
                $('span.form-error').remove();
                $('.has-success').removeClass('has-success');
                $('.valid .error').removeClass('valid error').css('border-color', '');

                generateSelect2('#member-domicile-subdistrict', [], '', '', false, '', '--Pilih Kecamatan--', '')
                    .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
                generateSelect2('#member-domicile-kelurahan', [], '', '', false, '', '--Pilih Kelurahan--', '')
                    .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
            }
        });

        $('#member-domicile-subdistrict').on('change', function(e) {
            let subdistrictId = $(this).val();
            if (subdistrictId) {
                ajaxRequest('common/general/option/village', 'GET', {
                    subdistrict_id: subdistrictId
                }, function(res) {
                    if (res.status == 200) {
                        let dataVillage = res.data.results;
                        generateSelect2('#member-domicile-kelurahan', dataVillage, 'village_id', 'village_name', false, '', '--Pilih Kelurahan--', '')
                            .prop('disabled', false).attr('data-validation', 'required').prev().find('span').text('*');
                        $('span.form-error').remove();
                        $('.has-success').removeClass('has-success');
                        $('.valid .error').removeClass('valid error').css('border-color', '');
                    } else {
                        alert(res.msg);
                    }
                });
            } else {
                $('span.form-error').remove();
                $('.has-success').removeClass('has-success');
                $('.valid .error').removeClass('valid error').css('border-color', '');

                generateSelect2('#member-domicile-kelurahan', [], '', '', false, '', '--Pilih Kelurahan--', '')
                    .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
            }
        });
    });

    $("#gridview").flexigrid({
        url: siteUrl + 'membership/registration/get_data',
        dataType: 'json',
        colModel: [{
                display: 'No. Bakal Anggota',
                name: 'member_temp_code',
                width: 110,
                sortable: true,
                align: 'center'
            },
            {
                display: 'Nama',
                name: 'member_name',
                width: 200,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Status Keanggotaan',
                name: 'member_status',
                width: 180,
                sortable: true,
                align: 'center'
            },
            {
                display: 'No. Identitas',
                name: 'member_identity_number',
                width: 150,
                sortable: true,
                align: 'center',
                hide: true
            },
            {
                display: 'Tipe Identitas',
                name: 'member_identity_type',
                width: 80,
                sortable: true,
                align: 'center',
                hide: true
            },
            {
                display: 'Jenis Kelamin',
                name: 'member_gender',
                width: 80,
                sortable: true,
                align: 'center'
            },
            {
                display: 'Tanggal Lahir',
                name: 'member_birthdate',
                width: 180,
                sortable: true,
                align: 'center',
                hide: true
            },
            {
                display: 'Tempat Lahir',
                name: 'member_birthplace',
                width: 100,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'Alamat',
                name: 'member_address',
                width: 300,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Provinsi',
                name: 'member_province',
                width: 100,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Kota',
                name: 'member_city',
                width: 100,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Kecamatan',
                name: 'member_subdistrict',
                width: 100,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Kelurahan',
                name: 'member_kelurahan',
                width: 100,
                sortable: true,
                align: 'left'
            },
            {
                display: 'RT',
                name: 'member_rt_number',
                width: 50,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'RW',
                name: 'member_rw_number',
                width: 50,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'Kode Pos',
                name: 'member_zipcode',
                width: 80,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'Domisili',
                name: 'member_address_domicile',
                width: 300,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Provinsi Domisili',
                name: 'member_domicile_province',
                width: 100,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Kota Domisili',
                name: 'member_domicile_city',
                width: 100,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Kecamatan Domisili',
                name: 'member_domicile_subdistrict',
                width: 100,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Kelurahan Domisili',
                name: 'member_domicile_kelurahan',
                width: 100,
                sortable: true,
                align: 'left'
            },
            {
                display: 'RT Domisili',
                name: 'member_domicile_rt_number',
                width: 100,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'RW Domisili',
                name: 'member_domicile_rw_number',
                width: 100,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'Kode Pos Domisili',
                name: 'member_domicile_zipcode',
                width: 150,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'Status Tempat Tinggal',
                name: 'member_residence_status',
                width: 150,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'Kewarganegaraan',
                name: 'member_nationality',
                width: 110,
                sortable: true,
                align: 'center',
                hide: true
            },
            {
                display: 'Telepon',
                name: 'member_phone_number',
                width: 100,
                sortable: true,
                align: 'left'
            },
            {
                display: 'No. Handphone',
                name: 'member_mobilephone_number',
                width: 100,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Pekerjaan',
                name: 'member_job',
                width: 100,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Detail Pekerjaan',
                name: 'member_job_detail',
                width: 300,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Bekerja di',
                name: 'member_working_in',
                width: 100,
                sortable: true,
                align: 'center',
                hide: true
            },
            {
                display: 'Rata-rata Penghasilan',
                name: 'member_average_income',
                width: 130,
                sortable: true,
                align: 'center',
                hide: true
            },
            {
                display: 'Pendidikan Terakhir',
                name: 'member_last_education',
                width: 100,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'Agama',
                name: 'member_religion',
                width: 150,
                sortable: true,
                align: 'center'
            },
            {
                display: 'Suku',
                name: 'member_ethnic_group',
                width: 100,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'Gol. Darah',
                name: 'member_blood_type',
                width: 100,
                sortable: true,
                align: 'center',
                hide: true
            },
            {
                display: 'Ukuran Baju',
                name: 'member_shirt_size',
                width: 100,
                sortable: true,
                align: 'center',
                hide: true
            },
            {
                display: 'Status Pernikahan',
                name: 'member_is_married',
                width: 110,
                sortable: true,
                align: 'center'
            },
            {
                display: 'Nama Suami/Istri',
                name: 'member_husband_wife_name',
                width: 200,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Nama Anak',
                name: 'member_child_name',
                width: 200,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Nama Ibu Kandung',
                name: 'member_mother_name',
                width: 200,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Pernah Terdaftar di CU Lain',
                name: 'member_is_registered_others_cu',
                width: 80,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'Nama CU Lain',
                name: 'member_others_cu_name',
                width: 100,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'Nama Ahli Waris',
                name: 'member_heir_name',
                width: 200,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Status Ahli Waris',
                name: 'member_heir_status',
                width: 200,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Waktu Daftar',
                name: 'member_join_datetime',
                width: 200,
                sortable: true,
                align: 'center'
            },
            {
                display: 'Nama Administrator Input',
                name: 'member_input_admin_name',
                width: 200,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'Waktu Administrator Input',
                name: 'member_input_datetime',
                width: 100,
                sortable: true,
                align: 'center',
                hide: true
            },
            {
                display: 'Unit',
                name: 'branch_name',
                width: 150,
                sortable: true,
                align: 'left'
            },
        ],
        buttons: [
            <?php
            if (privilege_view('add', $this->menu_privilege)) :
                echo "{display: 'Registrasi Anggota', name: 'add', bclass: 'add', onpress: openModalAdd},";
            endif;
            ?>
        ],
        buttons_right: [
            <?php
            if (privilege_view('export', $this->menu_privilege)) :
                echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("membership/registration/export_data_member") . "'}";
            endif;
            ?>
        ],
        searchitems: [{
                display: 'Unit',
                name: 'branch_name',
                type: 'text'
            },
            {
                display: 'No. Bakal Anggota',
                name: 'member_temp_code',
                type: 'text'
            },
            {
                display: 'Nama',
                name: 'member_name',
                type: 'text'
            },
            {
                display: 'Status Keanggotaan',
                name: 'member_status',
                type: 'select',
                option: '0:Anggota Koperasi|1:ALB Anak|2:ALB WNA|3:ALB Luar Negeri|4:ALB Khusus|5:Calon Anggota'
            },
            {
                display: 'No. Rekening',
                name: 'member_account_number',
                type: 'text'
            },
            {
                display: 'No. Identitas',
                name: 'member_identity_number',
                type: 'text'
            },
            {
                display: 'Tipe Identitas',
                name: 'member_identity_type',
                type: 'select',
                option: '0:NIK|1:PASSPORT'
            },
            {
                display: 'Jenis Kelamin',
                name: 'member_gender',
                type: 'select',
                option: '0:Laki-laki|1:Perempuan'
            },
            {
                display: 'Tanggal Lahir',
                name: 'member_birthdate',
                type: 'text'
            },
            {
                display: 'Tempat Lahir',
                name: 'member_birthplace',
                type: 'text'
            },
            {
                display: 'Alamat',
                name: 'member_address',
                type: 'text'
            },
            {
                display: 'Provinsi',
                name: 'member_province',
                type: 'text'
            },
            {
                display: 'Kota',
                name: 'member_city',
                type: 'text'
            },
            {
                display: 'Kecamatan',
                name: 'member_subdistrict',
                type: 'text'
            },
            {
                display: 'Kelurahan',
                name: 'member_kelurahan',
                type: 'text'
            },
            {
                display: 'RT',
                name: 'member_rt_number',
                type: 'text'
            },
            {
                display: 'RW',
                name: 'member_rw_number',
                type: 'text'
            },
            {
                display: 'Kode Pos',
                name: 'member_zipcode',
                type: 'text'
            },
            {
                display: 'Domisili',
                name: 'member_address_domicile',
                type: 'text'
            },
            {
                display: 'Provinsi Domisili',
                name: 'member_domicile_province',
                type: 'text'
            },
            {
                display: 'Kota Domisili',
                name: 'member_domicile_city',
                type: 'text'
            },
            {
                display: 'Kecamatan Domisili',
                name: 'member_domicile_subdistrict',
                type: 'text'
            },
            {
                display: 'Kelurahan Domisili',
                name: 'member_domicile_kelurahan',
                type: 'text'
            },
            {
                display: 'RT Domisili',
                name: 'member_domicile_rt_number',
                type: 'text'
            },
            {
                display: 'RW Domisili',
                name: 'member_domicile_rw_number',
                type: 'text'
            },
            {
                display: 'Kode Pos Domisili',
                name: 'member_domicile_zipcode',
                type: 'text'
            },
            {
                display: 'Status Tempat Tinggal',
                name: 'member_residence_status',
                type: 'select',
                option: '0:Tidak Diisi|1:Milik Sendiri|2:Sewa/Kontrak|3:Menumpang|4:Ikut Orang Tua'
            },
            {
                display: 'Telepon',
                name: 'member_phone_number',
                type: 'text'
            },
            {
                display: 'No. Handphone',
                name: 'member_mobilephone_number',
                type: 'text'
            },
            {
                display: 'Pekerjaan',
                name: 'member_job',
                type: 'text'
            },
            {
                display: 'Bekerja di',
                name: 'member_working_in',
                type: 'select',
                option: '0:Indonesia|1:Luar Negeri'
            },
            {
                display: 'Rata-rata Penghasilan',
                name: 'member_average_income',
                type: 'select',
                option: '0:< 1jt|1:1jt - 3jt|2:3jt - 5jt|3:5jt - 10jt|4:>10jt'
            },
            {
                display: 'Pendidikan Terakhir',
                name: 'member_last_education',
                type: 'select',
                option: '0:Tidak Sekolah|1:SD|2:SLTP|3:SMU/SMK|4:Diploma 1,2,3|5:S1|6:S2|7:S3'
            },
            {
                display: 'Agama',
                name: 'member_religion',
                type: 'select',
                option: '0:Tidak Diisi|1:Islam|2:Kristen|3:Katolik|4:Hindu|5:Budha|6:Kong Hu Cu|7:Aliran Kepercayaan|8:Lainnya'
            },
            {
                display: 'Suku',
                name: 'member_ethnic_group',
                type: 'text'
            },
            {
                display: 'Gol. Darah',
                name: 'member_blood_type',
                type: 'select',
                option: '0:Tidak Diisi|1:A|2:B|3:AB|4:O'
            },
            {
                display: 'Ukuran Baju',
                name: 'member_shirt_size',
                type: 'select',
                option: '0:Tidak Diisi|1:S|2:M|3:L|4:XL|5:XXL|6:XXXL'
            },
            {
                display: 'Status Pernikahan',
                name: 'member_is_married',
                type: 'select',
                option: '0:Belum Menikah|1:Sudah Menikah|2:Janda Mati|3:Janda Cerai|4:Duda Mati|5:Duda Cerai'
            },
            {
                display: 'Nama Suami/Istri',
                name: 'member_husband_wife_name',
                type: 'text'
            },
            {
                display: 'Nama Anak',
                name: 'member_child_name',
                type: 'text'
            },
            {
                display: 'Nama Ibu Kandung',
                name: 'member_mother_name',
                type: 'text'
            },
            {
                display: 'Pernah Terdaftar di CU Lain',
                name: 'member_is_registered_others_cu',
                type: 'text'
            },
            {
                display: 'Nama CU Lain',
                name: 'member_others_cu_name',
                type: 'text'
            },
            {
                display: 'Nama Ahli Waris',
                name: 'member_heir_name',
                type: 'text'
            },
            {
                display: 'Status Ahli Waris',
                name: 'member_heir_status',
                type: 'text'
            },
            {
                display: 'Waktu Daftar',
                name: 'member_join_datetime',
                type: 'date'
            },
            {
                display: 'Nama Administrator Input',
                name: 'member_input_admin_name',
                type: 'text'
            },
            {
                display: 'Waktu Administrator Input',
                name: 'member_input_datetime',
                type: 'date'
            },
        ],
        sortname: "jurnal_master_id",
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
                url: siteUrl + 'membership/registration/get_data_member',
                dataType: 'json',
                colModel: [{
                        display: 'No. Anggota',
                        name: 'member_code',
                        width: 80,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Nama',
                        name: 'member_name',
                        width: 200,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Status Keanggotaan',
                        name: 'member_status',
                        width: 150,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'No. Identitas',
                        name: 'member_identity_number',
                        width: 150,
                        sortable: true,
                        align: 'center',
                        hide: true
                    },
                    {
                        display: 'Tipe Identitas',
                        name: 'member_identity_type',
                        width: 80,
                        sortable: true,
                        align: 'center',
                        hide: true
                    },
                    {
                        display: 'Jenis Kelamin',
                        name: 'member_gender',
                        width: 80,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Tanggal Lahir',
                        name: 'member_birthdate',
                        width: 180,
                        sortable: true,
                        align: 'center',
                        hide: true
                    },
                    {
                        display: 'Tempat Lahir',
                        name: 'member_birthplace',
                        width: 100,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Alamat',
                        name: 'member_address',
                        width: 300,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Provinsi',
                        name: 'member_province',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Kota',
                        name: 'member_city',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Kecamatan',
                        name: 'member_subdistrict',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Kelurahan',
                        name: 'member_kelurahan',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'RT',
                        name: 'member_rt_number',
                        width: 50,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'RW',
                        name: 'member_rw_number',
                        width: 50,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Kode Pos',
                        name: 'member_zipcode',
                        width: 80,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Domisili',
                        name: 'member_address_domicile',
                        width: 300,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Provinsi Domisili',
                        name: 'member_domicile_province',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Kota Domisili',
                        name: 'member_domicile_city',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Kecamatan Domisili',
                        name: 'member_domicile_subdistrict',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Kelurahan Domisili',
                        name: 'member_domicile_kelurahan',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'RT Domisili',
                        name: 'member_domicile_rt_number',
                        width: 50,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'RW Domisili',
                        name: 'member_domicile_rw_number',
                        width: 50,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Kode Pos Domisili',
                        name: 'member_domicile_zipcode',
                        width: 80,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Telepon',
                        name: 'member_phone_number',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'No. Handphone',
                        name: 'member_mobilephone_number',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Pekerjaan',
                        name: 'member_job',
                        width: 100,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Rata-rata Penghasilan',
                        name: 'member_average_income',
                        width: 130,
                        sortable: true,
                        align: 'center',
                        hide: true
                    },
                    {
                        display: 'Pendidikan Terakhir',
                        name: 'member_last_education',
                        width: 100,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Agama',
                        name: 'member_religion',
                        width: 150,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Status Pernikahan',
                        name: 'member_is_married',
                        width: 110,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Nama Suami/Istri',
                        name: 'member_husband_wife_name',
                        width: 200,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Nama Anak',
                        name: 'member_child_name',
                        width: 200,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Nama Ibu Kandung',
                        name: 'member_mother_name',
                        width: 200,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Pernah Terdaftar di CU Lain',
                        name: 'member_is_registered_others_cu',
                        width: 80,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Nama CU Lain',
                        name: 'member_others_cu_name',
                        width: 100,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Nama Ahli Waris',
                        name: 'member_heir_name',
                        width: 200,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Status Ahli Waris',
                        name: 'member_heir_status',
                        width: 200,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Unit',
                        name: 'branch_name',
                        width: 150,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Waktu Daftar',
                        name: 'member_join_datetime',
                        width: 200,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Nama Administrator Input',
                        name: 'member_input_admin_name',
                        width: 200,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Waktu Administrator Input',
                        name: 'member_input_datetime',
                        width: 100,
                        sortable: true,
                        align: 'center',
                        hide: true
                    },
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
                searchitems: [{
                        display: 'Nama',
                        name: 'member_name',
                        type: 'text'
                    },
                    {
                        display: 'No. Anggota',
                        name: 'member_code',
                        type: 'text'
                    },
                    {
                        display: 'Alamat',
                        name: 'member_address',
                        type: 'text'
                    },
                    {
                        display: 'Provinsi',
                        name: 'member_province',
                        type: 'text'
                    },
                    {
                        display: 'Kota',
                        name: 'member_city',
                        type: 'text'
                    },
                    {
                        display: 'Kecamatan',
                        name: 'member_subdistrict',
                        type: 'text'
                    },
                    {
                        display: 'Kelurahan',
                        name: 'member_kelurahan',
                        type: 'text'
                    },
                    {
                        display: 'Domisili',
                        name: 'member_address_domicile',
                        type: 'text'
                    },
                    {
                        display: 'Provinsi Domisili',
                        name: 'member_domicile_province',
                        type: 'text'
                    },
                    {
                        display: 'Kota Domisili',
                        name: 'member_domicile_city',
                        type: 'text'
                    },
                    {
                        display: 'Kecamatan Domisili',
                        name: 'member_domicile_subdistrict',
                        type: 'text'
                    },
                    {
                        display: 'Kelurahan Domisili',
                        name: 'member_domicile_kelurahan',
                        type: 'text'
                    },
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
                url: siteUrl + 'membership/registration/get_data_member',
            }).flexClearReload();
        }
        $('.trSelected').focus();
    }

    // function generate select2
    function generateSelect2(element = '.select2', data = [], nameValue, nameText, selectedValue = false, selectedName = '', placeHolder = false, placeHolderValue = '') {
        let option = placeHolder === false ? '' : `<option value="${placeHolderValue}">${placeHolder}</option>`;
        data.forEach(function(item, index) {
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
    function convertFormatRp(currency) {
        let value = currency.replace('Rp. ', '');
        return parseInt(value.replace(/\./g, ''));
    }

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
            reader.onload = function(e) {
                $(element).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $.validate({
        modules: 'logic, file, security',
        lang: 'id',
        onError: function() {
            $('#container-tabs a[data-toggle="tab"][href="#data"]').click();
            $('#modal-registration .modal-body').animate({
                scrollTop: '0px'
            }, 300);
            $('#modal-choose-saving .modal-body').animate({
                scrollTop: '0px'
            }, 300);
        }
    });

    //    $(window).bind('beforeunload', function(e){
    //        e.preventDefault();
    //        if(confirm("Yakin akan meninggalkan halaman ini?")){
    //            return true;
    //        }else{
    //            return false
    //        }
    //    });
</script>

<!-- FORM INPUTMASK -->
<script src="<?php echo THEMES_BACKEND; ?>/js/jquery.inputmask.bundle.js"></script>
<script>
    $("#member-birthdate, #saving-date, #member-join-date, #saving-member-birthdate").inputmask({
        format: 'DD/MM/YYYY'
    });
    $("#container-diksar-date").inputmask({
        format: 'DD/MM/YYYY'
    });
</script>
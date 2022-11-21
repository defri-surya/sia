<style>
    .color-1 .form-group:nth-child(even){
        background:#E6E6FA;
        padding: 5px;
    }
    .color-1 .form-group:nth-child(odd){
        background-color: #fff;
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
        <div id="response_message" style="display:none;"></div>
        <ul id="container-tabs" class="nav nav-tabs bar_tabs" role="tablist">
            <li class="active"><a data-toggle="tab" href="#tab-member">Anggota</a></li>
            <li><a data-toggle="tab" href="#tab-alb">Anggota Luar Biasa</a></li>
            <li><a data-toggle="tab" href="#tab-alb-special">Anggota Luar Biasa Khusus</a></li>
        </ul>
        
        <div class="tab-content">
            <div id="tab-member" class="tab-pane fade in active">
                <table id="gridview" style="display:none;"></table>
            </div>
            <div id="tab-alb" class="tab-pane fade">
                <table id="gridview-alb" style="display:none;"></table>
            </div>
            <div id="tab-alb-special" class="tab-pane fade">
                <table id="gridview-alb-special" style="display:none;"></table>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit-->
<div id="modal-edit" class="modal" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Ubah Data Anggota</h4>
            </div>
            <form id="form-member" class="form-horizontal form-label-left" data-url="<?php echo site_url('membership/member/act_update'); ?>">
                <div class="modal-body" style="overflow-y: auto; height: calc(100vh - 200px)">
                    <div id="modal-response-message-member" class="alert alert-danger alert-dismissible fade in" style="display:none"></div>
                    <input id="member-id" type="hidden" name="member_id" value="">
                    <div class="row">
<!--                        <div class="form-group">
                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-join-date">Tanggal Bergabung
                            </label>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <input type="text" name="join_datetime" id="member-join-date" class="form-control input-sm" placeholder="dd/mm/yyyy" readonly="readonly" style="background-color: #fff;" value="">
                            </div>
                        </div>-->

<!-- nav-tab                -->
                        <ul id="tabs-edit" class="nav nav-tabs" style="margin-left: 5px;">
                            <li class="active"><a data-toggle="tab" href="#data">Data Diri</a></li>
                            <li><a data-toggle="tab" href="#pk">Pekerjaan Dan Pendidikan</a></li>
                            <li><a data-toggle="tab" href="#tambah">Info Tambahan</a></li>
                        </ul>

<!-- tab-content umum -->
                        <div class="tab-content">
                            <div id="data" class="tab-pane fade in active color-1">
                                <div class="form-group" style="margin-top: 8px;">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-name">Nama <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <input tabindex="1" type="text" name="name" id="member-name" class="form-control input-sm" data-validation="required" placeholder="Nama, sesuai dengan KTP/SIM/Ijazah" value="Deddy Corbuzier">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-id-type">Identitas <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <select tabindex="2" name="identity_type" id="member-id-type" class="form-control my-select2 input-sm" data-validation="required">
                                            <option value="0">NIK</option>
                                            <option value="1">PASSPORT</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                        <input tabindex="3" type="text" name="identity_number" id="member-id-number" class="form-control input-sm" placeholder="Nomor NIK/PASSPORT yang masih berlaku" value="3306124403910302" data-validation="required">
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
                                        <input tabindex="38" type="text" name="mother_name" id="member-mother-name" class="form-control input-sm" placeholder="Nama Ibu Kandung" value="Awiek Lestari Rahayu"  data-validation="required">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Jenis Kelamin
                                    </label>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <label class="control-label member-gender" style="margin-right: 25px;"><input tabindex="4" type="radio" checked="checked" value="0" name="gender"> Laki-laki</label>
                                        <label class="control-label member-gender" style="margin-right: 25px;"><input tabindex="4" type="radio" value="1" name="gender"> Perempuan</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-birthplace">Tempat, Tanggal Lahir
                                    </label>
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                        <input tabindex="5" type="text" name="birthplace" id="member-birthplace" class="form-control input-sm" placeholder="Tempat lahir" value="Yogyakarta">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <input data-inputmask="'alias': 'date'" tabindex="6" type="text" name="birthdate" id="member-birthdate" class="form-control input-sm" placeholder="Tgl/Bln/Thn" data-validation="required" style="background-color: #fff;" value="22/05/1986">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Kewarganegaraan
                                    </label>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <label class="control-label member-nationality" style="margin-right: 25px;"><input tabindex="7" type="radio" checked="checked" value="0" name="member_nationality"> WNI</label>
                                        <label class="control-label member-nationality" style="margin-right: 25px;"><input tabindex="7" type="radio" value="1" name="member_nationality"> WNA</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-address">Alamat Lengkap
                                    </label>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="margin-bottom: 5px;">
                                        <input tabindex="8" type="text" name="address" id="member-address" class="form-control input-sm" placeholder="Alamat lengkap, sesuai dengan identitas" value="Jl. Balirejo I No.28, Banguntapan, Bantul, D.I. Yogyakarta">
                                    </div>
                                
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="margin-bottom: 5px;">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <select tabindex="9" name="province" id="member-province" class="form-control my-select2 input-sm" data-validation="">
                                                    <option value="">--Pilih Provinsi--</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <select tabindex="10" name="city" id="member-city" class="form-control my-select2 input-sm" data-validation="">
                                                    <option value="">--Pilih Kota/Kab--</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                

                                
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="margin-bottom: 5px;">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <select tabindex="11" name="subdistrict" id="member-subdistrict" class="form-control my-select2 input-sm" data-validation="">
                                                    <option value="">--Pilih Kecamatan--</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <select tabindex="12" name="kelurahan" id="member-kelurahan" class="form-control my-select2 input-sm" data-validation="">
                                                    <option value="">--Pilih Kelurahan--</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                

                               
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="margin-bottom: 5px;">
                                            <input tabindex="13" type="text" name="rt_number" id="member-rt" class="form-control input-sm" placeholder="RT" value="4">
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <input tabindex="14" type="text" name="rw_number" id="member-rw" class="form-control input-sm" placeholder="RW" value="5">
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-right">
                                            <input tabindex="15" type="text" name="zipcode" id="member-zipcode" class="form-control input-sm" placeholder="Kode Pos" value="55431">
                                        </div>
                                </div>

                                <div class="form-group" style="margin-bottom: 5px;">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-address-domicile">Alamat Domisili
                                    </label>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="margin-bottom: 5px;">
                                        <input tabindex="16" type="text" name="address_domicile" id="member-address-domicile" class="form-control input-sm" placeholder="Alamat domisili" value="Jl. Balirejo I No.28">
                                    </div>
                                
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="margin-bottom: 5px;">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <select tabindex="17" name="domicile_province" id="member-domicile-province" class="form-control my-select2 input-sm" data-validation="">
                                                    <option value="">--Pilih Provinsi--</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <select tabindex="18" name="domicile_city" id="member-domicile-city" class="form-control my-select2 input-sm" data-validation="">
                                                    <option value="">--Pilih Kota/Kab--</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin-bottom: 5px;">
                                                <select tabindex="19" name="domicile_subdistrict" id="member-domicile-subdistrict" class="form-control my-select2 input-sm" data-validation="">
                                                    <option value="">--Pilih Kecamatan--</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <select tabindex="20" name="domicile_kelurahan" id="member-domicile-kelurahan" class="form-control my-select2 input-sm" data-validation="">
                                                    <option value="">--Pilih Kelurahan--</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="margin-bottom: 5px;">
                                        <input tabindex="21" type="text" name="domicile_rt_number" id="member-domicile-rt" class="form-control input-sm" placeholder="RT" value="4">
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <input tabindex="22" type="text" name="domicile_rw_number" id="member-domicile-rw" class="form-control input-sm" placeholder="RW" value="5">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-right">
                                        <input tabindex="23" type="text" name="domicile_zipcode" id="member-domicile-zipcode" class="form-control input-sm" placeholder="Kode Pos" value="55431">
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
                                        <input tabindex="25" type="text" name="phone_number" id="member-phone" class="form-control input-sm" placeholder="Telepon Rumah/Kantor" value="0281998675">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <input tabindex="26" type="text" name="mobilephone_number" id="member-mobilephone" class="form-control input-sm" placeholder="Handphone" value="08123456789">
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
                                <label class="control-label member-job" style="margin-right: 25px;"><input tabindex="27" type="radio" class="change-handler" checked="checked" value="Petani" name="job"> Petani</label>
                                <label class="control-label member-job" style="margin-right: 25px;"><input tabindex="27" type="radio" class="change-handler" value="PNS" name="job"> PNS</label>
                                <label class="control-label member-job" style="margin-right: 25px;"><input tabindex="27" type="radio" class="change-handler" value="Swasta/Karyawan" name="job"> Swasta/Karyawan</label>
                                <label class="control-label member-job" style="margin-right: 25px;"><input tabindex="27" type="radio" class="change-handler" value="Pengacara" name="job"> Pengacara</label>
                                <label class="control-label member-job" style="margin-right: 25px;"><input tabindex="27" type="radio" class="change-handler" value="Dokter" name="job"> Dokter</label>
                                <label class="control-label member-job" style="margin-right: 25px;"><input tabindex="27" type="radio" class="change-handler" value="Buruh Kasar" name="job"> Buruh Kasar</label>
                                <label class="control-label member-job" style="margin-right: 25px;"><input tabindex="27" type="radio" class="change-handler" value="Guru" name="job"> Guru</label>
                                <label class="control-label member-job" style="margin-right: 25px;"><input tabindex="27" type="radio" class="change-handler" value="Ibu Rumah Tangga" name="job"> Ibu Rumah Tangga</label>
                                <label class="control-label member-job" style="margin-right: 25px;"><input tabindex="27" type="radio" class="change-handler" value="Lain-lain" name="job"> Lain-lain</label>
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
                                <label class="control-label member-working-in" style="margin-right: 25px;"><input tabindex="28" type="radio" checked="checked" value="0" name="working_in"> Indonesia</label>
                                <label class="control-label member-working-in" style="margin-right: 25px;"><input tabindex="28" type="radio" value="1" name="working_in"> Luar Negeri</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Penghasilan Rata2 Per Bulan
                            </label>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <label class="control-label member-income" style="margin-right: 25px;"><input tabindex="29" type="radio" checked="checked" value="0" name="average_income"> Belum Berpenghasilan</label>
                                <label class="control-label member-income" style="margin-right: 25px;"><input tabindex="29" type="radio" value="1" name="average_income"> < 1 Juta</label>
                                <label class="control-label member-income" style="margin-right: 25px;"><input tabindex="29" type="radio" value="2" name="average_income"> 1 Juta - 3 Juta</label>
                                <label class="control-label member-income" style="margin-right: 25px;"><input tabindex="29" type="radio" value="3" name="average_income"> 3 Juta - 5 Juta</label>
                                <label class="control-label member-income" style="margin-right: 25px;"><input tabindex="29" type="radio" value="4" name="average_income"> 5 Juta - 10 Juta</label>
                                <label class="control-label member-income" style="margin-right: 25px;"><input tabindex="29" type="radio" value="5" name="average_income"> > 10 Juta</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Pendidikan Terakhir
                            </label>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <label class="control-label member-last-education" style="margin-right: 18px;"><input tabindex="30" type="radio" checked="checked" value="0" name="last_education"> Tidak Sekolah</label>
                                <label class="control-label member-last-education" style="margin-right: 18px;"><input tabindex="30" type="radio" value="1" name="last_education"> SD</label>
                                <label class="control-label member-last-education" style="margin-right: 18px;"><input tabindex="30" type="radio" value="2" name="last_education"> SLTP</label>
                                <label class="control-label member-last-education" style="margin-right: 18px;"><input tabindex="30" type="radio" value="3" name="last_education"> SMU/SMK</label>
                                <label class="control-label member-last-education" style="margin-right: 18px;"><input tabindex="30" type="radio" value="4" name="last_education"> Diploma 1,2,3</label>
                                <label class="control-label member-last-education" style="margin-right: 18px;"><input tabindex="30" type="radio" value="5" name="last_education"> S1</label>
                                <label class="control-label member-last-education" style="margin-right: 18px;"><input tabindex="30" type="radio" value="6" name="last_education"> S2</label>
                                <label class="control-label member-last-education" style="margin-right: 18px;"><input tabindex="30" type="radio" value="7" name="last_education"> S3</label>
                            </div>
                        </div> 
                    </div>

                    <div id="tambah" class="tab-pane fade color-1">
                        <div class="form-group" style="margin-top: 8px;">
                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-ethnic-group">Nama Suku
                            </label>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    <input tabindex="32" type="text" name="ethnic_group" id="member-ethnic-group" class="form-control input-sm" placeholder="Nama Suku" value="">
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
                                <input tabindex="36" type="text" name="husband_wife_name" id="member-husband-wife-name" class="form-control input-sm" placeholder="Nama Suami/Istri" value="Anna Sri Dewi Sianto">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="member-child-name">Nama Anak
                            </label>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-9">
                                <input tabindex="37" id="member-child-name" type="text" name="child_name[]" class="form-control input-sm" placeholder="Nama Anak">
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
                                <label class="control-label member-is-reg-others-cu" style="margin-right: 25px;"><input tabindex="39" type="radio" class="change-handler" checked="checked" value="0" name="is_registered_others_cu"> Belum Pernah</label>
                                <label class="control-label member-is-reg-others-cu" style="margin-right: 25px;"><input tabindex="39" type="radio" class="change-handler" value="1" name="is_registered_others_cu"> Sudah Pernah</label>
                                <input type="text" name="others_cu_name" id="container-others-cu" class="form-control input-sm" placeholder="Nama CU" style="width: 200px; display: inline">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Pernah Pendidikan Dasar?
                            </label>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <label class="control-label member-is-diksar" style="margin-right: 25px;"><input tabindex="40" type="radio" class="change-handler" checked="checked" value="0" name="member_is_diksar"> Belum Pernah</label>
                                <label class="control-label member-is-diksar" style="margin-right: 25px;"><input tabindex="40" type="radio" class="change-handler" value="1" name="member_is_diksar"> Sudah Pernah</label>
                                <input data-inputmask="'alias': 'date'" type="text" name="member_diksar_date" id="container-diksar-date" class="form-control input-sm" placeholder="Tgl/Bln/Thn" style="width: 200px; display: inline">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Nama Ahli Waris
                            </label>
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6">
                                <input tabindex="41" id="member-heir-name" type="text" name="heir_name[]" class="form-control input-sm" placeholder="Nama Ahli Waris">
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                <input tabindex="42" id="member-heir-status" type="text" name="heir_status[]" class="form-control input-sm" placeholder="Status">
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                <button type="button" class="btn btn-block btn-dark btn-sm" onclick="addFormElement('heir')"><i class="fa fa-plus"></i>&nbsp; Tambah</button>
                            </div>
                        </div>
                        <div id="container-heir"></div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label" for="btn-upload-photo">Foto
                                </label>
                                <img id="preview-member-photo" src="" border="0" alt="Foto" style="max-width: 150px; max-height: 150px; margin: auto; display: block">
                                <br>
                                <input tabindex="43" type="file" name="img_photo" id="btn-upload-photo" data-validation="mime size" data-validation-max-size="1M" class="form-control" data-validation-allowing="jpg, jpeg, png, gif" accept=".gif, .jpg, .jpeg, .png">
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label" for="btn-upload-photo">Foto Kartu Identitas
                                </label>
                                <img id="preview-member-id" src="" border="0" alt="Foto Kartu Identitas" style="max-width: 150px; max-height: 150px; margin: auto; display: block">
                                <br>
                                <input tabindex="44" type="file" name="img_id" id="btn-upload-id" data-validation="mime size" data-validation-max-size="1M" class="form-control" data-validation-allowing="jpg, jpeg, png, gif" accept=".gif, .jpg, .jpeg, .png">
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                                <label class="control-label" for="btn-upload-photo">Tanda Tangan 
                                </label>
                                <img id="preview-member-signature" src="" border="0" alt="Tanda Tangan" style="max-width: 150px; max-height: 150px; margin: auto; display: block">
                                <br>
                                <input tabindex="45" type="file" name="img_signature" id="btn-upload-signature" data-validation="mime size" data-validation-max-size="1M" class="form-control" data-validation-allowing="jpg, jpeg, png, gif" accept=".gif, .jpg, .jpeg, .png">
                            </div>
                        </div>
                </div>
                            </div>
                        </div>

                        
                        
                <div class="modal-footer">
                    <button tabindex="46" type="submit" class="btn btn-primary hide-on-detail"><i class="fa fa-save"></i>&nbsp; Simpan <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end Modal edit-->

<!--FORM VALIDATOR-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    
    let gridMember;
    let gridALB;
    let gridALBSpecial;
    
    let colModel = [
        <?php if(privilege_view('update', $this->menu_privilege)):
            echo "{display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false},";
        endif; ?>
//            {display: 'Detail', name: 'detail', width: 40, sortable: false, align: 'center', datasource: false},
        {display: 'No. Anggota', name: 'member_code', width: 80, sortable: true, align: 'center'},
        {display: 'Nama', name: 'member_name', width: 200, sortable: true, align: 'left'},
//        {display: 'Status Keanggotaan', name: 'member_status', width: 150, sortable: true, align: 'center', hide: true},
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
        {display: 'RT Domisili', name: 'member_domicile_rt_number', width: 100, sortable: true, align: 'left', hide: true},
        {display: 'RW Domisili', name: 'member_domicile_rw_number', width: 100, sortable: true, align: 'left', hide: true},
        {display: 'Kode Pos Domisili', name: 'member_domicile_zipcode', width: 150, sortable: true, align: 'left', hide: true},
        {display: 'Kewarganegaraan', name: 'member_nationality', width: 110, sortable: true, align: 'center', hide: true},
        {display: 'Status Tempat Tinggal', name: 'member_residence_status', width: 150, sortable: true, align: 'left', hide: true},
        {display: 'Telepon', name: 'member_phone_number', width: 100, sortable: true, align: 'left'},
        {display: 'No. Handphone', name: 'member_mobilephone_number', width: 100, sortable: true, align: 'left'},
        {display: 'Pekerjaan', name: 'member_job', width: 100, sortable: true, align: 'left'},
        {display: 'Detail Pekerjaan', name: 'member_job_detail', width: 300, sortable: true, align: 'left'},
        {display: 'Bekerja di', name: 'member_working_in', width: 100, sortable: true, align: 'center', hide: true},
        {display: 'Rata-rata Penghasilan', name: 'member_average_income', width: 130, sortable: true, align: 'center', hide: true},
        {display: 'Pendidikan Terakhir', name: 'member_last_education', width: 100, sortable: true, align: 'left', hide: true},
        {display: 'Agama', name: 'member_religion', width: 150, sortable: true, align: 'center'},
        {display: 'Suku', name: 'member_ethnic_group', width: 100, sortable: true, align: 'left', hide: true},
        {display: 'Gol. Darah', name: 'member_blood_type', width: 100, sortable: true, align: 'center', hide: true},
        {display: 'Ukuran Baju', name: 'member_shirt_size', width: 100, sortable: true, align: 'center', hide: true},
        {display: 'Status Pernikahan', name: 'member_is_married', width: 110, sortable: true, align: 'center'},
        {display: 'Nama Suami/Istri', name: 'member_husband_wife_name', width: 200, sortable: true, align: 'left'},
        {display: 'Nama Anak', name: 'member_child_name', width: 200, sortable: true, align: 'left'},
        {display: 'Nama Ibu Kandung', name: 'member_mother_name', width: 200, sortable: true, align: 'left'},
        {display: 'Pernah Terdaftar di CU Lain', name: 'member_is_registered_others_cu', width: 80, sortable: true, align: 'left', hide: true},
        {display: 'Nama CU Lain', name: 'member_others_cu_name', width: 100, sortable: true, align: 'left', hide: true},
        {display: 'Nama Ahli Waris', name: 'member_heir_name', width: 200, sortable: true, align: 'left'},
        {display: 'Status Ahli Waris', name: 'member_heir_status', width: 200, sortable: true, align: 'left'},
        {display: 'Waktu Daftar', name: 'member_join_datetime', width: 200, sortable: true, align: 'center'},
        {display: 'Nama Administrator Input', name: 'member_input_admin_name', width: 200, sortable: true, align: 'left', hide: true},
        {display: 'Waktu Administrator Input', name: 'member_input_datetime', width: 100, sortable: true, align: 'center', hide: true},
        {display: 'Unit', name: 'branch_name', width: 150, sortable: true, align: 'left'},
    ];
    
    function openModalEdit(id){
        $('#form-member').trigger("reset");
        $('#container-job-other, #container-others-cu, #container-diksar-date').hide();
        $('span.form-error').remove();
        $('.has-success').removeClass('has-success');
        $('.has-error').removeClass('has-error');
        $('.valid .error').removeClass('valid error').css('border-color', '');
        
        $('#container-member-child').html('');
        $('#container-heir').html('');
        
        $('#modal-edit .modal-body').animate({scrollTop: '0px'}, 300);
        
        ajaxRequest('common/general/membership/member/get_detail', 'GET', {id: id}, function (res){
            let data = res.data;
            
            $('#member-id').val(data.member_id);
            
            generateSelect2('#member-province', [], '', '', false, '', '--Pilih Provinsi--', '').prop('disabled', true);
            generateSelect2('#member-city', [], '', '', false, '', '--Pilih Kota--', '').prop('disabled', true);
            generateSelect2('#member-subdistrict', [], '', '', false, '', '--Pilih Kecamatan--', '').prop('disabled', true);
            generateSelect2('#member-kelurahan', [], '', '', false, '', '--Pilih Kelurahan--', '').prop('disabled', true);
            
            generateSelect2('#member-domicile-province', [], '', '', false, '', '--Pilih Provinsi--', '').prop('disabled', true);
            generateSelect2('#member-domicile-city', [], '', '', false, '', '--Pilih Kota--', '').prop('disabled', true);
            generateSelect2('#member-domicile-subdistrict', [], '', '', false, '', '--Pilih Kecamatan--', '').prop('disabled', true);
            generateSelect2('#member-domicile-kelurahan', [], '', '', false, '', '--Pilih Kelurahan--', '').prop('disabled', true);

            ajaxRequest('common/general/option/province', 'GET', '', function(res_province){
                if(res_province.status == 200){
                    let dataProvince = res_province.data.results;
                    if(dataProvince.length > 0){
                        let provinceId = 0;
                        let provinceIndex = arrayColumn(dataProvince, 'province_name').indexOf(data.member_province);
                        if(provinceIndex != -1){
                            provinceId = dataProvince[provinceIndex].province_id;
                            generateSelect2('#member-province', dataProvince, 'province_id', 'province_name', provinceId, 'province_id', '--Pilih Provinsi--', '').prop('disabled', false);

                            ajaxRequest('common/general/option/city', 'GET', {province_id: provinceId}, function(res_city){
                                if(res_city.status == 200){
                                    let dataCity = res_city.data.results;
                                    if(dataCity.length > 0){
                                        let cityId = 0;
                                        let cityIndex = arrayColumn(dataCity, 'city_name').indexOf(data.member_city);
                                        if(cityIndex != -1){
                                            cityId = dataCity[cityIndex].city_id;
                                            generateSelect2('#member-city', dataCity, 'city_id', 'city_name', cityId, 'city_id', '--Pilih Kota--', '').prop('disabled', false);

                                            ajaxRequest('common/general/option/subdistrict', 'GET', {city_id: cityId}, function(res_subdistrict){
                                                if(res_subdistrict.status == 200){
                                                    let dataSubdistrict = res_subdistrict.data.results;
                                                    if(dataSubdistrict.length > 0){
                                                        let subdistrictId = 0;
                                                        let subdistrictIndex = arrayColumn(dataSubdistrict, 'subdistrict_name').indexOf(data.member_subdistrict);
                                                        if(subdistrictIndex != -1){
                                                            subdistrictId = dataSubdistrict[subdistrictIndex].subdistrict_id
                                                            generateSelect2('#member-subdistrict', dataSubdistrict, 'subdistrict_id', 'subdistrict_name', subdistrictId, 'subdistrict_id', '--Pilih Kecamatan--', '').prop('disabled', false);

                                                            ajaxRequest('common/general/option/village', 'GET', {subdistrict_id: subdistrictId}, function(res_village){
                                                                if(res_village.status == 200){
                                                                    let dataVillage = res_village.data.results;
                                                                    if(dataVillage.length > 0){
                                                                        let villageId = 0;
                                                                        let villageIndex = arrayColumn(dataVillage, 'village_name').indexOf(data.member_kelurahan);
                                                                        if(villageIndex != -1){
                                                                            villageId = dataVillage[villageIndex].village_id
                                                                            generateSelect2('#member-kelurahan', dataVillage, 'village_id', 'village_name', villageId, 'village_id', '--Pilih Kelurahan--', '').prop('disabled', false);
                                                                        }else{
                                                                            generateSelect2('#member-kelurahan', dataVillage, 'village_id', 'village_name', false, '', '--Pilih Kelurahan--', '').prop('disabled', false);
                                                                        }
                                                                    }
                                                                }else{
                                                                    alert(res_village.msg);
                                                                }
                                                            });
                                                        }else{
                                                            generateSelect2('#member-subdistrict', dataSubdistrict, 'subdistrict_id', 'subdistrict_name', false, '', '--Pilih Kecamatan--', '').prop('disabled', false);
                                                        }
                                                    }
                                                }else{
                                                    alert(res_subdistrict.msg);
                                                }
                                            });
                                        }else{
                                            console.log(dataCity);
                                            generateSelect2('#member-city', dataCity, 'city_id', 'city_name', false, '', '--Pilih Kota--', '').prop('disabled', false);
                                        }
                                    }
                                }else{
                                    alert(res_city.msg);
                                }
                            });
                        }else{
                            generateSelect2('#member-province', dataProvince, 'province_id', 'province_name', false, '', '--Pilih Provinsi--', '').prop('disabled', false);
                        }
                    }
                }else{
                    alert(res_province.msg);
                }
            });
            
            ajaxRequest('common/general/option/province', 'GET', '', function(res_province){
                if(res_province.status == 200){
                    let dataProvince = res_province.data.results;
                    if(dataProvince.length > 0){
                        let provinceId = 0;
                        let provinceIndex = arrayColumn(dataProvince, 'province_name').indexOf(data.member_domicile_province);
                        if(provinceIndex != -1){
                            provinceId = dataProvince[provinceIndex].province_id;
                            generateSelect2('#member-domicile-province', dataProvince, 'province_id', 'province_name', provinceId, 'province_id', '--Pilih Provinsi--', '').prop('disabled', false);

                            ajaxRequest('common/general/option/city', 'GET', {province_id: provinceId}, function(res_city){
                                if(res_city.status == 200){
                                    let dataCity = res_city.data.results;
                                    if(dataCity.length > 0){
                                        let cityId = 0;
                                        let cityIndex = arrayColumn(dataCity, 'city_name').indexOf(data.member_domicile_city);
                                        if(cityIndex != -1){
                                            cityId = dataCity[cityIndex].city_id;
                                            generateSelect2('#member-domicile-city', dataCity, 'city_id', 'city_name', cityId, 'city_id', '--Pilih Kota--', '').prop('disabled', false);

                                            ajaxRequest('common/general/option/subdistrict', 'GET', {city_id: cityId}, function(res_subdistrict){
                                                if(res_subdistrict.status == 200){
                                                    let dataSubdistrict = res_subdistrict.data.results;
                                                    if(dataSubdistrict.length > 0){
                                                        let subdistrictId = 0;
                                                        let subdistrictIndex = arrayColumn(dataSubdistrict, 'subdistrict_name').indexOf(data.member_domicile_subdistrict);
                                                        if(subdistrictIndex != -1){
                                                            subdistrictId = dataSubdistrict[subdistrictIndex].subdistrict_id
                                                            generateSelect2('#member-domicile-subdistrict', dataSubdistrict, 'subdistrict_id', 'subdistrict_name', subdistrictId, 'subdistrict_id', '--Pilih Kecamatan--', '').prop('disabled', false);

                                                            ajaxRequest('common/general/option/village', 'GET', {subdistrict_id: subdistrictId}, function(res_village){
                                                                if(res_village.status == 200){
                                                                    let dataVillage = res_village.data.results;
                                                                    if(dataVillage.length > 0){
                                                                        let villageId = 0;
                                                                        let villageIndex = arrayColumn(dataVillage, 'village_name').indexOf(data.member_domicile_kelurahan);
                                                                        if(villageIndex != -1){
                                                                            villageId = dataVillage[villageIndex].village_id
                                                                            generateSelect2('#member-domicile-kelurahan', dataVillage, 'village_id', 'village_name', villageId, 'village_id', '--Pilih Kelurahan--', '').prop('disabled', false);
                                                                        }else{
                                                                            generateSelect2('#member-domicile-kelurahan', dataVillage, 'village_id', 'village_name', false, '', '--Pilih Kelurahan--', '').prop('disabled', false);
                                                                        }
                                                                    }
                                                                }else{
                                                                    alert(res_village.msg);
                                                                }
                                                            });
                                                        }else{
                                                            generateSelect2('#member-domicile-subdistrict', dataSubdistrict, 'subdistrict_id', 'subdistrict_name', false, '', '--Pilih Kecamatan--', '').prop('disabled', false);
                                                        }
                                                    }
                                                }else{
                                                    alert(res_subdistrict.msg);
                                                }
                                            });
                                        }else{
                                            console.log(dataCity);
                                            generateSelect2('#member-domicile-city', dataCity, 'city_id', 'city_name', false, '', '--Pilih Kota--', '').prop('disabled', false);
                                        }
                                    }
                                }else{
                                    alert(res_city.msg);
                                }
                            });
                        }else{
                            generateSelect2('#member-domicile-province', dataProvince, 'province_id', 'province_name', false, '', '--Pilih Provinsi--', '').prop('disabled', false);
                        }
                    }
                }else{
                    alert(res_province.msg);
                }
            });
            
            
//            $('#member-join-date').val(moment(data.member_join_datetime).format('DD/MM/YYYY'));
            $('#member-name').val(data.member_name);
            $('#member-id-type').val(data.member_identity_type).change();
            $('#member-id-number').val(data.member_identity_number);
            $('.member-gender input[type=radio][value='+data.member_gender+']').prop('checked', true);
            $('#member-birthplace').val(data.member_birthplace);
            $('#member-birthdate').val(moment(data.member_birthdate).format('DD/MM/YYYY'));
            $('.member-nationality input[type=radio][value='+data.member_nationality+']').prop('checked', true);
            $('#member-address').val(data.member_address);
            $('#member-address-domicile').val(data.member_address_domicile);
            
            $('#member-rt').val(data.member_rt_number);
            $('#member-rw').val(data.member_rw_number);
            $('#member-zipcode').val(data.member_zipcode);
            
            $('#member-domicile-rt').val(data.member_domicile_rt_number);
            $('#member-domicile-rw').val(data.member_domicile_rw_number);
            $('#member-domicile-zipcode').val(data.member_domicile_zipcode);
            
            $('#member-phone').val(data.member_phone_number);
            $('#member-mobilephone').val(data.member_mobilephone_number);
           
            if(data.member_job != ''){
                let existJob = $('.member-job input[type=radio][value="'+data.member_job+'"]');
                if(existJob.length > 0){
                    $('.member-job input[type=radio][value="'+data.member_job+'"]').prop('checked', true);
                    $('#container-job-other').removeAttr("name");
                }else{
                    $('.member-job input[type=radio][value="Lain-lain"]').prop('checked', true);
                    $('#container-job-other').val(data.member_job).show();
                    $('#container-job-other').attr("name", "job");
                }
            }
            
            $('#member-job-detail').val(data.member_job_detail);
            
            $('.member-income input[type=radio][value='+data.member_average_income+']').prop('checked', true);
            
            $('.member-last-education input[type=radio][value='+data.member_last_education+']').prop('checked', true);
            
            $('.member-religion input[type=radio][value='+data.member_religion+']').prop('checked', true);
            
            $('.member-residence-status input[type=radio][value='+data.member_residence_status+']').prop('checked', true);
            $('.member-working-in input[type=radio][value='+data.member_working_in+']').prop('checked', true);
            $('#member-ethnic-group').val(data.member_ethnic_group);
            $('.member-blood-type input[type=radio][value='+data.member_blood_type+']').prop('checked', true);
            $('.member-shirt-size input[type=radio][value='+data.member_shirt_size+']').prop('checked', true);
            
            $('.member-is-married input[type=radio][value='+data.member_is_married+']').prop('checked', true);
            
            $('#member-husband-wife-name').val(data.member_husband_wife_name);
            
            $('#member-mother-name').val(data.member_mother_name);
            
            $('.member-is-reg-others-cu input[type=radio][value='+data.member_is_registered_others_cu+']').prop('checked', true);
            if(data.member_is_registered_others_cu != 0){
                $('#container-others-cu').val(data.member_others_cu_name).show();
            }
            
            $('.member-is-diksar input[type=radio][value='+data.member_is_diksar+']').prop('checked', true);
            if(data.member_is_diksar != 0){
                $('#container-diksar-date').val(moment(data.member_diksar_date).format('DD/MM/YYYY')).show();
            }
            
            if(data.member_child_name != ''){
                let arrChild = data.member_child_name.split("#");
                
                if(arrChild.length > 0){
                    arrChild.forEach(function(item, index){
                        if(index == 0){
                            $('#member-child-name').val(item);
                        }else{
                            $('#container-member-child').append(`<div class="form-group">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                                                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-9">
                                                                        <input type="text" name="child_name[]" class="form-control input-sm" placeholder="Nama Anak" value="${item}">
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                                                        <button type="button" class="btn btn-block btn-danger btn-sm" onclick="deleteFormElement(this)"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
                                                                    </div>
                                                                </div>`);
                        }
                    });
                }
            }
            
            if(data.member_heir_name != ''){
                let arrHeirName = data.member_heir_name.split("#");
                let arrHeirStatus = data.member_heir_status.split("#");
                
                if(arrHeirName.length > 0){
                    arrHeirName.forEach(function(item, index){
                        if(index == 0){
                            $('#member-heir-name').val(item);
                            $('#member-heir-status').val(arrHeirStatus[index]);
                        }else{
                            $('#container-heir').append(`<div class="form-group">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6">
                                                                <input type="text" name="heir_name[]" class="form-control input-sm" placeholder="Nama Ahli Waris" value="${item}">
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                                                <input type="text" name="heir_status[]" class="form-control input-sm" placeholder="Status" value="${arrHeirStatus[index]}">
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                                                <button type="button" class="btn btn-block btn-danger btn-sm" onclick="deleteFormElement(this)"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
                                                            </div>
                                                        </div>`);
                        }
                    });
                }
            }
            
            if(data.member_photo_path != "" && data.member_photo_filename != ""){
                $('#preview-member-photo').attr('src', siteUrl + data.member_photo_path + data.member_photo_filename);
            }else{
                $('#preview-member-photo').attr('src', '<?php echo THEMES_BACKEND . '/images/no-img.jpg'; ?>');
            }
            
            if(data.member_identity_path != "" && data.member_identity_filename != ""){
                $('#preview-member-id').attr('src', siteUrl + data.member_identity_path + data.member_identity_filename);
            }else{
                $('#preview-member-id').attr('src', '<?php echo THEMES_BACKEND . '/images/no-img.jpg'; ?>');
            }
            
            if(data.member_signature_path != "" && data.member_signature_filename != ""){
                $('#preview-member-signature').attr('src', siteUrl + data.member_signature_path + data.member_signature_filename);
            }else{
                $('#preview-member-signature').attr('src', '<?php echo THEMES_BACKEND . '/images/no-img.jpg'; ?>');
            }
            
            $('#modal-edit').modal({
                backdrop: 'static',
                keyboard: false
            }, 'show');
        });
    }
    
    function addFormElement(type){
        if(type == 'child'){
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
        if(type == 'heir'){
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
    
    function deleteFormElement(element){
        $(element).parent().parent().remove();
    }
    
    $(document).ready(function (){
        
        $('.my-select2').select2();
      

//        
        
        $('#btn-upload-photo, #btn-upload-id, #btn-upload-signature').on('change', function (){
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
        
        $('.change-handler').on('change', function (){
            let name = $(this).attr('name');
            let value = $(this).val();
            if(name == 'job'){
                if(value == 'Lain-lain'){
                    $('#container-job-other').show();
                }else{
                    $('#container-job-other').hide();
                }
            }
            if(name == 'is_registered_others_cu'){
                if(value == 1){
                    $('#container-others-cu').show();
                }else{
                    $('#container-others-cu').hide();
                }
            }
            if(name == 'member_is_diksar'){
                if(value == 1){
                    $('#container-diksar-date').show();
                }else{
                    $('#container-diksar-date').hide();
                }
            }
        });
        
        $('#form-member').on('submit', function (e){
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
            formData.set('kelurahan', '');
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
                success: function (res) {
                    if (res.status == 200) {
                        $('#modal-edit').modal('hide');
                        $('#form-member button[type="submit"]').removeAttr('disabled');
                        $('#gridview').flexReload();
                        $('#gridview-alb').flexReload();
                        $('#gridview-alb-special').flexReload();
                        let message_class = 'response_confirmation alert alert-success';

                        $("#response_message").finish();

                        $("#response_message").addClass(message_class);
                        $("#response_message").slideDown("fast");
                        $("#response_message").html(res.data);
                        $("#response_message").delay(10000).slideUp(1000, function () {
                            $("#response_message").removeClass(message_class);
                        });
                    } else {
                        $('#modal-edit .modal-body').animate({scrollTop: '0px'}, 300);
                        $('#form-member button[type="submit"]').removeAttr('disabled');
                        $("#modal-response-message-member").finish();

                        $("#modal-response-message-member").slideDown("fast");
                        $('#modal-response-message-member').html(res.msg);
                        $("#modal-response-message-member").delay(10000).slideUp(1000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#form-member button[type="submit"]').removeAttr('disabled');
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });
        
        $('#member-province').on('change', function (e) {
            let provinceId = $(this).val();
            if (provinceId) {
                ajaxRequest('common/general/option/city', 'GET', {province_id: provinceId}, function(res){
                    if(res.status == 200){
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
                    }else{
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

        $('#member-city').on('change', function (e) {
            let cityId = $(this).val();
            if (cityId) {
                ajaxRequest('common/general/option/subdistrict', 'GET', {city_id: cityId}, function(res){
                    if(res.status == 200){
                        let dataSubdistrict = res.data.results;
                        generateSelect2('#member-subdistrict', dataSubdistrict, 'subdistrict_id', 'subdistrict_name', false, '', '--Pilih Kecamatan--', '')
                                .prop('disabled', false).attr('data-validation', 'required').prev().find('span').text('*');
                        $('span.form-error').remove();
                        $('.has-success').removeClass('has-success');
                        $('.valid .error').removeClass('valid error').css('border-color', '');
                        generateSelect2('#member-kelurahan', [], '', '', false, '', '--Pilih Kelurahan--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('*');
                    }else{
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

        $('#member-subdistrict').on('change', function (e) {
            let subdistrictId = $(this).val();
            if (subdistrictId) {
                ajaxRequest('common/general/option/village', 'GET', {subdistrict_id: subdistrictId}, function(res){
                    if(res.status == 200){
                        let dataVillage = res.data.results;
                        generateSelect2('#member-kelurahan', dataVillage, 'village_id', 'village_name', false, '', '--Pilih Kelurahan--', '')
                                .prop('disabled', false).attr('data-validation', 'required').prev().find('span').text('*');
                        $('span.form-error').remove();
                        $('.has-success').removeClass('has-success');
                        $('.valid .error').removeClass('valid error').css('border-color', '');
                    }else{
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
        
        $('#member-domicile-province').on('change', function (e) {
            let provinceId = $(this).val();
            if (provinceId) {
                ajaxRequest('common/general/option/city', 'GET', {province_id: provinceId}, function(res){
                    if(res.status == 200){
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
                    }else{
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

        $('#member-domicile-city').on('change', function (e) {
            let cityId = $(this).val();
            if (cityId) {
                ajaxRequest('common/general/option/subdistrict', 'GET', {city_id: cityId}, function(res){
                    if(res.status == 200){
                        let dataSubdistrict = res.data.results;
                        generateSelect2('#member-domicile-subdistrict', dataSubdistrict, 'subdistrict_id', 'subdistrict_name', false, '', '--Pilih Kecamatan--', '')
                                .prop('disabled', false).attr('data-validation', 'required').prev().find('span').text('*');
                        $('span.form-error').remove();
                        $('.has-success').removeClass('has-success');
                        $('.valid .error').removeClass('valid error').css('border-color', '');
                        generateSelect2('#member-domicile-kelurahan', [], '', '', false, '', '--Pilih Kelurahan--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('*');
                    }else{
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

        $('#member-domicile-subdistrict').on('change', function (e) {
            let subdistrictId = $(this).val();
            if (subdistrictId) {
                ajaxRequest('common/general/option/village', 'GET', {subdistrict_id: subdistrictId}, function(res){
                    if(res.status == 200){
                        let dataVillage = res.data.results;
                        generateSelect2('#member-domicile-kelurahan', dataVillage, 'village_id', 'village_name', false, '', '--Pilih Kelurahan--', '')
                                .prop('disabled', false).attr('data-validation', 'required').prev().find('span').text('*');
                        $('span.form-error').remove();
                        $('.has-success').removeClass('has-success');
                        $('.valid .error').removeClass('valid error').css('border-color', '');
                    }else{
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
        
        let urlLocation = new URL(window.location);
        let params = new URLSearchParams(urlLocation.search);
        if(params.get('page') != null){
            if(params.get('page') == 'alb'){
                $('#container-tabs a[data-toggle="tab"][href="#tab-alb"]').click();
                loadGridALB();
            }
            if(params.get('page') == 'alb-special'){
                $('#container-tabs a[data-toggle="tab"][href="#tab-alb-special"]').click();
                loadGridALBSpecial();
            }
        }else{
            $('#container-tabs a[data-toggle="tab"][href="#tab-member"]').click();
            loadGridMember();
        }
        
        $('#tabs-edit a[data-toggle="tab"]').on('show.bs.tab', function (e) {
            let target = $(e.target).attr("href"); // activated tab
            if (target == '#pk' || target == '#tambah') {
                let isError = false;
                
                $("#form-member input, #form-member select").validate(function (valid, elem) {
                    if (!valid) {
                        isError = true;
                    }
                });
                if (isError) {
                    setTimeout(function (){
                        $('#tabs-edit a[data-toggle="tab"][href="#data"]').click();
                        $('#modal-edit .modal-body').animate({scrollTop: '0px'}, 300);
                    }, 200);
                }
            }
        });
        
        $('#container-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var uri = 'show';
            var target = $(e.target).attr("href"); // activated tab
            if (target === '#tab-member') {
                loadGridMember();
            } else if (target === '#tab-alb') {
                loadGridALB();
                uri = 'show?page=alb';
            }else if (target === '#tab-alb-special') {
                loadGridALBSpecial();
                uri = 'show?page=alb-special';
            }
            window.history.replaceState({}, '', uri);
        });
        
        $('.change-handler').on('change', function (){
            let name = $(this).attr('name');
            let value = $(this).val();
            if(name == 'job'){
                if(value == 'Lain-lain'){
                    $('#container-job-other').show();
                    $('#container-job-other').attr("name", "job");
                }else{
                    $('#container-job-other').hide();
                    $('#container-job-other').removeAttr("name");
                }
            }
            if(name == 'is_registered_others_cu'){
                if(value == 1){
                    $('#container-others-cu').show();
                    $('#container-job-other').attr("name", "job");
                }else{
                    $('#container-others-cu').hide();
                    $('#container-job-other').removeAttr("name");
                }
            }
            if(name == 'member_is_diksar'){
                if(value == 1){
                    $('#container-diksar-date').show();
                    $('#container-job-other').attr("name", "job");
                }else{
                    $('#container-diksar-date').hide();
                    $('#container-job-other').removeAttr("name");
                }
            }
        });
    });
    
    function loadGridMember(){
        if(typeof gridMember == "undefined"){
            gridMember = $("#gridview").flexigrid({
                url: siteUrl + 'membership/member/get_data',
                params: [{name: "member_status", value: 'member'}],
                dataType: 'json',
                colModel: colModel,
                buttons_right: [
                    <?php if(privilege_view('export', $this->menu_privilege)):
                        echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: myExport, urlaction: '" . site_url("membership/member/export_data_member") . "'}";
                    endif; ?>
                ],
                searchitems: [
                    {display: 'Unit', name: 'branch_name', type:'text'},
                    {display: 'No. Anggota', name: 'member_code', type:'text'},
                    {display: 'Nama', name: 'member_name', type:'text'},
                    {display: 'No. Identitas', name: 'member_identity_number', type:'text'},
                    {display: 'Tipe Identitas', name: 'member_identity_type', type:'select', option:'0:NIK|1:PASSPORT'},
                    {display: 'Jenis Kelamin', name: 'member_gender', type:'select', option:'0:Laki-laki|1:Perempuan'},
                    {display: 'Tanggal Lahir', name: 'member_birthdate', type:'text'},
                    {display: 'Tempat Lahir', name: 'member_birthplace', type:'text'},
                    {display: 'Alamat', name: 'member_address', type:'text'},
                    {display: 'Provinsi', name: 'member_province', type:'text'},
                    {display: 'Kota', name: 'member_city', type:'text'},
                    {display: 'Kecamatan', name: 'member_subdistrict', type:'text'},
                    {display: 'Kelurahan', name: 'member_kelurahan', type:'text'},
                    {display: 'RT', name: 'member_rt_number', type:'text'},
                    {display: 'RW', name: 'member_rw_number', type:'text'},
                    {display: 'Kode Pos', name: 'member_zipcode', type:'text'},
                    {display: 'Domisili', name: 'member_address_domicile', type:'text'},
                    {display: 'Provinsi Domisili', name: 'member_domicile_province', type: 'text'},
                    {display: 'Kota Domisili', name: 'member_domicile_city', type: 'text'},
                    {display: 'Kecamatan Domisili', name: 'member_domicile_subdistrict', type: 'text'},
                    {display: 'Kelurahan Domisili', name: 'member_domicile_kelurahan', type: 'text'},
                    {display: 'RT Domisili', name: 'member_domicile_rt_number', type: 'text'},
                    {display: 'RW Domisili', name: 'member_domicile_rw_number', type: 'text'},
                    {display: 'Kode Pos Domisili', name: 'member_domicile_zipcode', type: 'text'},
                    {display: 'Status Tempat Tinggal', name: 'member_residence_status', type: 'select', option: '0:Tidak Diisi|1:Milik Sendiri|2:Sewa/Kontrak|3:Menumpang|4:Ikut Orang Tua'},
                    {display: 'Telepon', name: 'member_phone_number', type:'text'},
                    {display: 'No. Handphone', name: 'member_mobilephone_number', type:'text'},
                    {display: 'Pekerjaan', name: 'member_job', type:'text'},
                    {display: 'Bekerja di', name: 'member_working_in', type: 'select', option: '0:Indonesia|1:Luar Negeri'},
                    {display: 'Rata-rata Penghasilan', name: 'member_average_income', type:'select', option:'0:< 1jt|1:1jt - 3jt|2:3jt - 5jt|3:5jt - 10jt|4:>10jt'},
                    {display: 'Pendidikan Terakhir', name: 'member_last_education', type:'select', option:'0:Tidak Sekolah|1:SD|2:SLTP|3:SMU/SMK|4:Diploma 1,2,3|5:S1|6:S2|7:S3'},
                    {display: 'Agama', name: 'member_religion', type:'select', option:'0:Tidak Diisi|1:Islam|2:Kristen|3:Katolik|4:Hindu|5:Budha|6:Kong Hu Cu|7:Aliran Kepercayaan|8:Lainnya'},
                    {display: 'Suku', name: 'member_ethnic_group', type: 'text'},
                    {display: 'Gol. Darah', name: 'member_blood_type', type: 'select', option: '0:Tidak Diisi|1:A|2:B|3:AB|4:O'},
                    {display: 'Ukuran Baju', name: 'member_shirt_size', type: 'select', option: '0:Tidak Diisi|1:S|2:M|3:L|4:XL|5:XXL|6:XXXL'},
                    {display: 'Status Pernikahan', name: 'member_is_married', type:'select', option:'0:Belum Menikah|1:Sudah Menikah|2:Janda Mati|3:Janda Cerai|4:Duda Mati|5:Duda Cerai'},
                    {display: 'Nama Suami/Istri', name: 'member_husband_wife_name', type:'text'},
                    {display: 'Nama Anak', name: 'member_child_name', type:'text'},
                    {display: 'Nama Ibu Kandung', name: 'member_mother_name', type:'text'},
                    {display: 'Pernah Terdaftar di CU Lain', name: 'member_is_registered_others_cu', type:'text'},
                    {display: 'Nama CU Lain', name: 'member_others_cu_name', type:'text'},
                    {display: 'Nama Ahli Waris', name: 'member_heir_name', type:'text'},
                    {display: 'Status Ahli Waris', name: 'member_heir_status', type:'text'},
                    {display: 'Waktu Daftar', name: 'member_join_datetime', type:'date'},
                    {display: 'Nama Administrator Input', name: 'member_input_admin_name', type:'text'},
                    {display: 'Waktu Administrator Input', name: 'member_input_datetime', type:'date'},
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
                singleSelect: false
            });
        }else{
             $("#gridview").flexOptions({
                url: siteUrl + 'membership/member/get_data',
                params: [{name: "member_status", value: 'member'}],
            }).flexClearReload();
        }
    }
    
    function loadGridALB(){
        if(typeof gridALB == "undefined"){
            gridALB = $("#gridview-alb").flexigrid({
                url: siteUrl + 'membership/member/get_data',
                params: [{name: "member_status", value: 'alb'}],
                dataType: 'json',
                colModel: colModel,
                buttons_right: [
                    <?php if(privilege_view('export', $this->menu_privilege)):
                        echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: myExport, urlaction: '" . site_url("membership/member/export_data_member") . "'}";
                    endif; ?>
                ],
                searchitems: [
                    {display: 'Unit', name: 'branch_name', type:'text'},
                    {display: 'No. Anggota', name: 'member_code', type:'text'},
                    {display: 'Nama', name: 'member_name', type:'text'},
                    {display: 'Status Keanggotaan', name: 'member_status', type: 'select', option: '1:ALB Anak|2:ALB WNA|3:ALB Luar Negeri'},
                    {display: 'No. Identitas', name: 'member_identity_number', type:'text'},
                    {display: 'Tipe Identitas', name: 'member_identity_type', type:'select', option:'0:NIK|1:PASSPORT'},
                    {display: 'Jenis Kelamin', name: 'member_gender', type:'select', option:'0:Laki-laki|1:Perempuan'},
                    {display: 'Tanggal Lahir', name: 'member_birthdate', type:'text'},
                    {display: 'Tempat Lahir', name: 'member_birthplace', type:'text'},
                    {display: 'Alamat', name: 'member_address', type:'text'},
                    {display: 'Provinsi', name: 'member_province', type:'text'},
                    {display: 'Kota', name: 'member_city', type:'text'},
                    {display: 'Kecamatan', name: 'member_subdistrict', type:'text'},
                    {display: 'Kelurahan', name: 'member_kelurahan', type:'text'},
                    {display: 'RT', name: 'member_rt_number', type:'text'},
                    {display: 'RW', name: 'member_rw_number', type:'text'},
                    {display: 'Kode Pos', name: 'member_zipcode', type:'text'},
                    {display: 'Domisili', name: 'member_address_domicile', type:'text'},
                    {display: 'Provinsi Domisili', name: 'member_domicile_province', type: 'text'},
                    {display: 'Kota Domisili', name: 'member_domicile_city', type: 'text'},
                    {display: 'Kecamatan Domisili', name: 'member_domicile_subdistrict', type: 'text'},
                    {display: 'Kelurahan Domisili', name: 'member_domicile_kelurahan', type: 'text'},
                    {display: 'RT Domisili', name: 'member_domicile_rt_number', type: 'text'},
                    {display: 'RW Domisili', name: 'member_domicile_rw_number', type: 'text'},
                    {display: 'Kode Pos Domisili', name: 'member_domicile_zipcode', type: 'text'},
                    {display: 'Status Tempat Tinggal', name: 'member_residence_status', type: 'select', option: '0:Tidak Diisi|1:Milik Sendiri|2:Sewa/Kontrak|3:Menumpang|4:Ikut Orang Tua'},
                    {display: 'Telepon', name: 'member_phone_number', type:'text'},
                    {display: 'No. Handphone', name: 'member_mobilephone_number', type:'text'},
                    {display: 'Pekerjaan', name: 'member_job', type:'text'},
                    {display: 'Bekerja di', name: 'member_working_in', type: 'select', option: '0:Indonesia|1:Luar Negeri'},
                    {display: 'Rata-rata Penghasilan', name: 'member_average_income', type:'select', option:'0:< 1jt|1:1jt - 3jt|2:3jt - 5jt|3:5jt - 10jt|4:>10jt'},
                    {display: 'Pendidikan Terakhir', name: 'member_last_education', type:'select', option:'0:Tidak Sekolah|1:SD|2:SLTP|3:SMU/SMK|4:Diploma 1,2,3|5:S1|6:S2|7:S3'},
                    {display: 'Agama', name: 'member_religion', type:'select', option:'0:Tidak Diisi|1:Islam|2:Kristen|3:Katolik|4:Hindu|5:Budha|6:Kong Hu Cu|7:Aliran Kepercayaan|8:Lainnya'},
                    {display: 'Suku', name: 'member_ethnic_group', type: 'text'},
                    {display: 'Gol. Darah', name: 'member_blood_type', type: 'select', option: '0:Tidak Diisi|1:A|2:B|3:AB|4:O'},
                    {display: 'Ukuran Baju', name: 'member_shirt_size', type: 'select', option: '0:Tidak Diisi|1:S|2:M|3:L|4:XL|5:XXL|6:XXXL'},
                    {display: 'Status Pernikahan', name: 'member_is_married', type:'select', option:'0:Belum Menikah|1:Sudah Menikah|2:Janda Mati|3:Janda Cerai|4:Duda Mati|5:Duda Cerai'},
                    {display: 'Nama Suami/Istri', name: 'member_husband_wife_name', type:'text'},
                    {display: 'Nama Anak', name: 'member_child_name', type:'text'},
                    {display: 'Nama Ibu Kandung', name: 'member_mother_name', type:'text'},
                    {display: 'Pernah Terdaftar di CU Lain', name: 'member_is_registered_others_cu', type:'text'},
                    {display: 'Nama CU Lain', name: 'member_others_cu_name', type:'text'},
                    {display: 'Nama Ahli Waris', name: 'member_heir_name', type:'text'},
                    {display: 'Status Ahli Waris', name: 'member_heir_status', type:'text'},
                    {display: 'Waktu Daftar', name: 'member_join_datetime', type:'date'},
                    {display: 'Nama Administrator Input', name: 'member_input_admin_name', type:'text'},
                    {display: 'Waktu Administrator Input', name: 'member_input_datetime', type:'date'},
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
                singleSelect: false
            });
        }else{
             $("#gridview-alb").flexOptions({
                url: siteUrl + 'membership/member/get_data',
                params: [{name: "member_status", value: 'alb'}],
            }).flexClearReload();
        }
    }
    
    function loadGridALBSpecial(){
        if(typeof gridALBSpecial == "undefined"){
            gridALBSpecial = $("#gridview-alb-special").flexigrid({
                url: siteUrl + 'membership/member/get_data',
                params: [{name: "member_status", value: 'alb-special'}],
                dataType: 'json',
                colModel: [
                    <?php if(privilege_view('update', $this->menu_privilege)):
                        echo "{display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false},";
                    endif;
                    echo "
                        {display: 'No. Anggota', name: 'member_code', width: 80, sortable: true, align: 'center'},
                        {display: 'Nama', name: 'member_name', width: 200, sortable: true, align: 'left'},
                        {display: 'Status Keanggotaan', name: 'member_status', width: 150, sortable: true, align: 'center', hide: true},
                        {display: 'Uang Pangkal', name: 'member_entrance_fee_paid_off', width: 100, sortable: true, align: 'center'},
                        {display: 'Diksar', name: 'member_is_diksar', width: 100, sortable: true, align: 'center'},
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
                        {display: 'RT Domisili', name: 'member_domicile_rt_number', width: 100, sortable: true, align: 'left', hide: true},
                        {display: 'RW Domisili', name: 'member_domicile_rw_number', width: 100, sortable: true, align: 'left', hide: true},
                        {display: 'Kode Pos Domisili', name: 'member_domicile_zipcode', width: 150, sortable: true, align: 'left', hide: true},
                        {display: 'Kewarganegaraan', name: 'member_nationality', width: 110, sortable: true, align: 'center', hide: true},
                        {display: 'Status Tempat Tinggal', name: 'member_residence_status', width: 150, sortable: true, align: 'left', hide: true},
                        {display: 'Telepon', name: 'member_phone_number', width: 100, sortable: true, align: 'left'},
                        {display: 'No. Handphone', name: 'member_mobilephone_number', width: 100, sortable: true, align: 'left'},
                        {display: 'Pekerjaan', name: 'member_job', width: 100, sortable: true, align: 'left'},
                        {display: 'Detail Pekerjaan', name: 'member_job_detail', width: 300, sortable: true, align: 'left'},
                        {display: 'Bekerja di', name: 'member_working_in', width: 100, sortable: true, align: 'center', hide: true},
                        {display: 'Rata-rata Penghasilan', name: 'member_average_income', width: 130, sortable: true, align: 'center', hide: true},
                        {display: 'Pendidikan Terakhir', name: 'member_last_education', width: 100, sortable: true, align: 'left', hide: true},
                        {display: 'Agama', name: 'member_religion', width: 150, sortable: true, align: 'center'},
                        {display: 'Suku', name: 'member_ethnic_group', width: 100, sortable: true, align: 'left', hide: true},
                        {display: 'Gol. Darah', name: 'member_blood_type', width: 100, sortable: true, align: 'center', hide: true},
                        {display: 'Ukuran Baju', name: 'member_shirt_size', width: 100, sortable: true, align: 'center', hide: true},
                        {display: 'Status Pernikahan', name: 'member_is_married', width: 110, sortable: true, align: 'center'},
                        {display: 'Nama Suami/Istri', name: 'member_husband_wife_name', width: 200, sortable: true, align: 'left'},
                        {display: 'Nama Anak', name: 'member_child_name', width: 200, sortable: true, align: 'left'},
                        {display: 'Nama Ibu Kandung', name: 'member_mother_name', width: 200, sortable: true, align: 'left'},
                        {display: 'Pernah Terdaftar di CU Lain', name: 'member_is_registered_others_cu', width: 80, sortable: true, align: 'left', hide: true},
                        {display: 'Nama CU Lain', name: 'member_others_cu_name', width: 100, sortable: true, align: 'left', hide: true},
                        {display: 'Nama Ahli Waris', name: 'member_heir_name', width: 200, sortable: true, align: 'left'},
                        {display: 'Status Ahli Waris', name: 'member_heir_status', width: 200, sortable: true, align: 'left'},
                        {display: 'Waktu Daftar', name: 'member_join_datetime', width: 200, sortable: true, align: 'center'},
                        {display: 'Nama Administrator Input', name: 'member_input_admin_name', width: 200, sortable: true, align: 'left', hide: true},
                        {display: 'Waktu Administrator Input', name: 'member_input_datetime', width: 100, sortable: true, align: 'center', hide: true},
                        {display: 'Unit', name: 'branch_name', width: 150, sortable: true, align: 'left'},
                        ";
                    ?>
                ],
                buttons_right: [
                    <?php if(privilege_view('export', $this->menu_privilege)):
                        echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: myExport, urlaction: '" . site_url("membership/member/export_data_member") . "'}";
                    endif; ?>
                ],
                searchitems: [
                    {display: 'Unit', name: 'branch_name', type:'text'},
                    {display: 'No. Anggota', name: 'member_code', type:'text'},
                    {display: 'Nama', name: 'member_name', type:'text'},
                    {display: 'Uang Pangkal', name: 'member_entrance_fee_paid_off', type: 'select', option: '0:Belum Lunas|1:Lunas'},
                    {display: 'Diksar', name: 'member_is_diksar', type: 'select', option: '0:Belum Diksar|1:Sudah Diksar'},
                    {display: 'No. Identitas', name: 'member_identity_number', type:'text'},
                    {display: 'Tipe Identitas', name: 'member_identity_type', type:'select', option:'0:NIK|1:PASSPORT'},
                    {display: 'Jenis Kelamin', name: 'member_gender', type:'select', option:'0:Laki-laki|1:Perempuan'},
                    {display: 'Tanggal Lahir', name: 'member_birthdate', type:'text'},
                    {display: 'Tempat Lahir', name: 'member_birthplace', type:'text'},
                    {display: 'Alamat', name: 'member_address', type:'text'},
                    {display: 'Provinsi', name: 'member_province', type:'text'},
                    {display: 'Kota', name: 'member_city', type:'text'},
                    {display: 'Kecamatan', name: 'member_subdistrict', type:'text'},
                    {display: 'Kelurahan', name: 'member_kelurahan', type:'text'},
                    {display: 'RT', name: 'member_rt_number', type:'text'},
                    {display: 'RW', name: 'member_rw_number', type:'text'},
                    {display: 'Kode Pos', name: 'member_zipcode', type:'text'},
                    {display: 'Domisili', name: 'member_address_domicile', type:'text'},
                    {display: 'Provinsi Domisili', name: 'member_domicile_province', type: 'text'},
                    {display: 'Kota Domisili', name: 'member_domicile_city', type: 'text'},
                    {display: 'Kecamatan Domisili', name: 'member_domicile_subdistrict', type: 'text'},
                    {display: 'Kelurahan Domisili', name: 'member_domicile_kelurahan', type: 'text'},
                    {display: 'RT Domisili', name: 'member_domicile_rt_number', type: 'text'},
                    {display: 'RW Domisili', name: 'member_domicile_rw_number', type: 'text'},
                    {display: 'Kode Pos Domisili', name: 'member_domicile_zipcode', type: 'text'},
                    {display: 'Status Tempat Tinggal', name: 'member_residence_status', type: 'select', option: '0:Tidak Diisi|1:Milik Sendiri|2:Sewa/Kontrak|3:Menumpang|4:Ikut Orang Tua'},
                    {display: 'Telepon', name: 'member_phone_number', type:'text'},
                    {display: 'No. Handphone', name: 'member_mobilephone_number', type:'text'},
                    {display: 'Pekerjaan', name: 'member_job', type:'text'},
                    {display: 'Bekerja di', name: 'member_working_in', type: 'select', option: '0:Indonesia|1:Luar Negeri'},
                    {display: 'Rata-rata Penghasilan', name: 'member_average_income', type:'select', option:'0:< 1jt|1:1jt - 3jt|2:3jt - 5jt|3:5jt - 10jt|4:>10jt'},
                    {display: 'Pendidikan Terakhir', name: 'member_last_education', type:'select', option:'0:Tidak Sekolah|1:SD|2:SLTP|3:SMU/SMK|4:Diploma 1,2,3|5:S1|6:S2|7:S3'},
                    {display: 'Agama', name: 'member_religion', type:'select', option:'0:Tidak Diisi|1:Islam|2:Kristen|3:Katolik|4:Hindu|5:Budha|6:Kong Hu Cu|7:Aliran Kepercayaan|8:Lainnya'},
                    {display: 'Suku', name: 'member_ethnic_group', type: 'text'},
                    {display: 'Gol. Darah', name: 'member_blood_type', type: 'select', option: '0:Tidak Diisi|1:A|2:B|3:AB|4:O'},
                    {display: 'Ukuran Baju', name: 'member_shirt_size', type: 'select', option: '0:Tidak Diisi|1:S|2:M|3:L|4:XL|5:XXL|6:XXXL'},
                    {display: 'Status Pernikahan', name: 'member_is_married', type:'select', option:'0:Belum Menikah|1:Sudah Menikah|2:Janda Mati|3:Janda Cerai|4:Duda Mati|5:Duda Cerai'},
                    {display: 'Nama Suami/Istri', name: 'member_husband_wife_name', type:'text'},
                    {display: 'Nama Anak', name: 'member_child_name', type:'text'},
                    {display: 'Nama Ibu Kandung', name: 'member_mother_name', type:'text'},
                    {display: 'Pernah Terdaftar di CU Lain', name: 'member_is_registered_others_cu', type:'text'},
                    {display: 'Nama CU Lain', name: 'member_others_cu_name', type:'text'},
                    {display: 'Nama Ahli Waris', name: 'member_heir_name', type:'text'},
                    {display: 'Status Ahli Waris', name: 'member_heir_status', type:'text'},
                    {display: 'Waktu Daftar', name: 'member_join_datetime', type:'date'},
                    {display: 'Nama Administrator Input', name: 'member_input_admin_name', type:'text'},
                    {display: 'Waktu Administrator Input', name: 'member_input_datetime', type:'date'},
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
                singleSelect: false
            });
        }else{
            $("#gridview-alb-special").flexOptions({
                url: siteUrl + 'membership/member/get_data',
                params: [{name: "member_status", value: 'alb-special'}],
            }).flexClearReload();
        }
    }
    
    function myExport(com, grid, urlaction){
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

        let $form = $("<form target='_blank' method='post' action='" + urlaction + "'></form>");
        $form.append("<input type='hidden' name='column[name]' value='" + JSON.stringify(arr_column_name) + "' />");
        $form.append("<input type='hidden' name='column[title]' value='" + JSON.stringify(arr_column_title) + "' />");
        $form.append("<input type='hidden' name='column[show]' value='" + JSON.stringify(arr_column_show) + "' />");
        $form.append("<input type='hidden' name='column[align]' value='" + JSON.stringify(arr_column_align) + "' />");
        $form.append("<input type='hidden' name='sortname' value='" + sortname + "' />");
        $form.append("<input type='hidden' name='sortorder' value='" + sortorder + "' />");
        $form.append("<input type='hidden' name='query' value='" + query + "' />");
        $form.append("<input type='hidden' name='querys' value='" + querys + "' />");
        $form.append("<input type='hidden' name='optionused' value='" + optionused + "' />");
        $form.append("<input type='hidden' name='option' value='" + option + "' />");
        $form.append("<input type='hidden' name='date_start' value='" + date_start + "' />");
        $form.append("<input type='hidden' name='date_end' value='" + date_end + "' />");
        $form.append("<input type='hidden' name='qtype' value='" + qtype + "' />");
        $form.append("<input type='hidden' name='total_data' value='" + total_data + "' />");
        $form.append("<input type='hidden' name='rp' value='" + rp + "' />");
        $form.append("<input type='hidden' name='page' value='" + page + "' />");
        let urlLocation = new URL(window.location);
        let params = new URLSearchParams(urlLocation.search);
        let memberStatus = '';
        if(params.get('page') != null){
            memberStatus = params.get('page');
        }else{
            memberStatus = 'member';
        }
        $form.append("<input type='hidden' name='member_status' value='" + memberStatus + "' />");
        $(grid).after($form);
        $form.submit();
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
    
    // function arrayColumn
    function arrayColumn(array, columnName) {
        return array.map(function(value,index) {
            return value[columnName];
        });
    }
    
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
        $("#member-birthdate").inputmask({
            format: 'DD/MM/YYYY'
        });

        $("#container-diksar-date").inputmask({
            format: 'DD/MM/YYYY'
        });
</script>
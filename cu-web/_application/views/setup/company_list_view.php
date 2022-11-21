<style>
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
</style>
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

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                    <div class="x_title">
                        <h2>Detail Perusahaan</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="overflow-y: auto; overflow-x: hidden; min-height: 475px; max-height: 475px;">
                        <div id="table-detail-company"></div>

                        <div class="row">
                            <div id="table-detail-pf" class="col-md-6 col-sm-6 col-xs-12">
                                <h5><span class="glyphicon glyphicon-earphone"></span> Phone atau Fax</h5>
                            </div>

                            <div id="table-detail-cp" class="col-md-6 col-sm-6 col-xs-12">
                                <h5><span class="glyphicon glyphicon-credit-card"></span> Kontak Personal</h5>
                            </div>

                        </div>
                    </div>
        </div>
    </div>


    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Form Ubah Perusahaan</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="form-company" class="form-horizontal form-label-left" data-url="">
                    <input id="input-company-id" type="hidden" name="id">
                    <ul class="nav nav-tabs bar_tabs" role="tablist">
                        <li class="active">
                                <a   href="#company"  data-toggle="tab">
                                    <span class="fa fa-building" data-toggle="tooltip" data-placement="top" title="Perusahaan"></span>
                                </a>
                        </li>
                        <li class="nav-item">
                                <a href="#pf"  data-toggle="tab">
                                    <span class="fa fa-phone" data-toggle="tooltip" data-placement="top" title="Phone & Fax"></span>
                                </a>
                        </li>
                        <li class="nav-item">
                                <a href="#cp" data-toggle="tab">
                                <span class="glyphicon glyphicon-credit-card" data-toggle="tooltip" data-placement="top" title="Kontak Personal"></span>
                                </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="company" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="title">Nama Perusahaan <span class="required">*</span>
                                                </label>
                                                <input id="input-company-title" type="text" name="title" class="form-control" data-validation="required" data-validation-length="max100">
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="address">Alamat Perusahaan <span class="required">*</span>
                                                </label>
                                                <textarea id="input-company-address" name="address" class="form-control" data-validation="required" data-validation-length="max100"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                    <label class="control-label" for="province">Provinsi
                                                    </label>
                                                    <select id="input-company-province" name="province" data-validation="" class="form-control select2">
                                                        <option value="">--Pilih Provinsi--</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                    <label class="control-label" for="city">Kota <span class="required"></span>
                                                    </label>
                                                    <select id="input-company-city" name="city" data-validation="" class="form-control select2">
                                                        <option value="">--Pilih Kota--</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                    <label class="control-label" for="subdistrict">Kecamatan <span class="required"></span>
                                                    </label>
                                                    <select id="input-company-subdistrict" name="subdistrict" data-validation="" class="form-control select2">
                                                        <option value="">--Pilih Kecamatan--</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                    <label class="control-label" for="city">Kelurahan <span class="required"></span>
                                                    </label>
                                                    <select id="input-company-village" name="village" data-validation="" class="form-control select2">
                                                        <option value="">--Pilih Kelurahan--</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <div class="form-group pull-right col-md-6 col-sm-6 col-xs-12">
                                                    <label class="control-label" for="zip_code">Kode Pos
                                                    </label>
                                                    <input id="input-company-zip-code" type="text" name="zip_code" class="form-control" data-validation="number" data-validation-optional="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="pf" class="tab-pane fade" style="min-height: 370px;">
                            <div id="table-phonefax">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <a href="javascript:;" id="open-form-phonefax" class="btn btn-dark btn-sm pull-right"><i class="fa fa-plus-circle"></i> &nbsp; Tambah</a>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table class="table-like-flexigrid" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No.</th>
                                                    <th>Fax</th>
                                                    <th>Phone</th>
                                                    <th>Mobilephone</th>
                                                    <th width="10%" style="text-align:center;">Ubah</th>
                                                    <th width="10%" style="text-align:center;">Hapus</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="x_panel tile x_panel_form" id="form-phonefax" style="border: 1px solid #E6E9ED;">
                                <div class="x_title" style="color: inherit; border-bottom: 2px solid #E6E9ED;">
                                    <h5>Form Tambah Phone atau Fax</h5>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                            <label>Fax</label>
                                            <input type="text" name="fax" class="form-control" data-validation="length number" data-validation-optional="true" data-validation-length="max15">
                                        </div>
                                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                            <label>Phone</label>
                                            <input type="text" name="phone" class="form-control" data-validation="length number" data-validation-optional="true" data-validation-length="max15">
                                        </div>
                                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                            <label>Mobilephone
                                            </label>
                                            <input type="text" name="mobile_phone" class="form-control" data-validation="length number" data-validation-optional="true" data-validation-length="10-13">
                                        </div>
                                    </div>
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <a href="javascript:;" id="submit-pf" class="btn btn-sm btn-dark"><i class="fa fa-plus-circle"></i>&nbsp;Tambah</a>
                                        <a href="javascript:;" id="cancel-pf" class="btn btn-sm btn-default">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="cp" class="tab-pane fade" style="min-height: 370px;">
                            <div id="table-contactperson">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <a href="javascript:;" id="open-form-cp" class="btn btn-dark btn-sm pull-right"><i class="fa fa-plus-circle"></i>&nbsp; Tambah</a>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table class="table-like-flexigrid" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No.</th>
                                                    <th>Nama</th>
                                                    <th>Alamat</th>
                                                    <th>Phone</th>
                                                    <th width="10%" style="text-align:center;">Ubah</th>
                                                    <th width="10%" style="text-align:center;">Hapus</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="x_panel tile x_panel_form" id="form-contactperson" style="border: 1px solid #E6E9ED;">
                                <div class="x_title" style="color: inherit; border-bottom: 2px solid #E6E9ED;">
                                    <h5>Form Tambah Kontak Personal</h5>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <label>Nama</label>
                                            <input type="text" name="cp_name" class="form-control" data-validation="length" data-validation-optional="true" data-validation-length="max50">
                                        </div>
                                        <div class="form-group col-md-9 col-sm-9 col-xs-12">
                                            <label>Alamat</label>
                                            <textarea name="cp_address" class="form-control" data-validation="length" data-validation-optional="true" data-validation-length="max50"></textarea>
                                        </div>
                                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                            <label>Phone
                                            </label>
                                            <input type="text" name="cp_phone" class="form-control" data-validation="length number" data-validation-optional="true" data-validation-length="10-13">
                                        </div>
                                    </div>
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <a href="javascript:;" id="submit-cp" class="btn btn-sm btn-dark"><i class="fa fa-plus-circle"></i>&nbsp;Tambahkan</a>
                                        <a href="javascript:;" id="cancel-cp" class="btn btn-sm btn-default">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i>&nbsp; Simpan <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></button>
                </form>
            </div>
        </div>
    </div>
    
</div>

<!--FORM VALIDATOR-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<script>
    "use strict";
    
    let siteUrl = '<?php echo site_url();?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    let arrDataPhoneFax = [];
    let arrDataContactPerson = [];
    
    // function generate select2
    function generateSelect2(element = '.select2', data = [], nameValue, nameText, selectedValue = false, selectedName = '', placeHolder = false, placeHolderValue = '') {
        let option = placeHolder === false ? '' : `<option value="${placeHolderValue}">${placeHolder}</option>`;
        data.forEach(function (item, index){
            let strSelected = '';
            if(selectedValue !== false){
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
    function ajaxRequest(url, method = 'GET', data = '', callback){
        $.ajax({
            url: url,
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
    
    // function capitalize each word
    function titleCase(str) {
        var splitStr = str.toLowerCase().split(' ');
        for (var i = 0; i < splitStr.length; i++) {
            // You do not need to check if i is larger than splitStr length, as your for does that for you
            // Assign it back to the array
            splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
        }
        // Directly return the joined string
        return splitStr.join(' '); 
    }
    
    function setDetail(){
        ajaxRequest(siteUrl + 'common/general/setup/company/get_data', 'GET', '', function(res){
            if(res.status == 200){
                let results = res.data.results;
                let address = (results.company_province_name) ? ', ' + titleCase(results.company_village_name) + ', ' + titleCase(results.company_subdistrict_name) + ', ' + titleCase(results.company_city_name) + ', ' + titleCase(results.company_province_name) + ', ' + results.company_zip_code : '';
                let tableCompany = '';
                tableCompany +=     `<table class="table-like-flexigrid" style="width: 100%; margin-bottom: 15px;">
                                        <tbody>
                                            <tr>
                                                <th style="width: 30%"><strong>Nama Perusahaan</strong></th>
                                                <td>${results.company_title}</td>
                                            </tr>
                                            <tr>
                                                <th><strong>Alamat Perusahaan</strong></th>
                                                <td>${results.company_address}${address}</td>
                                            </tr>
                                        </tbody>
                                    </table>`;
                $('#table-detail-company').html(tableCompany);

                if (results.company_phone_fax.length !== 0) {
                    var isMain = '';
//                    var clMain = '';
                    var tablePhoneFax = '';
                    $.each(results.company_phone_fax, function (key, value) {
                        isMain = `ALTERNATIF ${key}`;
                        if (key === 0) {
                            isMain = 'UTAMA';
                        }
                        tablePhoneFax +=    `<table class="table-like-flexigrid" style="width: 100%; margin-bottom: 15px;">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2" class="text-center">
                                                            <strong>${isMain}</strong>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 30%">Fax</td>
                                                        <td>${value.fax}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Telepon</td>
                                                        <td>${value.phone}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mobilephone</td>
                                                        <td>${value.mobile_phone}</td>
                                                    </tr>
                                                </tbody>
                                            </table>`;
                    });
                    $('#table-detail-pf > table').remove();
                    $('#table-detail-pf h5').after(tablePhoneFax);
                    $('#table-detail-pf').show();
                } else {
                    $('#table-detail-pf > table').remove();
                    $('#table-detail-pf').hide();
                }

                if (results.company_contact_person.length !== 0) {
                    var isMain = '';
//                    var clMain = '';
                    var tableContactPerson = '';
                    $.each(results.company_contact_person, function (key, value) {
                        isMain = `ALTERNATIF ${key}`;
//                        clMain = 'bg-orange';
                        if (key === 0) {
                            isMain = 'UTAMA';
//                            clMain = 'bg-blue';
                        }
                        tableContactPerson +=   `<table class="table-like-flexigrid" style="width: 100%; margin-bottom: 15px;">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" class="text-center">
                                                                <strong>${isMain}</strong>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 30%">Nama</td>
                                                            <td>${value.name}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Telepon</td>
                                                            <td>${value.phone}</td>
                                                        </tr>
                                                        <tr><td>Alamat</td>
                                                            <td>${value.address}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>`;
                    });
                    $('#table-detail-cp > table').remove();
                    $('#table-detail-cp h5').after(tableContactPerson);
                    $('#table-detail-cp').show();
                } else {
                    $('#table-detail-cp > table').remove();
                    $('#table-detail-cp').hide();
                }
            }else{
                alert(res.msg)
            }
        });
    }
    
    function setUpdate(){
        $("#response_message").finish();
        ajaxRequest(siteUrl + 'common/general/setup/company/get_data', 'GET', '', function(res){
            if(res.status == 200){
                let results = res.data.results;

                $('#form-company').trigger("reset");
                $('#form-company').attr('data-url', '<?php echo site_url('setup/company/act_update'); ?>');

                $('#input-company-id').val(results.company_id);
                $('#input-company-title').val(results.company_title);
                $('#input-company-address').val(results.company_address);
                $('#input-company-zip-code').val(results.company_zip_code);

                generateSelect2('#input-company-province', [], '', '', false, '', '--Pilih Provinsi--', '').prop('disabled', true);
                generateSelect2('#input-company-city', [], '', '', false, '', '--Pilih Kota--', '').prop('disabled', true);
                generateSelect2('#input-company-subdistrict', [], '', '', false, '', '--Pilih Kecamatan--', '').prop('disabled', true);
                generateSelect2('#input-company-village', [], '', '', false, '', '--Pilih Kelurahan--', '').prop('disabled', true);

                ajaxRequest(siteUrl + 'common/general/option/province', 'GET', '', function(res_province){
                    if(res_province.status == 200){
                        let dataProvince = res_province.data.results;
                        if(dataProvince.length > 0){
                            let provinceId = 0;
                            let provinceIndex = arrayColumn(dataProvince, 'province_name').indexOf(results.company_province_name);
                            if(provinceIndex != -1){
                                provinceId = dataProvince[provinceIndex].province_id;
                                generateSelect2('#input-company-province', dataProvince, 'province_id', 'province_name', provinceId, 'province_id', '--Pilih Provinsi--', '').prop('disabled', false);

                                ajaxRequest(siteUrl + 'common/general/option/city', 'GET', {province_id: provinceId}, function(res_city){
                                    if(res_city.status == 200){
                                        let dataCity = res_city.data.results;
                                        if(dataCity.length > 0){
                                            let cityId = 0;
                                            let cityIndex = arrayColumn(dataCity, 'city_name').indexOf(results.company_city_name);
                                            if(cityIndex != -1){
                                                cityId = dataCity[cityIndex].city_id;
                                                generateSelect2('#input-company-city', dataCity, 'city_id', 'city_name', cityId, 'city_id', '--Pilih Kota--', '').prop('disabled', false);

                                                ajaxRequest(siteUrl + 'common/general/option/subdistrict', 'GET', {city_id: cityId}, function(res_subdistrict){
                                                    if(res_subdistrict.status == 200){
                                                        let dataSubdistrict = res_subdistrict.data.results;
                                                        if(dataSubdistrict.length > 0){
                                                            let subdistrictId = 0;
                                                            let subdistrictIndex = arrayColumn(dataSubdistrict, 'subdistrict_name').indexOf(results.company_subdistrict_name);
                                                            if(subdistrictIndex != -1){
                                                                subdistrictId = dataSubdistrict[subdistrictIndex].subdistrict_id
                                                                generateSelect2('#input-company-subdistrict', dataSubdistrict, 'subdistrict_id', 'subdistrict_name', subdistrictId, 'subdistrict_id', '--Pilih Kecamatan--', '').prop('disabled', false);

                                                                ajaxRequest(siteUrl + 'common/general/option/village', 'GET', {subdistrict_id: subdistrictId}, function(res_village){
                                                                    if(res_village.status == 200){
                                                                        let dataVillage = res_village.data.results;
                                                                        if(dataVillage.length > 0){
                                                                            let villageId = 0;
                                                                            let villageIndex = arrayColumn(dataVillage, 'village_name').indexOf(results.company_village_name);
                                                                            if(villageIndex != -1){
                                                                                villageId = dataVillage[villageIndex].village_id
                                                                                generateSelect2('#input-company-village', dataVillage, 'village_id', 'village_name', villageId, 'village_id', '--Pilih Kelurahan--', '').prop('disabled', false);
                                                                            }else{
                                                                                generateSelect2('#input-company-village', dataVillage, 'village_id', 'village_name', false, '', '--Pilih Kelurahan--', '').prop('disabled', false);
                                                                            }
                                                                        }
                                                                    }else{
                                                                        alert(res_village.msg);
                                                                    }
                                                                });
                                                            }else{
                                                                generateSelect2('#input-company-subdistrict', dataSubdistrict, 'subdistrict_id', 'subdistrict_name', false, '', '--Pilih Kecamatan--', '').prop('disabled', false);
                                                            }
                                                        }
                                                    }else{
                                                        alert(res_subdistrict.msg);
                                                    }
                                                });
                                            }else{
                                                console.log(dataCity);
                                                generateSelect2('#input-company-city', dataCity, 'city_id', 'city_name', false, '', '--Pilih Kota--', '').prop('disabled', false);
                                            }
                                        }
                                    }else{
                                        alert(res_city.msg);
                                    }
                                });
                            }else{
                                generateSelect2('#input-company-province', dataProvince, 'province_id', 'province_name', false, '', '--Pilih Provinsi--', '').prop('disabled', false);
                            }
                        }
                    }else{
                        alert(res_province.msg);
                    }
                });

                arrDataPhoneFax = results.company_phone_fax;
                arrDataContactPerson = results.company_contact_person;
                insertPhoneFaxToTable();
                insertContactPersonToTable();

            }else{
                alert(res.msg);
            }
        });
    }

    function insertPhoneFaxToTable(){
        $('#table-phonefax tbody').html('');
        if (arrDataPhoneFax.length != 0) {
            var tr = '';
            arrDataPhoneFax.forEach(function (item, index) {
                tr +=   `<tr>
                            <td>${index + 1}</td>
                            <td>${item.fax}</td>
                            <td>${item.phone}</td>
                            <td>${item.mobile_phone}</td>
                            <td style="text-align:center;">
                                <a href="javascript:;" onclick="editPhoneFax(${index})"><img src="${siteUrl}assets/images/icon/save_labled_edit.png" border="0" alt="Ubah" title="Ubah" /></a>
                            </td>
                            <td style="text-align:center;">
                                <a href="javascript:;" onclick="deletePhoneFax(${index})"><img src="${siteUrl}addons/flexigrid/button/images/close.png" border="0" alt="Hapus" title="Hapus" /></a>
                            </td>
                        </tr>`;
            });
            $('#table-phonefax tbody').html(tr);
            $('#table-phonefax').show();
            $('#form-phonefax').hide();
        } else {
            $('#table-phonefax').hide();
            resetFormPhoneFax();
            $('#submit-pf').attr('onclick', 'addPhoneFax()');
            $('#submit-pf').html('<i class="fa fa-plus-circle"></i>&nbsp;Tambah');
            $('#cancel-pf').hide();
            $('#form-phonefax').show();
            $('input[name="fax"]').focus();
        }
    }

    function resetFormPhoneFax(){
        $('input[name="fax"]').val('').removeClass('error').removeAttr('style').next('span.form-error').remove();
        $('input[name="fax"]').parent().removeClass('has-error');
        $('input[name="phone"]').val('').removeClass('error').removeAttr('style').next('span.form-error').remove();
        $('input[name="phone"]').parent().removeClass('has-error');
        $('input[name="mobile_phone"]').val('').removeClass('error').removeAttr('style').next('span.form-error').remove();
        $('input[name="mobile_phone"]').parent().removeClass('has-error');
    }

    function addPhoneFax() {
        var fax = $('input[name="fax"]').val();
        var phone = $('input[name="phone"]').val();
        var mobilePhone = $('input[name="mobile_phone"]').val();

        var isError = false;
        $('#form-phonefax input').validate(function (valid, elem) {
            if (!valid) {
                isError = true;
            }
        });

        if (!isError) {
            if (fax || phone || mobilePhone) {
                arrDataPhoneFax.push({"fax": fax, "phone": phone, "mobile_phone": mobilePhone});
                resetFormPhoneFax();
                insertPhoneFaxToTable();
            }
        }
    }

    function deletePhoneFax(index) {
        if (confirm(`Yakin akan menghapus phone atau fax nomor ${index + 1} ?`)) {
            arrDataPhoneFax.splice(index, 1);
            insertPhoneFaxToTable();
        }
    }

    function editPhoneFax(index) {
        resetFormPhoneFax();
        $('input[name="fax"]').val(arrDataPhoneFax[index].fax);
        $('input[name="phone"]').val(arrDataPhoneFax[index].phone);
        $('input[name="mobile_phone"]').val(arrDataPhoneFax[index].mobile_phone);
        $('#table-phonefax').hide();
        $('#submit-pf').attr('onclick', `updatePhoneFax(${index})`);
        $('#submit-pf').html('<i class="fa fa-save"></i>&nbsp;Simpan Perubahan');
        $('#cancel-pf').show();
        $('#form-phonefax').show();
        $('input[name="fax"]').focus();
    }

    function updatePhoneFax(index) {
        var fax = $('input[name="fax"]').val();
        var phone = $('input[name="phone"]').val();
        var mobilePhone = $('input[name="mobile_phone"]').val();

        var isError = false;
        $('#form-phonefax input').validate(function (valid, elem) {
            if (!valid) {
                isError = true;
            }
        });

        if (!isError) {
            if (fax || phone || mobilePhone) {
                arrDataPhoneFax[index].fax = fax;
                arrDataPhoneFax[index].phone = phone;
                arrDataPhoneFax[index].mobile_phone = mobilePhone;
                resetFormPhoneFax();
                insertPhoneFaxToTable();
            }
        }
    }

    function insertContactPersonToTable() {
        $('#table-contactperson tbody').html('');
        if (arrDataContactPerson.length != 0) {
            var tr = '';
            arrDataContactPerson.forEach(function (item, index) {
                tr +=   `<tr>
                            <td>${index + 1}</td>
                            <td>${item.name}</td>
                            <td>${item.address}</td>
                            <td>${item.phone}</td>
                            <td style="text-align:center;">
                                <a href="javascript:;" onclick="editContactPerson(${index})"><img src="${siteUrl}assets/images/icon/save_labled_edit.png" border="0" alt="Ubah" title="Ubah" /></a>
                            </td>
                            <td style="text-align:center;">
                                <a href="javascript:;" onclick="deleteContactPerson(${index})"><img src="${siteUrl}addons/flexigrid/button/images/close.png" border="0" alt="Hapus" title="Hapus" /></a>
                            </td>
                        </tr>`;
            });
            $('#table-contactperson tbody').html(tr);
            $('#table-contactperson').show();
            $('#form-contactperson').hide();
        } else {
            $('#table-contactperson').hide();
            resetFormContactPerson();
            $('#submit-cp').attr('onclick', 'addContactPerson()');
            $('#submit-cp').html('<i class="fa fa-plus-circle"></i>&nbsp;Tambah');
            $('#cancel-cp').hide();
            $('#form-contactperson').show();
            $('input[name="cp_name"]').focus();
        }
    }

    function resetFormContactPerson() {
        $('input[name="cp_name"]').val('')
                .removeClass('error')
                .removeAttr('style')
                .next('span.form-error')
                .remove();
        $('input[name="cp_name"]').parent().removeClass('has-error');
        $('textarea[name="cp_address"]').val('')
                .removeClass('error')
                .removeAttr('style')
                .next('span.form-error')
                .remove();
        $('textarea[name="cp_address"]').parent().removeClass('has-error');
        $('input[name="cp_phone"]').val('')
                .removeClass('error')
                .removeAttr('style')
                .next('span.form-error')
                .remove();
        $('input[name="cp_phone"]').parent().removeClass('has-error');
    }

    function addContactPerson() {
        var cpName = $('input[name="cp_name"]').val();
        var cpAddress = $('textarea[name="cp_address"]').val();
        var cpPhone = $('input[name="cp_phone"]').val();

        var isError = false;
        $('#form-contactperson input').validate(function (valid, elem) {
            if (!valid) {
                isError = true;
            }
        });

        if (!isError) {
            if (cpName || cpAddress || cpPhone) {
                arrDataContactPerson.push({"name": cpName, "address": cpAddress, "phone": cpPhone});
                resetFormContactPerson();
                insertContactPersonToTable();
            }
        }
    }

    function deleteContactPerson(index) {
        if (confirm(`Yakin akan menghapus kontak personal nomor ${index + 1} ?`)) {
            arrDataContactPerson.splice(index, 1);
            insertContactPersonToTable();
        }
    }

    function editContactPerson(index) {
        resetFormContactPerson();
        $('input[name="cp_name"]').val(arrDataContactPerson[index].name);
        $('textarea[name="cp_address"]').val(arrDataContactPerson[index].address);
        $('input[name="cp_phone"]').val(arrDataContactPerson[index].phone);
        $('#table-contactperson').hide();
        $('#submit-cp').attr('onclick', `updateContactPerson(${index})`);
        $('#submit-cp').html('<i class="fa fa-save"></i>&nbsp;Simpan Perubahan');
        $('#cancel-cp').show();
        $('#form-contactperson').show();
        $('input[name="cp_name"]').focus();
    }

    function updateContactPerson(index) {
        var cpName = $('input[name="cp_name"]').val();
        var cpAddress = $('textarea[name="cp_address"]').val();
        var cpPhone = $('input[name="cp_phone"]').val();

        var isError = false;
        $('#form-contactperson input').validate(function (valid, elem) {
            if (!valid) {
                isError = true;
            }
        });

        if (!isError) {
            if (cpName || cpAddress || cpPhone) {
                arrDataContactPerson[index].name = cpName;
                arrDataContactPerson[index].address = cpAddress;
                arrDataContactPerson[index].phone = cpPhone;
                resetFormContactPerson();
                insertContactPersonToTable();
            }
        }
    }

    $(document).ready(function () {
        setUpdate();
        setDetail();
        $('ul.nav-tabs li a').on('click', function (e){
            if($(this).parent().attr('class') == ''){
                var elementId = $(this).attr('href');
                setTimeout(function (){
                    $(elementId).find('input')[0].focus();
                }, 200);
            }
        });

        $('#modal').on('shown.bs.modal', function () {
            $('input[name="title"]').focus();
        });

        $('.select2').select2();

        $('#form-company').on('submit', function (e) {
            e.preventDefault();

            $('#form-company button[type="submit"]').attr('disabled', 'disabled');
            let urlForm = $('#form-company').attr('data-url');

            let formData = new FormData(this);
            formData.append('phone_fax', JSON.stringify(arrDataPhoneFax));
            formData.append('contact_person', JSON.stringify(arrDataContactPerson));

            let provinceValue = $('#input-company-province').val();
            let cityValue = $('#input-company-city').val();
            let subdistrictValue = $('#input-company-subdistrict').val();
            let villageValue = $('#input-company-village').val();

            formData.set('province', '');
            formData.set('city', '');
            formData.set('subdistrict', '');
            formData.set('village', '');
            if (provinceValue) {
                formData.set('province', $('#input-company-province option[value="' + provinceValue + '"]').text());
                formData.set('city', $('#input-company-city option[value="' + cityValue + '"]').text());
                formData.set('subdistrict', $('#input-company-subdistrict option[value="' + subdistrictValue + '"]').text());
                formData.set('village', $('#input-company-village option[value="' + villageValue + '"]').text());
            }
            formData.delete('fax');
            formData.delete('phone');
            formData.delete('mobile_phone');
            formData.delete('cp_name');
            formData.delete('cp_address');
            formData.delete('cp_phone');

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
                        setUpdate();
                        setDetail();
                        $('#form-company button[type="submit"]').removeAttr('disabled');

                        $("#response_message").finish();

                        $("#response_message").addClass('response_confirmation alert alert-success');
                        $("#response_message").slideDown("fast");
                        $("#response_message").html(res.data);
                        $("#response_message").delay(10000).slideUp(1000, function () {
                            $("#response_message").removeClass('response_confirmation alert alert-success');
                        });
                    } else {
                        $('#form-company button[type="submit"]').removeAttr('disabled');
                        $("#response_message").finish();

                        $("#response_message").addClass('response_confirmation alert alert-danger');
                        $("#response_message").slideDown("fast");
                        $("#response_message").html(res.msg);
                        $("#response_message").delay(10000).slideUp(1000, function () {
                            $("#response_message").removeClass('response_confirmation alert alert-success');
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#form-company button[type="submit"]').removeAttr('disabled');
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });

         $('#input-company-province').on('change', function (e) {
            let provinceId = $(this).val();
            if (provinceId) {
                ajaxRequest('<?php echo site_url('common/general/option/city'); ?>', 'GET', {province_id: provinceId}, function(res){
                    if(res.status == 200){
                        let dataCity = res.data.results;
                        generateSelect2('#input-company-city', dataCity, 'city_id', 'city_name', false, '', '--Pilih Kota--', '')
                                .prop('disabled', false).attr('data-validation', 'required').prev().find('span').text('*');
                        $('span.form-error').remove();
                        $('.has-success').removeClass('has-success');
                        $('.valid .error').removeClass('valid error').css('border-color', '');
                        generateSelect2('#input-company-subdistrict', [], '', '', false, '', '--Pilih Kecamatan--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('*');
                        generateSelect2('#input-company-village', [], '', '', false, '', '--Pilih Kelurahan--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('*');
                    }else{
                        alert(res.msg);
                    }
                });
            } else {
                $('span.form-error').remove();
                $('.has-success').removeClass('has-success');
                $('.valid .error').removeClass('valid error').css('border-color', '');

                generateSelect2('#input-company-city', [], '', '', false, '', '--Pilih Kota--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
                generateSelect2('#input-company-subdistrict', [], '', '', false, '', '--Pilih Kecamatan--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
                generateSelect2('#input-company-village', [], '', '', false, '', '--Pilih Kelurahan--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
            }
        });

        $('#input-company-city').on('change', function (e) {
            let cityId = $(this).val();
            if (cityId) {
                ajaxRequest('<?php echo site_url('common/general/option/subdistrict'); ?>', 'GET', {city_id: cityId}, function(res){
                    if(res.status == 200){
                        let dataSubdistrict = res.data.results;
                        generateSelect2('#input-company-subdistrict', dataSubdistrict, 'subdistrict_id', 'subdistrict_name', false, '', '--Pilih Kecamatan--', '')
                                .prop('disabled', false).attr('data-validation', 'required').prev().find('span').text('*');
                        $('span.form-error').remove();
                        $('.has-success').removeClass('has-success');
                        $('.valid .error').removeClass('valid error').css('border-color', '');
                        generateSelect2('#input-company-village', [], '', '', false, '', '--Pilih Kelurahan--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('*');
                    }else{
                        alert(res.msg);
                    }
                });
            } else {
                $('span.form-error').remove();
                $('.has-success').removeClass('has-success');
                $('.valid .error').removeClass('valid error').css('border-color', '');

                generateSelect2('#input-company-subdistrict', [], '', '', false, '', '--Pilih Kecamatan--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
                generateSelect2('#input-company-village', [], '', '', false, '', '--Pilih Kelurahan--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
            }
        });

        $('#input-company-subdistrict').on('change', function (e) {
            let subdistrictId = $(this).val();
            if (subdistrictId) {
                ajaxRequest('<?php echo site_url('common/general/option/village'); ?>', 'GET', {subdistrict_id: subdistrictId}, function(res){
                    if(res.status == 200){
                        let dataVillage = res.data.results;
                        generateSelect2('#input-company-village', dataVillage, 'village_id', 'village_name', false, '', '--Pilih Kelurahan--', '')
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

                generateSelect2('#input-company-village', [], '', '', false, '', '--Pilih Kelurahan--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
            }
        });

        $('#open-form-phonefax').on('click', function (e) {
            $('#table-phonefax').hide();
            $('#submit-pf').attr('onclick', 'addPhoneFax()');
            $('#submit-pf').html('<i class="fa fa-plus-circle"></i>&nbsp;Tambah');
            resetFormPhoneFax();
            $('#cancel-pf').show();
            $('#form-phonefax').show();
            $('input[name="fax"]').focus();
        });

        $('#open-form-cp').on('click', function (e) {
            $('#table-contactperson').hide();
            $('#submit-cp').attr('onclick', 'addContactPerson()');
            $('#submit-cp').html('<i class="fa fa-plus-circle"></i>&nbsp;Tambah');
            resetFormContactPerson();
            $('#cancel-cp').show();
            $('#form-contactperson').show();
            $('input[name="cp_name"]').focus();
        });

        $('#cancel-pf').on('click', function (e) {
            $('#table-phonefax').show();
            $('#form-phonefax').hide();
        });

        $('#cancel-cp').on('click', function (e) {
            $('#table-contactperson').show();
            $('#form-contactperson').hide();
        });
    });
    
    $.validate({
        modules: 'logic',
        lang: 'id'
    });

</script>
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
<div id="modal" class="modal fade" role="dialog">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <form id="form-branch" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body">
                    <div id="modal-response-message" class="alert alert-danger alert-dismissible fade in" role="alert" style="display:none"></div>

                    <input id="input-branch-id" type="hidden" name="id">

                    <ul class="nav nav-tabs bar_tabs" role="tablist">
                        <li class="active">
                                <a   href="#branch"  data-toggle="tab">
                                    <span class="fa fa-institution" data-toggle="tooltip" data-placement="top" title="Unit"></span>
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
                        <div id="branch" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="title">Nama Unit <span class="required">*</span>
                                                </label>
                                                <input tabindex="1" id="input-branch-name" type="text" name="name" class="form-control" data-validation="required length" data-validation-length="max50">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="code">Kode Unit
                                                </label>
                                                <input tabindex="2" id="input-branch-code" type="text" name="code" class="form-control" data-validation="length" data-validation-length="max5" data-validation-optional="true" data-validation-help="Jika kosong maka akan generate otomatis dari sistem.">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" for="address">Alamat Unit <span class="required">*</span>
                                        </label>
                                        <textarea tabindex="3" id="input-branch-address" name="address" class="form-control" data-validation="required length" data-validation-length="max50"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" for="province">Provinsi
                                        </label>
                                        <select tabindex="4" id="input-branch-province" name="province" data-validation="" class="form-control my-select2">
                                            <option value="">--Pilih Provinsi--</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="subdistrict">Kecamatan <span class="required"></span>
                                        </label>
                                        <select tabindex="5" id="input-branch-subdistrict" name="subdistrict" data-validation="" class="form-control my-select2">
                                            <option value="">--Pilih Kecamatan--</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" for="city">Kota <span class="required"></span>
                                        </label>
                                        <select tabindex="6" id="input-branch-city" name="city" data-validation="" class="form-control my-select2">
                                            <option value="">--Pilih Kota--</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label" for="village">Kelurahan <span class="required"></span>
                                        </label>
                                        <select tabindex="7" id="input-branch-village" name="village" data-validation="" class="form-control my-select2">
                                            <option value="">--Pilih Kelurahan--</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="form-group pull-right col-md-6 col-sm-6 col-xs-12">
                                            <label class="control-label" for="zip_code">Kode Pos
                                            </label>
                                            <input tabindex="8" id="input-branch-zip-code" type="text" name="zip_code" class="form-control" data-validation="number" data-validation-optional="true">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div id="pf" class="tab-pane fade">
                            <div id="table-phonefax">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <a href="javascript:;" id="open-form-phonefax" class="btn btn-dark btn-sm pull-right"><i class="fa fa-plus-circle"></i> &nbsp; Tambah</a>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th width="20%">Fax</th>
                                                    <th width="25%">Phone</th>
                                                    <th width="25%">Mobilephone</th>
                                                    <th width="25%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="x_panel tile x_panel_form" id="form-phonefax">
                                <div class="x_title">
                                    <h5>Form Tambah Phone atau Fax</h5>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                            <label>Fax</label>
                                            <input tabindex="9" type="text" name="fax" class="form-control" data-validation="length number" data-validation-optional="true" data-validation-length="max15">
                                        </div>
                                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                            <label>Phone</label>
                                            <input tabindex="10" type="text" name="phone" class="form-control" data-validation="length number" data-validation-optional="true" data-validation-length="max15">
                                        </div>
                                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                            <label>Mobilephone
                                            </label>
                                            <input tabindex="11" type="text" name="mobile_phone" class="form-control" data-validation="length number" data-validation-optional="true" data-validation-length="10-13">
                                        </div>
                                    </div>
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <a tabindex="12" href="javascript:;" id="submit-pf" class="btn btn-sm btn-dark"><i class="fa fa-plus-circle"></i>&nbsp;Tambah</a>
                                        <a href="javascript:;" id="cancel-pf" class="btn btn-sm btn-default">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="cp" class="tab-pane fade">
                            <div id="table-contactperson">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <a href="javascript:;" id="open-form-cp" class="btn btn-dark btn-sm pull-right"><i class="fa fa-plus-circle"></i>&nbsp; Tambah</a>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th width="20%">Nama</th>
                                                    <th width="30%">Alamat</th>
                                                    <th width="20%">Phone</th>
                                                    <th width="25%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="x_panel tile x_panel_form" id="form-contactperson">
                                <div class="x_title">
                                    <h5>Form Tambah Kontak Personal</h5>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <label>Nama</label>
                                            <input tabindex="13" type="text" name="cp_name" class="form-control" data-validation="length" data-validation-optional="true" data-validation-length="max50">
                                        </div>
                                        <div class="form-group col-md-9 col-sm-9 col-xs-12">
                                            <label>Alamat</label>
                                            <textarea tabindex="14" name="cp_address" class="form-control" data-validation="length" data-validation-optional="true" data-validation-length="max50"></textarea>
                                        </div>
                                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                            <label>Phone
                                            </label>
                                            <input tabindex="15" type="text" name="cp_phone" class="form-control" data-validation="length number" data-validation-optional="true" data-validation-length="10-13"">
                                        </div>
                                    </div>
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <a tabindex="16" href="javascript:;" id="submit-cp" class="btn btn-sm btn-dark"><i class="fa fa-plus-circle"></i>&nbsp;Tambahkan</a>
                                        <a href="javascript:;" id="cancel-cp" class="btn btn-sm btn-default">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button tabindex="17" type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Simpan <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal -->
<?php endif; ?>

<!--modal detail-->
<div id="detail" class="modal fade" role="dialog">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div id="table-detail-branch"></div>

                <div class="row">
                    <div id="table-detail-pf" class="col-md-6 col-sm-6 col-xs-12">
                        <h5>Phone atau Fax</h5>
                    </div>

                    <div id="table-detail-cp" class="col-md-6 col-sm-6 col-xs-12">
                        <h5>Kontak Personal</h5>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal detail-->

<!--FORM VALIDATOR-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    class Branch{
        constructor() {
            this.arrPrivilege = <?php echo $this->json_menu_privilege . ';'; ?>
            this.permissionDisplay();
            this.arrDataPhoneFax = [];
            this.arrDataContactPerson = [];
        }
        
        openModalDetail(branchId){
            branch.ajaxRequest('common/general/setup/branch/get_detail', 'GET', {id: branchId}, function(res){
                if(res.status == 200){
                    let results = res.data;
                    $('#detail .modal-title').text('Detail Unit ' + results.branch_name);
                    let address = (results.branch_province_name) ? ', ' + results.branch_village_name + ', ' + results.branch_subdistrict_name + ', ' + results.branch_city_name + ', ' + results.branch_province_name : '';
                    let tableBranch = '';
                    tableBranch +=     `<table class="table table-bordered">
                                            <tr>
                                                <td style="width: 30%"><strong>KODE PERUSAHAAN</strong></td>
                                                <td>${results.branch_code}</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 30%"><strong>NAMA PERUSAHAAN</strong></td>
                                                <td>${results.branch_name}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>ALAMAT PERUSAHAAN</strong></td>
                                                <td>${results.branch_address} ${address}</td>
                                            </tr>
                                        </table>`;
                    $('#table-detail-branch').html(tableBranch);

                    if (results.branch_phone_fax.length !== 0) {
                        var isMain = '';
                        var clMain = '';
                        var tablePhoneFax = '';
                        $.each(results.branch_phone_fax, function (key, value) {
                            isMain = `ALTERNATIF ${key}`;
                            clMain = 'bg-orange';
                            if (key === 0) {
                                isMain = 'UTAMA';
                                clMain = 'bg-blue';
                            }
                            tablePhoneFax +=    `<table class="table table-bordered">
                                                    <tr class="${clMain}">
                                                        <td colspan="2" class="text-center">
                                                            <strong>${isMain}</strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 30%">Fax</td>
                                                        <td>${value.fax}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Phone</td>
                                                        <td>${value.phone}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mobilephone</td>
                                                        <td>${value.mobile_phone}</td>
                                                    </tr>
                                                </table>`;
                        });
                        $('#table-detail-pf > table').remove();
                        $('#table-detail-pf h5').after(tablePhoneFax);
                        $('#table-detail-pf').show();
                    } else {
                        $('#table-detail-pf > table').remove();
                        $('#table-detail-pf').hide();
                    }

                    if (results.branch_contact_person.length !== 0) {
                        var isMain = '';
                        var clMain = '';
                        var tableContactPerson = '';
                        $.each(results.branch_contact_person, function (key, value) {
                            isMain = `ALTERNATIVE ${key}`;
                            clMain = 'bg-orange';
                            if (key === 0) {
                                isMain = 'MAIN';
                                clMain = 'bg-blue';
                            }
                            tableContactPerson +=   `<table class="table table-bordered">
                                                        <tr class="${clMain}">
                                                            <td colspan="2" class="text-center">
                                                                <strong>${isMain}</strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30%">Name</td>
                                                            <td>${value.name}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Phone</td>
                                                            <td>${value.phone}</td>
                                                        </tr>
                                                        <tr><td>Address</td>
                                                            <td>${value.address}</td>
                                                        </tr>
                                                    </table>`;
                        });
                        $('#table-detail-cp > table').remove();
                        $('#table-detail-cp h5').after(tableContactPerson);
                        $('#table-detail-cp').show();
                    } else {
                        $('#table-detail-cp > table').remove();
                        $('#table-detail-cp').hide();
                    }

                    $('#detail').modal('show');
                }else{
                    alert(res.msg)
                }
            });
        }
        
        insertPhoneFaxToTable(){
            $('#table-phonefax tbody').html('');
            if (branch.arrDataPhoneFax.length != 0) {
                var tr = '';
                branch.arrDataPhoneFax.forEach(function (item, index) {
                    tr +=   `<tr>
                                <td>${index + 1}</td>
                                <td>${item.fax}</td>
                                <td>${item.phone}</td>
                                <td>${item.mobile_phone}</td>
                                <td>
                                    <a href="javascript:;" onclick="branch.editPhoneFax(${index})" class="btn btn-default btn-xs" title="Ubah">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:;" onclick="branch.deletePhoneFax(${index})" class="btn btn-default btn-xs"title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>`;
                });
                $('#table-phonefax tbody').html(tr);
                $('#table-phonefax').show();
                $('#form-phonefax').hide();
            } else {
                $('#table-phonefax').hide();
                branch.resetFormPhoneFax();
                $('#submit-pf').attr('onclick', 'branch.addPhoneFax()');
                $('#submit-pf').html('<i class="fa fa-plus-circle"></i>&nbsp;Tambah');
                $('#cancel-pf').hide();
                $('#form-phonefax').show();
                $('input[name="fax"]').focus();
            }
        }
        
        resetFormPhoneFax(){
            $('input[name="fax"]').val('').removeClass('error').removeAttr('style').next('span.form-error').remove();
            $('input[name="fax"]').parent().removeClass('has-error');
            $('input[name="phone"]').val('').removeClass('error').removeAttr('style').next('span.form-error').remove();
            $('input[name="phone"]').parent().removeClass('has-error');
            $('input[name="mobile_phone"]').val('').removeClass('error').removeAttr('style').next('span.form-error').remove();
            $('input[name="mobile_phone"]').parent().removeClass('has-error');
        }
        
        addPhoneFax() {
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
                    branch.arrDataPhoneFax.push({"fax": fax, "phone": phone, "mobile_phone": mobilePhone});
                    branch.resetFormPhoneFax();
                    branch.insertPhoneFaxToTable();
                }
            }
        }

        deletePhoneFax(index) {
            if (confirm(`Yakin akan menghapus phone atau fax nomor ${index + 1} ?`)) {
                branch.arrDataPhoneFax.splice(index, 1);
                branch.insertPhoneFaxToTable();
            }
        }

        editPhoneFax(index) {
            branch.resetFormPhoneFax();
            $('input[name="fax"]').val(branch.arrDataPhoneFax[index].fax);
            $('input[name="phone"]').val(branch.arrDataPhoneFax[index].phone);
            $('input[name="mobile_phone"]').val(branch.arrDataPhoneFax[index].mobile_phone);
            $('#table-phonefax').hide();
            $('#submit-pf').attr('onclick', `branch.updatePhoneFax(${index})`);
            $('#submit-pf').html('<i class="fa fa-save"></i>&nbsp;Simpan Perubahan');
            $('#cancel-pf').show();
            $('#form-phonefax').show();
            $('input[name="fax"]').focus();
        }

        updatePhoneFax(index) {
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
                    branch.arrDataPhoneFax[index].fax = fax;
                    branch.arrDataPhoneFax[index].phone = phone;
                    branch.arrDataPhoneFax[index].mobile_phone = mobilePhone;
                    branch.resetFormPhoneFax();
                    branch.insertPhoneFaxToTable();
                }
            }
        }
        
        insertContactPersonToTable(arrDataContactPerson) {
            $('#table-contactperson tbody').html('');
            if (branch.arrDataContactPerson.length != 0) {
                var tr = '';
                branch.arrDataContactPerson.forEach(function (item, index) {
                    tr +=   `<tr>
                                <td>${index + 1}</td>
                                <td>${item.name}</td>
                                <td>${item.address}</td>
                                <td>${item.phone}</td>
                                <td>
                                    <a href="javascript:;" onclick="branch.editContactPerson(${index})" class="btn btn-default btn-xs" title="Ubah">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:;" onclick="branch.deleteContactPerson(${index})" class="btn btn-default btn-xs" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>`;
                });
                $('#table-contactperson tbody').html(tr);
                $('#table-contactperson').show();
                $('#form-contactperson').hide();
            } else {
                $('#table-contactperson').hide();
                branch.resetFormContactPerson();
                $('#submit-cp').attr('onclick', 'branch.addContactPerson()');
                $('#submit-cp').html('<i class="fa fa-plus-circle"></i>&nbsp;Tambah');
                $('#cancel-cp').hide();
                $('#form-contactperson').show();
                $('input[name="cp_name"]').focus();
            }
        }

        resetFormContactPerson() {
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

        addContactPerson() {
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
                    branch.arrDataContactPerson.push({"name": cpName, "address": cpAddress, "phone": cpPhone});
                    branch.resetFormContactPerson();
                    branch.insertContactPersonToTable();
                }
            }
        }

        deleteContactPerson(index) {
            if (confirm(`Yakin akan menghapus kontak personal nomor ${index + 1} ?`)) {
                branch.arrDataContactPerson.splice(index, 1);
                branch.insertContactPersonToTable();
            }
        }

        editContactPerson(index) {
            branch.resetFormContactPerson();
            $('input[name="cp_name"]').val(branch.arrDataContactPerson[index].name);
            $('textarea[name="cp_address"]').val(branch.arrDataContactPerson[index].address);
            $('input[name="cp_phone"]').val(branch.arrDataContactPerson[index].phone);
            $('#table-contactperson').hide();
            $('#submit-cp').attr('onclick', `branch.updateContactPerson(${index})`);
            $('#submit-cp').html('<i class="fa fa-save"></i>&nbsp;Simpan Perubahan');
            $('#cancel-cp').show();
            $('#form-contactperson').show();
            $('input[name="cp_name"]').focus();
        }

        updateContactPerson(index) {
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
                    branch.arrDataContactPerson[index].name = cpName;
                    branch.arrDataContactPerson[index].address = cpAddress;
                    branch.arrDataContactPerson[index].phone = cpPhone;
                    branch.resetFormContactPerson();
                    branch.insertContactPersonToTable();
                }
            }
        }
        
        // function arrayColumn
        arrayColumn(array, columnName) {
            return array.map(function(value,index) {
                return value[columnName];
            });
        }
        
        // function generate select2
        generateSelect2(element = '.select2', data = [], nameValue, nameText, selectedValue = false, selectedName = '', placeHolder = false, placeHolderValue = '') {
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
        ajaxRequest(url, method = 'GET', data = '', callback){
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
        
        // cek permission to display
        permissionDisplay() {
            let buttons = $("button");
            $.each(buttons, function (index, element){
                let key = $(element).data("action");
                for (var property in self.arrPrivilege) {
                    if (property == key) {
                        $(element).show();
                    }
                }
            });
        }
        
        // validate action
        validate() {
            <?php if(!$this->is_superuser): ?>
                if (typeof this.arrPrivilege[this.nameAction] === 'undefined') {
                    console.log("Anda tidak diperkenankan mengakses fungsi tersebut!");
                    alert("Anda tidak diperkenankan mengakses fungsi tersebut!");
                    return false;
                }
            <?php endif; ?>
        }
    }
    
    class ActionAdd extends Branch{
        constructor() {
            super();
            this.nameAction = 'add';
        }
        
        openModalAdd(){
            branch.validate();
            $("#modal-response-message").finish();
            $('#form-branch').trigger("reset");
            
            branch.generateSelect2('#input-branch-province', [], '', '', false, '', '--Pilih Provinsi--', '').prop('disabled', true);
            branch.generateSelect2('#input-branch-city', [], '', '', false, '', '--Pilih Kota--', '').prop('disabled', true);
            branch.generateSelect2('#input-branch-subdistrict', [], '', '', false, '', '--Pilih Kecamatan--', '').prop('disabled', true);
            branch.generateSelect2('#input-branch-village', [], '', '', false, '', '--Pilih Kelurahan--', '').prop('disabled', true);
            
            branch.ajaxRequest('common/general/option/province', 'GET', '', function(res_province){
                if(res_province.status == 200){
                    let dataProvince = res_province.data.results;
                    branch.generateSelect2('#input-branch-province', dataProvince, 'province_id', 'province_name', false, '', '--Pilih Provinsi--', '').prop('disabled', false);
                }else{
                    alert(res_province.msg);
                }
            });
            
            $('#modal .modal-title').text(`Form Tambah ${menuName}`);
            $('#form-branch').attr('data-url', `${siteUrl}setup/branch/act_add`);
            $('#modal').modal({
                backdrop: 'static',
                keyboard: false
            }, 'show');
        }        
    }
    class ActionUpdate extends Branch{
        constructor() {
            super();
            this.nameAction = 'update';
        }
        
        openModalUpdate(branchId){
            branch.validate();
            branch.ajaxRequest('common/general/setup/branch/get_detail', 'GET', {id: branchId}, function(res){
                if(res.status == 200){
                    let results = res.data;
                    
                    $('#form-branch').trigger("reset");
                    $('#modal .modal-title').text(`Form Ubah ${menuName}`);
                    $('#form-branch').attr('data-url', '<?php echo site_url('setup/branch/act_update'); ?>');
                    $("#modal-response-message").finish();
                    
                    $('#input-branch-id').val(results.branch_id);
                    $('#input-branch-name').val(results.branch_name);
                    $('#input-branch-code').val(results.branch_code);
                    $('#input-branch-address').val(results.branch_address);
                    $('#input-branch-zip-code').val(results.branch_zip_code);
                    
                    branch.generateSelect2('#input-branch-province', [], '', '', false, '', '--Pilih Provinsi--', '').prop('disabled', true);
                    branch.generateSelect2('#input-branch-city', [], '', '', false, '', '--Pilih Kota--', '').prop('disabled', true);
                    branch.generateSelect2('#input-branch-subdistrict', [], '', '', false, '', '--Pilih Kecamatan--', '').prop('disabled', true);
                    branch.generateSelect2('#input-branch-village', [], '', '', false, '', '--Pilih Kelurahan--', '').prop('disabled', true);
                    
                    branch.ajaxRequest('common/general/option/province', 'GET', '', function(res_province){
                        if(res_province.status == 200){
                            let dataProvince = res_province.data.results;
                            if(dataProvince.length > 0){
                                let provinceId = 0;
                                let provinceIndex = branch.arrayColumn(dataProvince, 'province_name').indexOf(results.branch_province_name);
                                if(provinceIndex != -1){
                                    provinceId = dataProvince[provinceIndex].province_id;
                                    branch.generateSelect2('#input-branch-province', dataProvince, 'province_id', 'province_name', provinceId, 'province_id', '--Pilih Provinsi--', '').prop('disabled', false);
                                    
                                    branch.ajaxRequest('common/general/option/city', 'GET', {province_id: provinceId}, function(res_city){
                                        if(res_city.status == 200){
                                            let dataCity = res_city.data.results;
                                            if(dataCity.length > 0){
                                                let cityId = 0;
                                                let cityIndex = branch.arrayColumn(dataCity, 'city_name').indexOf(results.branch_city_name);
                                                if(cityIndex != -1){
                                                    cityId = dataCity[cityIndex].city_id;
                                                    branch.generateSelect2('#input-branch-city', dataCity, 'city_id', 'city_name', cityId, 'city_id', '--Pilih Kota--', '').prop('disabled', false);

                                                    branch.ajaxRequest('common/general/option/subdistrict', 'GET', {city_id: cityId}, function(res_subdistrict){
                                                        if(res_subdistrict.status == 200){
                                                            let dataSubdistrict = res_subdistrict.data.results;
                                                            if(dataSubdistrict.length > 0){
                                                                let subdistrictId = 0;
                                                                let subdistrictIndex = branch.arrayColumn(dataSubdistrict, 'subdistrict_name').indexOf(results.branch_subdistrict_name);
                                                                if(subdistrictIndex != -1){
                                                                    subdistrictId = dataSubdistrict[subdistrictIndex].subdistrict_id
                                                                    branch.generateSelect2('#input-branch-subdistrict', dataSubdistrict, 'subdistrict_id', 'subdistrict_name', subdistrictId, 'subdistrict_id', '--Pilih Kecamatan--', '').prop('disabled', false);
                                                                    
                                                                    branch.ajaxRequest('common/general/option/village', 'GET', {subdistrict_id: subdistrictId}, function(res_village){
                                                                        if(res_village.status == 200){
                                                                            let dataVillage = res_village.data.results;
                                                                            if(dataVillage.length > 0){
                                                                                let villageId = 0;
                                                                                let villageIndex = branch.arrayColumn(dataVillage, 'village_name').indexOf(results.branch_village_name);
                                                                                if(villageIndex != -1){
                                                                                    villageId = dataVillage[villageIndex].village_id
                                                                                    branch.generateSelect2('#input-branch-village', dataVillage, 'village_id', 'village_name', villageId, 'village_id', '--Pilih Kelurahan--', '').prop('disabled', false);
                                                                                }else{
                                                                                    branch.generateSelect2('#input-branch-village', dataVillage, 'village_id', 'village_name', false, '', '--Pilih Kelurahan--', '').prop('disabled', false);
                                                                                }
                                                                            }
                                                                        }else{
                                                                            alert(res_village.msg);
                                                                        }
                                                                    });
                                                                }else{
                                                                    branch.generateSelect2('#input-branch-subdistrict', dataSubdistrict, 'subdistrict_id', 'subdistrict_name', false, '', '--Pilih Kecamatan--', '').prop('disabled', false);
                                                                }
                                                            }
                                                        }else{
                                                            alert(res_subdistrict.msg);
                                                        }
                                                    });
                                                }else{
                                                    console.log(dataCity);
                                                    branch.generateSelect2('#input-branch-city', dataCity, 'city_id', 'city_name', false, '', '--Pilih Kota--', '').prop('disabled', false);
                                                }
                                            }
                                        }else{
                                            alert(res_city.msg);
                                        }
                                    });
                                }else{
                                    branch.generateSelect2('#input-branch-province', dataProvince, 'province_id', 'province_name', false, '', '--Pilih Provinsi--', '').prop('disabled', false);
                                }
                            }
                        }else{
                            alert(res_province.msg);
                        }
                    });
                    
                    branch.arrDataPhoneFax = results.branch_phone_fax;
                    branch.arrDataContactPerson = results.branch_contact_person;
                    branch.insertPhoneFaxToTable();
                    branch.insertContactPersonToTable();

                    $('#modal').modal({
                        backdrop: 'static',
                        keyboard: false
                    }, 'show');
                }else{
                    alert(res.msg);
                }
            });
        }
    }
    class ActionDelete extends Branch{
        constructor() {
            super();
            this.nameAction = 'delete';
        }
        
        deleteData(com, grid, urlaction){
            let grid_id = $(grid).attr('id');
            grid_id = grid_id.substring(grid_id.lastIndexOf('grid_') + 5);
            let totalSelected = $('.trSelected', grid).length;
            if (totalSelected > 0) {
                if(confirm(`Yakin akan menghapus ${totalSelected} unit ?\nData tidak dapat dikembalikan lagi!`)){
                    let arrId = [];
                    $('.trSelected', grid).each(function () {
                        let id = $(this).attr('data-id');
                        arrId.push(id);
                    });
                    branch.ajaxRequest('setup/branch/act_delete', 'POST', {item: JSON.stringify(arrId)}, function(res){
                        $('#' + grid_id).flexReload();
                        let msgClass =  res.status == 200 ? 'response_confirmation alert alert-success' : 'response_confirmation alert alert-danger';
                        $("#response_message").finish();
                        $("#response_message").addClass(msgClass);
                        $("#response_message").slideDown("fast");
                        let msg = res.status == 200 ? res.data : res.msg;
                        $("#response_message").html(`<p>${msg}</p>`);
                        $("#response_message").delay(10000).slideUp(1000, function () {
                            $("#response_message").removeClass(msgClass);
                        });
                    });
                }
            }else{
                alert('Pilih terlebih dahulu data yang ingin dihapus.');
            }
        }
    }
    
    let branch = new Branch();
    let actionAdd = new ActionAdd();
    let actionUpdate = new ActionUpdate();
    let actionDelete = new ActionDelete();

    $(document).ready(function () {
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

        $('#form-branch').on('submit', function (e) {
            e.preventDefault();
            $('#form-branch button[type="submit"]').attr('disabled', 'disabled');
            let urlForm = $('#form-branch').attr('data-url');

            let formData = new FormData(this);
            formData.append('phone_fax', JSON.stringify(branch.arrDataPhoneFax));
            formData.append('contact_person', JSON.stringify(branch.arrDataContactPerson));

            let provinceValue = $('#input-branch-province').val();
            let cityValue = $('#input-branch-city').val();
            let subdistrictValue = $('#input-branch-subdistrict').val();
            let villageValue = $('#input-branch-village').val();

            formData.set('province', '');
            formData.set('city', '');
            formData.set('subdistrict', '');
            formData.set('village', '');
            if (provinceValue) {
                formData.set('province', $('#input-branch-province option[value="' + provinceValue + '"]').text());
                formData.set('city', $('#input-branch-city option[value="' + cityValue + '"]').text());
                formData.set('subdistrict', $('#input-branch-subdistrict option[value="' + subdistrictValue + '"]').text());
                formData.set('village', $('#input-branch-village option[value="' + villageValue + '"]').text());
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
                        $('#modal').modal('hide');
                        $('#form-branch button[type="submit"]').removeAttr('disabled');
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
                        $('#form-branch button[type="submit"]').removeAttr('disabled');
                        $("#modal-response-message").finish();

                        $("#modal-response-message").slideDown("fast");
                        $('#modal-response-message').html(res.msg);
                        $("#modal-response-message").delay(10000).slideUp(1000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#form-branch button[type="submit"]').removeAttr('disabled');
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });

         $('#input-branch-province').on('change', function (e) {
            let provinceId = $(this).val();
            if (provinceId) {
                branch.ajaxRequest('common/general/option/city', 'GET', {province_id: provinceId}, function(res){
                    if(res.status == 200){
                        let dataCity = res.data.results;
                        branch.generateSelect2('#input-branch-city', dataCity, 'city_id', 'city_name', false, '', '--Pilih Kota--', '')
                                .prop('disabled', false).attr('data-validation', 'required').prev().find('span').text('*');
                        $('span.form-error').remove();
                        $('.has-success').removeClass('has-success');
                        $('.valid .error').removeClass('valid error').css('border-color', '');
                        branch.generateSelect2('#input-branch-subdistrict', [], '', '', false, '', '--Pilih Kecamatan--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('*');
                        branch.generateSelect2('#input-branch-village', [], '', '', false, '', '--Pilih Kelurahan--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('*');
                    }else{
                        alert(res.msg);
                    }
                });
            } else {
                $('span.form-error').remove();
                $('.has-success').removeClass('has-success');
                $('.valid .error').removeClass('valid error').css('border-color', '');

                branch.generateSelect2('#input-branch-city', [], '', '', false, '', '--Pilih Kota--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
                branch.generateSelect2('#input-branch-subdistrict', [], '', '', false, '', '--Pilih Kecamatan--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
                branch.generateSelect2('#input-branch-village', [], '', '', false, '', '--Pilih Kelurahan--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
            }
        });

        $('#input-branch-city').on('change', function (e) {
            let cityId = $(this).val();
            if (cityId) {
                branch.ajaxRequest('common/general/option/subdistrict', 'GET', {city_id: cityId}, function(res){
                    if(res.status == 200){
                        let dataSubdistrict = res.data.results;
                        branch.generateSelect2('#input-branch-subdistrict', dataSubdistrict, 'subdistrict_id', 'subdistrict_name', false, '', '--Pilih Kecamatan--', '')
                                .prop('disabled', false).attr('data-validation', 'required').prev().find('span').text('*');
                        $('span.form-error').remove();
                        $('.has-success').removeClass('has-success');
                        $('.valid .error').removeClass('valid error').css('border-color', '');
                        branch.generateSelect2('#input-branch-village', [], '', '', false, '', '--Pilih Kelurahan--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('*');
                    }else{
                        alert(res.msg);
                    }
                });
            } else {
                $('span.form-error').remove();
                $('.has-success').removeClass('has-success');
                $('.valid .error').removeClass('valid error').css('border-color', '');

                branch.generateSelect2('#input-branch-subdistrict', [], '', '', false, '', '--Pilih Kecamatan--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
                branch.generateSelect2('#input-branch-village', [], '', '', false, '', '--Pilih Kelurahan--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
            }
        });

        $('#input-branch-subdistrict').on('change', function (e) {
            let subdistrictId = $(this).val();
            if (subdistrictId) {
                branch.ajaxRequest('common/general/option/village', 'GET', {subdistrict_id: subdistrictId}, function(res){
                    if(res.status == 200){
                        let dataVillage = res.data.results;
                        branch.generateSelect2('#input-branch-village', dataVillage, 'village_id', 'village_name', false, '', '--Pilih Kelurahan--', '')
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

                branch.generateSelect2('#input-branch-village', [], '', '', false, '', '--Pilih Kelurahan--', '')
                                .prop('disabled', true).attr('data-validation', '').prev().find('span').text('');
            }
        });

        $('#open-form-phonefax').on('click', function (e) {
            $('#table-phonefax').hide();
            $('#submit-pf').attr('onclick', 'branch.addPhoneFax()');
            $('#submit-pf').html('<i class="fa fa-plus-circle"></i>&nbsp;Tambah');
            branch.resetFormPhoneFax();
            $('#cancel-pf').show();
            $('#form-phonefax').show();
            $('input[name="fax"]').focus();
        });

        $('#open-form-cp').on('click', function (e) {
            $('#table-contactperson').hide();
            $('#submit-cp').attr('onclick', 'branch.addContactPerson()');
            $('#submit-cp').html('<i class="fa fa-plus-circle"></i>&nbsp;Tambah');
            branch.resetFormContactPerson();
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
    
    $("#gridview").flexigrid({
        url: '<?php echo site_url("setup/branch/get_data"); ?>',
        dataType: 'json',
        colModel: [
            <?php if(privilege_view('update', $this->menu_privilege)):
                echo "{display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false},";
            endif; ?>
            {display: 'Detail', name: 'detail', width: 40, sortable: false, align: 'center', datasource: false},
            {display: 'Kode Unit', name: 'branch_code', width: 100, sortable: true, align: 'center'},
            {display: 'Nama Unit', name: 'branch_name', width: 200, sortable: true, align: 'left'},
            {display: 'Alamat Unit', name: 'branch_address', width: 200, sortable: true, align: 'left'},
            {display: 'Provinsi', name: 'branch_province_name', width: 150, sortable: true, align: 'left'},
            {display: 'Kota', name: 'branch_city_name', width: 180, sortable: true, align: 'left'},
            {display: 'Kecamatan', name: 'branch_subdistrict_name', width: 150, sortable: true, align: 'left'},
            {display: 'Kelurahan', name: 'branch_village_name', width: 150, sortable: true, align: 'left'},
            {display: 'Kode Pos', name: 'branch_zip_code', width: 80, sortable: true, align: 'left'},
            {display: 'Phone / Fax', name: 'phone_fax', width: 180, sortable: false, align: 'left'},
            {display: 'Kontak Personal', name: 'contact_person', width: 180, sortable: false, align: 'left'},
        ],
        buttons: [
            <?php if(privilege_view('update', $this->menu_privilege)):
                echo "{display: 'Tambah Unit', name: 'add', bclass: 'add', onpress: actionAdd.openModalAdd},";
            endif;
            if(privilege_view('delete', $this->menu_privilege)):
                echo "
                    {separator: true},
                    {display: 'Pilih Semua', name: 'selectall', bclass: 'selectall', onpress: check},
                    {separator: true},
                    {display: 'Hapus Pilihan', name: 'selectnone', bclass: 'selectnone', onpress: check},
                    {separator: true},
                    {display: 'Hapus Unit', name: 'delete', bclass: 'delete', onpress: actionDelete.deleteData, urlaction: '" . site_url('setup/branch/act_delete') . "'},";
            endif; ?>
        ],
        buttons_right: [
            <?php if(privilege_view('export', $this->menu_privilege)):
                echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("setup/branch/export_data_branch") . "'}";
            endif; ?>
        ],
        searchitems: [
            {display: 'Kode Unit', name: 'branch_code', type: 'text'},
            {display: 'Nama Unit', name: 'branch_name', type: 'text'},
            {display: 'Alamat Unit', name: 'branch_address', type: 'text'},
            {display: 'Provinsi', name: 'branch_province_name', type: 'text'},
            {display: 'Kota', name: 'branch_city_name', type: 'text'},
            {display: 'Kecamatan', name: 'branch_subdistrict_name', type: 'text'},
            {display: 'Kelurahan', name: 'branch_village_name', type: 'text'},
            {display: 'Kode POS', name: 'branch_zip_code', type: 'text'},
        ],
        sortname: "branch_id",
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
    
    $.validate({
        modules: 'logic',
        lang: 'id'
    });
</script>
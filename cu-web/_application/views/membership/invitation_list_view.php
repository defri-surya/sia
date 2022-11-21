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
    .table-like-flexigrid .fbutton .upload{
        background: url(<?php echo site_url('addons/flexigrid/button/images/upload.png'); ?>) no-repeat scroll left center transparent;
    }
    .table-like-flexigrid .fbutton .excel{
        background: url(<?php echo site_url('addons/flexigrid/button/images/page_excel.png'); ?>) no-repeat scroll left center transparent;
    }
    .table-like-flexigrid .fbutton .list{
        background: url(<?php echo site_url('addons/flexigrid/button/images/list.png'); ?>) no-repeat scroll left center transparent;
    }
    .table-like-flexigrid .fbutton .accounting{
        background: url(<?php echo site_url('addons/flexigrid/button/images/accounting.png'); ?>) no-repeat scroll left center transparent;
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
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div id="response_message" style="display:none;"></div>
        <ul id="container-tabs" class="nav nav-tabs bar_tabs" role="tablist">
            <li class="active"><a data-toggle="tab" href="#tab-diksar">Undangan Diksar</a></li>
            <!--<li><a data-toggle="tab" href="#tab-diklan">Undangan Diklan</a></li>-->
        </ul>
        
        <div class="tab-content">
            <div id="tab-diksar" class="tab-pane fade in active">
                <table id="gridview-diksar" style="display:none;"></table>
            </div>
            <div id="tab-diklan" class="tab-pane fade">
                <table id="gridview-diklan" style="display:none;"></table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ADD/EDIT -->
<div id="modal-add-edit" class="modal" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <form id="form-add-edit" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body" style="overflow-y: auto; height: calc(100vh - 200px)">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div id="modal-response-message-diksar-add-edit" class="alert alert-danger fade in" style="display:none"></div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <div class="x_panel" style="padding: 0px;">
                                <div class="x_title">
                                    <h2>Data Anggota Diksar</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content" style="overflow: auto; height: calc(100vh - 300px);">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <button type="button" class="btn btn-xs btn-dark btn-round" onclick="openModalChooseMember()"><i class="fa fa-plus"></i>&nbsp;Pilih Anggota Diksar</button>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <table id="list-member-diksar" class="table-like-flexigrid" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 20%; text-align: center;">No. Bakal Anggota</th>
                                                        <th style="width: 65%;">Nama Anggota</th>
                                                        <th style="width: 5%; text-align: center;">Hapus</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="x_panel" style="padding: 0px;">
                                <div class="x_title">
                                    <h2>Informasi Undangan Diksar</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content" style="overflow: auto; height: calc(100vh - 300px);">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="control-label" for="input-datetime">Waktu Acara <span class="required">*</span>
                                            </label>
                                            <input type="text" name="datetime" id="input-datetime" class="form-control my-date-picker" placeholder="dd/mm/yyyy HH:mm" data-inputmask="'alias': 'datetime'" data-validation="required">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="input-code">No. Undangan <span class="required">*</span>
                                            </label>
                                            <input type="text" name="code" id="input-code" class="form-control" data-validation="required">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="input-subject">Perihal <span class="required">*</span>
                                            </label>
                                            <input type="text" name="subject" id="input-subject" class="form-control" data-validation="required">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="input-location">Lokasi Acara <span class="required">*</span>
                                            </label>
                                            <input type="text" name="location" id="input-location" class="form-control" data-validation="required">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="input-note">Catatan Acara <span class="required">*</span>
                                            </label>
                                            <textarea name="note" id="input-note" rows="5" class="form-control" data-validation="required"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Simpan Undangan Diksar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL ADD/EDIT -->

<!-- MODAL ABSEN DIKSAR -->
<div id="modal-absen-diksar" class="modal" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <form id="form-absen-diksar" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body" style="overflow-y: auto; height: calc(100vh - 200px)">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div id="modal-response-message-absen-diksar" class="alert alert-danger fade in" style="display:none"></div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <div class="x_panel" style="padding: 0px;">
                                <div class="x_title">
                                    <h2>Data Anggota Diksar</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content" style="overflow: auto; height: calc(100vh - 300px);">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input id="absen-id" type="hidden" name="id" value="">
                                            <input id="absen-date" type="hidden" name="date" value="">
                                            <table id="list-member-absen-diksar" class="table-like-flexigrid" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 20%; text-align: center;">No. Bakal Anggota</th>
                                                        <th style="width: 40%;">Nama Anggota</th>
                                                        <th style="width: 10%; text-align: center;">Tidak Lulus<br><label><input class="select-all" type="radio" name="selectall" value="2">Semua</label></th>
                                                        <th style="width: 10%; text-align: center;"><br>Lulus<br><label><input class="select-all" type="radio" name="selectall" value="1">Semua</label></th>
                                                        <th style="width: 10%; text-align: center;">Tidak Hadir<br><label><input class="select-all" type="radio" name="selectall" value="0">Semua</label></th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="x_panel" style="padding: 0px;">
                                <div class="x_title">
                                    <h2>Informasi Undangan Diksar</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content" style="overflow: auto; height: calc(100vh - 300px);">
                                        <div class="row">
                                            <div class="form-group">
                                            <label class="control-label">Waktu Acara
                                            </label>
                                            <input type="text" id="absen-datetime" class="form-control" readonly="readonly">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">No. Undangan
                                            </label>
                                            <input type="text" id="absen-code" class="form-control" readonly="readonly">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Perihal
                                            </label>
                                            <input type="text" id="absen-subject" class="form-control" readonly="readonly">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Lokasi Acara
                                            </label>
                                            <input type="text" id="absen-location" class="form-control" readonly="readonly">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Catatan Acara
                                            </label>
                                            <textarea id="absen-note" rows="5" class="form-control" readonly="readonly"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Simpan Absensi</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL ABSEN -->

<!-- MODAL DETAIL -->
<div id="modal-detail" class="modal" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Deatail Undangan</h4>
            </div>
            <div class="modal-body" style="overflow-y: auto; height: calc(100vh - 200px)">
                <div class="row">
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="x_panel" style="padding: 0px;">
                            <div class="x_title">
                                <h2>Data Anggota Diksar</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content" style="overflow: auto; height: calc(100vh - 300px);">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table id="list-member-diksar-detail" class="table-like-flexigrid" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20%; text-align: center;">No. Bakal Anggota</th>
                                                    <th style="width: 80%;">Nama Anggota</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <div class="x_panel" style="padding: 0px;">
                            <div class="x_title">
                                <h2>Informasi Undangan Diksar</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content" style="overflow: auto; height: calc(100vh - 300px);">
                                <div class="row">
                                    <div class="form-group">
                                        <label class="control-label">Waktu Acara
                                        </label>
                                        <input type="text" id="detail-datetime" class="form-control" readonly="readonly">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">No. Undangan
                                        </label>
                                        <input type="text" id="detail-code" class="form-control" readonly="readonly">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Perihal
                                        </label>
                                        <input type="text" id="detail-subject" class="form-control" readonly="readonly">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Lokasi Acara
                                        </label>
                                        <input type="text" id="detail-location" class="form-control" readonly="readonly">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Catatan Acara
                                        </label>
                                        <textarea id="detail-note" rows="5" class="form-control" readonly="readonly"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL DETAIL -->

<!-- MODAL CHOOSE MEMBER -->
<div id="modal-choose-member" class="modal" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Pilih Anggota</h4>
            </div>
            <div class="modal-body" style="overflow-y: auto; max-height: calc(100vh - 200px)">
                <div class="row">
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
<!-- END MODAL CHOOSE MEMBER -->

<!-- FORM VALIDATOR -->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    
    let gridDiksar, gridDiklan;
    
    let arrMember = []
    let arrExceptMember = [];
    
    function openModalAdd(){
        arrMember = [];
        arrExceptMember = [];
        
        generateHtmlTable('add');
        $('#input-datetime').val('');
        
        $('#modal-add-edit .modal-title').text('Form Tambah Undangan');
        $('#form-add-edit').attr('data-url', 'membership/invitation/act_add_diksar');
        $('#form-add-edit').trigger('reset');
        
        $('#modal-add-edit').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
    }
    
    function openModalChooseMember(){
        loadFlexigridMember();
        $('#modal-choose-member').modal('show');
    }
    
    function chooseMember(com, grid, urlaction){
        if ($('.trSelected', grid).length > 0) {
            $('.trSelected', grid).each(function () {
                var data = JSON.parse($(this).attr('data-id'));
                arrMember.push(data);
                arrExceptMember.push(data.id);
            });
            
            generateHtmlTable('add');
            
            loadFlexigridMember();
            
            $('#modal-choose-member').modal('hide');
        }else{
            alert('Pilih data terlebih dahulu.');
        }
    }
    
    function generateHtmlTable(type){
        let html = '';
        if(arrMember.length > 0){
            arrMember.forEach(function (item, index){
                if(type == 'add' || type == 'edit'){
                    html += `
                        <tr>
                            <td class="text-center">${item.temp_code}</td>
                            <td>${item.name}</td>
                            <td class="text-center"><a href="javascript:;" onclick="deleteItem(${index}, '${type}')"><img src="<?php echo site_url('addons/flexigrid/button/images/close.png'); ?>" border="0" alt="Hapus" title="Hapus" /></a></td>
                        </tr>`;
                }
                
                if(type == 'detail'){
                    html += `
                        <tr>
                            <td class="text-center">${item.temp_code}</td>
                            <td>${item.name}</td>
                        </tr>`;
                }
                
                if(type == 'absen'){
                    html += `
                        <tr>
                            <td class="text-center">${item.temp_code}</td>
                            <td>${item.name}</td>
                            <td class="text-center">
                                <input type="hidden" value="${item.id}" name="member[${index}][id]">
                                <input class="absen-2" type="radio" value="2" name="member[${index}][attend]">
                            </td>
                            <td class="text-center">
                                <input class="absen-1" type="radio" value="1" name="member[${index}][attend]">
                            </td>
                            <td class="text-center">
                                <input class="absen-0" type="radio" value="0" name="member[${index}][attend]">
                            </td>
                        </tr>
                    `;
                }
            });
        }else{
            if(type == 'add' || type == 'edit'){
                html += `
                    <tr>
                        <td colspan="3">Belum ada data.</td>
                    </tr>`;
            }
            
            if(type == 'detail'){
                html += `
                    <tr>
                        <td colspan="2">Belum ada data.</td>
                    </tr>`;
            }
            
            if(type == 'absen'){
                html += `
                    <tr>
                        <td colspan="5">Belum ada data.</td>
                    </tr>`;
            }
        }
        
        if(type == 'add' || type == 'edit'){
            $('#list-member-diksar tbody').html(html);
        }
        
        if(type == 'detail'){
            $('#list-member-diksar-detail tbody').html(html);
        }
        
        if(type == 'absen'){
            $('#list-member-absen-diksar tbody').html(html);
        }
    }
    
    function deleteItem(index, type){
        arrMember.splice(index, 1);
        arrExceptMember.splice(index, 1);
        generateHtmlTable(type);
    }
    
    function openModalEdit(id){
        // TODO
        arrMember = [];
        arrExceptMember = [];
        $('#modal-add-edit .modal-title').text('Form Ubah Undangan');
        $('#form-add-edit').attr('data-url', 'membership/invitation/act_update');
    }
    
    function openModalDetail(id){
        ajaxRequest('common/general/membership/invitation/get_detail', 'GET', {id: id}, function (res){
            arrMember = [];
            arrExceptMember = [];
            if(res.status == 200){
                let info = res.data;
                let detail = res.data.detail;
                
                $('#detail-datetime').val(moment(info.invitation_datetime).format('DD MMMM YYYY HH:mm'));
                $('#detail-code').val(info.invitation_code);
                $('#detail-subject').val(info.invitation_subject);
                $('#detail-location').val(info.invitation_location);
                $('#detail-note').val(info.invitation_note);
                
                detail.forEach(function (item, index){
                    arrMember.push({
                        id: item.invitation_detail_member_id,
                        code: item.member_code,
                        temp_code: item.member_temp_code,
                        name: item.member_name
                    });
                    arrExceptMember.push(item.invitation_detail_member_id);
                });
                
                generateHtmlTable('detail');
                
                $('#modal-detail').modal('show');
            }else{
                alert(res.msg);
            }
        });
    }
    
    function openModalAttendance(com, grid, urlaction){
        if ($('.trSelected', grid).length > 0) {
            let id = $('.trSelected', grid).attr('data-id');
            ajaxRequest('common/general/membership/invitation/get_detail', 'GET', {id: id}, function (res){
                arrMember = [];
                arrExceptMember = [];
                if(res.status == 200){
                    let info = res.data;
                    let detail = res.data.detail;
                    
                    if(info.invitation_status == 0){
                        
                        $('#absen-id').val(info.invitation_id);
                        $('#absen-date').val(moment(info.invitation_datetime).format('YYYY-MM-DD'));
                        
                        $('#form-absen-diksar').attr('data-url', 'membership/invitation/act_add_absen');
                        
                        $('#absen-datetime').val(moment(info.invitation_datetime).format('DD MMMM YYYY HH:mm'));
                        $('#absen-code').val(info.invitation_code);
                        $('#absen-subject').val(info.invitation_subject);
                        $('#absen-location').val(info.invitation_location);
                        $('#absen-note').val(info.invitation_note);

                        detail.forEach(function (item, index){
                            arrMember.push({
                                id: item.invitation_detail_member_id,
                                code: item.member_code,
                                temp_code: item.member_temp_code,
                                name: item.member_name
                            });
                            arrExceptMember.push(item.invitation_detail_member_id);
                        });

                        generateHtmlTable('absen');
                        
                        $('.select-all[value="0"]').prop('checked', true).change();

                        $('#modal-absen-diksar').modal({
                            backdrop: 'static',
                            keyboard: false
                        }, 'show');
                    }else{
                        alert("Absensi sudah dilakukan pada acara ini.\nSilahkan pilih acara yang belum terlaksana.");
                    }
                    
                }else{
                    alert(res.msg);
                }
            });
        }else{
            alert('Pilih data terlebih dahulu.');
        }
    }
    
    function printInvitation(com, grid, urlaction){
        if ($('.trSelected', grid).length > 0) {
            let id = $('.trSelected', grid).attr('data-id');
            
            ajaxRequest('common/general/membership/invitation/get_detail', 'GET', {id: id}, function (res){
                if(res.status == 200){
                    let info = res.data;
                    
                    if(info.invitation_status == 0){
                        openInNewTab(siteUrl + 'membership/invitation/act_print/' + id);
                    }else{
                        if(confirm("Acara sudah terlaksana, tetap lakukan print undangan?")){
                            openInNewTab(siteUrl + 'membership/invitation/act_print/' + id);
                        }
                    }
                }else{
                    alert(res.msg);
                }
            });
        }else{
            alert('Pilih data terlebih dahulu.');
        }
    }
    
    $(document).ready(function (){
        
        $('.select-all').on('change', function(){
           let value = $(this).val();
           if(value){
               console.log(value);
                switch (value) {
                    case '0':
                        $('.absen-0').prop('checked', true);
                        break;
                    case '1':
                        $('.absen-1').prop('checked', true);
                        break;
                    case '2':
                        $('.absen-2').prop('checked', true);
                        break;
                }
           }
        });
        
        let urlLocation = new URL(window.location);
        let params = new URLSearchParams(urlLocation.search);
        if(params.get('page') != null){
            if(params.get('page') == 'diklan'){
                $('#container-tabs a[data-toggle="tab"][href="#tab-diklan"]').click();
                loadGridDiklan();
            }
        }else{
            $('#container-tabs a[data-toggle="tab"][href="#tab-diksar"]').click();
            loadGridDiksar();
        }
        
        $('#container-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var uri = 'show';
            var target = $(e.target).attr("href");
            if (target === '#tab-diksar') {
                loadGridDiksar();
            } else if (target === '#tab-diklan') {
                loadGridDiklan();
                uri = 'show?page=diklan';
            }
            window.history.replaceState({}, '', uri);
        });
        
        $('#form-add-edit').on('submit', function (e) {
            e.preventDefault();
            
            $('#form-add-edit button[type="submit"]').attr('disabled', 'disabled');
            let urlForm = $('#form-add-edit').attr('data-url');

            let formData = new FormData(this);
            
            formData.append('member', JSON.stringify(arrExceptMember));

            $.ajax({
                type: 'POST',
                url: siteUrl + urlForm,
                data: formData,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    if (res.status == 200) {
                        $('#modal-add-edit').modal('hide');
                        $('#form-add-edit button[type="submit"]').removeAttr('disabled');
                        $('#gridview-diksar').flexReload();
                        let message_class = 'response_confirmation alert alert-success';

                        $("#response_message").finish();

                        $("#response_message").addClass(message_class);
                        $("#response_message").slideDown("fast");
                        $("#response_message").html(res.data);
                        $("#response_message").delay(10000).slideUp(1000, function () {
                            $("#response_message").removeClass(message_class);
                        });
                    } else {
                        $('#modal-add-edit .modal-body').animate({scrollTop: '0px'}, 300);
                        $('#form-add-edit button[type="submit"]').removeAttr('disabled');
                        $("#modal-response-message-diksar-add-edit").finish();

                        $("#modal-response-message-diksar-add-edit").slideDown("fast");
                        $('#modal-response-message-diksar-add-edit').html(res.msg);
                        $("#modal-response-message-diksar-add-edit").delay(10000).slideUp(1000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#form-add-edit button[type="submit"]').removeAttr('disabled');
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });
        
        $('#form-absen-diksar').on('submit', function (e) {
            e.preventDefault();
            
            $('#form-absen-diksar button[type="submit"]').attr('disabled', 'disabled');
            let urlForm = $('#form-absen-diksar').attr('data-url');

            let formData = new FormData(this);
            
            $.ajax({
                type: 'POST',
                url: siteUrl + urlForm,
                data: formData,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    if (res.status == 200) {
                        $('#modal-absen-diksar').modal('hide');
                        $('#form-absen-diksar button[type="submit"]').removeAttr('disabled');
                        $('#gridview-diksar').flexReload();
                        let message_class = 'response_confirmation alert alert-success';

                        $("#response_message").finish();

                        $("#response_message").addClass(message_class);
                        $("#response_message").slideDown("fast");
                        $("#response_message").html(res.data);
                        $("#response_message").delay(10000).slideUp(1000, function () {
                            $("#response_message").removeClass(message_class);
                        });
                    } else {
                        $('#modal-absen-diksar .modal-body').animate({scrollTop: '0px'}, 300);
                        $('#form-absen-diksar button[type="submit"]').removeAttr('disabled');
                        $("#modal-response-message-absen-diksar").finish();

                        $("#modal-response-message-absen-diksar").slideDown("fast");
                        $('#modal-response-message-absen-diksar').html(res.msg);
                        $("#modal-response-message-absen-diksar").delay(10000).slideUp(1000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#form-absen-diksar button[type="submit"]').removeAttr('disabled');
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });
    });
    
    function loadGridDiksar(){
        if(typeof gridDiksar == 'undefined'){
            gridDiksar = $("#gridview-diksar").flexigrid({
                url: siteUrl + 'membership/invitation/get_data',
                params: [{name: "invitation_event", value: 'diksar'}],
                dataType: 'json',
                colModel: [
//                    {display: 'Ubah', name: 'edit', width: 40, sortable: false, datasource:false, align: 'center'},
                    {display: 'Detail', name: 'detail', width: 40, sortable: false, datasource:false, align: 'center'},
                    {display: 'Waktu Acara', name: 'invitation_datetime', width: 180, sortable: true, align: 'center'},
                    {display: 'No. Undangan', name: 'invitation_code', width: 200, sortable: true, align: 'left'},
                    {display: 'Perihal', name: 'invitation_subject', width: 300, sortable: true, align: 'left'},
                    {display: 'Lokasi Acara', name: 'invitation_location', width: 250, sortable: true, align: 'left'},
                    {display: 'Catatan Acara', name: 'invitation_note', width: 500, sortable: true, align: 'left'},
                    {display: 'Status Acara', name: 'invitation_status', width: 100, sortable: true, align: 'center'},
                    {display: 'Waktu Buat', name: 'invitation_input_datetime', width: 180, sortable: true, align: 'center', hide: true},
                    {display: 'Waktu Berubah', name: 'invitation_update_datetime', width: 180, sortable: true, align: 'center', hide: true},
                    {display: 'Nama Admin', name: 'invitation_administrator_name', width: 100, sortable: true, align: 'left', hide: true},
                    {display: 'Username Admin', name: 'invitation_administrator_username', width: 200, sortable: true, align: 'left', hide: true},
                ],
                buttons: [
                    <?php
                    if (privilege_view('add', $this->menu_privilege)):
                        echo "{display: 'Tambah Undangan', name: 'add', bclass: 'add', onpress: openModalAdd},";
                    endif;
                    if (privilege_view('update', $this->menu_privilege)):
                        echo '{separator: true},';
                        echo "{display: 'Absensi', name: 'attentance', bclass: 'notes', onpress: openModalAttendance},";
                    endif;
                    if (privilege_view('print', $this->menu_privilege)):
                        echo '{separator: true},';
                        echo "{display: 'Cetak Undangan', name: 'print', bclass: 'print', onpress: printInvitation},";
                    endif;
                    ?>
                ],
                buttons_right: [
                    <?php
                    if (privilege_view('export', $this->menu_privilege)):
                        echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("membership/invitation/export_data/diksar") . "'}";
                    endif;
                    ?>
                ],
                searchitems: [
                    {display: 'Waktu Undangan', name: 'invitation_datetime', type: 'date'},
                    {display: 'No. Undangan', name: 'invitation_code', type: 'text'},
                    {display: 'Perihal', name: 'invitation_subject', type: 'text'},
                    {display: 'Lokasi Acara', name: 'invitation_location', type: 'text'},
                    {display: 'Catatan Acara', name: 'invitation_note', type: 'text'},
                    {display: 'Status Acara', name: 'invitation_status', type: 'select', option: '0:Belum terlaksana|1:Sudah terlaksana'},
                    {display: 'Waktu Buat', name: 'invitation_input_datetime', type: 'date'},
                    {display: 'Waktu Berubah', name: 'invitation_update_datetime', type: 'date'},
                    {display: 'Nama admin', name: 'invitation_administrator_name', type: 'text'},
                    {display: 'Username Admin', name: 'invitation_administrator_username', type: 'text'},
                ],
                sortname: "invitation_id",
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
            $("#gridview-diksar").flexOptions({
                url: siteUrl + 'membership/invitation/get_data',
                params: [{name: "invitation_event", value: 'diksar'}],
            }).flexClearReload();
        }
    }
    
    function loadGridDiklan(){
        if(typeof gridDiklan == 'undefined'){
            gridDiklan = $("#gridview-diklan").flexigrid({
                url: siteUrl + 'membership/invitation/get_data',
                params: [{name: "invitation_event", value: 'diktan'}],
                dataType: 'json',
                colModel: [
//                    {display: 'Ubah', name: 'edit', width: 40, sortable: false, datasource:false, align: 'center'},
                    {display: 'Detail', name: 'detail', width: 40, sortable: false, datasource:false, align: 'center'},
                    {display: 'Waktu Acara', name: 'invitation_datetime', width: 180, sortable: true, align: 'center'},
                    {display: 'No. Undangan', name: 'invitation_code', width: 200, sortable: true, align: 'left'},
                    {display: 'Perihal', name: 'invitation_subject', width: 300, sortable: true, align: 'left'},
                    {display: 'Lokasi Acara', name: 'invitation_location', width: 250, sortable: true, align: 'left'},
                    {display: 'Catatan Acara', name: 'invitation_note', width: 500, sortable: true, align: 'left'},
                    {display: 'Status Acara', name: 'invitation_status', width: 100, sortable: true, align: 'center'},
                    {display: 'Waktu Buat', name: 'invitation_input_datetime', width: 180, sortable: true, align: 'center', hide: true},
                    {display: 'Waktu Berubah', name: 'invitation_update_datetime', width: 180, sortable: true, align: 'center', hide: true},
                    {display: 'Nama Admin', name: 'invitation_administrator_name', width: 100, sortable: true, align: 'left', hide: true},
                    {display: 'Username Admin', name: 'invitation_administrator_username', width: 200, sortable: true, align: 'left', hide: true},
                ],
                buttons: [
                    <?php
                    if (privilege_view('add', $this->menu_privilege)):
                        echo "{display: 'Tambah Undangan', name: 'add', bclass: 'add', onpress: openModalAdd},";
                    endif;
                    if (privilege_view('update', $this->menu_privilege)):
                        echo '{separator: true},';
                        echo "{display: 'Absensi', name: 'attentance', bclass: 'notes', onpress: openModalAttendance},";
                    endif;
                    if (privilege_view('print', $this->menu_privilege)):
                        echo '{separator: true},';
                        echo "{display: 'Cetak Undangan', name: 'print', bclass: 'print', onpress: printInvitation},";
                    endif;
                    ?>
                ],
                buttons_right: [
                    <?php
                    if (privilege_view('export', $this->menu_privilege)):
                        echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("membership/invitation/export_data/diklan") . "'}";
                    endif;
                    ?>
                ],
                searchitems: [
                    {display: 'Waktu Undangan', name: 'invitation_datetime', type: 'date'},
                    {display: 'No. Undangan', name: 'invitation_code', type: 'text'},
                    {display: 'Perihal', name: 'invitation_subject', type: 'text'},
                    {display: 'Lokasi Acara', name: 'invitation_location', type: 'text'},
                    {display: 'Catatan Acara', name: 'invitation_note', type: 'text'},
                    {display: 'Status Acara', name: 'invitation_status', type: 'select', option: '0:Belum terlaksana|1:Sudah terlaksana'},
                    {display: 'Waktu Buat', name: 'invitation_input_datetime', type: 'date'},
                    {display: 'Waktu Berubah', name: 'invitation_update_datetime', type: 'date'},
                    {display: 'Nama admin', name: 'invitation_administrator_name', type: 'text'},
                    {display: 'Username Admin', name: 'invitation_administrator_username', type: 'text'},
                ],
                sortname: "invitation_id",
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
            $("#gridview-diklan").flexOptions({
                url: siteUrl + 'membership/invitation/get_data',
                params: [{name: "invitation_event", value: 'diktan'}],
            }).flexClearReload();
        }
    }
    
    let colModelGridMember = [
        {display: 'No. Anggota', name: 'member_code', width: 80, sortable: true, align: 'center'},
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
    ];
    let searchitemsGridMember = [
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
    ];
    
    function loadFlexigridMember(){
        if(typeof gridMember == 'undefined'){
            gridMember = $('#gridview-member').flexigrid({
                url: siteUrl + 'membership/invitation/get_data_member',
                params: [{name: "except_member", value: JSON.stringify(arrExceptMember)}],
                dataType: 'json',
                colModel: colModelGridMember,
                buttons: [
                    <?php
                    if (privilege_view('add', $this->menu_privilege)):
                        echo "
                            {display: 'P<u>i</u>lih Anggota', name: 'add', bclass: 'add', onpress: chooseMember},
                            {separator: true},
                            {display: 'Pilih Semua', name: 'selectall', bclass: 'selectall', onpress: check},
                            {separator: true},
                            {display: 'Hapus Pilihan', name: 'selectnone', bclass: 'selectnone', onpress: check},
                            ";
                    endif;
                    ?>
                ],
                searchitems: searchitemsGridMember,
                sortname: "member_registered_date",
                sortorder: "ASC",
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
            $("#gridview-member").flexOptions({
                url: siteUrl + 'membership/invitation/get_data_member',
                params: [{name: "except_member", value: JSON.stringify(arrExceptMember)}],
            }).flexClearReload();
        }
        $('.trSelected').focus();
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
    
    // function for open in new tab
    function openInNewTab(url) {
        window.open(url);
        window.focus();
    }
    
    $.validate({
        lang: 'id'
    });
</script>

<!-- FORM INPUTMASK -->
<script src="<?php echo THEMES_BACKEND; ?>/js/jquery.inputmask.bundle.js"></script>
<script>
      $(".my-date-picker").inputmask({
            format: 'DD/MM/YYYY HH:mm',
        });
</script>
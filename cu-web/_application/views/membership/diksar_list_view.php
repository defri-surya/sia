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
            <li class="active"><a data-toggle="tab" href="#tab-not-yet">Anggota Belum Diksar</a></li>
            <li><a data-toggle="tab" href="#tab-already">Anggota Sudah Diksar</a></li>
        </ul>
        
        <div class="tab-content">
            <div id="tab-not-yet" class="tab-pane fade in active">
                <table id="gridview-not-yet" style="display:none;"></table>
            </div>
            <div id="tab-already" class="tab-pane fade">
                <table id="gridview-already" style="display:none;"></table>
            </div>
        </div>
    </div>
</div>

<!-- Modal diksar-->
<div id="modal-diksar" class="modal" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Konfirmasi Diksar</h4>
            </div>
            <form id="form-diksar" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body" style="overflow-y: auto; max-height: calc(100vh - 200px)">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div id="modal-response-message-diksar" class="alert alert-danger fade in" style="display:none"></div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="hidden" name="member_id" id="confirm-member-id" value="">
                            <div class="form-group">
                                <label class="control-label" for="confirm-member-code-text">No. Bakal Anggota
                                </label>
                                <input type="text" id="confirm-member-code-text" class="form-control" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="confirm-member-code-text">Nama Anggota
                                </label>
                                <input tabindex="1" type="text" id="confirm-member-name-text" class="form-control" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="confirm-member-code-text">Tanggal Diksar
                                </label>
                                <input data-inputmask="'alias': 'date'" tabindex="2" type="text" name="date" id="confirm-member-diksar-date" class="form-control my-date-picker" style="background-color: #fff;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button tabindex="2" type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp; Proses Diksar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end Modal diksar-->

<!-- Modal list upload excel-->
<div id="modal-list-upload" class="modal" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Konfirmasi Diksar</h4>
            </div>
            <form id="form-list-upload" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body" style="overflow-y: auto; max-height: calc(100vh - 200px)">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div id="modal-response-message-list-upload" class="alert alert-danger fade in" style="display:none"></div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table id="list-member-export" class="table-like-flexigrid" style="width: 100%;">
                                    <thead>
                                        <tr class="first">
                                            <th colspan="5">
                                                <div class="btn-action-left">
                                                    <div class="fbutton" onclick="openModalUpload()"><span class="upload">Upload Excel</span></div>
                                                    <div class="fbuttonseparator"></div>
                                                    <div class="fbutton" onclick="downloadFormatExcel()"><span class="excel">Download Format Excel</span></div>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th style="width: 15%; text-align: center;">No. Anggota</th>
                                            <th style="width: 45%;">Nama Anggota</th>
                                            <th style="width: 20%; text-align: center;">Tanggal Diksar</th>
                                            <th style="width: 15%; text-align: center;">Status Format</th>
                                            <th style="width: 5%; text-align: center;">Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp; Proses Diksar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end Modal upload excel-->

<!-- Modal upload-->
<div id="modal-upload" class="modal" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="closeModalUpload()">&times;</button>
                <h4 class="modal-title">Form Upload Diksar</h4>
            </div>
            <form id="form-upload" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body" style="overflow-y: auto; max-height: calc(100vh - 200px)">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div id="modal-response-message-upload" class="alert alert-danger fade in" style="display:none"></div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <div class="form-group">
                                <label class="control-label" for="excel">Upload Excel
                                </label>
                               <input tabindex="1" type="file" name="excel" id="excel" class="form-control" accept=".xls, .xlsx, .csv">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button tabindex="2" type="submit" class="btn btn-primary"><i class="fa fa-upload"></i>&nbsp; Upload File</button>
                    <button type="button" class="btn btn-default" onclick="closeModalUpload()">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end Modal upload form-->

<!--form validator-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    let gridNotYet, gridAlready;
    let arrData = [];
    
    function openModalProcessDiksar(com, grid, urlaction){
        $('#confirm-member-id').val('');
        $('#confirm-member-code-text').val('');
        $('#confirm-member-name-text').val('');
        $('#confirm-member-diksar-date').val(moment().format('DD/MM/YYYY'));
        
        let grid_id = $(grid).attr('id');
        grid_id = grid_id.substring(grid_id.lastIndexOf('grid_') + 5);
        
        if ($('.trSelected', grid).length > 0) {
            let memberId = $('.trSelected', grid).attr('data-id');
            let memberCode = $('.trSelected', grid).find('td[abbr=member_code] span').text();
            let memberTempCode = $('.trSelected', grid).find('td[abbr=member_temp_code] span').text();
            let memberName = $('.trSelected', grid).find('td[abbr=member_name] span').text();
            
            $('#confirm-member-id').val(memberId);
            $('#confirm-member-code-text').val(memberTempCode);
            $('#confirm-member-name-text').val(memberName);
            
            $('#modal-diksar').modal({
                backdrop: 'static',
                keyboard: false
            }, 'show');
        }else{
            alert('Anda belum memilih data.');
        }
    }
    
    function openModalListUpload(){
        arrData = [];
        insertListMemberDiksar();
        $('#modal-list-upload').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
    }
    
    function openModalUpload(){
        $('#form-upload').trigger('reset');
        $('#modal-list-upload').modal('hide');
        $('#modal-upload').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
    }
    
    function closeModalUpload(){
        $('#modal-upload').modal('hide');
        $('#modal-list-upload').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
    }
    
    function downloadFormatExcel(){
        window.location.href = siteUrl + 'membership/diksar/get_template_diksar';
    }
    
    function insertListMemberDiksar(){
        let html = '';
        if(arrData.length > 0){
            arrData.forEach(function (item, index){
                html += `<tr id="item-upload-${index}" class="item-upload">
                            <td class="text-center">${item.code}</td>
                            <td>${item.name}</td>
                            <td class="text-center">${item.date}</td>
                            <td class="text-center"><span class="label label-${item.status == 1 ? 'success' : 'danger'}">${item.status == 1 ? 'Valid' : 'Tidak Valid'}</span></td>
                            <td class="text-center"><a href="javascript:;" onclick="deleteItem(${index})"><img src="<?php echo site_url('addons/flexigrid/button/images/close.png'); ?>" border="0" alt="Hapus" title="Hapus" /></a></td>
                        </tr>`;
            });
        }else{
            html += `<tr>
                        <td colspan="5">Belum ada data.</td>
                    </tr>`;
        }
        
        $('#list-member-export tbody').html(html);
    }
    
    function deleteItem(index){
        arrData.splice(index, 1);
        insertListMemberDiksar();
    }
    
    $(document).ready(function (){
       
        
        $('#form-diksar').on('submit', function (e) {
            e.preventDefault();
            
            $('#form-diksar button[type="submit"]').attr('disabled', 'disabled');
            let urlForm = siteUrl + 'membership/diksar/act_update_one';

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
                        $('#modal-diksar').modal('hide');
                        $('#form-diksar button[type="submit"]').removeAttr('disabled');
                        $('#gridview-not-yet').flexReload();
                        let message_class = 'response_confirmation alert alert-success';

                        $("#response_message").finish();

                        $("#response_message").addClass(message_class);
                        $("#response_message").slideDown("fast");
                        $("#response_message").html(res.data);
                        $("#response_message").delay(10000).slideUp(1000, function () {
                            $("#response_message").removeClass(message_class);
                        });
                    } else {
                        $('#modal-diksar .modal-body').animate({scrollTop: '0px'}, 300);
                        $('#form-diksar button[type="submit"]').removeAttr('disabled');
                        $("#modal-response-message-diksar").finish();

                        $("#modal-response-message-diksar").slideDown("fast");
                        $('#modal-response-message-diksar').html(res.msg);
                        $("#modal-response-message-diksar").delay(10000).slideUp(1000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#form-diksar button[type="submit"]').removeAttr('disabled');
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });
        
        $('#form-list-upload').on('submit', function (e) {
            e.preventDefault();
            
            if(arrData.length <= 0 ){
                alert('Data Anggota Diksar belum ada.'); return false;
            }
            
            $('#form-list-upload button[type="submit"]').attr('disabled', 'disabled');
            let urlForm = siteUrl + 'membership/diksar/act_update_many';

            $.ajax({
                type: 'POST',
                url: urlForm,
                data: {item:JSON.stringify(arrData)},
                dataType: 'json',
                success: function (res) {
                    if (res.status == 200) {
                        $('#modal-list-upload').modal('hide');
                        $('#form-list-upload button[type="submit"]').removeAttr('disabled');
                        $('#gridview-not-yet').flexReload();
                        let message_class = 'response_confirmation alert alert-success';

                        $("#response_message").finish();

                        $("#response_message").addClass(message_class);
                        $("#response_message").slideDown("fast");
                        $("#response_message").html(res.data);
                        $("#response_message").delay(10000).slideUp(1000, function () {
                            $("#response_message").removeClass(message_class);
                        });
                    } else {
                        $('#gridview-not-yet').flexReload();
                        $('#modal-list-upload .modal-body').animate({scrollTop: '0px'}, 300);
                        $('#form-list-upload button[type="submit"]').removeAttr('disabled');
                        $("#modal-response-message-list-upload").finish();

                        $("#modal-response-message-list-upload").slideDown("fast");
                        $('#modal-response-message-list-upload').html(res.msg.message);
                        $("#modal-response-message-list-upload").delay(10000).slideUp(1000);
                        if(typeof res.msg.data != 'undefined'){
                            if(res.msg.data.length > 0){
                                $('.item-upload').hide();
                                res.msg.data.forEach(function (item, index){
                                    $('#item-upload-' + item).css('background-color', '#ffd1d1').show();
                                });
                            }
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#form-list-upload button[type="submit"]').removeAttr('disabled');
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });
        
        $('#form-upload').on('submit', function (e) {
            e.preventDefault();
            
            $('#form-upload button[type="submit"]').attr('disabled', 'disabled');
            let urlForm = siteUrl + 'membership/diksar/act_upload';

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
                        $('#modal-upload').modal('hide');
                        arrData = JSON.parse(res.data);
                        insertListMemberDiksar();
                        $('#modal-list-upload').modal({
                            backdrop: 'static',
                            keyboard: false
                        }, 'show');
                        $('#form-upload button[type="submit"]').removeAttr('disabled');
                    } else {
                        $('#form-upload button[type="submit"]').removeAttr('disabled');
                        $("#modal-response-message-upload").finish();

                        $("#modal-response-message-upload").slideDown("fast");
                        $('#modal-response-message-upload').html(res.msg);
                        $("#modal-response-message-upload").delay(10000).slideUp(1000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#form-upload button[type="submit"]').removeAttr('disabled');
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });
        
        let urlLocation = new URL(window.location);
        let params = new URLSearchParams(urlLocation.search);
        if(params.get('page') != null){
            if(params.get('page') == 'already'){
                $('#container-tabs a[data-toggle="tab"][href="#tab-already"]').click();
                loadGridAlready();
            }
        }else{
            $('#container-tabs a[data-toggle="tab"][href="#tab-not-yet"]').click();
            loadGridNotYet();
        }
        
        $('#container-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var uri = 'show';
            var target = $(e.target).attr("href"); // activated tab
            if (target === '#tab-not-yet') {
                loadGridNotYet();
            } else if (target === '#tab-already') {
                loadGridAlready();
                uri = 'show?page=already';
            }
            window.history.replaceState({}, '', uri);
        });
    });
    
    function loadGridNotYet(){
        if(typeof gridNotYet == 'undefined'){
            gridNotYet = $("#gridview-not-yet").flexigrid({
                url: siteUrl + 'membership/diksar/get_data',
                params: [{name: "member_is_diksar", value: 0}],
                dataType: 'json',
                colModel: [
                    {display: 'No. Bakal Anggota', name: 'member_temp_code', width: 110, sortable: true, align: 'center'},
                    {display: 'Nama', name: 'member_name', width: 200, sortable: true, align: 'left'},
                    {display: 'Status Keanggotaan', name: 'member_status', width: 180, sortable: true, align: 'center'},
                    {display: 'Uang Pangkal', name: 'member_entrance_fee_paid_off', width: 100, sortable: true, align: 'center'},
                    {display: 'No. Identitas', name: 'member_identity_number', width: 150, sortable: true, align: 'center', hide: true},
                    {display: 'Tipe Identitas', name: 'member_identity_type', width: 80, sortable: true, align: 'center', hide: true},
                    {display: 'Jenis Kelamin', name: 'member_gender', width: 80, sortable: true, align: 'center'},
                    {display: 'Tanggal Lahir', name: 'member_birthdate', width: 180, sortable: true, align: 'center', hide: true},
                    {display: 'Tanggal Diksar', name: 'member_diksar_date', width: 180, sortable: true, align: 'center'},
                    {display: 'Kewarganegaraan', name: 'member_nationality', width: 110, sortable: true, align: 'center'},
                    {display: 'Waktu Daftar', name: 'member_join_datetime', width: 200, sortable: true, align: 'center'},
                    {display: 'Nama Administrator Input', name: 'member_input_admin_name', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Waktu Administrator Input', name: 'member_input_datetime', width: 100, sortable: true, align: 'center', hide: true},
                    {display: 'Unit', name: 'branch_name', width: 150, sortable: true, align: 'left'},
                ],
                buttons: [
                    <?php
                    if (privilege_view('approve', $this->menu_privilege)):
                        echo "{display: 'Proses Diksar', name: 'approve', bclass: 'check', onpress: openModalProcessDiksar},";
                        echo "{separator: true},";
                        echo "{display: 'Upload Proses Diksar', name: 'upload', bclass: 'upload', onpress: openModalListUpload},";
                    endif;
                    ?>
                            ],
                buttons_right: [
                    <?php
                    if (privilege_view('export', $this->menu_privilege)):
                        echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("membership/diksar/export_data_not_yet_diksar") . "'}";
                    endif;
                    ?>
                ],
                searchitems: [
                    {display: 'Unit', name: 'branch_name', type: 'text'},
                    {display: 'No. Bakal Anggota', name: 'member_temp_code', type: 'text'},
                    {display: 'Nama', name: 'member_name', type: 'text'},
                    {display: 'No. Identitas', name: 'member_identity_number', type: 'text'},
                    {display: 'Tipe Identitas', name: 'member_identity_type', type: 'select', option: '0:KTP|1:SIM|2:KK'},
                    {display: 'Jenis Kelamin', name: 'member_gender', type: 'select', option: '0:Pria|1:Wanita'},
                    {display: 'Tanggal Lahir', name: 'member_birthdate', type: 'text'},
                    {display: 'Status Keanggotaan', name: 'member_status', type: 'select', option: '0:Anggota Koperasi|1:Anggota Luar Biasa Dewasa|2:Anggota Luar Biasa Anak|3:Calon Anggota Dewasa|4:Calon Anggota Anak'},
                    {display: 'Tanggal Diksar', name: 'member_diksar_date', type: 'date'},
                    {display: 'Kewarganegaraan', name: 'member_nationality', type: 'select', option:'0:WNI|1:WNA'},
                    {display: 'Uang Pangkal', name: 'member_entrance_fee_paid_off', type: 'select', option:'0:Belum Lunas|1:Lunas'},
                    {display: 'Waktu Daftar', name: 'member_join_datetime', type: 'date'},
                    {display: 'Nama Administrator Input', name: 'member_input_admin_name', type: 'text'},
                    {display: 'Waktu Administrator Input', name: 'member_input_datetime', type: 'date'},
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
        }else{
            $("#gridview-not-yet").flexOptions({
                url: siteUrl + 'membership/diksar/get_data',
                params: [{name: "member_is_diksar", value: 0}],
            }).flexClearReload();
        }
    }
    
    function loadGridAlready(){
        if(typeof gridAlready == 'undefined'){
            gridAlready = $("#gridview-already").flexigrid({
                url: siteUrl + 'membership/diksar/get_data',
                params: [{name: "member_is_diksar", value: 1}],
                dataType: 'json',
                colModel: [
                    {display: 'No. Anggota', name: 'member_code', width: 80, sortable: true, align: 'center'},
                    {display: 'No. Bakal Anggota', name: 'member_temp_code', width: 110, sortable: true, align: 'center'},
                    {display: 'Nama', name: 'member_name', width: 200, sortable: true, align: 'left'},
                    {display: 'Status Keanggotaan', name: 'member_status', width: 180, sortable: true, align: 'center'},
                    {display: 'Uang Pangkal', name: 'member_entrance_fee_paid_off', width: 100, sortable: true, align: 'center'},
                    {display: 'No. Identitas', name: 'member_identity_number', width: 150, sortable: true, align: 'center', hide: true},
                    {display: 'Tipe Identitas', name: 'member_identity_type', width: 80, sortable: true, align: 'center', hide: true},
                    {display: 'Jenis Kelamin', name: 'member_gender', width: 80, sortable: true, align: 'center'},
                    {display: 'Tanggal Lahir', name: 'member_birthdate', width: 180, sortable: true, align: 'center', hide: true},
                    {display: 'Tanggal Diksar', name: 'member_diksar_date', width: 180, sortable: true, align: 'center'},
                    {display: 'Kewarganegaraan', name: 'member_nationality', width: 110, sortable: true, align: 'center'},
                    {display: 'Waktu Daftar', name: 'member_join_datetime', width: 200, sortable: true, align: 'center'},
                    {display: 'Nama Administrator Input', name: 'member_input_admin_name', width: 200, sortable: true, align: 'left', hide: true},
                    {display: 'Waktu Administrator Input', name: 'member_input_datetime', width: 100, sortable: true, align: 'center', hide: true},
                   {display: 'Cabang', name: 'branch_name', width: 150, sortable: true, align: 'left'},
                ],
                buttons_right: [
                    <?php
                    if (privilege_view('export', $this->menu_privilege)):
                        echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("membership/diksar/export_data_already_diksar") . "'}";
                    endif;
                    ?>
                ],
                searchitems: [
                    {display: 'Cabang', name: 'branch_name', type: 'text'},
                    {display: 'No. Anggota', name: 'member_code', type: 'text'},
                    {display: 'No. Bakal Anggota', name: 'member_temp_code', type: 'text'},
                    {display: 'Nama', name: 'member_name', type: 'text'},
                    {display: 'No. Identitas', name: 'member_identity_number', type: 'text'},
                    {display: 'Tipe Identitas', name: 'member_identity_type', type: 'select', option: '0:KTP|1:SIM|2:KK'},
                    {display: 'Jenis Kelamin', name: 'member_gender', type: 'select', option: '0:Pria|1:Wanita'},
                    {display: 'Tanggal Lahir', name: 'member_birthdate', type: 'text'},
                    {display: 'Status Keanggotaan', name: 'member_status', type: 'select', option: '0:Anggota Koperasi|1:Anggota Luar Biasa Dewasa|2:Anggota Luar Biasa Anak|3:Calon Anggota Dewasa|4:Calon Anggota Anak'},
                    {display: 'Tanggal Diksar', name: 'member_diksar_date', type: 'date'},
                    {display: 'Kewarganegaraan', name: 'member_nationality', type: 'select', option:'0:WNI|1:WNA'},
                    {display: 'Uang Pangkal', name: 'member_entrance_fee_paid_off', type: 'select', option:'0:Belum Lunas|1:Lunas'},
                    {display: 'Waktu Daftar', name: 'member_join_datetime', type: 'date'},
                    {display: 'Nama Administrator Input', name: 'member_input_admin_name', type: 'text'},
                    {display: 'Waktu Administrator Input', name: 'member_input_datetime', type: 'date'},
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
            $("#gridview-already").flexOptions({
                url: siteUrl + 'membership/diksar/get_data',
                params: [{name: "member_is_diksar", value: 1}],
            }).flexClearReload();
        }
    }
    
    $.validate({
        modules: 'file',
        lang: 'id'
    });
</script>

<!-- FORM INPUTMASK -->
<script src="<?php echo THEMES_BACKEND; ?>/js/jquery.inputmask.bundle.js"></script>
<script>
      $(".my-date-picker").inputmask({
            format: 'DD/MM/YYYY'
        });
</script>
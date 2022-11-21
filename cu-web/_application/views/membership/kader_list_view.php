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
    .table-like-flexigrid thead tr.first.title th{
        background: rgba(29, 89, 162, 0.05);
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
    .table-like-flexigrid .fbutton .list{
        background: url(<?php echo site_url('addons/flexigrid/button/images/list.png'); ?>) no-repeat scroll left center transparent;
    }
    .table-like-flexigrid .fbutton .selectall{
        background: url(<?php echo site_url('addons/flexigrid/button/images/check-all.png'); ?>) no-repeat scroll left center transparent;
    }
    .table-like-flexigrid .fbutton .unselectall{
        background: url(<?php echo site_url('addons/flexigrid/button/images/check-none.png'); ?>) no-repeat scroll left center transparent;
    }
    .table-like-flexigrid .fbutton .print{
        background: url(<?php echo site_url('addons/flexigrid/button/images/printer.png'); ?>) no-repeat scroll left center transparent;
    }
    .table-like-flexigrid .fbutton .search{
        background: url(<?php echo site_url('addons/flexigrid/button/images/magnifier.png'); ?>) no-repeat scroll left center transparent;
    }
    .table-like-flexigrid .fbutton .reset{
        background: url(<?php echo site_url('addons/flexigrid/button/images/undo.png'); ?>) no-repeat scroll left center transparent;
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
    .table-like-flexigrid .flabel{
        background: transparent;
        float: left;
        padding: 3px;
    }
    .table-like-flexigrid .fbutton span{
        padding: 3px;
        padding-left: 20px;
    }
    .table-like-flexigrid .fbutton.no-icon span{
        padding: 3px;
    }
    .table-like-flexigrid .fbuttonseparator{
        float: left;
        height: 22px;
        border-left: 1px solid #ccc;
        border-right: 1px solid #fff;
        margin: 1px;
    }
    .main_container .select2-selection--single{
        height: 32px !important;
        min-height: auto !important;
    }
    .main_container .select2-selection__rendered{
        padding-top: 2px !important;
    }
    .main_container .select2-selection__arrow{
        height: 32px !important;
    }
    .input-sm + span.select2-container--default span.select2-selection--single {
        height: 30px!important;
        min-height: 30px!important;
    }
    .input-sm + span.select2-container--default span.select2-selection--single span.select2-selection__arrow {
        height: 30px!important;
    }
    .input-sm + span.select2-container--default span.select2-selection--single span.select2-selection__rendered {
        line-height: 24px !important;
    }
    .ui-autocomplete {
         max-height: 200px;
         overflow-y: auto;
         overflow-x: hidden;
         padding-right: 20px;
     } 
</style>
<div class="page-title">
    <div class="title_left">
        <h3 id="menu-title"></h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div id="container-grid" class="col-md-12 col-sm-12 col-xs-12">
        <div id="response_message" style="display:none;"></div>
        <table id="gridview" style="display:none;"></table>
    </div>
    <div id="container-grid-detail" class="col-md-12 col-sm-12 col-xs-12">
        <table id="gridview-detail" style="display:none;"></table>
    </div>
</div>

<!-- MODAL KADER -->
<div id="modal-kader" class="modal" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <form id="form-kader" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body" style="overflow-y: auto; height: calc(100vh - 200px)">
                    <div id="modal-response-message-kader" class="alert alert-danger alert-dismissible fade in" role="alert" style="display:none"></div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="input-kader-name">Kader <span class="required">*</span> </label>
                                    <div class="col-md-5 col-sm-5 col-xs-12">
                                        <input id="input-kader-id" type="hidden" name="member_id" value="0">
                                        <input type="text" id="input-kader-name" class="input-sm form-control" placeholder="Pilih Kader" readonly="readonly" data-validation="required">
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <button id="btn-serach-kader" type="button" class="btn btn-default btn-round btn-sm" onclick="openModalChooseKader()"><i class="fa fa-search"></i>&nbsp;Cari</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="nput-kader-area">Area <span class="required">*</span> </label>
                                    <div class="col-md-5 col-sm-5 col-xs-12">
                                        <input type="text" name="area" id="input-kader-area" class="input-sm form-control" data-validation="required">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="ln_solid"></div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                            <table id="table-member" style="width: 100%;" class="table-like-flexigrid">
                                <thead>
                                    <tr class="first">
                                        <th colspan="6">
                                            <div class="btn-action-right">
                                                <div class="fbutton" onclick="openModalChooseMember()"><span class="search">Cari Anggota</span></div>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th style="width: 4%; text-align: center"><a href="javascript:;" onclick="deleteRow('all')"><img src="<?php echo site_url('addons/flexigrid/button/images/close.png'); ?>" border="0" alt="Hapus Semua" title="Hapus Semua"></a></th>
                                        <th style="width: 15%; text-align: center;"><strong>No. Anggota</strong></th>
                                        <th style="width: 15%; text-align: center;"><strong>No. Bakal Anggota</strong></th>
                                        <th style="width: 76%;"><strong>Nama Anggota</strong></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Simpan <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL KADER-->

<!-- MODAL CHOOSE KADER -->
<div id="modal-choose-kader" class="modal" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Pilih Kader</h4>
            </div>
            <div class="modal-body" style="overflow-y: auto; height: calc(100vh - 200px)">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <table id="gridview-kader" style="display:none;"></table>
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
    
    let grid;
    let gridDetail;
    let gridKader;
    let gridMember;
    
    let kaderIdExport = 0;
    let kaderNameExport = '';
    
    let kaderMemberId = 0;
    
    let arrMember = [];
    
    function openModalAddKader(){
        $('#form-kader').trigger('reset');
        $('#form-kader').attr('data-url', 'membership/kader/act_add');
        $('#btn-serach-kader').show();
        kaderMemberId = 0;
        arrMember = [];
        generateHtmlTable();
        $('#modal-kader .modal-title').text('Form Tambah Kader');
        $('#modal-kader').modal('show');
    }
    
    function openModalChooseKader(){
        loadFlexigridKader();
        $('#modal-choose-kader').modal('show');
    }
    
    function openModalDataAnggota(){
        $('#form-kader').trigger('reset');
        $('#form-kader').attr('data-url', 'membership/kader/act_add');
        $('#btn-serach-kader').hide();
        kaderMemberId = 0;
        arrMember = [];
        generateHtmlTable();
        
        // TODO: ajax get data
        $('#modal-kader .modal-title').text('Form Tambah Anggota');
        $('#modal-kader').modal('show');
    }
    
    function openModalChooseMember(){
        loadFlexigridMember();
        $('#modal-choose-member').modal('show');
    }
    
    function openDetail(memberId, memberName){
        loadFlexigridDetail(memberId, memberName);
    }
    
    function chooseKader(com, grid, urlaction){
        if ($('.trSelected', grid).length > 0) {
            let data = JSON.parse($('.trSelected', grid).attr('data-id'));
            kaderMemberId = data.id;
            $('#input-kader-id').val(kaderMemberId);
            $('#input-kader-name').val(data.name);
            
            $('#modal-choose-kader').modal('hide');
        }else{
            alert('Pilih data terlebih dahulu.');
        }
    }
    
    function chooseMember(com, grid, urlaction){
        if ($('.trSelected', grid).length > 0) {
            $('.trSelected', grid).each(function () {
                var data = JSON.parse($(this).attr('data-id'));
                arrMember.push(data);
            });
            
            generateHtmlTable();
            
            $('#modal-choose-member').modal('hide');
        }else{
            alert('Pilih data terlebih dahulu.');
        }
    }
    
    function generateHtmlTable(){
        let html = '';
        if(arrMember.length > 0){
            arrMember.forEach(function (item, index){
                html += `
                    <tr>
                        <td class="text-center"><a href="javascript:;" onclick="deleteItem(${index})"><img src="<?php echo site_url('addons/flexigrid/button/images/close.png'); ?>" border="0" alt="Hapus" title="Hapus" /></a></td>
                        <td class="text-center">${item.code}</td>
                        <td class="text-center">${item.temp_code}</td>
                        <td>${item.name}</td>
                    </tr>`;
            });
        }else{
            html += `
                <tr>
                    <td colspan="4">Belum ada data.</td>
                </tr>`;
        }
        
        $('#table-member tbody').html(html);
        
    }
    
    function deleteItem(index){
        arrMember.splice(index, 1);
        generateHtmlTable();
    }
    
    function deleteData(com, grid, urlaction){
        if ($('.trSelected', grid).length > 0) {
            let id = $('.trSelected', grid).attr('data-id');

            ajaxRequest('membership/kader/act_delete', 'POST', {member_id: id}, function (res) {
                if(res.status == 200){
                    let message_class = 'response_confirmation alert alert-success';
                    $('#gridview').flexReload();
                    $("#response_message").finish();

                    $("#response_message").addClass(message_class);
                    $("#response_message").slideDown("fast");
                    $("#response_message").html(res.data);
                    $("#response_message").delay(10000).slideUp(1000, function () {
                        $("#response_message").removeClass(message_class);
                    });
                }else{
                    let message_class = 'response_confirmation alert alert-danger';

                    $("#response_message").finish();

                    $("#response_message").addClass(message_class);
                    $("#response_message").slideDown("fast");
                    $("#response_message").html(res.msg);
                    $("#response_message").delay(10000).slideUp(1000, function () {
                        $("#response_message").removeClass(message_class);
                    });
                }
            });
            
        }else{
            alert('Pilih data terlebih dahulu.');
        }
    }
    
    function myExportData(com, grid, urlaction){
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

        $form = $("<form target='_blank' method='post' action='" + urlaction + "'></form>");
        $form.append("<input id='export_column_name' type='hidden' name='column[name]' value='" + JSON.stringify(arr_column_name) + "' />");
        $form.append("<input id='export_column_title' type='hidden' name='column[title]' value='" + JSON.stringify(arr_column_title) + "' />");
        $form.append("<input id='export_column_show' type='hidden' name='column[show]' value='" + JSON.stringify(arr_column_show) + "' />");
        $form.append("<input id='export_column_align' type='hidden' name='column[align]' value='" + JSON.stringify(arr_column_align) + "' />");
        $form.append("<input id='export_sortname' type='hidden' name='sortname' value='" + sortname + "' />");
        $form.append("<input id='export_sortorder' type='hidden' name='sortorder' value='" + sortorder + "' />");
        $form.append("<input id='export_query' type='hidden' name='query' value='" + query + "' />");
        $form.append("<input id='export_querys' type='hidden' name='querys' value='" + querys + "' />");
        $form.append("<input id='export_optionused' type='hidden' name='optionused' value='" + optionused + "' />");
        $form.append("<input id='export_option' type='hidden' name='option' value='" + option + "' />");
        $form.append("<input id='export_date_start' type='hidden' name='date_start' value='" + date_start + "' />");
        $form.append("<input id='export_date_end' type='hidden' name='date_end' value='" + date_end + "' />");
        $form.append("<input id='export_qtype' type='hidden' name='qtype' value='" + qtype + "' />");
        $form.append("<input id='export_total_data' type='hidden' name='total_data' value='" + total_data + "' />");
        $form.append("<input id='export_rp' type='hidden' name='rp' value='" + rp + "' />");
        $form.append("<input id='export_page' type='hidden' name='page' value='" + page + "' />");
        $form.append("<input type='hidden' name='member_kader_id' value='" + kaderIdExport + "' />");
        $form.append("<input type='hidden' name='member_kader_name' value='" + kaderNameExport + "' />");
        $(grid).after($form);
        $form.submit();
    }
    
    $(document).ready(function(){
        
        loadFlexigrid();
        
        $('#form-kader').on('submit', function (e) {
            e.preventDefault();
            
            $('#form-kader button[type="submit"]').attr('disabled', 'disabled');
            let urlForm = $('#form-kader').attr('data-url');

            let formData = new FormData(this);
            formData.append('arr_member', JSON.stringify(arrMember));
            
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
                        $('#modal-kader').modal('hide');
                        $('#form-kader button[type="submit"]').removeAttr('disabled');
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
                        $('#modal-add-edit .modal-body').animate({scrollTop: '0px'}, 300);
                        $('#form-kader button[type="submit"]').removeAttr('disabled');
                        $("#modal-response-message-kader").finish();

                        $("#modal-response-message-kader").slideDown("fast");
                        $('#modal-response-message-kader').html(res.msg);
                        $("#modal-response-message-kader").delay(10000).slideUp(1000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#form-kader button[type="submit"]').removeAttr('disabled');
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });
    });
    
    function loadFlexigridKader(){
        if(typeof gridKader == 'undefined'){
            gridKader = $('#gridview-kader').flexigrid({
                url: siteUrl + 'membership/kader/get_data_kader',
                params: [{name: "except_kader", value: kaderMemberId}, {name: "except_member", value: JSON.stringify(arrMember)}],
                dataType: 'json',
                colModel: [
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
                ],
                buttons: [
                    <?php
                    if (privilege_view('add', $this->menu_privilege)):
                        echo "
                            {display: 'P<u>i</u>lih Kader', name: 'add', bclass: 'add', onpress: chooseKader},
                            ";
                    endif;
                    ?>
                ],
                searchitems: [
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
                ],
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
                singleSelect: true
            });
        }else{
            $("#gridview-kader").flexOptions({
                url: siteUrl + 'membership/kader/get_data_kader',
                params: [{name: "except_kader", value: kaderMemberId}, {name: "except_member", value: JSON.stringify(arrMember)}],
            }).flexClearReload();
        }
        $('.trSelected').focus();
    }
    
    function loadFlexigridMember(){
        if(typeof gridMember == 'undefined'){
            gridMember = $('#gridview-member').flexigrid({
                url: siteUrl + 'membership/kader/get_data_member',
                params: [{name: "except_kader", value: kaderMemberId}, {name: "except_member", value: JSON.stringify(arrMember)}],
                dataType: 'json',
                colModel: [
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
                ],
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
                searchitems: [
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
                ],
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
                url: siteUrl + 'membership/kader/get_data_member',
                params: [{name: "except_kader", value: kaderMemberId}, {name: "except_member", value: JSON.stringify(arrMember)}],
            }).flexClearReload();
        }
        $('.trSelected').focus();
    }
    
    function loadFlexigrid(){
        $('.breadcrumb .breadcrumb-add').remove();
        $('.breadcrumb li:last-child').html('Kader').addClass('active');
        $('#menu-title').text(menuName);
        $('#container-grid').show();
        $('#container-grid-detail').hide();
        if(typeof grid == 'undefined'){
            grid = $("#gridview").flexigrid({
                url: siteUrl + 'membership/kader/get_data',
                dataType: 'json',
                colModel: [
                    {display: 'Detail', name: 'detail', width: 40, sortable: false, datasource: false, align: 'center'},
                    {display: 'No. Anggota', name: 'member_code', width: 110, sortable: true, align: 'center'},
                    {display: 'No. Bakal Anggota', name: 'member_temp_code', width: 110, sortable: true, align: 'center'},
                    {display: 'Nama', name: 'member_name', width: 200, sortable: true, align: 'left'},
                    {display: 'Area Kader', name: 'member_pic_area', width: 200, sortable: true, align: 'left'},
                    {display: 'Status Keanggotaan', name: 'member_status', width: 180, sortable: true, align: 'center'},
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
                    {display: 'Status Tempat Tinggal', name: 'member_residence_status', width: 150, sortable: true, align: 'left', hide: true},
                    {display: 'Kewarganegaraan', name: 'member_nationality', width: 110, sortable: true, align: 'center', hide: true},
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
                ],
                buttons: [
                    <?php
                    if (privilege_view('add', $this->menu_privilege)):
                    echo "{display: 'Tambah Kader', name: 'add', bclass: 'add', onpress: openModalAddKader},";
                    endif;
                    if (privilege_view('update', $this->menu_privilege)):
                    echo "
                        {separator: true},
                        {display: 'Data Anggota', name: 'update', bclass: 'notes', onpress: openModalDataAnggota},";
                    endif;
                    if (privilege_view('delete', $this->menu_privilege)):
                    echo "
                        {separator: true},
                        {display: 'Hapus Kader', name: 'delete', bclass: 'delete', onpress: deleteData},";
                    endif;
                    ?>
                ],
                buttons_right: [
                    <?php
                    if (privilege_view('export', $this->menu_privilege)):
                    echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("membership/kader/export_data") . "'}";
                    endif;
                    ?>
                ],
                searchitems: [
                    {display: 'Unit', name: 'branch_name', type: 'text'},
                    {display: 'No. Bakal Anggota', name: 'member_temp_code', type: 'text'},
                    {display: 'No. Anggota', name: 'member_code', type: 'text'},
                    {display: 'Nama', name: 'member_name', type: 'text'},
                    {display: 'Area Kader', name: 'member_pic_area', type: 'text'},
                    {display: 'Status Keanggotaan', name: 'member_status', type: 'select', option: '0:Anggota Koperasi|1:ALB Anak|2:ALB WNA|3:ALB Luar Negeri|4:ALB Khusus|5:Calon Anggota'},
                    {display: 'No. Rekening', name: 'member_account_number', type: 'text'},
                    {display: 'No. Identitas', name: 'member_identity_number', type: 'text'},
                    {display: 'Tipe Identitas', name: 'member_identity_type', type: 'select', option: '0:NIK|1:PASSPORT'},
                    {display: 'Jenis Kelamin', name: 'member_gender', type: 'select', option: '0:Laki-laki|1:Perempuan'},
                    {display: 'Tanggal Lahir', name: 'member_birthdate', type: 'text'},
                    {display: 'Tempat Lahir', name: 'member_birthplace', type: 'text'},
                    {display: 'Alamat', name: 'member_address', type: 'text'},
                    {display: 'Provinsi', name: 'member_province', type: 'text'},
                    {display: 'Kota', name: 'member_city', type: 'text'},
                    {display: 'Kecamatan', name: 'member_subdistrict', type: 'text'},
                    {display: 'Kelurahan', name: 'member_kelurahan', type: 'text'},
                    {display: 'RT', name: 'member_rt_number', type: 'text'},
                    {display: 'RW', name: 'member_rw_number', type: 'text'},
                    {display: 'Kode Pos', name: 'member_zipcode', type: 'text'},
                    {display: 'Domisili', name: 'member_address_domicile', type: 'text'},
                    {display: 'Provinsi Domisili', name: 'member_domicile_province', type: 'text'},
                    {display: 'Kota Domisili', name: 'member_domicile_city', type: 'text'},
                    {display: 'Kecamatan Domisili', name: 'member_domicile_subdistrict', type: 'text'},
                    {display: 'Kelurahan Domisili', name: 'member_domicile_kelurahan', type: 'text'},
                    {display: 'RT Domisili', name: 'member_domicile_rt_number', type: 'text'},
                    {display: 'RW Domisili', name: 'member_domicile_rw_number', type: 'text'},
                    {display: 'Kode Pos Domisili', name: 'member_domicile_zipcode', type: 'text'},
                    {display: 'Status Tempat Tinggal', name: 'member_residence_status', type: 'select', option: '0:Tidak Diisi|1:Milik Sendiri|2:Sewa/Kontrak|3:Menumpang|4:Ikut Orang Tua'},
                    {display: 'Telepon', name: 'member_phone_number', type: 'text'},
                    {display: 'No. Handphone', name: 'member_mobilephone_number', type: 'text'},
                    {display: 'Pekerjaan', name: 'member_job', type: 'text'},
                    {display: 'Bekerja di', name: 'member_working_in', type: 'select', option: '0:Indonesia|1:Luar Negeri'},
                    {display: 'Rata-rata Penghasilan', name: 'member_average_income', type: 'select', option: '0:< 1jt|1:1jt - 3jt|2:3jt - 5jt|3:5jt - 10jt|4:>10jt'},
                    {display: 'Pendidikan Terakhir', name: 'member_last_education', type: 'select', option: '0:Tidak Sekolah|1:SD|2:SLTP|3:SMU/SMK|4:Diploma 1,2,3|5:S1|6:S2|7:S3'},
                    {display: 'Agama', name: 'member_religion', type: 'select', option: '0:Tidak Diisi|1:Islam|2:Kristen|3:Katolik|4:Hindu|5:Budha|6:Kong Hu Cu|7:Aliran Kepercayaan|8:Lainnya'},
                    {display: 'Suku', name: 'member_ethnic_group', type: 'text'},
                    {display: 'Gol. Darah', name: 'member_blood_type', type: 'select', option: '0:Tidak Diisi|1:A|2:B|3:AB|4:O'},
                    {display: 'Ukuran Baju', name: 'member_shirt_size', type: 'select', option: '0:Tidak Diisi|1:S|2:M|3:L|4:XL|5:XXL|6:XXXL'},
                    {display: 'Status Pernikahan', name: 'member_is_married', type: 'select', option: '0:Belum Menikah|1:Sudah Menikah|2:Janda Mati|3:Janda Cerai|4:Duda Mati|5:Duda Cerai'},
                    {display: 'Nama Suami/Istri', name: 'member_husband_wife_name', type: 'text'},
                    {display: 'Nama Anak', name: 'member_child_name', type: 'text'},
                    {display: 'Nama Ibu Kandung', name: 'member_mother_name', type: 'text'},
                    {display: 'Pernah Terdaftar di CU Lain', name: 'member_is_registered_others_cu', type: 'text'},
                    {display: 'Nama CU Lain', name: 'member_others_cu_name', type: 'text'},
                    {display: 'Nama Ahli Waris', name: 'member_heir_name', type: 'text'},
                    {display: 'Status Ahli Waris', name: 'member_heir_status', type: 'text'},
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
            $("#gridview").flexOptions({
                url: siteUrl + 'membership/kader/get_data',
            }).flexClearReload();
        }
    }
    
    function loadFlexigridDetail(kaderId, kaderName){
        $('.breadcrumb .active').html(`<a href="javascript:;" onclick="loadFlexigrid()">Kader</a>`);
        $('.breadcrumb .active').removeClass('active');
        $('.breadcrumb').append(`<li class="active breadcrumb-add">Anggota dari Kader ${kaderName}</li>`);
        $('#menu-title').text(`Anggota dari Kader ${kaderName}`);
        $('#container-grid-detail').show();
        $('#container-grid').hide();
        
        kaderIdExport = kaderId;
        kaderNameExport = kaderName;
        
        if(typeof gridDetail == 'undefined'){
            gridDetail = $("#gridview-detail").flexigrid({
                url: siteUrl + 'membership/kader/get_data_detail',
                params: [{name: "member_kader_id", value: kaderId}],
                dataType: 'json',
                colModel: [
                    {display: 'No. Anggota', name: 'member_code', width: 110, sortable: true, align: 'center'},
                    {display: 'No. Bakal Anggota', name: 'member_temp_code', width: 110, sortable: true, align: 'center'},
                    {display: 'Nama', name: 'member_name', width: 200, sortable: true, align: 'left'},
                    {display: 'Status Keanggotaan', name: 'member_status', width: 180, sortable: true, align: 'center'},
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
                    {display: 'Status Tempat Tinggal', name: 'member_residence_status', width: 150, sortable: true, align: 'left', hide: true},
                    {display: 'Kewarganegaraan', name: 'member_nationality', width: 110, sortable: true, align: 'center', hide: true},
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
                ],
                buttons_right: [
                    <?php
                    if (privilege_view('export', $this->menu_privilege)):
                    echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: myExportData, urlaction: '" . site_url("membership/kader/export_data_detail") . "'}";
                    endif;
                    ?>
                ],
                searchitems: [
                    {display: 'Unit', name: 'branch_name', type: 'text'},
                    {display: 'No. Bakal Anggota', name: 'member_temp_code', type: 'text'},
                    {display: 'No. Anggota', name: 'member_code', type: 'text'},
                    {display: 'Nama', name: 'member_name', type: 'text'},
                    {display: 'Status Keanggotaan', name: 'member_status', type: 'select', option: '0:Anggota Koperasi|1:ALB Anak|2:ALB WNA|3:ALB Luar Negeri|4:ALB Khusus|5:Calon Anggota'},
                    {display: 'No. Rekening', name: 'member_account_number', type: 'text'},
                    {display: 'No. Identitas', name: 'member_identity_number', type: 'text'},
                    {display: 'Tipe Identitas', name: 'member_identity_type', type: 'select', option: '0:NIK|1:PASSPORT'},
                    {display: 'Jenis Kelamin', name: 'member_gender', type: 'select', option: '0:Laki-laki|1:Perempuan'},
                    {display: 'Tanggal Lahir', name: 'member_birthdate', type: 'text'},
                    {display: 'Tempat Lahir', name: 'member_birthplace', type: 'text'},
                    {display: 'Alamat', name: 'member_address', type: 'text'},
                    {display: 'Provinsi', name: 'member_province', type: 'text'},
                    {display: 'Kota', name: 'member_city', type: 'text'},
                    {display: 'Kecamatan', name: 'member_subdistrict', type: 'text'},
                    {display: 'Kelurahan', name: 'member_kelurahan', type: 'text'},
                    {display: 'RT', name: 'member_rt_number', type: 'text'},
                    {display: 'RW', name: 'member_rw_number', type: 'text'},
                    {display: 'Kode Pos', name: 'member_zipcode', type: 'text'},
                    {display: 'Domisili', name: 'member_address_domicile', type: 'text'},
                    {display: 'Provinsi Domisili', name: 'member_domicile_province', type: 'text'},
                    {display: 'Kota Domisili', name: 'member_domicile_city', type: 'text'},
                    {display: 'Kecamatan Domisili', name: 'member_domicile_subdistrict', type: 'text'},
                    {display: 'Kelurahan Domisili', name: 'member_domicile_kelurahan', type: 'text'},
                    {display: 'RT Domisili', name: 'member_domicile_rt_number', type: 'text'},
                    {display: 'RW Domisili', name: 'member_domicile_rw_number', type: 'text'},
                    {display: 'Kode Pos Domisili', name: 'member_domicile_zipcode', type: 'text'},
                    {display: 'Status Tempat Tinggal', name: 'member_residence_status', type: 'select', option: '0:Tidak Diisi|1:Milik Sendiri|2:Sewa/Kontrak|3:Menumpang|4:Ikut Orang Tua'},
                    {display: 'Telepon', name: 'member_phone_number', type: 'text'},
                    {display: 'No. Handphone', name: 'member_mobilephone_number', type: 'text'},
                    {display: 'Pekerjaan', name: 'member_job', type: 'text'},
                    {display: 'Bekerja di', name: 'member_working_in', type: 'select', option: '0:Indonesia|1:Luar Negeri'},
                    {display: 'Rata-rata Penghasilan', name: 'member_average_income', type: 'select', option: '0:< 1jt|1:1jt - 3jt|2:3jt - 5jt|3:5jt - 10jt|4:>10jt'},
                    {display: 'Pendidikan Terakhir', name: 'member_last_education', type: 'select', option: '0:Tidak Sekolah|1:SD|2:SLTP|3:SMU/SMK|4:Diploma 1,2,3|5:S1|6:S2|7:S3'},
                    {display: 'Agama', name: 'member_religion', type: 'select', option: '0:Tidak Diisi|1:Islam|2:Kristen|3:Katolik|4:Hindu|5:Budha|6:Kong Hu Cu|7:Aliran Kepercayaan|8:Lainnya'},
                    {display: 'Suku', name: 'member_ethnic_group', type: 'text'},
                    {display: 'Gol. Darah', name: 'member_blood_type', type: 'select', option: '0:Tidak Diisi|1:A|2:B|3:AB|4:O'},
                    {display: 'Ukuran Baju', name: 'member_shirt_size', type: 'select', option: '0:Tidak Diisi|1:S|2:M|3:L|4:XL|5:XXL|6:XXXL'},
                    {display: 'Status Pernikahan', name: 'member_is_married', type: 'select', option: '0:Belum Menikah|1:Sudah Menikah|2:Janda Mati|3:Janda Cerai|4:Duda Mati|5:Duda Cerai'},
                    {display: 'Nama Suami/Istri', name: 'member_husband_wife_name', type: 'text'},
                    {display: 'Nama Anak', name: 'member_child_name', type: 'text'},
                    {display: 'Nama Ibu Kandung', name: 'member_mother_name', type: 'text'},
                    {display: 'Pernah Terdaftar di CU Lain', name: 'member_is_registered_others_cu', type: 'text'},
                    {display: 'Nama CU Lain', name: 'member_others_cu_name', type: 'text'},
                    {display: 'Nama Ahli Waris', name: 'member_heir_name', type: 'text'},
                    {display: 'Status Ahli Waris', name: 'member_heir_status', type: 'text'},
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
            $("#gridview-detail").flexOptions({
                url: siteUrl + 'membership/kader/get_data_detail',
                params: [{name: "member_kader_id", value: kaderId}],
            }).flexClearReload();
        }
    }
    
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
    
    $.validate({
        lang: 'id'
    });
</script>
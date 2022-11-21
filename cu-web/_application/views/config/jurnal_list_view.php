<style>
    table.fancytree-ext-table tbody tr:hover {
        background-color: rgba(255, 221, 85, 0.51);
        outline: 1px solid rgba(255, 221, 85, 0.51);
    }
    table.fancytree-ext-table tbody tr.fancytree-active:hover,
    table.fancytree-ext-table tbody tr.fancytree-selected:hover {
        background-color: rgba(255, 221, 85, 0.51);
        outline: 1px solid rgba(255, 221, 85, 0.51);
    }
    .fancytree-plain.fancytree-container.fancytree-treefocus span.fancytree-selected span.fancytree-title {
        background-color: rgba(255, 221, 85, 0.51);
        border-color: rgba(255, 221, 85, 0.51);
    }
    table.fancytree-ext-table.fancytree-treefocus tbody tr.fancytree-active {
        background-color: rgba(255, 221, 85, 0.51);
        outline: 1px solid rgba(255, 221, 85, 0.51);
    }
    table.fancytree-ext-table.fancytree-treefocus tbody tr.fancytree-selected {
        background-color: rgba(255, 221, 85, 0.51);
    }
    table.fancytree-ext-table tbody tr.fancytree-selected {
        background-color: rgba(255, 221, 85, 0.51);
    }
    table.fancytree-ext-table tbody tr.fancytree-focused span.fancytree-title{
        outline: none;
    }
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
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div id="response_message" style="display:none;"></div>
        <table id="gridview" style="display:none;"></table>
    </div>
</div>

<!-- Modal -->
<div id="modal" class="modal fade" role="dialog">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <form class="form-horizontal form-label-left" data-url="">
                <div class="modal-body">
                    <div id="modal-response-message" class="alert alert-danger alert-dismissible fade in" role="alert" style="display:none"></div>
                    <div class="row">
                        <input type="hidden" name="id" id="jurnal-id" value="">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                            <div class="row">
                                <div class="form-group col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                    <label class="control-label" for="jurnal-title">Nama Jurnal <span class="required">*</span></label>
                                    <input tabindex="1" type="text" name="title" id="jurnal-title" class="form-control" data-validation="required">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="jurnal_master_id" id="jurnal-master-id" value="">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                            <table style="width: 100%;" class="table-like-flexigrid">
                                <thead>
                                    <tr class="first hide-on-detail">
                                        <th colspan="4">
                                            <div class="btn-action-right">
                                                <div class="fbutton" onclick="openModalChooseJurnal()"><span class="list">Pilih Dari Template</span></div>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th style="width: 40%;">Rekening</th>
                                        <th style="width: 15%; text-align: right;">Debet (Rp)</th>
                                        <th style="width: 15%; text-align: right;">Kredit (Rp)</th>
                                        <th style="width: 30%;">Keterangan</th>
                                    </tr>
                                </thead>
                            </table>
                            <div id="table-body">
                                <table id="grid-jurnal-detail" class="table-like-flexigrid" style="width: 100%;">
                                    <tbody></tbody>
                                </table>
                            </div>
                            <table class="table-like-flexigrid" style="width: 100%;">
                                <tfoot>
                                    <tr>
                                        <th style="width: 40%; text-align: right; font-weight: bold;"> TOTAL</th>
                                        <th style="width: 15%; text-align: right; font-weight: bold;" id="total-debet">0</th>
                                        <th style="width: 15%; text-align: right; font-weight: bold;" id="total-kredit">0</th>
                                        <th style="width: 30%;"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button tabindex="2" type="submit" class="btn btn-primary hide-on-detail"><i class="fa fa-save"></i>&nbsp; Simpan <?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end modal-->


<!-- Modal Master-->
<div id="modal-master" class="modal" role="dialog">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="closeModalMaster()">&times;</button>
                <h4 class="modal-title">Form Pilih Template Jurnal</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12" style="padding-right: 5px;">
                        <table id="gridview-master" style="display:none;"></table>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12" style="padding-left: 5px;">
                        <table id="gridview-detail" style="display:none;"></table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closeModalMaster()">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!--end Modal Master-->

<!--FORM VALIDATOR-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    let gridMaster;
    let gridDetail;
    let arrCoa = [];
    
    function openModalAdd(){
        $("#modal-response-message").finish();
        $('.hide-on-detail').show();
        $('#jurnal-title').prop('disabled', false);
        $('#modal form').trigger('reset');
        $('#jurnal-master-id').val('');
        $('form').attr('data-url', siteUrl + 'config/jurnal/act_add');
        $("#modal .modal-title").text('Form Tambah ' + menuName);
        arrCoa = [];
        insertToList();
        $('#modal').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
    }
    
    function openModalEdit(id){
        $("#modal-response-message").finish();
        $('.hide-on-detail').show();
        $("#modal .modal-title").text('Form Ubah ' + menuName);
        $('form').attr('data-url', siteUrl + 'config/jurnal/act_update');
        ajaxRequest('common/general/config/jurnal/get_detail', 'GET', {id : id}, function(res){
            if(res.status == 200){
                $('#jurnal-id').val(res.data.jurnal_config_id);
                $('#jurnal-title').val(res.data.jurnal_config_title).prop('disabled', false);;
                $('#jurnal-master-id').val(res.data.jurnal_config_jurnal_master_id);
                ajaxRequest('config/jurnal/get_jurnal_master_detail', 'GET', {jurnal_master_id: res.data.jurnal_config_jurnal_master_id}, function (res2){
                    if(res2.status == 200){
                        let jurnalMasterDetail = res2.data.results;
                        arrCoa = jurnalMasterDetail;
                        insertToList();
                        $('#modal').modal({
                            backdrop: 'static',
                            keyboard: false
                        }, 'show');
                    }else{
                        alert(res2.msg);
                    }
                });
            }else{
                alert(res.msg);
            }
        });
    }
    
    function openModalDetail(id){
        arrCoa = [];
        $("#modal-response-message").finish();
        $('.hide-on-detail').hide();
        $("#modal .modal-title").text('Form Detail ' + menuName);
        $('form').attr('data-url', '');
        ajaxRequest('common/general/config/jurnal/get_detail', 'GET', {id : id}, function(res){
            if(res.status == 200){
                $('#jurnal-title').val(res.data.jurnal_config_title).prop('disabled', true);
                ajaxRequest('config/jurnal/get_jurnal_master_detail', 'GET', {jurnal_master_id: res.data.jurnal_config_jurnal_master_id}, function (res2){
                    if(res2.status == 200){
                        let jurnalMasterDetail = res2.data.results;
                        arrCoa = jurnalMasterDetail;
                        insertToList();
                        $('#modal').modal({
                            backdrop: 'static',
                            keyboard: false
                        }, 'show');
                    }else{
                        alert(res2.msg);
                    }
                });
            }else{
                alert(res.msg);
            }
        });
    }
    
    function addToConfig(com, grid, urlaction){
        let grid_id = $(grid).attr('id');
        grid_id = grid_id.substring(grid_id.lastIndexOf('grid_') + 5);
        if ($('.trSelected', grid).length > 0) {
            let id = $('.trSelected', grid).attr('data-id');
            ajaxRequest('config/jurnal/get_jurnal_master_detail', 'GET', {jurnal_master_id: id}, function(res) {
                if(res.status == 200){
                    $('#jurnal-master-id').val(id);
                    let jurnalMasterDetail = res.data.results;
                    arrCoa = jurnalMasterDetail;
                    insertToList();
                    closeModalMaster();
                }else{
                    alert(res.msg);
                }
            });
        }else{
            alert('Pilih data terlebih duahulu.');
        }
    }
    
    function insertToList(){
        let html = '';
        if(arrCoa.length > 0){
            arrCoa.forEach(function (item, index){
                html += `<tr>
                            <td style="width: 40%;">${item.coa_master_number} - ${item.coa_master_title}</td>
                            <td style="width: 15%; text-align: right;">${number_format(item.jurnal_master_detail_debet)}</td>
                            <td style="width: 15%; text-align: right;">${number_format(item.jurnal_master_detail_kredit)}</td>
                            <td style="width: 30%;">${item.jurnal_master_detail_note}</td>
                        </tr>`;
            });
        }else{
            html += `<tr>
                        <td colspan="4">Belum ada data. Silahkan klik tombol <strong>Pilih Dari Daftar Jurnal</strong> terlebih dahulu.</td>
                    </tr>`;
        }
        $('#table-body tbody').html(html);
        countTotal();
    }
    
    function countTotal(){
        let totalKredit = 0;
        let totalDebet = 0;
        if(arrCoa.length > 0){
            arrCoa.forEach(function (item, index){
                totalKredit = totalKredit + arrCoa[index].jurnal_master_detail_kredit;
                totalDebet = totalDebet + arrCoa[index].jurnal_master_detail_debet;
            });
        }
        $('#total-kredit').text(number_format(totalKredit));
        $('#total-debet').text(number_format(totalDebet));
    }
    
    function openModalChooseJurnal(){
        loadMaster();
        loadDetail(0);
        $('#modal').modal('hide');
        $('#modal-master').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
    }
    
    function closeModalMaster(){
        $('#modal-master').modal('hide');
        $('#modal').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
    }
    
    function loadMaster(){
        if(typeof gridMaster == 'undefined'){
            gridMaster = $("#gridview-master").flexigrid({
                url: siteUrl + 'config/jurnal/get_data_jurnal_master',
                dataType: 'json',
                colModel: [
                    {display: 'Nama Jurnal', name: 'jurnal_master_title', width: 230, sortable: true, align: 'left'},
                    {display: 'Tipe Jurnal Master', name: 'jurnal_master_type', width: 200, sortable: true, align: 'left'},
                ],
                buttons: [
                    <?php if(privilege_view('add', $this->menu_privilege)):
                        echo "{display: 'Tambahkan ke Konfig Jurnal', name: 'add', bclass: 'add', onpress: addToConfig},";
                    endif; ?>
                ],
                searchitems: [
                    {display: 'Jurnal Master', name: 'jurnal_config_jurnal_master_id', type: 'text'},
                    {display: 'Nama Variabel Konfig', name: 'jurnal_config_name', type: 'text'},
                    {display: 'Nama Konfig Jurnal', name: 'jurnal_config_title', type: 'text'},
                ],
                sortname: "jurnal_master_id",
                sortorder: "desc",
                usepager: true,
                title: 'Data Jurnal Master',
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
            $("#gridview-master").flexOptions({
                url: siteUrl + 'config/jurnal/get_data_jurnal_master',
            }).flexClearReload();
        }
    }
    
    function loadDetail(jurnalMasterId = 0){
        if(typeof gridDetail == 'undefined'){
            gridDetail = $("#gridview-detail").flexigrid({
                url: siteUrl + 'config/jurnal/get_data_jurnal_master_detail',
                params: [{"name": "jurnal_master_id", "value": jurnalMasterId}],
                dataType: 'json',
                colModel: [
                    {display: 'No Rekening', name: 'coa_master_number', width: 80, sortable: true, align: 'left'},
                    {display: 'Nama Akun', name: 'coa_master_title', width: 180, sortable: true, align: 'left'},
                    {display: 'Debet', name: 'jurnal_master_detail_debet', width: 120, sortable: true, align: 'right'},
                    {display: 'Kredit', name: 'jurnal_master_detail_kredit', width: 120, sortable: true, align: 'right'},
                    {display: 'Keterangan', name: 'jurnal_master_detail_note', width: 200, sortable: true, align: 'left'},
                ],
                searchitems: [
                    {display: 'Nama Akun', name: 'coa_master_title', type: 'text'},
                    {display: 'Debet', name: 'jurnal_master_detail_debet', type: 'num'},
                    {display: 'Kredit', name: 'jurnal_master_detail_kredit', type: 'num'},
                    {display: 'Keterangan', name: 'jurnal_master_detail_note', type: 'text'},
                ],
                sortname: "jurnal_master_detail_id",
                sortorder: "asc",
                usepager: true,
                title: 'Detail Jurnal Master',
                useRp: true,
                rp: 10,
                showTableToggleBtn: false,
                showToggleBtn: true,
                width: 'auto',
                height: '330',
                resizable: false,
                singleSelect: false
            });
        }else{
            $("#gridview-detail").flexOptions({
                url: siteUrl + 'config/jurnal/get_data_jurnal_master_detail',
                params: [{"name": "jurnal_master_id", "value": jurnalMasterId}],
            }).flexClearReload();
        }
    }
    
    $(document).ready(function (){
       $('#gridview-master').on('click', function (e){
           let jurnalMasterId = $(e.target).closest( "tr.trSelected" ).data('id');
           if(jurnalMasterId == 'undefined'){
               jurnalMasterId = 0;
           }
           loadDetail(jurnalMasterId);
       });
       
       $('form').on('submit', function (e) {
            e.preventDefault();
            $('form button[type="submit"]').attr('disabled', 'disabled');

            var urlForm = $(this).attr('data-url');
            var dataForm = new FormData(this);

            $.ajax({
                type: 'POST',
                url: urlForm,
                data: dataForm,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    if (res.status == 200) {
                        $('form button[type="submit"]').removeAttr('disabled');
                        $('#modal').modal('hide');
                        $("#gridview").flexReload();
                        let message_class = 'response_confirmation alert alert-success';

                        $("#response_message").finish();

                        $("#response_message").addClass(message_class);
                        $("#response_message").slideDown("fast");
                        $("#response_message").html(res.data);
                        $("#response_message").delay(10000).slideUp(1000, function () {
                            $("#response_message").removeClass(message_class);
                        });

                    } else {
                        $('form button[type="submit"]').removeAttr('disabled');
                        $("#modal-response-message").finish();

                        $("#modal-response-message").slideDown("fast");
                        $('#modal-response-message').html(res.msg);
                        $("#modal-response-message").delay(10000).slideUp(1000);
                    }
                },
                error: function (err) {
                    $('#form-add button[type="submit"]').removeAttr('disabled');
                }
            });
        });
    });
    
    $("#gridview").flexigrid({
        url: siteUrl + 'config/jurnal/get_data',
        dataType: 'json',
        colModel: [
            <?php if(privilege_view('update', $this->menu_privilege)):
                echo "{display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false},";
            endif; ?>
            {display: 'Detail', name: 'detail', width: 40, sortable: false, align: 'center', datasource: false},
            {display: 'Nama Jurnal', name: 'jurnal_master_title', width: 200, sortable: true, align: 'left'},
            {display: 'Nama Variabel Konfig', name: 'jurnal_config_name', width: 200, sortable: true, align: 'left'},
            {display: 'Nama Konfig Jurnal', name: 'jurnal_config_title', width: 200, sortable: true, align: 'left'},
        ],
        buttons: [
            <?php if(privilege_view('add', $this->menu_privilege)):
                echo "{display: 'Tambah Konfig Jurnal', name: 'add', bclass: 'add', onpress: openModalAdd},";
            endif;
            if(privilege_view('delete', $this->menu_privilege)):
                echo "
                    {separator: true},
                    {display: 'Pilih Semua', name: 'selectall', bclass: 'selectall', onpress: check},
                    {separator: true},
                    {display: 'Hapus Pilihan', name: 'selectnone', bclass: 'selectnone', onpress: check},
                    {separator: true},
                    {display: 'Hapus Konfig Jurnal', name: 'delete', bclass: 'delete', onpress: act_show, urlaction: '" . site_url("config/jurnal/act_delete") . "'},
                    ";
            endif; ?>
        ],
        buttons_right: [
            <?php if(privilege_view('export', $this->menu_privilege)):
                echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("config/jurnal/export_data_jurnal") . "'}";
            endif; ?>
        ],
        searchitems: [
            {display: 'Nama Jurnal', name: 'jurnal_master_title', type: 'text'},
            {display: 'Nama Variabel Konfig', name: 'jurnal_config_name', type: 'text'},
            {display: 'Nama Konfig Jurnal', name: 'jurnal_config_title', type: 'text'},
        ],
        sortname: "jurnal_config_id",
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
    
    // for set number format
    function number_format(number, decimals = 0, decPoint = ',', thousandsSep = '.') {
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
    
    $.validate({
        modules: 'logic',
        lang: 'id'
    });
</script>
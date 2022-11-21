<link href="<?php echo THEMES_BACKEND; ?>/js/fancytree/skin-win8/ui.fancytree.css" rel="stylesheet" type="text/css">
<style>
    table.fancytree-ext-table tbody tr:hover {
/*        background-color: rgba(255, 221, 85, 0.51);
        outline: 1px solid rgba(255, 221, 85, 0.51);*/
        background-color: #d5effc;
        outline: 1px solid #d5effc;
    }
    table.fancytree-ext-table tbody tr.fancytree-active:hover,
    table.fancytree-ext-table tbody tr.fancytree-selected:hover {
/*        background-color: rgba(255, 221, 85, 0.51);
        outline: 1px solid rgba(255, 221, 85, 0.51);*/
        background-color: #d5effc;
        outline: 1px solid #d5effc;
    }
    .fancytree-plain.fancytree-container.fancytree-treefocus span.fancytree-selected span.fancytree-title {
/*        background-color: rgba(255, 221, 85, 0.51);
        border-color: rgba(255, 221, 85, 0.51);*/
        background: #d5effc url(<?php echo site_url('addons/flexigrid/css');?>/images/hl.png) repeat-x top;
        border-color: #d5effc;
    }
    table.fancytree-ext-table.fancytree-treefocus tbody tr.fancytree-active {
/*        background-color: rgba(255, 221, 85, 0.51);
        outline: 1px solid rgba(255, 221, 85, 0.51);*/
        background: #d5effc url(<?php echo site_url('addons/flexigrid/css');?>/images/hl.png) repeat-x top;
        border-color: #d5effc;
    }
    table.fancytree-ext-table.fancytree-treefocus tbody tr.fancytree-selected {
        /*background-color: rgba(255, 221, 85, 0.51);*/
        background: #d5effc url(<?php echo site_url('addons/flexigrid/css');?>/images/hl.png) repeat-x top;
    }
    table.fancytree-ext-table tbody tr.fancytree-selected {
        /*background-color: rgba(255, 221, 85, 0.51);*/
        background: #d5effc url(<?php echo site_url('addons/flexigrid/css');?>/images/hl.png) repeat-x top;
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
    .table-like-flexigrid .fbutton .accept{
        background: url(<?php echo site_url('addons/flexigrid/button/images/accept.png'); ?>) no-repeat scroll left center transparent;
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
    .table-like-flexigrid .fbutton .excel{
        background: url(<?php echo site_url('addons/flexigrid/button/images/page_excel.png'); ?>) no-repeat scroll left center transparent;
    }
    .table-like-flexigrid .flabel.icon .date{
        background: url(<?php echo site_url('addons/flexigrid/button/images/calendar.png'); ?>) no-repeat scroll right center transparent;
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
    .table-like-flexigrid .flabel.icon > span{
        padding: 3px;
        padding-right: 20px;
    }
    .table-like-flexigrid .flabel.icon.have-input > span{
        padding: 3px;
    }

    .table-like-flexigrid .flabel.icon.have-input input,
    .table-like-flexigrid .flabel.icon.have-select select{
        margin-right: 20px;
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
    .alignRight{
        text-align: right;
    }
    .alignLeft{
        text-align: left;
    }
    .alignCenter{
        text-align: center;
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
        <table style="width: 100%;" class="table-like-flexigrid">
            <thead>
                <tr class="first title" style="border: 1px solid #ccc;">
                    <th>
                        <div class="btn-action-left">
                            <div class="flabel"><span><strong>Pilih Periode:</strong></span></div>
                            <div class="flabel icon have-select">
                                <span class="date">
                                    <select id="input-month" style="width: 120px; height: 17.2px;">
                                        <?php
                                            $date_begining = DATE_BEGIN_APPLICATION;
                                            $month_begining = date('m', strtotime($date_begining));
                                            $year_begining = date('Y', strtotime($date_begining));
                                            
                                            $month_end = date('m');
                                            $year_end = date('Y');
                                            
                                            for($year = $year_begining; $year <= $year_end; $year++):
                                                for($month = $month_begining; $month <= 12 ; $month++):
                                                    $str_selected = '';
                                                    if($month == $month_end && $year == $year_end){
                                                        $str_selected = 'selected="selected"';
                                                    }
                                                    echo '<option value="' . $year . '-' . $month . '-01' . '" ' . $str_selected . '>' . convert_month($month, 'id') . ' ' . $year . '</option>';
                                                    
                                                    if($year != $year_end && $month == 12){
                                                        $month_begining = '01';
                                                    }
                                                    if($year == $year_end && $month == $month_end){
                                                        break;
                                                    }
                                                endfor;
                                            endfor;
                                        ?>
                                    </select>
                                </span>
                            </div>
                            <div class="fbuttonseparator"></div>
                            <div class="flabel"><span><strong>Selisih:</strong></span></div>
                            <div class="flabel">
                                <span><input id="saldo-diff" type="text" class="text-right" style="font-weight: bold; color: #ff3366; width: 200px; height: 17.2px;" readonly="readonly" value="0"></span>
                            </div>
                        </div>
                        <div class="btn-action-right">
                            <div class="fbutton" onclick="exportExcel()"><span class="excel">Export Excel</span></div>
                        </div>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <table style="width: 100%;" class="table-like-flexigrid">
            <thead>
                <tr class="first title" style="border: 1px solid #ccc;">
                    <th>
                        <div style="font-weight: bold; text-align: center;">LAPORAN NERACA PERIODE <span id="text-period"></span></div>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12" style="padding-right: 2px;">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <table style="width: 100%;" class="table-like-flexigrid">
                            <thead>
                                <tr class="first title" style="border: 1px solid #ccc;">
                                    <th>
                                        <div style="font-weight: bold; text-align: center;">AKTIVA</div>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <table id="treegrid-aktiva" class="table-like-flexigrid" style="width: 100%;">
                            <colgroup>
                                <col style="display: none;"></col>
                                <col width="25%"></col>
                                <col width="50%"></col>
                                <col width="25%"></col>
                            </colgroup>
                            <thead>
                                <tr class="first title" style="border: 1px solid #ccc;">
                                    <th colspan="4">
                                        <div class="btn-action-right">
                                            <div class="flabel"><span><strong>Saldo:</strong></span></div>
                                            <div class="flabel">
                                                <span><input id="saldo-aktiva" type="text" class="text-right" style="font-weight: bold; width: 180px; height: 17.2px;" readonly="readonly" value="0"></span>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th style="display: none;"></th>
                                    <th style="text-align: center;">No. Rekening</th>
                                    <th>Nama Akun</th>
                                    <th style="text-align: right">Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="display: none;"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-sm-12 col-xs-12" style="padding-left: 2px;">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <table style="width: 100%;" class="table-like-flexigrid">
                            <thead>
                                <tr class="first title" style="border: 1px solid #ccc;">
                                    <th>
                                        <div style="font-weight: bold; text-align: center;">PASIVA</div>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <table id="treegrid-pasiva" class="table-like-flexigrid" style="width: 100%;">
                            <colgroup>
                                <col style="display: none;"></col>
                                <col width="25%"></col>
                                <col width="50%"></col>
                                <col width="25%"></col>
                            </colgroup>
                            <thead>
                                <tr class="first title" style="border: 1px solid #ccc;">
                                    <th colspan="4">
                                        <div class="btn-action-right">
                                            <div class="flabel"><span><strong>Saldo:</strong></span></div>
                                            <div class="flabel">
                                                <span><input id="saldo-pasiva" type="text" class="text-right" style="font-weight: bold; width: 180px; height: 17.2px;" readonly="readonly" value="0"></span>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th style="display: none;"></th>
                                    <th style="text-align: center;">No. Rekening</th>
                                    <th>Nama Akun</th>
                                    <th style="text-align: right">Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="display: none;"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TREEVIEW LIBRARY -->
<script src="<?php echo THEMES_BACKEND; ?>/js/fancytree/jquery.fancytree.min.js" type="text/javascript"></script>
<script src="<?php echo THEMES_BACKEND; ?>/js/fancytree/jquery.fancytree.table.js" type="text/javascript"></script>

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    
    let arrAktiva = [];
    let arrPasiva = [];
    let totalAktiva = 0;
    let totalPasiva = 0;
    
    function exportExcel(){
        let month = $('#input-month').val();
        
        if(month){
            let $form = $(`<form target="_blank" method="POST" action="${siteUrl}accounting/balance/export_data"></form>`);
            $form.append(`<input type="hidden" name="month" value="${month}" />`);
            $('#treegrid-pasiva').after($form);
            $form.submit();
            $form.remove();
        }
    }
    
    function loadTreegridAktiva(){
        if(typeof treegridAktiva == 'undefined'){
            treegridAktiva = $("#treegrid-aktiva").fancytree({
                extensions: ["table"],
                checkbox: false,
                aria: true,
                table: {
                    indentation: 5,
                    nodeColumnIdx: 1,
                    checkboxColumnIdx: 0
                },
                source: arrAktiva,
                renderColumns: function (e, data) {
                    let node = data.node;
                    if(node.parent.key == "root_1"){
                        $(node.tr).css({"font-size": "13px", "font-weight": "bold"});
                    }else if(node.parent.parent.key == "root_1"){
                        $(node.tr).css({"font-size": "12px", "font-weight": "bold"});
                    }else if(node.parent.parent.parent.key == "root_1"){
                        $(node.tr).css({"font-size": "12px"});
                    }else if(node.parent.parent.parent.parent.key == "root_1"){
                        $(node.tr).css({"font-size": "11px"});
                    }else if(node.parent.parent.parent.parent.parent.key == "root_1"){
                        $(node.tr).css({"font-size": "10px"});
                    }
                    if(node.data.isPositive == 0){
                        $(node.tr).css({"color": "red"});
                    }
                    $tdList = $(node.tr).find(">td");
                    $tdList.eq(1).text(node.data.title);
                    $tdList.eq(2).text(node.data.coaName).addClass("alignLeft");
                    $tdList.eq(3).text(number_format(node.data.balance)).addClass("alignRight");
                },
                init: function (event, data) {
                    if (data.tree.count() == 0) {
                        $('#treegrid-aktiva').find("tbody tr").remove();
                        $('#treegrid-aktiva').find("tbody").append(`
                                        <tr>
                                            <td colspan="4">Data belum ada.</td>
                                        <tr>
                                    `);
                    }
                }
            });
        }else{
            treegridAktiva.fancytree('option', 'source', arrAktiva);
        }
        treegridAktiva.fancytree("getTree").visit(function (node) {
            node.setExpanded();
        });
    }
    
    function loadTreegridPasiva(){
        if(typeof treegridPasiva == 'undefined'){
            treegridPasiva = $("#treegrid-pasiva").fancytree({
                extensions: ["table"],
                checkbox: false,
                aria: true,
                table: {
                    indentation: 5,
                    nodeColumnIdx: 1,
                    checkboxColumnIdx: 0
                },
                source: arrPasiva,
                renderColumns: function (e, data) {
                    let node = data.node;
                    if(node.parent.key == "root_2"){
                        $(node.tr).css({"font-size": "13px", "font-weight": "bold"});
                    }else if(node.parent.parent.key == "root_2"){
                        $(node.tr).css({"font-size": "12px", "font-weight": "bold"});
                    }else if(node.parent.parent.parent.key == "root_2"){
                        $(node.tr).css({"font-size": "12px"});
                    }else if(node.parent.parent.parent.parent.key == "root_2"){
                        $(node.tr).css({"font-size": "11px"});
                    }else if(node.parent.parent.parent.parent.parent.key == "root_2"){
                        $(node.tr).css({"font-size": "10px"});
                    }
                    if(node.data.isPositive == 0){
                        $(node.tr).css({"color": "red"});
                    }
                    $tdList = $(node.tr).find(">td");
                    $tdList.eq(1).text(node.data.title);
                    $tdList.eq(2).text(node.data.coaName).addClass("alignLeft");
                    $tdList.eq(3).text(number_format(node.data.balance)).addClass("alignRight");
                },
                init: function (event, data) {
                    if (data.tree.count() == 0) {
                        $('#treegrid-pasiva').find("tbody tr").remove();
                        $('#treegrid-pasiva').find("tbody").append(`
                                        <tr>
                                            <td colspan="4">Data belum ada.</td>
                                        <tr>
                                    `);
                    }
                }
            });
        }else{
            treegridPasiva.fancytree('option', 'source', arrPasiva);
        }
        treegridPasiva.fancytree("getTree").visit(function (node) {
            node.setExpanded();
        });
    }
    
    function loadTotalSaldoAndDiff(){
        $('#saldo-aktiva').val(number_format(totalAktiva));
        $('#saldo-pasiva').val(number_format(totalPasiva));
        
        $('#saldo-diff').val(number_format(Math.abs(totalAktiva - totalPasiva)));
    }
    
    function getData(month){
        ajaxRequest('accounting/balance/get_data', 'GET', {month: month}, function(res){
            if(res.status == 200){
                arrAktiva = res.data.aktiva;
                arrPasiva = res.data.pasiva;
                totalAktiva = res.data.total_aktiva;
                totalPasiva = res.data.total_pasiva;
                
                loadTreegridAktiva();
                loadTreegridPasiva();
                loadTotalSaldoAndDiff();
                
                $('#text-period').text(moment(month).format('MMMM YYYY').toUpperCase());
            }else{
                alert(res.msg);
            }
        });
    }
    
    $(document).ready(function () {
        
        $('#input-month').on('change', function(){
           let month = $(this).val();
           if(month){
               getData(month);
           }
        });
        
        getData('<?php echo date("Y-m") . "-01";?>');
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
</script>
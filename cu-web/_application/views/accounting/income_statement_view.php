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
    .table-like-flexigrid tbody tr.body-head td{
        background: #fafafa url(<?php echo site_url('addons/flexigrid/css/images/bg.gif'); ?>) repeat-x top;
        height: 29px; 
        border-bottom: 0px;
        padding: 0px;
        padding-left: 2px;
        padding-right: 2px;
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
                        </div>
                        <div class="btn-action-right">
                            <div class="fbutton"  onclick="exportExcel()"><span class="excel">Export Excel</span></div>
                        </div>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        <table id="tabel-laba-rugi" style="width: 100%;" class="table-like-flexigrid">
            <tbody></tbody>
        </table>
    </div>
</div>

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    
    function exportExcel(){
        let month = $('#input-month').val();
        
        if(month){
            let $form = $(`<form target="_blank" method="POST" action="${siteUrl}accounting/income_statement/export_data"></form>`);
            $form.append(`<input type="hidden" name="month" value="${month}" />`);
            $('#tabel-laba-rugi').after($form);
            $form.submit();
            $form.remove();
        }
    }
    
    function getData(month){
        ajaxRequest('accounting/income_statement/get_data', 'GET', {month: month}, function(res){
            if(res.status == 200){
                let pendapatan = res.data.results.pendapatan;
                let biaya = res.data.results.biaya;
                let totalLabaRugi = res.data.results.total_laba_rugi;
                let totalPendapatan = res.data.results.total_pendapatan;
                let totalBiaya = res.data.results.total_biaya;
                
                let html = `
                    <tr>
                        <td style="font-weight: bold; text-align: right; font-size: 14px;">TOTAL LABA RUGI</td>
                        <td colspan="2" style="font-weight: bold; text-align: right; font-size: 14px;">${number_format(totalLabaRugi)}</td>
                    </tr>
                    <tr></tr>
                    <tr class="body-head">
                        <td style="font-weight: bold; text-align: center; font-size: 12px; width: 25%;">No. Rekening</td>
                        <td style="font-weight: bold; text-align: center; font-size: 12px;">Nama Rekening</td>
                        <td style="font-weight: bold; text-align: center; font-size: 12px; width: 25%;">Jumlah</td>
                    </tr>
                `;
                
                if(pendapatan.length > 0){
                    html += `
                        <tr><td colspan="3" style="text-align: right; font-weight: bold; font-size: 12px;">Pendapatan</td></tr>
                    `;
                                
                    pendapatan.forEach(function(item, index){
                        html += `
                            <tr>
                                <td style="text-align: center;">${item.number}</td>
                                <td style="text-align: left;">${item.title}</td>
                                <td style="text-align: right;">${number_format(item.balance)}</td>
                            </tr>
                        `;
                    });
                    
                    html += `
                        <tr>
                            <td style="text-align: right; font-weight: bold; font-size: 12px;" colspan="2">Total Pendapatan</td>
                            <td style="text-align: right; font-weight: bold; font-size: 12px;">${number_format(totalPendapatan)}</td>
                        </tr>
                        <tr></tr>
                    `;    
                }
                
                if(biaya.length > 0){
                    html += `
                        <tr><td colspan="3" style="text-align: right; font-weight: bold; font-size: 12px;">Biaya</td></tr>
                    `;
                                
                    biaya.forEach(function(item, index){
                        html += `
                            <tr>
                                <td style="text-align: center;">${item.number}</td>
                                <td style="text-align: left;">${item.title}</td>
                                <td style="text-align: right;">${number_format(item.balance)}</td>
                            </tr>
                        `;
                    });
                    
                    html += `
                        <tr>
                            <td style="text-align: right; font-weight: bold; font-size: 12px;" colspan="2">Total Biaya</td>
                            <td style="text-align: right; font-weight: bold; font-size: 12px;">${number_format(totalPendapatan)}</td>
                        </tr>
                        <tr></tr>
                    `;    
                }
                
                html += `
                    <tr>
                        <td style="font-weight: bold; text-align: right; font-size: 14px;">TOTAL LABA RUGI</td>
                        <td colspan="2" style="font-weight: bold; text-align: right; font-size: 14px;">${number_format(totalLabaRugi)}</td>
                    </tr>
                `;
                            
                $('#tabel-laba-rugi tbody').html(html);
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
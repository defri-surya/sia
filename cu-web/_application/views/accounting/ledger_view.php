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
    .table-like-flexigrid .fbutton .details{
        background: url(<?php echo site_url('addons/flexigrid/button/images/detail.png'); ?>) no-repeat scroll left center transparent;
    }
    .table-like-flexigrid .fbutton .accounting{
        background: url(<?php echo site_url('addons/flexigrid/button/images/accounting.png'); ?>) no-repeat scroll left center transparent;
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

    .table-like-flexigrid .flabel.icon.have-input input{
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
    .ui-autocomplete {
         max-height: 200px;
         overflow-y: auto;
         overflow-x: hidden;
         padding-right: 20px;
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
                            <div class="flabel icon have-input">
                                <span class="date"><input id="start-date" type="text" data-inputmask="'alias':'date'" style="width: 100px; height: 17.2px;" class="my-input-mask"></span>
                            </div>
                            <div class="flabel"><span><strong>s/d</strong></span></div>
                            <div class="flabel icon have-input">
                                <span class="date"><input id="end-date" type="text" data-inputmask="'alias':'date'" style="width: 100px; height: 17.2px;" class="my-input-mask"></span>
                            </div>
                            <div class="fbuttonseparator"></div>
                            <div class="flabel"><span><strong>Pilih Buku Besar:</strong></span></div>
                            <div class="flabel">
                                <span><input id="input-autocomplete-coa" type="text" style="width: 200px; height: 17.2px;"></span>
                            </div>
                            <div class="fbutton" onclick="searchLedger()"><span class="accept"><strong>Pilih</strong></span></div>
                            <div class="fbuttonseparator"></div>
                            <div class="fbutton" onclick="openModalShowJurnal()"><span class="details"><strong>Lihat Jurnal</strong></span></div>
                        </div>
                        <div class="btn-action-right">
                            <div class="fbutton" onclick="myExportData()"><span class="excel">Export Excel</span></div>
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
                        <div class="btn-action-left">
                            <div class="flabel"><span><strong>Awal Periode:</strong></span></div>
                            <div class="flabel" style="margin-right: 20px;"><span id="start-balance">13.000.000</span></div>
                            <div class="fbuttonseparator"></div>
                            <div class="flabel"><span><strong>Debet:</strong></span></div>
                            <div class="flabel" style="margin-right: 20px;"><span id="sum-debet">13.000.000</span></div>
                            <div class="fbuttonseparator"></div>
                            <div class="flabel"><span><strong>Kredit:</strong></span></div>
                            <div class="flabel" style="margin-right: 20px;"><span id="sum-kredit">13.000.000</span></div>
                            <div class="fbuttonseparator"></div>
                            <div class="flabel"><span><strong>Akhir Periode:</strong></span></div>
                            <div class="flabel" style="margin-right: 20px;"><span id="end-balance">13.000.000</span></div>
                            <div class="fbuttonseparator"></div>
                            <div class="fbutton" onclick="alert('Dalam Pengembangan')"><span class="accept">Update Waktu</span></div>
                        </div>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <table id="gridview-ledger" style="display:none;"></table>
    </div>
</div>

<!-- MODAL JURNAL -->
<div id="modal-jurnal" class="modal fade" role="dialog">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Jurnal No. Bukti <span id="text-trans-number"></span></h4>
            </div>
            <div class="modal-body" style="overflow-y: auto; height: calc(100vh - 200px);">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div id="container-jurnal" class="row"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL JURNAL -->

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    let gridLedger;
    let coaMasterIdChoosen = 0;
    let startDateChoosen = '';
    let endDateChoosen = '';
    let arrCoaAutocompleteMaster = <?php echo json_encode($arr_data_autocomplete); ?>;
    let arrCoaAutocomplete = <?php echo json_encode($arr_data_autocomplete); ?>;
    
    function openModalShowJurnal(){
        let transNumber = $('#grid_gridview-ledger tr.trSelected').data("id");
        
        if(typeof transNumber != "undefined"){
            $('#text-trans-number').text(transNumber);
            loadDataJurnal(transNumber);
            $('#modal-jurnal').modal('show');
        }else{
            alert("Silahkan pilih transaksi terlebih dahulu.")
        }
    }
    
    function searchLedger(){
        let startDate = $('#start-date').val();
        let endDate = $('#end-date').val();
        let coaMasterId = coaMasterIdChoosen;
        
        if(coaMasterId > 0){
            startDateChoosen = startDate;
            endDateChoosen = endDate;
            loadGridLedger(coaMasterId, startDate, endDate);
        }else{
            alert("Silahkan pilih buku besar terlebih dahulu.");
        }
    }
    
    function getSummary(coaMasterId = 0, startDate = '<?php echo date("d/m/Y"); ?>', endDate = '<?php echo date("d/m/Y"); ?>'){
        $('#start-balance').text(number_format(0));
        $('#sum-debet').text(number_format(0));
        $('#sum-kredit').text(number_format(0));
        $('#end-balance').text(number_format(0));
        if(coaMasterId > 0){
            ajaxRequest('accounting/ledger/get_summary', 'POST', {coa_master_id: coaMasterId, start_date: startDate, end_date: endDate}, function(res){
                if(res.status == 200){
                    let data = res.data.results;
                    $('#start-balance').text(number_format(data.start_balance));
                    $('#sum-debet').text(number_format(data.sum_debet));
                    $('#sum-kredit').text(number_format(data.sum_kredit));
                    $('#end-balance').text(number_format(data.end_balance));
                }else{
                    alert(res.msg);
                }
            });
        }
    }
    
    function loadDataJurnal(transNumber){
        ajaxRequest('accounting/ledger/get_data_jurnal', method = 'GET', {search_value: transNumber}, function (res){
            if(res.status == 200){
                let result = res.data.results;
                let html = '';
                
                if(result.length > 0){
                    result.forEach(function(item, index){
                        let htmlBody = '';
                        if(item.data.length > 0){
                            item.data.forEach(function(itemData, indexData){
                                htmlBody += `
                                    <tr>
                                        <td style="text-align: center;">${moment(itemData.ledger_datetime).format("DD MMMM YYYY")}</td>
                                        <td style="text-align: center;">${itemData.ledger_trans_number}</td>
                                        <td style="text-align: center;">${itemData.ledger_trans_number_manually}</td>
                                        <td>${itemData.coa_master_number} - ${itemData.coa_master_title}</td>
                                        <td>${itemData.ledger_note}</td>
                                        <td style="text-align: right;">${number_format(itemData.ledger_debet)}</td>
                                        <td style="text-align: right;">${number_format(itemData.ledger_kredit)}</td>
                                    </tr>
                                `;
                            });
                        }
                        html += `
                            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px">
                                <table style="width: 100%;" class="table-like-flexigrid">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%; text-align: center;"><strong>TGL JURNAL</strong></th>
                                            <th style="width: 10%; text-align: center;"><strong>No. Bukti</strong></th>
                                            <th style="width: 10%; text-align: center;"><strong>No. Bukti Manual</strong></th>
                                            <th style="width: 12%; text-align: center;"><strong>NAMA REKENING</strong></th>
                                            <th style="text-align: center;"><strong>KETERANGAN</strong></th>
                                            <th style="width: 12%; text-align: center;"><strong>DEBET (Rp)</strong></th>
                                            <th style="width: 12%; text-align: center;"><strong>KREDIT (Rp)</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${htmlBody}
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" style="text-align: right;"><strong>TOTAL</strong></th>
                                            <th style="text-align: right;"><strong>${number_format(item.total.debet)}</strong></th>
                                            <th style="text-align: right;"><strong>${number_format(item.total.kredit)}</strong></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        `; 
                    });
                }else{
                    html += `
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px">
                            <p>Belum ada data.</p>
                        </div>
                    `;
                }
                
                $('#container-jurnal').html(html);
            }else{
                alert(res.msg);
            }
        });
    }
    
    $(document).ready(function () {
        loadGridLedger();
        
        $("#input-autocomplete-coa").autocomplete({
            minLength: 1,
            delay: 2,
            source: function(request, resolve) {
                resolve($.ui.autocomplete.filter(arrCoaAutocomplete, request.term));
            },
            change: function (event, ui) {
                if (ui.item === null) {
                     $(this).val('');
                     coaMasterIdChoosen = 0;
                }
            },
            select: function (event, ui) {
                coaMasterIdChoosen = ui.item.data.coa_master_id;
                
                arrCoaAutocomplete = [];
                arrCoaAutocompleteMaster.forEach(function(item, index){
                    if(typeof arrCoaAutocompleteMaster[coaMasterIdChoosen] != "undefined"){
                        arrCoaAutocomplete.push(item);
                    }
                });
            }
        });

        $(".my-input-mask").inputmask({
            singleDatePicker: true,
            format: 'DD/MM/YYYY',
            
        });
    });
    
    function loadGridLedger(coaMasterId = 0, startDate = '<?php echo date("d/m/Y"); ?>', endDate = '<?php echo date("d/m/Y"); ?>'){
        if(typeof gridLedger == 'undefined'){
            gridLedger = $("#gridview-ledger").flexigrid({
                url: siteUrl + 'accounting/ledger/get_data',
                params: [{name: "coa_master_id", value: coaMasterId}, {name: "start_date", value: startDate}, {name: "end_date", value: endDate}],
                dataType: 'json',
                colModel: [
                    {display: 'Tgl Transaksi', name: 'ledger_datetime', width: 100, sortable: true, align: 'center'},
                    {display: 'No. Bukti', name: 'ledger_trans_number', width: 120, sortable: true, align: 'center'},
                    {display: 'No. Bukti Manual', name: 'ledger_trans_number_manually', width: 180, sortable: true, align: 'center'},
                    {display: 'Keterangan', name: 'ledger_note', width: 300, sortable: true, align: 'left'},
                    {display: 'Debet (Rp)', name: 'ledger_debet', width: 150, sortable: true, align: 'right'},
                    {display: 'Kredit (Rp)', name: 'ledger_kredit', width: 150, sortable: true, align: 'right'},
                    {display: 'Saldo Akumulatif (Rp)', name: 'accumulative_balance', width: 150, sortable: true, align: 'right'},
                    {display: 'Username Admin', name: 'ledger_input_admin_username', width: 120, sortable: true, align: 'left'},
                    {display: 'Nama Admin', name: 'ledger_input_admin_name', width: 200, sortable: true, align: 'left'},
                    {display: 'Waktu Input', name: 'ledger_input_datetime', width: 180, sortable: true, align: 'center'},
                ],
                sortname: "ledger_id",
                sortorder: "desc",
                usepager: true,
                title: '',
                useRp: true,
                rp: 10,
                rpOptions: [10, 30, 50, 100, 300, 500],
                showTableToggleBtn: false,
                showToggleBtn: false,
                width: 'auto',
                height: '400',
                resizable: false,
                singleSelect: true
            });
        }else{
            $("#gridview-ledger").flexOptions({
                url: siteUrl + 'accounting/ledger/get_data',
                params: [{name: "coa_master_id", value: coaMasterId}, {name: "start_date", value: startDate}, {name: "end_date", value: endDate}],
            }).flexClearReload();
        }
        getSummary(coaMasterId, startDate, endDate);
    }
    
    function myExportData() {
        if(coaMasterIdChoosen > 0){
            let grid = $('#grid_gridview-ledger');
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

            let $form = $("<form target='_blank' method='post' action='" + siteUrl + 'accounting/ledger/export_data' + "'></form>");
            $form.append("<input type='hidden' name='column[name]' value='" + JSON.stringify(arr_column_name) + "' />");
            $form.append("<input type='hidden' name='column[title]' value='" + JSON.stringify(arr_column_title) + "' />");
            $form.append("<input type='hidden' name='column[show]' value='" + JSON.stringify(arr_column_show) + "' />");
            $form.append("<input type='hidden' name='column[align]' value='" + JSON.stringify(arr_column_align) + "' />");
            $form.append("<input type='hidden' name='sortname' value='" + sortname + "' />");
            $form.append("<input type='hidden' name='sortorder' value='" + sortorder + "' />");
            $form.append("<input type='hidden' name='query' value='" + query + "' />");
            $form.append("<input type='hidden' name='start_date' value='" + startDateChoosen + "' />");
            $form.append("<input type='hidden' name='end_date' value='" + endDateChoosen + "' />");
            $form.append("<input type='hidden' name='coa_master_id' value='" + coaMasterIdChoosen + "' />");
            $form.append("<input id='export_querys' type='hidden' name='querys' value='" + querys + "' />");
            $form.append("<input id='export_optionused' type='hidden' name='optionused' value='" + optionused + "' />");
            $form.append("<input id='export_option' type='hidden' name='option' value='" + option + "' />");
            $form.append("<input id='export_date_start' type='hidden' name='date_start' value='" + date_start + "' />");
            $form.append("<input id='export_date_end' type='hidden' name='date_end' value='" + date_end + "' />");
            $form.append("<input id='export_qtype' type='hidden' name='qtype' value='" + qtype + "' />");
            $form.append("<input id='export_total_data' type='hidden' name='total_data' value='" + total_data + "' />");
            $form.append("<input id='export_rp' type='hidden' name='rp' value='" + rp + "' />");
            $form.append("<input id='export_page' type='hidden' name='page' value='" + page + "' />");
            $('#grid_gridview-ledger').after($form);
            $form.submit();
        }
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
</script>

<!-- FORM INPUTMASK -->
<script src="<?php echo THEMES_BACKEND; ?>/js/jquery.inputmask.bundle.js"></script>
<script>
      $("#my-input-mask").inputmask({
            format: 'DD/MM/YYYY'
        });
</script>
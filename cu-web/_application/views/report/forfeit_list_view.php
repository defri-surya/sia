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

<!-- MODAL DETAIL -->
<div id="modal-detail" class="modal" role="dialog" tabindex="-1">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detail Denda <span id="detail-text"></span></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <table id="gridview-detail" style="display:none;"></table>
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

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    
    let gridDetail;
    
    function openModalDetail(memberProductId, text){
        $('#detail-text').text(text);
        loadGridDetail(memberProductId);
        $('#modal-detail').modal({
            backdrop: 'static',
        }, 'show');
    }
    
    $("#gridview").flexigrid({
        url: siteUrl + 'report/forfeit/get_data',
        dataType: 'json',
        colModel: [
            {display: 'Detail', name: 'detail', width: 40, sortable: false, datasource: false, align: 'center'},
            {display: 'No. Anggota', name: 'member_code', width: 120, sortable: true, align: 'center'},
            {display: 'No. Bakal Anggota', name: 'member_temp_code', width: 120, sortable: true, align: 'center'},
            {display: 'Nama Anggota', name: 'member_name', width: 250, sortable: true, align: 'left'},
            {display: 'Kode Pinjaman', name: 'member_product_code', width: 100, sortable: true, align: 'center'},
            {display: 'Nama Pinjaman', name: 'member_product_product_loan_name', width: 150, sortable: true, align: 'left'},
            {display: 'Alias Pinjaman', name: 'member_product_product_loan_name_alias', width: 100, sortable: true, align: 'left'},
            {display: 'Plafon (Rp)', name: 'member_product_plafon', width: 150, sortable: true, align: 'right'},
            {display: 'Saldo Plafon (Rp)', name: 'member_product_plafon_balance', width: 150, sortable: true, align: 'right'},
            {display: 'Tenor (Bulan)', name: 'member_product_tenor', width: 100, sortable: true, align: 'center'},
            {display: 'Denda Total (Rp)', name: 'denda_total', width: 150, sortable: true, align: 'right'},
            {display: 'Denda Terbayar (Rp)', name: 'denda_total_terbayar', width: 150, sortable: true, align: 'right'},
            {display: 'Denda Pemutihan (Rp)', name: 'denda_total_pemutihan', width: 150, sortable: true, align: 'right'},
            {display: 'Catatan', name: 'denda_note', width: 300, sortable: true, align: 'left'},
        ],
        buttons_right: [
            <?php
            if (privilege_view('export', $this->menu_privilege)):
                echo "{display: 'E<u>x</u>port Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("report/forfeit/export_data") . "'}";
            endif;
            ?>
        ],
        searchitems: [
            {display: 'No. Anggota', name: 'member_code', type: 'text'},
            {display: 'No. Bakal Anggota', name: 'member_temp_code', type: 'text'},
            {display: 'Nama Anggota', name: 'member_name', type: 'text'},
            {display: 'Kode Pinjaman', name: 'member_product_code', type: 'text'},
            {display: 'Nama Pinjaman', name: 'member_product_product_loan_name', type: 'text'},
            {display: 'Alias Pinjaman', name: 'member_product_product_loan_name_alias', type: 'text'},
            {display: 'Plafon (Rp)', name: 'member_product_plafon', type: 'num'},
            {display: 'Saldo Plafon (Rp)', name: 'member_product_plafon_balance', type: 'num'},
            {display: 'Tenor (Bulan)', name: 'member_product_tenor', type: 'num'},
            {display: 'Denda Total (Rp)', name: 'denda_total', type: 'num'},
            {display: 'Denda Terbayar (Rp)', name: 'denda_total_terbayar', type: 'num'},
            {display: 'Denda Pemutihan (Rp)', name: 'denda_total_pemutihan', type: 'num'},
            {display: 'Catatan', name: 'denda_note', type: 'text'},
        ],
        sortname: "denda_id",
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
    
    function loadGridDetail(memberProductId){
        if(typeof gridDetail == 'undefined'){
            gridDetail = $("#gridview-detail").flexigrid({
                url: siteUrl + 'report/forfeit/get_data_detail',
                params: [{name: "member_product_id", value: memberProductId}],
                dataType: 'json',
                colModel: [
                    {display: 'Periode', name: 'denda_detail_periode', width: 100, sortable: true, align: 'center'},
                    {display: 'Denda Ke', name: 'denda_detail_ke', width: 100, sortable: true, align: 'center'},
                    {display: 'Nominal Denda (Rp)', name: 'denda_detail_nominal', width: 150, sortable: true, align: 'right'},
                    {display: 'Tanggal Input', name: 'denda_detail_input_date', width: 180, sortable: true, align: 'center'},
                ],
                searchitems: [
                    {display: 'Periode', name: 'denda_detail_periode', type: 'num'},
                    {display: 'Denda Ke', name: 'denda_detail_ke', type: 'num'},
                    {display: 'Nominal Denda (Rp)', name: 'denda_detail_nominal', type: 'num'},
                    {display: 'Tanggal Input', name: 'denda_detail_input_date', type: 'date'},
                ],
                sortname: "denda_detail_id",
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
                url: siteUrl + 'report/forfeit/get_data_detail',
                params: [{name: "member_product_id", value: memberProductId}],
            }).flexClearReload();
        }
    }
</script>
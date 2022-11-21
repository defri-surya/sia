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

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';

    $("#gridview").flexigrid({
        url: siteUrl + 'report/lkh/get_data',
        dataType: 'json',
        colModel: [{
                display: 'Tanggal Pembayaran',
                name: 'transaction_datetime',
                width: 160,
                sortable: true,
                align: 'center'
            },
            {
                display: 'Nama Anggota',
                name: 'member_name',
                width: 200,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'No. Anggota',
                name: 'member_code',
                width: 80,
                sortable: true,
                align: 'center'
            },
            {
                display: 'No. Bakal Anggota',
                name: 'member_temp_code',
                width: 110,
                sortable: true,
                align: 'center'
            },
            {
                display: 'Debet (Rp)',
                name: 'transaction_debet',
                width: 120,
                sortable: true,
                align: 'right'
            },
            {
                display: 'Kredit (Rp)',
                name: 'transaction_kredit',
                width: 120,
                sortable: true,
                align: 'right'
            },
            {
                display: 'Keterangan',
                name: 'transaction_note',
                width: 500,
                sortable: true,
                align: 'left'
            },
            {
                display: 'Waktu Input Sistem',
                name: 'transaction_input_datetime',
                width: 200,
                sortable: true,
                align: 'center'
            },
            {
                display: 'Nama Admin',
                name: 'transaction_administrator_name',
                width: 200,
                sortable: true,
                align: 'left',
                hide: true
            },
            {
                display: 'Username Admin',
                name: 'transaction_administrator_username',
                width: 150,
                sortable: true,
                align: 'left',
                hide: true
            },
        ],
        buttons_right: [
            <?php
            if (privilege_view('export', $this->menu_privilege)) :
                echo "{display: 'E<u>x</u>port Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("report/lkh/export_data_lkh") . "'}";
            endif;
            ?>
        ],
        searchitems: [{
                display: 'Nama Simpanan',
                name: 'transaction_product_saving_id',
                type: 'select',
                option: '<?php echo $option_saving; ?>'
            },
            {
                display: 'Nama Pinjaman',
                name: 'transaction_product_loan_id',
                type: 'select',
                option: '<?php echo $option_loan; ?>'
            },
            {
                display: 'Tanggal Pembayaran',
                name: 'transaction_datetime',
                type: 'date'
            },
            {
                display: 'Nama Anggota',
                name: 'member_name',
                type: 'text'
            },
            {
                display: 'No. Anggota',
                name: 'member_code',
                type: 'text'
            },
            {
                display: 'No. Bakal Anggota',
                name: 'member_temp_code',
                type: 'text'
            },
            {
                display: 'Debet (Rp)',
                name: 'transaction_debet',
                type: 'num'
            },
            {
                display: 'Kredit (Rp)',
                name: 'transaction_kredit',
                type: 'num'
            },
            {
                display: 'Keterangan',
                name: 'transaction_note',
                type: 'text'
            },
            {
                display: 'Waktu Input',
                name: 'transaction_input_datetime',
                type: 'date'
            },
            {
                display: 'Nama Admin',
                name: 'transaction_administrator_name',
                type: 'text'
            },
            {
                display: 'Username Admin',
                name: 'transaction_administrator_username',
                type: 'text'
            },
        ],
        sortname: "transaction_id",
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
</script>
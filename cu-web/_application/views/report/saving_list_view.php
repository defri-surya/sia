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
        url: siteUrl + 'report/saving/get_data',
        dataType: 'json',
        colModel: [
            {display: 'No. Anggota', name: 'member_product_saving_member_code', width: 80, sortable: true, align: 'center'},
            {display: 'Nama Anggota', name: 'member_product_saving_member_name', width: 300, sortable: true, align: 'left'},
            {display: 'Status Blokir', name: 'member_product_saving_is_blocked', width: 100, sortable: true, align: 'center'},
            {display: 'Status Aktif', name: 'member_product_saving_is_active', width: 100, sortable: true, align: 'center'},
            {display: 'No. Rekening', name: 'member_product_saving_account_number', width: 120, sortable: true, align: 'center'},
            {display: 'Saldo (Rp)', name: 'member_product_saving_member_balance', width: 120, sortable: true, align: 'right'},
            {display: 'Nama Simpanan', name: 'member_product_saving_name', width: 350, sortable: true, align: 'left'},
            {display: 'Nama Alias Simpanan', name: 'member_product_saving_name_alias', width: 200, sortable: true, align: 'left'},
            {display: 'Jangka Waktu', name: 'member_product_saving_period', width: 80, sortable: true, align: 'center'},
        ],
        buttons_right: [
            <?php
            if (privilege_view('export', $this->menu_privilege)):
                echo "{display: 'E<u>x</u>port Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("report/saving/export_data_saving") . "'}";
            endif;
            ?>
        ],
        searchitems: [
            {display: 'No. Anggota', name: 'member_product_saving_member_code', type: 'text'},
            {display: 'Nama Anggota', name: 'member_product_saving_member_name', type: 'text'},
            {display: 'Status Blokir', name: 'member_product_saving_is_blocked', type: 'select', option: '0:Tidak Terblokir|1:Terblokir'},
            {display: 'Status Aktif', name: 'member_product_saving_is_active', type: 'select', option: '0: Tidak Aktif|1: Aktif'},
            {display: 'No. Rekening', name: 'member_product_saving_account_number', type: 'text'},
            {display: 'Saldo (Rp)', name: 'member_product_saving_member_balance', type: 'num'},
            {display: 'Nama Simpanan', name: 'member_product_saving_product_saving_id', type: 'select', option: '<?php echo $list_option_saving; ?>'},
            {display: 'Nama Alias Simpanan', name: 'member_product_saving_name_alias', type: 'text'},
            {display: 'Jangka Waktu', name: 'member_product_saving_period', type: 'num'},
        ],
        sortname: "member_product_saving_id",
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
</script>
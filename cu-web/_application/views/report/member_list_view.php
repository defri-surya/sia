<style>
    .color-1 .form-group:nth-child(even){
        background:#E6E6FA;
        padding: 5px;
    }
    .color-1 .form-group:nth-child(odd){
        background-color: #fff;
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
            <li class="active"><a data-toggle="tab" href="#tab-member">Anggota</a></li>
            <li><a data-toggle="tab" href="#tab-alb">Anggota Luar Biasa</a></li>
            <li><a data-toggle="tab" href="#tab-alb-special">Anggota Luar Biasa Khusus</a></li>
            <li><a data-toggle="tab" href="#tab-calon">Calon Anggota</a></li>
            <li><a data-toggle="tab" href="#tab-bukan">Purna Anggota</a></li>
        </ul>
        
        <div class="tab-content">
            <div id="tab-member" class="tab-pane fade in active">
                <table id="gridview" style="display:none;"></table>
            </div>
            <div id="tab-alb" class="tab-pane fade">
                <table id="gridview-alb" style="display:none;"></table>
            </div>
            <div id="tab-alb-special" class="tab-pane fade">
                <table id="gridview-alb-special" style="display:none;"></table>
            </div>
            <div id="tab-calon" class="tab-pane fade">
                <table id="gridview-calon" style="display:none;"></table>
            </div>
            <div id="tab-bukan" class="tab-pane fade">
                <table id="gridview-bukan" style="display:none;"></table>
            </div>
        </div>
    </div>
</div>

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    
    let gridMember;
    let gridALB;
    let gridALBSpecial;
    let gridCalon;
    let gridBukan;
    
    let colModel = [
        {display: 'No. Anggota', name: 'member_code', width: 80, sortable: true, align: 'center'},
        {display: 'Nama', name: 'member_name', width: 200, sortable: true, align: 'left'},
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
        {display: 'Kewarganegaraan', name: 'member_nationality', width: 110, sortable: true, align: 'center', hide: true},
        {display: 'Status Tempat Tinggal', name: 'member_residence_status', width: 150, sortable: true, align: 'left', hide: true},
        {display: 'Telepon', name: 'member_phone_number', width: 100, sortable: true, align: 'left'},
        {display: 'No. Handphone', name: 'member_mobilephone_number', width: 100, sortable: true, align: 'left'},
        {display: 'Pekerjaan', name: 'member_job', width: 100, sortable: true, align: 'left'},
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
    ];
    
    $(document).ready(function (){
        
        $('.my-select2').select2();
        
        let urlLocation = new URL(window.location);
        let params = new URLSearchParams(urlLocation.search);
        if(params.get('page') != null){
            if(params.get('page') == 'alb'){
                $('#container-tabs a[data-toggle="tab"][href="#tab-alb"]').click();
                loadGridALB();
            }
            if(params.get('page') == 'alb-special'){
                $('#container-tabs a[data-toggle="tab"][href="#tab-alb-special"]').click();
                loadGridALBSpecial();
            }
            if(params.get('page') == 'calon'){
                $('#container-tabs a[data-toggle="tab"][href="#tab-calon"]').click();
                loadGridCalon();
            }
            if(params.get('page') == 'bukan'){
                $('#container-tabs a[data-toggle="tab"][href="#tab-bukan"]').click();
                loadGridBukan();
            }
        }else{
            $('#container-tabs a[data-toggle="tab"][href="#tab-member"]').click();
            loadGridMember();
        }
        
        $('#container-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var uri = 'show';
            var target = $(e.target).attr("href"); // activated tab
            if (target === '#tab-member') {
                loadGridMember();
            } else if (target === '#tab-alb') {
                loadGridALB();
                uri = 'show?page=alb';
            }else if (target === '#tab-alb-special') {
                loadGridALBSpecial();
                uri = 'show?page=alb-special';
            }else if(target === '#tab-calon'){
                loadGridCalon();
                uri = 'show?page=calon';
            }else if(target === '#tab-bukan'){
                loadGridBukan();
                uri = 'show?page=bukan';
            }
            window.history.replaceState({}, '', uri);
        });
        
    });
    
    function loadGridMember(){
        if(typeof gridMember == "undefined"){
            gridMember = $("#gridview").flexigrid({
                url: siteUrl + 'report/member/get_data',
                params: [{name: "member_status", value: 'member'}],
                dataType: 'json',
                colModel: colModel,
                buttons_right: [
                    <?php if(privilege_view('export', $this->menu_privilege)):
                        echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: myExport, urlaction: '" . site_url("report/member/export_data_member") . "'}";
                    endif; ?>
                ],
                searchitems: [
                    {display: 'Unit', name: 'branch_name', type:'text'},
                    {display: 'No. Anggota', name: 'member_code', type:'text'},
                    {display: 'Nama', name: 'member_name', type:'text'},
                    {display: 'No. Identitas', name: 'member_identity_number', type:'text'},
                    {display: 'Tipe Identitas', name: 'member_identity_type', type:'select', option:'0:KTP|1:SIM|2:KK|3:KIA/KTM|4:Passport|5:Lainnya'},
                    {display: 'Jenis Kelamin', name: 'member_gender', type:'select', option:'0:Pria|1:Wanita'},
                    {display: 'Tanggal Lahir', name: 'member_birthdate', type:'text'},
                    {display: 'Tempat Lahir', name: 'member_birthplace', type:'text'},
                    {display: 'Alamat', name: 'member_address', type:'text'},
                    {display: 'Provinsi', name: 'member_province', type:'text'},
                    {display: 'Kota', name: 'member_city', type:'text'},
                    {display: 'Kecamatan', name: 'member_subdistrict', type:'text'},
                    {display: 'Kelurahan', name: 'member_kelurahan', type:'text'},
                    {display: 'RT', name: 'member_rt_number', type:'text'},
                    {display: 'RW', name: 'member_rw_number', type:'text'},
                    {display: 'Kode Pos', name: 'member_zipcode', type:'text'},
                    {display: 'Domisili', name: 'member_address_domicile', type:'text'},
                    {display: 'Provinsi Domisili', name: 'member_domicile_province', type: 'text'},
                    {display: 'Kota Domisili', name: 'member_domicile_city', type: 'text'},
                    {display: 'Kecamatan Domisili', name: 'member_domicile_subdistrict', type: 'text'},
                    {display: 'Kelurahan Domisili', name: 'member_domicile_kelurahan', type: 'text'},
                    {display: 'RT Domisili', name: 'member_domicile_rt_number', type: 'text'},
                    {display: 'RW Domisili', name: 'member_domicile_rw_number', type: 'text'},
                    {display: 'Kode Pos Domisili', name: 'member_domicile_zipcode', type: 'text'},
                    {display: 'Status Tempat Tinggal', name: 'member_residence_status', type: 'select', option: '0:Milik Sendiri|1:Sewa/Kontrak|2:Menumpang|3:Ikut Orang Tua'},
                    {display: 'Telepon', name: 'member_phone_number', type:'text'},
                    {display: 'No. Handphone', name: 'member_mobilephone_number', type:'text'},
                    {display: 'Pekerjaan', name: 'member_job', type:'text'},
                    {display: 'Bekerja di', name: 'member_working_in', type: 'select', option: '0:Indonesia|1:Luar Negeri'},
                    {display: 'Rata-rata Penghasilan', name: 'member_average_income', type:'select', option:'0:< 1jt|1:1jt - 3jt|2:3jt - 5jt|3:5jt - 10jt|4:>10jt'},
                    {display: 'Pendidikan Terakhir', name: 'member_last_education', type:'select', option:'0:Tidak Sekolah|1:SD|2:SLTP|3:SMU/SMK|4:Diploma 1,2,3|5:S1|6:S2|7:S3'},
                    {display: 'Agama', name: 'member_religion', type:'select', option:'0:Islam|1:Kristen|2:Katolik|3:Hindu|4:Budha|5:Kong Hu Cu|6:Aliran Kepercayaan|7:Lainnya'},
                    {display: 'Suku', name: 'member_ethnic_group', type: 'text'},
                    {display: 'Gol. Darah', name: 'member_blood_type', type: 'select', option: '0:A|1:B|2:AB|3:O'},
                    {display: 'Ukuran Baju', name: 'member_shirt_size', type: 'select', option: '0:S|1:M|2:L|3:XL|4:XXL|5:XXXL'},
                    {display: 'Status Pernikahan', name: 'member_is_married', type:'select', option:'0:Belum Menikah|1:Sudah Menikah'},
                    {display: 'Nama Suami/Istri', name: 'member_husband_wife_name', type:'text'},
                    {display: 'Nama Anak', name: 'member_child_name', type:'text'},
                    {display: 'Nama Ibu Kandung', name: 'member_mother_name', type:'text'},
                    {display: 'Pernah Terdaftar di CU Lain', name: 'member_is_registered_others_cu', type:'text'},
                    {display: 'Nama CU Lain', name: 'member_others_cu_name', type:'text'},
                    {display: 'Nama Ahli Waris', name: 'member_heir_name', type:'text'},
                    {display: 'Status Ahli Waris', name: 'member_heir_status', type:'text'},
                    {display: 'Waktu Daftar', name: 'member_join_datetime', type:'date'},
                    {display: 'Nama Administrator Input', name: 'member_input_admin_name', type:'text'},
                    {display: 'Waktu Administrator Input', name: 'member_input_datetime', type:'date'},
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
             $("#gridview").flexOptions({
                url: siteUrl + 'report/member/get_data',
                params: [{name: "member_status", value: 'member'}],
            }).flexClearReload();
        }
    }
    
    function loadGridALB(){
        if(typeof gridALB == "undefined"){
            gridALB = $("#gridview-alb").flexigrid({
                url: siteUrl + 'report/member/get_data',
                params: [{name: "member_status", value: 'alb'}],
                dataType: 'json',
                colModel: colModel,
                buttons_right: [
                    <?php if(privilege_view('export', $this->menu_privilege)):
                        echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: myExport, urlaction: '" . site_url("report/member/export_data_member") . "'}";
                    endif; ?>
                ],
                searchitems: [
                    {display: 'Unit', name: 'branch_name', type:'text'},
                    {display: 'No. Anggota', name: 'member_code', type:'text'},
                    {display: 'Nama', name: 'member_name', type:'text'},
                    {display: 'No. Identitas', name: 'member_identity_number', type:'text'},
                    {display: 'Tipe Identitas', name: 'member_identity_type', type:'select', option:'0:KTP|1:SIM|2:KK|3:KIA/KTM|4:Passport|5:Lainnya'},
                    {display: 'Jenis Kelamin', name: 'member_gender', type:'select', option:'0:Pria|1:Wanita'},
                    {display: 'Tanggal Lahir', name: 'member_birthdate', type:'text'},
                    {display: 'Tempat Lahir', name: 'member_birthplace', type:'text'},
                    {display: 'Alamat', name: 'member_address', type:'text'},
                    {display: 'Provinsi', name: 'member_province', type:'text'},
                    {display: 'Kota', name: 'member_city', type:'text'},
                    {display: 'Kecamatan', name: 'member_subdistrict', type:'text'},
                    {display: 'Kelurahan', name: 'member_kelurahan', type:'text'},
                    {display: 'RT', name: 'member_rt_number', type:'text'},
                    {display: 'RW', name: 'member_rw_number', type:'text'},
                    {display: 'Kode Pos', name: 'member_zipcode', type:'text'},
                    {display: 'Domisili', name: 'member_address_domicile', type:'text'},
                    {display: 'Provinsi Domisili', name: 'member_domicile_province', type: 'text'},
                    {display: 'Kota Domisili', name: 'member_domicile_city', type: 'text'},
                    {display: 'Kecamatan Domisili', name: 'member_domicile_subdistrict', type: 'text'},
                    {display: 'Kelurahan Domisili', name: 'member_domicile_kelurahan', type: 'text'},
                    {display: 'RT Domisili', name: 'member_domicile_rt_number', type: 'text'},
                    {display: 'RW Domisili', name: 'member_domicile_rw_number', type: 'text'},
                    {display: 'Kode Pos Domisili', name: 'member_domicile_zipcode', type: 'text'},
                    {display: 'Status Tempat Tinggal', name: 'member_residence_status', type: 'select', option: '0:Milik Sendiri|1:Sewa/Kontrak|2:Menumpang|3:Ikut Orang Tua'},
                    {display: 'Telepon', name: 'member_phone_number', type:'text'},
                    {display: 'No. Handphone', name: 'member_mobilephone_number', type:'text'},
                    {display: 'Pekerjaan', name: 'member_job', type:'text'},
                    {display: 'Bekerja di', name: 'member_working_in', type: 'select', option: '0:Indonesia|1:Luar Negeri'},
                    {display: 'Rata-rata Penghasilan', name: 'member_average_income', type:'select', option:'0:< 1jt|1:1jt - 3jt|2:3jt - 5jt|3:5jt - 10jt|4:>10jt'},
                    {display: 'Pendidikan Terakhir', name: 'member_last_education', type:'select', option:'0:Tidak Sekolah|1:SD|2:SLTP|3:SMU/SMK|4:Diploma 1,2,3|5:S1|6:S2|7:S3'},
                    {display: 'Agama', name: 'member_religion', type:'select', option:'0:Islam|1:Kristen|2:Katolik|3:Hindu|4:Budha|5:Kong Hu Cu|6:Aliran Kepercayaan|7:Lainnya'},
                    {display: 'Suku', name: 'member_ethnic_group', type: 'text'},
                    {display: 'Gol. Darah', name: 'member_blood_type', type: 'select', option: '0:A|1:B|2:AB|3:O'},
                    {display: 'Ukuran Baju', name: 'member_shirt_size', type: 'select', option: '0:S|1:M|2:L|3:XL|4:XXL|5:XXXL'},
                    {display: 'Status Pernikahan', name: 'member_is_married', type:'select', option:'0:Belum Menikah|1:Sudah Menikah'},
                    {display: 'Nama Suami/Istri', name: 'member_husband_wife_name', type:'text'},
                    {display: 'Nama Anak', name: 'member_child_name', type:'text'},
                    {display: 'Nama Ibu Kandung', name: 'member_mother_name', type:'text'},
                    {display: 'Pernah Terdaftar di CU Lain', name: 'member_is_registered_others_cu', type:'text'},
                    {display: 'Nama CU Lain', name: 'member_others_cu_name', type:'text'},
                    {display: 'Nama Ahli Waris', name: 'member_heir_name', type:'text'},
                    {display: 'Status Ahli Waris', name: 'member_heir_status', type:'text'},
                    {display: 'Waktu Daftar', name: 'member_join_datetime', type:'date'},
                    {display: 'Nama Administrator Input', name: 'member_input_admin_name', type:'text'},
                    {display: 'Waktu Administrator Input', name: 'member_input_datetime', type:'date'},
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
             $("#gridview-alb").flexOptions({
                url: siteUrl + 'report/member/get_data',
                params: [{name: "member_status", value: 'alb'}],
            }).flexClearReload();
        }
    }
    
    function loadGridALBSpecial(){
        if(typeof gridALBSpecial == "undefined"){
            gridALBSpecial = $("#gridview-alb-special").flexigrid({
                url: siteUrl + 'report/member/get_data',
                params: [{name: "member_status", value: 'alb-special'}],
                dataType: 'json',
                colModel: [
                    <?php if(privilege_view('update', $this->menu_privilege)):
                        echo "{display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false},";
                    endif;
                    echo "
                        {display: 'No. Anggota', name: 'member_code', width: 80, sortable: true, align: 'center'},
                        {display: 'Nama', name: 'member_name', width: 200, sortable: true, align: 'left'},
                        {display: 'Status Keanggotaan', name: 'member_status', width: 150, sortable: true, align: 'center'},
                        {display: 'Uang Pangkal', name: 'member_entrance_fee_paid_off', width: 100, sortable: true, align: 'center'},
                        {display: 'Diksar', name: 'member_is_diksar', width: 100, sortable: true, align: 'center'},
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
                        {display: 'Kewarganegaraan', name: 'member_nationality', width: 110, sortable: true, align: 'center', hide: true},
                        {display: 'Status Tempat Tinggal', name: 'member_residence_status', width: 150, sortable: true, align: 'left', hide: true},
                        {display: 'Telepon', name: 'member_phone_number', width: 100, sortable: true, align: 'left'},
                        {display: 'No. Handphone', name: 'member_mobilephone_number', width: 100, sortable: true, align: 'left'},
                        {display: 'Pekerjaan', name: 'member_job', width: 100, sortable: true, align: 'left'},
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
                        ";
                    ?>
                ],
                buttons_right: [
                    <?php if(privilege_view('export', $this->menu_privilege)):
                        echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: myExport, urlaction: '" . site_url("report/member/export_data_member") . "'}";
                    endif; ?>
                ],
                searchitems: [
                    {display: 'Unit', name: 'branch_name', type:'text'},
                    {display: 'No. Anggota', name: 'member_code', type:'text'},
                    {display: 'Nama', name: 'member_name', type:'text'},
                    {display: 'Uang Pangkal', name: 'member_entrance_fee_paid_off', type: 'select', option: '0:Belum Lunas|1:Lunas'},
                    {display: 'Diksar', name: 'member_is_diksar', type: 'select', option: '0:Belum Diksar|1:Sudah Diksar'},
                    {display: 'No. Identitas', name: 'member_identity_number', type:'text'},
                    {display: 'Tipe Identitas', name: 'member_identity_type', type:'select', option:'0:KTP|1:SIM|2:KK|3:KIA/KTM|4:Passport|5:Lainnya'},
                    {display: 'Jenis Kelamin', name: 'member_gender', type:'select', option:'0:Pria|1:Wanita'},
                    {display: 'Tanggal Lahir', name: 'member_birthdate', type:'text'},
                    {display: 'Tempat Lahir', name: 'member_birthplace', type:'text'},
                    {display: 'Alamat', name: 'member_address', type:'text'},
                    {display: 'Provinsi', name: 'member_province', type:'text'},
                    {display: 'Kota', name: 'member_city', type:'text'},
                    {display: 'Kecamatan', name: 'member_subdistrict', type:'text'},
                    {display: 'Kelurahan', name: 'member_kelurahan', type:'text'},
                    {display: 'RT', name: 'member_rt_number', type:'text'},
                    {display: 'RW', name: 'member_rw_number', type:'text'},
                    {display: 'Kode Pos', name: 'member_zipcode', type:'text'},
                    {display: 'Domisili', name: 'member_address_domicile', type:'text'},
                    {display: 'Provinsi Domisili', name: 'member_domicile_province', type: 'text'},
                    {display: 'Kota Domisili', name: 'member_domicile_city', type: 'text'},
                    {display: 'Kecamatan Domisili', name: 'member_domicile_subdistrict', type: 'text'},
                    {display: 'Kelurahan Domisili', name: 'member_domicile_kelurahan', type: 'text'},
                    {display: 'RT Domisili', name: 'member_domicile_rt_number', type: 'text'},
                    {display: 'RW Domisili', name: 'member_domicile_rw_number', type: 'text'},
                    {display: 'Kode Pos Domisili', name: 'member_domicile_zipcode', type: 'text'},
                    {display: 'Status Tempat Tinggal', name: 'member_residence_status', type: 'select', option: '0:Milik Sendiri|1:Sewa/Kontrak|2:Menumpang|3:Ikut Orang Tua'},
                    {display: 'Telepon', name: 'member_phone_number', type:'text'},
                    {display: 'No. Handphone', name: 'member_mobilephone_number', type:'text'},
                    {display: 'Pekerjaan', name: 'member_job', type:'text'},
                    {display: 'Bekerja di', name: 'member_working_in', type: 'select', option: '0:Indonesia|1:Luar Negeri'},
                    {display: 'Rata-rata Penghasilan', name: 'member_average_income', type:'select', option:'0:< 1jt|1:1jt - 3jt|2:3jt - 5jt|3:5jt - 10jt|4:>10jt'},
                    {display: 'Pendidikan Terakhir', name: 'member_last_education', type:'select', option:'0:Tidak Sekolah|1:SD|2:SLTP|3:SMU/SMK|4:Diploma 1,2,3|5:S1|6:S2|7:S3'},
                    {display: 'Agama', name: 'member_religion', type:'select', option:'0:Islam|1:Kristen|2:Katolik|3:Hindu|4:Budha|5:Kong Hu Cu|6:Aliran Kepercayaan|7:Lainnya'},
                    {display: 'Suku', name: 'member_ethnic_group', type: 'text'},
                    {display: 'Gol. Darah', name: 'member_blood_type', type: 'select', option: '0:A|1:B|2:AB|3:O'},
                    {display: 'Ukuran Baju', name: 'member_shirt_size', type: 'select', option: '0:S|1:M|2:L|3:XL|4:XXL|5:XXXL'},
                    {display: 'Status Pernikahan', name: 'member_is_married', type:'select', option:'0:Belum Menikah|1:Sudah Menikah'},
                    {display: 'Nama Suami/Istri', name: 'member_husband_wife_name', type:'text'},
                    {display: 'Nama Anak', name: 'member_child_name', type:'text'},
                    {display: 'Nama Ibu Kandung', name: 'member_mother_name', type:'text'},
                    {display: 'Pernah Terdaftar di CU Lain', name: 'member_is_registered_others_cu', type:'text'},
                    {display: 'Nama CU Lain', name: 'member_others_cu_name', type:'text'},
                    {display: 'Nama Ahli Waris', name: 'member_heir_name', type:'text'},
                    {display: 'Status Ahli Waris', name: 'member_heir_status', type:'text'},
                    {display: 'Waktu Daftar', name: 'member_join_datetime', type:'date'},
                    {display: 'Nama Administrator Input', name: 'member_input_admin_name', type:'text'},
                    {display: 'Waktu Administrator Input', name: 'member_input_datetime', type:'date'},
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
             $("#gridview-alb-special").flexOptions({
                url: siteUrl + 'report/member/get_data',
                params: [{name: "member_status", value: 'alb-special'}],
            }).flexClearReload();
        }
    }
    
    function loadGridCalon(){
        if(typeof gridCalon == "undefined"){
            gridCalon = $("#gridview-calon").flexigrid({
                url: siteUrl + 'report/member/get_data',
                params: [{name: "member_status", value: 'calon'}],
                dataType: 'json',
                colModel: [
                    {display: 'No. Bakal Anggota', name: 'member_temp_code', width: 110, sortable: true, align: 'center'},
                    {display: 'Nama', name: 'member_name', width: 200, sortable: true, align: 'left'},
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
                    {display: 'Kewarganegaraan', name: 'member_nationality', width: 110, sortable: true, align: 'center', hide: true},
                    {display: 'Status Tempat Tinggal', name: 'member_residence_status', width: 150, sortable: true, align: 'left', hide: true},
                    {display: 'Telepon', name: 'member_phone_number', width: 100, sortable: true, align: 'left'},
                    {display: 'No. Handphone', name: 'member_mobilephone_number', width: 100, sortable: true, align: 'left'},
                    {display: 'Pekerjaan', name: 'member_job', width: 100, sortable: true, align: 'left'},
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
                    <?php if(privilege_view('export', $this->menu_privilege)):
                        echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: myExport, urlaction: '" . site_url("report/member/export_data_member") . "'}";
                    endif; ?>
                ],
                searchitems: [
                    {display: 'Unit', name: 'branch_name', type:'text'},
                    {display: 'No. Bakal Anggota', name: 'member_temp_code', type:'text'},
                    {display: 'Nama', name: 'member_name', type:'text'},
                    {display: 'No. Identitas', name: 'member_identity_number', type:'text'},
                    {display: 'Tipe Identitas', name: 'member_identity_type', type:'select', option:'0:KTP|1:SIM|2:KK|3:KIA/KTM|4:Passport|5:Lainnya'},
                    {display: 'Jenis Kelamin', name: 'member_gender', type:'select', option:'0:Pria|1:Wanita'},
                    {display: 'Tanggal Lahir', name: 'member_birthdate', type:'text'},
                    {display: 'Tempat Lahir', name: 'member_birthplace', type:'text'},
                    {display: 'Alamat', name: 'member_address', type:'text'},
                    {display: 'Provinsi', name: 'member_province', type:'text'},
                    {display: 'Kota', name: 'member_city', type:'text'},
                    {display: 'Kecamatan', name: 'member_subdistrict', type:'text'},
                    {display: 'Kelurahan', name: 'member_kelurahan', type:'text'},
                    {display: 'RT', name: 'member_rt_number', type:'text'},
                    {display: 'RW', name: 'member_rw_number', type:'text'},
                    {display: 'Kode Pos', name: 'member_zipcode', type:'text'},
                    {display: 'Domisili', name: 'member_address_domicile', type:'text'},
                    {display: 'Provinsi Domisili', name: 'member_domicile_province', type: 'text'},
                    {display: 'Kota Domisili', name: 'member_domicile_city', type: 'text'},
                    {display: 'Kecamatan Domisili', name: 'member_domicile_subdistrict', type: 'text'},
                    {display: 'Kelurahan Domisili', name: 'member_domicile_kelurahan', type: 'text'},
                    {display: 'RT Domisili', name: 'member_domicile_rt_number', type: 'text'},
                    {display: 'RW Domisili', name: 'member_domicile_rw_number', type: 'text'},
                    {display: 'Kode Pos Domisili', name: 'member_domicile_zipcode', type: 'text'},
                    {display: 'Status Tempat Tinggal', name: 'member_residence_status', type: 'select', option: '0:Milik Sendiri|1:Sewa/Kontrak|2:Menumpang|3:Ikut Orang Tua'},
                    {display: 'Telepon', name: 'member_phone_number', type:'text'},
                    {display: 'No. Handphone', name: 'member_mobilephone_number', type:'text'},
                    {display: 'Pekerjaan', name: 'member_job', type:'text'},
                    {display: 'Bekerja di', name: 'member_working_in', type: 'select', option: '0:Indonesia|1:Luar Negeri'},
                    {display: 'Rata-rata Penghasilan', name: 'member_average_income', type:'select', option:'0:< 1jt|1:1jt - 3jt|2:3jt - 5jt|3:5jt - 10jt|4:>10jt'},
                    {display: 'Pendidikan Terakhir', name: 'member_last_education', type:'select', option:'0:Tidak Sekolah|1:SD|2:SLTP|3:SMU/SMK|4:Diploma 1,2,3|5:S1|6:S2|7:S3'},
                    {display: 'Agama', name: 'member_religion', type:'select', option:'0:Islam|1:Kristen|2:Katolik|3:Hindu|4:Budha|5:Kong Hu Cu|6:Aliran Kepercayaan|7:Lainnya'},
                    {display: 'Suku', name: 'member_ethnic_group', type: 'text'},
                    {display: 'Gol. Darah', name: 'member_blood_type', type: 'select', option: '0:A|1:B|2:AB|3:O'},
                    {display: 'Ukuran Baju', name: 'member_shirt_size', type: 'select', option: '0:S|1:M|2:L|3:XL|4:XXL|5:XXXL'},
                    {display: 'Status Pernikahan', name: 'member_is_married', type:'select', option:'0:Belum Menikah|1:Sudah Menikah'},
                    {display: 'Nama Suami/Istri', name: 'member_husband_wife_name', type:'text'},
                    {display: 'Nama Anak', name: 'member_child_name', type:'text'},
                    {display: 'Nama Ibu Kandung', name: 'member_mother_name', type:'text'},
                    {display: 'Pernah Terdaftar di CU Lain', name: 'member_is_registered_others_cu', type:'text'},
                    {display: 'Nama CU Lain', name: 'member_others_cu_name', type:'text'},
                    {display: 'Nama Ahli Waris', name: 'member_heir_name', type:'text'},
                    {display: 'Status Ahli Waris', name: 'member_heir_status', type:'text'},
                    {display: 'Waktu Daftar', name: 'member_join_datetime', type:'date'},
                    {display: 'Nama Administrator Input', name: 'member_input_admin_name', type:'text'},
                    {display: 'Waktu Administrator Input', name: 'member_input_datetime', type:'date'},
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
             $("#gridview-calon").flexOptions({
                url: siteUrl + 'report/member/get_data',
                params: [{name: "member_status", value: 'calon'}],
            }).flexClearReload();
        }
    }
    
    function loadGridBukan(){
        if(typeof gridBukan == "undefined"){
            gridBukan = $("#gridview-bukan").flexigrid({
                url: siteUrl + 'report/member/get_data',
                params: [{name: "member_status", value: 'bukan'}],
                dataType: 'json',
                colModel: colModel,
                buttons_right: [
                    <?php if(privilege_view('export', $this->menu_privilege)):
                        echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: myExport, urlaction: '" . site_url("report/member/export_data_member") . "'}";
                    endif; ?>
                ],
                searchitems: [
                    {display: 'Unit', name: 'branch_name', type:'text'},
                    {display: 'No. Anggota', name: 'member_code', type:'text'},
                    {display: 'Nama', name: 'member_name', type:'text'},
                    {display: 'No. Identitas', name: 'member_identity_number', type:'text'},
                    {display: 'Tipe Identitas', name: 'member_identity_type', type:'select', option:'0:KTP|1:SIM|2:KK|3:KIA/KTM|4:Passport|5:Lainnya'},
                    {display: 'Jenis Kelamin', name: 'member_gender', type:'select', option:'0:Pria|1:Wanita'},
                    {display: 'Tanggal Lahir', name: 'member_birthdate', type:'text'},
                    {display: 'Tempat Lahir', name: 'member_birthplace', type:'text'},
                    {display: 'Alamat', name: 'member_address', type:'text'},
                    {display: 'Provinsi', name: 'member_province', type:'text'},
                    {display: 'Kota', name: 'member_city', type:'text'},
                    {display: 'Kecamatan', name: 'member_subdistrict', type:'text'},
                    {display: 'Kelurahan', name: 'member_kelurahan', type:'text'},
                    {display: 'RT', name: 'member_rt_number', type:'text'},
                    {display: 'RW', name: 'member_rw_number', type:'text'},
                    {display: 'Kode Pos', name: 'member_zipcode', type:'text'},
                    {display: 'Domisili', name: 'member_address_domicile', type:'text'},
                    {display: 'Provinsi Domisili', name: 'member_domicile_province', type: 'text'},
                    {display: 'Kota Domisili', name: 'member_domicile_city', type: 'text'},
                    {display: 'Kecamatan Domisili', name: 'member_domicile_subdistrict', type: 'text'},
                    {display: 'Kelurahan Domisili', name: 'member_domicile_kelurahan', type: 'text'},
                    {display: 'RT Domisili', name: 'member_domicile_rt_number', type: 'text'},
                    {display: 'RW Domisili', name: 'member_domicile_rw_number', type: 'text'},
                    {display: 'Kode Pos Domisili', name: 'member_domicile_zipcode', type: 'text'},
                    {display: 'Status Tempat Tinggal', name: 'member_residence_status', type: 'select', option: '0:Milik Sendiri|1:Sewa/Kontrak|2:Menumpang|3:Ikut Orang Tua'},
                    {display: 'Telepon', name: 'member_phone_number', type:'text'},
                    {display: 'No. Handphone', name: 'member_mobilephone_number', type:'text'},
                    {display: 'Pekerjaan', name: 'member_job', type:'text'},
                    {display: 'Bekerja di', name: 'member_working_in', type: 'select', option: '0:Indonesia|1:Luar Negeri'},
                    {display: 'Rata-rata Penghasilan', name: 'member_average_income', type:'select', option:'0:< 1jt|1:1jt - 3jt|2:3jt - 5jt|3:5jt - 10jt|4:>10jt'},
                    {display: 'Pendidikan Terakhir', name: 'member_last_education', type:'select', option:'0:Tidak Sekolah|1:SD|2:SLTP|3:SMU/SMK|4:Diploma 1,2,3|5:S1|6:S2|7:S3'},
                    {display: 'Agama', name: 'member_religion', type:'select', option:'0:Islam|1:Kristen|2:Katolik|3:Hindu|4:Budha|5:Kong Hu Cu|6:Aliran Kepercayaan|7:Lainnya'},
                    {display: 'Suku', name: 'member_ethnic_group', type: 'text'},
                    {display: 'Gol. Darah', name: 'member_blood_type', type: 'select', option: '0:A|1:B|2:AB|3:O'},
                    {display: 'Ukuran Baju', name: 'member_shirt_size', type: 'select', option: '0:S|1:M|2:L|3:XL|4:XXL|5:XXXL'},
                    {display: 'Status Pernikahan', name: 'member_is_married', type:'select', option:'0:Belum Menikah|1:Sudah Menikah'},
                    {display: 'Nama Suami/Istri', name: 'member_husband_wife_name', type:'text'},
                    {display: 'Nama Anak', name: 'member_child_name', type:'text'},
                    {display: 'Nama Ibu Kandung', name: 'member_mother_name', type:'text'},
                    {display: 'Pernah Terdaftar di CU Lain', name: 'member_is_registered_others_cu', type:'text'},
                    {display: 'Nama CU Lain', name: 'member_others_cu_name', type:'text'},
                    {display: 'Nama Ahli Waris', name: 'member_heir_name', type:'text'},
                    {display: 'Status Ahli Waris', name: 'member_heir_status', type:'text'},
                    {display: 'Waktu Daftar', name: 'member_join_datetime', type:'date'},
                    {display: 'Nama Administrator Input', name: 'member_input_admin_name', type:'text'},
                    {display: 'Waktu Administrator Input', name: 'member_input_datetime', type:'date'},
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
             $("#gridview-bukan").flexOptions({
                url: siteUrl + 'report/member/get_data',
                params: [{name: "member_status", value: 'bukan'}],
            }).flexClearReload();
        }
    }
    
    function myExport(com, grid, urlaction){
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

        let $form = $("<form target='_blank' method='post' action='" + urlaction + "'></form>");
        $form.append("<input type='hidden' name='column[name]' value='" + JSON.stringify(arr_column_name) + "' />");
        $form.append("<input type='hidden' name='column[title]' value='" + JSON.stringify(arr_column_title) + "' />");
        $form.append("<input type='hidden' name='column[show]' value='" + JSON.stringify(arr_column_show) + "' />");
        $form.append("<input type='hidden' name='column[align]' value='" + JSON.stringify(arr_column_align) + "' />");
        $form.append("<input type='hidden' name='sortname' value='" + sortname + "' />");
        $form.append("<input type='hidden' name='sortorder' value='" + sortorder + "' />");
        $form.append("<input type='hidden' name='query' value='" + query + "' />");
        $form.append("<input type='hidden' name='querys' value='" + querys + "' />");
        $form.append("<input type='hidden' name='optionused' value='" + optionused + "' />");
        $form.append("<input type='hidden' name='option' value='" + option + "' />");
        $form.append("<input type='hidden' name='date_start' value='" + date_start + "' />");
        $form.append("<input type='hidden' name='date_end' value='" + date_end + "' />");
        $form.append("<input type='hidden' name='qtype' value='" + qtype + "' />");
        $form.append("<input type='hidden' name='total_data' value='" + total_data + "' />");
        $form.append("<input type='hidden' name='rp' value='" + rp + "' />");
        $form.append("<input type='hidden' name='page' value='" + page + "' />");
        let urlLocation = new URL(window.location);
        let params = new URLSearchParams(urlLocation.search);
        let memberStatus = '';
        if(params.get('page') != null){
            memberStatus = params.get('page');
        }else{
            memberStatus = 'member';
        }
        $form.append("<input type='hidden' name='member_status' value='" + memberStatus + "' />");
        $(grid).after($form);
        $form.submit();
    }
    
</script>
<style>
    .table-like-flexigrid {
        font-family: verdana, tahoma, Arial, Helvetica, sans-serif;
        font-size: 11px;
        color: #222;
    }

    .table-like-flexigrid thead tr {
        background: #fafafa url(<?php echo site_url('addons/flexigrid/css/images/fhbg.gif'); ?>) repeat-x bottom;
        border: 1px solid #ccc;
        border-bottom: none;
    }

    .table-like-flexigrid thead tr th {
        border-right: 1px solid #ccc;
        padding: 5px;
        padding-left: 5px;
        padding-right: 5px;
        font-weight: normal;
    }

    .table-like-flexigrid thead tr.first th {
        background: #fafafa url(<?php echo site_url('addons/flexigrid/css/images/bg.gif'); ?>) repeat-x top;
        height: 29px;
        border-bottom: 0px;
        padding: 0px;
        padding-left: 2px;
        padding-right: 2px;
    }

    .table-like-flexigrid tfoot tr th {
        border-right: 1px solid #ccc;
        padding: 5px;
        padding-left: 5px;
        padding-right: 5px;
        font-weight: normal;
    }

    .table-like-flexigrid tfoot tr {
        background: #fafafa url(<?php echo site_url('addons/flexigrid/css/images/fhbg.gif'); ?>) repeat-x bottom;
        border: 1px solid #ccc;
        border-top: none;
        border-bottom: none;
    }

    .table-like-flexigrid tbody tr {
        border: 1px solid #ccc;
        height: 26px;
    }

    .table-like-flexigrid tbody tr td {
        border: 1px solid #ccc;
        padding-left: 5px;
        padding-right: 5px;
    }

    .table-like-flexigrid tbody tr td.have-input {
        padding-left: 2px;
        padding-right: 2px;
    }

    .table-like-flexigrid tbody tr td input {
        padding-left: 5px;
        padding-right: 5px;
    }

    .table-like-flexigrid .fbutton .add {
        background: url(<?php echo site_url('addons/flexigrid/button/images/add.png'); ?>) no-repeat scroll left center transparent;
    }

    .table-like-flexigrid .fbutton .list {
        background: url(<?php echo site_url('addons/flexigrid/button/images/list.png'); ?>) no-repeat scroll left center transparent;
    }

    .table-like-flexigrid .fbutton .accounting {
        background: url(<?php echo site_url('addons/flexigrid/button/images/accounting.png'); ?>) no-repeat scroll left center transparent;
    }

    .table-like-flexigrid .fbutton .selectall {
        background: url(<?php echo site_url('addons/flexigrid/button/images/check-all.png'); ?>) no-repeat scroll left center transparent;
    }

    .table-like-flexigrid .fbutton .unselectall {
        background: url(<?php echo site_url('addons/flexigrid/button/images/check-none.png'); ?>) no-repeat scroll left center transparent;
    }

    .table-like-flexigrid .btn-action-right {
        float: right;
    }

    .table-like-flexigrid .fbutton {
        background: transparent;
        float: left;
        display: block;
        cursor: pointer;
        padding: 3px;
        border: 1px solid transparent;
    }

    .table-like-flexigrid .fbutton:hover {
        border: 1px solid #ccc;
    }

    .table-like-flexigrid .fbutton span {
        padding: 3px;
        padding-left: 20px;
    }

    .table-like-flexigrid .fbuttonseparator {
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
            <li class="active"><a data-toggle="tab" href="#tab-not-yet">Belum Lunas</a></li>
            <li><a data-toggle="tab" href="#tab-already">Sudah Lunas</a></li>
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

<!-- Modal payment-->
<div id="modal-payment" class="modal" role="dialog" style="overflow-y: hidden">
    <div class="custom-loading"><span></span></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Pembayaran Anggota Baru <span id="title-member"></span></h4>
            </div>
            <form id="form-payment" class="form-horizontal form-label-left" data-url="">
                <div class="modal-body" style="overflow-y: auto; max-height: calc(100vh - 200px)">
                    <input type="hidden" name="member_id" id="payment-member-id" value="0">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table-like-flexigrid" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 40%;">Jenis Biaya</th>
                                        <th style="width: 15%; text-align: right;">Biaya (Rp)</th>
                                        <th style="width: 15%; text-align: right;">Terbayar (Rp)</th>
                                        <th style="width: 15%; text-align: right;">Belum Terbayar (Rp)</th>
                                        <th style="width: 15%; text-align: center;">Status Pembayaran</th>
                                    </tr>
                                </thead>
                            </table>
                            <div>
                                <table id="table-body" class="table-like-flexigrid" style="width: 100%;">
                                    <tbody></tbody>
                                </table>
                            </div>
                            <table class="table-like-flexigrid" style="width: 100%;">
                                <tfoot>
                                    <tr>
                                        <th style="width: 40%; text-align: right; font-weight: bold;"> TOTAL</th>
                                        <th style="width: 15%; text-align: right; font-weight: bold;" id="total-biaya">0</th>
                                        <th style="width: 15%; text-align: right; font-weight: bold;" id="total-paid">0</th>
                                        <th style="width: 15%; text-align: right; font-weight: bold;" id="total-unpaid">0</th>
                                        <th style="width: 15%;"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel" style="margin-top: 20px;">
                                <div class="x_title">
                                    <h2>Form Pembayaran Uang Pangkal</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div id="modal-response-message-payment" class="alert alert-danger alert-dismissible fade in" style="display:none"></div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-12" for="payment-date">Tanggal Pembayaran <span class="required">*</span>
                                            </label>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <input type="text" name="date" id="payment-date" class="form-control input-sm" placeholder="dd/mm/yyyy" readonly="readonly" style="background-color: #fff;" value="" data-validation="required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="container-payment"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="pull-left" style="font-size: 18px; font-weight: bold;">Total Pembayaran: Rp. <span id="total-payment"></span></span>
                    <button type="submit" class="btn btn-primary" id="btn-submit"><i class="fa fa-check"></i>&nbsp; Proses Pembayaran</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end Modal payment-->

<!--form validator-->
<script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

<!--MASK MONEY-->
<script src="<?php echo THEMES_BACKEND; ?>/js/jquery.maskMoney.min.js"></script>

<script>
    var siteUrl = '<?php echo site_url(); ?>';
    var menuName = '<?php echo $this->index_menu !== '' ? $this->arr_menu[$this->index_menu]->administrator_menu_title : '' ?>';
    let gridNotYet, gridAlready;

    function payEntranceFee(com, grid, urlaction) {
        let grid_id = $(grid).attr('id');
        grid_id = grid_id.substring(grid_id.lastIndexOf('grid_') + 5);

        if ($('.trSelected', grid).length > 0) {
            let id = $('.trSelected', grid).attr('data-id');
            let code = $(`#${grid_id}_row_${id} td[abbr="member_code"] span`).text();
            let name = $(`#${grid_id}_row_${id} td[abbr="member_name"] span`).text();
            $("#form-payment").attr('data-url', siteUrl + 'transaction/entrance_fee/act_add');
            $("#title-member").text(`(${code}) ${name}`);
            $('#payment-member-id').val(id);
            ajaxRequest('common/general/transaction/entrance_fee/get_data_by_member', 'GET', {
                member_id: id
            }, function(res) {
                if (res.status == 200) {
                    let data = res.data;
                    let html = '';
                    let htmlForm = '';
                    let totalValue = 0;
                    let totalPaid = 0;
                    let totalUnpaid = 0;
                    let totalPayment = 0;
                    if (data.length > 0) {
                        let count = 0;
                        data.forEach(function(item, index) {
                            let strStatus = '';
                            if (item.unpaid == 0) {
                                strStatus = '<span class="label label-success">Lunas</span>';
                            } else if (item.paid == 0) {
                                strStatus = '<span class="label label-danger">Belum Bayar</span>';
                            } else {
                                strStatus = '<span class="label label-warning">Terbayar Sebagian</span>';
                            }
                            html += `<tr>
                                        <td style="width: 40%;">${item.title}</td>
                                        <td style="width: 15%; text-align: right;">${number_format(item.value)}</td>
                                        <td style="width: 15%; text-align: right;">${number_format(item.paid)}</td>
                                        <td style="width: 15%; text-align: right;">${number_format(item.unpaid)}</td>
                                        <td style="width: 15%; text-align: center;">${strStatus}</td>
                                    </tr>`;

                            let alreadyPaid = item.unpaid == 0 ? 1 : 0;

                            if (item.unpaid != 0) {
                                htmlForm += `<div class="form-group">
                                                <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-12">${item.title}</label>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <input tabindex="${count+1}" onkeyup="keyuphandler(this)" type="text" name="${item.name}" data-title="${item.title}" data-type="${item.type}" data-paid="${alreadyPaid}" class="form-control my-curency text-right keyupable" value="${number_format(item.unpaid)}">
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <input tabindex="${count+2}" type="text" id="${item.name}-note" class="form-control" value="" placeholder="Keterangan">
                                                </div>
                                            </div>`;
                                totalPayment = totalPayment + item.unpaid;
                            }
                            count = count + 2;
                            totalValue = item.value + totalValue;
                            totalPaid = item.paid + totalPaid;
                            totalUnpaid = item.unpaid + totalUnpaid;
                        });
                    } else {
                        html += `<tr>
                                    <td colspan="4">Belum ada data.</td>
                                </tr>`;
                    }

                    $('#table-body tbody').html(html);
                    $('#container-payment').html(htmlForm);
                    $('#btn-submit').attr('tabindex', (data.length * 2 + 1));
                    $('#total-payment').text(`${number_format(totalPayment)}`);

                    $('.my-curency').maskMoney({
                        prefix: '',
                        suffix: '',
                        allowNegative: false,
                        thousands: '.',
                        decimal: ',',
                        affixesStay: true,
                        precision: 0,
                        allowZero: true
                    });

                    $('#total-biaya').text(number_format(totalValue));
                    $('#total-paid').text(number_format(totalPaid));
                    $('#total-unpaid').text(number_format(totalUnpaid));

                    $('#payment-date').val(moment().format('DD/MM/YYYY'));

                    $('#modal-payment').modal({
                        backdrop: 'static',
                        keyboard: false
                    }, 'show');
                } else {
                    alert(res.msg);
                }
            });
        } else {
            alert('Anda belum memilih data!');
        }
    }

    async function doPayment() {
        let idMember = $('#payment-member-id').val();

        let isFailed = false;
        let arrNameFailed = [];
        let countField = 0;
        let countZeroValue = 0;
        let $element = $('#form-payment input[name]');
        for (let index = 0; index < $element.length; index++) {
            let name = $($element[index]).attr('name');
            if (name != 'member_id' && name != 'date') {
                countField++;
                console.log($($element[index]).val());
                let value = convertFormatRp($($element[index]).val());
                let title = $($element[index]).attr('data-title');
                let note = $(`#${name}-note`).val();
                let type = $($element[index]).attr('data-type');
                let paid = $($element[index]).attr('data-paid');
                let date = $('#payment-date').val();
                data = {
                    member_id: idMember,
                    name: name,
                    value: value,
                    note: note,
                    date: date
                };

                if (value != 0) {
                    try {
                        let res = await ajaxRequestAwait('transaction/entrance_fee/act_add', 'POST', data);
                        if (res.status != 200 && paid == 0) {
                            isFailed = true;
                            arrNameFailed.push(res.msg.slice(0, 3) + title + ' : ' + res.msg.slice(3));
                        }
                    } catch (err) {
                        isFailed = true;
                        arrNameFailed.push(res.msg.slice(0, 3) + title + ' : ' + res.msg.slice(3));
                    }

                    //                    ajaxRequest('transaction/entrance_fee/act_add', 'POST', data, function (res){
                    //                        if(res.status != 200 && paid == 0){
                    //                            isFailed = true;
                    //                            arrNameFailed.push(res.msg.slice(0, 3) + title + ' : ' + res.msg.slice(3));
                    //                        }
                    //                    }, false);
                } else {
                    countZeroValue++;
                }

            }
        };

        if (countZeroValue == countField) {
            $('#form-payment button[type="submit"]').removeAttr('disabled');
            alert('Anda belum menginputkan nominal yang akan dibayarkan.');
            return false;
        }

        if (isFailed) {
            $('#form-payment button[type="submit"]').removeAttr('disabled');
            $("#modal-response-message-payment").finish();

            $("#modal-response-message-payment").slideDown("fast");
            $('#modal-response-message-payment').html('<p>Data gagal disimpan.</p>' + arrNameFailed.join(''));
            $("#modal-response-message-payment").delay(10000).slideUp(1000);
        } else {
            $('#modal-payment .modal-body').animate({
                scrollTop: '0px'
            }, 300);
            $('#form-payment button[type="submit"]').removeAttr('disabled');
            $('#modal-payment').modal('hide');
            $('#gridview-not-yet').flexReload();
            let message_class = 'response_confirmation alert alert-success';

            $("#response_message").finish();

            $("#response_message").addClass(message_class);
            $("#response_message").slideDown("fast");
            $("#response_message").html('Data berhasil disimpan.');
            $("#response_message").delay(10000).slideUp(1000, function() {
                $("#response_message").removeClass(message_class);
            });
        }
    }

    function keyuphandler() {
        let totalPayment = 0;
        $.each($('#modal-payment .keyupable'), function(index, element) {
            let value = convertFormatRp($(element).val());
            totalPayment = totalPayment + value;
        });
        $('#total-payment').text(number_format(totalPayment));
    }

    $(document).ready(function() {

        $('#modal-payment').on('keyup', '.keyupable', function() {
            let totalPayment = 0;
            $.each($('#modal-payment .keyupable'), function(index, element) {
                let value = convertFormatRp($(element).val());
                totalPayment = totalPayment + value;
            });
            $('#total-payment').text(number_format(totalPayment));
        });
        $("#payment-date").daterangepicker({
            singleDatePicker: true,
            format: 'DD/MM/YYYY',
            showDropdowns: true,
        });

        $('#form-payment').on('submit', function(e) {
            e.preventDefault();
            $('#form-payment button[type="submit"]').attr('disabled', 'disabled');

            doPayment();
        });

        let urlLocation = new URL(window.location);
        let params = new URLSearchParams(urlLocation.search);
        if (params.get('page') != null) {
            if (params.get('page') == 'already') {
                $('#container-tabs a[data-toggle="tab"][href="#tab-already"]').click();
                loadGridAlready();
            }
        } else {
            $('#container-tabs a[data-toggle="tab"][href="#tab-not-yet"]').click();
            loadGridNotYet();
        }

        $('#container-tabs a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
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

    function loadGridNotYet() {
        if (typeof gridNotYet == 'undefined') {
            gridNotYet = $("#gridview-not-yet").flexigrid({
                url: siteUrl + 'transaction/entrance_fee/get_data',
                params: [{
                    name: "member_is_paid",
                    value: 0
                }],
                dataType: 'json',
                colModel: [{
                        display: 'No. Bakal Anggota',
                        name: 'member_temp_code',
                        width: 110,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Nama',
                        name: 'member_name',
                        width: 200,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Status Keanggotaan',
                        name: 'member_status',
                        width: 180,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Uang Pangkal',
                        name: 'member_entrance_fee_paid_off',
                        width: 100,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'No. Identitas',
                        name: 'member_identity_number',
                        width: 150,
                        sortable: true,
                        align: 'center',
                        hide: true
                    },
                    {
                        display: 'Tipe Identitas',
                        name: 'member_identity_type',
                        width: 80,
                        sortable: true,
                        align: 'center',
                        hide: true
                    },
                    {
                        display: 'Jenis Kelamin',
                        name: 'member_gender',
                        width: 80,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Tanggal Lahir',
                        name: 'member_birthdate',
                        width: 180,
                        sortable: true,
                        align: 'center',
                        hide: true
                    },
                    {
                        display: 'Tanggal Diksar',
                        name: 'member_diksar_date',
                        width: 180,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Kewarganegaraan',
                        name: 'member_nationality',
                        width: 110,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Waktu Daftar',
                        name: 'member_join_datetime',
                        width: 200,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Nama Administrator Input',
                        name: 'member_input_admin_name',
                        width: 200,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Waktu Administrator Input',
                        name: 'member_input_datetime',
                        width: 100,
                        sortable: true,
                        align: 'center',
                        hide: true
                    },
                    {
                        display: 'Cabang',
                        name: 'branch_name',
                        width: 150,
                        sortable: true,
                        align: 'left'
                    },
                ],
                buttons: [
                    <?php
                    if (privilege_view('add', $this->menu_privilege)) :
                        echo "{display: 'Bayar Aggota Baru', name: 'payment', bclass: 'accounting', onpress: payEntranceFee},";
                    endif;
                    ?>
                ],
                buttons_right: [
                    <?php
                    if (privilege_view('export', $this->menu_privilege)) :
                        echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("transaction/entrance_fee/export_data_not_yet_paid") . "'}";
                    endif;
                    ?>
                ],
                searchitems: [{
                        display: 'Cabang',
                        name: 'branch_name',
                        type: 'text'
                    },
                    {
                        display: 'No. Bakal Anggota',
                        name: 'member_temp_code',
                        type: 'text'
                    },
                    {
                        display: 'Nama',
                        name: 'member_name',
                        type: 'text'
                    },
                    {
                        display: 'No. Identitas',
                        name: 'member_identity_number',
                        type: 'text'
                    },
                    {
                        display: 'Tipe Identitas',
                        name: 'member_identity_type',
                        type: 'select',
                        option: '0:KTP|1:SIM|2:KK'
                    },
                    {
                        display: 'Jenis Kelamin',
                        name: 'member_gender',
                        type: 'select',
                        option: '0:Pria|1:Wanita'
                    },
                    {
                        display: 'Tanggal Lahir',
                        name: 'member_birthdate',
                        type: 'text'
                    },
                    {
                        display: 'Status Keanggotaan',
                        name: 'member_status',
                        type: 'select',
                        option: '0:Anggota Koperasi|1:Anggota Luar Biasa Dewasa|2:Anggota Luar Biasa Anak|3:Calon Anggota Dewasa|4:Calon Anggota Anak'
                    },
                    {
                        display: 'Tanggal Diksar',
                        name: 'member_diksar_date',
                        type: 'date'
                    },
                    {
                        display: 'Kewarganegaraan',
                        name: 'member_nationality',
                        type: 'select',
                        option: '0:WNI|1:WNA'
                    },
                    {
                        display: 'Uang Pangkal',
                        name: 'member_entrance_fee_paid_off',
                        type: 'select',
                        option: '0:Belum Lunas|1:Lunas'
                    },
                    {
                        display: 'Waktu Daftar',
                        name: 'member_join_datetime',
                        type: 'date'
                    },
                    {
                        display: 'Nama Administrator Input',
                        name: 'member_input_admin_name',
                        type: 'text'
                    },
                    {
                        display: 'Waktu Administrator Input',
                        name: 'member_input_datetime',
                        type: 'date'
                    },
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
        } else {
            $("#gridview-not-yet").flexOptions({
                url: siteUrl + 'transaction/entrance_fee/get_data',
                params: [{
                    name: "member_is_paid",
                    value: 0
                }],
            }).flexClearReload();
        }
    }

    function loadGridAlready() {
        if (typeof gridAlready == 'undefined') {
            gridAlready = $("#gridview-already").flexigrid({
                url: siteUrl + 'transaction/entrance_fee/get_data',
                params: [{
                    name: "member_is_paid",
                    value: 1
                }],
                dataType: 'json',
                colModel: [{
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
                        display: 'Nama',
                        name: 'member_name',
                        width: 200,
                        sortable: true,
                        align: 'left'
                    },
                    {
                        display: 'Status Keanggotaan',
                        name: 'member_status',
                        width: 180,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Uang Pangkal',
                        name: 'member_entrance_fee_paid_off',
                        width: 100,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'No. Identitas',
                        name: 'member_identity_number',
                        width: 150,
                        sortable: true,
                        align: 'center',
                        hide: true
                    },
                    {
                        display: 'Tipe Identitas',
                        name: 'member_identity_type',
                        width: 80,
                        sortable: true,
                        align: 'center',
                        hide: true
                    },
                    {
                        display: 'Jenis Kelamin',
                        name: 'member_gender',
                        width: 80,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Tanggal Lahir',
                        name: 'member_birthdate',
                        width: 180,
                        sortable: true,
                        align: 'center',
                        hide: true
                    },
                    {
                        display: 'Tanggal Diksar',
                        name: 'member_diksar_date',
                        width: 180,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Kewarganegaraan',
                        name: 'member_nationality',
                        width: 110,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Waktu Daftar',
                        name: 'member_join_datetime',
                        width: 200,
                        sortable: true,
                        align: 'center'
                    },
                    {
                        display: 'Nama Administrator Input',
                        name: 'member_input_admin_name',
                        width: 200,
                        sortable: true,
                        align: 'left',
                        hide: true
                    },
                    {
                        display: 'Waktu Administrator Input',
                        name: 'member_input_datetime',
                        width: 100,
                        sortable: true,
                        align: 'center',
                        hide: true
                    },
                    {
                        display: 'Unit',
                        name: 'branch_name',
                        width: 150,
                        sortable: true,
                        align: 'left'
                    },
                ],
                buttons_right: [
                    <?php
                    if (privilege_view('export', $this->menu_privilege)) :
                        echo "{display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '" . site_url("transaction/entrance_fee/export_data_already_paid") . "'}";
                    endif;
                    ?>
                ],
                searchitems: [{
                        display: 'Unit',
                        name: 'branch_name',
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
                        display: 'Nama',
                        name: 'member_name',
                        type: 'text'
                    },
                    {
                        display: 'No. Identitas',
                        name: 'member_identity_number',
                        type: 'text'
                    },
                    {
                        display: 'Tipe Identitas',
                        name: 'member_identity_type',
                        type: 'select',
                        option: '0:KTP|1:SIM|2:KK'
                    },
                    {
                        display: 'Jenis Kelamin',
                        name: 'member_gender',
                        type: 'select',
                        option: '0:Pria|1:Wanita'
                    },
                    {
                        display: 'Tanggal Lahir',
                        name: 'member_birthdate',
                        type: 'text'
                    },
                    {
                        display: 'Status Keanggotaan',
                        name: 'member_status',
                        type: 'select',
                        option: '0:Anggota Koperasi|1:Anggota Luar Biasa Dewasa|2:Anggota Luar Biasa Anak|3:Calon Anggota Dewasa|4:Calon Anggota Anak'
                    },
                    {
                        display: 'Tanggal Diksar',
                        name: 'member_diksar_date',
                        type: 'date'
                    },
                    {
                        display: 'Kewarganegaraan',
                        name: 'member_nationality',
                        type: 'select',
                        option: '0:WNI|1:WNA'
                    },
                    {
                        display: 'Uang Pangkal',
                        name: 'member_entrance_fee_paid_off',
                        type: 'select',
                        option: '0:Belum Lunas|1:Lunas'
                    },
                    {
                        display: 'Waktu Daftar',
                        name: 'member_join_datetime',
                        type: 'date'
                    },
                    {
                        display: 'Nama Administrator Input',
                        name: 'member_input_admin_name',
                        type: 'text'
                    },
                    {
                        display: 'Waktu Administrator Input',
                        name: 'member_input_datetime',
                        type: 'date'
                    },
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
        } else {
            $("#gridview-already").flexOptions({
                url: siteUrl + 'transaction/entrance_fee/get_data',
                params: [{
                    name: "member_is_paid",
                    value: 1
                }],
            }).flexClearReload();
        }
    }

    // function generate select2
    function generateSelect2(element = '.select2', data = [], nameValue, nameText, selectedValue = false, selectedName = '', placeHolder = false, placeHolderValue = '') {
        let option = placeHolder === false ? '' : `<option value="${placeHolderValue}">${placeHolder}</option>`;
        data.forEach(function(item, index) {
            let strSelected = '';
            if (selectedValue !== false) {
                if (item[selectedName] == selectedValue) {
                    strSelected = `selected="selected"`;
                }
            }
            option += `<option value="${item[nameValue]}" ${strSelected}>${item[nameText]}</option>`;
        });
        $(element).html(option).select2();
        return $(element);
    }

    // function request with ajax
    function ajaxRequest(url, method = 'GET', data = '', callback, async = true) {
        $.ajax({
            async: async,
            url: siteUrl + url,
            method: method,
            data: data,
            dataType: 'json',
            success: function(res) {
                callback(res);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                let res = {
                    status: 400,
                    msg: 'Gagal mendapatkan data.'
                }
                callback(res);
            }
        });
    }

    // for request data with ajax for async/await
    function ajaxRequestAwait(url, method = 'GET', data = '') {
        return $.ajax({
            url: siteUrl + url,
            method: method,
            data: data,
            dataType: 'json'
        });
    }

    // for set number format
    function number_format(number = 0, decimals = 0, decPoint = ',', thousandsSep = '.') {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        let n = !isFinite(+number) ? 0 : +number;
        let prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
        let sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep;
        let dec = (typeof decPoint === 'undefined') ? '.' : decPoint;
        let s = '';

        let toFixedFix = function(n, prec) {
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

    // for convert format Rp in integer
    function convertFormatRp(currency) {
        let value = currency.replace('Rp. ', '');
        return parseInt(value.replace(/\./g, ''));
    }

    $('.currency').maskMoney({
        prefix: 'Rp. ',
        suffix: '',
        allowNegative: false,
        thousands: '.',
        decimal: ',',
        affixesStay: true,
        precision: 0,
        allowZero: true
    });

    $.validate({
        lang: 'id',
        onError: function() {
            $('.modal .modal-body').animate({
                scrollTop: '0px'
            }, 300);
        }
    });
</script>
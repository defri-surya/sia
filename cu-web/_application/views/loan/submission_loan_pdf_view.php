<table width="100%">
    <tr>
        <td width="20%" style="text-align: center;">
            <?php
            $dir = 'themes/backend/gentelella/images/' . CONFIG_SITE['logo_login'];
            if (@file_exists($dir)) {
                ?>
                <img src="<?php echo $dir; ?>" style="height: 50px;" /> 
                <?php
            } else {
                echo '<div style="font-size:18pt">Logo</div>';
            }
            ?>
        </td>
        <td width="60%">
            <table width="100%">
                <tr>
                    <td style="font-size:14pt;font-weight: bold; text-align: center;">KOPDIT KOSAYU</td>
                </tr>
                <tr>
                    <td style="font-size:8pt; text-align: center;">Jl. Candi Kalasan No. 3 Malang Jawa Timur 65125</td>
                </tr>
                <tr>
                    <td style="font-size:8pt; text-align: center;">Tlp. (0341) 491567 Fax. (0341) 418957 info@kopditkosayu.co.id</td>
                </tr>
            </table>
        </td>
        <td width="20%" style="text-align: center;"></td>
    </tr>
    <tr>
        <td colspan="3" style="border-bottom: solid 1px #222; font-size:2pt;"></td>
    </tr>

    <!-- Jarak -->
    <tr>
        <td colspan="3">
            <br>
        </td>
    </tr>

    <!-- Keterangan Anggota -->
    <tr>
        <td colspan="3">
            <table width="99%" style="font-size:8pt;">
                <tr><td><label><strong>Informasi Anggota : </strong></label></td></tr>
                <tr>
                    <td width="50%">
                        <table width="100%">
                            <tr>
                                <td valign="top" width="30%">Nama</td>
                                <td valign="top" align="center" width="5%">:</td>
                                <td valign="top" width="55%"><?php echo $detail->member_name; ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Identitas</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo IDENTITY_TYPE[$detail->member_identity_type] . " (" . $detail->member_identity_number . ")"; ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Jenis Kelamin</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo GENDER[$detail->member_gender]; ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Tempat, Tgl Lahir</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo $detail->member_birthplace . ", " . convert_date($detail->member_birthdate, 'id'); ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Kewarganegaraan</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo NATIONALITY[$detail->member_nationality]; ?></td>
                            </tr>
                            <?php
                                $member_domicile_address = (!empty($detail->member_address_domicile)) ? $detail->member_address_domicile : '';
                                $member_domicile_address .= (!empty($detail->member_province_name)) ? ' ' . $detail->member_kelurahan_name . ', ' . $detail->member_subdistrict_name . ', ' . $detail->member_city_name . ', ' . $detail->member_province_name : '';
                                $member_domicile_address .= (!empty($detail->member_zip_code)) ? ' ' . $detail->member_zip_code : '';
                            ?>
                            <tr>
                                <td valign="top">Alamat</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo $member_domicile_address; ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Status Tempat Tinggal</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo RESIDENCE_STATUS[$detail->member_residence_status]; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%">
                        <table width="100%">
                            <tr>
                                <td valign="top" width="30%">No. Handphone</td>
                                <td valign="top" align="center" width="5%">:</td>
                                <td valign="top" width="65%"><?php echo $detail->member_mobilephone_number; ?></td>
                            </tr>
                            <tr>
                                <td valign="top">No. Telepon</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo $detail->member_phone_number; ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Pekerjaan</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo !empty($detail->member_job) ? $detail->member_job : "-"; ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Bekerja di</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo WORKING_IN[$detail->member_working_in]; ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Penghasilan Rata2</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo AVERAGE_INCOME[$detail->member_average_income]; ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Pendidikan Terakhir</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo LAST_EDUCATION[$detail->member_last_education]; ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Status Pernikahan</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo IS_MARRIED[$detail->member_is_married]; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
    <!-- Jarak -->
    <tr style="font-size:5pt;">
        <td colspan="3">
            <br>
        </td>
    </tr>
    
    <!-- Jarak -->
    <tr style="font-size:5pt;">
        <td colspan="3">
            <br>
        </td>
    </tr>
    
    <!-- Jarak -->
    <tr style="font-size:5pt;">
        <td colspan="3">
            <br>
        </td>
    </tr>
    
    <!-- Keterangan Pinjaman -->
    <tr>
        <td colspan="3">
            <table width="99%" style="font-size:8pt;">
                <tr><td><label><strong>Informasi Pinjaman : </strong></label></td></tr>
                <tr>
                    <td width="50%">
                        <table width="100%">
                            <tr>
                                <td valign="top" width="18%">Nama Produk</td>
                                <td valign="top" align="center" width="5%">:</td>
                                <td valign="top" width="80%"><?php echo $detail->product_loan_name . " (" . $detail->product_loan_name_alias . ")"; ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Kode Produk</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo $detail->product_loan_code; ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Bunga</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo number_format($detail->product_loan_interest_percent, 2, ',', '.'); ?> %</td>
                            </tr>
                            <tr>
                                <td valign="top">Denda</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo number_format($detail->product_loan_forfeit_percent, 2, ',', '.'); ?> %</td>
                            </tr>
                            <?php $arr_interest_type = array('Flat/Tetap', 'Efektif/Menurun'); ?>
                            <tr>
                                <td valign="top">Jenis Bunga</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo $arr_interest_type[$detail->product_loan_interest_type]; ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Pinalty</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo number_format($detail->product_loan_pinalty_fee_percent, 2, ',', '.'); ?> %</td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%">
                        <table width="100%">
                            <tr>
                                <td valign="top" width="35%">Plafon</td>
                                <td valign="top" align="center" width="5%">:</td>
                                <td valign="top" width="60%"><?php echo number_format($detail->submission_product_loan_plafon, 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Tenor</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo number_format($detail->submission_product_loan_tenor, 0, ',', '.') . " Bulan"; ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Bunga Pinjaman</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo number_format($detail->submission_product_loan_interest_percent, 2, ',', '.'); ?> %</td>
                            </tr>
                            <tr>
                                <td valign="top">Jenis Jaminan</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo $detail->submission_product_loan_collateral_type; ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Total Nilai Jaminan</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo number_format($detail->submission_product_loan_collateral_value, 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Deskripsi Jaminan</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo $detail->submission_product_loan_collateral_description; ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Tanggal Kebutuhan Cair</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo convert_date($detail->submission_product_loan_disbursement_date, 'id'); ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Catatan</td>
                                <td valign="top" align="center">:</td>
                                <td valign="top"><?php echo $detail->submission_product_loan_note; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
    <!-- Jarak -->
    <tr style="font-size:5pt;">
        <td colspan="3">
            <br>
        </td>
    </tr>

    <!-- Jarak -->
    <tr style="font-size:5pt;">
        <td colspan="3">
            <br>
        </td>
    </tr>

    <!-- Jarak -->
    <tr style="font-size:5pt;">
        <td colspan="3">
            <br>
        </td>
    </tr>
    
    <!-- Persyaratan -->
    <tr>
        <td colspan="3">
            <table width="99%" style="font-size:8pt;" >
                <tr><td><label><strong>Persyaratan : </strong></label></td></tr>
                <tr>
                    <td width="50%">
                        <table width="100%">
                            <tr>
                                <td valign="top" width="4%"><table border="1"><tr><td align="center">V</td></tr></table></td>
                                <td valign="top" width="2%"></td>
                                <td valign="top" width="90%">Menjadi anggota penuh</td>
                            </tr>
                            <tr>
                                <td valign="top" width="4%"><table border="1"><tr><td align="center">V</td></tr></table></td>
                                <td valign="top" width="2%"></td>
                                <td valign="top">Mengikuti Diksar</td>
                            </tr>
                            <tr>
                                <td valign="top" width="4%"><table border="1"><tr><td align="center">V</td></tr></table></td>
                                <td valign="top" width="2%"></td>
                                <td valign="top">Usia minimal 21 tahun / sudah menikah / berpenghasilan *salah satu</td>
                            </tr>
                            <tr>
                                <td valign="top" width="4%"><table border="1"><tr><td align="center">V</td></tr></table></td>
                                <td valign="top" width="2%"></td>
                                <td valign="top">Usia maksimal 69 tahun pada saat jatuh tempo pinjaman</td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%">
                        <table width="100%">
                            <tr>
                                <td valign="top" width="4%"><table border="1"><tr><td></td></tr></table></td>
                                <td valign="top" width="2%"></td>
                                <td valign="top" width="90%">WNI cakap hukum</td>
                            </tr>
                            <tr>
                                <td valign="top" width="4%"><table border="1"><tr><td></td></tr></table></td>
                                <td valign="top" width="2%"></td>
                                <td valign="top">Sudah memiliki tabungan aset</td>
                            </tr>
                            <tr>
                                <td valign="top" width="4%"><table border="1"><tr><td></td></tr></table></td>
                                <td valign="top" width="2%"></td>
                                <td valign="top">Menyerahkan FC KTP & KK yang masih berlaku (termasuk suami/istri calon debitur *jika ada)</td>
                            </tr>
                            <tr>
                                <td valign="top" width="4%"><table border="1"><tr><td></td></tr></table></td>
                                <td valign="top" width="2%"></td>
                                <td valign="top">Mengisi Surat Permohonan Pinjaman</td>
                            </tr>
                            <tr>
                                <td valign="top" width="4%"><table border="1"><tr><td></td></tr></table></td>
                                <td valign="top" width="2%"></td>
                                <td valign="top">Surat Keterangan Izin Usaha (SIUP, TDP, Surat Izin Trayek, dll) *jika ada</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
    <!-- Jarak -->
    <tr style="font-size:5pt;">
        <td colspan="3">
            <br>
        </td>
    </tr>

    <!-- Jarak -->
    <tr style="font-size:5pt;">
        <td colspan="3">
            <br>
        </td>
    </tr>

    <!-- Jarak -->
    <tr style="font-size:5pt;">
        <td colspan="3">
            <br>
        </td>
    </tr>
    
    <!-- Catatan -->
    <tr>
        <td colspan="3">
            <table width="99%" style="font-size:8pt;">
                <tr><td><label><strong>Catatan Surveyor : </strong></label></td></tr>
                <tr>
                    <td width="80%" border="1">
                        <br><br><br><br><br><br><br><br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Jarak -->
    <tr style="font-size:5pt;">
        <td colspan="3">
            <br>
        </td>
    </tr>

    <!-- Jarak -->
    <tr style="font-size:5pt;">
        <td colspan="3">
            <br>
        </td>
    </tr>

    <!-- Jarak -->
    <tr style="font-size:8pt;">
        <td colspan="3">
            <br><br><br><br>
        </td>
    </tr>

    <tr style="font-size:8pt;">
        <td colspan="3">
            <table width="100%" style="font-size:8pt;">
                <tr>
                    <td width="10%"></td>
                    <td width="30%" align="center">Mengetahui,</td>
                    <td width="20%"></td>
                    <td width="30%" align="center">Surveyor,</td>
                    <td width="10%"></td>
                </tr>
                <!-- Jarak -->
                <tr>
                    <td>
                        <br />
                        <br />
                        <br />
                        <br />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center">( ................................................. )</td>
                    <td></td>
                    <td align="center">( ................................................. )</td>
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
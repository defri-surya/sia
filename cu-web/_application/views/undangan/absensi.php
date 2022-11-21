<?php 
$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetTitle('Daftar Hadir');
            $pdf->SetHeaderMargin(30);
            $pdf->SetTopMargin(0);
            $pdf->setFooterMargin(0);
            $pdf->SetAutoPageBreak(true);
            $pdf->SetAuthor('Author');
            $pdf->SetDisplayMode('real', 'default');
            $pdf->AddPage();
            $i=0;

            $html='

                    <div style="display:block; text-align:center;">
                              <h1><u>CU TYAS MANUNGGAL</u></h1>
                                <p>Ganjuran, Sumbermulyo, Bambanglipuro, Bantul
                                <br>Yogyakarta, Telp 0274-6460450
                                <br>Absensi Undangan Sarasehan, Hari Minggu Tanggal 23 Juni 2019 </p> 
                    </div> 
                    <table cellspacing="2" bgcolor="#666666" cellpadding="5">
                        <tr bgcolor="#ffffff">
                            <th width="5%" align="center">No</th>
                            <th width="30%" align="center">Nama </th>
                            <th width="40%" align="center">Alamat</th>
                            <th width="20%" align="center">Tanda Tangan</th>
                        </tr>';

            foreach ($nama as $name) {
                $i++;
                $html.='<tr bgcolor="#ffffff">
                            <th width="5%" align="center">'.$i.'</th>
                            <th width="30%" align="center">'.$name->name.'</th>
                            <th width="40%" align="center">Jalan. abcdefghijk asasa NO. 12</th>
                            <th width="20%" align="center"></th>
                        </tr>';
            }
            $html.='</table>';
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('daftar_hadir.pdf', 'I');
?>
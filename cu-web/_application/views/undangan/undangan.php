<?php 

$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetTitle('Undangan Diksar');
            $pdf->SetHeaderMargin(35);
            $pdf->SetTopMargin(0);
            $pdf->setFooterMargin(0);
            $pdf->setFontSize(11);
            $pdf->SetAutoPageBreak(true);
            $pdf->SetAuthor('Author');
            $pdf->SetDisplayMode('real', 'default');
            $pdf->AddPage();
            $i=0;
            $html='';
            // $data=cetak_banyak();
            // echo '<pre>';print_r($nama);exit;
            $hal=0; 
            foreach ($nama as $name ) {
                  $hal++;
                  $style='';
                  // echo $hal.'<'.count($nama);exit();
                  if($hal<count($nama)){
                        $style='page-break-after:always';
                  }
            // }($i=0; $i<3; $i++){

            $html.='
            <div style="'.$style.'">
                        <div style="display:block; text-align:center;">
                              <h1><u>CU TYAS MANUNGGAL</u></h1>
                                Alamat : Ganjuran, Sumbermulyo, Bambanglipuro, Bantul
                                <br>Yogyakarta, Telp 0274-6460450
                                <br>Nomor Badan Hukum : 144/BH/XV.I/V/2011, Tgl: 01-01-2008 
                        </div> 
                          
                          <br>
                          <h4>Nomor :
                          <br>Hal   : Undangan Sarasehan
                          <br>Lampiran : -
                        <br>
                        <br>
                        <br>Kepada Yth.
                        <br>Sdr/i. '.$name->name.'
                        <br>A.000.000 
                        <br>RT. 00 , baros, Tirtohargo, kretek, Bantul, Yogyakarta </h4>
                  
                        <p>Dengan Hormat,
                        <br>Dengan ini kami mengundang Bpk/Ibu/Sdr/I penabung aktif, untuk menghadiri Pendidikan Dasar Calon Anggota CU TYAS MANUNGGAL yang akan diadakan pada Tanggal:
                          
                          <br>
                            
                            <br> Hari   : Minggu,23 Juni 2019
                            <br> Jam    : 10.00 WIB
                            <br> Tempat : Rumah Bpk FX. Suminto
                            <br> Acara  : Sarasehan Calon Anggota CU TYAS MANUNGGAL
                      <br> 
                  
                        <br>mengingat penting dan manfaatnya acara ini, kami mohon dengan sangat kehadiran Bpk/Ibu/Sdr/i dalam acara Tersebut. Atas Perhatianya dan kerjasamanya yang baik, kami ucapkan terima kasih.</P>

                        <div style="display:block; text-align:right;">
                              <p>CU TYAS MANUNGGAL
                              <br>Bantul, 20 Juni 2019</p>
                              <br>
                              <br>
                              <p>Pelaksana</p>
                        </div>

                   <p>catatan:<br> -Keterlambatan Maksimal 15 Menit, lebih dari itu di ikut sertakan pada diksar berikutnya</p> 
            </div>  ';
         
         }
            // echo($html);exit;
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('Undangan Diksar.pdf', 'I');
?>
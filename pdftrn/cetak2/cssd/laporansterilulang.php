<?php
ob_start();
include('../connect2.php');

// header("Content-type: application/vnd-ms-excel");
// header("Content-Disposition: attachment; filename=laporan_sterilulang.xls");


$tahun = $_POST['tahun'];
$bulan = $_POST['bulan'];
$sqlitem="SELECT 
a.id,
    a.created_konfirmasi_at,
    g.userlevelname as ruang,
    b.nama_alat AS instrumen,
    a.jumlah,
    c.pd_nickname AS pengantar,
    d.pd_nickname AS perawat_jaga,
    e.pd_nickname AS petugas_pengambil,
    f.pd_nickname AS petugas_yg_menyerahkan,
    i.mesin as mesin,
    h.mesin_load as load_mesin,
    a.keterangan
FROM
    simrs2012.t_cssd a
        LEFT JOIN
    simrs2012.m_alat_cssd b ON b.alat_id = a.instrumen
        LEFT JOIN
    simrs.master_login c ON c.uid = a.pengantar
        LEFT JOIN
    simrs.master_login d ON d.uid = a.perawatjaga
    LEFT JOIN
    simrs.master_login e ON e.uid = a.petugas_pengambil
    LEFT JOIN
    simrs.master_login f ON f.uid = a.petugas_yg_menyerahkan
    left join simrs.userlevels g on g.userlevelid = a.ruang
    left join t_cssd_history h on h.idt_cssd = a.id
    LEFT JOIN
    simrs2012.l_mesin_cssd i ON i.id = h.mesin_autoclave
WHERE
    (a.flag = '3' OR a.flag = '4')
        AND year(a.created_konfirmasi_at) = '".$tahun."'
        AND month(a.created_konfirmasi_at) = '".$bulan."'
        and h.status_keberhasilan_sterilisasi = 'TIDAK'";
$queryitem = mysql_query($sqlitem);

?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan STERILISASI ULANG</title>
</head>

<body>
  <table width="100%" style="border:0;" cellpadding="0">
                    <tbody>
                        <tr>
                            <td width="100%" align="center"><span class="header"><strong><b>LAPORAN STERILISASI ULANG
                                        <br>CSSD RSUD AJIBARANG
                                    </b></strong></span></td>
                        </tr>
                        <tr>
                            <td height="20">&nbsp;</td>
                            <td style="text-align:left;" vtext-align="top"></td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>




                    </table>
<table width="100%" cellspacing="0" border="1"  class="penulisan">
  <tbody>
    <tr>
      <td rowspan="2" align="center">No</td>
      <td rowspan="2" align="center">ID</td>
      <td rowspan="2" align="center">WAKTU (JAM/HARI/TANGGAL)</td>
      <td rowspan="2" align="center">RUANG</td>
      <td rowspan="2" align="center">NAMA ALAT/INSTRUMEN YANG DISTERIL</td>
      <td rowspan="2" align="center">MESIN</td>
      <td rowspan="2" align="center">LOAD</td>
      <td rowspan="2" align="center">JUMLAH</td>
      <td colspan="4" align="center">NAMA DAN TANDA TANGAN PETUGAS</td>
      <td rowspan="2" align="center">KET</td>
    </tr>
 
    <tr>
      <td align="center">PENGANTAR</td>
      <td align="center">PERAWAT JAGA</td>
      <td align="center">PENGAMBIL</td>
      <td align="center">PETUGAS CSSD</td>
    </tr>
    
    <?php

		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
    echo '<td>'.$data['id'].'</td>';
      echo '<td>'.$data['created_konfirmasi_at'].'</td>';
			 echo '<td>'.$data['ruang'].'</td>';
       echo '<td>'.$data['instrumen'].'</td>';
       echo '<td>'.$data['mesin'].'</td>';
       echo '<td>'.$data['load_mesin'].'</td>';
       echo '<td>'.$data['jumlah'].'</td>';
       echo '<td>'.$data['pengantar'].'</td>';
       echo '<td>'.$data['perawat_jaga'].'</td>';
       echo '<td>'.$data['petugas_pengambil'].'</td>';
       echo '<td>'.$data['petugas_yg_menyerahkan'].'</td>';
       echo '<td>'.$data['keterangan'].'</td>';
			echo '</tr>';
			
			$no++;
		}
    
	?>
  </tbody>
</table>
</body>
</html>
<?php
ob_start();
include('../connect2.php');

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_register.xls");


$tahun = $_POST['tahun'];
$bulan = $_POST['bulan'];
$sqlitem="SELECT
  a.created_konfirmasi_at AS tanggal,
  f.userlevelname as ruang,
  b.nama_alat AS instrumen,
  a.jumlah,
  a.created_konfirmasi_at AS jam_pengantaran,
  a.jam_masuk_steril AS jam_steril,
  a.jam_selesai_steril AS jam_selesai_steril,
  a.lama_proses_steril,
  a.ks6jam AS kurang,
  a.exp_date_ruang AS ED,
  c.pd_nickname AS petugas_dekontaminasi,
  d.pd_nickname AS petugas_sterilisasi,
  a.dtt,
  d.pd_nickname AS petugas_setpacking,
  g.pd_nickname as petugas_pengering,
  a.keterangan,
  a.status_ed_ruang,
  g.mesin as mesin,
  a.mesin_load,
  ( CASE WHEN a.petugas_dekontaminasi IS NULL THEN 'Tidak' WHEN a.petugas_dekontaminasi = '' THEN 'Tidak' WHEN a.petugas_dekontaminasi != '' THEN 'Ya' END ) AS dekontaminasi,
  ( CASE WHEN a.petugas_sterilisasi IS NULL THEN 'Tidak' WHEN a.petugas_sterilisasi = '' THEN 'Tidak' WHEN a.petugas_sterilisasi != '' THEN 'Ya' END ) AS sterilisasi 
FROM
  t_cssd a
  LEFT JOIN m_alat_cssd b ON b.alat_id = a.instrumen
  LEFT JOIN simrs.master_login c ON c.uid = a.petugas_dekontaminasi
  LEFT JOIN simrs.master_login d ON d.uid = a.petugas_sterilisasi
  LEFT JOIN simrs.master_login e ON e.uid = a.petugas_setpacking
  LEFT JOIN simrs.master_login g on g.uid = a.petugas_pengering
  left join simrs.userlevels f on f.userlevelid = a.ruang
  left join l_mesin_cssd g on g.id = a.mesin_autoclave
WHERE
  ( a.flag = '3' OR a.flag = '4' ) 
  AND year( a.created_konfirmasi_at) = '".$tahun."' 
  AND month( a.created_konfirmasi_at) = '".$bulan."'";
$queryitem = mysql_query($sqlitem);

?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Register</title>
</head>

<body>
  <table width="100%" style="border:0;" cellpadding="0">
                    <tbody>
                        <tr>
                            <td width="100%" align="center"><span class="header"><strong><b>LAPORAN REGISTER CSSD
                                        <br>RSUD AJIBARANG
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
      <td rowspan="2" align="center">Hari/Tgl</td>
      <td rowspan="2" align="center">Nama Ruang</td>
      <td rowspan="2" align="center">Nama Instrumen</td>
      <td rowspan="2" align="center">Jml</td>
      <td rowspan="2" align="center">Mesin</td>
      <td rowspan="2" align="center">Load</td>
      <td rowspan="2" align="center">Jam Pengantaran</td>
      <td rowspan="2" align="center">Jam Steril</td>
      <td rowspan="2" align="center">Jam Selesai Steril</td>
      <td rowspan="2" align="center">Lama Proses Steril</td>
      <td colspan="1" align="center"><= 6 Jam</td>
      <td rowspan="2" align="center">ED</td>
      <td colspan="2" align="center">Dekontaminasi</td>
      <td colspan="2" align="center">Sterilisasi</td>
      <td colspan="1" align="center">DTT</td>
      <td rowspan="2" align="center">Petugas Pengering</td>
      <td rowspan="2" align="center">Petugas Setting Packing</td>
      <td rowspan="2">Ket</td>
    </tr>
 
    <tr>
      <td align="center">Ya/Tdk</td>
      <td>Ya/Tdk</td>
      <td>Petugas</td>
      <td>Ya/Tdk</td>
      <td>Petugas</td>
      <td>Ya/Tdk</td>
    </tr>
    
    <?php

		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
      echo '<td>'.$data['tanggal'].'</td>';
			 echo '<td>'.$data['ruang'].'</td>';
       echo '<td>'.$data['instrumen'].'</td>';
       echo '<td>'.$data['jumlah'].'</td>';
       echo '<td>'.$data['mesin'].'</td>';
       echo '<td>'.$data['mesin_load'].'</td>';
       echo '<td>'.$data['jam_pengantaran'].'</td>';
       echo '<td>'.$data['jam_steril'].'</td>';
       echo '<td>'.$data['jam_selesai_steril'].'</td>';
       echo '<td>'.$data['lama_proses_steril'].'</td>';
       echo '<td>'.$data['kurang'].'</td>';
       echo '<td>'.$data['status_ed_ruang'].'</td>';
       echo '<td>'.$data['dekontaminasi'].'</td>';
       echo '<td>'.$data['petugas_dekontaminasi'].'</td>';
       echo '<td>'.$data['sterilisasi'].'</td>';
       echo '<td>'.$data['petugas_sterilisasi'].'</td>';
       echo '<td>'.$data['dtt'].'</td>';
       echo '<td>'.$data['petugas_pengering'].'</td>';
       echo '<td>'.$data['petugas_setpacking'].'</td>';
       echo '<td>'.$data['keterangan'].'</td>';
			echo '</tr>';

			
			$no++;
		}
    
	?>

  
  </tbody>
</table>
</body>
</html>
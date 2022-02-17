<?php
ob_start();
session_start();
include('connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];

$sqlitem="SELECT 
    date_format(a.tanggal, '%d-%m-%Y %H:%i:%s') as tanggal,
    a.tetesan_infus,
    a.tensi,
    a.nadi,
    a.kontraksi_uterus,
    a.djj,
    a.kemajuan_persalinan,
    b.pd_nickname,
    b.signature_pad
FROM
    simrs.resume_persalinan a
        LEFT JOIN
    simrs.master_login b ON a.username = b.username
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif";
$queryitem = mysql_query($sqlitem);


$sqlidentitas="SELECT 
    a.id_bill_detail_tarif,
	a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
	date_format(b.tgllahir, '%d-%m-%Y') as tgllahir
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs.userlevels f ON a.userlevelid = f.userlevelid
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqlusername="SELECT 
    a.pd_nickname as nama, b.userlevelname
FROM
    master_login a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
WHERE
    a.username = '$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);
 
?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Persalinan</title>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
		font-size: 11px;
	}
	
.tabel {
    border-collapse:collapse;
}	

.isi {
	border-collapse:collapse;
	font-size: 11px;
}
.pagebreak { 
		page-break-before: always;
	}
	.hapushorizontal{
		border-top:none; border-bottom:none;
	}
	

</style>
</head>

<body>
<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="33%"><table width="100%">
        <tbody>
          <tr>
            <td width="23%" align="center"><img src="gambar/logobms.png" height="40px" /></td>
            <td width="77%" align="center" style="font-size: 7px; font-weight: bold" valign="middle">PEMERINTAH KABUPATEN BANYUMAS<br>RUMAH SAKIT UMUM DAERAH AJIBARANG<br>Jl. Raya Pancasan – Ajibarang<br>(0281) 6570004   Fax. (0281) 6570005<br>Email:rsudajibarang@banyumaskab.go.id</td>
          </tr>
        </tbody>
      </table></td>
      <td width="33%" style="font-size: 12px"><p align="center"><strong>LAPORAN<br> PERSALINAN <br> 
          <em>INDUKSI PERSALINAN</em></strong><br>
      <strong></strong></p></td>
      <td width="33%" valign="middle" style="font-weight: bold"><table width="100%" style="font-size: 11px" border="0">
        <tbody>
          <tr>
            <td width="27%">NO RM</td>
            <td width="4%">:</td>
            <td width="69%"><?php echo $DATA_IDENTITAS['nomr']; ?></td>
          </tr>
          <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?php echo $DATA_IDENTITAS['nama']; ?></td>
          </tr>
          <tr>
            <td>Tgl Lahir</td>
            <td>:</td>
            <td><?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>

<br>
<table width="100%" class="tabel" border="1">
  <tr>
    <th width="9%" valign="top">Tanggal Jam</th>
    <th width="9%" valign="top">Tetesan Infus</th>
    <th width="6%" valign="top">Tensi</th>
    <th width="5%" valign="top">Nadi</th>
    <th width="13%" valign="top">Kontraksi Uterus</th>
    <th width="7%" valign="top">DJJ</th>
    <th width="31%" valign="top">Kemajuan Persalinan</th>
    <th width="20%" valign="top">Nama dan Paraf Penolong Persalinan</th>
  </tr>
  <?php
	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="8">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
      			echo '<td valign="top" class="hapushorizontal">'.$data['tanggal'].'</td>';
			echo '<td valign="top" class="hapushorizontal">'.$data['tetesan_infus'].'</td>';
			echo '<td valign="top" class="hapushorizontal">'.$data['tensi'].'</td>';
			echo '<td valign="top" class="hapushorizontal">'.$data['nadi'].'</td>';
			echo '<td valign="top" class="hapushorizontal">'.$data['kontraksi_uterus'].'</td>';
			echo '<td valign="top" class="hapushorizontal">'.$data['djj'].'</td>';
			echo '<td valign="top" class="hapushorizontal">'.$data['kemajuan_persalinan'].'</td>';
			echo '<td valign="top" class="hapushorizontal" style="font-size:10px;">
			<center><img width="40px" height="40px" src="'.$data['signature_pad'].'"/><br>'.$data['pd_nickname'].'</center></td>';
			echo '</tr>';
			
			$no++;
		}
	}
    
	?> 
</table>



</body>
</html>

<?php
 $html = ob_get_clean();
require_once("dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporan_persalinan.pdf',array('Attachment' => 0));
?>

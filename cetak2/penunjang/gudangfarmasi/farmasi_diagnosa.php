<?php
ob_start();
session_start();
include('../../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$icd = $_GET['icd'];

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_diagnosa_".$icd.".xls");


$sqlitemdiagnosa="SELECT 
    b.tglreg,
    b.nomr,
    d.nama,
    d.tgllahir,
    d.alamat,
    d.jeniskelamin,
    a.icd10,
    e.userlevelname,
    d.nama_ibu,
    d.nama_ayah
FROM
    simrs.bill_detail_penyakit a
        LEFT JOIN
    simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.vw_diagnosa_eklaim c ON a.icd10 = c.code
        LEFT JOIN
    simrs2012.m_pasien d ON b.nomr = d.nomr
        LEFT JOIN
    simrs.userlevels e ON b.userlevelid = e.userlevelid
WHERE
    b.tglreg >= '$dari_tanggal'
        AND b.tglreg <= '$sampai_tanggal'
        AND a.icd10 LIKE '%$icd%'
GROUP BY b.nomr";
$querydiagnosa = mysql_query($sqlitemdiagnosa);

$sqlicd="SELECT concat(code,', ',str) as diagnosa FROM simrs2012.vw_diagnosa_eklaim WHERE code='$icd'";
$queryicd = mysql_query($sqlicd);
$DATA_ICD = mysql_fetch_array($queryicd);


?>



<html>
<head>
<meta charset="utf-8">
<title>Laporan Diagnosa</title>
<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 12px;
}
	
.header {
	font-size: 12px;
}	
.footer {
	font-size: 12px;
}

.pagebreak { 
		page-break-before: always;
	}

</style>
</head>

<body>
  <table width="100%" border="0" cellpadding="-3px" cellspacing="0px">
    <tr>
      <td width="10%" rowspan="3" align="right"><img src="../../gambar/logobms.png" height="70px" /></td>
      <td width="90%" align="center" style="font-size: 16px">PEMERINTAH KABUPATEN BANYUMAS</td>
    </tr>
    <tr>
      <td align="center"><strong style="font-size: 21px">RUMAH SAKIT UMUM DAERAH AJIBARANG</strong></td>
    </tr>
    <tr>
      <td align="center" style="font-size: 14px">Jl. Raya Pancasan - Ajibarang, Kode Pos 53163 <br> 
      Telp. (0281) 6570004 Fax. (0281) 6570005 <br> 
      E-mail : rsudajibarang@banyumaskab.go.id</td>
    </tr>
</table>
<hr>

    <div align="center" class="header"><strong>LAPORAN DIAGNOSA</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="15%">Diagnosa</td>
      <td colspan="3">: <?php echo $DATA_ICD['diagnosa']; ?></td>
    </tr>
    <tr>
      <td>Dari Tanggal</td>
      <td width="39%">: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td width="20%" align="right">Sampai Tanggal</td>
      <td width="26%">: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>

<br>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="2%">No.</td>
      <td width="6%">NORM</td>
      <td width="23%">Nama Pasien</td>
      <td width="7%" align="center">Tgl Lahir</td>
      <td width="2%">JK</td>
      <td width="11%">Nama Ortu</td>
      <td width="19%" align="center">Alamat</td>
      <td width="7%" align="center">Tgl Periksa</td>
      <td width="14%" align="center">Hasil Uji TB</td>
      <td width="9%" align="center">Keterangan</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($querydiagnosa)){
			
			$ibu=(($data['nama_ibu'] == '-') ? '' : $data['nama_ibu']);	
			$ayah=(($data['nama_ayah'] == '-') ? '' : $data['nama_ayah']);	
			
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td>'.$data['nomr'].'</td>';
	  echo '<td>'.$data['nama'].'</td>';
	  echo '<td>'.$data['tgllahir'].'</td>';
	  echo '<td align="center">'.$data['jeniskelamin'].'</td>';
	  echo '<td>'.$ayah.' | '.$ibu.'</td>';
			echo '<td>'.$data['alamat'].'</td>';
			echo '<td>'.$data['tglreg'].'</td>';
			echo '<td></td>';
			echo '<td></td>';
			echo '</tr>';
			$no++;
		}
	?>
    
  </tbody>
</table>

</body>
</html>


<?php
 /*$html = ob_get_clean();
require_once("../../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 11.69 * 72);
$dompdf->set_paper($paper_size, 'landscape');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('Laporan Diagnosa.pdf',array('Attachment' => 0));*/
?>
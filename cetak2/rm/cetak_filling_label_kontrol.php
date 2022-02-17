<?php
ob_start();
include('../connect.php');
$tanggal_berobat = $_GET['tanggal_kontrol'];
	
$sqlitem="SELECT 
	b.nomr,
	c.nama,
	a.tanggal_kontrol,
	d.nama AS poli,
	e.namadokter as dpjp
FROM
	simrs.bill_detail_lain a
		LEFT JOIN
	simrs2012.t_pendaftaran b ON a.idxdaftar = b.idxdaftar
		LEFT JOIN
	simrs2012.m_pasien c ON b.nomr = c.nomr
		LEFT JOIN
	simrs2012.m_poly d ON b.kdpoly = d.kode
		LEFT JOIN
	simrs2012.m_dokter e ON b.kddokter = e.kddokter
WHERE
	a.tanggal_kontrol='$tanggal_berobat'";
	$queryitem = mysql_query($sqlitem);
	
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Identitas Pasien</title>

<style>
	@page {
            margin-top: 0.1 cm;
            margin-left: 0.1 cm;
			margin-right: 0.1 cm;
			margin-bottom: 0.1 cm;
		font-size: 8px;
	}
	
	.penulisan{
		font-family: Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial," sans-serif";
		font-size: 9px;
		font-weight: bold;
	}
	
	.pagebreak { 
		page-break-after: always;
		
	}
</style>
</head>

<body>
<?php
$no=1;
while($data=mysql_fetch_assoc($queryitem)){
echo '<table width="100%" class="penulisan" border="0">';
  	echo '<tbody valign="middle">';
			
    echo '<tr>';
      echo '<td width="10%">NOMR</td>';
      echo '<td width="1%">:</td>';
      echo '<td width="80%">'.$data['nomr'].' | KONTROL</td>';
    echo '</tr>';
			
    echo '<tr>';
      echo '<td>NAMA</td>';
      echo '<td>:</td>';
      echo '<td>'.$data['nama'].'</td>';
    echo '</tr>';
			
    echo '<tr>';
      echo '<td>POLI</td>';
      echo '<td>:</td>';
      echo '<td>'.$data['poli'].'  |  '.$data['tanggal_kontrol'].'</td>';
    echo '</tr>';
	echo '<tr>';
      echo '<td>DPJP</td>';
      echo '<td>:</td>';
      echo '<td>'.$data['dpjp'].'</td>';
    echo '</tr>';
	
			
  echo '</tbody>';
echo '</table>';
echo '<div class="pagebreak"> </div>';
}
	?>
</body>

</html>
<?php
$html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 2.36 * 72, 1 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('identitas.pdf',array('Attachment' => 0));
?>
<?php
ob_start();
include('../connect.php');
$dari = $_GET['dari'];
$sampai = $_GET['sampai'];
	
$sqlitem="SELECT a.nomr,
       b.nama,
       DATE_FORMAT(a.tglreg, '%d-%m-%Y') AS tglreg,
       d.nama as poli,e.NAMADOKTER
FROM simrs2012.t_pendaftaran a
     LEFT JOIN simrs2012.m_pasien b ON a.nomr = b.NOMR
     LEFT JOIN simrs2012.m_carabayar c ON a.kdcarabayar = c.kode
     LEFT JOIN simrs2012.m_poly d ON a.kdpoly = d.kode
     LEFT JOIN simrs2012.m_dokter e on a.KDDOKTER=e.KDDOKTER
WHERE a.pasienbaru = 0 AND a.kdrujuk!=5 and
      a.tglreg = CURDATE() AND
      (a.kdpoly = 1 OR
      a.kdpoly = 2 OR
      a.kdpoly = 3 OR
      a.kdpoly = 4 OR
      a.kdpoly = 5 OR
      a.kdpoly = 6 OR
      a.kdpoly = 7 OR
      a.kdpoly = 28 OR
      a.kdpoly = 29 or
      a.kdpoly = 30 or
      a.kdpoly = 31 or
      a.kdpoly = 16 or
      a.kdpoly = 17 or
      a.kdpoly = 12 or
      a.kdpoly = 45 or
	  a.kdpoly = 44 or
	  a.kdpoly = 46 or
      a.kdpoly = 14) limit $dari,$sampai";
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
      echo '<td width="80%">'.$data['nomr'].'</td>';
    echo '</tr>';
			
    echo '<tr>';
      echo '<td>NAMA</td>';
      echo '<td>:</td>';
      echo '<td>'.$data['nama'].'</td>';
    echo '</tr>';
			
    echo '<tr>';
      echo '<td>POLI</td>';
      echo '<td>:</td>';
      echo '<td>'.$data['poli'].'  |  '.$data['tglreg'].'</td>';
    echo '</tr>';
	echo '<tr>';
      echo '<td>DPJP</td>';
      echo '<td>:</td>';
      echo '<td>'.$data['NAMADOKTER'].'</td>';
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
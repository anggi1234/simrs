<?php
ob_start();
session_start();
include('../connect.php');
$userlevelid    = $_GET['userlevelid'];
$kodebayar    	= $_GET['kdcarabayar'];
$dari_tanggal   = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$uid 			= $_GET['uid'];
?>

<html>
<head>
<meta charset="utf-8">
<title>Identitas Pasien</title>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
		font-size: 7px;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}

.tableisi {
  border-collapse: collapse;
  border: 1px solid black;
}
</style>
</head>

<body>

<?php
$whrunit.=($userlevelid)?" and a.userlevelid=$userlevelid":"";
$whruid.=($uid)?" AND e.uid=$uid":"";
$q = mysql_query("SELECT 
    c.userlevelname,
    DATE_FORMAT(a.tglreg, '%d-%m-%Y') AS tglreg,
    b.nama,
    b.tgllahir,
    a.nomr,
    d.nama AS carabayar
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs.userlevels c ON a.userlevelid = c.userlevelid
        LEFT JOIN
    simrs2012.m_carabayar d ON a.kdcarabayar = d.kode
		LEFT JOIN
    simrs.l_carabayar_group y ON d.payor_id = y.payor_id
		LEFT JOIN
    simrs.master_login e ON a.kddokter = e.kddokter
WHERE
    (DATE(a.tanggal) >= '$dari_tanggal'
        AND DATE(a.tanggal) <= '$sampai_tanggal')
        AND c.id_jenis_pelayanan_kasir = 1 $whrunit 
		AND y.payor_id = '$kodebayar' 
		$whruid
		order by a.userlevelid asc");

echo '<table width="100%">';
$nilai = 0;
while($row = mysql_fetch_array($q)){
   // make a new row after 9 games
   if($nilai%3 == 0) {
      if($nilai > 0) {
         // and close the previous row only if it's not the first
         echo '</tr>';
      }
      echo '<tr>';
   }
   // make a new column after 3 games
   if($nilai%1 == 0) {
      if($nilai > 0) {
         // and only close it if it's not the first game
         echo '</td>';
      }
      echo '<td>';
   }

   $nomr = $row['nomr'];
   $poli = $row['userlevelname'];
   $tgl = $row['tglreg'];
   $nama = $row['nama'];
   $tgllahir = $row['tgllahir'];
   $carabayar = $row['carabayar'];
   ?>
 
<?php 
echo '<table class="tableisi" width="100%">
  <tbody>
    <tr>
      <td colspan="2" align="center"><strong>'.$poli.' ('.$carabayar.')</strong></td>
    </tr>
    <tr>
      <td colspan="2" align="center">TGL PELAYANAN: '.$tgl.'</td>
    </tr>
    <tr>
      <td width="24%">NAMA</td>
      <td width="76%">: '.$nama.'</td>
    </tr>
    <tr>
      <td>NO RM</td>
      <td>: '.$nomr.'</td>
    </tr>
    <tr>
      <td>TGLLAHIR</td>
      <td>: '.$tgllahir.'</td>
    </tr>
  </tbody>
</table>';
 ?>  
   
   <br />
   <?php 
   $nilai++; // increment the $nilai element so we know how many games we've already processed
}
?>
</table>



</body>
</html>
<?php
$html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$dompdf->set_paper(DEFAULT_PDF_PAPER_SIZE, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('identitas_pasien.pdf',array('Attachment' => 0));
?>
<?php
ob_start();
include('../connect2.php');


// $userid = $_GET['userid'];
$tanggal = $_GET['tanggal'];
// $sqlitem="SELECT
//   dailyrecords.id,dailyrecords.tanggal,substring(tanggal,6,2) as bulan,year(tanggal) as tahun,dailyrecords.id_tasks_detail,dailyrecords.catatan, dailyrecords.jam_mulai,dailyrecords.jam_selesai,dailyrecords.durasi
// FROM
//   dailyrecords
// WHERE
//   substring(dailyrecords.tanggal, 6, 2) = '". substr($tanggal,5,2) ."' and dailyrecords.created_by = '". $userid ."'";
// $queryitem = mysql_query($sqlitem);

$sqlitem="SELECT
  a.tanggal, a.ruangan, a.keterangan, a.penyebab, a.solusi
  FROM
  t_working_record a
  WHERE
   SUBSTR(a.tanggal, 1, 10) = '".$tanggal."'";
  $queryitem = mysql_query($sqlitem);

// print_r($queryitem);
// die();
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
        <td width="100%" align="center"><span class="header"><strong><b>LAPORAN KELUHAN DAN PERBAIKAN
        <br>BULAN <?php echo substr($tanggal, 5,2) ?> TAHUN <?php echo substr($tanggal, 0,4) ?>
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
  <strong>Nama : </strong>
  <br>
  <strong>Pekerjaan :</strong>

<table width="100%" cellspacing="0" border="1"  class="penulisan">
  <tbody>
    <tr>
      <td align="center">N0</td>
      <td align="center">TANGGAL</td>
      <td align="center">RUANG</td>
      <td align="center">KETERANGAN</td>
      <td align="center">PENYEBAB</td>
      <td align="center">SOLUSI</td>
    </tr>
    <?php

      while($data=mysql_fetch_assoc($queryitem)){
        echo '<tr>';
        echo '<td>'.$no.'</td>';
        echo '<td>'.$data['tanggal'].'</td>';
         echo '<td>'.$data['ruangan'].'</td>';
         echo '<td>'.$data['keterangan'].'</td>';
         echo '<td>'.$data['penyebab'].'</td>';
         echo '<td>'.$data['solusi'].'</td>';
        echo '</tr>';
        
        $no++;
      }
    ?>
  </tbody>
</table>
</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.66 * 72, 5.51 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('lap_keluhan.pdf',array('Attachment' => 0));
?>
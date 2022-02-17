<?php
ob_start();
include('../connect.php');

$userid = $_GET['userid'];
$tanggal = $_GET['tanggal'];
$sqlitem="SELECT
  a.id,a.tanggal,month(a.tanggal) as bulan,year(a.tanggal) as tahun,a.id_tasks_detail,a.catatan, a.jam_mulai,a.jam_selesai,a.durasi, b.tasks_detail as tugas
FROM
  simrs2012.dailyrecords a
  left join simrs2012.m_tasks_detail b on b.id = a.id_tasks_detail
WHERE
  month(a.tanggal) = '". substr($tanggal,5,2) ."' and year(a.tanggal) = '". substr($tanggal,0,4) ."' and a.created_by = '". $userid ."'";
$queryitem = mysql_query($sqlitem);

$sqlnama = "SELECT a.id, a.pegawai_id, a.tasks, b.pd_nickname as nama, c.tasks as pekerjaan from simrs2012.user a
left join simrs.master_login b on b.uid = a.pegawai_id
left join simrs2012.m_tasks c on c.id = a.tasks
where a.id = '".$userid."'";
$querynama = mysql_query($sqlnama);
$tampilnama = mysql_fetch_assoc($querynama);

// print($sqlnama);
?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Bulanan</title>
</head>

<body>
  <table width="100%" style="border:0;font-size: 14px;" cellpadding="0">
    <tbody>
      <tr>
        <td width="100%" align="center"><span><strong><b>LAPORAN CATATAN HARIAN
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
  <strong style="font-size: 12px">Nama : <?php echo($tampilnama['nama']) ?></strong>
  <br>
  <strong style="font-size: 12px">Jabatan : <?php echo($tampilnama['pekerjaan']) ?></strong>

<table width="100%" cellspacing="0" border="1" style="font-size: 11px">
  <tbody>
    <tr>
      <td align="center">N0</td>
      <td align="center">TANGGAL</td>
      <td align="center">TUGAS</td>
      <td align="center">CATATAN</td>
      <td align="center">JAM MULAI</td>
      <td align="center">JAM SELESAI</td>
    </tr>
    <?php

      while($data=mysql_fetch_array($queryitem)){
        $no = 1;
        echo '<tr>';
        echo '<td>'.$no.'</td>';
        echo '<td>'.$data['tanggal'].'</td>';
        echo '<td>'.$data['tugas'].'</td>';
        echo '<td>'.$data['catatan'].'</td>';
        echo '<td>'.$data['jam_mulai'].'</td>';
        echo '<td>'.$data['jam_selesai'].'</td>';
        echo '</tr>';
        
        $no++;
      }
    ?>
  </tbody>
</table>

<br><br>
<table width="100%" cellspacing="0" border="0" style="font-size: 11px">
  <tbody>
    <tr>
      <td align="center" width="35%">Mengetahui</td>
      <td align="center" width="30%"></td>
      <td align="center" width="35%">Dikeluarkan Tanggal, ...</td>
    </tr>
    <tr>
      <td align="center" width="35%">Kepala ...</td>
      <td align="center" width="30%"></td>
      <td align="center" width="35%">Pegawai Non PNS</td>
    </tr>
  </tbody>
</table>
<br><br><br><br>
<table width="100%" cellspacing="0" border="0" style="font-size: 11px" align="center">
  <tbody>
    <tr>
      <td align="center" width="35%">Nama</td>
      <td align="center" width="30%"></td>
      <td align="center" width="35%"><?php echo($tampilnama['nama']) ?></td>
    </tr>
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
$dompdf->stream('lap_bulanan.pdf',array('Attachment' => 0));
?>
<?php
ob_start();
// session_start();
include('../connect2.php');

$tahun = '2020';
$bulan = '06';
// $konfirmasi="SELECT t_cssd.created_konfirmasi_at, t_cssd.ruang, m_alat_cssd.nama_alat as instrumen, t_cssd.jumlah, t_cssd.pengantar, t_cssd.perawatjaga, t_cssd.petugas_pengambil, t_cssd.petugas_yg_menyerahkan, t_cssd.keterangan
// from t_cssd
// LEFT JOIN m_alat_cssd ON m_alat_cssd.alat_id = t_cssd.instrumen

// where (t_cssd.flag = '3' or t_cssd.flag = '4') and substring(t_cssd.created_konfirmasi_at, 1, 4) = $tahun and substring(t_cssd.created_konfirmasi_at, 6, 2) = $bulan
// ";
//  $querykonfirmasi = mysql_query($konfirmasi);
//   $data = mysql_fetch_assoc($querykonfirmasi);


//   $sqlitemlab="SELECT t_cssd.created_konfirmasi_at, t_cssd.ruang, m_alat_cssd.nama_alat as instrumen, t_cssd.jumlah, t_cssd.pengantar, t_cssd.perawatjaga, t_cssd.petugas_pengambil, t_cssd.petugas_yg_menyerahkan, t_cssd.keterangan
// from t_cssd
// LEFT JOIN m_alat_cssd ON m_alat_cssd.alat_id = t_cssd.instrumen

// where (t_cssd.flag = '3' or t_cssd.flag = '4') and substring(t_cssd.created_konfirmasi_at, 1, 4) = $tahun and substring(t_cssd.created_konfirmasi_at, 6, 2) = $bulan";
// $queryitemlab = mysql_query($sqlitemlab);

$result = "SELECT t_cssd.created_konfirmasi_at, t_cssd.ruang, m_alat_cssd.nama_alat as instrumen, t_cssd.jumlah, t_cssd.pengantar, t_cssd.perawatjaga, t_cssd.petugas_pengambil, t_cssd.petugas_yg_menyerahkan, t_cssd.keterangan
from t_cssd
LEFT JOIN m_alat_cssd ON m_alat_cssd.alat_id = t_cssd.instrumen

where (t_cssd.flag = '3' or t_cssd.flag = '4') and substring(t_cssd.created_konfirmasi_at, 1, 4) = '".$tahun."' and substring(t_cssd.created_konfirmasi_at, 6, 2) = '".$bulan."'";

$queryitem=mysql_query($result);
  // print_r($queryitem);
  // die();
?>

<!-- <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> -->
<!doctype html>
<html>

<head>
<meta charset="utf-8">
<title>Laporan Konfirmasi</title>

<style>
  @page {
            margin-top: 0.1 cm;
            margin-left: 0.1 cm;
      margin-right: 0.1 cm;
      margin-bottom: 0.1 cm;
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
<div class="ex1">
  <table width="100%" cellspacing="0" border="1"  class="penulisan">
  <tbody>
    <tr>
      <td rowspan="2" align="center">No</td>
      <td rowspan="2" align="center">WAKTU (JAM/HARI/TANGGAL)</td>
      <td rowspan="2" align="center">RUANG</td>
      <td rowspan="2" align="center">NAMA ALAT/INSTRUMEN YANG DISTERIL</td>
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
      $no=1;
      while($data=mysql_fetch_assoc($queryitem)){
        print_r($data);
        die();
      echo '<tr>';
      echo '<td>'.$no.'</td>';
        echo '<td></td>';
      echo '<td align="right"></td>';
        echo '<td align="center"></td>';
      echo '<td align="right"><strong></strong></td>';
      echo '</tr>';
        
        $no++;
    }
    ?>
  
  </tbody>
</table>
</div>
</body>

</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporankonfirmasi.pdf',array('Attachment' => 0));
?>
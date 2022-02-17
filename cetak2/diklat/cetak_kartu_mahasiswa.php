<?php
ob_start();
include('../connect.php');
$no_praktik = $_GET['no_praktik'];

$sqlidentitas="SELECT 
    a.id_diklat_registrasi_mhs,
    a.no_praktik,
    a.nama,
    a.alamat,
    b.nama_asal_pendidikan,
    c.nama_jurusan_pendidikan,
    a.total_minggu,
    a.tanggal_mulai,
    a.tanggal_akhir,
    a.total_pembayaran,
	a.photo
FROM
    simrs.diklat_registrasi_mhs a
        LEFT JOIN
    master_asal_pendidikan b ON a.kd_asal = b.id_master_asal_pendidikan
        LEFT JOIN
    master_jurusan_pendidikan c ON a.kd_jurusan = c.id_master_jurusan_pendidikan where a.no_praktik=$no_praktik";
 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);
 
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Kartu Identitas</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	
	@page {
            margin-top: 0.1 cm;
            margin-left: 0.1 cm;
			margin-right: 0.1 cm;
			margin-bottom: 0.1 cm;
			font-family:Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial," sans-serif";
			size: 155.90pt 240.94pt;
	}
	
.identitas {
    border-collapse:collapse;
	font-size: 7px;
	}
.header {
	border-collapse: collapse;
	font-size: 11px;
	}
.footer {
	border-collapse: collapse;
	font-size: 11px;
	}

</style>
</head>
<body>

<table width="100%" cellpadding="0.1" border="0">
  <tr>
    <td align="center" class="header">
    <img src="../gambar/banyumas.png" width="44px" height="44px" /><br />
    <strong style="line-height: 9px">PEMERINTAH<br />
     KABUPATEN BANYUMAS
     </strong>
     </td>
  </tr>
  <tr>
    <td align="center"><?php echo '<img src="../../uploads/'.$DATA_IDENTITAS['photo'].'" width="130px" height="145px"/>' ?></td>
  </tr>
  <tr>
    <td>
    <table width="100%" cellpadding="0,2" class="identitas" border="0">
     <tr>
        <td width="15%"><strong>NO PRAKTIK</strong></td>
        <td width="85%"><strong>: <?php echo $DATA_IDENTITAS['no_praktik']; ?></strong></td>
      </tr>
      <tr>
        <td width="15%"><strong>NAMA</strong></td>
        <td width="85%"><strong>: <?php echo $DATA_IDENTITAS['nama']; ?></strong></td>
      </tr>
      <tr>
        <td><strong>PENDIDIKAN</strong></td>
        <td><strong>: <?php echo $DATA_IDENTITAS['nama_asal_pendidikan']; ?></strong></td>
      </tr>
      <tr>
        <td><strong>JURUSAN</strong></td>
        <td><strong>: <?php echo $DATA_IDENTITAS['nama_jurusan_pendidikan']; ?></strong></td>
      </tr>
    </table>
    </td>
  </tr>
  <div class="footer" style="position: absolute; line-height: 10px; background-color: #4267b2; bottom: 10px;">
      <center style="color: #F4EEEE"><strong>RSUD AJIBARANG<br />PRAKTIKAN</strong></center>
	</div>
</table>


</body>
</html>

<?php
$html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0,155.90, 240.94);
$dompdf->set_paper($paper_size,'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('kartuid.pdf',array('Attachment' => 0));
?>
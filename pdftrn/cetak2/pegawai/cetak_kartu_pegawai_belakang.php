<?php
ob_start();
include('../connect.php');
$uid = $_GET['uid'];

$sqlidentitas="SELECT 
    a.pd_nickname,
    a.nip,
    c.nama_golongan_darah,
    d.nama_profesi as jabatan
FROM
    simrs.master_login a
        LEFT JOIN
    simrs.l_golongan_darah c ON a.id_golongan_darah = c.id_golongan_darah
    left join simrs.master_profesi d on a.id_profesi = d.id_profesi
    where uid=$uid";
 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqlprofil="SELECT 
    alamat,
    CONCAT('Kode Pos ', kode_pos) AS kodepos,
    CONCAT('Telp ', telp1) AS telp1,
    CONCAT('Fax ', fax) AS fax,
    CONCAT('Email ', email) AS email
FROM
    simrs.profil_rumah_sakit;";
 $queryprofil = mysql_query($sqlprofil);
 $DATA_PROFIL = mysql_fetch_array($queryprofil);


function tanggal_indo($tanggal){
	$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
	$split = explode('-', $tanggal);
	return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
	}

 
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Kartu Identitas</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	
	@page {
            margin-top: 1 cm;
            margin-left: 0.2 cm;
			margin-right: 0.2 cm;
			margin-bottom: 1.2 cm;
			font-family:Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial," sans-serif";
			size: 155.90pt 240.94pt;
	}
	
.identitas {
    border-collapse:collapse;
	font-size: 7px;
	}
.header {
	border-collapse: collapse;
	font-size: 12px;
	}
.footer {
	border-collapse: collapse;
	font-size: 12px;
	}

</style>
</head>
<body>

<table width="100%" class="identitas" border="0">
  <tbody>
    <tr>
      <td width="32%"><strong>Nama</strong></td>
      <td width="1%"><strong>:</strong></td>
      <td width="67%"><strong><?php echo $DATA_IDENTITAS['pd_nickname']; ?></strong></td>
    </tr>
    <tr>
      <td width="32%"><strong>NIP</strong></td>
      <td width="1%"><strong>:</strong></td>
      <td width="67%"><strong><?php echo $DATA_IDENTITAS['nip']; ?></strong></td>
    </tr>
    <tr>
      <td width="32%"><strong>Jabatan</strong></td>
      <td width="1%"><strong>:</strong></td>
      <td width="67%"><strong><?php echo $DATA_IDENTITAS['jabatan']; ?></strong></td>
    </tr>
    <tr>
      <td width="32%"><strong>Gol. Darah</strong></td>
      <td width="1%"><strong>:</strong></td>
      <td width="67%"><strong><?php echo $DATA_IDENTITAS['nama_golongan_darah']; ?></strong></td>
    </tr>
    <tr>
      <td width="32%" valign="top"><strong>Alamat Kantor</strong></td>
      <td width="1%"><strong>:</strong></td>
      <td width="67%"><strong><?php echo $DATA_PROFIL['alamat']; ?></strong></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td><strong>:</strong></td>
      <td><strong><?php echo $DATA_PROFIL['kodepos']; ?></strong></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td><strong>:</strong></td>
      <td><strong><?php echo $DATA_PROFIL['telp1']; ?></strong></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td><strong>:</strong></td>
      <td><strong><?php echo $DATA_PROFIL['fax']; ?></strong></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top"><strong>:</strong></td>
      <td><strong><?php echo $DATA_PROFIL['email']; ?></strong></td>
    </tr>
    <tr>
      <td width="32%"><strong>Dikeluarkan</strong></td>
      <td width="1%"><strong>:</strong></td>
      <td width="67%"><strong><?php echo tanggal_indo(date("Y-m-d")); ?></strong></td>
    </tr>
  </tbody>
</table>
<div style="position: absolute; bottom: -13px;">
 		<div style="position: relative">
  		<center valign="center" style="font-size: 7px;"><strong>DIREKTUR RSUD AJIBARANG <br> KABUPATEN BANYUMAS</strong> <br>
 		   <!-- <img src="../gambar/cap.png" style="position: absolute" width="60px" height="60px" alt=""/> -->
  		  <img src="../gambar/budirttdgrae.png" width="70px" height="50px" alt=""/><br>
  		<strong><u>dr. Widyana Grehastuti, Sp.OG., M.Si,Med</u><br>Pembina<br>NIP. 197011130 200212 2 006</strong>
  		</center>
  		</div>
  </div>


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
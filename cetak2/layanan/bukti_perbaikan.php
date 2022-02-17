<?php
ob_start();
session_start();
include('../connect.php');
$id_layanan_sarana_perbaikan= $_GET['id_layanan_sarana_perbaikan'];
$username = $_GET['username'];

$sqlitem="SELECT 
    b.nama_sarana,
    DATE_FORMAT(a.tanggal_rencana_perbaikan, '%d-%m-%Y') AS tanggal_perbaikan,
    pd_nickname
FROM
    simrs.layanan_sarana_perbaikan_detail a
        LEFT JOIN
    master_sarana_perbaikan b ON a.id_master_layanan_sarana_perbaikan = b.id_master_sarana_perbaikan
        LEFT JOIN
    master_login c ON a.username = c.username where a.id_layanan_sarana_perbaikan=$id_layanan_sarana_perbaikan";
$queryitem = mysql_query($sqlitem);

$sqlidentitas="SELECT 
    b.userlevelname AS dari_unit,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y') AS tanggal_permintaan,
    DATE_FORMAT(a.tanggal_konfirmasi, '%d-%m-%Y') AS tanggal_konfirmasi,
    c.userlevelname AS tujuan
FROM
    layanan_sarana_perbaikan a
        left JOIN
    userlevels b ON a.userlevelid = b.userlevelid
        left JOIN
    userlevels c ON a.userlevelid_tujuan = c.userlevelid where a.id_layanan_sarana_perbaikan=$id_layanan_sarana_perbaikan";
$queryidentitas = mysql_query($sqlidentitas);
$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqlusername="select pd_nickname from master_login where username='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);
?>



<html>
<head>
<meta charset="utf-8">
<title>BUKTI PERBAIKAN SARPRAS</title>
<style type="text/css">
	@page {
            margin-top: 0.1 cm;
            margin-left: 0.1 cm;
			margin-right: 0.1 cm;
			margin-bottom: 0.1 cm;
			font-family: Lucida Grande, Lucida Sans Unicode, Lucida Sans, DejaVu Sans, Verdana," sans-serif";
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
<table width="100%" class="tabel" border="1">
    <tr>
      <td width="10%" style="vertical-align:top" class="header"><img src="../gambar/logobms.png" height="60px" /></td>
      <td width="90%" style="vertical-align:top" height="60px" class="header"><strong>RSUD AJIBARANG </strong><br />
          <strong>Jl. Raya Pancasan - Ajibarang, Banyumas<br />
      TELP: (0281) 557 0004 FAX: - (0281)5670005<br />
      Kode Pos : 53163 -</strong></td>
      <td width="30%" style="vertical-align:top" class="header"> Tanggal Cetak: <?php echo date("d-m-Y") ?></td>
    </tr>
</table>
    <div align="center" class="header"><strong>BUKTI  PERBAIKAN SARANA PRASARANA RUMAH SAKIT RSUD AJIBARANG</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="20%">Dari Unit</td>
      <td width="25%">: <?php echo $DATA_IDENTITAS['dari_unit']; ?></td>
      <td width="22%" align="left">Unit Penanggung Jawab</td>
      <td width="33%">: <?php echo $DATA_IDENTITAS['tujuan']; ?></td>
    </tr>
    <tr>
      <td>Tanggal Permintaan</td>
      <td>: <?php echo $DATA_IDENTITAS['tanggal_permintaan']; ?></td>
      <td align="left">Tanggal Konfirmasi</td>
      <td>: <?php echo $DATA_IDENTITAS['tanggal_konfirmasi']; ?></td>
    </tr>
  </tbody>
</table>


<hr>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="2%">No.</td>
      <td width="40%">Nama Perbaikan</td>
      <td width="15%" align="center">Tanggal Perbaikan</td>
      <td width="15%" align="center">Teknisi</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td>'.$data['nama_sarana'].'</td>';
	  echo '<td align="center">'.$data['tanggal_perbaikan'].'</td>';
	  echo '<td>'.$data['pd_nickname'].'</td>';
			$no++;
		}
	?>
    
  </tbody>
</table>

<table width="100%" border="0" class="tabel">
  <tbody>
    <tr>
      <td width="27%" align="center">Hormat Kami</td>
      <td width="50%">&nbsp;</td>
      <td width="23%" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_USERNAME['pd_nickname']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>


</body>
</html>


<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 11.69 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('notainacbg.pdf',array('Attachment' => 0));
?>
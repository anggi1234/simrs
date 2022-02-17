<?php
ob_start();
session_start();
include('../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$id_tindakan= $_GET['id_tindakan'];


$sqlitemtindakan="SELECT 
    a.tanggal_tindakan, b.nama_tindakan, SUM(a.qty) AS jumlah
FROM
    bill_detail_tindakan a
        LEFT JOIN
    master_tindakan b ON a.id_tindakan = b.id_tindakan
WHERE
    a.id_tindakan = $id_tindakan
        AND a.userlevelid = $userlevelid
        and (a.tanggal_tindakan >= '$dari_tanggal' and  a.tanggal_tindakan <= '$sampai_tanggal')
GROUP BY a.tanggal_tindakan";
$queryitemtindakan = mysql_query($sqlitemtindakan);

$sqlitemunit="select userlevelname from userlevels where userlevelid=$userlevelid";
$queryitemunit = mysql_query($sqlitemunit);
$DATA_USERNAME = mysql_fetch_array($queryitemunit);

?>



<html>
<head>
<meta charset="utf-8">
<title>Laporan Tindakan</title>
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
	font-size: 10px;
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
      <td width="10%" rowspan="3" align="right"><img src="../gambar/logobms.png" height="70px" /></td>
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
  

    <div align="center" class="header"><strong>LAPORAN TINDAKAN</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="14%">Unit</td>
      <td colspan="3">: <?php echo $DATA_USERNAME['userlevelname']; ?></td>
    </tr>
    <tr>
      <td>Dari Tanggal</td>
      <td width="33%">: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td width="15%" align="right">Sampai Tanggal</td>
      <td width="38%">: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>

<hr>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="5%">No.</td>
      <td width="31%" align="center">Tanggal</td>
      <td width="48%">Nama Tindakan</td>
      <td width="16%" align="center">Jumlah</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemtindakan)){
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td align="center">'.$data['tanggal_tindakan'].'</td>';
	  echo '<td>'.$data['nama_tindakan'].'</td>';
	  echo '<td align="center">'.$data['jumlah'].'</td>';
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
$paper_size = array(0,0, 8.26 * 72, 11.69 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporantindakan.pdf',array('Attachment' => 0));
?>
<?php
ob_start();
session_start();
include('../../connect.php');

$tahun = $_GET['tahun'];

$sqlidentitas="SELECT 
    c.nama_kategori,
    b.nama_tindakan,
    YEAR(a.tanggal) AS Tahun,
    COUNT(a.id_bill_detail_tindakan) AS Jumlah
FROM
    simrs.bill_detail_tindakan a
        LEFT JOIN
    simrs.master_tindakan b ON a.id_tindakan = b.id_tindakan
        LEFT JOIN
    simrs.l_kategori_tindakan c ON b.id_kategori_tindakan = c.id_kategori_tindakan
WHERE
    c.userlevelid = 17 AND YEAR(a.tanggal) = $tahun GROUP BY c.id_kategori_tindakan";
$queryitemstok = mysql_query($sqlidentitas);

?>



<html>
<head>
<meta charset="utf-8">
<title>Laporan RL 3.7 Radiologi</title>
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
	font-size: 9px;
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
      <td width="10%" rowspan="3" align="right"><img src="../../gambar/logobms.png" height="70px" /></td>
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

    <div align="center" class="header"><strong>LAPORAN RL 3.7 RADIOLOGI</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="5%">Tahun</td>
      <td width="95%">: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
    </tr>
  </tbody>
</table>

<hr>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td>No</td>
      <td width="12%" >KODE PROVINSI</td>
      <td width="10%" align="center">KAB/KOTA</td>
      <td width="12%" align="center">KODE RS</td>
      <td width="12%" >NAMA RS</td>
      <td width="15%" align="center" >TAHUN</td>
      <td width="15%" align="center" >NO</td>
      <td width="14%" align="center" >JENIS KEGIATAN</td>
      <td width="10%" align="right" >JUMLAH</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemstok)){
			  echo '<tr>';
			  echo '<td>'.$no.'</td>';
        echo '<td>33</td>';
        echo '<td>Banyumas</td>';
        echo '<td>3302191</td>';
        echo '<td>RSUD Ajibarang</td>';
        echo '<td>'.$data['Tahun'].'</td>';
			  echo '<td>'.$data['nama_kategori'].'</td>';
        echo '<td>'.$data['nama_tindakan'].'</td>';
        echo '<td>'.$data['Jumlah'].'</td>';
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
require_once("../../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('RL3_7 Radiologi.pdf',array('Attachment' => 0));
?>

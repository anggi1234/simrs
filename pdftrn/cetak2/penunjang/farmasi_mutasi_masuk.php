<?php
ob_start();
session_start();
include('../connect.php');
$username = $_GET['username'];
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid_dari= $_GET['userlevelid_dari'];
$userlevelid= $_GET['userlevelid'];
$id_master_obat_detail= $_GET['id_master_obat_detail'];


$sqlitemmutasimasuk="SELECT 
    DATE_FORMAT(d.tanggal_mutasi, '%d-%m-%Y') AS tanggal,
    f.userlevelname AS dariunit,
    CONCAT(c.nama_obat, ' (', g.userlevelname, ')') AS tujuan,
    a.kuantitas,
    b.harga_jual,
    a.total
FROM
    farmasi_detail_mutasi a
        LEFT JOIN
    master_obat_detail b ON a.id_master_obat_detail_tujuan = b.id_master_obat_detail
        LEFT JOIN
    master_obat c ON b.id_obat = c.id_obat
        LEFT JOIN
    farmasi_mutasi d ON a.id_farmasi_mutasi = d.id_farmasi_mutasi
        LEFT JOIN
    userlevels e ON d.userlevelid_tujuan = e.userlevelid
        LEFT JOIN
    userlevels f ON d.userlevelid = f.userlevelid
        LEFT JOIN
    userlevels g ON b.userlevelid = g.userlevelid
WHERE
    a.id_master_obat_detail_tujuan = $id_master_obat_detail
        AND (DATE(d.tanggal) >= '$dari_tanggal'
        AND DATE(d.tanggal) <= '$sampai_tanggal')
        AND d.userlevelid_tujuan = $userlevelid_dari
        AND d.userlevelid = $userlevelid";
$queryitemmutasimasuk = mysql_query($sqlitemmutasimasuk);

 $queryitemmutasimasuk2 = mysql_query($sqlitemmutasimasuk);
 $DATA_MUTASIMASUK = mysql_fetch_array($queryitemmutasimasuk2);

$sqlusername="select a.pd_nickname,b.userlevelname from master_login a left join userlevels b on a.userlevelid=b.userlevelid where a.username=$username";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

?>



<html>
<head>
<meta charset="utf-8">
<title>Mutasi</title>
<style type="text/css">
	@page {
            margin-top: 0.1 cm;
            margin-left: 0.1 cm;
			margin-right: 0.1 cm;
			margin-bottom: 0.1 cm;
			font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 12px;
	font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
}
	
.header {
	font-size: 12px;
	font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
}	
.footer {
	font-size: 12px;
	font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
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
  

    <div align="center" class="header"><strong>LAPORAN MUTASI MASUK</strong></div>
<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="12%">Nama Obat</td>
      <td colspan="2">: <?php echo $DATA_MUTASIMASUK['tujuan']; ?></td>
      <td width="38%">&nbsp;</td>
    </tr>
    <tr>
      <td>Dari Tanggal</td>
      <td width="17%">: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td width="33%" align="right">Sampai Tanggal</td>
      <td>: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>


<hr>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="2%">No.</td>
      <td width="25%">Unit</td>
      <td width="10%">Tanggal</td>
      <td width="5%">Jumlah</td>
      <td width="15%" align="right">Harga Beli</td>
      <td width="15%" align="right">Total</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemmutasimasuk)){
	  echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td>'.$data['dariunit'].'</td>';
	  echo '<td>'.$data['tanggal'].'</td>';
	  echo '<td>'.$data['kuantitas'].'</td>';
      echo '<td><div align="right">'.number_format($data['harga_jual'], 2,",",".").'</div></td>';
	  echo '<td><div align="right">'.number_format($data['total'], 2,",",".").'</div></td>';
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
$dompdf->stream('mutasimasuk.pdf',array('Attachment' => 0));
?>
<?php
ob_start();
session_start();
include('../connect.php');
$idxdaftar = $_GET['idxdaftar'];
$username = $_GET['username'];
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$id_master_obat_detail= $_GET['id_master_obat_detail'];


$sqlitemstok="SELECT 
    DATE_FORMAT(d.tanggal, '%d-%m-%Y') AS tanggal,
    a.id_master_obat_detail,
    e.userlevelname,
    c.nama_obat,
    a.qty_masuk,
    a.harga_beli,
    a.total
FROM
    bill_detail_pengambilan_obat a
        LEFT JOIN
    master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
        LEFT JOIN
    master_obat c ON b.id_obat = c.id_obat
        LEFT JOIN
    bill_pengambilan_obat d ON a.id_bill_pengambilan_obat = d.id_bill_pengambilan_obat
        LEFT JOIN
    userlevels e ON d.userlevelid = e.userlevelid
	where a.userlevelid=$userlevelid and 
	a.id_master_obat_detail=$id_master_obat_detail and 
	date(d.tanggal) >= '$dari_tanggal' and 
	date(d.tanggal) <= '$sampai_tanggal'";
$queryitemstok = mysql_query($sqlitemstok);
$queryitemobat = mysql_query($sqlitemstok);
$DATA_OBAT = mysql_fetch_array($queryitemobat);

$sqlusername="select a.pd_nickname,b.userlevelname from master_login a left join userlevels b on a.userlevelid=b.userlevelid where a.username=$username";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

?>



<html>
<head>
<meta charset="utf-8">
<title>Obat Masuk</title>
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
  

    <div align="center" class="header"><strong>LAPORAN STOK MASUK</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="19%">Nama Obat</td>
      <td colspan="3">: <?php echo $DATA_OBAT['nama_obat']; ?></td>
    </tr>
    <tr>
      <td>Dari Tanggal</td>
      <td width="27%">: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td width="14%" align="right">Sampai Tanggal</td>
      <td width="40%">: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>


<hr>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="3%">No.</td>
      <td width="20%" align="center">Tanggal</td>
      <td width="40%">Unit Pengambilan</td>
      <td width="8%" align="center">Jumlah</td>
      <td width="14%" align="right">Harga</td>
      <td width="15%" align="right">Total</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemstok)){
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
	  echo '<td align="center">'.$data['tanggal'].'</td>';
      echo '<td>'.$data['userlevelname'].'</td>';
	  echo '<td align="right">'.$data['qty_masuk'].'</td>';
	  echo '<td align="right">'.$data['harga_beli'].'</td>';
      echo '<td><div align="right">'.number_format($data['total'], 2,",",".").'</div></td>';
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
$dompdf->stream('stok_masuk.pdf',array('Attachment' => 0));
?>
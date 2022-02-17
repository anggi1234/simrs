<?php
ob_start();
session_start();
include('../../connect.php');
$username = $_GET['username'];
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$id_master_barang_detail= $_GET['id_master_barang_detail'];

$sqlitemstok="SELECT
	DATE_FORMAT( d.tanggal, '%d-%m-%Y' ) AS tanggal,
	a.id_master_barang_detail,
	c.nama_barang,
	a.qty * volume AS qty,
	a.harga_beli_satuan,
	a.pajak,
	a.disc,
	(( a.qty * a.volume ) * a.harga_beli_satuan) AS total_hargabeli,
	e.nama_supplier 
FROM
	simrs.gudang_pembelian_detail a
	LEFT JOIN simrs.master_barang_detail b ON a.id_master_barang_detail = b.id_master_barang_detail
	LEFT JOIN simrs.master_barang c ON b.id_master_barang = c.id_master_barang
	LEFT JOIN simrs.gudang_pembelian d ON a.id_gudang_pembelian = d.id_gudang_pembelian
	LEFT JOIN simrs.master_supplier e ON d.id_supplier = e.id_master_supplier
WHERE
    a.userlevelid = $userlevelid
        AND a.id_master_barang_detail = $id_master_barang_detail
        AND DATE(d.tanggal) >= '$dari_tanggal'
        AND DATE(d.tanggal) <= '$sampai_tanggal'";
$queryitemstok = mysql_query($sqlitemstok);
$queryitemobat1 = mysql_query($sqlitemstok);
$DATA_OBAT = mysql_fetch_array($queryitemobat1);

$sqlusername="select a.pd_nickname,b.userlevelname from master_login a left join userlevels b on a.userlevelid=b.userlevelid where a.username=$username";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

?>



<html>
<head>
<meta charset="utf-8">
<title>Laporan Pemasukan</title>
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
  

    <div align="center" class="header"><strong>LAPORAN STOK PEMBELIAN</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="12%">Nama Obat</td>
      <td width="39%">: <?php echo $DATA_OBAT['nama_barang']; ?></td>
      <td width="14%" align="right">&nbsp;</td>
      <td width="35%">&nbsp;</td>
    </tr>
    <tr>
      <td>Dari Tanggal</td>
      <td>: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td align="right">Sampai Tanggal</td>
      <td>: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>


<hr>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="2%">No.</td>
      <td width="10%">Tanggal</td>
      <td width="20%">Supplier</td>
      <td width="10%">Jumlah</td>
      <td width="15%">Harga Beli</td>
      <td width="15%">Pajak</td>
      <td width="15%">Diskon</td>
      <td width="15%">Total</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemstok)){
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td>'.$data['tanggal'].'</td>';
	  echo '<td>'.$data['nama_supplier'].'</td>';
	  echo '<td>'.$data['qty'].'</td>';
	  echo '<td>'.number_format($data['harga_beli_satuan'], 2,",",".").'</td>';
	  echo '<td>'.$data['pajak'].'</td>';
	  echo '<td>'.$data['disc'].'</td>';
      echo '<td><div align="right">'.number_format($data['total_hargabeli'], 2,",",".").'</div></td>';
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
$paper_size = array(0,0, 8.26 * 72, 11.69 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('pembelian_barang.pdf',array('Attachment' => 0));
?>
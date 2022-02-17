<?php
ob_start();
session_start();
include('../../connect.php');
$username = $_GET['username'];
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$id_supplier= $_GET['id_supplier'];


$sqlitemstok="SELECT
	date_format(a.tanggal, '%d-%m-%Y') as tanggal,e.nama_obat,(a.qty*a.volume) as jumlah, round(a.harga_beli_satuan,2) as harga_beli,(a.qty*a.volume)*round(a.harga_beli_satuan,2) as total,c.nama_supplier 
FROM
	farmasi_pembelian_obat_detail a
	LEFT JOIN farmasi_pembelian_obat b ON a.id_pembelian_obat = b.id_pembelian_obat
	left join master_supplier c on b.id_supplier=c.id_master_supplier
	left join master_obat_detail d on a.id_master_obat_detail=d.id_master_obat_detail
	left join master_obat e on d.id_obat=e.id_obat
WHERE
    a.userlevelid = $userlevelid AND
	b.id_supplier = $id_supplier
        AND (DATE(b.tanggal) >= '$dari_tanggal'
        AND DATE(b.tanggal) <= '$sampai_tanggal')";
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
  

    <div align="center" class="header"><strong>LAPORAN STOK OBAT PER SUPPLIER</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="12%">Supplier</td>
      <td width="39%">: <?php echo $DATA_OBAT['nama_supplier']; ?></td>
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
      <td width="5%">No.</td>
      <td width="15%">Tanggal</td>
      <td width="33%">Nama Barang</td>
      <td width="7%" align="center">Jumlah</td>
      <td width="20%" align="center">Harga Beli</td>
      <td width="20%" align="center">Total</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemstok)){
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td>'.$data['tanggal'].'</td>';
	  echo '<td>'.$data['nama_obat'].'</td>';
	  echo '<td>'.$data['jumlah'].'</td>';
	  echo '<td align="right">'.number_format($data['harga_beli'], 2,",",".").'</td>';
			echo '<td align="right">'.number_format($data['total'], 2,",",".").'</td>';
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
$dompdf->stream('notainacbg.pdf',array('Attachment' => 0));
?>
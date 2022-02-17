<?php
ob_start();
session_start();
include('../../connect.php');
$username = $_GET['username'];
$id_pembelian_obat= $_GET['id_pembelian_obat'];

$sqlusername="SELECT 
    a.pd_nickname, b.userlevelname
FROM
	master_login_detail c left join
    master_login a on c.uid=a.uid
        LEFT JOIN
    userlevels b ON c.userlevelid = b.userlevelid
WHERE
    c.username ='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

$sqlitempembelian="SELECT 
    c.nama_obat,a.qty,c.satuan_pembelian,a.volume as isi,a.harga_beli,concat(a.pajak,'%') as pajak,concat(a.disc,'%') as disc,floor(a.harga_beli_setelah_diskon) as total_harga_beli
FROM
    farmasi_pembelian_obat_detail a
        LEFT JOIN
    master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
    left join master_obat c on b.id_obat=c.id_obat where a.id_pembelian_obat=$id_pembelian_obat";
$queryitempembelian = mysql_query($sqlitempembelian);

$sqlusername="SELECT 
    DATE_FORMAT(a.tgl_beli, '%d-%m-%Y') AS tgl_beli,
    a.total_pembelian,
    a.total_pajak,
    a.total_diskon,
    a.total_ongkir,
    a.grandtotal_setelah_ongkir as grandtotal,
    b.nama_supplier,
    c.nama_status_pembelian
FROM
    simrs.farmasi_pembelian_obat a
        LEFT JOIN
    simrs.master_supplier b ON a.id_supplier = b.id_master_supplier
        LEFT JOIN
    simrs.l_status_transaksi c ON a.id_keterangan = c.id_status_transaksi where a.id_pembelian_obat=$id_pembelian_obat";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

?>



<html>
<head>
<meta charset="utf-8">
<title>Pembelian Barang</title>
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
  

    <div align="center" class="header"><strong>RINCIAN NOTA PEMBELIAN OBAT</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="10%">Supplier</td>
      <td width="50%">: <?php echo $DATA_USERNAME['nama_supplier']; ?></td>
      <td width="13%">Status</td>
      <td width="27%">: <?php echo $DATA_USERNAME['nama_status_pembelian']; ?></td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td>: <?php echo $DATA_USERNAME['tgl_beli']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>


<hr>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="2%">No.</td>
      <td width="20%">Nama Obat</td>
      <td width="5%" align="right">Kuantitas</td>
      <td width="5%" align="right">Satuan</td>
      <td width="5%" align="right">Isi</td>
      <td width="5%" align="right">Diskon</td>
      <td width="5%" align="right">Pajak</td>
      <td width="10%" align="right">Harga Beli</td>
      <td width="10%" align="right">Sub Total</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitempembelian)){
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td>'.$data['nama_obat'].'</td>';
	  echo '<td align="right">'.$data['qty'].'</td>';
	  echo '<td align="right">'.$data['satuan_pembelian'].'</td>';
	  echo '<td align="right">'.$data['isi'].'</td>';
	  echo '<td align="right">'.$data['disc'].'</td>';
	  echo '<td align="right">'.$data['pajak'].'</td>';
	  echo '<td align="right">'.number_format($data['harga_beli'], 2,",",".").'</td>';
	  echo '<td align="right">'.number_format($data['total_harga_beli'], 2,",",".").'</td>';
			echo '</tr>';
			$no++;
		}
	?>
	<tr>
	  <td colspan="7" rowspan="6">&nbsp;</td>
	  <td colspan="2" align="right">&nbsp;</td>
    </tr>
	<tr>
	  <td align="right">Pembelian</td>
	  <td align="right"><?php echo number_format($DATA_USERNAME['total_pembelian'], 2,",","."); ?></td>
    </tr>
	<tr>
	  <td align="right">Pajak</td>
	  <td align="right"><?php echo number_format($DATA_USERNAME['total_pajak'], 2,",","."); ?></td>
    </tr>
	<tr>
	  <td align="right"> Diskon</td>
	  <td align="right"><?php echo number_format($DATA_USERNAME['total_diskon'], 2,",","."); ?></td>
    </tr>
	<tr>
	  <td align="right"> Ongkir</td>
	  <td align="right"><?php echo number_format($DATA_USERNAME['total_ongkir'], 2,",","."); ?></td>
    </tr>
	<tr>
      <td width="10%" align="right"><strong>GRAND TOTAL</strong></td>
      <td width="10%" align="right"><?php echo number_format($DATA_USERNAME['grandtotal'], 2,",","."); ?></td>
    </tr>
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
$dompdf->stream('pembelianobat.pdf',array('Attachment' => 0));
?>
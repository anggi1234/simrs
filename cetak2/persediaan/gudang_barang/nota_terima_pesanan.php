<?php
ob_start();
session_start();
include('../../connect.php');
$username = $_GET['username'];
$id_gudang_pembelian= $_GET['id_gudang_pembelian'];

$sqluser="SELECT 
    a.pd_nickname, b.userlevelname, a.nip
FROM
	master_login_detail c left join
    master_login a on c.uid=a.uid
        LEFT JOIN
    userlevels b ON c.userlevelid = b.userlevelid
WHERE
    c.username ='$username'";
 $queryuser = mysql_query($sqluser);
 $DATA_USER = mysql_fetch_array($queryuser);

$sqlitempembelian="SELECT
	c.nama_barang,
	a.qty,
	d.nama_satuan,
	a.volume AS isi,
	a.harga_beli,
	CONCAT( a.pajak, '%' ) AS pajak,
	CONCAT( a.disc, '%' ) AS disc,
	FLOOR( a.harga_beli_setelah_diskon ) AS total_harga_beli 
FROM
	gudang_pembelian_detail a
	LEFT JOIN master_barang_detail b ON a.id_master_barang_detail = b.id_master_barang_detail
	LEFT JOIN master_barang c ON b.id_master_barang = c.id_master_barang
	LEFT JOIN master_satuan d ON c.id_satuan_pembelian = d.id_satuan 
WHERE a.id_gudang_pembelian=$id_gudang_pembelian";
$queryitempembelian = mysql_query($sqlitempembelian);


$sqlusername="SELECT
	DATE_FORMAT( a.tanggal, '%d-%m-%Y' ) AS tgl_beli,
	a.total_pembelian,
	a.total_pajak,
	a.total_diskon,
	a.total_ongkir,
	a.grand_total_setelah_ongkir AS grandtotal,
	b.nama_supplier,
	a.nomor_faktur,
	DATE_FORMAT( a.tgl_faktur, '%d-%m-%Y' ) AS tgl_faktur
FROM
	simrs.gudang_pembelian a
	LEFT JOIN simrs.master_supplier b ON a.id_supplier = b.id_master_supplier 
WHERE a.id_gudang_pembelian=$id_gudang_pembelian";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Nota Terima Pesanan</title>

<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
	font-family: Impact, Haettenschweiler, Franklin Gothic Bold, Arial Black," sans-serif";
	}
.tabel {
    border-collapse:collapse;
	font-size: 10px;	
}
.kosong {
    border:none;
}	
.header {
	font-size: 14px;	
}	
.footer {
	font-size: 12px;
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
      <td align="center" style="font-size: 14px">Jl. Raya Pancasan - Ajibarang, Ajibarang Kode Pos 53163 <br> 
      Telp. (0281) 6570004 Fax. (0281) 6570005 <br> 
      e-mail : rsudajibarang@banyumaskab.go.id</td>
    </tr>
</table>
<hr>
<div align="center" class="header" ><u><strong>NOTA TERIMA BARANG PESANAN</strong></u></div>
     <div class="footer" align="center"></div>
<p></p>
<table class="tabel" width="100%" cellpadding="2" border="0">
    
      <tr>
        <td width="24%" >Terima dari </td>
        <td width="2%" >:</td>
        <td width="74%" > <?php echo $DATA_USERNAME['nama_supplier']; ?></td>
      </tr>
      <tr>
		  <td height="33" colspan="3" > Faktur/Surat Jalan/Bukti Kirim ;</td>
	  </tr>
      <tr>
        <td> Nomor </td>
        <td> :</td>
        <td> <?php echo $DATA_USERNAME['nomor_faktur']; ?></td>
      </tr>
      <tr>
        <td> Tanggal</td>
        <td> :</td>
        <td> <?php echo $DATA_USERNAME['tgl_faktur']; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3"><strong>Telah diterima dan diperiksa barang-barang sebagai berikut:</strong></td>
      </tr>
    
</table>

<table width="100%" class="tabel" border="1" cellpadding="4">
  <tr>
    <td width="4%" rowspan="2" align="center" > No</td>
    <td width="43%" rowspan="2" align="center" > Nama Barang</td>
    <td colspan="3%" align="center" > Terima</td>
    <td width="9%" rowspan="2" align="center" >Total</td>
  </tr>
  <tr>
    <td width="10%" align="center" >Vol</td>
    <td width="10%" align="center" >Sat</td>
    <td width="10%" align="center" >Harga</td>
  </tr>
   <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitempembelian)){
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td>'.$data['nama_barang'].'</td>';
	  echo '<td align="right">'.$data['qty'].'</td>';
	  echo '<td align="right">'.$data['nama_satuan'].'</td>';
	  echo '<td align="right">'.number_format($data['harga_beli'], 2,",",".").'</td>';
	  echo '<td align="right">'.number_format($data['total_harga_beli'], 2,",",".").'</td>';
			echo '</tr>';
			$no++;
		}
	?>
	
  <tr>
    <td colspan="5" align="right"></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="right">Pembelian</td>
    <td align="right"><?php echo number_format($DATA_USERNAME['total_pembelian'], 2,",","."); ?></td>
  </tr>
  <tr>
    <td colspan="5" align="right">Pajak</td>
    <td align="right"><?php echo number_format($DATA_USERNAME['total_pajak'], 2,",","."); ?></td>
  </tr>
  <tr>
    <td colspan="5" align="right">Diskon</td>
    <td align="right"><?php echo number_format($DATA_USERNAME['total_diskon'], 2,",","."); ?></td>
  </tr>
  <tr>
    <td colspan="5" align="right">Ongkir</td>
    <td align="right"><?php echo number_format($DATA_USERNAME['total_ongkir'], 2,",","."); ?></td>
  </tr>
  <tr>
    <td colspan="5" align="right">Grand Total</td>
    <td align="right"><?php echo number_format($DATA_USERNAME['grandtotal'], 2,",","."); ?></td>
  </tr>
</table>
  
  	    	    
   <P></P>
   <table class="footer" width="100%" border="0">
        
     <tr>
       <td width="40%" align="center" ></td>
       <td width="33%" align="center" ></td>
       <td width="42%" align="center" >Ajibarang, <?php echo date("d-m-Y") ?></td>
     </tr>
     <tr>
       <td width="40%" align="center" >Yang Menyerahkan,</td>
       <td width="33%" align="center" >&nbsp;</td>
       <td width="42%" align="center" ><p>Yang Menerima,</p></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     
     <tr>
       <td width="40%" align="center" >&nbsp;</td>
       <td width="33%" align="center" >&nbsp;</td>
       <td width="42%" align="center" > <u><?php echo $DATA_USER['pd_nickname']; ?></u></td>
     </tr>
     <tr>
      <td width="40%" align="center" >(........................)</td>
      <td width="33%" align="center" >&nbsp;</td>
      <td width="42%" align="center" >NIP. <?php echo $DATA_USER['nip']; ?></td>
    </tr>
    
        
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
$dompdf->stream('notafarmasi.pdf',array('Attachment' => 0));
?>
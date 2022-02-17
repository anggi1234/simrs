<?php
ob_start();
session_start();
include('../connect.php');

$id_bill_pengambilan_obat = $_GET['id_bill_pengambilan_obat'];

$sqlidentitas="SELECT 
    c.userlevelname as dari
FROM
    simrs.bill_pengambilan_obat a
        LEFT JOIN
    simrs.userlevels c ON a.userlevelid = c.userlevelid
WHERE
    a.id_bill_pengambilan_obat = $id_bill_pengambilan_obat";
$queryidentitas = mysql_query($sqlidentitas);
$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqlitem="SELECT 
    a.id_master_obat_detail AS kode_barang,
    c.nama_obat,
    a.qty_masuk,
    c.satuan_pembelian,
    a.harga_beli,
    b.stok_akhir,
    c.satuan_pembelian AS satuan
FROM
    simrs.bill_detail_pengambilan_obat a
        LEFT JOIN
    simrs.master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
        LEFT JOIN
    simrs.master_obat c ON b.id_obat = c.id_obat
WHERE
    a.id_bill_pengambilan_obat =$id_bill_pengambilan_obat";
$queryitem = mysql_query($sqlitem);



?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Nota Permintaan Stok</title>


<style type="text/css">
	@page {
		    margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
		font-size: 12px;
	font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 12px;	
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
<div class="header" align="center" ><u><strong>NOTA PERMINTAAN STOK BARANG</strong></u></div>
<div class="footer" align="center" > Nomor : (.........)</div>


<table class="tabel" width="100%" cellpadding="2" border="0">
      <tr>
        <td width="10%" >Dari </td>
        <td width="1%" >:</td>
        <td width="33%" > <?php echo $DATA_IDENTITAS['dari']; ?></td>
        <td width="21%" >&nbsp;</td>
        <td width="11%" >&nbsp;</td>
        <td width="1%" >&nbsp;</td>
        <td width="23%" >&nbsp;</td>
      </tr>
      <tr>
        <td>Kepada </td>
        <td>:</td>
        <td> GUDANG FARMASI</td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </table>
    
<p class="footer" >Permintaan stok barang tersebut dibawah ini: </p>

<table class="tabel" width="100%" border="1" cellpadding="4">
  <tr>
    <td width="3%" rowspan="2" align="center" >No</td>
    <td width="11%" rowspan="2" align="center" >Kode Barang</td>
    <td width="29%" rowspan="2" align="center" >Nama Barang</td>
    <td colspan="2%" align="center" >Banyaknya</td>
    <td colspan="3%" align="center" >Stok Tersedia</td>
    <td width="15%" rowspan="2" align="center" >Ket.</td>
  </tr>
  <tr>
    <td width="6%" align="center" >Vol</td>
    <td width="8%" align="center" >Sat</td>
    <td width="6%" align="center" >Vol</td>
    <td width="8%" align="center" >Sat</td>
    <td width="14%" align="center" >Harga Satuan</td>
  </tr>
   <?php
	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="7">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
	  echo '<td align="center">'.$no.'</td>';
      echo '<td align="left">'.$data['kode_barang'].'</td>';
	  echo '<td align="left">'.$data['nama_obat'].'</td>';
      echo '<td align="center">'.$data['qty']. '</td>';
	  echo '<td align="center">'.$data['satuan_pembelian']. '</div></td>';
	  echo '<td align="center">'.$data['stok_akhir']. '</td>';
	  echo '<td align="center">'.$data['satuan']. '</td>';
	  echo '<td align="center">'.$data['harga']. '</td>';
	  echo '<td align="left"></td>';
			echo '</tr>';
			$no++;
		}
	}
	?>
	</table>
 	   <p></p> 	   
   
   <table class="footer" width="100%" border="0">
       
     
     <tr>
       <td width="40%" align="center"  >&nbsp;</td>
       <td width="33%" align="center"  >&nbsp;</td>
       <td width="42%" align="center" >Ajibarang, <?php echo date("d-m-Y") ?></td>
     </tr>
     <tr>
       <td width="40%" align="center" >&nbsp;</td>
       <td width="33%" align="center" >&nbsp;</td>
       <td width="42%" align="center" ><p>(.........)</p></td>
     </tr>
     <tr>
       <td height="50" >&nbsp;</td>
       <td >&nbsp;</td>
       <td >&nbsp;</td>
     </tr>
     
     <tr>
       <td width="40%" align="center" >&nbsp;</td>
       <td width="33%" align="center" >&nbsp;</td>
       <td width="42%" align="center" > <u>(.........)</u></td>
     </tr>
     <tr>
      <td width="40%" align="center" >&nbsp;</td>
      <td width="33%" align="center" >&nbsp;</td>
      <td width="42%" align="center" >NIP. (.........)</td>
    </tr>
    
  </table>
</body>
</html>
<?php
$html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('notafarmasi.pdf',array('Attachment' => 0));
?>
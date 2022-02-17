<?php
ob_start();
session_start();
include('../../connect.php');
$username = $_GET['username'];
$id_pengiriman_barang= $_GET['id_pengiriman_barang'];

$sqlitem="SELECT
	c.nama_barang,
	a.qty,
	d.nama_satuan,
	a.harga_jual,
	a.total 
FROM
	simrs.gudang_pengiriman_detail a
	LEFT JOIN simrs.master_barang_detail b ON a.id_master_barang_detail = b.id_master_barang_detail
	LEFT JOIN simrs.master_barang c ON b.id_master_barang = c.id_master_barang 
	LEFT JOIN simrs.master_satuan d on c.id_satuan=d.id_satuan
WHERE
	a.id_pengiriman_barang =$id_pengiriman_barang";
$queryitemobat = mysql_query($sqlitem);

$sqlusername="SELECT
	c.userlevelname AS dari,
	b.userlevelname,
	DATE_FORMAT( a.tanggal, '%d-%m-%Y' ) AS tanggal,
	a.total_keseluruhan,
	a.no_reg 
FROM
	simrs.gudang_pengiriman a
	LEFT JOIN simrs.userlevels b ON a.userlevelid_to = b.userlevelid
	LEFT JOIN simrs.userlevels c ON a.userlevelid = c.userlevelid 
WHERE
	a.id_pengiriman_barang =$id_pengiriman_barang";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

$sqluser="SELECT 
    pd_nickname, nip
FROM
    simrs.master_login_detail a
        LEFT JOIN
    simrs.master_login b ON a.uid = b.uid
WHERE
    a.username = '$username'";
 $queryuser = mysql_query($sqluser);
 $DATA_USER = mysql_fetch_array($queryuser);

?>


<html>
<head>
<meta charset="utf-8">
<title>Pengiriman Barang</title>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
			font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 12px;
	font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
}
	
.header {
	font-size: 14px;
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
<div align="center" class="header"><strong>NOTA PENGIRIMAN STOK BARANG</strong></div>
<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td>Dari</td>
      <td>: <?php echo $DATA_USERNAME['dari']; ?></td>
    </tr>
    <tr>
      <td width="10%">Kepada</td>
      <td width="90%">: <?php echo $DATA_USERNAME['userlevelname']; ?></td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td>: <?php echo $DATA_USERNAME['tanggal']; ?></td>
    </tr>
  </tbody>
</table>


<hr>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="2%">No.</td>
      <td width="40%">Nama Obat</td>
      <td width="10%">Jumlah</td>
      <td width="15%" align="center">Satuan</td>
      <td width="15%" align="right">Harga Obat</td>
      <td width="15%" align="right">Total</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemobat)){
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td>'.$data['nama_barang'].'</td>';
	  echo '<td>'.$data['qty'].'</td>';
	  echo '<td>'.$data['nama_satuan'].'</td>';
      echo '<td><div align="right">'.number_format($data['harga_jual'], 2,",",".").'</div></td>';
			echo '<td><div align="right">'.number_format($data['total'], 2,",",".").'</div></td>';
			echo '</tr>';
			$no++;
		}
	?>
    <tr>
      <td colspan="5" align="right"><strong>Grand Total</strong></td>
      <td width="15%" align="right" style="font-size: 15px"><strong><?php echo number_format($DATA_USERNAME['total_keseluruhan'], 2,",","."); ?></strong></td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0" class="footer" >
       
     <tr>
       <td align="center" ></td>
       <td align="center" ></td>
       <td align="center" ></td>
     </tr>
     
      <tr>
       <td width="40%" align="center" ></td>
       <td width="33%" align="center" ></td>
       <td width="42%" align="center" >Ajibarang, <?php echo date("d-m-Y") ?></td>
     </tr>
     <tr>
       <td width="40%" align="center" >Yang menerima,</td>
       <td width="33%" align="center" >&nbsp;</td>
       <td width="42%" align="center" >Yang menyerahkan,</td>
     </tr>
     <tr>
       <td height="30" >&nbsp;</td>
       <td >&nbsp;</td>
       <td >&nbsp;</td>
     </tr>
     
     <tr>
       <td width="40%" align="center" >&nbsp;</td>
       <td width="33%" align="center" >&nbsp;</td>
       <td width="42%" align="center" ><u><?php echo $DATA_USER['pd_nickname']; ?></u></td>
     </tr>
     <tr>
      <td width="40%" align="center" >&nbsp;</td>
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
$paper_size = array(0,0, 8.26 * 72, 11.69 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('notainacbg.pdf',array('Attachment' => 0));
?>
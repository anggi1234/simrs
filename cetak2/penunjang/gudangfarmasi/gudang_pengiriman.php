<?php
ob_start();
session_start();
include('../../connect.php');
$username = $_GET['username'];
$id_farmasi_pengiriman_obat= $_GET['id_farmasi_pengiriman_obat'];

$sqlitem="SELECT 
    c.nama_obat,a.qty,c.satuan,a.hargajual,a.total
FROM
    simrs.farmasi_pengiriman_obat_detail a
        LEFT JOIN
    simrs.master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
    left join simrs.master_obat c on b.id_obat=c.id_obat where a.id_farmasi_pengiriman_obat=$id_farmasi_pengiriman_obat";
$queryitemobat = mysql_query($sqlitem);

$sqlusername="SELECT c.userlevelname AS dari,
    b.userlevelname,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y') AS tanggal,
    a.total_pengiriman,a.no_reg
FROM
    simrs.farmasi_pengiriman_obat a
        LEFT JOIN
    simrs.userlevels b ON a.userlevelid_to = b.userlevelid
        LEFT JOIN
    simrs.userlevels c ON a.userlevelid = c.userlevelid
    where a.id_farmasi_pengiriman_obat=$id_farmasi_pengiriman_obat";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

$sqluser="SELECT 
    a.pd_nickname, a.nip
FROM
    simrs.master_login a
WHERE
    a.username = '$username'";
 $queryuser = mysql_query($sqluser);
 $DATA_USER = mysql_fetch_array($queryuser);

?>


<html>
<head>
<meta charset="utf-8">
<title>Pemberian Obat</title>
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
	font-size: 12px;
}
	
.header {
	font-size: 14px;
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
      <td align="center" style="font-size: 14px">Jl. Raya Pancasan - Ajibarang, Ajibarang Kode Pos 53163 <br> 
      Telp. (0281) 6570004 Fax. (0281) 6570005 <br> 
      e-mail : rsudajibarang@banyumaskab.go.id</td>
    </tr>
</table>
  <hr>
<div align="center" class="header"><strong>NOTA PENGIRIMAN STOK BARANG</strong></div>
<div class="footer" align="center" >Nomor : <?php echo $DATA_USERNAME['no_reg']; ?></div>
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
      echo '<td>'.$data['nama_obat'].'</td>';
	  echo '<td>'.$data['qty'].'</td>';
	  echo '<td>'.$data['satuan'].'</td>';
      echo '<td><div align="right">'.number_format($data['hargajual'], 2,",",".").'</div></td>';
			echo '<td><div align="right">'.number_format($data['total'], 2,",",".").'</div></td>';
			$no++;
		}
	?>
    <tr>
      <td colspan="5" align="right"><strong>Grand Total</strong></td>
      <td width="15%" align="right" style="font-size: 15px"><strong><?php echo number_format($DATA_USERNAME['total_pengiriman'], 2,",","."); ?></strong></td>
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
       <td width="40%" align="center" ><?php echo $DATA_USERNAME['userlevelname']; ?></td>
       <td width="33%" align="center" >&nbsp;</td>
       <td width="42%" align="center" ><u><?php echo $DATA_USER['pd_nickname']; ?></u></td>
     </tr>
     <tr>
      <td width="40%" align="center" ></td>
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
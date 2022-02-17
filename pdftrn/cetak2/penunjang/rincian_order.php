<?php
ob_start();
session_start();
include('../connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];
$userlevelid = $_GET['userlevelid'];

$sqlidentitas="SELECT 
    a.id_bill_detail_tarif,
	a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
	g.userlevelname,
	DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
	c.nama AS carabayar,
	DATE_FORMAT(a.tanggal, '%d-%m-%Y %H:%m:%s') AS tglmasuk
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs2012.m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    simrs.bill_detail_transfer_pasien d ON a.id_bill_detail_tarif = d.id_bill_detail_tarif
	        LEFT JOIN
    simrs2012.m_statuskeluar e ON e.status = d.id_status_keluar
        LEFT JOIN
    simrs.userlevels f ON d.userlevelid_transfer = f.userlevelid
	LEFT JOIN
	simrs.userlevels g ON a.userlevelid = g.userlevelid
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif";
$queryidentitas = mysql_query($sqlidentitas);
$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

$sqliisi="SELECT nama_order,tanggal FROM simrs.bill_detail_order_penunjang where id_bill_detail_tarif = $id_bill_detail_tarif  and userlevelid_tujuan=$userlevelid"; 
$queryisi = mysql_query($sqliisi);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Order Penunjang</title>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.7 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
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
	font-size: 12px;
}	
.footer {
	font-size: 12px;
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
<div align="center"><strong>ORDER PENUNJANG</strong></div>
<table width="100%" border="0" cellpadding="1" cellspacing="0" class="header">
    <tr>
      <td width="14%" align="left">No. RM</td>
      <td width="44%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="19%" align="left">Status Pembayaran </td>
      <td width="23%">: <?php echo $DATA_IDENTITAS['carabayar']; ?></td>
    </tr>
    <tr>
      <td align="left">Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['nama']; ?></td>
      <td align="left">Tanggal Masuk</td>
      <td>: <?php echo $DATA_IDENTITAS['tglmasuk']; ?></td>
    </tr>
    <tr>
      <td align="left">Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
      <td align="left">Dari Unit</td> 
      <td>: <?php echo $DATA_IDENTITAS['userlevelname']; ?></td>
  </tr>
    <tr>
      <td align="left">Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS['jeniskelamin']; ?></td>
      <td align="left">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">Alamat</td>
      <td colspan="3" valign="top">: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
</table>

<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="5%" align="center">No</td>
      <td width="70%" align="center">Nama Order </td>
      <td width="25%" align="center">Jam Order</td>
    </tr>
    <?php
	  	$no=1;
		while($data=mysql_fetch_assoc($queryisi)){
			echo '<tr>';
	  		echo '<td align="center">'.$no.'.</td>';
			echo '<td align="left">'.$data['nama_order'].'</td>';
			echo '<td align="center">'.$data['tanggal'].'</td>';
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
$paper_size = array(0,0, 8.66 * 72, 11.69 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('notarincianpenunjang.pdf',array('Attachment' => 0));
?>
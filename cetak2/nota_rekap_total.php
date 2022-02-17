<?php
ob_start();
session_start();
include('connect.php');
$idxdaftar = $_GET['idxdaftar'];
$username = $_GET['username'];

$sqlidentitas="SELECT 
    a.id_bill_detail_tarif,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y %H:%i:%s') AS tglmasuk
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs2012.m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    simrs.bill_detail_transfer_pasien d ON a.id_bill_detail_tarif = d.id_bill_detail_tarif
WHERE
    a.idxdaftar = $idxdaftar order by a.id_bill_detail_tarif asc limit 1";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqlusername="SELECT 
    a.pd_nickname, b.userlevelname
FROM
    master_login a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid where a.username='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);
 
 $sqltotal="select sum(total_keseluruhan) as total from bill_detail_tarif where idxdaftar=$idxdaftar";
 $querytotal = mysql_query($sqltotal);
 $DATA_TOTAL = mysql_fetch_array($querytotal);


$sqlitemobat=" 
    SELECT sum(biaya_obat)-sum(biaya_obat_retur) as total_obat FROM bill_detail_tarif where idxdaftar=$idxdaftar";
$queryitemobat = mysql_query($sqlitemobat);
$DATA_TOTAL_OBAT = mysql_fetch_array($queryitemobat);


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>REKAP TOTALS</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 0.5 cm;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 11px;
}
	
.kosong {
    border:none;
}
	
.header {
	font-size: 12px;
}	
.footer {
	font-size: 14px;
}
	
</style>

</head>

<body>


<table width="100%" border="0" cellpadding="-3px" cellspacing="0px">
    <tr>
      <td width="10%" rowspan="3" align="right"><img src="gambar/logobms.png" height="70px" /></td>
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
  

<div align="center"><strong>DAFTAR TOTAL BIAYA ADMINISTRASI PASIEN</strong></div>



<table width="100%" class="header" border="0">
    <tr>
      <td width="18%">No. RM</td>
      <td width="27%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="19%">Status Pembayaran </td>
      <td width="36%">: <?php echo $DATA_IDENTITAS['carabayar']; ?></td>
    </tr>
    <tr>
      <td>Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['nama']; ?></td>
      <td>Tanggal Masuk</td>
      <td>: <?php echo $DATA_IDENTITAS['tglmasuk']; ?></td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
  </tr>
    <tr>
      <td>Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS['jeniskelamin']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td colspan="3">: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
</table>




<table width="100%" border="1" class="tabel">
  <?php 
$sqlitemunit="SELECT 
    b.userlevelname, a.kelas,
    a.total_keseluruhan - (ifnull(a.biaya_obat,0) - ifnull(a.biaya_obat_retur,0)) AS total
FROM
    bill_detail_tarif a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
WHERE
    a.idxdaftar = $idxdaftar";
$queryitemunit = mysql_query($sqlitemunit);
	
	
	$no=1;
     while($data=mysql_fetch_assoc($queryitemunit)){
		echo '<tr>
		<td width="39%" bgcolor="#FFFFFF"><strong>TOTAL '.$data['userlevelname'].'</strong></td>
		<td width="6%" align="right" bgcolor="#FFFFFF">Kelas</td>
		<td width="4%" align="center" bgcolor="#FFFFFF">'.$data["kelas"].'</td>
		<td width="51%" align="right" bgcolor="#FFFFFF">'.number_format($data['total'], 0,",",".").'</td>
	  </tr>';
		 $no++;
	}?>
  
  
  <tr>
    <td bgcolor="#FFFFFF"><strong>TOTAL BIAYA OBAT (FARMASI)</strong></td>
    <td colspan="3" align="right" bgcolor="#FFFFFF">
		<?php echo number_format($DATA_TOTAL_OBAT['total_obat'], 0,",","."); ?>
	</td>
  </tr>
  
  <tr>
    <td colspan="4" align="center" bgcolor="#FFFFFF">
    	
    	<table width="100%" border="0">
        <tbody>
     <tr>
       <td width="33%" align="center">Petugas Administrasi</td>
      <td colspan="6" align="right">Sub Total</td>
      <td width="15%" align="right">Rp<?php echo number_format($DATA_TOTAL['total'], 0,",","."); ?></td>
    </tr>
     <tr>
       <td align="right">&nbsp;</td>
       <td colspan="6" align="right">&nbsp;</td>
       <td align="right" class="total">&nbsp;</td>
     </tr>
     <tr>
      <td align="right">&nbsp;</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td align="right" class="total">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_USERNAME['pd_nickname']; ?></td>
      <td colspan="6" align="right"><strong>TOTAL KESELURUHAN</strong></td>
      <td align="right" class="footer"><strong>Rp<?php echo number_format($DATA_TOTAL['total'], 0,",","."); ?></strong></td>
    </tr>
        </tbody>
      </table>
    	
    	
    </td>
  </tr>
</table>





</body>
</html>
<?php
$html = ob_get_clean();
require_once("dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('notafarmasi.pdf',array('Attachment' => 0));
?>
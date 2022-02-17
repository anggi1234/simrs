<?php
ob_start();
session_start();
include('connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];
$username = $_GET['username'];

$sqlrincian="SELECT 
    b.nama_tindakan,
    a.qty,
    a.tarif_pelayanan,
    a.tarif_bhp,
    a.tarif_jasa_sarana,
    a.total
FROM
    bill_detail_tindakan a
        LEFT JOIN
    master_tindakan b ON a.id_tindakan = b.id_tindakan
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif";
 $queryrincian = mysql_query($sqlrincian);


$sqlidentitas="SELECT 
    a.id_bill_detail_tarif,
    a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    e.call_unit,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y') AS tglmasuk,
    d.total
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs2012.m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    (SELECT 
        id_bill_detail_tarif, SUM(total) AS total
    FROM
        bill_detail_tindakan
    GROUP BY id_bill_detail_tarif) d ON a.id_bill_detail_tarif = d.id_bill_detail_tarif
        LEFT JOIN
    simrs.userlevels e ON a.userlevelid = e.userlevelid
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif";
 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqlusername="SELECT 
    a.pd_nickname as nama, b.userlevelname
FROM
    master_login a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
WHERE a.username='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BIAYA TINDAKAN</title>
<link rel="shortcut icon" href="../favicon.ico"/>
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

    <div align="center"><strong>RINCIAN LAYANAN RAWAT JALAN</strong></div>
<table width="100%" class="footer" border="0">
    <tr>
      <td width="18%">No. Rekam Medis</td>
      <td width="49%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="13%">Unit</td>
      <td width="20%">: <?php echo $DATA_IDENTITAS['call_unit']; ?></td>
    </tr>
    <tr>
      <td>Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['nama']; ?></td>
      <td>Pembayaran</td>
      <td>: <?php echo $DATA_IDENTITAS['carabayar']; ?></td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS['tgllahir']; ?> (<?php echo $DATA_IDENTITAS['jeniskelamin']; ?>)</td>
      <td>Tanggal Masuk</td>
      <td>: <?php echo $DATA_IDENTITAS['tglmasuk']; ?></td>
  </tr>
    <tr>
      <td>Alamat</td>
      <td colspan="3">: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
</table>
	<br>

<table width="100%" border="1" class="tabel">
  <tbody>
    <tr>
      <td width="2%">No</td>
      <td width="40%">Nama Tindakan</td>
      <td width="5%" align="center">Jumlah</td>
      <td width="17%" align="center">Tarif Pelayanan</td>
      <td width="12%" align="center">BHP</td>
      <td width="15%" align="center">Jasa Sarana</td>
      <td width="14%" align="center">Total</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryrincian)){
			echo '<tr>';
	  echo '<td class="a kosong">'.$no.'</td>';
      echo '<td class="a kosong">'.$data['nama_tindakan'].'</td>';
      echo '<td class="a kosong"><div align="center">'.$data['qty']. '</div></td>';
      echo '<td class="a kosong"><div align="right">'.number_format($data['tarif_pelayanan'], 0,",","."). '</div></td>';
	  echo '<td class="a kosong"><div align="right">'.number_format($data['tarif_bhp'], 0,",","."). '</div></td>';
	  echo '<td class="a kosong"><div align="right">'.number_format($data['tarif_jasa_sarana'], 0,",","."). '</div></td>';
	  echo '<td class="a kosong"><div align="right">'.number_format($data['total'], 0,",","."). '</div></td>';
			echo '</tr>';
			
			$no++;
		}
	?>
	
	<tr>
      <td colspan="7" style="font-size: 16px"><div align="right"><strong>TOTAL  : <?php echo 'Rp '.number_format($DATA_IDENTITAS['total'], 0,",",".").'' ?></strong></div>        
        <div align="center"></div>        <div align="center"></div>        <div align="center"></div>        <div align="center"></div>        <div align="center"></div></td>
  </tr>
	
  </tbody>
</table>

<table width="100%" style="font-size: 12px">
	<tr>
    <td width="29%">&nbsp;</td>
    <td width="39%">&nbsp;</td>
    <td width="32%" align="center">Ajibarang, <?php echo date("d-m-Y") ?></td>
  </tr>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">Petugas Kasir</td>
  </tr>
	<tr>
	  <td align="center"></td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
  </tr>
	<tr>
	  <td align="center"></td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
  </tr>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">( <?php 
	  
	  if($_GET['user']){
		  echo $_GET['user']; 
	  }else{
		echo $DATA_USERNAME['nama'];
	  }
	  
	 


	  ?> )</td>
  </tr>
</table>


</body>
</html>
<?php
$html = ob_get_clean();
require_once("dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.66 * 72, 5.51 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('notapenunjang.pdf',array('Attachment' => 0));
?>
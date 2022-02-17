<?php
ob_start();
include('connect.php');
$idxdaftar = $_GET['idxdaftar'];
$username = $_GET['username'];

$sqlitemobatrajal="SELECT 
    c.idxdaftar,SUM(a.total) - SUM(IFNULL(b.total, 0)) AS total_rajal
FROM
    bill_detail_permintaan_obat a
        LEFT JOIN
    bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    left join
    bill_detail_tarif c on a.id_bill_detail_tarif=c.id_bill_detail_tarif
WHERE
    a.userlevelid = 114 and c.idxdaftar=$idxdaftar and a.id_status_konfirmasi=2";
 $queryitemobatrajal = mysql_query($sqlitemobatrajal);
$DATA_RAJAL = mysql_fetch_array($queryitemobatrajal);

$sqlitemobatibs="SELECT 
    c.idxdaftar,SUM(a.total) - SUM(IFNULL(b.total, 0)) AS total_ibs
FROM
    bill_detail_permintaan_obat a
        LEFT JOIN
    bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    left join
    bill_detail_tarif c on a.id_bill_detail_tarif=c.id_bill_detail_tarif
WHERE
    a.userlevelid = 117 and c.idxdaftar=$idxdaftar and a.id_status_konfirmasi=2";
 $queryitemibs = mysql_query($sqlitemobatibs);
$DATA_IBS = mysql_fetch_array($queryitemibs);

$sqlitemobatranap="SELECT 
    c.idxdaftar,SUM(a.total) - SUM(IFNULL(b.total, 0)) AS total_ranap
FROM
    bill_detail_permintaan_obat a
        LEFT JOIN
    bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    left join
    bill_detail_tarif c on a.id_bill_detail_tarif=c.id_bill_detail_tarif
WHERE
    a.userlevelid = 116 and c.idxdaftar=$idxdaftar and a.id_status_konfirmasi=2";
 $queryitemranap = mysql_query($sqlitemobatranap);
$DATA_RANAP = mysql_fetch_array($queryitemranap);

$sqlitemobatigd="SELECT 
    c.idxdaftar,SUM(a.total) - SUM(IFNULL(b.total, 0)) AS total_igd
FROM
    bill_detail_permintaan_obat a
        LEFT JOIN
    bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    left join
    bill_detail_tarif c on a.id_bill_detail_tarif=c.id_bill_detail_tarif
WHERE
    a.userlevelid = 115 and c.idxdaftar=$idxdaftar and a.id_status_konfirmasi=2";
 $queryitemigd = mysql_query($sqlitemobatigd);
$DATA_IGD = mysql_fetch_array($queryitemigd);


$sqlidentitas="SELECT 
    a.id_bill_detail_tarif,
	a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y %H:%i:%s') AS tglmasuk,
    DATE_FORMAT(d.tglkeluar, '%d-%m-%Y %H:%i:%s') AS tglkeluar,
    a.total_keseluruhan,
	CONCAT(e.keterangan, ' (', ifnull(f.userlevelname,''), ')') AS status_keluar,
	sum(a.biaya_obat)-sum(ifnull(a.biaya_obat_retur,0)) as total_obat
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
WHERE
    a.idxdaftar = $idxdaftar";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqlusername="SELECT 
    a.pd_nickname as nama, b.userlevelname
FROM
    master_login a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
WHERE
    a.username = '$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USER = mysql_fetch_array($queryusername);
 
 $sqltotal="select sum(biaya_obat)-sum(ifnull(biaya_obat_retur,0)) as total_obat from bill_detail_tarif where idxdaftar=$idxdaftar";
 $querytotal = mysql_query($sqltotal);
 $DATATOTAL = mysql_fetch_array($querytotal);
 
 
 $sqladmisi="SELECT 
     a.idxdaftar, date_format(a.tanggal,'%d-%m-%Y %H:%i:%s') as tglmasuk, date_format(b.tglkeluar,'%d-%m-%Y %H:%i:%s') as tglkeluar
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    (SELECT 
        id_bill_detail_tarif, idxdaftar, tglkeluar
    FROM
        bill_detail_transfer_pasien WHERE idxdaftar=$idxdaftar
    ORDER BY idid_bill_transfer_pasien DESC
    LIMIT 1) b ON a.idxdaftar = b.idxdaftar where a.idxdaftar=$idxdaftar
ORDER BY a.id_bill_detail_tarif ASC
LIMIT 1";

 $queryadmisi = mysql_query($sqladmisi);
 $DATA_ADMISI = mysql_fetch_array($queryadmisi);


 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BIAYA KESELURUHAN</title>
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
      

    <div align="center"><strong>RINCIAN KESELURUHAN OBAT</strong></div>



<table width="100%" border="0" cellpadding="1" cellspacing="0" class="header">
    <tr>
      <td width="14%" align="left">No. Rekam Medis</td>
      <td width="41%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="22%" align="left">No. Pelayanan</td>
      <td width="23%">: <?php echo $DATA_IDENTITAS['idxdaftar']; ?></td>
    </tr>
    <tr>
      <td align="left">Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['nama']; ?></td>
      <td align="left">Status Pembayaran </td>
      <td>: <?php echo $DATA_IDENTITAS['carabayar']; ?></td>
    </tr>
    <tr>
      <td align="left">Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
      <td align="left">Tanggal Masuk</td>
      <td>: <?php echo $DATA_ADMISI['tglmasuk']; ?></td>
  </tr>
    <tr>
      <td align="left">Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS['jeniskelamin']; ?></td>
      <td align="left">Tanggal Keluar</td>
      <td>: <?php echo $DATA_ADMISI['tglkeluar']; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top">Alamat</td>
      <td valign="top">: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
      <td align="left" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
</table>




<table width="100%" class="tabel" border="1">
    <tr>
    <td width="6%" align="center" bgcolor="#FFFFFF"><strong>No</strong></td>
    <td width="60%" align="center" bgcolor="#FFFFFF"><strong>INSTALASI FARMASI</strong></td>
    <td width="34%" align="center" bgcolor="#FFFFFF"><strong>TOTAL</strong></td>
  </tr>
   
    <tr>
      <td align="center">1</td>
      <td>Farmasi Rawat Jalan</td>
      <td align="right"><?php echo number_format($DATA_RAJAL['total_rajal'], 2,",","."); ?></td>
    </tr>
 
    <tr>
      <td align="center">2</td>
      <td>Farmasi IGD</td>
      <td align="right"><?php echo number_format($DATA_IGD['total_igd'], 2,",","."); ?></td>
    </tr>
    <tr>
      <td align="center">3</td>
      <td>Farmasi Rawat Inap</td>
      <td align="right"><?php echo number_format($DATA_RANAP['total_ranap'], 2,",","."); ?></td>
    </tr>
    
    <tr>
      <td align="center">4</td>
      <td>Farmasi IBS</td>
      <td align="right"><?php echo number_format($DATA_IBS['total_ibs'], 2,",","."); ?></td>
    </tr>
   
    <tr>
      <td colspan="2" align="right">&nbsp;</td>
      <td align="right" class="total">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="right">TOTAL KESELURUHAN</td>
      <td align="right" style="font-size: 20px" class="total"><strong>Rp <?php echo number_format($DATATOTAL['total_obat'], 0,",","."); ?></strong></td>
    </tr>
    
</table>


<table width="100%" class="footer">
	<tr>
    <td width="29%">Notice :</td>
    <td width="39%">&nbsp;</td>
    <td width="32%" align="right">Ajibarang, <?php echo date("d-m-Y") ?></td>
  </tr>
	<tr>
	  <td colspan="2" align="left">Terima kasih atas kepercayaan anda kepada RSUD Ajibarang, semoga lekas sembuh</td>
	  <td align="center">Petugas Farmasi</td>
  </tr>
	<tr>
	  <td align="center"></td>
	  <td align="center">&nbsp;</td>
	  <td align="center"></td>
  </tr>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center"><?php echo $DATA_USER['nama']; ?></td>
  </tr>
</table>







</body>
</html>
<?php
 $html = ob_get_clean();
require_once("dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.27 * 72, 5.51 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('rincianobatfarmasi.pdf',array('Attachment' => 0));
?>
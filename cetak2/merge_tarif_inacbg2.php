<?php
ob_start();
session_start();
include('connect.php');
$idxdaftar_ny = $_GET['idxdaftar_ny'];
$idxdaftar_by = $_GET['idxdaftar_by'];
$idxdaftar_by2 = $_GET['idxdaftar_by2'];
$username = $_GET['username'];

$sqlidentitas="SELECT 
    a.id_bill_detail_tarif,
    a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    (SELECT 
            DATE_FORMAT(MIN(tanggal), '%d-%m-%Y %H:%i:%s')
        FROM
            bill_detail_tarif z
        WHERE
            z.idxdaftar = a.idxdaftar) AS tglmasuk,
    (SELECT 
            DATE_FORMAT(MAX(tglout), '%d-%m-%Y %H:%i:%s')
        FROM
            bill_detail_tarif z
        WHERE
            z.idxdaftar = a.idxdaftar) AS tglkeluar,
    (SELECT 
            DATE_FORMAT(MAX(tglout), '%d-%m-%Y %H:%i:%s')
        FROM
            bill_detail_tarif z
        WHERE
            z.idxdaftar = a.idxdaftar) AS tglcetak
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs2012.m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    simrs2012.m_statuskeluar e ON e.status = a.id_status_pasien
WHERE a.idxdaftar = $idxdaftar_ny 
order by a.id_bill_detail_tarif desc limit 1";
 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);



$sqlidentitas_by="SELECT 
    a.id_bill_detail_tarif,
    a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    (SELECT 
            DATE_FORMAT(MIN(tanggal), '%d-%m-%Y %H:%i:%s')
        FROM
            bill_detail_tarif z
        WHERE
            z.idxdaftar = a.idxdaftar) AS tglmasuk,
    (SELECT 
            DATE_FORMAT(MAX(tglout), '%d-%m-%Y %H:%i:%s')
        FROM
            bill_detail_tarif z
        WHERE
            z.idxdaftar = a.idxdaftar) AS tglkeluar,
    (SELECT 
            DATE_FORMAT(MAX(tglout), '%d-%m-%Y %H:%i:%s')
        FROM
            bill_detail_tarif z
        WHERE
            z.idxdaftar = a.idxdaftar) AS tglcetak
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs2012.m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    simrs2012.m_statuskeluar e ON e.status = a.id_status_pasien
WHERE a.idxdaftar = $idxdaftar_by order by id_bill_detail_tarif desc limit 1";
 $queryidentitas_by = mysql_query($sqlidentitas_by);
 $DATA_IDENTITAS_BY = mysql_fetch_array($queryidentitas_by);
 
 
 $sqlidentitas_by2="SELECT 
    a.id_bill_detail_tarif,
    a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    (SELECT 
            DATE_FORMAT(MIN(tanggal), '%d-%m-%Y %H:%i:%s')
        FROM
            bill_detail_tarif z
        WHERE
            z.idxdaftar = a.idxdaftar) AS tglmasuk,
    (SELECT 
            DATE_FORMAT(MAX(tglout), '%d-%m-%Y %H:%i:%s')
        FROM
            bill_detail_tarif z
        WHERE
            z.idxdaftar = a.idxdaftar) AS tglkeluar,
    (SELECT 
            DATE_FORMAT(MAX(tglout), '%d-%m-%Y %H:%i:%s')
        FROM
            bill_detail_tarif z
        WHERE
            z.idxdaftar = a.idxdaftar) AS tglcetak
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs2012.m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    simrs2012.m_statuskeluar e ON e.status = a.id_status_pasien
WHERE a.idxdaftar = $idxdaftar_by2 order by id_bill_detail_tarif desc limit 1";
 $queryidentitas_by2 = mysql_query($sqlidentitas_by2);
 $DATA_IDENTITAS_BY2 = mysql_fetch_array($queryidentitas_by2);



$sqladmisi="SELECT 
     a.idxdaftar, date_format(a.tanggal,'%d-%m-%Y %H:%i:%s') as tglmasuk, date_format(b.tglkeluar,'%d-%m-%Y %H:%i:%s') as tglkeluar
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    (SELECT 
        id_bill_detail_tarif, idxdaftar, tglkeluar
    FROM
        bill_detail_transfer_pasien WHERE idxdaftar=$idxdaftar_ny
    ORDER BY idid_bill_transfer_pasien DESC
    LIMIT 1) b ON a.idxdaftar = b.idxdaftar where a.idxdaftar=$idxdaftar_ny
ORDER BY a.id_bill_detail_tarif ASC
LIMIT 1";

 $queryadmisi = mysql_query($sqladmisi);
 $DATA_ADMISI = mysql_fetch_array($queryadmisi);



$sqliteminacbg="SELECT 
    a.*, b.call_unit as userlevelname, d.keterangan
FROM
    simrs.v_bill_inacbg a
        LEFT JOIN
    simrs.userlevels b ON a.userlevelid = b.userlevelid
        LEFT JOIN
    simrs.m_statuskeluar d ON a.id_status_pasien = d.status
WHERE a.idxdaftar=$idxdaftar_ny
union all
SELECT 
    a.*, b.call_unit as userlevelname, d.keterangan
FROM
    simrs.v_bill_inacbg a
        LEFT JOIN
    simrs.userlevels b ON a.userlevelid = b.userlevelid
        LEFT JOIN
    simrs.m_statuskeluar d ON a.id_status_pasien = d.status
WHERE a.idxdaftar=$idxdaftar_by
union all
SELECT 
    a.*, b.call_unit as userlevelname, d.keterangan
FROM
    simrs.v_bill_inacbg a
        LEFT JOIN
    simrs.userlevels b ON a.userlevelid = b.userlevelid
        LEFT JOIN
    simrs.m_statuskeluar d ON a.id_status_pasien = d.status
WHERE a.idxdaftar=$idxdaftar_by2";
$queryiteminacbg = mysql_query($sqliteminacbg);
$queryiteminacbg2 = mysql_query($sqliteminacbg);
$queryiteminacbg3 = mysql_query($sqliteminacbg);
$queryiteminacbg4 = mysql_query($sqliteminacbg);
$queryiteminacbg5 = mysql_query($sqliteminacbg);
$queryiteminacbg6 = mysql_query($sqliteminacbg);
$queryiteminacbg7 = mysql_query($sqliteminacbg);
$queryiteminacbg8 = mysql_query($sqliteminacbg);
$queryiteminacbg9 = mysql_query($sqliteminacbg);
$queryiteminacbg10 = mysql_query($sqliteminacbg);
$queryiteminacbg11 = mysql_query($sqliteminacbg);
$queryiteminacbg12 = mysql_query($sqliteminacbg);
$queryiteminacbg13 = mysql_query($sqliteminacbg);
$queryiteminacbg14 = mysql_query($sqliteminacbg);
$queryiteminacbg15 = mysql_query($sqliteminacbg);
$queryiteminacbg16 = mysql_query($sqliteminacbg);
$queryiteminacbg17 = mysql_query($sqliteminacbg);
$queryiteminacbg18 = mysql_query($sqliteminacbg);
$queryiteminacbg19 = mysql_query($sqliteminacbg);

$sqlitemtotal="SELECT 
    SUM(total_bedah) AS total_bedah,
    SUM(total_tenaga_ahli) AS total_tenaga_ahli,
    SUM(total_radiologi) AS total_radiologi,
    SUM(total_fisioterapi) AS total_fisioterapi,
    SUM(total_obat) AS total_obat,
    SUM(total_tmo) AS total_tmo,
    SUM(total_keperawatan) AS total_keperawatan,
    SUM(total_laboratorium) AS total_laboratorium,
    SUM(total_akomodasi) AS total_akomodasi,
    SUM(total_konsultasi) AS total_konsultasi,
    SUM(total_penunjang) AS total_penunjang,
    SUM(total_pelayanan_darah) AS total_pelayanan_darah,
    SUM(total_bhp) AS total_bhp,
    SUM(total_rawat_intensive) AS total_rawat_intensive,
    SUM(total_sewa_alat) AS total_sewa_alat,
    SUM(grand_total_keseluruhan) AS grand_total_keseluruhan
FROM
    (SELECT 
        SUM(inacbg_non_bedah) AS total_bedah,
            SUM(inacbg_tenaga_ahli) AS total_tenaga_ahli,
            SUM(inacbg_radiologi) AS total_radiologi,
            SUM(inacbg_fisioterapi) AS total_fisioterapi,
            SUM(inacbg_obat) AS total_obat,
            SUM(inacbg_tmo) AS total_tmo,
            SUM(inacbg_keperawatan) AS total_keperawatan,
            SUM(inacbg_laboratorium) AS total_laboratorium,
            SUM(inacbg_akomodasi) AS total_akomodasi,
            SUM(inacbg_konsultasi) AS total_konsultasi,
            SUM(inacbg_penunjang) AS total_penunjang,
            SUM(inacbg_pelayanan_darah) AS total_pelayanan_darah,
            SUM(inacbg_bhp) AS total_bhp,
            SUM(inacbg_rawat_intensive) AS total_rawat_intensive,
            SUM(inacbg_sewa_alat) AS total_sewa_alat,
            SUM(total_keseluruhan) AS grand_total_keseluruhan
    FROM
        simrs.v_bill_inacbg
    WHERE
        idxdaftar = $idxdaftar_ny UNION ALL SELECT 
        SUM(inacbg_non_bedah) AS total_bedah,
            SUM(inacbg_tenaga_ahli) AS total_tenaga_ahli,
            SUM(inacbg_radiologi) AS total_radiologi,
            SUM(inacbg_fisioterapi) AS total_fisioterapi,
            SUM(inacbg_obat) AS total_obat,
            SUM(inacbg_tmo) AS total_tmo,
            SUM(inacbg_keperawatan) AS total_keperawatan,
            SUM(inacbg_laboratorium) AS total_laboratorium,
            SUM(inacbg_akomodasi) AS total_akomodasi,
            SUM(inacbg_konsultasi) AS total_konsultasi,
            SUM(inacbg_penunjang) AS total_penunjang,
            SUM(inacbg_pelayanan_darah) AS total_pelayanan_darah,
            SUM(inacbg_bhp) AS total_bhp,
            SUM(inacbg_rawat_intensive) AS total_rawat_intensive,
            SUM(inacbg_sewa_alat) AS total_sewa_alat,
            SUM(total_keseluruhan) AS grand_total_keseluruhan
    FROM
        simrs.v_bill_inacbg
    WHERE
        idxdaftar = $idxdaftar_by) x";
$queryitemtotal = mysql_query($sqlitemtotal);
$DATA_TOTAL = mysql_fetch_array($queryitemtotal);

$sqlusername="SELECT 
    a.pd_nickname, b.userlevelname
FROM
    master_login a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
WHERE
    a.username = '$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);



?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>INACBG</title>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.8 cm;
			margin-right: 0.8 cm;
			margin-bottom: 0.5 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 10px;
}
	
.header {
	font-size: 10px;
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
   <center>
  <span style="font-size: 14px">RINCIAN BIAYA INACBGs</span>
</center>


<table width="100%" border="0" cellpadding="1" cellspacing="0" class="header">
    <tr>
      <td width="17%" align="left">No. Rekam Medis</td>
      <td width="32%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="21%" align="left">No. Pelayanan</td>
      <td width="30%">: <?php echo $DATA_IDENTITAS['idxdaftar']; ?></td>
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
      <td>: <?php echo $DATA_IDENTITAS['tglkeluar']; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top">Alamat</td>
      <td valign="top">: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
      <td align="left" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
</table>

<hr>


<table width="100%" border="0" cellpadding="1" cellspacing="0" class="header">
    <tr>
      <td width="17%" align="left">No. Rekam Medis</td>
      <td width="32%">: <?php echo $DATA_IDENTITAS_BY['nomr']; ?></td>
      <td width="21%" align="left">No. Pelayanan</td>
      <td width="30%">: <?php echo $DATA_IDENTITAS_BY['idxdaftar']; ?></td>
    </tr>
    <tr>
      <td align="left">Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS_BY['nama']; ?></td>
      <td align="left">Status Pembayaran </td>
      <td>: <?php echo $DATA_IDENTITAS_BY['carabayar']; ?></td>
    </tr>
    <tr>
      <td align="left">Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS_BY['tgllahir']; ?></td>
      <td align="left">Tanggal Masuk</td>
      <td>: <?php echo $DATA_IDENTITAS_BY['tglmasuk']; ?></td>
  </tr>
    <tr>
      <td align="left">Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS_BY['jeniskelamin']; ?></td>
      <td align="left">Tanggal Keluar</td>
      <td>: <?php echo $DATA_IDENTITAS_BY['tglkeluar']; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top">Alamat</td>
      <td valign="top">: <?php echo $DATA_IDENTITAS_BY['alamat']; ?></td>
      <td align="left" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
</table>


<hr>


<table width="100%" border="0" cellpadding="1" cellspacing="0" class="header">
    <tr>
      <td width="17%" align="left">No. Rekam Medis</td>
      <td width="32%">: <?php echo $DATA_IDENTITAS_BY2['nomr']; ?></td>
      <td width="21%" align="left">No. Pelayanan</td>
      <td width="30%">: <?php echo $DATA_IDENTITAS_BY2['idxdaftar']; ?></td>
    </tr>
    <tr>
      <td align="left">Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS_BY2['nama']; ?></td>
      <td align="left">Status Pembayaran </td>
      <td>: <?php echo $DATA_IDENTITAS_BY2['carabayar']; ?></td>
    </tr>
    <tr>
      <td align="left">Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS_BY2['tgllahir']; ?></td>
      <td align="left">Tanggal Masuk</td>
      <td>: <?php echo $DATA_IDENTITAS_BY2['tglmasuk']; ?></td>
  </tr>
    <tr>
      <td align="left">Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS_BY2['jeniskelamin']; ?></td>
      <td align="left">Tanggal Keluar</td>
      <td>: <?php echo $DATA_IDENTITAS_BY2['tglkeluar']; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top">Alamat</td>
      <td valign="top">: <?php echo $DATA_IDENTITAS_BY2['alamat']; ?></td>
      <td align="left" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
</table>



<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="2%">No.</td>
      <td width="15%">Nama Pelayanan</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg)){
				echo '<td align="center">'.$data['userlevelname'].'</td>';
		}
		
		?>
   		<td width="20%" rowspan="2" align="center">Sub Total Tarif</td>
    </tr>
    <tr>
       <td colspan="2">Keterangan Keluar</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg19)){
				echo '<td align="center"><strong>'.$data['keterangan'].'</strong></td>';
		}
		
		?>
	</tr>
    <tr>
      <td>1.</td>
      <td>Non Bedah</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg2)){
				echo '<td align="right">'.number_format($data['inacbg_non_bedah'], 0,",",".").'</td>';
		}
		
		?>
   		<td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_bedah'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>2.</td>
      <td>Tenaga Ahli</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg3)){
				echo '<td align="right">'.number_format($data['inacbg_tenaga_ahli'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_tenaga_ahli'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>3.</td>
      <td>Radiologi</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg4)){
				echo '<td align="right">'.number_format($data['inacbg_radiologi'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_radiologi'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>3.</td>
      <td>Rehabilitas</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg5)){
				echo '<td align="right">'.number_format($data['inacbg_fisioterapi'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_fisioterapi'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>5.</td>
      <td>Obat</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg6)){
				echo '<td align="right">'.number_format($data['inacbg_obat'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_obat'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>6.</td>
      <td>Sewa Alat</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg7)){
				echo '<td align="right">'.number_format($data['inacbg_sewa_alat'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_sewa_alat'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>7.</td>
      <td>Prosedur Bedah</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg8)){
				echo '<td align="right">'.number_format($data['inacbg_tmo'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_tmo'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>8.</td>
      <td>Keperawatan</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg9)){
				echo '<td align="right">'.number_format($data['inacbg_keperawatan'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_keperawatan'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>9.</td>
      <td>Laboratorium</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg10)){
				echo '<td align="right">'.number_format($data['inacbg_laboratorium'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_laboratorium'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>10.</td>
      <td>Akomodasi/Kamar</td>
      <?php
		while($data=mysql_fetch_assoc($queryiteminacbg11)){
				echo '<td align="right">'.number_format($data['inacbg_akomodasi'], 0,",",".").'</td>';
		}
		?>
   	 <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_akomodasi'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>11.</td>
      <td>Alkes</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg12)){
				echo '<td align="right">0</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_alkes'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>12.</td>
      <td>Konsultasi</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg13)){
				echo '<td align="right">'.number_format($data['inacbg_konsultasi'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_konsultasi'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>13.</td>
      <td>Penunjang</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg14)){
				echo '<td align="right">'.number_format($data['inacbg_penunjang'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_penunjang'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>14.</td>
      <td>Pelayanan Darah</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg15)){
				echo '<td align="right">'.number_format($data['inacbg_pelayanan_darah'], 0,",",".").'</td>';
		}
		
		?>
   		<td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_pelayanan_darah'], 0,",","."); ?></td>
    </tr>
	<tr>
      <td>15.</td>
      <td>Rawat Intensive</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg16)){
				echo '<td align="right">'.number_format($data['inacbg_rawat_intensive'], 0,",",".").'</td>';
		}
		
		?>
   		<td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_rawat_intensive'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>16.</td>
      <td>BMHP</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg17)){
				echo '<td align="right">'.number_format($data['inacbg_bhp'], 0,",",".").'</td>';
		}
		
		?>
   		<td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_bhp'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td></td>
      <td>TOTAL TARIF RS</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg18)){
				echo '<td align="right">'.number_format($data['total_keseluruhan'], 0,",",".").'</td>';
		}
		
		?>
   		<td width="15%" style="font-size: 15px" align="right"><strong>Rp. <?php echo number_format($DATA_TOTAL['grand_total_keseluruhan'], 0,",","."); ?></strong></td>
    </tr>
    
  </tbody>
</table>


<table width="100%" class="tabel">
	<tr>
    <td width="29%">&nbsp;</td>
    <td width="39%">&nbsp;</td>
    <td width="32%" align="center">Ajibarang, <?php echo $DATA_IDENTITAS['tglcetak']; ?></td>
  </tr>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">Petugas Administrasi</td>
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
	  <td align="center"><?php echo $DATA_USERNAME['pd_nickname']; ?></td>
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
$dompdf->stream('notainacbg.pdf',array('Attachment' => 0));
?>
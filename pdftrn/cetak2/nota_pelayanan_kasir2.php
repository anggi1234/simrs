<?php
ob_start();
session_start();
include('connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];
$username = $_GET['username'];
$idxdaftar = $_GET['idxdaftar'];

$sqlidentitas="SELECT 
    a.id_bill_detail_tarif,
	a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y %H:%m:%s') AS tglmasuk,
    DATE_FORMAT(d.tglkeluar, '%d-%m-%Y %H:%m:%s') AS tglkeluar,
	DATE_FORMAT(d.tglkeluar, '%d-%m-%Y') AS tglcetak,
    a.total_keseluruhan,
	CONCAT(e.keterangan, ' (', ifnull(f.userlevelname,''), ')') AS status_keluar,
	g.userlevelname
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
    a.id_bill_detail_tarif = $id_bill_detail_tarif and a.idxdaftar = $idxdaftar";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqlusername="SELECT 
    a.pd_nickname, b.userlevelname
FROM
	master_login_detail c left join
    master_login a on c.uid=a.uid
        LEFT JOIN
    userlevels b ON c.userlevelid = b.userlevelid
WHERE
    c.username = '$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);
 
 $sqltotal="select total_keseluruhan as total from bill_detail_tarif where id_bill_detail_tarif=$id_bill_detail_tarif";
 $querytotal = mysql_query($sqltotal);
 $DATA_TOTAL = mysql_fetch_array($querytotal);


$sqlrincian="select
    a.id_bill_detail_tarif,
    a.biaya_pendaftaran,
    a.biaya_jasar,
    c.nama_pendaftaran,
	c.biaya_pendaftaran as tarif_pendaftaran,
    c.biaya_jasar as tarif_jasar,
    a.biaya_akomodasi,
	(SELECT 
            count(*) as qty_pendaftaran
        FROM
            bill_detail_keterangan
        WHERE
            id_bill_detail_tarif =$id_bill_detail_tarif group by id_bill_detail_tarif) AS qty_pendaftaran,
	(SELECT 
            count(*) as qty_jasar
        FROM
            bill_detail_keterangan
        WHERE
            id_bill_detail_tarif =$id_bill_detail_tarif group by id_bill_detail_tarif) AS qty_jasar,
	(SELECT 
            SUM(QTY) as qty_akomodasi
        FROM
            bill_detail_tindakan_lain
        WHERE
            id_bill_detail_tarif =$id_bill_detail_tarif and id_jenis_tindakan=15 group by id_bill_detail_tarif) AS qty_akomodasi,
	(SELECT 
            tarif_pelayanan
        FROM
            bill_detail_tindakan_lain
        WHERE
            id_bill_detail_tarif =$id_bill_detail_tarif and id_jenis_tindakan=15 group by id_bill_detail_tarif) AS tarif_akomodasi,
    a.biaya_makan,
	(SELECT 
            qty
        FROM
            bill_detail_tindakan_lain
        WHERE
            id_bill_detail_tarif =$id_bill_detail_tarif and id_jenis_tindakan=13 group by id_bill_detail_tarif) AS qty_makan,
	(SELECT 
            tarif_pelayanan
        FROM
            bill_detail_tindakan_lain
        WHERE
            id_bill_detail_tarif =$id_bill_detail_tarif and id_jenis_tindakan=13 group by id_bill_detail_tarif) AS tarif_makan,
    a.biaya_asuhan_keperawatan,
	(SELECT 
            qty
        FROM
            bill_detail_tindakan_lain
        WHERE
            id_bill_detail_tarif =$id_bill_detail_tarif and id_jenis_tindakan=16 group by id_bill_detail_tarif) AS qty_askep,
	(SELECT 
            tarif_pelayanan
        FROM
            bill_detail_tindakan_lain
        WHERE
            id_bill_detail_tarif =$id_bill_detail_tarif and id_jenis_tindakan=16 group by id_bill_detail_tarif) AS tarif_askep,
    a.biaya_penj_non_medis,
	(SELECT 
            qty
        FROM
            bill_detail_tindakan_lain
        WHERE
            id_bill_detail_tarif =$id_bill_detail_tarif and id_jenis_tindakan=17 group by id_bill_detail_tarif) AS qty_pnm,
	(SELECT 
            tarif_pelayanan
        FROM
            bill_detail_tindakan_lain
        WHERE
            id_bill_detail_tarif =$id_bill_detail_tarif and id_jenis_tindakan=17 group by id_bill_detail_tarif) AS tarif_pnm,
	a.biaya_pel_rm,
     (SELECT 
            qty
        FROM
            bill_detail_tindakan_lain
        WHERE
            id_bill_detail_tarif =$id_bill_detail_tarif and id_jenis_tindakan=14 group by id_bill_detail_tarif) AS qty_rm,
	(SELECT 
            tarif_pelayanan
        FROM
            bill_detail_tindakan_lain
        WHERE
            id_bill_detail_tarif =$id_bill_detail_tarif and id_jenis_tindakan=14 group by id_bill_detail_tarif) AS tarif_rm,
	biaya_penj_fisioterapi,
    biaya_penj_laboratorium,
    biaya_penj_radiologi,
    biaya_pel_darah,
    biaya_obat - IFNULL(biaya_obat_retur, 0) AS biaya_farmasi,
	biaya_tind_jenazah,
	biaya_ekg,
	biaya_usg
FROM
    bill_detail_tarif a
        LEFT JOIN
    bill_detail_keterangan b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
	 left join master_admisi c on b.id_pasienbaru=c.id_pasienbaru and b.userlevelid=c.userlevelid
WHERE
    a.id_bill_detail_tarif=$id_bill_detail_tarif
	GROUP BY a.id_bill_detail_tarif";

 $queryrincian = mysql_query($sqlrincian);
 $DATA_RINCIAN = mysql_fetch_array($queryrincian);



$sqlitemdokter="SELECT 
    c.pd_nickname,d.nama_profesi,a.qty,a.tarif_dokter,a.total
FROM
    bill_detail_visit_dokter a
        LEFT JOIN
    l_dokter_standby b ON a.id_dokter_standby = b.id_dokter_standby
    left join master_login c on c.uid=b.uid
    left join master_profesi d on b.id_profesi=d.id_profesi where a.id_bill_detail_tarif=$id_bill_detail_tarif order by a.id_profesi asc";
$queryitemdokter = mysql_query($sqlitemdokter);

$sqlitemtindakan="SELECT 
    b.jenis_tindakan,
    c.type_tindakan,
    sum(a.qty) as qty,
    d.tarif_pelayanan as tarif,
    sum(IFNULL(a.total_jasa_sarana, 0) + IFNULL(a.total_pelayanan, 0)) AS total
FROM
    bill_detail_tindakan a
        LEFT JOIN
    l_jenis_tindakan b ON a.id_jenis_tindakan = b.id_jenis_tindakan
        LEFT JOIN
    l_type_tindakan c ON c.id_type_tindakan = a.id_type_tindakan
        LEFT JOIN
    master_tindakan d ON a.id_tindakan = d.id_tindakan
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif
        AND (a.id_jenis_tindakan = 1
        OR a.id_jenis_tindakan = 2
        OR a.id_jenis_tindakan = 3
        OR a.id_jenis_tindakan = 8
		OR a.id_jenis_tindakan = 22
		OR a.id_jenis_tindakan = 23)
        group by a.id_type_tindakan,a.id_jenis_tindakan
        order by a.id_jenis_tindakan asc, a.id_type_tindakan asc";
$queryitemtindakan = mysql_query($sqlitemtindakan);


$sqlitembhp="SELECT 
    b.jenis_tindakan,
    c.type_tindakan,
    sum(a.qty) as qty,
    d.tarif_bhp,
    sum(IFNULL(a.total_bhp, 0)) AS total
FROM
    bill_detail_tindakan a
        LEFT JOIN
    l_jenis_tindakan b ON a.id_jenis_tindakan = b.id_jenis_tindakan
        LEFT JOIN
    l_type_tindakan c ON c.id_type_tindakan = a.id_type_tindakan
        LEFT JOIN
    master_tindakan d ON a.id_tindakan = d.id_tindakan
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif
        AND (a.id_jenis_tindakan = 1
        OR a.id_jenis_tindakan = 2
        OR a.id_jenis_tindakan = 3
        OR a.id_jenis_tindakan = 8 OR a.id_jenis_tindakan = 22
		OR a.id_jenis_tindakan = 23)
        group by a.id_type_tindakan,a.id_jenis_tindakan
        order by a.id_jenis_tindakan asc, a.id_type_tindakan asc";
$queryitembhp = mysql_query($sqlitembhp);

$sqlitemoksigen="select 
    b.nama_tindakan,
    a.tarif_oksigen,
    a.qty_jam,
    a.qty_liter,
    a.total
FROM
    bill_detail_oksigen a
        LEFT JOIN
    v_master_tindakan_oksigen b ON a.id_tindakan_oksigen = b.id_tindakan
    where a.id_bill_detail_tarif=$id_bill_detail_tarif";
$queryitemoksigen = mysql_query($sqlitemoksigen);


$sqlitemfarmasi="SELECT 
    b.nama_obat,
    a.qty-IFNULL(c.qty, 0) AS qty,
    a.tarif_obat,
    a.total
FROM
    bill_detail_permintaan_obat a
        LEFT JOIN
    master_obat_detail d ON a.id_master_obat_detail = d.id_master_obat_detail
        LEFT JOIN
    master_obat b ON d.id_obat = b.id_obat
        LEFT JOIN
    bill_detail_permintaan_retur_obat c ON a.id_bill_detail_permintaan_obat = c.id_bill_detail_permintaan_obat
WHERE
    a.id_bill_detail_tarif=$id_bill_detail_tarif";
$queryitemfarmasi = mysql_query($sqlitemfarmasi);


$sqlitemradiologi="select b.nama_tindakan,a.qty,a.total_pelayanan+a.total_bhp+a.total_jasa_sarana as harga,a.total from bill_detail_tindakan a 
left join master_tindakan b on a.id_tindakan=b.id_tindakan
left join bill_detail_tarif_detail c on a.id_bill_detail_tarif_detail=c.id_bill_detail_tarif_detail
where a.id_bill_detail_tarif =$id_bill_detail_tarif and a.id_jenis_tindakan=4";
$queryitemradiologi = mysql_query($sqlitemradiologi);

$sqlitemlaboratorium="select b.nama_tindakan,a.qty,a.total_pelayanan+a.total_bhp+a.total_jasa_sarana as harga,a.total from bill_detail_tindakan a 
left join master_tindakan b on a.id_tindakan=b.id_tindakan
left join bill_detail_tarif_detail c on a.id_bill_detail_tarif_detail=c.id_bill_detail_tarif_detail
where a.id_bill_detail_tarif =$id_bill_detail_tarif and a.id_jenis_tindakan=5";
$queryitemlaboratorium = mysql_query($sqlitemlaboratorium);

$sqlitemfisioterapi="select b.nama_tindakan,a.qty,a.total_pelayanan+a.total_bhp+a.total_jasa_sarana as harga,a.total from bill_detail_tindakan a 
left join master_tindakan b on a.id_tindakan=b.id_tindakan
left join bill_detail_tarif_detail c on a.id_bill_detail_tarif_detail=c.id_bill_detail_tarif_detail
where a.id_bill_detail_tarif =$id_bill_detail_tarif and a.id_jenis_tindakan=20";
$queryitemfisioterapi = mysql_query($sqlitemfisioterapi);


$sqlitempelayanandarah="select b.nama_tindakan,a.qty,a.total_pelayanan+a.total_bhp+a.total_jasa_sarana as harga,a.total from bill_detail_tindakan a 
left join master_tindakan b on a.id_tindakan=b.id_tindakan
left join bill_detail_tarif_detail c on a.id_bill_detail_tarif_detail=c.id_bill_detail_tarif_detail
where a.id_bill_detail_tarif =$id_bill_detail_tarif and a.id_jenis_tindakan=7";
$queryitempelayanandarah = mysql_query($sqlitempelayanandarah);


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BIAYA PELAYANAN</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.8 cm;
			margin-right: 0.2 cm;
			margin-bottom: 0.5 cm;
			font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
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
	
body {
	margin-top: 0px;
	margin-bottom: 0px;
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
  <span style="font-size: 14px">TAGIHAN BIAYA PELAYANAN</span>
</center>



<table width="100%" border="0" cellpadding="1" cellspacing="0" class="header">
    <tr>
      <td width="14%" align="left">No. RM</td>
      <td width="41%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="24%" align="left">No. Pelayanan</td>
      <td width="21%">: <?php echo $DATA_IDENTITAS['idxdaftar']; ?></td>
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
      <td>: <?php echo $DATA_IDENTITAS['tglmasuk']; ?></td>
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
      <td align="left" valign="top">Unit</td>
      <td valign="top">: <?php echo $DATA_IDENTITAS['userlevelname']; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td align="left" valign="top">Status Pasien</td>
      <td valign="top">: <?php echo $DATA_IDENTITAS['status_keluar']; ?></td>
    </tr>
</table>




<table width="100%" border="1" class="tabel">
  <tr>
    <td width="3%" align="center" bgcolor="#FFFFFF"><strong>No</strong></td>
    <td width="40%" align="center" bgcolor="#FFFFFF"><strong>JENIS PELAYANAN</strong></td>
    <td width="20%" align="center" bgcolor="#FFFFFF"><strong>KETERANGAN</strong></td>
    <td width="6%" align="center" bgcolor="#FFFFFF"><strong>JUMLAH</strong></td>
    <td width="3%" align="center" bgcolor="#FFFFFF"><strong>X</strong></td>
    <td width="9%" align="center" bgcolor="#FFFFFF"><strong>TARIF</strong></td>
    <td width="19%" align="center" bgcolor="#FFFFFF"><strong>TOTAL</strong></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">1.</td>
    <td bgcolor="#FFFFFF">PENDAFTARAN</td>
    <td align="left" bgcolor="#FFFFFF"><?php echo $DATA_RINCIAN['nama_pendaftaran']; ?></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_pendaftaran'], 0,",","."); ?></td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_pendaftaran'], 0,",","."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_pendaftaran'], 0,",","."); ?></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">2.</td>
    <td bgcolor="#FFFFFF">JASA SARANA</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_jasar'], 0,",","."); ?></td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_jasar'], 0,",","."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_jasar'], 0,",","."); ?></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">3.</td>
    <td colspan="6" bgcolor="#FFFFFF">VISIT</td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemdokter)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['pd_nickname'].'</td>';
				echo '<td align="left">'.$data['nama_profesi'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="center">x</td>';
				echo '<td align="right">'.number_format($data['tarif_dokter'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
				
			$no++;
		}
		?>
  <tr>
    <td align="center" bgcolor="#FFFFFF">4.</td>
    <td bgcolor="#FFFFFF">AKOMODASI</td>
    <td align="left" bgcolor="#FFFFFF"></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_akomodasi'], 0,",","."); ?></td>
    <td align="center" bgcolor="#FFFFFF">x</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_akomodasi'], 0,",","."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_akomodasi'], 0,",","."); ?></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">5.</td>
    <td bgcolor="#FFFFFF">MAKAN</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_makan'], 0,",","."); ?></td>
    <td align="center" bgcolor="#FFFFFF">x</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_makan'], 0,",","."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_makan'], 0,",","."); ?></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">6.</td>
    <td bgcolor="#FFFFFF">ASUHAN KEPERAWATAN</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_askep'], 0,",","."); ?></td>
    <td align="center" bgcolor="#FFFFFF">x</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_askep'], 0,",","."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_asuhan_keperawatan'], 0,",","."); ?></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">7.</td>
    <td bgcolor="#FFFFFF">PENUNJANG NON MEDIS</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_pnm'], 0,",","."); ?></td>
    <td align="center" bgcolor="#FFFFFF">x</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_pnm'], 0,",","."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_penj_non_medis'], 0,",","."); ?></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">8.</td>
    <td colspan="6" bgcolor="#FFFFFF">PENUNJANG</td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF"><strong>- OBAT (FARMASI)</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><!--<?php echo number_format($DATA_RINCIAN['biaya_farmasi'], 0,",","."); ?>--></td>
  </tr>
  
  <?php
  		$no=a;
		while($data=mysql_fetch_assoc($queryitemfarmasi)){
	  echo '<tr>';
	  echo '<td></td>';
      echo '<td>&nbsp;&nbsp;'.$no.').'.$data['nama_obat'].'</td>';
	  echo '<td></td>';
	  echo '<td align="center">'.$data['qty'].'</td>';
	  echo '<td><center>x</center></td>';
	  echo '<td align="right">'.number_format($data['tarif_obat'], 2,",",".").'</td>';
	  echo '<td align="right">'.number_format($data['total'], 2,",",".").'</td>';
	  echo '</tr>';
			
			$no++;
		}
	?>
  
  <tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF"><strong>- LABORATORIUM</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><!--<?php echo number_format($DATA_RINCIAN['biaya_penj_laboratorium'], 0,",","."); ?>--></td>
  </tr>
  
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemlaboratorium)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>&nbsp;&nbsp;'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td></td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td><center>x</center></td>';
				echo '<td align="right">'.$data['harga'].'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
			$no++;
		}
		?>
  
  <tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF"><strong>- RADIOLOGI</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><!--<?php echo number_format($DATA_RINCIAN['biaya_penj_radiologi'], 0,",","."); ?>--></td>
  </tr>
  
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemradiologi)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>&nbsp;&nbsp;'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td></td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td><center>x</center></td>';
				echo '<td align="right">'.$data['harga'].'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
				
			$no++;
		}
		?>
  
  <tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF"><strong>- FISIOTERAPI</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><!--<?php echo number_format($DATA_RINCIAN['biaya_penj_fisioterapi'], 0,",","."); ?>--></td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemfisioterapi)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>&nbsp;&nbsp;'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td></td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td><center>x</center></td>';
				echo '<td align="right">'.$data['harga'].'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
				
			$no++;
		}
		?>

	<tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF"><strong>- PELAYANAN DARAH</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><!--<?php echo number_format($DATA_RINCIAN['biaya_pel_darah'], 0,",","."); ?>--></td>
  </tr>
  
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitempelayanandarah)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>&nbsp;&nbsp;'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td></td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td><center>x</center></td>';
				echo '<td align="right">'.$data['harga'].'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
				
			$no++;
		}
		?>


  <tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF"><strong>- PELAYANAN REKAM MEDIS &amp; SIMRS</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_rm'], 0,",","."); ?></td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_rm'], 0,",","."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_pel_rm'], 0,",","."); ?></td>
  </tr>
  
  
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF"><strong>- PEMULASARAN JENAZAH</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_tind_jenazah'], 0,",","."); ?></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">9.</td>
    <td colspan="6" bgcolor="#FFFFFF">TINDAKAN</td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemtindakan)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['jenis_tindakan'].'</td>';
				echo '<td align="left">'.$data['type_tindakan'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="center">x</td>';
				echo '<td align="right">'.number_format($data['tarif'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
				
			$no++;
		}
		?>
  <tr>
    <td align="center" bgcolor="#FFFFFF">10.</td>
    <td colspan="6" bgcolor="#FFFFFF">BHP TINDAKAN</td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitembhp)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['jenis_tindakan'].'</td>';
				echo '<td align="left">'.$data['type_tindakan'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="center">x</td>';
				echo '<td align="right">'.number_format($data['tarif_bhp'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
				
			$no++;
		}
		?>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">11.</td>
    <td bgcolor="#FFFFFF">BHP OKSIGEN</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_bhp_oksigen'], 0,",","."); ?></td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemoksigen)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td align="left">'.$data['qty_jam'].' jam</td>';
				echo '<td align="center">'.$data['qty_liter'].' liter</td>';
				echo '<td align="center">x</td>';
				echo '<td align="right">'.number_format($data['tarif_oksigen'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
				
			$no++;
		}
		?>
  <tr>
    <td align="center" bgcolor="#FFFFFF">12.</td>
    <td bgcolor="#FFFFFF">PELAYANAN MOBIL AMBULANCE / MOBIL</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_pel_ambulan'], 0,",","."); ?></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">13.</td>
    <td bgcolor="#FFFFFF">PELAYANAN KONSULTASI VCT</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_vct'], 0,",","."); ?></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">14.</td>
    <td bgcolor="#FFFFFF">PELAYANAN CT-SCAN </td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_ctscan'], 0,",","."); ?></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">15.</td>
    <td bgcolor="#FFFFFF">TINDAKAN EKG</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_ekg'], 0,",","."); ?></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">16.</td>
    <td bgcolor="#FFFFFF">TINDAKAN USG</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_usg'], 0,",","."); ?></td>
  </tr>
  <tr>
    <td colspan="7" align="center" bgcolor="#FFFFFF">
    	
    	<table width="100%" border="0">
        <tbody>
     <tr>
       <td align="center">Ajibarang, <?php echo $DATA_IDENTITAS['tglcetak']; ?></td>
       <td colspan="6" align="right">&nbsp;</td>
       <td align="right">&nbsp;</td>
     </tr>
     <tr>
       <td width="27%" align="center">Petugas Administrasi</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td width="15%" align="right">&nbsp;</td>
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
$dompdf->stream('notapelayanan.pdf',array('Attachment' => 0));
?>
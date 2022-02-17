<?php
ob_start();
session_start();
include('connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];
$username = $_GET['username'];
$idxdaftar = $_GET['idxdaftar'];

$sqlidentitas="SELECT 
    a.id_bill_detail_tarif,
	a.kelas,
	a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    concat(DATE_FORMAT(a.tanggal, '%d-%m-%Y %H:%i:%s')) AS tglmasuk,
    DATE_FORMAT(a.tglout, '%d-%m-%Y %H:%i:%s') AS tglkeluar,
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
    simrs.m_statuskeluar e ON e.status = d.id_status_keluar
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
    master_login a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
WHERE a.username='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);
 
 $sqltotal="select total_keseluruhan as total,ifnull(total_diskon,0) as total_diskon,ifnull(total_keseluruhan,0)+ifnull(total_diskon,0) as sub_total from bill_detail_tarif where id_bill_detail_tarif=$id_bill_detail_tarif";
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
            sum(qty) as qty
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
             sum(qty) as qty
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
            sum(qty) as qty
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
            sum(qty) as qty
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
	biaya_usg,
	biaya_pel_ambulan,
	biaya_bimbingan_rohani,
	biaya_ctscan
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





$sqlitemtindakan="SELECT 
    b.jenis_tindakan,
    c.type_tindakan,
    sum(a.qty) as qty,
    d.tarif_pelayanan as tarif,
    sum(IFNULL(a.total_pelayanan, 0)) AS total
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
		OR a.id_jenis_tindakan = 23
		OR a.id_jenis_tindakan = 24) and a.total_pelayanan<>0 
        group by a.id_type_tindakan,a.id_jenis_tindakan
        order by a.id_jenis_tindakan asc, a.id_type_tindakan asc";
$queryitemtindakan = mysql_query($sqlitemtindakan);

$sqlitemjasar="SELECT 
    b.jenis_tindakan,
    c.type_tindakan,
    sum(a.qty) as qty,
    d.tarif_jasa_sarana,
    sum(IFNULL(a.total_jasa_sarana, 0)) AS total
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
		OR a.id_jenis_tindakan = 9
        OR a.id_jenis_tindakan = 8 
		OR a.id_jenis_tindakan = 22
		OR a.id_jenis_tindakan = 23
		OR a.id_jenis_tindakan = 24) and a.total_jasa_sarana<>0 
        group by a.id_type_tindakan,a.id_jenis_tindakan
        order by a.id_jenis_tindakan asc, a.id_type_tindakan asc";
$queryitemjasar = mysql_query($sqlitemjasar);

$sqlitembhp="SELECT 
    b.jenis_tindakan,
    c.type_tindakan,
    SUM(a.qty) AS qty,
    e.tarif_bhp,
    SUM(IFNULL(a.total_bhp, 0)) AS total
FROM
    bill_detail_tindakan a
        LEFT JOIN
    l_jenis_tindakan b ON a.id_jenis_tindakan = b.id_jenis_tindakan
        LEFT JOIN
    l_type_tindakan c ON c.id_type_tindakan = a.id_type_tindakan
        LEFT JOIN
    master_tindakan d ON a.id_tindakan = d.id_tindakan
        LEFT JOIN
    (SELECT 
        id_type_tindakan,
            id_jenis_tindakan,
            GROUP_CONCAT(tarif_bhp
                SEPARATOR ', ') AS tarif_bhp
    FROM
        bill_detail_tindakan
    WHERE
        id_bill_detail_tarif = $id_bill_detail_tarif
    GROUP BY id_type_tindakan , id_jenis_tindakan) e ON a.id_type_tindakan = e.id_type_tindakan
        AND a.id_jenis_tindakan = e.id_jenis_tindakan
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif
        AND (a.id_jenis_tindakan = 1
        OR a.id_jenis_tindakan = 2
        OR a.id_jenis_tindakan = 3
        OR a.id_jenis_tindakan = 9
        OR a.id_jenis_tindakan = 10
        OR a.id_jenis_tindakan = 8
        OR a.id_jenis_tindakan = 22
        OR a.id_jenis_tindakan = 23
        OR a.id_jenis_tindakan = 24)
        AND a.total_bhp <> 0
GROUP BY a.id_type_tindakan , a.id_jenis_tindakan
ORDER BY a.id_jenis_tindakan ASC , a.id_type_tindakan ASC";
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
    master_tindakan b ON a.id_tindakan_oksigen = b.id_tindakan
    where a.id_bill_detail_tarif=$id_bill_detail_tarif";
$queryitemoksigen = mysql_query($sqlitemoksigen);

$sqlitemdiskon="SELECT nama_potongan,harga FROM simrs.bill_detail_potongan
    where id_bill_detail_tarif=$id_bill_detail_tarif";
$queryitemdiskon = mysql_query($sqlitemdiskon);

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
      <td width="44%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="16%" align="left">Kelas</td>
      <td width="26%">: <?php echo $DATA_IDENTITAS['kelas']; ?></td>
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
  <tr>
    <td align="center" bgcolor="#FFFFFF">1.</td>
    <td bgcolor="#FFFFFF"><strong>PENDAFTARAN</strong></td>
    <td align="left" bgcolor="#FFFFFF"></td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_pendaftaran'], 0,",","."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">2.</td>
    <td bgcolor="#FFFFFF"><strong>JASA SARANA</strong></td>
    <td align="left" bgcolor="#FFFFFF"></td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_jasar'], 0,",","."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">3.</td>
    <td bgcolor="#FFFFFF"><strong>AKOMODASI</strong></td>
    <td align="left" bgcolor="#FFFFFF"></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_akomodasi'], 0,",","."); ?></td>
    <td align="center" bgcolor="#FFFFFF">x</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_akomodasi'], 0,",","."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_akomodasi'], 0,",","."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">4.</td>
    <td bgcolor="#FFFFFF"><strong>PELAYANAN MAKAN</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_makan'], 0,",","."); ?></td>
    <td align="center" bgcolor="#FFFFFF">x</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_makan'], 0,",","."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_makan'], 0,",","."); ?></strong></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">5.</td>
    <td colspan="6" bgcolor="#FFFFFF"><strong>VISIT DOKTER</strong></td>
  </tr>
  <?php
	
	
$sqlitemdokter="SELECT 
    c.pd_nickname,d.nama_profesi,sum(a.qty) as qty,a.tarif_dokter,sum(a.qty)*a.tarif_dokter as total
FROM
    bill_detail_visit_dokter a
        LEFT JOIN
    l_dokter_standby b ON a.id_dokter_standby = b.id_dokter_standby
    left join master_login c on c.uid=b.uid
    left join master_profesi d on b.id_profesi=d.id_profesi 
	where a.id_bill_detail_tarif=$id_bill_detail_tarif and (a.id_profesi=1 or a.id_profesi=13 or a.id_profesi=19)
	group by a.id_profesi, c.kddokter
	order by a.id_profesi asc";
$queryitemdokter = mysql_query($sqlitemdokter);
	
	
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemdokter)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['pd_nickname'].'</td>';
				echo '<td align="left">'.$data['nama_profesi'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="center">x</td>';
				echo '<td align="right">'.number_format($data['tarif_dokter'], 0,",",".").'</td>';
				echo '<td align="right"><strong>'.number_format($data['total'], 0,",",".").'</strong></td>';
				echo '</tr>';
				
			$no++;
		}
		?>
  

  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">6.</td>
    <td colspan="6" bgcolor="#FFFFFF"><strong>KONSULTASI DOKTER</strong></td>
  </tr>
	<?php
	
$sqlitemkonsultasidokter="SELECT 
    c.pd_nickname,d.nama_profesi,a.qty,a.tarif_dokter,a.total
FROM
    bill_detail_visit_dokter a
        LEFT JOIN
    l_dokter_standby b ON a.id_dokter_standby = b.id_dokter_standby
    left join master_login c on c.uid=b.uid
    left join master_profesi d on b.id_profesi=d.id_profesi 
	where a.id_bill_detail_tarif=$id_bill_detail_tarif and (a.id_profesi=12)
	order by a.id_profesi asc";
$queryitemkonsuldokter = mysql_query($sqlitemkonsultasidokter);
	
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemkonsuldokter)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['pd_nickname'].'</td>';
				echo '<td align="left">'.$data['nama_profesi'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="center">x</td>';
				echo '<td align="right">'.number_format($data['tarif_dokter'], 0,",",".").'</td>';
				echo '<td align="right"><strong>'.number_format($data['total'], 0,",",".").'</strong></td>';
				echo '</tr>';
				
			$no++;
		}
		?>
	
  <tr>
    <td align="center" bgcolor="#FFFFFF">7.</td>
    <td colspan="6" bgcolor="#FFFFFF"><strong>KONSULTASI VCT</strong></td>
  </tr>
	<?php

	
$sqlitemvct="SELECT 
    c.pd_nickname,d.nama_profesi,a.qty,a.tarif_dokter,a.total
FROM
    bill_detail_visit_dokter a
        LEFT JOIN
    l_dokter_standby b ON a.id_dokter_standby = b.id_dokter_standby
    left join master_login c on c.uid=b.uid
    left join master_profesi d on b.id_profesi=d.id_profesi 
	where a.id_bill_detail_tarif=$id_bill_detail_tarif and (a.id_profesi=14)
	order by a.id_profesi asc";
$queryitemvct = mysql_query($sqlitemvct);
	
	
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemvct)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['pd_nickname'].'</td>';
				echo '<td align="left">'.$data['nama_profesi'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="center">x</td>';
				echo '<td align="right">'.number_format($data['tarif_dokter'], 0,",",".").'</td>';
				echo '<td align="right"><strong>'.number_format($data['total'], 0,",",".").'</strong></td>';
				echo '</tr>';
				
			$no++;
		}
		?>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">8.</td>
    <td colspan="6" bgcolor="#FFFFFF"><strong>VISIT FARMASI</strong></td>
  </tr>
	<?php

	
$sqlitemvisitfarmasi="SELECT 
    c.pd_nickname,d.nama_profesi,a.qty,a.tarif_dokter,a.total
FROM
    bill_detail_visit_dokter a
        LEFT JOIN
    l_dokter_standby b ON a.id_dokter_standby = b.id_dokter_standby
    left join master_login c on c.uid=b.uid
    left join master_profesi d on b.id_profesi=d.id_profesi 
	where a.id_bill_detail_tarif=$id_bill_detail_tarif and (a.id_profesi=3)
	order by a.id_profesi asc";
$queryitemvisitfarmasi= mysql_query($sqlitemvisitfarmasi);
	
	
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemvisitfarmasi)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['pd_nickname'].'</td>';
				echo '<td align="left">'.$data['nama_profesi'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="center">x</td>';
				echo '<td align="right">'.number_format($data['tarif_dokter'], 0,",",".").'</td>';
				echo '<td align="right"><strong>'.number_format($data['total'], 0,",",".").'</strong></td>';
				echo '</tr>';
				
			$no++;
		}
		?>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">9.</td>
    <td bgcolor="#FFFFFF"><strong>ASUHAN KEPERAWATAN</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_askep'], 0,",","."); ?></td>
    <td align="center" bgcolor="#FFFFFF">x</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_askep'], 0,",","."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_asuhan_keperawatan'], 0,",","."); ?></strong></td>
  </tr>
	<tr>
    <td align="center" bgcolor="#FFFFFF">10.</td>
    <td bgcolor="#FFFFFF"> <strong>PELAYANAN REKAM MEDIS &amp; SIMRS</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_rm'], 0,",","."); ?></td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_rm'], 0,",","."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_pel_rm'], 0,",","."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">11.</td>
    <td bgcolor="#FFFFFF"><strong>PENUNJANG NON MEDIS</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_pnm'], 0,",","."); ?></td>
    <td align="center" bgcolor="#FFFFFF">x</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_pnm'], 0,",","."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_penj_non_medis'], 0,",","."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">12.</td>
    <td colspan="6" bgcolor="#FFFFFF"><strong>KONSULTASI GIZI</strong></td>
  </tr>
	<?php
	
$sqlitemkonsulgizi="SELECT 
    c.pd_nickname,d.nama_profesi,a.qty,a.tarif_dokter,a.total
FROM
    bill_detail_visit_dokter a
        LEFT JOIN
    l_dokter_standby b ON a.id_dokter_standby = b.id_dokter_standby
    left join master_login c on c.uid=b.uid
    left join master_profesi d on b.id_profesi=d.id_profesi 
	where a.id_bill_detail_tarif=$id_bill_detail_tarif and (a.id_profesi=4)
	order by a.id_profesi asc";
$queryitemkonsulgizi= mysql_query($sqlitemkonsulgizi);
	
	
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemkonsulgizi)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['pd_nickname'].'</td>';
				echo '<td align="left">'.$data['nama_profesi'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="center">x</td>';
				echo '<td align="right">'.number_format($data['tarif_dokter'], 0,",",".").'</td>';
				echo '<td align="right"><strong>'.number_format($data['total'], 0,",",".").'</strong></td>';
				echo '</tr>';
				
			$no++;
		}
		?>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">13.</td>
    <td colspan="6" bgcolor="#FFFFFF"><strong>PENUNJANG</strong></td>
  </tr>

    <tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">-USG</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_usg'], 0,",","."); ?></strong></td>
  </tr>
	
  <tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">- RADIOLOGI</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_penj_radiologi'], 0,",","."); ?></strong></td>
  </tr>
  
  
	
  <tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">- PELAYANAN CT-SCAN </td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_ctscan'], 0,",","."); ?></strong></td>
  </tr>
  
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">14.</td>
    <td colspan="6" bgcolor="#FFFFFF"><strong>JASA PELAYANAN TINDAKAN</strong></td>
  </tr>
	<?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemtindakan)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['jenis_tindakan'].'</td>';
				echo '<td align="left">'.$data['type_tindakan'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="center"></td>';
				echo '<td align="right">'.number_format($data['tarif'], 0,",",".").'</td>';
				echo '<td align="right"><strong>'.number_format($data['total'], 0,",",".").'</strong></td>';
				echo '</tr>';
				
			$no++;
		}
		?>
	
  <tr>
    <td align="center" bgcolor="#FFFFFF">15.</td>
    <td colspan="6" bgcolor="#FFFFFF"><strong>JASA SARANA TINDAKAN</strong></td>
  </tr>
	<?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemjasar)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['jenis_tindakan'].'</td>';
				echo '<td align="left">'.$data['type_tindakan'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="center"></td>';
				echo '<td align="right">'.number_format($data['tarif_jasa_sarana'], 0,",",".").'</td>';
				echo '<td align="right"><strong>'.number_format($data['total'], 0,",",".").'</strong></td>';
				echo '</tr>';
				
			$no++;
		}
		?>
	<tr>
    <td align="center" bgcolor="#FFFFFF">16.</td>
    <td bgcolor="#FFFFFF"><strong>TINDAKAN EKG</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_ekg'], 0,",","."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">17.</td>
    <td bgcolor="#FFFFFF"><strong>LABORATORIUM</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_penj_laboratorium'], 0,",","."); ?></strong></td>
  </tr>
	
	<tr>
    <td align="center" bgcolor="#FFFFFF">18.</td>
    <td bgcolor="#FFFFFF"><strong>PELAYANAN DARAH</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_pel_darah'], 0,",","."); ?></strong></td>
  </tr>
  
  
	
  
  <tr>
    <td align="center" bgcolor="#FFFFFF">19.</td>
    <td colspan="6" bgcolor="#FFFFFF"><strong>BHP TINDAKAN</strong></td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitembhp)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['jenis_tindakan'].'</td>';
				echo '<td align="left">'.$data['type_tindakan'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="center"></td>';
				echo '<td align="right">'.$data['tarif_bhp'].'</td>';
				echo '<td align="right"><strong>'.number_format($data['total'], 0,",",".").'</strong></td>';
				echo '</tr>';
				
			$no++;
		}
		?>
  <tr>
    <td align="center" bgcolor="#FFFFFF">20.</td>
    <td bgcolor="#FFFFFF"><strong>FISIOTERAPI</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_penj_fisioterapi'], 0,",","."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">21.</td>
    <td bgcolor="#FFFFFF"><strong>BIMBINGAN ROHANI</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_bimbingan_rohani'], 0,",","."); ?></strong></td>
  </tr>
	<tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">22.</td>
    <td bgcolor="#FFFFFF"><strong>PEMULASARAN JENAZAH</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_tind_jenazah'], 0,",","."); ?></strong></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">23.</td>
    <td bgcolor="#FFFFFF"><strong>BHP OKSIGEN</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_bhp_oksigen'], 0,",","."); ?></strong></td>
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
				echo '<td align="right"><strong>'.number_format($data['total'], 0,",",".").'</strong></td>';
				echo '</tr>';
				
			$no++;
		}
	?>
  <tr>
    <td align="center" bgcolor="#FFFFFF">24.</td>
    <td bgcolor="#FFFFFF"><strong>PELAYANAN MOBIL AMBULANCE / MOBIL</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_pel_ambulan'], 0,",","."); ?></strong></td>
  </tr>
  
  
  
  
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">25.</td>
    <td bgcolor="#FFFFFF"><strong>OBAT (FARMASI)</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_farmasi'], 0,",","."); ?></strong></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">26.</td>
    <td colspan="6" bgcolor="#FFFFFF"><strong>RAWAT INTENSIVE</strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">27.</td>
    <td bgcolor="#FFFFFF"><strong>RINCIAN DISKON</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemdiskon)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['nama_potongan'].'</td>';
				echo '<td align="left" colspan="4"></td>';
				echo '<td align="right"><strong>'.number_format($data['harga'], 0,",",".").'</strong></td>';
				echo '</tr>';
				
			$no++;
		}
	?>
	
<?php	
$sqlitemrawatintensive="SELECT 
    d.nama_tindakan,
    a.qty AS qty,
    a.tarif_pelayanan,
    a.total_tarif_pelayanan AS total
FROM
    bill_detail_tindakan_lain a
        LEFT JOIN
    master_tindakan_lain d ON a.id_tindakan_lain = d.id_master_tindakan_lain
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif and a.id_jenis_tindakan=21";
$queryitemrawatintensive = mysql_query($sqlitemrawatintensive);
	
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemrawatintensive)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td align="left"></td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="center">x</td>';
				echo '<td align="right">'.number_format($data['tarif_pelayanan'], 0,",",".").'</td>';
				echo '<td align="right"><strong>'.number_format($data['total'], 0,",",".").'</strong></td>';
				echo '</tr>';
				
			$no++;
		}
		?>
	
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
       <td width="37%" align="center">Petugas Administrasi</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td width="18%" align="right">&nbsp;</td>
    </tr>
     <tr>
       <td align="right">&nbsp;</td>
       <td colspan="6" align="right">Sub Total</td>
       <td align="right" class="total">Rp<?php echo number_format($DATA_TOTAL['sub_total'], 0,",","."); ?>,-</td>
     </tr>
     <tr>
      <td align="right">&nbsp;</td>
      <td colspan="6" align="right">Diskon</td>
      <td align="right" class="total">Rp<?php echo number_format($DATA_TOTAL['total_diskon'], 0,",","."); ?>,-</td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_USERNAME['pd_nickname']; ?></td>
      <td colspan="6" align="right"><strong>TOTAL KESELURUHAN</strong></td>
      <td align="right" style="font-size: 17px"><strong>Rp<?php echo number_format($DATA_TOTAL['total'], 0,",","."); ?></strong></td>
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
$dompdf->stream('notaranap.pdf',array('Attachment' => 0));
?>
<?php
ob_start();
session_start();
include 'connect.php';
$idxdaftar = $_GET['idxdaftar'];
$username  = $_GET['username'];
//$username  = 'rusmiatin';
//$idxdaftar = 665939;

$sqlidentitas = "SELECT
    a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    DATE_FORMAT(d.tanggal_masuk, '%d-%m-%Y %H:%i:%s') AS tglmasuk,
    DATE_FORMAT(d.tanggal_keluar, '%d-%m-%Y %H:%i:%s') AS tglkeluar,
    DATE_FORMAT(d.tanggal_keluar, '%d-%m-%Y') AS tglcetak,
    a.total_keseluruhan,
    g.userlevelname,
    a.kelas
FROM
    data a
        LEFT JOIN
    m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    data_kamar d ON a.idxdaftar = d.idxdaftar
            LEFT JOIN
    m_statuskeluar e ON e.status = d.status
    LEFT JOIN
    userlevels g ON a.userlevelid = g.userlevelid
WHERE
    a.idxdaftar = $idxdaftar";

$queryidentitas = mysqli_query($mysqli, $sqlidentitas);
$DATA_IDENTITAS = mysqli_fetch_array($queryidentitas);

$sqlusername = "SELECT
    a.pd_nickname, b.userlevelname
FROM
    master_login a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
WHERE a.username='$username'";
$queryusername = mysqli_query($mysqli, $sqlusername);
$DATA_USERNAME = mysqli_fetch_array($queryusername);

$sqltotal   = "select total_keseluruhan as total,ifnull(total_diskon,0) as total_diskon,ifnull(total_keseluruhan,0)+ifnull(total_diskon,0) as sub_total from data where idxdaftar=$idxdaftar";
$querytotal = mysqli_query($mysqli, $sqltotal);
$DATA_TOTAL = mysqli_fetch_array($querytotal);

$sqlrincian = "select
    a.idxdaftar,
    a.biaya_pendaftaran,
    a.biaya_jasar,
    '' nama_pendaftaran,
    a.biaya_pendaftaran as tarif_pendaftaran,
    a.biaya_jasar as tarif_jasar,
    e.keterangan as status,
    a.biaya_akomodasi,
    a.biaya_bhp_oksigen,
    a.biaya_ctscan,
    a.biaya_vct,
    (SELECT
            count(*) as qty_pendaftaran
        FROM
            data_keterangan
        WHERE
            idxdaftar =$idxdaftar group by idxdaftar) AS qty_pendaftaran,
    (SELECT
            count(*) as qty_jasar
        FROM
            data_keterangan
        WHERE
            idxdaftar =$idxdaftar group by idxdaftar) AS qty_jasar,
    (SELECT
            SUM(QTY) as qty_akomodasi
        FROM
            data_tindakan_lain
        WHERE
            idxdaftar =$idxdaftar and id_jenis_tindakan=15 group by idxdaftar) AS qty_akomodasi,
    (SELECT
            tarif_pelayanan
        FROM
            data_tindakan_lain
        WHERE
            idxdaftar =$idxdaftar and id_jenis_tindakan=15 group by idxdaftar) AS tarif_akomodasi,
    a.biaya_makan,
    (SELECT
            qty
        FROM
            data_tindakan_lain
        WHERE
            idxdaftar =$idxdaftar and id_jenis_tindakan=13 group by idxdaftar) AS qty_makan,
    (SELECT
            tarif_pelayanan
        FROM
            data_tindakan_lain
        WHERE
            idxdaftar =$idxdaftar and id_jenis_tindakan=13 group by idxdaftar) AS tarif_makan,
    a.biaya_asuhan_keperawatan,
    (SELECT
            qty
        FROM
            data_tindakan_lain
        WHERE
            idxdaftar =$idxdaftar and id_jenis_tindakan=16 group by idxdaftar) AS qty_askep,
    (SELECT
            tarif_pelayanan
        FROM
            data_tindakan_lain
        WHERE
            idxdaftar =$idxdaftar and id_jenis_tindakan=16 group by idxdaftar) AS tarif_askep,
    a.biaya_penj_non_medis,
    (SELECT
            qty
        FROM
            data_tindakan_lain
        WHERE
            idxdaftar =$idxdaftar and id_jenis_tindakan=17 group by idxdaftar) AS qty_pnm,
    (SELECT
            tarif_pelayanan
        FROM
            data_tindakan_lain
        WHERE
            idxdaftar =$idxdaftar and id_jenis_tindakan=17 group by idxdaftar) AS tarif_pnm,
    a.biaya_pel_rm,
     (SELECT
            qty
        FROM
            data_tindakan_lain
        WHERE
            idxdaftar =$idxdaftar and id_jenis_tindakan=14 group by idxdaftar) AS qty_rm,
    (SELECT
            tarif_pelayanan
        FROM
            data_tindakan_lain
        WHERE
            idxdaftar =$idxdaftar and id_jenis_tindakan=14 group by idxdaftar) AS tarif_rm,
    biaya_penj_fisioterapi,
    biaya_penj_laboratorium,
    biaya_penj_radiologi,
    biaya_pel_darah,
    biaya_obat - IFNULL(biaya_obat_retur, 0) AS biaya_farmasi,
    biaya_tind_jenazah,
    biaya_ekg,
    biaya_usg,
    biaya_pel_ambulan
FROM
    data a
        LEFT JOIN
    data_keterangan b ON a.idxdaftar = b.idxdaftar
            LEFT JOIN
    m_statuskeluar e ON e.status = a.id_status_pasien
WHERE
    a.idxdaftar=$idxdaftar
    GROUP BY a.idxdaftar";

$queryrincian = mysqli_query($mysqli, $sqlrincian);
$DATA_RINCIAN = mysqli_fetch_array($queryrincian);

$status = $DATA_RINCIAN['status'];

$sqlitemtindakan = "SELECT
    b.jenis_tindakan,
    c.type_tindakan,
    sum(a.qty) as qty,
    d.tarif_pelayanan as tarif,
    sum(IFNULL(a.total_pelayanan, 0)) AS total
FROM
    data_tindakan a
        LEFT JOIN
    l_jenis_tindakan b ON a.id_jenis_tindakan = b.id_jenis_tindakan
        LEFT JOIN
    l_type_tindakan c ON c.id_type_tindakan = a.id_type_tindakan
        LEFT JOIN
    master_tindakan d ON a.id_tindakan = d.id_tindakan
WHERE
    a.idxdaftar = $idxdaftar
        AND (a.id_jenis_tindakan = 1
        OR a.id_jenis_tindakan = 2
        OR a.id_jenis_tindakan = 3
        OR a.id_jenis_tindakan = 8
		OR a.id_jenis_tindakan = 22
		OR a.id_jenis_tindakan = 23) and a.total_pelayanan<>0
        group by a.id_type_tindakan,a.id_jenis_tindakan
        order by a.id_jenis_tindakan asc, a.id_type_tindakan asc";
$queryitemtindakan = mysqli_query($mysqli, $sqlitemtindakan);

$sqlitemjasar = "SELECT
    b.jenis_tindakan,
    c.type_tindakan,
    sum(a.qty) as qty,
    d.tarif_jasa_sarana,
    sum(IFNULL(a.total_jasa_sarana, 0)) AS total
FROM
    data_tindakan a
        LEFT JOIN
    l_jenis_tindakan b ON a.id_jenis_tindakan = b.id_jenis_tindakan
        LEFT JOIN
    l_type_tindakan c ON c.id_type_tindakan = a.id_type_tindakan
        LEFT JOIN
    master_tindakan d ON a.id_tindakan = d.id_tindakan
WHERE
    a.idxdaftar = $idxdaftar
        AND (a.id_jenis_tindakan = 1
        OR a.id_jenis_tindakan = 2
        OR a.id_jenis_tindakan = 3
		OR a.id_jenis_tindakan = 9
		OR a.id_jenis_tindakan = 10
        OR a.id_jenis_tindakan = 8
		OR a.id_jenis_tindakan = 22
		OR a.id_jenis_tindakan = 23) and a.total_jasa_sarana<>0
        group by a.id_type_tindakan,a.id_jenis_tindakan
        order by a.id_jenis_tindakan asc, a.id_type_tindakan asc";
$queryitemjasar = mysqli_query($mysqli, $sqlitemjasar);

$sqlitembhp = "SELECT
    b.jenis_tindakan,
    c.type_tindakan,
    sum(a.qty) as qty,
    d.tarif_bhp,
    sum(IFNULL(a.total_bhp, 0)) AS total
FROM
    data_tindakan a
        LEFT JOIN
    l_jenis_tindakan b ON a.id_jenis_tindakan = b.id_jenis_tindakan
        LEFT JOIN
    l_type_tindakan c ON c.id_type_tindakan = a.id_type_tindakan
        LEFT JOIN
    master_tindakan d ON a.id_tindakan = d.id_tindakan
WHERE
    a.idxdaftar = $idxdaftar
        AND (a.id_jenis_tindakan = 1
        OR a.id_jenis_tindakan = 2
        OR a.id_jenis_tindakan = 3
		OR a.id_jenis_tindakan = 9
		OR a.id_jenis_tindakan = 10
        OR a.id_jenis_tindakan = 8
		OR a.id_jenis_tindakan = 22
		OR a.id_jenis_tindakan = 23) and a.total_bhp<>0
        group by a.id_type_tindakan,a.id_jenis_tindakan
        order by a.id_jenis_tindakan asc, a.id_type_tindakan asc";
$queryitembhp = mysqli_query($mysqli, $sqlitembhp);

$sqlitemoksigen = "select
    b.nama_tindakan,
    a.tarif_oksigen,
    a.qty_jam,
    a.qty_liter,
    a.total
FROM
    data_oksigen a
        LEFT JOIN
    master_tindakan b ON a.id_tindakan_oksigen = b.id_tindakan
    where a.idxdaftar=$idxdaftar";
$queryitemoksigen = mysqli_query($mysqli, $sqlitemoksigen);

$sqlitemdiskon = "SELECT nama_potongan,harga FROM data_potongan
    where idxdaftar=$idxdaftar";
$queryitemdiskon = mysqli_query($mysqli, $sqlitemdiskon);

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
	font-size: 14px;
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
      <td width="10%" rowspan="3" align="right"><img src="http://localhost/simrs/cetak/gambar/logorsud.png" height="70px" /></td>
      <td width="90%" align="center" style="font-size: 16px">PEMERINTAH KOTA PAGAR ALAM</td>
    </tr>
    <tr>
      <td align="center"><strong style="font-size: 21px">RUMAH SAKIT UMUM DAERAH BESEMAH PAGAR ALAM</strong></td>
    </tr>
    <tr>
      <td align="center" style="font-size: 14px">Jl. Ais Nasution No.03 Pagar Alam Utara<br>+62 730 621 118<br>Email:pagaralamrsudbesemah@gmail.com</td>
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
      <td valign="top">: <?php echo $status; ?></td>
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
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_pendaftaran'], 0, ",", "."); ?></td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_pendaftaran'], 0, ",", "."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_pendaftaran'], 0, ",", "."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">2.</td>
    <td bgcolor="#FFFFFF">JASA SARANA</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_jasar'], 0, ",", "."); ?></td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_jasar'], 0, ",", "."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_jasar'], 0, ",", "."); ?></strong></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">3.</td>
    <td colspan="6" bgcolor="#FFFFFF">VISIT</td>
  </tr>
  <?php
$no          = 1;
$entridokter = mysqli_query($mysqli, "SELECT
			*
		FROM
			data_visit_dokter a
				LEFT JOIN
			l_dokter_standby b ON a.id_dokter_standby = b.id_dokter_standby
			left join master_login c on c.uid=b.uid
			left join master_profesi d on b.id_profesi=d.id_profesi where a.idxdaftar=$idxdaftar order by a.id_profesi asc");

if (mysqli_num_rows($entridokter) == 0) {
    $sqlitemdokter = mysqli_query($mysqli, "SELECT
				b.nama_dokter as pd_nickname,
				'1' AS qty,
				a.temp_biaya_pemeriksaan AS tarif_dokter,
				d.nama_profesi,
				a.temp_biaya_pemeriksaan AS total
			FROM
				data a
					LEFT JOIN
				m_dokter b ON a.kddokter = b.kddokter
					AND a.userlevelid = b.userlevelid
					LEFT JOIN
				master_login c ON b.kddokter = c.kddokter
					LEFT JOIN
				master_profesi d ON c.id_profesi = d.id_profesi
			WHERE
				a.idxdaftar = $idxdaftar and a.kdcarabayar=1");
} else {
    $sqlitemdokter = mysqli_query($mysqli, "SELECT
    c.pd_nickname,d.nama_profesi,a.qty,a.tarif_dokter,a.total
FROM
    data_visit_dokter a
        LEFT JOIN
    l_dokter_standby b ON a.id_dokter_standby = b.id_dokter_standby
    left join master_login c on c.uid=b.uid
    left join master_profesi d on b.id_profesi=d.id_profesi where a.idxdaftar=$idxdaftar order by a.id_profesi asc");
}
while ($data = mysqli_fetch_array($sqlitemdokter)) {
    echo '<tr>';
    echo '<td></td>';
    echo '<td>' . $no . '). ' . $data['pd_nickname'] . '</td>';
    echo '<td align="left">' . $data['nama_profesi'] . '</td>';
    echo '<td align="center">' . $data['qty'] . '</td>';
    echo '<td align="center">x</td>';
    echo '<td align="right">' . number_format($data['tarif_dokter'], 0, ",", ".") . '</td>';
    echo '<td align="right"><strong>' . number_format($data['total'], 0, ",", ".") . '</strong></td>';
    echo '</tr>';

    $no++;
}
?>
  <tr>
    <td align="center" bgcolor="#FFFFFF">4.</td>
    <td bgcolor="#FFFFFF">AKOMODASI</td>
    <td align="left" bgcolor="#FFFFFF"></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_akomodasi'], 0, ",", "."); ?></td>
    <td align="center" bgcolor="#FFFFFF">x</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_akomodasi'], 0, ",", "."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_akomodasi'], 0, ",", "."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">5.</td>
    <td bgcolor="#FFFFFF">MAKAN</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_makan'], 0, ",", "."); ?></td>
    <td align="center" bgcolor="#FFFFFF">x</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_makan'], 0, ",", "."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_makan'], 0, ",", "."); ?></strong></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">6.</td>
    <td bgcolor="#FFFFFF">ASUHAN KEPERAWATAN</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_askep'], 0, ",", "."); ?></td>
    <td align="center" bgcolor="#FFFFFF">x</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_askep'], 0, ",", "."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_asuhan_keperawatan'], 0, ",", "."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">7.</td>
    <td bgcolor="#FFFFFF">PENUNJANG NON MEDIS</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_pnm'], 0, ",", "."); ?></td>
    <td align="center" bgcolor="#FFFFFF">x</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_pnm'], 0, ",", "."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_penj_non_medis'], 0, ",", "."); ?></strong></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">8.</td>
    <td colspan="6" bgcolor="#FFFFFF">PENUNJANG</td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">- OBAT (FARMASI)</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_farmasi'], 0, ",", "."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">- LABORATORIUM</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_penj_laboratorium'], 0, ",", "."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">- RADIOLOGI</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_penj_radiologi'], 0, ",", "."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">- FISIOTERAPI</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_penj_fisioterapi'], 0, ",", "."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF"> - PELAYANAN REKAM MEDIS &amp; SIMRS</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_rm'], 0, ",", "."); ?></td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_rm'], 0, ",", "."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_pel_rm'], 0, ",", "."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">- PELAYANAN DARAH</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_pel_darah'], 0, ",", "."); ?></strong></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">- PEMULASARAN JENAZAH</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_tind_jenazah'], 0, ",", "."); ?></strong></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">9.</td>
    <td colspan="6" bgcolor="#FFFFFF">TINDAKAN</td>
  </tr>
  <?php
$no = 1;
while ($data = mysqli_fetch_assoc($queryitemtindakan)) {
    echo '<tr>';
    echo '<td></td>';
    echo '<td>' . $no . '). ' . $data['jenis_tindakan'] . '</td>';
    echo '<td align="left">' . $data['type_tindakan'] . '</td>';
    echo '<td align="center">' . $data['qty'] . '</td>';
    echo '<td align="center">x</td>';
    echo '<td align="right">' . number_format($data['tarif'], 0, ",", ".") . '</td>';
    echo '<td align="right"><strong>' . number_format($data['total'], 0, ",", ".") . '</strong></td>';
    echo '</tr>';

    $no++;
}
?>
  <tr>
    <td align="center" bgcolor="#FFFFFF">10.</td>
    <td colspan="6" bgcolor="#FFFFFF">JASA SARANA TINDAKAN</td>
  </tr>
	<?php
$no = 1;
while ($data = mysqli_fetch_assoc($queryitemjasar)) {
    echo '<tr>';
    echo '<td></td>';
    echo '<td>' . $no . '). ' . $data['jenis_tindakan'] . '</td>';
    echo '<td align="left">' . $data['type_tindakan'] . '</td>';
    echo '<td align="center">' . $data['qty'] . '</td>';
    echo '<td align="center">x</td>';
    echo '<td align="right">' . number_format($data['tarif'], 0, ",", ".") . '</td>';
    echo '<td align="right"><strong>' . number_format($data['total'], 0, ",", ".") . '</strong></td>';
    echo '</tr>';

    $no++;
}
?>
  <tr>
    <td align="center" bgcolor="#FFFFFF">11.</td>
    <td colspan="6" bgcolor="#FFFFFF">BHP TINDAKAN</td>
  </tr>
  <?php
$no = 1;
while ($data = mysqli_fetch_assoc($queryitembhp)) {
    echo '<tr>';
    echo '<td></td>';
    echo '<td>' . $no . '). ' . $data['jenis_tindakan'] . '</td>';
    echo '<td align="left">' . $data['type_tindakan'] . '</td>';
    echo '<td align="center">' . $data['qty'] . '</td>';
    echo '<td align="center">x</td>';
    echo '<td align="right">' . number_format($data['tarif_bhp'], 0, ",", ".") . '</td>';
    echo '<td align="right"><strong>' . number_format($data['total'], 0, ",", ".") . '</strong></td>';
    echo '</tr>';

    $no++;
}
?>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">12.</td>
    <td bgcolor="#FFFFFF">BHP OKSIGEN</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_bhp_oksigen'], 0, ",", "."); ?></strong></td>
  </tr>
  <?php
$no = 1;
while ($data = mysqli_fetch_assoc($queryitemoksigen)) {
    echo '<tr>';
    echo '<td></td>';
    echo '<td>' . $no . '). ' . $data['nama_tindakan'] . '</td>';
    echo '<td align="left">' . $data['qty_jam'] . ' jam</td>';
    echo '<td align="center">' . $data['qty_liter'] . ' liter</td>';
    echo '<td align="center">x</td>';
    echo '<td align="right">' . number_format($data['tarif_oksigen'], 0, ",", ".") . '</td>';
    echo '<td align="right"><strong>' . number_format($data['total'], 0, ",", ".") . '</strong></td>';
    echo '</tr>';

    $no++;
}
?>
  <tr>
    <td align="center" bgcolor="#FFFFFF">13.</td>
    <td bgcolor="#FFFFFF">PELAYANAN MOBIL AMBULANCE / MOBIL</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_pel_ambulan'], 0, ",", "."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">14.</td>
    <td bgcolor="#FFFFFF">PELAYANAN KONSULTASI VCT</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_vct'], 0, ",", "."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">15.</td>
    <td bgcolor="#FFFFFF">PELAYANAN CT-SCAN </td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_ctscan'], 0, ",", "."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">16.</td>
    <td bgcolor="#FFFFFF">TINDAKAN EKG</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_ekg'], 0, ",", "."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">17.</td>
    <td bgcolor="#FFFFFF">TINDAKAN USG</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><strong><?php echo number_format($DATA_RINCIAN['biaya_usg'], 0, ",", "."); ?></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">18.</td>
    <td bgcolor="#FFFFFF">RINCIAN DISKON</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>

  <?php
$no = 1;
while ($data = mysqli_fetch_assoc($queryitemdiskon)) {
    echo '<tr>';
    echo '<td></td>';
    echo '<td>' . $no . '). ' . $data['nama_potongan'] . '</td>';
    echo '<td align="left" colspan="4"></td>';
    echo '<td align="right"><strong>' . number_format($data['harga'], 0, ",", ".") . '</strong></td>';
    echo '</tr>';

    $no++;
}
?>

  <tr>
    <td colspan="7" align="center" bgcolor="#FFFFFF">

    	<table width="100%" border="0">
        <tbody>
     <tr>
       <td align="center">Pagaralam, <?php echo $DATA_IDENTITAS['tglcetak']; ?></td>
       <td colspan="6" align="right">&nbsp;</td>
       <td align="right">&nbsp;</td>
     </tr>
     <tr>
       <td width="27%" align="center">Petugas Administrasi</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td width="22%" align="right">&nbsp;</td>
    </tr>
     <tr>
       <td align="right">&nbsp;</td>
       <td colspan="6" align="right">Sub Total</td>
       <td align="right" class="total">Rp<?php echo number_format($DATA_TOTAL['sub_total'], 0, ",", "."); ?>,-</td>
     </tr>
     <tr>
      <td align="right">&nbsp;</td>
      <td colspan="6" align="right">Diskon</td>
      <td align="right">Rp<?php echo number_format($DATA_TOTAL['total_diskon'], 0, ",", "."); ?>,-</td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_USERNAME['pd_nickname']; ?></td>
      <td colspan="6" align="right"><strong>TOTAL KESELURUHAN</strong></td>
      <td align="right" style="font-size: 20px"><strong>Rp<?php echo number_format($DATA_TOTAL['total'], 0, ",", "."); ?>,-</strong></td>
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
require_once "../vendor/autoload.php";
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->setIsRemoteEnabled(true);
$dompdf = new Dompdf($options);
$paper_size = [0, 0, 8.26 * 72, 12.99 * 72];
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('notapelayanan.pdf', ['Attachment' => 0]);
?>
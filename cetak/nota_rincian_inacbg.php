<?php
ob_start();
session_start();
include 'connect.php';
$idxdaftar = $_GET['idxdaftar'];
$username = $_GET['username'];
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
    DATE_FORMAT(a.tanggal, '%d-%m-%Y %H:%i:%s') AS tglmasuk,
    DATE_FORMAT(d.tglkeluar, '%d-%m-%Y %H:%i:%s') AS tglkeluar,
	DATE_FORMAT(d.tglkeluar, '%d-%m-%Y') AS tglcetak,
    a.total_keseluruhan,
	CONCAT(e.keterangan, ' (', ifnull(f.userlevelname,''), ')') AS status_keluar
FROM
    data a
        LEFT JOIN
    m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    bill_detail_transfer_pasien d ON a.idxdaftar = d.idxdaftar
	    LEFT JOIN
    m_statuskeluar e ON e.status = d.id_status_keluar
        LEFT JOIN
    userlevels f ON d.userlevelid_transfer = f.userlevelid
WHERE a.idxdaftar = $idxdaftar order by idxdaftar desc limit 1";
$queryidentitas = mysqli_query($mysqli, $sqlidentitas);
$DATA_IDENTITAS = mysqli_fetch_array($queryidentitas);

$sqladmisi = "SELECT
     a.idxdaftar, date_format(a.tanggal,'%d-%m-%Y %H:%i:%s') as tglmasuk, date_format(b.tglout,'%d-%m-%Y %H:%i:%s') as tglkeluar
FROM
    data a
        LEFT JOIN
    (SELECT
        idxdaftar, tglout
    FROM
        data WHERE idxdaftar=$idxdaftar and userlevelid <> 40
     ORDER BY tglout DESC
    LIMIT 1) b ON a.idxdaftar = b.idxdaftar where a.idxdaftar=$idxdaftar
ORDER BY a.idxdaftar ASC
LIMIT 1";

$queryadmisi = mysqli_query($mysqli, $sqladmisi);
$DATA_ADMISI = mysqli_fetch_array($queryadmisi);

$sqliteminacbg = "SELECT
    a.*, b.userlevelname, c.keterangan
FROM
    v_bill_inacbg a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
        LEFT JOIN
    m_statuskeluar c ON a.id_status_pasien = c.status
WHERE
    a.idxdaftar = $idxdaftar";
$queryiteminacbg   = mysqli_query($mysqli, $sqliteminacbg);
$queryiteminacbg2  = mysqli_query($mysqli, $sqliteminacbg);
$queryiteminacbg3  = mysqli_query($mysqli, $sqliteminacbg);
$queryiteminacbg4  = mysqli_query($mysqli, $sqliteminacbg);
$queryiteminacbg5  = mysqli_query($mysqli, $sqliteminacbg);
$queryiteminacbg6  = mysqli_query($mysqli, $sqliteminacbg);
$queryiteminacbg7  = mysqli_query($mysqli, $sqliteminacbg);
$queryiteminacbg8  = mysqli_query($mysqli, $sqliteminacbg);
$queryiteminacbg9  = mysqli_query($mysqli, $sqliteminacbg);
$queryiteminacbg10 = mysqli_query($mysqli, $sqliteminacbg);
$queryiteminacbg11 = mysqli_query($mysqli, $sqliteminacbg);
$queryiteminacbg12 = mysqli_query($mysqli, $sqliteminacbg);
$queryiteminacbg13 = mysqli_query($mysqli, $sqliteminacbg);
$queryiteminacbg14 = mysqli_query($mysqli, $sqliteminacbg);
$queryiteminacbg15 = mysqli_query($mysqli, $sqliteminacbg);
$queryiteminacbg16 = mysqli_query($mysqli, $sqliteminacbg);
$queryiteminacbg17 = mysqli_query($mysqli, $sqliteminacbg);
$queryiteminacbg18 = mysqli_query($mysqli, $sqliteminacbg);
$queryiteminacbg19 = mysqli_query($mysqli, $sqliteminacbg);

$sqlitemtotal = "SELECT
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
    v_bill_inacbg
WHERE
    idxdaftar=$idxdaftar";
$queryitemtotal = mysqli_query($mysqli, $sqlitemtotal);
$DATA_TOTAL     = mysqli_fetch_array($queryitemtotal);

$sqlusername = "SELECT
    a.pd_nickname, b.userlevelname, a.signature
FROM
    master_login a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
WHERE
    a.username = '$username'";
$queryusername = mysqli_query($mysqli, $sqlusername);
$DATA_USERNAME = mysqli_fetch_array($queryusername);

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
      <td width="10%" rowspan="3" align="right"><img src="http://localhost/simrs/cetak/gambar/logorsud.png" height="50px" /></td>
      <td width="90%" align="center" style="font-size: 12px">PEMERINTAH KOTA PAGAR ALAM</td>
    </tr>
    <tr>
      <td align="center"><strong style="font-size: 17px">RUMAH SAKIT UMUM DAERAH BESEMAH PAGAR ALAM</strong></td>
    </tr>
    <tr>
      <td align="center" style="font-size: 10px">Jl. Ais Nasution No.03 Pagar Alam Utara<br>+62 730 621 118<br>Email:pagaralamrsudbesemah@gmail.com</td>
    </tr>
</table>
<hr>
   <center>
  <span style="font-size: 14px;">RINCIAN BIAYA INACBGs</span>
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
      <td>: <?php echo $DATA_ADMISI['tglkeluar']; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top">Alamat</td>
      <td colspan="3" valign="top">: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
</table>


<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="2%">No.</td>
      <td width="15%">Nama Pelayanan</td>
      <?php

while ($data = mysqli_fetch_assoc($queryiteminacbg)) {
    echo '<td align="center">' . $data['userlevelname'] . '</td>';
}

?>
   		<td width="20%" rowspan="2" align="center">Sub Total Tarif</td>
    </tr>
    <tr>
       <td colspan="2">Keterangan Keluar</td>
      <?php

while ($data = mysqli_fetch_assoc($queryiteminacbg19)) {
    echo '<td align="center"><strong>' . $data['keterangan'] . '</strong></td>';
}

?>
	</tr>
    <tr>
      <td>1.</td>
      <td>Non Bedah</td>
      <?php

while ($data = mysqli_fetch_assoc($queryiteminacbg2)) {
    echo '<td align="right">' . number_format($data['inacbg_non_bedah'], 0, ",", ".") . '</td>';
}

?>
   		<td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_bedah'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>2.</td>
      <td>Tenaga Ahli</td>
      <?php

while ($data = mysqli_fetch_assoc($queryiteminacbg3)) {
    echo '<td align="right">' . number_format($data['inacbg_tenaga_ahli'], 0, ",", ".") . '</td>';
}

?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_tenaga_ahli'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>3.</td>
      <td>Radiologi</td>
      <?php

while ($data = mysqli_fetch_assoc($queryiteminacbg4)) {
    echo '<td align="right">' . number_format($data['inacbg_radiologi'], 0, ",", ".") . '</td>';
}

?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_radiologi'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>3.</td>
      <td>Rehabilitas</td>
      <?php

while ($data = mysqli_fetch_assoc($queryiteminacbg5)) {
    echo '<td align="right">' . number_format($data['inacbg_fisioterapi'], 0, ",", ".") . '</td>';
}

?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_fisioterapi'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>5.</td>
      <td>Obat</td>
      <?php

while ($data = mysqli_fetch_assoc($queryiteminacbg6)) {
    echo '<td align="right">' . number_format($data['inacbg_obat'], 0, ",", ".") . '</td>';
}

?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_obat'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>6.</td>
      <td>Sewa Alat</td>
      <?php

while ($data = mysqli_fetch_assoc($queryiteminacbg7)) {
    echo '<td align="right">' . number_format($data['inacbg_sewa_alat'], 0, ",", ".") . '</td>';
}

?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_sewa_alat'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>7.</td>
      <td>Prosedur Bedah</td>
      <?php

while ($data = mysqli_fetch_assoc($queryiteminacbg8)) {
    echo '<td align="right">' . number_format($data['inacbg_tmo'], 0, ",", ".") . '</td>';
}

?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_tmo'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>8.</td>
      <td>Keperawatan</td>
      <?php

while ($data = mysqli_fetch_assoc($queryiteminacbg9)) {
    echo '<td align="right">' . number_format($data['inacbg_keperawatan'], 0, ",", ".") . '</td>';
}

?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_keperawatan'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>9.</td>
      <td>Laboratorium</td>
      <?php

while ($data = mysqli_fetch_assoc($queryiteminacbg10)) {
    echo '<td align="right">' . number_format($data['inacbg_laboratorium'], 0, ",", ".") . '</td>';
}

?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_laboratorium'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>10.</td>
      <td>Akomodasi/Kamar</td>
      <?php
while ($data = mysqli_fetch_assoc($queryiteminacbg11)) {
    echo '<td align="right">' . number_format($data['inacbg_akomodasi'], 0, ",", ".") . '</td>';
}
?>
   	 <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_akomodasi'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>11.</td>
      <td>Alkes</td>
      <?php

while ($data = mysqli_fetch_assoc($queryiteminacbg12)) {
    echo '<td align="right">0</td>';
}

?>
   <td width="15%" align="right"><?php //echo number_format($DATA_TOTAL['total_alkes'], 0, ",", "."); ?>0</td>
    </tr>
    <tr>
      <td>12.</td>
      <td>Konsultasi</td>
      <?php

while ($data = mysqli_fetch_assoc($queryiteminacbg13)) {
    echo '<td align="right">' . number_format($data['inacbg_konsultasi'], 0, ",", ".") . '</td>';
}

?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_konsultasi'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>13.</td>
      <td>Penunjang</td>
      <?php

while ($data = mysqli_fetch_assoc($queryiteminacbg14)) {
    echo '<td align="right">' . number_format($data['inacbg_penunjang'], 0, ",", ".") . '</td>';
}

?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_penunjang'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>14.</td>
      <td>Pelayanan Darah</td>
      <?php

while ($data = mysqli_fetch_assoc($queryiteminacbg15)) {
    echo '<td align="right">' . number_format($data['inacbg_pelayanan_darah'], 0, ",", ".") . '</td>';
}

?>
   		<td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_pelayanan_darah'], 0, ",", "."); ?></td>
    </tr>
	<tr>
      <td>15.</td>
      <td>Rawat Intensive</td>
      <?php

while ($data = mysqli_fetch_assoc($queryiteminacbg16)) {
    echo '<td align="right">' . number_format($data['inacbg_rawat_intensive'], 0, ",", ".") . '</td>';
}

?>
   		<td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_rawat_intensive'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>16.</td>
      <td>BMHP</td>
      <?php

while ($data = mysqli_fetch_assoc($queryiteminacbg17)) {
    echo '<td align="right">' . number_format($data['inacbg_bhp'], 0, ",", ".") . '</td>';
}

?>
   		<td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_bhp'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td></td>
      <td>TOTAL TARIF RS</td>
      <?php

while ($data = mysqli_fetch_assoc($queryiteminacbg18)) {
    echo '<td align="right">' . number_format($data['total_keseluruhan'], 0, ",", ".") . '</td>';
}

?>
   		<td width="15%" style="font-size: 15px" align="right"><strong>Rp. <?php echo number_format($DATA_TOTAL['grand_total_keseluruhan'], 0, ",", "."); ?></strong></td>
    </tr>

  </tbody>
</table>


<table width="100%" class="tabel">
	<tr>
	  <td>Petugas Administrasi wajib melakukan verifikasi data billing dengan cara klik <strong>SELESAI</strong> pada menu Administrasi Pelayanan</td>
	  <td align="center">Pagaralam, <?php echo $DATA_IDENTITAS['tglcetak']; ?></td>
  </tr>
	<tr>
    <td><strong>Penanggung Jawab Administrasi:</strong></td>
    <td width="41%" align="center">Petugas Administrasi</td>
  </tr>
	<tr>
	  <td rowspan="3" valign="top">


  <?php
$sqlitempj = "SELECT
    b.pd_nickname, c.userlevelname
FROM
    data a
        LEFT JOIN
    master_login b ON a.uidadm = b.username
        LEFT JOIN
    userlevels c ON a.userlevelid = c.userlevelid
WHERE
    a.idxdaftar = $idxdaftar
ORDER BY a.tanggal ASC";
$queryitempj = mysqli_query($mysqli, $sqlitempj);

$no = 1;
while ($data = mysqli_fetch_assoc($queryitempj)) {
    echo '' . $no . '. ' . $data['userlevelname'] . ' (Adm: ' . $data['pd_nickname'] . ') <br>';
    $no++;
}
?>


      </td>
	  <td align="center">
      <center><img height="40px" src=""/><br>
      <?php echo $DATA_USERNAME['pd_nickname']; ?></center>
    </td>
  </tr>
	<tr>
	  <td align="center">&nbsp;</td>
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
$paper_size = [0, 0, 8.26 * 72, 14 * 72];
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('50_inacbg.pdf', ['Attachment' => 0]);
?>
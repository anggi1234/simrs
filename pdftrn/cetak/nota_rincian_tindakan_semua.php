<?php
ob_start();
include 'connect.php';
$idxdaftar = $_GET['idxdaftar'];
$username = $_GET['username'];
//$username  = 'rusmiatin';
//$idxdaftar = 665939;

$sqlitem = "SELECT
    b.nama_tindakan,
    a.qty,
    a.tarif_pelayanan,
    a.tarif_bhp,
    a.tarif_jasa_sarana,
    a.total
FROM
    data_tindakan a
        LEFT JOIN
    master_tindakan b ON a.id_tindakan = b.id_tindakan
WHERE
    a.idxdaftar = $idxdaftar and b.userlevelid is null";
$queryitem = mysqli_query($mysqli, $sqlitem);

$sqlidentitas = "SELECT
    a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(d.tanggal_keluar, '%d-%m-%Y') AS tglcetak,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y %H:%i:%s') AS tglmasuk,
    DATE_FORMAT(d.tanggal_keluar, '%d-%m-%Y %H:%i:%s') AS tglkeluar,
    DATE_FORMAT(d.tanggal_keluar, '%d-%m-%Y') AS tglcetak,
    a.total_keseluruhan,
    e.keterangan AS status_keluar,
    g.userlevelname as unit
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

$sqltotal = "SELECT
    SUM(a.total) as total
FROM
    data_tindakan a
        LEFT JOIN
    master_tindakan b ON a.id_tindakan = b.id_tindakan
WHERE
    idxdaftar = $idxdaftar and b.userlevelid is null";
$querytotal = mysqli_query($mysqli, $sqltotal);
$DATA_TOTAL = mysqli_fetch_array($querytotal);

$sqlusername = "SELECT
    a.pd_nickname, b.userlevelname
FROM
    master_login a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
WHERE
    a.username ='$username'";
$queryusername = mysqli_query($mysqli, $sqlusername);
$DATA_USERNAME = mysqli_fetch_array($queryusername);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Rincian Tindakan</title>
<style type="text/css">

	@page {
            margin-top: 0.5 cm;
            margin-left: 1 cm;
			margin-right: 1.5 cm;
			margin-bottom: 0.5 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}

.tabelfix {
    border-collapse:collapse;
	font-size: 18px;
}
.header {
	font-size: 18px;
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

<table width="100%" height="52" border="0">
  <tr>
    <td width="100%" class="header"><div align="center"><strong>RINCIAN TINDAKAN</strong></div></td>
  </tr>
</table>

	<table width="100%" border="0" cellpadding="1" cellspacing="0" class="header">
    <tr>
      <td width="18%" align="left">No. Rekam Medis</td>
      <td width="39%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="18%" align="left">No. Pelayanan</td>
      <td width="25%">: <?php echo $DATA_IDENTITAS['idxdaftar']; ?></td>
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
      <td valign="top">: <?php echo $DATA_IDENTITAS['unit']; ?></td>
    </tr>
</table>

<hr>
<table width="100%" class="tabelfix" border="1">
    <tr>
      <td width="6%" align="center" class="a"><strong>No.</strong></td>
      <td width="41%" align="center" class="a"><strong>PEMERIKSAAN/TINDAKAN</strong></td>
      <td width="12%" align="center" class="a"><strong>QTY</strong></td>
      <td width="12%" align="center" class="a"><strong>TARIF</strong></td>
      <td width="11%" align="center" class="a"><strong>BHP</strong></td>
      <td width="12%" align="center" class="a"><strong>JASA SARANA</strong></td>
      <td width="18%" align="center" class="a"><strong>SUB TOTAL</strong></td>
  </tr>
	<?php
if (mysqli_num_rows($queryitem) == 0) {
    echo '<tr><td colspan="7"><br><br></td></tr>';
} else {
    $no = 1;
    while ($data = mysqli_fetch_assoc($queryitem)) {
        echo '<tr>';
        echo '<td class="a"><div align="center">' . $no . '</div></td>';
        echo '<td class="a">' . $data['nama_tindakan'] . '</td>';
        echo '<td class="a" align="right">' . $data['qty'] . '</td>';
        echo '<td class="a" align="right">' . $data['tarif_pelayanan'] . '</td>';
        echo '<td class="a" align="right">' . $data['tarif_bhp'] . '</td>';
        echo '<td class="a"><div align="right">' . $data['tarif_jasa_sarana'] . '</div></td>';
        echo '<td class="a" align="right">' . number_format($data['total'], 0, ",", ".") . '</td>';
        echo '</tr>';
        $no++;
    }
}

?>
        <tr>
      <td align="right" style="font-size: 30px" colspan="7" class="a">
		  <strong>TOTAL  : <?php echo 'Rp ' . number_format($DATA_TOTAL['total'], 0, ",", ".") . '' ?></strong>
	  </td>
  </tr>
</table>

<table width="100%" class="header">
	<tr>
    <td width="29%">&nbsp;</td>
    <td width="39%">&nbsp;</td>
    <td width="32%" align="center">Pagaralam, <?php echo date("d-m-Y") ?></td>
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
	  <td align="center">( <?php echo $DATA_USERNAME['pd_nickname']; ?> )</td>
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
$paper_size = [0, 0, 12.99 * 72, 8.26 * 72];
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('tindakan.pdf', ['Attachment' => 0]);
?>
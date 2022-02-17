<?php
ob_start();
include '../connect.php';
session_start();

// $id_spj_gu = $_GET['id_spj_gu'];
$id_spj_gu = "";

$sqlidentitas = "SELECT
    b.kode_rekening,
    b.nama_rekening3,
    a.kode_spj,
    a.tanggal_spj,
    YEAR(tanggal_spj) AS tahun_anggaran
FROM
    keu_spj_gu a
        LEFT JOIN
    master_rekening3 b ON a.id_master_rekening3 = b.id_master_rekening3
WHERE
    a.id_spj_gu=$id_spj_gu";
$queryidentitas = mysqli_query($mysqli, $sqlidentitas);
$DATA_IDENTITAS = mysqli_fetch_array($queryidentitas);

$sqlttd = "SELECT
    nama_jabatan, nama_pejabat, nip
FROM
    master_jabatan
WHERE
    id_jabatan = 4";
$queryttd = mysqli_query($mysqli, $sqlttd);
$DATA_TTD = mysqli_fetch_array($queryttd);

$sql = "SELECT
    a.tanggal_sbp,
    c.kode_bukti,
    a.kode_rekening,
    a.nama_rekening,
    a.jumlah,
    a.jumlah_pajak
FROM
    keu_spj_gu_detail a
        LEFT JOIN
    keu_spj_gu b ON a.id_spj_gu = b.id_spj_gu
        LEFT JOIN
    keu_bukti_pengeluaran_gu c ON a.id_bukti_pengeluaran = c.id_bukti_pengeluaran_gu
    where a.id_spj_gu=$id_spj_gu";
$query = mysqli_query($mysqli, $sql);

$sqltotal   = "SELECT sum(jumlah) as grandtotal, sum(jumlah_pajak) AS grandtotalpajak from keu_spj_gu_detail where id_spj_gu=$id_spj_gu";
$querytotal = mysqli_query($mysqli, $sqltotal);
$DATA_TOTAL = mysqli_fetch_array($querytotal);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan SPPR LS</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">

	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
		font-family: Gotham, Helvetica Neue, Helvetica, Arial," sans-serif";
		font-size: 11px;
	}

.tabelfix {
    border-collapse:collapse;
	font-size: 11px;
}
.footer {
	font-size: 12px;
}
.header {
	font-size: 15px;
}

</style>
</head>

<body>
	<table width="100%" border="0">
		<tr>
			<td width="90%" align="center" style="font-size: 14px"><strong>PEMERINTAH KOTA PAGAR ALAM</strong></td>
		</tr>
		<tr>
		  <td align="center" style="font-size: 14px"><strong>RUMAH SAKIT UMUM DAERAH BESEMAH PAGAR ALAM</strong></td>
	  </tr>
		<tr>
			<td align="center"><strong style="font-size: 18px">DAFTAR BUKTI PENGELUARAN UNTUK PENGAJUAN SPP-GU</strong></td>
		</tr>
		<tr>
			<td align="center" style="font-size: 14px">
				<strong>TAHUN ANGGARAN <?php echo $DATA_IDENTITAS['tahun_anggaran']; ?></strong>
			</td>
		</tr>
	</table>

	<hr>

	<table width="100%" border="0">
	<tr>
		<td width="20%">&nbsp;</td>
		<td width="1%">&nbsp;</td>
		<td width="42%">&nbsp;</td>
		<td width="13%">Nomor</td>
		<td width="24%">: <?php echo $DATA_IDENTITAS['kode_spj']; ?></td>
	  </tr>
	<tr>
	  <td>Kode Sub Keg.</td>
	  <td>:</td>
	  <td><?php echo $DATA_IDENTITAS['kode_rekening']; ?></td>
	  <td>Tanggal</td>
	  <td>: <?php echo $DATA_IDENTITAS['tanggal_spj']; ?></td>
	  </tr>
	<tr>
	  <td>Sub Kegiatan</td>
	  <td>:</td>
	  <td><?php echo $DATA_IDENTITAS['nama_rekening3']; ?></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  </tr>
	</table>

	<br>
	<table width="100%" class="tabelfix" border="1">
		<tr>
		  <th colspan="2">SBP</th>
		  <th width="11%" rowspan="2">Kode Rekening</th>
		  <th width="33%" rowspan="2">Uraian</th>
		  <th width="10%" rowspan="2">Jumlah</th>
		  <th width="14%" rowspan="2">Potongan Pajak</th>
      </tr>
		<tr>
		  <th width="10%">Tanggal</th>
		  <th width="22%">Nomor</th>
	  </tr>
		<?php
while ($data = mysqli_fetch_assoc($query)) {
    echo '<tr>';
    echo '<td align="center"><strong>' . $data['tanggal_sbp'] . '</strong></td>';
    echo '<td align="center"><strong>' . $data['kode_bukti'] . '</strong></td>';
    echo '<td align="center"><strong>' . $data['kode_rekening'] . '</strong></td>';
    echo '<td align="left"><strong>' . $data['nama_rekening'] . '</strong></td>';
    echo '<td align="right">' . number_format($data['jumlah'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['jumlah_pajak'], 0, ",", ".") . '</td>';
    echo '</tr>';
}
?>
		<tr>
		  <td colspan="4" align="center"><strong>JUMLAH</strong></td>
		  <td align="right"><?php echo number_format($DATA_TOTAL['grandtotal'], 0, ",", "."); ?></td>
		  <td align="right"><?php echo number_format($DATA_TOTAL['grandtotalpajak'], 0, ",", "."); ?></td>
	  </tr>
	</table>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="5%">&nbsp;</td>
      <td width="23%">&nbsp;</td>
      <td width="15%">&nbsp;</td>
      <td width="5%">&nbsp;</td>
      <td width="23%">&nbsp;</td>
      <td width="9%">&nbsp;</td>
      <td width="20%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" align="center">Dibuat oleh:</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" align="center">Bendahara Pengeluaran</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" align="center"><?php echo $DATA_TTD['nama_pejabat']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" align="center">NIP.<?php echo $DATA_TTD['nip']; ?></td>
    </tr>
  </tbody>
</table>


</body>
</html>




<?php
$html = ob_get_clean();
require_once "../../vendor/autoload.php";
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->setIsRemoteEnabled(true);
$dompdf = new Dompdf($options);
$paper_size = [0, 0, 8.26 * 72, 12.99 * 72];
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('Laporan_SPJ_GU.pdf', ['Attachment' => 0]);
?>
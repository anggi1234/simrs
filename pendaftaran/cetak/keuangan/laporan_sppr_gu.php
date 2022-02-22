<?php
ob_start();
include '../connect.php';
session_start();

// $idsppr = $_GET['id_sppr_gu'];
$idsppr = "";

$sqlidentitas = "SELECT
    tanggal_sppr,kode_sppr
FROM
    keu_sppr_gu a
WHERE
    a.id_sppr_gu = $idsppr";
$queryidentitas = mysqli_query($mysqli, $sqlidentitas);
$DATA_IDENTITAS = mysqli_fetch_array($queryidentitas);

$sqldetail = "SELECT
    a.id_sppr_detail_gu,
    a.id_sppr_gu,
    b.kode_spm,
    a.nama_bank,
    a.no_rekening_penerima,
    a.nama_rekening,
    a.bruto,
    a.pajak,
    a.netto
FROM
    keu_sppr_detail_gu a
    left join keu_spm_gu b on a.id_spm_gu=b.id_spm_gu
WHERE
    a.id_sppr_gu = $idsppr";
$querydetail = mysqli_query($mysqli, $sqldetail);

$sqldetailtot = "SELECT SUM(a.bruto) as totbruto,SUM(a.pajak) as totpajak,SUM(a.netto) as totnetto
    from keu_sppr_detail_gu a
    where a.id_sppr_gu = $idsppr";
$querydetailtot = mysqli_query($mysqli, $sqldetailtot);
$DATA_TOTAL     = mysqli_fetch_array($querydetailtot);

function Terbilang($nilai) {
    $huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
    if ($nilai == 0) {
        return "";
    } elseif ($nilai < 12 & $nilai != 0) {
        return "" . $huruf[$nilai];
    } elseif ($nilai < 20) {
        return Terbilang($nilai - 10) . " Belas ";
    } elseif ($nilai < 100) {
        return Terbilang($nilai / 10) . " Puluh " . Terbilang($nilai % 10);
    } elseif ($nilai < 200) {
        return " Seratus " . Terbilang($nilai - 100);
    } elseif ($nilai < 1000) {
        return Terbilang($nilai / 100) . " Ratus " . Terbilang($nilai % 100);
    } elseif ($nilai < 2000) {
        return " Seribu " . Terbilang($nilai - 1000);
    } elseif ($nilai < 1000000) {
        return Terbilang($nilai / 1000) . " Ribu " . Terbilang($nilai % 1000);
    } elseif ($nilai < 1000000000) {
        return Terbilang($nilai / 1000000) . " Juta " . Terbilang($nilai % 1000000);
    } elseif ($nilai < 1000000000000) {
        return Terbilang($nilai / 1000000000) . " Milyar " . Terbilang($nilai % 1000000000);
    } elseif ($nilai < 100000000000000) {
        return Terbilang($nilai / 1000000000000) . " Trilyun " . Terbilang($nilai % 1000000000000);
    } elseif ($nilai <= 100000000000000) {
        return "Maaf Tidak Dapat di Prose Karena Jumlah nilai Terlalu Besar ";
    }
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan SPPR GU</title>
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
			<td align="center"><strong style="font-size: 18px">SURAT PERINTAH PENDEBETAN REKENING (SPPR - GU)</strong></td>
		</tr>
		<tr>
			<td align="center" style="font-size: 14px">
				Tanggal: <?php echo $DATA_IDENTITAS['tanggal_sppr'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Nomor : <?php echo $DATA_IDENTITAS['kode_sppr'] ?>
			</td>
		</tr>
	</table>

	<hr>

	<table width="100%" border="0">
	<tr>
		  <td colspan="3">Saya yang bertandatangan dibawah ini selaku Pengguna Anggaran memerintahkan Bendahara Pengeluaran agar melakukan pendebetan rekening menggunakan pemindahbukuan sejumlah Rp. <?php echo number_format($DATA_TOTAL['totnetto'], 0, ",", "."); ?></td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
		<tr>
			<td width="27%">Terbilang</td>
			<td width="1%">:</td>
			<td><?php echo Terbilang($DATA_TOTAL['totnetto']) ?> Rupiah</td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		  <td></td>
		  <td></td>
	  </tr>
		<tr>
			<td>Dari baki rekening  :</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Nomor</td>
			<td>:</td>
			<td>3-113-05468 8</td>
		</tr>
		<tr>
		  <td>Nama</td>
		  <td>:</td>
		  <td>Kas BLUD RSUD Besemah</td>
	  </tr>
		<tr>
		  <td colspan="3">Atas dasar Surat Perintah Membayar (SPM - GU) kepada penerima sebagai berikut :</td>
	  </tr>

	</table>



	<br>
	<table width="100%" class="tabelfix" border="1">
		<tr>
		  <th width="2%" rowspan="2">No</th>
		  <th width="14%" rowspan="2">No. SPM</th>
		  <th colspan="3">Uraian</th>
		  <th colspan="3">Potongan Pajak</th>
	  </tr>
		<tr>
		  <th width="13%">Nama Bank</th>
		  <th width="14%">No. Rekening</th>
		  <th width="24%">Nama Rekening</th>
		  <th width="9%">Bruto</th>
		  <th width="9%">Pajak</th>
		  <th width="15%">Netto</th>
	  </tr>
		<?php
$no = 1;
while ($data = mysqli_fetch_assoc($querydetail)) {
    echo '<tr>';
    echo '<td>' . $no . '</td>';
    echo '<td align="right">' . $data['kode_spm'] . '</td>';
    echo '<td>' . $data['nama_bank'] . '</td>';
    echo '<td>' . $data['no_rekening_penerima'] . '</td>';
    echo '<td>' . $data['nama_rekening'] . '</td>';
    echo '<td align="right">' . number_format($data['bruto'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['pajak'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['netto'], 0, ",", ".") . '</td>';
    echo '</tr>';
    $no++;
}
?>
		<tr>
		  <td colspan="5" align="center"><strong>Jumlah</strong></td>

		  <td align="right"><?php echo number_format($DATA_TOTAL['totbruto'], 0, ",", "."); ?></td>
		  <td align="right"><?php echo number_format($DATA_TOTAL['totpajak'], 0, ",", "."); ?></td>
		  <td align="right"><?php echo number_format($DATA_TOTAL['totnetto'], 0, ",", "."); ?></td>
	  </tr>
	</table>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="7" align="center"></td>
    </tr>
    <tr>
      <td width="5%">&nbsp;</td>
      <td width="23%">&nbsp;</td>
      <td colspan="3" align="center">Pagaralam, <?php echo date("d-m-Y"); ?></td>
      <td width="9%">&nbsp;</td>
      <td width="20%">&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="2" align="center">Pengguna Anggaran</td>
      <td width="15%">&nbsp;</td>

      <td width="5%">&nbsp;</td>
      <td width="23%">&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" align="center">Bendahara Pengeluaran</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="2" align="center">dr. Widyana Grehastuti, Sp.OG, M.Si.Med</td>
      <td>&nbsp;</td>

      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" align="center">RISTANTI</td>
    </tr>
    <tr>
    	<td colspan="2" align="center">NIP. 19721125 200312 2 007</td>
      <td>&nbsp;</td>

      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" align="center">NIP. 19700407 199501 2 002</td>
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
$dompdf->stream('Laporan_SPPRgu.pdf', ['Attachment' => 0]);
?>
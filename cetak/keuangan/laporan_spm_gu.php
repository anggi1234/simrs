<?php
ob_start();
session_start();
include '../connect.php';
// $id_spm_gu = $_GET['id_spm_gu'];
$id_spm_gu = "";

$sqlidentitas = "SELECT
    a.kode_spm,
    b.kode_spp,
    b.tanggal_spp,
    a.tanggal_spm,
	year(a.tanggal_spm) as tahun_anggaran,
    d.nama_supplier,
    d.alamat,
    d.npwp,
    d.no_rekening,
	d.nama_rekening,
    d.nama_bank,
    CONCAT('Ganti Uang Persediaan-', c.kode_spj) AS keperluan,
    e.kode_rekening AS kode_rekening3,
    e.nama_rekening3,
    f.kode_rekening AS kode_rekening2,
    f.nama_rekening2,
    g.kode_rekening AS kode_rekening1,
    g.nama_rekening1,
	a.total_netto
FROM
    keu_spm_gu a
        LEFT JOIN
    keu_spp_gu b ON a.id_spp_gu = b.id_spp_gu
        LEFT JOIN
    keu_spj_gu c ON b.id_spj_gu = c.id_spj_gu
        LEFT JOIN
    master_supplier d ON c.id_master_supplier = d.id_master_supplier
        LEFT JOIN
    master_rekening3 e ON c.id_master_rekening3 = e.id_master_rekening3
        LEFT JOIN
    master_rekening2 f ON e.id_master_rekening2 = f.id_master_rekening2
        LEFT JOIN
    master_rekening1 g ON f.id_master_rekening1 = g.id_master_rekening1
    where a.id_spm_gu=$id_spm_gu";
$queryidentitas = mysqli_query($mysqli, $sqlidentitas);
$DATA_IDENTITAS = mysqli_fetch_array($queryidentitas);

$sqlppn = "SELECT
    SUM(b.bruto) AS bruto,
    SUM(b.ppn) AS ppn,
    SUM(b.pph21) AS pph21,
    SUM(b.pph22) AS pph22,
    SUM(b.pph23) AS pph23,
    SUM(b.pph4_2) AS pph4_2,
    SUM(b.ppn) + SUM(b.pph21) + SUM(b.pph22) + SUM(b.pph23) + SUM(b.pph4_2) AS total_potongan,
    SUM(b.netto) AS netto
FROM
    keu_spj_gu_detail a
        LEFT JOIN
    keu_bukti_pengeluaran_gu b ON a.id_bukti_pengeluaran = b.id_bukti_pengeluaran_gu
        LEFT JOIN
    keu_spj_gu c ON a.id_spj_gu = c.id_spj_gu
        LEFT JOIN
    keu_spp_gu d ON c.id_spj_gu = d.id_spj_gu
        LEFT JOIN
    keu_spm_gu e ON d.id_spp_gu = e.id_spp_gu
    where e.id_spm_gu=$id_spm_gu";
$queryppn = mysqli_query($mysqli, $sqlppn);
$DATA_PPN = mysqli_fetch_array($queryppn);

$sql = "SELECT
    kode_rekening,nama_rekening,jumlah_netto
FROM
    keu_spj_gu_detail
        WHERE id_spm_gu=$id_spm_gu";
$query = mysqli_query($mysqli, $sql);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan SPM-GU</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">

	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
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
			<td width="10%" rowspan="4" align="right"><img src="http://localhost/simrs/cetak/gambar/logorsud.png" height="70px" /></td>
			<td width="90%" align="center" style="font-size: 14px"><strong>PEMERINTAH KOTA PAGAR ALAM</strong></td>
		</tr>
		<tr>
		  <td align="center" style="font-size: 14px"><strong>RUMAH SAKIT UMUM DAERAH BESEMAH PAGAR ALAM</strong></td>
	  </tr>
		<tr>
			<td align="center"><strong style="font-size: 18px">SURAT PERINTAH MEMBAYAR (SPM)</strong></td>
		</tr>
		<tr>
			<td align="center" style="font-size: 12px"><strong>TAHUN ANGGARAN <?php echo $DATA_IDENTITAS['tahun_anggaran']; ?></strong></td>
		</tr>
	</table>

	<hr>

	<table width="100%" border="0">
		<tr>
			<td width="14%">No.SPP</td>
			<td width="1%">:</td>
			<td width="35%"><?php echo $DATA_IDENTITAS['kode_spp']; ?></td>
			<td width="14%">Dari</td>
			<td width="2%">:</td>
			<td width="34%">Pejabat Pelaksanan Kegiatan</td>
		</tr>
		<tr>
			<td>Tanggal</td>
			<td>:</td>
			<td><?php echo $DATA_IDENTITAS['tanggal_spp']; ?></td>
			<td>No.SPM</td>
			<td>:</td>
			<td><?php echo $DATA_IDENTITAS['kode_spm']; ?></td>
		</tr>
		<tr>
			<td>Sub Kegiatan</td>
			<td>:</td>
			<td><?php echo $DATA_IDENTITAS['nama_rekening3']; ?></td>
			<td>Tanggal SPM</td>
			<td>:</td>
			<td><?php echo $DATA_IDENTITAS['tanggal_spm']; ?></td>
		</tr>

	</table>

	<br>

	<table width="100%" border="0">
		<tr>
			<td width="19%">Bank/Pos</td>
			<td width="1%">:</td>
			<td width="80%">Bank Jateng Cabang Pembantu Besemah</td>
		</tr>
		<tr>
			<td colspan="3">Hendaklah mencairkan / memindahkan dari buku rekening Nomor 3-113--05468-8, Uang sebesar Rp <?php echo number_format($DATA_IDENTITAS['total_netto'], 0, ",", "."); ?></td>
		</tr>
	</table>

	<br>

	<table width="100%" border="0">
		<tr>
			<td width="21%">Kepada</td>
			<td width="2%">:</td>
			<td colspan="2"><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td>:</td>
			<td colspan="2"><?php echo $DATA_IDENTITAS['alamat']; ?></td>
		</tr>
		<tr>
			<td>NPWP</td>
			<td>:</td>
			<td colspan="2"><?php echo $DATA_IDENTITAS['npwp']; ?></td>
		</tr>
		<tr>
			<td>No. & Nama Rekening Bank</td>
			<td>:</td>
			<td colspan="2"><?php echo $DATA_IDENTITAS['no_rekening']; ?> - <?php echo $DATA_IDENTITAS['nama_rekening']; ?></td>
		</tr>
		<tr>
			<td>Bank / Pos</td>
			<td>:</td>
			<td colspan="2"><?php echo $DATA_IDENTITAS['nama_bank']; ?></td>
		</tr>
		<tr>
			<td>Keperluan Untuk</td>
			<td>:</td>
			<td colspan="2"><?php echo $DATA_IDENTITAS['keperluan']; ?></td>
		</tr>
		<tr>
			<td>Program</td>
			<td>:</td>
			<td width="12%"><?php echo $DATA_IDENTITAS['kode_rekening1']; ?></td>
			<td width="65%"><?php echo $DATA_IDENTITAS['nama_rekening1']; ?></td>
		</tr>
		<tr>
			<td>Kegiatan</td>
			<td>:</td>
			<td><?php echo $DATA_IDENTITAS['kode_rekening2']; ?></td>
			<td><?php echo $DATA_IDENTITAS['nama_rekening2']; ?></td>
		</tr>
		<tr>
			<td>Sub Kegiatain</td>
			<td>:</td>
			<td><?php echo $DATA_IDENTITAS['kode_rekening3']; ?></td>
			<td><?php echo $DATA_IDENTITAS['nama_rekening3']; ?></td>
		</tr>
	</table>

	<br>

	<table width="100%" class="tabelfix" border="1">
		<tr>
			<th width="5%">No</th>
			<th width="18%">Kode Rekening</th>
			<th width="52%">Uraian</th>
			<th width="25%">Nilai</th>
		</tr>
		<?php
$no = 1;
while ($data = mysqli_fetch_assoc($query)) {
    echo '<tr>';
    echo '<td align="center"><strong>' . $no++ . '</strong></td>';
    echo '<td align="center"><strong>' . $data['kode_rekening'] . '</strong></td>';
    echo '<td align="center"><strong>' . $data['nama_rekening'] . '</strong></td>';
    echo '<td align="right">' . number_format($data['jumlah_netto'], 0, ",", ".") . '</td>';
    echo '</tr>';
}
?>
		<tr>
			<td colspan="3" align="right"><strong>JUMLAH</strong></td>
			<td align="right">Rp <?php echo number_format($DATA_IDENTITAS['total_netto'], 0, ",", "."); ?></td>
		</tr>
	</table>

	<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="2">Potongan oleh Bendahara Pengeluaran</td>
      <td width="2%">&nbsp;</td>
      <td colspan="3">Informasi:</td>
    </tr>
    <tr>
      <td width="25%">1.</td>
      <td width="18%">Rp.</td>
      <td>&nbsp;</td>
      <td colspan="3">Pajak yang dipungut Bendahara Pengeluaran dan telah lunas dibayar/disetor ke Kas Negara :</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="3%">1.</td>
      <td width="35%">PPN</td>
      <td width="17%" align="right"><?php echo number_format($DATA_PPN['ppn'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>2.</td>
      <td>PPh Pasal 21</td>
      <td align="right"><?php echo number_format($DATA_PPN['pph21'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>3.</td>
      <td>PPh Pasal 22</td>
      <td align="right"><?php echo number_format($DATA_PPN['pph22'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>4.</td>
      <td>PPh Pasal 23</td>
      <td align="right"><?php echo number_format($DATA_PPN['pph23'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>5.</td>
      <td>PPh Pasal 4 (2)</td>
      <td align="right"><?php echo number_format($DATA_PPN['pph4_2'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><strong>Jumlah</strong></td>
      <td align="right"><strong>Rp.<?php echo number_format($DATA_PPN['total_potongan'], 0, ",", "."); ?></strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">Pajak yang dipungut Bendahara Pengeluaran dan akan disetor ke Kas Negara melalui Bank persepsi bersama SPM : </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">Rp.00</td>
    </tr>
    <tr>
      <td align="right"><strong>Jumlah</strong></td>
      <td><strong>Rp.</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><strong>Jumlah</strong></td>
      <td align="right"><strong>Rp.00</strong></td>
    </tr>
  </tbody>
</table>

<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="2"><strong>Jumlah yang dibayarkan  :</strong></td>
      <td width="15%">&nbsp;</td>
      <td width="5%">&nbsp;</td>
      <td width="23%">&nbsp;</td>
      <td width="9%" align="right">&nbsp;</td>
      <td width="20%" align="right">&nbsp;</td>
    </tr>
    <tr>
      <td width="5%">&nbsp;</td>
      <td colspan="2">Jumlah Pembayaran Bruto</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">Rp.</td>
      <td align="right"><?php echo number_format($DATA_PPN['bruto'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><strong>Jumlah Potongan:</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">Pajak yang dipungut dan disetor bersama SPM</td>
      <td>&nbsp;</td>
      <td align="right">Rp.0</td>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">Perhitungan Fihak Ketiga (PFK) yang dipotong Bendahara</td>
      <td>&nbsp;</td>
      <td align="right">Rp.0</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">Rp.</td>
      <td align="right"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">Jumlah yang ditransfer ke rekening penerima, setelah dikurangi potongan dan setoran pajak</td>
      <td align="right">Rp.</td>
      <td align="right"><?php echo number_format($DATA_PPN['netto'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="7">Jumlah yang dicairkan dari rekening Kas BLUD RSUD Besemah atas pajak terutang dan selanjutnya disetor ke Bank Jateng sebagai bank persepsi pajak sebesar Rp. </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="23%">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" align="center">Pagaralam, <?php echo date("d-m-Y"); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" align="center">Pemimpin BLUD</td>
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
      <td colspan="2" align="center">dr. Widyana Grehastuti, Sp.OG, M.Si.Med</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" align="center">NIP.197211252003122007</td>
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
$dompdf->stream('Laporan_SPM.pdf', ['Attachment' => 0]);
?>
<?php
ob_start();
session_start();
include '../connect.php';
// $id_spm = $_GET['id_spm'];
$id_spm = '';

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

$sqlidentitas = "SELECT
    YEAR(a.tanggal_spm) AS 'Tahun',
    b.kode_spp,
    b.tanggal_spp,
    e.nama_rekening3,
    a.kode_spm,
    a.tanggal_spm AS 'Tanggal',
    b.total_netto,
    h.nama_supplier AS 'Kepada',
    h.alamat,
    h.npwp,
    concat(h.no_rekening,' ',h.nama_supplier) AS 'no_bank',
    h.nama_bank,
    CONCAT(d.nama_rekening,' No Tagihan : ',a.kode_spm,' Tgl ', a.tanggal_spm, ' pada ', h.nama_supplier) AS 'keperluan',
    concat(j.kode_rekening,' ',j.nama_rekening1) AS 'kode_rekening1',
    concat(i.kode_rekening,' ',i.nama_rekening2) AS 'kode_rekening2',
    concat(e.kode_rekening,' ',e.nama_rekening3) AS 'kode_rekening3',
    d.kode_rekening AS 'kode_rekenings',
    d.nama_rekening AS 'nama_rekenings',
    a.total_netto AS 'total_nettos',
    g.ppn,
    g.pph22,
    g.bruto,
    g.netto,
  	a.total_pajak,
  	a.total_bruto
FROM
    keu_spm a
        LEFT JOIN
    keu_spp b ON a.id_spp = b.id_spp
        LEFT JOIN
    master_login c ON a.uid = c.uid
        LEFT JOIN
    master_rekening d ON a.id_rekening = d.id_rekening
        LEFT JOIN
    master_rekening3 e ON d.id_master_rekening3 = e.id_master_rekening3
        LEFT JOIN
    keu_bukti_pengeluaran g ON b.id_bukti_pengeluaran = g.id_bukti_pengeluaran
        LEFT JOIN
    master_supplier h ON g.id_master_supplier = h.id_master_supplier
        LEFT JOIN
    master_rekening2 i ON e.id_master_rekening2 = i.id_master_rekening2
        LEFT JOIN
    master_rekening1 j ON i.id_master_rekening1 = j.id_master_rekening1
	WHERE a.id_spm = '$id_spm'";

$queryidentitas = mysqli_query($mysqli, $sqlidentitas);
$DATA_IDENTITAS = mysqli_fetch_array($queryidentitas);

$sqlpejabat = "SELECT nama_pejabat,nip FROM master_jabatan where id_jabatan=1;";

$querypejabat = mysqli_query($mysqli, $sqlpejabat);
$DATA_PEJABAT = mysqli_fetch_array($querypejabat);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan SPM</title>
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
			<td align="center" style="font-size: 12px"><strong>TAHUN ANGGARAN <?php echo $DATA_IDENTITAS['Tahun']; ?></strong></td>
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
			<td width="34%">Pejabat Pelaksanan Teknis Kegiatan</td>
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
			<td><?php echo $DATA_IDENTITAS['Tanggal']; ?></td>
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
			<td colspan="3">Hendaklah mencairkan / memindahkan dari buku rekening Nomor 3-113--05468-8, Uang sebesar <?php echo "Rp." . number_format($DATA_IDENTITAS['bruto'], 0, ",", "."); ?></td>
		</tr>
		<tr>
		  <td colspan="3"><strong>( <?php echo Terbilang($DATA_IDENTITAS['bruto']) ?> Rupiah )</strong></td>
	  </tr>
	</table>

	<br>

	<table width="100%" border="0">
		<tr>
			<td width="29%">Kepada</td>
			<td width="2%">:</td>
			<td width="69%"><?php echo $DATA_IDENTITAS['Kepada']; ?></td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td>:</td>
			<td><?php echo $DATA_IDENTITAS['alamat']; ?></td>
		</tr>
		<tr>
			<td>NPWP</td>
			<td>:</td>
			<td><?php echo $DATA_IDENTITAS['npwp']; ?></td>
		</tr>
		<tr>
			<td>No. & Nama Rekening Bank</td>
			<td>:</td>
			<td><?php echo $DATA_IDENTITAS['no_bank']; ?></td>
		</tr>
		<tr>
			<td>Bank / Pos</td>
			<td>:</td>
			<td><?php echo $DATA_IDENTITAS['nama_bank']; ?></td>
		</tr>
		<tr>
			<td>Keperluan Untuk</td>
			<td>:</td>
			<td>Pembayaran <?php echo $DATA_IDENTITAS['keperluan']; ?></td>
		</tr>
		<tr>
			<td>Program</td>
			<td>:</td>
			<td><?php echo $DATA_IDENTITAS['kode_rekening1']; ?></td>
		</tr>
		<tr>
			<td>Kegiatan</td>
			<td>:</td>
			<td><?php echo $DATA_IDENTITAS['kode_rekening2']; ?></td>
		</tr>
		<tr>
			<td>Sub Kegiatain</td>
			<td>:</td>
			<td><?php echo $DATA_IDENTITAS['kode_rekening3']; ?></td>
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
		<tr>
			<td align="center"><?php echo $no++; ?>1.</td>
			<td align="center"><?php echo $DATA_IDENTITAS['kode_rekenings']; ?></td>
			<td><?php echo $DATA_IDENTITAS['nama_rekenings']; ?></td>
			<td  align="right"><?php echo number_format($DATA_IDENTITAS['bruto'], 0, ",", "."); ?></td>
		</tr>
		<tr>
			<td colspan="3" align="right"><strong>JUMLAH</strong></td>
			<td align="right"><strong><?php echo number_format($DATA_IDENTITAS['bruto'], 0, ",", "."); ?></strong></td>
		</tr>
	</table>

	<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td colspan="3">Informasi:</td>
    </tr>
    <tr>
      <td width="25%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">Pajak yang dipungut Bendahara Pengeluaran dan telah lunas dibayar/disetor ke Kas Negara :</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="3%">1.</td>
      <td width="35%">&nbsp;</td>
      <td width="17%">Rp.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><strong>Jumlah</strong></td>
      <td><strong>Rp.</strong></td>
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
      <td>1</td>
      <td>PPN Pusat</td>
      <td align="right">Rp.<?php echo number_format($DATA_IDENTITAS['ppn'], 0, ",", ".") ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>2</td>
      <td>PPN Pasal 22</td>
      <td align="right">Rp. <?php echo number_format($DATA_IDENTITAS['pph22'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><strong>Jumlah</strong></td>
      <td align="right"><strong>Rp. <?php echo number_format($DATA_IDENTITAS['total_pajak'], 0, ",", "."); ?></strong></td>
    </tr>
  </tbody>
</table>

<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="2"><strong>Jumlah yang dibayarkan  :</strong></td>
      <td width="15%">&nbsp;</td>
      <td width="5%">&nbsp;</td>
      <td width="17%">&nbsp;</td>
      <td width="15%" align="right">&nbsp;</td>
      <td width="20%">&nbsp;</td>
    </tr>
    <tr>
      <td width="5%">&nbsp;</td>
      <td colspan="2">Jumlah Pembayaran Bruto</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">RP. <?php echo number_format($DATA_IDENTITAS['total_bruto'], 0, ",", "."); ?></td>
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
      <td colspan="2"><strong>Jumlah Potongan:</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">Pajak yang dipungut dan disetor bersama SPM</td>
      <td>&nbsp;</td>
      <td align="right">Rp. <?php echo number_format($DATA_IDENTITAS['total_pajak'], 0, ",", "."); ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">Perhitungan Pihak Ketiga (PFK) yang dipotong Bendahara</td>
      <td align="right">Rp. 0</td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"></td>
      <td align="right">Rp. <?php echo number_format($DATA_IDENTITAS['total_pajak'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">Jumlah yang ditransfer ke rekening penerima, setelah dikurangi potongan dan setoran pajak</td>
      <td align="right"></td>
      <td align="right">Rp. <?php echo number_format($DATA_IDENTITAS['total_netto'], 0, ",", "."); ?></td>
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
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="7">Jumlah yang dicairkan dari rekening Kas BLUD RSUD Besemah atas pajak terutang dan selanjutnya disetor ke Bank Jateng sebagai bank persepsi pajak sebesar Rp. <?php echo number_format($DATA_IDENTITAS['total_pajak'], 0, ",", "."); ?></td>
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" align="center"><strong><u><?php echo $DATA_PEJABAT['nama_pejabat']; ?></u></strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" align="center">NIP. <?php echo $DATA_PEJABAT['nip']; ?></td>
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
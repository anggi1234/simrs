<?php
ob_start();
session_start();

include '../connect.php';
// $id_spp = $_GET['id_spp_gu'];
$id_spp = "";

$sqlidentitas = "SELECT
    a.kode_spp,
    YEAR(a.tanggal_spp) AS tahun_anggaran,
    d.nama_supplier,
    b.kode_spj,
    d.nama_pj,
    a.total_netto,
    e.pd_nickname AS pptk_nama,
    e.nip AS nip_pptk,
    f.kode_rekening AS kode_rekening2,
    f.nama_rekening2,
    g.kode_rekening AS kode_rekening1,
    g.nama_rekening1
FROM
    keu_spp_gu a
        LEFT JOIN
    keu_spj_gu b ON a.id_spj_gu = b.id_spj_gu
        LEFT JOIN
    master_rekening3 c ON b.id_master_rekening3 = c.id_master_rekening3
        LEFT JOIN
    master_supplier d ON b.id_master_supplier = d.id_master_supplier
        LEFT JOIN
    master_login e ON c.pptk_uid = e.uid
        LEFT JOIN
    master_rekening2 f ON c.id_master_rekening2 = f.id_master_rekening2
        LEFT JOIN
    master_rekening1 g ON g.id_master_rekening1 = f.id_master_rekening1
WHERE
    a.id_spp_gu=$id_spp";

$queryidentitas = mysqli_query($mysqli, $sqlidentitas);
$DATA_IDENTITAS = mysqli_fetch_array($queryidentitas);

$sqldpa    = "SELECT kode_dpa,tanggal_dpa,nilai_spd FROM keu_dpa;";
$querydpa  = mysqli_query($mysqli, $sqldpa);
$querydpa1 = mysqli_query($mysqli, $sqldpa);
$DATA_DPA  = mysqli_fetch_array($querydpa1);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan SPPGU</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">

	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
		font-size: 10px;
	}

.tabelfix {
    border-collapse:collapse;
	font-size: 10px;
}

</style>
</head>

<body>
	<table width="100%" class="tabelfix" border="0">
		<tr>
			<td width="10%" rowspan="3" align="right"><img src="http://localhost/simrs/cetak/gambar/logorsud.png" height="70px" /></td>
			<td width="90%" align="center" style="font-size: 16px">PEMERINTAH KOTA PAGAR ALAM</td>
		</tr>
		<tr>
			<td align="center"><strong style="font-size: 18px">SURAT PERMINTAAN PEMBAYARAN LANGSUNG BARANG DAN JASA</strong></td>
		</tr>
		<tr>
			<td align="center" style="font-size: 14px">(SPP-GU BARANG DAN JASA) <br>
				NOMOR : <?php echo $DATA_IDENTITAS['kode_spp']; ?>
			</td>
		</tr>
	</table>

	<hr>


	<table width="100%" class="tabelfix" border="0">
  <tbody>
    <tr>
      <td colspan="2">Kepada Yth.</td>
      <td width="17%">&nbsp;</td>
      <td width="30%">&nbsp;</td>
      <td width="20%">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Pemimpin BLUD</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Rumah Sakit Umum Daerah Besemah</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Di Tempat</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="3%">&nbsp;</td>
      <td width="30%">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5">Dengan memperhatikan Peraturan Bupati Banyumas Nomor : 65 Tahun 2019, tentang Penjabaran Anggaran Pendapatan dan Belanja Daerah Tahun 2020, bersama ini kami mengajukan Surat Permintaan Pembayaran Ganti Uang Persediaan berikut:</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

    <tr>
      <td>a.</td>
      <td>Urusan Pemerintah</td>
      <td>1.02</td>
      <td colspan="2">Kesehatan</td>
    </tr>
    <tr>
      <td>b.</td>
      <td>OPD</td>
      <td>1.02.03</td>
      <td colspan="2">Rumah Sakit Umum Daerah Besemah</td>
    </tr>
    <tr>
      <td>c.</td>
      <td>Program</td>
      <td><?php echo $DATA_IDENTITAS['kode_rekening1']; ?></td>
      <td colspan="2"><?php echo $DATA_IDENTITAS['nama_rekening1']; ?></td>
    </tr>
    <tr>
      <td>d.</td>
      <td>Kegiatan</td>
      <td><?php echo $DATA_IDENTITAS['kode_rekening2']; ?></td>
      <td colspan="2"><?php echo $DATA_IDENTITAS['nama_rekening2']; ?></td>
    </tr>
    <tr>
      <td>e.</td>
      <td>Sub Kegiatan</td>
      <td><?php echo $DATA_IDENTITAS['kode_rekening']; ?></td>
      <td colspan="2"><?php echo $DATA_IDENTITAS['kegiatan']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>f</td>
      <td>Tahun Anggaran</td>
      <td colspan="3"><?php echo $DATA_IDENTITAS['tahun_anggaran']; ?></td>
    </tr>
    <tr>
      <td>g.</td>
      <td>Dasar SPD Nomor</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>h.</td>
      <td>Jumlah Sisa Dana SPD</td>
      <td colspan="3"><?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>i.</td>
      <td>Untuk Keperluan</td>
      <td colspan="3">Ganti Uang Persediaan <?php echo $DATA_IDENTITAS['kode_spj']; ?></td>
    </tr>
    <tr>
      <td>j.</td>
      <td>Nama Bendahara Pengeluaran</td>
      <td colspan="3"><?php echo $DATA_IDENTITAS['nama_pj']; ?></td>
    </tr>
    <tr>
      <td>k.</td>
      <td>Jumlah Pembayaran yang Diminta</td>
      <td colspan="3"><?php echo number_format($DATA_IDENTITAS['total_netto'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><strong>RINGKASAN</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="border: solid thin;" colspan="5" align="center"><strong>RINGKASAN DPA-/DPPA-/DPAL-SKPD</strong></td>
    </tr>
    <tr>
      <td colspan="4">Jumlah Dana DPA-/DPPA-/DPAL-SKPD</td>
      <td align="right">Rp. <?php echo number_format($DATA_DPA['nilai_spd'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td colspan="5" align="center"><strong>RINGKASAN SPD</strong></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><strong>Nomor SPD</strong></td>
      <td align="center"><strong>Tanggal SPD</strong></td>
      <td colspan="2" align="center"><strong>Jumlah Dana</strong></td>
    </tr>
    <?php

$no = 1;
while ($data = mysqli_fetch_assoc($querydpa)) {
    echo '<tr>';
    echo '<td colspan="2" align="right">' . $data['kode_dpa'] . '</td>';
    echo '<td align="right">' . $data['tanggal_dpa'] . '</td>';
    echo '<td colspan="2" align="right">' . number_format($data['nilai_spd'], 0, ",", ".") . '</td>';
    echo '</tr>';
    $no++;
}
?>
    <tr>
      <td colspan="4" align="right"><strong>Jumlah</strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="right"><strong>Sisa dana yang belum di SPD-kan (I-II)</strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="border: solid thin;" colspan="5" align="center"><strong>RINGKASAN BELANJA</strong></td>
    </tr>
    <?php
$sqlviewdpa   = "SELECT * FROM v_keu_anggaran_terpakai;";
$queryviewdpa = mysqli_query($mysqli, $sqlviewdpa);

while ($data = mysqli_fetch_assoc($queryviewdpa)) {
    echo '<tr>';
    echo '<td colspan="2">' . $data['jenis'] . '</td>';
    echo '<td colspan="2"></td>';
    echo '<td align="right">Rp ' . number_format($data['anggaran_terpakai'], 0, ",", ".") . '</td>';
    echo '</tr>';
}
?>

    <tr>
      <td colspan="4" align="right"><strong>Jumlah</strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="right"><strong>Sisa SPD yang diterbitkan, belum dibelanjakan (II-III)</strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="border: solid thin;" colspan="5" align="center"><strong>RINCIAN SPP</strong></td>
    </tr>
    <tr>
      <td>NO</td>
      <td>Kode Rekening</td>
      <td colspan="2">Uraian</td>
      <td>Nilai</td>
    </tr>
    <?php

$sqlviewspp = "SELECT
    a.kode_rekening,a.nama_rekening,a.jumlah_netto
FROM
    keu_spj_gu_detail a
        LEFT JOIN
    keu_spj_gu b ON a.id_spj_gu = b.id_spj_gu
    where a.id_spp_gu=$id_spp";
$queryviewspp = mysqli_query($mysqli, $sqlviewspp);

$no = 1;
while ($data = mysqli_fetch_assoc($queryviewspp)) {
    echo '<tr>';
    echo '<td>' . $no . '.</td>';
    echo '<td>' . $data['kode_rekening'] . '</td>';
    echo '<td colspan="2">' . $data['nama_rekening'] . '</td>';
    echo '<td align="right">Rp ' . number_format($data['jumlah_netto'], 0, ",", ".") . '</td>';
    echo '</tr>';
    $no++;
}
?>
    <tr>
      <td colspan="4" align="right"><strong>JUMLAH</strong></td>
      <td align="right" style="font-size: 13px"><strong><?php echo number_format($DATA_IDENTITAS['total_netto'], 0, ",", "."); ?></strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2"><strong>Potongan Oleh Bendahara Pengeluaran :</strong></td>
      <td colspan="2"><strong>Informasi</strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">Pajak yang dipungut Bendahara Pengeluaran dan telah lunas dibayar/disetor ke Kas Negara :</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>1.</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">Jumlah</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">Pajak yang dipungut Bendahara Pengeluaran dan akan disetor ke Kas Negara melalui Bank persepsi bersama SPM :</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>1. PPN Pusat</td>
      <td>Rp.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center">Mengetahui</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center">Pejabat Pelaksana Teknis Kegiatan</td>
      <td>&nbsp;</td>
      <td colspan="2" align="center">Bendahara Pengeluaran</td>
    </tr>
    <tr>
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
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center"><u><?php echo $DATA_IDENTITAS['pptk_nama']; ?></u></td>
      <td>&nbsp;</td>
      <td colspan="2" align="center"><u><?php echo $DATA_IDENTITAS['nama_pj']; ?></u></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center">NIP.<?php echo $DATA_IDENTITAS['nip_pptk']; ?></td>
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
$dompdf->stream('Laporan_SPPGU.pdf', ['Attachment' => 0]);
?>
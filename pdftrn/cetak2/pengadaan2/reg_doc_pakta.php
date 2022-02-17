<?php
ob_start();
session_start();
include('../connect.php');
$id_pengadaan_pesanan_barang_masuk = $_GET['id_pengadaan_pesanan_barang_masuk'];

$sqlidentitas="SELECT
	b.nama_rekening AS pekerjaan,
	a.tahun_anggaran,
	a.jumlah_netto,
	d.nama_supplier,
	d.nama_pj,
	d.posisi 
FROM
	pengadaan_pesanan_masuk a
	LEFT JOIN master_rekening b ON a.id_rekening = b.id_rekening
	LEFT JOIN master_supplier d ON a.id_supplier = d.id_master_supplier 
WHERE
	a.id_pengadaan_pesanan_barang_masuk = '$id_pengadaan_pesanan_barang_masuk'";
$queryidentitas = mysql_query($sqlidentitas);
$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


function tanggal_indo($tanggal, $cetak_hari = false)
	{
		$hari = array ( 1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);
			
		$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
		$split 	  = explode('-', $tanggal);
		$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
	
		if ($cetak_hari) {
			$num = date('N', strtotime($tanggal));
			return $tgl_indo;
		}
		return $tgl_indo;
	}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Pakta Integritas</title>
	<style type="text/css">
	@page {
            margin-top: 2 cm;
            margin-left: 2 cm;
			margin-right: 2 cm;
			margin-bottom: 2 cm;
		font-size: 12px;
		font-family: Impact, Haettenschweiler, Franklin Gothic Bold, Arial Black," sans-serif";
	}
	
	.tabel {
    	border-collapse:collapse;
	}
	
	.pagebreak { 
	page-break-before: always; 
	}
	.normal { 
	font-size: 12px; 
	}
</style>
</head>

<body>
	<div style="font-size: 14px"><center>
	  <strong>PAKTA INTEGRITAS</strong>
	</center></div>
	<br><br><br><br>
	<table style="text-align: justify" width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="2">Saya yang bertanda tangan dibawah ini, dalam rangka Pengadaan <?php echo $DATA_IDENTITAS['pekerjaan']; ?> pada RSUD Ajibarang dengan ini menyatakan bahwa saya:</td>
    </tr>
    <tr>
      <td width="2%" valign="top">1.</td>
      <td width="98%">Tidak akan melakukan praktek KKN;</td>
    </tr>
    <tr>
      <td valign="top">2.</td>
      <td> Akan melaporkan kepada pihak yang berwajib/ berwenang apabila mengetahui ada indikasi KKN di dalam proses pengadaan ini</td>
    </tr>
    <tr>
      <td valign="top">3.</td>
      <td>Dalam proses pengadaan ini, berjanji akan melaksanakan tugas secara bersih, transparan dan professional dalam arti akan mengerahkan segala kemampuan dan sumber daya secara optimal untuk memberikan hasil kerja terbaik mulai dari penyiapan penawaran, pelaksanaan dan penyelesaian pekerjaan / kegiatan ini ;</td>
    </tr>
    <tr>
      <td valign="top">4.</td>
      <td>Apabila saya melanggar hal-hal yang telah saya nyatakan dalam PAKTA INTEGRITAS ini, saya bersedia dikenakan sanksi moral, sanksi administrasi serta dituntut ganti rugi dan pidana sesuai dengan ketentuan peraturan perundang-undangan yang berlaku.</td>
    </tr>
  </tbody>
</table>

	<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="50%">&nbsp;</td>
      <td width="50%" align="right">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">Ajibarang, <?php echo tanggal_indo(date('Y-m-d'),true); ?></td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center"><u><?php echo $DATA_IDENTITAS['nama_pj']; ?></u></td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center"><?php echo $DATA_IDENTITAS['posisi']; ?></td>
    </tr>
  </tbody>
</table>
	
</body>
</html>
<?php
$html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 11.69 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporanpengeluaran.pdf',array('Attachment' => 0));
?>
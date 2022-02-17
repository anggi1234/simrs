<?php
ob_start();
session_start();
include '../connect.php';
// $idxdaftar = $_GET['idxdaftar'];
$idxdaftar = 665939;

$sqlidentitas = "
SELECT
    a.no_kontrol,
    c.nama,
    CASE
        WHEN c.jeniskelamin = 'L' THEN 'LAKI-LAKI'
        WHEN c.jeniskelamin = 'P' THEN 'PEREMPUAN'
    END AS JK,
    c.alamat,
    b.nomr,
    CONCAT(h.code, ', ', h.str) AS nama_penyakit,
    DATE_FORMAT(a.tanggal_kontrol, '%d-%m-%Y') AS tanggal_kontrol,
	DATE_FORMAT(b.tglreg, '%d-%m-%Y') AS tglcetak,
    f.userlevelname,
    a.alasan_kontrol,
    b.pasien_usia,
    g.namadokter,
    a.idxdaftar,
    i.signature
FROM
    data_lain a
        LEFT JOIN
    data b ON a.idxdaftar = b.idxdaftar
        LEFT JOIN
    m_pasien c ON b.nomr = c.nomr
        LEFT JOIN
    data_penyakit d ON a.idxdaftar = d.idxdaftar
        LEFT JOIN
    master_penyakit e ON d.id_penyakit = e.id_master_penyakit
        LEFT JOIN
    userlevels f ON a.userlevelid_kontrol = f.userlevelid
        LEFT JOIN
    m_dokter g ON b.kddokter = g.kddokter
        LEFT JOIN
    icd_eklaim h ON d.icd10 = h.code
    LEFT JOIN master_login i on g.kddokter=i.kddokter
WHERE a.idxdaftar = $idxdaftar and a.userlevelid is null";
$queryidentitas = mysqli_query($mysqli, $sqlidentitas);
$DATA_IDENTITAS = mysqli_fetch_array($queryidentitas);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SURAT KONTROL</title>

<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
		font-size: 12px;
		font-family: Gotham, Helvetica Neue, Helvetica, Arial," sans-serif";
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
  <span style="font-size: 18px">SURAT PERINTAH KONTROL RAWAT JALAN PASIEN BPJS KESEHATAN</span>
</center>
<center><strong style="font-size: 24px">NO. SURAT: <?php echo $DATA_IDENTITAS['no_kontrol']; ?></strong></center><br>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="17%">Nama</td>
      <td width="51%">: <?php echo $DATA_IDENTITAS['nama']; ?></td>
      <td width="13%">Umur</td>
      <td width="19%">: <?php echo $DATA_IDENTITAS['usia']; ?></td>
    </tr>
    <tr>
      <td>Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS['JK']; ?></td>
      <td>No. RM</td>
      <td>: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td>: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
      <td>Diagnosis</td>
      <td>: <?php echo $DATA_IDENTITAS['nama_penyakit']; ?></td>
    </tr>
  </tbody>
</table>
<br>
<u>Masih membutuhkan pemeriksaan lanjutan ke RSUD Besemah Pagar Alam pada unit:</u>
<br><br>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="23%">Poliklinik</td>
      <td width="77%">: <?php echo $DATA_IDENTITAS['userlevelname']; ?></td>
    </tr>
    <tr>
      <td>Tanggal Kontrol</td>
      <td>: <?php echo $DATA_IDENTITAS['tanggal_kontrol']; ?></td>
    </tr>
    <tr>
      <td>Alasan Kontrol</td>
      <td>: <?php echo $DATA_IDENTITAS['alasan_kontrol']; ?></td>
    </tr>
  </tbody>
</table><br>

Pasien penyakit kronis mohon kontrol setelah 30 hari dengan obat penuh dan apabila telah stabil diberi Rujuk Balik

<table width="100%" class="tabel">
	<tr>
    <td width="29%">&nbsp;</td>
    <td width="39%">&nbsp;</td>
    <td width="32%" align="center">Pagaralam, <?php echo $DATA_IDENTITAS['tglcetak']; ?></td>
  </tr>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">Dokter Poliklinik</td>
  </tr>
	<!-- <tr>
	  <td align="center"></td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
  </tr> -->
	<tr>

	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center"><center><img height="60px" src=""/></center></td>
  </tr>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>

	  <td align="center"><?php echo $DATA_IDENTITAS['namadokter']; ?></td>
  </tr>
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
$paper_size = [0, 0, 8.26 * 72, 6 * 72];
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('surat_kontrol.pdf', ['Attachment' => 0]);
?>
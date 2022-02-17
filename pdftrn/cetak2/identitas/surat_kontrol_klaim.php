<?php
ob_start();
session_start();
include('../connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];
$nomr = $_GET['nomr'];

$sqlidentitas="
SELECT 
    a.id_bill_detail_lain,
    a.no_kontrol,
    c.nama,
    CASE
        WHEN c.jeniskelamin = 'L' THEN 'LAKI-LAKI'
        WHEN c.jeniskelamin = 'P' THEN 'PEREMPUAN'
    END AS JK,
    c.alamat,
    b.nomr,
    (SELECT 
            CONCAT(z.icd10, ', ', y.str) AS diagnosa
        FROM
            simrs.bill_detail_penyakit z
                LEFT JOIN
            simrs2012.vw_diagnosa_eklaim y ON z.icd10 = y.code
        WHERE
            z.jenis_diagnosa = 'PRIMER'
                AND z.id_bill_detail_tarif = a.id_bill_detail_tarif
        GROUP BY z.id_bill_detail_tarif) AS nama_penyakit,
    DATE_FORMAT(a.tanggal_kontrol, '%d-%m-%Y') AS tanggal_kontrol,
    DATE_FORMAT(b.tglreg, '%d-%m-%Y') AS tglcetak,
    f.userlevelname,
    a.alasan_kontrol,
    b.usia,
    g.nama_dokter,
    a.id_bill_detail_tarif,
    i.signature
FROM
    simrs.bill_detail_lain a
        LEFT JOIN
    simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
        AND a.userlevelid_kontrol = b.userlevelid
        LEFT JOIN
    simrs2012.m_pasien c ON b.nomr = c.nomr
        LEFT JOIN
    simrs.userlevels f ON a.userlevelid_kontrol = f.userlevelid
        LEFT JOIN
    simrs.m_dokter g ON b.kddokter = g.kddokter
        AND b.userlevelid = g.userlevelid
        LEFT JOIN
    simrs.master_login i ON g.kddokter = i.kddokter
WHERE
    a.id_bill_detail_tarif <> $id_bill_detail_tarif
        AND b.nomr = $nomr
ORDER BY a.id_bill_detail_lain DESC";
// print_r($sqlidentitas);
// die();
 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

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
      <td width="10%" rowspan="3" align="right"><img src="../gambar/logobms.png" height="70px" /></td>
      <td width="90%" align="center" style="font-size: 16px">PEMERINTAH KABUPATEN BANYUMAS</td>
    </tr>
    <tr>
      <td align="center"><strong style="font-size: 21px">RUMAH SAKIT UMUM DAERAH AJIBARANG</strong></td>
    </tr>
    <tr>
      <td align="center" style="font-size: 14px">Jl. Raya Pancasan - Ajibarang, Kode Pos 53163 <br> 
      Telp. (0281) 6570004 Fax. (0281) 6570005 <br> 
      E-mail : rsudajibarang@banyumaskab.go.id</td>
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
<u>Masih membutuhkan pemeriksaan lanjutan ke RSUD Ajibarang pada unit:</u>
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
    <td width="32%" align="center">Ajibarang, <?php echo $DATA_IDENTITAS['tglcetak']; ?></td>
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
	  <td align="center"><center><img height="60px" src="../../uploads/<?php echo $DATA_IDENTITAS['signature']; ?>"/></center></td>
  </tr>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  
	  <td align="center"><?php echo $DATA_IDENTITAS['nama_dokter']; ?></td>
  </tr>
</table>


</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 6 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('12_surat_kontrol.pdf',array('Attachment' => 0));
?>
<?php
ob_start();
include('../connect.php');
$id_bill_detail_tarif_detail = $_GET['id_bill_detail_tarif_detail'];


$sqlidentitas="SELECT 
    c.nomr,
    d.NAMA,
    DATE_FORMAT(d.tgllahir, '%d-%m-%Y') AS tgllahir,
    d.alamat,
    e.userlevelname,
    f.nama AS pembayaran,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y') AS tanggal,
    CASE
        WHEN a.userlevelid_asal = 17 THEN ''
        WHEN a.userlevelid_asal <> 17 THEN g.nama_dokter
    END AS nama_dokter
FROM
    simrs.bill_detail_tarif_detail a
        LEFT JOIN
    simrs.bill_detail_tarif c ON a.id_bill_detail_tarif = c.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_pasien d ON c.nomr = d.nomr
        LEFT JOIN
    userlevels e ON c.userlevelid = e.userlevelid
        LEFT JOIN
    simrs2012.m_carabayar f ON c.kdcarabayar = f.kode
        LEFT JOIN
    simrs.m_dokter g ON c.kddokter = g.kddokter
        AND c.userlevelid = g.userlevelid
where a.id_bill_detail_tarif_detail=$id_bill_detail_tarif_detail";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);
 
 
 $sqlphoto="SELECT 
    GROUP_CONCAT(b.nama_tindakan
        SEPARATOR ', ') AS tindakan
FROM
    simrs.v_bill_detail_tindakan_penunjang a
        LEFT JOIN
    simrs.master_tindakan b ON a.id_tindakan = b.id_tindakan
WHERE
    a.id_bill_detail_tarif_detail = $id_bill_detail_tarif_detail
GROUP BY a.id_bill_detail_tarif_detail";

 $queryphoto = mysql_query($sqlphoto);
 $DATA_PHOTO = mysql_fetch_array($queryphoto);
?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Cetak Label</title>

<style type="text/css">
	
	@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
		
	}
	
.tabelfix {
    border-collapse:collapse;
	font-size: 20px;
}
.oke {
    border:none;
}
	
	
	
	</style>
</head>

<body>
	
	
<table width="100%" border="0" cellpadding="5" cellspacing="5" class="tabelfix">
  <tbody>
    <tr>
      <td width="30%">NO. RM</td>
      <td width="3%">:</td>
      <td width="67%"><?php echo $DATA_IDENTITAS['nomr']; ?></td>
    </tr>
    <tr>
      <td style="vertical-align:top">NAMA</td>
      <td style="vertical-align:top">:</td>
      <td><?php echo $DATA_IDENTITAS['NAMA']; ?></td>
    </tr>
    <tr>
      <td>TANGGAL LAHIR</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
    </tr>
    <tr>
      <td style="vertical-align:top">ALAMAT</td>
      <td style="vertical-align:top">:</td>
      <td><?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
    <tr>
      <td>UNIT</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['userlevelname']; ?></td>
    </tr>
    <tr>
      <td>PEMBAYARAN</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['pembayaran']; ?></td>
    </tr>
    <tr>
      <td style="vertical-align:top">PHOTO</td>
      <td style="vertical-align:top">:</td>
      <td><?php echo $DATA_PHOTO['tindakan']; ?>.</td>
    </tr>
    <tr>
      <td>TANGGAL</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['tanggal']; ?></td>
    </tr>
    <tr>
      <td>DOKTER</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['nama_dokter']; ?>.</td>
    </tr>
  </tbody>
</table>

	
	
	
</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.66 * 72, 5.51 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('coba.pdf',array('Attachment' => 0));
?>
<?php
ob_start();
include('../connect.php');
$id_expertise_radiologi =$_GET['id_expertise_radiologi'];
$username = $_GET['username'];

$sqlisi="SELECT * FROM simrs.expertise_detail_radiologi where id_expertise_radiologi=$id_expertise_radiologi";
 $queryisi = mysql_query($sqlisi);
 $DATA_ISI = mysql_fetch_array($queryisi);


$sqlidentitas="SELECT 
    a.id_expertise_radiologi,
    c.nomr,
    d.NAMA,
    d.ALAMAT,
    DATE_FORMAT(d.TGLLAHIR, '%d-%m-%Y') AS TGLLAHIR,
    e.nama AS cara_bayar,
    DATE_FORMAT(b.tanggal, '%d-%m-%Y') AS tanggal,
    a.photo,
    f.namadokter AS pengirim,
	CASE
        WHEN b.userlevelid_asal = 17 THEN ''
        WHEN b.userlevelid_asal <> 17 THEN f.namadokter
    END AS pengirim,
    i.signature_pad
FROM
    expertise_radiologi a
        LEFT JOIN
    bill_detail_tarif_detail b ON a.id_bill_detail_tarif_detail = b.id_bill_detail_tarif_detail
        LEFT JOIN
    bill_detail_tarif c ON b.id_bill_detail_tarif = c.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_pasien d ON c.nomr = d.NOMR
        LEFT JOIN
    simrs2012.m_carabayar e ON c.kdcarabayar = e.kode
        LEFT JOIN
    simrs2012.m_dokter f ON c.kddokter = f.kddokter
        LEFT JOIN
    simrs.m_dokter h ON a.userlevelid = h.userlevelid
        LEFT JOIN
    simrs.master_login i ON i.kddokter = h.kddokter
where a.id_expertise_radiologi=$id_expertise_radiologi";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqlusername="select pd_nickname,signature_pad from master_login where username='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>EXPERTISE RADIOLOGI</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 0.3 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 12px;
}
	
.kosong {
    border:none;
}
	
.header {
	font-size: 12px;
}	
.footer {
	font-size: 12px;
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
  

    <div align="center"><strong>HASIL PEMERIKSAAN RADIOLOGI</strong></div>



<table width="100%" class="footer" border="0">
    <tr>
      <td width="18%">No. RM</td>
      <td width="27%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="19%">Alamat</td>
      <td width="36%">: <?php echo $DATA_IDENTITAS['ALAMAT']; ?></td>
    </tr>
    <tr>
      <td>Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['NAMA']; ?></td>
      <td>Cara Bayar</td>
      <td>: <?php echo $DATA_IDENTITAS['cara_bayar']; ?></td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS['TGLLAHIR']; ?></td>
      <td>Tanggal Periksa</td>
      <td>: <?php echo $DATA_IDENTITAS['tanggal']; ?></td>
  </tr>
    <tr>
      <td valign="top">Jenis Pemeriksaan</td>
      <td valign="top">: <?php echo $DATA_IDENTITAS['photo']; ?></td>
      <td valign="top">Pengirim</td>
      <td valign="top">: <?php echo $DATA_IDENTITAS['pengirim']; ?></td>
    </tr>
</table>

<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="8%" style="vertical-align:top"><strong>KLINIS</strong></td>
      <td width="3%" style="vertical-align:top">:</td>
      <td width="89%" style="vertical-align:top"><?php echo $DATA_ISI['klinis']; ?></td>
    </tr>
    <tr>
      <td style="vertical-align:top"><strong>DESKRIPSI</strong></td>
      <td style="vertical-align:top">:</td>
      <td style="vertical-align:top"><?php echo $DATA_ISI['bacaan']; ?></td>
    </tr>
    <tr>
      <td style="vertical-align:top"><strong>KESAN</strong></td>
      <td style="vertical-align:top">:</td>
      <td style="vertical-align:top"><strong><?php echo $DATA_ISI['kesan']; ?></strong></td>
    </tr>
  </tbody>
</table>

<div align="right" style="position: relative;">
  <div style="position: absolute; bottom: 5px;">
  <div align="right">
        Spesialis Radiodiagnostik,
      <br><img height="80px" src="<?php echo $DATA_IDENTITAS['signature_pad'];?>"/><br>
      <?php echo $DATA_IDENTITAS['dokter_radiologi']; ?>
      </div>
  </div>
</div>	


</body>
</html>
<?php
$html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.4 * 72, 11 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('46_expertise_radiologi.pdf',array('Attachment' => 0));
?>
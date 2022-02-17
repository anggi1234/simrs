<?php
ob_start();
session_start();
include('../connect.php');
$nomr = $_GET['nomr'];
$idxdaftar = $_GET['idxdaftar'];
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];

$sqlitemanamnesa="";
$queryitemanamnesa = mysql_query($sqlitemanamnesa);
$DATAISI = mysql_fetch_array($queryitemanamnesa);

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>FORM ASSESEMENT AWAL</title>
<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}
	
.tabel {
    border-collapse:collapse;
}
	
.header {
	font-size: 12px;
}	
.footer {
	font-size: 12px;
}
.isi {
	font-size: 10px;
}
.pagebreak { 
		page-break-before: always;
	}
    .vertical-line{

        display: inline-block;
        border-left: 1px solid #000000;
        height: 40px;

    }
	

</style>
</head>

<body>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="33%"><table width="100%" border="0">
        <tbody>
          <tr>
            <td width="23%" align="center"><img src="../gambar/logobms.png" height="40px" /></td>
            <td width="77%" align="center" style="font-size: 7px; font-weight: bold" valign="middle">PEMERINTAH KABUPATEN BANYUMAS<br>RUMAH SAKIT UMUM DAERAH AJIBARANG<br>Jl. Raya Pancasan – Ajibarang<br>(0281) 6570004   Fax. (0281) 6570005<br>Email:rsudajibarang@banyumaskab.go.id</td>
          </tr>
        </tbody>
      </table></td>
      <td width="33%" style="font-size: 12px"><p align="center"><strong>ASSASEMEN RAWAT JALAN <br> <?php echo $DATAISI['userlevelname']; ?></strong><br>
      <strong></strong></p></td>
      <td width="33%" valign="middle" style="font-weight: bold"><table width="100%" style="font-size: 11px" border="0">
        <tbody>
          <tr>
            <td width="27%">NO RM</td>
            <td width="4%">:</td>
            <td width="69%"><?php echo $DATAISI['nomr']; ?></td>
          </tr>
          <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?php echo $DATAISI['nama']; ?></td>
          </tr>
          <tr>
            <td>Tgl Lahir</td>
            <td>:</td>
            <td><?php echo $DATAISI['tgllahir']; ?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>

<table width="100%" border="1" class="tabel">
  <tbody>
    <tr>
      <td align="center">Tanggal Jam</td>
      <td align="center">Tetesan Infus</td>
      <td align="center">Tensi</td>
      <td align="center">Nadi</td>
      <td align="center">Kontraksi Uterus</td>
      <td align="center">DJJ</td>
      <td align="center">Kemajuan Persalinan</td>
      <td align="center">Nama dan Paraf Penolong Persalinan</td>
    </tr>
  
  </tbody>
</table>

	    
	
<div style="font-size: 9px; font-style: oblique">Terima kasih atas kerjasamanya telah mengisi formulir ini dengan jelas dan benar.</div> 
<div style="font-size: 9px; font-style: oblique">SIMRS VERSI 2.0 RSUD Ajibarang</div> 

</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.46 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('nota.pdf',array('Attachment' => 0));
?>
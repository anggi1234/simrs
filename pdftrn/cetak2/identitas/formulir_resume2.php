<?php
ob_start();
session_start();
include('../connect.php');
$nomr = $_GET['nomr'];

$sqlitemanamnesa="";
$queryitemanamnesa = mysql_query($sqlitemanamnesa);
$queryitemanamnesa1 = mysql_query($sqlitemanamnesa);
$DATAISI = mysql_fetch_array($queryitemanamnesa1);

$sqlumur="";
$queryumur = mysql_query($sqlumur);
$DATAUMUR = mysql_fetch_array($queryumur);

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>FORMULIR RAWAT JALAN</title>
<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
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

.pagebreak { 
		page-break-before: always;
}
	
.kosong {
    border:none;
}
	
body {
margin: 0;
padding: 0;
border: 2px solid #000000;
}

</style>
</head>

<body>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="33%">
      	<table width="100%" border="0">
        <tbody>
          <tr>
            <td width="23%" align="center"><img src="../gambar/logobms.png" height="60px" /></td>
            <td width="77%" align="center" style="font-size: 10px; font-weight: bold" valign="top">PEMERINTAH KABUPATEN BANYUMAS<br>RUMAH SAKIT UMUM DAERAH AJIBARANG<br>Jl. Raya Pancasan – Ajibarang<br>(0281) 6570004   Fax. (0281) 6570005<br>Email:rsudajibarang@banyumaskab.go.id</td>
          </tr>
        </tbody>
      </table></td>
      <td width="33%" style="font-size: 12px"><p align="center"><strong>FORMULIR <br/> RESUME RAWAT JALAN</strong><br>
      </p></td>
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
            <td valign="top">Tgl Lahir</td>
            <td valign="top">:</td>
            <td><?php echo $DATAISI['tgllahir']; ?>  <br>/ <?php echo $DATAUMUR['umur']; ?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>
	  
<table width="100%" class="tabel" style="font-size: 12px" border="1">
  <tbody>
    <tr>
      <td colspan="5">Diisi Oleh Perawat Penanggungjawab Pasien</td>
    </tr>
    <tr>
      <td colspan="2" align="center">ALERGI</td>
      <td colspan="3" align="center">RAWAT INAP - OPERASI</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td width="20%" align="center">TANGGAL</td>
      <td width="20%" align="center">KLINIK / NAMA DOKTER</td>
      <td width="20%" align="center">DIAGNOSE</td>
      <td width="20%" align="center">TERAPI</td>
      <td width="20%" align="center">KET</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>


	
	<div align="right" style="position: relative;">
	<div style="position: absolute; bottom: 9px;">
		<div align="left" style="font-size: 9px; font-style: oblique">
      		Terima kasih atas kerjasamanya telah mengisi formulir ini dengan jelas dan benar.
    	</div>
	</div>
</div>	

</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.27 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('nota.pdf',array('Attachment' => 0));
?>
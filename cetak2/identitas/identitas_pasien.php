<?php
ob_start();
include('../connect.php');
$nomr = $_GET['nomr'];
	
$sqlidentitas="SELECT 
    nomr, nama, tgllahir
FROM
    simrs2012.m_pasien where nomr=$nomr";
 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);
	
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Identitas Pasien</title>

<style>
	@page {
            margin-top: 0.1 cm;
            margin-left: 0.1 cm;
			margin-right: 0.1 cm;
			margin-bottom: 0.1 cm;
	}
	
	.penulisan{
		font-family: Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial," sans-serif";
		font-size: 9px;
		font-weight: bold;
	}
	
	.pagebreak { 
		page-break-after: always;
		
	}
</style>
</head>

<body>
	<table width="100%" class="penulisan" border="0">
  <tbody valign="middle">
    <tr>
      <td width="24%">NOMR</td>
      <td width="1%">:</td>
      <td width="75%"><?php echo $DATA_IDENTITAS['nomr']; ?></td>
    </tr>
    <tr>
      <td>NAMA</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['nama']; ?></td>
    </tr>
    <tr>
      <td>TGL LAHIR</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
    </tr>
  </tbody>
</table>

</body>

</html>
<?php
$html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 2.36 * 72, 1 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('identitas.pdf',array('Attachment' => 0));
?>
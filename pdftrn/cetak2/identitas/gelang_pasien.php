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
<title>Gelang Pasien</title>

<style>
	@page {
            margin-top: 0.1 cm;
            margin-left: 0.1 cm;
			margin-right: 0.1 cm;
			margin-bottom: 0.1 cm;
	}
	
	.penulisan{
		font-family: Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial," sans-serif";
		font-size: 12px;
		font-weight: bold;
	}
	
	.pagebreak { 
		page-break-after: always;
		
	}
</style>
</head>

<body>
	<table width="100%" class="penulisan" border="0">
  <tbody>
    <tr>
      <td width="8%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="5%">NOMR</td>
      <td width="1%">:</td>
      <td width="85%"><?php echo $DATA_IDENTITAS['nomr']; ?> | TGL LAHIR : <?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>NAMA</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['nama']; ?></td>
    </tr>
  </tbody>
</table>

</body>

</html>
<?php
$html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 7.36 * 72, 0.8 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('gelang.pdf',array('Attachment' => 0));
?>
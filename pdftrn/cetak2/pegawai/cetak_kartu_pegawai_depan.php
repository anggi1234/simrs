<?php
ob_start();
include('../connect.php');
$uid = $_GET['uid'];

$sqlidentitas="SELECT pd_avatar FROM simrs.master_login where uid=$uid;";
 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);
 
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Kartu Identitas</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	
	@page {
            margin-top: 0.1 cm;
            margin-left: 0.1 cm;
			margin-right: 0.1 cm;
			margin-bottom: 0.1 cm;
			font-family:Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial," sans-serif";
			size: 155.90pt 240.94pt;
	}
	
.header {
	border-collapse: collapse;
	font-size: 14px;
	}
.footer {
	border-collapse: collapse;
	font-size: 50px;
	}

</style>
</head>
<body>

<table width="100%" border="0">
  <tr>
    <td align="center" class="header">
    <img src="../gambar/banyumas.png" width="44px" height="44px"/><br /></td>
  </tr>
  <tr>
    <td align="center" class="header"><strong style="line-height: 11px">PEMERINTAH<br />
KABUPATEN BANYUMAS</strong></td>
  </tr>
  <tr>
    <td align="center"><?php echo '<img src="../../uploads/'.$DATA_IDENTITAS['pd_avatar'].'" width="165px" height="180px"/>' ?></td>
  </tr>
  
  <div style="position: absolute; background-color: #4267b2; bottom: 7px;">
 		<p>
  		<center valign="center" style="color: #F4EEEE; font-size: 20px;"><strong>RSUD AJIBARANG</strong></center>
  		</p>
  </div>
  
</table>


</body>
</html>

<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0,155.90, 240.94);
$dompdf->set_paper($paper_size,'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('kartuid.pdf',array('Attachment' => 0));
?>
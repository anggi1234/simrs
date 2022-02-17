<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
		font-size: 8px;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}

table {
  border-collapse: collapse;
  border: 1px solid black;
}
</style>
</head>

<body>
<table width="33%">
  <tbody>
    <tr>
      <td colspan="2" align="center"><strong>POLI:</strong></td>
    </tr>
    <tr>
      <td colspan="2" align="center">TGL PELAYANAN:</td>
    </tr>
    <tr>
      <td width="24%">NAMA</td>
      <td width="76%">:</td>
    </tr>
    <tr>
      <td>NO RM</td>
      <td>:</td>
    </tr>
    <tr>
      <td>TGLLAHIR</td>
      <td>:</td>
    </tr>
  </tbody>
</table>

</body>
</html>
<?php
$html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 6 * 72, 7 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('LAPORAN_SLIT_LAMP.pdf',array('Attachment' => 0));
?>
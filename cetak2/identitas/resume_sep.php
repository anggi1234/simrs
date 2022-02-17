<?php
ob_start();
session_start();
include('../connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];

$sqlSEP="SELECT nama_file FROM simrs.bill_detail_upload
	WHERE
    id_bill_detail_tarif = $id_bill_detail_tarif AND nama_dokumen='SEP'";

 $querySEP = mysql_query($sqlSEP);
 $DATA_SEP = mysql_fetch_array($querySEP);
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Hasil Scan SEP</title>
</head>

<body>
<img height="90%" width="80%" src="../../dokumen_rm/<?php echo $DATA_SEP['nama_file']; ?>"/>
</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 11.69 * 72);
$dompdf->set_paper($paper_size, 'landscape');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporanoperasi.pdf',array('Attachment' => 0));
?>
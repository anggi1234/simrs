<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
	<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
		font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 12px;
}


</style>
</head>

<body>
	<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="4%" rowspan="2" align="center">No.</td>
      <td width="27%" rowspan="2">Variabel</td>
      <td width="56%" rowspan="2">Pertanyaan</td>
      <td width="13%" align="center">Skor</td>
    </tr>
    <tr>
      <td align="center">YA=1, TIDAK=0</td>
    </tr>
    <tr>
      <td align="center">1.</td>
      <td>Kondisi Pasien Sekarang apakah pasien</td>
      <td>Apakah pasien terlihat kurus</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td rowspan="2" align="center">2.</td>
      <td rowspan="2">Penurunan Berat Badan</td>
      <td>Apakah pakaian anda terasa lebih longgar</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Apakah akhir-akhir ini kehilangan berat badan yang tidak sengaja (3-6 bln terakhir)</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">3.</td>
      <td>Penurunan Asupan Makanan</td>
      <td>Apakah anda mengalami penurunan asupan makanan selama satu minggu terakhir</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td rowspan="2" align="center">4.</td>
      <td rowspan="2">Riwayat Penyakit</td>
      <td>Apakah anda merasa lemah loyo dan tidak bertenaga</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Apakah anda menderita suatu penyakit yang mengakitbatkan adanya perubahan jumlah atau jenis makanan yang anda makan</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>

</body>
</html>

<?php
 $html = ob_get_clean();
require_once("dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.66 * 72, 11.69 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('notarincianpenunjang.pdf',array('Attachment' => 0));
?>
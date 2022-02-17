<?php
ob_start();
// include('../connect.php');
include('../connect2.php');
 $id = $_GET['id'];
	
$sqlitemetiket="SELECT a.id, b.nama_alat as instrumen, c.userlevelname AS ruang, a.jam_masuk_steril as tgl_steril, a.exp_date as tgl_exp, d.mesin, a.mesin_load as loadke, e.pd_nickname as petugas_steril from simrs2012.t_cssd a
left outer join simrs2012.m_alat_cssd b on b.alat_id = a.instrumen
left outer join simrs.userlevels c on c.userlevelid = a.ruang
left outer join simrs2012.l_mesin_cssd d on d.id = a.mesin_autoclave
left outer join simrs.master_login e on e.uid = a.petugas_sterilisasi
where a.id = $id";
$queryitemetiket = mysql_query($sqlitemetiket);

// print_r($sqlitemetiket);
// die();

$tgl_cetak = date("Y-m-d h:i:sa");
	
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CSSD RSUD AJB</title>

<style>
	@page {
            margin-top: 1.0 cm;
            margin-left: 0.3 cm;
			margin-right: 0.1 cm;
			margin-bottom: 0.1 cm;
	}
	
	.penulisan{
		font-family: Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial," sans-serif";
		font-size: 8px;
		font-weight: bold;
	}
	
	.pagebreak { 
		page-break-after: always;
		
	}
</style>
</head>


<a><center><b><u>CSSD RSUD AJIBARANG</u></b></center></a>
<br>
<?php
while($data=mysql_fetch_assoc($queryitemetiket)){
echo '<body>
<table class="penulisan" width="100%" border="0">
  <tbody>
    <tr>
      <td width="35%">Instrumen</td>
      <td width="7%">:</td>
      <td width="68%">'.$data['instrumen'].'</td>
    </tr>
    <tr>
      <td colspan="3"><center></center></td>
    </tr>
    <tr>
      <td width="13%">Ruang</td>
      <td width="7%">:</td>
      <td width="80%">'.$data['ruang'].'</td>
    </tr>
    <tr>
      <td width="13%">Tgl Steril</td>
      <td width="7%">:</td>
      <td width="80%">'.$data['tgl_steril'].'</td>
    </tr>
    <tr>
      <td width="13%">Tgl Exp</td>
      <td width="7%">:</td>
      <td width="80%">'.$data['tgl_exp'].'</td>
    </tr>
    <tr>
      <td width="13%">Mesin</td>
      <td width="7%">:</td>
      <td width="80%">'.$data['mesin'].'</td>
    </tr>
    <tr>
      <td width="13%">Load</td>
      <td width="7%">:</td>
      <td width="80%">'.$data['loadke'].'</td>
    </tr>
    <tr>
      <td width="13%">Petugas St</td>
      <td width="7%">:</td>
      <td width="80%">'.$data['petugas_steril'].'</td>
    </tr>
    <tr>
      <td colspan="3" align="center"><hr></td>
    </tr>
    <tr>
      <td width="13%">&nbsp;</td>
      <td width="7%">&nbsp;</td>
      <td width="80%" align="right">Tanggal: '.$tgl_cetak.'</td>
    </tr>
  </tbody>
</table></body>';
		}
?>




</html>
<?php
$html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 2.36 * 72, 2.95 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('labelcssd.pdf',array('Attachment' => 0));
?>
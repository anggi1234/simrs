<?php
ob_start();
include('../connect.php');
$id_bill_detail_permintaan_obat_master = $_GET['id_bill_detail_permintaan_obat_master'];
	
$sqlitemetiket="SELECT 
    c.nomr,
    d.nama,
    DATE_FORMAT(d.tgllahir, '%d-%m-%Y') as tgllahir,
    e.userlevelname,
    g.nama_obat,
    a.qty,
    h.nama_resep,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y') AS tgl
FROM
    simrs.bill_detail_permintaan_obat a
        LEFT JOIN
    bill_detail_permintaan_obat_master b ON a.id_bill_detail_permintaan_obat_master = b.id_bill_detail_permintaan_obat_master
        LEFT JOIN
    bill_detail_tarif c ON b.id_bill_detail_tarif = c.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_pasien d ON c.nomr = d.nomr
        LEFT JOIN
    userlevels e ON c.userlevelid = e.userlevelid
        LEFT JOIN
    master_obat_detail f ON a.id_master_obat_detail = f.id_master_obat_detail
        LEFT JOIN
    master_obat g ON f.id_obat = g.id_obat
        LEFT JOIN
    master_resep h ON a.id_master_resep = h.id_master_resep where a.id_bill_detail_permintaan_obat_master=$id_bill_detail_permintaan_obat_master and a.id_jenis_etiket=1";
$queryitemetiket = mysql_query($sqlitemetiket);

	
	
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ETIKET PULANG</title>

<style>
	@page {
            margin-top: 0.1 cm;
            margin-left: 0.1 cm;
			margin-right: 0.1 cm;
			margin-bottom: 0.1 cm;
	}
	
	.penulisan{
		font-family: Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial," sans-serif";
		font-size: 11px;
		font-weight: bold;
	}
	
	.pagebreak { 
		page-break-after: always;
		
	}
</style>
</head>


<?php
while($data=mysql_fetch_assoc($queryitemetiket)){
echo '<body>
<table class="penulisan" width="100%" border="0">
  <tbody>
    <tr>
      <td width="20%">NOMR</td>
      <td width="7%">:</td>
      <td width="80%">'.$data['nomr'].'</td>
    </tr>
    <tr>
      <td colspan="3"><center>'.$data['nama'].'</center></td>
    </tr>
    <tr>
      <td width="13%">TGL LAHIR</td>
      <td width="7%">:</td>
      <td width="80%">'.$data['tgllahir'].'</td>
    </tr>
    <tr>
      <td width="13%">POLI</td>
      <td width="7%">:</td>
      <td width="80%">'.$data['userlevelname'].'</td>
    </tr>
    <tr>
      <td colspan="3" align="center"><hr>'.$data['nama_obat'].'</td>
    </tr>
    <tr>
      <td colspan="3" align="center">'.$data['nama_resep'].'<hr></td>
    </tr>
    <tr>
      <td width="13%">Qty: '.$data['qty'].'</td>
      <td width="7%">&nbsp;</td>
      <td width="80%" align="right">Tanggal: '.$data['tgl'].'</td>
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
$dompdf->stream('notafarmasi.pdf',array('Attachment' => 0));
?>
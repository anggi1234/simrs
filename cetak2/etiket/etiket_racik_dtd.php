<?php
ob_start();
include('../connect.php');
$id_bill_detail_permintaan_obat_master = $_GET['id_bill_detail_permintaan_obat_master'];
	
$sqlitemetiket="SELECT 
    c.nomr,
    d.nama,
    DATE_FORMAT(d.tgllahir, '%d-%m-%Y') as tgllahir,
    e.userlevelname,
    concat(g.nama_obat, ' (',a.qty_temp,')') as nama_obat,
    a.qty,
    h.nama_resep,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y') AS tgl,
	b.jumlah_racikan
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
    master_resep h ON b.aturan_pakai = h.id_master_resep where a.id_bill_detail_permintaan_obat_master=$id_bill_detail_permintaan_obat_master";
$queryitemetiket = mysql_query($sqlitemetiket);
$queryitemetiket1 = mysql_query($sqlitemetiket);
$DATA_IDENTITAS = mysql_fetch_array($queryitemetiket1);

	
	
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ETIKET RACIK</title>

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
<table class="penulisan" width="100%" border="0">
  <tbody>
    <tr>
      <td width="30%">NOMR</td>
      <td width="7%">:</td>
      <td width="63%"><?php echo $DATA_IDENTITAS['nomr']; ?></td>
    </tr>
    <tr>
      <td colspan="3"><center><?php echo $DATA_IDENTITAS['nama']; ?></center></td>
    </tr>
    <tr>
      <td>TGL LAHIR</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
    </tr>
    <tr>
      <td>POLI</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['userlevelname']; ?></td>
    </tr>
	<tr>
	  <td colspan="3">&nbsp;</td>
    </tr>
	<tr>
      <td colspan="3">Jenis Racikan:</td>
    </tr>
	<?php
	  	$no=1;
		while($data=mysql_fetch_assoc($queryitemetiket)){
			echo '<tr>';
			echo '<td colspan="3" align="left">'.$data['nama_obat'].'</td>';
			echo '</tr>';
			
			$no++;
		}
	?>
    <tr>
      <td>Qty: <?php echo $DATA_IDENTITAS['jumlah_racikan']; ?></td>
      <td>&nbsp;</td>
      <td align="right">Tanggal: <?php echo $DATA_IDENTITAS['tgl']; ?></td>
    </tr>
    <tr>
      <td colspan="3">Aturan Pakai: <?php echo $DATA_IDENTITAS['nama_resep']; ?></td>
    </tr>
  </tbody>
</table>
</body>




</html>
<?php
$html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 2.36 * 72, 2.95 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('etiket.pdf',array('Attachment' => 0));
?>
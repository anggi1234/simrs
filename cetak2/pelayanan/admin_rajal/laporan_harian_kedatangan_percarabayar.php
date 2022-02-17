<?php
ob_start();
session_start();
include('../../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$username = $_GET['username'];


$sqliisi="SELECT 
    a.tglreg, ifnull(b.umum,0) as umum, ifnull(c.bpjs,0) as bpjs, ifnull(d.jamkesda,0) as jamkesda
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    (SELECT 
        tglreg, COUNT(*) AS umum
    FROM
        simrs.bill_detail_tarif
    WHERE
        kdcarabayar = 1
            AND (tglreg >= '$dari_tanggal'
            AND tglreg <= '$sampai_tanggal') and (userlevelid=1 or userlevelid=2 or userlevelid=2 or userlevelid=3 or userlevelid=4 or userlevelid=5 or userlevelid=6 or userlevelid=7 or userlevelid=12 or userlevelid=14 or userlevelid=28 or userlevelid=29 or userlevelid=30 or userlevelid=45)
    GROUP BY tglreg) b ON a.tglreg = b.tglreg
    LEFT JOIN
    (SELECT 
        tglreg, COUNT(*) AS bpjs
    FROM
        simrs.bill_detail_tarif
    WHERE
        (kdcarabayar = 2 or kdcarabayar = 3 or kdcarabayar = 4 or kdcarabayar = 6)
            AND (tglreg >= '$dari_tanggal'
            AND tglreg <= '$sampai_tanggal') and (userlevelid=1 or userlevelid=2 or userlevelid=2 or userlevelid=3 or userlevelid=4 or userlevelid=5 or userlevelid=6 or userlevelid=7 or userlevelid=12 or userlevelid=14 or userlevelid=28 or userlevelid=29 or userlevelid=30 or userlevelid=45)
    GROUP BY tglreg) c ON a.tglreg = c.tglreg
    LEFT JOIN
    (SELECT 
        tglreg, COUNT(*) AS jamkesda
    FROM
        simrs.bill_detail_tarif
    WHERE
        (kdcarabayar = 7 or kdcarabayar = 9)
            AND (tglreg >= '$dari_tanggal'
            AND tglreg <= '$sampai_tanggal') and (userlevelid=1 or userlevelid=2 or userlevelid=2 or userlevelid=3 or userlevelid=4 or userlevelid=5 or userlevelid=6 or userlevelid=7 or userlevelid=12 or userlevelid=14 or userlevelid=28 or userlevelid=29 or userlevelid=30 or userlevelid=45)
    GROUP BY tglreg) d ON a.tglreg = d.tglreg
WHERE
    a.tglreg >= '$dari_tanggal'
        AND a.tglreg <= '$sampai_tanggal'
GROUP BY a.tglreg
";
$queryisi = mysql_query($sqliisi);
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Kedatangan Percarabayar</title>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
		font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
	}
	
.tabel {
	border-collapse: collapse;
	font-size: 12px;
	text-align: right;
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

</style>
</head>

<body>
<table width="100%" border="0" cellpadding="-3px" cellspacing="0px">
    <tr>
      <td width="10%" rowspan="3" align="right"><img src="../../gambar/logobms.png" height="70px" /></td>
      <td width="90%" align="center" style="font-size: 16px">PEMERINTAH KABUPATEN BANYUMAS</td>
    </tr>
    <tr>
      <td align="center"><strong style="font-size: 21px">RUMAH SAKIT UMUM DAERAH AJIBARANG</strong></td>
    </tr>
    <tr>
      <td align="center" style="font-size: 14px">Jl. Raya Pancasan - Ajibarang, Kode Pos 53163 <br> 
      Telp. (0281) 6570004 Fax. (0281) 6570005 <br> 
      E-mail : rsudajibarang@banyumaskab.go.id</td>
    </tr>
</table>
<hr>
<div align="center"><strong>LAPORAN HARIAN KEDATANGAN PER CARA BAYAR</strong></div>
<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="15%" align="left">Dari Tanggal : <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td width="30%" align="right">Sampai Tanggal : <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>

<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="8%" align="center">No.</td>
      <td width="49%" align="center">Tanggal </td>
      <td width="16%" align="center">UMUM </td>
      <td width="14%" align="center">BPJS</td>
      <td width="13%" align="center">JAMKESDA</td>
    </tr>
    <?php
	  	$no=1;
		while($data=mysql_fetch_assoc($queryisi)){
			echo '<tr>';
	  		echo '<td align="center">'.$no.'.</td>';
			echo '<td align="left">'.$data['tglreg'].'</td>';
			echo '<td align="center">'.$data['umum'].'</td>';
			echo '<td align="center">'.$data['bpjs'].'</td>';
			echo '<td align="center">'.$data['jamkesda'].'</td>';
			echo '</tr>';
			
			$no++;
		}
	?>
    
  </tbody>
</table>



</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.66 * 72, 5.51 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporan_status.pdf',array('Attachment' => 0));
?>
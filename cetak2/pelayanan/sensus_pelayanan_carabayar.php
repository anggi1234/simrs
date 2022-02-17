<?php
ob_start();
session_start();
include('../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];


$sqlitem="SELECT 
    DATE_FORMAT(a.tanggal,'%d-%m-%Y') AS tgl,
    IFNULL(b.umum, 0) AS umum,
    IFNULL(c.kbs, 0) AS kbs,
    IFNULL(d.bpjs, 0) AS bpjs,
    IFNULL(e.jkn, 0) AS jkn,
    IFNULL(f.jamkesda, 0) AS jamkesda,
    IFNULL(b.umum, 0) + IFNULL(c.kbs, 0) + IFNULL(d.bpjs, 0) + IFNULL(e.jkn, 0) + IFNULL(f.jamkesda, 0) AS total
FROM
    bill_detail_tarif a
        LEFT JOIN
    (SELECT 
        DATE(tanggal) AS tgl, COUNT(*) AS umum
    FROM
        bill_detail_tarif
    WHERE
        DATE(tanggal) >= '$dari_tanggal'
            AND DATE(tanggal) <= '$sampai_tanggal'
            AND kdcarabayar = 1
            AND userlevelid = $userlevelid
    GROUP BY DATE(tanggal)) b ON DATE(a.tanggal) = b.tgl
        LEFT JOIN
    (SELECT 
        DATE(tanggal) AS tgl, COUNT(*) AS kbs
    FROM
        bill_detail_tarif
    WHERE
        DATE(tanggal) >= '$dari_tanggal'
            AND DATE(tanggal) <= '$sampai_tanggal'
            AND kdcarabayar = 7
            AND userlevelid = $userlevelid
    GROUP BY DATE(tanggal)) c ON DATE(a.tanggal) = c.tgl
        LEFT JOIN
    (SELECT 
        DATE(tanggal) AS tgl, COUNT(*) AS bpjs
    FROM
        bill_detail_tarif
    WHERE
        DATE(tanggal) >= '$dari_tanggal'
            AND DATE(tanggal) <= '$sampai_tanggal'
            AND (kdcarabayar = 3 OR kdcarabayar = 4
            OR kdcarabayar = 6)
            AND userlevelid = $userlevelid
    GROUP BY DATE(tanggal)) d ON DATE(a.tanggal) = d.tgl
        LEFT JOIN
    (SELECT 
        DATE(tanggal) AS tgl, COUNT(*) AS jkn
    FROM
        bill_detail_tarif
    WHERE
        DATE(tanggal) >= '$dari_tanggal'
            AND DATE(tanggal) <= '$sampai_tanggal'
            AND kdcarabayar = 2
            AND userlevelid = $userlevelid
    GROUP BY DATE(tanggal)) e ON DATE(a.tanggal) = e.tgl
        LEFT JOIN
    (SELECT 
        DATE(tanggal) AS tgl, COUNT(*) AS jamkesda
    FROM
        bill_detail_tarif
    WHERE
        DATE(tanggal) >= '$dari_tanggal'
            AND DATE(tanggal) <= '$sampai_tanggal'
            AND kdcarabayar = 9
            AND userlevelid = $userlevelid
    GROUP BY DATE(tanggal)) f ON DATE(a.tanggal) = f.tgl
WHERE
    DATE(a.tanggal) >= '$dari_tanggal'
        AND DATE(a.tanggal) <= '$sampai_tanggal'
        AND userlevelid = $userlevelid
GROUP BY DATE(a.tanggal)";
$queryitem = mysql_query($sqlitem);


?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SENSUS HARIAN PER CARABAYAR</title>
<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 10px;
}
	
.kosong {
    border:none;
}
	
.header {
	font-size: 12px;
}	
.footer {
	font-size: 12px;
}
</style>
</head>

<body>

<table width="100%" border="0" cellpadding="-3px" cellspacing="0px">
    <tr>
      <td width="10%" rowspan="3" align="right"><img src="../gambar/logobms.png" height="70px" /></td>
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
  

    <div align="center"><strong>LAPORAN HARIAN JUMLAH PASIEN PER CARA BAYAR</strong></div>

<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="3%">No.</td>
      <td width="18%" align="center">TANGGAL REGISTER</td>
      <td width="8%" align="center">UMUM</td>
      <td width="7%" align="center">BPJS</td>
      <td width="7%" align="center">KBS</td>
      <td width="7%" align="center">JKN</td>
      <td width="7%" align="center">JAMKESDA</td>
      <td width="13%" align="center">TOTAL</td>
    </tr>
    <?php
	  $no=1;
      		while($data=mysql_fetch_assoc($queryitem)){
				echo '<tr>';
				echo '<td align="center">'.$no.'</td>';
				echo '<td align="center">'.$data['tgl'].'</td>';
				echo '<td align="right">'.$data['umum'].'</td>';
				echo '<td align="right">'.$data['bpjs'].'</td>';
				echo '<td align="right">'.$data['kbs'].'</td>';
				echo '<td align="right">'.$data['jkn'].'</td>';
				echo '<td align="right">'.$data['jamkesda'].'</td>';
				echo '<td align="right">'.$data['total'].'</td>';
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
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 11.69 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('LAPORAN_SENSUS_CARABAYAR.pdf',array('Attachment' => 0));
?>
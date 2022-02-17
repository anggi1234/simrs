<?php
ob_start();
session_start();
include('../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$id_dokter_standby= $_GET['id_dokter_standby'];


$sqlitem="SELECT 
    DATE(a.tanggal) AS tgl,
    IFNULL(e.kecila, 0) AS kecila,
    IFNULL(f.kecilb, 0) AS kecilb,
    IFNULL(g.sedang, 0) AS sedang,
    IFNULL(h.besar, 0) AS besar,
    IFNULL(i.khusus, 0) AS khusus,
    IFNULL(j.sederhana, 0) AS sederhana
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    (SELECT 
        tanggal_tindakan AS tgl, SUM(qty) AS kecila
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND l_standby_dokter = $id_dokter_standby
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 1
    GROUP BY DATE(tanggal_tindakan)) e ON DATE(a.tanggal) = e.tgl
        LEFT JOIN
    (SELECT 
        tanggal_tindakan AS tgl, SUM(qty) AS kecilb
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND l_standby_dokter = $id_dokter_standby
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 2
    GROUP BY DATE(tanggal_tindakan)) f ON DATE(a.tanggal) = f.tgl
        LEFT JOIN
    (SELECT 
        tanggal_tindakan AS tgl, SUM(qty) AS sedang
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND l_standby_dokter = $id_dokter_standby
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 13
    GROUP BY DATE(tanggal_tindakan)) g ON DATE(a.tanggal) = g.tgl
        LEFT JOIN
    (SELECT 
        tanggal_tindakan AS tgl, SUM(qty) AS besar
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND l_standby_dokter = $id_dokter_standby
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 15
    GROUP BY DATE(tanggal_tindakan)) h ON DATE(a.tanggal) = h.tgl
        LEFT JOIN
    (SELECT 
        tanggal_tindakan AS tgl, SUM(qty) AS khusus
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND l_standby_dokter = $id_dokter_standby
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 17
    GROUP BY DATE(tanggal_tindakan)) i ON DATE(a.tanggal) = i.tgl
        LEFT JOIN
    (SELECT 
        tanggal_tindakan AS tgl, SUM(qty) AS sederhana
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND l_standby_dokter = $id_dokter_standby
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 16
    GROUP BY DATE(tanggal_tindakan)) j ON DATE(a.tanggal) = j.tgl
WHERE
    a.userlevelid = $userlevelid
        AND (DATE(a.tanggal) >= '$dari_tanggal'
        AND DATE(a.tanggal) <= '$sampai_tanggal')
GROUP BY DATE(a.tanggal)";
$queryitem = mysql_query($sqlitem);


$sqldokter="select a.*,b.pd_nickname from l_dokter_standby a left join master_login b on a.uid=b.uid where id_dokter_standby=$id_dokter_standby";
 $querydokter = mysql_query($sqldokter);
 $DATA_DOKTER = mysql_fetch_array($querydokter);


?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Jasa Pelayanan</title>
<style type="text/css">
	@page {
            margin-top: 0.1 cm;
            margin-left: 0.1 cm;
			margin-right: 0.1 cm;
			margin-bottom: 0.1 cm;
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
<table width="100%" class="tabel" border="1">
    <tr>
      <td width="10%" style="vertical-align:top" class="header"><img src="../gambar/logobms.png" height="60px" /></td>
      <td width="90%" style="vertical-align:top" height="60px" class="header"><strong>RSUD AJIBARANG</strong><br />
          <strong>Jl. Raya Pancasan - Ajibarang, Banyumas<br />
      TELP: (0281) 557 0004 FAX: - (0281)5670005<br />
      Kode Pos : 53163 -</strong></td>
      <td width="20%" style="vertical-align:top" class="header"> Tanggal Cetak: <?php echo date("d-m-Y") ?> <br> Unit: <?php echo $DATA_IDENTITAS['userlevelname']; ?></td>
    </tr>
</table>
  
<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="12%">Nama Perawat</td>
      <td width="17%">: <?php echo $DATA_DOKTER['pd_nickname']; ?></td>
      <td width="20%" align="right">&nbsp;</td>
      <td width="51%">&nbsp;</td>
    </tr>
    <tr>
      <td>Dari Tanggal</td>
      <td>: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td align="right">Sampai Tanggal</td>
      <td>: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>

<div align="center"><strong>LAPORAN HARIAN JASA PELAYANAN PERAWAT</strong></div>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="3%" rowspan="2" align="center">No</td>
      <td width="7%" rowspan="2" align="center">Tanggal</td>
      <td colspan="7" align="center">TINDAKAN KEPERAWATAN</td>
      <td width="5%" rowspan="2" align="center">Keterangan</td>
    </tr>
    <tr>
      <td width="7%" align="center">KECIL A</td>
      <td width="5%" align="center">KECIL B</td>
      <td width="6%" align="center">SEDANG</td>
      <td width="5%" align="center">BESAR</td>
      <td width="7%" align="center">KHUSUS</td>
      <td width="7%" align="center">SEDERHANA</td>
      <td width="5%" align="center">KECIL</td>
    </tr>
    <?php
	  $no=1;
      		while($data=mysql_fetch_assoc($queryitem)){
				echo '<tr>';
				echo '<td align="center">'.$no.'</td>';
				echo '<td align="center">'.$data['tgl'].'</td>';
				echo '<td align="center">'.$data['kecila'].'</td>';
				echo '<td align="center">'.$data['kecilb'].'</td>';
				echo '<td align="center">'.$data['sedang'].'</td>';
				echo '<td align="center">'.$data['besar'].'</td>';
				echo '<td align="center">'.$data['khusus'].'</td>';
				echo '<td align="center">'.$data['sederhana'].'</td>';
				echo '<td align="center">'.$data['kecil'].'</td>';
				echo '<td align="center">'.$data['keterangan'].'</td>';
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
$dompdf->stream('jaspelperawat.pdf',array('Attachment' => 0));
?>
<?php
ob_start();
session_start();
include('../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];


$sqlitem="SELECT 
    a.uid,
    c.pd_nickname,
    b.nama_profesi,
    a.userlevelid,
    IFNULL(g.kecila, 0) AS kecila,
    IFNULL(h.kecilb, 0) AS kecilb,
    IFNULL(i.sedang, 0) AS sedang,
    IFNULL(j.kecil, 0) AS kecil,
    IFNULL(k.besar, 0) AS besar,
    IFNULL(l.sederhana, 0) AS sederhana,
    IFNULL(m.khusus, 0) AS khusus,
	
	IFNULL(g.kecila, 0)+
    IFNULL(h.kecilb, 0)+
    IFNULL(i.sedang, 0)+
    IFNULL(j.kecil, 0)+
    IFNULL(k.besar, 0)+
    IFNULL(l.sederhana, 0)+
    IFNULL(m.khusus, 0) as total_tindakan
	
FROM
    simrs.l_dokter_standby a
        LEFT JOIN
    simrs.master_profesi b ON a.id_profesi = b.id_profesi
        LEFT JOIN
    simrs.master_login c ON a.uid = c.uid
        LEFT JOIN
    (SELECT 
        l_standby_dokter, SUM(qty) AS kecila
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 1
    GROUP BY l_standby_dokter) g ON a.id_dokter_standby = g.l_standby_dokter
        LEFT JOIN
    (SELECT 
        l_standby_dokter, SUM(qty) AS kecilb
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 2
    GROUP BY l_standby_dokter) h ON a.id_dokter_standby = h.l_standby_dokter
        LEFT JOIN
    (SELECT 
        l_standby_dokter, SUM(qty) AS sedang
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 13
    GROUP BY l_standby_dokter) i ON a.id_dokter_standby = i.l_standby_dokter
        LEFT JOIN
    (SELECT 
        l_standby_dokter, SUM(qty) AS kecil
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 14
    GROUP BY l_standby_dokter) j ON a.id_dokter_standby = j.l_standby_dokter
        LEFT JOIN
    (SELECT 
        l_standby_dokter, SUM(qty) AS besar
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 15
    GROUP BY l_standby_dokter) k ON a.id_dokter_standby = k.l_standby_dokter
        LEFT JOIN
    (SELECT 
        l_standby_dokter, SUM(qty) AS sederhana
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 16
    GROUP BY l_standby_dokter) l ON a.id_dokter_standby = l.l_standby_dokter
        LEFT JOIN
    (SELECT 
        l_standby_dokter, SUM(qty) AS khusus
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 17
    GROUP BY l_standby_dokter) m ON a.id_dokter_standby = m.l_standby_dokter
WHERE
    (a.id_profesi = 6 OR a.id_profesi = 16 OR a.id_profesi = 17)
        AND a.userlevelid = $userlevelid";
$queryitem = mysql_query($sqlitem);


$sqlunit="SELECT * FROM userlevels where userlevelid = $userlevelid";
 $queryunit = mysql_query($sqlunit);
 $DATA_UNIT = mysql_fetch_array($queryunit);

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
      <td width="12%">Unit</td>
      <td width="33%">: <?php echo $DATA_UNIT['userlevelname']; ?></td>
      <td width="18%" align="right">&nbsp;</td>
      <td width="37%">&nbsp;</td>
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
      <td width="7%" rowspan="2" align="center">Nama</td>
      <td width="7%" rowspan="2" align="center">Profesi</td>
      <td colspan="7" align="center">TINDAKAN KEPERAWATAN</td>
      <td width="7%" rowspan="2" align="center">TOTAL TINDAKAN</td>
    </tr>
    <tr>
      <td width="5%" align="center">KECIL A</td>
      <td width="5%" align="center">KECIL B</td>
      <td width="5%" align="center">SEDANG</td>
      <td width="5%" align="center">BESAR</td>
      <td width="5%" align="center">KHUSUS</td>
      <td width="5%" align="center">SEDERHANA</td>
      <td width="5%" align="center">KECIL</td>
    </tr>
    <?php
	  $no=1;
      		while($data=mysql_fetch_assoc($queryitem)){
				echo '<tr>';
				echo '<td align="center">'.$no.'</td>';
				echo '<td align="left">'.$data['pd_nickname'].'</td>';
				echo '<td align="left">'.$data['nama_profesi'].'</td>';
				echo '<td align="center">'.$data['kecila'].'</td>';
				echo '<td align="center">'.$data['kecilb'].'</td>';
				echo '<td align="center">'.$data['sedang'].'</td>';
				echo '<td align="center">'.$data['besar'].'</td>';
				echo '<td align="center">'.$data['khusus'].'</td>';
				echo '<td align="center">'.$data['sederhana'].'</td>';
				echo '<td align="center">'.$data['kecil'].'</td>';
				echo '<td align="center">'.$data['total_tindakan'].'</td>';
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
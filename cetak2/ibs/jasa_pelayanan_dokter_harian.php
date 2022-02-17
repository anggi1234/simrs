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
    IFNULL(b.visit_bpjs, 0) AS visit_bpjs,
    IFNULL(c.visit_umum, 0) AS visit_umum,
    IFNULL(d.visit_kbs, 0) AS visit_kbs,
    IFNULL(e.kecila, 0) AS kecila,
    IFNULL(f.kecilb, 0) AS kecilb,
    IFNULL(g.kecilc, 0) AS kecilc,
    IFNULL(h.besara, 0) AS besara,
    IFNULL(i.besarb, 0) AS besarb,
    IFNULL(j.besarc, 0) AS besarc,
    IFNULL(k.sedanga, 0) AS sedanga,
    IFNULL(l.sedangb, 0) AS sedangb,
    IFNULL(m.sedangc, 0) AS sedangc,
    IFNULL(n.khususa, 0) AS khususa,
    IFNULL(o.khususb, 0) AS khususb,
    IFNULL(p.khususc, 0) AS khususc
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    (SELECT 
        tanggal_visit AS tgl, SUM(qty) AS visit_bpjs
    FROM
        bill_detail_visit_dokter
    WHERE
        (DATE(tanggal_visit) >= '$dari_tanggal'
            AND DATE(tanggal_visit) <= '$sampai_tanggal')
            AND id_dokter_standby = $id_dokter_standby
            AND (kdcarabayar = 2 OR kdcarabayar = 3
            OR kdcarabayar = 4
            OR kdcarabayar = 6)
            AND userlevelid = $userlevelid
    GROUP BY DATE(tanggal_visit)) b ON DATE(a.tanggal) = b.tgl
        LEFT JOIN
    (SELECT 
        tanggal_visit AS tgl, SUM(qty) AS visit_umum
    FROM
        bill_detail_visit_dokter
    WHERE
        (DATE(tanggal_visit) >= '$dari_tanggal'
            AND DATE(tanggal_visit) <= '$sampai_tanggal')
            AND id_dokter_standby = $id_dokter_standby
            AND (kdcarabayar = 1)
            AND userlevelid = $userlevelid
    GROUP BY DATE(tanggal_visit)) c ON DATE(a.tanggal) = c.tgl
        LEFT JOIN
    (SELECT 
        tanggal_visit AS tgl, SUM(qty) AS visit_kbs
    FROM
        bill_detail_visit_dokter
    WHERE
        (DATE(tanggal_visit) >= '$dari_tanggal'
            AND DATE(tanggal_visit) <= '$sampai_tanggal')
            AND id_dokter_standby = $id_dokter_standby
            AND (kdcarabayar = 9 OR kdcarabayar = 7)
            AND userlevelid = $userlevelid
    GROUP BY DATE(tanggal_visit)) d ON DATE(a.tanggal) = d.tgl
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
        tanggal_tindakan AS tgl, SUM(qty) AS kecilc
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND l_standby_dokter = $id_dokter_standby
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 3
    GROUP BY DATE(tanggal_tindakan)) g ON DATE(a.tanggal) = g.tgl
        LEFT JOIN
    (SELECT 
        tanggal_tindakan AS tgl, SUM(qty) AS besara
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND l_standby_dokter = $id_dokter_standby
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 4
    GROUP BY DATE(tanggal_tindakan)) h ON DATE(a.tanggal) = h.tgl
        LEFT JOIN
    (SELECT 
        tanggal_tindakan AS tgl, SUM(qty) AS besarb
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND l_standby_dokter = $id_dokter_standby
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 5
    GROUP BY DATE(tanggal_tindakan)) i ON DATE(a.tanggal) = i.tgl
        LEFT JOIN
    (SELECT 
        tanggal_tindakan AS tgl, SUM(qty) AS besarc
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND l_standby_dokter = $id_dokter_standby
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 6
    GROUP BY DATE(tanggal_tindakan)) j ON DATE(a.tanggal) = j.tgl
        LEFT JOIN
    (SELECT 
        tanggal_tindakan AS tgl, SUM(qty) AS sedanga
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND l_standby_dokter = $id_dokter_standby
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 7
    GROUP BY DATE(tanggal_tindakan)) k ON DATE(a.tanggal) = k.tgl
        LEFT JOIN
    (SELECT 
        tanggal_tindakan AS tgl, SUM(qty) AS sedangb
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND l_standby_dokter = $id_dokter_standby
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 8
    GROUP BY DATE(tanggal_tindakan)) l ON DATE(a.tanggal) = l.tgl
        LEFT JOIN
    (SELECT 
        tanggal_tindakan AS tgl, SUM(qty) AS sedangc
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND l_standby_dokter = $id_dokter_standby
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 9
    GROUP BY DATE(tanggal_tindakan)) m ON DATE(a.tanggal) = m.tgl
        LEFT JOIN
    (SELECT 
        tanggal_tindakan AS tgl, SUM(qty) AS khususa
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND l_standby_dokter = $id_dokter_standby
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 10
    GROUP BY DATE(tanggal_tindakan)) n ON DATE(a.tanggal) = n.tgl
        LEFT JOIN
    (SELECT 
        tanggal_tindakan AS tgl, SUM(qty) AS khususb
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND l_standby_dokter = $id_dokter_standby
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 11
    GROUP BY DATE(tanggal_tindakan)) o ON DATE(a.tanggal) = o.tgl
        LEFT JOIN
    (SELECT 
        tanggal_tindakan AS tgl, SUM(qty) AS khususc
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND l_standby_dokter = $id_dokter_standby
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 12
    GROUP BY DATE(tanggal_tindakan)) p ON DATE(a.tanggal) = p.tgl
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
  
<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="12%">Nama Dokter</td>
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

<div align="center"><strong>LAPORAN HARIAN JASA PELAYANAN DOKTER</strong></div>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="3%" rowspan="2" align="center">No</td>
      <td width="7%" rowspan="2" align="center">Tanggal</td>
      <td colspan="3" align="center">Visit</td>
      <td colspan="12" align="center">TMNO</td>
      <td width="5%" rowspan="2" align="center">Keterangan</td>
    </tr>
    <tr>
      <td width="5%" align="center">BPJS</td>
      <td width="6%" align="center">KBS</td>
      <td width="5%" align="center">UMUM</td>
      <td width="7%" align="center">KECIL A</td>
      <td width="5%" align="center">KECIL B</td>
      <td width="6%" align="center">KECIL C</td>
      <td width="5%" align="center">SEDANG A</td>
      <td width="7%" align="center">SEDANG B</td>
      <td width="7%" align="center">SEDANG C</td>
      <td width="5%" align="center">BESAR A</td>
      <td width="5%" align="center">BESAR B</td>
      <td width="5%" align="center">BESAR C</td>
      <td width="5%" align="center">KHUSUS A</td>
      <td width="6%" align="center">KHUSUS B</td>
      <td width="6%" align="center">KHUSUS C</td>
    </tr>
    <?php
	  $no=1;
      		while($data=mysql_fetch_assoc($queryitem)){
				echo '<tr>';
				echo '<td align="center">'.$no.'</td>';
				echo '<td align="center">'.$data['tgl'].'</td>';
				echo '<td align="center">'.$data['visit_bpjs'].'</td>';
				echo '<td align="center">'.$data['visit_kbs'].'</td>';
				echo '<td align="center">'.$data['visit_umum'].'</td>';
				echo '<td align="center">'.$data['kecila'].'</td>';
				echo '<td align="center">'.$data['kecilb'].'</td>';
				echo '<td align="center">'.$data['kecilc'].'</td>';
				echo '<td align="center">'.$data['sedanga'].'</td>';
				echo '<td align="center">'.$data['sedangb'].'</td>';
				echo '<td align="center">'.$data['sedangc'].'</td>';
				echo '<td align="center">'.$data['besara'].'</td>';
				echo '<td align="center">'.$data['besarb'].'</td>';
				echo '<td align="center">'.$data['besarc'].'</td>';
				echo '<td align="center">'.$data['khususa'].'</td>';
				echo '<td align="center">'.$data['khususb'].'</td>';
				echo '<td align="center">'.$data['khususc'].'</td>';
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
$paper_size = array(0,0, 12.99 * 72, 8.26 * 72); // 12" x 12"
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('LAPORAN_JASA_PELAYANAN.pdf',array('Attachment' => 0));
?>
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
    IFNULL(d.visit_bpjs, 0) AS visit_bpjs,
    IFNULL(e.visit_umum, 0) AS visit_umum,
    IFNULL(f.visit_kbs, 0) AS visit_kbs,
	
	IFNULL(d.visit_bpjs, 0)+
    IFNULL(e.visit_umum, 0)+
    IFNULL(f.visit_kbs, 0) as total_visit,
	
	
    IFNULL(g.kecila, 0) AS kecila,
    IFNULL(h.kecilb, 0) AS kecilb,
    IFNULL(i.kecilc, 0) AS kecilc,
    IFNULL(j.besara, 0) AS besara,
    IFNULL(k.besarb, 0) AS besarb,
    IFNULL(l.besarc, 0) AS besarc,
    IFNULL(m.sedanga, 0) AS sedanga,
    IFNULL(n.sedangb, 0) AS sedangb,
    IFNULL(o.sedangc, 0) AS sedangc,
    IFNULL(p.khususa, 0) AS khususa,
    IFNULL(q.khususb, 0) AS khususb,
    IFNULL(r.khususc, 0) AS khususc,
	
	IFNULL(g.kecila, 0)+
    IFNULL(h.kecilb, 0)+
    IFNULL(i.kecilc, 0)+
    IFNULL(j.besara, 0)+
    IFNULL(k.besarb, 0) +
    IFNULL(l.besarc, 0)+
    IFNULL(m.sedanga, 0)+
    IFNULL(n.sedangb, 0)+
    IFNULL(o.sedangc, 0)+
    IFNULL(p.khususa, 0)+
    IFNULL(q.khususb, 0)+
    IFNULL(r.khususc, 0) as total_tindakan
	
	
	
FROM
    simrs.l_dokter_standby a
        LEFT JOIN
    simrs.master_profesi b ON a.id_profesi = b.id_profesi
        LEFT JOIN
    simrs.master_login c ON a.uid = c.uid
        LEFT JOIN
    (SELECT 
        id_dokter_standby, SUM(qty) AS visit_bpjs
    FROM
        bill_detail_visit_dokter
    WHERE
        (DATE(tanggal_visit) >= '$dari_tanggal'
            AND DATE(tanggal_visit) <= '$sampai_tanggal')
            AND (kdcarabayar = 2 OR kdcarabayar = 3
            OR kdcarabayar = 4
            OR kdcarabayar = 6)
            AND userlevelid = $userlevelid
    GROUP BY id_dokter_standby) d ON a.id_dokter_standby = d.id_dokter_standby
        LEFT JOIN
    (SELECT 
        id_dokter_standby, SUM(qty) AS visit_umum
    FROM
        bill_detail_visit_dokter
    WHERE
        (DATE(tanggal_visit) >= '$dari_tanggal'
            AND DATE(tanggal_visit) <= '$sampai_tanggal')
            AND (kdcarabayar = 1)
            AND userlevelid = $userlevelid
    GROUP BY id_dokter_standby) e ON a.id_dokter_standby = e.id_dokter_standby
        LEFT JOIN
    (SELECT 
        id_dokter_standby, SUM(qty) AS visit_kbs
    FROM
        bill_detail_visit_dokter
    WHERE
        (DATE(tanggal_visit) >= '$dari_tanggal'
            AND DATE(tanggal_visit) <= '$sampai_tanggal')
            AND (kdcarabayar = 9 OR kdcarabayar = 7)
            AND userlevelid = $userlevelid
    GROUP BY id_dokter_standby) f ON a.id_dokter_standby = f.id_dokter_standby
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
        l_standby_dokter, SUM(qty) AS kecilc
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 3
    GROUP BY l_standby_dokter) i ON a.id_dokter_standby = i.l_standby_dokter
        LEFT JOIN
    (SELECT 
        l_standby_dokter, SUM(qty) AS besara
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 4
    GROUP BY l_standby_dokter) j ON a.id_dokter_standby = j.l_standby_dokter
        LEFT JOIN
    (SELECT 
        l_standby_dokter, SUM(qty) AS besarb
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 5
    GROUP BY l_standby_dokter) k ON a.id_dokter_standby = k.l_standby_dokter
        LEFT JOIN
    (SELECT 
        l_standby_dokter, SUM(qty) AS besarc
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 6
    GROUP BY l_standby_dokter) l ON a.id_dokter_standby = l.l_standby_dokter
        LEFT JOIN
    (SELECT 
        l_standby_dokter, SUM(qty) AS sedanga
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 7
    GROUP BY l_standby_dokter) m ON a.id_dokter_standby = m.l_standby_dokter
        LEFT JOIN
    (SELECT 
        l_standby_dokter, SUM(qty) AS sedangb
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 8
    GROUP BY l_standby_dokter) n ON a.id_dokter_standby = n.l_standby_dokter
        LEFT JOIN
    (SELECT 
        l_standby_dokter, SUM(qty) AS sedangc
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 9
    GROUP BY l_standby_dokter) o ON a.id_dokter_standby = o.l_standby_dokter
        LEFT JOIN
    (SELECT 
        l_standby_dokter, SUM(qty) AS khususa
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 10
    GROUP BY l_standby_dokter) p ON a.id_dokter_standby = p.l_standby_dokter
        LEFT JOIN
    (SELECT 
        l_standby_dokter, SUM(qty) AS khususb
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 11
    GROUP BY l_standby_dokter) q ON a.id_dokter_standby = q.l_standby_dokter
        LEFT JOIN
    (SELECT 
        l_standby_dokter, SUM(qty) AS khususc
    FROM
        bill_detail_tindakan
    WHERE
        (DATE(tanggal_tindakan) >= '$dari_tanggal'
            AND DATE(tanggal_tindakan) <= '$sampai_tanggal')
            AND userlevelid = $userlevelid
            AND id_type_tindakan = 12
    GROUP BY l_standby_dokter) r ON a.id_dokter_standby = r.l_standby_dokter
WHERE
    (a.id_profesi = 1 OR a.id_profesi = 12
        OR a.id_profesi = 13)
        AND a.userlevelid = $userlevelid order by a.id_profesi desc";
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
      <td width="12%">Unit</td>
      <td width="17%">: <?php echo $DATA_UNIT['userlevelname']; ?></td>
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
      <td width="7%" rowspan="2" align="center">Nama</td>
      <td width="7%" rowspan="2" align="center">Profesi</td>
      <td colspan="3" align="center">Visit</td>
      <td colspan="14" align="center">TMNO</td>
    </tr>
    <tr>
      <td width="5%" align="center">BPJS</td>
      <td width="5%" align="center">KBS</td>
      <td width="5%" align="center">UMUM</td>
      <td width="5%" align="center">KECIL A</td>
      <td width="5%" align="center">KECIL B</td>
      <td width="5%" align="center">KECIL C</td>
      <td width="5%" align="center">SEDANG A</td>
      <td width="5%" align="center">SEDANG B</td>
      <td width="5%" align="center">SEDANG C</td>
      <td width="5%" align="center">BESAR A</td>
      <td width="5%" align="center">BESAR B</td>
      <td width="5%" align="center">BESAR C</td>
      <td width="5%" align="center">KHUSUS A</td>
      <td width="5%" align="center">KHUSUS B</td>
      <td width="5%" align="center">KHUSUS C</td>
      <td width="6%" align="center">TOTAL VISIT</td>
      <td width="6%" align="center">TOTAL TINDAKAN</td>
    </tr>
    <?php
	  $no=1;
      		while($data=mysql_fetch_assoc($queryitem)){
				echo '<tr>';
				echo '<td align="center">'.$no.'</td>';
				echo '<td align="left">'.$data['pd_nickname'].'</td>';
				echo '<td align="left">'.$data['nama_profesi'].'</td>';
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
				echo '<td align="center">'.$data['total_visit'].'</td>';
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
$paper_size = array(0,0, 12.99 * 72, 8.26 * 72); // 12" x 12"
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('LAPORAN_JASA_PELAYANAN.pdf',array('Attachment' => 0));
?>
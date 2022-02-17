<?php
ob_start();
session_start();
include('../connect.php');
$idxdaftar = $_GET['idxdaftar'];
$username = $_GET['username'];
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$kdcarabayar= $_GET['kdcarabayar'];


$sqlitempasien="SELECT 
	date_format(a.tglreg, '%d-%m-%y') as tglreg,
    a.nomr,
    b.nama,
    b.alamat,
    c.userlevelname AS unit,
    IFNULL(d.jasa, 0) AS jasa,
    IFNULL(e.obat, 0) AS obat,
    IFNULL(d.jasa, 0) + IFNULL(e.obat, 0) AS total,
    IFNULL(f.generic, 0) AS generic,
    IFNULL(g.paten, 0) AS paten,
    IFNULL(h.obat2, 0) AS obat2,
    IFNULL(i.obat3, 0) AS obat3,
    IFNULL(j.alkes2, 0) AS alkes2,
    IFNULL(k.alkes3, 0) AS alkes3,
    IFNULL(l.kie, 0) AS kie,
    IFNULL(m.puyer2, 0) AS puyer2,
    IFNULL(n.puyer3, 0) AS puyer3,
    IFNULL(o.cap2, 0) AS cap2,
    IFNULL(p.cap3, 0) AS cap3,
    IFNULL(q.crm2, 0) AS crm2,
    IFNULL(r.crm3, 0) AS crm3,
    IFNULL(s.sir2, 0) AS sir2,
    IFNULL(t.sir3, 0) AS sir3,
    DATEDIFF(a.tglout, a.tglreg) AS hari_berobat
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs.userlevels c ON a.userlevelid = c.userlevelid
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            SUM(IFNULL(a.total, 0) - IFNULL(b.total, 0)) AS jasa
    FROM
        bill_detail_permintaan_obat a
    LEFT JOIN bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    LEFT JOIN master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
    LEFT JOIN master_obat d ON c.id_obat = d.id_obat
    WHERE
        d.nama_obat LIKE '%jasa%'
            AND (a.tanggal >= '$dari_tanggal'
            AND a.tanggal >= '$sampai_tanggal')
    GROUP BY a.id_bill_detail_tarif) d ON a.id_bill_detail_tarif = d.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            SUM(IFNULL(a.total, 0) - IFNULL(b.total, 0)) AS obat
    FROM
        bill_detail_permintaan_obat a
    LEFT JOIN bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    LEFT JOIN master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
    LEFT JOIN master_obat d ON c.id_obat = d.id_obat
    WHERE
        d.nama_obat NOT LIKE '%jasa%'
            AND (a.tanggal >= '$dari_tanggal'
            AND a.tanggal >= '$sampai_tanggal')
    GROUP BY a.id_bill_detail_tarif) e ON a.id_bill_detail_tarif = e.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif, COUNT(*) AS generic
    FROM
        bill_detail_permintaan_obat a
    LEFT JOIN bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    LEFT JOIN master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
    LEFT JOIN master_obat d ON c.id_obat = d.id_obat
    WHERE
        (a.tanggal >= '$dari_tanggal'
            AND a.tanggal >= '$sampai_tanggal')
            AND c.id_golongan = 27
    GROUP BY a.id_bill_detail_tarif) f ON a.id_bill_detail_tarif = f.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif, COUNT(*) AS paten
    FROM
        bill_detail_permintaan_obat a
    LEFT JOIN bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    LEFT JOIN master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
    LEFT JOIN master_obat d ON c.id_obat = d.id_obat
    WHERE
        (a.tanggal >= '$dari_tanggal'
            AND a.tanggal >= '$sampai_tanggal')
            AND c.id_golongan = 34
    GROUP BY a.id_bill_detail_tarif) g ON a.id_bill_detail_tarif = g.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS obat2
    FROM
        bill_detail_permintaan_obat a
    LEFT JOIN bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    LEFT JOIN master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
    LEFT JOIN master_obat d ON c.id_obat = d.id_obat
    WHERE
        (a.tanggal >= '$dari_tanggal'
            AND a.tanggal >= '$sampai_tanggal')
            AND d.id_obat = 21837
    GROUP BY a.id_bill_detail_tarif) h ON a.id_bill_detail_tarif = h.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS obat3
    FROM
        bill_detail_permintaan_obat a
    LEFT JOIN bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    LEFT JOIN master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
    LEFT JOIN master_obat d ON c.id_obat = d.id_obat
    WHERE
        (a.tanggal >= '$dari_tanggal'
            AND a.tanggal >= '$sampai_tanggal')
            AND d.id_obat = 21838
    GROUP BY a.id_bill_detail_tarif) i ON a.id_bill_detail_tarif = i.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS alkes2
    FROM
        bill_detail_permintaan_obat a
    LEFT JOIN bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    LEFT JOIN master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
    LEFT JOIN master_obat d ON c.id_obat = d.id_obat
    WHERE
        (a.tanggal >= '$dari_tanggal'
            AND a.tanggal >= '$sampai_tanggal')
            AND d.id_obat = 21835
    GROUP BY a.id_bill_detail_tarif) j ON a.id_bill_detail_tarif = j.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS alkes3
    FROM
        bill_detail_permintaan_obat a
    LEFT JOIN bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    LEFT JOIN master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
    LEFT JOIN master_obat d ON c.id_obat = d.id_obat
    WHERE
        (a.tanggal >= '$dari_tanggal'
            AND a.tanggal >= '$sampai_tanggal')
            AND d.id_obat = 21836
    GROUP BY a.id_bill_detail_tarif) k ON a.id_bill_detail_tarif = k.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS kie
    FROM
        bill_detail_permintaan_obat a
    LEFT JOIN bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    LEFT JOIN master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
    LEFT JOIN master_obat d ON c.id_obat = d.id_obat
    WHERE
        (a.tanggal >= '$dari_tanggal'
            AND a.tanggal >= '$sampai_tanggal')
            AND d.id_obat = 21830
    GROUP BY a.id_bill_detail_tarif) l ON a.id_bill_detail_tarif = l.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS puyer2
    FROM
        bill_detail_permintaan_obat a
    LEFT JOIN bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    LEFT JOIN master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
    LEFT JOIN master_obat d ON c.id_obat = d.id_obat
    WHERE
        (a.tanggal >= '$dari_tanggal'
            AND a.tanggal >= '$sampai_tanggal')
            AND d.id_obat = 21833
    GROUP BY a.id_bill_detail_tarif) m ON a.id_bill_detail_tarif = m.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS puyer3
    FROM
        bill_detail_permintaan_obat a
    LEFT JOIN bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    LEFT JOIN master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
    LEFT JOIN master_obat d ON c.id_obat = d.id_obat
    WHERE
        (a.tanggal >= '$dari_tanggal'
            AND a.tanggal >= '$sampai_tanggal')
            AND d.id_obat = 21834
    GROUP BY a.id_bill_detail_tarif) n ON a.id_bill_detail_tarif = n.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS cap2
    FROM
        bill_detail_permintaan_obat a
    LEFT JOIN bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    LEFT JOIN master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
    LEFT JOIN master_obat d ON c.id_obat = d.id_obat
    WHERE
        (a.tanggal >= '$dari_tanggal'
            AND a.tanggal >= '$sampai_tanggal')
            AND d.id_obat = 21828
    GROUP BY a.id_bill_detail_tarif) o ON a.id_bill_detail_tarif = o.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS cap3
    FROM
        bill_detail_permintaan_obat a
    LEFT JOIN bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    LEFT JOIN master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
    LEFT JOIN master_obat d ON c.id_obat = d.id_obat
    WHERE
        (a.tanggal >= '$dari_tanggal'
            AND a.tanggal >= '$sampai_tanggal')
            AND d.id_obat = 21829
    GROUP BY a.id_bill_detail_tarif) p ON a.id_bill_detail_tarif = p.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS crm2
    FROM
        bill_detail_permintaan_obat a
    LEFT JOIN bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    LEFT JOIN master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
    LEFT JOIN master_obat d ON c.id_obat = d.id_obat
    WHERE
        (a.tanggal >= '$dari_tanggal'
            AND a.tanggal >= '$sampai_tanggal')
            AND d.id_obat = 21839
    GROUP BY a.id_bill_detail_tarif) q ON a.id_bill_detail_tarif = q.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS crm3
    FROM
        bill_detail_permintaan_obat a
    LEFT JOIN bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    LEFT JOIN master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
    LEFT JOIN master_obat d ON c.id_obat = d.id_obat
    WHERE
        (a.tanggal >= '$dari_tanggal'
            AND a.tanggal >= '$sampai_tanggal')
            AND d.id_obat = 21840
    GROUP BY a.id_bill_detail_tarif) r ON a.id_bill_detail_tarif = r.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS sir2
    FROM
        bill_detail_permintaan_obat a
    LEFT JOIN bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    LEFT JOIN master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
    LEFT JOIN master_obat d ON c.id_obat = d.id_obat
    WHERE
        (a.tanggal >= '$dari_tanggal'
            AND a.tanggal >= '$sampai_tanggal')
            AND d.id_obat = 21841
    GROUP BY a.id_bill_detail_tarif) s ON a.id_bill_detail_tarif = s.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS sir3
    FROM
        bill_detail_permintaan_obat a
    LEFT JOIN bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    LEFT JOIN master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
    LEFT JOIN master_obat d ON c.id_obat = d.id_obat
    WHERE
        (a.tanggal >= '$dari_tanggal'
            AND a.tanggal >= '$sampai_tanggal')
            AND d.id_obat = 21842
    GROUP BY a.id_bill_detail_tarif) t ON a.id_bill_detail_tarif = t.id_bill_detail_tarif
	LEFT JOIN
    simrs2012.m_carabayar u ON a.kdcarabayar = u.kode
    LEFT JOIN
    l_carabayar_group v ON u.payor_id = v.payor_id
WHERE
    (a.tglreg >= '$dari_tanggal'
        AND a.tglreg <= '$sampai_tanggal') AND v.payor_id = $kdcarabayar";
$queryitempasien = mysql_query($sqlitempasien);

$sqlusername="select a.pd_nickname,b.userlevelname from master_login a left join userlevels b on a.userlevelid=b.userlevelid where a.username=$username";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

$sqlpembayaran="select nama_carabayar_group from l_carabayar_group where payor_id=$kdcarabayar";
 $querypembayaran = mysql_query($sqlpembayaran);
 $DATA_PEMBAYARAN = mysql_fetch_array($querypembayaran);

?>



<html>
<head>
<meta charset="utf-8">
<title>INACBG</title>
<style type="text/css">
	@page {
            margin-top: 0.1 cm;
            margin-left: 0.1 cm;
			margin-right: 0.1 cm;
			margin-bottom: 0.1 cm;
		font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 12px;
	font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
}
	
.header {
	font-size: 12px;
	font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
}	
.footer {
	font-size: 12px;
	font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
}

.pagebreak { 
		page-break-before: always;
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
    <div align="center" class="header"><strong>LAPORAN PENDAPATAN BERDASARKAN PASIEN</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="12%">Filter</td>
      <td width="17%">&nbsp;</td>
      <td width="20%" align="right">Pembayaran</td>
      <td width="51%">: <?php echo $DATA_PEMBAYARAN['nama_carabayar_group']; ?></td>
    </tr>
    <tr>
      <td>Dari Tanggal</td>
      <td>: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td align="right">Sampai Tanggal</td>
      <td>: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>


<hr>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="10%" rowspan="2" align="center">Tgl</td>
      <td width="2%" rowspan="2" align="center">No</td>
      <td width="10%" rowspan="2" align="center">Nama</td>
      <td width="5%" rowspan="2" align="center">No RM</td>
      <td width="15%" rowspan="2" align="center">Unit</td>
      <td width="15%" rowspan="2" align="center">Alamat</td>
      <td width="8%" rowspan="2" align="center">Jasa</td>
      <td width="8%" rowspan="2" align="center">Obat</td>
      <td width="8%" rowspan="2" align="center">Total</td>
      <td colspan="2" align="center">Obat Jadi</td>
      <td width="3%" rowspan="2" align="center">KIE</td>
      <td colspan="4" align="center">Jasa Obat Racikan Kelas 2</td>
      <td colspan="4" align="center">Jasa Obat Racikan Kelas 3</td>
      <td colspan="2" align="center">JASA KELAS 2</td>
      <td colspan="2" align="center">JASA KELAS 3</td>
    </tr>
    <tr>
      <td width="3%" align="center">G</td>
      <td width="3%" align="center">P</td>
      <td width="3%" align="center">PYR</td>
      <td width="3%" align="center">CAP</td>
      <td width="3%" align="center">CRM</td>
      <td width="3%" align="center">SIR</td>
      
      <td width="3%" align="center">PYR</td>
      <td width="3%" align="center">CAP</td>
      <td width="3%" align="center">CRM</td>
      <td width="3%" align="center">SIR</td>
      
      <td width="8%" align="center">OBAT</td>
      <td width="8%" align="center">ALKES</td>
      <td width="6%" align="center">OBAT</td>
      <td width="6%" align="center">ALKES</td>
    </tr>
    
    <?php
	  $no=1;
      		while($data=mysql_fetch_assoc($queryitempasien)){
				echo '<tr>';
				echo '<td>'.$data['tglreg'].'</td>';
				echo '<td>'.$no.'</td>';
				echo '<td align="left">'.$data['nama'].'</td>';
				echo '<td align="left">'.$data['nomr'].'</td>';
				echo '<td align="left">'.$data['unit'].'</td>';
				echo '<td align="left">'.$data['alamat'].'</td>';
				echo '<td align="right">'.number_format($data['jasa'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['obat'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '<td align="left">'.$data['generic'].'</td>';
				echo '<td align="left">'.$data['paten'].'</td>';
				echo '<td align="left">'.$data['kie'].'</td>';
				echo '<td align="left">'.$data['puyer2'].'</td>';
				echo '<td align="left">'.$data['cap2'].'</td>';
				echo '<td align="left">'.$data['crm2'].'</td>';
				echo '<td align="left">'.$data['sir2'].'</td>';
				echo '<td align="left">'.$data['puyer3'].'</td>';
				echo '<td align="left">'.$data['cap3'].'</td>';
				echo '<td align="left">'.$data['crm3'].'</td>';
				echo '<td align="left">'.$data['sir3'].'</td>';
				
				echo '<td align="left">'.$data['obat2'].'</td>';
				echo '<td align="left">'.$data['obat3'].'</td>';
				
				echo '<td align="left">'.$data['alkes2'].'</td>';
				echo '<td align="left">'.$data['alkes3'].'</td>';
				
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
$paper_size = array(0,0, 8.26 * 72, 12.90 * 72);
$dompdf->set_paper($paper_size, 'landscape');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('pendapatanfarmasi.pdf',array('Attachment' => 0));
?>
<?php
ob_start();
session_start();
include('../../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$username = $_GET['username'];


$sqliisi="SELECT 
    a.tglreg,
    IFNULL(b.pulang, 0) AS pulang,
    IFNULL(c.ranap, 0) AS ranap,
    IFNULL(d.rujukpoli, 0) AS rujukpoli,
    IFNULL(e.rujukop, 0) AS rujukop,
    IFNULL(f.batal, 0) AS batal,
    IFNULL(g.meninggal, 0) AS meninggal
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    (SELECT 
        DATE(tanggal) AS tglreg, COUNT(*) pulang
    FROM
        simrs.bill_detail_transfer_pasien
    WHERE
        (DATE(tanggal) >= '$dari_tanggal'
            AND DATE(tanggal) <= '$sampai_tanggal')
            AND id_status_keluar = 1 and (userlevelid=1 or userlevelid=2 or userlevelid=2 or userlevelid=3 or userlevelid=4 or userlevelid=5 or userlevelid=6 or userlevelid=7 or userlevelid=12 or userlevelid=14 or userlevelid=28 or userlevelid=29 or userlevelid=30 or userlevelid=45)
    GROUP BY DATE(tanggal)) b ON a.tglreg = b.tglreg
        LEFT JOIN
    (SELECT 
        DATE(tanggal) AS tglreg, COUNT(*) ranap
    FROM
        simrs.bill_detail_transfer_pasien
    WHERE
        (DATE(tanggal) >= '$dari_tanggal'
            AND DATE(tanggal) <= '$sampai_tanggal')
            AND id_status_keluar = 2 and (userlevelid=1 or userlevelid=2 or userlevelid=2 or userlevelid=3 or userlevelid=4 or userlevelid=5 or userlevelid=6 or userlevelid=7 or userlevelid=12 or userlevelid=14 or userlevelid=28 or userlevelid=29 or userlevelid=30 or userlevelid=45)
    GROUP BY DATE(tanggal)) c ON a.tglreg = c.tglreg
        LEFT JOIN
    (SELECT 
        DATE(tanggal) AS tglreg, COUNT(*) rujukpoli
    FROM
        simrs.bill_detail_transfer_pasien
    WHERE
        (DATE(tanggal) >= '$dari_tanggal'
            AND DATE(tanggal) <= '$sampai_tanggal')
            AND id_status_keluar = 5 and (userlevelid=1 or userlevelid=2 or userlevelid=2 or userlevelid=3 or userlevelid=4 or userlevelid=5 or userlevelid=6 or userlevelid=7 or userlevelid=12 or userlevelid=14 or userlevelid=28 or userlevelid=29 or userlevelid=30 or userlevelid=45)
    GROUP BY DATE(tanggal)) d ON a.tglreg = d.tglreg
        LEFT JOIN
    (SELECT 
        DATE(tanggal) AS tglreg, COUNT(*) rujukop
    FROM
        simrs.bill_detail_transfer_pasien
    WHERE
        (DATE(tanggal) >= '$dari_tanggal'
            AND DATE(tanggal) <= '$sampai_tanggal')
            AND id_status_keluar = 4 and (userlevelid=1 or userlevelid=2 or userlevelid=2 or userlevelid=3 or userlevelid=4 or userlevelid=5 or userlevelid=6 or userlevelid=7 or userlevelid=12 or userlevelid=14 or userlevelid=28 or userlevelid=29 or userlevelid=30 or userlevelid=45)
    GROUP BY DATE(tanggal)) e ON a.tglreg = e.tglreg
        LEFT JOIN
    (SELECT 
        DATE(tanggal) AS tglreg, COUNT(*) batal
    FROM
        simrs.bill_detail_transfer_pasien
    WHERE
        (DATE(tanggal) >= '$dari_tanggal'
            AND DATE(tanggal) <= '$sampai_tanggal')
            AND id_status_keluar = 11 and (userlevelid=1 or userlevelid=2 or userlevelid=2 or userlevelid=3 or userlevelid=4 or userlevelid=5 or userlevelid=6 or userlevelid=7 or userlevelid=12 or userlevelid=14 or userlevelid=28 or userlevelid=29 or userlevelid=30 or userlevelid=45)
    GROUP BY DATE(tanggal)) f ON a.tglreg = f.tglreg
    LEFT JOIN
    (SELECT 
        DATE(tanggal) AS tglreg, COUNT(*) meninggal
    FROM
        simrs.bill_detail_transfer_pasien
    WHERE
        (DATE(tanggal) >= '$dari_tanggal'
            AND DATE(tanggal) <= '$sampai_tanggal')
            AND id_status_keluar = 8 and (userlevelid=1 or userlevelid=2 or userlevelid=2 or userlevelid=3 or userlevelid=4 or userlevelid=5 or userlevelid=6 or userlevelid=7 or userlevelid=12 or userlevelid=14 or userlevelid=28 or userlevelid=29 or userlevelid=30 or userlevelid=45)
    GROUP BY DATE(tanggal)) g ON a.tglreg = g.tglreg
WHERE
    (DATE(a.tglreg) >= '$dari_tanggal'
        AND DATE(a.tglreg) <= '$sampai_tanggal')
GROUP BY DATE(a.tglreg)";
$queryisi = mysql_query($sqliisi);
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Status Pasien</title>
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
<div align="center"><strong>LAPORAN STATUS KELUAR PER TANGGAL</strong></div>
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
      <td width="3%">No.</td>
      <td width="22%" align="center">Tanggal</td>
      <td width="17%" align="center">Pulang</td>
      <td width="17%" align="center">Rawat Inap</td>
      <td width="14%" align="center">Ke Poli Lain</td>
      <td width="14%" align="center">Kirim IBS</td>
      <td width="13%" align="center">Batal</td>
      <td width="13%" align="center">Meninggal</td>
    </tr>
    <?php
	  	$no=1;
		while($data=mysql_fetch_assoc($queryisi)){
			echo '<tr>';
	  		echo '<td align="center">'.$no.'.</td>';
			echo '<td align="center">'.$data['tglreg'].'</td>';
			echo '<td align="center">'.$data['pulang'].'</td>';
			echo '<td align="center">'.$data['ranap'].'</td>';
			echo '<td align="center">'.$data['rujukpoli'].'</td>';
			echo '<td align="center">'.$data['rujukop'].'</td>';
			echo '<td align="center">'.$data['batal'].'</td>';
			echo '<td align="center">'.$data['meninggal'].'</td>';
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
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporan_status.pdf',array('Attachment' => 0));
?>
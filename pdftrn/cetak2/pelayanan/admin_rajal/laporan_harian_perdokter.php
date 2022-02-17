<?php
ob_start();
session_start();
include('../../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$username = $_GET['username'];


$sqliisi="SELECT 
    b.userlevelname AS poliklinik,a.nama_dokter AS namadokter,ifnull(c.umum,0) as umum,ifnull(d.bpjs,0) as bpjs,ifnull(e.jamkesda,0) as jamkesda
FROM
    simrs.m_dokter a
        LEFT JOIN
    simrs.userlevels b ON a.userlevelid = b.userlevelid
    left join (SELECT 
        userlevelid,kddokter, COUNT(*) AS umum
    FROM
        simrs.bill_detail_tarif
    WHERE
        kdcarabayar = 1
            AND (tglreg >= '$dari_tanggal'
            AND tglreg <= '$sampai_tanggal') and (userlevelid=1 or userlevelid=2 or userlevelid=2 or userlevelid=3 or userlevelid=4 or userlevelid=5 or userlevelid=6 or userlevelid=7 or userlevelid=12 or userlevelid=14 or userlevelid=28 or userlevelid=29 or userlevelid=30 or userlevelid=31 or userlevelid=45 or userlevelid=46)
    GROUP BY userlevelid, kddokter) c on a.userlevelid=c.userlevelid and a.kddokter=c.kddokter
    left join (SELECT 
        userlevelid,kddokter, COUNT(*) AS bpjs
    FROM
        simrs.bill_detail_tarif
    WHERE
        (kdcarabayar = 2 or kdcarabayar = 3 or kdcarabayar = 4 or kdcarabayar = 6)
            AND (tglreg >= '$dari_tanggal'
            AND tglreg <= '$sampai_tanggal') and (userlevelid=1 or userlevelid=2 or userlevelid=2 or userlevelid=3 or userlevelid=4 or userlevelid=5 or userlevelid=6 or userlevelid=7 or userlevelid=12 or userlevelid=14 or userlevelid=28 or userlevelid=29 or userlevelid=30 or userlevelid=31 or userlevelid=45 or userlevelid=46)
    GROUP BY userlevelid, kddokter) d on a.userlevelid=d.userlevelid and a.kddokter=d.kddokter
    left join (SELECT 
        userlevelid,kddokter, COUNT(*) AS jamkesda
    FROM
        simrs.bill_detail_tarif
    WHERE
        (kdcarabayar = 7 or kdcarabayar = 9)
            AND (tglreg >= '$dari_tanggal'
            AND tglreg <= '$sampai_tanggal') and (userlevelid=1 or userlevelid=2 or userlevelid=2 or userlevelid=3 or userlevelid=4 or userlevelid=5 or userlevelid=6 or userlevelid=7 or userlevelid=12 or userlevelid=14 or userlevelid=28 or userlevelid=29 or userlevelid=30 or userlevelid=31 or userlevelid=45 or userlevelid=46)
    GROUP BY userlevelid, kddokter) e on a.userlevelid=e.userlevelid and a.kddokter=e.kddokter
WHERE
    a.userlevelid = 1 OR a.userlevelid = 2
        OR a.userlevelid = 2
        OR a.userlevelid = 3
        OR a.userlevelid = 4
        OR a.userlevelid = 5
        OR a.userlevelid = 6
        OR a.userlevelid = 7
        OR a.userlevelid = 12
        OR a.userlevelid = 14
        OR a.userlevelid = 28
        OR a.userlevelid = 29
        OR a.userlevelid = 30
		OR a.userlevelid = 31
        OR a.userlevelid = 45
		OR a.userlevelid = 46
        order by b.userlevelname asc"; 
$queryisi = mysql_query($sqliisi);
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Harian Dokter Per Carabayar</title>
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
<div align="center"><strong>LAPORAN HARIAN DOKTER PER CARABAYAR</strong></div>
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
      <td width="49%" align="center">Nama Dokter </td>
      <td width="49%" align="center">Poliklinik </td>
      <td width="14%" align="center">BPJS</td>
	  <td width="16%" align="center">UMUM </td>
      <td width="13%" align="center">JAMKESDA</td>
    </tr>
    <?php
	  	$no=1;
		while($data=mysql_fetch_assoc($queryisi)){
			echo '<tr>';
	  		echo '<td align="center">'.$no.'.</td>';
			echo '<td align="left">'.$data['namadokter'].'</td>';
			echo '<td align="left">'.$data['poliklinik'].'</td>';
			echo '<td align="center">'.$data['bpjs'].'</td>';
			echo '<td align="center">'.$data['umum'].'</td>';
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
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporan_status.pdf',array('Attachment' => 0));
?>
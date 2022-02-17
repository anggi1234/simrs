<?php
ob_start();
session_start();
include('../../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid = $_GET['userlevelid'];
$status = $_GET['status'];
$kddokter = $_GET['kddokter'];

$whrdokter.=($kddokter)?" and a.kddokter = '$kddokter'":"";
$whrstatus.=($status)?" and a.id_status_pasien = '$status'":"";
$sqliisi="SELECT 
    a.tglreg,
    c.no_sjp,
    a.nomr,
    b.nama,
    b.alamat,
    d.userlevelname,
    a.kelas,
    e.nama_dokter,
    f.nama AS carabayar,
    a.total_keseluruhan,
    g.pd_nickname,
    h.nama_status_bill
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs2012.t_pendaftaran c ON a.idxdaftar = c.idxdaftar
        LEFT JOIN
    simrs.userlevels d ON a.userlevelid = d.userlevelid
        LEFT JOIN
    simrs.m_dokter e ON a.kddokter = e.kddokter
        AND a.userlevelid = e.userlevelid
        LEFT JOIN
    simrs2012.m_carabayar f ON a.kdcarabayar = f.kode
        LEFT JOIN
    simrs.master_login g ON a.uidadm = g.username
        LEFT JOIN
    simrs.l_status_bill h ON a.id_status_bill = h.id_status_bill
WHERE
    a.tglreg >= '$dari_tanggal'
        AND a.tglreg <= '$sampai_tanggal'
        and a.userlevelid=$userlevelid $whrdokter $whrstatus"; 
$queryisi = mysql_query($sqliisi);
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Harian Adm</title>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
		font-family: Gotham, Helvetica Neue, Helvetica, Arial," sans-serif";
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
<div align="center"><strong>LAPORAN HARIAN ADMISTRASI</strong></div>
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
      <td width="2%" align="center">No.</td>
      <td width="5%" align="center">TGLREG</td>
      <td width="7%" align="center">SEP</td>
      <td width="4%" align="center">NORM</td>
      <td width="12%" align="center">NAMA</td>
      <td width="11%" align="center">ALAMAT</td>
	  <td width="8%" align="center">UNIT</td>
	  <td width="3%" align="center">KLS</td>
	  <td width="14%" align="center">DPJP</td>
	  <td width="8%" align="center">CARA BAYAR</td>
	  <td width="7%" align="center">TOTAL</td>
      <td width="7%" align="center">STATUS</td>
      <td width="12%" align="center">ADMIN</td>
    </tr>
    <?php
	  	$no=1;
		while($data=mysql_fetch_assoc($queryisi)){
			echo '<tr>';
	  		echo '<td align="center">'.$no.'.</td>';
			echo '<td align="center">'.$data['tglreg'].'</td>';
			echo '<td align="left">'.$data['no_sjp'].'</td>';
			echo '<td align="center">'.$data['nomr'].'</td>';
			echo '<td align="left">'.$data['nama'].'</td>';
			echo '<td align="left">'.$data['alamat'].'</td>';
			echo '<td align="left">'.$data['userlevelname'].'</td>';
			echo '<td align="center">'.$data['kelas'].'</td>';
			echo '<td align="left">'.$data['nama_dokter'].'</td>';
			echo '<td align="left">'.$data['carabayar'].'</td>';
			echo '<td align="right">Rp. '.number_format($data['total_keseluruhan'], 0,",",".").'</td>';
			echo '<td align="left">'.$data['nama_status_bill'].'</td>';
			echo '<td align="left">'.$data['pd_nickname'].'</td>';
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
$paper_size = array(0,0, 8.26 * 72, 15 * 72);
$dompdf->set_paper($paper_size, 'landscape');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporan_harian_adm.pdf',array('Attachment' => 0));
?>
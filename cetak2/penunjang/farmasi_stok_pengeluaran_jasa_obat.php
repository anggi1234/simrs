<?php
ob_start();
session_start();
include('../connect.php');
$username = $_GET['username'];
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$kdcarabayar= $_GET['kdcarabayar'];
$userlevelid= $_GET['userlevelid'];


$sqlitemstok="SELECT 
    MONTH(a.tanggal) AS bulan,
    YEAR(a.tanggal) AS tahun,
    SUM(a.total) AS jumlah,
    e.nama_carabayar_group,
    f.nama_obat
FROM
    simrs.bill_detail_permintaan_obat a
        LEFT JOIN
    simrs.bill_detail_permintaan_obat_master b ON a.id_bill_detail_permintaan_obat_master = b.id_bill_detail_permintaan_obat_master
        LEFT JOIN
    simrs.bill_detail_tarif c ON b.id_bill_Detail_tarif = c.id_bill_Detail_tarif
        LEFT JOIN
    simrs2012.m_carabayar d ON c.kdcarabayar = d.kode
        LEFT JOIN
    simrs.l_carabayar_group e ON d.payor_id = e.payor_id
        LEFT JOIN
    simrs.v_master_obat f ON a.id_master_obat_detail = f.id_master_obat_detail
WHERE
    	e.payor_id = $kdcarabayar
        AND (DATE(a.tanggal) >= '$dari_tanggal'
        AND DATE(a.tanggal) <= '$sampai_tanggal')
		and f.nama_obat not like '%jasa%'
		AND f.userlevelid = $userlevelid
GROUP BY MONTH(a.tanggal) , YEAR(a.tanggal)";
$queryitemstok = mysql_query($sqlitemstok);
$queryitemobat = mysql_query($sqlitemstok);
$DATA_OBAT = mysql_fetch_array($queryitemobat);

$sqlusername="select a.pd_nickname,b.userlevelname from master_login a left join userlevels b on a.userlevelid=b.userlevelid where a.username=$username";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

?>



<html>
<head>
<meta charset="utf-8">
<title>Obat Keluar</title>
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
	font-size: 9px;
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

    <div align="center" class="header"><strong>LAPORAN PENGELUARAN OBAT</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="15%">Nama Jasa Pelayanan</td>
      <td>: Semua obat pada Satelit Farmasi masing-masing</td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Dari Tanggal</td>
      <td width="31%">: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td width="23%" align="right">Sampai Tanggal</td>
      <td width="31%">: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>

<hr>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="5%" >No.</td>
      <td width="29%" align="center">Bulan</td>
      <td width="15%" align="center">Tahun</td>
      <td width="38%" align="center" >Cara Bayar</td>
      <td width="13%" align="center" >Jumlah</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemstok)){
			echo '<tr>';
			echo '<td align="center">'.$no.'</td>';
      		echo '<td align="center">'.$data['bulan'].'</td>';
			echo '<td align="center">'.$data['tahun'].'</td>';
			echo '<td>'.$data['nama_carabayar_group'].'</td>';
			echo '<td align="right">'.number_format($data['jumlah'], 0,",",".").'</td>';
			echo '</tr>';
			$no++;
		}
	?>
    <tr>
      <td colspan="4" align="right" >TOTAL KESELURUHAN</td>
      <td align="center" >&nbsp;</td>
    </tr>
    
    
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
$dompdf->stream('laporanpengeluaran.pdf',array('Attachment' => 0));
?>
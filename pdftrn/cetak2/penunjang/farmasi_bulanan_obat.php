<?php
ob_start();
session_start();
include('../connect.php');
$bulanid = $_GET['bulan_id'];
$tahun = $_GET['tahun_id'];
$id_obat= $_GET['id_obat'];

$whrcondn.=($id_obat)?" and a.id_obat = '$id_obat'":"";

$sqlitemstok="SELECT 
    D.nama_obat,F.nama, F.alamat, A.qty
FROM
    simrs.bill_detail_permintaan_obat A
        LEFT JOIN
    simrs.bill_detail_permintaan_obat_master B ON A.id_bill_detail_permintaan_obat_master = B.id_bill_detail_permintaan_obat_master
        LEFT JOIN
    simrs.master_obat_detail C ON A.id_master_obat_detail = C.id_master_obat_detail
        LEFT JOIN
    simrs.master_obat D ON C.id_obat = D.id_obat
        LEFT JOIN
    simrs.bill_detail_tarif E ON B.id_bill_detail_tarif = E.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_pasien F ON E.nomr = F.nomr
WHERE
    D.id_obat = $id_obat
    AND MONTH(E.tglreg) = $bulanid
    AND YEAR(E.tglreg) = $tahun ";
$queryitemstok = mysql_query($sqlitemstok);

?>



<html>
<head>
<meta charset="utf-8">
<title>LAPORAN OBAT BULANAN</title>
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
	
.header {
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
    <div align="center" class="header"><strong>LAPORAN OBAT PSIKOTROPIKA/NARKOTIKA BULANAN</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="12%">Filter</td>
      <td width="17%">&nbsp;</td>
      <td width="20%" align="right">Nama Obat</td>
      <td width="51%">:</td>
    </tr>
    <tr>
      <td>Bulan</td>
      <td>: <?php echo 2 ?></td>
      <td align="right">Tahun</td>
      <td>: <?php echo $tahun ?></td>
    </tr>
  </tbody>
</table>


<hr>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="3%">No.</td>
      <td width="29%">Nama Obat</td>
      <td width="28%">Nama Pasien</td>
      <td width="28%">Alamat</td>
      <td width="12%">Jumlah</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemstok)){
		echo '<tr>';
	  echo '<td>'.$no.'</td>';
    echo '<td>'.$data['nama_obat'].'</td>';
    echo '<td align="right">'.$data['nama'].'</td>';
	  echo '<td align="right">'.$data['alamat'].'</td>';
	  echo '<td align="right">'.$data['qty'].'</td>';
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
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('LAPORANBULANANOBAT.pdf',array('Attachment' => 0));
?>
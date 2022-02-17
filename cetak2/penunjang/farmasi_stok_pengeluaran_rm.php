<?php
ob_start();
session_start();
include('../connect.php');
$idxdaftar = $_GET['idxdaftar'];
$username = $_GET['username'];
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$id_master_obat_detail= $_GET['id_master_obat_detail'];


$sqlitemstok="SELECT 
        a.id_master_obat_detail,
    DATE_FORMAT(e.tanggal, '%d-%m-%Y') AS tanggal,
    d.nama_obat,
    a.qty,
    IFNULL(b.qty, 0) AS retur,
    a.tarif_obat,
    e.nomr,
    f.nama,
    f.alamat,
    g.namadokter,
     (a.qty-
    IFNULL(b.qty, 0))*a.tarif_obat AS total 
FROM
    bill_detail_permintaan_obat a
        LEFT JOIN
    bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
        LEFT JOIN
    master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
        LEFT JOIN
    master_obat d ON c.id_obat = d.id_obat
        LEFT JOIN
    bill_detail_tarif e ON a.id_bill_detail_tarif = e.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_pasien f ON e.nomr = f.nomr
        LEFT JOIN
    simrs2012.m_dokter g ON e.kddokter = g.kddokter
	where a.userlevelid=$userlevelid and a.id_master_obat_detail=$id_master_obat_detail and date(a.tanggal) >= '$dari_tanggal' and date(a.tanggal) <= '$sampai_tanggal'";
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
<title>Laporan Stok Pengeluaran</title>
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
  

    <div align="center" class="header"><strong>LAPORAN STOK PENGELUARAN BERDASARKAN REKAM MEDIS</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="12%">Nama Obat</td>
      <td width="26%">: <?php echo $DATA_OBAT['nama_obat']; ?></td>
      <td width="21%" align="right">&nbsp;</td>
      <td width="41%">&nbsp;</td>
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
      <td width="2%" align="center">No.</td>
      <td width="5%" align="center">No RM</td>
      <td width="10%" align="center">Nama Pasien</td>
      <td width="10%" align="center">Alamat</td>
      <td width="10%" align="center">Dokter</td>
      <td width="5%" align="center">Tanggal</td>
      <td width="5%" align="center">Jumlah</td>
      <td width="5%" align="center">Retur</td>
      <td width="5%" align="center">Harga Jual</td>
      <td width="5%" align="center">Total</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemstok)){
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td>'.$data['nomr'].'</td>';
	  echo '<td>'.$data['nama'].'</td>';
	  echo '<td>'.$data['alamat'].'</td>';
			echo '<td>'.$data['namadokter'].'</td>';
			echo '<td>'.$data['tanggal'].'</td>';
			echo '<td>'.$data['qty'].'</td>';
			echo '<td>'.$data['retur'].'</td>';
      echo '<td><div align="right">'.number_format($data['tarif_obat'], 2,",",".").'</div></td>';
			echo '<td><div align="right">'.number_format($data['total'], 2,",",".").'</div></td>';
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
$dompdf->stream('laporanpengeluaran.pdf',array('Attachment' => 0));
?>
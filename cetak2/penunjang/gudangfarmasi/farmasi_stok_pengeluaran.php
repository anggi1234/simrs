<?php
ob_start();
session_start();
include('../../connect.php');
$username = $_GET['username'];
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$id_master_obat_detail= $_GET['id_master_obat_detail'];
$id_supplier= $_GET['id_supplier'];
$id_golongan_obat= $_GET['id_golongan_obat'];
$userlevelid_to= $_GET['userlevelid_to'];

$whrcondn.=($id_master_obat_detail)?" and a.id_master_obat_detail = '$id_master_obat_detail'":"";
$whrunit.=($userlevelid_to)?" and d.userlevelid_to = '$userlevelid_to'":"";
$sqlitemstok="SELECT 
    DATE_FORMAT(a.tanggal, '%d-%m-%Y') AS tanggal,
    a.id_master_obat_detail,
    c.nama_obat,
    a.qty,
    a.hargajual AS tarif_obat,
    a.total,
    a.userlevelid,
	e.userlevelname
FROM
    farmasi_pengiriman_obat_detail a
        LEFT JOIN
    master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
        LEFT JOIN
    master_obat c ON b.id_obat = c.id_obat
		LEFT JOIN
	farmasi_pengiriman_obat d on a.id_farmasi_pengiriman_obat=d.id_farmasi_pengiriman_obat
		LEFT JOIN
    userlevels e ON d.userlevelid_to = e.userlevelid
WHERE
		a.id_master_obat_detail = $id_master_obat_detail
        AND DATE(d.tgl_kirim) >= '$dari_tanggal'
        AND DATE(d.tgl_kirim) <= '$sampai_tanggal' $whrunit";
$queryitemstok = mysql_query($sqlitemstok);

$sqlusername="select a.pd_nickname,b.userlevelname from master_login a left join userlevels b on a.userlevelid=b.userlevelid where a.username=$username";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

$sqlitemobat="select nama_obat from v_master_obat where id_master_obat_detail = $id_master_obat_detail";
$queryitemobat = mysql_query($sqlitemobat);
$DATA_OBAT = mysql_fetch_array($queryitemobat);

?>



<html>
<head>
<meta charset="utf-8">
<title>Laporan Stok Pengeluaran</title>
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
	font-size: 12px;
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

    <div align="center" class="header"><strong>LAPORAN PENGELUARAN</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="15%">Nama Obat</td>
      <td width="39%">: <?php echo $DATA_OBAT['nama_obat']; ?></td>
      <td width="20%" align="right">&nbsp;</td>
      <td width="26%">&nbsp;</td>
    </tr>
    <tr>
      <td>Dari Tanggal</td>
      <td>: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td align="right">Sampai Tanggal</td>
      <td>: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>

<br>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="2%">No.</td>
      <td width="10%">Tanggal</td>
      <td width="30%">Unit Tujuan</td>
      <td width="5%">Jumlah</td>
      <td width="10%">Harga Jual</td>
      <td width="10%">Total</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemstok)){
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td>'.$data['tanggal'].'</td>';
	  echo '<td>'.$data['userlevelname'].'</td>';
	  echo '<td>'.$data['qty'].'</td>';
	  echo '<td align="right">'.$data['tarif_obat'].'</td>';
      echo '<td><div align="right">'.number_format($data['total'], 2,",",".").'</div></td>';
			echo '<tr>';
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
$paper_size = array(0,0, 8.26 * 72, 11.69 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporanpengeluaran.pdf',array('Attachment' => 0));
?>
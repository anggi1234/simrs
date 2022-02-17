<?php
ob_start();
session_start();
include('../connect.php');
$username = $_GET['username'];
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid_tujuan= $_GET['userlevelid_tujuan'];
$userlevelid= $_GET['userlevelid'];
$id_master_obat_detail= $_GET['id_master_obat_detail'];


$sqlitemmutasikeluar="SELECT 
    DATE_FORMAT(d.tanggal_mutasi, '%d-%m-%Y') AS tanggal,
    e.userlevelname AS tujuanunit,
    CONCAT(c.nama_obat, ' (', g.userlevelname, ')') AS tujuan,
    a.kuantitas,
    a.tarif_obat,
    a.total
FROM
    farmasi_detail_mutasi a
        LEFT JOIN
    master_obat_detail b ON a.id_master_obat_detail_tujuan = b.id_master_obat_detail
        LEFT JOIN
    master_obat c ON b.id_obat = c.id_obat
        LEFT JOIN
    farmasi_mutasi d ON a.id_farmasi_mutasi = d.id_farmasi_mutasi
        LEFT JOIN
    userlevels e ON d.userlevelid_tujuan = e.userlevelid
        LEFT JOIN
    userlevels f ON d.userlevelid = f.userlevelid
        LEFT JOIN
    userlevels g ON b.userlevelid = g.userlevelid
	where 
	a.id_master_obat_detail=$id_master_obat_detail and 
	(date(d.tanggal_mutasi) >= '$dari_tanggal' and 
	date(d.tanggal_mutasi) <= '$sampai_tanggal') and 
	d.userlevelid_tujuan=$userlevelid_tujuan and 
	d.userlevelid=$userlevelid";
$queryitemmutasikeluar = mysql_query($sqlitemmutasikeluar);

 $queryitemmutasikeluar2 = mysql_query($sqlitemmutasikeluar);
 $DATA_MUTASIKELUAR = mysql_fetch_array($queryitemmutasikeluar2);


$sqlusername="select a.pd_nickname,b.userlevelname from master_login a left join userlevels b on a.userlevelid=b.userlevelid where a.username=$username";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

?>



<html>
<head>
<meta charset="utf-8">
<title>Mutasi</title>
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
  

    <div align="center" class="header"><strong>LAPORAN MUTASI KELUAR</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="15%">Nama Obat</td>
      <td colspan="3">: <?php echo $DATA_MUTASIKELUAR['tujuan']; ?>        </td></td>
      <td width="35%">&nbsp;</td>
    </tr>
    <tr>
      <td>Dari Tanggal</td>
      <td width="12%">: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td width="18%" align="right">Sampai Tanggal</td>
      <td width="20%">: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>

<hr>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="2%">No.</td>
      <td width="25%">Unit</td>
      <td width="10%">Tanggal</td>
      <td width="5%">Jumlah</td>
      <td width="15%" align="right">Tarif Obat</td>
      <td width="15%" align="right">Total</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemmutasikeluar)){
	  echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td>'.$data['tujuanunit'].'</td>';
	  echo '<td>'.$data['tanggal'].'</td>';
	  echo '<td>'.$data['kuantitas'].'</td>';
      echo '<td><div align="right">'.number_format($data['tarif_obat'], 2,",",".").'</div></td>';
	  echo '<td><div align="right">'.number_format($data['total'], 2,",",".").'</div></td>';
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
$paper_size = array(0,0, 8.26 * 72, 11.69 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('mutasikeluar.pdf',array('Attachment' => 0));
?>
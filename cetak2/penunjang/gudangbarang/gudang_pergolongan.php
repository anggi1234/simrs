<?php
ob_start();
session_start();
include('../../connect.php');
$username = $_GET['username'];
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];



$sqlitemstok="SELECT 
    a.nama_golongan,
    IFNULL(b.qty_masuk, 0) AS qty_masuk,
    IFNULL(c.qty_keluar, 0) AS qty_keluar,
    IFNULL(b.qty_masuk, 0) - IFNULL(c.qty_keluar, 0) AS sisa
FROM
    simrs.l_golongan_obat a
        LEFT JOIN
    (SELECT 
        SUM(a.qty * a.volume) AS qty_masuk, b.id_golongan
    FROM
        simrs.farmasi_pembelian_obat_detail a
    LEFT JOIN simrs.master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
    WHERE
        a.tanggal >= '$dari_tanggal'
            AND a.tanggal <= '$sampai_tanggal'
    GROUP BY b.id_golongan) b ON a.id_golongan_obat = b.id_golongan
        LEFT JOIN
    (SELECT 
        SUM(a.qty) AS qty_keluar, b.id_golongan
    FROM
        farmasi_pengiriman_obat_detail a
    LEFT JOIN master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
    WHERE
        a.tanggal >= '$dari_tanggal'
            AND a.tanggal <= '$sampai_tanggal'
    GROUP BY b.id_golongan) c ON a.id_golongan_obat = c.id_golongan";
$queryitemstok = mysql_query($sqlitemstok);

$sqlusername="select a.pd_nickname,b.userlevelname from master_login a left join userlevels b on a.userlevelid=b.userlevelid where a.username=$username";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);



?>



<html>
<head>
<meta charset="utf-8">
<title>Stok Per Golongan</title>
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
    <div align="center" class="header"><strong>LAPORAN OBAT PER GOLONGAN</strong></div>
<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="12%">Filter</td>
      <td width="17%">&nbsp;</td>
      <td width="20%">&nbsp;</td>
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

<hr>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="4%">No.</td>
      <td width="41%">Nama Golongan Obat</td>
      <td width="17%" align="center">Jumlah Masuk</td>
      <td width="18%" align="center">Jumlah Keluar</td>
      <td width="20%" align="center">Sisa Obat</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemstok)){
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td>'.$data['nama_golongan'].'</td>';
	  echo '<td align="right">'.$data['qty_masuk'].'</td>';
      echo '<td align="right">'.$data['qty_keluar']. '</td>';
	  echo '<td align="right">'.$data['sisa'].'</td>';
			$no++;
		}
	?>
   
  </tbody>
  
</table>
</body>

</html>


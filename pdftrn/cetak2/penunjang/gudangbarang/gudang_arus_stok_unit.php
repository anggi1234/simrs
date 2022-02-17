<?php
ob_start();
session_start();
include('../../connect.php');
$username = $_GET['username'];
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$userlevelid_to= $_GET['userlevelid_to'];

$sqlitemstok="SELECT 
    b.nama_obat,
    IFNULL(a.stok_akhir - ((IFNULL(f.mutasi_masuk, 0) + IFNULL(c.qty_masuk, 0)) - (IFNULL(e.mutasi_keluar, 0) + IFNULL(d.qty_keluar, 0))),
            0) AS stok_awal,
    IFNULL(c.qty_masuk, 0) AS stok_masuk,
    IFNULL(d.qty_keluar, 0) AS stok_keluar,
    IFNULL(f.mutasi_masuk, 0) AS mutasi_masuk,
    IFNULL(e.mutasi_keluar, 0) AS mutasi_keluar,
    IFNULL(c.qty_masuk, 0) - IFNULL(d.qty_keluar, 0) + IFNULL(f.mutasi_masuk, 0) - IFNULL(e.mutasi_keluar, 0) AS stok_akhir,
    a.harga_jual
FROM
    simrs.master_obat_detail a
        LEFT JOIN
    simrs.master_obat b ON a.id_obat = b.id_obat
        LEFT JOIN
    (SELECT 
        SUM((qty * volume)) AS qty_masuk, id_master_obat_detail
    FROM
        simrs.farmasi_pembelian_obat_detail a
    LEFT JOIN simrs.farmasi_pembelian_obat b ON a.id_pembelian_obat = b.id_pembelian_obat
    WHERE
        a.userlevelid = $userlevelid
            AND DATE(b.tgl_pesan) >= '$dari_tanggal'
            AND DATE(b.tgl_pesan) <= '$sampai_tanggal'
    GROUP BY a.id_master_obat_detail) c ON a.id_master_obat_detail = c.id_master_obat_detail
        LEFT JOIN
    (SELECT 
        c.nama_obat,
            SUM(a.qty) AS qty_keluar,
            a.id_master_obat_detail
    FROM
        simrs.farmasi_pengiriman_obat_detail a
    LEFT JOIN simrs.master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
    LEFT JOIN simrs.master_obat c ON b.id_obat = c.id_obat
    LEFT JOIN simrs.farmasi_pengiriman_obat d ON a.id_farmasi_pengiriman_obat = d.id_farmasi_pengiriman_obat
    WHERE
        a.userlevelid = $userlevelid
            AND d.userlevelid_to = $userlevelid_to
            AND DATE(d.tanggal) >= '$dari_tanggal'
            AND DATE(d.tanggal) <= '$sampai_tanggal'
    GROUP BY a.id_master_obat_detail) d ON a.id_master_obat_detail = d.id_master_obat_detail
        LEFT JOIN
    (SELECT 
        a.id_master_obat_detail,
            d.nama_obat,
            SUM(kuantitas) AS mutasi_keluar
    FROM
        simrs.farmasi_detail_mutasi a
    LEFT JOIN simrs.farmasi_mutasi b ON a.id_farmasi_mutasi = b.id_farmasi_mutasi
    LEFT JOIN simrs.master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
    LEFT JOIN simrs.master_obat d ON c.id_obat = d.id_obat
    WHERE
        (DATE(b.tanggal_mutasi) >= '$dari_tanggal'
            AND DATE(b.tanggal_mutasi) <= '$sampai_tanggal')
            AND a.userlevelid = $userlevelid
            AND a.userlevelid_tujuan = $userlevelid_to
    GROUP BY id_master_obat_detail_tujuan) e ON a.id_master_obat_detail = e.id_master_obat_detail
        LEFT JOIN
    (SELECT 
        a.id_master_obat_detail_tujuan AS id_master_obat_detail,
            c.nama_obat,
            SUM(a.kuantitas) AS mutasi_masuk
    FROM
        simrs.farmasi_detail_mutasi a
    LEFT JOIN simrs.master_obat_detail b ON a.id_master_obat_detail_tujuan = b.id_master_obat_detail
    LEFT JOIN simrs.master_obat c ON b.id_obat = c.id_obat
    LEFT JOIN simrs.farmasi_mutasi d ON a.id_farmasi_mutasi = d.id_farmasi_mutasi
    WHERE
        (DATE(d.tanggal_mutasi) >= '$dari_tanggal'
            AND DATE(d.tanggal_mutasi) <= '$sampai_tanggal')
            AND b.userlevelid = $userlevelid
    GROUP BY a.id_master_obat_detail_tujuan) f ON a.id_master_obat_detail = f.id_master_obat_detail
WHERE
    a.userlevelid = $userlevelid and a.stok_akhir != 0";
$queryitemstok = mysql_query($sqlitemstok);

$sqlusername="select a.pd_nickname,b.userlevelname from master_login a left join userlevels b on a.userlevelid=b.userlevelid where a.username=$username";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);



?>



<html>
<head>
<meta charset="utf-8">
<title>Arus Stok Unit</title>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
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
 <a href="excel/arus_stok.php"><button>Export ke Excel</button></a>
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
    <div align="center" class="header"><strong>LAPORAN ARUS STOK</strong></div>

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
      <td width="2%">No.</td>
      <td width="40%">Nama Obat</td>
      <td width="5%">Stok Awal</td>
      <td width="5%">Stok Masuk</td>
      <td width="5%">Stok Keluar</td>
      <td width="5%">Mutasi Masuk</td>
      <td width="5%">Mutasi Keluar</td>
      <td width="5%">Stok Akhir</td>
      <td width="5%">Nilai Stok</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemstok)){
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td>'.$data['nama_obat'].'</td>';
	  echo '<td>'.$data['stok_awal'].'</td>';
	  echo '<td>'.$data['stok_masuk'].'</td>';
      echo '<td>'.$data['stok_keluar']. '</td>';
	  echo '<td>'.$data['mutasi_masuk'].'</td>';
      echo '<td>'.$data['mutasi_keluar']. '</td>';
	  echo '<td>'.$data['stok_akhir'].'</td>';
      echo '<td><div align="right">'.number_format($data['harga_jual'], 2,",","."). '</div></td>';
	  echo '</tr>';
			$no++;
		}
	?>
   
  </tbody>
  
</table>
</body>

</html>


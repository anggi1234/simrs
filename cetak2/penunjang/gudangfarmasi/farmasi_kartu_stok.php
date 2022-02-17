<?php
ob_start();
session_start();
include('../../connect.php');
$username = $_GET['username'];
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$id_master_obat_detail= $_GET['id_master_obat_detail'];

$sqlitemstok="SELECT 
    s.unit,
    date(s.tanggal) as tanggal,
    @saldo_awal:=@saldo_awal AS stok_awal,
    s.stok_masuk,
    s.stok_keluar,
    (@saldo_awal:=@saldo_awal + s.stok_masuk - s.stok_keluar) AS stok_akhir,
	s.nomor_bukti
FROM
    (SELECT 
        (@sum:=@sum + (a.qty * a.volume)) AS stok_akhir,
            (a.qty * a.volume) AS stok_masuk,
            0 AS stok_keluar,
            c.nama_supplier AS unit,
            b.tanggal AS tanggal,
			b.nomor_bukti
    FROM
        simrs.farmasi_pembelian_obat_detail a
    CROSS JOIN (SELECT @sum:=0) params
    LEFT JOIN simrs.farmasi_pembelian_obat b ON a.id_pembelian_obat = b.id_pembelian_obat
    LEFT JOIN simrs.master_supplier c ON b.id_supplier = c.id_master_supplier
    WHERE
        a.id_master_obat_detail = $id_master_obat_detail
            AND DATE(a.tanggal) >= '$dari_tanggal'
            AND DATE(a.tanggal) <= '$sampai_tanggal' UNION ALL SELECT 
        (@sum:=@sum - a.qty) AS stok_akhir,
            0 AS stok_masuk,
            a.qty AS stok_keluar,
            c.userlevelname AS unit,
            b.tgl_kirim AS tanggal,
			b.no_reg
    FROM
        simrs.farmasi_pengiriman_obat_detail a
    CROSS JOIN (SELECT @sum:=0) params
    LEFT JOIN simrs.farmasi_pengiriman_obat b ON a.id_farmasi_pengiriman_obat = b.id_farmasi_pengiriman_obat
    LEFT JOIN simrs.userlevels c ON b.userlevelid_to = c.userlevelid
    WHERE
        a.id_master_obat_detail = $id_master_obat_detail
            AND DATE(a.tanggal) >= '$dari_tanggal'
            AND DATE(a.tanggal) <= '$sampai_tanggal'
    ORDER BY tanggal ASC) s,
    (SELECT 
        @saldo_awal:=(SELECT 
                    (IFNULL(e.qty_masuk, 0) - (IFNULL(f.qty_keluar, 0))) AS stok_awal
                FROM
                    master_obat_detail a
                LEFT JOIN master_obat b ON a.id_obat = b.id_obat
                LEFT JOIN (SELECT 
                    SUM((qty * volume)) AS qty_masuk, id_master_obat_detail
                FROM
                    farmasi_pembelian_obat_detail a
                LEFT JOIN farmasi_pembelian_obat b ON a.id_pembelian_obat = b.id_pembelian_obat
                WHERE
                    DATE(b.tanggal) < '$dari_tanggal'
                GROUP BY a.id_master_obat_detail) e ON a.id_master_obat_detail = e.id_master_obat_detail
                LEFT JOIN (SELECT 
                    c.nama_obat,
                        SUM(a.qty) AS qty_keluar,
                        a.id_master_obat_detail
                FROM
                    simrs.farmasi_pengiriman_obat_detail a
                LEFT JOIN master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
                LEFT JOIN master_obat c ON b.id_obat = c.id_obat
                LEFT JOIN farmasi_pengiriman_obat d ON a.id_farmasi_pengiriman_obat = d.id_farmasi_pengiriman_obat
                WHERE
                    DATE(d.tanggal) < '$dari_tanggal'
                GROUP BY a.id_master_obat_detail) f ON a.id_master_obat_detail = f.id_master_obat_detail
                WHERE
                    a.id_master_obat_detail = $id_master_obat_detail)
    ) r";
$queryitemstok = mysql_query($sqlitemstok);

$sqlusername="select a.pd_nickname,b.userlevelname from master_login a left join userlevels b on a.userlevelid=b.userlevelid where a.username=$username";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

$sqlobat="SELECT
	b.nama_obat 
FROM
	simrs.master_obat_detail a
	LEFT JOIN simrs.master_obat b ON a.id_obat = b.id_obat 
WHERE
	a.id_master_obat_detail = $id_master_obat_detail";
 $queryobat = mysql_query($sqlobat);
 $DATA_OBAT = mysql_fetch_array($queryobat);

?>



<html>
<head>
<meta charset="utf-8">
<title>Laporan Kartu Stok</title>
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
    <div align="center" class="header"><strong>LAPORAN KARTU STOK</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="12%">Nama Obat</td>
      <td width="35%">: <?php echo $DATA_OBAT['nama_obat']; ?></td>
      <td width="13%">&nbsp;</td>
      <td width="40%">&nbsp;</td>
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
      <td width="6%">Tanggal</td>
      <td width="26%">Supplier/Unit</td>
      <td width="7%">No Faktur/Reg</td>
      <td width="7%">Stok Awal</td>
      <td width="8%">Stok Masuk</td>
      <td width="8%">Stok Keluar</td>
      <td width="7%">Stok Akhir</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemstok)){
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td>'.$data['tanggal'].'</td>';
	  echo '<td>'.$data['unit'].'</td>';
			echo '<td>'.$data['nomor_bukti'].'</td>';
	  echo '<td>'.$data['stok_awal'].'</td>';
	  echo '<td>'.$data['stok_masuk'].'</td>';
      echo '<td>'.$data['stok_keluar']. '</td>';
	  echo '<td>'.$data['stok_akhir'].'</td>';
	  echo '</tr>';
			$no++;
		}
	?>
   
  </tbody>
  
</table>
</body>

</html>


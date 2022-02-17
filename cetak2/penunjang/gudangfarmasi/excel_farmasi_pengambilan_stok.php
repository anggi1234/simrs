<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=pembelian_obat_gudang.xls");
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

$whrcondn.=($id_master_obat_detail)?" and a.id_master_obat_detail = '$id_master_obat_detail'":"";
$whrsupplier.=($id_supplier)?" and d.id_supplier = '$id_supplier'":"";
$whrgolongan.=($id_golongan_obat)?" and b.id_golongan = '$id_golongan_obat'":"";
$sqlitemstok="SELECT
	DATE_FORMAT( d.tanggal, '%d-%m-%Y' ) AS tanggal,
	a.id_master_obat_detail,
	c.nama_obat,
	a.qty * volume AS qty,
	a.harga_beli_satuan,
	a.pajak,
	a.disc,
	a.total_harga_beli_satuan,
	( a.qty * a.volume ) * a.harga_beli_satuan AS total_hargabeli,
	e.nama_supplier,d.id_supplier,f.nama_golongan,
	d.nomor_bukti
FROM
	farmasi_pembelian_obat_detail a
	LEFT JOIN master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
	LEFT JOIN master_obat c ON b.id_obat = c.id_obat
	LEFT JOIN farmasi_pembelian_obat d ON a.id_pembelian_obat = d.id_pembelian_obat
	LEFT JOIN master_supplier e ON d.id_supplier = e.id_master_supplier 
	LEFT JOIN l_golongan_obat f on b.id_golongan=f.id_golongan_obat
WHERE
    a.userlevelid = $userlevelid
        $whrcondn $whrgolongan
        AND DATE(d.tanggal) >= '$dari_tanggal'
        AND DATE(d.tanggal) <= '$sampai_tanggal' $whrsupplier";
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
<title>Laporan Pemasukan</title>
<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
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
  

    <div align="center" class="header"><strong>LAPORAN STOK PEMBELIAN</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="13%">Nama Obat</td>
      <td width="38%">: <?php echo $DATA_OBAT['nama_obat']; ?></td>
      <td width="17%" align="right">&nbsp;</td>
      <td width="32%">&nbsp;</td>
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
      <td width="12%">Tanggal</td>
      <td width="11%">No. Faktur</td>
      <td width="11%">Nama Obat</td>
      <td width="11%">Golongan</td>
      <td width="24%">Supplier</td>
      <td width="8%">Jumlah</td>
      <td width="13%">Harga Beli</td>
      <td width="6%">Pajak</td>
      <td width="6%">Diskon</td>
      <td width="18%">Total</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemstok)){
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td>'.$data['tanggal'].'</td>';
	  echo '<td>'.$data['nomor_bukti'].'</td>';
	  echo '<td>'.$data['nama_obat'].'</td>';
	  echo '<td>'.$data['nama_golongan'].'</td>';
	  echo '<td>'.$data['nama_supplier'].'</td>';
	  echo '<td align="right">'.$data['qty'].'</td>';
	  echo '<td align="right">'.number_format($data['harga_beli_satuan'], 2,",",".").'</td>';
	  echo '<td align="right">'.$data['pajak'].'</td>';
	  echo '<td align="right">'.$data['disc'].'</td>';
      echo '<td align="right">'.number_format($data['total_hargabeli'], 2,",",".").'</td>';
			$no++;
		}
	?>
    
  </tbody>
</table>

</body>
</html>


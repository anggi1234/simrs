<?php
ob_start();
session_start();
include('../connect.php');
$id_pengadaan_pesanan_barang_masuk = $_GET['id_pengadaan_pesanan_barang_masuk'];

$sqlidentitas="SELECT 
    a.sp_no,a.sp_tgl,b.nama_supplier,b.posisi, b.alamat, a.jumlah_netto,a.no_pesanan,a.tgl_pesanan,b.nama_pj
FROM
    simrs.pengadaan_pesanan_masuk a
        LEFT JOIN
    master_supplier b ON a.id_supplier = b.id_master_supplier
        LEFT JOIN
    master_rekening c ON a.id_rekening = c.id_rekening
        LEFT JOIN
    master_rekening3 d ON a.id_master_rekening3 = d.id_master_rekening3
WHERE
    a.id_pengadaan_pesanan_barang_masuk = '$id_pengadaan_pesanan_barang_masuk'";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

$sqlitem="SELECT
	f.nama_obat,a.qty*a.volume as jumlah,f.satuan,a.harga_beli_satuan,a.harga_beli_setelah_pajak
FROM
	farmasi_pembelian_obat_detail a
	LEFT JOIN farmasi_pembelian_obat b ON a.id_pembelian_obat = b.id_pembelian_obat
	LEFT JOIN pengadaan_pesanan_masuk_faktur c ON b.nomor_bukti = c.nomor_faktur
	LEFT JOIN pengadaan_pesanan_masuk d ON c.id_pengadaan_pesanan_masuk = d.id_pengadaan_pesanan_barang_masuk
	left join master_obat_detail e on a.id_master_obat_detail=e.id_master_obat_detail
	left join master_obat f on e.id_obat=f.id_obat 
WHERE d.id_pengadaan_pesanan_barang_masuk = '$id_pengadaan_pesanan_barang_masuk'";
 $queryitem = mysql_query($sqlitem);

$sqlppk="select nama_pejabat,nip,nama_jabatan,id_jabatan from master_jabatan where id_jabatan=3";
$queryppk = mysql_query($sqlppk);
$DATA_PPK = mysql_fetch_array($queryppk);


function Terbilang($nilai) {
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        if($nilai==0){
            return "";
        }elseif ($nilai < 12&$nilai!=0) {
            return "" . $huruf[$nilai];
        } elseif ($nilai < 20) {
            return Terbilang($nilai - 10) . " Belas ";
        } elseif ($nilai < 100) {
            return Terbilang($nilai / 10) . " Puluh " . Terbilang($nilai % 10);
        } elseif ($nilai < 200) {
            return " Seratus " . Terbilang($nilai - 100);
        } elseif ($nilai < 1000) {
            return Terbilang($nilai / 100) . " Ratus " . Terbilang($nilai % 100);
        } elseif ($nilai < 2000) {
            return " Seribu " . Terbilang($nilai - 1000);
        } elseif ($nilai < 1000000) {
            return Terbilang($nilai / 1000) . " Ribu " . Terbilang($nilai % 1000);
        } elseif ($nilai < 1000000000) {
            return Terbilang($nilai / 1000000) . " Juta " . Terbilang($nilai % 1000000);
        }elseif ($nilai < 1000000000000) {
            return Terbilang($nilai / 1000000000) . " Milyar " . Terbilang($nilai % 1000000000);
        }elseif ($nilai < 100000000000000) {
            return Terbilang($nilai / 1000000000000) . " Trilyun " . Terbilang($nilai % 1000000000000);
        }elseif ($nilai <= 100000000000000) {
            return "Maaf Tidak Dapat di Prose Karena Jumlah nilai Terlalu Besar ";
        }
    }


function tanggal_indo($tanggal, $cetak_hari = false)
	{
		$hari = array ( 1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);
			
		$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
		$split 	  = explode('-', $tanggal);
		$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
	
		if ($cetak_hari) {
			$num = date('N', strtotime($tanggal));
			return $tgl_indo;
		}
		return $tgl_indo;
	}

?>
 <!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SP PUR</title>
<style type="text/css">
	@page {
            margin-top: 2 cm;
            margin-left: 2 cm;
			margin-right: 2 cm;
			margin-bottom: 2 cm;
		font-size: 12px;
		font-family: Impact, Haettenschweiler, Franklin Gothic Bold, Arial Black," sans-serif";
	}
	
	.tabel {
    	border-collapse:collapse;
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

<table width="100%" cellpadding="8px" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="27%" rowspan="3" style="font-weight: bold" align="center">SURAT PESANAN (SP)</td>
      <td colspan="2">SATUAN KERJA PEJABAT PENANDATANGAN/PENGESAHAN TANDA BUKTI PERJANJIAN: RSUD AJIBARANG</td>
    </tr>
    <tr>
      <td width="13%">Nomor SP</td>
      <td width="60%">: <?php echo $DATA_IDENTITAS['sp_no']; ?></td>
    </tr>
    <tr>
      <td>Tanggal SP</td>
      <td>: <?php echo tanggal_indo($DATA_IDENTITAS['sp_tgl'],true); ?></td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="3">Yang bertanda tangan dibawah ini:</td>
    </tr>
    <tr>
      <td width="11%">Nama</td>
      <td width="2%">:</td>
      <td width="87%"><?php echo $DATA_IDENTITAS['ppk']; ?></td>
    </tr>
    <tr>
      <td>Jabatan</td>
      <td>:</td>
      <td>Pejabat Pembuat Komitmen</td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td>:</td>
      <td>Jl. Raya Pancasan - Ajibarang, Kode Pos 53163</td>
    </tr>
    <tr>
      <td colspan="3">selanjutnya disebut sebagai Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Nama</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">dalam hal ini diwakili oleh : <?php echo $DATA_IDENTITAS['nama_pj']; ?></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;selanjutnya disebut sebagai Penyedia;</td>
    </tr>
    <tr>
      <td colspan="3">untuk mengirimkan barang dengan memperhatikan ketentutan-ketentuan sebagai berikut:</td>
    </tr>
  </tbody>
</table>
<center>
  <strong>RINCIAN</strong>
</center>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="4%" align="center">No</td>
      <td width="45%" align="center">Nama Barang</td>
      <td width="7%" align="center">Volume</td>
      <td width="10%" align="center">Satuan</td>
      <td width="17%" align="center">Harga Satuan + PPN</td>
      <td width="17%" align="center">Jumlah Harga</td>
    </tr>
	<?php
	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="7">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
	  echo '<td>'.$no.'.</td>';
      echo '<td>'.$data['nama_obat'].'</td>';
	  echo '<td>'.$data['jumlah'].'</td>';
	  echo '<td>'.$data['satuan'].'</td>';
      echo '<td><div align="right">'.number_format($data['harga_beli_satuan'], 2,",","."). '</div></td>';
	  echo '<td><div align="right">'.number_format($data['harga_beli_setelah_pajak'], 2,",","."). '</div></td>';
			echo '</tr>';
			
			$no++;
		}
	}
    
	?>
	  <tr>
      <td colspan="5" align="right"><strong>TOTAL</strong></td>
      <td width="17%" align="right">Rp.<?php echo number_format($DATA_IDENTITAS['jumlah_netto'], 2,",","."); ?></td>
    </tr>
	  <tr>
      <td colspan="6">Terbilang : <?php echo Terbilang($DATA_IDENTITAS['jumlah_netto']) ?> Rupiah</td>
    </tr>
  </tbody>
</table>

<div class="pagebreak"> </div>

	
	
	
<table border="0" cellpadding="0" style="text-align: justify" cellspacing="0" id="sheet0" class="sheet0 gridlines">
        <col class="col0">
        <col class="col1">
        <col class="col2">
        <col class="col3">
        <col class="col4">
        <col class="col5">
        <col class="col6">
        <col class="col7">
        <col class="col8">
        <col class="col9">
        <col class="col10">
        <col class="col11">
        <col class="col12">
        <col class="col13">
        <col class="col14">
        <tbody>
          <tr class="row0">
            <td class="column0 style1 s style3" colspan="15"><strong>SYARAT DAN KETENTUAN:</strong></td>
          </tr>
          <tr class="row1">
            <td width="3%" class="column0 style4 s style6">1.   </td>
            <td colspan="14" class="column0 style4 s style6">Hak dan Kewajiban</td>
          </tr>
          <tr class="row3">
            <td align="right" class="column0 style10 null">&nbsp;</td>
            <td class="column1 style11 s">&nbsp;</td>
            <td class="column2 style12 s style13" colspan="13">&nbsp;</td>
          </tr>
          <tr class="row3">
            <td width="3%" align="right" class="column0 style10 null">&nbsp;</td>
            <td width="3%" class="column1 style11 s">a.</td>
            <td class="column2 style12 s style13" colspan="13">Penyedia</td>
          </tr>
          <tr class="row3">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 s">&nbsp;</td>
            <td width="4%" class="column2 style12 s style13" valign="top">&nbsp;1)</td>
            <td colspan="12" class="column2 style12 s style13">Penyedia memiliki hak menerima pembayaran atas pembelian barang sesuai dengan total harga dan waktu yang tercantum di dalam SP ini</td>
          </tr>
          <tr class="row4">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 s">&nbsp;</td>
            <td width="4%" class="column2 style5 s style6">&nbsp;<span class="column1 style11 s">2)</span></td>
            <td colspan="12" class="column2 style5 s style6">Penyedia memiliki Kewajiban :</td>
          </tr>
          <tr class="row5">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style15 s">&nbsp;</td>
            <td width="3%" class="column3 style5 s style6">a)</td>
            <td colspan="11" class="column3 style5 s style6">tidak membuat dan/atau menyampaikan dokumen dan/atau keterangan lain yang tidak benar untuk memenuhi persyaratan Katalog Elektronik;</td>
          </tr>
          <tr class="row5">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style15 s">&nbsp;</td>
            <td width="3%" class="column3 style5 s style6">&nbsp;</td>
            <td colspan="11" class="column3 style5 s style6">tidak menjual barang melalui e-Purchasing lebih mahal dari harga barang yang dijual selain melalui e-Purchasing pada periode penjualan, jumlah, dan tempat serta spesifikasi teknis dan persyaratan yang sama;</td>
          </tr>
          <tr class="row5">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style15 s">&nbsp;</td>
            <td width="3%" class="column3 style5 s style6">b)</td>
            <td colspan="11" class="column3 style5 s style6">mengirimkan barang sesuai spesifikasi dalam SP ini selambat-lambatnya pada (tanggal/bulan/tahun) sejak SP ini diterima oleh Penyedia;</td>
          </tr>
          <tr class="row5">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style15 s">&nbsp;</td>
            <td width="3%" class="column3 style5 s style6">c)</td>
            <td colspan="11" class="column3 style5 s style6">bertanggungjawab atas keamanan, kualitas, dan kuantitas barang yang dipesan;</td>
          </tr>
          <tr class="row5">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style15 s">&nbsp;</td>
            <td width="3%" class="column3 style5 s style6">d)</td>
            <td colspan="11" class="column3 style5 s style6">mengganti barang setelah Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian melalui Pejabat/Panitia Penerima Hasil Pekerjaan (PPHP) melakukan pemeriksaan barang dan menemukan bahwa:</td>
          </tr>
          <tr class="row11">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style15 s">&nbsp;</td>
            <td width="3%" class="column4 style5 s style6"><span class="column3 style15 s">e.1</span></td>
            <td colspan="10" class="column4 style5 s style6">barang rusak akibat cacat produksi;</td>
          </tr>
          <tr class="row11">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style15 s">&nbsp;</td>
            <td width="3%" class="column4 style5 s style6"><span class="column3 style15 s">e.2</span></td>
            <td colspan="10" class="column4 style5 s style6">barang rusak pada saat pengiriman barang hingga barang diterima oleh Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian; dan/atau</td>
          </tr>
          <tr class="row11">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style15 s">&nbsp;</td>
            <td width="3%" class="column4 style5 s style6"><span class="column3 style15 s">e.3</span></td>
            <td colspan="10" class="column4 style5 s style6">barang yang diterima tidak sesuai dengan spesifikasi barang sebagaimana tercantum pada SP ini.</td>
          </tr>
          <tr class="row11">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style15 s"><span class="column2 style15 s">f)</span></td>
            <td colspan="11" class="column4 style5 s style6"><span class="column3 style5 s style6">memberikan layanan tambahan yang diperjanjikan seperti instalasi, testing, dan pelatihan (apabila ada); </span></td>
          </tr>
          <tr class="row11">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style15 s"><span class="column2 style15 s">g)</span></td>
            <td class="column4 style5 s style6" colspan="11"><span class="column3 style5 s style6">memberikan layanan purna jual sesuai dengan ketentuan garansi masing-masing barang. </span></td>
          </tr>
          <tr class="row16">
            <td width="3%" class="column0 style10 s">&nbsp;</td>
            <td width="3%" class="column1 style17 s style18">b.</td>
            <td colspan="13" class="column1 style17 s style18">Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian</td>
          </tr>
          <tr class="row18">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s"><span class="column1 style11 s">1)</span></td>
            <td class="column3 style5 s style6" colspan="12"><span class="column2 style17 s style18">Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian memiliki hak:</span></td>
          </tr>
          <tr class="row18">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s">&nbsp;</td>
            <td width="3%" class="column3 style5 s style6">a)</td>
            <td colspan="11" class="column3 style5 s style6">&nbsp;menerima barang dari Penyedia sesuai dengan spesifikasi yang tercantum di dalam SP ini.</td>
          </tr>
          <tr class="row18">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s">&nbsp;</td>
            <td width="3%" class="column3 style5 s style6"><span class="column2 style11 s">b)</span></td>
            <td colspan="11" class="column3 style5 s style6">mendapatkan jaminan keamanan, kualitas, dan kuantitas barang yang dipesan;</td>
          </tr>
          <tr class="row18">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s">&nbsp;</td>
            <td width="3%" class="column3 style5 s style6"><span class="column2 style11 s">c)</span></td>
            <td colspan="11" class="column3 style5 s style6">mendapatkan penggantian barang, dalam hal:</td>
          </tr>
          <tr class="row21">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 s">&nbsp;</td>
            <td width="3%" class="column4 style5 s style6"><span class="column3 style11 s">c.1</span></td>
            <td colspan="10" class="column4 style5 s style6">barang rusak akibat cacat produksi;</td>
          </tr>
          <tr class="row21">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 s">&nbsp;</td>
            <td width="3%" class="column4 style5 s style6">c.2</td>
            <td colspan="10" class="column4 style5 s style6">barang rusak pada saat pengiriman barang hingga barang diterima oleh Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian; dan/atau</td>
          </tr>
          <tr class="row21">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 s">&nbsp;</td>
            <td width="3%" class="column4 style5 s style6">c.3</td>
            <td colspan="10" class="column4 style5 s style6">barang yang diterima tidak sesuai dengan spesifikasi barang sebagaimana tercantum pada SP ini.</td>
          </tr>
          <tr class="row21">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 s">d)</td>
            <td colspan="11" class="column4 style5 s style6"><span class="column3 style5 s style6">Mendapatkan layanan tambahan yang diperjanjikan seperti instalasi, testing, dan pelatihan (apabila ada);</span></td>
          </tr>
          <tr class="row21">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 s">e)</td>
            <td colspan="11" class="column4 style5 s style6"><span class="column3 style5 s style6">Mendapatkan layanan purnajual sesuai dengan ketentuan garansi masing-masing barang.</span></td>
          </tr>
          <tr class="row21">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null">2)</td>
            <td colspan="12" class="column3 style11 s"><span class="column2 style21 s style22">Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian memiliki Kewajiban:</span></td>
          </tr>
          <tr class="row21">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 s">a)</td>
            <td colspan="11" class="column4 style5 s style6"><span class="column3 style5 s style6">melakukan pembayaran sesuai dengan total harga yang tercantum di dalam SP ini; dan</span></td>
          </tr>
          <tr class="row21">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 s">b)</td>
            <td colspan="11" class="column4 style5 s style6"><span class="column3 style5 s style6">memeriksa kualitas dan kuantitas barang;</span></td>
          </tr>
          <tr class="row21">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 s">c)</td>
            <td colspan="11" class="column4 style5 s style6"><span class="column3 style5 s style6">memastikan layanan tambahan telah dilaksanakan oleh penyedia seperti instalasi, testing, dan pelatihan (apabila ada).</span></td>
          </tr>
          <tr class="row30">
            <td class="column0 style10 n">&nbsp;</td>
            <td class="column1 style12 s style13" colspan="14">&nbsp;</td>
          </tr>
          <tr class="row30">
            <td width="3%" class="column0 style10 n">2</td>
            <td class="column1 style12 s style13" colspan="14">Waktu Pengiriman Barang</td>
          </tr>
          <tr class="row31">
            <td width="3%" class="column0 style14 null"></td>
            <td class="column1 style23 s style24" colspan="14">Penyedia mengirimkan barang dan melaksanakan sesuai spesifikasi dalam SP ini selambat-lambatnya 90 (  sembilan puluh ) hari kalender sejak SP ini diterima oleh Penyedia</td>
          </tr>
          <tr class="row32">
            <td class="column0 style10 s">&nbsp;</td>
            <td class="column1 style17 s style18" colspan="14">&nbsp;</td>
          </tr>
          <tr class="row32">
            <td width="3%" class="column0 style10 s">3.</td>
            <td class="column1 style17 s style18" colspan="14">Alamat Pengiriman Barang</td>
          </tr>
          <tr class="row33">
            <td width="3%" class="column0 style14 null"></td>
            <td class="column1 style5 s style6" colspan="14">Penyedia mengirimkan barang ke alamat sebagai berikut:</td>
          </tr>
          <tr class="row34">
            <td width="3%" class="column0 style14 null"></td>
            <td class="column1 style5 s style6" colspan="14">RSUD Ajibarang Jl. Raya Pancasan - Ajibarang Kode Pos 53163 Banyumas </td>
          </tr>
          <tr class="row35">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 null"></td>
            <td width="3%" class="column4 style11 null"></td>
            <td width="633" class="column5 style11 null"></td>
            <td width="46" class="column6 style11 null"></td>
            <td width="46" class="column7 style11 null"></td>
            <td width="46" class="column8 style11 null"></td>
            <td width="46" class="column9 style11 null"></td>
            <td width="46" class="column10 style11 null"></td>
            <td width="46" class="column11 style11 null"></td>
            <td width="46" class="column12 style11 null"></td>
            <td width="46" class="column13 style11 null"></td>
            <td width="52" class="column14 style16 null"></td>
          </tr>
          <tr class="row36">
            <td class="column0 style10 s">&nbsp;</td>
            <td class="column1 style5 s style6" colspan="14">&nbsp;</td>
          </tr>
          <tr class="row36">
            <td width="3%" class="column0 style10 s">4.</td>
            <td class="column1 style5 s style6" colspan="14">Tanggal Barang Diterima</td>
          </tr>
          <tr class="row37">
            <td width="3%" class="column0 style14 null"></td>
            <td class="column1 style25 s style26" colspan="14">Barang diterima selambat-lambatnya pada tanggal 19 April 2018</td>
          </tr>
          <tr class="row38">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style27 null"></td>
            <td width="4%" class="column2 style27 null"></td>
            <td width="3%" class="column3 style27 null"></td>
            <td width="3%" class="column4 style27 null"></td>
            <td class="column5 style27 null"></td>
            <td class="column6 style27 null"></td>
            <td class="column7 style27 null"></td>
            <td class="column8 style27 null"></td>
            <td class="column9 style27 null"></td>
            <td class="column10 style27 null"></td>
            <td class="column11 style27 null"></td>
            <td class="column12 style27 null"></td>
            <td class="column13 style27 null"></td>
            <td class="column14 style28 null"></td>
          </tr>
          <tr class="row39">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 null"></td>
            <td width="3%" class="column4 style11 null"></td>
            <td class="column5 style11 null"></td>
            <td class="column6 style11 null"></td>
            <td class="column7 style11 null"></td>
            <td class="column8 style11 null"></td>
            <td class="column9 style11 null"></td>
            <td class="column10 style11 null"></td>
            <td class="column11 style11 null"></td>
            <td class="column12 style11 null"></td>
            <td class="column13 style11 null"></td>
            <td class="column14 style16 null"></td>
          </tr>
          <tr class="row40">
            <td class="column0 style10 s">&nbsp;</td>
            <td class="column1 style5 s style6" colspan="14">&nbsp;</td>
          </tr>
          <tr class="row40">
            <td width="3%" class="column0 style10 s">5.</td>
            <td class="column1 style5 s style6" colspan="14">Penerimaan, Pemeriksaan, dan Retur Barang</td>
          </tr>
          <tr class="row41">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">a.</td>
            <td class="column2 style5 s style6" colspan="13">Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian melalui PPHP menerima barang dan melakukan pemeriksaan barang berdasarkan ketentuan di dalam SP ini.</td>
          </tr>
          <tr class="row42">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">b.</td>
            <td class="column2 style5 s style6" colspan="13">Dalam hal pada saat pemeriksaan barang, Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian menemukan bahwa:</td>
          </tr>
          <tr class="row43">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s">b.1</td>
            <td class="column3 style5 s style6" colspan="12">barang rusak akibat cacat produksi;</td>
          </tr>
          <tr class="row44">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s">b.2</td>
            <td class="column3 style5 s style6" colspan="12">barang rusak pada saat pengiriman barang hingga barang diterima oleh Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian; dan/atau</td>
          </tr>
          <tr class="row45">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s">b.3</td>
            <td class="column3 style5 s style6" colspan="12">barang yang diterima tidak sesuai dengan spesifikasi barang sebagaimana tercantum pada SP ini.</td>
          </tr>
          <tr class="row46">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 null"></td>
            <td width="3%" class="column4 style11 null"></td>
            <td class="column5 style11 null"></td>
            <td class="column6 style11 null"></td>
            <td class="column7 style11 null"></td>
            <td class="column8 style11 null"></td>
            <td class="column9 style11 null"></td>
            <td class="column10 style11 null"></td>
            <td class="column11 style11 null"></td>
            <td class="column12 style11 null"></td>
            <td class="column13 style11 null"></td>
            <td class="column14 style16 null"></td>
          </tr>
          <tr class="row47">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style29 null"></td>
            <td class="column2 style5 s style6" colspan="13">Maka Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian dapat menolak penerimaan barang dan menyampaikan pemberitahuan tertulis kepada Penyedia atas cacat mutu atau kerusakan barang tersebut.</td>
          </tr>
          <tr class="row48">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">c.</td>
            <td class="column2 style5 s style6" colspan="13">Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian dapat meminta Tim Teknis untuk melakukan pemeriksaan atau uji mutu terhadap barang yang diterima. </td>
          </tr>
          <tr class="row49">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">d.</td>
            <td class="column2 style5 s style6" colspan="13">Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian dapat memerintahkan Penyedia untuk menemukan dan mengungkapkan cacat mutu serta melakukan pengujian terhadap barang yang dianggap Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian mengandung cacat mutu atau kerusakan.</td>
          </tr>
          <tr class="row50">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">e.</td>
            <td class="column2 style5 s style6" colspan="13">Penyedia bertanggungjawab atas cacat mutu atau kerusakan barang dengan memberikan penggantian barang selambat-lambatnya 7 (tujuh) hari kerja. </td>
          </tr>
          <tr class="row51">
            <td class="column0 style10 s">&nbsp;</td>
            <td class="column1 style17 s style18" colspan="14">&nbsp;</td>
          </tr>
          <tr class="row51">
            <td width="3%" class="column0 style10 s">6.</td>
            <td class="column1 style17 s style18" colspan="14">Harga</td>
          </tr>
          <tr class="row52">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">a.</td>
            <td class="column2 style5 s style6" colspan="13">Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian membayar kepada Penyedia atas pelaksanaan pekerjaan sebesar harga yang tercantum pada SP ini. </td>
          </tr>
          <tr class="row53">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">b.</td>
            <td class="column2 style5 s style6" colspan="13">Harga SP telah memperhitungkan keuntungan, pajak, biaya <span style="font-style:italic; color:#000000; font-family:'Tahoma'; font-size:11pt">overhead</span>, biaya pengiriman,  biaya asuransi, biaya layanan tambahan (apabila ada) dan biaya layanan purna jual.</td>
          </tr>
          <tr class="row54">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">c.</td>
            <td class="column2 style5 s style6" colspan="13">Rincian harga SP sesuai dengan rincian yang tercantum dalam daftar kuantitas dan harga.</td>
          </tr>
          <tr class="row55">
            <td class="column0 style10 s">&nbsp;</td>
            <td class="column1 style17 s style18" colspan="14">&nbsp;</td>
          </tr>
          <tr class="row55">
            <td width="3%" class="column0 style10 s">7.</td>
            <td class="column1 style17 s style18" colspan="14">Perpajakan</td>
          </tr>
          <tr class="row56">
            <td width="3%" class="column0 style10 null"></td>
            <td class="column1 style5 s style6" colspan="14">Penyedia berkewajiban untuk membayar semua pajak, bea, retribusi, dan pungutan lain yang sah yang dibebankan oleh hukum yang berlaku atas pelaksanaan SP. Semua pengeluaran perpajakan ini dianggap telah termasuk dalam harga SP.</td>
          </tr>
          <tr class="row57">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 null"></td>
            <td width="3%" class="column4 style11 null"></td>
            <td class="column5 style11 null"></td>
            <td class="column6 style11 null"></td>
            <td class="column7 style11 null"></td>
            <td class="column8 style11 null"></td>
            <td class="column9 style11 null"></td>
            <td class="column10 style11 null"></td>
            <td class="column11 style11 null"></td>
            <td class="column12 style11 null"></td>
            <td class="column13 style11 null"></td>
            <td class="column14 style16 null"></td>
          </tr>
          <tr class="row58">
            <td class="column0 style10 s">&nbsp;</td>
            <td class="column1 style17 s style18" colspan="14">&nbsp;</td>
          </tr>
          <tr class="row58">
            <td width="3%" class="column0 style10 s">8.</td>
            <td class="column1 style17 s style18" colspan="14">Pengalihan dan/atau subkontrak</td>
          </tr>
          <tr class="row59">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 s">a.</td>
            <td class="column2 style5 s style6" colspan="13">Pengalihan seluruh Kontrak hanya diperbolehkan dalam hal terdapat pergantian nama Penyedia, baik sebagai akibat peleburan (<span style="font-style:italic; color:#000000; font-family:'Tahoma'; font-size:11pt">merger</span><span style="color:#000000; font-family:'Tahoma'; font-size:11pt">), konsolidasi, atau pemisahan.</span></td>
          </tr>
          <tr class="row60">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 s">b.</td>
            <td class="column2 style5 s style6" colspan="13">Pengalihan sebagian pelaksanaan Kontrak dilakukan dengan ketentuan sebagai berikut:</td>
          </tr>
          <tr class="row61">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s">1)</td>
            <td class="column3 style5 s style6" colspan="12">Pengalihan sebagian pelaksanaan Kontrak untuk barang/jasa yang bersifat standar dilakukan untuk pekerjaan seperti pengiriman barang (distribusi barang) dari Penyedia kepada Kementerian/Lembaga/Satuan Kerja Perangkat Daerah/Institusi; dan</td>
          </tr>
          <tr class="row62">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s">2)</td>
            <td class="column3 style5 s style6" colspan="12">Pengalihan sebagian pelaksanaan Kontrak dapat dilakukan untuk barang/jasa yang bersifat tidak standar misalnya untuk pekerjaan konstruksi (minor), pengadaan ambulans, ready mix, hot mix dan lain sebagainya.</td>
          </tr>
          <tr class="row63">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 null"></td>
            <td width="3%" class="column4 style11 null"></td>
            <td class="column5 style11 null"></td>
            <td class="column6 style11 null"></td>
            <td class="column7 style11 null"></td>
            <td class="column8 style11 null"></td>
            <td class="column9 style11 null"></td>
            <td class="column10 style11 null"></td>
            <td class="column11 style11 null"></td>
            <td class="column12 style11 null"></td>
            <td class="column13 style11 null"></td>
            <td class="column14 style16 null"></td>
          </tr>
          <tr class="row64">
            <td class="column0 style10 s">&nbsp;</td>
            <td class="column1 style17 s style18" colspan="14">&nbsp;</td>
          </tr>
          <tr class="row64">
            <td width="3%" class="column0 style10 s">9.</td>
            <td class="column1 style17 s style18" colspan="14">&nbsp;Perubahan SP</td>
          </tr>
          <tr class="row65">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">a.</td>
            <td class="column2 style5 s style6" colspan="13">SP hanya dapat diubah melalui adendum SP.</td>
          </tr>
          <tr class="row66">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">b.</td>
            <td class="column2 style5 s style6" colspan="13">Perubahan SP dapat dilakukan apabila disetujui oleh para pihak dalam hal terjadi perubahan jadwal pengiriman barang atas permintaan Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian atau permohonan Penyedia yang disepakati oleh Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian. </td>
          </tr>
          <tr class="row67">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 null"></td>
            <td width="3%" class="column4 style11 null"></td>
            <td class="column5 style11 null"></td>
            <td class="column6 style11 null"></td>
            <td class="column7 style11 null"></td>
            <td class="column8 style11 null"></td>
            <td class="column9 style11 null"></td>
            <td class="column10 style11 null"></td>
            <td class="column11 style11 null"></td>
            <td class="column12 style11 null"></td>
            <td class="column13 style11 null"></td>
            <td class="column14 style16 null"></td>
          </tr>
          <tr class="row68">
            <td class="column0 style10 s">&nbsp;</td>
            <td class="column1 style17 s style18" colspan="14">&nbsp;</td>
          </tr>
          <tr class="row68">
            <td width="3%" class="column0 style10 s">10.</td>
            <td class="column1 style17 s style18" colspan="14">&nbsp;Peristiwa Kompensasi</td>
          </tr>
          <tr class="row69">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">a.</td>
            <td class="column2 style5 s style6" colspan="13">Peristiwa Kompensasi dapat diberikan kepada penyedia dalam hal Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian terlambat melakukan pembayaran prestasi pekerjaan kepada Penyedia.</td>
          </tr>
          <tr class="row70">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">b.</td>
            <td class="column2 style5 s style6" colspan="13">Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian dikenakan ganti rugi atas keterlambatan pembayaran sebesar 0% (nol perseratus)</td>
          </tr>
          <tr class="row71">
            <td class="column0 style10 s">&nbsp;</td>
            <td class="column1 style17 s style18" colspan="14">&nbsp;</td>
          </tr>
          <tr class="row71">
            <td width="3%" class="column0 style10 s">11.</td>
            <td class="column1 style17 s style18" colspan="14">&nbsp;Hak Atas Kekayaan Intelektual</td>
          </tr>
          <tr class="row72">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">a.</td>
            <td class="column2 style5 s style6" colspan="13">Penyedia berkewajiban untuk memastikan bahwa barang yang dikirimkan/dipasok tidak melanggar Hak Atas Kekayaan Intelektual (HAKI) pihak manapun dan dalam bentuk apapun. </td>
          </tr>
          <tr class="row73">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">b.</td>
            <td class="column2 style5 s style6" colspan="13">Penyedia berkewajiban untuk menanggung Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian dari atau atas semua tuntutan, tanggung jawab, kewajiban, kehilangan, kerugian, denda, gugatan atau tuntutan hukum, proses pemeriksaan hukum, dan biaya yang dikenakan terhadap Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian sehubungan dengan klaim atas pelanggaran HAKI, termasuk pelanggaran hak cipta, merek dagang, hak paten, dan bentuk HAKI lainnya yang dilakukan atau diduga dilakukan oleh Penyedia.</td>
          </tr>
          <tr class="row74">
            <td class="column0 style10 s">&nbsp;</td>
            <td class="column1 style17 s style18" colspan="14">&nbsp;</td>
          </tr>
          <tr class="row74">
            <td width="3%" class="column0 style10 s">12.</td>
            <td class="column1 style17 s style18" colspan="14">Jaminan Bebas Cacat Mutu/Garansi</td>
          </tr>
          <tr class="row75">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 s">a.</td>
            <td class="column2 style5 s style6" colspan="13">Penyedia dengan jaminan pabrikan dari produsen pabrikan (jika ada) berkewajiban untuk menjamin bahwa selama penggunaan secara wajar oleh Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian, Barang tidak mengandung cacat mutu yang disebabkan oleh tindakan atau kelalaian Penyedia, atau cacat mutu akibat desain, bahan, dan cara kerja.</td>
          </tr>
          <tr class="row76">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">b.</td>
            <td class="column2 style5 s style6" colspan="13">Jaminan bebas cacat mutu ini berlaku sampai dengan 12 (dua belas) bulan setelah serah terima Barang atau jangka waktu lain yang ditetapkan dalam SP ini.</td>
          </tr>
          <tr class="row77">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">c.</td>
            <td class="column2 style5 s style6" colspan="13">Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian akan menyampaikan pemberitahuan cacat mutu kepada Penyedia segera setelah ditemukan cacat mutu tersebut selama Masa Layanan Purnajual.</td>
          </tr>
          <tr class="row78">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">d.</td>
            <td class="column2 style5 s style6" colspan="13">Terhadap pemberitahuan cacat mutu oleh Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian, Penyedia berkewajiban untuk memperbaiki atau mengganti Barang dalam jangka waktu yang ditetapkan dalam pemberitahuan tersebut.</td>
          </tr>
          <tr class="row79">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">e.</td>
            <td class="column2 style5 s style6" colspan="13">Jika Penyedia tidak memperbaiki atau mengganti Barang akibat cacat mutu dalam jangka waktu yang ditentukan, maka Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian akan menghitung biaya perbaikan yang diperlukan dan Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian secara langsung atau melalui pihak ketiga yang ditunjuk oleh Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian akan melakukan perbaikan tersebut. Penyedia berkewajiban untuk membayar biaya perbaikan atau penggantian tersebut sesuai dengan klaim yang diajukan secara tertulis oleh Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian. Biaya tersebut dapat dipotong oleh Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian dari nilai tagihan Penyedia. </td>
          </tr>
          <tr class="row80">
            <td class="column0 style10 s">&nbsp;</td>
            <td class="column1 style17 s style18" colspan="14">&nbsp;</td>
          </tr>
          <tr class="row80">
            <td width="3%" class="column0 style10 s">13.</td>
            <td class="column1 style17 s style18" colspan="14">Pembayaran</td>
          </tr>
          <tr class="row81">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">a.</td>
            <td class="column2 style5 s style6" colspan="13">Pembayaran prestasi hasil pekerjaan yang disepakati dilakukan oleh Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian, dengan ketentuan:</td>
          </tr>
          <tr class="row82">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s">1)</td>
            <td class="column3 style5 s style6" colspan="12">penyedia telah mengajukan tagihan;</td>
          </tr>
          <tr class="row83">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s">2)</td>
            <td class="column3 style5 s style6" colspan="12">pembayaran dilakukan dengan sistem pembayaran secara sekaligus; dan</td>
          </tr>
          <tr class="row84">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s">3)</td>
            <td class="column3 style5 s style6" colspan="12">pembayaran harus dipotong denda (apabila ada) dan pajak.</td>
          </tr>
          <tr class="row85">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">b.</td>
            <td class="column2 style5 s style6" colspan="13">pembayaran terakhir hanya dilakukan setelah pekerjaan selesai 100% (seratus perseratus) dan bukti penyerahan pekerjaan diterbitkan.</td>
          </tr>
          <tr class="row86">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">&nbsp;&nbsp;</td>
            <td class="column2 style5 s style6" colspan="13">Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian melakukan proses pembayaran atas pembelian barang selambat-lambatnya 90 (  sembilan puluh ) hari kalender setelah PPK menilai bahwa dokumen pembayaran lengkap dan sah</td>
          </tr>
          <tr class="row87">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 null"></td>
            <td width="3%" class="column4 style11 null"></td>
            <td class="column5 style11 null"></td>
            <td class="column6 style11 null"></td>
            <td class="column7 style11 null"></td>
            <td class="column8 style11 null"></td>
            <td class="column9 style11 null"></td>
            <td class="column10 style11 null"></td>
            <td class="column11 style11 null"></td>
            <td class="column12 style11 null"></td>
            <td class="column13 style11 null"></td>
            <td class="column14 style16 null"></td>
          </tr>
          <tr class="row88">
            <td class="column0 style10 s">&nbsp;</td>
            <td class="column1 style17 s style18" colspan="14">&nbsp;</td>
          </tr>
          <tr class="row88">
            <td width="3%" class="column0 style10 s">14.</td>
            <td class="column1 style17 s style18" colspan="14">Sanksi</td>
          </tr>
          <tr class="row89">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">a.</td>
            <td class="column2 style5 s style6" colspan="13">Penyedia dikenakan sanksi apabila:</td>
          </tr>
          <tr class="row90">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s">1)</td>
            <td class="column3 style5 s style6" colspan="12">Tidak menanggapi pesanan barang selambat-lambatnya 90 (  sembilan puluh ) hari kalender</td>
          </tr>
          <tr class="row91">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s">2)</td>
            <td class="column3 style5 s style6" colspan="12">Tidak dapat memenuhi pesanan sesuai dengan kesepakatan dalam transaksi melalui <span style="font-style:italic; color:#000000; font-family:'Tahoma'; font-size:11pt">e-Purchasing</span> dan SP ini tanpa disertai alasan yang dapat diterima; dan/atau</td>
          </tr>
          <tr class="row92">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s">3)</td>
            <td class="column3 style5 s style6" colspan="12">menjual barang melalui proses <span style="font-style:italic; color:#000000; font-family:'Tahoma'; font-size:11pt">e-Purchasing </span>dengan harga yanglebih mahal dari harga Barang/Jasa yang dijual selain melalui </span><span style="font-style:italic; color:#000000; font-family:'Tahoma'; font-size:11pt">e-Purchasing </span>pada periode penjualan,  jumlah, dan tempat serta spesifikasi teknis dan persyaratan yang sama. </td>
          </tr>
          <tr class="row93">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">b.</td>
            <td class="column2 style5 s style6" colspan="13">Penyedia yang melakukan perbuatan sebagaimana dimaksud dalam huruf a dikenakan sanksi administratif berupa:</td>
          </tr>
          <tr class="row94">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s">1)</td>
            <td class="column3 style30 s style31" colspan="12">&nbsp;peringatan tertulis;</td>
          </tr>
          <tr class="row95">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s">2)</td>
            <td class="column3 style30 s style31" colspan="12">&nbsp;denda; dan</td>
          </tr>
          <tr class="row96">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s">3)</td>
            <td class="column3 style30 s style31" colspan="12">&nbsp;pelaporan kepada LKPP untuk dilakukan:</td>
          </tr>
          <tr class="row97">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 s">a)</td>
            <td class="column4 style17 s style18" colspan="11">&nbsp;penghentian sementara dalam sistem transaksi <span style="font-style:italic; color:#000000; font-family:'Tahoma'; font-size:11pt">e-Purchasing</span><span style="color:#000000; font-family:'Tahoma'; font-size:11pt">; atau</span></td>
          </tr>
          <tr class="row98">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 null"></td>
            <td width="3%" class="column4 style32 null"></td>
            <td class="column5 style32 null"></td>
            <td class="column6 style32 null"></td>
            <td class="column7 style32 null"></td>
            <td class="column8 style32 null"></td>
            <td class="column9 style32 null"></td>
            <td class="column10 style32 null"></td>
            <td class="column11 style32 null"></td>
            <td class="column12 style32 null"></td>
            <td class="column13 style32 null"></td>
            <td class="column14 style33 null"></td>
          </tr>
          <tr class="row99">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 s">b)</td>
            <td class="column4 style17 s style18" colspan="11">&nbsp;penurunan pencantuman dari Katalog Elektronik (<span style="font-style:italic; color:#000000; font-family:'Tahoma'; font-size:11pt">e-Catalogue</span><span style="color:#000000; font-family:'Tahoma'; font-size:11pt">). </span></td>
          </tr>
          <tr class="row100">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 s">c.</td>
            <td colspan="13" class="column2 style34 s">Tata Cara Pengenaan Sanksi</td>
          </tr>
          <tr class="row101">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td class="column2 style5 s style6" colspan="13">Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian mengenakan sanksi sebagaimana dimaksud dalam huruf a dan huruf b berdasarkan ketentuan mengenai sanksi sebagaimana diatur dalam Peraturan Kepala LKPP tentang <span style="font-style:italic; color:#000000; font-family:'Tahoma'; font-size:11pt">e-Purchasing</span><span style="color:#000000; font-family:'Tahoma'; font-size:11pt">. </span></td>
          </tr>
          <tr class="row102">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 null"></td>
            <td width="3%" class="column4 style11 null"></td>
            <td class="column5 style11 null"></td>
            <td class="column6 style11 null"></td>
            <td class="column7 style11 null"></td>
            <td class="column8 style11 null"></td>
            <td class="column9 style11 null"></td>
            <td class="column10 style11 null"></td>
            <td class="column11 style11 null"></td>
            <td class="column12 style11 null"></td>
            <td class="column13 style11 null"></td>
            <td class="column14 style16 null"></td>
          </tr>
          <tr class="row103">
            <td class="column0 style14 s">&nbsp;</td>
            <td class="column1 style17 s style18" colspan="14">&nbsp;</td>
          </tr>
          <tr class="row103">
            <td width="3%" class="column0 style14 s">15.</td>
            <td class="column1 style17 s style18" colspan="14">Penghentian dan Pemutusan SP </td>
          </tr>
          <tr class="row104">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">a.</td>
            <td class="column2 style5 s style6" colspan="13">Penghentian SP dapat dilakukan karena pekerjaan sudah selesai atau terjadi Keadaan Kahar.</td>
          </tr>
          <tr class="row105">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">b.</td>
            <td class="column2 style5 s style6" colspan="13">Pemutusan SP oleh Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian</td>
          </tr>
          <tr class="row106">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s">1)</td>
            <td class="column3 style5 s style6" colspan="12">Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian dapat melakukan pemutusan SP apabila:</td>
          </tr>
          <tr class="row107">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 s">a)</td>
            <td class="column4 style5 s style6" colspan="11">&nbsp;kebutuhan barang/jasa tidak dapat ditunda melebihi batas berakhirnya SP;</td>
          </tr>
          <tr class="row108">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 s">b)</td>
            <td class="column4 style5 s style6" colspan="11">berdasarkan penelitian Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian, Penyedia tidak akan mampu menyelesaikan keseluruhan pekerjaan walaupun diberikan kesempatan sampai dengan 50 (lima puluh) hari kalender sejak masa berakhirnya pelaksanaan pekerjaan untuk menyelesaikan pekerjaan;</td>
          </tr>
          <tr class="row109">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 s">c)</td>
            <td class="column4 style5 s style6" colspan="11">setelah diberikan kesempatan menyelesaikan pekerjaan sampai dengan 50 (lima puluh) hari kalender sejak masa berakhirnya pelaksanaan pekerjaan, Penyedia Barang/Jasa tidak dapat menyelesaikan pekerjaan;</td>
          </tr>
          <tr class="row110">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 s">d)</td>
            <td class="column4 style5 s style6" colspan="11">Penyedia lalai/cidera janji dalam melaksanakan kewajibannya dan tidak memperbaiki kelalaiannya dalam jangka waktu yang telah ditetapkan;</td>
          </tr>
          <tr class="row111">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 s">e)</td>
            <td class="column4 style5 s style6" colspan="11">Penyedia terbukti melakukan KKN, kecurangan dan/atau pemalsuan dalam proses Pengadaan yang diputuskan oleh instansi yang berwenang; dan/atau</td>
          </tr>
          <tr class="row112">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 s">f)</td>
            <td class="column4 style5 s style6" colspan="11">pengaduan tentang penyimpangan prosedur, dugaan KKN dan/atau pelanggaran persaingan sehat dalam pelaksanaan pengadaan dinyatakan benar oleh instansi yang berwenang.</td>
          </tr>
          <tr class="row113">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style36 null"></td>
            <td width="4%" class="column2 style36 s">2)</td>
            <td class="column3 style23 s style24" colspan="12">Pemutusan SP sebagaimana dimaksud pada angka 1) dilakukan selambat-lambatnya 30 (tiga puluh) hari kerja setelah Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian menyampaikan pemberitahuan rencana pemutusan SP secara tertulis kepada Penyedia</td>
          </tr>
          <tr class="row114">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">c.</td>
            <td class="column2 style12 s style13" colspan="13">&nbsp;Pemutusan SP oleh Penyedia</td>
          </tr>
          <tr class="row115">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 s">1)</td>
            <td class="column3 style5 s style6" colspan="12">Penyedia dapat melakukan pemutusan Kontrak jika terjadi hal-hal sebagai berikut:</td>
          </tr>
          <tr class="row116">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 s">a)</td>
            <td class="column4 style5 s style6" colspan="11">akibat keadaan kahar sehingga Penyedia tidak dapat melaksanakan pekerjaan sesuai ketentuan SP atau adendum SP;</td>
          </tr>
          <tr class="row117">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 s">b)</td>
            <td class="column4 style5 s style6" colspan="11">Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian gagal mematuhi keputusan akhir penyelesaian perselisihan; atau</td>
          </tr>
          <tr class="row118">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 s">c)</td>
            <td class="column4 style5 s style6" colspan="11">Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian tidak memenuhi kewajiban sebagaimana dimaksud dalam SP atau Adendum SP. </td>
          </tr>
          <tr class="row119">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style37 null"></td>
            <td width="4%" class="column2 style37 s">2)</td>
            <td class="column3 style23 s style24" colspan="12">Pemutusan SP sebagaimana dimaksud pada angka 1) dilakukan selambat-lambatnya 30 (tiga puluh) hari kerja setelah Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian menandatangani  SP.</td>
          </tr>
          <tr class="row120">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 null"></td>
            <td width="3%" class="column4 style11 null"></td>
            <td class="column5 style11 null"></td>
            <td class="column6 style11 null"></td>
            <td class="column7 style11 null"></td>
            <td class="column8 style11 null"></td>
            <td class="column9 style11 null"></td>
            <td class="column10 style11 null"></td>
            <td class="column11 style11 null"></td>
            <td class="column12 style11 null"></td>
            <td class="column13 style11 null"></td>
            <td class="column14 style16 null"></td>
          </tr>
          <tr class="row121">
            <td class="column0 style10 s">&nbsp;</td>
            <td class="column1 style5 s style6" colspan="14">&nbsp;</td>
          </tr>
          <tr class="row121">
            <td width="3%" class="column0 style10 s">16.</td>
            <td class="column1 style5 s style6" colspan="14">Denda Keterlambatan Pelaksanaan Pekerjaan</td>
          </tr>
          <tr class="row122">
            <td width="3%" class="column0 style14 null"></td>
            <td class="column1 style5 s style6" colspan="14">Penyedia yang terlambat menyelesaikan pekerjaan dalam jangka waktu sebagaimana ditetapkan dalam SP ini karena kesalahan Penyedia, dikenakan denda keterlambatan sebesar 1/1000 (satu perseribu) dari total harga atau dari sebagian total harga sebagaimana tercantum dalam SP ini untuk setiap hari keterlambatan.</td>
          </tr>
          <tr class="row123">
            <td class="column0 style10 s">&nbsp;</td>
            <td class="column1 style5 s style6" colspan="14">&nbsp;</td>
          </tr>
          <tr class="row123">
            <td width="3%" class="column0 style10 s">17.</td>
            <td class="column1 style5 s style6" colspan="14">Keadaan Kahar</td>
          </tr>
          <tr class="row124">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">a.</td>
            <td class="column2 style5 s style6" colspan="13">Keadaan Kahar adalah suatu keadaan yang terjadi diluar kehendak para pihak dan tidak dapat diperkirakan sebelumnya, sehingga kewajiban yang ditentukan dalam SP menjadi tidak dapat dipenuhi.</td>
          </tr>
          <tr class="row125">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">b.  </td>
            <td class="column2 style5 s style6" colspan="13">Dalam hal terjadi Keadaan Kahar, Penyedia memberitahukan tentang terjadinya Keadaan Kahar kepada Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian secara tertulis dalam waktu selambat-lambatnya 14 (empat belas) hari kalender sejak terjadinya Keadaan Kahar yang dikeluarkan oleh pihak/instansi yang berwenang sesuai ketentuan peraturan perundang-undangan.</td>
          </tr>
          <tr class="row126">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">c.</td>
            <td class="column2 style5 s style6" colspan="13">Tidak termasuk Keadaan Kahar adalah hal-hal merugikan yang disebabkan oleh perbuatan atau kelalaian para pihak.</td>
          </tr>
          <tr class="row127">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 null"></td>
            <td width="3%" class="column4 style11 null"></td>
            <td class="column5 style11 null"></td>
            <td class="column6 style11 null"></td>
            <td class="column7 style11 null"></td>
            <td class="column8 style11 null"></td>
            <td class="column9 style11 null"></td>
            <td class="column10 style11 null"></td>
            <td class="column11 style11 null"></td>
            <td class="column12 style11 null"></td>
            <td class="column13 style11 null"></td>
            <td class="column14 style16 null"></td>
          </tr>
          <tr class="row128">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">d.</td>
            <td class="column2 style5 s style6" colspan="13">Keterlambatan pelaksanaan pekerjaan yang diakibatkan oleh terjadinya Keadaan Kahar tidak dikenakan sanksi.</td>
          </tr>
          <tr class="row129">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 s">e.</td>
            <td class="column2 style5 s style6" colspan="13">Setelah terjadinya Keadaan Kahar, para pihak dapat melakukan kesepakatan, yang dituangkan dalam perubahan SP. </td>
          </tr>
          <tr class="row130">
            <td width="3%" class="column0 style14 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 null"></td>
            <td width="3%" class="column4 style11 null"></td>
            <td class="column5 style11 null"></td>
            <td class="column6 style11 null"></td>
            <td class="column7 style11 null"></td>
            <td class="column8 style11 null"></td>
            <td class="column9 style11 null"></td>
            <td class="column10 style11 null"></td>
            <td class="column11 style11 null"></td>
            <td class="column12 style11 null"></td>
            <td class="column13 style11 null"></td>
            <td class="column14 style16 null"></td>
          </tr>
          <tr class="row131">
            <td class="column0 style10 s">&nbsp;</td>
            <td class="column1 style5 s style6" colspan="14">&nbsp;</td>
          </tr>
          <tr class="row131">
            <td width="3%" class="column0 style10 s">18.</td>
            <td class="column1 style5 s style6" colspan="14">Penyelesaian Perselisihan</td>
          </tr>
          <tr class="row132">
            <td width="3%" class="column0 style14 null"></td>
            <td class="column1 style5 s style6" colspan="14">Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian dan penyedia berkewajiban untuk berupaya sungguh-sungguh menyelesaikan secara damai semua perselisihan yang timbul dari atau berhubungan dengan SP ini atau interpretasinya selama atau setelah pelaksanaan pekerjaan. Jika perselisihan tidak dapat diselesaikan secara musyawarah maka perselisihan akan diselesaikan melalui arbitrase, mediasi, konsiliasi atau pengadilan negeri dalam wilayah hukum Republik Indonesia.</td>
          </tr>
          <tr class="row133">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 null"></td>
            <td width="3%" class="column4 style11 null"></td>
            <td class="column5 style11 null"></td>
            <td class="column6 style11 null"></td>
            <td class="column7 style11 null"></td>
            <td class="column8 style11 null"></td>
            <td class="column9 style11 null"></td>
            <td class="column10 style11 null"></td>
            <td class="column11 style11 null"></td>
            <td class="column12 style11 null"></td>
            <td class="column13 style11 null"></td>
            <td class="column14 style16 null"></td>
          </tr>
          <tr class="row134">
            <td class="column0 style10 s">&nbsp;</td>
            <td class="column1 style5 s style6" colspan="14">&nbsp;</td>
          </tr>
          <tr class="row134">
            <td width="3%" class="column0 style10 s">19.</td>
            <td class="column1 style5 s style6" colspan="14">Larangan Pemberian Komisi</td>
          </tr>
          <tr class="row135">
            <td width="3%" class="column0 style14 null"></td>
            <td class="column1 style5 s style6" colspan="14">Penyedia menjamin bahwa tidak satu pun personil satuan kerja Pejabat Penandatangan/Pengesahan Tanda Bukti Perjanjian telah atau akan menerima komisi dalam bentuk apapun (gratifikasi) atau keuntungan tidak sah lainnya baik langsung maupun tidak langsung dari SP ini. Penyedia menyetujui bahwa pelanggaran syarat ini merupakan pelanggaran yang mendasar terhadap SP ini.</td>
          </tr>
          <tr class="row136">
            <td class="column0 style10 s">&nbsp;</td>
            <td class="column1 style17 s style18" colspan="14">&nbsp;</td>
          </tr>
          <tr class="row136">
            <td width="3%" class="column0 style10 s">20.</td>
            <td class="column1 style17 s style18" colspan="14">Masa Berlaku SP</td>
          </tr>
          <tr class="row137">
            <td width="3%" class="column0 style14 null"></td>
            <td class="column1 style5 s style6" colspan="14">SP ini berlaku sejak tanggal SP ini ditandatangani oleh para pihak sampai dengan selesainya pelaksanaan pekerjaan.</td>
          </tr>
          <tr class="row138">
            <td width="3%" class="column0 style10 null"></td>
            <td width="3%" class="column1 style11 null"></td>
            <td width="4%" class="column2 style11 null"></td>
            <td width="3%" class="column3 style11 null"></td>
            <td width="3%" class="column4 style11 null"></td>
            <td class="column5 style11 null"></td>
            <td class="column6 style11 null"></td>
            <td class="column7 style11 null"></td>
            <td class="column8 style11 null"></td>
            <td class="column9 style11 null"></td>
            <td class="column10 style11 null"></td>
            <td class="column11 style11 null"></td>
            <td class="column12 style11 null"></td>
            <td class="column13 style11 null"></td>
            <td class="column14 style16 null"></td>
          </tr>
          <tr class="row139">
            <td class="column0 style4 s style6" colspan="15">Demikian SP ini dibuat dan ditandatangani dalam 2 (dua) rangkap bermaterai dan masing-masing memiliki kekuatan hukum yang sama.  </td>
          </tr>
        </tbody>
    </table>	
	<br><br>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="50%" style="text-align: center">Untuk dan atas nama</td>
      <td width="50%" style="text-align: center">Untuk dan atas nama</td>
    </tr>
    <tr>
      <td style="text-align: center">RSUD AJIBARANG</td>
      <td style="text-align: center"><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center"><u><?php echo $DATA_PPK['nama_pejabat']; ?></u></td>
      <td style="text-align: center"><u><?php echo $DATA_IDENTITAS['nama_pj']; ?></u></td>
    </tr>
    <tr>
      <td style="text-align: center">NIP.<?php echo $DATA_PPK['nip']; ?></td>
      <td style="text-align: center"><?php echo $DATA_IDENTITAS['posisi']; ?></td>
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
$dompdf->stream('e-purchasing_sp.pdf',array('Attachment' => 0));
?>
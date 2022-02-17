<?php
ob_start();
session_start();
include('../connect.php');
$nomor_pesanan = $_GET['no_pesanan'];

$sqlidentitas="SELECT
	a.jumlah_bruto,
	a.jumlah_ppn + a.jumlah_pph AS potongan,
	a.jumlah_ppn,
	a.jumlah_pph,
	a.jumlah_netto,
	b.nama_rekening,
	b.sub_kegiatan,
	a.kode_rekening,
c.nama_supplier,
c.alamat,
c.nama_pj,
c.posisi,
C.npwp,
d.pd_nickname as pengguna_anggaran,
e.pd_nickname as ppk,
e.nip AS nip_ppk,
f.pd_nickname as pptk,
g.pd_nickname as bendahara,
h.pd_nickname as pphp,
	a.sp_no,
	date_format(a.sp_tgl, '%d-%m-%Y') as sp_tgl,
	i.jumlah_total,a.kontrak_tgl_akhir,a.kontrak_jangka_waktu
FROM
	simrs.pengadaan_pesanan_masuk a
	LEFT JOIN simrs.master_rekening b ON a.id_rekening = b.id_rekening
	LEFT JOIN simrs.master_supplier c ON a.id_supplier = c.id_master_supplier
	LEFT JOIN simrs.master_login d on b.pa_uid=d.uid
	LEFT JOIN simrs.master_login e on b.ppk_uid=e.uid
	LEFT JOIN simrs.master_login f on b.pptk_uid=f.uid
	left join simrs.master_login g on b.bp_uid=g.uid
	left join simrs.master_login h on b.pphp_uid=h.uid 
	LEFT JOIN ( SELECT no_pesanan, sum( jumlah_total ) AS jumlah_total FROM pengadaan_pesanan_masuk_faktur WHERE no_pesanan = '$nomor_pesanan' GROUP BY no_pesanan ) i ON a.no_pesanan = i.no_pesanan
WHERE
	a.no_pesanan = '$nomor_pesanan'";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

$sqlitem="SELECT
	f.nama_obat,a.qty*a.volume as jumlah,f.satuan,a.harga_beli_satuan,a.harga_beli_setelah_pajak
FROM
	farmasi_pembelian_obat_detail a
	LEFT JOIN farmasi_pembelian_obat b ON a.id_pembelian_obat = b.id_pembelian_obat
	LEFT JOIN pengadaan_pesanan_masuk_faktur c ON b.id_pembelian_obat = c.id_pembelian_obat
	LEFT JOIN pengadaan_pesanan_masuk d ON c.id_pengadaan_pesanan_masuk = d.id_pengadaan_pesanan_barang_masuk
	left join master_obat_detail e on a.id_master_obat_detail=e.id_master_obat_detail
	left join master_obat f on e.id_obat=f.id_obat 
WHERE
	d.no_pesanan = '$nomor_pesanan'";
 $queryitem = mysql_query($sqlitem);


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
<title>REG Surat Pesanan</title>
<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
		font-size: 12px;
		font-family: Impact, Haettenschweiler, Franklin Gothic Bold, Arial Black," sans-serif";
	}
	
	.tabel {
    	border-collapse:collapse;
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
  <table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td align="center" style="font-weight: bold; font-size: 18px;"><u>SURAT PESANAN (SP)</u></td>
    </tr>
    <tr>
      <td align="center">NOMOR : -</td>
    </tr>
    <tr>
      <td align="center"><strong>Pekerjaan <?php echo $DATA_IDENTITAS['nama_rekening']; ?></strong></td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="3">Yang bertanda tangan dibawah ini:</td>
    </tr>
    <tr>
      <td width="19%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="80%">&nbsp;</td>
    </tr>
    <tr>
      <td>Nama</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['ppk']; ?></td>
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
      <td colspan="3">selanjutnya disebut sebagai Pejabat Penandatanganan/Pengesahan Tanga Bukti Perjanjian:  </td>
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
      <td colspan="3">dalam hal ini diwakili oleh : <?php echo $DATA_IDENTITAS['nama_pj']; ?></td>
    </tr>
    <tr>
      <td colspan="3">selanjutnya disebut sebagai Penyedia;</td>
    </tr>
    <tr>
      <td colspan="3">untuk mengirimkan barang dengan memperhatikan ketentuan-ketentuan sebagai berikut:</td>
    </tr>
    <tr>
      <td colspan="3">1. Rincian Barang</td>
    </tr>
  </tbody>
</table>

<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="4%" align="center">No</td>
      <td width="43%" align="center">Jenis Barang</td>
      <td width="9%" align="center">Volume</td>
      <td width="10%" align="center">Satuan</td>
      <td width="18%" align="center">Harga Satuan + PPN</td>
      <td width="16%" align="center">Jumlah Harga</td>
    </tr>
    <?php
	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="6">Tidak ada data</td></tr>';
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
      <td colspan="4" rowspan="3">&nbsp;</td>
      <td>Jumlah</td>
      <td align="right">Rp <?php echo number_format($DATA_IDENTITAS['jumlah_bruto'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>PPN</td>
      <td align="right"></td>
    </tr>
    <tr>
      <td>Nilai</td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6">Terbilang: <?php echo Terbilang($DATA_IDENTITAS['jumlah_total']) ?> Rupiah</td>
    </tr>
  </tbody>
</table>
	
	
	<table width="100%" cellpadding="5px" border="0">
  <tbody>
    <tr>
      <td width="3%">2.</td>
      <td width="97%">Tanggal Barang diterima (paling lambat): 
		  <?php echo tanggal_indo($DATA_IDENTITAS['kontrak_tgl_akhir'],true); ?></td>
    </tr>
    <tr>
      <td>3.</td>
      <td>Syarat-syarat pekerjaan : sesuai dengan persyaratan dan ketentuan kontrak</td>
    </tr>
    <tr>
      <td>4.</td>
      <td>Waktu penyelesaian selama <?php echo $DATA_IDENTITAS['kontrak_jangka_waktu']; ?> (<?php echo Terbilang($DATA_IDENTITAS['kontrak_jangka_waktu']) ?>) hari kalender dan pekerjaan harus sudah selesai pada tanggal <?php echo tanggal_indo($DATA_IDENTITAS['kontrak_tgl_akhir'],true); ?></td>
    </tr>
    <tr>
      <td>5.</td>
      <td>Alamat Pengiriman Barang</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>RSUD Ajibarang Jl. Raya Pancasan - Ajibarang Kode Pos 53163 Banyumas</td>
    </tr>
    <tr>
      <td valign="top">6</td>
      <td>Denda : Terhadap setiap hari keterlambatan penyelesaian pekerjaan penyedia akan dikenakan denda keterlambatan sebesar 1/1000 (satu perseribu) dari nilai kontrak sebelum PPN sesuai dengan persyaratan dan ketentuan kontrak.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>

	

<table width="100%" border="0">
  <tbody>
    <tr>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr>
      <td width="50%">&nbsp;</td>
      <td width="50%" align="right">Ajibarang, <?php echo tanggal_indo(date('Y-m-d'),true); ?></td>
    </tr>
    <tr>
      <td colspan="2" style="text-align: center">Menerima dan menyetujui:</td>
    </tr>
    <tr>
      <td style="text-align: center">Untuk dan atas nama</td>
      <td style="text-align: center">Untuk dan atas nama</td>
    </tr>
    <tr>
      <td style="text-align: center">RSUD Ajibarang</td>
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
      <td style="text-align: center"><?php echo $DATA_IDENTITAS['ppk']; ?></td>
      <td style="text-align: center"><?php echo $DATA_IDENTITAS['nama_pj']; ?></td>
    </tr>
    <tr>
      <td style="text-align: center">NIP. <?php echo $DATA_IDENTITAS['nip_ppk']; ?></td>
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
$dompdf->stream('laporanpengeluaran.pdf',array('Attachment' => 0));
?>

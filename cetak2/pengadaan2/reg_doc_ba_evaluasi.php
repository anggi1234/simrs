<?php
ob_start();
session_start();
include('../connect.php');
$id_pengadaan_pesanan_barang_masuk = $_GET['id_pengadaan_pesanan_barang_masuk'];

$sqldasarpelaksanaan="SELECT kepdir,perbup FROM pengadaan_dasar_pelaksanaan";
$querydasarpelaksanaan = mysql_query($sqldasarpelaksanaan);
$DATA_DASAR_PELAKSANAAN = mysql_fetch_array($querydasarpelaksanaan);


$sqlidentitas="SELECT 
    a.jumlah_bruto,
    a.jumlah_ppn + a.jumlah_pph AS potongan,
    a.jumlah_ppn,
    a.jumlah_pph,
    a.jumlah_netto,
    b.nama_rekening,
    a.kode_rekening,
    c.nama_supplier,
    c.alamat,
    c.nama_pj,
    c.posisi,
    c.npwp,
    h.pd_nickname AS pphp,
    h.nip AS nip_pphp,
    j.pd_nickname AS pp,
    j.nip AS nip_pp,
    a.sp_no,
    DATE_FORMAT(a.sp_tgl, '%d-%m-%Y') AS sp_tgl,
    a.bapem_no,
    a.tahun_anggaran,
    DAY(a.ba_pemasukan_tgl) AS tgl_penawaran,
    YEAR(a.ba_pemasukan_tgl) AS tahun_penawaran,
    DATE_FORMAT(a.ba_pemasukan_tgl, '%d-%m-%Y') AS tanggal,
    CASE
        WHEN MONTH(a.ba_pemasukan_tgl) = 1 THEN 'Januari'
        WHEN MONTH(a.ba_pemasukan_tgl) = 2 THEN 'Februari'
        WHEN MONTH(a.ba_pemasukan_tgl) = 3 THEN 'Maret'
        WHEN MONTH(a.ba_pemasukan_tgl) = 4 THEN 'April'
        WHEN MONTH(a.ba_pemasukan_tgl) = 5 THEN 'Mei'
        WHEN MONTH(a.ba_pemasukan_tgl) = 6 THEN 'Juni'
        WHEN MONTH(a.ba_pemasukan_tgl) = 7 THEN 'Juli'
        WHEN MONTH(a.ba_pemasukan_tgl) = 8 THEN 'Agustus'
        WHEN MONTH(a.ba_pemasukan_tgl) = 9 THEN 'September'
        WHEN MONTH(a.ba_pemasukan_tgl) = 10 THEN 'Oktober'
        WHEN MONTH(a.ba_pemasukan_tgl) = 11 THEN 'November'
        WHEN MONTH(a.ba_pemasukan_tgl) = 12 THEN 'Desember'
    END AS bulan_penawaran,
    a.ba_evaluasi_no,
	a.no_pesanan
FROM
    simrs.pengadaan_pesanan_masuk a
        LEFT JOIN
    simrs.master_rekening b ON a.id_rekening = b.id_rekening
        LEFT JOIN
    simrs.master_supplier c ON a.id_supplier = c.id_master_supplier
        LEFT JOIN
    simrs.master_login h ON b.pphp_uid = h.uid
            LEFT JOIN
    simrs.master_rekening3 e ON e.id_master_rekening3 = b.id_master_rekening3
        LEFT JOIN
    simrs.master_login j ON b.pp_uid = j.uid
    
WHERE
    a.id_pengadaan_pesanan_barang_masuk = '$id_pengadaan_pesanan_barang_masuk'";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

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
			return $hari[$num] . ' ' . $tgl_indo;
		}
		return $tgl_indo;
	}


function hari_indo($tanggal, $cetak_hari = false)
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
			return $hari[$num];
		}
		return $tgl_indo;
	}


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Berita Acara Evaluasi</title>
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
	.normal { 
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
	<div style="font-size: 14px"><center>
		<strong>BERITA ACARA<br>EVALUASI PENAWARAN DAN KUALIFIKASI
	  </strong>
	</center></div><br>
	
	<div style="font-size: 14px"><center>
		<strong>Pekerjaan <?php echo $DATA_IDENTITAS['nama_rekening']; ?><br>Pada RSUD Ajibarang T.A. <?php echo $DATA_IDENTITAS['tahun_anggaran']; ?></strong>
	</center></div>
	<center>
	NOMOR: <?php echo $DATA_IDENTITAS['ba_evaluasi_no']; ?>
	</center>
	
	
	<div style="text-align: justify">Pada hari ini, <?php echo hari_indo($DATA_IDENTITAS['ba_pemasukan_tgl'],true); ?> tanggal <?php echo Terbilang($DATA_IDENTITAS['tgl_penawaran']) ?> <?php echo $DATA_IDENTITAS['bulan_penawaran']; ?> <?php echo Terbilang($DATA_IDENTITAS['tahun_penawaran']) ?> (<?php echo $DATA_IDENTITAS['tanggal']; ?>) bertempat di Ruang Pengadaan Rumah Sakit Umum Daerah Ajibarang Kabupaten Banyumas, telah diadakan evaluasi penawaran dan kualifikasi pengadaan langsung pekerjaan <?php echo $DATA_IDENTITAS['nama_rekening']; ?>, kegiatan <?php echo $DATA_IDENTITAS['sub_kegiatan']; ?></div>
	
	<br>
	
<table width="100%" style="text-align: justify" border="0">
  <tbody>
    <tr>
      <td colspan="5">DASAR PELAKSANAAN</td>
    </tr>
    <tr>
      <td width="3%">&nbsp;</td>
      <td width="3%" valign="top">1.</td>
      <td colspan="3" >Peraturan Presiden Republik Indonesia Nomor 16 Tahun 2018 tentang Pengadaan Barang/Jasa yang persiapan dan pelaksanaan dilakukan sebelum tanggal 1 Juli 2018 dapat dilakukan berdasarkan Peraturan Presiden Nomor 54 Tahun 2010 tentang Pengadaan Barang/Jasa Pemerintah sebagaimana telah beberapa kali diubah, terakhir dengan Peraturan Presiden Nomor 4 Tahun 2015 tentang Perubahan Keempat atas Peraturan Presiden Nomor 54 Tahun 2010 tentang Pengadaan Barang/Jasa Pemerintah.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">2.</td>
      <td colspan="3"><?php echo $DATA_DASAR_PELAKSANAAN['perbup']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">3.</td>
      <td colspan="3"><?php echo $DATA_DASAR_PELAKSANAAN['kepdir']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">4.</td>
      <td colspan="3">Dokumen <?php echo $DATA_IDENTITAS['sub_kegiatan']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">5.</td>
      <td colspan="3">Surat Perintah Pengadaan Langsung dari Pejabat Pembuat Komitmen Nomor : <?php echo $DATA_IDENTITAS['no_pesanan']; ?></td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5">Evaluasi dokumen penawaran dan kualifikasi dilakukan oleh Pejabat <?php echo $DATA_IDENTITAS['sub_kegiatan']; ?></td>
    </tr>
    <tr>
      <td>1.</td>
      <td colspan="4">Evaluasi administrasi dilakukan terhadap:</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>A.</td>
      <td colspan="3">Penawaran dinyatakan memenuhi persyaratan administrasi, apabila:</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="2%">1)</td>
      <td colspan="2">Surat penawaran memenuhi persyaratan ketentuan sebagai berikut:</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="2%" valign="top">a)</td>
      <td width="90%">ditandatangani oleh direktur/ penerima kuasa dari direktur/ pihak lain yang bukan direktur utama/ pimpinan perusahaan/ pengurus koperasi yang namanya tidak tercantum dalam akta pendirian/ anggaran dasar, sepanjang pihak lain tersebut adalah pengurus/ karyawan perusahaan/ karyawan koperasi yang berstatus sebagai tenaga kerja tetap dan mendapat kuasa atau pendelegasian wewenang yang sah dari direktur utama/ pimpinan perusahaan/ pengurus koperasi berdasarkan akta pendirian/ anggaran dasar/ kepala cabang perusahaan yang diangkat oleh kantor pusat .</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>b)</td>
      <td>mencantumkan penawaran harga;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>c)</td>
      <td>Jangka waktu berlakunya surat penawaran tidak kurang dari waktu sebagaimana tercantum dalam LDP;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>d)</td>
      <td>jangka waktu pelaksanaan pekerjaan yang ditawarkan tidak melebihi jangka waktu sebagaimana tercantum dalam LDP;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>e)</td>
      <td>Bertanggal</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>2)</td>
      <td colspan="2">Pejabat Pengadaan dapat melakukan klarifikasi terhadap hal-hal yang kurang jelas dan meragukan;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>B.</td>
      <td colspan="3">Apabila penyedia tidak memenuhi persyaratan administrasi, Pejabat Pengadaan menyatakan Pengadaan Langsung gagal, dan mengundang penyedia lain.</td>
    </tr>
    <tr>
      <td>2.</td>
      <td colspan="4">Evaluasi Teknis</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>1)</td>
      <td colspan="3">penyedia yang memenuhi persyaratan administrasi;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>2)</td>
      <td colspan="3"> unsur-unsur yang dievaluasi teknis sesuai dengan yang ditetapkan sebagaimana yang tercantum di spesifikasi; </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>3)</td>
      <td colspan="3"> evaluasi teknis dilakukan dengan sistem gugur;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>4)</td>
      <td colspan="3">Pejabat Pengadaan menilai persyaratan teknis minimal yang harus dipenuhi sebagaimana tercantum di spesifikasi;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>5)</td>
      <td colspan="3">Penilaian syarat teknis minimal dilakukan terhadap:</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td valign="top">a)</td>
      <td colspan="2">spesifikasi teknis barang yang ditawarkan berdasarkan contoh, brosur dan gambar-gambar yang memuat identitas barang ( jenis, tipe dan merek) </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td valign="top">b)</td>
      <td colspan="2">jangka waktu jadwal waktu pelaksanaan pekerjaan dan/atau jadwal serah terima pekerjaan (dalam hal serah terima pekerjaan dilakukan per termin) sebagaimana tercantum dalam LDP; </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td valign="top">c)</td>
      <td colspan="2"> layanan purna jual (apabila dipersyaratkan);</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td valign="top">d)</td>
      <td colspan="2">Tenaga teknis operasional/ penggunaan barang (apabila dipersyaratkan); dan</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td valign="top">e)</td>
      <td colspan="2">bagian pekerjaan yang akan disubkontrakkan sebagaimana tercantum dalam LDP.</td>
    </tr>
    <tr>
      <td>3.</td>
      <td colspan="4">Evaluasi Harga</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">1)</td>
      <td colspan="3">Unsur-unsur yang perlu dievaluasi adalah hal-hal yang pokok atau penting, dengan ketentuan harga satuan penawaran yang nilainya lebih besar dari 110% (seratus sepuluh perseratus) dari harga satuan yang tercantum dalam HPS, dilakukan klarifikasi. Apabila setelah dilakukan klarifikasi, ternyata harga satuan penawaran tersebut dinyatakan timpang maka harga satuan timpang hanya berlaku untuk volume sesuai dengan Daftar Kuantitas dan Harga. Jika terjadi penambahan volume, harga satuan yang berlaku sesuai dengan harga satuan dalam HPS.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">2)</td>
      <td colspan="3">harga penawaran terkoreksi yang melebihi nilai total HPS, dinyatakan gugur. Pejabat Pengadaan menyatakan Pengadaan Langsung gagal, dan mengundang penyedia lain.nsur-unsur yang perlu dievaluasi adalah hal-hal yang pokok atau penting, dengan ketentuan harga satuan penawaran yang nilainya lebih besar dari 110% (seratus sepuluh perseratus) dari harga satuan yang tercantum dalam HPS, dilakukan klarifikasi. Apabila setelah dilakukan klarifikasi, ternyata harga satuan penawaran tersebut dinyatakan timpang maka harga satuan timpang hanya berlaku untuk volume sesuai dengan Daftar Kuantitas dan Harga. Jika terjadi penambahan volume, harga satuan yang berlaku sesuai dengan harga satuan dalam HPS.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">3)</td>
      <td colspan="3">harga penawaran terkoreksi yang melebihi nilai total HPS, dinyatakan gugur. Pejabat Pengadaan menyatakan Pengadaan Langsung gagal, dan mengundang penyedia lain</td>
    </tr>
    <tr>
      <td>4.</td>
      <td colspan="4">Evaluasi kelengkapan dan keabsahan Pakta Integritas dan Formulir Isian Kualifikasi, meliputi:</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>a)</td>
      <td colspan="3">memiliki surat izin usaha sesuai LDP;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>b)</td>
      <td colspan="3">menyampaikan pernyataan/ pengakuan tertulis bahwa badan usaha yang bersangkutan dan manajemennya tidak dalam pengawasan pengadilan, tidak pailit, kegiatan usahanya tidak sedang dihentikan dan/ atau direksi yang bertindak untuk dan atas nama perusahaan tidak sedang dalam menjalani sanksi pidana;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>c)</td>
      <td colspan="3">salah satu dan/atau semua pengurus dan badan usahanya tidak masuk dalam daftar hitam;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>d)</td>
      <td colspan="3">memiliki NPWP dan telah memenuhi kewajiban perpajakan tahun pajak terakhir (SPT Tahunan) serta memiliki laporan bulanan PPh Pasal 21, PPh Pasal 23 (bila ada transaksi), PPh Pasal 25/Pasal 29 dan PPN (bagi Pengusaha Kena Pajak) paling kurang 3 (tiga) bulan terakhir dalam tahun berjalan. Penyedia dapat mengganti persyaratan ini dengan menyampaikan Surat Keterangan Fiskal (SKF) yang dikeluarkan oleh Kantor Pelayanan Pajak dengan tanggal penerbitan paling lama 1 (satu) bulan sebelum tanggal mulai emasukan Dokumen Kualifikasi.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>e)</td>
      <td colspan="3">memperoleh paling sedikit 1 (satu) pekerjaan sebagai penyedia jasa konsultansi dalam kurun waktu 4 (empat) tahun terakhir, baik di lingkungan pemerintah maupun swasta termasuk pengalaman subkontrak; </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>f)</td>
      <td colspan="3">memiliki kemampuan pada bidang pekerjaan yang sesuai</td>
    </tr>
  </tbody>
</table>
	
	
	
	<table width="100%" border="0">
  <tbody>
    <tr>
      <td>5.</td>
      <td colspan="3"> Ringkasan Hasil Evaluasi</td>
    </tr>
    <tr>
      <td width="3%">&nbsp;</td>
      <td colspan="3"><strong><?php echo $DATA_IDENTITAS['nama_supplier']; ?></strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">Nilai Penawaran Terkoreksi:</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>a)</td>
      <td>Administrasi </td>
      <td>: Memenuhi Syarat.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="3%">b)</td>
      <td width="16%">Teknis</td>
      <td width="78%">: Memenuhi Syarat.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>c)</td>
      <td>Harga</td>
      <td>: Memenuhi Syarat.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>d)</td>
      <td>Kualifikasi</td>
      <td>: Memenuhi Syarat.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>e)</td>
      <td>Klarifikasi</td>
      <td>: Memenuhi Syarat.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>f)</td>
      <td>Kesimpulan</td>
      <td>: Diusulkan sebagai Calon Pemenang</td>
    </tr>
    <tr>
      <td>6</td>
      <td colspan="3">Uraian Hasil Evaluasi Terlampir</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
	
<div>Demikian Berita Acara Evaluasi ini dibuat  untuk dapat dipergunakan sebagaimana mestinya.</div>
	<br>
	<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="24%" style="text-align: center">&nbsp;</td>
      <td width="47%" style="text-align: center">&nbsp;</td>
      <td width="29%" style="text-align: center">Pejabat <?php echo $DATA_IDENTITAS['sub_kegiatan']; ?></td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center"><u><?php echo $DATA_IDENTITAS['pp']; ?></u></td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">NIP.<?php echo $DATA_IDENTITAS['nip_pp']; ?></td>
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
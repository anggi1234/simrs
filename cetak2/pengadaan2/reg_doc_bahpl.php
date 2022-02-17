<?php
ob_start();
session_start();
include('../connect.php');


$id_pengadaan_pesanan_barang_masuk = $_GET['id_pengadaan_pesanan_barang_masuk'];

$sqlidentitas="SELECT 
    b.nama_rekening AS pekerjaan,
    a.tahun_anggaran,
    a.jumlah_netto,
    d.nama_supplier,
    d.nama_pj,
    d.posisi,
    e.pd_nickname AS pp,
    e.nip,
    d.posisi,
    a.ba_hpl_tgl,
    DATE_FORMAT(a.ba_hpl_tgl, '%d-%m-%Y') AS tanggal,
    DAY(a.ba_hpl_tgl) AS tgl_penawaran,
    YEAR(a.ba_hpl_tgl) AS tahun_penawaran,
    CASE
        WHEN MONTH(a.ba_hpl_tgl) = 1 THEN 'Januari'
        WHEN MONTH(a.ba_hpl_tgl) = 2 THEN 'Februari'
        WHEN MONTH(a.ba_hpl_tgl) = 3 THEN 'Maret'
        WHEN MONTH(a.ba_hpl_tgl) = 4 THEN 'April'
        WHEN MONTH(a.ba_hpl_tgl) = 5 THEN 'Mei'
        WHEN MONTH(a.ba_hpl_tgl) = 6 THEN 'Juni'
        WHEN MONTH(a.ba_hpl_tgl) = 7 THEN 'Juli'
        WHEN MONTH(a.ba_hpl_tgl) = 8 THEN 'Agustus'
        WHEN MONTH(a.ba_hpl_tgl) = 9 THEN 'September'
        WHEN MONTH(a.ba_hpl_tgl) = 10 THEN 'Oktober'
        WHEN MONTH(a.ba_hpl_tgl) = 11 THEN 'November'
        WHEN MONTH(a.ba_hpl_tgl) = 12 THEN 'Desember'
    END AS bulan_penawaran,
    a.ba_pemasukan_tgl,
    a.ba_pemasukan_no,
    a.ba_evaluasi_tgl,
    a.ba_evaluasi_no,
    a.ba_nego_tgl,
    a.ba_nego_no,
    a.pl_undangan_tgl,
    a.ba_nego_und_tgl,
    d.alamat,
    a.ba_hpl_no
FROM
    pengadaan_pesanan_masuk a
        LEFT JOIN
    master_rekening b ON a.id_rekening = b.id_rekening
        LEFT JOIN
    master_supplier d ON a.id_supplier = d.id_master_supplier
        LEFT JOIN
    master_login e ON b.pp_uid = e.uid
WHERE
    a.id_pengadaan_pesanan_barang_masuk = '$id_pengadaan_pesanan_barang_masuk'";
$queryidentitas = mysql_query($sqlidentitas);
$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

$sqldasarpelaksanaan="SELECT kepdir,perbup FROM pengadaan_dasar_pelaksanaan";
$querydasarpelaksanaan = mysql_query($sqldasarpelaksanaan);
$DATA_DASAR_PELAKSANAAN = mysql_fetch_array($querydasarpelaksanaan);


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


function tgl_indo($tanggal, $cetak_hari = false)
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
<title>BAHPL</title>
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
	
	<center>
	  <strong>BERITA ACARA<br>
		HASIL PENGADAAN LANGSUNG (BAHPL)</strong>
	</center>
	<br>
	<center>NOMOR: <?php echo $DATA_IDENTITAS['ba_hpl_no']; ?></center>
	<br>
	
		<div style="text-align: justify">Pada hari ini, <?php echo hari_indo($DATA_IDENTITAS['ba_nego_tgl'],true); ?> tanggal <?php echo Terbilang($DATA_IDENTITAS['tgl_penawaran']) ?> <?php echo $DATA_IDENTITAS['bulan_penawaran']; ?> <?php echo Terbilang($DATA_IDENTITAS['tahun_penawaran']) ?> (<?php echo $DATA_IDENTITAS['tanggal']; ?>) kami yang bertanda tangan dibawah ini, pejabat <?php echo $DATA_IDENTITAS['sub_kegiatan']; ?> RSUD Ajibarang Kabupaten Banyumas telah melaksanakan evaluasi penawaran pengadaan langsung pekerjaan <?php echo $DATA_IDENTITAS['pekerjaan']; ?></div>
	
	<br>
	
	
	<table width="100%" style="text-align: justify" border="0">
  <tbody>
    <tr>
      <td colspan="4">DASAR PELAKSANAAN</td>
    </tr>
    <tr>
      <td width="4%">&nbsp;</td>
      <td width="3%" valign="top">1.</td>
      <td colspan="2"><?php echo $DATA_DASAR_PELAKSANAAN['kepdir']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>2.</td>
      <td colspan="2">Berita Acara Pembukaan Penawaran Nomor : <?php echo $DATA_IDENTITAS['ba_pemasukan_no']; ?>, tanggal <?php echo tgl_indo($DATA_IDENTITAS['ba_pemasukan_tgl'],true); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>3.</td>
      <td colspan="2">Berita Acara Evaluasi Penawaran Nomor : <?php echo $DATA_IDENTITAS['ba_evaluasi_no']; ?>, tanggal <?php echo tgl_indo($DATA_IDENTITAS['ba_evaluasi_tgl'],true); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>4.</td>
      <td colspan="2">Berita Acara Klarifikasi dan NegosiasiNomor : <?php echo $DATA_IDENTITAS['ba_nego_no']; ?>, tanggal <?php echo tgl_indo($DATA_IDENTITAS['ba_nego_tgl'],true); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">Hasil Pengadaan Langsung adalah sebagai berikut :</td>
    </tr>
    <tr>
      <td>I.</td>
      <td colspan="3">Jadwal Pengadaan</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>1.</td>
      <td width="38%">Undangan</td>
      <td width="55%">: <?php echo tgl_indo($DATA_IDENTITAS['pl_undangan_tgl'],true); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>2.</td>
      <td>Pemasukan dan Pembukaan Penawaran</td>
      <td>: <?php echo tgl_indo($DATA_IDENTITAS['ba_nego_und_tgl'],true); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>3.</td>
      <td>Evaluasi Penawaran</td>
      <td>: <?php echo tgl_indo($DATA_IDENTITAS['ba_evaluasi_tgl'],true); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>4.</td>
      <td>Klarifikasi dan Negosiasi</td>
      <td>: <?php echo tgl_indo($DATA_IDENTITAS['ba_nego_tgl'],true); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>II.</td>
      <td colspan="3">Pejabat Pengadaan: <?php echo $DATA_IDENTITAS['pekerjaan']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>III.</td>
      <td colspan="3">Hasil Evaluasi</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">Uraian Hasil Evaluasi dokumentasi penawaran adalah sebagai berikut :</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><?php echo $DATA_IDENTITAS['pekerjaan']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">Nilai HPS : Rp <?php echo number_format($DATA_IDENTITAS['jumlah_netto'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">Nilai Penawaran Terkoreksi</td>
      <td> Rp <?php echo number_format($DATA_IDENTITAS['jumlah_netto'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">a) Administrasi</td>
      <td> : Lengkap/Benar</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">b) Teknis</td>
      <td> : Lengkap/Benar</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">c) Harga</td>
      <td> : Wajar</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">d) Kualifikasi</td>
      <td>: Lengkap/Benar</td>
    </tr>
    <tr>
      <td>&nbsp; </td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>IV.</td>
      <td colspan="3">Klarifikasi dan Negosiasi Harga</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">Dari harga penawaran yang masukkan dilakukan klarifikasi dan negosiasi harga dengan hasil sebagai berikut:</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">Nilai Penawaran Terkoreksi</td>
      <td>Rp <?php echo number_format($DATA_IDENTITAS['jumlah_netto'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">Nilai Negosiasi disepakati</td>
      <td>Rp <?php echo number_format($DATA_IDENTITAS['jumlah_netto'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>V.</td>
      <td colspan="2">Hasil Pengadaan Langsung</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">Berdasarkan hasil evaluasi administrasi, teknis, harga, kualifikasi, dan negosiasi harga Pengadaan Langsung <?php echo $DATA_IDENTITAS['pekerjaan']; ?> RSUD Ajibarang Kabupaten Banyumas, Pejabat Pengadaan menunjuk <?php echo $DATA_IDENTITAS['nama_supplier']; ?> yang beralamat di <?php echo $DATA_IDENTITAS['alamat']; ?> untuk melaksanakan pekerjaan <?php echo $DATA_IDENTITAS['pekerjaan']; ?> dengan nilai harga disepakati Rp.<?php echo number_format($DATA_IDENTITAS['jumlah_netto'], 0,",","."); ?>,-</td>
    </tr>
    </tbody>
</table>
	<br><br>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="25%" style="text-align: center">&nbsp;</td>
      <td width="43%" style="text-align: center">&nbsp;</td>
      <td width="32%" style="text-align: center">Pejabat Pengadaan <?php echo $DATA_IDENTITAS['pekerjaan']; ?></td>
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
      <td style="text-align: center">NIP.<?php echo $DATA_IDENTITAS['nip']; ?></td>
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
$dompdf->stream('BAHPL.pdf',array('Attachment' => 0));
?>
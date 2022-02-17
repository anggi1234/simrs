<?php
ob_start();
session_start();
include('../connect.php');
$id_pengadaan_pesanan_barang_masuk = $_GET['id_pengadaan_pesanan_barang_masuk'];

$sqlidentitas="SELECT 
    b.nama_rekening AS pekerjaan,
    a.tahun_anggaran,
    a.jumlah_netto,
    a.jumlah_netto,
    d.nama_supplier,
    d.nama_pj,
    d.posisi,
    e.pd_nickname AS pp,
    e.nip,
    d.posisi,
    a.ba_nego_tgl,
    DATE_FORMAT(a.ba_nego_tgl, '%d-%m-%Y') AS tanggal,
    DAY(a.ba_nego_tgl) AS tgl_penawaran,
    YEAR(a.ba_nego_tgl) AS tahun_penawaran,
    CASE
        WHEN MONTH(a.ba_nego_tgl) = 1 THEN 'Januari'
        WHEN MONTH(a.ba_nego_tgl) = 2 THEN 'Februari'
        WHEN MONTH(a.ba_nego_tgl) = 3 THEN 'Maret'
        WHEN MONTH(a.ba_nego_tgl) = 4 THEN 'April'
        WHEN MONTH(a.ba_nego_tgl) = 5 THEN 'Mei'
        WHEN MONTH(a.ba_nego_tgl) = 6 THEN 'Juni'
        WHEN MONTH(a.ba_nego_tgl) = 7 THEN 'Juli'
        WHEN MONTH(a.ba_nego_tgl) = 8 THEN 'Agustus'
        WHEN MONTH(a.ba_nego_tgl) = 9 THEN 'September'
        WHEN MONTH(a.ba_nego_tgl) = 10 THEN 'Oktober'
        WHEN MONTH(a.ba_nego_tgl) = 11 THEN 'November'
        WHEN MONTH(a.ba_nego_tgl) = 12 THEN 'Desember'
    END AS bulan_penawaran,
    a.ba_nego_no
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
<title>BA NEGO</title>
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
	  <strong>BERITA ACARA <br> KLARIFIKASI DAN NEGOSIASI TEKNIS DAN BIAYA</strong>
	</center>
	</div>
	<br>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="17%">Nomor</td>
      <td width="4%">:</td>
      <td width="79%"><?php echo $DATA_IDENTITAS['ba_nego_no']; ?></td>
    </tr>
    <tr>
      <td>Pekerjaan</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['pekerjaan']; ?></td>
    </tr>
    <tr>
      <td>Lokasi</td>
      <td>:</td>
      <td>RSUD Ajibarang Kab. Banyumas</td>
    </tr>
    <tr>
      <td>Anggaran</td>
      <td>:</td>
      <td>Anggaran BLUD RSUD Ajibarang Kab. Banyumas T.A. <?php echo $DATA_IDENTITAS['tahun_anggaran']; ?></td>
    </tr>
  </tbody>
</table>
	<hr>
	
	<div style="text-align: justify">Pada hari ini, <?php echo hari_indo($DATA_IDENTITAS['ba_nego_tgl'],true); ?> tanggal <?php echo Terbilang($DATA_IDENTITAS['tgl_penawaran']) ?> <?php echo $DATA_IDENTITAS['bulan_penawaran']; ?> <?php echo Terbilang($DATA_IDENTITAS['tahun_penawaran']) ?> (<?php echo $DATA_IDENTITAS['tanggal']; ?>) bertempat di Ruang Pengadaan Rumah Sakit Umum Daerah Ajibarang Kabupaten Banyumas, telah diadakan evaluasi penawaran dan kualifikasi pengadaan langsung pekerjaan <?php echo $DATA_IDENTITAS['nama_rekening']; ?>, kegiatan <?php echo $DATA_IDENTITAS['sub_kegiatan']; ?></div>
	
	<br>
	<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="4%">1.</td>
      <td colspan="3">Hadir dalam rapat:</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="3%">1.1</td>
      <td width="93%" colspan="2">Pejabat Pengadaan Obat dan Bahan Farmasi</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>1.2</td>
      <td colspan="2">Penyedia barang/jasa:</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2"><strong><?php echo $DATA_IDENTITAS['nama_supplier']; ?></strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>2.</td>
      <td colspan="3">Hasil Rapat</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">1.1</td>
      <td colspan="2">Rapat dipimpin oleh Pejabat <?php echo $DATA_IDENTITAS['sub_kegiatan']; ?> dan dibuka pada pukul 10.00 WIB.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>1.2</td>
      <td colspan="2">Kemudian dilanjutkan dengan pembukaan surat penawaran yang diajukan oleh :</td>
    </tr>
    </tbody>
</table>
	
	<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="4%" rowspan="2" align="center">No</td>
      <td width="31%" rowspan="2" align="center">Rekanan</td>
      <td width="26%" rowspan="2" align="center">Pekerjaan</td>
      <td width="17%" rowspan="2" align="center">Harga Penawaran</td>
      <td colspan="2" align="center">Syarat</td>
    </tr>
    <tr>
      <td width="11%" align="center">Adm</td>
      <td width="11%" align="center">Teknis</td>
    </tr>
    <tr>
      <td>1.</td>
      <td><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
      <td><?php echo $DATA_IDENTITAS['pekerjaan']; ?></td>
      <td align="right">Rp <?php echo number_format($DATA_IDENTITAS['jumlah_netto'], 0,",","."); ?></td>
      <td align="center">Sah</td>
      <td align="center">Sah</td>
    </tr>
  </tbody>
</table>

<br>
	<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="4%">&nbsp;</td>
      <td width="3%">1.3</td>
      <td colspan="2">Evaluasi, Klarifikasi dan negosiasi surat penawaran dengan pertimbangan :</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="2%" valign="top">-</td>
      <td width="91%">Penawaran yang diajukan baik secara teknis maupun administratif memenuhi syarat dan sesuai dengan ketentuan yang berlaku.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="2%" valign="top">-</td>
      <td width="91%">Harga tersebut wajar dan tidak melebihi dana yang tersedia</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>1.4</td>
      <td colspan="2">Hasil Negosiasi harga sebagai berikut :</td>
    </tr>
  </tbody>
</table>	
	
	
	
	<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="6%" align="center">No</td>
      <td width="33%" align="center">Rekanan</td>
      <td width="20%" align="center">Harga Penawaran</td>
      <td width="18%" align="center">Harga Negosiasi</td>
      <td width="23%" align="center">Mengetahui/Setuju harga Negosiasi</td>
    </tr>
    <tr>
      <td style="padding: 20px">1.</td>
      <td><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
      <td align="right">Rp <?php echo number_format($DATA_IDENTITAS['jumlah_netto'], 0,",","."); ?></td>
      <td align="right">Rp <?php echo number_format($DATA_IDENTITAS['jumlah_netto'], 0,",","."); ?></td>
      <td align="left">1.</td>
    </tr>
  </tbody>
</table>
	<br>
	<div style="text-align: justify">Demikian Berita Acara Klarifikasi dan Negosiasi Harga dan Teknis ini dibuat  untuk dapat dipergunakan sebagaimana mestinya.</div>
	
	
	
	<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="23%">&nbsp;</td>
      <td width="45%" align="right">&nbsp;</td>
      <td width="32%" align="right">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">Pejabat Pengadaan <?php echo $DATA_IDENTITAS['pekerjaan']; ?></td>
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
	
	
	<div class="pagebreak"></div>

<div style="font-size: 14px"><center>
	  <strong>DAFTAR HADIR</strong>
	</center>
</div>
	<br>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="20%" valign="top">RAPAT</td>
      <td width="2%" valign="top">:</td>
      <td width="78%">Klarifikasi dan Negosiasi Teknis dan Biaya Pekerjaan Belanja Persediaan Belanja Obat-Obatan Rumah Sakit</td>
    </tr>
    <tr>
      <td>HARI/TANGGAL</td>
      <td>:</td>
      <td><?php echo tanggal_indo($DATA_IDENTITAS['ba_nego_tgl'],true); ?></td>
    </tr>
    <tr>
      <td>WAKTU</td>
      <td>:</td>
      <td>10.00 WIB s/d Selesai</td>
    </tr>
    <tr>
      <td>TEMPAT</td>
      <td>:</td>
      <td>Ruang Pengadaan RSUD Ajibarang Kab. Banyumas </td>
    </tr>
  </tbody>
</table><br>
	<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="3%"><strong>No</strong></td>
      <td width="38%"><strong>NAMA</strong></td>
      <td width="34%"><strong>JABATAN</strong></td>
      <td width="25%"><strong>TANDATANGAN</strong></td>
    </tr>
    <tr>
      <td style="padding: 20px">1.</td>
      <td><?php echo $DATA_IDENTITAS['pp']; ?></td>
      <td>Pejabat Pengadaan <?php echo $DATA_IDENTITAS['pekerjaan']; ?></td>
      <td>1.</td>
    </tr>
    <tr>
      <td style="padding: 20px">2.</td>
      <td><?php echo $DATA_IDENTITAS['nama_pj']; ?></td>
      <td><?php echo $DATA_IDENTITAS['posisi']; ?></td>
      <td>2.</td>
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
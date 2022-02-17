<?php
ob_start();
session_start();
include('../connect.php');
$id_pengadaan_pesanan_barang_masuk = $_GET['id_pengadaan_pesanan_barang_masuk'];

$sqlidentitas="SELECT
	c.nama_supplier,
	time_format( a.tanggal_penawaran, '%h:%i' ) AS jam_penawaran,
	c.nama_pj,
	c.posisi,
	a.doc_surat_penawaran,
	a.doc_penawaran_teknis,
	a.doc_penawaran_harga,
	a.doc_pakta_integritas,
	a.doc_form_isian_kualifikasi,
	a.ket,
	d.nama_rekening AS kegiatan,
	b.ba_pemasukan_tgl,
	e.pd_nickname AS pp,
	e.nip
FROM
	pengadaan_pesanan_masuk_penawaran a
	LEFT JOIN pengadaan_pesanan_masuk b ON a.id_pengadaan_pesanan_barang_masuk = b.id_pengadaan_pesanan_barang_masuk
	LEFT JOIN master_supplier c ON a.id_supplier = c.id_master_supplier
	LEFT JOIN master_rekening d ON b.id_rekening = d.id_rekening
	LEFT JOIN master_login e ON e.uid = d.pp_uid
	where b.id_pengadaan_pesanan_barang_masuk = '$id_pengadaan_pesanan_barang_masuk'";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


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

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>DAFTAR HADIR REKANAN</title>
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
	.pagebreak { 
	page-break-before: always; 
	}
	.normal { 
	font-size: 12px; 
	}
</style>
</head>

<body>
	<div style="font-size: 14px"><center>
		<strong>DAFTAR REKANAN YANG MEMASUKKAN PENAWARAN<br>
	  </strong>
	</center></div><br>
	<center><?php echo $DATA_IDENTITAS['nama_rekening']; ?></center>
	<br>
	<div style="font-size: 12px"><center>
		Pada Hari, <?php echo tanggal_indo($DATA_IDENTITAS['ba_pemasukan_tgl'],true); ?>
	</center></div>
	<br>
	
	<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="5%">No.</td>
      <td width="34%" align="center">NAMA PT/CV</td>
      <td width="33%" align="center">JAM PEMASUKAN</td>
      <td width="28%" align="center">TANDA TANGAN</td>
    </tr>
    <tr>
      <td align="center">1.</td>
      <td style="padding: 30px;"><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
      <td align="center"><?php echo $DATA_IDENTITAS['jam_penawaran']; ?></td>
      <td align="center">&nbsp;</td>
    </tr>
  </tbody>
</table>
	
	
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	
	
	
	
	
	
	
	<div style="font-size: 14px"><center>
		<strong>DAFTAR HADIR REKANAN<br>PADA ACARA PEMBUKAAN PENAWARAN PEKERJAAN
	  </strong>
	</center></div><br>
	<center><center><?php echo $DATA_IDENTITAS['nama_rekening']; ?></center></center>
	<br>
	<div style="font-size: 12px"><center>
		Pada Hari, <?php echo tanggal_indo($DATA_IDENTITAS['ba_pemasukan_tgl'],true); ?>
	</center></div>
	<br>
	
	<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="5%">No.</td>
      <td width="34%" align="center">NAMA</td>
      <td width="33%" align="center">NAMA PT/CV</td>
      <td width="28%" align="center">TANDA TANGAN</td>
    </tr>
    <tr>
      <td align="center">1.</td>
      <td align="center" style="padding: 30px"><?php echo $DATA_IDENTITAS['nama_pj']; ?></td>
      <td align="center"><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
      <td align="center">&nbsp;</td>
    </tr>
  </tbody>
</table>
	

	<br><br><br><br>
	
	
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="50%" style="text-align: center">&nbsp;</td>
      <td width="50%" style="text-align: center">&nbsp;</td>
      <td width="50%" style="text-align: center">Pejabat Pengadaan <?php echo $DATA_IDENTITAS['kegiatan']; ?></td>
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
$dompdf->stream('laporanpengeluaran.pdf',array('Attachment' => 0));
?>
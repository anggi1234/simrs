<?php
ob_start();
session_start();
include('../connect.php');
$id_pengadaan_pesanan_barang_masuk = $_GET['id_pengadaan_pesanan_barang_masuk'];

$sqlidentitas="SELECT 
    c.nama_supplier,
    TIME_FORMAT(a.tanggal_penawaran, '%h:%i') AS jam_penawaran,
    c.alamat,
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
    e.nip,
    b.ba_pemasukan_tgl,
    b.tahun_anggaran,
    c.posisi
FROM
    pengadaan_pesanan_masuk_penawaran a
        LEFT JOIN
    pengadaan_pesanan_masuk b ON a.id_pengadaan_pesanan_barang_masuk = b.id_pengadaan_pesanan_barang_masuk
        LEFT JOIN
    master_supplier c ON a.id_supplier = c.id_master_supplier
        LEFT JOIN
    master_rekening d ON b.id_rekening = d.id_rekening
        LEFT JOIN
    master_login e ON e.uid = d.pp_uid
WHERE
    b.id_pengadaan_pesanan_barang_masuk = '$id_pengadaan_pesanan_barang_masuk'";
 $queryitem = mysql_query($sqlidentitas);
 $queryitem1 = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryitem1);


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
<title>Lampiran Berita Acara Pembukaan Penawaran</title>
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
		<strong>LAMPIRAN BERITA ACARA PEMBUKAAN PENAWARAN PENGADAAN BARANG/JASA<br>
			Pada RSUD Ajibarang Kab. Banyumas T.A.
	  </strong>
	</center></div><br><br>
	
	
<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="24%">NAMA PEKERJAAN</td>
      <td width="2%">:</td>
      <td width="74%"><?php echo $DATA_IDENTITAS['kegiatan']; ?> Rumah Sakit</td>
    </tr>
    <tr>
      <td>HARI/TANGGAL PEMBUKAAN</td>
      <td>:</td>
      <td><?php echo tanggal_indo($DATA_IDENTITAS['ba_pemasukan_tgl'],true); ?></td>
    </tr>
    <tr>
      <td>HPS</td>
      <td>:</td>
      <td>Rp <?php echo number_format($DATA_IDENTITAS['jumlah_total'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>TAHUN ANGGARAN</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['tahun_anggaran']; ?></td>
    </tr>
  </tbody>
</table>
	<br>
	
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="3%" rowspan="2" align="center">No</td>
      <td width="11%" rowspan="2" align="center">NAMA PT/CV</td>
      <td width="17%" rowspan="2" align="center">ALAMAT</td>
      <td colspan="6" align="center">KELENGKAPAN DOKUMEN PENAWARAN</td>
    </tr>
    <tr>
      <td width="10%" align="center" >SURAT PENAWARAN</td>
      <td width="10%" align="center">DOKUMEN PENAWARAN TEKNIS</td>
      <td width="10%" align="center">DOKUMEN PENAWARAN HARGA</td>
      <td width="11%" align="center">PAKTA INTEGRITAS</td>
      <td width="10%" align="center">FORMULIR ISIAN KUALIFIKASI</td>
      <td width="15%" align="center">KET</td>
    </tr>
    <?php
	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="9">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
	  echo '<td style="padding: 30px" align="center">'.$no.'.</td>';
	  echo '<td>'.$data['nama_supplier'].'</td>';
      echo '<td>'.$data['alamat']. '</td>';
			echo '<td align="center">'.$data['doc_surat_penawaran']. '</td>';
			echo '<td align="center">'.$data['doc_penawaran_teknis']. '</td>';
			echo '<td align="center">'.$data['doc_penawaran_harga']. '</td>';
			echo '<td align="center">'.$data['doc_pakta_integritas']. '</td>';
			echo '<td align="center">'.$data['doc_form_isian_kualifikasi']. '</td>';
			echo '<td align="center">'.$data['ket']. '</td>';
			echo '</tr>';
			$no++;
		}
	}
	?>
  </tbody>
</table>
	
	<br><br>
	
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="23%" style="text-align: center">Wakil Penyedia Barang/Jasa</td>
      <td width="50%" style="text-align: center">&nbsp;</td>
      <td width="27%" style="text-align: center">Pejabat Pengadaan <?php echo $DATA_IDENTITAS['kegiatan']; ?></td>
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
		<td style="text-align: center"><u><?php echo $DATA_IDENTITAS['nama_pj']; ?></u></td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center"><u><?php echo $DATA_IDENTITAS['pp']; ?></u></td>
    </tr>
    <tr>
      <td style="text-align: center"><?php echo $DATA_IDENTITAS['posisi']; ?></td>
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
$dompdf->set_paper($paper_size, 'landscape');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporanpengeluaran.pdf',array('Attachment' => 0));
?>
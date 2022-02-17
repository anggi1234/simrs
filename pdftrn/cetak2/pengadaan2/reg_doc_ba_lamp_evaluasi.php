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
	e.pd_nickname as pp,
	e.nip
FROM
	pengadaan_pesanan_masuk a
	LEFT JOIN master_rekening b ON a.id_rekening = b.id_rekening
    LEFT JOIN master_supplier d ON a.id_supplier = d.id_master_supplier
	LEFT JOIN master_login e ON b.pp_uid = e.uid
WHERE
	a.id_pengadaan_pesanan_barang_masuk = '$id_pengadaan_pesanan_barang_masuk'";
$queryidentitas = mysql_query($sqlidentitas);
$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Evaluasi Administrasi</title>
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
<div style="font-size: 14px"><center>
		<strong>EVALUASI ADMINISTRASI<br>
	  </strong>
	</center></div><br><br>
	
<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="28%">NAMA PEKERJAAN</td>
      <td width="2%">:</td>
      <td width="70%"><?php echo $DATA_IDENTITAS['pekerjaan']; ?></td>
    </tr>
    <tr>
      <td>SATUAN KERJA</td>
      <td>:</td>
      <td>RSUD Ajibarang</td>
    </tr>
    <tr>
      <td>TAHUN ANGGARAN</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['tahun_anggaran']; ?></td>
    </tr>
    <tr>
      <td>HPS</td>
      <td>:</td>
      <td>Rp <?php echo number_format($DATA_IDENTITAS['jumlah_total'], 0,",","."); ?></td>
    </tr>
  </tbody>
</table>
	<br>
	<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="5%" rowspan="2" align="center">No</td>
      <td width="19%" rowspan="2" align="center">NAMA PENAWAR</td>
      <td colspan="6" align="center">SURAT PENAWARAN</td>
    </tr>
    <tr>
      <td width="14%" align="center" >Di Tandatangani Oleh Direktur/Penerima Kuasa/Kepala Cabang</td>
      <td width="11%" align="center">Mencamtumkan Harga Penawaran</td>
      <td width="11%" align="center">Bertanggal</td>
      <td width="13%" align="center">Jangka Waktu Berlaku surat tidak kurang dari yang ditetapkan</td>
      <td width="13%" align="center">Jangka Waktu Pelaksanaan Pekerjaan yang ditawarkan tidak melebihi yang ditetapkan</td>
      <td width="14%" align="center">KET</td>
    </tr>
    <tr>
      <td align="center">1.</td>
      <td style="padding: 30px"><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
      <td align="center">+</td>
		<td align="center">+</td>
		<td align="center">+</td>
		<td align="center">+</td>
		<td align="center">+</td>
		<td align="center">MS</td>
    </tr>
  </tbody>
</table>
	<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="3">Keterangan:</td>
    </tr>
    <tr>
      <td width="6%">Tanda</td>
      <td width="5%">+</td>
      <td width="89%"> Ya / Ada / Sesuai</td>
    </tr>
    <tr>
      <td>Tanda</td>
      <td>-</td>
      <td>Tidak / Tidak Ada / Tidak Sesuai</td>
    </tr>
    <tr>
      <td>Tanda</td>
      <td>MS</td>
      <td>Memenuhi Syarat</td>
    </tr>
    <tr>
      <td>Tanda</td>
      <td>TMS</td>
      <td>Tidak Memenuhi Syarat</td>
    </tr>
  </tbody>
</table>
	
	
	<div class="pagebreak"></div>
	
	
	<div style="font-size: 14px"><center>
		<strong>EVALUASI TEKNIS<br>
	  </strong>
	</center></div><br><br>
	
<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="28%">NAMA PEKERJAAN</td>
      <td width="2%">:</td>
      <td width="70%"><?php echo $DATA_IDENTITAS['pekerjaan']; ?></td>
    </tr>
    <tr>
      <td>SATUAN KERJA</td>
      <td>:</td>
      <td>RSUD Ajibarang</td>
    </tr>
    <tr>
      <td>TAHUN ANGGARAN</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['tahun_anggaran']; ?></td>
    </tr>
    <tr>
      <td>HPS</td>
      <td>:</td>
      <td>Rp <?php echo number_format($DATA_IDENTITAS['jumlah_total'], 0,",","."); ?></td>
    </tr>
  </tbody>
</table>
	<br>
	<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="13%" rowspan="2" align="center">No</td>
      <td width="30%" rowspan="2" align="center">NAMA PENAWAR</td>
      <td colspan="3" align="center">EVALUASI TEKNIS</td>
    </tr>
    <tr>
      <td width="19%" align="center">Spesifikasi Teknis Barang yang ditawarkan</td>
      <td width="21%" align="center">Jangka waktu jadwal pelaksanaan pekerjaan dan/atau jadwal serah terima pekerjaan</td>
      <td width="17%" align="center">KET</td>
    </tr>
    <tr>
      <td align="center">1.</td>
      <td style="padding: 30px"><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
      <td align="center">+</td>
      <td align="center">+</td>
      <td width="17%" align="center">MS</td>
    </tr>
  </tbody>
</table>
	
	<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="3">Keterangan:</td>
    </tr>
    <tr>
      <td width="6%">Tanda</td>
      <td width="5%">+</td>
      <td width="89%"> Ya / Ada / Sesuai</td>
    </tr>
    <tr>
      <td>Tanda</td>
      <td>-</td>
      <td>Tidak / Tidak Ada / Tidak Sesuai</td>
    </tr>
    <tr>
      <td>Tanda</td>
      <td>MS</td>
      <td>Memenuhi Syarat</td>
    </tr>
    <tr>
      <td>Tanda</td>
      <td>TMS</td>
      <td>Tidak Memenuhi Syarat</td>
    </tr>
  </tbody>
</table>

	
	
	
	
	<div class="pagebreak"></div>
	
	
	<div style="font-size: 14px"><center>
		<strong>EVALUASI HARGA<br>
	  </strong>
	</center></div><br><br>
	
<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="28%">NAMA PEKERJAAN</td>
      <td width="2%">:</td>
      <td width="70%"><?php echo $DATA_IDENTITAS['pekerjaan']; ?></td>
    </tr>
    <tr>
      <td>SATUAN KERJA</td>
      <td>:</td>
      <td>RSUD Ajibarang</td>
    </tr>
    <tr>
      <td>TAHUN ANGGARAN</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['tahun_anggaran']; ?></td>
    </tr>
    <tr>
      <td>HPS</td>
      <td>:</td>
      <td>Rp <?php echo number_format($DATA_IDENTITAS['jumlah_netto'], 0,",","."); ?></td>
    </tr>
  </tbody>
</table>
	<br>
	<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="13%" rowspan="2" align="center">No</td>
      <td width="30%" rowspan="2" align="center">NAMA PENAWAR</td>
      <td colspan="3" align="center">KELENGKAPAN DOKUMEN PENAWARAN</td>
    </tr>
    <tr>
      <td width="19%" align="center">Nilai Penawaran</td>
      <td width="21%" align="center">Penawaran diatas HPS</td>
      <td width="17%" align="center">KET</td>
    </tr>
    <tr>
      <td align="center">1.</td>
      <td style="padding: 30px"><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
      <td align="center">Rp <?php echo number_format($DATA_IDENTITAS['jumlah_netto'], 0,",","."); ?></td>
      <td align="center">-</td>
      <td align="center" width="17%">MS</td>
    </tr>
  </tbody>
</table>
	<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="3">Keterangan:</td>
    </tr>
    <tr>
      <td width="6%">Tanda</td>
      <td width="5%">+</td>
      <td width="89%"> Ya / Ada / Sesuai</td>
    </tr>
    <tr>
      <td>Tanda</td>
      <td>-</td>
      <td>Tidak / Tidak Ada / Tidak Sesuai</td>
    </tr>
    <tr>
      <td>Tanda</td>
      <td>MS</td>
      <td>Memenuhi Syarat</td>
    </tr>
    <tr>
      <td>Tanda</td>
      <td>TMS</td>
      <td>Tidak Memenuhi Syarat</td>
    </tr>
  </tbody>
</table>
	
	
	<div class="pagebreak"></div>
	
	
	
	<div style="font-size: 14px"><center>
		<strong>EVALUASI KUALIFIKASI<br>
	  </strong>
	</center></div><br><br>
	
<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="28%">NAMA PEKERJAAN</td>
      <td width="2%">:</td>
      <td width="70%"><?php echo $DATA_IDENTITAS['pekerjaan']; ?></td>
    </tr>
    <tr>
      <td>SATUAN KERJA</td>
      <td>:</td>
      <td>RSUD Ajibarang</td>
    </tr>
    <tr>
      <td>TAHUN ANGGARAN</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['tahun_anggaran']; ?></td>
    </tr>
    <tr>
      <td>HPS</td>
      <td>:</td>
      <td>Rp <?php echo number_format($DATA_IDENTITAS['jumlah_total'], 0,",","."); ?></td>
    </tr>
  </tbody>
</table>
	<br>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="4%" rowspan="2" align="center">No</td>
      <td width="23%" rowspan="2" align="center">NAMA PENAWAR</td>
      <td colspan="7" align="center">NILAI KUALIFIKASI</td>
    </tr>
    <tr>
      <td width="10%" align="center" >1</td>
      <td width="10%" align="center">2</td>
      <td width="10%" align="center">3</td>
      <td width="9%" align="center">4</td>
      <td width="9%" align="center">5</td>
      <td width="9%" align="center">6</td>
      <td width="16%" align="center">KET</td>
    </tr>
    <tr>
      <td align="center">1.</td>
      <td style="padding: 30px"><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
      <td align="center">+</td>
		<td align="center">+</td>
		<td align="center">+</td>
		<td align="center">+</td>
		<td align="center">+</td>
		<td align="center">+</td>
		<td align="center">MS</td>
    </tr>
  </tbody>
</table><br>
	<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="3">Keterangan:</td>
      <td colspan="3">Catatan :</td>
    </tr>
    <tr>
      <td width="4%">&nbsp;</td>
      <td width="3%">1</td>
      <td width="48%">Memiliki akta perusahaan</td>
      <td width="6%">Tanda</td>
      <td width="4%">+</td>
      <td width="35%"> Ya / Ada / Sesuai</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>2</td>
      <td>Memiliki SIUP</td>
      <td>Tanda</td>
      <td>-</td>
      <td>Tidak / Tidak Ada / Tidak Sesuai</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>3</td>
      <td>Surat Pernyataan Tidak Pailit</td>
      <td>Tanda</td>
      <td>MS</td>
      <td>Memenuhi Syarat</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>4</td>
      <td>Surat Pernyataan Tidak Masuk Daftar Hitam</td>
      <td>Tanda</td>
      <td>TMS</td>
      <td>Tidak Memenuhi Syarat</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>5</td>
      <td>NPWP dan Pajak 3 Bulan Terakhir</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>6</td>
      <td>Memiliki Kemampuan</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
	
	
	
	<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="22%" style="text-align: center">&nbsp;</td>
      <td width="51%" style="text-align: center">&nbsp;</td>
      <td width="27%" style="text-align: center">Pejabat Pengadaan <?php echo $DATA_IDENTITAS['pekerjaan']; ?></td>
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
$dompdf->set_paper($paper_size, 'landscape');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('ba_evaluasi.pdf',array('Attachment' => 0));
?>
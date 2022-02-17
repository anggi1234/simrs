<?php
ob_start();
session_start();
include('../connect.php');
$id_pengadaan_pesanan_barang_masuk = $_GET['id_pengadaan_pesanan_barang_masuk'];

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
    a.bapem_no,
    a.tahun_anggaran,
    a.ba_pemasukan_no,
    d.pd_nickname as pptk,
    d.nip,
	e.nama_rekening3
FROM
    simrs.pengadaan_pesanan_masuk a
        LEFT JOIN
    simrs.master_rekening b ON a.id_rekening = b.id_rekening
        LEFT JOIN
    simrs.master_rekening3 e ON e.id_master_rekening3 = b.id_master_rekening3
        LEFT JOIN
    simrs.master_supplier c ON a.id_supplier = c.id_master_supplier
        LEFT JOIN
    simrs.master_login d ON b.pp_uid = d.uid
WHERE
    a.id_pengadaan_pesanan_barang_masuk = '$id_pengadaan_pesanan_barang_masuk'";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqldasarpelaksanaan="SELECT kepdir FROM pengadaan_dasar_pelaksanaan";
$querydasarpelaksanaan = mysql_query($sqldasarpelaksanaan);
$DATA_DASAR_PELAKSANAAN = mysql_fetch_array($querydasarpelaksanaan);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Berita Acara Pemasukan dan Pembukaan Penawaran</title>
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
		PEMASUKAN DAN PEMBUKAAN PENAWARAN</strong>
	</center>
	<br>
	<center>NOMOR: <?php echo $DATA_IDENTITAS['ba_pemasukan_no']; ?></center>
	<br>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="17%">Pekerjaan</td>
      <td width="2%">:</td>
      <td width="81%"><?php echo $DATA_IDENTITAS['nama_rekening']; ?> Rumah Sakit</td>
    </tr>
    <tr>
      <td>Sumber Dana</td>
      <td>:</td>
      <td>Anggaran BLUD RSUD Ajibarang Kab. Banyumas T.A. <?php echo $DATA_IDENTITAS['tahun_anggaran']; ?></td>
    </tr>
    <tr>
      <td>HPS</td>
      <td>:</td>
      <td>Rp <?php echo number_format($DATA_IDENTITAS['jumlah_netto'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>Tahun Anggaran</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['tahun_anggaran']; ?></td>
    </tr>
  </tbody>
</table>

	
	<table width="100%" border="0" style="text-align: justify">
  <tbody>
    <tr>
      <td colspan="3">I. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DASAR PELAKSANAAN</td>
    </tr>
    <tr>
      <td width="2%">&nbsp;</td>
      <td valign="top">1. </td>
      <td>Peraturan Presiden Republik Indonesia Nomor 54 Tahun 2010 tentang Pengadaan Barang/ Jasa Pemerintah sebagaimana telah beberapa kali diubah terakhir dengan Peraturan Presiden Republik Indonesia Nomor 04 Tahun 2015 tentang Perubahan Keempat Atas Peraturan Presiden Republik Indonesia Nomor 54 Tahun 2010 tentang Pengadaan Barang/Jasa Pemerintah.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">2.</td>
      <td>Peraturan Bupati Banyumas Nomor 16 Tahun 2016 tentang Jenjang Nilai Pengadaan Barang / Jasa pada Badan Layanan Umum Daerah Rumah Sakit Umum Daerah Ajibarang</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">3.</td>
      <td><?php echo $DATA_DASAR_PELAKSANAAN['kepdir']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">4.</td>
      <td>Dokumen <?php echo $DATA_IDENTITAS['sub_kegiatan']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="96%">&nbsp;</td>
    </tr>
    <tr>
      <td>II.</td>
      <td colspan="2">PESERTA RAPAT</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">Unsur-unsur terkait:</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="2%">1.</td>
      <td width="96%">Pejabat <?php echo $DATA_IDENTITAS['sub_kegiatan']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="2%">2.</td>
      <td width="96%">Penyedia Barang/Jasa</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="96%">&nbsp;</td>
    </tr>
    <tr>
      <td>III.</td>
      <td colspan="2">SUSUNAN ACARA</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="2%">1.</td>
      <td width="96%">Pembukaan</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="96%">Pembukaan rapat disampaikan oleh Pejabat <?php echo $DATA_IDENTITAS['sub_kegiatan']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="2%">2.</td>
      <td width="96%">Pembukaan dan Pencatatan</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="96%">Pembukaan dokumen penawaran dimulai pukul 10.15 WIB. Hasil pembukaan dokumen</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="2%">3.</td>
      <td width="96%">Rapat ditutup pada pukul 11.30 WIB oleh Pejabat <?php echo $DATA_IDENTITAS['sub_kegiatan']; ?> Rumah Sakit</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="96%">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">Demikian Berita Acara ini dibuat  untuk dapat dipergunakan sebagaimana mestinya.</td>
    </tr>
  </tbody>
</table><br><br>
	
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="50%" style="text-align: center">Wakil Peserta</td>
      <td width="50%" style="text-align: center">&nbsp;</td>
      <td width="50%" style="text-align: center">Pejabat <?php echo $DATA_IDENTITAS['nama_rekening3']; ?></td>
    </tr>
    <tr>
      <td style="text-align: center"><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
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
      <td style="text-align: center"><u><?php echo $DATA_IDENTITAS['pptk']; ?></u></td>
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
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporanpengeluaran.pdf',array('Attachment' => 0));
?>
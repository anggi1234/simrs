<?php
ob_start();
session_start();
include('../connect.php');
$id_pengadaan_pesanan_barang_masuk = $_GET['id_pengadaan_pesanan_barang_masuk'];

$sqldasarpelaksanaan="SELECT kepdir FROM pengadaan_dasar_pelaksanaan";
$querydasarpelaksanaan = mysql_query($sqldasarpelaksanaan);
$DATA_DASAR_PELAKSANAAN = mysql_fetch_array($querydasarpelaksanaan);

$sqlidentitas="SELECT
	b.nama_rekening AS pekerjaan,
    c.nama_rekening3 as sub_kegiatan,
	a.tahun_anggaran,
	a.jumlah_netto,
	a.pl_perintah_no
FROM
	pengadaan_pesanan_masuk a
	LEFT JOIN master_rekening b ON a.id_rekening = b.id_rekening
    left join master_rekening3 c on c.id_master_rekening3=b.id_master_rekening3
WHERE
	a.id_pengadaan_pesanan_barang_masuk = $id_pengadaan_pesanan_barang_masuk";
$queryidentitas = mysql_query($sqlidentitas);
$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

$sqlppk="select nama_pejabat,nip,nama_jabatan,id_jabatan from master_jabatan where id_jabatan=3";
$queryppk = mysql_query($sqlppk);
$DATA_PPK = mysql_fetch_array($queryppk);


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
<title>Perintah PL</title>
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
<div align="right">Ajibarang, <?php echo tanggal_indo(date('Y-m-d'),true); ?></div>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="9%">Nomor</td>
      <td width="38%">: <?php echo $DATA_IDENTITAS['pl_perintah_no']; ?></td>
      <td width="21%">&nbsp;</td>
      <td width="32%">&nbsp;</td>
    </tr>
    <tr>
      <td>Lampiran</td>
      <td>: 1 Lembar</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Perihal</td>
      <td>: <u>Perintah Pengadaan Langsung</u></td>
      <td>&nbsp;</td>
      <td>Kepada Yth:</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Pejabat <?php echo $DATA_IDENTITAS['sub_kegiatan']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>RSUD Ajibarang, Kab. Banyumas</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>di-</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Ajibarang</u></td>
    </tr>
  </tbody>
</table><br><br><br>
<table width="100%" style="text-align: justify" border="0">
  <tbody>
    <tr>
      <td width="9%">&nbsp;</td>
      <td colspan="2">DASAR</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="2%" valign="top">1.</td>
      <td width="89%">Peraturan Presiden Republik Indonesia Nomor 54 Tahun 2010 tentang Pengadaan Barang/ Jasa Pemerintah sebagaimana telah beberapa kali diubah terakhir dengan Peraturan Presiden Republik Indonesia Nomor 04 Tahun 2015 tentang Perubahan Keempat Atas Peraturan Presiden Republik Indonesia Nomor 54 Tahun 2010 tentang Pengadaan Barang/Jasa Pemerintah.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">2.</td>
      <td>Peraturan Bupati Banyumas Nomor 16 Tahun 2016 tentang Jenjang Nilai Pengadaan Barang / Jasa pada Badan Layanan Umum Daerah Rumah Sakit Umum Daerah Ajibarang</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">3.</td>
      <td>Peraturan Direktur RSUD Ajibarang Kabupaten Banyumas Nomor 061 tahun 2016 tentang Pedoman Pengadaan Barang / Jasa pada Rumah Sakit Umum Daerah Ajibarang</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">4.</td>
      <td><?php echo $DATA_DASAR_PELAKSANAAN['kepdir']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">5.</td>
      <td>DPA/DPPA dan RBA BLUD RSUD Ajibarang Kabupaten Banyumas TA.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">Atas dasar hal tersebut di atas, dengan ini kami mohon untuk melaksanakan proses pengadaan barang/ jasa dengan metode pengadaan langsung dengan ketentuan sebagai </td>
    </tr>
  </tbody>
</table>
	
	<table width="100%" cellpadding="5px" border="0">
  <tbody>
    <tr>
      <td width="16%">Sub Kegiatan</td>
      <td width="74%">: Pejabat <?php echo $DATA_IDENTITAS['sub_kegiatan']; ?></td>
    </tr>
    <tr>
      <td>Pekerjaan</td>
      <td>: <?php echo $DATA_IDENTITAS['pekerjaan']; ?></td>
    </tr>
    <tr>
      <td>HPS</td>
      <td>: Rp <?php echo number_format($DATA_IDENTITAS['jumlah_netto'], 2,",","."); ?></td>
    </tr>
    <tr>
      <td colspan="2">Demikian untuk menjadikan maklum dan terima kasih atas kerjasamanya.</td>
    </tr>
  </tbody>
</table>


	
	<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="50%">&nbsp;</td>
      <td width="50%" align="right">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">Pejabat Pembuat Komitmen</td>
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
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center"><u><?php echo $DATA_PPK['nama_pejabat']; ?></u></td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">NIP.<?php echo $DATA_PPK['nip']; ?></td>
    </tr>
  </tbody>
</table>
	<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="3">Tembusan :</td>
    </tr>
    <tr>
      <td width="3%">1.</td>
      <td width="64%">Direktur</td>
      <td width="33%">&nbsp;</td>
    </tr>
    <tr>
      <td>2.</td>
      <td>Pejabat Pelaksana Teknis Kegiatan</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>3.</td>
      <td>Arsip (TU)</td>
      <td>&nbsp;</td>
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
$dompdf->stream('doc_pl.pdf',array('Attachment' => 0));
?>
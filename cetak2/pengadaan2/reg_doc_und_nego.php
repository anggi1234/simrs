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
	e.nip,
	d.posisi,
	a.ba_nego_und_tgl,
	a.ba_nego_und_no
FROM
	pengadaan_pesanan_masuk a
	LEFT JOIN master_rekening b ON a.id_rekening = b.id_rekening
	LEFT JOIN master_supplier d ON a.id_supplier = d.id_master_supplier
	LEFT JOIN master_login e ON b.pp_uid = e.uid
WHERE
	a.id_pengadaan_pesanan_barang_masuk = '$id_pengadaan_pesanan_barang_masuk'";
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
			return $hari[$num] . ' / ' . $tgl_indo;
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
      <td width="38%">: <?php echo $DATA_IDENTITAS['ba_nego_und_no']; ?></td>
      <td width="25%">&nbsp;</td>
      <td width="28%">&nbsp;</td>
    </tr>
    <tr>
      <td>Lampiran</td>
      <td>: 1 Lembar</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Perihal</td>
      <td>: Undangan Negosiasi Penawaran</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Kepada Yth:</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><strong><?php echo $DATA_IDENTITAS['posisi']; ?> <?php echo $DATA_IDENTITAS['nama_supplier']; ?></strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">di-</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><strong>TEMPAT</strong></u></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table><br><br><br>
<table width="100%" style="text-align: justify" border="0">
  <tbody>
    <tr>
      <td width="9%">&nbsp;</td>
      <td colspan="3">Dengan Hormat</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3" valign="top">Sehubungan dengan akan dilaksanakannya negosiasi penawaran, maka kami mengundang saudara untuk hadir pada negosiasi penawaran yang akan dilaksanakan pada :</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="12%" valign="top">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="78%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">Hari/Tanggal</td>
      <td>:</td>
      <td><?php echo tanggal_indo($DATA_IDENTITAS['ba_nego_und_tgl'],true); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">Pukul</td>
      <td>:</td>
      <td>10.00 WIB s/d Selesai</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">Tempat</td>
      <td>:</td>
      <td>Ruang Pengadaan RSUD Ajibarang</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3" valign="top">Demikian undangan dari kami astas kerjasamanya diucapkan terima kasih.</td>
    </tr>
  </tbody>
</table>

	
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
      <td>Pejabat Pembuat Komitmen (sebagai laporan)</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>3.</td>
      <td>Arsip</td>
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
$dompdf->stream('laporanpengeluaran.pdf',array('Attachment' => 0));
?>
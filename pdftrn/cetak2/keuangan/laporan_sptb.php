<?php
ob_start();
include('../connect.php');
session_start();

$id_spj_gu = $_GET['id_spj_gu'];

$sqlidentitas="SELECT 
    a.kode_sptb,
    f.kode_rekening AS 'kode_rekening2',
    f.nama_rekening2 AS 'nama_rekening2',
    e.kode_rekening AS 'kode_rekening3',
    e.nama_rekening3 AS 'nama_rekening3',
    b.tanggal_spm AS 'tanggal_spm',
    b.kode_spm AS 'kode_spm',
    d.kode_rekening AS 'kode_rekening',
    d.nama_rekening AS 'nama_rekening',
    b.total_netto AS 'total_netto',
    b.total_pajak AS 'total_pajak',
    c.pd_nickname AS 'nickname'
FROM
    simrs.keu_sptb a
        LEFT JOIN
    keu_spm b ON a.id_spm = b.id_spm
        LEFT JOIN
    master_login c ON a.uid = c.uid
        LEFT JOIN
    master_rekening d ON b.id_rekening = d.id_rekening
        LEFT JOIN
    master_rekening3 e ON d.id_master_rekening3 = e.id_master_rekening3
        LEFT JOIN
    master_rekening2 f ON e.id_master_rekening2 = f.id_master_rekening2
        LEFT JOIN
    master_rekening1 g ON f.id_master_rekening1 = g.id_master_rekening1";
 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas)

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan SPTB</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
		font-family: Gotham, Helvetica Neue, Helvetica, Arial," sans-serif";
		font-size: 11px;
	}
	
.tabelfix {
    border-collapse:collapse;
	font-size: 11px;
}
.footer {
	font-size: 12px;
}
.header {
	font-size: 15px;
}
	
</style>
</head>

<body>
	<table width="100%" border="0">
		<tr>
			<td width="10%" rowspan="4" align="right"><img src="../gambar/logobms.png" height="70px" /></td>
			<td width="90%" align="center" style="font-size: 14px"><strong>PEMERINTAH KABUPATEN BANYUMAS</strong></td>
		</tr>
		<tr>
		  <td align="center" style="font-size: 14px"><strong>RUMAH SAKIT UMUM DAERAH AJIBARANG</strong></td>
	  </tr>
		<tr>
			<td align="center"><strong style="font-size: 18px">SURAT PERNYATAAN TANGGUNGJAWAB BELANJA</strong></td>
		</tr>
		<tr>
			<td align="center" style="font-size: 14px">
				NOMOR : <?php echo $DATA_IDENTITAS['kode_sptb']; ?>
			</td>
		</tr>
	</table>

	<hr>

	<table width="100%" border="0">
		<tr>
			<td width="27%">Kode Kegiatan</td>
			<td width="1%">:</td>
			<td><?php echo $DATA_IDENTITAS['kode_rekening2']; ?></td>
		</tr>
		<tr>
			<td>Nama Kegiatan</td>
			<td>:</td>
			<td><?php echo $DATA_IDENTITAS['nama_rekening2']; ?></td>
		</tr>
		<tr>
			<td>Kode Sub Kegiatan</td>
			<td>:</td>
			<td><?php echo $DATA_IDENTITAS['kode_rekening3']; ?></td>
		</tr>
		<tr>
		  <td>Nama Sub Kegiatan</td>
		  <td>:</td>
		  <td><?php echo $DATA_IDENTITAS['nama_rekening3']; ?></td>
	  </tr>
		
	</table>

	<br>

	<table width="100%" border="0">
		<tr>
			<td width="100%">Yang bertandatangan dibawah ini menyatakan bahwa sya bertanggungjawab secara formal dan material dan kebenaran pemungutan pajak atas segala pembayaran tagihan yang telah kami perintahkan dalam SPM ini dengan perincian sebagai berikut :</td>
		</tr>
	</table>

	<br>
	<table width="100%" class="tabelfix" border="1">
		<tr>
		  <th colspan="2">Bukti</th>
		  <th width="13%" rowspan="2">Kode Rekening</th>
		  <th width="35%" rowspan="2">Uraian</th>
		  <th width="15%" rowspan="2">Jumlah</th>
		  <th width="15%" rowspan="2">Potongan Pajak</th>
	  </tr>
		<tr>
			<th width="12%">Tanggal</th>
			<th width="10%">Nomor</th>
		</tr>
		<tr>
			<td><?php echo $DATA_IDENTITAS['tanggal_spm']; ?></td>
			<td><?php echo $DATA_IDENTITAS['kode_spm']; ?></td>
			<td><?php echo $DATA_IDENTITAS['kode_rekening']; ?></td>
			<td><?php echo $DATA_IDENTITAS['nama_rekening']; ?></td>
			<td><?php echo number_format($DATA_IDENTITAS['total_netto'],0,",","."); ?></td>
			<td><?php echo number_format($DATA_IDENTITAS['total_pajak'],0,",","."); ?></td>
			
		</tr>
		<tr>
		  <td colspan="4" align="right"><strong>Jumlah Bukti Pengeluaran</strong></td>
		  <td><?php echo number_format($DATA_IDENTITAS['total_netto'],0,",","."); ?></td>
		  <td><?php echo number_format($DATA_IDENTITAS['total_pajak'],0,",","."); ?></td>
	  </tr>
	</table>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="7">Bukti - bukti pengeluaran anggaran dan asli setoran pajak tersebut diatas disimpan oleh Pengguna Anggaran/Kuasa Pengguna Anggaran untuk kelengkapan administrasi dan pemeriksaan aparat pengawasan fungsional.</td>
    </tr>
    <tr>
      <td width="5%">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td width="5%">&nbsp;</td>
      <td width="23%">&nbsp;</td>
      <td width="9%">&nbsp;</td>
      <td width="20%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="23%">&nbsp;</td>
      <td width="15%">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" align="center">Pemimpin BLUD</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" align="center">.....................</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" align="center">NIP.</td>
    </tr>
  </tbody>
</table>


</body>
</html>




<?php
$html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('Laporan_SPTB.pdf',array('Attachment' => 0));
?>
<?php
ob_start();
session_start();
include('../connect.php');
$nomor_pesanan = $_GET['no_pesanan'];

$sqlidentitas="SELECT
	a.jumlah_bruto,
	a.jumlah_ppn + a.jumlah_pph AS potongan,
	a.jumlah_ppn,
	a.jumlah_pph,
	a.jumlah_netto,
	b.nama_rekening,
	b.sub_kegiatan,
	a.kode_rekening,
	c.nama_supplier,
	c.alamat,
	c.nama_pj,
	c.posisi,
	C.npwp,
	d.pd_nickname AS pengguna_anggaran,
	d.nip AS nip_pengguna_anggaran,
	e.pd_nickname AS ppk,
	e.nip AS nip_ppk,
	f.pd_nickname AS pptk,
	f.nip AS nip_pptk,
	g.pd_nickname AS bendahara,
	g.nip AS nip_bendahara,
	h.pd_nickname AS pphp,
	h.nip as nip_pphp,
	a.sp_no,
	a.sp_tgl,
	a.tahun_anggaran,
	a.spk_no,
	a.spk_tgl,a.bapem_no
FROM
	simrs.pengadaan_pesanan_masuk a
	LEFT JOIN simrs.master_rekening b ON a.id_rekening = b.id_rekening
	LEFT JOIN simrs.master_supplier c ON a.id_supplier = c.id_master_supplier
	LEFT JOIN simrs.master_login d ON b.pa_uid = d.uid
	LEFT JOIN simrs.master_login e ON b.ppk_uid = e.uid
	LEFT JOIN simrs.master_login f ON b.pptk_uid = f.uid
	LEFT JOIN simrs.master_login g ON b.bp_uid = g.uid
	LEFT JOIN simrs.master_login h ON b.pphp_uid = h.uid
	LEFT JOIN simrs.pengadaan_anggaran_kendali i ON a.id_kendali_anggaran = i.id_kendali_anggaran 
WHERE a.no_pesanan = '$nomor_pesanan'";

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
			return $tgl_indo;
		}
		return $tgl_indo;
	}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>BERITA ACARA PEMERIKSAAN BARANG</title>
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
<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td align="center" style="font-weight: bold; font-size: 18px;"><u>BERITA ACARA PEMERIKSAAN BARANG</u></td>
    </tr>
    <tr>
      <td align="center">NOMOR : <?php echo $DATA_IDENTITAS['bapem_no']; ?></td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td width="18%">Pekerjaan</td>
      <td width="2%">:</td>
      <td width="80%"><?php echo $DATA_IDENTITAS['nama_rekening']; ?></td>
    </tr>
    <tr>
      <td>Nomor &amp; Tanggal SPK</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['spk_no']; ?>; Tanggal <?php echo tanggal_indo($DATA_IDENTITAS['spk_tgl'],true); ?></td>
    </tr>
    <tr>
      <td>Sumber Dana</td>
      <td>:</td>
      <td>Anggaran BLUD RSUD Ajibarang Kab. Banyumas</td>
    </tr>
    <tr>
      <td>Tahun Anggaran</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['tahun_anggaran']; ?></td>
    </tr>
    <tr>
      <td>Penyedia</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Harga</td>
      <td>:</td>
      <td>Rp <?php echo number_format($DATA_IDENTITAS['jumlah_bruto'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">Hasil dari pemeriksaan pekerjaan adalah dengan kesimpulan : <strong>Diterima</strong></td>
    </tr>
    <tr>
      <td colspan="3">Demikian Berita Acara Pemeriksaan Barang ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</td>
    </tr>
  </tbody>
</table>

<br><br><br>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="33%" align="center">Penyedia</td>
      <td width="33%" align="center">&nbsp;</td>
      <td width="33%" align="center">Pejabat Penerima Hasil Pekerjaan</td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><u><?php echo $DATA_IDENTITAS['nama_pj']; ?></u></td>
      <td>&nbsp;</td>
      <td align="center"><u><?php echo $DATA_IDENTITAS['pphp']; ?></u></td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_IDENTITAS['posisi']; ?></td>
      <td>&nbsp;</td>
      <td align="center">NIP. <?php echo $DATA_IDENTITAS['nip_pphp']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center">Mengetahui,</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">Pejabat Pembuat Komitmen</td>
      <td align="center">&nbsp;</td>
      <td align="center">Pejabat Pelaksana Teknis Kegiatan</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><u><?php echo $DATA_IDENTITAS['ppk']; ?></u></td>
      <td align="center">&nbsp;</td>
      <td align="center"><u><?php echo $DATA_IDENTITAS['pptk']; ?></u></td>
    </tr>
    <tr>
      <td align="center">NIP. <?php echo $DATA_IDENTITAS['nip_ppk']; ?></td>
      <td align="center">&nbsp;</td>
      <td align="center">NIP. <?php echo $DATA_IDENTITAS['nip_pptk']; ?></td>
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
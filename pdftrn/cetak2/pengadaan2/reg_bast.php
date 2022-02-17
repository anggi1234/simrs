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
d.nip AS nip_pengguna_anggaran,
d.pd_nickname AS pengguna_anggaran,
	e.pd_nickname AS ppk,
	e.nip AS nip_ppk,
	f.pd_nickname AS pptk,
	f.nip AS nip_pptk,
	g.pd_nickname AS bendahara,
	g.nip AS nip_bendahara,
	h.pd_nickname AS pphp,
	h.nip as nip_pphp,
	a.sp_no,
	date_format(a.sp_tgl, '%d-%m-%Y') as sp_tgl,
	a.bast_no,
	a.bast_tgl,a.spk_no,a.spk_tgl
FROM
	simrs.pengadaan_pesanan_masuk a
	LEFT JOIN simrs.master_rekening b ON a.id_rekening = b.id_rekening
	LEFT JOIN simrs.master_supplier c ON a.id_supplier = c.id_master_supplier
	LEFT JOIN simrs.master_login d on b.pa_uid=d.uid
	LEFT JOIN simrs.master_login e on b.ppk_uid=e.uid
	LEFT JOIN simrs.master_login f on b.pptk_uid=f.uid
	left join simrs.master_login g on b.bp_uid=g.uid
	left join simrs.master_login h on b.pphp_uid=h.uid 
WHERE
	a.no_pesanan = '$nomor_pesanan'";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

$sqlitem="SELECT
	f.nama_obat,a.qty*a.volume as jumlah,f.satuan,a.harga_beli_satuan,a.harga_beli_setelah_pajak
FROM
	farmasi_pembelian_obat_detail a
	LEFT JOIN farmasi_pembelian_obat b ON a.id_pembelian_obat = b.id_pembelian_obat
	LEFT JOIN pengadaan_pesanan_masuk_faktur c ON b.id_pembelian_obat = c.id_pembelian_obat
	LEFT JOIN pengadaan_pesanan_masuk d ON c.id_pengadaan_pesanan_masuk = d.id_pengadaan_pesanan_barang_masuk
	left join master_obat_detail e on a.id_master_obat_detail=e.id_master_obat_detail
	left join master_obat f on e.id_obat=f.id_obat 
WHERE
	d.no_pesanan = '$nomor_pesanan'";
 $queryitem = mysql_query($sqlitem);


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
<title>BAST REG</title>
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
      <td align="center" style="font-weight: bold; font-size: 18px;"><u>BERITA ACARA SERAH TERIMA</u></td>
    </tr>
    <tr>
      <td align="center">NOMOR : <?php echo $DATA_IDENTITAS['bast_no']; ?></td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="4%">&nbsp;</td>
      <td width="12%">&nbsp;</td>
      <td width="84%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>1.</td>
      <td>Nama</td>
      <td>: <?php echo $DATA_IDENTITAS['pphp']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Jabatan</td>
      <td>: Pejabat Penerima Hasil Pekerjaan</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Alamat</td>
      <td>: Jl. Raya Pancasan - Ajibarang, Kode Pos 53163</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>2.</td>
      <td>Nama</td>
      <td>: <?php echo $DATA_IDENTITAS['nama_pj']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Jabatan</td>
      <td>: <?php echo $DATA_IDENTITAS['posisi']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Alamat</td>
      <td>: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="4" style="text-align: justify">Dengan ini setuju dan bersepakat untuk mengadakan Serah Terima barang pekerjaan <?php echo $DATA_IDENTITAS['nama_rekening']; ?> dengan ketentutan sebagai berikut:</td>
    </tr>
    <tr>
      <td colspan="4" style="text-align: center">Pasal 1</td>
    </tr>
    <tr>
      <td colspan="4" style="text-align: justify">PIHAK KEDUA dalam hal ini sebagai Pelaksana pekerjaan <?php echo $DATA_IDENTITAS['nama_rekening']; ?> Sub kegiatan <?php echo $DATA_IDENTITAS['sub_kegiatan']; ?> menyerahkan kepada PIHAK PERTAMA dan PIHAK PERTAMA menerima penyerahan pekerjaan tersebut dari PIHAK KEDUA berdasarkan:</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>1. Surat Perintah Kerja (SPK)</td>
      <td>Nomor</td>
      <td>: <?php echo $DATA_IDENTITAS['spk_no']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Tanggal</td>
      <td>: <?php echo tanggal_indo($DATA_IDENTITAS['spk_tgl'],true); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="2%">&nbsp;</td>
      <td width="31%">2. Berita Acara Pemeriksaan Barang</td>
      <td width="7%">Nomor</td>
      <td width="60%">: <?php echo $DATA_IDENTITAS['bast_no']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td> Tanggal</td>
      <td>: <?php echo tanggal_indo($DATA_IDENTITAS['bast_tgl'],true); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" style="text-align: center">Pasal 2</td>
    </tr>
    <tr>
      <td colspan="4" style="text-align: left">Perbaikan kerusakan selama masa garansi tanggung jawab PIHAK KEDUA.</td>
    </tr>
    <tr>
      <td colspan="4" style="text-align: left">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" style="text-align: left">Demikian Berita Acara Serah Terima ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="40%">&nbsp;</td>
      <td width="15%">&nbsp;</td>
      <td width="45%">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center">Pihak Kedua</td>
      <td>&nbsp;</td>
      <td style="text-align: center">Pihak Pertama</td>
    </tr>
    <tr>
      <td style="text-align: center"> <?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
      <td>&nbsp;</td>
      <td style="text-align: center">Pejabat Penerima Hasil Pekerjaan</td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td>&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td>&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center"> <u><?php echo $DATA_IDENTITAS['nama_pj']; ?></u></td>
      <td>&nbsp;</td>
      <td style="text-align: center"><u><?php echo $DATA_IDENTITAS['pphp']; ?></u></td>
    </tr>
    <tr>
      <td style="text-align: center"> <?php echo $DATA_IDENTITAS['posisi']; ?></td>
      <td>&nbsp;</td>
      <td style="text-align: center">NIP. <?php echo $DATA_IDENTITAS['nip_pphp']; ?></td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">Mengetahui</td>
      <td style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center">Pengguna Anggaran</td>
      <td>&nbsp;</td>
      <td style="text-align: center">Pejabat Pembuat Komitmen</td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td>&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td>&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
		<td style="text-align: center"> <u><?php echo $DATA_IDENTITAS['pengguna_anggaran']; ?></u></td>
      <td>&nbsp;</td>
		<td style="text-align: center"> <u><?php echo $DATA_IDENTITAS['ppk']; ?></u></td>
    </tr>
    <tr>
      <td style="text-align: center">NIP. <?php echo $DATA_IDENTITAS['nip_pengguna_anggaran']; ?></td>
      <td>&nbsp;</td>
      <td style="text-align: center">NIP. <?php echo $DATA_IDENTITAS['nip_ppk']; ?></td>
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
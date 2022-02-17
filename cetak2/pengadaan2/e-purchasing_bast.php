<?php
ob_start();
session_start();
include('../connect.php');
$id_pengadaan_pesanan_barang_masuk = $_GET['id_pengadaan_pesanan_barang_masuk'];

$sqlidentitas="SELECT
    a.bapem_no,
    c.nama_rekening, 
    a.tahun_anggaran,
    b.nama_supplier,
    b.alamat,
    a.jumlah_bruto,
    b.nama_pj,
    b.posisi,
    e.pd_nickname AS 'pphp',
    e.nip AS 'nip_pphp',
    f.pd_nickname AS 'pptk',
    f.nip AS 'nip_pptk',
    a.no_pesanan,
    a.tgl_pesanan

FROM
    simrs.pengadaan_pesanan_masuk a
        LEFT JOIN
    master_supplier b ON a.id_supplier = b.id_master_supplier
        LEFT JOIN
    master_rekening c ON a.id_rekening = c.id_rekening
        LEFT JOIN
    master_rekening3 d ON a.id_master_rekening3 = d.id_master_rekening3
    LEFT JOIN
    master_login e ON c.pphp_uid = e.uid
    LEFT JOIN
    master_login f ON d.pptk_uid = f.uid
WHERE
    a.id_pengadaan_pesanan_barang_masuk = '$id_pengadaan_pesanan_barang_masuk'";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

$sqlppk="select nama_pejabat,nip,nama_jabatan,id_jabatan from master_jabatan where id_jabatan=3";
$queryppk = mysql_query($sqlppk);
$DATA_PPK = mysql_fetch_array($queryppk);

$sqlpa="select nama_pejabat,nip,nama_jabatan,id_jabatan from master_jabatan where id_jabatan=2";
$querypa = mysql_query($sqlpa);
$DATA_PA = mysql_fetch_array($querypa);


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


<?php
ob_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>BAST E-PUR</title>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
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
      <td>Selanjutnya disebut PIHAK PERTAMA</td>
    </tr>
    <tr>
      <td>2.</td>
      <td>Nama</td>
      <td>: <?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Jabatan</td>
      <td>: <?php echo $DATA_IDENTITAS['posisi']; ?> <?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Alamat</td>
      <td>: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Selanjutnya disebut PIHAK KEDUA</td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="4">Dengan ini setuju dan bersepakat untuk mengadakan Serah Terima barang pekerjaan <?php echo $DATA_IDENTITAS['nama_rekening']; ?></td>
    </tr>
    <tr>
      <td colspan="4" style="text-align: center">Pasal 1</td>
    </tr>
    <tr>
      <td colspan="4" style="text-align: justify">PIHAK KEDUA dalam hal ini sebagai Pelaksana pekerjaan <?php echo $DATA_IDENTITAS['nama_rekening']; ?> Sub kegiatan <?php echo $DATA_IDENTITAS['sub_kegiatan']; ?> menyerahkan kepada PIHAK PERTAMA dan PIHAK PERTAMA menerima penyerahan pekerjaan tersebut dari PIHAK KEDUA berdasarkan:</td>
    </tr>
    <tr>
      <td width="2%">&nbsp;</td>
      <td width="31%">1. Berita Acara Pemeriksaan Barang</td>
      <td width="10%">Nomor</td>
      <td width="57%">  : <?php echo $DATA_IDENTITAS['no_pesanan']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Tanggal</td>
      <td>: <?php echo tanggal_indo($DATA_IDENTITAS['tgl_pesanan'],true); ?></td>
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
      <td colspan="4" style="text-align: left">Demikian Berita Acara Serah Terima ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana</td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">Pihak Kedua</td>
      <td>&nbsp;</td>
      <td align="center">Pihak Pertama</td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
      <td>&nbsp;</td>
      <td align="center">Pejabat Penerima Hasil Pekerjaan</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><u><?php echo $DATA_IDENTITAS['nama_pj']; ?></u></td>
      <td>&nbsp;</td>
      <td align="center"><u><?php echo $DATA_IDENTITAS['pphp']; ?></u></td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_IDENTITAS['posisi']; ?></td>
      <td>&nbsp;</td>
      <td align="center">NIP.<?php echo $DATA_IDENTITAS['nip_pphp']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center">Mengetahui</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">Pengguna Anggaran</td>
      <td>&nbsp;</td>
      <td align="center">Pejabat Pembuat Komitmen</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><u><?php echo $DATA_PA['nama_pejabat']; ?></u></td>
      <td>&nbsp;</td>
      <td align="center"><u><?php echo $DATA_PPK['nama_pejabat']; ?></u></td>
    </tr>
    <tr>
      <td align="center">NIP. <?php echo $DATA_PA['nip']; ?></td>
      <td>&nbsp;</td>
      <td align="center">NIP. <?php echo $DATA_PPK['nip']; ?></td>
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
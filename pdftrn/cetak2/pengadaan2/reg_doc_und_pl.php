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
    d.nama_pj,
    d.posisi,
    e.pd_nickname AS pp,
    e.nip,
    d.posisi,
    a.ba_hpl_tgl,
    DATE_FORMAT(a.ba_hpl_tgl, '%d-%m-%Y') AS tanggal,
    DAY(a.ba_hpl_tgl) AS tgl_penawaran,
    YEAR(a.ba_hpl_tgl) AS tahun_penawaran,
    CASE
        WHEN MONTH(a.ba_hpl_tgl) = 1 THEN 'Januari'
        WHEN MONTH(a.ba_hpl_tgl) = 2 THEN 'Februari'
        WHEN MONTH(a.ba_hpl_tgl) = 3 THEN 'Maret'
        WHEN MONTH(a.ba_hpl_tgl) = 4 THEN 'April'
        WHEN MONTH(a.ba_hpl_tgl) = 5 THEN 'Mei'
        WHEN MONTH(a.ba_hpl_tgl) = 6 THEN 'Juni'
        WHEN MONTH(a.ba_hpl_tgl) = 7 THEN 'Juli'
        WHEN MONTH(a.ba_hpl_tgl) = 8 THEN 'Agustus'
        WHEN MONTH(a.ba_hpl_tgl) = 9 THEN 'September'
        WHEN MONTH(a.ba_hpl_tgl) = 10 THEN 'Oktober'
        WHEN MONTH(a.ba_hpl_tgl) = 11 THEN 'November'
        WHEN MONTH(a.ba_hpl_tgl) = 12 THEN 'Desember'
    END AS bulan_penawaran,
    a.ba_pemasukan_tgl,
    a.ba_pemasukan_no,
    a.ba_evaluasi_tgl,
    a.ba_evaluasi_no,
    a.ba_nego_tgl,
    a.ba_nego_no,
    a.pl_undangan_tgl,
    a.ba_nego_und_tgl,
    d.alamat,
    a.pl_undangan_no,
    a.spk_tgl,
    c.nama_rekening3
FROM
    pengadaan_pesanan_masuk a
        LEFT JOIN
    master_rekening b ON a.id_rekening = b.id_rekening
        LEFT JOIN
    master_supplier d ON a.id_supplier = d.id_master_supplier
        LEFT JOIN
    master_login e ON b.pp_uid = e.uid
        LEFT JOIN
    master_rekening3 c ON b.id_master_rekening3 = c.id_master_rekening3
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
			return $hari[$num] . ' ' . $tgl_indo;
		}
		return $tgl_indo;
	}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Undangan Pengadaan Langsung</title>
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
      <td colspan="2">: <?php echo $DATA_IDENTITAS['pl_undangan_no']; ?></td>
      <td width="28%">&nbsp;</td>
    </tr>
    <tr>
      <td>Lampiran</td>
      <td colspan="2">: 1 (satu) berkas</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="24%">&nbsp;</td>
      <td width="39%">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Kepada Yth:</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><strong><?php echo $DATA_IDENTITAS['posisi']; ?> <?php echo $DATA_IDENTITAS['nama_supplier']; ?></strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">di-</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>TEMPAT</u></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>Perihal</td>
      <td colspan="3">: Perintah Pengadaan Langsung untuk <?php echo $DATA_IDENTITAS['pekerjaan']; ?> Pada RSUD Ajibarang Tahun Anggaran <?php echo $DATA_IDENTITAS['tahun_anggaran']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">Dengan ini Saudara kami undang untuk mengikuti proses Pengadaan langsung pekerjaan sebagai berikut :</td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right">1.</td>
      <td> Pekerjaan</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Nama Pekerjaan</td>
      <td colspan="2">: <?php echo $DATA_IDENTITAS['pekerjaan']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Sub Kegiatan</td>
      <td colspan="2">: <?php echo $DATA_IDENTITAS['nama_rekening3']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Nilai HPS</td>
      <td colspan="2">: Rp <?php echo number_format($DATA_IDENTITAS['jumlah_netto'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Sumber Dana</td>
      <td colspan="2">: Anggaran BLUD RSUD Ajibarang Tahun <?php echo $DATA_IDENTITAS['tahun_anggaran']; ?></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right">2.</td>
      <td colspan="3">Pelaksanaan Pengadaan</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tempat dan Alamat</td>
      <td colspan="2">: RSUD Ajibarang Kabupaten Banyumas</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp; JL. Raya Pancasan - Ajibarang, Ajibarang </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Telepon/Fax/Email</td>
      <td colspan="2">: (0281-6570004 / (0281)6570005 / </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;&nbsp;rsudajibarang@banyumaskab.go.id</td>
    </tr>
    <tr>
      <td colspan="4">Saudara diminta untuk memasukkan penawaran administrasi, teknis dan harga secara langsung sesuai dengan jadwal pelaksanaan sebagai berikut :</td>
    </tr>
    <tr>
      <td colspan="4"><table width="100%" border="1" class="tabel">
        <tbody>
          <tr>
            <td width="3%" align="center">No</td>
            <td width="52%" align="center">KEGIATAN</td>
            <td width="29%" align="center">HARI/TANGGAL</td>
            <td width="16%" align="center">WAKTU</td>
          </tr>
          <tr>
            <td align="center">a.</td>
            <td>Pemasukan dokumen penawaran</td>
            <td><?php echo tanggal_indo($DATA_IDENTITAS['ba_pemasukan_tgl'],true); ?> s/d <?php echo tanggal_indo($DATA_IDENTITAS['ba_evaluasi_tgl'],true); ?></td>
            <td align="center">08.00 s/d 13.00</td>
          </tr>
          <tr>
            <td align="center">b.</td>
            <td>Pembukaan, Evaluasi, Klarifikasi Teknis, Negosiasi Harga</td>
            <td><?php echo tanggal_indo($DATA_IDENTITAS['ba_evaluasi_tgl'],true); ?> s/d <?php echo tanggal_indo($DATA_IDENTITAS['ba_nego_tgl'],true); ?></td>
            <td align="center">08.00 s/d 13.00</td>
          </tr>
          <tr>
            <td align="center">c.</td>
            <td>Penandatanganan SPK</td>
            <td><?php echo tanggal_indo($DATA_IDENTITAS['spk_tgl'],true); ?></td>
            <td align="center">08.00 s/d 13.00</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">Apabila Saudara membutuhkan keterangan dan penjelasan lebih lanjut, dapat menghubungi kami sesuai alamat tersebut diatas sampai dengan batas akhir pemasukan dokumen</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">Demikian disampaikan untuk diketahui.</td>
    </tr>
  </tbody>
</table><br>
	
	
	<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="50%">&nbsp;</td>
      <td width="50%" align="right">&nbsp;</td>
      <td width="50%" align="right">&nbsp;</td>
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
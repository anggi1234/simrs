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
    f.nip AS 'nip_pptk'

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

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>BAPEM E-PUR</title>
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
      <td align="center" style="font-weight: bold">BERITA ACARA PEMERIKSAAN</td>
    </tr>
    <tr>
      <td align="center">NOMOR : <?php echo $DATA_IDENTITAS['bapem_no']; ?></td>
    </tr>
  </tbody>
</table>
 <table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td width="21%">Pekerjaan</td>
      <td width="3%">:</td>
      <td width="76%"><?php echo $DATA_IDENTITAS['nama_rekening']; ?></td>
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">Demikian Berita Acara Pemeriksaan Barang ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</td>
    </tr>
  </tbody>
</table>



<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
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
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center">Mengetahui,</td>
      <td>&nbsp;</td>
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
      <td align="center"><u><?php echo $DATA_PPK['nama_pejabat']; ?></u></td>
      <td align="center">&nbsp;</td>
      <td align="center"><u><?php echo $DATA_IDENTITAS['pptk']; ?></u></td>
    </tr>
    <tr>
      <td align="center">NIP. <?php echo $DATA_PPK['nip']; ?></td>
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
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
    h.pd_nickname AS pphp,
    YEAR(a.tgl_pesanan) AS tahun_pengadaan,
    e.pd_nickname as pptk,
    e.nip as nip_pptk
FROM
    simrs.pengadaan_pesanan_masuk a
        LEFT JOIN
    simrs.master_rekening b ON a.id_rekening = b.id_rekening
        LEFT JOIN
    simrs.master_supplier c ON a.id_supplier = c.id_master_supplier
        LEFT JOIN
    simrs.master_login h ON b.pphp_uid = h.uid
        LEFT JOIN
    simrs.master_rekening3 d ON b.id_master_rekening3 = d.id_master_rekening3
        LEFT JOIN
    simrs.master_login e ON d.pptk_uid = e.uid
WHERE
    a.id_pengadaan_pesanan_barang_masuk = '$id_pengadaan_pesanan_barang_masuk'";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

$sqlpa="select nama_pejabat,nip,nama_jabatan,id_jabatan from master_jabatan where id_jabatan=2";
$querypa = mysql_query($sqlpa);
$DATA_PA = mysql_fetch_array($querypa);

$sqlppk="select nama_pejabat,nip,nama_jabatan,id_jabatan from master_jabatan where id_jabatan=3";
$queryppk = mysql_query($sqlppk);
$DATA_PPK = mysql_fetch_array($queryppk);
 
 
 function Terbilang($nilai) {
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        if($nilai==0){
            return "";
        }elseif ($nilai < 12&$nilai!=0) {
            return "" . $huruf[$nilai];
        } elseif ($nilai < 20) {
            return Terbilang($nilai - 10) . " Belas ";
        } elseif ($nilai < 100) {
            return Terbilang($nilai / 10) . " Puluh " . Terbilang($nilai % 10);
        } elseif ($nilai < 200) {
            return " Seratus " . Terbilang($nilai - 100);
        } elseif ($nilai < 1000) {
            return Terbilang($nilai / 100) . " Ratus " . Terbilang($nilai % 100);
        } elseif ($nilai < 2000) {
            return " Seribu " . Terbilang($nilai - 1000);
        } elseif ($nilai < 1000000) {
            return Terbilang($nilai / 1000) . " Ribu " . Terbilang($nilai % 1000);
        } elseif ($nilai < 1000000000) {
            return Terbilang($nilai / 1000000) . " Juta " . Terbilang($nilai % 1000000);
        }elseif ($nilai < 1000000000000) {
            return Terbilang($nilai / 1000000000) . " Milyar " . Terbilang($nilai % 1000000000);
        }elseif ($nilai < 100000000000000) {
            return Terbilang($nilai / 1000000000000) . " Trilyun " . Terbilang($nilai % 1000000000000);
        }elseif ($nilai <= 100000000000000) {
            return "Maaf Tidak Dapat di Prose Karena Jumlah nilai Terlalu Besar ";
        }
    }
 

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Kwitansi</title>
<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
		font-size: 11px;
		font-family: Impact, Haettenschweiler, Franklin Gothic Bold, Arial Black," sans-serif";
	}
	
	.tabel {
    border-collapse:collapse;
	}
	.tableatas {
  border-collapse: collapse;
  border: 1px solid black;
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
      <td align="center" style="font-size: 14px">Jl. Raya Pancasan - Ajibarang, Ajibarang Kode Pos 53163 <br> 
      Telp. (0281) 6570004 Fax. (0281) 6570005 <br> 
      e-mail : rsudajibarang@banyumaskab.go.id</td>
    </tr>
</table>
	<hr>
<center style="font-size: 24px; font-weight: bold;">KWITANSI</center>
<table width="100%" class="tableatas">
  <tbody>
    <tr>
      <td colspan="3" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td width="19%">Telah diterima dari</td>
      <td colspan="2">: Rumah Sakit Umum Daerah Ajibarang</td>
    </tr>
    <tr>
      <td>Uang Sebanyak</td>
      <td colspan="2">: <?php echo Terbilang($DATA_IDENTITAS['jumlah_bruto']) ?> Rupiah</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Guna Membayar</td>
      <td colspan="2">: Pembayaran <?php echo $DATA_IDENTITAS['nama_rekening']; ?> pada <?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="41%">&nbsp;</td>
      <td width="40%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>NPWP</td>
      <td>: <?php echo $DATA_IDENTITAS['npwp']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Terbilang</td>
      <td style="font-size: 18px">: <strong>Rp.<?php echo number_format($DATA_IDENTITAS['jumlah_bruto'], 0,",","."); ?></strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">Ajibarang, ...................................</td>
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><u><?php echo $DATA_IDENTITAS['nama_pj']; ?></u></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><?php echo $DATA_IDENTITAS['posisi']; ?></td>
    </tr>
  </tbody>
</table>

<table width="100%">
  <tbody>
    <tr>
      <td width="30%">&nbsp;</td>
      <td width="37%" align="center">Mengetahui</td>
      <td width="33%">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">Pejabat Pelaksana Teknis Kegiatan</td>
      <td align="center">&nbsp;</td>
      <td align="center">Pejabat Pembuat Komitmen</td>
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
      <td align="center"><u><?php echo $DATA_IDENTITAS['pptk']; ?></u></td>
      <td align="center">&nbsp;</td>
      <td align="center"><u><?php echo $DATA_PPK['nama_pejabat']; ?></u></td>
    </tr>
    <tr>
      <td align="center">NIP. <?php echo $DATA_IDENTITAS['nip_pptk']; ?></td>
      <td align="center">&nbsp;</td>
      <td align="center">NIP. <?php echo $DATA_PPK['nip']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center">Menyetujui</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center">Pengguna Anggaran</td>
      <td>&nbsp;</td>
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
      <td>&nbsp;</td>
      <td style="text-align: center"><u><?php echo $DATA_PA['nama_pejabat']; ?></u></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center">NIP. <?php echo $DATA_PA['nip']; ?></td>
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
$paper_size = array(0,0, 8.26 * 72, 7 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('kwitansi.pdf',array('Attachment' => 0));
?>
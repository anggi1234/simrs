<?php
ob_start();
session_start();

include('../connect.php');
$id_spp = $_GET['id_spp'];

$sqlidentitas="SELECT 
    a.kode_spp,
    YEAR(a.tanggal_spp) AS tahun_anggaran,
    c.nama_supplier,
    c.bentuk_perusahaan,
    c.alamat,
    c.nama_pj,
    CONCAT(c.nama_bank, ' - ', c.no_rekening) AS nama_rekening,
    d.nama_rekening AS kegiatan,
    d.kode_rekening,
    a.total_netto,
    a.total_bruto,
    b.ppn,
    b.pph21,
    b.pph22,
    b.pph23,
    b.pph4_2,
    e.nama_rekening3,
    f.pd_nickname AS pptk,
    f.nip AS nip_pptk,
    g.nama_jabatan AS bp,
    g.nama_pejabat AS bp_nama,
    g.nip AS nip_bp,
    b.uraian,
    h.kode_rekening as kode_rekening2,h.nama_rekening2,
    i.kode_rekening as kode_rekening1,i.nama_rekening1
FROM
    simrs.keu_spp a
        LEFT JOIN
    keu_bukti_pengeluaran b ON a.id_bukti_pengeluaran = b.id_bukti_pengeluaran
        LEFT JOIN
    master_supplier c ON b.id_master_supplier = c.id_master_supplier
        LEFT JOIN
    master_rekening d ON b.id_rekening = d.id_rekening
        LEFT JOIN
    master_rekening3 e ON d.id_master_rekening3 = e.id_master_rekening3
        LEFT JOIN
    master_login f ON e.pptk_uid = f.uid
        LEFT JOIN
    master_jabatan g ON b.bp_uid = g.uid
        LEFT JOIN
    master_rekening2 h ON e.id_master_rekening2 = h.id_master_rekening2
        LEFT JOIN
    master_rekening1 i ON h.id_master_rekening1 = i.id_master_rekening1
WHERE
    a.id_spp=$id_spp";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

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

    $sqldpa="SELECT kode_dpa,tanggal_dpa,nilai_spd FROM simrs.keu_dpa";
    $querydpa = mysql_query($sqldpa);
    $DATA_DPA = mysql_fetch_assoc($querydpa);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan SPPLS</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
		font-size: 10px;
	}
	
.tabelfix {
    border-collapse:collapse;
	font-size: 10px;
}
	
</style>
</head>

<body>
	<table width="100%" class="tabelfix" border="0">
		<tr>
			<td width="10%" rowspan="3" align="right"><img src="../gambar/logobms.png" height="70px" /></td>
			<td width="90%" align="center" style="font-size: 16px">PEMERINTAH KABUPATEN BANYUMAS</td>
		</tr>
		<tr>
			<td align="center"><strong style="font-size: 18px">SURAT PERMINTAAN PEMBAYARAN LANGSUNG BARANG DAN JASA</strong></td>
		</tr>
		<tr>
			<td align="center" style="font-size: 14px">(SPP-LS BARANG DAN JASA) <br>
				NOMOR : <?php echo $DATA_IDENTITAS['kode_spp']; ?>
			</td>
		</tr>
	</table>

	<hr>
	
	
	<table width="100%" class="tabelfix" border="0">
  <tbody>
    <tr>
      <td colspan="2">Kepada Yth.</td>
      <td width="25%">&nbsp;</td>
      <td width="25%">&nbsp;</td>
      <td width="25%">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Pemimpin BLUD</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Rumah Sakit Umum Daerah Ajibarang</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Di Tempat</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="3%">&nbsp;</td>
      <td width="30%">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5">Dengan memperhatikan Peraturan Bupati Banyumas Nomor : 65 Tahun 2019, tentang Penjabaran Anggaran Pendapatan dan Belanja Daerah Tahun 2020, bersama ini kami mengajukan Surat Permintaan Pembayaran Langsung Barang dan Jasa sebagai berikut:</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>a.</td>
      <td>Urusan Pemerintah</td>
      <td>1.02</td>
      <td>Kesehatan</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>b.</td>
      <td>OPD</td>
      <td>1.02.03.001</td>
      <td>Rumah Sakit Umum Daerah Ajibarang</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>c.</td>
      <td>Tahun Anggaran</td>
      <td colspan="3"><?php echo $DATA_IDENTITAS['tahun_anggaran']; ?></td>
    </tr>
    <tr>
      <td>d.</td>
      <td>Untuk Keperluan</td>
      <td colspan="3">Pembayaran <?php echo $DATA_IDENTITAS['uraian']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>e.</td>
      <td>Nama Bendahara Pengeluaran</td>
      <td colspan="3"><?php echo $DATA_IDENTITAS['bp_nama']; ?></td>
    </tr>
    <tr>
      <td>f.</td>
      <td>Jumlah Pembayaran Yang Diminta</td>
      <td colspan="3"><?php echo number_format($DATA_IDENTITAS['total_bruto'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>g.</td>
      <td>Terbilang</td>
      <td colspan="3"><?php echo Terbilang($DATA_IDENTITAS['total_bruto']); ?></td>
    </tr>
    <tr>
      <td style="border: solid thin;" colspan="5" align="center"><strong>RINGKASAN KEGIATAN</strong></td>
    </tr>
    <tr>
      <td>1.</td>
      <td>Program</td>
      <td><?php echo $DATA_IDENTITAS['kode_rekening1']; ?></td>
      <td colspan="2"><?php echo $DATA_IDENTITAS['nama_rekening1']; ?></td>
    </tr>
    <tr>
      <td>2.</td>
      <td>Kegiatan</td>
      <td><?php echo $DATA_IDENTITAS['kode_rekening2']; ?></td>
      <td colspan="2"><?php echo $DATA_IDENTITAS['nama_rekening2']; ?></td>
    </tr>
    <tr>
      <td>3.</td>
      <td>Sub Kegiatan</td>
      <td><?php echo $DATA_IDENTITAS['kode_rekening']; ?></td>
      <td colspan="2"><?php echo $DATA_IDENTITAS['kegiatan']; ?></td>
    </tr>
    <tr>
      <td>4.</td>
      <td>Nomor dan Tanggal DPA/DPPA/DPAL-SKPD</td>
      <td colspan="3">1.02-03.001-1.02.013-0001-5-2 </td>
    </tr>
    <tr>
      <td>5.</td>
      <td>Nama Perusahaan</td>
      <td colspan="3"><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
    </tr>
    <tr>
      <td>6.</td>
      <td>Bentuk Perusahaan</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>7.</td>
      <td>Alamat Perusahaan</td>
      <td colspan="3"><?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
    <tr>
      <td>8.</td>
      <td>Nama Pimpinan Perusahaan</td>
      <td colspan="3"><?php echo $DATA_IDENTITAS['nama_pj']; ?></td>
    </tr>
    <tr>
      <td>9.</td>
      <td>Nama dan Nomor Rekening Bank</td>
      <td colspan="3"><?php echo $DATA_IDENTITAS['nama_rekening']; ?></td>
    </tr>
    <tr>
      <td>10.</td>
      <td>Nomor Kontrak</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>11.</td>
      <td>Kegiatan Lanjutan</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>12.</td>
      <td>Waktu dan Pelaksanaan Kegiatan</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>13.</td>
      <td>Deskripsi Pekerjaan</td>
      <td colspan="3"><?php echo $DATA_IDENTITAS['kegiatan']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><strong>RINGKASAN</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="border: solid thin;" colspan="5" align="center"><strong>RINGKASAN DPA-/DPPA-/DPAL-SKPD</strong></td>
    </tr>
    <tr>
      <td colspan="4">Jumlah Dana DPA-/DPPA-/DPAL-SKPD</td>
      <td>Rp.<?php echo number_format($DATA_DPA['nilai_spd'],0,",","."); ?></td>
    </tr>
    <tr>
      <td style="border: solid thin;" colspan="5" align="center"><strong>RINGKASAN SPD</strong></td>
    </tr>
    <tr>
      <td colspan="2" align="left"><strong>Nomor SPD</strong></td>
      <td align="center"><strong>Tanggal SPD</strong></td>
      <td colspan="2" align="center"><strong>Jumlah Dana</strong></td>
    </tr>
    <?php
	  
  $sqldpa="SELECT kode_dpa,tanggal_dpa,nilai_spd FROM simrs.keu_dpa";
  $querydpa = mysql_query($sqldpa);
	  
			$no=1;
				while($data=mysql_fetch_assoc($querydpa)){
					echo '<tr>';
					echo '<td colspan="2">'.$data['kode_dpa'].'</td>';
					echo '<td align="right">'.$data['tanggal_dpa'].'</td>';
					echo '<td colspan="2" align="right">'.number_format($data['nilai_spd'], 0,",",".").'</td>';
					echo '</tr>';
					$no++;
			}
		?>
    <tr>
      <td colspan="4" align="right"><strong>Jumlah</strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="right"><strong>Sisa dana yang belum di SPD-kan (I-II)</strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="border: solid thin;" colspan="5" align="center"><strong>RINGKASAN BELANJA</strong></td>
    </tr>
    <?php
$sqlviewdpa="SELECT * FROM simrs.v_keu_anggaran_terpakai";
$queryviewdpa = mysql_query($sqlviewdpa);
	  
    		while($data=mysql_fetch_assoc($queryviewdpa)){
					echo '<tr>';
					echo '<td colspan="2">'.$data['jenis'].'</td>';
					echo '<td colspan="2"></td>';
					echo '<td align="right">Rp '.number_format($data['anggaran_terpakai'], 0,",",".").'</td>';
					echo '</tr>';
			}
	?>

  <?php

  $querytotal = "SELECT SUM(anggaran_terpakai) AS 'totaldpa' FROM simrs.v_keu_anggaran_terpakai";
  $getquertotal = mysql_query($querytotal);
  $DATA_DPA  = mysql_fetch_array($getquertotal);

  ?>

    <tr>
      <td colspan="4" align="right"><strong>Jumlah</strong></td>
      <td align="right">RP. <?php echo number_format($DATA_DPA['totaldpa'],0,",","."); ?></td>
    </tr>
    <tr>
      <td colspan="4" align="right"><strong>Sisa SPD yang diterbitkan, belum dibelanjakan (II-III)</strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="border: solid thin;" colspan="5" align="center"><strong>RINCIAN SPP</strong></td>
    </tr>
    <tr>
      <td>NO</td>
      <td>Kode Rekening</td>
      <td colspan="2">Uraian</td>
      <td>Nilai</td>
    </tr>
    <tr>
      <td>1</td>
      <td><?php echo $DATA_IDENTITAS['kode_rekening']; ?></td>
      <td colspan="2"><?php echo $DATA_IDENTITAS['kegiatan']; ?></td>
      <td><?php echo number_format($DATA_IDENTITAS['total_bruto'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td colspan="4" align="right"><strong>JUMLAH</strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2"><strong>Potongan Oleh Bendahara Pengeluaran :</strong></td>
      <td colspan="2"><strong>Informasi</strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">Pajak yang dipungut Bendahara Pengeluaran dan telah lunas dibayar/disetor ke Kas Negara :</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>1.</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">Jumlah</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">Pajak yang dipungut Bendahara Pengeluaran dan akan disetor ke Kas Negara melalui Bank persepsi bersama SPM :</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>1. PPN Pusat</td>
      <td>Rp.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center">Mengetahui</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><?php echo date("d-m-Y"); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center">Pejabat Pelaksana Teknis Kegiatan</td>
      <td>&nbsp;</td>
      <td colspan="2" align="center">Bendahara Pengeluaran</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
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
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center"><u><?php echo $DATA_IDENTITAS['pptk']; ?></u></td>
      <td>&nbsp;</td>
      <td colspan="2" align="center"><u><?php echo $DATA_IDENTITAS['bp_nama']; ?></u></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center">NIP.<?php echo $DATA_IDENTITAS['nip_pptk']; ?></td>
      <td>&nbsp;</td>
      <td colspan="2" align="center">NIP.<?php echo $DATA_IDENTITAS['nip_bp']; ?></td>
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
$dompdf->stream('Laporan_SPPLS.pdf',array('Attachment' => 0));
?>
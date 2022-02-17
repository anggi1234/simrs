<?php
ob_start();
include('../connect.php');
$id_pengadaan_pesanan_barang_masuk = $_GET['id_pengadaan_pesanan_barang_masuk'];

$sqlidentitas="SELECT 
    a.kode_permintaan,
    a.kode_bukti AS 'nomer',
    YEAR(a.tanggal_bukti_pengeluaran) AS 'tahun_pengadaan',
    a.netto AS 'jumlah_dibayar',
    a.bruto AS 'jumlah_bruto',
    a.jumlah_pajak AS 'jumlah_potongan',
    f.nama_rekening,
    g.nama_rekening3 AS 'sub_kegiatan',
    a.ppn,
    a.pph22,
    b.nama_supplier,
    b.alamat,
    c.pd_nickname AS 'pptk',
    d.pd_nickname AS 'pengguna_anggaran',
    e.pd_nickname AS 'bendahara',
    c.nip AS 'nip_pptk',
    d.nip AS 'nip_pengguna_anggaran',
    e.nip AS 'nip_bendahara'
FROM
    simrs.keu_bukti_pengeluaran a
        LEFT JOIN
    master_supplier b ON a.id_master_supplier = b.id_master_supplier
        LEFT JOIN
    master_login d ON a.bp_uid = d.uid
        LEFT JOIN
    master_login e ON a.pa_uid = e.uid
        LEFT JOIN
    master_rekening f ON a.id_rekening = f.id_rekening
        LEFT JOIN
    master_rekening3 g ON f.id_master_rekening3 = g.id_master_rekening3
        LEFT JOIN
    pengadaan_pesanan_masuk h ON a.kode_permintaan = h.no_pesanan
            LEFT JOIN
    master_login c ON g.pptk_uid = c.uid
WHERE
    a.kode_permintaan = '$id_pengadaan_pesanan_barang_masuk'";

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
 

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>C5</title>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
		font-size: 9px;
		font-family: Impact, Haettenschweiler, Franklin Gothic Bold, Arial Black," sans-serif";
	}
	
	.tabel {
    border-collapse:collapse;
	border: 1px solid black;
	}
	#table2 {
 	 	border-collapse: separate;
  		border-color: blue;
	}
	tr.border_bottom td {
  		border-bottom:1pt solid black;
		border-collapse: collapse;
	}
		
	td.border_left {
  		border-left:1pt solid black;
		border-collapse: collapse;
		}
</style>
</head>

<body>
<table width="100%" border="0">
  <tbody>
    <tr class="border_bottom">
      <td style="font-size: 11px" colspan="5" align="center"><strong>SURAT BUKTI PENGELUARAN <br>Nomor : <?php echo $DATA_IDENTITAS['nomer'];?> </strong></td>
    </tr>
    <tr id="table2">
      <td width="21%">Kode SKPD</td>
      <td width="79%" colspan="4">: 1.02.03</td>
    </tr>
    <tr id="table2">
      <td>Nama SKPD</td>
      <td colspan="4">: RSUD Ajibarang</td>
    </tr>
    <tr class="border_bottom" id="table2">
      <td>Tahun Anggaran</td>
      <td colspan="4">: <?php echo $DATA_IDENTITAS['tahun_pengadaan']; ?></td>
    </tr>
  </tbody>
</table>


<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="64%"><table width="100%" border="0">
        <tbody>
          <tr>
            <td width="26%">&nbsp;</td>
            <td width="3%">&nbsp;</td>
            <td width="67%">&nbsp;</td>
            <td width="4%">&nbsp;</td>
          </tr>
          <tr>
            <td>Sudah Terima dari</td>
            <td>:</td>
            <td>RSUD Ajibarang</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Uang Sejumlah</td>
            <td>:</td>
            <td>Rp. <?php echo number_format($DATA_IDENTITAS['jumlah_dibayar'], 0,",","."); ?></td>
            <td style="text-align: right">&nbsp;</td>
          </tr>
          <tr>
            <td>Terbilang</td>
            <td>:</td>
            <td><?php echo Terbilang($DATA_IDENTITAS['jumlah_dibayar']) ?> Rupiah</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Yaitu untuk pembayaran</td>
            <td>:</td>
            <td><?php echo $DATA_IDENTITAS['nama_rekening']; ?> pada RSUD Ajibarang</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Kode lengkap</td>
            <td>:</td>
            <td>1.02.013.0001.<?php echo $DATA_IDENTITAS['kode_rekening']; ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Nama Sub Kegiatan</td>
            <td>:</td>
            <td><?php echo $DATA_IDENTITAS['sub_kegiatan']; ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Berguna untuk keperluan</td>
            <td>:</td>
            <td colspan="2">Pembayaran <?php echo $DATA_IDENTITAS['nama_rekening']; ?> pada <?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
      <td width="36%"><table width="100%" border="0">
        <tbody>
          <tr>
            <td colspan="4">Barang-barang tersebut telah masuk buku persediaan investasi pada tanggal</td>
          </tr>
          <tr>
            <td colspan="4">&nbsp;</td>
            </tr>
          <tr>
            <td width="36%">&nbsp;</td>
            <td width="7%">&nbsp;</td>
            <td width="28%">&nbsp;</td>
            <td width="29%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Jumlah Kotor</td>
            <td>:</td>
            <td>Rp</td>
            <td style="text-align: right"><?php echo number_format($DATA_IDENTITAS['jumlah_bruto'], 0,",","."); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: right">&nbsp;</td>
          </tr>
          <tr>
            <td>Potongan</td>
            <td>:</td>
            <td>Rp</td>
            <td style="text-align: right"><?php echo number_format($DATA_IDENTITAS['jumlah_potongan'], 0,",","."); ?></td>
          </tr>
          <tr>
            <td>Dibayar</td>
            <td>:</td>
            <td>Rp</td>
            <td style="text-align: right"><?php echo number_format($DATA_IDENTITAS['jumlah_dibayar'], 0,",","."); ?></td>
          </tr>
          <tr>
            <td>Perincian potongan</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: right">&nbsp;</td>
          </tr>
          <tr>
            <td>PPN</td>
            <td>:</td>
            <td>Rp</td>
            <td style="text-align: right"><?php echo number_format($DATA_IDENTITAS['ppn'], 0,",","."); ?></td>
          </tr>
          <tr>
            <td>PPh 21</td>
            <td>:</td>
            <td>Rp</td>
            <td style="text-align: right"><?php echo number_format($DATA_IDENTITAS['pph21'], 0,",","."); ?></td>
          </tr>
          <tr>
            <td>PPh 22</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: right"><?php echo number_format($DATA_IDENTITAS['pph22'], 0,",","."); ?></td>
          </tr>
          <tr>
            <td>PPh 23</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: right"><?php echo number_format($DATA_IDENTITAS['pph23'], 0,",","."); ?></td>
          </tr>
          <tr>
            <td>PPh 4 (2)</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: right"><?php echo number_format($DATA_IDENTITAS['pph4_2'], 0,",","."); ?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="2" class="tabel"></td>
    </tr>
    <tr>
    <td>Yang berhak menerima pembayaran:</td>
    <td>Tandatangan dan/atau cap:</td>
    </tr>
    <tr>
      <td>
        <table width="100%" border="0">
          <tbody>
            <tr>
              <td>Nama</td>
              <td>:</td>
              <td><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="26%">Alamat</td>
              <td width="3%">:</td>
              <td width="46%"><?php echo $DATA_IDENTITAS['alamat']; ?></td>
              <td width="25%">&nbsp;</td>
            </tr>
          </tbody>
        </table>
      </td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
<hr>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="33%" style="text-align: center">Diajukan oleh:</td>
      <td width="32%" style="text-align: center">Setuju dibayar:</td>
      <td width="35%" style="text-align: center">Yang Membayarkan:</td>
    </tr>
    <tr>
      <td style="text-align: center">Pejabat Pelaksana Teknis Kegiatan</td>
      <td style="text-align: center">Pengguna Anggaran</td>
      <td style="text-align: center">Bendahara Pengeluaran<span style="text-align: center"></span></td>
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
      <td style="text-align: center"><?php echo $DATA_IDENTITAS['pptk']; ?></td>
      <td style="text-align: center">dr. Widyana Grehastuti, Sp.OG, M.Si.Med</td>
      <td style="text-align: center">RISTANTI</td>
    </tr>
    <tr>
      <td style="text-align: center">NIP. <?php echo $DATA_IDENTITAS['nip_pptk']; ?></td>
      <td style="text-align: center">NIP. 19721125 200312 2 007</td>
      <td style="text-align: center">NIP. 19700407 199501 2 002</td>
    </tr>
  </tbody>
</table>



<br><br><br><br>

<div style="width: 100%; height: 5px; border-bottom: 1px solid black; text-align: center">
  <span style="font-size: 10px; background-color: #F3F5F6; padding: 0 10px;">
    Potong Disini
  </span>
</div>


<br><br><br><br>





<table width="100%" border="0">
  <tbody>
    <tr class="border_bottom">
      <td style="font-size: 11px" colspan="5" align="center"><strong>SURAT BUKTI PENGELUARAN <br>Nomor : <?php echo $DATA_IDENTITAS['nomer']; ?> </strong></td>
    </tr>
    <tr id="table2">
      <td width="21%">Kode SKPD</td>
      <td width="79%" colspan="4">: 1.02.03</td>
    </tr>
    <tr id="table2">
      <td>Nama SKPD</td>
      <td colspan="4">: RSUD Ajibarang</td>
    </tr>
    <tr class="border_bottom" id="table2">
      <td>Tahun Anggaran</td>
      <td colspan="4">: <?php echo $DATA_IDENTITAS['tahun_pengadaan']; ?></td>
    </tr>
  </tbody>
</table>


<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="64%"><table width="100%" border="0">
        <tbody>
          <tr>
            <td width="26%">&nbsp;</td>
            <td width="3%">&nbsp;</td>
            <td width="67%">&nbsp;</td>
            <td width="4%">&nbsp;</td>
          </tr>
          <tr>
            <td>Sudah Terima dari</td>
            <td>:</td>
            <td>RSUD Ajibarang</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Uang Sejumlah</td>
            <td>:</td>
            <td>Rp. <?php echo number_format($DATA_IDENTITAS['jumlah_dibayar'], 0,",","."); ?></td>
            <td style="text-align: right">&nbsp;</td>
          </tr>
          <tr>
            <td>Terbilang</td>
            <td>:</td>
            <td><?php echo Terbilang($DATA_IDENTITAS['jumlah_dibayar']) ?> Rupiah</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Yaitu untuk pembayaran</td>
            <td>:</td>
            <td><?php echo $DATA_IDENTITAS['nama_rekening']; ?> pada RSUD Ajibarang</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Kode lengkap</td>
            <td>:</td>
            <td>1.02.013.0001.<?php echo $DATA_IDENTITAS['kode_rekening']; ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Nama Sub Kegiatan</td>
            <td>:</td>
            <td><?php echo $DATA_IDENTITAS['sub_kegiatan']; ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Berguna untuk keperluan</td>
            <td>:</td>
            <td colspan="2">Pembayaran <?php echo $DATA_IDENTITAS['nama_rekening']; ?> pada <?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
      <td width="36%"><table width="100%" border="0">
        <tbody>
          <tr>
            <td colspan="4">Barang-barang tersebut telah masuk buku persediaan investasi pada tanggal</td>
          </tr>
          <tr>
            <td colspan="4">&nbsp;</td>
            </tr>
          <tr>
            <td width="36%">&nbsp;</td>
            <td width="7%">&nbsp;</td>
            <td width="28%">&nbsp;</td>
            <td width="29%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Jumlah Kotor</td>
            <td>:</td>
            <td>Rp</td>
            <td style="text-align: right"><?php echo number_format($DATA_IDENTITAS['jumlah_bruto'], 0,",","."); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: right">&nbsp;</td>
          </tr>
          <tr>
            <td>Potongan</td>
            <td>:</td>
            <td>Rp</td>
            <td style="text-align: right"><?php echo number_format($DATA_IDENTITAS['jumlah_potongan'], 0,",","."); ?></td>
          </tr>
          <tr>
            <td>Dibayar</td>
            <td>:</td>
            <td>Rp</td>
            <td style="text-align: right"><?php echo number_format($DATA_IDENTITAS['jumlah_dibayar'], 0,",","."); ?></td>
          </tr>
          <tr>
            <td>Perincian potongan</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: right">&nbsp;</td>
          </tr>
          <tr>
            <td>PPN</td>
            <td>:</td>
            <td>Rp</td>
            <td style="text-align: right"><?php echo number_format($DATA_IDENTITAS['ppn'], 0,",","."); ?></td>
          </tr>
          <tr>
            <td>PPh 21</td>
            <td>:</td>
            <td>Rp</td>
            <td style="text-align: right"><?php echo number_format($DATA_IDENTITAS['pph21'], 0,",","."); ?></td>
          </tr>
          <tr>
            <td>PPh 22</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: right"><?php echo number_format($DATA_IDENTITAS['pph22'], 0,",","."); ?></td>
          </tr>
          <tr>
            <td>PPh 23</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: right"><?php echo number_format($DATA_IDENTITAS['pph23'], 0,",","."); ?></td>
          </tr>
          <tr>
            <td>PPh 4(2)</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: right"><?php echo number_format($DATA_IDENTITAS['pph4_2'], 0,",","."); ?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="2" class="tabel"></td>
    </tr>
    <tr>
    <td>Yang berhak menerima pembayaran:</td>
    <td>Tandatangan dan/atau cap:</td>
    </tr>
    <tr>
      <td>
        <table width="100%" border="0">
          <tbody>
            <tr>
              <td>Nama</td>
              <td>:</td>
              <td><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="26%">Alamat</td>
              <td width="3%">:</td>
              <td width="46%"><?php echo $DATA_IDENTITAS['alamat']; ?></td>
              <td width="25%">&nbsp;</td>
            </tr>
          </tbody>
        </table>
      </td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
<hr>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="33%" style="text-align: center">Diajukan oleh:</td>
      <td width="32%" style="text-align: center">Setuju dibayar:</td>
      <td width="35%" style="text-align: center">Yang Membayarkan:</td>
    </tr>
    <tr>
      <td style="text-align: center">Pejabat Pelaksana Teknis Kegiatan</td>
      <td style="text-align: center">Pengguna Anggaran</td>
      <td style="text-align: center">Bendahara Pengeluaran<span style="text-align: center"></span></td>
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
      <td style="text-align: center"><?php echo $DATA_IDENTITAS['pptk']; ?></td>
      <td style="text-align: center">dr. Widyana Grehastuti, Sp.OG, M.Si.Med</td>
      <td style="text-align: center">RISTANTI</td>
    </tr>
    <tr>
      <td style="text-align: center">NIP. <?php echo $DATA_IDENTITAS['nip_pptk']; ?></td>
      <td style="text-align: center">NIP. 19721125 200312 2 007</td>
      <td style="text-align: center">NIP. 19700407 199501 2 002</td>
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
$dompdf->stream('laporan_sbp_ls.pdf',array('Attachment' => 0));
?>
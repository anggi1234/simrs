<?php
ob_start();
include('../connect.php');
$id_pengadaan_pesanan_barang_masuk = $_GET['id_pengadaan_pesanan_barang_masuk'];


$sqlitemstok="SELECT 
    a.tahun_anggaran,
    b.nama_rekening,
    d.nama_rekening3,
    c.nama_supplier,
    c.alamat,
    a.jumlah_netto
FROM
    pengadaan_pesanan_masuk a
        LEFT JOIN
    master_rekening b ON a.id_rekening = b.id_rekening
        LEFT JOIN
    master_supplier c ON a.id_supplier = c.id_master_supplier
        LEFT JOIN
    master_rekening3 d ON b.id_master_rekening3 = d.id_master_rekening3
WHERE
    a.id_pengadaan_pesanan_barang_masuk ='$id_pengadaan_pesanan_barang_masuk'";
$queryitemobat = mysql_query($sqlitemstok);
$DATA_IDENTITAS = mysql_fetch_array($queryitemobat);

$sqlusername="select a.pd_nickname,b.userlevelname from master_login a left join userlevels b on a.userlevelid=b.userlevelid where a.username=$username";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);


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
			return $hari[$num] . ', ' . $tgl_indo;
		}
		return $tgl_indo;
	}


?>
 <!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>COVER</title>
<style type="text/css">
	@page {
            margin-top: 3 cm;
            margin-left: 3 cm;
			margin-right: 3 cm;
			margin-bottom: 3 cm;
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
  <br>
  <br>
  <table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td align="center" style="font-weight: bold; font-size: 18px;"><u>DOKUMEN PENGADAAN</u></td>
    </tr>
    </tbody>
</table>

<br>
<br>
<br>
<br>
<br>
<br>
  <table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td align="center" style="font-weight: bold; font-size: 18px;"><u>TENTANG</u></td>
    </tr>
    </tbody>
</table>
<br>
<br>
<center style="font-weight: bold; font-size: 15px;"><?php echo $DATA_IDENTITAS['nama_rekening']; ?> Rumah Sakit</center>
<br>
<center style="font-weight: bold; font-size: 15px;">Sub Kegiatan <?php echo $DATA_IDENTITAS['nama_rekening3']; ?></center>
<br>
<center style="font-weight: bold; font-size: 18px;"><strong>TAHUN ANGGARAN <?php echo $DATA_IDENTITAS['tahun_anggaran']; ?></strong></center>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<center style="font-weight: bold; font-size: 15px;"><strong>HARGA PEKERJAAN</strong></center>
<br>
<center style="font-weight: bold; font-size: 15px;"><strong>Rp.<?php echo number_format($DATA_IDENTITAS['jumlah_netto'], 0,",","."); ?></strong></center><br>
<center style="font-weight: bold; font-size: 18px;"><strong><?php echo Terbilang($DATA_IDENTITAS['jumlah_netto']) ?> Rupiah</strong></center>
<br>
<br>
<br>
<br>
<br>
<br>
<center style="font-weight: bold; font-size: 18px;"><strong>PELAKSANA PEKERJAAN</strong></center><br>
<center style="font-weight: bold; font-size: 18px;"><strong><?php echo $DATA_IDENTITAS['nama_supplier']; ?></strong></center>
<center style="font-size: 18px;"><?php echo $DATA_IDENTITAS['alamat']; ?></center>
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
$dompdf->stream('Cover.pdf',array('Attachment' => 0));
?>
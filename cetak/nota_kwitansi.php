<?php
ob_start();
session_start();
include 'connect.php';
$idxdaftar = $_GET['idxdaftar'];
//$idxdaftar = 665939;

$sqlidentitas = "SELECT
    ROUND(SUM(a.total_keseluruhan), 0) AS total,
    b.nama AS namapasien,
    a.pj_bayar,
    CONCAT('Biaya Pelayanan Kesehatan ',
            d.nama,
            ' RSUD Besemah Pagar Alam Pasien a/n ',
            b.nama,
            ' pada ',
            c.userlevelname) AS gunabayar,a.pj_bayar,
			DATE_FORMAT(a.tglreg, '%d-%m-%Y') AS tglreg,
			e.pd_nickname as namakasir,a.no_faktur
FROM
    data a
        LEFT JOIN
    m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    userlevels c ON a.userlevelid = c.userlevelid
        LEFT JOIN
    l_jenis_pelayanan_kasir d ON c.id_jenis_pelayanan_kasir = d.id_jenis_pelayanan_kasir
		LEFT JOIN
    master_login e ON a.uidkasir = e.username
WHERE
    a.idxdaftar = $idxdaftar
GROUP BY a.idxdaftar";

$queryidentitas = mysqli_query($mysqli, $sqlidentitas);
$DATA_IDENTITAS = mysqli_fetch_array($queryidentitas);

function Terbilang($nilai) {
    $huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
    if ($nilai == 0) {
        return "";
    } elseif ($nilai < 12 & $nilai != 0) {
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
    } elseif ($nilai < 1000000000000) {
        return Terbilang($nilai / 1000000000) . " Milyar " . Terbilang($nilai % 1000000000);
    } elseif ($nilai < 100000000000000) {
        return Terbilang($nilai / 1000000000000) . " Trilyun " . Terbilang($nilai % 1000000000000);
    } elseif ($nilai <= 100000000000000) {
        return "Maaf Tidak Dapat di Prose Karena Jumlah nilai Terlalu Besar ";
    }
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Kwitansi Pembayaran Umum</title>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}

.tabel {
	border-collapse: collapse;
	font-size: 12px;
	text-align: right;
}

.header {
	font-size: 12px;
}
.footer {
	font-size: 12px;
}

.pagebreak {
		page-break-before: always;
	}

</style>
</head>

<body>
<table width="100%" border="0" cellpadding="-3px" cellspacing="0px">
    <tr>
      <td width="10%" rowspan="3" align="right"><img src="http://localhost/simrs/cetak/gambar/logorsud.png" height="70px" /></td>
      <td width="90%" align="center" style="font-size: 16px">PEMERINTAH KOTA PAGAR ALAM</td>
    </tr>
    <tr>
      <td align="center"><strong style="font-size: 21px">RUMAH SAKIT UMUM DAERAH BESEMAH PAGAR ALAM</strong></td>
    </tr>
    <tr>
      <td align="center" style="font-size: 14px">Jl. Ais Nasution No.03 Pagar Alam Utara<br>+62 730 621 118<br>Email:pagaralamrsudbesemah@gmail.com</td>
    </tr>
</table>
<hr>
<div align="center"><strong>KWITANSI</strong></div>
<table width="100%" border="0" cellspacing="10">
  <tbody>
    <tr>
      <td width="4%">&nbsp;</td>
      <td width="25%">No</td>
      <td width="1%">:</td>
      <td width="70%"><?php echo $DATA_IDENTITAS['no_faktur']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Telah Diterima Dari</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['pj_bayar']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Uang Sebanyak</td>
      <td>:</td>
      <td><?php echo Terbilang($DATA_IDENTITAS['total']) ?> Rupiah</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">Guna Membayar</td>
      <td valign="top">:</td>
      <td valign="top"><?php echo $DATA_IDENTITAS['gunabayar']; ?></td>
    </tr>
  </tbody>
</table>

<table width="100%" border="0">
  <tbody>
     <tr>
       <td align="center">&nbsp;</td>
       <td colspan="6" align="right">&nbsp;</td>
       <td align="center">&nbsp;</td>
     </tr>
     <tr>
       <td width="29%" align="center">&nbsp;</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td width="32%" align="center">Pagaralam, <?php echo $DATA_IDENTITAS['tglreg']; ?></td>
    </tr>
     <tr>
       <td align="center">&nbsp;</td>
       <td colspan="6" align="right">&nbsp;</td>
       <td align="center" class="total">Petugas Kasir</td>
     </tr>
     <tr>
      <td align="right">&nbsp;</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td align="center" class="total">&nbsp;</td>
    </tr>
     <tr>
       <td align="center">&nbsp;</td>
       <td colspan="6" align="right">&nbsp;</td>
       <td align="center" class="footer">&nbsp;</td>
     </tr>
     <tr>
      <td align="center">Terbilang</td>
      <td colspan="6" style="font-size: 20px" align="left">: <strong>Rp.<?php echo number_format($DATA_IDENTITAS['total'], 0, ",", "."); ?>,-</strong></td>
      <td align="center" class="footer"><u><?php echo $DATA_IDENTITAS['namakasir']; ?></u></td>
    </tr>
        </tbody>
      </table>

</body>
</html>
<?php
$html = ob_get_clean();
require_once "../vendor/autoload.php";
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->setIsRemoteEnabled(true);
$dompdf = new Dompdf($options);
$paper_size = [0, 0, 8.66 * 72, 5.51 * 72];
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporan_status.pdf', ['Attachment' => 0]);
?>


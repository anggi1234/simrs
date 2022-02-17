<?php
ob_start();
session_start();
include 'connect.php';
$idxdaftar = $_GET['idxdaftar'];
$username = $_GET['username'];
//$username  = 'rusmiatin';
//$idxdaftar = 665939;

$sqlidentitas = "SELECT
    a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y %H:%i:%s') AS tglmasuk
FROM
    data a
        LEFT JOIN
    m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    data_kamar d ON a.idxdaftar = d.idxdaftar
WHERE
    a.idxdaftar = $idxdaftar order by a.idxdaftar asc limit 1";

$queryidentitas = mysqli_query($mysqli, $sqlidentitas);
$DATA_IDENTITAS = mysqli_fetch_array($queryidentitas);

$sqlusername = "SELECT
    a.pd_nickname, b.userlevelname
FROM
    master_login a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid where a.username='$username'";
$queryusername = mysqli_query($mysqli, $sqlusername);
$DATA_USERNAME = mysqli_fetch_array($queryusername);

$sqltotal   = "select sum(total_keseluruhan) as total from data where idxdaftar=$idxdaftar";
$querytotal = mysqli_query($mysqli, $sqltotal);
$DATA_TOTAL = mysqli_fetch_array($querytotal);

$sqlitemobat = "
    SELECT sum(biaya_obat)-sum(biaya_obat_retur) as total_obat FROM data where idxdaftar=$idxdaftar";
$queryitemobat   = mysqli_query($mysqli, $sqlitemobat);
$DATA_TOTAL_OBAT = mysqli_fetch_array($queryitemobat);

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>REKAP TOTALS</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 0.5 cm;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}

.tabel {
    border-collapse:collapse;
	font-size: 11px;
}

.kosong {
    border:none;
}

.header {
	font-size: 12px;
}
.footer {
	font-size: 14px;
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


<div align="center"><strong>DAFTAR TOTAL BIAYA ADMINISTRASI PASIEN</strong></div>



<table width="100%" class="header" border="0">
    <tr>
      <td width="18%">No. RM</td>
      <td width="27%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="19%">Status Pembayaran </td>
      <td width="36%">: <?php echo $DATA_IDENTITAS['carabayar']; ?></td>
    </tr>
    <tr>
      <td>Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['nama']; ?></td>
      <td>Tanggal Masuk</td>
      <td>: <?php echo $DATA_IDENTITAS['tglmasuk']; ?></td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
  </tr>
    <tr>
      <td>Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS['jeniskelamin']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td colspan="3">: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
</table>




<table width="100%" border="1" class="tabel">
  <?php
$sqlitemunit = "SELECT
    b.userlevelname, a.kelas,
    a.total_keseluruhan - (ifnull(a.biaya_obat,0) - ifnull(a.biaya_obat_retur,0)) AS total
FROM
    data a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
WHERE
    a.idxdaftar = $idxdaftar";
$queryitemunit = mysqli_query($mysqli, $sqlitemunit);

$no = 1;
while ($data = mysqli_fetch_assoc($queryitemunit)) {
    echo '<tr>
		<td width="39%" bgcolor="#FFFFFF"><strong>TOTAL ' . $data['userlevelname'] . '</strong></td>
		<td width="6%" align="right" bgcolor="#FFFFFF">Kelas</td>
		<td width="4%" align="center" bgcolor="#FFFFFF">' . $data["kelas"] . '</td>
		<td width="51%" align="right" bgcolor="#FFFFFF">' . number_format($data['total'], 0, ",", ".") . '</td>
	  </tr>';
    $no++;
}?>


  <tr>
    <td bgcolor="#FFFFFF"><strong>TOTAL BIAYA OBAT (FARMASI)</strong></td>
    <td colspan="3" align="right" bgcolor="#FFFFFF">
		<?php echo number_format($DATA_TOTAL_OBAT['total_obat'], 0, ",", "."); ?>
	</td>
  </tr>

  <tr>
    <td colspan="4" align="center" bgcolor="#FFFFFF">

    	<table width="100%" border="0">
        <tbody>
     <tr>
       <td width="33%" align="center">Petugas Administrasi</td>
      <td colspan="6" align="right">Sub Total</td>
      <td width="15%" align="right">Rp<?php echo number_format($DATA_TOTAL['total'], 0, ",", "."); ?></td>
    </tr>
     <tr>
       <td align="right">&nbsp;</td>
       <td colspan="6" align="right">&nbsp;</td>
       <td align="right" class="total">&nbsp;</td>
     </tr>
     <tr>
      <td align="right">&nbsp;</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td align="right" class="total">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_USERNAME['pd_nickname']; ?></td>
      <td colspan="6" align="right"><strong>TOTAL KESELURUHAN</strong></td>
      <td align="right" class="footer"><strong>Rp<?php echo number_format($DATA_TOTAL['total'], 0, ",", "."); ?></strong></td>
    </tr>
        </tbody>
      </table>


    </td>
  </tr>
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
$paper_size = [0, 0, 8.26 * 72, 12.99 * 72];
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('notafarmasi.pdf', ['Attachment' => 0]);
?>
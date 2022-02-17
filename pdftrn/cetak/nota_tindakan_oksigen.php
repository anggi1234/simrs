<?php
ob_start();
session_start();
include 'connect.php';
$idxdaftar = $_GET['idxdaftar'];
$username = $_GET['username'];
//$username  = 'rusmiatin';
//$idxdaftar = 665939;

$sqlitem = "SELECT
    b.nama_tindakan,
    a.tarif_oksigen,
    a.qty_jam,
    a.qty_liter,
    a.total
FROM
    data_oksigen a
        LEFT JOIN
    master_tindakan b ON a.id_tindakan_oksigen = b.id_tindakan
    where a.idxdaftar=$idxdaftar";
$queryitemoksigen = mysqli_query($mysqli, $sqlitem);

$sqlidentitas = "SELECT
    a.idxdaftar,
    a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y %H:%i:%s') AS tglmasuk,
    DATE_FORMAT(a.tglout, '%d-%m-%Y %H:%i:%s') AS tglout,
    DATE_FORMAT(a.tglout, '%d-%m-%Y') AS tglcetak,
    e.userlevelname
FROM
    data a
        LEFT JOIN
    m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    userlevels e ON a.userlevelid = e.userlevelid
WHERE
    a.idxdaftar =$idxdaftar";

$queryidentitas = mysqli_query($mysqli, $sqlidentitas);
$DATA_IDENTITAS = mysqli_fetch_array($queryidentitas);

$sqltotal = "SELECT
    sum(a.total) as total
FROM
    data_oksigen a
        LEFT JOIN
    master_tindakan b ON a.id_tindakan_oksigen = b.id_tindakan
    where a.idxdaftar=$idxdaftar";

$querytotal = mysqli_query($mysqli, $sqltotal);
$DATA_TOTAL = mysqli_fetch_array($querytotal);

$sqlusername = "SELECT
    a.pd_nickname, b.userlevelname
FROM
    master_login a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
WHERE
    a.username ='$username'";
$queryusername = mysqli_query($mysqli, $sqlusername);
$DATA_USERNAME = mysqli_fetch_array($queryusername);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BIAYA LABORATORIUM</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}

.tabel {
    border-collapse:collapse;
	font-size: 12px;
}

.kosong {
    border:none;
}

.header {
	font-size: 12px;
}
.footer {
	font-size: 12px;
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

<center>
  <span style="font-size: 14px">RINCIAN BIAYA OKSIGEN</span>
</center>

<table width="100%" border="0" cellpadding="1" cellspacing="1" class="footer">
    <tr>
      <td width="13%">No. RM</td>
      <td width="43%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="19%">No. Pelayanan</td>
      <td width="25%">: <?php echo $DATA_IDENTITAS['idxdaftar']; ?></td>
    </tr>
    <tr>
      <td>Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['nama']; ?></td>
      <td>Status Pembayaran </td>
      <td>: <?php echo $DATA_IDENTITAS['carabayar']; ?></td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
      <td>Tanggal Masuk</td>
      <td>: <?php echo $DATA_IDENTITAS['tglmasuk']; ?></td>
  </tr>
    <tr>
      <td>Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS['jeniskelamin']; ?></td>
      <td>Tanggal Keluar</td>
      <td>: <?php echo $DATA_IDENTITAS['tglout']; ?></td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td>: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
      <td>Dari Unit</td>
      <td>: <?php echo $DATA_IDENTITAS['userlevelname']; ?></td>
    </tr>
</table>


<table width="100%" class="tabel" border="1">
    <tr>
	  <td width="4%" align="left" class="a"><strong>No</strong></td>
      <td width="39%" align="left" class="a"><strong>Jenis Oksigen</strong></td>
      <td width="12%" align="center" class="a"><strong>Jumlah Jam</strong></td>
      <td width="9%" align="center" class="a"><strong>Jumlah Liter</strong></td>
      <td width="16%" align="center" class="a"><strong>Tarif</strong></td>
      <td width="20%" align="center" class="a"><strong>Total</strong></td>
  </tr>
	<?php
$no = 1;
while ($data = mysqli_fetch_assoc($queryitemoksigen)) {
    echo '<tr>';
    echo '<td>' . $no . '</td>';
    echo '<td>' . $data['nama_tindakan'] . '</td>';
    echo '<td align="left">' . $data['qty_jam'] . ' jam</td>';
    echo '<td align="center">' . $data['qty_liter'] . ' liter</td>';
    echo '<td align="right">' . number_format($data['tarif_oksigen'], 0, ",", ".") . '</td>';
    echo '<td align="right"><strong>' . number_format($data['total'], 0, ",", ".") . '</strong></td>';
    echo '</tr>';

    $no++;
}
?>
	<tr>
      <td colspan="6" align="right"><table width="100%" border="0">
        <tbody>
     <tr>
       <td align="center">Pagaralam, <?php echo $DATA_IDENTITAS['tglcetak']; ?></td>
       <td colspan="6" align="right">&nbsp;</td>
       <td align="right" class="total">&nbsp;</td>
     </tr>
     <tr>
       <td width="26%" align="center">Petugas Administrasi</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td width="15%" align="right" class="total">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td align="right" class="total">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_USERNAME['pd_nickname']; ?></td>
      <td colspan="6" align="right">Total Keseluruhan</td>
      <td align="right" class="total"><strong>Rp.<?php echo number_format($DATA_TOTAL['total'], 0, ",", "."); ?></strong></td>
    </tr>
        </tbody>
      </table></td>
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
$paper_size = [0, 0, 8.66 * 72, 5.51 * 72];
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('notapenunjang.pdf', ['Attachment' => 0]);
?>
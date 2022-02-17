<?php
ob_start();
session_start();
include 'connect.php';
$username = $_GET['username'];
$idxdaftar = $_GET['idxdaftar'];
//$username  = 'rusmiatin';
//$idxdaftar = 665939;

$sqlitem = "SELECT
    replace(f.userlevelname, 'FARMASI','') as userlevelname,
    date_format(a.tanggal, '%d-%m-%Y') as tanggal,
    d.nama_obat,
    d.satuan,
    a.qty,
    IFNULL(c.qty, 0) AS qty_retur,
    a.tarif_obat,
    a.total
FROM
    bill_detail_permintaan_obat a
        LEFT JOIN
    master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
        LEFT JOIN
    bill_detail_permintaan_retur_obat c ON a.id_bill_detail_permintaan_obat = c.id_bill_detail_permintaan_obat
        LEFT JOIN
    master_obat d ON b.id_obat = d.id_obat
        LEFT JOIN
    bill_detail_permintaan_obat_master e ON a.id_bill_detail_permintaan_obat_master = e.id_bill_detail_permintaan_obat_master
        LEFT JOIN
    userlevels f ON b.userlevelid = f.userlevelid
WHERE
    e.idxdaftar = $idxdaftar and a.id_status_konfirmasi=2";
$queryitem = mysqli_query($mysqli, $sqlitem);

$sqlidentitas = "SELECT
    a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y %T') AS tglmasuk,
    DATE_FORMAT(d.tanggal_keluar, '%d-%m-%Y %T') AS tglkeluar,
    a.biaya_obat-ifnull(a.biaya_obat_retur,0) as total_keseluruhan,
    e.keterangan AS status_keluar,
  	g.userlevelname,
  	a.biaya_obat,
  	ifnull(a.biaya_obat_retur,0) as biaya_obat_retur
FROM
    data a
        LEFT JOIN
    m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    data_kamar d ON a.idxdaftar = d.idxdaftar
	        LEFT JOIN
    m_statuskeluar e ON e.status = d.status
	LEFT JOIN
	userlevels g ON a.userlevelid = g.userlevelid
WHERE
    a.idxdaftar = $idxdaftar";

$queryidentitas = mysqli_query($mysqli, $sqlidentitas);
$DATA_IDENTITAS = mysqli_fetch_array($queryidentitas);

$sqlusername = "SELECT
    a.pd_nickname as nama, b.userlevelname
FROM
    master_login a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
WHERE
    a.username = '$username'";
$queryusername = mysqli_query($mysqli, $sqlusername);
$DATA_USERNAME = mysqli_fetch_array($queryusername);

$sqltotal = "SELECT
    SUM(a.biaya_obat) AS biaya_obat,
    SUM(IFNULL(a.biaya_obat_retur, 0)) AS retur,
    SUM(a.biaya_obat) - SUM(IFNULL(a.biaya_obat_retur, 0)) AS total
FROM
    data a
WHERE
    a.idxdaftar = $idxdaftar";
$querytotal = mysqli_query($mysqli, $sqltotal);
$DATA_TOTAL = mysqli_fetch_array($querytotal);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BIAYA OBAT</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.7 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
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
  <span style="font-size: 14px"><strong>RINCIAN OBAT</strong></span>
</center>



<table width="100%" border="0" cellpadding="1" cellspacing="0" class="header">
    <tr>
      <td width="18%" align="left">No. Rekam Medis</td>
      <td width="43%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="19%" align="left">No. Pelayanan</td>
      <td width="20%">: <?php echo $DATA_IDENTITAS['idxdaftar']; ?></td>
    </tr>
    <tr>
      <td align="left">Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['nama']; ?></td>
      <td align="left">Status Pembayaran </td>
      <td>: <?php echo $DATA_IDENTITAS['carabayar']; ?></td>
    </tr>
    <tr>
      <td align="left">Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
      <td align="left">Tanggal Masuk</td>
      <td>: <?php echo $DATA_IDENTITAS['tglmasuk']; ?></td>
  </tr>
    <tr>
      <td align="left">Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS['jeniskelamin']; ?></td>
      <td align="left">Tanggal Keluar</td>
      <td>: <?php echo $DATA_IDENTITAS['tglkeluar']; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top">Alamat</td>
      <td valign="top">: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
      <td align="left" valign="top">Unit</td>
      <td valign="top">: <?php echo $DATA_USERNAME['userlevelname']; ?></td>
    </tr>
</table>


<table width="100%" class="tabel" border="1">
    <tr>
	  <td width="2%" align="left" class="a"><strong>No</strong></td>
	  <td width="14%" align="left" class="a"><strong>Unit Farmasi</strong></td>
	  <td width="11%" align="left" class="a"><strong>Tanggal</strong></td>
      <td width="30%" align="left" class="a"><strong>Nama Obat</strong></td>
      <td width="8%" align="center" class="a"><strong>Satuan</strong></td>
      <td width="5%" align="center" class="a"><strong>Qty</strong></td>
	  <td width="5%" align="center" class="a"><strong>Retur</strong></td>
      <td width="11%" align="center" class="a"><strong>Harga</strong></td>
      <td width="14%" align="center" class="a"><strong>Total</strong></td>
  </tr>
	<?php
if (mysqli_num_rows($queryitem) == 0) {
    echo '<tr><td colspan="9">Tidak ada data</td></tr>';
} else {
    $no = 1;
    while ($data = mysqli_fetch_assoc($queryitem)) {
        echo '<tr>';
        echo '<td class="a kosong">' . $no . '</td>';
        echo '<td class="a kosong">' . $data['userlevelname'] . '</td>';
        echo '<td class="a kosong">' . $data['tanggal'] . '</td>';
        echo '<td class="a kosong">' . $data['nama_obat'] . '</td>';
        echo '<td class="a kosong">' . $data['satuan'] . '</td>';
        echo '<td class="a kosong"><div align="center">' . $data['qty'] . '</div></td>';
        echo '<td class="a kosong"><div align="center">' . $data['qty_retur'] . '</div></td>';
        echo '<td class="a kosong"><div align="right">' . number_format($data['tarif_obat'], 2, ",", ".") . '</div></td>';
        echo '<td class="a kosong"><div align="right">' . number_format($data['total'], 2, ",", ".") . '</div></td>';
        echo '</tr>';

        $no++;
    }
}

?>
	<tr>
      <td colspan="9" align="right"><table width="100%" border="0">
        <tbody>
     <tr>
       <td width="32%" align="center">Petugas Farmasi</td>
      <td colspan="6" align="right">Sub Total</td>
      <td width="15%" align="right" class="total">Rp.<?php echo number_format($DATA_TOTAL['biaya_obat'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td colspan="6" align="right">Sub Total  Retur</td>
      <td align="right" class="total">Rp.<?php echo number_format($DATA_TOTAL['retur'], 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_USERNAME['nama']; ?></td>
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
$paper_size = [0, 0, 8.26 * 72, 12.99 * 72];
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('nota_farmasi.pdf', ['Attachment' => 0]);
?>
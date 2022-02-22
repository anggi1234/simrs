<?php
ob_start();
session_start();
include 'connect.php';
$idxdaftar = $_GET['idxdaftar'];
$username = $_GET['username'];
//$username  = 'rusmiatin';
//$idxdaftar = 665939;

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

$sqlidentitas = "SELECT
  d.idxdaftar,
	d.id_bill_detail_tarif_detail
FROM
    bill_detail_tarif_detail d
WHERE
    d.idxdaftar =$idxdaftar and d.userlevelid=16";

$queryidentitas = mysqli_query($mysqli, $sqlidentitas);

if (mysqli_num_rows($queryidentitas) == 0) {
    echo '<center>Tidak ada pemeriksaan laboratorium</center>';
} else {
    $no = 1;
    while ($rows = mysqli_fetch_array($queryidentitas)) {
        $sqlitemid = "SELECT
    a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y') AS tglmasuk,
    DATE_FORMAT(d.tanggal, '%d-%m-%Y') AS tglorder,
	DATE_FORMAT(d.tanggal, '%d-%m-%Y') AS tglcetak,
    e.userlevelname,
	d.id_bill_detail_tarif_detail
FROM
    bill_detail_tarif_detail d
        LEFT JOIN
    data a ON d.idxdaftar = a.idxdaftar
        LEFT JOIN
    m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    userlevels e ON a.userlevelid = e.userlevelid
WHERE
    d.id_bill_detail_tarif_detail = " . $rows["id_bill_detail_tarif_detail"] . "
	and d.userlevelid=16";
        $queryitemid = mysqli_query($mysqli, $sqlitemid);
        $DATA_ID     = mysqli_fetch_array($queryitemid);

        echo '
<div class="pagebreak">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BIAYA LABORATORIUM</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 1 cm;
			margin-right: 1cm;
			margin-bottom: 0.5 cm;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}

.tabel {
    border-collapse:collapse;
	font-size: 11px;
}

.pagebreak {
		page-break-after: always;
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
  <span style="font-size: 14px">RINCIAN BIAYA PEMERIKSAAN LABORATORIUM</span>
</center>

<table width="100%" border="0" cellpadding="1" cellspacing="1" class="footer">
    <tr>
      <td width="13%">No. RM</td>
      <td width="43%">: ' . $DATA_ID['nomr'] . '</td>
      <td width="19%">Dari Unit</td>
      <td width="25%">: ' . $DATA_ID['userlevelname'] . '</td>
    </tr>
    <tr>
      <td>Nama Pasien</td>
      <td>: ' . $DATA_ID['nama'] . '</td>
      <td>Status Pembayaran </td>
      <td>: ' . $DATA_ID['carabayar'] . '</td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>: ' . $DATA_ID['tgllahir'] . '</td>
      <td>Tanggal Masuk</td>
      <td>: ' . $DATA_ID['tglmasuk'] . '</td>
  </tr>
    <tr>
      <td>Jenis Kelamin</td>
      <td>: ' . $DATA_ID['jeniskelamin'] . '</td>
      <td>Tanggal Order</td>
      <td>: ' . $DATA_ID['tglorder'] . '</td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td>: ' . $DATA_ID['alamat'] . '</td>
      <td></td>
      <td></td>
    </tr>
</table>


<table width="100%" class="tabel" border="1">
    <tr>
	  <td width="10" align="left" class="a"><strong>No</strong></td>
      <td width="189" align="left" class="a"><strong>Nama Produk</strong></td>
      <td width="50" align="center" class="a"><strong>Kuantitas</strong></td>
      <td width="92" align="center" class="a"><strong>Total</strong></td>
  </tr>';

        $sqlitem = "SELECT
    b.nama_tindakan, a.qty, a.total
FROM
    data_tindakan a
        LEFT JOIN
    master_tindakan b ON a.id_tindakan = b.id_tindakan
        LEFT JOIN
    data c ON a.idxdaftar= c.idxdaftar
WHERE
    a.id_bill_detail_tarif_detail = " . $rows["id_bill_detail_tarif_detail"] . " and b.userlevelid=16";
        $queryitem = mysqli_query($mysqli, $sqlitem);

        $sqltotal = "SELECT
    sum(a.total) as total
FROM
    data_tindakan a
        LEFT JOIN
    master_tindakan b ON a.id_tindakan = b.id_tindakan
        LEFT JOIN
    data c ON a.idxdaftar= c.idxdaftar
WHERE
    a.id_bill_detail_tarif_detail = " . $rows["id_bill_detail_tarif_detail"] . " and b.userlevelid=16";

        $querytotal = mysqli_query($mysqli, $sqltotal);
        $DATA_TOTAL = mysqli_fetch_array($querytotal);

        if (mysqli_num_rows($queryitem) == 0) {
            echo '<tr><td colspan="4">Tidak ada data</td></tr>';
        } else {
            $no = 1;
            while ($data = mysql_fetch_assoc($queryitem)) {
                echo '<tr>';
                echo '<td class="a kosong">' . $no . '</td>';
                echo '<td class="a kosong">' . $data['nama_tindakan'] . '</td>';
                echo '<td class="a kosong"><div align="center">' . $data['qty'] . '</div></td>';
                echo '<td class="a kosong"><div align="right">' . number_format($data['total'], 0, ",", ".") . '</div></td>';
                echo '</tr>';

                $no++;
            }
        }

        echo '<tr>
      <td colspan="4" align="right"><table width="100%" border="0">
        <tbody>
     <tr>
       <td align="center">Pagaralam, ' . $DATA_ID['tglcetak'] . '</td>
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
      <td align="center">' . $DATA_USERNAME['pd_nickname'] . '</td>
      <td colspan="6" align="right">Total Keseluruhan</td>
      <td align="right" style="font-size: 16px" class="total"><strong>Rp' . number_format($DATA_TOTAL['total'], 0, ",", ".") . '</strong></td>
    </tr>
        </tbody>
      </table></td>
    </tr>

  </table>


</body>
</html></div>';
    }
}
;

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
$dompdf->stream('nota_laboratorium.pdf', ['Attachment' => 0]);
?>




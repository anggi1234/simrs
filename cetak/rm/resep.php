<?php
ob_start();
session_start();
include '../connect.php';
// $idxdaftar = $_GET['idxdaftar'];
$idxdaftar = 665939;

$sqlitemtotal = "SELECT
    a.nomr,
    b.nama,
    b.alamat,
    b.tgllahir,
    c.userlevelname,
    a.tglreg,
    d.nama AS carabayar,
    e.nama_dokter
FROM
    data a
        LEFT JOIN
    m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    userlevels c ON a.userlevelid = c.userlevelid
        LEFT JOIN
    m_carabayar d ON a.kdcarabayar = d.kode
        LEFT JOIN
    m_dokter e ON a.kddokter = e.kddokter
        AND a.userlevelid = e.userlevelid
WHERE
    idxdaftar = $idxdaftar";
$queryitemtotal = mysqli_query($mysqli, $sqlitemtotal);
$DATA_IDENTITAS = mysqli_fetch_array($queryitemtotal);

$dayList = [
    'Sun' => 'Minggu',
    'Mon' => 'Senin',
    'Tue' => 'Selasa',
    'Wed' => 'Rabu',
    'Thu' => 'Kamis',
    'Fri' => 'Jumat',
    'Sat' => 'Sabtu',
];
//echo "Tanggal {$tanggal} adalah hari : " . $dayList[$day];

function tanggal_indo($tanggal) {
    $bulan = [1 => 'Januari',
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
        'Desember',
    ];
    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];
}

$sqlidmasterada = mysqli_query($mysqli, "SELECT
  id_bill_detail_permintaan_obat_master as id_master
FROM
  bill_detail_permintaan_obat_master
WHERE
  idxdaftar = $idxdaftar AND (id_jenis_resep = 1 OR id_jenis_resep is null)");

while ($rows = mysqli_fetch_array($sqlidmasterada)) {
    echo '<div class="pagebreak">
<html>
<head>
<meta charset="utf-8">
<title>Data Pemberian E-Resep</title>
<style type="text/css">
@page {
          margin-top: 0.5 cm;
          margin-left: 0.2 cm;
    margin-right: 0.2 cm;
    margin-bottom: 0.2 cm;
  font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
}

.tabel {
  border-collapse:collapse;
font-size: 12px;
}

.header {
font-size: 12px;
}
.footer {
font-size: 12px;
}

.pagebreak {
  page-break-after: always;
}


.footer {
 position: absolute;
 left: 0;
 bottom: 5px;
 width: 100%;
 text-align: center;
}

</style>
</head>

<body>

<table width="100%" border="0" cellpadding="-3px" cellspacing="0px">
  <tr>
    <td width="10%" rowspan="3" align="right"><img src="http://localhost/simrs/cetak/gambar/logorsud.png" height="40px" /></td>
    <td width="90%" align="center" style="font-size: 10px">PEMERINTAH KOTA PAGAR ALAM</td>
  </tr>
  <tr>
    <td align="center"><strong style="font-size: 15px">RUMAH SAKIT UMUM DAERAH BESEMAH PAGAR ALAM</strong></td>
  </tr>
  <tr>
    <td align="center" style="font-size: 8px">Jl. Ais Nasution No.03 Pagar Alam Utara<br>+62 730 621 118<br>Email:pagaralamrsudbesemah@gmail.com</td>
  </tr>
</table>

<hr>



<table width="100%" class="tabel" style="font-size:10px" border="0">
<tbody>
  <tr>
    <td width="24%">Ruang/Poli</td>
    <td width="76%">: ' . $DATA_IDENTITAS['userlevelname'] . '</td>
  </tr>
  <tr>
    <td>Nama Dokter</td>
    <td>: ' . $DATA_IDENTITAS['nama_dokter'] . '</td>
  </tr>
  <tr>
    <td>Tanggal</td>
    <td>: ' . ($DATA_IDENTITAS['tglreg'] != '') ? tanggal_indo($DATA_IDENTITAS['tglreg']) : '' . '</td>
  </tr>
  <tr>
    <td>Alergi</td>
    <td>: </td>
  </tr>
</tbody>
</table>

<table width="100%" border="0" style="font-size:10px">
  <tbody>';

    $sqlobatjadi = "SELECT
  b.id_bill_detail_permintaan_obat_master,d.nama_obat, a.qty, a.qty_temp, b.jumlah_racikan, e.nama_resep as aturan_pakai,f.pd_nickname,f.signature
FROM
  bill_detail_permintaan_obat a
      LEFT JOIN
  bill_detail_permintaan_obat_master b ON a.id_bill_detail_permintaan_obat_master = b.id_bill_detail_permintaan_obat_master
      LEFT JOIN
  master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
      LEFT JOIN
  master_obat d ON c.id_obat = d.id_obat
  LEFT JOIN
master_resep e on a.id_master_resep=e.id_master_resep
  LEFT JOIN
  master_login f ON b.username = f.username
WHERE
    a.id_bill_detail_permintaan_obat_master = " . $rows['id_master'] . "
        AND (b.id_jenis_resep = 1 OR b.id_jenis_resep is null) and nama_obat not like '%JASA%'";
    $queryobatjadi = mysqli_query($mysqli, $sqlobatjadi);

    while ($isi = mysqli_fetch_array($queryobatjadi)) {
        echo '<tr>
                <td width="74%" style="padding: 5px">R/ ' . $isi['nama_obat'] . '<br><div style="text-indent: 20px;">' . $isi['aturan_pakai'] . '</div></td>
                <td width="26%">Qty: ' . $isi['qty'] . '</td>
              </tr>';
    }

    echo '</tbody>
</table>




<div class="footer">
  <table width="100%" class="tabel" border="0">
<tbody>
  <tr>
    <td width="24%">Nama</td>
    <td width="76%">: ' . $DATA_IDENTITAS['nama'] . '</td>
  </tr>
  <tr>
    <td>No RM</td>
    <td>: ' . $DATA_IDENTITAS['nomr'] . '</td>
  </tr>
  <tr>
    <td>Alamat</td>
    <td>: ' . $DATA_IDENTITAS['alamat'] . '</td>
  </tr>
  <tr>
    <td>Unit</td>
    <td>: ' . $DATA_IDENTITAS['userlevelname'] . '</td>
  </tr>
  <tr>
    <td>Penjamin</td>
    <td>: ' . $DATA_IDENTITAS['carabayar'] . '</td>
  </tr>
</tbody>
</table>
<br>
</div>


</body>
</html></div>';
}
;

$sqlidmaster = mysqli_query($mysqli, "SELECT
    id_bill_detail_permintaan_obat_master as id_master
FROM
    bill_detail_permintaan_obat_master
WHERE
    idxdaftar = $idxdaftar AND (id_jenis_resep = 2 OR id_jenis_resep = 3)");

while ($rows = mysqli_fetch_array($sqlidmaster)) {
    echo '<div class="pagebreak">
<html>
<head>
<meta charset="utf-8">
<title>Data Pemberian E-Resep</title>
	<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.2 cm;
			margin-right: 0.2 cm;
			margin-bottom: 0.2 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}

.tabel {
    border-collapse:collapse;
	font-size: 12px;
}

.header {
	font-size: 12px;
}
.footer {
	font-size: 12px;
}

.pagebreak {
		page-break-after: always;
	}


.footer {
   position: absolute;
   left: 0;
   bottom: 5px;
   width: 100%;
   text-align: center;
}

</style>
</head>

<body>

<table width="100%" border="0" cellpadding="-3px" cellspacing="0px">
    <tr>
      <td width="10%" rowspan="3" align="right"><img src="http://localhost/simrs/cetak/gambar/logorsud.png" height="40px" /></td>
      <td width="90%" align="center" style="font-size: 10px">PEMERINTAH KOTA PAGAR ALAM</td>
    </tr>
    <tr>
      <td align="center"><strong style="font-size: 15px">RUMAH SAKIT UMUM DAERAH BESEMAH PAGAR ALAM</strong></td>
    </tr>
    <tr>
      <td align="center" style="font-size: 8px">Jl. Ais Nasution No.03 Pagar Alam Utara<br>+62 730 621 118<br>Email:pagaralamrsudbesemah@gmail.com</td>
    </tr>
</table>

  <hr>



<table width="100%" class="tabel" style="font-size:10px" border="0">
  <tbody>
    <tr>
      <td width="24%">Ruang/Poli</td>
      <td width="76%">: ' . $DATA_IDENTITAS['userlevelname'] . '</td>
    </tr>
    <tr>
      <td>Nama Dokter</td>
      <td>: ' . $DATA_IDENTITAS['nama_dokter'] . '</td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td>: ' . ($DATA_IDENTITAS['tglreg'] != '') ? tanggal_indo($DATA_IDENTITAS['tglreg']) : '' . '</td>
    </tr>
    <tr>
      <td>Alergi</td>
      <td>: </td>
    </tr>
  </tbody>
</table>



	<br><br>


	<table width="100%" style="font-size:10px" border="0">
	  <tbody>
	    <tr>
	      <td width="84%">Nama Obat</td>
	      <td width="16%" align="center">Jumlah</td>
	    </tr>';

    $sqlobatracik = "SELECT
    b.id_bill_detail_permintaan_obat_master,d.nama_obat, a.qty, a.qty_temp, b.jumlah_racikan, e.nama_resep as aturan_pakai,f.pd_nickname,f.signature
FROM
    bill_detail_permintaan_obat a
        LEFT JOIN
    bill_detail_permintaan_obat_master b ON a.id_bill_detail_permintaan_obat_master = b.id_bill_detail_permintaan_obat_master
        LEFT JOIN
    master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
        LEFT JOIN
    master_obat d ON c.id_obat = d.id_obat
		LEFT JOIN
	master_resep e on b.aturan_pakai=e.id_master_resep
		LEFT JOIN
    master_login f ON b.username = f.username
WHERE
    a.id_bill_detail_permintaan_obat_master = " . $rows['id_master'] . "
        AND (b.id_jenis_resep = 2 OR b.id_jenis_resep = 3) and nama_obat not like '%JASA%'";
    $queryobatracik          = mysqli_query($mysqli, $sqlobatracik);
    $queryobatracikjml       = mysqli_query($mysqli, $sqlobatracik);
    $queryobatracikaturan    = mysqli_query($mysqli, $sqlobatracik);
    $queryobatracikid        = mysqli_query($mysqli, $sqlobatracik);
    $queryobatsignatureracik = mysqli_query($mysqli, $sqlobatracik);

    while ($isi = mysqli_fetch_array($queryobatracik)) {
        echo '    <tr>';
        echo '      <td width="84%"><strong>' . $isi['nama_obat'] . '</strong></td>';
        echo '      <td width="16%" align="center"><strong>' . $isi['qty_temp'] . '</strong></td>';
        echo '    </tr>';
    }

    $jml = mysqli_fetch_array($queryobatracikjml);
    echo '    <tr>';
    echo '      <td colspan="2">Jumlah : <strong>' . $jml['jumlah_racikan'] . '</strong></td>';
    echo '    </tr>';

    $aturan_pakai = mysqli_fetch_array($queryobatracikaturan);
    echo '    <tr>';
    echo '      <td colspan="2">Aturan Pakai : <strong>' . $aturan_pakai['aturan_pakai'] . '</strong></td>';
    echo '    </tr>';

    echo '  </tbody>';
    echo '</table><br>


	<div class="footer">
		<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="24%">Nama</td>
      <td width="76%">: ' . $DATA_IDENTITAS['nama'] . '</td>
    </tr>
    <tr>
      <td>No RM</td>
      <td>: ' . $DATA_IDENTITAS['nomr'] . '</td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td>: ' . $DATA_IDENTITAS['alamat'] . '</td>
    </tr>
    <tr>
      <td>Unit</td>
      <td>: ' . $DATA_IDENTITAS['userlevelname'] . '</td>
    </tr>
    <tr>
      <td>Penjamin</td>
      <td>: ' . $DATA_IDENTITAS['carabayar'] . '</td>
    </tr>
  </tbody>
</table>
	<br>
</div>


</body>
</html></div>';
}
;

$html = ob_get_clean();
require_once "../../vendor/autoload.php";
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->setIsRemoteEnabled(true);
$dompdf = new Dompdf($options);
$paper_size = [0, 0, 4.13 * 72, 8.26 * 72];
$dompdf->set_paper($paper_size, "portrait");
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("41_eresep.pdf", ["Attachment" => 0]);
?>
<?php
ob_start();
session_start();
include '../connect.php';
$idxdaftar= $_GET['idxdaftar'];
//$idxdaftar = 665939;
//print_r($idxdaftar);

$sqlidentitas = "SELECT
    a.nomr,
    b.nama,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    DATE_FORMAT(a.tglreg, '%d-%m-%Y') AS tglreg,
    DATE_FORMAT(a.tglout, '%d-%m-%Y') AS tglout,
    DATE_FORMAT(a.tglout, '%d-%m-%Y %H:%i:%s') AS tglkeluar,
    a.kelas,
    c.userlevelname,
    d.signature,
    d.no_surat_izin_praktek,
    d.pd_nickname,
    d.signature as ttd_pasien,
    b.penanggungjawab_nama
FROM
    data a
        LEFT JOIN
    m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    userlevels c ON a.userlevelid = c.userlevelid
        LEFT JOIN
    master_login d ON a.kddokter = d.kddokter
WHERE
    a.idxdaftar = $idxdaftar";
$queryidentitas = mysqli_query($mysqli, $sqlidentitas);
$DATA_IDENTITAS = mysqli_fetch_array($queryidentitas);

$sqlisi = "SELECT
    a.*,
    DATE_FORMAT(a.tanggal_masuk, '%d-%m-%Y %H:%i:%s') AS tglmasuk,
    DATE_FORMAT(a.tanggal_keluar, '%d-%m-%Y %H:%i:%s') AS tglkeluar,
    DATE_FORMAT(a.ventilator_lepas, '%d-%m-%Y %H:%i:%s') AS ven_lepas,
    DATE_FORMAT(a.ventilator_pasang, '%d-%m-%Y %H:%i:%s') AS ven_pasang,
    TIMEDIFF(ventilator_lepas, ventilator_pasang) AS lama_ventilator
FROM
    resume_rawat_inap a
	where a.idxdaftar=$idxdaftar";
$queryisi = mysqli_query($mysqli, $sqlisi);
$DATA_ISI = mysqli_fetch_array($queryisi);

$sqlkontrol = "SELECT
    b.userlevelname,a.tanggal_kontrol
FROM
    data_lain a
        LEFT JOIN
    userlevels b ON a.userlevelid_kontrol = b.userlevelid
WHERE
    idxdaftar = $idxdaftar
ORDER BY id_bill_detail_lain DESC
LIMIT 1";
$querykontrol = mysqli_query($mysqli, $sqlkontrol);
$DATA_KONTROL = mysqli_fetch_array($querykontrol);

$sqldiagnosaprimer = "SELECT
    KETERANGAN as diagnosa, icd10
FROM
    data_penyakit
WHERE
    idxdaftar = $idxdaftar
        AND jenis_diagnosa = 'PRIMER'";
$querydiagnosaprimer = mysqli_query($mysqli, $sqldiagnosaprimer);

$sqldiagnosasekunder = "SELECT
    KETERANGAN as diagnosa, icd10
FROM
    data_penyakit
WHERE
    idxdaftar = $idxdaftar
        AND jenis_diagnosa = 'SEKUNDER'";
$querydiagnosasekunder = mysqli_query($mysqli, $sqldiagnosasekunder);

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

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Fomulir Ringkasan Pasien Pulang</title>
<style type="text/css">
	@page {
            margin-top: 0.2 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.2 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
		font-size: 11px;
	}

.tabel {
    border-collapse:collapse;
}

.isi {
	border-collapse:collapse;
	font-size: 11px;
}
.pagebreak {
		page-break-before: always;
	}


</style>
</head>

<body>
<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="33%"><table width="100%" border="0">
        <tbody>
          <tr>
            <td width="23%" align="center"><img src="http://localhost/simrs/cetak/gambar/logorsud.png" height="40px" /></td>
            <td width="77%" align="center" style="font-size: 7px; font-weight: bold" valign="middle">PEMERINTAH KOTA PAGAR ALAM<br>RUMAH SAKIT UMUM DAERAH BESEMAH PAGAR ALAM<br>Jl. Ais Nasution No.03 Pagar Alam Utara<br>+62 730 621 118<br>Email:pagaralamrsudbesemah@gmail.com</td>
          </tr>
        </tbody>
      </table></td>
      <td width="33%" style="font-size: 12px"><p align="center"><strong>FORMULIR RINGKASAN<br> PASIEN PULANG <br>
          <em>(DISCHARGE SUMMARY)</em></strong><br>
      <strong></strong></p></td>
      <td width="33%" valign="middle" style="font-weight: bold"><table width="100%" style="font-size: 11px" border="0">
        <tbody>
          <tr>
            <td width="27%">NO RM</td>
            <td width="4%">:</td>
            <td width="69%"><?php echo $DATA_IDENTITAS['nomr']; ?></td>
          </tr>
          <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?php echo $DATA_IDENTITAS['nama']; ?></td>
          </tr>
          <tr>
            <td>Tgl Lahir</td>
            <td>:</td>
            <td><?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>


<table width="100%" class="isi"  border="1">
  <tbody>
    <tr>
      <td width="33%"><strong>Tanggal Masuk</strong></td>
      <td width="35%"><strong>: <?php echo isset($DATA_ISI['tglmasuk']); ?></strong></td>
      <td width="10%"><strong>Tgl Keluar</strong></td>
      <td width="22%"><strong>: <?php echo isset($DATA_ISI['tglkeluar']); ?></strong></td>
    </tr>
    <tr>
      <td><strong>Ruang</strong></td>
      <td><strong>: <?php echo $DATA_IDENTITAS['userlevelname']; ?></strong></td>
      <td><strong>Kelas</strong></td>
      <td><strong>: <?php echo $DATA_IDENTITAS['kelas']; ?></strong></td>
    </tr>
    <tr>
      <td colspan="4"><strong><em>Disi Oleh DPJP/Petugas yang berwenang</em></strong></td>
    </tr>
    <tr>
      <td colspan="4"><strong>Riwayat Kesehatan:</strong><br><?php echo isset($DATA_ISI['riwayat_kesehatan']); ?></td>
    </tr>
    <tr>
      <td colspan="4"><strong>Indikasi Pasien Masuk Dirawat:</strong> <br> <?php echo isset($DATA_ISI['indikasi']); ?></td>
    </tr>
    <tr>
      <td colspan="4"><strong>Pemeriksaan Fisik</strong></td>
    </tr>
    <tr>
      <td><strong>Subyekif</strong></td>
      <td colspan="3">: <?php echo isset($DATA_ISI['subjektif']); ?></td>
    </tr>
    <tr>
      <td><strong>Obyektif</strong></td>
      <td colspan="3"><?php echo isset($DATA_ISI['objektif']); ?></td>
    </tr>
    <tr>
      <td colspan="4"><strong>Tindakan diagnostik dan prosedur terapi yang telah dikerjakan:</strong></td>
    </tr>
    <tr>
      <td>A. Laboratorium</strong></td>
      <td colspan="3">: <?php echo isset($DATA_ISI['laboratorium']); ?></td>
    </tr>
    <tr>
      <td>B. Radiologi</strong></td>
      <td colspan="3">: <?php echo isset($DATA_ISI['radiologi']); ?></td>
    </tr>
    <tr>
      <td>C. EKG</strong></td>
      <td colspan="3">: <?php echo isset($DATA_ISI['ekg']); ?></td>
    </tr>

    <tr>
      <td colspan="4"><strong>Hasil Konsultasi:</strong><br><?php echo isset($DATA_ISI['hasil_konsultasi']); ?></td>
    </tr>
    <tr>
      <td colspan="4"><strong>Diagnosa Utama / Primer </strong>
      </td>
    </tr>


    <?php
$no = 1;
while ($data = mysqli_fetch_assoc($querydiagnosaprimer)) {
    echo '<tr>';
    echo '<td width="40%" colspan="2" style="font-size:15px;font-weight: bold;">' . $data['diagnosa'] . '</td>';
    echo '<td width="10%"><strong>ICD 10</strong></td>';
    echo '<td width="50%">' . $data['icd10'] . '</td>';
    echo '</tr>';
    $no++;
}
?>

    <tr>
      <td colspan="4"><strong>Diagnosa Sekunder </strong></td>
    </tr>

    <?php
$no = 1;
while ($data = mysqli_fetch_assoc($querydiagnosasekunder)) {
    echo '<tr>';
    echo '<td width="40%" colspan="2" style="font-size:15px;font-weight: bold;">' . $data['diagnosa'] . '</td>';
    echo '<td width="10%"><strong>ICD 10</strong></td>';
    echo '<td width="50%">' . $data['icd10'] . '</td>';
    echo '</tr>';
    $no++;
}
?>

    <tr>
      <td colspan="4"><strong>Prosedur Terapi dan Tindakan yang Telah Dikerjakan</strong>      </td>
    </tr>
    <tr>
      <td colspan="4"><?php echo isset($DATA_ISI['tindakan_prosedur']); ?></td>
    </tr>
    <tr>
      <td colspan="4"><strong>Obat yang diberikan selama di Rumah Sakit</strong></td>
    </tr>
    <tr>
      <td colspan="4">

      	<?php

$q = mysqli_query($mysqli, "SELECT
    d.nama_obat
FROM
    bill_detail_permintaan_obat a
        LEFT JOIN
    bill_detail_permintaan_obat_master b ON b.id_bill_detail_permintaan_obat_master = a.id_bill_detail_permintaan_obat_master
        LEFT JOIN
    master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
        LEFT JOIN
    master_obat d ON c.id_obat = d.id_obat
WHERE
    b.idxdaftar = $idxdaftar
        AND d.nama_obat NOT LIKE '%JASA%'
        AND d.nama_obat NOT LIKE '%KASSA%'
		AND d.nama_obat NOT LIKE '%INFUSET%'
        AND d.nama_obat NOT LIKE '%AQUADEST%'
        AND d.nama_obat NOT LIKE '%URIN BAG%'
        AND d.nama_obat NOT LIKE '%NEDLE%'
        AND d.nama_obat NOT LIKE '%APRON%'
        AND d.nama_obat NOT LIKE '%TEGADERM%'
        AND d.nama_obat NOT LIKE '%HIPAVIX%'
        AND d.nama_obat NOT LIKE '%DRESSING%'
        AND d.nama_obat NOT LIKE '%TRIWAY%'
        AND d.nama_obat NOT LIKE '%FC NO%'
        AND d.nama_obat NOT LIKE '%POUCHES%'
        AND d.nama_obat NOT LIKE '%SPUIT%'
        AND d.nama_obat NOT LIKE '%ST STERIL%'
        AND d.nama_obat NOT LIKE '%ST NON STERIL%'
        AND d.nama_obat NOT LIKE '%SPUIT%'
        AND d.nama_obat NOT LIKE '%PLESTER%'
        AND d.nama_obat NOT LIKE '%ALKOHOL%'
        AND d.nama_obat NOT LIKE '%SPALK%'
        AND d.nama_obat NOT LIKE '%MASKER%'
        AND d.nama_obat NOT LIKE '%UNDERPAD%'
        AND d.nama_obat NOT LIKE '%NASAL%'
        AND d.nama_obat NOT LIKE '%POVIDON%'
        AND d.nama_obat NOT LIKE '%TRANFUSI%'
        AND d.nama_obat NOT LIKE '%ANIOSYME%'
        AND d.nama_obat NOT LIKE '%INTROCAN%'
        AND d.nama_obat NOT LIKE '%DERMANIOS%'
        AND d.nama_obat NOT LIKE '%INDIKATOR%'
        AND d.nama_obat NOT LIKE '%RED DOT%'
		AND d.nama_obat NOT LIKE '%GUDEL%'
		AND d.nama_obat NOT LIKE '%BISTURI%'
		AND d.nama_obat NOT LIKE '%HARUM%'
		AND d.nama_obat NOT LIKE '%HISTOPOT%'
		AND d.nama_obat NOT LIKE '%T-LENE%'
		AND d.nama_obat NOT LIKE '%T-VIO%'
GROUP BY d.nama_obat");

echo '<table width="100%" style="font-size: 9px;border-spacing: 1px;">';
$nilai = 0;
while ($row = mysqli_fetch_array($q)) {
    if ($nilai % 3 == 0) {
        if ($nilai > 0) {
            echo '</tr>';
        }
        echo '<tr>';
    }
    if ($nilai % 1 == 0) {
        if ($nilai > 0) {
            echo '</td>';
        }
        echo '<td>';
    }

    $nama_obat = '- ' . $row['nama_obat'];
    ?>

<?php
echo $nama_obat;
    ?>

   <?php
$nilai++; // increment the $nilai element so we know how many games we've already processed
}
echo '</table>';
?>

      </td>
    </tr>
    <tr>
      <td><strong>Diit</strong></td>
      <td colspan="3"><strong>:</strong><?php echo isset($DATA_ISI['diit']); ?></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Alergi</strong></td>
		<td colspan="3"><strong>:</strong> <?php echo isset($DATA_ISI['alergi']); ?></td>
    </tr>
    <tr>
      <td colspan="4"><strong>Intruksi follow up / tindak lanjut:</strong></td>
    </tr>
    <tr>
      <td colspan="4"><?php echo isset($DATA_ISI['tindak_lanjut']); ?></td>
    </tr>
    <tr>
      <td><strong>Cara Keluar</strong></td>
      <td colspan="3"><strong>:</strong> <?php echo isset($DATA_ISI['cara_keluar']); ?></td>
    </tr>
    <tr>
      <td colspan="4"><strong>Kondisi Saat Pulang</strong></td>
    </tr>
    <tr>
      <td colspan="4"><?php echo isset($DATA_ISI['kondisi_pulang']); ?>
      </td>
    </tr>
    <tr>
      <td><strong>Ventilator</strong></td>
      <td colspan="3">
        <strong>Dipasang : <?php echo isset($DATA_ISI['ven_pasang']); ?><br>
      Dilepas: <?php echo isset($DATA_ISI['ven_lepas']); ?><br>
      Lama Pakai: <?php echo isset($DATA_ISI['lama_ventilator']); ?>
      </strong></td>
    </tr>
    <tr>
      <td><strong>Mode Ventilator</strong></td>
      <td colspan="3"><?php echo isset($DATA_ISI['ventilator_mode']); ?></td>
    </tr>
    <tr>
      <td><strong>Pengobatan dilanjutkan</strong></td>
      <td colspan="3"><?php echo isset($DATA_ISI['pengobatan_lanjutan']); ?></td>
    </tr>
    <tr>
      <td><strong>Edukasi</strong></td>
      <td colspan="3">: YA</td>
    </tr>
    <tr>
      <td><strong>Tanggal Kontrol</strong></td>
      <td colspan="3">: <strong><?php echo (isset($DATA_KONTROL['tanggal_kontrol']) != '') ? tanggal_indo(isset($DATA_KONTROL['tanggal_kontrol'])) : '' ?></strong></td>
    </tr>
    <tr>
      <td><strong>Poliklinik Tujuan</strong></td>
      <td colspan="3">: <strong><?php echo isset($DATA_KONTROL['userlevelname']); ?></strong></td>
    </tr>
    <tr>
      <td colspan="4"><strong>Terapi / obat waktu pulang</strong></td>
    </tr>
    <tr>
      <td colspan="4">
       <table width="100%" class="tabel" style="font-size: 10px;border-spacing: 1px;" border="0">
        <tbody>

         <?php

$sqlitemobat = "SELECT
    c.nama_obat, a.qty, d.nama_resep AS aturan
FROM
    bill_detail_permintaan_obat a
        LEFT JOIN
    master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
        LEFT JOIN
    master_obat c ON b.id_obat = c.id_obat
        LEFT JOIN
    master_resep d ON a.id_master_resep = d.id_master_resep
        LEFT JOIN
    bill_detail_permintaan_obat_master e ON a.id_bill_detail_permintaan_obat_master = e.id_bill_detail_permintaan_obat_master
WHERE
    a.id_jenis_etiket = 1
        AND e.idxdaftar = $idxdaftar
ORDER BY a.id_bill_detail_permintaan_obat DESC";
$queryitemobatpulang = mysqli_query($mysqli, $sqlitemobat);

$no = 1;
while ($data = mysqli_fetch_assoc($queryitemobatpulang)) {
    echo '<tr style="font-size: 9px">';
    echo '<td align="left">' . $data['nama_obat'] . '</td>';
    echo '<td align="center">' . $data['qty'] . '</td>';
    echo '<td align="left">' . $data['aturan'] . '</td>';
    echo '</tr>';
    $no++;
}
?>
        </tbody>
      </table>

      </td>
    </tr>
    <tr>
      <td colspan="4" align="right">Ajibarang, <?php echo isset($DATA_ISI['tglkeluar']); ?> WIB</td>
    </tr>
    <tr style="font-size: 9px">
      <td align="center">Tanda Tangan dan Nama Terang Pasien/ Keluarga</td>
      <td align="center">&nbsp;</td>
      <td colspan="2" align="center">Tanda Tangan dan Nama Terang DPJP</td>
    </tr>
    <tr>
      <td align="center">
		  <center>
		  <img width="50px" height="70px" src=""/>
		  </center>

		  <p align="center" style="font-size: 10px">( <?php echo $DATA_IDENTITAS['penanggungjawab_nama']; ?> )</p>
      </td>
      <td align="center">&nbsp;</td>
      <td colspan="2" align="center">
      <center>
      	<img height="50px" src=""/>
      </center>
      <p align="center" style="font-size: 10px">( <?php echo $DATA_IDENTITAS['pd_nickname']; ?> )<br>
      SIP:<?php echo $DATA_IDENTITAS['no_surat_izin_praktek']; ?></p></td>
    </tr>
  </tbody>
</table>



</body>
</html>


<?php
$html = ob_get_clean();
require_once "../../vendor/autoload.php";
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->setIsRemoteEnabled(true);
$dompdf = new Dompdf($options);
$paper_size = [0, 0, 8.46 * 72, 12.99 * 72];
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('14_resume_ranap.pdf', ['Attachment' => 0]);
?>
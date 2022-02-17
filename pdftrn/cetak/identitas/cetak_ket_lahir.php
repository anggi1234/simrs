<?php
ob_start();
session_start();
include '../connect.php';

// $nomr = $_GET['nomr'];
$nomr         = 280544;
$sqlidentitas = "
SELECT
    b.no_surat,
    b.anak_ke,
    b.tanggal_lahir AS hari,
    date(b.tanggal_lahir) as tanggal_lahir,
    TIME_FORMAT(b.tanggal_lahir, '%H:%i') AS jam_lahir,
    b.nama_ibu,
    b.nama_ayah,
    b.ktp_ibu,
    b.ktp_ayah,
    b.umur_ibu,
    b.umur_ayah,
    b.pekerjaan_ayah,
    b.pekerjaan_ibu,
    b.alamat_ayah,
    b.berat_badan,
    b.tinggi_badan,
    CASE
        WHEN d.jeniskelamin = 'L' THEN 'LAKI-LAKI'
        WHEN d.jeniskelamin = 'P' THEN 'PEREMPUAN'
    END AS jeniskelamin,
    e.signature,
    e.pd_nickname,
    e.no_surat_izin_praktek,
	b.tanggal_pembuatan_surat
FROM
    vk_detail_kelahiran b
        LEFT JOIN
    data a ON a.idxdaftar = b.idxdaftar
        LEFT JOIN
    data_keterangan c ON b.idxdaftar = c.idxdaftar
        LEFT JOIN
    m_pasien d ON a.nomr = d.nomr
        LEFT JOIN
    master_login e ON e.kddokter = b.kddokter
WHERE
    a.nomr = $nomr";
$queryidentitas = mysqli_query($mysqli, $sqlidentitas);
$DATA_IDENTITAS = mysqli_fetch_array($queryidentitas);

$tanggal = $DATA_IDENTITAS['hari'];
$day     = date('D', strtotime($tanggal));
$dayList = [
    'Sun' => 'Minggu',
    'Mon' => 'Senin',
    'Tue' => 'Selasa',
    'Wed' => 'Rabu',
    'Thu' => 'Kamis',
    'Fri' => 'Jumat',
    'Sat' => 'Sabtu',
];

function tgl_indo($tanggal, $cetak_hari = false) {
    $hari = [1 => 'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Minggu',
    ];

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
    $split    = explode('-', $tanggal);
    $tgl_indo = $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];

    if ($cetak_hari) {
        $num = date('N', strtotime($tanggal));
        return $tgl_indo;
    }
    return $tgl_indo;
}

?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Surat Keterangan Lahir</title>
<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
		font-size: 12px;
	}

#box {
    box-sizing: content-box;
    width: 100%;
    height: 48%;
    padding: 0px;
    border: 2px solid #000000;
}


</style>


</head>
<body>
<div id="box">
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
  <span style="font-size: 14px"><strong>SURAT KETERANGAN KELAHIRAN</strong></span><br>
  <span style="font-size: 14px"><strong>NO.<?php echo $DATA_IDENTITAS['no_surat']; ?> </strong></span>
</center>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="5"><p style="text-align: justify; text-indent: 30px;">Yang bertanda tangan dibawah ini, menerangkan bahwa pada hari <?php echo $dayList[$day] ?> tanggal <?php echo ($DATA_IDENTITAS['tanggal_lahir'] != '') ? tgl_indo($DATA_IDENTITAS['tanggal_lahir'], true) : ''; ?> Pukul <?php echo $DATA_IDENTITAS['jam_lahir']; ?> WIB telah lahir seorang <?php echo $DATA_IDENTITAS['jeniskelamin']; ?> anak ke <?php echo $DATA_IDENTITAS['anak_ke']; ?> dengan berat <?php echo $DATA_IDENTITAS['berat_badan']; ?> kilogram dan panjang <?php echo $DATA_IDENTITAS['tinggi_badan']; ?> cm di RSUD Besemah Pagar Alam dari pasangan :<br>
      </p></td>
    </tr>
    <tr>
      <td width="16%">Nama Ibu</td>
      <td width="24%">: <?php echo $DATA_IDENTITAS['nama_ibu']; ?></td>
      <td width="16%">&nbsp;</td>
      <td width="15%">Umur Ibu</td>
      <td width="29%">: <?php echo $DATA_IDENTITAS['umur_ibu']; ?> Tahun</td>
    </tr>
    <tr>
      <td>Pekerjaan</td>
      <td colspan="2">: <?php echo $DATA_IDENTITAS['pekerjaan_ibu']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>No. KTP</td>
      <td>: <?php echo $DATA_IDENTITAS['ktp_ibu']; ?></td>
      <td>&nbsp;</td>
      <td>Umur Ayah</td>
      <td>: <?php echo $DATA_IDENTITAS['umur_ayah']; ?> Tahun</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Nama Ayah</td>
      <td>: <?php echo $DATA_IDENTITAS['nama_ayah']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Pekerjaan</td>
      <td>: <?php echo $DATA_IDENTITAS['pekerjaan_ayah']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>No. KTP</td>
      <td>: <?php echo $DATA_IDENTITAS['ktp_ayah']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td colspan="4">: <?php echo $DATA_IDENTITAS['alamat_ayah']; ?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2" align="center">Pagaralam, <?php echo ($DATA_IDENTITAS['tanggal_pembuatan_surat'] != '') ? tgl_indo($DATA_IDENTITAS['tanggal_pembuatan_surat'], true) : '' ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2" align="center">Dokter DPJP</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2" align="center"><img height="70px" src=""></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2" align="center"><?php echo $DATA_IDENTITAS['pd_nickname']; ?><br><?php echo $DATA_IDENTITAS['no_surat_izin_praktek']; ?></td>
      </tr>
    </tbody>
</table>
	</div>
<hr style="border:none;
  border-top:1px dotted #00000;
  color:#fff;
  background-color:#fff;
  height:1px;
  width:100%;" />


	<div id="box">
<table width="100%" border="0" cellpadding="-3px" cellspacing="0px">
    <tr>
      <td width="10%" rowspan="3" align="right"><img src="../http://localhost/simrs/cetak/gambar/logorsud.png" height="70px" /></td>
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
  <span style="font-size: 14px"><strong>SURAT KETERANGAN KELAHIRAN</strong></span><br>
  <span style="font-size: 14px"><strong>NO.<?php echo $DATA_IDENTITAS['no_surat']; ?> </strong></span>
</center>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="5"><p style="text-align: justify; text-indent: 30px;">Yang bertanda tangan dibawah ini, menerangkan bahwa pada hari <?php echo $dayList[$day] ?> tanggal <?php echo ($DATA_IDENTITAS['tanggal_lahir'] != '') ? tgl_indo($DATA_IDENTITAS['tanggal_lahir'], true) : ''; ?> Pukul <?php echo $DATA_IDENTITAS['jam_lahir']; ?> WIB telah lahir seorang <?php echo $DATA_IDENTITAS['jeniskelamin']; ?> anak ke <?php echo $DATA_IDENTITAS['anak_ke']; ?> dengan berat <?php echo $DATA_IDENTITAS['berat_badan']; ?> kilogram dan panjang <?php echo $DATA_IDENTITAS['tinggi_badan']; ?> cm di RSUD Besemah Pagar Alam dari pasangan :<br>
      </p></td>
    </tr>
    <tr>
      <td width="16%">Nama Ibu</td>
      <td width="24%">: <?php echo $DATA_IDENTITAS['nama_ibu']; ?></td>
      <td width="16%">&nbsp;</td>
      <td width="15%">Umur Ibu</td>
      <td width="29%">: <?php echo $DATA_IDENTITAS['umur_ibu']; ?> Tahun</td>
    </tr>
    <tr>
      <td>Pekerjaan</td>
      <td colspan="2">: <?php echo $DATA_IDENTITAS['pekerjaan_ibu']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>No. KTP</td>
      <td>: <?php echo $DATA_IDENTITAS['ktp_ibu']; ?></td>
      <td>&nbsp;</td>
      <td>Umur Ayah</td>
      <td>: <?php echo $DATA_IDENTITAS['umur_ayah']; ?> Tahun</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Nama Ayah</td>
      <td>: <?php echo $DATA_IDENTITAS['nama_ayah']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Pekerjaan</td>
      <td>: <?php echo $DATA_IDENTITAS['pekerjaan_ayah']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>No. KTP</td>
      <td>: <?php echo $DATA_IDENTITAS['ktp_ayah']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td colspan="4">: <?php echo $DATA_IDENTITAS['alamat_ayah']; ?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2" align="center">Pagaralam, <?php echo ($DATA_IDENTITAS['tanggal_pembuatan_surat'] != '') ? tgl_indo($DATA_IDENTITAS['tanggal_pembuatan_surat'], true) : '' ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2" align="center">Dokter DPJP</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2" align="center"><img height="70px" src=""></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2" align="center"><?php echo $DATA_IDENTITAS['pd_nickname']; ?><br><?php echo $DATA_IDENTITAS['no_surat_izin_praktek']; ?></td>
      </tr>
    </tbody>
</table>
	</div>

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
$paper_size = [0, 0, 8.26 * 72, 12.99 * 72];
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('SURATKELAHIRAN.pdf', ['Attachment' => 0]);
?>
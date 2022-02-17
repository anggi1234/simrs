<?php
ob_start();
session_start();
include '../connect.php';
// $idxdaftar = $_GET['idxdaftar'];
$idxdaftar = 665939;
$username  = 'rusmiatin';

$sqlsliplamp = "SELECT idxdaftar,
    idxdaftar,
    mata_palpebra_od,
    mata_konjungtiva_od,
    mata_kornea_od,
    mata_coa_od,
    mata_pupil_od,
    mata_iris_od,
    mata_lensa_od,
    mata_fundus_od,
    mata_palpebra_os,
    mata_konjungtiva_os,
    mata_kornea_os,
    mata_coa_os,
    mata_pupil_os,
    mata_iris_os,
    mata_lensa_os,
    mata_fundus_os from data_keterangan
    where userlevelid <> 31 and  idxdaftar=$idxdaftar";
$querysliplamp = mysqli_query($mysqli, $sqlsliplamp);
$DATA_SLIPLAMP = mysqli_fetch_array($querysliplamp);

$sqlfunduskopi = "SELECT idxdaftar,
    idxdaftar,
    mata_fundus_optic_od,
    mata_fundus_retinal_blood_od,
    mata_fundus_retina_od,
    mata_fundus_makula_od,
    mata_fundus_fovea_od,
    mata_fundus_sclera_od,
    mata_fundus_choroid_od,
    mata_fundus_optic_os,
    mata_fundus_retinal_blood_os,
    mata_fundus_retina_os,
    mata_fundus_makula_os,
    mata_fundus_fovea_os,
    mata_fundus_sclera_os,
    mata_fundus_choroid_os from data_keterangan
    where userlevelid <> 31 and  idxdaftar=$idxdaftar";
$queryfunduskopi = mysqli_query($mysqli, $sqlfunduskopi);
$DATA_FUNDUSKOPI = mysqli_fetch_array($queryfunduskopi);
// print_r($DATA_FUNDUSKOPI['mata_palpebra_os']);

$q = mysqli_query($mysqli, "SELECT
    b.nama,
    a.nomr,
    c.userlevelname,
    b.tgllahir,
    a.tglreg,
    (SELECT
            GROUP_CONCAT(keterangan
                    SEPARATOR ', ')
        FROM
            data_penyakit
        WHERE
            idxdaftar = a.idxdaftar
        GROUP BY idxdaftar) AS diagnosa,
    d.pd_nickname,
    d.signature
FROM
    data a
        LEFT JOIN
    m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    userlevels c ON a.userlevelid = c.userlevelid
        LEFT JOIN
    master_login d ON a.kddokter = d.kddokter
WHERE
    a.idxdaftar = $idxdaftar");
$r = mysqli_fetch_array($q);

$sqlusername   = "select pd_nickname from master_login where username='$username'";
$queryusername = mysqli_query($mysqli, $sqlusername);
$DATA_USERNAME = mysqli_fetch_array($queryusername);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pemeriksaan Slit Lamp</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}

.tabel {
    border-collapse:collapse;
	font-size: 10px;
}

.kosong {
    border:none;
}

.header {
	font-size: 10px;
}
.footer {
	font-size: 10px;
}
</style>

</head>

<body>

<table width="100%" border="0" cellpadding="-3px" cellspacing="0px">
    <tr>
      <td width="10%" rowspan="3" align="right"><img src="http://localhost/simrs/cetak/gambar/logorsud.png" height="70px" /></td>
      <td width="90%" align="center" style="font-size: 14px">PEMERINTAH KOTA PAGAR ALAM</td>
    </tr>
    <tr>
      <td align="center"><strong style="font-size: 15px">RUMAH SAKIT UMUM DAERAH BESEMAH PAGAR ALAM</strong></td>
    </tr>
    <tr>
      <td align="center" style="font-size: 10px">Jl. Ais Nasution No.03 Pagar Alam Utara<br>+62 730 621 118<br>Email:pagaralamrsudbesemah@gmail.com</td>
    </tr>
</table>
  <hr>

    <div align="left" style="font-size: 10px"><strong>Pemeriksan dengan menggunakan silt lamp, merk Shin Nippon Jepang Type SL 500 dari Lensa 78D</strong></div>

    <table width="100%" class="tabel" border="0">
    <tbody>
        <tr>
            <td width="15%">NAMA</td>
            <td width="34%">:<?php echo $r['nama']; ?></td>
        </tr>
        <tr>
            <td>NO RM</td>
            <td>:<?php echo $r['nomr']; ?></td>
            <td width="16%">POLIKLINIK</td>
            <td width="35%">:<?php echo $r['userlevelname']; ?></td>
        </tr>
        <tr>
            <td>TGL LAHIR</td>
            <td>:<?php echo $r['tgllahir']; ?></td>
        </tr>
    </tbody>
    </table>

    <table width="100%" class="tabel" border="1">
    <tr>
      <td width="5%" align="center"><strong>NO.</strong></td>
      <td width="25%" align="center"><strong>HASIL</strong></td>
      <td width="35%" align="center"><strong>OD</strong></td>
      <td width="35%" align="center"><strong>OS</strong></td>
  </tr>
    <tr>
      <td align="center">1.</td>
      <td align="center">Pemeriksaan Slip Lamp</td>
      <td align="center">
        <?php if ($DATA_SLIPLAMP['mata_palpebra_od'] == '') {
    echo '';
} else {
    $str1 = "Palpebra OD : ";
    echo $str1 . " " . $DATA_SLIPLAMP['mata_palpebra_od'] . '<br>';
}?>
        <?php if ($DATA_SLIPLAMP['mata_konjungtiva_od'] == '') {
    echo '';
} else {
    $str1 = "Konjungtiva OD : ";
    echo $str1 . " " . $DATA_SLIPLAMP['mata_konjungtiva_od'] . '<br>';
}?>
        <?php if ($DATA_SLIPLAMP['mata_kornea_od'] == '') {
    echo '';
} else {
    $str1 = "Kornea OD : ";
    echo $str1 . " " . $DATA_SLIPLAMP['mata_kornea_od'] . '<br>';
}?>
        <?php if ($DATA_SLIPLAMP['mata_coa_od'] == '') {
    echo '';
} else {
    $str1 = "Coa OD : ";
    echo $str1 . " " . $DATA_SLIPLAMP['mata_coa_od'] . '<br>';
}?>
        <?php if ($DATA_SLIPLAMP['mata_pupil_od'] == '') {
    echo '';
} else {
    $str1 = "Pupil OD : ";
    echo $str1 . " " . $DATA_SLIPLAMP['mata_pupil_od'] . '<br>';
}?>
        <?php if ($DATA_SLIPLAMP['mata_iris_od'] == '') {
    echo '';
} else {
    $str1 = "Iris OD : ";
    echo $str1 . " " . $DATA_SLIPLAMP['mata_iris_od'] . '<br>';
}?>
        <?php if ($DATA_SLIPLAMP['mata_lensa_od'] == '') {
    echo '';
} else {
    $str1 = "Lensa OD : ";
    echo $str1 . " " . $DATA_SLIPLAMP['mata_lensa_od'] . '<br>';
}?>
        <?php if ($DATA_SLIPLAMP['mata_fundus_od'] == '') {
    echo '';
} else {
    $str1 = "Fundus OD : ";
    echo $str1 . " " . $DATA_SLIPLAMP['mata_fundus_od'] . '<br>';
}?></td>
        <!-- os -->
      <td align="center"><?php if ($DATA_SLIPLAMP['mata_palpebra_os'] == '') {
    echo '';
} else {
    $str1 = "Palpebra OS : ";
    echo $str1 . " " . $DATA_SLIPLAMP['mata_palpebra_os'] . '<br>';
}?>
        <?php if ($DATA_SLIPLAMP['mata_konjungtiva_os'] == '') {
    echo '';
} else {
    $str1 = "Konjungtiva OS : ";
    echo $str1 . " " . $DATA_SLIPLAMP['mata_konjungtiva_os'] . '<br>';
}?>
        <?php if ($DATA_SLIPLAMP['mata_kornea_os'] == '') {
    echo '';
} else {
    $str1 = "Kornea OS : ";
    echo $str1 . " " . $DATA_SLIPLAMP['mata_kornea_os'] . '<br>';
}?>
        <?php if ($DATA_SLIPLAMP['mata_coa_os'] == '') {
    echo '';
} else {
    $str1 = "Coa OS : ";
    echo $str1 . " " . $DATA_SLIPLAMP['mata_coa_os'] . '<br>';
}?>
        <?php if ($DATA_SLIPLAMP['mata_pupil_os'] == '') {
    echo '';
} else {
    $str1 = "Pupil OS : ";
    echo $str1 . " " . $DATA_SLIPLAMP['mata_pupil_os'] . '<br>';
}?>
        <?php if ($DATA_SLIPLAMP['mata_iris_os'] == '') {
    echo '';
} else {
    $str1 = "Iris OS : ";
    echo $str1 . " " . $DATA_SLIPLAMP['mata_iris_os'] . '<br>';
}?>
        <?php if ($DATA_SLIPLAMP['mata_lensa_os'] == '') {
    echo '';
} else {
    $str1 = "Lensa OS : ";
    echo $str1 . " " . $DATA_SLIPLAMP['mata_lensa_os'] . '<br>';
}?>
        <?php if ($DATA_SLIPLAMP['mata_fundus_os'] == '') {
    echo '';
} else {
    $str1 = "Fundus OS : ";
    echo $str1 . " " . $DATA_SLIPLAMP['mata_fundus_os'] . '<br>';
}?></td>
    </tr>
    <tr>
      <td align="center">2.</td>
      <td align="center">Pemeriksaan Funduskopi</td>
      <td align="center"><img src="../gambar/od.png" height="100px" width="150px" />
        <br>
        <?php if ($DATA_FUNDUSKOPI['mata_fundus_optic_od'] == '') {
    echo '';
} else {
    $str1 = "Optic OD : ";
    echo $str1 . " " . $DATA_FUNDUSKOPI['mata_fundus_optic_od'];
}?>
        <?php if ($DATA_FUNDUSKOPI['mata_fundus_retinal_blood_od'] == '') {
    echo '';
} else {
    $str1 = "Retina Blood OD : ";
    echo $str1 . " " . $DATA_FUNDUSKOPI['mata_fundus_retinal_blood_od'];
}?>
        <?php if ($DATA_FUNDUSKOPI['mata_fundus_retina_od'] == '') {
    echo '';
} else {
    $str1 = "Retina OD : ";
    echo $str1 . " " . $DATA_FUNDUSKOPI['mata_fundus_retina_od'];
}?>
        <?php if ($DATA_FUNDUSKOPI['mata_fundus_makula_od'] == '') {
    echo '';
} else {
    $str1 = "Makula OD : ";
    echo $str1 . " " . $DATA_FUNDUSKOPI['mata_fundus_makula_od'];
}?>
        <?php if ($DATA_FUNDUSKOPI['mata_fundus_fovea_od'] == '') {
    echo '';
} else {
    $str1 = "Fovea OD : ";
    echo $str1 . " " . $DATA_FUNDUSKOPI['mata_fundus_fovea_od'];
}?>
        <?php if ($DATA_FUNDUSKOPI['mata_fundus_sclera_od'] == '') {
    echo '';
} else {
    $str1 = "Sclera OD : ";
    echo $str1 . " " . $DATA_FUNDUSKOPI['mata_fundus_sclera_od'];
}?>
        <?php if ($DATA_FUNDUSKOPI['mata_fundus_choroid_od'] == '') {
    echo '';
} else {
    $str1 = "Choroid OD : ";
    echo $str1 . " " . $DATA_FUNDUSKOPI['mata_fundus_choroid_od'];
}?>
      </td>
      <td align="center"><img src="../gambar/os.png" height="100px" width="150px" />
      <br>
        <?php if ($DATA_FUNDUSKOPI['mata_fundus_optic_os'] == '') {
    echo '';
} else {
    $str1 = "Optic OS : ";
    echo $str1 . " " . $DATA_FUNDUSKOPI['mata_fundus_optic_os'];
}?>
        <?php if ($DATA_FUNDUSKOPI['mata_fundus_retinal_blood_os'] == '') {
    echo '';
} else {
    $str1 = "Retinal Blood OS : ";
    echo $str1 . " " . $DATA_FUNDUSKOPI['mata_fundus_retinal_blood_os'];
}?>
        <?php if ($DATA_FUNDUSKOPI['mata_fundus_retina_os'] == '') {
    echo '';
} else {
    $str1 = "Retina OS : ";
    echo $str1 . " " . $DATA_FUNDUSKOPI['mata_fundus_retina_os'];
}?>
        <?php if ($DATA_FUNDUSKOPI['mata_fundus_makula_os'] == '') {
    echo '';
} else {
    $str1 = "Makula OS : ";
    echo $str1 . " " . $DATA_FUNDUSKOPI['mata_fundus_makula_os'];
}?>
        <?php if ($DATA_FUNDUSKOPI['mata_fundus_fovea_os'] == '') {
    echo '';
} else {
    $str1 = "Fovea OS : ";
    echo $str1 . " " . $DATA_FUNDUSKOPI['mata_fundus_fovea_os'];
}?>
        <?php if ($DATA_FUNDUSKOPI['mata_fundus_sclera_os'] == '') {
    echo '';
} else {
    $str1 = "Sclera OS : ";
    echo $str1 . " " . $DATA_FUNDUSKOPI['mata_fundus_sclera_os'];
}?>
        <?php if ($DATA_FUNDUSKOPI['mata_fundus_choroid_os'] == '') {
    echo '';
} else {
    $str1 = "Choroid OS : ";
    echo $str1 . " " . $DATA_FUNDUSKOPI['mata_fundus_choroid_os'];
}?>
      </td>
    </tr>

</table>
<table width="100%" class="tabel" border="0">
    <tbody>
        <tr>
            <td colspan="4">DIAGNOSA:<?php echo $r['diagnosa']; ?></td>
        </tr>
        <tr>
            <td width="25%"></td>
            <td width="25%"></td>
            <td width="16%" align="right">&nbsp;</td>
            <td width="34%" align="right">Ajibarang,<?php echo $r['tglreg']; ?></td>
        </tr>
        <tr>
            <td align="center">Pasien/Keluarga Pasien
            <td>&nbsp;</td>
            <td></td>
            <td align="center">Dokter Pemeriksa</td>
        </tr>
        <tr>
		  <td colspan="2" align="center">

		  	<img height="80px" src=""/>

		  </td>
          <td></td>
          <td align="center"><img height="50px" src=""/></td>
        </tr>
        <tr>
          <td align="center">
          <td>&nbsp;</td>
          <td></td>
          <td align="center"><?php echo $r['pd_nickname']; ?></td>
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
$paper_size = [0, 0, 6 * 72, 7 * 72];
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('45_slit_lamp.pdf', ['Attachment' => 0]);
?>
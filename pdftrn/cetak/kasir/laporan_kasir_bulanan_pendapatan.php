<?php
ob_start();
session_start();
include '../connect.php';
// $dari_tanggal             = $_GET['dari_tanggal'];
// $sampai_tanggal           = $_GET['sampai_tanggal'];
// $kdcarabayar              = $_GET['kdcarabayar'];
// $username                 = $_GET['username'];
// $id_jenis_pelayanan_kasir = $_GET['id_jenis_pelayanan_kasir'];
$dari_tanggal             = "2020-12-17";
$sampai_tanggal           = "2021-12-17";
$kdcarabayar              = 3;
$username                 = "POLIKLINIK KEBIDANAN";
$id_jenis_pelayanan_kasir = 1;

$sqlidentitas = "SELECT
    a.pd_nickname, b.userlevelname
FROM
    master_login a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
WHERE
    c.username = '$username'";
$queryidentitas = mysqli_query($mysqli, $sqlidentitas);
$DATA_IDENTITAS = mysqli_fetch_array($queryidentitas);

$sqlitem = "SELECT
	concat(case
		when month(a.tglreg)=1 then 'Januari'
        when month(a.tglreg)=2 then 'Februari'
        when month(a.tglreg)=3 then 'Maret'
        when month(a.tglreg)=4 then 'April'
        when month(a.tglreg)=5 then 'Mei'
        when month(a.tglreg)=6 then 'Juni'
        when month(a.tglreg)=7 then 'Juli'
        when month(a.tglreg)=8 then 'Agustus'
        when month(a.tglreg)=9 then 'September'
        when month(a.tglreg)=10 then 'Oktober'
        when month(a.tglreg)=11 then 'November'
        when month(a.tglreg)=12 then 'Desember' END, ' ',year(a.tglreg))  as bulan,
	sum(IFNULL(biaya_pendaftaran, 0) + IFNULL(biaya_jasar, 0) + IFNULL(biaya_penj_non_medis, 0) + IFNULL(biaya_asuhan_keperawatan, 0) + IFNULL(biaya_pemeriksaan, 0)) AS karcis,
    sum(IFNULL(a.biaya_tind_tmno, 0)) AS biaya_tind_tmno,
    sum(IFNULL(a.biaya_tind_tmo, 0)) AS biaya_tind_tmo,
    sum(IFNULL(a.biaya_tind_keperawatan, 0)) AS biaya_tind_keperawatan,
    sum(IFNULL(a.biaya_tind_persalinan, 0)) AS biaya_tind_persalinan,
    sum(IFNULL(a.biaya_penj_laboratorium, 0)) AS biaya_penj_laboratorium,
    sum(IFNULL(a.biaya_penj_radiologi, 0)) AS biaya_penj_radiologi,
    sum(IFNULL(a.biaya_penj_fisioterapi, 0)) AS biaya_penj_fisioterapi,
    sum(IFNULL(a.biaya_obat, 0) - IFNULL(a.biaya_obat_retur, 0)) AS biaya_obat,
    sum(IFNULL(a.biaya_ekg, 0)) AS biaya_ekg,
    sum(IFNULL(a.biaya_usg, 0)) AS biaya_usg,
	sum(IFNULL(biaya_bhp_tmno, 0) + IFNULL(biaya_bhp_tmo, 0) + IFNULL(biaya_bhp_keperawatan, 0) + IFNULL(biaya_bhp_persalinan, 0) + IFNULL(biaya_bhp_oksigen, 0) + IFNULL(biaya_bhp_ekg, 0) + IFNULL(biaya_bhp_usg, 0)) AS bhp,
sum(IFNULL(a.biaya_pel_ambulan, 0)) as biaya_pel_ambulan,
sum(IFNULL(a.biaya_tind_jenazah, 0)) as biaya_tind_jenazah,
sum(IFNULL(a.biaya_bimbingan_rohani, 0)) as biaya_bimbingan_rohani,
sum(IFNULL(a.biaya_akomodasi, 0)) as biaya_akomodasi,
sum(IFNULL(a.biaya_makan, 0)) as biaya_makan,
sum(IFNULL(a.total_keseluruhan,0)) AS total_keseluruhan
FROM
    data a
	LEFT JOIN
    m_carabayar d ON a.kdcarabayar = d.kode
	LEFT JOIN
    userlevels e ON a.userlevelid = e.userlevelid
WHERE a.tglreg >= '$dari_tanggal' and
  a.tglreg <= '$sampai_tanggal' and
  d.payor_id=$kdcarabayar AND
  e.id_jenis_pelayanan_kasir = $id_jenis_pelayanan_kasir
GROUP BY MONTH(a.tglreg)";
$queryitem = mysqli_query($mysqli, $sqlitem);

$sqlidentitas = "SELECT
    SUM(a.total_keseluruhan) AS grandtotal
FROM
    data a
	LEFT JOIN
    m_carabayar d ON a.kdcarabayar = d.kode
	LEFT JOIN
    userlevels e ON a.userlevelid = e.userlevelid
WHERE
  a.tglreg >= '$dari_tanggal' and
  a.tglreg <= '$sampai_tanggal' and
  d.payor_id=$kdcarabayar AND
  e.id_jenis_pelayanan_kasir = $id_jenis_pelayanan_kasir";
$queryidentitas = mysqli_query($mysqli, $sqlidentitas);
$DATA_TOTAL     = mysqli_fetch_array($queryidentitas);

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

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LAPORAN PENDAPATAN BULANAN</title>
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
	font-size: 9px;
}

.header {
	font-size: 9px;
}
.footer {
	font-size: 9px;
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


    <div align="center"><strong>SETORAN PENDAPATAN BULANAN</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="8%">Nama Kasir</td>
      <td width="40%">: <?php echo $DATA_USERNAME['pd_nickname']; ?></td>

    </tr>
    <tr>
      <td>Dari Tanggal</td>
      <td>: <?php echo date("d-m-Y", strtotime($dari_tanggal)) ?></td>
      <td width="37%" align="right">Sampai Tanggal</td>
      <td width="15%">: <?php echo date("d-m-Y", strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>

<table width="100%" border="1" class="tabel">
  <tbody>
    <tr>
      <td align="center">Bulan</td>
      <td align="center">Karcis</td>
      <td align="center">TMNO</td>
      <td align="center">TMO</td>
      <td align="center">Kep</td>
      <td align="center">Persal</td>
      <td align="center">BHP</td>
      <td align="center">Akomodasi</td>
      <td align="center">Makan</td>
      <td align="center">Ambulan</td>
      <td align="center">Jenazah</td>
      <td align="center">Bimroh</td>
      <td align="center">Lab</td>
      <td align="center">Rad</td>
      <td align="center">Fisio</td>
      <td align="center">Obat</td>
      <td align="center">EKG</td>
      <td align="center">USG</td>
      <td align="center">Total</td>
    </tr>
    <?php
$no = 1;
while ($data = mysqli_fetch_assoc($queryitem)) {
    echo '<tr>';
    echo '<td align="left">' . $data['bulan'] . '</td>';
    echo '<td align="right">' . number_format($data['karcis'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['biaya_tind_tmno'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['biaya_tind_tmo'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['biaya_tind_keperawatan'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['biaya_tind_persalinan'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['bhp'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['biaya_akomodasi'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['biaya_makan'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['biaya_pel_ambulan'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['biaya_tind_jenazah'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['biaya_bimbingan_rohani'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['biaya_penj_laboratorium'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['biaya_penj_radiologi'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['biaya_penj_fisioterapi'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['biaya_obat'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['biaya_ekg'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['biaya_usg'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['total_keseluruhan'], 0, ",", ".") . '</td>';
    echo '</tr>';

    $no++;
}
?>
	 <tr>
      <td colspan="13" style="text-align: center"><strong>TOTAL PENDAPATAN</strong></td>
      <td colspan="6" style="text-align: center"><h2><strong>Rp.<?php echo number_format($DATA_TOTAL['grandtotal'], 0, ",", "."); ?></strong></h2></td>
    </tr>
  </tbody>
</table>



<table width="100%" border="0" class="tabel">
        <tbody>
     <tr>
       <td width="27%" align="center">Yang Menyerahkan</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td width="34%" align="center">Yang Menerima</td>
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
      <td colspan="6" align="right">&nbsp;</td>
      <td align="center" class="footer">Wiwid Kurniati</td>
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
$paper_size = [0, 0, 8.26 * 72, 12.99 * 72];
$dompdf->set_paper($paper_size, 'landscape');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('Laporan Pendapatan Bulanan.pdf', ['Attachment' => 0]);
?>

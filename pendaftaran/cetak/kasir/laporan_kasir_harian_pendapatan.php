<?php
ob_start();
session_start();
include '../connect.php';
$dari_tanggal   = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$kdcarabayar    = $_GET['kdcarabayar'];
$username       = $_GET['username'];

$sqlidentitas = "SELECT
    a.pd_nickname, b.userlevelname
FROM
	master_login_detail c left join
    master_login a on c.uid=a.uid
        LEFT JOIN
    userlevels b ON c.userlevelid = b.userlevelid
WHERE
    c.username = '$username'";
$queryidentitas = mysql_query($sqlidentitas);
$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

$sqlitem = "SELECT
    a.tglreg,d.NAMA as pembayaran,
    SUM(IFNULL(a.biaya_pendaftaran, 0) + IFNULL(a.biaya_jasar, 0) + IFNULL(a.biaya_akomodasi, 0) + IFNULL(a.biaya_penj_non_medis, 0) + IFNULL(a.biaya_asuhan_keperawatan, 0) + IFNULL(a.biaya_pemeriksaan, 0)) AS karcis,
    SUM(IFNULL(a.biaya_tind_tmno, 0)) AS biaya_tind_tmno,
    SUM(IFNULL(a.biaya_tind_tmo, 0)) AS biaya_tind_tmo,
    SUM(IFNULL(a.biaya_tind_keperawatan, 0)) AS biaya_tind_keperawatan,
    SUM(IFNULL(a.biaya_tind_persalinan, 0)) AS biaya_tind_persalinan,
    SUM(IFNULL(a.biaya_penj_laboratorium, 0)) AS biaya_penj_laboratorium,
    SUM(IFNULL(a.biaya_penj_radiologi, 0)) AS biaya_penj_radiologi,
    SUM(IFNULL(a.biaya_penj_fisioterapi, 0)) AS biaya_penj_fisioterapi,
    SUM(IFNULL(a.biaya_obat, 0) - IFNULL(a.biaya_obat_retur, 0)) AS biaya_obat,
    SUM(IFNULL(a.biaya_ekg, 0)) AS biaya_ekg,
    SUM(IFNULL(a.biaya_usg, 0)) AS biaya_usg,
    SUM(a.total_keseluruhan) AS total_keseluruhan
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs.userlevels c ON a.userlevelid = c.userlevelid
        LEFT JOIN
    simrs2012.m_carabayar d ON a.kdcarabayar = d.kode
WHERE a.tglreg >= '$dari_tanggal' and a.tglreg <= '$sampai_tanggal' and d.payor_id=$kdcarabayar GROUP BY a.tglreg";
$queryitem = mysql_query($sqlitem);

$sqlidentitas = "SELECT
    SUM(a.total_keseluruhan) AS grandtotal
FROM
    simrs.bill_detail_tarif a
	LEFT JOIN
    simrs2012.m_carabayar d ON a.kdcarabayar = d.kode
WHERE a.tglreg >= '$dari_tanggal' and a.tglreg <= '$sampai_tanggal' and d.payor_id=$kdcarabayar";
$queryidentitas = mysql_query($sqlidentitas);
$DATA_TOTAL     = mysql_fetch_array($queryidentitas);
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LAPORAN SHIFT</title>
<link rel="shortcut icon" href="../favicon.ico"/>

<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
			size: 14in 8.5in;
	}

.tabel {
    border-collapse:collapse;
	font-size: 9px;
	font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
}

.header {
	font-size: 9px;
	font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
}
.footer {
	font-size: 9px;
	font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
}

.pagebreak {
		page-break-before: always;
	}

</style>

</head>
<body>


<table width="100%" border="0" cellpadding="-3px" cellspacing="0px">
    <tr>
      <td width="10%" rowspan="3" align="right"><img src="../gambar/logobms.png" height="70px" /></td>
      <td width="90%" align="center" style="font-size: 16px">PEMERINTAH KABUPATEN BANYUMAS</td>
    </tr>
    <tr>
      <td align="center"><strong style="font-size: 21px">RUMAH SAKIT UMUM DAERAH AJIBARANG</strong></td>
    </tr>
    <tr>
      <td align="center" style="font-size: 14px">Jl. Raya Pancasan - Ajibarang, Kode Pos 53163 <br>
      Telp. (0281) 6570004 Fax. (0281) 6570005 <br>
      E-mail : rsudajibarang@banyumaskab.go.id</td>
    </tr>
</table>
  <hr>


    <div align="center"><strong>SETORAN PENDAPATAN HARIAN PER TANGGAL</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="12%">Nama Kasir</td>
      <td width="36%">: <?php echo $DATA_IDENTITAS['pd_nickname']; ?></td>

    </tr>
    <tr>
      <td>Dari Tanggal</td>
      <td>: <?php echo date("d-m-Y", strtotime($dari_tanggal)) ?></td>
      <td align="right">Sampai Tanggal</td>
      <td>: <?php echo date("d-m-Y", strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>

<table width="100%" border="1" class="tabel">
  <tbody>
    <tr>
      <td width="2%" align="center">No</td>
      <td width="3%" align="center">Tanggal</td>
      <td width="5%" align="center">Pembayaran</td>
      <td width="5%" align="center">Karcis</td>
      <td width="5%" align="center">TMNO</td>
      <td width="5%" align="center">TMO</td>
      <td width="5%" align="center">Kep</td>
      <td width="5%" align="center">Persalinan</td>
      <td width="4%" align="center">Lab</td>
      <td width="4%" align="center">Rad</td>
      <td width="5%" align="center">Fisio</td>
      <td width="5%" align="center">Obat</td>
      <td width="4%" align="center">EKG</td>
      <td width="3%" align="center">USG</td>
      <td width="5%" align="center">Total</td>
    </tr>
    <?php
while ($data = mysql_fetch_assoc($queryitem)) {
    echo '<tr>';
    echo '<td>' . $no . '</td>';
    echo '<td>' . $data['tglreg'] . '</td>';
    echo '<td>' . $data['pembayaran'] . '</td>';
    echo '<td align="right">' . number_format($data['karcis'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['biaya_tind_tmno'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['biaya_tind_tmo'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['biaya_tind_keperawatan'], 0, ",", ".") . '</td>';
    echo '<td align="right">' . number_format($data['biaya_tind_persalinan'], 0, ",", ".") . '</td>';
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
      <td colspan="14" style="text-align: center">TOTAL PENDAPATAN</td>
      <td align="right"><h2><strong>Rp.<?php echo number_format($DATA_TOTAL['grandtotal'], 0, ",", "."); ?></strong></h2></td>
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
      <td align="center"><?php echo $DATA_IDENTITAS['pd_nickname']; ?></td>
      <td colspan="6" align="right">&nbsp;</td>
      <td align="center">Wiwid Kurniati</td>
    </tr>
        </tbody>
      </table>


</body>
</html>

<?php
ob_start();
session_start();
include('../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$kdcarabayar = $_GET['kdcarabayar'];
$username = $_GET['username'];
$id_jenis_pelayanan_kasir = $_GET['id_jenis_pelayanan_kasir'];

$sqliisi="SELECT 
    SUM(IFNULL(a.biaya_pendaftaran, 0) + IFNULL(a.biaya_jasar, 0) + IFNULL(a.biaya_asuhan_keperawatan, 0) + IFNULL(a.biaya_penj_non_medis, 0) + IFNULL(a.biaya_pemeriksaan, 0)) AS karcis,
    SUM(IFNULL(a.biaya_tind_tmo, 0)) AS tmo,
    SUM(IFNULL(a.biaya_tind_tmno, 0)) AS tmno,
    SUM(IFNULL(a.biaya_tind_keperawatan, 0)) AS keperawatan,
    SUM(IFNULL(a.biaya_tind_persalinan, 0)) AS persalinan,
    SUM(IFNULL(a.biaya_penj_laboratorium, 0)) AS lab,
    SUM(IFNULL(a.biaya_penj_radiologi, 0)) AS rad,
    SUM(IFNULL(a.biaya_penj_fisioterapi, 0)) AS fisio,
    SUM(IFNULL(a.biaya_obat, 0) - IFNULL(biaya_obat_retur, 0)) AS obat,
    SUM(IFNULL(a.biaya_ekg, 0)) AS ekg,
    SUM(IFNULL(a.biaya_usg, 0)) AS usg,e.nama_carabayar_group
FROM
    bill_detail_tarif a
        LEFT JOIN
    simrs.userlevels b ON a.userlevelid = b.userlevelid
        LEFT JOIN
    simrs2012.m_carabayar d ON a.kdcarabayar = d.KODE
        LEFT JOIN
    simrs.l_carabayar_group e ON d.payor_id = e.payor_id
        LEFT JOIN
    simrs.master_login g ON a.uidkasir = g.uid
WHERE
    a.uidkasir = '$username'
        AND a.tglreg >= '$dari_tanggal'
        AND a.tglreg <= '$sampai_tanggal'
        AND b.id_jenis_pelayanan_kasir = $id_jenis_pelayanan_kasir
        AND e.payor_id = $kdcarabayar";

 $queryisi = mysql_query($sqliisi);
 $RINCIAN = mysql_fetch_array($queryisi);

$sqlidentitas="SELECT SUM(a.total_keseluruhan) AS total
FROM
    bill_detail_tarif a
        LEFT JOIN
    simrs.userlevels b ON a.userlevelid = b.userlevelid
        LEFT JOIN
    simrs2012.m_carabayar d ON a.kdcarabayar = d.KODE
        LEFT JOIN
    simrs.l_carabayar_group e ON d.payor_id = e.payor_id
        LEFT JOIN
    simrs.master_login g ON a.uidkasir = g.uid
WHERE
    a.uidkasir = '$username'
        AND a.tglreg >= '$dari_tanggal'
        AND a.tglreg <= '$sampai_tanggal'
        AND b.id_jenis_pelayanan_kasir = $id_jenis_pelayanan_kasir
        AND e.payor_id = $kdcarabayar";
$queryidentitas = mysql_query($sqlidentitas);
$DATA_TOTAL = mysql_fetch_array($queryidentitas);

$sqlusername="SELECT 
    a.pd_nickname, b.userlevelname
FROM
    master_login a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
WHERE
    a.username ='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LAPORAN SHIFT</title>
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
	border-collapse: collapse;
	font-size: 10px;
}
	
.header {
	font-size: 12px;
}	
.footer {
	font-size: 12px;
}

.pagebreak { 
		page-break-before: always;
	}

</style>

</head>
<body>


<table class="header" width="100%" border="0" cellpadding="-3px" cellspacing="0px">
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


<div align="center"><strong>SETORAN RINCIAN PENDAPATAN HARIAN PER SHIFT</strong></div>
<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="11%">Nama Kasir</td>
      <td width="1%">: </td>
      <td width="33%" align="left"><?php echo $RINCIAN['pd_nickname']; ?></td>
      <td width="30%" align="right">Cara Bayar</td>
      <td width="1%">:</td>
      <td width="24%" align="left"><?php echo $RINCIAN['nama_carabayar_group']; ?></td>
    </tr>
    <tr>
      <td>Dari Tanggal</td>
      <td>: </td>
      <td align="left"><?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td align="right">Sampai Tanggal</td>
      <td>:</td>
      <td align="left"><?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>

<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="4%">No.</td>
      <td width="54%" align="left">Objek Penerimaan</td>
      <td width="17%" align="center">Keterangan</td>
      <td width="25%" align="right">Nominal</td>
    </tr>
    <tr>
      <td>1.</td>
      <td align="left">Karcis</td>
      <td>&nbsp;</td>
      <td align="right"><?php echo number_format($RINCIAN['karcis'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>2.</td>
      <td align="left">Tindakan Medis Operatik (TMO)</td>
      <td>&nbsp;</td>
      <td align="right"><?php echo number_format($RINCIAN['tmo'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>3.</td>
      <td align="left">Tindakan Medis Non Operatik (TMNO)</td>
      <td>&nbsp;</td>
      <td align="right"><?php echo number_format($RINCIAN['tmno'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>4.</td>
      <td align="left">Tindakan Keperawatan</td>
      <td>&nbsp;</td>
      <td align="right"><?php echo number_format($RINCIAN['keperawatan'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>5.</td>
      <td align="left">Tindakan Pesalinan</td>
      <td>&nbsp;</td>
      <td align="right"><?php echo number_format($RINCIAN['persalinan'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>6.</td>
      <td align="left">Laboratorium</td>
      <td>&nbsp;</td>
      <td align="right"><?php echo number_format($RINCIAN['lab'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>7.</td>
      <td align="left">Radiologi</td>
      <td>&nbsp;</td>
      <td align="right"><?php echo number_format($RINCIAN['rad'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>8.</td>
      <td align="left">Fisioterapi</td>
      <td>&nbsp;</td>
      <td align="right"><?php echo number_format($RINCIAN['fisio'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>9.</td>
      <td align="left">Obat</td>
      <td>&nbsp;</td>
      <td align="right"><?php echo number_format($RINCIAN['obat'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>10.</td>
      <td align="left">EKG</td>
      <td>&nbsp;</td>
      <td align="right"><?php echo number_format($RINCIAN['ekg'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>11.</td>
      <td align="left">USG</td>
      <td>&nbsp;</td>
      <td align="right"><?php echo number_format($RINCIAN['usg'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td colspan="3" style="text-align: center">TOTAL PENDAPATAN</td>
      <td align="right"><h2><strong>Rp<?php echo number_format($DATA_TOTAL['total'], 0,",","."); ?></strong></h2></td>
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
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.66 * 72, 5.51 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('Setoran Pershift Detail.pdf',array('Attachment' => 0));
?>
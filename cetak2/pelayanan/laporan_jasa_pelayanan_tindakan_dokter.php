<?php
ob_start();
session_start();
include('../connect.php');
$kelas = $_GET['kelas'];
$username = $_GET['username'];
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$id_tindakan= $_GET['id_tindakan'];
$uid= $_GET['uid'];


$whruid.=($uid)?" and a.l_standby_dokter = '$uid'":"";
$sqlitemstok="SELECT 
    d.pd_nickname as ppa, c.nama_tindakan, SUM(a.qty) AS qty, date_format(a.tanggal, '%d-%m-%Y') as tanggal, e.userlevelname
FROM
    simrs.bill_detail_tindakan a
        LEFT JOIN
    simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
        LEFT JOIN
    simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
        LEFT JOIN
    simrs.master_login d ON a.l_standby_dokter = d.uid
	left join 
	simrs.userlevels e on b.userlevelid=e.userlevelid
WHERE
    (b.tglreg >= '$dari_tanggal'
        AND b.tglreg <= '$sampai_tanggal')
        AND a.id_tindakan = $id_tindakan 
        AND b.userlevelid = $userlevelid 
        AND a.kelas = $kelas $whruid
GROUP BY b.tglreg, a.l_standby_dokter, a.id_tindakan order by a.tanggal asc";
$queryitemstok = mysql_query($sqlitemstok);
$queryitemobat = mysql_query($sqlitemstok);
$DATA_OBAT = mysql_fetch_array($queryitemobat);



$sqlitemtotal="SELECT 
    SUM(a.qty) AS total
FROM
    simrs.bill_detail_tindakan a
        LEFT JOIN
    simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
        LEFT JOIN
    simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
        LEFT JOIN
    simrs.master_login d ON a.l_standby_dokter = d.uid
	left join 
	simrs.userlevels e on b.userlevelid=e.userlevelid
WHERE
    (b.tglreg >= '$dari_tanggal'
        AND b.tglreg <= '$sampai_tanggal')
        AND a.id_tindakan = $id_tindakan 
        AND b.userlevelid = $userlevelid 
        AND a.kelas = $kelas $whruid";
$queryitemtotal = mysql_query($sqlitemtotal);
$DATA_TOTAL = mysql_fetch_array($queryitemtotal);

$sqlusername="select a.pd_nickname,b.userlevelname from master_login a left join userlevels b on a.userlevelid=b.userlevelid where a.username=$username";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Jasa Tindakan</title>

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

    <div align="center" class="header"><strong>LAPORAN JASA PELAYANAN TINDAKAN</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="15%">Nama Jasa Pelayanan</td>
      <td>: <?php echo $DATA_OBAT['nama_tindakan']; ?></td>
      <td align="right">Unit</td>
      <td>: <?php echo $DATA_OBAT['userlevelname']; ?></td>
    </tr>
    <tr>
      <td>Kelas</td>
      <td>: <?php echo $kelas ?></td>
      <td align="right">PPA</td>
      <td>:<?php echo $DATA_OBAT['pd_nickname']; ?></td>
    </tr>
    <tr>
      <td>Dari Tanggal</td>
      <td width="31%">: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td width="23%" align="right">Sampai Tanggal</td>
      <td width="31%">: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>

<hr>

<table width="100%" border="1" class="tabel">
  <tbody>
    <tr>
      <td width="2%">No</td>
      <td width="12%" align="center">Tanggal</td>
      <td width="30%" align="center">PPA</td>
      <td width="48%" align="center">Tindakan</td>
      <td width="8%" align="right">Jumlah</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemstok)){
			echo '<tr>';
			echo '<td align="center">'.$no.'</td>';
			echo '<td align="center">'.$data['tanggal'].'</td>';
      		echo '<td align="left">'.$data['ppa'].'</td>';
			echo '<td align="left">'.$data['nama_tindakan'].'</td>';
			echo '<td align="right">'.$data['qty'].'</td>';
			echo '</tr>';
			$no++;
		}
	?>
    <tr>
      <td colspan="4" align="right">TOTAL </td>
      <td align="center" style="font-size: 15px"><strong><?php echo $DATA_TOTAL['total']; ?></strong></td>
    </tr>
  </tbody>
</table>



</body>
</html>


<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 11.69 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporanpengeluaran.pdf',array('Attachment' => 0));
?>
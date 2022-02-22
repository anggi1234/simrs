<?php
ob_start();
session_start();
include('../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$kdcarabayar = $_GET['kdcarabayar'];
$username = $_GET['username'];


$sqliisi="SELECT 
    b.id_jenis_pelayanan_kasir,
    c.nama,
    COUNT(*) AS jml_pasien,
    ROUND(SUM(a.total_keseluruhan), 0) AS total,
    e.nama_carabayar_group,
    g.pd_nickname
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs.userlevels b ON a.userlevelid = b.userlevelid
        LEFT JOIN
    simrs.l_jenis_pelayanan_kasir c ON b.id_jenis_pelayanan_kasir = c.id_jenis_pelayanan_kasir
        LEFT JOIN
    simrs2012.m_carabayar d ON a.kdcarabayar = d.KODE
        LEFT JOIN
    simrs.l_carabayar_group e ON d.payor_id = e.payor_id
        LEFT JOIN
    simrs.master_login g ON a.uidkasir = g.uid
WHERE
    e.payor_id = $kdcarabayar
        AND (a.tglreg >= '$dari_tanggal'
        AND a.tglreg <= '$sampai_tanggal')
        AND a.uidkasir = '$username'
        AND a.id_status_transaksi = 2
GROUP BY b.id_jenis_pelayanan_kasir";
 $queryisi = mysql_query($sqliisi);

$sqlidentitas="SELECT 
    ROUND(SUM(a.total_keseluruhan), 0) AS total,e.nama_carabayar_group
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs.userlevels b ON a.userlevelid = b.userlevelid
        LEFT JOIN
    simrs.l_jenis_pelayanan_kasir c ON b.id_jenis_pelayanan_kasir = c.id_jenis_pelayanan_kasir
        LEFT JOIN
    simrs2012.m_carabayar d ON a.kdcarabayar = d.KODE
        LEFT JOIN
    simrs.l_carabayar_group e ON d.payor_id = e.payor_id
        LEFT JOIN
    simrs.master_login g ON a.uidkasir = g.uid
WHERE
    e.payor_id = $kdcarabayar
        AND (a.tglreg >= '$dari_tanggal'
        AND a.tglreg <= '$sampai_tanggal')
        AND a.uidkasir = '$username'
        AND a.id_status_transaksi = 2
GROUP BY b.id_jenis_pelayanan_kasir";
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
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}
	
.tabel {
	border-collapse: collapse;
	font-size: 12px;
	text-align: right;
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


<div align="center"><strong>SETORAN PENDAPATAN HARIAN</strong></div>
<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="15%">Nama Kasir</td>
      <td width="4%">: </td>
      <td width="26%" align="left"><?php echo $CARABAYAR['pd_nickname']; ?></td>
      <td width="30%" align="right">Cara Bayar</td>
      <td width="2%">:</td>
      <td width="23%" align="left"><?php echo $DATA_TOTAL['nama_carabayar_group']; ?></td>
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
      <td width="17%">Jumlah Pasien</td>
      <td width="25%">Nominal</td>
    </tr>
    <?php
	  	$no=1;
		while($data=mysql_fetch_assoc($queryisi)){
			echo '<tr>';
	  		echo '<td align="center">'.$no.'.</td>';
			echo '<td align="left">'.$data['nama'].'</td>';
			echo '<td>'.$data['jml_pasien'].'</td>';
			echo '<td>'.number_format($data['total'], 0,",",".").'</td>';
			echo '</tr>';
			
			$no++;
		}
	?>
    <tr>
      <td colspan="3" style="text-align: center">TOTAL PENDAPATAN</td>
      <td><h2><strong>Rp <?php echo number_format($DATA_TOTAL['total'], 0,",","."); ?></strong></h2></td>
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
$dompdf->stream('notafarmasi.pdf',array('Attachment' => 0));
?>
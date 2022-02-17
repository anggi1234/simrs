<?php
ob_start();
session_start();
include('../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$username = $_GET['username'];

$sqlitem="SELECT 
    a.idxdaftar,
    a.tglreg,
    a.nomr,
    b.nama as namapasien,
    b.alamat,
    b.jeniskelamin,
    c.userlevelname,
    d.nama AS carabayar,
    e.tindakan,
    IFNULL(e.total, 0) AS total
FROM
    (SELECT 
        a.id_bill_detail_tarif,
            GROUP_CONCAT(b.nama_tindakan
                SEPARATOR ', ') AS tindakan,
            SUM(a.total) AS total
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.master_tindakan b ON a.id_tindakan = b.id_tindakan
    WHERE
        a.userlevelid IS NOT NULL
            AND b.userlevelid = $userlevelid
    GROUP BY a.id_bill_detail_tarif) e
        LEFT JOIN
    simrs.bill_detail_tarif a ON a.id_bill_detail_tarif = e.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs.userlevels c ON a.userlevelid = c.userlevelid
        LEFT JOIN
    simrs2012.m_carabayar d ON a.kdcarabayar = d.kode
WHERE
    a.tglreg >= '$dari_tanggal'
        AND a.tglreg <= '$sampai_tanggal'
        AND a.userlevelid = '$userlevelid'
GROUP BY a.id_bill_detail_tarif";
$queryitem = mysql_query($sqlitem);



$sqlusername="select pd_nickname from master_login where username='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

$sqltotal="SELECT 
        sum(a.total) as total
    FROM
        simrs.bill_detail_tindakan a left join bill_detail_tarif b on a.id_bill_detail_tarif=b.id_bill_detail_tarif
    WHERE
        a.userlevelid IS NOT NULL
            AND a.userlevelid = $userlevelid and (date(b.tanggal) >= '$dari_tanggal' and date(b.tanggal) <= '$sampai_tanggal');";
 $querytotal = mysql_query($sqltotal);
 $DATA_TOTAL = mysql_fetch_array($querytotal);

 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LAPORAN HARIAN PPA</title>
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
	font-size: 10px;
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
  
    <div align="center"><strong>LAPORAN TINDAKAN</strong></div>

<!-- <table width="100%" class="tabel" border="1">
    <tr>
	  <td width="2%" align="left" class="a"><strong>NO.</strong></td>
      <td width="5%" align="center" class="a"><strong>TANGGAL</strong></td>
      <td width="3%" align="center" class="a"><strong>NOMR</strong></td>
	  <td width="7%" align="center" class="a"><strong>NAMA</strong></td>
      <td width="10%" align="center" class="a"><strong>ALAMAT</strong></td>
      <td width="2%" align="center" class="a"><strong>JK</strong></td>
      <td width="5%" align="center" class="a"><strong>UNIT</strong></td>
      <td width="5%" align="center" class="a"><strong>CARA BAYAR</strong></td>
      <td width="35%" align="center" class="a"><strong>TINDAKAN</strong></td>
      <td width="5%" align="center" class="a"><strong>TOTAL</strong></td>
  </tr>
	<?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
		    echo '<td valign="top" class="a kosong" align="center">'.$no.'</td>';
			echo '<td valign="top" class="a kosong" align="center">'.$data['tglreg'].'</td>';
		    echo '<td valign="top" class="a kosong" align="center">'.$data['nomr'].'</td>';
			echo '<td valign="top" class="a kosong">'.$data['namapasien'].'</td>';
			echo '<td valign="top" class="a kosong">'.$data['alamat'].'</td>';
			echo '<td valign="top" class="a kosong" align="center">'.$data['jeniskelamin'].'</td>';
			echo '<td valign="top" class="a kosong">'.$data['userlevelname'].'</td>';
			echo '<td valign="top" class="a kosong">'.$data['carabayar'].'</td>';
			echo '<td valign="top" class="a kosong">'.$data['tindakan'].'</td>';
			echo '<td valign="top" class="a kosong" align="right">'.number_format($data['total'], 0,",",".").'</td>';
			echo '</tr>';
			
			$no++;
		}
	
    
	?>
	<tr>
      <td colspan="10" align="right"><table width="100%" border="0">
        <tbody>
     <tr>
       <td width="17%" align="center">Petugas</td>
      <td colspan="6" align="right">JUMLAH TOTAL</td>
      <td width="15%" align="right" class="total"><strong style="font-size: 18px">Rp <?php echo number_format($DATA_TOTAL['total'], 0,",","."); ?></strong><hr></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td align="right" class="total">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_USERNAME['pd_nickname']; ?></td>
      <td colspan="6" align="right">&nbsp;</td>
      <td align="right" class="total">&nbsp;</td>
    </tr>
        </tbody>
      </table></td>
    </tr>
	
</table> -->


</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 12.99 * 72, 8.26 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('LAPORAN_SENSUS.pdf',array('Attachment' => 0));
?>
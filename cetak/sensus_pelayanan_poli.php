<?php
ob_start();
session_start();
include('../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$username = $_GET['username'];
$kddokter = $_GET['uid'];

$whrkddokter.=($kddokter)?" AND j.uid = '$kddokter'":"";
$sqlitem="
SELECT 
    c.id_bill_detail_tarif AS NOREF,
    DATE_FORMAT(c.tanggal, '%d-%m-%Y') AS tanggal,
    d.NOMR,
    d.NAMA,
    d.ALAMAT,
    d.JENISKELAMIN,
    REPLACE(g.userlevelname,
        'POLIKLINIK',
        '') AS UNIT,
    h.NAMA AS cara_bayar,
    i.NAMADOKTER AS DPJP,
    c.biaya_penj_radiologi AS biaya_radiologi,
    c.biaya_penj_laboratorium AS biaya_laboratorium,
    c.total_keseluruhan,
    (SELECT 
            GROUP_CONCAT(CONCAT(z.icd10, '', y.str)
                    SEPARATOR ',') AS diagnosa
        FROM
            simrs.bill_detail_penyakit z
                LEFT JOIN
            simrs2012.vw_diagnosa_eklaim y ON z.icd10 = y.code
        WHERE
            z.id_bill_detail_tarif = c.id_bill_detail_tarif
        GROUP BY z.id_bill_detail_tarif) AS diagnosa,
    (SELECT 
            GROUP_CONCAT(CONCAT(y.nama_tindakan)
                    SEPARATOR ',') AS tindakan
        FROM
            simrs.bill_detail_tindakan z
                LEFT JOIN
            master_tindakan y ON z.id_tindakan = y.id_tindakan
        WHERE
            z.id_bill_detail_tarif = c.id_bill_detail_tarif
                AND y.userlevelid IS NULL
        GROUP BY z.id_bill_detail_tarif) AS tindakan
FROM
    bill_detail_tarif c
        LEFT JOIN
    simrs2012.m_pasien d ON c.nomr = d.NOMR
        LEFT JOIN
    userlevels g ON c.userlevelid = g.userlevelid
        LEFT JOIN
    simrs2012.m_carabayar h ON h.kode = c.kdcarabayar
        LEFT JOIN
    simrs2012.m_dokter i ON c.kddokter = i.KDDOKTER
		LEFT JOIN
    simrs.master_login j ON i.kddokter = j.kddokter
where 
date(c.tanggal)>='$dari_tanggal' and 
date(c.tanggal)<='$sampai_tanggal' and 
c.userlevelid=$userlevelid $whrkddokter
GROUP BY c.id_bill_detail_tarif , c.userlevelid;";
$queryitem = mysql_query($sqlitem);



$sqlusername="select pd_nickname from master_login where username='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

$sqltotal="SELECT 
    SUM(c.total_keseluruhan) AS total
FROM
    bill_detail_tarif c
		LEFT JOIN
    simrs2012.m_dokter i ON c.kddokter = i.KDDOKTER
        LEFT JOIN
    simrs.master_login j ON i.kddokter = j.kddokter
where date(c.tanggal)>='$dari_tanggal' and date(c.tanggal)<='$sampai_tanggal' and c.userlevelid=$userlevelid $whrkddokter";
 $querytotal = mysql_query($sqltotal);
 $DATA_TOTAL = mysql_fetch_array($querytotal);
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SENSUS HARIAN RAWAT JALAN</title>
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
      <td width="90%" align="center" style="font-size: 16px">PEMERINTAH KOTA PAGAR ALAM</td>
    </tr>
    <tr>
      <td align="center"><strong style="font-size: 21px">RUMAH SAKIT UMUM DAERAH BESEMAH</strong></td>
    </tr>
    <tr>
      <td align="center" style="font-size: 14px">JL AIS NASUTION NO 03 KOTA PAGAR ALAM.31551.</td>
    </tr>
</table>
  <hr>
  

    <div align="center"><strong>LAPORAN SENSUS HARIAN POLI</strong></div>






<table width="100%" class="tabel" border="1">
    <tr>
	  <td width="2%" align="left" class="a"><strong>No</strong></td>
      <td width="7%" align="center" class="a"><strong>TANGGAL</strong></td>
      <td width="4%" align="center" class="a"><strong>NOMR</strong></td>
	  <td width="10%" align="center" class="a"><strong>NAMA</strong></td>
      <td width="11%" align="center" class="a"><strong>ALAMAT</strong></td>
      <td width="3%" align="center" class="a"><strong>JK</strong></td>
      <td width="5%" align="center" class="a"><strong>UNIT</strong></td>
      <td width="8%" align="center" class="a"><strong>CARABAYAR</strong></td>
      <td width="15%" align="center" class="a"><strong>TINDAKAN</strong></td>
      <td width="11%" align="center" class="a"><strong>DIAGNOSA</strong></td>
      <td width="6%" align="center" class="a"><strong>DPJP</strong></td>
      <td width="5%" align="center" class="a"><strong>RAD</strong></td>
      <td width="5%" align="center" class="a"><strong>LAB</strong></td>
      <td width="8%" align="center" class="a"><strong>TOTAL</strong></td>
  </tr>
	<?php
	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="14">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
	  echo '<td valign="top" class="a kosong" align="center">'.$no.'</td>';
	  echo '<td valign="top" class="a kosong" align="center">'.$data['tanggal'].'</td>';
			echo '<td valign="top" class="a kosong" align="center">'.$data['NOMR'].'</td>';
			echo '<td valign="top" class="a kosong">'.$data['NAMA'].'</td>';
			echo '<td valign="top" class="a kosong">'.$data['ALAMAT'].'</td>';
			echo '<td valign="top" class="a kosong" align="center">'.$data['JENISKELAMIN'].'</td>';
			echo '<td valign="top" class="a kosong">'.$data['UNIT'].'</td>';
			echo '<td valign="top" class="a kosong">'.$data['cara_bayar'].'</td>';
			echo '<td valign="top" class="a kosong">'.$data['tindakan'].'</td>';
			echo '<td valign="top" class="a kosong">'.$data['diagnosa'].'</td>';
			echo '<td valign="top" class="a kosong">'.$data['DPJP'].'</td>';
			echo '<td valign="top" class="a kosong" align="right">'.$data['biaya_radiologi'].'</td>';
			echo '<td valign="top" class="a kosong" align="right">'.$data['biaya_laboratorium'].'</td>';
			echo '<td valign="top" class="a kosong" align="right">'.number_format($data['total_keseluruhan'], 0,",",".").'</td>';
      
			echo '</tr>';
			
			$no++;
		}
	}
    
	?>
	<tr>
      <td colspan="14" align="right"><table width="100%" border="0">
        <tbody>
     <tr>
       <td width="29%" align="center">Petugas</td>
      <td colspan="6" align="right">JUMLAH TOTAL</td>
      <td width="15%" align="right" class="total" style="font-size: 18px"><strong>Rp <?php echo number_format($DATA_TOTAL['total'], 0,",","."); ?></strong></td>
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
	
  </table>


</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72); // 12" x 12"
$dompdf->set_paper($paper_size, 'landscape');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('LAPORAN_SENSUS.pdf',array('Attachment' => 0));
?>
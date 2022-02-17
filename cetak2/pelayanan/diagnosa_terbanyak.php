<?php
ob_start();
session_start();
include('../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$username = $_GET['username'];
$jeniskasus = $_GET['jeniskasus'];

$sqlidentitas="select b.userlevelname from bill_detail_tarif a left join userlevels b on a.userlevelid=b.userlevelid where a.userlevelid=$userlevelid";
 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);
 
$whruserlevelid.=($userlevelid)?" AND b.userlevelid = $userlevelid":"";
$whrjeniskasus.=($jeniskasus)?" AND a.id_kasus = $jeniskasus":"";
$sqlitem="SELECT 
    CONCAT(a.icd10, ', ', c.str) AS diagnosa, COUNT(*) AS jumlah
FROM
    simrs.bill_detail_penyakit a
        LEFT JOIN
    simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.vw_diagnosa_eklaim c ON a.icd10 = c.code
WHERE
    b.tglreg >= '$dari_tanggal'
        AND b.tglreg <= '$sampai_tanggal'
        AND CONCAT(a.icd10, ', ', c.str) IS NOT NULL
         $whruserlevelid $whrjeniskasus
GROUP BY a.icd10
ORDER BY COUNT(*) DESC limit 10";
$queryitem = mysql_query($sqlitem);



$sqlusername="select pd_nickname from master_login where username='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

$sqlunit="SELECT * FROM simrs.l_jenis_kasus where id_jenis_kasus=$jeniskasus";
 $queryunit = mysql_query($sqlunit);
 $DATA_UNIT = mysql_fetch_array($queryunit);

$sqlunit1="SELECT * FROM simrs.userlevels where userlevelid=$userlevelid";
 $queryunit1 = mysql_query($sqlunit1);
 $DATA_UNIT1 = mysql_fetch_array($queryunit1);
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LAPORAN DIAGNOSA TERBESAR</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
		font-family: Gotham, Helvetica Neue, Helvetica, Arial," sans-serif";
		font-size: 12px;
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 12px;
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

    <div align="center"><strong>LAPORAN 10 DIAGNOSA TERBESAR</strong></div>



<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="12%">Dari Tanggal</td>
      <td width="27%">: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td width="15%" align="right">Sampai Tanggal</td>
      <td width="46%">: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
    <tr>
      <td>Jenis Kasus</td>
      <td>: <?php echo $DATA_UNIT['nama_kasus'];?></td>
      <td align="right">Unit</td>
      <td>: <?php echo $DATA_UNIT1['userlevelname'];?></td>
    </tr>
  </tbody>
</table>


<table width="100%" class="tabel" border="1">
    <tr>
	  <td width="5%" align="left" class="a"><strong>NO</strong></td>
      <td width="60%" align="left" class="a"><strong>NAMA DIAGNOSA</strong></td>
      <td width="30%" align="center" class="a"><strong>JUMLAH</strong></td>
      
  </tr>
	<?php
	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="3">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
	  echo '<td class="a kosong" align="center">'.$no.'</td>';
      echo '<td class="a kosong">'.$data['diagnosa'].'</td>';
	  echo '<td class="a kosong" align="center">'.$data['jumlah'].'</td>';
		
      
			echo '</tr>';
			
			$no++;
		}
	}
    
	?>
	<tr>
      <td colspan="3" align="right"><table width="100%" border="0">
        <tbody>
     <tr>
       <td width="40%" align="center">Petugas</td>
      <td colspan="6" align="right">&nbsp;</td>
      </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td colspan="6" align="right">&nbsp;</td>
      </tr>
    <tr>
      <td align="center"><?php echo $DATA_USERNAME['pd_nickname']; ?></td>
      <td colspan="6" align="right">&nbsp;</td>
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
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('LAPORAN_DIAGNOSA_TERBESAR.pdf',array('Attachment' => 0));
?>
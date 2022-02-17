<?php
ob_start();
session_start();
include('../connect.php');
$dari_tanggal   = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];


$sqlitem="SELECT 
    tanggal,count(*) as jumlah
FROM
    simrs.expertise_radiologi
    WHERE (DATE(tanggal) >= '$dari_tanggal'
        AND DATE(tanggal) <= '$sampai_tanggal')
		group by tanggal";
$queryitem = mysql_query($sqlitem);



$sqlusername="select pd_nickname from master_login where username='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LAPORAN PENJUNJANG</title>
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
  
    <div align="center"><strong>LAPORAN HARIAN INSTALASI RADIOLOGI</strong></div>
    
    
<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="12%">Dari Tanggal</td>
      <td width="27%">: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td width="15%" align="right">Sampai Tanggal</td>
      <td width="46%">: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>

    <table width="100%" class="tabel" border="1">
    <tr>
      <td width="5%" align="center"><strong>NO.</strong></td>
      <td width="16%" align="center"><strong>Tanggal</strong></td>
      <td width="16%" align="center"><strong>Expertaise</strong></td>
  </tr>
	<?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
      echo '<td valign="top" align="center">'.$no.'</td>';
      echo '<td valign="top" align="left">'.$data['tanggal'].'</td>';
      echo '<td valign="top" align="left">'.$data['jumlah'].'</td>';
			echo '</tr>';
			
			$no++;
		}
	
    
	?>
	
</table>


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
$dompdf->stream('LAPORAN_JUMLAH_EXPERTISE.pdf',array('Attachment' => 0));
?>
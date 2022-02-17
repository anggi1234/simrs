<?php
ob_start();
session_start();
include('../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$username = $_GET['username'];

$sqlidentitas="select b.userlevelname from bill_detail_tarif a left join userlevels b on a.userlevelid=b.userlevelid where a.userlevelid=$userlevelid";
 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);
 

$sqlitem=" 
SELECT 
    a.id_penyakit,a.userlevelid, b.nama_penyakit as diagnosa, c.jumlah
FROM
    bill_detail_penyakit a
        JOIN
    (SELECT 
        *
    FROM
        (SELECT 
        id_penyakit, COUNT(1) AS jumlah
    FROM
        bill_detail_penyakit where date(tanggal)>='$dari_tanggal' and date(tanggal)<='$sampai_tanggal' and userlevelid=$userlevelid
    GROUP BY id_penyakit,userlevelid) b
    LIMIT 10) c ON a.id_penyakit = c.id_penyakit
        LEFT JOIN
    master_penyakit b ON a.id_penyakit = b.id_master_penyakit
    group by a.id_penyakit,a.userlevelid order by c.jumlah desc
";
$queryitem = mysql_query($sqlitem);



$sqlusername="select pd_nickname from master_login where username='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

$sqltotal="SELECT 
    SUM(total_keseluruhan) AS total
FROM
    bill_detail_tarif
where tanggal>='$dari_tanggal' and tanggal<='$sampai_tanggal' and userlevelid=$userlevelid";
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
            margin-top: 0.1 cm;
            margin-left: 0.1 cm;
			margin-right: 0.1 cm;
			margin-bottom: 0.1 cm;
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


<table width="100%" class="tabel" border="1">
    <tr>
      <td width="10%" style="vertical-align:top" class="header"><img src="../gambar/logobms.png" height="60px" /></td>
      <td width="90%" style="vertical-align:top" height="60px" class="header"><strong>RSUD AJIBARANG</strong><br />
          <strong>Jl. Raya Pancasan - Ajibarang, Banyumas<br />
      TELP: (0281) 557 0004 FAX: - (0281)5670005<br />
      Kode Pos : 53163 -</strong></td>
      <td width="20%" style="vertical-align:top" class="header"> Tanggal Cetak: <?php echo date("d-m-Y") ?> <br> Unit: <?php echo $DATA_IDENTITAS['userlevelname']; ?></td>
    </tr>
</table>
  

    <div align="center"><strong>LAPORAN DIAGNOSA TERBESAR</strong></div>






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
       <td width="17%" align="center">Petugas</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td width="15%" align="right" class="total">&nbsp;</td>
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
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('LAPORAN_DIAGNOSA_TERBESAR.pdf',array('Attachment' => 0));
?>
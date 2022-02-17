<?php
ob_start();
session_start();
include('../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$kdcarabayar= $_GET['kdcarabayar'];
$username = $_GET['username'];

$sqlitem="SELECT 
    a.userlevelname,
    IFNULL((SELECT 
                    COUNT(*) AS jumlah
                FROM
                    simrs.bill_detail_tarif_detail z
                        LEFT JOIN
                    simrs2012.m_carabayar x ON z.kdcarabayar = x.kode
                        LEFT JOIN
                    l_carabayar_group y ON x.payor_id = y.payor_id
                WHERE
                    y.payor_id = $kdcarabayar
                        AND z.tanggal_input >= '$dari_tanggal'
                        AND z.tanggal_input <= '$sampai_tanggal'
                        AND z.userlevelid_asal = a.userlevelid
                GROUP BY z.userlevelid_asal),
            0) AS jumlah
FROM
    simrs.userlevels a
WHERE
    a.id_jenis_pelayanan_farmasi IS NOT NULL";
$queryitem = mysql_query($sqlitem);



$sqlusername="SELECT 
    y.nama_carabayar_group
FROM
    l_carabayar_group y
WHERE
    y.payor_id = $kdcarabayar";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LAPORAN PENUNJANG PER CARABAYAR</title>
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
  
    <div align="center"><strong>LAPORAN PASIEN PEMERIKSAAN PENUNJANG</strong></div>
    <div align="center"></div>
    
    
    <table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td>Cara Bayar</td>
      <td>: <?php echo $DATA_USERNAME["nama_carabayar_group"]; ?></td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
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
      <td width="5%" align="center">NO.</td>
      <td width="76%" align="center">UNIT</td>
      <td width="19%" align="center">JUMLAH</td>
   	</tr>
   	<?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
      echo '<td valign="top" align="center">'.$no.'</td>';
      echo '<td valign="top" align="left">'.$data['userlevelname'].'</td>';
      echo '<td valign="top" align="center">'.$data['jumlah'].'</td>';
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
$dompdf->stream('LAPORAN_SENSUS.pdf',array('Attachment' => 0));
?>
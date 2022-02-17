<?php
ob_start();
session_start();
include('../connect.php');
$tahun  = $_GET['tahun_id'];
$userlevelid= $_GET['jenis_farmasi'];

$sqlitem="SELECT 
    COUNT(a.id_bill_detail_permintaan_obat_master) AS JUMLAH,
    MONTH(a.tanggal) AS BULAN,
    YEAR(a.tanggal) AS TAHUN
FROM
    (SELECT 
        id_bill_detail_permintaan_obat_master, tanggal, userlevelid
    FROM
        simrs.bill_detail_permintaan_obat_master
    GROUP BY id_bill_detail_tarif) a
WHERE
    YEAR(a.tanggal) = $tahun
        AND a.userlevelid = $userlevelid
GROUP BY MONTH(a.tanggal);";
$queryitem = mysql_query($sqlitem);

function bulan($bulan)
{
Switch ($bulan){
    case 1 : $bulan="Januari";
        Break;
    case 2 : $bulan="Februari";
        Break;
    case 3 : $bulan="Maret";
        Break;
    case 4 : $bulan="April";
        Break;
    case 5 : $bulan="Mei";
        Break;
    case 6 : $bulan="Juni";
        Break;
    case 7 : $bulan="Juli";
        Break;
    case 8 : $bulan="Agustus";
        Break;
    case 9 : $bulan="September";
        Break;
    case 10 : $bulan="Oktober";
        Break;
    case 11 : $bulan="November";
        Break;
    case 12 : $bulan="Desember";
        Break;
    }
return $bulan;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LAPORAN JUMLAH PENERIMA OBAT PERBULAN</title>
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
  
    <div align="center"><strong>LAPORAN JUMLAH PENERIMA OBAT PERBULAN</strong></div>

<table width="100%" class="tabel" border="1">
    <tr>
      <td width="4%" align="center" class="a"><strong>NO.</strong></td>
      <td width="34%" align="center" class="a"><strong>BULAN</strong></td>
      <td width="40%" align="center" class="a"><strong>TAHUN</strong></td>
      <td width="22%" align="center" class="a"><strong>JUMLAH</strong></td>
  </tr>
	<?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
		  echo '<td valign="top" class="a kosong" align="center">'.$no.'</td>';
      echo '<td valign="top" class="a kosong" align="center">'.bulan($data['BULAN']).'</td>';
			echo '<td valign="top" class="a kosong" align="center">'.$data['TAHUN'].'</td>';
		  echo '<td valign="top" class="a kosong" align="center">'.$data['JUMLAH'].'</td>';
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
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('LAPORAN_JUMLAH_PENERIMA_OBAT.pdf',array('Attachment' => 0));
?>
<?php
ob_start();
include('../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$username = $_GET['username'];

$sqlitem="SELECT 
    DATE_FORMAT(e.tglreg, '%d-%m-%Y') AS tglreg,
    a.nomr,
    b.nama,
    b.alamat,
    c.userlevelname AS unit,
    d.userlevelname AS ke_unit,
    f.nama as carabayar
FROM
    simrs.bill_detail_transfer_pasien a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs.userlevels c ON a.userlevelid = c.userlevelid
        LEFT JOIN
    simrs.userlevels d ON a.userlevelid_transfer = d.userlevelid
        LEFT JOIN
    simrs.bill_detail_tarif e ON a.id_bill_detail_tarif = e.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_carabayar f ON e.kdcarabayar = f.kode
WHERE
    a.id_status_keluar = 5 AND (e.tglreg >='$dari_tanggal' and e.tglreg <='$sampai_tanggal') and a.userlevelid_transfer=$userlevelid";
$queryitem = mysql_query($sqlitem);



 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SENSUS HARIAN KONSULTASI POLI</title>
<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
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
  

    <div align="center"><strong>LAPORAN SENSUS HARIAN POLI</strong></div>






<table width="100%" class="tabel" border="1">
    <tr>
	  <td width="3%" align="left" class="a"><strong>No</strong></td>
      <td width="7%" align="center" class="a"><strong>TANGGAL</strong></td>
      <td width="6%" align="center" class="a"><strong>NOMR</strong></td>
	  <td width="18%" align="center" class="a"><strong>NAMA</strong></td>
      <td width="29%" align="center" class="a"><strong>ALAMAT</strong></td>
      <td width="11%" align="center" class="a"><strong>DARI UNIT</strong></td>
      <td width="11%" align="center" class="a"><strong>KE UNIT</strong></td>
      <td width="15%" align="center" class="a"><strong>CARA BAYAR</strong></td>
  </tr>
	<?php
	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="8">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
	  		echo '<td valign="top" class="a kosong" align="center">'.$no.'</td>';
	  		echo '<td valign="top" class="a kosong" align="center">'.$data['tglreg'].'</td>';
			echo '<td valign="top" class="a kosong" align="center">'.$data['nomr'].'</td>';
			echo '<td valign="top" class="a kosong">'.$data['nama'].'</td>';
			echo '<td valign="top" class="a kosong">'.$data['alamat'].'</td>';
			echo '<td valign="top" class="a kosong">'.$data['unit'].'</td>';
			echo '<td valign="top" class="a kosong">'.$data['ke_unit'].'</td>';
      		echo '<td valign="top" class="a kosong">'.$data['carabayar'].'</td>';
			echo '</tr>';
			
			$no++;
		}
	}
    
	?>
  </table>


</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72); // 12" x 12"
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('LAPORAN_SENSUS_KONSUL.pdf',array('Attachment' => 0));
?>
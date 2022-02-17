<?php
ob_start();
session_start();
include('../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$username = $_GET['username'];
$kddokter = $_GET['kddokter'];

$whrkddokter.=($kddokter)?" and a.kddokter = '$kddokter'":"";
$whrunit.=($userlevelid)?" and a.userlevelid = '$userlevelid'":"";

$sqlitem="SELECT 
    a.nomr,
    b.nama,
    b.alamat,
    c.call_unit,
    d.nama AS carabayar,
    e.nama_dokter,
    (SELECT 
            GROUP_CONCAT(y.nama_tindakan
                    SEPARATOR ', ') AS tindakan
        FROM
            bill_detail_tindakan z
                LEFT JOIN
            master_tindakan y ON z.id_tindakan = y.id_tindakan
        WHERE
            z.id_bill_detail_tarif = a.id_bill_detail_tarif and y.userlevelid is null
        GROUP BY z.id_bill_detail_tarif) AS tindakan,
    f.keterangan
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs.userlevels c ON a.userlevelid = c.userlevelid
        LEFT JOIN
    simrs2012.m_carabayar d ON a.kdcarabayar = d.kode
        LEFT JOIN
    simrs.m_dokter e ON a.kddokter = e.kddokter
        AND a.userlevelid = e.userlevelid
        LEFT JOIN
    simrs.m_statuskeluar f ON a.id_status_pasien = f.status
WHERE
    (a.tglreg >= '$dari_tanggal'
        AND a.tglreg <= '$sampai_tanggal')
        AND (a.id_status_pasien = 2 or a.id_status_pasien = 4) $whrkddokter $whrunit and (a.userlevelid < 100 and a.userlevelid != 10 and a.userlevelid != 9)";
$queryitem = mysql_query($sqlitem);



$sqlitemunit="select userlevelname from userlevels where userlevelid=$userlevelid";
$queryitemunit = mysql_query($sqlitemunit);
$DATA_USERNAME = mysql_fetch_array($queryitemunit);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LAPORAN KEDATANGAN PASIEN</title>
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
	font-size: 10px;
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
  

    <div align="center"><strong>LAPORAN RUJUK RAWAT INAP</strong></div>


<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="9%">Dari Tanggal</td>
      <td width="38%">: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td width="15%" align="right">Sampai Tanggal</td>
      <td width="38%">: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>



<table width="100%" class="tabel" border="1">
    <tr>
	  <td width="2%" align="left" class="a"><strong>No</strong></td>
	  <td width="3%" align="center" class="a"><strong>NOMR</strong></td>
      <td width="14%" align="center" class="a"><strong>NAMA</strong></td>
      <td width="19%" align="center" class="a"><strong>ALAMAT</strong></td>
      <td width="10%" align="center" class="a"><strong>CARA BAYAR</strong></td>
      <td width="6%" align="center" class="a"><strong>UNIT</strong></td>
      <td width="16%" align="center" class="a"><strong>DOKTER</strong></td>
      <td width="15%" align="center" class="a"><strong>TINDAKAN</strong></td>
	  <td width="15%" align="center" class="a"><strong>KETERANGAN LAIN</strong></td>
  </tr>
	<?php
	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="9">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
			echo '<td valign="top">'.$no.'.</td>';
			echo '<td valign="top" align="center">'.$data['nomr'].'</td>';
			echo '<td valign="top">'.$data['nama'].'</td>';
			echo '<td valign="top">'.$data['alamat'].'</td>';
      		echo '<td valign="top">'.$data['carabayar'].'</td>';
			echo '<td valign="top">'.$data['call_unit'].'</td>';
			echo '<td valign="top">'.$data['nama_dokter'].'</td>';
			echo '<td valign="top">'.$data['tindakan'].'</td>';
			echo '<td valign="top" align="center">'.$data['keterangan'].'</td>';
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
$dompdf->set_paper($paper_size, 'landscape');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('LAPORAN_KEDATANGAN_PASIEN.pdf',array('Attachment' => 0));
?>
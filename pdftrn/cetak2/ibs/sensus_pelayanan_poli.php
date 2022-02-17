<?php
ob_start();
session_start();
include('../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$username = $_GET['username'];

$sqlitem="SELECT 
    c.id_bill_detail_tarif AS NOREF,
    date_format(c.tanggal,'%d-%m-%Y') as tanggal,
    d.NOMR,
    d.NAMA,
    d.ALAMAT,
    d.JENISKELAMIN,
    g.userlevelname AS UNIT,
    h.NAMA AS cara_bayar,
    GROUP_CONCAT(b.nama_tindakan
        SEPARATOR ',') AS tindakan,
    e.diagnosa,
    i.NAMADOKTER AS DPJP,
    c.biaya_penj_radiologi AS biaya_radiologi,
    c.biaya_penj_laboratorium AS biaya_laboratorium,
    c.total_keseluruhan
FROM
    bill_detail_tindakan a
        LEFT JOIN
    master_tindakan b ON a.id_tindakan = b.id_tindakan
        LEFT JOIN
    bill_detail_tarif c ON a.id_bill_detail_tarif = c.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_pasien d ON c.nomr = d.NOMR
        LEFT JOIN
    userlevels g ON a.userlevelid = g.userlevelid
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            GROUP_CONCAT(b.nama_penyakit
                SEPARATOR ',') AS diagnosa,
            a.userlevelid
    FROM
        bill_detail_penyakit a
    LEFT JOIN master_penyakit b ON a.id_penyakit = b.id_master_penyakit
    GROUP BY userlevelid,id_bill_detail_tarif) e ON e.id_bill_detail_tarif = c.id_bill_detail_tarif
        AND g.userlevelid = e.userlevelid
        LEFT JOIN
    simrs2012.m_carabayar h ON h.kode = c.kdcarabayar
        LEFT JOIN
    simrs2012.m_dokter i ON c.kddokter = i.KDDOKTER where date(c.tanggal)>='$dari_tanggal' and date(c.tanggal)<='$sampai_tanggal' and c.userlevelid=$userlevelid
GROUP BY c.id_bill_detail_tarif , c.userlevelid;";
$queryitem = mysql_query($sqlitem);



$sqlusername="select pd_nickname from master_login where username='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

$sqltotal="SELECT 
    SUM(total_keseluruhan) AS total
FROM
    bill_detail_tarif
where date(tanggal)>='$dari_tanggal' and date(tanggal)<='$sampai_tanggal' and userlevelid=$userlevelid";
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
	  <td width="2%" align="left" class="a"><strong>No</strong></td>
      <td width="5%" align="left" class="a"><strong>NO PEL</strong></td>
      <td width="5%" align="center" class="a"><strong>TANGGAL</strong></td>
      <td width="5%" align="center" class="a"><strong>NOMR</strong></td>
	  <td width="10%" align="center" class="a"><strong>NAMA</strong></td>
      <td width="10%" align="center" class="a"><strong>ALAMAT</strong></td>
      <td width="2%" align="center" class="a"><strong>JK</strong></td>
      <td width="5%" align="center" class="a"><strong>UNIT</strong></td>
      <td width="5%" align="center" class="a"><strong>CARA BAYAR</strong></td>
      <td width="15%" align="center" class="a"><strong>TINDAKAN</strong></td>
      <td width="10%" align="center" class="a"><strong>DIAGNOSA</strong></td>
      <td width="5%" align="center" class="a"><strong>DPJP</strong></td>
      <td width="5%" align="center" class="a"><strong>BIAYA RAD</strong></td>
      <td width="5%" align="center" class="a"><strong>BIAYA LAB</strong></td>
      <td width="5%" align="center" class="a"><strong>TOTAL</strong></td>
  </tr>
	<?php
	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="15">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
      echo '<td valign="top" class="a kosong">'.$data['NOREF'].'</td>';
	
      
			echo '</tr>';
			
			$no++;
		}
	}
    
	?>
	<tr>
      <td colspan="15" align="right"><table width="100%" border="0">
        <tbody>
     <tr>
       <td width="17%" align="center">Petugas</td>
      <td colspan="6" align="right">JUMLAH TOTAL</td>
      <td width="15%" align="right" class="total">Rp <?php echo number_format($DATA_TOTAL['total'], 0,",","."); ?></td>
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
$paper_size = array(0,0, 12.99 * 72, 8.26 * 72); // 12" x 12"
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('LAPORAN_TMO_IBS.pdf',array('Attachment' => 0));
?>
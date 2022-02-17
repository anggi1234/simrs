<?php
ob_start();
session_start();
include('connect.php');
$id_diklat_registrasi_mhs = $_GET['id_diklat_registrasi_mhs'];
$username = $_GET['username'];

$sqlitem="SELECT 
    b.nama, b.jasa_sarana, b.jasa_bimbingan, a.total_bayar
FROM
    simrs.diklat_bill_detail_pembayaran a
        LEFT JOIN
    master_tarif_magang b ON a.id_detail_pembayaran_magang = b.id_master_tarif_magang
WHERE
     a.id_diklat_registrasi_mhs=$id_diklat_registrasi_mhs";
$queryitem = mysql_query($sqlitem);


$sqlidentitas="SELECT 
    a.no_praktik,
    a.nama,
    a.alamat,
    b.nama_asal_pendidikan,c.nama_jurusan_pendidikan,
    a.total_minggu,
    a.tanggal_mulai,
    a.tanggal_akhir,a.total_pembayaran
FROM
    simrs.diklat_registrasi_mhs a
        LEFT JOIN
    master_asal_pendidikan b ON a.kd_asal = b.id_master_asal_pendidikan
    left join master_jurusan_pendidikan c on a.kd_jurusan=c.id_master_jurusan_pendidikan where a.id_diklat_registrasi_mhs=$id_diklat_registrasi_mhs";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqlusername="select pd_nickname from master_login where username='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>NOTA MAGANG</title>
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
      <td width="10%" rowspan="3" align="right"><img src="gambar/logobms.png" height="70px" /></td>
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
  

    <div align="center"><strong>RINCIAN BIAYA ADMINISTRASI DIKLAT</strong></div>



<table width="100%" class="footer" border="0">
    <tr>
      <td width="18%">No Praktik</td>
      <td width="27%">: <?php echo $DATA_IDENTITAS['no_praktik']; ?></td>
      <td width="19%">Alamat</td>
      <td width="36%">: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
    <tr>
      <td>Nama</td>
      <td>: <?php echo $DATA_IDENTITAS['nama']; ?></td>
      <td>Lama Praktik</td>
      <td>: <?php echo $DATA_IDENTITAS['total_minggu']; ?> Minggu</td>
    </tr>
    <tr>
      <td>Pendidikan Asal</td>
      <td>: <?php echo $DATA_IDENTITAS['nama_asal_pendidikan']; ?></td>
      <td>Tanggal Mulai</td>
      <td>: <?php echo $DATA_IDENTITAS['tanggal_mulai']; ?></td>
  </tr>
    <tr>
      <td>Jurusan</td>
      <td>: <?php echo $DATA_IDENTITAS['nama_jurusan_pendidikan']; ?></td>
      <td>Tanggal Berakhir</td>
      <td>: <?php echo $DATA_IDENTITAS['tanggal_akhir']; ?></td>
    </tr>
</table>


<table width="100%" class="tabel" border="1">
    <tr>
	  <td width="10" align="left" class="a"><strong>No</strong></td>
      <td width="189" align="left" class="a"><strong>Nama Pembayaran</strong></td>
      <td width="72" align="center" class="a"><strong>Biaya Jasa Sarana</strong></td>
      <td width="64" align="center" class="a"><strong>Biaya Bimbingan</strong></td>
      <td width="92" align="center" class="a"><strong>Sub Total</strong></td>
  </tr>
	<?php
	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="5">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
	  echo '<td class="a kosong">'.$no.'</td>';
      echo '<td class="a kosong">'.$data['nama'].'</td>';
      echo '<td class="a kosong"><div align="right">'.number_format($data['jasa_sarana'], 0,",","."). '</div></td>';
	  echo '<td class="a kosong"><div align="right">'.number_format($data['jasa_bimbingan'], 0,",","."). '</div></td>';
			echo '<td class="a kosong"><div align="right">'.number_format($data['total_bayar'], 0,",","."). '</div></td>';
			echo '</tr>';
			
			$no++;
		}
	}
    
	?>
	<tr>
      <td colspan="5" align="right"><table width="100%" border="0">
        <tbody>
     <tr>
       <td width="17%" align="center">Administrasi</td>
      <td colspan="6" align="right">Sub Total</td>
      <td width="15%" align="right" class="total">Rp.<?php echo number_format($DATA_IDENTITAS['total_pembayaran'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td align="right" class="total">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_USERNAME['pd_nickname']; ?></td>
      <td colspan="6" align="right">Total Keseluruhan</td>
      <td align="right" class="total"><strong>Rp.<?php echo number_format($DATA_IDENTITAS['total_pembayaran'], 0,",","."); ?></strong></td>
    </tr>
        </tbody>
      </table></td>
    </tr>
	
  </table>


</body>
</html>
<?php
 $html = ob_get_clean();
require_once("dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.66 * 72, 5.51 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('notafarmasi.pdf',array('Attachment' => 0));
?>
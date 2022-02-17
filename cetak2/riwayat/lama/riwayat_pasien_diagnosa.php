<?php
ob_start();
include('connect.php');
$NOMR = $_GET['nomr'];


 $sqlitem="select * from a_riwayat_diagnosa WHERE NOMR=$NOMR";
 $queryitem = mysql_query($sqlitem);

$sqlidentitas="select a.NOMR,date_format(b.TGLLAHIR, '%d-%m-%Y') as TGLLAHIR,b.NAMA,c.NAMA as 'STATUS', b.ALAMAT, d.nama as POLI, b.JENISKELAMIN,date_format(a.JAMREG, '%d-%m-%Y') AS TANGGALMASUK
from t_pendaftaran a left outer join m_pasien b on a.NOMR=b.NOMR 
LEFT OUTER JOIN m_carabayar c on a.KDCARABAYAR=c.KODE
LEFT OUTER JOIN m_poly d on a.KDPOLY=d.kode WHERE a.NOMR=$NOMR";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);
 
 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Riwayat SIMRS Baru</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
.tabelfix {
    border-collapse:collapse;
}
.oke {
    border:none;
}
	
	@page {
            margin-top: 0.1 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.2 cm;
	}
	
</style>
</head>

<body>

 <table width="100%" border="0">
  <tr>
    <td class="header" width="3%"><img src="../../gambar/logobms.png" width="76" height="70" /></td>
    <td class="header" width="97%">
      <div align="center">
        <strong>PEMERINTAH KABUPATEN BANYUMAS</strong><br />
        <strong>RUMAH SAKIT UMUM DAERAH AJIBARANG</strong><br />
        Jl. Raya Pancasan - Ajibarang, Kode Pos 53163 Telp. (0281)6570004, Fax (0281)5670005<br />      
        Email: rsudajibarang@banyumaskab.go.id
      </div>
    </td>
  </tr>
</table>
<hr>
<table width="100%" height="52" border="0">
  <tr>
    <td width="100%" class="header"><div align="center"><strong>RIWAYAT DIAGNOSA DI SIMRS BARU</strong></div></td>
  </tr>
</table>
<table width="100%" class="footer" border="0">
    <tr>
      <td>No. RM</td>
      <td>: <?php echo $DATA_IDENTITAS['NOMR']; ?></td>
      <td>&nbsp;</td>
      <td>Alamat</td>
      <td>: <?php echo $DATA_IDENTITAS['ALAMAT']; ?></td>
    </tr>
    <tr>
      <td>Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['NAMA']; ?></td>
      <td>&nbsp;</td>
      <td>Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS['JENISKELAMIN']; ?></td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS['TGLLAHIR']; ?></td>
      <td></td>
      <td>Tanggal Berobat</td>
      <td>: <?php echo $DATA_IDENTITAS['TANGGALMASUK']; ?></td>
  </tr>
</table>
<table width="100%" class="tabelfix" border="1">
    <tr>
      <td width="5%" class="a"><div align="center"><strong>No.</strong></div></td>
      <td width="20%" class="a"><div align="center"><strong>TGL KUNJUNG</strong></div></td>
	  <td width="10%" class="a"><div align="center"><strong>UNIT</strong></div></td>
      <td width="70%" class="a"><div align="center"><strong>DIAGNOSA DOKTER</strong></div></td>
  </tr>
	<?php
	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="4"><br><br></td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
      echo '<td class="a" align="center">'.$no.'</td>';
	  echo '<td class="a"><div align="center">'.$data['TANGGAL'].'</div></td>';
	  echo '<td class="a"><div align="center">'.$data['POLI'].'</div></td>';
	  echo '<td class="a"><div align="center">'.$data['DIAGNOSA_DOKTER'].'</div></td>';
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
require_once("../../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$dompdf->set_paper(DEFAULT_PDF_PAPER_SIZE, 'LANDSCAPE');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('coba.pdf',array('Attachment' => 0));
?>
<?php
ob_start();
include('../connect.php');
$idxdaftar = $_GET['idxdaftar'];
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];
$nomr = $_GET['nomr'];
$username = $_GET['username'];




?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>EKLAIM</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 0.5 cm;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}
	
	.pagebreak { 
	page-break-before: always; 
	}
	.tabel {
    border-collapse:collapse;
	font-size: 11px;
}
	
	
</style>

</head>
<?php 
	$DATA_SEP = $DATA_IDENTITAS["nomer_sep"];
?>
<body>
<?php
	$sqlid="SELECT userlevelid FROM simrs.bill_detail_tarif where id_bill_detail_tarif=$id_bill_detail_tarif";
	$queryid = mysql_query($sqlid);
	$DATA_ID = mysql_fetch_array($queryid);
	
	
	
?>

	<?php include_once "eklaim_sep.php"; ?>
	<?php include_once "eklaim_inacbg.php"; ?>
	<?php include_once "eklaim_resume_rajal.php"; ?>

	
<?php



	
$sqlusg="SELECT 
    COUNT(*) AS jumlah
FROM
    simrs.bill_detail_tindakan
WHERE
    idxdaftar=$idxdaftar
        AND id_jenis_tindakan = 10";
	$queryusg = mysql_query($sqlusg);
	$DATA_USG = mysql_fetch_array($queryusg);		
				if($DATA_USG['jumlah'] > 0){
						include_once "eklaim_usg.php";
				}

	
$sqlekg="SELECT 
    COUNT(*) AS jumlah
FROM
    simrs.bill_detail_tindakan
WHERE
    idxdaftar=$idxdaftar
        AND id_jenis_tindakan = 9";
	$queryekg = mysql_query($sqlekg);
	$DATA_EKG = mysql_fetch_array($queryekg);		
				if($DATA_EKG['jumlah'] > 0){
					echo '<div class="pagebreak">';
						include_once "eklaim_ekg.php";
					echo '</div>';
				}


	if($DATA_ID['userlevelid']==29){
		include_once "eklaim_slitlamp.php";
	}

  $sqlibsrincian="SELECT 
    COUNT(*) AS jumlah
FROM
    simrs.bill_detail_tarif_ibs
WHERE
    idxdaftar=$idxdaftar";
  $queryibsrincian = mysql_query($sqlibsrincian);
  $DATA_IBSRINCIAN = mysql_fetch_array($queryibsrincian);   
        if($DATA_IBSRINCIAN['jumlah'] > 0){
            include_once "eklaim_nota_pelayanan_ibs.php";
        }
	
	?>	
<?php 
	
	$sqllapop="SELECT 
    COUNT(*) AS jumlah
FROM
    simrs.bill_detail_tarif_ibs
WHERE
    idxdaftar=$idxdaftar";
	
	$querylapop = mysql_query($sqllapop);
	$DATA_LAPOP = mysql_fetch_array($querylapop);
	
	if($DATA_LAPOP['jumlah'] >= 1){
		include_once "eklaim_laporan_operasi.php";
	}
	
	?>
	
<?php
	$sqlidmaster=mysql_query("SELECT 
    a.id_expertise_radiologi,
    c.nomr,
    d.NAMA,
    d.ALAMAT,
    DATE_FORMAT(d.TGLLAHIR, '%d-%m-%Y') AS TGLLAHIR,
    e.nama AS cara_bayar,
    DATE_FORMAT(b.tanggal, '%d-%m-%Y') AS tanggal,
    a.photo,
    f.namadokter AS pengirim,
    i.pd_nickname AS dokter_radiologi,
    i.signature_pad
FROM
    expertise_radiologi a
        LEFT JOIN
    bill_detail_tarif_detail b ON a.id_bill_detail_tarif_detail = b.id_bill_detail_tarif_detail
        LEFT JOIN
    bill_detail_tarif c ON b.id_bill_detail_tarif = c.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_pasien d ON c.nomr = d.NOMR
        LEFT JOIN
    simrs2012.m_carabayar e ON c.kdcarabayar = e.kode
        LEFT JOIN
    simrs2012.m_dokter f ON c.kddokter = f.kddokter
        LEFT JOIN
    simrs.m_dokter h ON a.userlevelid = h.userlevelid
        LEFT JOIN
    simrs.master_login i ON i.kddokter = h.kddokter
WHERE
    b.idxdaftar = $idxdaftar");

while($rows=mysql_fetch_array($sqlidmaster)){	
	echo '<div class="pagebreak"></div>';
	echo '
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
  

    <div align="center"><strong>HASIL PEMERIKSAAN RADIOLOGI</strong></div>
	<table width="100%" class="footer" border="0">
    <tr>
      <td width="18%">No. RM</td>
      <td width="27%">: '.$rows["nomr"].'</td>
      <td width="19%">Alamat</td>
      <td width="36%">: '.$rows["ALAMAT"].'</td>
    </tr>
    <tr>
      <td>Nama Pasien</td>
      <td>: '.$rows["NAMA"].'</td>
      <td>Cara Bayar</td>
      <td>: '.$rows["cara_bayar"].'</td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>: '.$rows["TGLLAHIR"].'</td>
      <td>Tanggal Periksa</td>
      <td>: '.$rows["tanggal"].'</td>
  </tr>
    <tr>
      <td valign="top">Jenis Pemeriksaan</td>
      <td valign="top">: '.$rows["photo"].'</td>
      <td valign="top">Pengirim</td>
      <td valign="top">: '.$rows["pengirim"].'</td>
    </tr>
</table>';

$sqlisi="SELECT * FROM simrs.expertise_detail_radiologi where id_expertise_radiologi=".$rows['id_expertise_radiologi']."";
$queryisi = mysql_query($sqlisi);
	
while($data=mysql_fetch_assoc($queryisi)){	
echo '<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="8%" style="vertical-align:top"><strong>KLINIS</strong></td>
      <td width="3%" style="vertical-align:top">: </td>
      <td width="89%" style="vertical-align:top">'.$data["klinis"].'</td>
    </tr>
    <tr>
      <td style="vertical-align:top"><strong>DESKRIPSI</strong></td>
      <td style="vertical-align:top">:</td>
      <td style="vertical-align:top">'.$data["bacaan"].'</td>
    </tr>
    <tr>
      <td style="vertical-align:top"><strong>KESAN</strong></td>
      <td style="vertical-align:top">:</td>
      <td style="vertical-align:top"><strong>'.$data["kesan"].'</strong></td>
    </tr>
  </tbody>
</table>

<div align="right" style="position: relative;">
  <div style="position: absolute; bottom: 5px;">
  <div align="right">
        Spesialis Radiodiagnostik,
      <br><img height="80px" src="'.$rows["signature_pad"].'"/><br>
	  		'.$rows["dokter_radiologi"].'
      </div>
  </div>
</div>	';
};

}
	
?>	




<?php
	$sqladalab=mysql_query("SELECT 
	z.id_bill_detail_tarif_detail,
    a.nomr,
    b.nama,
    b.alamat,
    b.tgllahir,
    d.nama AS carabayar,
    a.tglreg,
    c.nama_dokter,
    b.jeniskelamin,
    e.userlevelname,
	a.tglreg,
	z.tanggal_input
FROM
	simrs.bill_detail_tarif_detail z 
		LEFT JOIN
    simrs.bill_detail_tarif a on z.id_bill_detail_tarif=a.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs.m_dokter c ON a.kddokter = c.kddokter
        AND a.userlevelid = c.userlevelid
        LEFT JOIN
    simrs2012.m_carabayar d ON a.kdcarabayar = d.kode
        LEFT JOIN
    simrs.userlevels e ON a.userlevelid = e.userlevelid
WHERE
    z.id_bill_detail_tarif = $id_bill_detail_tarif;");
	while($rowslab=mysql_fetch_array($sqladalab)){	
		echo '<div class="pagebreak"></div>';
		echo '
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
  <table width="100%" border="0" cellspacing="2">
    <tbody style="font-size: 12px">
      <tr>
        <td width="12%">Dokter</td>
        <td width="1%">:</td>
        <td width="43%">'.$rowslab["nama_dokter"].'</td>
        <td width="17%">Bangsal/Poli</td>
        <td width="0%">:</td>
        <td width="27%">'.$rowslab["userlevelname"].'</td>
      </tr>
      <tr>
        <td>Pasien</td>
        <td>:</td>
        <td>'.$rowslab["nama"].'</td>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td>'.$rowslab["jeniskelamin"].'</td>
      </tr>
      <tr>
        <td>No.Lab</td>
        <td>:</td>
        <td>'.$rowslab["lno"].'</td>
        <td>Tgl.Lahir/Umur</td>
        <td>:</td>
        <td>'.$rowslab["tgllahir"].'</td>
      </tr>
      <tr>
        <td valign="top">No.RM</td>
        <td valign="top">:</td>
        <td valign="top">'.$rowslab["nomr"].'</td>
        <td valign="top">Tanggal Terima</td>
        <td valign="top">:</td>
        <td valign="top">'.$rowslab["tanggal_input"].'</td>
      </tr>
      <tr>
        <td>Tgl. Registrasi</td>
        <td>:</td>
        <td>'.$rowslab["tglreg"].'</td>
        <td>Tanggal Pelaporan</td>
        <td>:</td>
        <td>'.$rowslab["pelaporan"].'</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>:</td>
        <td colspan="4">'.$rowslab["alamat"].'</td>
      </tr>
    </tbody>
  </table>
		
		<center><h2>HASIL PEMERIKSAAN LABORATORIUM</h2></center>
<table width="100%" border="0" class="tabel">
  <tbody>
    <tr>
      <td width="47%" align="left"><strong>Pemeriksaan</strong></td>
      <td width="2%" align="right">&nbsp;</td>
      <td width="18%" align="center"><strong>Hasil</strong></td>
      <td width="14%" align="center"><strong>Satuan</strong></td>
      <td width="19%" align="center"><strong>Nilai Normal</strong></td>
    </tr>';
		
    $sqlitemlab="SELECT 
    test_name, result_value, unit, reference_range, CASE
        WHEN flag = 'N' THEN ''
        WHEN flag = 'L' THEN 'L'
        WHEN flag = 'H' THEN 'H'
    END AS flag,SUBSTRING_INDEX(validated_by,'^',-1) as validated_by,test_comment
FROM
    simrs.labresult_details a
        LEFT JOIN
    simrs.bill_detail_tarif_detail b ON a.ono = b.id_bill_detail_tarif_detail
WHERE
    b.id_bill_detail_tarif_detail = ".$rowslab["id_bill_detail_tarif_detail"]."";
$queryitemlab = mysql_query($sqlitemlab);
	while($data1=mysql_fetch_assoc($queryitemlab)){
		
$bg_colorkonfirmasi=(($data1['flag'] == "N") ? 'normal;' :
(($data1['flag'] == "H" || $data1['flag'] == "L") ? 'bold;' : ""));	

	  echo '<tr>
      <td align="left">'.$data1['test_name'].'<br><strong>'.$data1['test_comment'].'</strong></td>
	  <td align="left">'.$data1['flag'].'</td>
      <td align="center" style="font-weight: '.$bg_colorkonfirmasi.'">'.$data1['result_value'].'</td>
      <td align="center">'.$data1['unit'].'</td>
	  <td align="center">'.$data1['reference_range'].'</td>
	  </tr>';
		
	}
	
  echo '</tbody>
</table>';
	}
?>

<?php $sqlkontrol="SELECT 
      count(*) as jumlah
    FROM
      simrs.bill_detail_lain a
        LEFT JOIN
      simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
        AND a.userlevelid_kontrol = b.userlevelid
    WHERE
      a.id_bill_detail_tarif <> $id_bill_detail_tarif
        AND b.nomr = $nomr";
  $querykontrol = mysql_query($sqlkontrol);
  $DATA_KONTROL = mysql_fetch_array($querykontrol);   
        if($DATA_KONTROL['jumlah'] > 0){
            include_once "eklaim_surat_kontrol.php";
        } 
  ?>
	

</body>
</html>
<?php
$sqlidentitas="SELECT nomer_sep FROM simrs2012.t_sep where idx=$idxdaftar";
$queryidentitas = mysql_query($sqlidentitas);
$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);
$html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('SEP'.$DATA_IDENTITAS['nomer_sep'].'.pdf',array('Attachment' => 0));
?>

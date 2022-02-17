<?php
ob_start();
session_start();
include('../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];

$sqlitem="SELECT 
    c.tglreg,
    c.nomr,
    d.nama,
    (SELECT 
            GROUP_CONCAT(CONCAT(z.icd10, '', y.str)
                    SEPARATOR ',') AS diagnosa
        FROM
            simrs.bill_detail_penyakit z
                LEFT JOIN
            simrs2012.vw_diagnosa_eklaim y ON z.icd10 = y.code
        WHERE
            z.id_bill_detail_tarif = c.id_bill_detail_tarif
        GROUP BY z.id_bill_detail_tarif) AS diagnosa,
    (SELECT 
            GROUP_CONCAT(IFNULL(q.mata_palpebra_od, ''),
                    IFNULL(q.mata_konjungtiva_od, ''),
                    IFNULL(q.mata_kornea_od, ''),
                    IFNULL(q.mata_coa_od, ''),
                    IFNULL(q.mata_pupil_od, ''),
                    IFNULL(q.mata_iris_od, ''),
                    IFNULL(q.mata_lensa_od, ''),
                    IFNULL(q.mata_fundus_od, ''),
                    IFNULL(q.mata_palpebra_os, ''),
                    IFNULL(q.mata_konjungtiva_os, ''),
                    IFNULL(q.mata_kornea_os, ''),
                    IFNULL(q.mata_coa_os, ''),
                    IFNULL(q.mata_pupil_os, ''),
                    IFNULL(q.mata_iris_os, ''),
                    IFNULL(q.mata_lensa_os, ''),
                    IFNULL(q.mata_fundus_os, ''),
                    IFNULL(q.mata_fundus_optic_od, ''),
                    IFNULL(q.mata_fundus_retinal_blood_od, ''),
                    IFNULL(q.mata_fundus_retina_od, ''),
                    IFNULL(q.mata_fundus_makula_od, ''),
                    IFNULL(q.mata_fundus_fovea_od, ''),
                    IFNULL(q.mata_fundus_sclera_od, ''),
                    IFNULL(q.mata_fundus_choroid_od, ''),
                    IFNULL(q.mata_fundus_optic_os, ''),
                    IFNULL(q.mata_fundus_retinal_blood_os, ''),
                    IFNULL(q.mata_fundus_retina_os, ''),
                    IFNULL(q.mata_fundus_makula_os, ''),
                    IFNULL(q.mata_fundus_fovea_os, ''),
                    IFNULL(q.mata_fundus_sclera_os, ''),
                    IFNULL(q.mata_fundus_choroid_os, '')
                    SEPARATOR ',') AS pemeriksaan
        FROM
            simrs.bill_detail_keterangan q
        WHERE
            q.id_bill_detail_tarif = c.id_bill_detail_tarif
        GROUP BY q.id_bill_detail_tarif) AS pemeriksaan
FROM
    simrs.bill_detail_tarif c
        LEFT JOIN
    simrs2012.m_pasien d ON c.nomr = d.nomr
WHERE
    c.userlevelid = 29
        AND (c.tglreg >= '$dari_tanggal' and c.tglreg <= '$sampai_tanggal')";
$queryitem = mysql_query($sqlitem);
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>INFORMASI SLIT LAMP</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
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
  

<div align="center"><strong>LAPORAN PEMERIKSAAN SLIT LAMP POLI MATA</strong></div>






<table width="100%" class="tabel" border="1">
    <tr>
	  <td width="2%" align="left" class="a"><strong>No</strong></td>
      <td width="7%" align="center" class="a"><strong>TANGGAL</strong></td>
      <td width="6%" align="center" class="a"><strong>NOMR</strong></td>
	  <td width="19%" align="center" class="a"><strong>NAMA</strong></td>
      <td width="46%" align="center" class="a"><strong>HASIL PEMERIKSAAN SLIT LAMP</strong></td>
      <td width="20%" align="center" class="a"><strong>DIAGNOSA</strong></td>
  </tr>
	<?php
	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="14">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
	  		echo '<td valign="top" class="a kosong" align="center">'.$no.'</td>';
	  		echo '<td valign="top" class="a kosong" align="center">'.$data['tglreg'].'</td>';
			echo '<td valign="top" class="a kosong" align="center">'.$data['nomr'].'</td>';
			echo '<td valign="top" class="a kosong">'.$data['nama'].'</td>';
			echo '<td valign="top" class="a kosong">'.$data['pemeriksaan'].'</td>';
			echo '<td valign="top" class="a kosong">'.$data['diagnosa'].'</td>';
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
$dompdf->stream('Laporan_Slit_Lamp.pdf',array('Attachment' => 0));
?>
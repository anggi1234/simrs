<?php
ob_start();
include('../connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];

$sqlidentitas="SELECT 
    f.nama_dokter,
    a.NOMR,
    DATE_FORMAT(b.TGLLAHIR, '%d-%m-%Y') AS TGLLAHIR,
    b.NAMA,
    c.NAMA AS 'STATUS',
    b.ALAMAT,
    d.userlevelname AS UNIT,
    b.JENISKELAMIN,
    DATE_FORMAT(a.tglreg, '%d-%m-%Y') AS TANGGALMASUK,
	g.nama_penyakit AS diagnosa_primer,
    h.nama_penyakit AS diagnosa_sekunder,
    g.icd10_1,
    h.icd10_2,
	i.no_surat_izin_praktek,
	b.NO_KARTU,
	i.signature
FROM
    simrs.bill_detail_tarif a
        LEFT OUTER JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT OUTER JOIN
    simrs2012.m_carabayar c ON a.kdcarabayar = c.kode
        LEFT OUTER JOIN
    simrs.userlevels d ON a.userlevelid = d.userlevelid
        LEFT OUTER JOIN
    simrs.m_dokter f ON a.kddokter = f.kddokter and a.userlevelid=f.userlevelid
	LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif, b.str as nama_penyakit,a.icd10 as icd10_1
    FROM
        simrs.bill_detail_penyakit a
    LEFT JOIN simrs2012.vw_diagnosa_eklaim b ON a.icd10 = b.code
    WHERE
        a.id_bill_detail_tarif = $id_bill_detail_tarif
    GROUP BY a.id_penyakit
    LIMIT 1) g ON a.id_bill_detail_tarif = g.id_bill_detail_tarif
        LEFT JOIN
    (    SELECT 
        a.id_bill_detail_tarif, b.str as nama_penyakit,a.icd10 as icd10_2
    FROM
        simrs.bill_detail_penyakit a
    LEFT JOIN simrs2012.vw_diagnosa_eklaim b ON a.icd10 = b.code
    WHERE
        a.id_bill_detail_tarif = $id_bill_detail_tarif AND a.jenis_diagnosa = 'SEKUNDER') h ON a.id_bill_detail_tarif = h.id_bill_detail_tarif
	LEFT JOIN master_login i on a.kddokter=i.kddokter
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqlidentitas1="SELECT anamnesa,suhu_badan AS suhu,
	tekanan_darah as tekdar,
    berat_badan AS berat,
    tinggi_badan AS tinggi, 
    heart_rate as nadi,
    respiration_rate as respirasi from simrs.bill_detail_keterangan where userlevelid <> 31 and  id_bill_detail_tarif=$id_bill_detail_tarif";
 $queryidentitas1 = mysql_query($sqlidentitas1);
 $DATA_ANAMNESA = mysql_fetch_array($queryidentitas1);


$sqlidentitas2="SELECT 
    a.id_bill_detail_tarif,
    b.RADIOLOGI,
    c.LABORATORIUM,
    d.FISIOTERAPI,
    e.PELAYANAN_DARAH
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            CONCAT('RADIOLOGI :', GROUP_CONCAT(b.nama_tindakan
                SEPARATOR ', ')) AS RADIOLOGI
    FROM
        bill_detail_tindakan a
    LEFT OUTER JOIN master_tindakan b ON a.id_tindakan = b.id_tindakan
    WHERE
        a.userlevelid = 17
    GROUP BY a.id_bill_detail_tarif) AS b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            CONCAT('LABORATORIUM :', GROUP_CONCAT(b.nama_tindakan
                SEPARATOR ', ')) AS LABORATORIUM
    FROM
        bill_detail_tindakan a
    LEFT OUTER JOIN master_tindakan b ON a.id_tindakan = b.id_tindakan
    WHERE
        a.userlevelid = 16
    GROUP BY a.id_bill_detail_tarif) c ON a.id_bill_detail_tarif = c.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            CONCAT('FISIOTERAPI :', GROUP_CONCAT(b.nama_tindakan
                SEPARATOR ', ')) AS FISIOTERAPI
    FROM
        bill_detail_tindakan a
    LEFT OUTER JOIN master_tindakan b ON a.id_tindakan = b.id_tindakan
    WHERE
        a.userlevelid = 31
    GROUP BY a.id_bill_detail_tarif) d ON a.id_bill_detail_tarif = d.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            CONCAT('PELAYANAN DARAH :', GROUP_CONCAT(b.nama_tindakan
                SEPARATOR ', ')) AS PELAYANAN_DARAH
    FROM
        bill_detail_tindakan a
    LEFT OUTER JOIN master_tindakan b ON a.id_tindakan = b.id_tindakan
    WHERE
        a.userlevelid = 126
    GROUP BY a.id_bill_detail_tarif) e ON a.id_bill_detail_tarif = e.id_bill_detail_tarif
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif";
 $queryidentitas2 = mysql_query($sqlidentitas2);
 $DATA_PENUNJANG = mysql_fetch_array($queryidentitas2);

$sqlidentitas3="SELECT 
    a.id_bill_detail_tarif,
    IFNULL(GROUP_CONCAT(CONCAT(LOWER(d.nama_obat),
                        '(',
                        CASE
                            WHEN a.nilai1 IS NULL THEN a.qty-IFNULL(c.qty, 0)
                            WHEN a.nilai1 IS NOT NULL and a.id_jenis_racikan=1 THEN CONCAT(a.nilai1, ' ',f.jenis_racikan)
                            WHEN a.nilai1 IS NOT NULL and a.id_jenis_racikan=2 THEN CONCAT(a.nilai1, '/',a.nilai2 ,' ',f.jenis_racikan)
							WHEN a.nilai1 IS NOT NULL and a.id_jenis_racikan=3 THEN CONCAT(a.nilai1,' ',f.jenis_racikan)
                        END,
                        ')')
                SEPARATOR ', '),
            '') AS OBAT
FROM
    bill_detail_permintaan_obat a
        LEFT JOIN
    bill_detail_permintaan_retur_obat c ON a.id_bill_detail_permintaan_obat = c.id_bill_detail_permintaan_obat
        LEFT JOIN
    master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
        LEFT JOIN
    master_obat d ON b.id_obat = d.id_obat
        LEFT JOIN
    master_resep e on a.id_master_resep = e.id_master_resep
		LEFT JOIN
	simrs.l_jenis_racikan f ON a.id_jenis_racikan = f.id_jenis_racikan
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif
        AND d.nama_obat NOT LIKE '%JASA%' 
    and d.nama_obat NOT LIKE '%SPUIT%' 
    and d.nama_obat NOT LIKE '%INJEKSI%' 
    and d.nama_obat NOT LIKE '%KASSA%' 
    and d.nama_obat NOT LIKE '%INFUS%' 
    and d.nama_obat NOT LIKE '%AQUADEST%' 
    and d.nama_obat NOT LIKE '%URIN BAG%' 
    and d.nama_obat NOT LIKE '%NEDLE%'
    and d.nama_obat NOT LIKE '%APRON%'
    and d.nama_obat NOT LIKE '%TEGADERM%'
    and d.nama_obat NOT LIKE '%HIPAVIX%'
    and d.nama_obat NOT LIKE '%DRESSING%'
    and d.nama_obat NOT LIKE '%TRIWAY%'
    and d.nama_obat NOT LIKE '%FC NO%'
    and d.nama_obat NOT LIKE '%INJ%'
GROUP BY a.id_bill_detail_tarif";

 $queryidentitas3 = mysql_query($sqlidentitas3);
 $DATA_FARMASI = mysql_fetch_array($queryidentitas3);


$sqlitemtindakan="SELECT 
    b.nama_tindakan, a.icd9
FROM
    bill_detail_tindakan a
        LEFT JOIN
    master_tindakan b ON a.id_tindakan = b.id_tindakan
WHERE
    a.id_bill_detail_tarif=$id_bill_detail_tarif and b.userlevelid is null";
$queryitemtindakan = mysql_query($sqlitemtindakan);

 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Resume Rawat Jalan</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}
	
.tabelfix {
    border-collapse:collapse;
	font-size: 16px;
}
.footer {
	font-size: 12px;
}
.header {
	font-size: 15px;
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
<table width="100%" height="52" border="0">
  <tr>
    <td width="100%" style="font-size: 26px"><div align="center"><strong>RESUME PASIEN</strong></div></td>
  </tr>
</table>
<table width="100%" class="footer tabelfix" border="1">
    <tr>
      <td width="16%">NO. RM</td>
      <td width="84%">: <?php echo $DATA_IDENTITAS['NOMR']; ?></td>
    </tr>
    <tr>
      <td>NAMA</td>
      <td>: <?php echo $DATA_IDENTITAS['NAMA']; ?></td>
    </tr>
    <tr>
      <td>TANGGAL LAHIR</td>
      <td>: <?php echo $DATA_IDENTITAS['TGLLAHIR']; ?></td>
  </tr>
    <tr>
      <td>STATUS</td>
      <td>: <?php echo $DATA_IDENTITAS['STATUS']; ?></td>
    </tr>
    <tr>
      <td>NO. KARTU</td>
      <td>: <?php echo $DATA_IDENTITAS['NO_KARTU']; ?></td>
    </tr>
    <tr>
      <td>TGL. PELAYANAN</td>
      <td>: <?php echo $DATA_IDENTITAS['TANGGALMASUK']; ?></td>
    </tr>
    <tr>
      <td>POLIKLINIK</td>
      <td>: <?php echo $DATA_IDENTITAS['UNIT']; ?></td>
    </tr>
    <tr>
      <td>ALAMAT</td>
      <td>: <?php echo $DATA_IDENTITAS['ALAMAT']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
</table>
<br>
<table border="1" width="100%" class="tabelfix">
 <tr><td>
<table width="100%" class="footer" border="0">
  <tr>
    <td class="header"><div align="center"><strong>RINGKASAN RIWAYAT DAN PEMERIKSAAN PENTING</strong></div></td>
  </tr>
  
  
  <tr>
    <td><strong>1. ANAMNESA DAN PEMERIKSAAN</strong><br>
    	&nbsp;&nbsp;&nbsp;<?php echo $DATA_ANAMNESA['anamnesa']; ?>
    	<?php if($DATA_ANAMNESA['suhu'] == '') 
			{ 
				echo '' ;
			} 
			else 
			{
				$str1=", Suhu badan :";
				$str2=" Celcius";
				echo $str1 . " " . $DATA_ANAMNESA['suhu']. " " .$str2;
			}  ?>
		<?php if($DATA_ANAMNESA['berat'] == '') 
			{ 
				echo '' ;
			} 
			else 
			{
				$str1=", Berat badan :";
				echo $str1 . " " . $DATA_ANAMNESA['berat'];
			}  ?>
		<?php if($DATA_ANAMNESA['tinggi'] == '') 
			{ 
				echo '' ;
			} 
			else 
			{
				$str1=", Tinggi badan :";
				echo $str1 . " " . $DATA_ANAMNESA['tinggi'];
			}  ?>

		<?php if($DATA_ANAMNESA['tekdar'] == '') 
			{ 
				echo '' ;
			} 
			else 
			{
				$str1=", Tekanan Darah :";
				$str2=" mm Hg";
				echo $str1 . " " . $DATA_ANAMNESA['tekdar']. " " .$str2;
			}  ?>
    <?php if($DATA_ANAMNESA['nadi'] == '') 
      { 
        echo '' ;
      } 
      else 
      {
        $str1=", Nadi :";
        $str2=" Permenit";
        echo $str1 . " " . $DATA_ANAMNESA['nadi']. " " .$str2;
      }  ?>
    <?php if($DATA_ANAMNESA['respirasi'] == '') 
      { 
        echo '' ;
      } 
      else 
      {
        $str1=", Respirasi :";
        $str2=" Permenit";
        echo $str1 . " " . $DATA_ANAMNESA['respirasi']. " " .$str2;
      }  ?>
    </td>
  </tr>
  
  <tr>
	  <td><strong>2. PENUNJANG</strong><br>
      &nbsp;&nbsp;&nbsp;<?php echo $DATA_PENUNJANG['RADIOLOGI']; ?> <br>
      &nbsp;&nbsp;&nbsp;<?php echo $DATA_PENUNJANG['LABORATORIUM']; ?> <br>
      &nbsp;&nbsp;&nbsp;<?php echo $DATA_PENUNJANG['FISIOTERAPI']; ?> <br>
      &nbsp;&nbsp;&nbsp;<?php echo $DATA_PENUNJANG['PELAYANAN_DARAH']; ?>
      
      </td>
  </tr>
  
  <tr>
    <td><strong>3. PENGOBATAN</strong><br>
     &nbsp;&nbsp;&nbsp;<?php echo $DATA_FARMASI['OBAT']; ?>
      </td>
  </tr>
  
  
  <tr>
    <td><table width="100%" class="tabelfix" border="1">
      <tbody>
        <tr>
          <td width="25%">DIAGNOSA UTAMA</td>
          <td width="30%"><strong><?php echo $DATA_IDENTITAS['diagnosa_primer']; ?></strong></td>
          <td width="20%">KODE ICD 10</td>
          <td width="30%"><?php echo $DATA_IDENTITAS['icd10_1']; ?></strong></td>
        </tr>
        <tr>
          <td width="25%">DIAGNOSA SEKUNDER</td>
          <td width="30%"><strong><?php echo $DATA_IDENTITAS['diagnosa_sekunder']; ?></strong></td>
          <td width="20%">KODE ICD 10</td>
          <td width="30%"><strong><?php echo $DATA_IDENTITAS['icd10_2']; ?></strong></td>
        </tr>
        <tr>
          <td width="25%">TINDAKAN</td>
          <td width="30%">&nbsp;</td>
          <td width="20%">KODE ICD 9</td>
          <td width="30%">&nbsp;</td>
        </tr>
        
            <?php
			  $no=1;
				while($data=mysql_fetch_assoc($queryitemtindakan)){
					echo '<tr>';
					echo '<td colspan="2" align="left"><strong>'.$no.'. '.$data['nama_tindakan'].'</strong></td>';
					echo '<td colspan="2" align="left"><strong>'.$no.'. '.$data['icd9'].'</strong></td>';
					echo '</tr>';
					$no++;
			}
			?>

      </tbody>
    </table></td>
  </tr>
</table>


<table class="header" width="100%" border="0">
  <tr>
    <td><p align="center">DOKTER PEMERIKSA</p>
	<center><img height="100px" src="../../uploads/<?php echo $DATA_IDENTITAS['signature']; ?>"/></center>
    <p align="center">( <?php echo $DATA_IDENTITAS['nama_dokter']; ?> )<br>SIP:<?php echo $DATA_IDENTITAS['no_surat_izin_praktek']; ?></p></td>
  </tr>
</table>
</td>
</tr>
</table>



</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$dompdf->set_paper(DEFAULT_PDF_PAPER_SIZE, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('resume.pdf',array('Attachment' => 0));
?>
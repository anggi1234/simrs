<?php
ob_start();
session_start();
include('../connect.php');
$id_bill_detail_tarif= $_GET['id_bill_detail_tarif'];
$idxdaftar= $_GET['idxdaftar'];

$sqlidentitas="SELECT 
    a.nomr,
    b.nama,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    DATE_FORMAT(a.tglreg, '%d-%m-%Y') AS tglreg,
    DATE_FORMAT(a.tglout, '%d-%m-%Y') AS tglout,
	DATE_FORMAT(a.tglout, '%d-%m-%Y %H:%i:%s') AS tglkeluar,
    a.kelas,
    c.userlevelname,
    d.keterangan,
    f.userlevelname AS kontrol_ke,
	e.tempat_kontrol,
    e.alasan_kontrol,
	d.ket,
    DATE_FORMAT(e.tanggal_kontrol, '%d-%m-%Y') AS tanggal_kontrol,
    (SELECT 
            GROUP_CONCAT(y.nama_tindakan
                    SEPARATOR ', ') AS tindakan_lab
        FROM
            simrs.bill_detail_tindakan z
                LEFT JOIN
            simrs.master_tindakan y ON z.id_tindakan = y.id_tindakan
        WHERE
            z.id_bill_detail_tarif = a.id_bill_detail_tarif
                AND y.userlevelid = 16
        GROUP BY y.userlevelid) AS lab,
    (SELECT 
            GROUP_CONCAT(y.nama_tindakan
                    SEPARATOR ', ') AS tindakan_lab
        FROM
            simrs.bill_detail_tindakan z
                LEFT JOIN
            simrs.master_tindakan y ON z.id_tindakan = y.id_tindakan
        WHERE
            z.id_bill_detail_tarif = a.id_bill_detail_tarif
                AND y.userlevelid = 17
        GROUP BY y.userlevelid) AS rad,
    (SELECT 
            y.nama_tindakan
        FROM
            simrs.bill_detail_tindakan z
                LEFT JOIN
            simrs.master_tindakan y ON z.id_tindakan = y.id_tindakan
        WHERE
            z.id_bill_detail_tarif = 214508
                AND y.id_jenis_tindakan = 9) AS EKG,
    (SELECT 
            GROUP_CONCAT(CONCAT(z.icd10, ', ', y.str)
                    SEPARATOR ' | ') AS diagnosa
        FROM
            simrs.bill_detail_penyakit z
                LEFT JOIN
            simrs.bill_detail_tarif x ON z.id_bill_detail_tarif = x.id_bill_detail_tarif
                LEFT JOIN
            simrs2012.vw_diagnosa_eklaim y ON z.icd10 = y.code
        WHERE
            z.id_bill_detail_tarif = a.id_bill_detail_tarif
                AND z.jenis_diagnosa = 'PRIMER'
        GROUP BY x.id_bill_detail_tarif) AS diagnosa_primer,
    (SELECT 
            GROUP_CONCAT(CONCAT(z.icd10, ', ', y.str)
                    SEPARATOR ' | ') AS diagnosa
        FROM
            simrs.bill_detail_penyakit z
                LEFT JOIN
            simrs.bill_detail_tarif x ON z.id_bill_detail_tarif = x.id_bill_detail_tarif
                LEFT JOIN
            simrs2012.vw_diagnosa_eklaim y ON z.icd10 = y.code
        WHERE
            z.id_bill_detail_tarif = a.id_bill_detail_tarif
                AND z.jenis_diagnosa = 'SEKUNDER'
        GROUP BY x.id_bill_detail_tarif) AS diagnosa_sekunder,
    (SELECT 
            GROUP_CONCAT(y.nama_tindakan
                    SEPARATOR ', ') AS tindakan_lab
        FROM
            simrs.bill_detail_tindakan z
                LEFT JOIN
            simrs.master_tindakan y ON z.id_tindakan = y.id_tindakan
        WHERE
            z.idxdaftar = a.idxdaftar
                AND y.userlevelid = 40
        GROUP BY y.userlevelid) AS TMO,
    (SELECT 
    group_concat(distinct x.nama_obat separator ', ') as obat
FROM
    simrs.bill_detail_permintaan_obat z
        LEFT JOIN
    simrs.master_obat_detail y ON z.id_master_obat_detail = y.id_master_obat_detail
        LEFT JOIN
    simrs.master_obat x ON y.id_obat = x.id_obat
        LEFT JOIN
    simrs.master_resep w ON z.id_master_resep = w.id_master_resep
WHERE
    z.id_jenis_etiket <> 1
        AND z.id_bill_detail_tarif = a.id_bill_detail_tarif) AS obat,g.signature,g.pd_nickname,g.no_surat_izin_praktek
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs.userlevels c ON a.userlevelid = c.userlevelid
        LEFT JOIN
    simrs.m_statuskeluar d ON a.id_status_pasien = d.status
        LEFT JOIN
    simrs.bill_detail_lain e ON a.id_bill_detail_tarif = e.id_bill_detail_tarif
        LEFT JOIN
    simrs.userlevels f ON e.userlevelid_kontrol = f.userlevelid
		LEFT JOIN
    simrs.master_login g ON a.kddokter = g.kddokter
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif";
$queryidentitas = mysql_query($sqlidentitas);
$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);



$sqlasesmen="SELECT * FROM simrs.bill_detail_keterangan where id_bill_detail_tarif=$id_bill_detail_tarif and informasi_dari is not null";
$queryasasmen = mysql_query($sqlasesmen);
$DATA_ASESMEN = mysql_fetch_array($queryasasmen);




$sqlrad="SELECT 
    concat(b.tanggal,' - ',b.photo) as tanggal_input,a.kesan AS hasil
FROM
    simrs.expertise_detail_radiologi a
        LEFT JOIN
    simrs.expertise_radiologi b ON a.id_expertise_radiologi = b.id_expertise_radiologi
        LEFT JOIN
    simrs.bill_detail_tarif_detail c ON b.id_bill_detail_tarif_detail = c.id_bill_detail_tarif_detail
WHERE
    c.id_bill_detail_tarif = $id_bill_detail_tarif";
$queryrad = mysql_query($sqlrad);

$sqlekg="SELECT 
    kesimpulan as hasil
FROM
    simrs.bill_detail_keterangan_ekg
    where id_bill_detail_tarif=$id_bill_detail_tarif";
$queryekg = mysql_query($sqlekg);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Fomulir Ringkasan Pasien Pulang</title>
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
}
	
.header {
	font-size: 12px;
}	
.footer {
	font-size: 12px;
}
.isi {
	font-size: 12px;
	border-collapse:collapse;
}
.pagebreak { 
		page-break-before: always;
	}
    .vertical-line{

        display: inline-block;
        border-left: 1px solid #000000;
        height: 40px;

    }
	

</style>
</head>

<body>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="33%"><table width="100%" border="0">
        <tbody>
          <tr>
            <td width="23%" align="center"><img src="../gambar/logobms.png" height="40px" /></td>
            <td width="77%" align="center" style="font-size: 7px; font-weight: bold" valign="middle">PEMERINTAH KABUPATEN BANYUMAS<br>RUMAH SAKIT UMUM DAERAH AJIBARANG<br>Jl. Raya Pancasan – Ajibarang<br>(0281) 6570004   Fax. (0281) 6570005<br>Email:rsudajibarang@banyumaskab.go.id</td>
          </tr>
        </tbody>
      </table></td>
      <td width="33%" style="font-size: 12px"><p align="center"><strong>FORMULIR RINGKASAN<br> PASIEN PULANG <br> 
          <em>(DISCHARGE SUMMARY)</em></strong><br>
      <strong></strong></p></td>
      <td width="33%" valign="middle" style="font-weight: bold"><table width="100%" style="font-size: 11px" border="0">
        <tbody>
          <tr>
            <td width="27%">NO RM</td>
            <td width="4%">:</td>
            <td width="69%"><?php echo $DATA_IDENTITAS['nomr']; ?></td>
          </tr>
          <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?php echo $DATA_IDENTITAS['nama']; ?></td>
          </tr>
          <tr>
            <td>Tgl Lahir</td>
            <td>:</td>
            <td><?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>


<table width="100%" class="isi"  border="1">
  <tbody>
    <tr>
      <td colspan="4"><strong><em>Disi Oleh DPJP/Petugas yang berwenang</em></strong></td>
    </tr>
    <tr>
      <td colspan="2">Tanggal Masuk: <strong><?php echo $DATA_IDENTITAS['tglreg']; ?></strong></td>
      <td width="32%" colspan="2">Tanggal Keluar: <strong><?php echo $DATA_IDENTITAS['tglout']; ?></strong></td>
    </tr>
    <tr>
      <td colspan="2">Ruang: <strong><?php echo $DATA_IDENTITAS['userlevelname']; ?></strong></td>
      <td colspan="2">Kelas: <strong><?php echo $DATA_IDENTITAS['kelas']; ?></strong></td>
    </tr>
    <tr>
      <td width="33%">Indikasi pasien masuk dirawat</td>
      <td colspan="3">: <strong><?php echo $DATA_ASESMEN['anamnesa']; ?></strong></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">Temuan fisik penting dan temuan lainnya:</td>
    </tr>
    <tr>
      <td>Subyek</td>
      <td colspan="3">: <strong>Pasien mengatakan</strong> <strong><?php echo $DATA_ASESMEN['ranap_subjektif']; ?></strong></td>
    </tr>
    <tr>
      <td>Obyektif</td>
      <td colspan="3">: <strong><?php echo $DATA_ASESMEN['ranap_objektif']; ?></strong></td>
    </tr>
    <tr>
      <td colspan="4">
      	
      	<strong>
      	
      		<?php if($DATA_ASESMEN['tekanan_darah'] == '') 
			{ 
				echo '' ;
			} 
			else 
			{
				$str1="Tekanan Darah :";
				$str2=" mm Hg";
				echo $str1 . " " . $DATA_ASESMEN['tekanan_darah']. " " .$str2;
			}  ?>	
      		
		<?php if($DATA_ASESMEN['berat_badan'] == '') 
			{ 
				echo '' ;
			} 
			else 
			{
				$str1=", Berat badan :";
				echo $str1 . " " . $DATA_ASESMEN['berat_badan'];
			}  ?>
		<?php if($DATA_ASESMEN['tinggi_badan'] == '') 
			{ 
				echo '' ;
			} 
			else 
			{
				$str1=", Tinggi badan :";
				echo $str1 . " " . $DATA_ASESMEN['tinggi_badan'];
			}  ?>

		
    <?php if($DATA_ASESMEN['heart_rate'] == '') 
      { 
        echo '' ;
      } 
      else 
      {
        $str1=", Nadi :";
        $str2=" Permenit";
        echo $str1 . " " . $DATA_ASESMEN['heart_rate']. " " .$str2;
      }  ?>
    <?php if($DATA_ASESMEN['respiration_rate'] == '') 
      { 
        echo '' ;
      } 
      else 
      {
        $str1=", Respirasi :";
        $str2=" Permenit";
        echo $str1 . " " . $DATA_ASESMEN['respiration_rate']. " " .$str2;
      }  ?>
     		
     		<?php if($DATA_ASESMEN['suhu_badan'] == '') 
			{ 
				echo '' ;
			} 
			else 
			{
				$str1=", Suhu badan :";
				$str2=" Celcius";
				echo $str1 . " " . $DATA_ASESMEN['suhu_badan']. " " .$str2;
			}  ?>
      		
      	</strong>
      	
      </td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">Tindakan diagnostik dan prosedur terapi yang telah dikerjakan:</td>
    </tr>
    <tr>
      <td colspan="4">A. Laboratorium</strong></td>
    </tr>
    
    
    <?php
	
	$sqllab="SELECT 
    concat(b.tanggal_input,' - ', c.call_unit) as tanggal_input,
    GROUP_CONCAT(CONCAT(a.test_name,
                ':',
                result_value,
                ' ',
                unit)
        SEPARATOR ', ') AS hasil
FROM
    simrs.labresult_details a
        LEFT JOIN
    simrs.bill_detail_tarif_detail b ON a.ono = b.id_bill_detail_tarif_detail
        LEFT JOIN
    simrs.userlevels c ON b.userlevelid_asal = c.userlevelid
WHERE
    b.idxdaftar = $idxdaftar
        AND (a.test_name NOT LIKE '%MCV%'
        AND a.test_name NOT LIKE '%MCH%'
        AND a.test_name NOT LIKE '%MCHC%'
        AND a.test_name NOT LIKE '%RDW%'
        AND a.test_name NOT LIKE '%MPV%'
        AND a.test_name NOT LIKE '%Basofil%'
        AND a.test_name NOT LIKE '%Eosinofil%'
        AND a.test_name NOT LIKE '%Batang%'
        AND a.test_name NOT LIKE '%Segmen%'
        AND a.test_name NOT LIKE '%Limfosit%'
        AND a.test_name NOT LIKE '%Monosit%'
        AND a.test_name NOT LIKE '%Netrofil Limfosit Ratio%')
        AND (flag = 'L' OR flag = 'H')
GROUP BY b.id_bill_detail_tarif_detail";
$querylab = mysql_query($sqllab);
	
	if(mysql_num_rows($querylab)==0){
		echo '<tr><td colspan="4">'.$DATA_ASESMEN['temp_lab'].'</td></tr>';
	}
	else{
		while($data=mysql_fetch_assoc($querylab)){
			echo '<tr style="font-size:9px">';
			echo '<td><strong>'.$data["tanggal_input"].'</strong></td>';
			echo '<td colspan="3"><strong>'.$data["hasil"].'</strong></td>';
			echo '</tr>';
		}
	}
	?>
    
    <tr>
      <td colspan="4">B. Radiologi</strong></td>
    </tr>

    
    <?php
	if(mysql_num_rows($queryrad)==0){
		echo '<tr><td colspan="4">'.$DATA_ASESMEN['temp_rad'].'</td></tr>';
	}
	else{
		while($data=mysql_fetch_assoc($queryrad)){
			echo '<tr style="font-size:9px">';
			echo '<td align="center"><strong>'.$data["tanggal_input"].'</strong></td>';
			echo '<td colspan="3"><strong>'.$data["hasil"].'</strong></td>';
			echo '</tr>';
		}
	}
	?>
    <tr>
      <td colspan="4">C. EKG</strong></td>
    </tr>

    
    <?php
		while($data=mysql_fetch_assoc($queryekg)){
			echo '<tr>';
			echo '<td colspan="4"><strong>'.$data['hasil'].'</strong></td>';
			echo '</tr>';
		}
	?>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Hasil Konsultasi</td>
      <td colspan="3">:</td>
    </tr>
    <tr>
      <td colspan="4"><strong><?php echo $DATA_ASESMEN['hasil_konsultasi']; ?></strong></td>
    </tr>
    <tr>
      <td>Diagnosa Utama / Primer</td>
      <td colspan="3">: <strong><?php echo $DATA_IDENTITAS['diagnosa_primer']; ?></strong></td>
    </tr>
    <tr>
      <td>Diagnosa Sekuder</td>
      <td colspan="3">: <strong><?php echo $DATA_IDENTITAS['diagnosa_sekunder']; ?></strong></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Tindakan / Prosedur yang telah diberikan</td>
      <td colspan="3">:</td>
    </tr>
    <tr>
      <td colspan="4"><strong><?php 
		  if($DATA_IDENTITAS['TMO'] == ""){
			  echo $DATA_ASESMEN['temp_tindakan'];
		  }else{
			  echo $DATA_IDENTITAS['TMO'];
		  }
		  ?></strong></td>
    </tr>
    <tr>
      <td colspan="4">Terapi / Pengobatan yang diberikan selama di Rumah Sakit</td>
    </tr>
    <tr>
      <td colspan="4"><strong>
      	
      	
<?php

$q = mysql_query("SELECT 
    distinct x.nama_obat
FROM
    simrs.bill_detail_permintaan_obat z
        LEFT JOIN
    simrs.master_obat_detail y ON z.id_master_obat_detail = y.id_master_obat_detail
        LEFT JOIN
    simrs.master_obat x ON y.id_obat = x.id_obat
        LEFT JOIN
    simrs.master_resep w ON z.id_master_resep = w.id_master_resep
WHERE
    z.id_jenis_etiket <> 1
        AND z.id_bill_detail_tarif = $id_bill_detail_tarif");

echo '<table width="100%">';
$nilai = 0;
while($row = mysql_fetch_array($q)){
   if($nilai%3 == 0) {
      if($nilai > 0) {
         echo '</tr>';
      }
      echo '<tr style="font-size:9px">';
   }
   if($nilai%1 == 0) {
      if($nilai > 0) {
         echo '</td>';
      }
      echo '<td>';
   }

   $nama_obat = $row['nama_obat'];
   ?>
 
<?php 
echo $nama_obat;
 ?>  

   <?php 
   $nilai++; // increment the $nilai element so we know how many games we've already processed
}
		  echo '</table>';
?>

      	
      	
      </strong></td>
    </tr>
    <tr>
      <td>Diit</td>
      <td colspan="3">: <strong><?php echo $DATA_ASESMEN['gizi_diit']; ?></strong></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Alergi</td>
		<td colspan="3">: <strong><?php echo $DATA_ASESMEN['alergi']; ?></strong></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">Intruksi follow up / tindak lanjut:</td>
    </tr>
    <tr>
      <td colspan="4"><strong><?php echo $DATA_IDENTITAS['alasan_kontrol']; ?></strong></td>
    </tr>
    <tr>
      <td>Cara Keluar</td>
      <td colspan="3">: <strong><?php echo $DATA_IDENTITAS['keterangan']; ?></strong>, <?php echo $DATA_IDENTITAS['ket']; ?></td>
    </tr>
    <tr>
      <td colspan="4">Kondisi Saat Pulang</td>
    </tr>
    <tr>
      <td colspan="4">
      	
      	
      	<strong>
      	
		<?php if($DATA_ASESMEN['keadaan_umum_pulang'] == '') 
			{ 
				echo '' ;
			} 
			else 
			{
				echo $DATA_ASESMEN['keadaan_umum_pulang'];
			}  ?>
		
      		<?php if($DATA_ASESMEN['tekanan_darah_pulang'] == '') 
			{ 
				echo '' ;
			} 
			else 
			{
				$str1=" ,Tekanan Darah :";
				$str2=" mm Hg";
				echo $str1 . " " . $DATA_ASESMEN['tekanan_darah_pulang']. " " .$str2;
			}  ?>	
      		
		<?php if($DATA_ASESMEN['berat_badan_pulang'] == '') 
			{ 
				echo '' ;
			} 
			else 
			{
				$str1=", Berat badan :";
				echo $str1 . " " . $DATA_ASESMEN['berat_badan_pulang'];
			}  ?>
		<?php if($DATA_ASESMEN['tinggi_badan_pulang'] == '') 
			{ 
				echo '' ;
			} 
			else 
			{
				$str1=", Tinggi badan :";
				echo $str1 . " " . $DATA_ASESMEN['tinggi_badan_pulang'];
			}  ?>

		
    <?php if($DATA_ASESMEN['heart_rate_pulang'] == '') 
      { 
        echo '' ;
      } 
      else 
      {
        $str1=", Nadi :";
        $str2=" Permenit";
        echo $str1 . " " . $DATA_ASESMEN['heart_rate_pulang']. " " .$str2;
      }  ?>
    <?php if($DATA_ASESMEN['respiration_rate_pulang'] == '') 
      { 
        echo '' ;
      } 
      else 
      {
        $str1=", Respirasi :";
        $str2=" Permenit";
        echo $str1 . " " . $DATA_ASESMEN['respiration_rate_pulang']. " " .$str2;
      }  ?>
     		
     		<?php if($DATA_ASESMEN['suhu_badan_pulang'] == '') 
			{ 
				echo '' ;
			} 
			else 
			{
				$str1=", Suhu badan :";
				$str2=" Celcius";
				echo $str1 . " " . $DATA_ASESMEN['suhu_badan_pulang']. " " .$str2;
			}  ?>
      		
      	</strong>
      	
      </td>
    </tr>
    <tr>
      <td>Pengobatan dilanjutkan</td>
      <td colspan="3"><strong><?php echo $DATA_IDENTITAS['tempat_kontrol']; ?></strong></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Edukasi</td>
      <td colspan="3">: <strong>YA</strong></td>
    </tr>
    <tr>
      <td>Tanggal Kontrol dan Poliklinik Tujuan</td>
      <td colspan="3">: <strong><?php echo $DATA_IDENTITAS['tanggal_kontrol']; ?> & <?php echo $DATA_IDENTITAS['kontrol_ke']; ?></strong></td>
    </tr>
    <tr>
      <td colspan="4">Terapi / obat waktu pulang</td>
    </tr>
    <tr>
      <td colspan="4">
       <table width="100%" class="tabel" style="font-size: 10px" border="1">
        <tbody>
          <tr>
            <td width="43%" align="center">Nama Obat</td>
            <td width="7%" align="center">Jumlah</td>
            <td width="50%" align="center">Aturan Pakai</td>
            </tr>
         <?php
			
$sqlitemobat="SELECT 
    c.nama_obat, a.qty, d.nama_resep as aturan
FROM
    simrs.bill_detail_permintaan_obat a
        LEFT JOIN
    simrs.master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
        LEFT JOIN
    simrs.master_obat c ON b.id_obat = c.id_obat
        LEFT JOIN
    simrs.master_resep d ON a.id_master_resep = d.id_master_resep
WHERE
    a.id_jenis_etiket = 1
        AND a.id_bill_detail_tarif = $id_bill_detail_tarif
ORDER BY a.id_bill_detail_permintaan_obat DESC";
$queryitemobatpulang = mysql_query($sqlitemobat);
			
		$no=1;
		while($data=mysql_fetch_assoc($queryitemobatpulang)){
			echo '<tr>';
			echo '<td align="left">'.$data['nama_obat'].'</td>';
			echo '<td align="center">'.$data['qty'].'</td>';
			echo '<td align="left">'.$data['aturan'].'</td>';
			echo '</tr>';
			$no++;
		}
	?>
        </tbody>
      </table>
      
      </td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="right">Ajibarang, <?php echo $DATA_IDENTITAS['tglkeluar']; ?> WIB</td>
    </tr>
    <tr>
      <td colspan="2" align="center">&nbsp;</td>
      <td colspan="2" align="center">Tanda Tangan dan Nama Terang DPJP</td>
    </tr>
    <tr>
      <td colspan="2" align="center">&nbsp;</td>
      <td colspan="2" align="center"><center><img height="100px" src="../../uploads/<?php echo $DATA_IDENTITAS['signature']; ?>"/></center>        <p align="center">( <?php echo $DATA_IDENTITAS['pd_nickname']; ?> )<br>SIP:<?php echo $DATA_IDENTITAS['no_surat_izin_praktek']; ?></p></td>
    </tr>
  </tbody>
</table>



</body>
</html>


<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.46 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('nota.pdf',array('Attachment' => 0));
?>
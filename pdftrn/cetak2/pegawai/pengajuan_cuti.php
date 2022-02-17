<?php
ob_start();
session_start();
include('../connect.php');
$id_pegawai_cuti_detail= $_GET['id_pegawai_cuti_detail'];
$username = $_GET['username'];
$id_status_karyawan = $_GET['id_status_karyawan'];

$sqlidentitas="SELECT 
    a.id_pegawai_cuti_detail,
    a.uid,
    b.pd_nickname,
	b.pd_nickname as hormatsaya,
    b.nip,
	b.nip as nipsaya,
	b.no_telp,
    CONCAT(TIMESTAMPDIFF(YEAR,
                `b`.`tanggal_masuk_kerja`,
                NOW()),
            ' Th-',
            (TIMESTAMPDIFF(MONTH,
                `b`.`tanggal_masuk_kerja`,
                NOW()) % 12),
            ' Bln') AS `masa_kerja`,
    d.nama_cuti,
    DATEDIFF(a.tanggal_selesai, a.tanggal_mulai) AS jumlah_cuti,
    date_format(a.tanggal_mulai,'%d-%m-%Y') as tanggal_mulai,
    date_format(a.tanggal_selesai,'%d-%m-%Y') as tanggal_selesai,
    CONCAT(c.nama_profesi,
            ' ',
            IFNULL(e.nama_master_profesi_sub, '')) AS jabatan, a.alasan_cuti, a.alamat_selama_cuti
FROM
    simrs.pegawai_cuti_detail a
        LEFT JOIN
    master_login b ON a.uid = b.uid
        LEFT JOIN
    master_profesi c ON b.id_profesi = c.id_profesi
        LEFT JOIN
    l_cuti d ON a.id_cuti = d.id_cuti
        LEFT JOIN
    master_profesi_sub e ON b.id_profesi_sub = e.id_master_profesi_sub
	where a.id_pegawai_cuti_detail=$id_pegawai_cuti_detail";
$queryidentitas = mysql_query($sqlidentitas);
$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);



$sqlatasan="SELECT 
    a.uid,
    a.pd_nickname,
    c.pd_nickname AS nama_kabid,
    c.nip AS nip_kabid,
    b.nama_jabatan AS bidang,
    e.pd_nickname AS nama_kasi,
    e.nip AS nip_kasi,
    d.nama_jabatan_sub AS bidang_sub,
    g.pd_nickname AS nama_direktur,
    g.nip AS nip_direktur
FROM
    master_login a
        LEFT JOIN
    l_jabatan_intern b ON a.id_parent_unit_sub = b.id_parent_unit_sub
        LEFT JOIN
    master_login c ON b.uid = c.uid
        LEFT JOIN
    l_jabatan_intern_sub d ON b.id_jabatan_intern = d.id_jabatan_intern
        LEFT JOIN
    master_login e ON d.uid = e.uid
        LEFT JOIN
    l_jabatan_intern f ON f.id_jabatan_intern = 1
        LEFT JOIN
    master_login g ON g.uid = f.uid
        LEFT JOIN
    master_login_detail h ON a.uid = h.uid
WHERE
    h.username = '$username'
LIMIT 1";
$queryatasan = mysql_query($sqlatasan);
$DATA_ATASAN = mysql_fetch_array($queryatasan);


	$dayList = array(
	'Sun' => 'Minggu',
	'Mon' => 'Senin',
	'Tue' => 'Selasa',
	'Wed' => 'Rabu',
	'Thu' => 'Kamis',
	'Fri' => 'Jumat',
	'Sat' => 'Sabtu'
	);
//echo "Tanggal {$tanggal} adalah hari : " . $dayList[$day];


function tanggal_indo($tanggal){
	$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
	$split = explode('-', $tanggal);
	return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
	}

$sqlusername="select pd_nickname,nip from master_login where username='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);


$sqlitemcuti="SELECT 
    a.id_master_periode_cuti,
    b.nama_cuti,
    a.jumlah_kuota_cuti,
    sum(IFNULL(c.jumlah_cuti, 0)) AS jumlah_cuti,
	a.jumlah_kuota_cuti-sum(IFNULL(c.jumlah_cuti, 0)) as sisa
FROM
    simrs.master_periode_cuti a
        LEFT JOIN
    l_cuti b ON a.id_cuti = b.id_cuti
        LEFT JOIN
    (SELECT 
        id_periode_cuti, jumlah_cuti
    FROM
        pegawai_cuti_detail a
    LEFT JOIN master_login b ON a.uid = b.uid
    WHERE
        username = '$username') c ON a.id_master_periode_cuti = c.id_periode_cuti
WHERE
    a.id_status_karyawan = $id_status_karyawan group by a.id_master_periode_cuti";
$queryitemcuti = mysql_query($sqlitemcuti);


?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Pengajuan Cuti</title>

<style type="text/css">
	@page {
            margin-top: 0.6 cm;
            margin-left: 0.6 cm;
			margin-right: 0.6 cm;
			margin-bottom: 0.6 cm;
			font-family: Cambria, Hoefler Text, Liberation Serif, Times, Times New Roman, serif;
			font-size: 12px;
	}
	
.tabel {
    border-collapse:collapse;
	
}

</style>

</head>

<body>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">Ajibarang, <?php echo tanggal_indo(date("Y-m-d")); ?></td>
    </tr>
    <tr>
      <td width="20%">&nbsp;</td>
      <td width="28%">&nbsp;</td>
      <td width="21%">&nbsp;</td>
      <td width="31%">Kepada</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Yth. Direktur RSUD Ajibarang</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>di</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td> Tempat</td>
    </tr>
  </tbody>
</table>

 <div align="center" class="header"><strong style="font-size: 16px">FORMULIR PERMINTAAN DAN PEMBERIAN CUTI</strong></div>
<table width="100%" border="1" class="tabel">
  <tbody>
    <tr>
      <td colspan="4">I. DATA PEGAWAI</td>
    </tr>
    <tr>
      <td width="16%">Nama</td>
      <td width="29%"><?php echo $DATA_IDENTITAS['pd_nickname']; ?></td>
      <td width="14%">NIP</td>
      <td width="41%"><?php echo $DATA_IDENTITAS['nip']; ?></td>
    </tr>
    <tr>
      <td>Jabatan</td>
      <td><?php echo $DATA_IDENTITAS['jabatan']; ?></td>
      <td>Masa Kerja</td>
      <td><?php echo $DATA_IDENTITAS['masa_kerja']; ?></td>
    </tr>
    <tr>
      <td>Unit Kerja</td>
      <td colspan="3">RSUD Ajibarang</td>
    </tr>
  </tbody>
</table>
<br>
<table width="100%" border="1" class="tabel">
  <tbody>
    <tr>
      <td colspan="2">II. JENIS CUTI YANG DIAMBIL **</td>
    </tr>
    <tr>
      <td width="5%">1.</td>
      <td width="95%"><?php echo $DATA_IDENTITAS['nama_cuti']; ?></td>
    </tr>
  </tbody>
</table>
<br>
<table width="100%" border="1" class="tabel">
  <tbody>
    <tr>
      <td>III. ALASAN CUTI **</td>
    </tr>
    <tr>
      <td><?php echo $DATA_IDENTITAS['alasan_cuti']; ?></td>
    </tr>
  </tbody>
</table>
<br>
<table width="100%" border="1" class="tabel">
  <tbody>
    <tr>
      <td colspan="6">IV. LAMANYA CUTI</td>
    </tr>
    <tr>
      <td width="16%">Selama</td>
      <td width="12%" align="center"><?php echo $DATA_IDENTITAS['jumlah_cuti']; ?> hari</td>
      <td width="14%">Mulai Tanggal</td>
      <td width="18%" align="center"><?php echo $DATA_IDENTITAS['tanggal_mulai']; ?></td>
      <td width="15%" align="center">s/d</td>
      <td width="25%" align="center"><?php echo $DATA_IDENTITAS['tanggal_selesai']; ?></td>
    </tr>
  </tbody>
</table>
<br>
<table width="100%" border="1" class="tabel">
  <tbody>
    <tr>
      <td colspan="5">V. CATATAN CUTI</td>
    </tr>
    <tr>
     <td align="center">No.</td>
      <td align="center">Nama Cuti</td>
      <td align="center">Batasan Jumlah Cuti</td>
      <td align="center">Jumlah Cuti yang Telah diambil</td>
      <td align="center">Sisa Cuti</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemcuti)){
			echo '<tr>';
	  echo '<td align="center">'.$no.'</td>';
      echo '<td>'.$data['nama_cuti'].'</td>';
	  echo '<td align="center">'.$data['jumlah_kuota_cuti'].'</td>';
	  echo '<td align="center">'.$data['jumlah_cuti'].'</td>';
	  echo '<td align="center">'.$data['sisa'].'</td>';
			echo '</tr>';
			$no++;
		}
	?>
    
  </tbody>
</table>

<br>

<table width="100%" border="1" class="tabel">
  <tbody>
    <tr>
      <td colspan="3">VI. ALAMAT SELAMA MENJALANKAN CUTI</td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_IDENTITAS['alamat_selama_cuti']; ?></td>
      <td align="center">Telp</td>
      <td align="center"><?php echo $DATA_IDENTITAS['no_telp']; ?></td>
    </tr>
    <tr>
      <td width="49%" align="center"><strong><?php echo $DATA_ATASAN['jabatan_kasi']; ?></strong></td>
      <td width="4%" align="center">&nbsp;</td>
      <td width="47%" align="center">Hormat saya,</td>
    </tr>
    <tr>
      <td align="center"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p><u><?php echo $DATA_ATASAN['atasan_kasi']; ?></u><br>NIP. <?php echo $DATA_ATASAN['nip_kabid']; ?></p></td>
      <td align="center"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
      <td align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
      <p><u><?php echo $DATA_IDENTITAS['hormatsaya']; ?></u><br>NIP. <?php echo $DATA_IDENTITAS['nipsaya']; ?></p></td>
    </tr>
  </tbody>
</table>
<br>
<table width="100%" border="1" class="tabel">
  <tbody>
    <tr>
      <td colspan="2">VII. PERTIMBANGAN ATASAN LANGSUNG**</td>
    </tr>
    <tr>
      <td colspan="2" align="left">&nbsp;</td>
    </tr>
    <tr>
      <td width="49%" align="center">&nbsp;</td>
      <td width="47%" align="center"><strong><?php echo $DATA_ATASAN['bidang']; ?></strong></td>
    </tr>
    <tr>
      <td><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
      <td align="center"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p><u><?php echo $DATA_ATASAN['nama_kabid']; ?></u><br>NIP. <?php echo $DATA_ATASAN['nip_kabid']; ?></p></td>
    </tr>
  </tbody>
</table>
<br>
<table width="100%" border="1" class="tabel">
  <tbody>
    <tr>
      <td colspan="2">VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI**</td>
    </tr>
    <tr>
      <td colspan="2" align="left">&nbsp;</td>
    </tr>
    <tr>
      <td width="49%" align="center">&nbsp;</td>
      <td width="47%" align="center"><strong>DIREKTUR RSUD AJIBARANG</strong></td>
    </tr>
    <tr>
      <td><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
      <td align="center"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p><u><?php echo $DATA_ATASAN['nama_direktur']; ?></u><br>NIP. <?php echo $DATA_ATASAN['nip_direktur']; ?></p></td>
    </tr>
  </tbody>
</table>



</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 11.69 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('cuti.pdf',array('Attachment' => 0));
?>
<?php
ob_start();
include('connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];
//$id_bill_detail_tarif = 344708;
$username = $_GET['username'];

$sqlidentitas="SELECT 
    a.id_bill_detail_tarif,
    a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y %H:%m:%s') AS tglmasuk,
    DATE_FORMAT(d.tglkeluar, '%d-%m-%Y %H:%m:%s') AS tglkeluar,
    (SELECT 
    SUM(z.qty) AS jumlah
FROM
    simrs.bill_detail_tindakan_lain z
WHERE
    (z.id_jenis_tindakan = 15
        OR z.id_jenis_tindakan = 21)
        AND z.idxdaftar = a.idxdaftar) as lamarawat,
    DATE_FORMAT(d.tglkeluar, '%d-%m-%Y') AS tglcetak,
    CONCAT(e.keterangan,
            ' (',
            IFNULL(f.userlevelname, ''),
            ')') AS status_keluar,
	g.nama_penyakit AS diagnosa_primer,
    h.nama_penyakit AS diagnosa_sekunder,
	i.total as obat,
	k.nama_dokter,
	    l.rujukan,right(l.no_sep, 4) as no_skp,
		m.berat_badan,
		n.jam_pulang,
		n.jam_administrasi_selesai,
		n.jam_farmasi_datang,
		n.jam_farmasi_selesai,
		n.jam_kasir_datang,
		n.jam_kasir_selesai,
		n.jam_berkas_selesai
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs2012.m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    simrs.bill_detail_transfer_pasien d ON a.id_bill_detail_tarif = d.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_statuskeluar e ON e.status = d.id_status_keluar
        LEFT JOIN
    simrs.userlevels f ON d.userlevelid_transfer = f.userlevelid
	LEFT JOIN
    (SELECT 
        a.idxdaftar, b.nama_penyakit
    FROM
        bill_detail_penyakit a
    LEFT JOIN master_penyakit b ON a.id_penyakit = b.id_master_penyakit
    WHERE
        a.idxdaftar = $idxdaftar
    GROUP BY a.id_penyakit
    LIMIT 1) g ON a.idxdaftar = g.idxdaftar
        LEFT JOIN
    (SELECT 
        a.idxdaftar, b.nama_penyakit
    FROM
        bill_detail_penyakit a
    LEFT JOIN master_penyakit b ON a.id_penyakit = b.id_master_penyakit
    WHERE
        a.idxdaftar = $idxdaftar
    GROUP BY a.id_penyakit
    LIMIT 1 , 2) h ON a.idxdaftar = h.idxdaftar
	
	LEFT JOIN (SELECT 
    c.idxdaftar,
    IFNULL(SUM(a.total - IFNULL(b.total, 0)), 0) AS total
FROM
    bill_detail_permintaan_obat a
        LEFT JOIN
    bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
        LEFT JOIN
    bill_detail_tarif c ON a.id_bill_detail_tarif = c.id_bill_detail_tarif
WHERE
    c.idxdaftar = $idxdaftar) i on a.idxdaftar=i.idxdaftar
	        LEFT JOIN
    m_dokter k ON a.kddokter = k.kddokter
LEFT JOIN bill_detail_lain l on a.idxdaftar=l.idxdaftar
LEFT JOIN (SELECT 
        a.idxdaftar, a.berat_badan
    FROM
        bill_detail_keterangan a
    WHERE
        a.idxdaftar = $idxdaftar order by a.id_bill_detail_keterangan desc
    LIMIT 1) m on a.idxdaftar=m.idxdaftar
LEFT JOIN (SELECT 
    idxdaftar,
    DATE_FORMAT(jam_pulang, '%d-%m-%Y %H:%i:%s') AS jam_pulang,
    DATE_FORMAT(jam_administrasi_selesai,
            '%d-%m-%Y %H:%i:%s') AS jam_administrasi_selesai,
    DATE_FORMAT(jam_farmasi_datang, '%d-%m-%Y %H:%i:%s') AS jam_farmasi_datang,
    DATE_FORMAT(jam_farmasi_selesai, '%d-%m-%Y %H:%i:%s') AS jam_farmasi_selesai,
    DATE_FORMAT(jam_kasir_datang, '%d-%m-%Y %H:%i:%s') AS jam_kasir_datang,
    DATE_FORMAT(jam_kasir_selesai, '%d-%m-%Y %H:%i:%s') AS jam_kasir_selesai,
    DATE_FORMAT(jam_berkas_selesai, '%d-%m-%Y %H:%i:%s') AS jam_berkas_selesai
FROM
    simrs.bill_detail_mutu_pelayanan
ORDER BY id_bill_detail_tarif DESC
LIMIT 1) n on a.idxdaftar=n.idxdaftar
	
WHERE a.idxdaftar = $idxdaftar group by a.idxdaftar";
 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqlitembiaya="SELECT 
    a.idxdaftar,c.nama_pelayanan,b.userlevelname, total_keseluruhan-(a.biaya_obat-ifnull(a.biaya_obat_retur,0)) as biaya
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
    LEFT JOIN l_pelayanan c on b.id_pelayanan=c.id_pelayanan
WHERE
    idxdaftar = $idxdaftar";
$queryitembiaya = mysql_query($sqlitembiaya);

$sqlitempelayanan="SELECT 
    c.nama_pelayanan
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
    LEFT JOIN l_pelayanan c on b.id_pelayanan=c.id_pelayanan
WHERE
    a.idxdaftar = $idxdaftar group by c.id_pelayanan";
$queryitempelayanan = mysql_query($sqlitempelayanan);


$sqlitemtindakan="SELECT 
    b.nama_tindakan, SUM(a.qty) AS jumlah, c.userlevelname
FROM
    simrs.bill_detail_tindakan a
        LEFT JOIN
    simrs.master_tindakan b ON a.id_tindakan = b.id_tindakan
        LEFT JOIN
    simrs.userlevels c ON a.userlevelid = c.userlevelid
WHERE
    a.idxdaftar = $idxdaftar
        AND (a.id_type_tindakan = 4
        OR a.id_type_tindakan = 5
        OR a.id_type_tindakan = 6
        OR a.id_type_tindakan = 10
        OR a.id_type_tindakan = 11
        OR a.id_type_tindakan = 12)
GROUP BY a.id_tindakan";
$queryitemtindakan = mysql_query($sqlitemtindakan);


$sqlitemdokter="SELECT 
    b.namadokter, c.userlevelname
FROM
    bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_dokter b ON a.kddokter = b.kddokter
        LEFT JOIN
    userlevels c ON a.userlevelid = c.userlevelid
WHERE
    a.idxdaftar = $idxdaftar";
$queryitemdokter = mysql_query($sqlitemdokter);


$sqlitemkelas="SELECT 
    b.nama_kelas
FROM
    simrs.bill_detail_tarif a
    left join l_kelas b on a.kelas=b.kelas
WHERE
    a.idxdaftar = $idxdaftar group by a.kelas";
$queryitemkelas = mysql_query($sqlitemkelas);

$sqlitemcarakeluar="SELECT 
    keterangan
FROM
    bill_detail_transfer_pasien a
        LEFT JOIN
    simrs2012.m_statuskeluar b ON a.id_status_keluar = b.status
WHERE
    a.idxdaftar = $idxdaftar order by a.id_bill_detail_tarif desc limit 1";
$queryitemcarakeluar = mysql_query($sqlitemcarakeluar);



 $sqltotal="select sum(total_keseluruhan) as total from bill_detail_tarif where idxdaftar=$idxdaftar";
 $querytotal = mysql_query($sqltotal);
 $DATA_TOTAL = mysql_fetch_array($querytotal);
 
 $sqladmisi="SELECT 
     a.idxdaftar, date_format(a.tanggal,'%d-%m-%Y %H:%i:%s') as tglmasuk, date_format(b.tglkeluar,'%d-%m-%Y %H:%i:%s') as tglkeluar
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    (SELECT 
        id_bill_detail_tarif, idxdaftar, tglkeluar
    FROM
        bill_detail_transfer_pasien WHERE idxdaftar=$idxdaftar
    ORDER BY idid_bill_transfer_pasien DESC
    LIMIT 1) b ON a.idxdaftar = b.idxdaftar where a.idxdaftar=$idxdaftar
ORDER BY a.id_bill_detail_tarif ASC
LIMIT 1";

 $queryadmisi = mysql_query($sqladmisi);
 $DATA_ADMISI = mysql_fetch_array($queryadmisi);


?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>INADRG</title>

<style type="text/css">
	
@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
	font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}
	
.tabelfix {
    border-collapse:collapse;
	font-size: 11px;
}
.oke {
    border:none;
}
.a {
	font-size: 9px;
}
.footer {
	font-size: 11px;
}
.header {
	font-size: 14px;
}
	
</style>



</head>

<body>
<table width="100%" border="0">
  <tr>
    <td class="header" width="97%">
      <div>
        <strong>DATA COLLECTION FORM INA-DRG VERSI 1.6</strong><br />
        <strong>RUMAH SAKIT UMUM DAERAH AJIBARANG - JAWA TENGAH</strong><br />
        Jl. Raya Pancasan - Ajibarang, Kode Pos 53163 Telp. (0281)6570004, Fax (0281)5670005<br />      
        Email: rsudajibarang@banyumaskab.go.id
      </div>
    </td>
  </tr>
</table>

<br>

<table width="100%" cellpadding="3px" class="tabelfix" border="1">
  <tbody>
    <tr>
      <td width="3%" align="center"><strong>NO</strong></td>
      <td width="27%" align="center"><strong>KODE</strong></td>
      <td width="30%" align="center"><strong>ITEM</strong></td>
      <td width="40%" align="center"><strong>KET</strong></td>
    </tr>
    <tr>
      <td align="center">1</td>
      <td>KODE RS</td>
      <td align="center" class="header"><strong>3302191</strong></td>
      <td align="center" class="header"><strong>RSUD AJIBARANG</strong></td>
    </tr>
    <tr>
      <td align="center">2</td>
      <td>KELAS</td>
      <td align="center"><strong>C</strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">3</td>
      <td>NO. REKAM MEDIS</td>
      <td align="center"><?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">4</td>
      <td>NO SKP</td>
      <td align="center"><?php echo $DATA_IDENTITAS['no_skp']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">5</td>
      <td>SURAT RUJUKAN</td>
      <td align="center"><?php echo $DATA_IDENTITAS['rujukan']; ?></td>
      <td align="center">1. ADA &nbsp;&nbsp;&nbsp;&nbsp; 2. TIDAK</td>
    </tr>
    <tr>
      <td align="center">6</td>
      <td>NAMA PASIEN</td>
      <td align="center"><?php echo $DATA_IDENTITAS['nama']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">7</td>
      <td>KELAS PERAWATAN</td>
      <td align="center"><table width="100%" border="0">
        <tbody>
          <tr>
            <?php
			  $no=1;
				while($data=mysql_fetch_assoc($queryitemkelas)){
					echo '<td align="center">'.$data['nama_kelas'].'</td>';
					$no++;
			}
			?>
          </tr>
        </tbody>
      </table></td>
      <td>
      		<center>1. (Kelas 1) &nbsp;&nbsp; 2. (Kelas 2) &nbsp;&nbsp; 3. (Kelas 3) </center>
      </td>
    </tr>
    <tr>
      <td align="center">8</td>
      <td>CARA BAYAR</td>
      <td align="center"><?php echo $DATA_IDENTITAS['carabayar']; ?></td>
      <td align="center"><center>1. BPJS PBI &nbsp;&nbsp; 2. BPJS NON PBI &nbsp;&nbsp; 3. UMUM  &nbsp;&nbsp; 4. KBS/JAMKSESDA</center></td>
    </tr>
    <tr>
      <td align="center">9</td>
      <td>JENIS PERAWATAN</td>
      <td align="center"><table width="100%" border="0">
        <tbody>
          <tr>
            <?php
			  $no=1;
				while($data=mysql_fetch_assoc($queryitempelayanan)){
					echo '<td align="center">'.$no.'. '.$data['nama_pelayanan'].'</td>';
					$no++;
			}
			?>
          </tr>
        </tbody>
      </table></td>
      <td>
      <center>1. Rawat Jalan &nbsp;&nbsp; 2. Rawat Inap</center>
      </td>
    </tr>
    <tr>
      <td align="center">10</td>
      <td>TANGGAL MASUK/JAM</td>
      <td align="center"><?php echo $DATA_ADMISI['tglmasuk']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">11</td>
      <td>TANGGAL KELUAR/JAM</td>
      <td align="center"><?php echo $DATA_ADMISI['tglkeluar']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">12</td>
      <td>TANGGAL LAHIR</td>
      <td align="center"><?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">13</td>
      <td>JUMLAH LAMA DIRAWAT</td>
      <td align="center"><?php echo $DATA_IDENTITAS['lamarawat']; ?> Hari</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">14</td>
      <td>JENIS KELAMIN</td>
      <td align="center"><?php echo $DATA_IDENTITAS['jeniskelamin']; ?></td>
      <td align="center">1. LAKI-LAKI (L) &nbsp;&nbsp; 2. PEREMPUAN (P)</td>
    </tr>
    <tr>
      <td align="center">15</td>
      <td>CARA PULANG</td>
      <td align="center">&nbsp;</td>
      <td>
      	<table width="100%" border="0">
        <tbody>
          <tr>
            <?php
			  $no=1;
				while($data=mysql_fetch_assoc($queryitemcarakeluar)){
					echo '<td align="center">'.$no.'. '.$data['keterangan'].'</td>';
					$no++;
			}
			?>
          </tr>
        </tbody>
      </table>
      </td>
    </tr>
    <tr>
      <td align="center">16</td>
      <td>BERAT LAHIR</td>
      <td align="center"><?php echo $DATA_IDENTITAS['berat_badan']; ?></td>
      <td align="center">Satuan Kilogram</td>
    </tr>
    <tr>
      <td align="center">17</td>
      <td>DIAGNOSA PRIMER</td>
      <td align="center"><?php echo $DATA_IDENTITAS['diagnosa_primer']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">18</td>
      <td>DIAGNOSA SEKUNDER</td>
      <td align="center"><?php echo $DATA_IDENTITAS['diagnosa_sekunder']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">19</td>
      <td>TINDAKAN</td>
      <td align="center">&nbsp;</td>
      <td>
      </td>
    </tr>
    
    <?php
		while($data=mysql_fetch_assoc($queryitemtindakan)){
			echo '<tr>';
			echo '<td></td>';
      		echo '<td>-'.$data['nama_tindakan'].'</td>';
	  		echo '<td align="center">'.$data['jumlah'].'</td>';
			echo '<td>'.$data['userlevelname'].'</td>';
			echo '</tr>';
			
		$no++;
	}
    
	?>
    
    <tr>
      <td align="center">20</td>
      <td> SEBAB CIDERA</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">21</td>
      <td>RINCIAN BIAYA</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
    
    <?php
		while($data=mysql_fetch_assoc($queryitembiaya)){
			echo '<tr>';
			echo '<td></td>';
      		echo '<td>-'.$data['nama_pelayanan'].'</td>';
	  		echo '<td align="center">'.number_format($data['biaya'], 0,",",".").'</td>';
			echo '<td>'.$data['userlevelname'].'</td>';
			echo '</tr>';
			
		$no++;
	}
    
	?>
    
    
    <tr>
      <td align="center">&nbsp;</td>
      <td>-OBAT / FARMASI</td>
      <td align="center"><?php echo number_format($DATA_IDENTITAS['obat'], 0,",","."); ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td><strong>TOTAL BIAYA RIIL</strong></td>
      <td align="center"><strong>Rp. <?php echo number_format($DATA_TOTAL['total'], 0,",","."); ?></strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">22</td>
      <td>KODEBINA-DRG</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">23</td>
      <td>TARIF INA-DRG</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">24</td>
      <td>DPJP</td>
      <td align="center"></td>
      <td>&nbsp;</td>
    </tr>
    
    <?php
		while($data=mysql_fetch_assoc($queryitemdokter)){
			echo '<tr>';
			echo '<td></td>';
			echo '<td>- '.$data['namadokter'].'</td>';
      		echo '<td align="center">1</td>';
			echo '<td>'.$data['userlevelname'].'</td>';
			echo '</tr>';
			
		$no++;
	}
	?>
    
    <tr>
      <td align="center">25</td>
      <td>PENGESAHAN SEV. LEVEL</td>
      <td align="center">&nbsp;</td>
      <td><table width="100%" class="tabelfix" border="0">
        <tbody>
          <tr>
            <td width="55%">1. ADA</td>
            <td width="45%">2. TIDAK</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>JAM DIPUTUSKAN PULANG</td>
      <td align="center"><?php echo $DATA_IDENTITAS['jam_pulang']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>JAM SELESAI ADMINISTRASI</td>
      <td align="center"><?php echo $DATA_IDENTITAS['jam_administrasi_selesai']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>JAM DATANG FARMASI</td>
      <td align="center"><?php echo $DATA_IDENTITAS['jam_farmasi_datang']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>JAM SELESAI FARMASI</td>
      <td align="center"><?php echo $DATA_IDENTITAS['jam_farmasi_selesai']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>JAM DATANG KASIR</td>
      <td align="center"><?php echo $DATA_IDENTITAS['jam_kasir_datang']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>JAM SELESAI KASIR</td>
      <td align="center"><?php echo $DATA_IDENTITAS['jam_kasir_selesai']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>JAM PASIEN MENYERAHKAN BERKAS ADMINISTASI</td>
      <td align="center"><?php echo $DATA_IDENTITAS['jam_berkas_selesai']; ?></td>
      <td>&nbsp;</td>
    </tr>
   
    
  </tbody>
</table>
<br>
<table width="100%" border="0">
  <tbody>
    <tr>
     <td width="3%" align="center"></td>
      <td width="27%" align="center"></td>
      <td width="30%" align="center"></td>
      <td width="40%" align="center"><em>Form Pengumpulan Data INA-DRG Versi 1.6</em></td>
    </tr>
  </tbody>
</table>


</body>
</html>
<?php
 $html = ob_get_clean();
require_once("dompdf_baru/dompdf_config.inc.php");
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->setIsRemoteEnabled(true);
$dompdf = new Dompdf($options);
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('notainacbg.pdf',array('Attachment' => 0));
?>

<?php
ob_start();
session_start();
include('../connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];
$username = $_GET['username'];
$id_bill_detail_tarif_ibs = $_GET['id_bill_detail_tarif_ibs'];

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


$sqlidentitas="SELECT 
    a.id_bill_detail_tarif,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y %H:%m:%s') AS tglmasuk,
    DATE_FORMAT(d.tglkeluar, '%d-%m-%Y %H:%m:%s') AS tglkeluar,
    a.total_keseluruhan
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs2012.m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    simrs.bill_detail_transfer_pasien d ON a.id_bill_detail_tarif = d.id_bill_detail_tarif
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqljamoperasi="SELECT 
    tanggal,
    TIME(tanggal_mulai) AS jam_mulai,
    TIME(tanggal_selesai) AS jam_selesai,
    TIMEDIFF(tanggal_selesai, tanggal_mulai) AS lama_operasi
FROM
    simrs.ibs_jam_operasi
WHERE
    id_bill_detail_tarif_ibs = $id_bill_detail_tarif_ibs";

 $queryjamoperasi = mysql_query($sqljamoperasi);
 $DATA_JAMOPERASI = mysql_fetch_array($queryjamoperasi);


$sqldiagnosa="SELECT 
    GROUP_CONCAT(b.nama_penyakit
        SEPARATOR ',') AS pra_diagnosa,
    (SELECT 
            GROUP_CONCAT(b.nama_penyakit
                    SEPARATOR ',') AS pasca_diagnosa
        FROM
            ibs_detail_diagnosa_pasca a
                LEFT JOIN
            master_penyakit b ON a.diagnosa_pasca = b.id_master_penyakit
        WHERE
            a.id_bill_detail_tarif_ibs = 4
        GROUP BY id_bill_detail_tarif_ibs) AS pasca_diagnosa,
    c.tindakan,d.laporan_operasi,d.catatan_operasi,d.keterangan_bedah,d.intruksi_operasi
FROM
    ibs_detail_diagnosa_pra a
        LEFT JOIN
    master_penyakit b ON a.diagnosa_pra = b.id_master_penyakit
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif_detail,
            GROUP_CONCAT(b.nama_tindakan
                SEPARATOR ', ') AS tindakan
    FROM
        bill_detail_tindakan a
    LEFT JOIN master_tindakan b ON a.id_tindakan = b.id_tindakan
    WHERE
        a.id_bill_detail_tarif_detail = $id_bill_detail_tarif_ibs
    GROUP BY a.id_tindakan) c ON a.id_bill_detail_tarif_ibs = c.id_bill_detail_tarif_detail
	LEFT JOIN
    (SELECT 
        id_bill_detail_tarif_ibs, laporan_operasi, catatan_operasi,intruksi_operasi,keterangan_bedah
    FROM
        ibs_detail_catatan
    WHERE
        id_bill_detail_tarif_ibs = $id_bill_detail_tarif_ibs) d ON a.id_bill_detail_tarif_ibs = d.id_bill_detail_tarif_ibs
WHERE
    a.id_bill_detail_tarif_ibs = $id_bill_detail_tarif_ibs
GROUP BY a.id_bill_detail_tarif_ibs";

 $querydiagnosa = mysql_query($sqldiagnosa);
 $DATA_DIAGNOSA = mysql_fetch_array($querydiagnosa);


$sqlitempj="SELECT 
    GROUP_CONCAT(c.pd_nickname
        SEPARATOR ' | ') AS nama_tenaga_ahli,
    CONCAT(d.nama_profesi,
            ' ',
            e.nama_master_profesi_sub) AS pj
FROM
    bill_detail_visit_dokter a
        LEFT JOIN
    l_dokter_standby b ON a.id_dokter_standby = b.id_dokter_standby
        LEFT JOIN
    master_login c ON b.uid = c.uid
        LEFT JOIN
    master_profesi d ON b.id_profesi = d.id_profesi
        LEFT JOIN
    master_profesi_sub e ON b.id_profesi_sub = e.id_master_profesi_sub
WHERE
    id_bill_detail_tarif_detail = $id_bill_detail_tarif_ibs
GROUP BY a.id_profesi_sub asc";
$queryitempj = mysql_query($sqlitempj);


?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan IBS</title>
<style type="text/css">
	
	@page {
            margin-top: 0.1 cm;
            margin-left: 0.1 cm;
			margin-right: 0.1 cm;
			margin-bottom: 0.1 cm;
	}
.tabel {
    border-collapse:collapse;
	font-size: 11px;
	font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
	
}
</style>
</head>

<body>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="40%">
      	  <div align="center">
            <span style="font-size: 9px"><strong>PEMERINTAH KABUPATEN BANYUMAS</strong><br />
            <strong>RUMAH SAKIT UMUM DAERAH AJIBARANG</strong><br />
        			Jl. Raya Pancasan - Ajibarang, Kode Pos 53163 Telp. (0281)6570004, Fax (0281)5670005<br />     
        			Email: rsudajibarang@banyumaskab.go.id
        	</span></div>
      </td>
      <td width="20%" align="center"><strong>LAPORAN TINDAKAN MEDIK OPERATIK</strong></td>
      <td width="40%"><table width="100%" border="0">
        <tbody>
          <tr>
            <td width="26%">NOMR</td>
            <td width="74%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
          </tr>
          <tr>
            <td>Nama</td>
            <td>: <?php echo $DATA_IDENTITAS['nama']; ?></td>
          </tr>
          <tr>
            <td>Tgl Lahir</td>
            <td>: <?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="2"><strong>Tenaga Ahli</strong></td>
      <td><strong>Penanggung Jawab Tugas</strong></td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitempj)){
			echo '<tr>';
      echo '<td colspan="2">'.''.$no.'. '.$data['nama_tenaga_ahli'].'</td>';
	  echo '<td>'.$data['pj'].'</td>';
			echo '</tr>';
			$no++;
		}
	?>
    
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">
      DIAGNOSA PRA BEDAH : <?php echo $DATA_DIAGNOSA['pra_diagnosa']; ?>
      </td>
    </tr>
    <tr>
      <td colspan="3">
      DIAGNOSA PASCA BEDAH : <?php echo $DATA_DIAGNOSA['pasca_diagnosa']; ?>
      </td>
    </tr>
    
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">JENIS OPERASI/TINDAKAN : <?php echo $DATA_DIAGNOSA['tindakan']; ?></td>
    </tr>
    <tr>
      <td colspan="3"><table width="100%" class="tabel" border="1">
        <tbody>
          <tr>
            <td>Tanggal Operasi</td>
            <td>Jam Mulai Operasi</td>
            <td>Jam Selesai Operasi</td>
            <td>Lama Operasi</td>
          </tr>
          <tr>
            <td align="center"><?php echo tanggal_indo($DATA_JAMOPERASI['tanggal']); ?></td>
            <td align="center"><?php echo $DATA_JAMOPERASI['jam_mulai']; ?></td>
            <td align="center"><?php echo $DATA_JAMOPERASI['jam_selesai']; ?></td>
            <td align="center"><?php echo $DATA_JAMOPERASI['lama_operasi']; ?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="3"><table width="100%" border="0">
        <tbody>
          <tr>
            <td>Jaringan yang dieksisi, kuretase :<br> <?php echo $DATA_DIAGNOSA['keterangan_bedah']; ?></td>
            <td>&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="3"><strong>LAPORAN OPERASI</strong> <br> <?php echo $DATA_DIAGNOSA['laporan_operasi']; ?></td>
    </tr>
    <tr>
      <td colspan="3"><strong>CATATAN</strong> <br> <?php echo $DATA_DIAGNOSA['catatan_operasi']; ?></td>
    </tr>
    <tr>
      <td><strong>INTRUKSI PASCA BEDAH</strong><br>
      <?php echo $DATA_DIAGNOSA['intruksi_operasi']; ?>
      
      </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td align="center"><p>Tanda Tangan</p>
      <p>&nbsp;</p></td>
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
$dompdf->stream('laporanoperasi.pdf',array('Attachment' => 0));
?>
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
    a.total_keseluruhan,
	e.signature,
	e.pd_nickname,
	e.no_surat_izin_praktek
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs2012.m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    simrs.bill_detail_transfer_pasien d ON a.id_bill_detail_tarif = d.id_bill_detail_tarif
		LEFT JOIN
    simrs.master_login e ON a.kddokter = e.kddokter
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
    b.pra,
    c.pasca,
    d.tindakan,
    e.laporan_operasi,
    e.catatan_operasi,
    e.keterangan_bedah,
    e.intruksi_operasi,
    e.jam_mulai,
    e.jam_selesai,
    e.tanggal_operasi,
	e.lama_operasi,
	e.jenis_pemeriksaan,d.type_tindakan
FROM
    simrs.bill_detail_tarif_ibs a
        LEFT JOIN
    (SELECT 
        z.keterangan AS pra, id_bill_detail_tarif
    FROM
        bill_detail_penyakit z
    WHERE
        id_diagnosa_inout = 1) b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        z.keterangan AS pasca, id_bill_detail_tarif
    FROM
        bill_detail_penyakit z
    WHERE
        id_diagnosa_inout = 2) c ON a.id_bill_detail_tarif = c.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
    a.id_bill_detail_tarif_detail,
    GROUP_CONCAT(b.nama_tindakan
        SEPARATOR ', ') AS tindakan,c.type_tindakan
FROM
    bill_detail_tindakan a
        LEFT JOIN
    master_tindakan b ON a.id_tindakan = b.id_tindakan
        LEFT JOIN
    simrs.l_type_tindakan c ON a.id_type_tindakan = c.id_type_tindakan
	WHERE b.userlevelid = 40  AND a.id_bill_detail_tarif_detail=$id_bill_detail_tarif_ibs) d ON a.id_bill_detail_tarif_ibs = d.id_bill_detail_tarif_detail
        LEFT JOIN
    (SELECT 
        id_bill_detail_tarif_ibs,
            laporan_operasi,
            catatan_operasi,
            intruksi_operasi,
            keterangan_bedah,
            jam_mulai,
            jam_selesai,
            tanggal_operasi,
			TIMEDIFF(jam_selesai, jam_mulai) AS lama_operasi,
			jenis_pemeriksaan
    FROM
        ibs_detail_catatan) e ON a.id_bill_detail_tarif_ibs = e.id_bill_detail_tarif_ibs
WHERE
    a.id_bill_detail_tarif_ibs = $id_bill_detail_tarif_ibs";

 $querydiagnosa = mysql_query($sqldiagnosa);
 $DATA_DIAGNOSA = mysql_fetch_array($querydiagnosa);


$sqlitempj="SELECT 
    GROUP_CONCAT(c.pd_nickname
        SEPARATOR ', ') AS dpjp
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
    a.id_bill_detail_tarif_detail = $id_bill_detail_tarif_ibs
        AND c.id_profesi = 13
        AND c.id_profesi_sub <> 4
GROUP BY a.id_bill_detail_tarif_detail";
$queryitempj = mysql_query($sqlitempj);
$DATA_DPJP = mysql_fetch_array($queryitempj);

$sqlitempjan="SELECT 
    GROUP_CONCAT(c.pd_nickname
        SEPARATOR ', ') AS dpjp
FROM
    bill_detail_visit_dokter a
        LEFT JOIN
    l_dokter_standby b ON a.id_dokter_standby = b.id_dokter_standby
        AND b.id_profesi_sub = 4
        LEFT JOIN
    master_login c ON b.uid = c.uid
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif
GROUP BY a.id_bill_detail_tarif_detail";
$queryitempjan = mysql_query($sqlitempjan);
$DATA_DPJP_ANESTESI = mysql_fetch_array($queryitempjan);

$sqlitempasbed="SELECT 
    GROUP_CONCAT(c.pd_nickname
        SEPARATOR ', ') AS asbed
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
    a.id_bill_detail_tarif_detail = $id_bill_detail_tarif_ibs
        AND e.id_master_profesi_sub = 7
GROUP BY a.id_bill_detail_tarif_detail";
$queryitemasbed = mysql_query($sqlitempasbed);
$DATA_ASBED = mysql_fetch_array($queryitemasbed);

$sqlitempasan="SELECT 
    GROUP_CONCAT(c.pd_nickname
        SEPARATOR ', ') AS asan
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
    a.id_bill_detail_tarif_detail = $id_bill_detail_tarif_ibs
        AND e.id_master_profesi_sub = 8
GROUP BY a.id_bill_detail_tarif_detail";
$queryitemasan = mysql_query($sqlitempasan);
$DATA_ASAN = mysql_fetch_array($queryitemasan);


?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan IBS</title>
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
	font-size: 12px;
	
}
.spasi {
  padding-top: 15px;
  padding-bottom: 15px;
}
.spasi2 {
  padding-top: 10px;
  padding-bottom: 10px;
}
</style>
</head>

<body>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="40%" colspan="2">
      	  <div align="center">
            <span style="font-size: 9px"><strong>PEMERINTAH KABUPATEN BANYUMAS</strong><br />
            <strong>RUMAH SAKIT UMUM DAERAH AJIBARANG</strong><br />
        			Jl. Raya Pancasan - Ajibarang, Kode Pos 53163 Telp. (0281)6570004, Fax (0281)5670005<br />     
        			Email: rsudajibarang@banyumaskab.go.id
        	</span></div>
      </td>
      <td width="25%" align="center"><strong>LAPORAN TINDAKAN MEDIK OPERATIK</strong></td>
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
      <td class="spasi" colspan="3"><strong>Dokter Bedah &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> <?php echo $DATA_DPJP['dpjp']; ?></td>
      <td><strong>Asisten Bedah:</strong> <?php echo $DATA_ASBED['asbed']; ?></td>
    </tr>
    <tr>
      <td class="spasi" colspan="3"><strong>Dokter Anastesi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> <?php echo $DATA_DPJP_ANESTESI['dpjp']; ?></td>
      <td><strong>Penata Anastesi:</strong> <?php echo $DATA_ASAN['asan']; ?></td>
    </tr>
    
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td class="spasi2" colspan="4">
      DIAGNOSA PRA BEDAH &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <?php echo $DATA_DIAGNOSA['pra']; ?>
      </td>
    </tr>
    <tr>
      <td class="spasi2" colspan="4">
      DIAGNOSA PASCA BEDAH &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <?php echo $DATA_DIAGNOSA['pasca']; ?>
      </td>
    </tr>
    
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" class="spasi">JENIS OPERASI/TINDAKAN : <?php echo $DATA_DIAGNOSA['tindakan']; ?></td>
    </tr>
    
    <tr>
      <td width="40%" align="center">Tanggal Operasi</td>
      <td width="25%" align="center">Jam Mulai Operasi</td>
      <td width="25%" align="center">Jam Selesai Operasi</td>
      <td width="40%" align="center">Lama Operasi</td>
    </tr>
    <tr>
      <td class="spasi2" width="40%"  align="center"><?php echo tanggal_indo($DATA_DIAGNOSA['tanggal_operasi']); ?></td>
      <td class="spasi2" width="25%" align="center"><?php echo $DATA_DIAGNOSA['jam_mulai']; ?></td>
      <td class="spasi2" width="25%" align="center"><?php echo $DATA_DIAGNOSA['jam_selesai']; ?></td>
      <td class="spasi2" width="40%" align="center"><?php echo $DATA_DIAGNOSA['lama_operasi']; ?></td>
    </tr>
    
    <tr>
      <td colspan="2" rowspan="2">Jaringan yang dieksisi, insisi, kuretase: <br>dikirim untuk pemeriksaan: <br><strong><?php echo $DATA_DIAGNOSA['jenis_pemeriksaan']; ?></strong></td>
      <td colspan="2">Tindakan Medis Operatif:</td>
    </tr>
    <tr>
      <td colspan="2"><?php echo $DATA_DIAGNOSA['type_tindakan']; ?></td>
    </tr>
    <tr>
      <td colspan="4"><strong>LAPORAN OPERASI</strong> <br> <?php echo $DATA_DIAGNOSA['laporan_operasi']; ?></td>
    </tr>
    <tr>
      <td colspan="4"><strong>CATATAN</strong> <br> <?php echo $DATA_DIAGNOSA['catatan_operasi']; ?></td>
    </tr>
    <tr>
      <td colspan="3" valign="top"><strong>INTRUKSI PASCA BEDAH</strong><br>
        <?php echo $DATA_DIAGNOSA['intruksi_operasi']; ?>
        
      </td>
      <td align="center"><p>Tanda Tangan</p>
      <p><img height="80px" src="../../uploads/<?php echo $DATA_IDENTITAS['signature']; ?>"/><br>( <?php echo $DATA_IDENTITAS['pd_nickname']; ?> )<br>SIP:<?php echo $DATA_IDENTITAS['no_surat_izin_praktek']; ?>
      </p></td>
    </tr>

  </tbody>
</table>
<br>
<table>
			<tr>
            	<td class="label2">
                aurolab
                </td>
                <td class="label2"><b> Auroflex </b>
                </td>
                <td class="label3">
                	Issue 2 09/16
                </td>
            </tr> 
            <tr>
            	<td colspan="3" class="label3">Hydrophilic<b> foldable IOL</b></td>
            </tr>
            <tr>
            	<td colspan="3" class="label3">
                	<table>
                    	<tr>
                        	<td>Optic 6.0</td>
                            <td> </td>
                            <td>mm</td>
                            <td> </td>
                            <td>Overall 12.00 mm</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
            	<td colspan="3">
                	<table class="label1">
                    	<tr>
                        	<td border="1"><strong>REF</strong></td>
                            <td> </td>
                            <td>FH5600SQ</td>
                            <td> </td>
                            <td>Power +22.0</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
            	<td colspan="3" class="label1">
                	<table>
                    	<tr>
                        	<td border="1"><strong>LOT</strong></td>
                            <td> </td>
                            <td>FH5600SQ</td>
                            <td> </td>
                            <td>Power +22.0</td>
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
$paper_size = array(0,0, 8.26 * 72, 11.69 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporanoperasi.pdf',array('Attachment' => 0));
?>
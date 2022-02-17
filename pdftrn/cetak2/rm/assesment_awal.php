<?php
ob_start();
session_start();
include('../connect.php');
$nomr = $_GET['nomr'];
$idxdaftar = $_GET['idxdaftar'];
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];

$sqlitemanamnesa="SELECT 
    b.nomr,
    d.nama,
    DATE_FORMAT(d.tgllahir, '%d-%m-%Y') AS tgllahir,
    DATE_FORMAT(a.tanggal_anamnesa, '%d-%m-%Y %H:%i:%s') AS tanggal_anamnesa,
    c.nama AS caradatang,
    a.informasi_dari,
    a.anamnesa,
	a.tanda_inpartu,
	a.gerak_janin,
	a.bab,
	a.hpht,
	a.hpl,
	a.umur_kehamilan,
	a.riwayat_persalinan,
	a.riwayat_kb,
	a.riwayat_imunisasi,
	a.riwayat_makanan,
	a.riwayat_tumbuh_kembang,
    a.riwayat_terdahulu,
    a.alergi,
    a.riwayat_keluarga,
    a.riwayat_sosial,
    a.tempat_tinggal,
    d.PENANGGUNGJAWAB_NAMA,
    d.PENANGGUNGJAWAB_HUBUNGAN,
    d.PENANGGUNGJAWAB_PHONE,
    d.PEKERJAAN,
    a.edukasi_hambatan,
    e.bahasa_harian,
    a.edukasi_penerjemah,
    a.edukasi_kepercayaan_dianut,
    a.edukasi_pembelajaran,
    a.edukasi_informasi_diberikan,
    f.skala_nyeri,
    a.perencanaan_tindakan,
    a.skor_resiko_jatuh_berdiri,
    a.skor_resiko_jatuh_duduk,
    a.status_fungsional,
    a.gizi_terlihat_kurus,
    a.gizi_pakaian_terlihat_longgar,
    a.gizi_kehilangan_bb,
    a.gizi_penurunan_asupan,
    a.gizi_merasa_loyo,
    a.gizi_menderita_penyakit,
    a.tekanan_darah,
    a.heart_rate,
    a.respiration_rate,
    a.suhu_badan,
    a.tinggi_badan,
    a.berat_badan,
    a.psikologi,
    a.mental,
	a.lingkar_kepala,
    IFNULL((SELECT 
                    x.keterangan
                FROM
                    bill_detail_transfer_pasien z
                        LEFT JOIN
                    m_statuskeluar x ON z.id_status_keluar = x.status
                WHERE
                    z.id_bill_detail_tarif = a.id_bill_detail_tarif
                        AND z.id_status_keluar = 2),
            'Tidak') AS rujuk,
    (SELECT 
            CASE
                    WHEN y.userlevelname IS NULL THEN 'Tidak'
                    WHEN y.userlevelname IS NOT NULL THEN CONCAT('Konsul Ke ', y.userlevelname)
                END AS konsul
        FROM
            bill_detail_transfer_pasien z
                LEFT JOIN
            m_statuskeluar x ON z.id_status_keluar = x.status
                LEFT JOIN
            userlevels y ON z.userlevelid_transfer = y.userlevelid
        WHERE
            z.id_bill_detail_tarif = a.id_bill_detail_tarif
                AND z.id_status_keluar = 5) AS konsul,
                g.userlevelname
FROM
    simrs.bill_detail_keterangan a
        LEFT JOIN
    simrs2012.t_pendaftaran b ON a.idxdaftar = b.idxdaftar
        LEFT JOIN
    simrs2012.m_rujukan c ON b.KDRUJUK = c.KODE
        LEFT JOIN
    simrs2012.m_pasien d ON b.NOMR = d.NOMR
        LEFT JOIN
    simrs2012.m_bahasa_harian e ON e.id = d.KD_BHS_HARIAN
        LEFT JOIN
    simrs.l_skala_nyeri f ON a.skala_nyeri = f.id_skala_nyeri
        LEFT JOIN
    simrs.userlevels g ON b.kdpoly = g.userlevelid
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif";
$queryitemanamnesa = mysql_query($sqlitemanamnesa);
$DATAISI = mysql_fetch_array($queryitemanamnesa);



$sqlitemobjektif="SELECT 
    `bill_detail_keterangan`.`obj_kepala`,
    `bill_detail_keterangan`.`obj_leher`,
    `bill_detail_keterangan`.`obj_thorax`,
    `bill_detail_keterangan`.`obj_abdomen`,
    `bill_detail_keterangan`.`obj_anogenital`,
    `bill_detail_keterangan`.`obj_ekstremitas`,
    `bill_detail_keterangan`.`obj_status_lokalis`,
    `bill_detail_keterangan`.`kelainan`,
    `bill_detail_keterangan`.`penj_lab`,
    `bill_detail_keterangan`.`penj_rad`,
    `bill_detail_keterangan`.`penj_ekg`,
    `bill_detail_keterangan`.`penj_usg`,
    `bill_detail_keterangan`.`penj_endescopy`,
    `bill_detail_keterangan`.`rencana_tindakan`,
    `bill_detail_keterangan`.`mata_visus_dasar_od`,
    `bill_detail_keterangan`.`mata_visus_koreksi_od`,
    `bill_detail_keterangan`.`mata_tekanan_intraokuler_od`,
    `bill_detail_keterangan`.`mata_palpebra_od`,
    `bill_detail_keterangan`.`mata_konjungtiva_od`,
    `bill_detail_keterangan`.`mata_kornea_od`,
    `bill_detail_keterangan`.`mata_coa_od`,
    `bill_detail_keterangan`.`mata_pupil_od`,
    `bill_detail_keterangan`.`mata_iris_od`,
    `bill_detail_keterangan`.`mata_lensa_od`,
    `bill_detail_keterangan`.`mata_fundus_od`,
    `bill_detail_keterangan`.`mata_corpus_vitreum`,
    `bill_detail_keterangan`.`mata_funduskopi_od`,
    `bill_detail_keterangan`.`mata_visus_dasar_os`,
    `bill_detail_keterangan`.`mata_visus_koreksi_os`,
    `bill_detail_keterangan`.`mata_tekanan_intraokuler_os`,
    `bill_detail_keterangan`.`mata_palpebra_os`,
    `bill_detail_keterangan`.`mata_konjungtiva_os`,
    `bill_detail_keterangan`.`mata_kornea_os`,
    `bill_detail_keterangan`.`mata_coa_os`,
    `bill_detail_keterangan`.`mata_pupil_os`,
    `bill_detail_keterangan`.`mata_iris_os`,
    `bill_detail_keterangan`.`mata_lensa_os`,
    `bill_detail_keterangan`.`mata_fundus_os`,
    `bill_detail_keterangan`.`mata_funduskopi_os`,
    `bill_detail_keterangan`.`gigi_ekstra_oral`,
    `bill_detail_keterangan`.`gigi_intra_oral`,
    `bill_detail_keterangan`.`gigi_jaringan_lunak`,
    `bill_detail_keterangan`.`gigi_jaringan_keras`,
    `bill_detail_keterangan`.`jiwa_gangguan_persepsi`,
    `bill_detail_keterangan`.`jiwa_psikiatri`,
    `bill_detail_keterangan`.`jiwa_perilaku`,
    `bill_detail_keterangan`.`jiwa_alam_perasaan`,
    `bill_detail_keterangan`.`jiwa_proses_mikir`,
    `bill_detail_keterangan`.`jiwa_insight`,
    `bill_detail_keterangan`.`saraf_meningealsign`,
    `bill_detail_keterangan`.`saraf_nervus_cranialis`,
    `bill_detail_keterangan`.`saraf_motorik`,
    `bill_detail_keterangan`.`saraf_sensorik`,
    `bill_detail_keterangan`.`saraf_otonom`,
    `bill_detail_keterangan`.`bidan_fundus_uteri`,
    `bill_detail_keterangan`.`bidan_denyut_janin`,
    `bill_detail_keterangan`.`bidan_vaginal_toucher`,
    `bill_detail_keterangan`.`bidan_letak_janin`,
    `bill_detail_keterangan`.`bidan_status_obstetri`,
    `bill_detail_keterangan`.`bidan_his`
FROM
    `simrs`.`bill_detail_keterangan` 
	where id_bill_detail_tarif = $id_bill_detail_tarif";
$queryitemobjektif = mysql_query($sqlitemobjektif);
$DATAOBJEKTIF = mysql_fetch_array($queryitemobjektif);



$sqlitemdiagnosa1="SELECT 
    group_concat(CONCAT(CODE, ', ', STR) separator ' | ') AS diagnosa
FROM
    simrs.bill_detail_penyakit a
        LEFT JOIN
    simrs2012.vw_diagnosa_eklaim b ON a.icd10 = b.code
WHERE
    id_bill_detail_tarif = $id_bill_detail_tarif AND a.jenis_diagnosa='PRIMER'
    group by a.jenis_diagnosa";
$queryitemdiagnosa1 = mysql_query($sqlitemdiagnosa1);
$DATADIAGNOSAPRIMER = mysql_fetch_array($queryitemdiagnosa1);

$sqlitemdiagnosa2="SELECT 
    group_concat(CONCAT(CODE, ', ', STR) separator ' | ') AS diagnosa
FROM
    simrs.bill_detail_penyakit a
        LEFT JOIN
    simrs2012.vw_diagnosa_eklaim b ON a.icd10 = b.code
WHERE
    id_bill_detail_tarif = $id_bill_detail_tarif AND a.jenis_diagnosa='SEKUNDER'
    group by a.jenis_diagnosa";
$queryitemdiagnosa2 = mysql_query($sqlitemdiagnosa2);
$DATADIAGNOSASEKUNDER = mysql_fetch_array($queryitemdiagnosa2);

$sqlitemobat="SELECT 
    GROUP_CONCAT(CONCAT('(',
                d.nama_obat,
                ', ',
                a.qty,
                ', ',
                ifnull(a.aturan_pakai,''),
                ')')
        SEPARATOR ' | ') AS obat
FROM
    bill_detail_permintaan_obat a
        LEFT JOIN
    bill_detail_permintaan_obat_master b ON a.id_bill_detail_permintaan_obat_master = b.id_bill_detail_permintaan_obat_master
        LEFT JOIN
    master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
        LEFT JOIN
    master_obat d ON c.id_obat = d.id_obat
    where b.id_bill_detail_tarif = $id_bill_detail_tarif 
		and d.nama_obat NOT LIKE '%JASA%' 
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
    group by b.id_bill_detail_tarif";
$queryitemobat = mysql_query($sqlitemobat);
$DATAOBAT = mysql_fetch_array($queryitemobat);

$sqlitempenunjang="SELECT 
    b.userlevelname, a.nama_order
FROM
    simrs.bill_detail_order_penunjang a
        LEFT JOIN
    userlevels b ON a.userlevelid_tujuan = b.userlevelid
    where id_bill_detail_tarif=$id_bill_detail_tarif";
$queryitempenunjang = mysql_query($sqlitempenunjang);



$sqlitemtindakan="SELECT 
			GROUP_CONCAT(b.nama_tindakan
					SEPARATOR ', ') AS tindakan
		FROM
			simrs.bill_detail_tindakan a
				LEFT JOIN
			simrs.master_tindakan b ON a.id_tindakan = b.id_tindakan
		WHERE
			b.userlevelid IS NULL
				AND a.id_bill_detail_tarif = $id_bill_detail_tarif
		GROUP BY a.id_bill_detail_tarif";
$queryitemtindakan = mysql_query($sqlitemtindakan);
$DATATINDAKAN = mysql_fetch_array($queryitemtindakan);

$sqlitemobatdikonsumsi="SELECT 
    b.nomr, b.idxdaftar, d.nama_obat, e.nama_resep
FROM
    simrs.bill_detail_permintaan_obat a
        LEFT JOIN
    simrs.bill_detail_permintaan_obat_master b ON a.id_bill_detail_permintaan_obat_master = b.id_bill_detail_permintaan_obat_master
        LEFT JOIN
    simrs.master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
        LEFT JOIN
    simrs.master_obat d ON c.id_obat = d.id_obat
        LEFT JOIN
    simrs.master_resep e ON a.id_master_resep = e.id_master_resep
WHERE
    b.nomr = $nomr and b.id_bill_detail_tarif < $id_bill_detail_tarif
	and d.nama_obat NOT LIKE '%JASA%' 
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
GROUP BY c.id_obat";
$queryitemobatdikonsumsi = mysql_query($sqlitemobatdikonsumsi);


$sqlitemdokter="SELECT 
    b.pd_nickname,b.no_surat_izin_praktek,b.signature
FROM
    simrs.bill_detail_keterangan a
        LEFT JOIN
    simrs.master_login b ON a.username_dokter = b.username
    where a.id_bill_detail_tarif=$id_bill_detail_tarif";
$queryitemdokter = mysql_query($sqlitemdokter);
$DATADOKTER = mysql_fetch_array($queryitemdokter);

$sqlitemperawat="SELECT 
    b.pd_nickname,b.no_surat_izin_praktek,b.signature
FROM
    simrs.bill_detail_keterangan a
        LEFT JOIN
    simrs.master_login b ON a.username_perawat = b.username
    where a.id_bill_detail_tarif=$id_bill_detail_tarif";
$queryitemperawat = mysql_query($sqlitemperawat);
$DATAPERAWAT = mysql_fetch_array($queryitemperawat);


$sqlitemusername="SELECT
	a.userlevelid
FROM
	simrs.bill_detail_tarif a
		LEFT JOIN
	simrs2012.m_pasien b ON a.nomr = b.nomr
		LEFT JOIN
	simrs.userlevels c ON a.userlevelid = c.userlevelid
WHERE a.id_bill_detail_tarif = '$id_bill_detail_tarif'";
$queryitemusername = mysql_query($sqlitemusername);
$DATA_IDENTITAS = mysql_fetch_array($queryitemusername);


?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>FORM ASSESEMENT AWAL</title>
<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
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
	font-size: 10px;
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
      <td width="33%" style="font-size: 12px"><p align="center"><strong>ASSASEMEN RAWAT JALAN <br> <?php echo $DATAISI['userlevelname']; ?></strong><br>
      <strong></strong></p></td>
      <td width="33%" valign="middle" style="font-weight: bold"><table width="100%" style="font-size: 11px" border="0">
        <tbody>
          <tr>
            <td width="27%">NO RM</td>
            <td width="4%">:</td>
            <td width="69%"><?php echo $DATAISI['nomr']; ?></td>
          </tr>
          <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?php echo $DATAISI['nama']; ?></td>
          </tr>
          <tr>
            <td>Tgl Lahir</td>
            <td>:</td>
            <td><?php echo $DATAISI['tgllahir']; ?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>

	<table width="100%" class="isi" border="0">
  <tbody>
    <tr>
      <td colspan="2">Tanggal Pemeriksaan</td>
      <td width="2%">&nbsp;</td>
      <td colspan="4"><?php echo $DATAISI['tanggal_anamnesa']; ?></td>
    </tr>
    <tr>
      <td width="4%"><strong>I.</strong></td>
      <td width="22%"><strong>Subjektif</strong></td>
      <td>&nbsp;</td>
      <td width="26%">&nbsp;</td>
      <td width="25%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="20%">&nbsp;</td>
    </tr>
    <tr>
      <td>1.</td>
      <td>Cara Pasien Datang</td>
      <td>:</td>
      <td colspan="2"><?php echo $DATAISI['caradatang']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>2.</td>
      <td>Informasi Dari</td>
      <td>:</td>
      <td colspan="4"><?php echo $DATAISI['informasi_dari']; ?></td>
    </tr>
    <tr>
      <td>3.</td>
      <td>Anamnesa</td>
      <td>:</td>
      <td colspan="4"><?php echo $DATAISI['anamnesa']; ?></td>
    </tr>
	  
	<?php
	$unit = $DATA_IDENTITAS['userlevelid'];
	if($unit=="2"){
		$statuspolianak="none";
		$statuspolibidan="inline";
	}
	else if($unit=="3"){
		$statuspolianak="inline";
		$statuspolibidan="none";
	}
	else{
		$statuspolianak="none";
		$statuspolibidan="none";
	  }
	?>
	  
    <tr>
	    <td>&nbsp;</td>
	    <td colspan="6">
		<div style="display: <?php echo $statuspolianak; ?>">	
		<table width="100%" border="0">
	      <tbody>
				<tr>
				  <td width="23%">Riwayat Tumbuh Kembang</td>
				  <td width="1%">:</td>
				  <td width="28%"><?php echo $DATAISI['riwayat_tumbuh_kembang']; ?></td>
				  <td width="27%">Riwayat Makanan</td>
				  <td width="1%">:</td>
				  <td width="20%"><?php echo $DATAISI['riwayat_makanan']; ?></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Riwayat Imunisasi</td>
				  <td>:</td>
				  <td><?php echo $DATAISI['riwayat_imunisasi']; ?></td>
				</tr>
          </tbody>
        </table>
			</div>
		</td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td colspan="6">
	<div style="display: <?php echo $statuspolibidan; ?>">	  
	<table width="100%" border="0">
        <tbody>
			<tr>
			  <td width="23%">Tanda-tanda inpartu</td>
			  <td width="2%">:</td>
			  <td width="28%"><?php echo $DATAISI['tanda_inpartu']; ?></td>
			  <td width="26%">&nbsp;</td>
			  <td width="1%">&nbsp;</td>
			  <td width="20%">&nbsp;</td>
			</tr>
			<tr>
			  <td>Gerak Janin</td>
			  <td>:</td>
			  <td><?php echo $DATAISI['gerak_janin']; ?></td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td>BAB/BAK</td>
			  <td>:</td>
			  <td><?php echo $DATAISI['bab']; ?></td>
			  <td>HPL</td>
			  <td>:</td>
			  <td><?php echo $DATAISI['hpl']; ?></td>
			</tr>
			<tr>
			  <td>HPHT</td>
			  <td>:</td>
			  <td><?php echo $DATAISI['hpht']; ?></td>
			  <td>Umur Kehamilan</td>
			  <td>:</td>
			  <td><?php echo $DATAISI['umur_kehamilan']; ?></td>
			</tr>
			<tr>
			  <td>Riwayat Persalinan</td>
			  <td>:</td>
			  <td><?php echo $DATAISI['riwayat_persalinan']; ?></td>
			  <td>Riwayat KB</td>
			  <td>:</td>
			  <td><?php echo $DATAISI['riwayat_kb']; ?></td>
			</tr>
        </tbody>
      </table>
	</div>
		</td>
    </tr>
    
		
    <tr>
      <td>4.</td>
      <td>Penyakit Dahulu</td>
      <td>:</td>
      <td colspan="4"><?php echo $DATAISI['riwayat_terdahulu']; ?></td>
    </tr>
    <tr>
      <td>5.</td>
      <td>Riwayat Alergi</td>
      <td>:</td>
      <td colspan="4"><?php echo $DATAISI['alergi']; ?></td>
    </tr>
    <tr>
      <td>6.</td>
      <td>Riwayat Penyakit Keluarga</td>
      <td>:</td>
      <td colspan="4"><?php echo $DATAISI['riwayat_keluarga']; ?></td>
    </tr>
    <tr>
      <td>7.</td>
      <td>Riwayat Sosial dan Ekonomi</td>
      <td>:</td>
      <td colspan="4"><?php echo $DATAISI['riwayat_sosial']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tempat Tinggal</td>
      <td>:</td>
      <td colspan="4"><?php echo $DATAISI['tempat_tinggal']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Kerabat Terdekat</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Nama</td>
      <td>&nbsp;</td>
      <td><?php echo $DATAISI['PENANGGUNGJAWAB_NAMA']; ?></td>
      <td>Telepon</td>
      <td>&nbsp;</td>
      <td><?php echo $DATAISI['PENANGGUNGJAWAB_PHONE']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Hubungan</td>
      <td>&nbsp;</td>
      <td><?php echo $DATAISI['PENANGGUNGJAWAB_HUBUNGAN']; ?></td>
      <td>Pekerjaan</td>
      <td>&nbsp;</td>
      <td><?php echo $DATAISI['PEKERJAAN']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>8.</td>
      <td>Kebutuhan Edukasi</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Terdapat hambatan dalam pembelajaran</td>
      <td>&nbsp;</td>
      <td><?php echo $DATAISI['edukasi_hambatan']; ?></td>
      <td>Bahasa yang dipakai</td>
      <td>&nbsp;</td>
      <td><?php echo $DATAISI['bahasa_harian']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Nilai-nilai/Kepercayaan yang di anut</td>
      <td>&nbsp;</td>
      <td><?php echo $DATAISI['edukasi_kepercayaan_dianut']; ?></td>
      <td>Butuh penerjemah</td>
      <td>&nbsp;</td>
      <td><?php echo $DATAISI['edukasi_penerjemah']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Kebutuhan pembelajaran pasien</td>
      <td>&nbsp;</td>
      <td><?php echo $DATAISI['edukasi_pembelajaran']; ?></td>
      <td>Ketersediaan pasien/keluarga menerima informasi yang diberikan</td>
      <td>&nbsp;</td>
      <td><?php echo $DATAISI['edukasi_informasi_diberikan']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>9.</td>
      <td>Skala Nyeri</td>
      <td>:</td>
      <td colspan="4"><?php echo $DATAISI['skala_nyeri']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Perencanaan Tindakan</td>
      <td>:</td>
      <td colspan="4"><?php echo $DATAISI['perencanaan_tindakan']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>10</td>
      <td>Resiko Jatuh</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="6"><table width="100%" class="tabel" border="1">
        <tbody>
          <tr>
            <td width="5%" align="center">No</td>
            <td width="80%" align="center">Penilaian/Pengkajian</td>
            <td width="15%" align="center">Skor</td>
            </tr>
          <tr>
            <td align="center">1</td>
            <td>Tidak seimbang / Sempoyongan / Limbung</td>
            <td rowspan="2" align="center"><?php echo $DATAISI['skor_resiko_jatuh_berdiri']; ?></td>
            </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td>Jalan dengan menggunakan alat bantu</td>
            </tr>
          <tr>
            <td align="center">2</td>
            <td>Menopang pada saat akan duduk (tampak memegang pinggiran kursi atau meja/benda lain sebagai  penopang  saat duduk</td>
            <td align="center"><?php echo $DATAISI['skor_resiko_jatuh_duduk']; ?></td>
            </tr>
          <tr>
            <td colspan="2" align="center">TOTAL SKOR</td>
            <td align="center"><?php echo $DATAISI['skor_resiko_jatuh_berdiri']+$DATAISI['skor_resiko_jatuh_duduk']; ?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Interpretasi Skor :</td>
      <td colspan="2">Tidak beresiko : 0</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">Bresiko rendah : 1</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">Bresiko tinggi : 2-3</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">Bila beresiko tinggi pasang <strong><em>pita penanda warna kuning</em></strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Status Fungsional</td>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Aktivitas dan mobilisasi</td>
      <td colspan="3">: <?php echo $DATAISI['status_fungsional']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="6"><strong>Bila terdapat gangguan fungsional, pasien dikonsul ke Rehabilitasi medis melalui DPJP</strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>11</td>
      <td colspan="6">Skrining Gizi Menurut SNST</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="6">
		
		<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="4%" rowspan="2" align="center">No.</td>
      <td width="27%" rowspan="2">Variabel</td>
      <td width="56%" rowspan="2">Pertanyaan</td>
      <td width="13%" align="center">Skor</td>
    </tr>
    <tr>
      <td align="center">YA=1, TIDAK=0</td>
    </tr>
    <tr>
      <td align="center">1.</td>
      <td>Kondisi Pasien Sekarang apakah pasien</td>
      <td>Apakah pasien terlihat kurus</td>
      <td align="center"><?php echo $DATAISI['gizi_terlihat_kurus']; ?></td>
    </tr>
    <tr>
      <td rowspan="2" align="center">2.</td>
      <td rowspan="2">Penurunan Berat Badan</td>
      <td>Apakah pakaian anda terasa lebih longgar</td>
      <td align="center"><?php echo $DATAISI['gizi_pakaian_terlihat_longgar']; ?></td>
    </tr>
    <tr>
      <td>Apakah akhir-akhir ini kehilangan berat badan yang tidak sengaja (3-6 bln terakhir)</td>
      <td align="center"><?php echo $DATAISI['gizi_kehilangan_bb']; ?></td>
    </tr>
    <tr>
      <td align="center">3.</td>
      <td>Penurunan Asupan Makanan</td>
      <td>Apakah anda mengalami penurunan asupan makanan selama satu minggu terakhir</td>
      <td align="center"><?php echo $DATAISI['gizi_penurunan_asupan']; ?></td>
    </tr>
    <tr>
      <td rowspan="2" align="center">4.</td>
      <td rowspan="2">Riwayat Penyakit</td>
      <td>Apakah anda merasa lemah loyo dan tidak bertenaga</td>
      <td align="center"><?php echo $DATAISI['gizi_merasa_loyo']; ?></td>
    </tr>
    <tr>
      <td>Apakah anda menderita suatu penyakit yang mengakitbatkan adanya perubahan jumlah atau jenis makanan yang anda makan</td>
      <td align="center"><?php echo $DATAISI['gizi_menderita_penyakit']; ?></td>
    </tr>
    <tr>
      <td colspan="3" align="center">TOTAL SKOR</td>
      <td align="center"><?php echo $hasilskrining = $DATAISI['gizi_menderita_penyakit']+$DATAISI['gizi_merasa_loyo']+$DATAISI['gizi_penurunan_asupan']+$DATAISI['gizi_kehilangan_bb']+$DATAISI['gizi_terlihat_kurus']+$DATAISI['gizi_pakaian_terlihat_longgar']; ?></td>
    </tr>
  </tbody>
</table>
		
		
		</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Interpretasi </td>
      <td>&nbsp;</td>
      <td>0 - 2 Tidak beresiko malnutrisi</td>
      <td>3-6 Resiko malnutrisi</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Hasil berisiko malnutrisi</td>
      <td>&nbsp;</td>
      <td colspan="4"><?php 
		  if($hasilskrining >= 0 && $hasilskrining <= 2){
			  echo "<strong>Tidak Bersiko</strong>";
		  }else{
			  echo "<strong>Bersiko</strong>";
		  } 
		  ?>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>12.</td>
      <td colspan="6">Daftar Obat yang dikonsumsi</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="6"><table width="100%" class="tabel" border="1">
        <tbody>
          <tr>
            <td width="3%">NO</td>
            <td width="40%">Nama Obat</td>
            <td width="35%">Dosis</td>
            <td width="22%">Keterangan (lanjut/berhenti)</td>
            </tr>
			<?php
				$no=1;
				while($data=mysql_fetch_assoc($queryitemobatdikonsumsi)){
				echo '<tr>';
				echo '<td>'.$no.'</td>';
				echo '<td>'.$data['nama_obat'].'</td>';
				echo '<td>'.$data['nama_resep'].'</td>';
				echo '<td></td>';
				echo '</tr>';
				$no++;
				}
			?>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="7">&nbsp;</td>
    </tr>
    <tr>
      <td><strong>II.</strong></td>
      <td><strong>Objektif</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Pemeriksaan Fisik</td>
      <td>:</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tekanan Darah</td>
      <td>:</td>
      <td><?php echo $DATAISI['tekanan_darah']; ?> mm Hg</td>
      <td>Nadi</td>
      <td>:</td>
      <td><?php echo $DATAISI['heart_rate']; ?> Permenit</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Respirasi</td>
      <td>:</td>
      <td><?php echo $DATAISI['respiration_rate']; ?> Permenit</td>
      <td>Suhu</td>
      <td>:</td>
      <td><?php echo $DATAISI['suhu_badan']; ?> Derajat Celcius</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Berat Badan</td>
      <td>:</td>
      <td><?php echo $DATAISI['berat_badan']; ?> KG</td>
      <td>Status Psikologi</td>
      <td>:</td>
      <td><?php echo $DATAISI['psikologi']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tinggi Badan</td>
      <td>:</td>
      <td><?php echo $DATAISI['tinggi_badan']; ?> CM</td>
      <td>Status Mental</td>
      <td>:</td>
      <td><?php echo $DATAISI['mental']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Lingkar Kepala</td>
      <td>:</td>
      <td><?php echo $DATAISI['lingkar_kepala']; ?> CM</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="6">
		  
<?php
	$unit1 = $DATA_IDENTITAS['userlevelid'];
	if($unit1=="1" || $unit1=="30" || $unit1=="3"){
		$statusdalam="inline";
		$statusbidan="none";
		$statusmata="none";
		$statusgigi="none";
		$statussaraf="none";
		$statusjiwa="none";
	}
	else if($unit1=="2"){
		$statusbidan="inline";
		$statusdalam="inline";
		$statusmata="none";
		$statusgigi="none";
		$statussaraf="none";
		$statusjiwa="none";
	}
	else if($unit1=="29"){
		$statusmata="inline";
		$statusdalam="none";
		$statusbidan="none";
		$statusgigi="none";
		$statussaraf="none";
		$statusjiwa="none";
	}
	else if($unit1=="5"){
		$statusgigi="inline";
		$statusmata="none";
		$statusdalam="none";
		$statusbidan="none";
		$statussaraf="none";
		$statusjiwa="none";
	}
	else if($unit1=="7"){
		$statussaraf="inline";
		$statusgigi="none";
		$statusmata="none";
		$statusdalam="none";
		$statusbidan="none";
		$statusjiwa="none";
	}
	else if($unit1=="6"){
		$statusjiwa="inline";
		$statussaraf="none";
		$statusgigi="none";
		$statusmata="none";
		$statusdalam="none";
		$statusbidan="none";
	}
	else{
		$statusdalam="inline";
		$statusbidan="none";
		$statusmata="none";
		$statusgigi="none";
		$statussaraf="none";
		$statusjiwa="none";
	}
?>
		  
		  
<div style="display: <?php echo $statusdalam; ?>">	
	<table width="100%" class="tabel" border="0">
        <tbody>
          <tr>
            <td width="23%">Kepala</td>
            <td width="77%">: <?php echo $DATAOBJEKTIF['obj_kepala']; ?></td>
          </tr>
          <tr>
            <td>Leher</td>
            <td>: <?php echo $DATAOBJEKTIF['obj_leher']; ?></td>
          </tr>
          <tr>
            <td>Thorax</td>
            <td>: <?php echo $DATAOBJEKTIF['obj_thorax']; ?></td>
          </tr>
          <tr>
            <td>Abdomen</td>
            <td>: <?php echo $DATAOBJEKTIF['obj_abdomen']; ?></td>
          </tr>
          <tr>
            <td>Anogenital</td>
            <td>: <?php echo $DATAOBJEKTIF['obj_anogenital']; ?></td>
          </tr>
          <tr>
            <td>Esktremitas</td>
            <td>: <?php echo $DATAOBJEKTIF['obj_ekstremitas']; ?></td>
          </tr>
          </tbody>
    </table>	  
</div>
		  
		  
		  
<div style="display: <?php echo $statusjiwa; ?>">
	<table width="100%" class="tabel" border="0">
        <tbody>
          <tr>
            <td width="23%">Pemeriksaan Psikiatri</td>
            <td width="77%">:</td>
          </tr>
          <tr>
            <td>Perilaku</td>
            <td>: <?php echo $DATAOBJEKTIF['jiwa_perilaku']; ?></td>
          </tr>
          <tr>
            <td>Alam Perasaan</td>
            <td>: <?php echo $DATAOBJEKTIF['jiwa_alam_perasaan']; ?></td>
          </tr>
          <tr>
            <td>Gangguan Proses Mikir</td>
            <td>: <?php echo $DATAOBJEKTIF['jiwa_gangguan_persepsi']; ?></td>
          </tr>
          <tr>
            <td>Gangguan Persepsi</td>
            <td>: <?php echo $DATAOBJEKTIF['jiwa_gangguan_persepsi']; ?></td>
          </tr>
          <tr>
            <td>Insight</td>
            <td>: <?php echo $DATAOBJEKTIF['jiwa_insight']; ?></td>
          </tr>
          </tbody>
    </table>	  
</div>
		  
<div style="display: <?php echo $statusgigi; ?>">
	<table width="100%" class="tabel" border="0">
        <tbody>
          <tr>
            <td width="23%">Pemeriksaan Ekstra Oral</td>
            <td width="77%">: <?php echo $DATAOBJEKTIF['gigi_ekstra_oral']; ?></td>
          </tr>
          <tr>
            <td>Pemeriksaan Intra Oral</td>
            <td>: <?php echo $DATAOBJEKTIF['gigi_intra_oral']; ?></td>
          </tr>
          <tr>
            <td>Jaringan Lunak</td>
            <td>: <?php echo $DATAOBJEKTIF['gigi_jaringan_lunak']; ?></td>
          </tr>
          <tr>
            <td>Jaringan Keras</td>
            <td>: <?php echo $DATAOBJEKTIF['gigi_jaringan_keras']; ?></td>
          </tr>
          <tr>
            <td>Gigi Geligi</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><table width="100%" border="0">
  <tbody>
    <tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">V</td>
      <td align="center">IV</td>
      <td align="center">III</td>
      <td align="center">II</td>
      <td align="center">I</td>
      <td rowspan="2" align="center"><span class="vertical-line"></span></td>
      <td align="center">I</td>
      <td align="center">II</td>
      <td align="center">III</td>
      <td align="center">IV</td>
      <td align="center">V</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      </tr>
    <tr>
      <td align="center">8</td>
      <td align="center">7</td>
      <td align="center">6</td>
      <td align="center">5</td>
      <td align="center">4</td>
      <td align="center">3</td>
      <td align="center">2</td>
      <td align="center">1</td>
      <td align="center">1</td>
      <td align="center">2</td>
      <td align="center">3</td>
      <td align="center">4</td>
      <td align="center">5</td>
      <td align="center">6</td>
      <td align="center">7</td>
      <td align="center">8</td>
      </tr>
    <tr>
      <td colspan="17" align="center"><hr></td>
      </tr>
    <tr>
      <td align="center">8</td>
      <td align="center">7</td>
      <td align="center">6</td>
      <td align="center">5</td>
      <td align="center">4</td>
      <td align="center">3</td>
      <td align="center">2</td>
      <td align="center">1</td>
      <td rowspan="2" align="center"><span class="vertical-line"></span></td>
      <td align="center">1</td>
      <td align="center">2</td>
      <td align="center">3</td>
      <td align="center">4</td>
      <td align="center">5</td>
      <td align="center">6</td>
      <td align="center">7</td>
      <td align="center">8</td>
      </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">V</td>
      <td align="center">IV</td>
      <td align="center">III</td>
      <td align="center">II</td>
      <td align="center">I</td>
      <td align="center">I</td>
      <td align="center">II</td>
      <td align="center">III</td>
      <td align="center">IV</td>
      <td align="center">V</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      </tr>
  </tbody>
</table>
</td>
            </tr>
          </tbody>
    </table>	  
</div>
		  
		  
		  
<div style="display: <?php echo $statusbidan; ?>">
	<table width="100%" class="tabel" border="0">
        <tbody>
          <tr>
            <td width="23%">Status Obstetri</td>
            <td width="77%">: <?php echo $DATAOBJEKTIF['bidan_status_obstetri']; ?></td>
          </tr>
          <tr>
            <td>Tinggi Fundus Uteri</td>
            <td>: <?php echo $DATAOBJEKTIF['bidan_fundus_uteri']; ?></td>
          </tr>
          <tr>
            <td>Denyut Jantung Janin</td>
            <td>: <?php echo $DATAOBJEKTIF['bidan_denyut_janin']; ?></td>
          </tr>
          <tr>
            <td>Vaginal Toucher</td>
            <td>: <?php echo $DATAOBJEKTIF['bidan_vaginal_toucher']; ?></td>
          </tr>
          <tr>
            <td>Letak Janin</td>
            <td>: <?php echo $DATAOBJEKTIF['bidan_letak_janin']; ?></td>
          </tr>
          <tr>
            <td>His</td>
            <td>: <?php echo $DATAOBJEKTIF['bidan_his']; ?></td>
          </tr>
          </tbody>
    </table>	  
</div>
		  
	
		  
<div style="display: <?php echo $statussaraf; ?>">
	<table width="100%" class="tabel" border="0">
        <tbody>
          <tr>
            <td width="23%">MeningealSign</td>
            <td width="77%">: <?php echo $DATAOBJEKTIF['saraf_meningealsign']; ?></td>
          </tr>
          <tr>
            <td>Nervus Cranialis</td>
            <td>: <?php echo $DATAOBJEKTIF['saraf_nervus_cranialis']; ?></td>
          </tr>
          <tr>
            <td>Sistem Saraf Motorik</td>
            <td>: <?php echo $DATAOBJEKTIF['saraf_motorik']; ?></td>
          </tr>
          <tr>
            <td>Sistem Saraf Sensorik</td>
            <td>: <?php echo $DATAOBJEKTIF['saraf_sensorik']; ?></td>
          </tr>
          <tr>
            <td>Sistem Saraf Otonom</td>
            <td>: <?php echo $DATAOBJEKTIF['saraf_otonom']; ?></td>
          </tr>
          </tbody>
    </table>	  
</div>
		  
		  
		  
<div style="display: <?php echo $statusmata; ?>">
	<table width="100%" class="tabel" border="0">
        <tbody>
          <tr>
            <td width="20%">Visus Dasar OD</td>
            <td colspan="2">: <?php echo $DATAOBJEKTIF['mata_visus_dasar_od']; ?></td>
            </tr>
          <tr>
            <td>Visus Dasar OS</td>
            <td colspan="2">: <?php echo $DATAOBJEKTIF['mata_visus_dasar_os']; ?></td>
          </tr>
          <tr>
            <td>Visus Koreksi OD</td>
            <td colspan="2">: <?php echo $DATAOBJEKTIF['mata_visus_koreksi_od']; ?></td>
            </tr>
          <tr>
            <td>Visus Koreksi OS</td>
            <td colspan="2">: <?php echo $DATAOBJEKTIF['mata_visus_koreksi_os']; ?></td>
          </tr>
          <tr>
            <td>Tekanan Intraokuler OD</td>
            <td colspan="2">: <?php echo $DATAOBJEKTIF['mata_tekanan_intraokuler_od']; ?></td>
          </tr>
          <tr>
            <td>Tekanan Intraokuler OS</td>
            <td colspan="2">: <?php echo $DATAOBJEKTIF['mata_tekanan_intraokuler_os']; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="26%" align="center">&nbsp;</td>
            <td width="31%">&nbsp;</td>
          </tr>
          <tr>
            <td align="center">OD</td>
            <td align="center">&nbsp;</td>
            <td align="center">OS</td>
          </tr>
          <tr>
            <td align="right"><?php echo $DATAOBJEKTIF['mata_palpebra_od']; ?></td>
            <td align="center">Palbera</td>
            <td align="left"><?php echo $DATAOBJEKTIF['mata_palpebra_os']; ?></td>
          </tr>
          <tr>
            <td align="right"><?php echo $DATAOBJEKTIF['mata_konjungtiva_od']; ?></td>
            <td align="center">Konjungtiva</td>
            <td align="left"><?php echo $DATAOBJEKTIF['mata_konjungtiva_os']; ?></td>
          </tr>
          <tr>
            <td align="right"><?php echo $DATAOBJEKTIF['mata_kornea_od']; ?></td>
            <td align="center">Kornea</td>
            <td align="left"><?php echo $DATAOBJEKTIF['mata_kornea_os']; ?></td>
          </tr>
          <tr>
            <td align="right"><?php echo $DATAOBJEKTIF['mata_coa_od']; ?></td>
            <td align="center">COA</td>
            <td align="left"><?php echo $DATAOBJEKTIF['mata_coa_os']; ?></td>
          </tr>
          <tr>
            <td align="right"><?php echo $DATAOBJEKTIF['mata_pupil_od']; ?></td>
            <td align="center">Pupil</td>
            <td align="left"><?php echo $DATAOBJEKTIF['mata_pupil_os']; ?></td>
          </tr>
          <tr>
            <td align="right"><?php echo $DATAOBJEKTIF['mata_iris_od']; ?></td>
            <td align="center">Iris</td>
            <td align="left"><?php echo $DATAOBJEKTIF['mata_iris_os']; ?></td>
          </tr>
          <tr>
            <td align="right"><?php echo $DATAOBJEKTIF['mata_lensa_od']; ?></td>
            <td align="center">Lensa</td>
            <td align="left"><?php echo $DATAOBJEKTIF['mata_lensa_os']; ?></td>
          </tr>
          <tr>
            <td align="right"><?php echo $DATAOBJEKTIF['mata_fundus_od']; ?></td>
            <td align="center">Fundus Reflex</td>
            <td align="left"><?php echo $DATAOBJEKTIF['mata_fundus_os']; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Status Oftalmologi Khusus</td>
            <td colspan="2"></td>
            </tr>
          <tr>
            <td>Corpus Vietrum</td>
            <td colspan="2">: <?php echo $DATAOBJEKTIF['mata_corpus_vitreum_od']; ?></td>
            </tr>
		<tr>
		  <td align="right"><?php echo $DATAOBJEKTIF['mata_funduskopi_od']; ?></td>
		  <td align="center">Funduskopi</td>
		  <td align="left"><?php echo $DATAOBJEKTIF['mata_funduskopi_os']; ?></td>
		  </tr>
          </tbody>
    </table>	  
</div>
		  
		  
		  
		
		</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Kelainan</td>
      <td>:</td>
      <td colspan="4"><?php echo $DATAOBJEKTIF['kelainan']; ?></td>
    </tr>
    <tr>
         <td>&nbsp;</td>
         <td valign="top">Status Lokalis</td>
         <td>:</td>
         <td colspan="4"><?php echo $DATAOBJEKTIF['obj_status_lokalis']; ?></td>
    </tr>
	  
	  <?php
	  		$sqlitempemeriksaan="SELECT 
    unit,
    CASE
        WHEN dokumen = 'Ada' THEN 'Ada, terlampir di rekam medis'
        WHEN dokumen = 'Tidak ada' THEN 'Tidak ada'
    END AS dokumen
FROM
    (SELECT 
        'Laboratorium' AS unit, IFNULL(penj_lab, 'Tidak ada') AS dokumen
    FROM
        simrs.bill_detail_keterangan
    WHERE
        id_bill_detail_tarif = 164078 UNION ALL SELECT 
        'Radiologi', IFNULL(penj_rad, 'Tidak ada') AS dokumen
    FROM
        simrs.bill_detail_keterangan
    WHERE
        id_bill_detail_tarif = 164078 UNION ALL SELECT 
        'EKG', IFNULL(penj_ekg, 'Tidak ada') AS dokumen
    FROM
        simrs.bill_detail_keterangan
    WHERE
        id_bill_detail_tarif = 164078 UNION ALL SELECT 
        'USG', IFNULL(penj_usg, 'Tidak ada') AS dokumen
    FROM
        simrs.bill_detail_keterangan
    WHERE
        id_bill_detail_tarif = 164078 UNION ALL SELECT 
        'Endescopy', IFNULL(penj_endescopy, 'Tidak ada') AS dokumen
    FROM
        simrs.bill_detail_keterangan
    WHERE
        id_bill_detail_tarif = $id_bill_detail_tarif) s;";
	  		$queryitempemeriksaan = mysql_query($sqlitempemeriksaan);
	  ?>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">Pemeriksaan Penunjang</td>
      <td>&nbsp;</td>
      <td colspan="4">
		<table width="100%" border="0">
        <tbody>
          <?php
				while($data=mysql_fetch_assoc($queryitempemeriksaan)){
				echo '<tr>';
				echo '<td width="24%">'.$data['unit'].'</td>';
				echo '<td width="76%">: '.$data['dokumen'].'</td>';
				echo '</tr>';
				}
			?>
        </tbody>
      </table>
	 </td>
    </tr>
	  
	 

    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>III.</strong></td>
      <td><strong>Assesmen</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Diagnosa Primer</td>
      <td>:</td>
      <td colspan="4"><?php echo $DATADIAGNOSAPRIMER['diagnosa']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Diagnosa Sekunder</td>
      <td>:</td>
      <td colspan="4"><?php echo $DATADIAGNOSASEKUNDER['diagnosa']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>IV.</strong></td>
      <td><strong>Penatalaksanaan</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>1. Terapi</td>
      <td>:</td>
      <td colspan="4"><?php echo $DATAOBAT['obat']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>2. Rencana Tindakan</td>
      <td>:</td>
      <td colspan="4"><?php echo $DATATINDAKAN['tindakan']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td colspan="4" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">3. Pemeriksaan Penunjang</td>
      <td valign="top">:</td>
      <td colspan="4" valign="top"><table width="100%" class="tabel" border="1">
        <tbody>
          <tr>
            <td width="21%">Penunjang</td>
            <td width="79%">Pemeriksaan</td>
          </tr>
          <?php
				while($data=mysql_fetch_assoc($queryitempenunjang)){
				echo '<tr>';
				echo '<td>'.$data['userlevelname'].'</td>';
				echo '<td>'.$data['nama_order'].'</td>';
				echo '</tr>';
				}
			?>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>4. Rujuk</td>
      <td>:</td>
      <td colspan="4"><?php echo $DATAISI['rujuk']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>5. Konsul</td>
      <td>:</td>
      <td colspan="4"><?php echo $DATAISI['konsul']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="7"><table width="100%" border="0">
        <tbody>
          <tr>
            <td width="25%" align="center">&nbsp;</td>
            <td width="31%" align="center">Nama &amp; TTD Perawat Pengkaji</td>
            <td width="14%" align="center">&nbsp;</td>
            <td width="30%" align="center">Nama &amp; TTD Dokter Pemeriksa</td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td rowspan="3" align="center"><img src="../../uploads/<?php echo $DATAPERAWAT['signature']; ?>" height="70px" width="70px" /></td>
            <td align="center">&nbsp;</td>
            <td rowspan="3" align="center"><img src="../../uploads/<?php echo $DATADOKTER['signature']; ?>" width="70px" height="70px" /></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center"><u><?php echo $DATAPERAWAT['pd_nickname']; ?></u> <br><?php echo $DATAPERAWAT['no_surat_izin_praktek']; ?></td>
            <td align="center">&nbsp;</td>
            <td align="center"><u><?php echo $DATADOKTER['pd_nickname']; ?></u> <br><?php echo $DATADOKTER['no_surat_izin_praktek']; ?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>

	    
	
<div style="font-size: 9px; font-style: oblique">Terima kasih atas kerjasamanya telah mengisi formulir ini dengan jelas dan benar.</div> 
<div style="font-size: 9px; font-style: oblique">SIMRS VERSI 2.0 RSUD Ajibarang</div> 

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
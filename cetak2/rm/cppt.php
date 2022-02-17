<?php
ob_start();
session_start();
include('../connect.php');
$nomr = $_GET['nomr'];

$sqlitemanamnesa="SELECT 
    b.nomr,
    d.nama,
    DATE_FORMAT(d.tgllahir, '%d-%m-%Y') AS tgllahir,
    DATE_FORMAT(a.tanggal_anamnesa, '%d-%m-%Y %H:%i:%s') AS tanggal_anamnesa,
    CONCAT('<center>',
            IFNULL(i.nama_profesi, ''),
            '<br>',
            IFNULL(j.nama_master_profesi_sub, ''),
            '</center>') AS profesi,
    CONCAT('<strong>S</strong> : ',
            ifnull(a.anamnesa,''),
            '<br><br>',
            '<strong>O</strong> : ',
            ifnull(a.tekanan_darah,''),
            'mm Hg ',
            ' nadi : ',
            ifnull(a.heart_rate,''),
            ' permenit,',
            ' respirasi : ',
            ifnull(a.respiration_rate,''),
            ' permenit,',
            ' bb : ',
            ifnull(a.berat_badan,''),
            ' kg,',
            ' suhu : ',
            ifnull(a.suhu_badan,''),
            ' derajat C, ',
            CASE
                WHEN obj_kepala IS NULL THEN ''
                WHEN obj_kepala = 'Dalam Batas Normal' THEN 'Kepala : Dalam Batas Normal, '
                WHEN obj_kepala = 'dbn' THEN 'Kepala : Dalam Batas Normal, '
                ELSE 'Kepala : Ada Kelainan, '
            END,
            CASE
                WHEN obj_leher IS NULL THEN ''
                WHEN obj_leher = 'Dalam Batas Normal' THEN 'Leher : Dalam Batas Normal '
                WHEN obj_leher = 'dbn' THEN 'Leher : Dalam Batas Normal, '
                ELSE 'Leher : Ada Kelainan '
            END,
            CASE
                WHEN obj_thorax IS NULL THEN ''
                WHEN obj_thorax = 'Dalam Batas Normal' THEN 'Thorax : Dalam Batas Normal '
                WHEN obj_thorax = 'dbn' THEN 'Thorax : Dalam Batas Normal, '
                ELSE 'Thorax : Ada Kelainan '
            END,
            CASE
                WHEN obj_abdomen IS NULL THEN ''
                WHEN obj_abdomen = 'Dalam Batas Normal' THEN 'Abdomen : Dalam Batas Normal '
                WHEN obj_abdomen = 'dbn' THEN 'Abdomen : Dalam Batas Normal, '
                ELSE 'Abdomen : Ada Kelainan '
            END,
            CASE
                WHEN obj_anogenital IS NULL THEN ''
                WHEN obj_anogenital = 'Dalam Batas Normal' THEN 'Anogenital : Dalam Batas Normal '
                WHEN obj_anogenital = 'dbn' THEN 'Anogenital : Dalam Batas Normal, '
                ELSE 'Anogenital : Ada Kelainan '
            END,
            CASE
                WHEN obj_ekstremitas IS NULL THEN ''
                WHEN obj_ekstremitas = 'Dalam Batas Normal' THEN 'Ekstremitas : Dalam Batas Normal '
                WHEN obj_ekstremitas = 'dbn' THEN 'Ekstremitas : Dalam Batas Normal, '
                ELSE 'Ekstremitas : Ada Kelainan '
            END,
            CASE
                WHEN
                    penj_lab IS NULL
                        OR penj_lab = 'Tidak Ada'
                THEN
                    ''
                WHEN penj_lab = 'Ada' THEN 'Laboratorium : Ada, Terlampir di Rekam Medis, '
            END,
            CASE
                WHEN
                    penj_rad IS NULL
                        OR penj_rad = 'Tidak Ada'
                THEN
                    ''
                WHEN penj_rad = 'Ada' THEN 'Radiologi : Ada, Terlampir di Rekam Medis, '
            END,
            CASE
                WHEN
                    penj_ekg IS NULL
                        OR penj_ekg = 'Tidak Ada'
                THEN
                    ''
                WHEN penj_ekg = 'Ada' THEN 'EKG : Ada, Terlampir di Rekam Medis, '
            END,
            CASE
                WHEN
                    penj_usg IS NULL
                        OR penj_usg = 'Tidak Ada'
                THEN
                    ''
                WHEN penj_usg = 'Ada' THEN 'USG : Ada, Terlampir di Rekam Medis, '
            END,
            CASE
                WHEN
                    penj_endescopy IS NULL
                        OR penj_endescopy = 'Tidak Ada'
                THEN
                    ''
                WHEN penj_endescopy = 'Ada' THEN 'Endescopy : Ada, Terlampir di Rekam Medis, '
            END,
            CASE
                WHEN
                    mata_visus_dasar_od IS NULL
                        OR mata_visus_dasar_od = '-'
                THEN
                    ''
                WHEN mata_visus_dasar_od IS NOT NULL THEN CONCAT(mata_visus_dasar_od, ' od,')
            END,
            CASE
                WHEN
                    mata_visus_koreksi_od IS NULL
                        OR mata_visus_koreksi_od = '-'
                THEN
                    ''
                WHEN mata_visus_koreksi_od IS NOT NULL THEN CONCAT(mata_visus_koreksi_od, ' od,')
            END,
            CASE
                WHEN
                    mata_tekanan_intraokuler_od IS NULL
                        OR mata_tekanan_intraokuler_od = '-'
                THEN
                    ''
                WHEN mata_tekanan_intraokuler_od IS NOT NULL THEN CONCAT(mata_tekanan_intraokuler_od, ' od,')
            END,
            CASE
                WHEN
                    mata_palpebra_od IS NULL
                        OR mata_palpebra_od = '-'
                THEN
                    ''
                WHEN mata_palpebra_od IS NOT NULL THEN CONCAT(mata_palpebra_od, ' od,')
            END,
            CASE
                WHEN
                    mata_konjungtiva_od IS NULL
                        OR mata_konjungtiva_od = '-'
                THEN
                    ''
                WHEN mata_konjungtiva_od IS NOT NULL THEN CONCAT(mata_konjungtiva_od, ' od,')
            END,
            CASE
                WHEN
                    mata_kornea_od IS NULL
                        OR mata_kornea_od = '-'
                THEN
                    ''
                WHEN mata_kornea_od IS NOT NULL THEN CONCAT(mata_kornea_od, ' od,')
            END,
            CASE
                WHEN mata_coa_od IS NULL OR mata_coa_od = '-' THEN ''
                WHEN mata_coa_od IS NOT NULL THEN CONCAT(mata_coa_od, ' od,')
            END,
            CASE
                WHEN
                    mata_pupil_od IS NULL
                        OR mata_pupil_od = '-'
                THEN
                    ''
                WHEN mata_pupil_od IS NOT NULL THEN CONCAT(mata_pupil_od, ' od,')
            END,
            CASE
                WHEN
                    mata_iris_od IS NULL
                        OR mata_iris_od = '-'
                THEN
                    ''
                WHEN mata_iris_od IS NOT NULL THEN CONCAT(mata_iris_od, ' od,')
            END,
            CASE
                WHEN
                    mata_lensa_od IS NULL
                        OR mata_lensa_od = '-'
                THEN
                    ''
                WHEN mata_lensa_od IS NOT NULL THEN CONCAT(mata_lensa_od, ' od,')
            END,
            CASE
                WHEN
                    mata_fundus_od IS NULL
                        OR mata_fundus_od = '-'
                THEN
                    ''
                WHEN mata_fundus_od IS NOT NULL THEN CONCAT(mata_fundus_od, ' od,')
            END,
            CASE
                WHEN
                    mata_corpus_vitreum IS NULL
                        OR mata_corpus_vitreum = '-'
                THEN
                    ''
                WHEN mata_corpus_vitreum IS NOT NULL THEN CONCAT(mata_corpus_vitreum, ',')
            END,
            CASE
                WHEN
                    mata_funduskopi_od IS NULL
                        OR mata_funduskopi_od = '-'
                THEN
                    ''
                WHEN mata_funduskopi_od IS NOT NULL THEN CONCAT(mata_funduskopi_od, ' od,')
            END,
            CASE
                WHEN
                    mata_visus_dasar_os IS NULL
                        OR mata_visus_dasar_os = '-'
                THEN
                    ''
                WHEN mata_visus_dasar_os IS NOT NULL THEN CONCAT(mata_visus_dasar_os, ' os,')
            END,
            CASE
                WHEN
                    mata_visus_koreksi_os IS NULL
                        OR mata_visus_koreksi_os = '-'
                THEN
                    ''
                WHEN mata_visus_koreksi_os IS NOT NULL THEN CONCAT(mata_visus_koreksi_os, ' os,')
            END,
            CASE
                WHEN
                    mata_tekanan_intraokuler_os IS NULL
                        OR mata_tekanan_intraokuler_os = '-'
                THEN
                    ''
                WHEN mata_tekanan_intraokuler_os IS NOT NULL THEN CONCAT(mata_tekanan_intraokuler_os, ' os,')
            END,
            CASE
                WHEN
                    mata_palpebra_os IS NULL
                        OR mata_palpebra_os = '-'
                THEN
                    ''
                WHEN mata_palpebra_os IS NOT NULL THEN CONCAT(mata_palpebra_os, ' os,')
            END,
            CASE
                WHEN
                    mata_konjungtiva_os IS NULL
                        OR mata_konjungtiva_os = '-'
                THEN
                    ''
                WHEN mata_konjungtiva_os IS NOT NULL THEN CONCAT(mata_konjungtiva_os, ' os,')
            END,
            CASE
                WHEN
                    mata_kornea_os IS NULL
                        OR mata_kornea_os = '-'
                THEN
                    ''
                WHEN mata_kornea_os IS NOT NULL THEN CONCAT(mata_kornea_os, ' os,')
            END,
            CASE
                WHEN mata_coa_os IS NULL OR mata_coa_os = '-' THEN ''
                WHEN mata_coa_os IS NOT NULL THEN CONCAT(mata_coa_os, ' os,')
            END,
            CASE
                WHEN
                    mata_pupil_os IS NULL
                        OR mata_pupil_os = '-'
                THEN
                    ''
                WHEN mata_pupil_os IS NOT NULL THEN CONCAT(mata_pupil_os, ' os,')
            END,
            CASE
                WHEN
                    mata_iris_os IS NULL
                        OR mata_iris_os = '-'
                THEN
                    ''
                WHEN mata_iris_os IS NOT NULL THEN CONCAT(mata_iris_os, ' os,')
            END,
            CASE
                WHEN
                    mata_lensa_os IS NULL
                        OR mata_lensa_os = '-'
                THEN
                    ''
                WHEN mata_lensa_os IS NOT NULL THEN CONCAT(mata_lensa_os, ' os,')
            END,
            CASE
                WHEN
                    mata_fundus_os IS NULL
                        OR mata_fundus_os = '-'
                THEN
                    ''
                WHEN mata_fundus_os IS NOT NULL THEN CONCAT(mata_fundus_os, ' os,')
            END,
            CASE
                WHEN
                    mata_funduskopi_os IS NULL
                        OR mata_funduskopi_os = '-'
                THEN
                    ''
                WHEN mata_funduskopi_os IS NOT NULL THEN CONCAT(mata_funduskopi_os, ' os,')
            END,
            CASE
                WHEN
                    gigi_ekstra_oral IS NULL
                        OR gigi_ekstra_oral = '-'
                THEN
                    ''
                WHEN gigi_ekstra_oral IS NOT NULL THEN CONCAT(gigi_ekstra_oral, ',')
            END,
            CASE
                WHEN
                    gigi_intra_oral IS NULL
                        OR gigi_intra_oral = '-'
                THEN
                    ''
                WHEN gigi_intra_oral IS NOT NULL THEN CONCAT(gigi_intra_oral, ',')
            END,
            CASE
                WHEN
                    gigi_jaringan_lunak IS NULL
                        OR gigi_jaringan_lunak = '-'
                THEN
                    ''
                WHEN gigi_jaringan_lunak IS NOT NULL THEN CONCAT(gigi_jaringan_lunak, ',')
            END,
            CASE
                WHEN
                    gigi_jaringan_keras IS NULL
                        OR gigi_jaringan_keras = '-'
                THEN
                    ''
                WHEN gigi_jaringan_keras IS NOT NULL THEN CONCAT(gigi_jaringan_keras, ',')
            END,
            CASE
                WHEN
                    jiwa_gangguan_persepsi IS NULL
                        OR jiwa_gangguan_persepsi = '-'
                THEN
                    ''
                WHEN jiwa_gangguan_persepsi IS NOT NULL THEN CONCAT(jiwa_gangguan_persepsi, ',')
            END,
            CASE
                WHEN
                    jiwa_psikiatri IS NULL
                        OR jiwa_psikiatri = '-'
                THEN
                    ''
                WHEN jiwa_psikiatri IS NOT NULL THEN CONCAT(jiwa_psikiatri, ',')
            END,
            CASE
                WHEN
                    jiwa_perilaku IS NULL
                        OR jiwa_perilaku = '-'
                THEN
                    ''
                WHEN jiwa_perilaku IS NOT NULL THEN CONCAT(jiwa_perilaku, ',')
            END,
            CASE
                WHEN
                    jiwa_proses_mikir IS NULL
                        OR jiwa_proses_mikir = '-'
                THEN
                    ''
                WHEN jiwa_proses_mikir IS NOT NULL THEN CONCAT(jiwa_proses_mikir, ',')
            END,
            CASE
                WHEN
                    jiwa_insight IS NULL
                        OR jiwa_insight = '-'
                THEN
                    ''
                WHEN jiwa_insight IS NOT NULL THEN CONCAT(jiwa_insight, ',')
            END,
            CASE
                WHEN
                    saraf_meningealsign IS NULL
                        OR saraf_meningealsign = '-'
                THEN
                    ''
                WHEN saraf_meningealsign IS NOT NULL THEN CONCAT(saraf_meningealsign, ',')
            END,
            CASE
                WHEN
                    saraf_nervus_cranialis IS NULL
                        OR saraf_nervus_cranialis = '-'
                THEN
                    ''
                WHEN saraf_nervus_cranialis IS NOT NULL THEN CONCAT(saraf_nervus_cranialis, ',')
            END,
            CASE
                WHEN
                    saraf_motorik IS NULL
                        OR saraf_motorik = '-'
                THEN
                    ''
                WHEN saraf_motorik IS NOT NULL THEN CONCAT(saraf_motorik, ',')
            END,
            CASE
                WHEN
                    saraf_sensorik IS NULL
                        OR saraf_sensorik = '-'
                THEN
                    ''
                WHEN saraf_sensorik IS NOT NULL THEN CONCAT(saraf_sensorik, ',')
            END,
            CASE
                WHEN
                    saraf_otonom IS NULL
                        OR saraf_otonom = '-'
                THEN
                    ''
                WHEN saraf_otonom IS NOT NULL THEN CONCAT(saraf_otonom, ',')
            END,
            CASE
                WHEN
                    bidan_fundus_uteri IS NULL
                        OR bidan_fundus_uteri = '-'
                THEN
                    ''
                WHEN bidan_fundus_uteri IS NOT NULL THEN CONCAT(bidan_fundus_uteri, ',')
            END,
            CASE
                WHEN
                    bidan_denyut_janin IS NULL
                        OR bidan_denyut_janin = '-'
                THEN
                    ''
                WHEN bidan_denyut_janin IS NOT NULL THEN CONCAT(bidan_denyut_janin, ',')
            END,
            CASE
                WHEN
                    bidan_vaginal_toucher IS NULL
                        OR bidan_vaginal_toucher = '-'
                THEN
                    ''
                WHEN bidan_vaginal_toucher IS NOT NULL THEN CONCAT(bidan_vaginal_toucher, ',')
            END,
            CASE
                WHEN
                    bidan_letak_janin IS NULL
                        OR bidan_letak_janin = '-'
                THEN
                    ''
                WHEN bidan_letak_janin IS NOT NULL THEN CONCAT(bidan_letak_janin, ',')
            END,
            CASE
                WHEN
                    bidan_status_obstetri IS NULL
                        OR bidan_status_obstetri = '-'
                THEN
                    ''
                WHEN bidan_status_obstetri IS NOT NULL THEN CONCAT(bidan_status_obstetri, ',')
            END,
            CASE
                WHEN bidan_his IS NULL OR bidan_his = '-' THEN ''
                WHEN bidan_his IS NOT NULL THEN CONCAT(bidan_his, ',')
            END,
            IFNULL(a.kelainan, ''),
            ',',
            IFNULL(a.obj_status_lokalis, ''),
            '<br><br>',
            '<strong>A</strong> : ',
            ' Diagnosa : ',
            IFNULL((SELECT 
                                GROUP_CONCAT(CONCAT(IFNULL(o.keterangan, ''),
                ', ',
                IFNULL(d.code, ''),
                ':',
                ifnull(d.str,''))
        SEPARATOR ', ') AS diagnosa
                        FROM
                            simrs.bill_detail_penyakit o
                                LEFT JOIN
                            simrs.master_penyakit b ON o.id_penyakit = b.id_master_penyakit
                                LEFT JOIN
                            simrs.bill_detail_tarif c ON o.id_bill_detail_tarif = c.id_bill_detail_tarif
                                LEFT JOIN
                            simrs2012.vw_diagnosa_eklaim d ON o.icd10 = d.code
                        WHERE
                            o.id_bill_detail_tarif = a.id_bill_detail_tarif
                        GROUP BY o.id_bill_detail_tarif),
                    ''),
            '<br><br>',
            '<strong>P</strong> : Status Keluar : ',
            IFNULL((SELECT 
                            group_concat(x.keterangan separator ', ')
                        FROM
                            simrs.bill_detail_transfer_pasien z
                                LEFT JOIN
                            simrs.m_statuskeluar x ON z.id_status_keluar = x.status
                        WHERE
                            z.id_bill_detail_tarif = a.id_bill_detail_tarif group by z.id_bill_detail_tarif),
                    ''),
            ',',
            IFNULL((SELECT 
                            group_concat(CASE
                                    WHEN y.userlevelname IS NULL THEN ''
                                    WHEN y.userlevelname IS NOT NULL THEN CONCAT('Konsul ke ', y.userlevelname)
                                END separator ', ') AS konsul
                        FROM
                            simrs.bill_detail_transfer_pasien z
                                LEFT JOIN
                            simrs.m_statuskeluar x ON z.id_status_keluar = x.status
                                LEFT JOIN
                            simrs.userlevels y ON z.userlevelid_transfer = y.userlevelid
                        WHERE
                            z.id_bill_detail_tarif = a.id_bill_detail_tarif
                                AND z.id_status_keluar = 5 group by z.id_bill_detail_tarif),
                    ''),' ',ifnull(a.rencana_tindakan,'')) AS assasemen,
    CONCAT((ifnull((SELECT 
                    ifnull(GROUP_CONCAT(b.nama_tindakan
                            SEPARATOR ', '),'') AS tindakan
                FROM
                    simrs.bill_detail_tindakan o
                        LEFT JOIN
                    simrs.master_tindakan b ON o.id_tindakan = b.id_tindakan
                WHERE
                    b.userlevelid IS NULL
                        AND o.id_bill_detail_tarif = a.id_bill_detail_tarif
                GROUP BY o.id_bill_detail_tarif),'')),
            ' | ',
            (SELECT 
                        IFNULL(GROUP_CONCAT(CONCAT(LOWER(c.nama_obat),
                        '(',
                        CASE
                            WHEN o.nilai1 IS NULL THEN o.qty
                            WHEN o.nilai1 IS NOT NULL and o.id_jenis_racikan=1 THEN CONCAT(o.nilai1, ' ',e.jenis_racikan)
                            WHEN o.nilai1 IS NOT NULL and o.id_jenis_racikan=2 THEN CONCAT(o.nilai1, '/',o.nilai2 ,' ',e.jenis_racikan)
							WHEN o.nilai1 IS NOT NULL and o.id_jenis_racikan=3 THEN CONCAT(o.nilai1,' ',e.jenis_racikan)
                        END,
                        ')')
                SEPARATOR ', '),
            '') AS obat
                FROM
                    simrs.bill_detail_permintaan_obat o
                        LEFT JOIN
                    simrs.master_obat_detail b ON o.id_master_obat_detail = b.id_master_obat_detail
                        LEFT JOIN
                    simrs.master_obat c ON b.id_obat = c.id_obat
					    LEFT JOIN
					simrs.bill_detail_permintaan_obat_master d ON o.id_bill_detail_permintaan_obat_master = d.id_bill_detail_permintaan_obat_master
						LEFT JOIN
					simrs.l_jenis_racikan e ON o.id_jenis_racikan = e.id_jenis_racikan
                WHERE
                    o.id_bill_detail_tarif = a.id_bill_detail_tarif
                        AND (c.nama_obat NOT LIKE '%JASA%'
                        AND c.nama_obat NOT LIKE '%SPUIT%'
                        AND c.nama_obat NOT LIKE '%INJEKSI%'
                        AND c.nama_obat NOT LIKE '%KASSA%'
                        AND c.nama_obat NOT LIKE '%INFUS%'
                        AND c.nama_obat NOT LIKE '%AQUADEST%'
                        AND c.nama_obat NOT LIKE '%URIN BAG%'
                        AND c.nama_obat NOT LIKE '%NEDLE%'
                        AND c.nama_obat NOT LIKE '%APRON%'
                        AND c.nama_obat NOT LIKE '%TEGADERM%'
                        AND c.nama_obat NOT LIKE '%HIPAVIX%'
                        AND c.nama_obat NOT LIKE '%DRESSING%'
                        AND c.nama_obat NOT LIKE '%TRIWAY%'
                        AND c.nama_obat NOT LIKE '%FC NO%'
						AND c.nama_obat NOT LIKE '%ORAL%'
                        AND c.nama_obat NOT LIKE '%INJ%')
                GROUP BY o.id_bill_detail_tarif)) AS intruksi,
    h.signature,
    CONCAT('<br><center>',
            h.pd_nickname,
            '<br>',
            h.no_surat_izin_praktek,
            '</center>') AS dpjp,
    g.userlevelname
FROM
    simrs.bill_detail_keterangan a
        LEFT JOIN
    simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_rujukan c ON b.kdrujuk = c.KODE
        LEFT JOIN
    simrs2012.m_pasien d ON b.nomr = d.NOMR
        LEFT JOIN
    simrs2012.m_bahasa_harian e ON e.id = d.KD_BHS_HARIAN
        LEFT JOIN
    simrs.l_skala_nyeri f ON a.skala_nyeri = f.id_skala_nyeri
        LEFT JOIN
    simrs.userlevels g ON b.userlevelid = g.userlevelid
        LEFT JOIN
    simrs.master_login h ON b.kddokter = h.kddokter
        LEFT JOIN
    simrs.master_profesi i ON h.id_profesi = i.id_profesi
        LEFT JOIN
    simrs.master_profesi_sub j ON h.id_profesi_sub = j.id_master_profesi_sub
WHERE
    b.nomr = $nomr order by a.tanggal_anamnesa asc";
$queryitemanamnesa = mysql_query($sqlitemanamnesa);
$queryitemanamnesa1 = mysql_query($sqlitemanamnesa);
$DATAISI = mysql_fetch_array($queryitemanamnesa1);

$sqlumur="SELECT 
    nomr,
    CONCAT(TIMESTAMPDIFF(YEAR,tgllahir,NOW()),' Tahun ',(TIMESTAMPDIFF(MONTH,tgllahir,NOW()) % 12),' Bulan') as umur 
FROM
    simrs.bill_detail_tarif 
WHERE
    nomr = $nomr";
$queryumur = mysql_query($sqlumur);
$DATAUMUR = mysql_fetch_array($queryumur);

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>FORM CPPT PASIEN</title>
<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
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

.pagebreak { 
		page-break-before: always;
}
	
.kosong {
    border:none;
}
	
body {
margin: 0;
padding: 0;
border: 2px solid #000000;
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
            <td width="23%" align="center"><img src="../gambar/logobms.png" height="60px" /></td>
            <td width="77%" align="center" style="font-size: 10px; font-weight: bold" valign="top">PEMERINTAH KABUPATEN BANYUMAS<br>RUMAH SAKIT UMUM DAERAH AJIBARANG<br>Jl. Raya Pancasan – Ajibarang<br>(0281) 6570004   Fax. (0281) 6570005<br>Email:rsudajibarang@banyumaskab.go.id</td>
          </tr>
        </tbody>
      </table></td>
      <td width="33%" style="font-size: 12px"><p align="center"><strong>CATATAN  PERKEMBANGAN PASIEN TERINTEGRASI</strong><br>
      <strong>(CPPT)</strong></p></td>
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
            <td valign="top">Tgl Lahir</td>
            <td valign="top">:</td>
            <td><?php echo $DATAISI['tgllahir']; ?>  <br>/ <?php echo $DATAUMUR['umur']; ?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>
	  
		  
<table width="100%" border="0" class="tabel">
  <tbody>
    <tr>
      <td width="9%" align="center" style="font-size: 11px; padding-bottom:20px;" valign="top"><strong>TGL JAM</strong></td>
      <td width="13%" align="center" style="font-size: 11px; padding-bottom:20px;" valign="top"><strong>PROFESI</strong></td>
      <td width="37%" align="center" style="font-size: 11px; padding-bottom:20px;" valign="top"><strong>HASIL ASESMEN <br>PENATALAKSANAAN PASIEN</strong><br>(Tulis dengan format SOAP, disertai Sasaran, Tulis Nama, beri Paraf pada akhir catatan)</td>
      <td width="23%" align="center" style="font-size: 11px; padding-bottom:20px;" valign="top"><strong>INTRUKSI PPA TERMASUK PASCA BEDAH</strong><br>(Instruksi ditulis
 dengan rinci dan jelas)
</td>
      <td width="18%" align="center" style="font-size: 11px; padding-bottom:20px;" valign="top"><strong>VERIFIKASI DPJP</strong><br>(DPJP harus membaca/mereview seluruh Rencana Asuhan)</td>
    </tr>
	  <?php
		while($data1=mysql_fetch_assoc($queryitemanamnesa)){
			echo '<tr>';
	  echo '<td style="font-size: 10px; padding-bottom:20px;" align="center" valign="top" class="kosong">'.$data1['tanggal_anamnesa'].'</td>';
	  echo '<td style="font-size: 10px; padding-bottom:20px;" valign="top" class="kosong">'.$data1['profesi'].'</td>';
	  echo '<td style="font-size: 10px; padding-bottom:20px;" valign="top" class="kosong">'.$data1['assasemen'].'</td>';
	  echo '<td style="font-size: 10px; padding-bottom:20px;" valign="top" class="kosong">'.$data1['intruksi'].' '.$data1['tindakan'].' '.$data1['LAB'].' '.$data1['RAD'].'</td>';
	  echo '<td style="font-size: 8px; padding-bottom:20px;" valign="button" class="kosong"><center><img src="../../uploads/'.$data1['signature'].'" height="40px" /></center> '.$data1['dpjp'].'</td>';
			echo '</tr>';
		}

 ?>
  </tbody>
</table>
		  
	

	
	<div align="right" style="position: relative;">
	<div style="position: absolute; bottom: 9px;">
		<div align="left" style="font-size: 9px; font-style: oblique">
      		Terima kasih atas kerjasamanya telah mengisi formulir ini dengan jelas dan benar.
    	</div>
	</div>
	</div>	

</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.27 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('nota.pdf',array('Attachment' => 0));
?>
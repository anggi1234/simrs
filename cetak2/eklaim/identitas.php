<?php

$sqlidentitas="SELECT 
    a.id_bill_detail_tarif,
    a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y %H:%i:%s') AS tglmasuk,
    DATE_FORMAT(a.tglout, '%d-%m-%Y %H:%i:%s') AS tglkeluar,
    DATE_FORMAT(a.tglout, '%d-%m-%Y') AS tglcetak,
    a.total_keseluruhan,
    CONCAT(e.keterangan,
            ' (',
            IFNULL(f.userlevelname, ''),
            ')') AS status_keluar
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs2012.m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    simrs2012.m_statuskeluar e ON e.status = a.id_status_pasien
    left join simrs.userlevels f on a.userlevelid=f.userlevelid
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            b.str AS nama_penyakit,
            a.icd10 AS icd10_1
    FROM
        simrs.bill_detail_penyakit a
    LEFT JOIN simrs2012.vw_diagnosa_eklaim b ON a.icd10 = b.code
    WHERE
        a.id_bill_detail_tarif = $id_bill_detail_tarif
            AND a.userlevelid IS NULL
    GROUP BY a.id_penyakit
    LIMIT 1) g ON a.id_bill_detail_tarif = g.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            b.str AS nama_penyakit,
            a.icd10 AS icd10_2
    FROM
        simrs.bill_detail_penyakit a
    LEFT JOIN simrs2012.vw_diagnosa_eklaim b ON a.icd10 = b.code
    WHERE
        a.id_bill_detail_tarif = $id_bill_detail_tarif
            AND a.userlevelid IS NULL
            AND a.jenis_diagnosa = 'SEKUNDER') h ON a.id_bill_detail_tarif = h.id_bill_detail_tarif
WHERE
    a.idxdaftar = $idxdaftar";
 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

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

$sqlusername="SELECT 
    a.pd_nickname, b.userlevelname, a.signature
FROM
    master_login a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
WHERE
    a.username = '$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

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

?>
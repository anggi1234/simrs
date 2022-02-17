<?php
ob_start();
session_start();
include('../connect.php');
$kdcarabayar = $_GET['kdcarabayar'];
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$kelas= $_GET['kelas'];



$sqlitemstok="SELECT 
    z.pd_nickname AS dokter,
    IFNULL(a.qty, 0) AS kcla,
    IFNULL(b.qty, 0) AS kclb,
    IFNULL(c.qty, 0) AS kclc,
    IFNULL(d.qty, 0) AS bsra,
    IFNULL(e.qty, 0) AS bsrb,
    IFNULL(f.qty, 0) AS bsrc,
    IFNULL(g.qty, 0) AS sdga,
    IFNULL(h.qty, 0) AS sdgb,
    IFNULL(i.qty, 0) AS sdgc,
    IFNULL(j.qty, 0) AS khsa,
    IFNULL(k.qty, 0) AS khsb,
    IFNULL(l.qty, 0) AS khsc,
    IFNULL(m.qty, 0) AS sdg,
    IFNULL(n.qty, 0) AS kcl,
    IFNULL(o.qty, 0) AS bsr,
    IFNULL(p.qty, 0) AS sdh,
    IFNULL(q.qty, 0) AS khs,
	IFNULL(r.qty, 0) AS usg,
	IFNULL(s.qty, 0) AS ekg,
    IFNULL(y.qty, 0) AS visit,
    IFNULL(x.qty, 0) AS konsul
FROM
    master_login z
        LEFT JOIN
    (SELECT 
        a.l_standby_dokter, SUM(a.qty) AS qty
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
    LEFT JOIN simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid IS NULL
            AND (b.tglreg >= '$dari_tanggal'
            AND b.tglreg <= '$sampai_tanggal')
            AND c.id_jenis_tindakan = 1
            AND b.userlevelid = $userlevelid
            AND b.kelas = $kelas
            AND a.l_standby_dokter IS NOT NULL
            AND e.payor_id = $kdcarabayar
            AND c.id_type_tindakan = 1
    GROUP BY a.l_standby_dokter) a ON z.uid = a.l_standby_dokter
        LEFT JOIN
    (SELECT 
        a.l_standby_dokter, SUM(a.qty) AS qty
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
    LEFT JOIN simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid IS NULL
            AND (b.tglreg >= '$dari_tanggal'
            AND b.tglreg <= '$sampai_tanggal')
            AND c.id_jenis_tindakan = 1
            AND b.userlevelid = $userlevelid
            AND b.kelas = $kelas
            AND a.l_standby_dokter IS NOT NULL
            AND e.payor_id = $kdcarabayar
            AND c.id_type_tindakan = 2
    GROUP BY a.l_standby_dokter) b ON z.uid = b.l_standby_dokter
        LEFT JOIN
    (SELECT 
        a.l_standby_dokter, SUM(a.qty) AS qty
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
    LEFT JOIN simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid IS NULL
            AND (b.tglreg >= '$dari_tanggal'
            AND b.tglreg <= '$sampai_tanggal')
            AND c.id_jenis_tindakan = 1
            AND b.userlevelid = $userlevelid
            AND b.kelas = $kelas
            AND a.l_standby_dokter IS NOT NULL
            AND e.payor_id = $kdcarabayar
            AND c.id_type_tindakan = 3
    GROUP BY a.l_standby_dokter) c ON z.uid = c.l_standby_dokter
        LEFT JOIN
    (SELECT 
        a.l_standby_dokter, SUM(a.qty) AS qty
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
    LEFT JOIN simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid IS NULL
            AND (b.tglreg >= '$dari_tanggal'
            AND b.tglreg <= '$sampai_tanggal')
            AND c.id_jenis_tindakan = 1
            AND b.userlevelid = $userlevelid
            AND b.kelas = $kelas
            AND a.l_standby_dokter IS NOT NULL
            AND e.payor_id = $kdcarabayar
            AND c.id_type_tindakan = 4
    GROUP BY a.l_standby_dokter) d ON z.uid = d.l_standby_dokter
        LEFT JOIN
    (SELECT 
        a.l_standby_dokter, SUM(a.qty) AS qty
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
    LEFT JOIN simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid IS NULL
            AND (b.tglreg >= '$dari_tanggal'
            AND b.tglreg <= '$sampai_tanggal')
            AND c.id_jenis_tindakan = 1
            AND b.userlevelid = $userlevelid
            AND b.kelas = $kelas
            AND a.l_standby_dokter IS NOT NULL
            AND e.payor_id = $kdcarabayar
            AND c.id_type_tindakan = 5
    GROUP BY a.l_standby_dokter) e ON z.uid = e.l_standby_dokter
        LEFT JOIN
    (SELECT 
        a.l_standby_dokter, SUM(a.qty) AS qty
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
    LEFT JOIN simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid IS NULL
            AND (b.tglreg >= '$dari_tanggal'
            AND b.tglreg <= '$sampai_tanggal')
            AND c.id_jenis_tindakan = 1
            AND b.userlevelid = $userlevelid
            AND b.kelas = $kelas
            AND a.l_standby_dokter IS NOT NULL
            AND e.payor_id = $kdcarabayar
            AND c.id_type_tindakan = 6
    GROUP BY a.l_standby_dokter) f ON z.uid = f.l_standby_dokter
        LEFT JOIN
    (SELECT 
        a.l_standby_dokter, SUM(a.qty) AS qty
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
    LEFT JOIN simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid IS NULL
            AND (b.tglreg >= '$dari_tanggal'
            AND b.tglreg <= '$sampai_tanggal')
            AND c.id_jenis_tindakan = 1
            AND b.userlevelid = $userlevelid
            AND b.kelas = $kelas
            AND a.l_standby_dokter IS NOT NULL
            AND e.payor_id = $kdcarabayar
            AND c.id_type_tindakan = 7
    GROUP BY a.l_standby_dokter) g ON z.uid = g.l_standby_dokter
        LEFT JOIN
    (SELECT 
        a.l_standby_dokter, SUM(a.qty) AS qty
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
    LEFT JOIN simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid IS NULL
            AND (b.tglreg >= '$dari_tanggal'
            AND b.tglreg <= '$sampai_tanggal')
            AND c.id_jenis_tindakan = 1
            AND b.userlevelid = $userlevelid
            AND b.kelas = $kelas
            AND a.l_standby_dokter IS NOT NULL
            AND e.payor_id = $kdcarabayar
            AND c.id_type_tindakan = 8
    GROUP BY a.l_standby_dokter) h ON z.uid = h.l_standby_dokter
        LEFT JOIN
    (SELECT 
        a.l_standby_dokter, SUM(a.qty) AS qty
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
    LEFT JOIN simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid IS NULL
            AND (b.tglreg >= '$dari_tanggal'
            AND b.tglreg <= '$sampai_tanggal')
            AND c.id_jenis_tindakan = 1
            AND b.userlevelid = $userlevelid
            AND b.kelas = $kelas
            AND a.l_standby_dokter IS NOT NULL
            AND e.payor_id = $kdcarabayar
            AND c.id_type_tindakan = 9
    GROUP BY a.l_standby_dokter) i ON z.uid = i.l_standby_dokter
        LEFT JOIN
    (SELECT 
        a.l_standby_dokter, SUM(a.qty) AS qty
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
    LEFT JOIN simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid IS NULL
            AND (b.tglreg >= '$dari_tanggal'
            AND b.tglreg <= '$sampai_tanggal')
            AND c.id_jenis_tindakan = 1
            AND b.userlevelid = $userlevelid
            AND b.kelas = $kelas
            AND a.l_standby_dokter IS NOT NULL
            AND e.payor_id = $kdcarabayar
            AND c.id_type_tindakan = 10
    GROUP BY a.l_standby_dokter) j ON z.uid = j.l_standby_dokter
        LEFT JOIN
    (SELECT 
        a.l_standby_dokter, SUM(a.qty) AS qty
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
    LEFT JOIN simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid IS NULL
            AND (b.tglreg >= '$dari_tanggal'
            AND b.tglreg <= '$sampai_tanggal')
            AND c.id_jenis_tindakan = 1
            AND b.userlevelid = $userlevelid
            AND b.kelas = $kelas
            AND a.l_standby_dokter IS NOT NULL
            AND e.payor_id = $kdcarabayar
            AND c.id_type_tindakan = 11
    GROUP BY a.l_standby_dokter) k ON z.uid = k.l_standby_dokter
        LEFT JOIN
    (SELECT 
        a.l_standby_dokter, SUM(a.qty) AS qty
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
    LEFT JOIN simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid IS NULL
            AND (b.tglreg >= '$dari_tanggal'
            AND b.tglreg <= '$sampai_tanggal')
            AND c.id_jenis_tindakan = 1
            AND b.userlevelid = $userlevelid
            AND b.kelas = $kelas
            AND a.l_standby_dokter IS NOT NULL
            AND e.payor_id = $kdcarabayar
            AND c.id_type_tindakan = 12
    GROUP BY a.l_standby_dokter) l ON z.uid = l.l_standby_dokter
        LEFT JOIN
    (SELECT 
        a.l_standby_dokter, SUM(a.qty) AS qty
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
    LEFT JOIN simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid IS NULL
            AND (b.tglreg >= '$dari_tanggal'
            AND b.tglreg <= '$sampai_tanggal')
            AND c.id_jenis_tindakan = 1
            AND b.userlevelid = $userlevelid
            AND b.kelas = $kelas
            AND a.l_standby_dokter IS NOT NULL
            AND e.payor_id = $kdcarabayar
            AND c.id_type_tindakan = 13
    GROUP BY a.l_standby_dokter) m ON z.uid = m.l_standby_dokter
        LEFT JOIN
    (SELECT 
        a.l_standby_dokter, SUM(a.qty) AS qty
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
    LEFT JOIN simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid IS NULL
            AND (b.tglreg >= '$dari_tanggal'
            AND b.tglreg <= '$sampai_tanggal')
            AND c.id_jenis_tindakan = 1
            AND b.userlevelid = $userlevelid
            AND b.kelas = $kelas
            AND a.l_standby_dokter IS NOT NULL
            AND e.payor_id = $kdcarabayar
            AND c.id_type_tindakan = 14
    GROUP BY a.l_standby_dokter) n ON z.uid = n.l_standby_dokter
        LEFT JOIN
    (SELECT 
        a.l_standby_dokter, SUM(a.qty) AS qty
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
    LEFT JOIN simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid IS NULL
            AND (b.tglreg >= '$dari_tanggal'
            AND b.tglreg <= '$sampai_tanggal')
            AND c.id_jenis_tindakan = 1
            AND b.userlevelid = $userlevelid
            AND b.kelas = $kelas
            AND a.l_standby_dokter IS NOT NULL
            AND e.payor_id = $kdcarabayar
            AND c.id_type_tindakan = 15
    GROUP BY a.l_standby_dokter) o ON z.uid = o.l_standby_dokter
        LEFT JOIN
    (SELECT 
        a.l_standby_dokter, SUM(a.qty) AS qty
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
    LEFT JOIN simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid IS NULL
            AND (b.tglreg >= '$dari_tanggal'
            AND b.tglreg <= '$sampai_tanggal')
            AND c.id_jenis_tindakan = 1
            AND b.userlevelid = $userlevelid
            AND b.kelas = $kelas
            AND a.l_standby_dokter IS NOT NULL
            AND e.payor_id = $kdcarabayar
            AND c.id_type_tindakan = 16
    GROUP BY a.l_standby_dokter) p ON z.uid = p.l_standby_dokter
        LEFT JOIN
    (SELECT 
        a.l_standby_dokter, SUM(a.qty) AS qty
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
    LEFT JOIN simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid IS NULL
            AND (b.tglreg >= '$dari_tanggal'
            AND b.tglreg <= '$sampai_tanggal')
            AND c.id_jenis_tindakan = 1
            AND b.userlevelid = $userlevelid
            AND b.kelas = $kelas
            AND a.l_standby_dokter IS NOT NULL
            AND e.payor_id = $kdcarabayar
            AND c.id_type_tindakan = 17
    GROUP BY a.l_standby_dokter) q ON z.uid = q.l_standby_dokter
	
	LEFT JOIN
	
	
	(SELECT 
        a.l_standby_dokter, SUM(a.qty) AS qty
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
    LEFT JOIN simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid IS NULL
            AND (b.tglreg >= '$dari_tanggal'
            AND b.tglreg <= '$sampai_tanggal')
            AND b.userlevelid = $userlevelid
            AND b.kelas = $kelas
            AND a.l_standby_dokter IS NOT NULL
            AND e.payor_id = $kdcarabayar
            AND c.id_jenis_tindakan = 10
    GROUP BY a.l_standby_dokter) r ON z.uid = r.l_standby_dokter
	
	LEFT JOIN
	
	(SELECT 
        a.l_standby_dokter, SUM(a.qty) AS qty
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_tindakan c ON a.id_tindakan = c.id_tindakan
    LEFT JOIN simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid IS NULL
            AND (b.tglreg >= '$dari_tanggal'
            AND b.tglreg <= '$sampai_tanggal')
            AND b.userlevelid = $userlevelid
            AND b.kelas = $kelas
            AND a.l_standby_dokter IS NOT NULL
            AND e.payor_id = $kdcarabayar
            AND c.id_jenis_tindakan = 9
    GROUP BY a.l_standby_dokter) s ON z.uid = s.l_standby_dokter
	
	
	
	
	
	
        LEFT JOIN
    (SELECT 
        b.uid, SUM(a.qty) AS qty
    FROM
        bill_detail_visit_dokter a
    LEFT JOIN v_master_standby b ON a.id_dokter_standby = b.id_dokter_standby
    LEFT JOIN simrs.bill_detail_tarif c ON a.id_bill_detail_tarif = c.id_bill_detail_tarif
    LEFT JOIN simrs2012.m_carabayar d ON c.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid = $userlevelid AND e.payor_id = $kdcarabayar
            AND (c.tglreg >= '$dari_tanggal'
            AND c.tglreg <= '$sampai_tanggal')
            AND c.kelas = $kelas
            AND (b.id_profesi = 13 OR b.id_profesi = 19
            OR b.id_profesi = 1)
    GROUP BY b.uid) y ON z.uid = y.uid
        LEFT JOIN
    (SELECT 
        b.uid, SUM(a.qty) AS qty
    FROM
        bill_detail_visit_dokter a
    LEFT JOIN v_master_standby b ON a.id_dokter_standby = b.id_dokter_standby
    LEFT JOIN simrs.bill_detail_tarif c ON a.id_bill_detail_tarif = c.id_bill_detail_tarif
    LEFT JOIN simrs2012.m_carabayar d ON c.kdcarabayar = d.kode
    LEFT JOIN simrs.l_carabayar_group e ON d.payor_id = e.payor_id
    WHERE
        c.userlevelid = $userlevelid AND e.payor_id = $kdcarabayar
            AND (c.tglreg >= '$dari_tanggal'
            AND c.tglreg <= '$sampai_tanggal')
            AND c.kelas = $kelas
            AND (b.id_profesi = 12)
    GROUP BY b.uid) x ON z.uid = x.uid
WHERE
    z.userlevelid = 121
ORDER BY z.id_profesi ASC , z.pd_nickname ASC";
$queryitemstok = mysql_query($sqlitemstok);
$queryitemobat = mysql_query($sqlitemstok);
$DATA_OBAT = mysql_fetch_array($queryitemobat);

$querytotal = mysql_query($sqlitemstok);
$querykonsul = mysql_query($sqlitemstok);

$querykcla = mysql_query($sqlitemstok);
$querykclb = mysql_query($sqlitemstok);
$querykclc = mysql_query($sqlitemstok);
$querybsra = mysql_query($sqlitemstok);
$querybsrb = mysql_query($sqlitemstok);
$querybsrc = mysql_query($sqlitemstok);
$querysdga = mysql_query($sqlitemstok);
$querysdgb = mysql_query($sqlitemstok);
$querysdgc = mysql_query($sqlitemstok);
$querykhsa = mysql_query($sqlitemstok);
$querykhsb = mysql_query($sqlitemstok);
$querykhsc = mysql_query($sqlitemstok);
$querykcl = mysql_query($sqlitemstok);
$querysdg = mysql_query($sqlitemstok);
$querybsr = mysql_query($sqlitemstok);
$querysdh = mysql_query($sqlitemstok);
$querykhs = mysql_query($sqlitemstok);

$queryusg = mysql_query($sqlitemstok);
$queryekg = mysql_query($sqlitemstok);



$sqlitemtotal="";
$queryitemtotal = mysql_query($sqlitemtotal);
$DATA_TOTAL = mysql_fetch_array($queryitemtotal);

$sqlitemcarabayar="SELECT 
    b.nama_carabayar_group
FROM
    simrs2012.m_carabayar a
        LEFT JOIN
    simrs.l_carabayar_group b ON a.payor_id = b.payor_id
	where b.payor_id=$kdcarabayar";
$queryitemcarabayar = mysql_query($sqlitemcarabayar);
$DATA_CARABAYAR = mysql_fetch_array($queryitemcarabayar);

$sqlitemaskep="SELECT 
    ifnull(SUM(qty),0) AS jumlah
FROM
    simrs.bill_detail_tindakan_lain a
        LEFT JOIN
    simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_carabayar c ON b.kdcarabayar = c.kode
        LEFT JOIN
    simrs.l_carabayar_group d ON c.payor_id = d.payor_id
WHERE
    a.id_jenis_tindakan = 16
        AND b.userlevelid = $userlevelid
        AND (b.tglreg >= '$dari_tanggal'
        AND b.tglreg <= '$sampai_tanggal')
        AND b.kelas = $kelas
        and d.payor_id = $kdcarabayar";
$queryitemaskep = mysql_query($sqlitemaskep);
$DATA_ASKEP = mysql_fetch_array($queryitemaskep);

$sqlitemuserlevel="SELECT 
    userlevelname
FROM
    simrs.userlevels
	where userlevelid=$userlevelid";
$queryitemuserlevel = mysql_query($sqlitemuserlevel);
$DATA_USERLEVEL = mysql_fetch_array($queryitemuserlevel);

$sqlitemkeperawatan="SELECT 
    c.type_tindakan, SUM(a.qty) AS jumlah
FROM
    simrs.bill_detail_tindakan a
        LEFT JOIN
    simrs.master_tindakan b ON a.id_tindakan = b.id_tindakan
        LEFT JOIN
    simrs.l_type_tindakan c ON a.id_type_tindakan = c.id_type_tindakan
        LEFT JOIN
    simrs.bill_detail_tarif d ON a.id_bill_detail_tarif = d.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_carabayar e ON d.kdcarabayar = e.kode
        LEFT JOIN
    simrs.l_carabayar_group f ON e.payor_id = f.payor_id
WHERE
    a.id_jenis_tindakan = 3
        AND b.id_type_tindakan IS NOT NULL
        AND (d.tanggal >= '$dari_tanggal'
        AND d.tanggal <= '$sampai_tanggal')
        AND d.userlevelid = $userlevelid
        AND e.payor_id = $kdcarabayar
        AND d.kelas = $kelas
GROUP BY a.id_type_tindakan";
$queryitemkeperawatan = mysql_query($sqlitemkeperawatan);

?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Jasa Visit Dokter</title>

<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom:0.5 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
			
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 9px;
	font-weight: bold;
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

    <div align="center" class="header"><strong>LAPORAN JASA PELAYANAN</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="7%">Cara Bayar</td>
      <td>: <?php echo $DATA_CARABAYAR['nama_carabayar_group']; ?></td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Kelas</td>
      <td>: <?php echo $kelas ?></td>
      <td align="left">Unit</td>
      <td>: <?php echo $DATA_USERLEVEL['userlevelname']; ?></td>
    </tr>
    <tr>
      <td>Dari Tanggal</td>
      <td width="39%">: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td width="9%" align="left">Sampai Tanggal</td>
      <td width="45%">: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>

<hr>

<table width="100%" border="1" class="tabel">
  <tbody>
    <tr>
      <td width="2%" rowspan="2" align="center">No</td>
      <td width="13%" rowspan="2" align="center">Dokter</td>
      <td width="2%" rowspan="2" align="center">Visit</td>
      <td width="3%" rowspan="2" align="center">Konsul</td>
      <td colspan="19" align="center">TMNO DOKTER SIMRS V.2</td>
    </tr>
    <tr>
      <td width="4%" align="center">KCL A</td>
      <td width="4%" align="center">KCL B</td>
      <td width="4%" align="center">KCL C</td>
      <td width="4%" align="center">SDG A</td>
      <td width="4%" align="center">SDG B</td>
      <td width="4%" align="center">SDG C</td>
      <td width="4%" align="center">BSR A</td>
      <td width="4%" align="center">BSR B</td>
      <td width="4%" align="center">BSR C</td>
      <td width="4%" align="center">KHS A</td>
      <td width="4%" align="center">KHS B</td>
      <td width="4%" align="center">KHS C</td>
      <td width="4%" align="center">SDG</td>
      <td width="4%" align="center">KECIL</td>
      <td width="4%" align="center">BESAR</td>
      <td width="4%" align="center">SDH</td>
      <td width="4%" align="center">KHS</td>
      <td width="4%" align="center">USG</td>
      <td width="4%" align="center">EKG</td>
    </tr>
    
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemstok)){
			echo '<tr>';
			echo '<td align="center">'.$no.'</td>';
			echo '<td align="left">'.$data['dokter'].'</td>';
			echo '<td align="center">'.$data['visit'].'</td>';
			echo '<td align="center">'.$data['konsul'].'</td>';
			echo '<td align="center">'.$data['kcla'].'</td>';
			echo '<td align="center">'.$data['kclb'].'</td>';
			echo '<td align="center">'.$data['kclc'].'</td>';
			echo '<td align="center">'.$data['sdga'].'</td>';
			echo '<td align="center">'.$data['sdgb'].'</td>';
			echo '<td align="center">'.$data['sdgc'].'</td>';
			echo '<td align="center">'.$data['bsra'].'</td>';
			echo '<td align="center">'.$data['bsrb'].'</td>';
			echo '<td align="center">'.$data['bsrc'].'</td>';
			echo '<td align="center">'.$data['khsa'].'</td>';
			echo '<td align="center">'.$data['khsb'].'</td>';
			echo '<td align="center">'.$data['khsc'].'</td>';
			echo '<td align="center">'.$data['kcl'].'</td>';
			echo '<td align="center">'.$data['sdg'].'</td>';
			echo '<td align="center">'.$data['sdh'].'</td>';
			echo '<td align="center">'.$data['bsr'].'</td>';
			echo '<td align="center">'.$data['khs'].'</td>';
			echo '<td align="center">'.$data['usg'].'</td>';
			echo '<td align="center">'.$data['ekg'].'</td>';
			echo '</tr>';
			$no++;
		}
	?>
   
   <?php
	  
	  $visit= 0;
	  	while ($num = mysql_fetch_assoc ($querytotal)) {
    	$visit += $num['visit'];
	  }
	  $konsul= 0;
	  	while ($num = mysql_fetch_assoc ($querykonsul)) {
    	$konsul += $num['konsul'];
	  }
	  $kcla= 0;
	  	while ($num = mysql_fetch_assoc ($querykcla)) {
    	$kcla += $num['kcla'];
	  }
	  $kclb= 0;
	  	while ($num = mysql_fetch_assoc ($querykclb)) {
    	$kclb += $num['kclb'];
	  }
	  $kclc= 0;
	  	while ($num = mysql_fetch_assoc ($querykclc)) {
    	$kclc += $num['kclc'];
	  }
	  
	  $sdga= 0;
	  	while ($num = mysql_fetch_assoc ($querysdga)) {
    	$sdga += $num['sdga'];
	  }
	  
	  $sdgb= 0;
	  	while ($num = mysql_fetch_assoc ($querysdgb)) {
    	$sdgb += $num['sdgb'];
	  }
	  
	  $sdgc= 0;
	  	while ($num = mysql_fetch_assoc ($querysdgc)) {
    	$sdgc += $num['sdgc'];
	  }
	  
	  $bsra= 0;
	  	while ($num = mysql_fetch_assoc ($querybsra)) {
    	$bsra += $num['bsra'];
	  }
	  
	  $bsrb= 0;
	  	while ($num = mysql_fetch_assoc ($querybsrb)) {
    	$bsrb += $num['bsrb'];
	  }
	  
	  $bsrc= 0;
	  	while ($num = mysql_fetch_assoc ($querybsrc)) {
    	$bsrc += $num['bsrc'];
	  }
	  
	  $khsa= 0;
	  	while ($num = mysql_fetch_assoc ($querykhsa)) {
    	$khsa += $num['khsa'];
	  }
	  
	   $khsb= 0;
	  	while ($num = mysql_fetch_assoc ($querykhsb)) {
    	$khsb += $num['khsb'];
	  }
	  
	   $khsc= 0;
	  	while ($num = mysql_fetch_assoc ($querykhsc)) {
    	$khsc += $num['khsc'];
	  }
	  
	  $kcl= 0;
	  	while ($num = mysql_fetch_assoc ($querykcl)) {
    	$kcl += $num['kcl'];
	  }
	  
	  $sdh= 0;
	  	while ($num = mysql_fetch_assoc ($querysdh)) {
    	$sdh += $num['sdh'];
	  }
	  
	  $bsr= 0;
	  	while ($num = mysql_fetch_assoc ($querybsr)) {
    	$bsr += $num['bsr'];
	  }
	  
	  $sdg= 0;
	  	while ($num = mysql_fetch_assoc ($querysdg)) {
    	$sdg += $num['sdg'];
	  }
	  
	  $khs= 0;
	  	while ($num = mysql_fetch_assoc ($querykhs)) {
    	$khs += $num['khs'];
	  }
	  
	  $usg= 0;
	  	while ($num = mysql_fetch_assoc ($queryusg)) {
    	$usg += $num['usg'];
	  }
	  
	   $ekg= 0;
	  	while ($num = mysql_fetch_assoc ($queryekg)) {
    	$ekg += $num['ekg'];
	  }
	  
	  ?>
    
    <tr>
      <td colspan="2" align="center">JUMLAH</td>
      <td align="center"><?php echo $visit ?></td>
      <td align="center"><?php echo $konsul ?></td>
      <td align="center"><?php echo $kcla ?></td>
      <td align="center"><?php echo $kclb ?></td>
      <td align="center"><?php echo $kclc ?></td>
      <td align="center"><?php echo $sdga ?></td>
      <td align="center"><?php echo $sdgb ?></td>
      <td align="center"><?php echo $sdgc ?></td>
      <td align="center"><?php echo $bsra ?></td>
      <td align="center"><?php echo $bsrb ?></td>
      <td align="center"><?php echo $bsrc ?></td>
      <td align="center"><?php echo $khsa ?></td>
      <td align="center"><?php echo $khsb ?></td>
      <td align="center"><?php echo $khsc ?></td>
      <td align="center"><?php echo $sdg ?></td>
      <td align="center"><?php echo $kcl ?></td>
      <td align="center"><?php echo $bsr ?></td>
      <td align="center"><?php echo $sdh ?></td>
      <td align="center"><?php echo $khs ?></td>
      <td align="center"><?php echo $usg ?></td>
      <td align="center"><?php echo $ekg ?></td>
    </tr>
    
  </tbody>
</table>
<br>

<div class="pagebreak"></div>

<table width="40%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="5%" align="center">No.</td>
      <td width="76%">Kategori Tindakan Keperawatan</td>
      <td width="19%" align="center">Jumlah</td>
    </tr>
    <tr>
      <td align="center">1.</td>
      <td>ASUHAN KEPERAWATAN</td>
      <td align="center"><?php echo $DATA_ASKEP['jumlah']; ?></td>
    </tr>
    <?php
		$no=2;
		while($data=mysql_fetch_assoc($queryitemkeperawatan)){
			echo '<tr>';
			echo '<td align="center">'.$no.'.</td>';
			echo '<td align="left">'.$data['type_tindakan'].'</td>';
			echo '<td align="center">'.$data['jumlah'].'</td>';
			echo '</tr>';
			$no++;
		}
	?>
  </tbody>
</table>

Keterangan:
Dimohon untuk mengisi data PPA yang berisi Dokter/Perawat pada saat mengisi tindakan agar dapat dihitung secara otomatis


</body>
</html>


<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 15.69 * 72);
$dompdf->set_paper($paper_size, 'landscape');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporanvisit.pdf',array('Attachment' => 0));
?>
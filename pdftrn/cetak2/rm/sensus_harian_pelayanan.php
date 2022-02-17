<?php
ob_start();
session_start();
include('../connect.php');
$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];
$tglout = $_GET['tglout'];
$id_pelayanan = $_GET['id_pelayanan'];
$username = $_GET['username'];

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Sensus_".$bulan."-".$tahun.".xls");

$sqlitem="SELECT 
    DATE_FORMAT(c.tglreg, '%d-%m-%Y') AS tglmasuk,
    DATE_FORMAT(c.tglout, '%d-%m-%Y') AS tglkeluar,
    DATEDIFF(c.tglout, c.tglreg) AS ld,
    d.NOMR,
    d.NAMA,
    d.ALAMAT,
    DATE_FORMAT(d.tgllahir, '%d-%m-%Y') AS tgllahir,
    CONCAT(TIMESTAMPDIFF(YEAR, d.tgllahir, NOW())) AS umur,
    d.JENISKELAMIN,
    REPLACE(g.userlevelname,
        'POLIKLINIK',
        '') AS UNIT,
    h.NAMA AS cara_bayar,
    c.kelas,
    i.nama_dokter AS DPJP,
    CASE
        WHEN c.id_pasienbaru = 0 THEN 'LAMA'
        WHEN c.id_pasienbaru = 1 THEN 'BARU'
    END AS pasienbaru,
    k.namakecamatan,
    (SELECT 
            GROUP_CONCAT(CONCAT(IFNULL(z.icd10, ''))
                    SEPARATOR ',') AS diagnosa
        FROM
            simrs.bill_detail_penyakit z
                LEFT JOIN
            simrs2012.vw_diagnosa_eklaim y ON z.icd10 = y.code
        WHERE
            z.jenis_diagnosa = 'PRIMER'
                AND c.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY z.id_bill_detail_tarif) AS dx1,
    (SELECT 
            GROUP_CONCAT(CONCAT(IFNULL(z.icd10, ''))
                    SEPARATOR ',') AS diagnosa
        FROM
            simrs.bill_detail_penyakit z
                LEFT JOIN
            simrs2012.vw_diagnosa_eklaim y ON z.icd10 = y.code
        WHERE
            z.jenis_diagnosa = 'SEKUNDER'
                AND c.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY z.id_bill_detail_tarif) AS dx2,
    (SELECT 
            GROUP_CONCAT(CONCAT(IFNULL(z.keterangan, ''))
                    SEPARATOR ',') AS diagnosa
        FROM
            simrs.bill_detail_penyakit z
        WHERE
            z.jenis_diagnosa = 'PRIMER'
                AND c.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY z.id_bill_detail_tarif) AS diag1,
    (SELECT 
            GROUP_CONCAT(CONCAT(IFNULL(z.keterangan, ''))
                    SEPARATOR ',') AS diagnosa
        FROM
            simrs.bill_detail_penyakit z
        WHERE
            z.jenis_diagnosa = 'SEKUNDER'
                AND c.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY z.id_bill_detail_tarif) AS diag2,
    IFNULL((SELECT 
                    b.call_unit
                FROM
                    simrs.bill_detail_tarif a
                        LEFT JOIN
                    simrs.userlevels b ON a.userlevelid = b.userlevelid
                WHERE
                    a.idxdaftar = c.idxdaftar
                        AND b.id_pelayanan = 1
                GROUP BY a.idxdaftar),
            'VK') AS via,
    (SELECT 
            (SELECT 
                        GROUP_CONCAT(y.nama_tindakan
                                SEPARATOR ', ')
                    FROM
                        bill_detail_tindakan z
                            LEFT JOIN
                        master_tindakan y ON z.id_tindakan = y.id_tindakan
                    WHERE
                        a.id_bill_detail_tarif = z.id_bill_detail_tarif
                    GROUP BY z.id_bill_detail_tarif)
        FROM
            simrs.bill_detail_tarif a
        WHERE
            a.userlevelid = 40
                AND a.idxdaftar = c.idxdaftar) AS op,
    l.keterangan
FROM
    simrs.bill_detail_tarif c
        LEFT JOIN
    simrs2012.m_pasien d ON c.nomr = d.NOMR
        LEFT JOIN
    simrs.userlevels g ON c.userlevelid = g.userlevelid
        LEFT JOIN
    simrs2012.m_carabayar h ON h.kode = c.kdcarabayar
        LEFT JOIN
    simrs.m_dokter i ON c.kddokter = i.KDDOKTER
        AND c.userlevelid = i.userlevelid
        LEFT JOIN
    simrs.master_login j ON c.kddokter = j.kddokter
        LEFT JOIN
    simrs2012.m_kecamatan k ON d.kdkecamatan = k.idkecamatan
        LEFT JOIN
    simrs.m_statuskeluar l ON c.id_status_pasien = l.status
WHERE
    MONTH(c.tglreg) = '$bulan'
        AND YEAR(c.tglreg) = '$tahun'
        AND g.id_jenis_pelayanan_kasir = $id_pelayanan
		AND date(c.tglout)='$tglout'
ORDER BY c.tglreg ASC";
$queryitem = mysql_query($sqlitem);


 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SENSUS HARIAN</title>
<link rel="shortcut icon" href="../favicon.ico"/>
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
	font-size: 10px;
}
	
.kosong {
    border:none;
}
	
.header {
	font-size: 12px;
}	
.footer {
	font-size: 12px;
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
  

<div align="center"><strong>LAPORAN SENSUS</strong></div>

<table width="100%" class="tabel" border="1">
    <tr>
	  <td width="3%" align="center"><strong>NOMR</strong></td>
	  <td width="5%" align="center"><strong>NAMA</strong></td>
	  <td width="5%" align="center"><strong>TGLLAHIR</strong></td>
      <td width="5%" align="center"><strong>ALAMAT</strong></td>
      <td width="4%" align="center"><strong>UM</strong></td>
      <td width="6%" align="center"><strong>CARABAYAR</strong></td>
      <td width="4%" align="center"><strong>KEL</strong></td>
      <td width="4%" align="center"><strong>RUANG</strong></td>
      <td width="6%" align="center"><strong>TGLMASUK</strong></td>
      <td width="7%" align="center"><strong>TGLKELUAR</strong></td>
      <td width="2%" align="center"><strong>LD</strong></td>
      <td width="2%" align="center"><strong>VIA</strong></td>
      <td width="4%" align="center"><strong>P.BARU</strong></td>
      <td width="2%" align="center"><strong>JK</strong></td>
      <td width="3%" align="center"><strong>UMUR</strong></td>
      <td width="3%" align="center"><strong>DPJP</strong></td>
      <td width="2%" align="center"><strong>DX1</strong></td>
      <td width="4%" align="center"><strong>KODE1</strong></td>
      <td width="2%" align="center"><strong>DX2</strong></td>
      <td width="4%" align="center"><strong>KODE2</strong></td>
      <td width="4%" align="center"><strong>TIND.OP</strong></td>
	<td width="8%" align="center"><strong>KEC</strong></td>
	<td width="5%" align="center"><strong>CARAPLG</strong></td>
  </tr>
	<?php
	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="14">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
			echo '<td valign="top">'.$data['NOMR'].'</td>';
			echo '<td valign="top">'.$data['NAMA'].'</td>';
			echo '<td valign="top">'.$data['tgllahir'].'</td>';
			echo '<td valign="top">'.$data['ALAMAT'].'</td>';
			echo '<td valign="top">'.$data['umur'].'</td>';
			echo '<td valign="top">'.$data['cara_bayar'].'</td>';
			echo '<td valign="top">'.$data['kelas'].'</td>';
			echo '<td valign="top">'.$data['UNIT'].'</td>';
			echo '<td valign="top">'.$data['tglmasuk'].'</td>';
			echo '<td valign="top">'.$data['tglkeluar'].'</td>';
			echo '<td valign="top">'.$data['ld'].'</td>';
			echo '<td valign="top">'.$data['via'].'</td>';
			echo '<td valign="top">'.$data['pasienbaru'].'</td>';
			echo '<td valign="top">'.$data['JENISKELAMIN'].'</td>';
			echo '<td valign="top">'.$data['umur'].'</td>';
			echo '<td valign="top">'.$data['DPJP'].'</td>';
			echo '<td valign="top">'.$data['diag1'].'</td>';
			echo '<td valign="top">'.$data['dx1'].'</td>';
			echo '<td valign="top">'.$data['diag2'].'</td>';
			echo '<td valign="top">'.$data['dx2'].'</td>';
			echo '<td valign="top">'.$data['op'].'</td>';
			echo '<td valign="top">'.$data['namakecamatan'].'</td>';
			echo '<td valign="top">'.$data['keterangan'].'</td>';
      
			echo '</tr>';
			
			$no++;
		}
	}
    
	?>
	
  </table>


</body>
</html>

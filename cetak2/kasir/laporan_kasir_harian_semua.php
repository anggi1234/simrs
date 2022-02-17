<?php

ob_start();
session_start();
include('../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$kdcarabayar = $_GET['kdcarabayar'];
$username = $_GET['username'];
$id_jenis_pelayanan_kasir = $_GET['id_jenis_pelayanan_kasir'];

/*header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_pendapatan_harian.xls");*/
$sqlidentitas="SELECT 
    a.pd_nickname, b.userlevelname
FROM
    master_login a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
WHERE
    a.username = '$username'";
 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqlitem="SELECT 
    a.idxdaftar,
    a.nomr,
    b.nama,
	c.userlevelname,
	d.nama as carabayar,
    b.alamat,
    DATE_FORMAT(a.tglreg, '%d-%m-%Y') AS tglreg,
    e.namadokter,
    SUM(IFNULL(biaya_pendaftaran, 0) + IFNULL(biaya_jasar, 0) + IFNULL(biaya_penj_non_medis, 0) + IFNULL(biaya_asuhan_keperawatan, 0) + IFNULL(biaya_pemeriksaan, 0)) AS karcis,
    SUM(IFNULL(a.biaya_tind_tmno, 0)) AS biaya_tind_tmno,
    SUM(IFNULL(a.biaya_tind_tmo, 0)) AS biaya_tind_tmo,
    SUM(IFNULL(a.biaya_tind_keperawatan, 0)) AS biaya_tind_keperawatan,
    SUM(IFNULL(a.biaya_tind_persalinan, 0)) AS biaya_tind_persalinan,
    SUM(IFNULL(a.biaya_penj_laboratorium, 0)) AS biaya_penj_laboratorium,
    SUM(IFNULL(a.biaya_penj_radiologi, 0)) AS biaya_penj_radiologi,
    SUM(IFNULL(a.biaya_penj_fisioterapi, 0)) AS biaya_penj_fisioterapi,
    SUM(IFNULL(a.biaya_obat, 0) - IFNULL(a.biaya_obat_retur, 0)) AS biaya_obat,
    SUM(IFNULL(a.biaya_ekg, 0)) AS biaya_ekg,
    SUM(IFNULL(a.biaya_usg, 0)) AS biaya_usg,
    SUM(IFNULL(biaya_bhp_tmno, 0) + IFNULL(biaya_bhp_tmo, 0) + IFNULL(biaya_bhp_keperawatan, 0) + IFNULL(biaya_bhp_persalinan, 0) + IFNULL(biaya_bhp_oksigen, 0) + IFNULL(biaya_bhp_ekg, 0) + IFNULL(biaya_bhp_usg, 0)) AS bhp,
    SUM(a.total_keseluruhan) AS total_keseluruhan,
    (SELECT 
            GROUP_CONCAT(CONCAT(z.icd10, '', y.str)
                    SEPARATOR ',') AS diagnosa
        FROM
            simrs.bill_detail_penyakit z
                LEFT JOIN
            simrs2012.vw_diagnosa_eklaim y ON z.icd10 = y.code
        WHERE
            z.id_bill_detail_tarif = a.id_bill_detail_tarif
        GROUP BY z.idxdaftar) AS diagnosa,
    (SELECT 
            CONCAT(y.keterangan,
                        ' (',
                        IFNULL(x.userlevelname, ''),
                        ')') AS konsul
        FROM
            simrs.bill_detail_transfer_pasien z
                LEFT JOIN
            simrs.m_statuskeluar y ON z.id_status_keluar = y.status
                LEFT JOIN
            simrs.userlevels x ON z.userlevelid_transfer = x.userlevelid
        WHERE
            z.id_bill_detail_tarif = a.id_bill_detail_tarif
        GROUP BY z.idxdaftar) AS konsul,
    SUM(IFNULL(a.biaya_pel_ambulan, 0)) AS biaya_pel_ambulan,
    SUM(IFNULL(a.biaya_tind_jenazah, 0)) AS biaya_tind_jenazah,
    SUM(IFNULL(a.biaya_bimbingan_rohani, 0)) AS biaya_bimbingan_rohani,
    SUM(IFNULL(a.biaya_akomodasi, 0)) AS biaya_akomodasi,
    SUM(IFNULL(a.biaya_makan, 0)) AS biaya_makan
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs.userlevels c ON a.userlevelid = c.userlevelid
        LEFT JOIN
    simrs2012.m_carabayar d ON a.kdcarabayar = d.kode
        LEFT JOIN
    simrs2012.m_dokter e ON a.kddokter = e.kddokter
WHERE a.tglreg >= '$dari_tanggal' 
and a.tglreg <= '$sampai_tanggal' 
and d.payor_id=$kdcarabayar AND c.id_jenis_pelayanan_kasir = $id_jenis_pelayanan_kasir
GROUP BY a.idxdaftar";
$queryitem = mysql_query($sqlitem);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LAPORAN HARIAN KASIR</title>
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
	font-size: 11px;
}
	
.header {
	font-size: 9px;
}	
.footer {
	font-size: 9px;
}

.pagebreak { 
		page-break-before: always;
	}

.footer1 {	font-size: 9px;
	font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
}
</style>

</head>
<body>

    <div align="center"><strong>SETORAN PENDAPATAN HARIAN PER PASIEN</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="12%">Nama Kasir</td>
      <td width="36%">: <?php echo $DATA_IDENTITAS['pd_nickname']; ?></td>

    </tr>
    <tr>
      <td>Dari Tanggal</td>
      <td>: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td align="right">Sampai Tanggal</td>
      <td>: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>

<table width="100%" border="1" class="tabel">
  <tbody>
    <tr>
      <td width="2%" align="center">No</td>
      <td width="3%" align="center">Nomr</td>
      <td width="7%" align="center">Nama</td>
      <td width="7%" align="center">Alamat</td>
      <td width="3%" align="center">Unit</td>
      <td width="3%" align="center">Dokter</td>
      <td width="3%" align="center">Tgl</td>
      <td width="6%" align="center">Diagnosa</td>
      <td width="5%" align="center">Pembayaran</td>
      <td width="5%" align="center">Karcis</td>
      <td width="5%" align="center">TMNO</td>
      <td width="5%" align="center">TMO</td>
      <td width="5%" align="center">Kep</td>
      <td width="5%" align="center">Persal</td>
      <td width="4%" align="center">BHP</td>
      <td width="4%" align="center">Akomodasi</td>
      <td width="4%" align="center">Makan</td>
      <td width="4%" align="center">Ambulan</td>
      <td width="4%" align="center">Jenazah</td>
      <td width="4%" align="center">Bimroh</td>
      <td width="4%" align="center">Lab</td>
      <td width="4%" align="center">Rad</td>
      <td width="5%" align="center">Fisio</td>
      <td width="5%" align="center">Obat</td>
      <td width="4%" align="center">EKG</td>
      <td width="3%" align="center">USG</td>
      <td width="5%" align="center">Total</td>
      <td width="5%" align="center">Ket</td>
    </tr>
    <?php
	$no=1;
    while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
		echo '<td>'.$data['nomr'].'</td>';
		echo '<td>'.$data['nama'].'</td>';
		echo '<td>'.$data['alamat'].'</td>';
		echo '<td>'.$data['userlevelname'].'</td>';
		echo '<td>'.$data['namadokter'].'</td>';
		echo '<td>'.$data['tglreg'].'</td>';
		echo '<td>'.$data['diagnosa'].'</td>';
		echo '<td>'.$data['carabayar'].'</td>';
	  	echo '<td align="right">'.number_format($data['karcis'], 0,",","."). '</td>';
		echo '<td align="right">'.number_format($data['biaya_tind_tmno'], 0,",","."). '</td>';
		echo '<td align="right">'.number_format($data['biaya_tind_tmo'], 0,",","."). '</td>';
		echo '<td align="right">'.number_format($data['biaya_tind_keperawatan'], 0,",","."). '</td>';
		echo '<td align="right">'.number_format($data['biaya_tind_persalinan'], 0,",","."). '</td>';
		echo '<td align="right">'.number_format($data['bhp'], 0,",","."). '</td>';
		echo '<td align="right">'.number_format($data['biaya_akomodasi'], 0,",","."). '</td>';
		echo '<td align="right">'.number_format($data['biaya_makan'], 0,",","."). '</td>';
		echo '<td align="right">'.number_format($data['biaya_pel_ambulan'], 0,",","."). '</td>';
		echo '<td align="right">'.number_format($data['biaya_tind_jenazah'], 0,",","."). '</td>';
		echo '<td align="right">'.number_format($data['biaya_bimbingan_rohani'], 0,",","."). '</td>';
		echo '<td align="right">'.number_format($data['biaya_penj_laboratorium'], 0,",","."). '</td>';
		echo '<td align="right">'.number_format($data['biaya_penj_radiologi'], 0,",","."). '</td>';
		echo '<td align="right">'.number_format($data['biaya_penj_fisioterapi'], 0,",","."). '</td>';
		echo '<td align="right">'.number_format($data['biaya_obat'], 0,",","."). '</td>';
		echo '<td align="right">'.number_format($data['biaya_ekg'], 0,",","."). '</td>';
		echo '<td align="right">'.number_format($data['biaya_usg'], 0,",","."). '</td>';
		echo '<td align="right">'.number_format($data['total_keseluruhan'], 0,",","."). '</td>';
		echo '<td>'.$data['konsul'].'</td>';
			echo '</tr>';
			
			$no++;
		}
	?>
  </tbody>
</table>



<table width="100%" border="0" class="tabel">
        <tbody>
     <tr>
       <td width="27%" align="center">Yang Menyerahkan</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td width="34%" align="center">Yang Menerima</td>
    </tr>
     <tr>
       <td align="right">&nbsp;</td>
       <td colspan="6" align="right">&nbsp;</td>
       <td align="right" class="total">&nbsp;</td>
     </tr>
     <tr>
      <td align="right">&nbsp;</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td align="right" class="total">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_IDENTITAS['pd_nickname']; ?></td>
      <td colspan="6" align="right">&nbsp;</td>
      <td align="center">Wiwid Kurniati</td>
    </tr>
  </tbody>
</table>


</body>
</html>

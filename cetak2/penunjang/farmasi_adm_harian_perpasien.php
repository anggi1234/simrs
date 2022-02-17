<?php
ob_start();
session_start();
include('../connect.php');
$username = $_GET['username'];
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$kdcarabayar= $_GET['kdcarabayar'];
$id_jenis_pelayanan_farmasi= $_GET['id_jenis_pelayanan_farmasi'];


$sqlitempasien="SELECT 
    DATE_FORMAT(z.tglreg, '%d-%m-%y') AS tglreg,
    z.nomr,
    b.nama,
    b.alamat,
    c.userlevelname AS unit,
    (SELECT 
            SUM(IFNULL(a.total, 0) - IFNULL(b.total, 0)) AS jasa
        FROM
            bill_detail_permintaan_obat a
                LEFT JOIN
            bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
                LEFT JOIN
            master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
                LEFT JOIN
            master_obat d ON c.id_obat = d.id_obat
        WHERE
            d.nama_obat LIKE '%jasa%'
                AND a.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif) AS jasa,
    (SELECT 
            SUM(IFNULL(a.total, 0) - IFNULL(b.total, 0)) AS obat
        FROM
            bill_detail_permintaan_obat a
                LEFT JOIN
            bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
                LEFT JOIN
            master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
                LEFT JOIN
            master_obat d ON c.id_obat = d.id_obat
        WHERE
            d.nama_obat NOT LIKE '%jasa%'
                AND a.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif) AS obat,
    (SELECT 
            SUM(IFNULL(a.total, 0) - IFNULL(b.total, 0)) AS jasa
        FROM
            bill_detail_permintaan_obat a
                LEFT JOIN
            bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
                LEFT JOIN
            master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
                LEFT JOIN
            master_obat d ON c.id_obat = d.id_obat
        WHERE
            d.nama_obat LIKE '%jasa%'
                AND a.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif) + (SELECT 
            SUM(IFNULL(a.total, 0) - IFNULL(b.total, 0)) AS obat
        FROM
            bill_detail_permintaan_obat a
                LEFT JOIN
            bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
                LEFT JOIN
            master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
                LEFT JOIN
            master_obat d ON c.id_obat = d.id_obat
        WHERE
            d.nama_obat NOT LIKE '%jasa%'
                AND a.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif) AS total,
    ifnull((SELECT 
            COUNT(*) AS generic
        FROM
            bill_detail_permintaan_obat a
                LEFT JOIN
            bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
                LEFT JOIN
            master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
                LEFT JOIN
            master_obat d ON c.id_obat = d.id_obat
        WHERE
            c.id_golongan = 27
                AND a.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif),0) AS generic,
    ifnull((SELECT 
            COUNT(*) AS paten
        FROM
            bill_detail_permintaan_obat a
                LEFT JOIN
            bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
                LEFT JOIN
            master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
                LEFT JOIN
            master_obat d ON c.id_obat = d.id_obat
        WHERE
            c.id_golongan = 34
                AND a.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif),0) AS paten,
    ifnull((SELECT 
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS obat2
        FROM
            bill_detail_permintaan_obat a
                LEFT JOIN
            bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
                LEFT JOIN
            master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
                LEFT JOIN
            master_obat d ON c.id_obat = d.id_obat
        WHERE
            d.id_obat = 21837
                AND a.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif),0) AS obat2,
    ifnull((SELECT 
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS obat3
        FROM
            bill_detail_permintaan_obat a
                LEFT JOIN
            bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
                LEFT JOIN
            master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
                LEFT JOIN
            master_obat d ON c.id_obat = d.id_obat
        WHERE
            d.id_obat = 21838
                AND a.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif),0) AS obat3,
    ifnull((SELECT 
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS alkes2
        FROM
            bill_detail_permintaan_obat a
                LEFT JOIN
            bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
                LEFT JOIN
            master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
                LEFT JOIN
            master_obat d ON c.id_obat = d.id_obat
        WHERE
            d.id_obat = 21835
                AND a.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif),0) AS alkes2,
    ifnull((SELECT 
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS alkes3
        FROM
            bill_detail_permintaan_obat a
                LEFT JOIN
            bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
                LEFT JOIN
            master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
                LEFT JOIN
            master_obat d ON c.id_obat = d.id_obat
        WHERE
            d.id_obat = 21836
                AND a.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif),0) AS alkes3,
    ifnull((SELECT 
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS kie
        FROM
            bill_detail_permintaan_obat a
                LEFT JOIN
            bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
                LEFT JOIN
            master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
                LEFT JOIN
            master_obat d ON c.id_obat = d.id_obat
        WHERE
            d.id_obat = 21830
                AND a.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif),0) AS kie,
    ifnull((SELECT 
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS puyer2
        FROM
            bill_detail_permintaan_obat a
                LEFT JOIN
            bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
                LEFT JOIN
            master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
                LEFT JOIN
            master_obat d ON c.id_obat = d.id_obat
        WHERE
            d.id_obat = 21833
                AND a.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif),0) AS puyer2,
    ifnull((SELECT 
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS puyer3
        FROM
            bill_detail_permintaan_obat a
                LEFT JOIN
            bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
                LEFT JOIN
            master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
                LEFT JOIN
            master_obat d ON c.id_obat = d.id_obat
        WHERE
            d.id_obat = 21834
                AND a.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif),0) AS puyer3,
    ifnull((SELECT 
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS cap2
        FROM
            bill_detail_permintaan_obat a
                LEFT JOIN
            bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
                LEFT JOIN
            master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
                LEFT JOIN
            master_obat d ON c.id_obat = d.id_obat
        WHERE
            d.id_obat = 21828
                AND a.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif),0) AS cap2,
    ifnull((SELECT 
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS cap3
        FROM
            bill_detail_permintaan_obat a
                LEFT JOIN
            bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
                LEFT JOIN
            master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
                LEFT JOIN
            master_obat d ON c.id_obat = d.id_obat
        WHERE
            d.id_obat = 21829
                AND a.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif),0) AS cap3,
    ifnull((SELECT 
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS crm2
        FROM
            bill_detail_permintaan_obat a
                LEFT JOIN
            bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
                LEFT JOIN
            master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
                LEFT JOIN
            master_obat d ON c.id_obat = d.id_obat
        WHERE
            d.id_obat = 21839
                AND a.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif),0) AS crm2,
    ifnull((SELECT 
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS crm3
        FROM
            bill_detail_permintaan_obat a
                LEFT JOIN
            bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
                LEFT JOIN
            master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
                LEFT JOIN
            master_obat d ON c.id_obat = d.id_obat
        WHERE
            d.id_obat = 21840
                AND a.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif),0) AS crm3,
    ifnull((SELECT 
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS sir2
        FROM
            bill_detail_permintaan_obat a
                LEFT JOIN
            bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
                LEFT JOIN
            master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
                LEFT JOIN
            master_obat d ON c.id_obat = d.id_obat
        WHERE
            d.id_obat = 21841
                AND a.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif),0) AS sir2,
    ifnull((SELECT 
            SUM(IFNULL(a.qty, 0) - IFNULL(b.qty, 0)) AS sir3
        FROM
            bill_detail_permintaan_obat a
                LEFT JOIN
            bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
                LEFT JOIN
            master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
                LEFT JOIN
            master_obat d ON c.id_obat = d.id_obat
        WHERE
            d.id_obat = 21842
                AND a.id_bill_detail_tarif = z.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif),0) AS sir3,
    DATEDIFF(z.tglout, z.tglreg) AS hari_berobat
FROM
    simrs.bill_detail_tarif z
        LEFT JOIN
    simrs2012.m_pasien b ON z.nomr = b.nomr
        LEFT JOIN
    simrs.userlevels c ON z.userlevelid = c.userlevelid
        LEFT JOIN
    simrs2012.m_carabayar u ON z.kdcarabayar = u.kode
        LEFT JOIN
    l_carabayar_group v ON u.payor_id = v.payor_id
WHERE
    (z.tglreg >= '$dari_tanggal'
        AND z.tglreg <= '$sampai_tanggal')
        AND v.payor_id = $kdcarabayar AND c.id_jenis_pelayanan_farmasi=$id_jenis_pelayanan_farmasi";
$queryitempasien = mysql_query($sqlitempasien);

$sqlusername="select a.pd_nickname,b.userlevelname from master_login a left join userlevels b on a.userlevelid=b.userlevelid where a.username=$username";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

$sqlpembayaran="select nama_carabayar_group from l_carabayar_group where payor_id=$kdcarabayar";
 $querypembayaran = mysql_query($sqlpembayaran);
 $DATA_PEMBAYARAN = mysql_fetch_array($querypembayaran);

?>



<html>
<head>
<meta charset="utf-8">
<title>Administrasi Pengeluaran Obat</title>
<style type="text/css">
	@page {
            margin-top: 0.1 cm;
            margin-left: 0.1 cm;
			margin-right: 0.1 cm;
			margin-bottom: 0.1 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 12px;
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
    <div align="center" class="header"><strong>LAPORAN PENDAPATAN BERDASARKAN PASIEN</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="12%">Filter</td>
      <td width="17%">&nbsp;</td>
      <td width="20%" align="right">Pembayaran</td>
      <td width="51%">: <?php echo $DATA_PEMBAYARAN['nama_carabayar_group']; ?></td>
    </tr>
    <tr>
      <td>Dari Tanggal</td>
      <td>: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td align="right">Sampai Tanggal</td>
      <td>: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>


<hr>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="2%" rowspan="2" align="center">No</td>
      <td width="7%" rowspan="2" align="center">Tgl</td>
      <td width="10%" rowspan="2" align="center">Nama</td>
      <td width="5%" rowspan="2" align="center">No RM</td>
      <td width="15%" rowspan="2" align="center">Unit</td>
      <td width="15%" rowspan="2" align="center">Alamat</td>
      <td width="8%" rowspan="2" align="center">Jasa</td>
      <td width="8%" rowspan="2" align="center">Obat</td>
      <td width="8%" rowspan="2" align="center">Total</td>
      <td colspan="2" align="center">Obat Jadi</td>
      <td width="3%" rowspan="2" align="center">KIE</td>
      <td colspan="4" align="center">Jasa Obat Racikan Kelas 2</td>
      <td colspan="4" align="center">Jasa Obat Racikan Kelas 3</td>
      <td colspan="2" align="center">JASA KELAS 2</td>
      <td colspan="2" align="center">JASA KELAS 3</td>
    </tr>
    <tr>
      <td width="3%" align="center">G</td>
      <td width="3%" align="center">P</td>
      <td width="3%" align="center">PYR</td>
      <td width="3%" align="center">CAP</td>
      <td width="3%" align="center">CRM</td>
      <td width="3%" align="center">SIR</td>
      
      <td width="3%" align="center">PYR</td>
      <td width="3%" align="center">CAP</td>
      <td width="3%" align="center">CRM</td>
      <td width="3%" align="center">SIR</td>
      
      <td width="8%" align="center">OBAT</td>
      <td width="8%" align="center">ALKES</td>
      <td width="6%" align="center">OBAT</td>
      <td width="6%" align="center">ALKES</td>
    </tr>
    
    <?php
	  $no=1;
      		while($data=mysql_fetch_assoc($queryitempasien)){
				echo '<tr>';
				echo '<td>'.$no.'</td>';
				echo '<td>'.$data['tglreg'].'</td>';
				echo '<td align="left">'.$data['nama'].'</td>';
				echo '<td align="left">'.$data['nomr'].'</td>';
				echo '<td align="left">'.$data['unit'].'</td>';
				echo '<td align="left">'.$data['alamat'].'</td>';
				echo '<td align="right">'.number_format($data['jasa'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['obat'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '<td align="left">'.$data['generic'].'</td>';
				echo '<td align="left">'.$data['paten'].'</td>';
				echo '<td align="left">'.$data['kie'].'</td>';
				echo '<td align="left">'.$data['puyer2'].'</td>';
				echo '<td align="left">'.$data['cap2'].'</td>';
				echo '<td align="left">'.$data['crm2'].'</td>';
				echo '<td align="left">'.$data['sir2'].'</td>';
				echo '<td align="left">'.$data['puyer3'].'</td>';
				echo '<td align="left">'.$data['cap3'].'</td>';
				echo '<td align="left">'.$data['crm3'].'</td>';
				echo '<td align="left">'.$data['sir3'].'</td>';
				
				echo '<td align="left">'.$data['obat2'].'</td>';
				echo '<td align="left">'.$data['obat3'].'</td>';
				
				echo '<td align="left">'.$data['alkes2'].'</td>';
				echo '<td align="left">'.$data['alkes3'].'</td>';
				
				echo '</tr>';
				
			$no++;
		}
		?>
    
  </tbody>
</table>

</body>
</html>



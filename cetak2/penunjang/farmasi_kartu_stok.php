<?php
ob_start();
session_start();
include('../connect.php');
$username = $_GET['username'];
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$id_master_obat_detail= $_GET['id_master_obat_detail'];

$sqlitemstok="SELECT 
    s.unit,
    date_format(s.tanggal, '%d-%m-%Y') as tanggal,
    @saldo_awal:=@saldo_awal AS stok_awal,
    s.stok_masuk,
    s.stok_keluar,
    (@saldo_awal:=@saldo_awal + s.stok_masuk - s.stok_keluar) AS stok_akhir
FROM
    (SELECT 
        (@sum:=@sum + a.qty_masuk) AS stok_akhir,
            a.qty_masuk AS stok_masuk,
            0 AS stok_keluar,
            c.userlevelname AS unit,
            b.tanggal_entri AS tanggal
    FROM
        simrs.bill_detail_pengambilan_obat a
    CROSS JOIN (SELECT @sum:=0) params
    LEFT JOIN simrs.bill_pengambilan_obat b ON a.id_bill_pengambilan_obat = b.id_bill_pengambilan_obat
    LEFT JOIN simrs.userlevels c ON b.userlevelid = c.userlevelid
    WHERE
        a.id_master_obat_detail = $id_master_obat_detail
            AND DATE(a.tanggal) >= '$dari_tanggal'
            AND DATE(a.tanggal) <= '$sampai_tanggal' UNION ALL SELECT 
        (@sum:=@sum - (a.qty - IFNULL(b.qty, 0))) AS stok_akhir,
            0 AS stok_masuk,
            a.qty - IFNULL(b.qty, 0) AS stok_keluar,
            CONCAT(d.nomr, ', ', d.nama, ', ', d.alamat, ', ', d.notelp) AS unit,
            c.tanggal AS tanggal
    FROM
        simrs.bill_detail_permintaan_obat a
    CROSS JOIN (SELECT @sum:=0) params
    LEFT JOIN simrs.bill_detail_permintaan_retur_obat b ON a.id_bill_detail_permintaan_obat = b.id_bill_detail_permintaan_obat
    LEFT JOIN simrs.bill_detail_permintaan_obat_master c ON c.id_bill_detail_permintaan_obat_master = a.id_bill_detail_permintaan_obat_master
    LEFT JOIN simrs2012.m_pasien d ON c.nomr = d.nomr
    WHERE
        a.id_master_obat_detail = $id_master_obat_detail
            AND DATE(c.tanggal) >= '$dari_tanggal'
            AND DATE(c.tanggal) <= '$sampai_tanggal'
    ORDER BY tanggal ASC) s,
    (SELECT 
        @saldo_awal:=(SELECT 
                    (IFNULL(e.qty_masuk, 0) - (IFNULL(f.qty_keluar, 0))) AS saldo_awal
                FROM
                    master_obat_detail a
                LEFT JOIN master_obat b ON a.id_obat = b.id_obat
                LEFT JOIN (SELECT 
                    SUM(qty_masuk) AS qty_masuk, id_master_obat_detail
                FROM
                    simrs.bill_detail_pengambilan_obat
                WHERE
                    DATE(tanggal) < '$dari_tanggal'
                GROUP BY id_master_obat_detail) e ON a.id_master_obat_detail = e.id_master_obat_detail
                LEFT JOIN (SELECT 
                    c.nama_obat,
                        SUM(a.qty) - IFNULL(SUM(d.qty), 0) AS qty_keluar,
                        a.id_master_obat_detail
                FROM
                    simrs.bill_detail_permintaan_obat a
                LEFT JOIN simrs.master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
                LEFT JOIN simrs.master_obat c ON b.id_obat = c.id_obat
                LEFT JOIN simrs.bill_detail_permintaan_retur_obat d ON a.id_bill_detail_permintaan_obat = d.id_bill_detail_permintaan_obat
                WHERE DATE(a.tanggal) < '$dari_tanggal'
                GROUP BY a.id_master_obat_detail) f ON a.id_master_obat_detail = f.id_master_obat_detail
                WHERE
                    a.id_master_obat_detail = $id_master_obat_detail)
    ) t";
$queryitemstok = mysql_query($sqlitemstok);

$sqlusername="select a.pd_nickname,b.userlevelname from master_login a left join userlevels b on a.userlevelid=b.userlevelid where a.username=$username";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

$sqlobat="SELECT
	b.nama_obat 
FROM
	simrs.master_obat_detail a
	LEFT JOIN simrs.master_obat b ON a.id_obat = b.id_obat 
WHERE
	a.id_master_obat_detail = $id_master_obat_detail";
 $queryobat = mysql_query($sqlobat);
 $DATA_OBAT = mysql_fetch_array($queryobat);

?>



<html>
<head>
<meta charset="utf-8">
<title>Laporan Kartu Stok</title>
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
	font-size: 10px;
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
    <div align="center" class="header"><strong>LAPORAN KARTU STOK</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="12%">Nama Obat</td>
      <td width="35%">: <?php echo $DATA_OBAT['nama_obat']; ?></td>
      <td width="13%">&nbsp;</td>
      <td width="40%">&nbsp;</td>
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
      <td width="4%">No.</td>
      <td width="10%">Tanggal</td>
      <td width="39%">Unit/Pasien</td>
      <td width="12%">Stok Awal</td>
      <td width="12%">Stok Masuk</td>
      <td width="11%">Stok Keluar</td>
      <td width="12%">Stok Akhir</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemstok)){
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td>'.$data['tanggal'].'</td>';
	  echo '<td>'.$data['unit'].'</td>';
	  echo '<td align="right">'.$data['stok_awal'].'</td>';
	  echo '<td align="right">'.$data['stok_masuk'].'</td>';
      echo '<td align="right">'.$data['stok_keluar']. '</td>';
	  echo '<td align="right">'.$data['stok_akhir'].'</td>';
	  echo '</tr>';
			$no++;
		}
	?>
   
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
$dompdf->stream('kartu_stok.pdf',array('Attachment' => 0));
?>


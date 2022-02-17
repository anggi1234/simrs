<?php
ob_start();

include('connect.php');
$IDXDAFTAR = $_GET['IDXDAFTAR'];

$sqlidentitas="select a.NOMR,date_format(b.TGLLAHIR, '%d-%m-%Y') as TGLLAHIR,b.NAMA,c.NAMA as 'STATUS', b.ALAMAT, d.nama as POLI, d.nama as NAMA_POLI, b.JENISKELAMIN,date_format(a.JAMREG, '%d-%m-%Y') AS TANGGALMASUK, a.biaya_obat_rajal as JUMLAH_UANG,a.biaya_retur_obat_rajal as TOTAL_RETUR,a.TOTAL_BIAYA_OBAT_RAJAL AS GRANDTOTAL,
BIAYA_TINDAKAN_POLI,BHP_RAJAL,BIAYA_TINDAKAN_POLI_KEPERAWATAN,BHP_RAJAL_KEPERAWATAN,BIAYA_TINDAKAN_POLI_PERSALINAN,BHP_RAJAL_PERSALINAN,BIAYA_TINDAKAN_POLI_TMO,BHP_RAJAL_TMO
from t_pendaftaran a left outer join m_pasien b on a.NOMR=b.NOMR 
LEFT OUTER JOIN m_carabayar c on a.KDCARABAYAR=c.KODE
LEFT OUTER JOIN m_poly d on a.KDPOLY=d.kode WHERE a.IDXDAFTAR=$IDXDAFTAR";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

$sqlitemtmno="SELECT 
        `a`.`IDXDAFTAR` AS `IDXDAFTAR`,
		 DATE(a.TANGGAL) AS TANGGAL,
        `c`.`nama` AS `POLI`,
        `d`.`NAMA` AS `TIPE`,
        (`b`.`TINDAKAN`) AS TINDAKAN,
        `a`.`QTY` AS `QTY`,
        `a`.`TARIF_TMNO` AS `TARIF`,
        `a`.`BHP` AS `BHP`,
        `a`.`TOTAL_TMNO` AS `TOTAL_TMNO`
    FROM
        (((`y_tindakan_diagnosa_tindakan` `a`
        LEFT JOIN `y_tmno_poli` `b` ON ((`a`.`ID_TMNO` = `b`.`ID_TMNO`)))
        LEFT JOIN `m_poly` `c` ON ((`a`.`KDPOLY` = `c`.`kode`)))
        LEFT JOIN `l_type_tmno_rajal` `d` ON ((`a`.`ID_TYPE_TMNO` = `d`.`ID_TYPE_TMNO`))) WHERE IDXDAFTAR=$IDXDAFTAR";
 $queryitemtmno = mysql_query($sqlitemtmno);

$sqlitemtmo="SELECT 
        `a`.`IDXDAFTAR` AS `IDXDAFTAR`,
		 DATE(a.TANGGAL) AS TANGGAL,
        `c`.`nama` AS `POLI`,
        `d`.`NAMA` AS `TIPE`,
        (`b`.`TINDAKAN`) AS TINDAKAN,
        `a`.`QTY` AS `QTY`,
        `a`.`TARIF_TMO` AS `TARIF`,
        `a`.`JASA_SARANA` AS `BHP`,
        `a`.`TOTAL_TMO` AS `TOTAL_TMNO`
    FROM
        (((`y_tindakan_tmo_poli` `a`
        LEFT JOIN `y_tmo_poli` `b` ON ((`a`.`ID_TMO` = `b`.`ID_TMO`)))
        LEFT JOIN `m_poly` `c` ON ((`a`.`KDPOLY` = `c`.`kode`)))
        LEFT JOIN `l_type_tmo_rajal` `d` ON ((`a`.`ID_TYPE_TMO` = `d`.`ID_TYPE_TMO`))) WHERE IDXDAFTAR=$IDXDAFTAR";
 $queryitemtmo = mysql_query($sqlitemtmo);


$sqlitempersalinan="SELECT 
        `a`.`IDXDAFTAR` AS `IDXDAFTAR`,
		 DATE(a.TANGGAL) AS TANGGAL,
        `c`.`nama` AS `POLI`,
        `d`.`NAMA` AS `TIPE`,
        (`b`.`TINDAKAN`) AS TINDAKAN,
        `a`.`QTY` AS `QTY`,
        `a`.`TARIF` AS `TARIF`,
        `a`.`BHP` AS `BHP`,
        `a`.`TOTAL` AS `TOTAL_TMNO`
    FROM
        (((`y_tindakan_persalinan` `a`
        LEFT JOIN `y_tmno_persalinan` `b` ON ((`a`.`ID_TMNO_PERSALINAN` = `b`.`ID_TMNO_PERSALINAN`)))
        LEFT JOIN `m_poly` `c` ON ((`a`.`KDPOLY` = `c`.`kode`)))
        LEFT JOIN `l_type_persalinan` `d` ON ((`a`.`ID_TYPE_PERSALINAN` = `d`.`ID_TYPE_PERSALINAN`))) WHERE IDXDAFTAR=$IDXDAFTAR";
 $queryitempersalinan = mysql_query($sqlitempersalinan);


$sqlitemkeperawatan="SELECT 
    `a`.`IDXDAFTAR` AS `IDXDAFTAR`,
    DATE(a.TANGGAL) AS TANGGAL,
    `c`.`nama` AS `POLI`,
    `d`.`NAMA` AS `TIPE`,
    (`b`.`TINDAKAN`) AS TINDAKAN,
    `a`.`QTY` AS `QTY`,
    `a`.`TARIF` AS `TARIF`,
    `a`.`BHP` AS `BHP`,
    `a`.`TOTAL` AS `TOTAL_TMNO`
FROM
    (((`y_tindakan_keperawatan` `a`
    LEFT JOIN `y_tmno_keperawatan` `b` ON ((`a`.`ID_TMNO_KEPERAWATAN` = `b`.`ID_TMNO_KEPERAWATAN`)))
    LEFT JOIN `m_poly` `c` ON ((`a`.`KDPOLY` = `c`.`kode`)))
    LEFT JOIN `l_type_tindakan_keperawatan_rajal` `d` ON ((`a`.`ID_TYPE_TMNO` = `d`.`ID_TYPE_TINDAKAN_KEPERAWATAN`)))
WHERE
    IDXDAFTAR =$IDXDAFTAR";
 $queryitemkeperawatan = mysql_query($sqlitemkeperawatan);






?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Rincian Pelayanan Rajal</title>
<style type="text/css">
.tabelfix {
    border-collapse:collapse;
	font-size: 12px;
}
tr.spaceUnder>td {
  padding-bottom: 4em;
}
.oke {
    border:none;
}
.a {
	font-size: 11px;
}
.footer {
	font-size: 12px;
}
.header {
	font-size: 12px;
}
.pagebreak { 
	page-break-before: always; 
}
	
	@page {
            margin-top: 0.1 cm;
            margin-left: 0.1 cm;
			margin-right: 0.1 cm;
			margin-bottom: 0.1 cm;
	}
	
</style>


</head>

<body>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td style="vertical-align:top">
      	
      	<table width="100%" border="0">
  <tr>
    <td class="header" width="3%"><img src="../../images/Icon/logobanyumas.png" width="76" height="70" /></td>
    <td class="header" width="100%">
      <div align="center">
        <strong>PEMERINTAH KABUPATEN BANYUMAS</strong><br />
        <strong>RUMAH SAKIT UMUM DAERAH AJIBARANG</strong><br />
        Jl. Raya Pancasan - Ajibarang, Kode Pos 53163 Telp. (0281)6570004, Fax (0281)5670005<br />      
        Email: rsudajibarang@banyumaskab.go.id
      </div>
    </td>
  </tr>
</table>
<hr>
<table width="100%" height="52" border="0">
  <tr>
    <td width="100%" class="header"><div align="center"><strong>RINCIAN BIAYA TINDAKAN NON OPERATIF IGD</strong></div></td>
  </tr>
</table>
<table width="100%" class="footer" border="0">
    <tr>
      <td width="18%">No. RM</td>
      <td width="27%">: <?php echo $DATA_IDENTITAS['NOMR']; ?></td>
      <td width="19%">Alamat</td>
      <td width="36%">: <?php echo $DATA_IDENTITAS['ALAMAT']; ?></td>
    </tr>
    <tr>
      <td>Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['NAMA']; ?></td>
      <td>Status Pembayaran </td>
      <td>: <?php echo $DATA_IDENTITAS['STATUS']; ?></td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS['TGLLAHIR']; ?></td>
      <td>Poli Klinik</td>
      <td>: <?php echo $DATA_IDENTITAS['POLI']; ?></td>
  </tr>
    <tr>
      <td>Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS['JENISKELAMIN']; ?></td>
      <td>Tanggal Berobat</td>
      <td>: <?php echo $DATA_IDENTITAS['TANGGALMASUK']; ?></td>
    </tr>
</table>
<hr>


<table width="100%" class="tabelfix" border="1">
  <tbody>
    <tr>
      <td width="2%"><strong>No</strong></td>
      <td width="7%"><strong>Tanggal</strong></td>
      <td width="30%"><strong>Tindakan</strong></td>
      <td width="5%"><strong>Jml</strong></td>
      <td width="5%"><strong>Kategori</strong></td>
      <td width="10%"><strong>Biaya</strong></td>
      <td width="10%"><strong>BHP</strong></td>
    </tr>
   <?php
	if(mysql_num_rows($queryitemtmno)==0){
		echo '<tr><td colspan="7">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitemtmno)){
			echo '<tr>';
	  echo '<td class="a oke">'.$no.'</td>';
      echo '<td class="a oke">'.$data['TANGGAL'].'</td>';
	  echo '<td class="a oke">'.$data['TINDAKAN'].'</td>';
	  echo '<td class="a oke">'.$data['QTY'].'</td>';
      echo '<td class="a oke">'.$data['TIPE']. '</td>';
	  echo '<td class="a oke"><div align="right">'.number_format($data['TARIF'], 2,",",".").'</div></td>';
      echo '<td class="a oke"><div align="right">'.number_format($data['BHP'], 2,",",".").'</div></td>';
			echo '</tr>';
			
			$no++;
		}
	}
    
	?>
    <tr>
      <td colspan="5" align="right"><strong>JUMLAH</strong></td>
      <td align="right"><strong>Rp.<?php echo number_format($DATA_IDENTITAS['BIAYA_TINDAKAN_POLI'], 0,",","."); ?></strong></td>
      <td align="right"><strong>Rp.<?php echo number_format($DATA_IDENTITAS['BHP_RAJAL'], 0,",","."); ?></strong></td>
    </tr>
  </tbody>
</table>



<table width="100%">
	<tr>
    <td width="29%">&nbsp;</td>
    <td width="39%">&nbsp;</td>
    <td width="32%" align="right">Ajibarang, <?php echo date("d-m-Y") ?></td>
  </tr>
	<tr>
	  <td align="center">Petugas Kasir</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">Administrasi IGD</td>
  </tr>
	<tr>
	  <td align="center"><p>&nbsp;</p>
      <p>&nbsp;</p></td>
	  <td align="center">&nbsp;</td>
	  <td align="center"><p>&nbsp;</p></td>
  </tr>
	<tr>
	  <td align="center">(...............................)</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">(......................................)</td>
  </tr>
</table>
      	
      	
      </td>  
      <td style="vertical-align:top">
      	
      	
      	
      	<table width="100%" border="0">
  <tr>
    <td class="header" width="3%"><img src="../../images/Icon/logobanyumas.png" width="76" height="70" /></td>
    <td class="header" width="100%">
      <div align="center">
        <strong>PEMERINTAH KABUPATEN BANYUMAS</strong><br />
        <strong>RUMAH SAKIT UMUM DAERAH AJIBARANG</strong><br />
        Jl. Raya Pancasan - Ajibarang, Kode Pos 53163 Telp. (0281)6570004, Fax (0281)5670005<br />      
        Email: rsudajibarang@banyumaskab.go.id
      </div>
    </td>
  </tr>
</table>
<hr>
<table width="100%" height="52" border="0">
  <tr>
    <td width="100%" class="header"><div align="center"><strong>RINCIAN BIAYA TINDAKAN OPERATIF IGD</strong></div></td>
  </tr>
</table>
<table width="100%" class="footer" border="0">
    <tr>
      <td width="18%">No. RM</td>
      <td width="27%">: <?php echo $DATA_IDENTITAS['NOMR']; ?></td>
      <td width="19%">Alamat</td>
      <td width="36%">: <?php echo $DATA_IDENTITAS['ALAMAT']; ?></td>
    </tr>
    <tr>
      <td>Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['NAMA']; ?></td>
      <td>Status Pembayaran </td>
      <td>: <?php echo $DATA_IDENTITAS['STATUS']; ?></td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS['TGLLAHIR']; ?></td>
      <td>Poli Klinik</td>
      <td>: <?php echo $DATA_IDENTITAS['POLI']; ?></td>
  </tr>
    <tr>
      <td>Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS['JENISKELAMIN']; ?></td>
      <td>Tanggal Berobat</td>
      <td>: <?php echo $DATA_IDENTITAS['TANGGALMASUK']; ?></td>
    </tr>
</table>
<hr>


<table width="100%" class="tabelfix" border="1">
  <tbody>
    <tr>
      <td width="2%"><strong>No</strong></td>
      <td width="7%"><strong>Tanggal</strong></td>
      <td width="30%"><strong>Tindakan</strong></td>
       <td width="5%"><strong>Jml</strong></td>
      <td width="5%"><strong>Kategori</strong></td>
      <td width="10%"><strong>Biaya</strong></td>
      <td width="10%"><strong>BHP</strong></td>
    </tr>
    <?php
	if(mysql_num_rows($queryitemtmo)==0){
		echo '<tr><td colspan="7">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitemtmo)){
			echo '<tr>';
	  echo '<td class="a oke">'.$no.'</td>';
      echo '<td class="a oke">'.$data['TANGGAL'].'</td>';
	  echo '<td class="a oke">'.$data['TINDAKAN'].'</td>';
	  echo '<td class="a oke">'.$data['QTY'].'</td>';
      echo '<td class="a oke">'.$data['TIPE']. '</td>';
	  echo '<td class="a oke"><div align="right">'.number_format($data['TARIF'], 2,",","."). '</div></td>';
      echo '<td class="a oke"><div align="right">'.number_format($data['BHP'], 2,",","."). '</div></td>';
			echo '</tr>';
			
			$no++;
		}
	}
    
	?>
    <tr>
      <td colspan="5" align="right"><strong>JUMLAH</strong></td>
      <td align="right"><strong>Rp.<?php echo number_format($DATA_IDENTITAS['BIAYA_TINDAKAN_POLI_TMO'], 0,",","."); ?></strong></td>
      <td align="right"><strong>Rp.<?php echo number_format($DATA_IDENTITAS['BHP_RAJAL_TMO'], 0,",","."); ?></strong></td>
    </tr>
  </tbody>
</table>


<table width="100%">
	<tr>
    <td width="29%">&nbsp;</td>
    <td width="39%">&nbsp;</td>
    <td width="32%" align="right">Ajibarang, <?php echo date("d-m-Y") ?></td>
  </tr>
	<tr>
	  <td align="center">Petugas Kasir</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">Administrasi IGD</td>
  </tr>
	<tr>
	  <td align="center"><p>&nbsp;</p>
      <p>&nbsp;</p></td>
	  <td align="center">&nbsp;</td>
	  <td align="center"><p>&nbsp;</p></td>
  </tr>
	<tr>
	  <td align="center">(...............................)</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">(......................................)</td>
  </tr>
</table>
      	
      	
      	
      	
      </td>
    </tr>
  </tbody>
</table>

<div class="pagebreak"> </div>


<table width="100%" border="0">
  <tbody>
    <tr>
      <td style="vertical-align:top">
      	
      	<table width="100%" border="0">
  <tr>
    <td class="header" width="3%"><img src="../../images/Icon/logobanyumas.png" width="76" height="70" /></td>
    <td class="header" width="100%">
      <div align="center">
        <strong>PEMERINTAH KABUPATEN BANYUMAS</strong><br />
        <strong>RUMAH SAKIT UMUM DAERAH AJIBARANG</strong><br />
        Jl. Raya Pancasan - Ajibarang, Kode Pos 53163 Telp. (0281)6570004, Fax (0281)5670005<br />      
        Email: rsudajibarang@banyumaskab.go.id
      </div>
    </td>
  </tr>
</table>
<hr>
<table width="100%" height="52" border="0">
  <tr>
    <td width="100%" class="header"><div align="center"><strong>RINCIAN BIAYA TINDAKAN KEPERAWATAN</strong></div></td>
  </tr>
</table>
<table width="100%" class="footer" border="0">
    <tr>
      <td width="18%">No. RM</td>
      <td width="27%">: <?php echo $DATA_IDENTITAS['NOMR']; ?></td>
      <td width="19%">Alamat</td>
      <td width="36%">: <?php echo $DATA_IDENTITAS['ALAMAT']; ?></td>
    </tr>
    <tr>
      <td>Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['NAMA']; ?></td>
      <td>Status Pembayaran </td>
      <td>: <?php echo $DATA_IDENTITAS['STATUS']; ?></td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS['TGLLAHIR']; ?></td>
      <td>Poli Klinik</td>
      <td>: <?php echo $DATA_IDENTITAS['POLI']; ?></td>
  </tr>
    <tr>
      <td>Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS['JENISKELAMIN']; ?></td>
      <td>Tanggal Berobat</td>
      <td>: <?php echo $DATA_IDENTITAS['TANGGALMASUK']; ?></td>
    </tr>
</table>
<hr>


<table width="100%" class="tabelfix" border="1">
  <tbody>
    <tr>
      <td width="2%"><strong>No</strong></td>
      <td width="7%"><strong>Tanggal</strong></td>
      <td width="30%"><strong>Tindakan</strong></td>
      <td width="5%"><strong>Jml</strong></td>
      <td width="5%"><strong>Kategori</strong></td>
      <td width="10%"><strong>Biaya</strong></td>
      <td width="10%"><strong>BHP</strong></td>
    </tr>
   <?php
	if(mysql_num_rows($queryitemkeperawatan)==0){
		echo '<tr><td colspan="7">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitemkeperawatan)){
			echo '<tr>';
	  echo '<td class="a oke">'.$no.'</td>';
      echo '<td class="a oke">'.$data['TANGGAL'].'</td>';
	  echo '<td class="a oke">'.$data['TINDAKAN'].'</td>';
	  echo '<td class="a oke">'.$data['QTY']. '</td>';
      echo '<td class="a oke">'.$data['TIPE']. '</td>';
	  echo '<td class="a oke"><div align="right">'.number_format($data['TARIF'], 2,",",".").'</div></td>';
      echo '<td class="a oke"><div align="right">'.number_format($data['BHP'], 2,",",".").'</div></td>';
			echo '</tr>';
			
			$no++;
		}
	}
    
	?>
    <tr>
      <td colspan="5" align="right"><strong>JUMLAH</strong></td>
      <td align="right"><strong>Rp.<?php echo number_format($DATA_IDENTITAS['BIAYA_TINDAKAN_POLI_KEPERAWATAN'], 0,",","."); ?></strong></td>
      <td align="right"><strong>Rp.<?php echo number_format($DATA_IDENTITAS['BHP_RAJAL_KEPERAWATAN'], 0,",","."); ?></strong></td>
    </tr>
  </tbody>
</table>



<table width="100%">
	<tr>
    <td width="29%">&nbsp;</td>
    <td width="39%">&nbsp;</td>
    <td width="32%" align="right">Ajibarang, <?php echo date("d-m-Y") ?></td>
  </tr>
	<tr>
	  <td align="center">Petugas Kasir</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">Administrasi IGD</td>
  </tr>
	<tr>
	  <td align="center"><p>&nbsp;</p>
      <p>&nbsp;</p></td>
	  <td align="center">&nbsp;</td>
	  <td align="center"><p>&nbsp;</p></td>
  </tr>
	<tr>
	  <td align="center">(...............................)</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">(......................................)</td>
  </tr>
</table>
      	
      	
      </td>  
      <td style="vertical-align:top">
      	
      	
      	
      	<table width="100%" border="0">
  <tr>
    <td class="header" width="3%"><img src="../../images/Icon/logobanyumas.png" width="76" height="70" /></td>
    <td class="header" width="100%">
      <div align="center">
        <strong>PEMERINTAH KABUPATEN BANYUMAS</strong><br />
        <strong>RUMAH SAKIT UMUM DAERAH AJIBARANG</strong><br />
        Jl. Raya Pancasan - Ajibarang, Kode Pos 53163 Telp. (0281)6570004, Fax (0281)5670005<br />      
        Email: rsudajibarang@banyumaskab.go.id
      </div>
    </td>
  </tr>
</table>
<hr>
<table width="100%" height="52" border="0">
  <tr>
    <td width="100%" class="header"><div align="center"><strong>RINCIAN BIAYA TINDAKAN PERSALINAN</strong></div></td>
  </tr>
</table>
<table width="100%" class="footer" border="0">
    <tr>
      <td width="18%">No. RM</td>
      <td width="27%">: <?php echo $DATA_IDENTITAS['NOMR']; ?></td>
      <td width="19%">Alamat</td>
      <td width="36%">: <?php echo $DATA_IDENTITAS['ALAMAT']; ?></td>
    </tr>
    <tr>
      <td>Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['NAMA']; ?></td>
      <td>Status Pembayaran </td>
      <td>: <?php echo $DATA_IDENTITAS['STATUS']; ?></td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS['TGLLAHIR']; ?></td>
      <td>Poli Klinik</td>
      <td>: <?php echo $DATA_IDENTITAS['POLI']; ?></td>
  </tr>
    <tr>
      <td>Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS['JENISKELAMIN']; ?></td>
      <td>Tanggal Berobat</td>
      <td>: <?php echo $DATA_IDENTITAS['TANGGALMASUK']; ?></td>
    </tr>
</table>
<hr>


<table width="100%" class="tabelfix" border="1">
  <tbody>
    <tr>
      <td width="2%"><strong>No</strong></td>
      <td width="7%"><strong>Tanggal</strong></td>
      <td width="30%"><strong>Tindakan</strong></td>
      <td width="5%"><strong>Jml</strong></td>
      <td width="5%"><strong>Kategori</strong></td>
      <td width="10%"><strong>Biaya</strong></td>
      <td width="10%"><strong>BHP</strong></td>
    </tr>
    <?php
	if(mysql_num_rows($queryitempersalinan)==0){
		echo '<tr><td colspan="7">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitempersalinan)){
			echo '<tr>';
	  echo '<td class="a oke">'.$no.'</td>';
      echo '<td class="a oke">'.$data['TANGGAL'].'</td>';
	  echo '<td class="a oke">'.$data['TINDAKAN'].'</td>';
	echo '<td class="a oke">'.$data['QTY'].'</td>';
      echo '<td class="a oke">'.$data['TIPE']. '</td>';
	  echo '<td class="a oke"><div align="right">'.number_format($data['TARIF'], 2,",","."). '</div></td>';
      echo '<td class="a oke"><div align="right">'.number_format($data['BHP'], 2,",","."). '</div></td>';
			echo '</tr>';
			
			$no++;
		}
	}
    
	?>
    <tr>
      <td colspan="5" align="right"><strong>JUMLAH</strong></td>
      <td align="right"><strong>Rp.<?php echo number_format($DATA_IDENTITAS['BIAYA_TINDAKAN_POLI_PERSALINAN'], 0,",","."); ?></strong></td>
      <td align="right"><strong>Rp.<?php echo number_format($DATA_IDENTITAS['BHP_RAJAL_PERSALINAN'], 0,",","."); ?></strong></td>
    </tr>
  </tbody>
</table>


<table width="100%">
	<tr>
    <td width="29%">&nbsp;</td>
    <td width="39%">&nbsp;</td>
    <td width="32%" align="right">Ajibarang, <?php echo date("d-m-Y") ?></td>
  </tr>
	<tr>
	  <td align="center">Petugas Kasir</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">Administrasi IGD</td>
  </tr>
	<tr>
	  <td align="center"><p>&nbsp;</p>
      <p>&nbsp;</p></td>
	  <td align="center">&nbsp;</td>
	  <td align="center"><p>&nbsp;</p></td>
  </tr>
	<tr>
	  <td align="center">(...............................)</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">(......................................)</td>
  </tr>
</table>
      	
      	
      	
      	
      </td>
    </tr>
  </tbody>
</table>

</body>
</html>


<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 12.90 * 72); // 12" x 12"
$dompdf->set_paper($paper_size, 'landscape');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('biaya_adm_igd.pdf',array('Attachment' => 0));
?>
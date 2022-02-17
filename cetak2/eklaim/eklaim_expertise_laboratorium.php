<?php
include('../connect.php');
$id_bill_detail_tarif_detail = $_GET['id_bill_detail_tarif_detail'];

$sqlidentitas="SELECT 
    a.nomr,
    b.nama,
    b.alamat,
    b.tgllahir,
    d.nama AS carabayar,
    a.tglreg,
    c.nama_dokter,
    b.jeniskelamin,
    e.userlevelname,
	a.tglreg,
	z.tanggal_input,
	    CONCAT(SUBSTRING(f.validated_on, 1, 4),
            '-',
            SUBSTRING(f.validated_on, 5, 2),
            '-',
            SUBSTRING(f.validated_on, 7, 2),
            ' ',
            SUBSTRING(f.validated_on, 9, 2),
            ':',
            SUBSTRING(f.validated_on, 11, 2),
            ':',
            SUBSTRING(f.validated_on, 13, 2)) AS pelaporan,f.lno
FROM
	simrs.bill_detail_tarif_detail z 
		LEFT JOIN
    simrs.bill_detail_tarif a on z.id_bill_detail_tarif=a.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs.m_dokter c ON a.kddokter = c.kddokter
        AND a.userlevelid = c.userlevelid
        LEFT JOIN
    simrs2012.m_carabayar d ON a.kdcarabayar = d.kode
        LEFT JOIN
    simrs.userlevels e ON a.userlevelid = e.userlevelid
		LEFT JOIN 
	simrs.labresult_details f on f.ono=z.id_bill_detail_tarif_detail
WHERE
    z.id_bill_detail_tarif_detail = $id_bill_detail_tarif_detail limit 1";
$queryidentitas = mysql_query($sqlidentitas);
$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

$sqldpjp="SELECT 
    c.pd_nickname, c.signature, c.no_surat_izin_praktek
FROM
    simrs.bill_detail_tarif_detail a
        LEFT JOIN
    simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
        LEFT JOIN
    simrs.master_login c ON b.kddokter = c.kddokter
WHERE
    a.id_bill_detail_tarif_detail = $id_bill_detail_tarif_detail";
$querydpjp = mysql_query($sqldpjp);
$DATA_DPJP = mysql_fetch_array($querydpjp);


$sqlitem="SELECT 
    test_name, result_value, unit, reference_range, CASE
        WHEN flag = 'N' THEN ''
        WHEN flag = 'L' THEN 'L'
        WHEN flag = 'H' THEN 'H'
    END AS flag,SUBSTRING_INDEX(validated_by,'^',-1) as validated_by,test_comment
FROM
    simrs.labresult_details a
        LEFT JOIN
    simrs.bill_detail_tarif_detail b ON a.ono = b.id_bill_detail_tarif_detail
WHERE
    b.id_bill_detail_tarif_detail = $id_bill_detail_tarif_detail";
$queryitem = mysql_query($sqlitem);
$queryitem1 = mysql_query($sqlitem);
$DATA_ITEM = mysql_fetch_array($queryitem1);

function Terbilang($nilai) {
  $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
  if($nilai==0){
    return "";
  }elseif ($nilai < 12&$nilai!=0) {
    return "" . $huruf[$nilai];
  } elseif ($nilai < 20) {
    return Terbilang($nilai - 10) . " Belas ";
  } elseif ($nilai < 100) {
    return Terbilang($nilai / 10) . " Puluh " . Terbilang($nilai % 10);
  } elseif ($nilai < 200) {
    return " Seratus " . Terbilang($nilai - 100);
  } elseif ($nilai < 1000) {
    return Terbilang($nilai / 100) . " Ratus " . Terbilang($nilai % 100);
  } elseif ($nilai < 2000) {
    return " Seribu " . Terbilang($nilai - 1000);
  } elseif ($nilai < 1000000) {
    return Terbilang($nilai / 1000) . " Ribu " . Terbilang($nilai % 1000);
  } elseif ($nilai < 1000000000) {
    return Terbilang($nilai / 1000000) . " Juta " . Terbilang($nilai % 1000000);
  }elseif ($nilai < 1000000000000) {
    return Terbilang($nilai / 1000000000) . " Milyar " . Terbilang($nilai % 1000000000);
  }elseif ($nilai < 100000000000000) {
    return Terbilang($nilai / 1000000000000) . " Trilyun " . Terbilang($nilai % 1000000000000);
  }elseif ($nilai <= 100000000000000) {
    return "Maaf Tidak Dapat di Prose Karena Jumlah nilai Terlalu Besar ";
  }
}

?>

  <style type="text/css">
    @page {
      margin-top: 0.5 cm;
      margin-left: 0.5 cm;
      margin-right: 0.5 cm;
      margin-bottom: 0.5 cm;
      font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
    }

    .tabel {
      border-collapse: collapse;
      font-size: 12px;
      text-align: right;
    }  

    .header {
      font-size: 12px;
    } 
    .footer {
      font-size: 10px;
    }

    .pagebreak { 
      page-break-before: always;
    }

  </style>

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
  <table width="100%" border="0" cellspacing="2">
    <tbody style="font-size: 12px">
      <tr>
        <td width="12%">Dokter</td>
        <td width="1%">:</td>
        <td width="43%"><?php echo $DATA_IDENTITAS['nama_dokter']; ?></td>
        <td width="17%">Bangsal/Poli</td>
        <td width="0%">:</td>
        <td width="27%"><?php echo $DATA_IDENTITAS['userlevelname'];?></td>
      </tr>
      <tr>
        <td>Pasien</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['nama']; ?></td>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['jeniskelamin']; ?></td>
      </tr>
      <tr>
        <td>No.Lab</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['lno'];?></td>
        <td>Tgl.Lahir/Umur</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
      </tr>
      <tr>
        <td valign="top">No.RM</td>
        <td valign="top">:</td>
        <td valign="top"><?php echo $DATA_IDENTITAS['nomr']; ?></td>
        <td valign="top">Tanggal Terima</td>
        <td valign="top">:</td>
        <td valign="top"><?php echo $DATA_IDENTITAS['tanggal_input']; ?></td>
      </tr>
      <tr>
        <td>Tgl. Registrasi</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['tglreg'];?> </td>
        <td>Tanggal Pelaporan</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['pelaporan']; ?></td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>:</td>
        <td colspan="4"><?php echo $DATA_IDENTITAS['alamat'];?></td>
      </tr>
    </tbody>
  </table>

  <br>

<table width="100%" border="0" class="tabel">
  <tbody>
    <tr>
      <td width="47%" align="left"><strong>Pemeriksaan</strong></td>
      <td width="2%" align="right">&nbsp;</td>
      <td width="18%" align="center"><strong>Hasil</strong></td>
      <td width="14%" align="center"><strong>Satuan</strong></td>
      <td width="19%" align="center"><strong>Nilai Normal</strong></td>
    </tr>
    <?php
	while($data=mysql_fetch_assoc($queryitem)){
		
		$bg_colorkonfirmasi=(($data['flag'] == "N") ? 'normal;' :
(($data['flag'] == "H" || $data['flag'] == "L") ? 'bold;' : ""));	

			echo '<tr>';
      echo '<td align="left">'.$data['test_name'].'<br><strong>'.$data['test_comment'].'</strong></td>';
		echo '<td align="left">'.$data['flag'].'</td>';
      echo '<td align="center" style="font-weight: '.$bg_colorkonfirmasi.'">'.$data['result_value'].'</td>';
      echo '<td align="center">'.$data['unit'].'</td>';
	  echo '<td align="center">'.$data['reference_range'].'</td>';
			echo '</tr>';
		}
	?>
  </tbody>
</table> 

<?php
 $sqlusernamedokter="SELECT signature FROM simrs.master_login where uid=73";
 $queryusernamedokter = mysql_query($sqlusernamedokter);
 $DATA_USERNAMEDOKTER = mysql_fetch_array($queryusernamedokter);	
?>

<?php
$sqlhitung="SELECT 
    count(*) as hitung
FROM
    simrs.bill_detail_tarif_detail a
WHERE
    a.id_bill_detail_tarif_detail = $id_bill_detail_tarif_detail and verifikasi_dpjp='Yes'";
$queryhitung = mysql_query($sqlhitung);
$DATA_HITUNG = mysql_fetch_array($queryhitung);
	
	if($DATA_HITUNG["hitung"]==1){
		$statushitung="inline";
	}else{
		$statushitung="none";
	}
?>
	<div style="display: <?php echo $statushitung ?>">
	<div align="right" style="position: relative; font-size: 12px">
		<div style="position: absolute; bottom: 30px;">
		<div align="center">
			  Diverifikasi Oleh DPJP,
			 <br><img height="70px" src="../../uploads/<?php echo $DATA_DPJP['signature']; ?>"/><br>
			<?php echo $DATA_DPJP['pd_nickname']; ?><br><?php echo $DATA_DPJP['no_surat_izin_praktek']; ?>
			</div>
		</div>
	</div>
	</div>

	<div align="right" style="position: relative; font-size: 12px">
		<div style="position: absolute; bottom: 5px;">
		<div align="left">
			  Validasi,
		  <br><img height="70px" src="../../uploads/<?php echo $DATA_USERNAMEDOKTER['signature']; ?>"/><br>
			dr. I.Edward KSL., Sp.PK
			<br>
			Catatan: Jika ada keragu-raguan pemeriksaan, segera menghubungi laboratorium
		  </div>
		</div>
	</div>
 
  
<br>
  	<div align="right" style="position: relative; font-size: 12px">
		<div style="position: absolute; bottom: 5px;">
		<div align="right">
			  Diverifikasi oleh,
			 <br><br><br>
			<?php echo $DATA_ITEM['validated_by']; ?>
			</div>
		</div>
	</div>	
	
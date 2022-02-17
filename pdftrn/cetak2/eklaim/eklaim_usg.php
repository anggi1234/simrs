<?php
include('../connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];

$sqlcrot = mysql_query("SELECT 
    b.nomr,
    c.nama_dokter,
    b.tgllahir,
    d.NAMA,
    d.JENISKELAMIN AS jk,
    e.NAMA AS carabayar,
    f.userlevelname AS ruangrawat,
    a.*,
    g.signature,
	concat(ifnull(a.saran,''),'',ifnull(a.kesimpulan,'')) as sarankesimpulan
FROM
    simrs.bill_detail_keterangan_usg a
        LEFT JOIN
    simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
        LEFT JOIN
    simrs.m_dokter c ON b.kddokter = c.kddokter
        AND b.userlevelid = c.userlevelid
        LEFT JOIN
    simrs2012.m_pasien d ON d.NOMR = b.nomr
        LEFT JOIN
    simrs2012.m_carabayar e ON e.KODE = b.kdcarabayar
        LEFT JOIN
    simrs.userlevels f ON f.userlevelid = b.userlevelid
        LEFT JOIN
    simrs.master_login g ON b.kddokter = g.kddokter
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif");
$DATA_IDENTITAS = mysql_fetch_array($sqlcrot);

?>

<div class="pagebreak"></div>
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
	<div align="center"><strong>HASIL BACAAN USG KEBIDANAN</strong></div>
	<div style="font-size: 10px">
	<table width="100%" border="0" cellspacing="2">
		<tbody style="font-size: 12px">
			<tr>
				<td width="4%">&nbsp;</td>
				<td width="30%">Dokter</td>
				<td width="1%">:</td>
				<td width="70%"><?php echo $DATA_IDENTITAS['nama_dokter']; ?></td>
				<td width="4%">&nbsp;</td>
				<td width="25%">NO RM</td>
				<td width="1%">:</td>
				<td width="70%"><?php echo $DATA_IDENTITAS['nomr']; ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Tgl Pemeriksaan</td>
				<td>:</td>
				<td><?php echo $DATA_IDENTITAS['tanggal']; ?></td>
				<td width="4%">&nbsp;</td>
				<td>Nama</td>
				<td>:</td>
				<td><?php echo $DATA_IDENTITAS['NAMA']; ?></td>
				<td align="left"><?php echo $DATA_IDENTITAS['jk']; ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Ruang Rawat</td>
				<td>:</td>
				<td><?php echo $DATA_IDENTITAS['ruangrawat'] ?> </td>
				<td width="4%">&nbsp;</td>
				<td>Tgl lahir</td>
				<td>:</td>
				<td><?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td valign="top">Status Pembiayaan</td>
				<td valign="top">:</td>
				<td valign="top"><?php echo $DATA_IDENTITAS['carabayar']; ?></td>
			</tr>
		</tbody>
	</table>
</div>
	<br>

	<table width="100%" border="0" cellspacing="2">
		<tbody style="font-size: 10px">
			<tr>
				<td width="4%">&nbsp;</td>
				<td width="25%">1. Janin</td>
				<td width="1%">:</td>
				<td width="70%"><?php echo $DATA_IDENTITAS['janin']; ?></td>

			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>2. Letak/Presentasi</td>
				<td>:</td>
				<td><?php echo $DATA_IDENTITAS['letak']; ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>3. Denyut Jantung Janin</td>
				<td>:</td>
				<td><?php echo $DATA_IDENTITAS['denyut'] ?> </td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>4. TBJ</td>
				<td>:</td>
				<td><?php echo $DATA_IDENTITAS['tbj']; ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>5. Plasenta</td>
				<td>:</td>
				<td><?php echo $DATA_IDENTITAS['plasenta'] ?> </td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>6. Indexs Cairan Amnion</td>
				<td>:</td>
				<td><?php echo $DATA_IDENTITAS['amnion']; ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>7. Jenis Kelamin</td>
				<td>:</td>
				<td><?php echo $DATA_IDENTITAS['jenis_kelamin'] ?> </td>
			</tr>

		</tbody>
	</table>
	<br> 
	<table width="100%" border="0"  style="font-size: 12px">
		<tbody>
			<tr>
				<td align="center" width="20%">Saran dan Kesimpulan</td>
				<td colspan="6" style="font-size: 12px" align="left" width="40%">: <?php echo $DATA_IDENTITAS['sarankesimpulan']; ?></strong></td>
				<td align="center" class="footer" width="40%"><u>Dokter Pemeriksa</u></td>
			</tr>
			<tr>
				<td align="center">&nbsp;</td>
				<td colspan="6" align="right">&nbsp;</td>
				<td align="center"><img  height="100px" src="../../uploads/<?php echo $DATA_IDENTITAS['signature'];?>"></td>
			</tr>
			<tr>
				<td align="center">&nbsp;</td>
				<td colspan="6" align="right">&nbsp;</td>
				<td align="center">(<?php echo $DATA_IDENTITAS['nama_dokter']; ?>)</td>
			</tr>
			
		</tbody>
	</table>
	<!-- <div class="pagebreak"></div> -->
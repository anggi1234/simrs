<?php
ob_start();
session_start();
include 'connect.php';
$id_bill_detail_keterangan_usg = $_GET['id_bill_detail_keterangan_usg'];
$idxdaftar = $_GET['idxdaftar'];
//$idxdaftar = 665939;

$sqlcrot = mysqli_query($mysqli, "SELECT
    b.nomr,
    c.nama_dokter,
    b.pasien_tgl_lahir,
    d.NAMA,
    d.JENISKELAMIN AS jk,
    e.NAMA AS carabayar,
    f.userlevelname AS ruangrawat,
    a.*,
    g.signature,
	concat(ifnull(a.saran,''),'',ifnull(a.kesimpulan,'')) as sarankesimpulan
FROM
    data_keterangan_usg a
        LEFT JOIN
    data b ON a.idxdaftar = b.idxdaftar
        LEFT JOIN
    m_dokter c ON b.kddokter = c.kddokter
        AND b.userlevelid = c.userlevelid
        LEFT JOIN
    m_pasien d ON d.NOMR = b.nomr
        LEFT JOIN
    m_carabayar e ON e.KODE = b.kdcarabayar
        LEFT JOIN
    userlevels f ON f.userlevelid = b.userlevelid
        LEFT JOIN
    master_login g ON b.kddokter = g.kddokter
WHERE
    a.idxdaftar = $idxdaftar");
$DATA_IDENTITAS = mysqli_fetch_array($sqlcrot);

function Terbilang($nilai) {
    $huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
    if ($nilai == 0) {
        return "";
    } elseif ($nilai < 12 & $nilai != 0) {
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
    } elseif ($nilai < 1000000000000) {
        return Terbilang($nilai / 1000000000) . " Milyar " . Terbilang($nilai % 1000000000);
    } elseif ($nilai < 100000000000000) {
        return Terbilang($nilai / 1000000000000) . " Trilyun " . Terbilang($nilai % 1000000000000);
    } elseif ($nilai <= 100000000000000) {
        return "Maaf Tidak Dapat di Prose Karena Jumlah nilai Terlalu Besar ";
    }
}

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Hasil Bacaan USG</title>
	<style type="text/css">
		@page {
			margin-top: 0.5 cm;
			margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
			font-size: 10px
		}

		.tabel {
			border-collapse: collapse;
			font-size: 9px;
			text-align: right;
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
			<td width="10%" rowspan="3" align="right"><img src="http://localhost/simrs/cetak/gambar/logorsud.png" height="70px" /></td>
			<td width="90%" align="center" style="font-size: 16px">PEMERINTAH KOTA PAGAR ALAM</td>
		</tr>
		<tr>
			<td align="center"><strong style="font-size: 21px">RUMAH SAKIT UMUM DAERAH BESEMAH PAGAR ALAM</strong></td>
		</tr>
		<tr>
			<td align="center" style="font-size: 14px">Jl. Ais Nasution No.03 Pagar Alam Utara<br>+62 730 621 118<br>Email:pagaralamrsudbesemah@gmail.com</td>
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
				<td align="center"><img  height="100px" src=""></td>
			</tr>
			<tr>
				<td align="center">&nbsp;</td>
				<td colspan="6" align="right">&nbsp;</td>
				<td align="center">(<?php echo $DATA_IDENTITAS['nama_dokter']; ?>)</td>
			</tr>

		</tbody>
	</table>
</body>
</html>
<?php
$html = ob_get_clean();
require_once "../vendor/autoload.php";
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->setIsRemoteEnabled(true);
$dompdf = new Dompdf($options);
$paper_size = [0, 0, 8.66 * 72, 5.51 * 72];
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('43_usg.pdf', ['Attachment' => 0]);
?>
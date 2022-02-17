<?php
include('../connect.php');
$idxdaftar = $_GET['idxdaftar'];
$sqlsep="SELECT 
    a.nomer_sep,
    DATE(a.tgl_sep) AS tgl_sep,
    b.no_kartu,
    a.nomr,
    b.nama,
    b.jeniskelamin,
    b.tgllahir,
    b.notelp,
    IFNULL(a.poli_eksekutif, 0) AS poli_eksekutif,
    d.nama AS poli,
    a.nama_diagnosaawal,
    a.catatan,
    a.no_rujukan,
    DATE(a.tgl_rujukan) AS tgl_rujukan,
    DATE(a.tgl_rujukan) + INTERVAL 88 DAY AS akhir_rujukan,
    a.cob,
    a.prolanisPRB,
    a.jenispeserta_keterangan,
    a.jenis_layanan,
    e.kdppk,
    e.nmppk,
	a.signature,
    f.signature AS ttd_user,
    c.nip,
	c.penanggungjawab_nama,
	a.kelas_rawat,
	a.penjamin,
	a.nama_kelas
FROM
    simrs2012.t_sep a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs2012.t_pendaftaran c ON a.idx = c.idxdaftar
        LEFT JOIN
    simrs2012.m_poly d ON c.kdpoly = d.kode
        LEFT JOIN
    simrs2012.refppk e ON a.ppkRujukan = e.kdppk
        LEFT JOIN
    simrs2012.user f ON c.uid = f.id
WHERE
    a.idx = $idxdaftar";
$querysep = mysql_query($sqlsep);
$DATA_SEP = mysql_fetch_array($querysep);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SEP</title>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
			font-family: Constantia, Lucida Bright, DejaVu Serif, Georgia, serif;
	}
	.tabel {
    	border-collapse:collapse;
		font-size: 12px;
	}
</style>
</head>

<body>
<table width="100%" class="tabel" style="border:0;" cellpadding="0">
        <tbody>
            <tr>
                <td width="14%" rowspan="2" style="text-align:left;" valign="top"><img src="../../uploads/logo-bpjs.png" width="100" height="25" alt="" /></td>
                <td width="3%" height="20">&nbsp;</td>
                <td width="79%"><span class="header"><strong>SURAT ELEGIBILITAS PESERTA<br>RSUD AJIBARANG</strong></span></td>
                <td width="4%">&nbsp;</td>
            </tr>
            <tr>
                <td height="20">&nbsp;</td>
                <td style="text-align:left;" valign="top"></td>
                <td>&nbsp;</td>
            </tr>
        </tbody>

    </table>

        <table width="100%" class="tabel" style="border:0;" cellspacing="4px" cellpadding="0">
            <tbody>
                <tr>
                    <td width="19%" style="text-align:left;" vtext-align="bottom">No.SEP</td>
                    <td width="1%" style="text-align:left;" vtext-align="bottom">:</td>
                    <td style="text-align:left; font-size: 15px" vtext-align="bottom">
                        &nbsp;<strong><?php echo $DATA_SEP['nomer_sep'] ?></strong></td>
                    <td style="text-align:left;" vtext-align="bottom">&nbsp;</td>
                    <td style="text-align:left;" vtext-align="bottom">&nbsp;</td>
                    <td style="text-align:left;" vtext-align="bottom">&nbsp;<strong><?php echo $DATA_SEP['prolanisPRB'] ?></strong></td>
                </tr>
                <tr>
                    <td style="text-align:left;" valign="top">Tgl.SEP</td>
                    <td style="text-align:left;" valign="top">:</td>
                    <td width="40%" style="text-align:left;" valign="top">&nbsp; <?php echo $DATA_SEP['tgl_sep'] ?></td>
                    <td width="15%" style="text-align:left;" valign="top">Peserta</td>
                    <td width="1%" style="text-align:left;" valign="top">:</td>
                    <td width="35%" style="text-align:left;" valign="top">&nbsp;<?php echo $DATA_SEP['jenispeserta_keterangan'] ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" valign="top">No.Kartu</td>
                    <td style="text-align:left;" valign="top">:</td>
                    <td style="text-align:left;" valign="top">&nbsp;<?php echo $DATA_SEP['no_kartu'] ?> ( <?php echo $DATA_SEP['nomr'] ?> )</td>
                    <td style="text-align:left;" valign="top">COB</td>
                    <td style="text-align:left;" valign="top">:</td>
                    <td style="text-align:left;" valign="top">&nbsp;<?php echo $DATA_SEP['cob'] ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" valign="top">Nama Peserta</td>
                    <td style="text-align:left;" valign="top">:</td>
                    <td style="text-align:left;" valign="top">&nbsp;<?php echo $DATA_SEP['nama'] ?>, ( <?php echo $DATA_SEP['jeniskelamin'] ?> )</td>
                    <td style="text-align:left;" valign="top">Jns.Rawat</td>
                    <td style="text-align:left;" valign="top">:</td>
                    <td style="text-align:left;" valign="top">&nbsp;
                    <?php 
							if($DATA_SEP['jenis_layanan'] == 2){
								echo 'Rawat Jalan';
							}else if ($DATA_SEP['jenis_layanan'] == 1){
								echo 'Rawat Inap';
							}
							
					?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" valign="top">Tgl.Lahir</td>
                    <td style="text-align:left;" valign="top">:</td>
                    <td style="text-align:left;" valign="top">&nbsp;<?php echo $DATA_SEP['tgllahir'] ?></td>
                    <td style="text-align:left;" valign="top">Kls.Rawat</td>
                    <td style="text-align:left;" valign="top">:</td>
                    <td style="text-align:left;" valign="top">&nbsp;<?php echo $DATA_SEP['nama_kelas'] ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" valign="top">No.Telepon</td>
                    <td style="text-align:left;" valign="top">:</td>
                    <td style="text-align:left;" valign="top">&nbsp;<?php echo $DATA_SEP['notelp'] ?></td>
                    <td style="text-align:left;" valign="top">Penjamin</td>
                    <td style="text-align:left;" valign="top">:</td>
                    <td style="text-align:left;" valign="top">&nbsp;<?php echo $DATA_SEP['penjamin'] ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" valign="top">Sub/Spesialis</td>
                    <td style="text-align:left;" valign="top">:</td>
                    <td style="text-align:left;" valign="top">&nbsp;<?php echo $DATA_SEP['poli'] ?>, <?php echo $DATA_SEP['poli_eksekutif'] ?></td>
                    <td style="text-align:left;" valign="top">No.Rujukan</td>
                    <td style="text-align:left;" valign="top">:</td>
                    <td style="text-align:left;" valign="top">&nbsp;<?php echo $DATA_SEP['no_rujukan'] ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" valign="top">FaskesPerujuk</td>
                    <td style="text-align:left;" valign="top">:</td>
                    <td style="text-align:left;" valign="top">&nbsp; <?php echo $DATA_SEP['kdppk'] ?>/<?php echo $DATA_SEP['nmppk'] ?></td>
                    <td colspan="3" valign="top" style="text-align:left;">tgl berlaku rujukan <?php echo $DATA_SEP['tgl_rujukan'] ?> -s/d- <?php echo $DATA_SEP['akhir_rujukan'] ?></td>
                </tr>
                <tr>
                    <td style="text-align:left;" valign="top">Diagnosa Awal</td>
                    <td style="text-align:left;" valign="top">:</td>
                    <td colspan="2" style="text-align:left;" valign="top">&nbsp;<?php echo $DATA_SEP['nama_diagnosaawal'] ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align:left;" valign="top">Catatan</td>
                    <td style="text-align:left;" valign="top">:</td>
                    <td colspan="2" style="text-align:left;" valign="top">&nbsp;<?php echo $DATA_SEP['catatan'] ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>

        <table width="100%" class="tabel" style="border:0;" cellspacing="5px" cellpadding="0">
            <tbody>
                <tr>
                    <td colspan="6">
                        <p class="style11">*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan
                            <br>*SEP bukan sebagai bukti penjamin peserta .
                            
                            <br>Cetakan Ke 1
                            <br>Dibuat Pertama Oleh:
                        </p>
                    </td>
                    <td colspan="1">&nbsp;</td>
                    <td colspan="3"><span class="style11">Pasien/Keluarga Pasien</span></td>
                </tr>
                <tr>
                    <td colspan="2">
					<img id="salinan" width="100px" height="60px" src="<?php echo $DATA_SEP['ttd_user'] ?>" class="resize" alt="tanda tangan user">
					<img src="cap.png" width="90" height="90" 
                             />
					</td>
                    <td colspan="4">&nbsp;</td>
                    <td colspan="4"><span class="style11sign">
                            <img id="salinan" width="100px" height="60px" src="<?php echo $DATA_SEP['signature'] ?>" class="resize" alt="tanda tangan pasien">
                        </span></td>
                </tr>
                <tr>
                    <td colspan="4"><span class="style11"><?php echo $DATA_SEP['nip'] ?></span></td>
                    <td colspan="2">&nbsp;</td>
                    <td colspan="4"><span class="style12"><span class="style11"><?php echo $DATA_SEP['penanggungjawab_nama'] ?></span></span></td>
                </tr>
            </tbody>
        </table>
</body>
</html>
 <div class="pagebreak"> </div>

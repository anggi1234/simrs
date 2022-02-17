<?php
ob_start();
session_start();
include('../connect.php');
$nomor_pesanan = $_GET['no_pesanan'];

$sqlidentitas="SELECT
	a.jumlah_bruto,
	a.jumlah_ppn + a.jumlah_pph AS potongan,
	a.jumlah_ppn,
	a.jumlah_pph,
	a.jumlah_netto,
	b.nama_rekening,
	b.sub_kegiatan,
	a.kode_rekening,
c.nama_supplier,
c.alamat,
c.nama_pj,
c.posisi,
C.npwp,
d.nip AS nip_pengguna_anggaran,
	e.pd_nickname AS ppk,
	e.nip AS nip_ppk,
	f.pd_nickname AS pptk,
	f.nip AS nip_pptk,
	g.pd_nickname AS bendahara,
	g.nip AS nip_bendahara,
	h.pd_nickname AS pphp,
	h.nip as nip_pphp,
	a.sp_no,
	date_format(a.sp_tgl, '%d-%m-%Y') as sp_tgl,
	i.jumlah_total,
	a.bapem_no
FROM
	simrs.pengadaan_pesanan_masuk a
	LEFT JOIN simrs.master_rekening b ON a.id_rekening = b.id_rekening
	LEFT JOIN simrs.master_supplier c ON a.id_supplier = c.id_master_supplier
	LEFT JOIN simrs.master_login d on b.pa_uid=d.uid
	LEFT JOIN simrs.master_login e on b.ppk_uid=e.uid
	LEFT JOIN simrs.master_login f on b.pptk_uid=f.uid
	left join simrs.master_login g on b.bp_uid=g.uid
	left join simrs.master_login h on b.pphp_uid=h.uid 
	LEFT JOIN ( SELECT no_pesanan, sum( jumlah_total ) AS jumlah_total FROM pengadaan_pesanan_masuk_faktur WHERE no_pesanan = '$nomor_pesanan' GROUP BY no_pesanan ) i ON a.no_pesanan = i.no_pesanan
WHERE
	a.no_pesanan = '$nomor_pesanan'";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

$sqlitem="SELECT
	f.nama_obat,a.qty*a.volume as jumlah,f.satuan,a.harga_beli_satuan,a.harga_beli_setelah_pajak
FROM
	farmasi_pembelian_obat_detail a
	LEFT JOIN farmasi_pembelian_obat b ON a.id_pembelian_obat = b.id_pembelian_obat
	LEFT JOIN pengadaan_pesanan_masuk_faktur c ON b.id_pembelian_obat = c.id_pembelian_obat
	LEFT JOIN pengadaan_pesanan_masuk d ON c.id_pengadaan_pesanan_masuk = d.id_pengadaan_pesanan_barang_masuk
	left join master_obat_detail e on a.id_master_obat_detail=e.id_master_obat_detail
	left join master_obat f on e.id_obat=f.id_obat 
WHERE
	d.no_pesanan = '$nomor_pesanan'";
 $queryitem = mysql_query($sqlitem);


function tanggal_indo($tanggal, $cetak_hari = false)
	{
		$hari = array ( 1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);
			
		$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
		$split 	  = explode('-', $tanggal);
		$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
	
		if ($cetak_hari) {
			$num = date('N', strtotime($tanggal));
			return $tgl_indo;
		}
		return $tgl_indo;
	}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Lampiran BAPEM REG</title>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
		font-size: 12px;
		font-family: Impact, Haettenschweiler, Franklin Gothic Bold, Arial Black," sans-serif";
	}
	
	.tabel {
    	border-collapse:collapse;
	}
</style>
</head>

<body>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="13%"><strong>LAMPIRAN</strong></td>
      <td colspan="2">: BERITA ACARA PEMERIKSAAN</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="10%">&nbsp;&nbsp;NOMOR : </td>
      <td width="77%"><?php echo $DATA_IDENTITAS['bapem_no']; ?></td>
    </tr>
  </tbody>
</table>
<br>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="4%">No.</td>
      <td width="42%">Jenis Barang</td>
      <td width="11%" align="center">Satuan</td>
      <td width="10%" align="center">Volume</td>
      <td width="18%" align="center">Harga Satuan + PPN</td>
      <td width="15%" align="center">Jumlah Harga</td>
    </tr>
    <?php
	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="7">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
	  echo '<td>'.$no.'.</td>';
      echo '<td>'.$data['nama_obat'].'</td>';
	  echo '<td>'.$data['satuan'].'</td>';
	  echo '<td align="right">'.$data['jumlah'].'</td>';
      echo '<td><div align="right">'.number_format($data['harga_beli_satuan'], 2,",","."). '</div></td>';
	  echo '<td><div align="right">'.number_format($data['harga_beli_setelah_pajak'], 2,",","."). '</div></td>';
			echo '</tr>';
			
			$no++;
		}
	}
    
	?>
    <tr>
      <td colspan="4" rowspan="3">&nbsp;</td>
      <td>Jumlah</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>PPN</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>TOTAL</td>
      <td align="right">Rp.<?php echo number_format($DATA_IDENTITAS['jumlah_total'], 2,",","."); ?></td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="33%">&nbsp;</td>
      <td width="33%">&nbsp;</td>
      <td width="33%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">Ajibarang, <?php echo tanggal_indo(date('Y-m-d'),true); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center">Penyedia</td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">Pejabat Penerima Hasil Pekerjaan</td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><u><?php echo $DATA_IDENTITAS['nama_pj']; ?></u></td>
      <td>&nbsp;</td>
      <td align="center"><u><?php echo $DATA_IDENTITAS['pphp']; ?></u></td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_IDENTITAS['posisi']; ?></td>
      <td style="text-align: center">&nbsp;</td>
      <td align="center">NIP. <?php echo $DATA_IDENTITAS['nip_pphp']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="text-align: center">Mengetahui,</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center">Pejabat Pembuat Komitmen</td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">Pejabat Pelaksana Teknis Kegiatan</td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center"><u><?php echo $DATA_IDENTITAS['ppk']; ?></u></td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center"><u><?php echo $DATA_IDENTITAS['pptk']; ?></u></td>
    </tr>
    <tr>
      <td style="text-align: center">NIP. <?php echo $DATA_IDENTITAS['nip_ppk']; ?></td>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">NIP. <?php echo $DATA_IDENTITAS['nip_pptk']; ?></td>
    </tr>
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
$dompdf->stream('laporanpengeluaran.pdf',array('Attachment' => 0));
?>
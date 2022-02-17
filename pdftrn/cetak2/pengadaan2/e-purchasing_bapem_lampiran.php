<?php
ob_start();
session_start();
include('../connect.php');
$id_pengadaan_pesanan_barang_masuk = $_GET['id_pengadaan_pesanan_barang_masuk'];

$sqlidentitas="SELECT
    a.bapem_no,
    c.nama_rekening, 
    a.tahun_anggaran,
    b.nama_supplier,
    b.alamat,
    a.jumlah_bruto,
	a.jumlah_netto,
	a.jumlah_pph+a.jumlah_ppn as potongan,
    b.nama_pj,
    b.posisi,
    e.pd_nickname AS 'pphp',
    e.nip AS 'nip_pphp',
    f.pd_nickname AS 'pptk',
    f.nip AS 'nip_pptk'

FROM
    simrs.pengadaan_pesanan_masuk a
        LEFT JOIN
    master_supplier b ON a.id_supplier = b.id_master_supplier
        LEFT JOIN
    master_rekening c ON a.id_rekening = c.id_rekening
        LEFT JOIN
    master_rekening3 d ON a.id_master_rekening3 = d.id_master_rekening3
    LEFT JOIN
    master_login e ON c.pphp_uid = e.uid
    LEFT JOIN
    master_login f ON d.pptk_uid = f.uid
WHERE
    a.id_pengadaan_pesanan_barang_masuk = '$id_pengadaan_pesanan_barang_masuk'";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

$sqlppk="select nama_pejabat,nip,nama_jabatan,id_jabatan from master_jabatan where id_jabatan=3";
$queryppk = mysql_query($sqlppk);
$DATA_PPK = mysql_fetch_array($queryppk);

$sqlitem="SELECT
	f.nama_obat,a.qty*a.volume as jumlah,f.satuan,a.harga_beli_satuan,a.harga_beli_setelah_pajak
FROM
	farmasi_pembelian_obat_detail a
	LEFT JOIN farmasi_pembelian_obat b ON a.id_pembelian_obat = b.id_pembelian_obat
	LEFT JOIN pengadaan_pesanan_masuk_faktur c ON b.nomor_bukti = c.nomor_faktur
	LEFT JOIN pengadaan_pesanan_masuk d ON c.id_pengadaan_pesanan_masuk = d.id_pengadaan_pesanan_barang_masuk
	left join master_obat_detail e on a.id_master_obat_detail=e.id_master_obat_detail
	left join master_obat f on e.id_obat=f.id_obat 
WHERE
	d.id_pengadaan_pesanan_barang_masuk = '$id_pengadaan_pesanan_barang_masuk'";
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
<title>Lampiran BAPEM</title>
<style type="text/css">
	@page {
            margin-top: 1 cm;
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
      <td width="14%">&nbsp;&nbsp;NOMOR : <?php echo $DATA_IDENTITAS['bapem_no']; ?></td>
      <td width="73%">&nbsp;</td>
    </tr>
  </tbody>
</table>
<br>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="4%" align="center">No</td>
      <td width="48%" align="center">Nama Barang</td>
      <td width="8%" align="center">Volume</td>
      <td width="9%" align="center">Satuan</td>
      <td width="14%" align="center">Harga Satuan + PPN</td>
      <td width="17%" align="center">Jumlah Harga</td>
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
	  echo '<td>'.$data['jumlah'].'</td>';
	  echo '<td>'.$data['satuan'].'</td>';
      echo '<td><div align="right">'.number_format($data['harga_beli_satuan'], 2,",","."). '</div></td>';
	  echo '<td><div align="right">'.number_format($data['harga_beli_setelah_pajak'], 2,",","."). '</div></td>';
			echo '</tr>';
			
			$no++;
		}
	}
    
	?>
	  <tr>
	    <td colspan="5" align="right"><strong>Jumlah</strong></td>
	    <td align="right">Rp <?php echo number_format($DATA_IDENTITAS['jumlah_bruto'], 2,",","."); ?></td>
    </tr>
	  <tr>
	    <td colspan="5" align="right"><strong>PPN</strong></td>
	    <td align="right">Rp <?php echo number_format($DATA_IDENTITAS['potongan'], 2,",","."); ?></td>
    </tr>
	  <tr>
      <td colspan="5" align="right"><strong>TOTAL</strong></td>
      <td width="17%" align="right">Rp <?php echo number_format($DATA_IDENTITAS['jumlah_netto'], 2,",","."); ?></td>
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
      <td align="center">Ajibarang, <?php echo tanggal_indo(date('Y-m-d'),true); ?></td>
    </tr>
  </tbody>
</table> 

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td width="33%" align="center">Penyedia</td>
      <td width="33%" align="center">&nbsp;</td>
      <td width="33%" align="center">Pejabat Penerima Hasil Pekerjaan</td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
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
      <td>&nbsp;</td>
      <td align="center">NIP.<?php echo $DATA_IDENTITAS['nip_pphp']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center">Mengetahui,</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">Pejabat Pembuat Komitmen</td>
      <td align="center">&nbsp;</td>
      <td align="center">Pejabat Pelaksana Teknis Kegiatan</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><u><?php echo $DATA_PPK['nama_pejabat']; ?></u></td>
      <td align="center">&nbsp;</td>
      <td align="center"><u><?php echo $DATA_IDENTITAS['pptk']; ?></u></td>
    </tr>
    <tr>
      <td align="center">NIP.<?php echo $DATA_PPK['nip']; ?></td>
      <td align="center">&nbsp;</td>
      <td align="center">NIP.<?php echo $DATA_IDENTITAS['nip_pptk']; ?></td>
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
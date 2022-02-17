<?php
include('../connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];
$userlevelid = $_GET['userlevelid'];

$sqlidentitas="SELECT 
    a.id_bill_detail_tarif,
	a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
	g.userlevelname,
	DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
	c.nama AS carabayar,
	DATE_FORMAT(a.tanggal, '%d-%m-%Y %T') AS tglmasuk
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs2012.m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    simrs.bill_detail_transfer_pasien d ON a.id_bill_detail_tarif = d.id_bill_detail_tarif
	        LEFT JOIN
    simrs2012.m_statuskeluar e ON e.status = d.id_status_keluar
        LEFT JOIN
    simrs.userlevels f ON d.userlevelid_transfer = f.userlevelid
	LEFT JOIN
	simrs.userlevels g ON a.userlevelid = g.userlevelid
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif";
$queryidentitas = mysql_query($sqlidentitas);
$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

$sqliisi="SELECT 
    d.nama_obat, a.qty, e.nama_resep, f.jenis_etiket
FROM
    bill_detail_permintaan_obat a
        LEFT JOIN
    bill_detail_permintaan_obat_master b ON a.id_bill_detail_permintaan_obat_master = b.id_bill_detail_permintaan_obat_master
        LEFT JOIN
    master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
        LEFT JOIN
    master_obat d ON c.id_obat = d.id_obat
        LEFT JOIN
    master_resep e ON a.id_master_resep = e.id_master_resep
        LEFT JOIN
    l_jenis_etiket f ON a.id_jenis_etiket = f.id_jenis_etiket
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif
        AND d.nama_obat NOT LIKE '%jasa%'"; 
$queryisi = mysql_query($sqliisi);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Order Farmasi</title>

  <link rel="stylesheet" href="../../adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../../adminlte/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../../adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="../../adminlte/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../../adminlte/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>

<body>

		<div class="box">

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
<div align="center"><strong>ORDER FARMASI</strong></div>
<table width="100%" border="0" cellpadding="1" cellspacing="0" class="header">
    <tr>
      <td width="14%" align="left">No. RM</td>
      <td width="44%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="19%" align="left">Status Pembayaran </td>
      <td width="23%">: <?php echo $DATA_IDENTITAS['carabayar']; ?></td>
    </tr>
    <tr>
      <td align="left">Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['nama']; ?></td>
      <td align="left">Tanggal Masuk</td>
      <td>: <?php echo $DATA_IDENTITAS['tglmasuk']; ?></td>
    </tr>
    <tr>
      <td align="left">Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
      <td align="left">Dari Unit</td> 
      <td>: <?php echo $DATA_IDENTITAS['userlevelname']; ?></td>
  </tr>
    <tr>
      <td align="left">Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS['jeniskelamin']; ?></td>
      <td align="left">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">Alamat</td>
      <td colspan="3" valign="top">: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
</table>

<div class="box-body">
			  <table id="example1" class="table table-bordered table-striped">
				<thead>
    <tr>
      <td align="center">No</td>
      <td align="center">Nama Obat</td>
      <td align="center">Jumlah</td>
      <td align="center">Resep</td>
      <td align="center">Jenis Etiket</td>
    </tr>
	</thead>
	<tbody>
    <?php
	  	$no=1;
		while($data=mysql_fetch_assoc($queryisi)){
			echo '<tr>';
	  		echo '<td align="center">'.$no.'.</td>';
			echo '<td align="left">'.$data['nama_obat'].'</td>';
			echo '<td align="center">'.$data['qty'].'</td>';
			echo '<td align="left">'.$data['nama_resep'].'</td>';
			echo '<td align="left">'.$data['jenis_etiket'].'</td>';
			echo '</tr>';
			
			$no++;
		}
	?>
		</tbody>
	</table>
</div>
</body>
</html>



<script src="../../adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../../adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../../adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../../adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="../../adminlte/bower_components/fastclick/lib/fastclick.js"></script>
<script src="../../adminlte/dist/js/adminlte.min.js"></script>
<script src="../../adminlte/dist/js/demo.js"></script>
		  
		  
<script>
  $(function () {
	$('#example1').DataTable()
	$('#example2').DataTable({
	  'paging'      : true,
	  'lengthChange': false,
	  'searching'   : false,
	  'ordering'    : true,
	  'info'        : true,
	  'autoWidth'   : false
	})
  })
</script>	
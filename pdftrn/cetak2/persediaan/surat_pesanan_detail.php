  <link rel="stylesheet" href="../../adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../../adminlte/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../../adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="../../adminlte/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../../adminlte/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Riwayat Pembelian</title>
</head>

<body>

<?php
	
ob_start();
session_start();
include('../connect.php');	
$no_pesanan= $_GET['no_pesanan'];
$sqlitemkasir="SELECT
	f.nama_supplier,
	e.kode_permintaan as nomor_sp,
	date_format(e.tgl_permintaan, '%d-%m-%Y') as tgl_sp,
	c.nama_obat,
	a.satuan,
	a.jumlah_barang,
	a.harga,
	d.jml_satuan AS diterima,
	a.jumlah_barang-d.jml_satuan as sisa
FROM
	pengadaan_permintaan_barang_detail a
	LEFT JOIN pengadaan_permintaan_barang e ON a.id_pengadaan_permintaan_barang = e.id_pengadaan_permintaan_barang
	LEFT JOIN master_obat_detail b ON a.id_master_barang_detail = b.id_master_obat_detail
	LEFT JOIN master_obat c ON b.id_obat = c.id_obat
	LEFT JOIN (
	SELECT
		b.nomor_bukti,
		b.nomor_pesan,
		a.id_master_obat_detail,
		sum( a.qty * a.volume ) AS jml_satuan 
	FROM
		farmasi_pembelian_obat_detail a
		LEFT JOIN farmasi_pembelian_obat b ON a.id_pembelian_obat = b.id_pembelian_obat 
	GROUP BY
		a.id_master_obat_detail,
		b.nomor_pesan 
	) d ON a.id_master_barang_detail = d.id_master_obat_detail 
	AND d.nomor_pesan = e.kode_permintaan
	LEFT JOIN master_supplier f on e.id_supplier=f.id_master_supplier where e.kode_permintaan='$no_pesanan'";
 $queryitemkasir = mysql_query($sqlitemkasir);
	
	
	
$sqlidentitas="SELECT
	a.kode_permintaan,
	b.nama_supplier,
	b.alamat,
	b.telp,
	b.npwp,
	date_format( a.tgl_permintaan, '%d-%m-%Y' ) AS tgl_permintaan,
	a.nama_pengadaan,c.nama_rekening
FROM
	pengadaan_permintaan_barang a
	LEFT JOIN master_supplier b ON a.id_supplier = b.id_master_supplier
	LEFT JOIN master_rekening c on a.id_rekening=c.id_rekening
	where a.kode_permintaan='$no_pesanan'";
$queryidentitas = mysql_query($sqlidentitas);
$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);
	
	

?>


	
	<section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Rincian Pesanan Pengadaan - Integrasi SP.
            <small class="pull-right">Tanggal: <?php echo date('d-m-Y') ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          Dari
          <address>
            <strong><?php echo $DATA_IDENTITAS['nama_supplier']; ?></strong><br>
            <?php echo $DATA_IDENTITAS['alamat']; ?><br>
            Telp: <?php echo $DATA_IDENTITAS['telp']; ?><br>
            Email: 
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          Untuk
          <address>
            <strong>RSUD AJIBARANG</strong><br>
            Jalan Raya Pancasan, Ajibarang<br>
            Kode Pos: 53163<br>
            Telp: (0281) 6570005<br>
            Email: rsudajibarang@banyumaskab.go.id
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Nomor SP <?php echo $DATA_IDENTITAS['kode_permintaan']; ?></b><br>
          <br>
          <b>Tanggal SP: </b> <?php echo $DATA_IDENTITAS['tgl_permintaan']; ?><br>
          <b>Jenis Pengadaan: </b><?php echo $DATA_IDENTITAS['nama_pengadaan']; ?><br>
          <b>Kegiatan: </b> <?php echo $DATA_IDENTITAS['nama_rekening']; ?>
        </div>
        <!-- /.col -->
      </div>
	</section>
	
	
	
	
	
		<div class="box box-success">
			<div class="box-header">
			  <h3 class="box-title">Data Pesanan Pada Nomor SP:</h3>
			</div>
			<div class="box-body">
			  <table id="example1" class="table table-bordered table-striped">
				<thead>
				<tr>
				  <th>No.</th>
				  <th>Nama Obat</th>
				  <th>Satuan</th>
				  <th>Jumlah Pesan</th>
				  <th>Jumlah Diterima</th>
				  <th>Sisa</th>
				</tr>
				</thead>
				<tbody>
<?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemkasir)){
			echo '<tr>';
			echo '<td>'.$no.'</td>';
			echo '<td>'.$data['nama_obat'].'</td>';
			echo '<td>'.$data['satuan'].'</td>';
			echo '<td>'.$data['jumlah_barang'].'</td>';
			echo '<td>'.$data['diterima'].'</td>';
			echo '<td>'.$data['sisa'].'</td>';
			echo '</tr>';
			$no++;
		}
	
	?>
				</tbody>
				<tfoot>
				<tr>
				  <th>No.</th>
				  <th>Nama Obat</th>
				  <th>Satuan</th>
				  <th>Jumlah Pesan</th>
				  <th>Jumlah Diterima</th>
				  <th>Sisa</th>
				</tr>
				</tfoot>
			  </table>
			</div>
			<!-- /.box-body -->
		  </div>
	
	
	
	<!--<div class="row">
        
        <div class="col-xs-6">
          
        </div>
        <div class="col-xs-6">
          <p class="lead">Amount Due 2/22/2014</p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Subtotal:</th>
                <td>$250.30</td>
              </tr>
              <tr>
                <th>Tax (9.3%)</th>
                <td>$10.34</td>
              </tr>
              <tr>
                <th>Shipping:</th>
                <td>$5.80</td>
              </tr>
              <tr>
                <th>Total:</th>
                <td>$265.24</td>
              </tr>
            </table>
          </div>
        </div>
      </div>-->
	


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
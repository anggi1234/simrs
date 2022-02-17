<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Riwayat Pembelian</title>
  <link rel="stylesheet" href="../../../adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../../adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../../../adminlte/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../../../adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="../../../adminlte/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../../../adminlte/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>

<body>

<?php
	
ob_start();
session_start();
include('../../connect.php');	
$id_master_obat_detail= $_GET['id_master_obat_detail'];
$sqlitemkasir="SELECT 
        date_format(b.tanggal, '%d-%m-%Y') as tglbeli,c.nama_supplier, a.qty, a.harga_beli_satuan
FROM
    farmasi_pembelian_obat_detail a
        LEFT JOIN
    farmasi_pembelian_obat b ON a.id_pembelian_obat = b.id_pembelian_obat
        LEFT JOIN
    master_supplier c ON b.id_supplier = c.id_master_supplier
    where a.id_master_obat_detail=$id_master_obat_detail";
 $queryitemkasir = mysql_query($sqlitemkasir);

?>

 				<a href="../../../farmasi_pembelian_obatadd.php?showdetail=farmasi_pembelian_obat_detail" class="btn btn-block btn-social btn-bitbucket">
                <i class="fa fa-plus-square-o"></i> Tambah Pembelian
              </a>
		<div class="box">
			<div class="box-header">
			  <h3 class="box-title">Data Riwayat Pembelian</h3>
			</div>
			<div class="box-body">
			  <table id="example1" class="table table-bordered table-striped">
				<thead>
				<tr>
				  <th>No.</th>
				  <th>Tanggal Beli</th>
				  <th>Nama Supplier</th>
				  <th>Jumlah</th>
				  <th>Harga Beli</th>
				</tr>
				</thead>
				<tbody>
<?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemkasir)){
			echo '<tr>';
	echo '<td>'.$no.'</td>';
	echo '<td>'.$data['tglbeli'].'</td>';
	echo '<td>'.$data['nama_supplier'].'</td>';
	echo '<td>'.$data['qty'].'</td>';
	echo '<td align="right">'.number_format($data['harga_beli_satuan'], 2,",",".").'</td>';
			echo '</tr>';
			$no++;
		}
	
	?>
				</tbody>
				<tfoot>
				<tr>
				  <th>No.</th>
				  <th>Tanggal Beli</th>
				  <th>Nama Supplier</th>
				  <th>Jumlah</th>
				  <th>Harga Beli</th>
				</tr>
				</tfoot>
			  </table>
			</div>
			<!-- /.box-body -->
		  </div>


</body>
</html>


<script src="../../../adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../../../adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../../../adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../../adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../../../adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="../../../adminlte/bower_components/fastclick/lib/fastclick.js"></script>
<script src="../../../adminlte/dist/js/adminlte.min.js"></script>
<script src="../../../adminlte/dist/js/demo.js"></script>
		  
		  
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
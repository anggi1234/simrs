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


<!--<div class="box-body">
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
</div> -->



<div class="col-md-8">
<div align="center"><strong>E-RESEP FARMASI RSUD AJIBARANG</strong></div>
<table width="100%" border="0" style="font-size: 11px" cellpadding="1" cellspacing="0" class="header">
    <tr>
      <td width="14%" align="left">No. RM</td>
      <td width="29%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="25%" align="left">Status Pembayaran </td>
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



<div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Order Farmasi</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        Obat Jadi
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="box-body">

<?php
$sqlobatjadi="SELECT 
    d.nama_obat, a.qty,e.nama_resep as aturan_pakai
FROM
    simrs.bill_detail_permintaan_obat a
        LEFT JOIN
    simrs.bill_detail_permintaan_obat_master b ON a.id_bill_detail_permintaan_obat_master = b.id_bill_detail_permintaan_obat_master
        LEFT JOIN
    simrs.master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
        LEFT JOIN
    simrs.master_obat d ON c.id_obat = d.id_obat
    LEFT JOIN simrs.master_resep e on a.id_master_resep = e.id_master_resep
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif
        AND b.id_jenis_resep = 1"; 
$queryobatjadi = mysql_query($sqlobatjadi);
?>
<table width="100%" style="font-size: 12px" border="1">
  <tbody>
    <tr>
      <td width="45%">Nama Obat</td>
      <td width="5%">Jumlah</td>
      <td width="50%" align="center">Aturan Pakai</td>
    </tr>
    <?php
		while($data=mysql_fetch_assoc($queryobatjadi)){
			echo '<tr>';
			echo '<td align="left"><strong>'.$data['nama_obat'].'</strong></td>';
			echo '<td align="center"><strong>'.$data['qty'].'</strong></td>';
			echo '<td align="left"><strong>'.$data['aturan_pakai'].'</strong></td>';
			echo '</tr>';
		}
	?>
  </tbody>
</table>


                    </div>
                  </div>
                </div>
                <div class="panel box box-danger">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        Obat Racik dtd
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse in">
                    <div class="box-body">
                      
<?php
$sqlidmaster=mysql_query("
SELECT 
    id_bill_detail_permintaan_obat_master as id_master
FROM
    bill_detail_permintaan_obat_master
WHERE
    id_bill_detail_tarif = $id_bill_detail_tarif AND id_jenis_resep = 2");


	while($rows=mysql_fetch_array($sqlidmaster)){					  
	echo '<table width="100%" border="1">';
	echo '  <tbody>';
	echo '    <tr>';
	echo '      <td width="84%">Nama Obat</td>';
	echo '      <td width="16%" align="center">Jumlah</td>';
	echo '    </tr>';
	
	$sqlobatracik="SELECT 
    b.id_bill_detail_permintaan_obat_master,d.nama_obat, a.qty, a.qty_temp, b.jumlah_racikan, e.nama_resep as aturan_pakai,f.pd_nickname,f.signature
FROM
    simrs.bill_detail_permintaan_obat a
        LEFT JOIN
    simrs.bill_detail_permintaan_obat_master b ON a.id_bill_detail_permintaan_obat_master = b.id_bill_detail_permintaan_obat_master
        LEFT JOIN
    simrs.master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
        LEFT JOIN
    simrs.master_obat d ON c.id_obat = d.id_obat
		LEFT JOIN
	simrs.master_resep e on b.aturan_pakai=e.id_master_resep
		LEFT JOIN
    simrs.master_login f ON b.username = f.username
WHERE
    a.id_bill_detail_permintaan_obat_master = ".$rows['id_master']."
        AND b.id_jenis_resep = 2";
		$queryobatracik = mysql_query($sqlobatracik);
		$queryobatracikjml = mysql_query($sqlobatracik);
		$queryobatracikaturan = mysql_query($sqlobatracik);
		$queryobatracikid = mysql_query($sqlobatracik);
		$queryobatsignatureracik = mysql_query($sqlobatracik);
		
			while($isi=mysql_fetch_array($queryobatracik))
            {
				echo '    <tr>';
				echo '      <td width="84%"><strong>'.$isi['nama_obat'].'</strong></td>';
				echo '      <td width="16%" align="center"><strong>'.$isi['qty_temp'].'</strong></td>';
				echo '    </tr>';
            }
	
	$jml=mysql_fetch_array($queryobatracikjml);
				echo '    <tr>';
				echo '      <td colspan="2">Jumlah : <strong>'.$jml['jumlah_racikan'].'</strong></td>';
				echo '    </tr>';
	
	$aturan_pakai=mysql_fetch_array($queryobatracikaturan);
	echo '    <tr>';
	echo '      <td colspan="2">Aturan Pakai : <strong>'.$aturan_pakai['aturan_pakai'].'</strong></td>';
	echo '    </tr>';
	
	$idmasterdtd=mysql_fetch_array($queryobatracikid);
	echo '    <tr>';
	echo "      <td colspan=\"2\"><a class=\"btn btn-block btn-success btn-sm\" href=\"../etiket/etiket_racik_dtd.php?id_bill_detail_permintaan_obat_master=" . $idmasterdtd['id_bill_detail_permintaan_obat_master'] . "\" onclick=\"window.open('../etiket/etiket_racik_dtd.php?id_bill_detail_permintaan_obat_master=" . $idmasterdtd['id_bill_detail_permintaan_obat_master'] . "', 'nota', 'width=1100px,height=500px'); return false;\">Etiket Racik</a></strong></td>";
	echo '    </tr>';
	
	echo '  </tbody>';
	echo '</table> <br>';
	};
?>					  

				  
					  
                    </div>
                  </div>
                </div>
				
				
				
				<div class="panel box box-warning">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        Obat Racik Non dtd
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse in">
                    <div class="box-body">
 

<?php
$sqlidmaster=mysql_query("
SELECT 
    id_bill_detail_permintaan_obat_master as id_master
FROM
    bill_detail_permintaan_obat_master
WHERE
    id_bill_detail_tarif = $id_bill_detail_tarif AND id_jenis_resep = 3");


	while($rows=mysql_fetch_array($sqlidmaster)){					  
	echo '<table width="100%" border="1">';
	echo '  <tbody>';
	echo '    <tr>';
	echo '      <td width="84%">Nama Obat</td>';
	echo '      <td width="16%" align="center">Jumlah</td>';
	echo '    </tr>';
	
	$sqlobatracik1="SELECT 
    b.id_bill_detail_permintaan_obat_master,d.nama_obat, a.qty, a.qty_temp, b.jumlah_racikan, e.nama_resep as aturan_pakai
FROM
    simrs.bill_detail_permintaan_obat a
        LEFT JOIN
    simrs.bill_detail_permintaan_obat_master b ON a.id_bill_detail_permintaan_obat_master = b.id_bill_detail_permintaan_obat_master
        LEFT JOIN
    simrs.master_obat_detail c ON a.id_master_obat_detail = c.id_master_obat_detail
        LEFT JOIN
    simrs.master_obat d ON c.id_obat = d.id_obat
		LEFT JOIN
	simrs.master_resep e on b.aturan_pakai=e.id_master_resep
WHERE
    a.id_bill_detail_permintaan_obat_master = ".$rows['id_master']."
        AND b.id_jenis_resep = 3";
		$queryobatracik = mysql_query($sqlobatracik1);
		$queryobatracikjml = mysql_query($sqlobatracik1);
		$queryobatracikaturan = mysql_query($sqlobatracik1);
		$queryobatracikid1 = mysql_query($sqlobatracik1);
		
			while($isi=mysql_fetch_array($queryobatracik))
            {
				echo '    <tr>';
				echo '      <td width="84%"><strong>'.$isi['nama_obat'].'</strong></td>';
				echo '      <td width="16%" align="center"><strong>'.$isi['qty_temp'].'</strong></td>';
				echo '    </tr>';
            }
	
	$jml=mysql_fetch_array($queryobatracikjml);
				echo '    <tr>';
				echo '      <td colspan="2">Jumlah : <strong>'.$jml['jumlah_racikan'].'</strong></td>';
				echo '    </tr>';
	
	$aturan_pakai=mysql_fetch_array($queryobatracikaturan);
	echo '    <tr>';
	echo '      <td colspan="2">Aturan Pakai : <strong>'.$aturan_pakai['aturan_pakai'].'</strong></td>';
	echo '    </tr>';
	
	
	$idmaster1=mysql_fetch_array($queryobatracikid1);
	echo '    <tr>';
	echo "      <td colspan=\"2\"><a class=\"btn btn-block btn-warning btn-sm\" href=\"../etiket/etiket_racik_dtd.php?id_bill_detail_permintaan_obat_master=" . $idmaster1['id_bill_detail_permintaan_obat_master'] . "\" onclick=\"window.open('../etiket/etiket_racik_dtd.php?id_bill_detail_permintaan_obat_master=" . $idmaster1['id_bill_detail_permintaan_obat_master'] . "', 'nota', 'width=1100px,height=500px'); return false;\">Etiket Racik</a></strong></td>";
	echo '    </tr>';
	
	echo '  </tbody>';
	echo '</table> <br>';
	};
?>	
					  
					  
                    </div>
                  </div>
                </div>
				
				

              </div>
            </div>
            <!-- /.box-body -->
          </div>


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
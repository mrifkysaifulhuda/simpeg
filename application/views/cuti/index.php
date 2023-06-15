 
<!-- jQuery 3 -->

<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

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

<?php
function tgl_indo($tanggal){
	
	$bulan = array (
		1 =>   'Januari',
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
	$pecahkan = explode(' ', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return $pecahkan[0] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[2];
}
 ?>

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Tables
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Cuti Pegawai</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nama</th>
                 <th>Awal</th>
                  <th>Akhir</th>
                  <th>Lama</th>
                  <th>Keterangan</th>
                  <th>Status</th>
                  <th>Action</th>
                  
                </tr>
                </thead>
                <tbody>
                	<?php foreach ($cuti as $cuti_item): ?>
                		<tr>
                	<td><?php echo $cuti_item['nama']; ?></td>
                  	<td><?php echo tgl_indo(date("d m Y",strtotime($cuti_item['tanggal_awal']))); ?></td>
                  	<td><?php echo tgl_indo(date("d m Y",strtotime($cuti_item['tanggal_akhir'])));?></td>
                  	<td><?php echo $cuti_item['lama']; ?></td>
                   <td><?php echo $cuti_item['keterangan']; ?></td>
                   <td><?php echo $cuti_item['status']; ?></td>
                  
                  <td><a href="<?php echo site_url('pegawai/cuti/'.$cuti_item['id_pegawai']); ?>">View Detail</a></td>
                </tr>
				        

				<?php endforeach; ?>


                
               
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
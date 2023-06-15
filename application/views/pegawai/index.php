 
<!-- jQuery 3 -->

<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>



 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Pegawai
        <small>Cuti dan Surat Tugas</small>
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
              <h3 class="box-title">Daftar Pegawai</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-striped table-bordered" id="table-pegawai">
                <thead>
                    <tr>
                        <th> Nama </th>
                        <th> NIP </th>
                        <th> Tanggal Lahir </th>
                        <th> Aksi </th>
                    </tr>
                </thead>
                <tbody></tbody>
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

  <script>
    var tabel = null;
    $(document).ready(function() {
        tabel = $('#table-pegawai').DataTable({
            "processing": true,
            "responsive":true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax":
            {
                "url": "<?= site_url('datatables/view_data_query');?>", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "aLengthMenu": [[50, 75, 100],[ 50, 75, 100]], // Combobox Limit
            "columns": [
              
                { "data": "nama" },  // Tampilkan kategori
                { "data": "nip" },  // Tampilkan nama sub kategori
                { "data": "tanggal_lahir" },  // Tampilkan nama sub kategori
                { "data": "id_pegawai",
                "render": 
                function( data, type, row, meta ) {
                    return '<a href="pegawai/'+data+'">View Details</a>';
                }
                },
            ],
        });
    });
</script>
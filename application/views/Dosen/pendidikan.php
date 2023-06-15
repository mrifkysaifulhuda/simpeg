<div class="content-wrapper">
    <section class="content-header" style="padding-bottom: 15px;">
      <h1>
        <?php echo $dosen['nama']; ?>
      
      </h1>
     
    </section>
   

      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom" style="overflow: auto;">
            <ul class="nav nav-tabs">
              <li><a href="<?php echo site_url('dosen/'.$dosen['id']); ?>" >Detail</a></li>
              <li class="active"><a href="#tab_2" data-toggle="tab">Pedidikan</a></li>
             
            </ul>
            <div class="tab-content">
              <div class="tab-pane" id="tab_1">
              </div>
              <!-- /.tab-pane -->
             
             
            <br />
               
        <div class="col-xs-12">
          

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Riwayat Pendidikan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Jenis Pendidikan</th>
                  <th>Tanggal Lulus</th>
                  <th>Nama Sekolah</th>
                  <th>Kota</th>
                  <th>Gelar</th>
                  <th>Bidang Ilmu</th>
                  <th>Keterangan</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($pendidikan as $pnd_dosen): ?>
                  <tr>
                      <td><?php echo $pnd_dosen['jenis_pendidikan']; ?></td>
                      <td><?php echo $pnd_dosen['tanggal_lulus']; ?></td>
                      <td><?php echo $pnd_dosen['nama_sekolah']; ?></td>
                       <td><?php echo $pnd_dosen['kota']; ?></td>
                       <td><?php echo $pnd_dosen['gelar']; ?></td>
                       <td><?php echo $pnd_dosen['bidang_ilmu']; ?></td>
                        <td><?php echo $pnd_dosen['keterangan']; ?></td>
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

    </div>
              <!-- /.tab-pane -->
           
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->

       
        <!-- /.col -->
      </div>
</div>


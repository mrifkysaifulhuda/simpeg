<div class="content-wrapper">

  <section class="content-header" style="padding-bottom: 15px;">
      <h1>
        <?php echo $dosen['nama']; ?>
      
      </h1>
     
    </section>
	 

      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Detail</a></li>
              <li><a href="<?php echo site_url('dosen/pendidikan/'.$dosen['id']); ?>">Pendidkan</a></li>
             
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <dl class="dl-horizontal">
                <dt>NIP</dt>
                <dd> <?php echo $dosen['nip']; ?></dd>
                <dt>Nama</dt>
                <dd><?php echo $dosen['nama']; ?></dd>
                <dt>Tempat/Tanggal Lahir </dt>
                <dd><?php echo $dosen['tempat_lahir']; ?>/<?php echo $dosen['tanggal_lahir']; ?></dd>
                <dt>Jurusan</dt>
                <dd><?php echo $dosen['jurusan']; ?></dd>
                <dt>Program Studi</dt>
                <dd><?php echo $dosen['program_studi']; ?></dd>
                <dt>Fakultas</dt>
                <dd><?php echo $dosen['fakultas']; ?></dd>
                <dt>NIK</dt>
                <dd><?php echo $dosen['nik']; ?></dd>
                 <dt>NPWP</dt>
                <dd><?php echo $dosen['npwp']; ?></dd>
               
              </dl>
                

               
			
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                
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


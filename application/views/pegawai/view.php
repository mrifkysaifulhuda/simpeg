<div class="content-wrapper">

  <section class="content-header" style="padding-bottom: 15px;">
      <h1>
        <?php echo $pegawai_item['nama']; ?>
      
      </h1>
     
    </section>
	 

      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Detail</a></li>
              <li><a href="<?php echo site_url('pegawai/cuti/'.$pegawai_item['id_pegawai']); ?>">Cuti</a></li>
              <li><a href="<?php echo site_url('pegawai/surat_tugas/'.$pegawai_item['id_pegawai']); ?>">Surat Tugas</a></li>
             
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <dl class="dl-horizontal">
                <dt>NIP</dt>
                <dd> <?php echo $pegawai_item['nip']; ?></dd>
                <dt>Nama</dt>
                <dd><?php echo $pegawai_item['nama']; ?></dd>
                <dt>Tempat/Tanggal Lahir </dt>
                <dd><?php echo $pegawai_item['tempat_lahir']; ?>/<?php echo $pegawai_item['tanggal_lahir']; ?></dd>
                <dt>TMT Capeg</dt>
                <dd><?php echo $pegawai_item['tmt_capeg']; ?></dd>
                <dt>Pangkat</dt>
                <dd><?php echo $pegawai_item['pangkat']; ?></dd>
                <dt>Golongan</dt>
                <dd><?php echo $pegawai_item['golongan']; ?></dd>
                <dt>Jabatan</dt>
                <dd><?php echo $pegawai_item['jabatan']; ?></dd>
                 <dt>Satker</dt>
                <dd><?php echo $pegawai_item['satker']; ?></dd>
               
              </dl>
                

               
			
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                The European languages are members of the same family. Their separate existence is a myth.
                For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
                in their grammar, their pronunciation and their most common words. Everyone realizes why a
                new common language would be desirable: one could refuse to pay expensive translators. To
                achieve this, it would be necessary to have uniform grammar, pronunciation and more common
                words. If several languages coalesce, the grammar of the resulting language is more simple
                and regular than that of the individual languages.
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


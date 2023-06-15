<div class="content-wrapper">
    <section class="content-header" style="padding-bottom: 15px;">
      <h1>
        <?php echo $pegawai_item['nama']; ?>
      </h1>
    </section>
      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom" style="overflow: auto;">
            <ul class="nav nav-tabs">
              <li><a href="<?php echo site_url('pegawai/'.$pegawai_item['id_pegawai']); ?>" >Detail</a></li>
              <li class="active"><a href="#tab_2" data-toggle="tab">Cuti</a></li>
              <li><a href="<?php echo site_url('pegawai/surat_tugas/'.$pegawai_item['id_pegawai']); ?>">Surat Tugas</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane" id="tab_1">
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane active box"  id="tab_2">
              <?php echo validation_errors(); ?>
              <?php if ($in_valid == true) { ?>
               <div class="box-body">
             
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                    Jumlah Cuti yang di ajukan melebihi jumlah cuti yang tersisa
              </div>
            </div>
            <?php } ?>
                
            <!-- /.box-header -->
            <!-- form start -->
            <?php  echo form_open('pegawai/cuti/'.$pegawai_item['id_pegawai'], array('method'=>'post', 'class' =>'form-horizontal')); ?>
                  <input type="hidden"  name="id_pegawai" value="<?php echo $pegawai_item['id_pegawai']; ?> ">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputAkhir" class="col-sm-2 control-label">Awal</label>

                  <div class="col-sm-5">
                  <div class="input-group date">
                          <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right" name="tanggal_awal" id="tanggal_awal" placeholder="Tanggal Awal">
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputAkhir"  class="col-sm-2 control-label">Akhir</label>

                  <div class="col-sm-5">
                  <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                        <input type="text" class="form-control pull-right" name="tanggal_akhir" id="tanggal_akhir" placeholder="Tanggal akhir">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputAkhir" class="col-sm-2 control-label">Jenis Cuti</label>

                  <div class="col-sm-5">
                    <select name="jenis_cuti" id="jenis_cuti" class="form-control pull-right">
                      <option value="Cuti Tahunan">Cuti Tahunan</option>
                      <option value="Cuti Besar">Cuti Besar</option>
                      <option value="Cuti Sakit">Cuti Sakit</option>
                      <option value="Cuti Melahirkan">Cuti Melahirkan</option>
                      <option value="Cuti Karena Alasan Penting">Cuti Karena Alasan Penting</option>
                      <option value="Cuti Bersama">Cuti Bersama</option>
                      <option value="Cuti di Luar Tanggungan Negara">Cuti di Luar Tanggungan Negara</option>
                    </select>
                  </div>
                </div>
              </div>

              
              <div class="form-group">
                  <label for="inputAkhir" class="col-sm-2 control-label">Keterangan</label>

                  <div class="col-sm-5">
                      <textarea class="form-control" name="keterangan" rows="3" placeholder="Enter ..."></textarea>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
               
                <button type="submit" class="btn btn-info ">Simpan</button>
              </div>
              <!-- /.box-footer -->
            </form>
               
            
                <div class="col-lg-3 col-xs-6">


          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <p>Total Cuti  tahun lalu</p>
              <h2><?php echo $total_cuti_tahun_lalu ?> Hari</h2>
            </div>
            <div class="icon">
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">

                  
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <p>Total Cuti tahun ini</p>
              <h2><?php echo $total_cuti ?> Hari</h2>
            </div>
            <div class="icon">
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Cuti</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Awal</th>
                  <th>Akhir</th>
                  <th>Lama</th>
                  <th>Keterangan</th>
                  <th>Status</th>
                  <th>Jenis</th>
                  <?php if ($this->session->userdata('level') == 1) { ?>
                  <th>Action</th>
                  <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($cuti_pegawai as $cuti): ?>
                  <tr>
                      <td><?php echo $cuti['tanggal_awal']; ?></td>
                      <td><?php echo $cuti['tanggal_akhir']; ?></td>
                      <td><?php echo $cuti['lama']; ?></td>
                      <td><?php echo $cuti['keterangan']; ?></td>
                      <td><?php echo $cuti['status']; ?></td>
                      <td><?php echo $cuti['jenis']; ?></td>
                      <?php if ($this->session->userdata('level') == 1) { ?>
                        <td><?php if ($cuti['status'] == STATUS_CUTI_BARU) {  ?> <a href="<?php echo site_url('pegawai/setujui/'.$cuti['id']); ?>"> Setujui</a> <a href="<?php echo site_url('pegawai/tolak/'.$cuti['id']); ?>"> Tolak</a><?php } ?> &nbsp;&nbsp;
                        <?php if ($cuti['status'] == STATUS_CUTI_DISETUJUI) {  ?>  <button type="button" class="btn btn-info" onclick="showTembusanModal(<?php echo $cuti['id']; ?>)" data-toggle="modal" data-target="#modal-info"> Cetak Surat Izin</button> <?php } ?>
                        </td>
                      <?php } ?>
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

  

    <div class="modal modal-info fade" id="modal-info">
          <div class="modal-dialog">
            <?php  echo form_open('pegawai/laporan_pdf/'.$pegawai_item['id_pegawai'], array('method'=>'post', 'class' =>'form-horizontal')); ?>
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Data Tambahan</h4>
              </div>
              <div class="modal-body" style="height: 110px">
                
              <div class="form-group">
                  <div class="col-sm-12">
                    <input type="hidden" id='cuti_id' name='cuti_id'/>
                    <select class="form-control"  id="penandatangan" name="penandatangan" placeholder="Pejabat Penandatangan">
                      <option value="warek_dua">Wakil Rektor Bidang Dua</option>
                      <option value="ka_biro">Kepala Biro UK</option>
                    </select>
                    
                  </div>
                </div>
                 <div class="form-group">
                  <div class="col-sm-12">
                   
                     <input class="form-control" type="text" placeholder="Tembusan" name="tembusan_surat" />
                  </div>
                </div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Cetak Surat</button>
             
              </div>

            </div>
          </form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
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
<script type="text/javascript">
  function showTembusanModal($id){
    $("#cuti_id").val($id);
  }

  $('#tanggal_awal').datepicker({
      autoclose: true,
      format: 'mm/dd/yyyy'
    })

    $('#tanggal_akhir').datepicker({
      autoclose: true,
      format: 'mm/dd/yyyy',
    })
</script>

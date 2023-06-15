<script>
  $(function () {

    $.fn.readonlyDatepicker = function (makeReadonly) {
    $(this).each(function(){

        //find corresponding hidden field
        var name = $(this).attr('name');
        var $hidden = $('input[name="' + name + '"][type="hidden"]');

        //if it doesn't exist, create it
        if ($hidden.length === 0){
            $hidden = $('<input type="hidden" name="' + name + '"/>');
            $hidden.insertAfter($(this));
        }

        if (makeReadonly){
            $hidden.val($(this).val());
            $(this).unbind('change.readonly');
            $(this).attr('disabled', true);
        }
        else{
            $(this).bind('change.readonly', function(){
                $hidden.val($(this).val());
            });
            $(this).attr('disabled', false);
        }
    });
};
    $('#tanggal_awal').datepicker({
      autoclose: true,
      format: 'mm/dd/yyyy'
    })

    $('#tanggal_akhir').datepicker({
      autoclose: true,
      format: 'mm/dd/yyyy',
    })

    $('#tanggal_akhir').readonlyDatepicker(true);
    
  })
</script>


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
              <li><a href="<?php echo site_url('pegawai/cuti/'.$pegawai_item['id_pegawai']); ?>">Cuti</a></li>
              <li class="active"><a href="#tab_2" data-toggle="tab">Surat Tugas</a></li>
             
            </ul>
            <div class="tab-content">
              <div class="tab-pane" id="tab_1">
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane active box"  id="tab_2">
              <?php if (validation_errors() != "" or isset($error_messages )) { ?>
               <div class="box-body">
             
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                <?php echo validation_errors(); ?>
                <?php if(isset($error_messages )){ echo $error_messages; }?>
              </div>
            </div>
            <?php } ?>
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
            <?php  echo form_open('pegawai/surat_tugas/'.$pegawai_item['id_pegawai'], array('method'=>'post', 'class' =>'form-horizontal')); ?>
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
                  <label for="satuHari"  class="col-sm-2 control-label">Satu Hari</label>

                  <div class="col-sm-5">
                  <input type="checkbox" name="satu_hari" id="satu_hari" value="satu_hari" checked>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputAkhir"  class="col-sm-2 control-label">Akhir</label>

                  <div class="col-sm-5">
                  <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                        <input type="text" class="form-control pull-right" name="tanggal_akhir" id="tanggal_akhir" placeholder="Tanggal akhir" readonly>
                    </div>
                   
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

                    <div class="col-xs-12">
          

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Surat Tugas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Awal</th>
                  <th>Akhir</th>
                  <th>Keterangan</th>
                  <?php if ($this->session->userdata('level') == 1) { ?>
                  <th>Action</th>
                  <?php } ?>
                </tr>
                </thead>
                <tbody>

                <?php  foreach ($surat_tugas_pegawai as $surat_tugas): ?>
                  <tr>
                      <td><?php echo $surat_tugas['tanggal_awal']; ?></td>
                      <td><?php echo $surat_tugas['tanggal_akhir']; ?></td>
                      <td><?php echo $surat_tugas['keterangan']; ?></td>
                       <?php if ($this->session->userdata('level') == 1) { ?>
                   		<td>
                   			<a href="<?php echo site_url('pegawai/hapus_surat_tugas/'.$surat_tugas['id']); ?>"> Hapus</a>
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

  

 
      
           
            </div>
          
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->

       
        <!-- /.col -->
      </div>
</div>

<script type="text/javascript">

  

var date_input = document.getElementById('tanggal_awal');


date_input.onchange = function(){
   if(document.getElementById("satu_hari").checked == true){
      document.getElementById("tanggal_akhir").value = this.value;
   }
   
}

var satu_hari_input = document.getElementById('satu_hari');

satu_hari_input.onchange = function(){
    if(document.getElementById("satu_hari").checked == true){
        $('#tanggal_akhir').readonlyDatepicker(true);
        document.getElementById('tanggal_akhir').readOnly = true;
        document.getElementById("tanggal_akhir").value = date_input.value;
    }else{
        $('#tanggal_akhir').readonlyDatepicker(false);
        document.getElementById('tanggal_akhir').readOnly = false;
        document.getElementById("tanggal_akhir").value = null;
    }
    }

</script>

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

<script>
    
     $(function () {
      $('#tanggal').datepicker({
        autoclose: true,
        format: 'mm/dd/yyyy',
        })
     });
</script>
 
 <div class="content-wrapper">
 <?php echo validation_errors(); ?>
                
            <!-- /.box-header -->
            <!-- form start -->
            <?php  echo form_open('libur/tambah/', array('method'=>'post', 'class' =>'form-horizontal')); ?>
                 
              <div class="box-body">
                <div class="form-group">
                  <label for="inputAkhir" class="col-sm-2 control-label">Tanggal</label>

                  <div class="col-sm-5">
                  <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" name="tanggal" id="tanggal" placeholder="Tanggal">
                    </div>
                  </div>
                </div>
                
              <div class="form-group">
                  <label for="inputAkhir" class="col-sm-2 control-label">Keterangan</label>

                  <div class="col-sm-5">
                      <textarea class="form-control" name="keterangan" id="keterangan" rows="3" placeholder="Enter ..."></textarea>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
               
                <button type="submit" class="btn btn-info ">Simpan</button>
              </div>
              <!-- /.box-footer -->
            </form>



<section class="content">
      <div class="row">
        <div class="col-xs-12">
          

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Hari Libur Nasional</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                 
                  <th>Tanggal</th>
                  <th>Keterangan</th>
                 
                  
                </tr>
                </thead>
                <tbody>
                  <?php foreach ($libur as $libur_item): ?>
                    <tr>
                 
                    <td><?php echo tgl_indo(date("d m Y",strtotime($libur_item['tanggal']))); ?></td>
                     <td><?php echo $libur_item['keterangan']; ?></td>
                   
                  
                  
                  
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

</div>
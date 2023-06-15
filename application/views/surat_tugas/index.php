 
<!-- jQuery 3 -->

<!-- DataTables -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<?php
$bulan = date('n');
$tahun = date('Y');
?>
<style>
.select2-container--default .select2-selection--multiple .select2-selection__choice {background-color: #3c8dbc;}
</style>
#3c8dbc
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
    $('#id_pegawai').select2({
        placeholder: '-Pilih Pegawai-',
        minimumInputLength: 3,
        ajax: {
            url: "<?php echo site_url('surat_tugas/get_list_pegawai'); ?>",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data
                };
            }
        }
    });

    var pegawaiSelect = $('#id_pegawai');
    $.ajax({
        type: 'GET',
        url: "<?php echo site_url('surat_tugas/get_list_pegawai_by_id'); ?>"
    }).then(function (data) {
        data.forEach((item) =>{
        var option = new Option(item.text, item.id, true, true);
        pegawaiSelect.append(option).trigger('change');

        // manually trigger the `select2:select` event
        pegawaiSelect.trigger({
            type: 'select2:select',
            params: {
                data: {"id" : item.id, "text":item.text}
            }
        });
      });
    });

    $('#example1').DataTable({
            "processing": true,
            "responsive":true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax":
            {
                "url": "<?= site_url('surat_tugas/view_data_where');?>", // URL file untuk proses select datanya
                "type": "POST",
                'data': function (d) {
                    d.tahun = $('#tahun').val();
                    d.bulan = $('#bulan').val();
                }
          },
            "deferRender": true,
            "aLengthMenu": [[25, 50, 75],[ 25, 50, 75]], // Combobox Limit
            "columns": [
              
                { "data": "nama" },  // Tampilkan kategori
                { "data": "tanggal_awal" }, 
                { "data": "tanggal_akhir" },
                { "data": "keterangan" },
                { "data": "id_pegawai",
                "render": 
                function( data, type, row, meta ) {
                    return '<a href="<?= site_url('pegawai/surat_tugas/');?>'+data+'">View Details</a>';
                }
                },
                
            ],
            "columnDefs": [
                { "visible": false, "targets": 0 }
            ],
            "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="5"><b>'+group+'</b></td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
        })

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

<script type="text/javascript">
  function refresh_databales(){
    $('#example1').DataTable().ajax.reload();
  }   
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
        Surat Tugas Pegawai
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>



    
    <?php  echo form_open('surat_tugas/index', array('method'=>'post', 'class' =>'form-horizontal')); ?>
    <div class="box-body">  
        
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
                <div class="form-group">
                  <label for="inputAkhir" class="col-sm-2 control-label">Pegawai</label>

                  <div class="col-sm-5">
                  <select id="id_pegawai" name="id_pegawai[]" class="form-control" multiple="multiple"></select>
                  </div>
                </div>
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
               
              <div class="form-group">
                  <label for="inputAkhir" class="col-sm-2 control-label">Keterangan</label>

                  <div class="col-sm-5">
                      <textarea class="form-control" name="keterangan" rows="3" placeholder="Enter ..."></textarea>
                  </div>
                </div>
              </div>
              <div class="form-group">
                  <label for="salinDaftarPegawai"  class="col-sm-2 control-label">Salin Daftar Pegawai</label>

                  <div class="col-sm-5">
                  <input type="checkbox" name="salin_pegawai" id="salin_pegawai" value="salin_pegawai">
                  </div>
                </div>
              <!-- /.box-body -->
              <div class="box-footer">
               
                <button type="submit" class="btn btn-info ">Simpan</button>
              </div>
              <!-- /.box-footer -->
            </form>

    <!-- Main content -->
    <section class="content">

   
      <div class="row">
        <div class="col-xs-12">
          

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Surat Tugas Pegawai</h3>
            </div>
            
            <div class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <div class="row">
              <div class="col-sm-6">
                <div class="dataTables_length">
                  <label style="padding-left:10px">Bulan 
                    <select onchange="refresh_databales()" id="bulan" name="bulan" aria-controls="example1" class="form-control input-sm">
                      <option value="1" <?php if($bulan == "1"){echo "selected";}; ?>>Januari</option>
                      <option value="2" <?php if($bulan == "2"){echo "selected";}; ?>>Februari</option>
                      <option value="3" <?php if($bulan == "3"){echo "selected";}; ?>>Maret</option>
                      <option value="4" <?php if($bulan == "4"){echo "selected";}; ?>>April</option>
                      <option value="5" <?php if($bulan == "5"){echo "selected";}; ?>>Mei</option>
                      <option value="6" <?php if($bulan == "6"){echo "selected";}; ?>>Juni</option>
                      <option value="7" <?php if($bulan == "7"){echo "selected";}; ?>>Juli</option>
                      <option value="8" <?php if($bulan == "8"){echo "selected";}; ?> >Agustus</option>
                      <option value="9" <?php if($bulan == "9"){echo "selected";}; ?>>September</option>
                      <option value="10" <?php if($bulan == "10"){echo "selected";}; ?>>Oktober</option>
                      <option value="11" <?php if($bulan == "11"){echo "selected";}; ?>>November</option>
                      <option value="12" <?php if($bulan == "12"){echo "selected";}; ?>>Desember</option>
                    </select></label>
                </div>
              </div>
              <div class="col-sm-6">
                <div id="example1_filter" class="dataTables_filter">
                <label>Tahun 
                    <select onchange="refresh_databales()" name="tahun" id="tahun" aria-controls="example1" class="form-control input-sm">
                      <option value="2021">2021</option>
                      <option value="2022" <?php if($tahun == "2022"){echo "selected";}; ?>>2022</option>
                      <option value="2023"<?php if($tahun == "2023"){echo "selected";}; ?>>2023</option>
                      <option value="2024" <?php if($tahun == "2024"){echo "selected";}; ?>>2024</option>
                    </select></label>
                </div>
              </div>
            </div>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
              <thead>
                    <tr>
                      <th> Nama </th>
                      <th> Awal </th>
                      <th> Akhir </th>
                      <th> Keterangan </th>
                      <th> Action </th>
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
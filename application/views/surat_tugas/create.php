
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>

<script>
    
     $(function () {
        CKEDITOR.plugins.add( 'sisip_peg', {
           
            init: function( editor ) {
                editor.addCommand( 'sisipkanPegawai', {
                    exec: function( editor ) {
                        var now = new Date();
                        const html_text = $("#div_table_pegawai").html().replace("table_pegawai", "table_pegawai_clone");
                        editor.insertHtml( html_text );
                    }
                });
                editor.ui.addButton( 'sisip_peg', {
                    label: 'Sisipkan Pegawai',
                    command: 'sisipkanPegawai',
                    toolbar: 'insert',
                    icon: '<?php echo base_url(); ?>images/icon-sisipkan-pegawai.png'
                });
            }
        });

        CKEDITOR.plugins.add( 'sisip_ttd', {
           
           init: function( editor ) {
               editor.addCommand( 'sisipkanTandaTangan', {
                   exec: function( editor ) {
                        if($('#id_pejabat_ttd').find(':selected')[0] !== undefined){
                            const pejabat_ttd = $('#id_pejabat_ttd').find(':selected')[0]["label"].split(" - ");
                            
                            var html_text = `
                            <div class="row">
                                <div class="col-sm-7">&nbsp;</div>
                                <div class="col-sm-5"><?php echo tgl_indo(date("d m Y"))?></div>
                                </div>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <div class="row">
                                    <div class="col-sm-7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tembusan</div>

                                    <div class="col-sm-5" style="text-align: left">`+pejabat_ttd[0]+`</div>
                                    </div>

                                    <div class="row">
                                    <div class="col-sm-7">&nbsp;</div>

                                    <div class="col-sm-5">NIP.`+pejabat_ttd[1]+`</div>
                                </div>`;

                           editor.insertHtml(html_text);
                        }else{
                            alert("Silahkan Pilih Pejabat Penandatangan");
                        }
                   }
               });
               editor.ui.addButton( 'sisip_ttd', {
                   label: 'Sisipkan Tanda Tangan',
                   command: 'sisipkanTandaTangan',
                   toolbar: 'insert',
                   icon: '<?php echo base_url(); ?>images/icon-sisipkan-ttd.png'
               });
           }
       });

       CKEDITOR.plugins.add( 'halaman_baru', {
           
           init: function( editor ) {
               editor.addCommand( 'halamanBaru', {
                   exec: function( editor ) {
                       const html_text = "<div class=\"page_break\" contenteditable=\"false\"></div>";
                       editor.insertHtml( html_text );
                   }
               });
               editor.ui.addButton( 'halaman_baru', {
                   label: 'Halaman Baru',
                   command: 'halamanBaru',
                   toolbar: 'insert',
                   icon: '<?php echo base_url(); ?>images/new-page.png'
               });
           }
       });

        CKEDITOR.replace( 'editor', {extraPlugins: ['sisip_peg','sisip_ttd','halaman_baru','justify', 'tab'], width:  '810px', height: '900px', tabSpaces : 4} );

        var customButton = document.querySelector('#custom-button-save');
        customButton.addEventListener('click', function() {
            $("#editorHiddenArea").val(CKEDITOR.instances.editor.getData());
            document.getElementById("form_create_st").submit();
        });

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

        <?php  if(isset($wizard)){?>

            var customPDFButton = document.getElementById('custom-button-pdf');
            customPDFButton.addEventListener('click', function() {
                var html_content = CKEDITOR.instances.editor.getData();
                $.post("<?php echo site_url('surat_tugas/save_content'); ?>",
                    {
                        content: html_content,
                        surat_tugas_wizard_id:$("#wizard_id").val() 
                    },
                    function(data, status){
                        window.open('<?php echo site_url('surat_tugas/view_pdf'); ?>/'+data, '_blank');
                });
            });

            var pegawaiSelect = $('#id_pegawai');
                $.ajax({
                    type: 'GET',
                    url: "<?php echo site_url('surat_tugas/get_list_pegawai_by_surat_tugas_id/' . $wizard["surat_tugas_wizard_id"]); ?>"
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

            var id = "<?php echo $pejabat_ttd["id"]; ?>"
            var text = "<?php echo $pejabat_ttd["text"]; ?>"

            var option = new Option(text, id, true, true);
            $("#id_pejabat_ttd").append(option).trigger('change');

                    // manually trigger the `select2:select` event
                    $("#id_pejabat_ttd").trigger({
                type: 'select2:select',
                params: {
                    data: {"id" : id, "text":text}
                }
            });

        <?php }?>

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

       

        $('#id_pejabat_ttd').select2({
        placeholder: '-Pilih Pejabat-',
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

        $('#id_pegawai').on('select2:select', function (e) {
            var data = e.params.data;
            insertRow(data.id);
        });

        $('#id_pegawai').on('select2:unselect', function (e) {
            var data = e.params.data;
            $(".table_pegawai_"+data.id).remove();
            document.getElementById("table_pegawai_"+data.id).remove()
        });

        $('#tanggal_awal').datepicker({
        autoclose: true,
        format: 'mm/dd/yyyy'
        })

        $('#tanggal_akhir').datepicker({
        autoclose: true,
        format: 'mm/dd/yyyy',
        })

        if($('#tanggal_awal').val() == $('#tanggal_akhir').val()){
            $('#tanggal_akhir').readonlyDatepicker(true);
        }

     });

     function insertRow(n) {
        $.ajax({
            type: 'GET',
            url: "<?php echo site_url('surat_tugas/get_pegawai'); ?>/"+n
        }).then(function (data) {
           
            var newRow=document.getElementById('table_pegawai').insertRow();
            newRow.setAttribute("class","table_pegawai_"+n);
            newRow.innerHTML="<td class='nomor_peg'></td><td>"+data.nama+"</td><td>"+data.pangkat+"/"+data.golongan+"</td><td>"+data.jabatan+"</td>";
            
            var table = document.getElementsByTagName('table')[0],
            rows = table.getElementsByTagName('tr'),
            text = 'textContent' in document ? 'textContent' : 'innerText';

            for (var i = 0, len = rows.length; i < len; i++) {
                if(i > 0){
                    rows[i].children[0][text] = i;
                }
            }

            if(document.getElementById('table_pegawai_clone') !== null){
                var newRow=document.getElementById('table_pegawai_clone').insertRow();
                newRow.setAttribute("id","table_pegawai_"+n);
                newRow.innerHTML="<td class='nomor_peg'></td><td>"+data.nama+"</td><td>"+data.pangkat+"/"+data.golongan+"</td><td>"+data.jabatan+"</td>";
            }  
        });
    }
</script>

<style>
    .form-group{
        margin-top:20px;
    }

    .page {
    position: absolute;
    width: 850px;
    height: 1100px;
    left: 49.5%;
    margin: 10px 0 50px -410px;
    background-color: white;
    box-shadow: 0 0 5px grey;
    font-family: 'Times New Roman';
    font-size: 15px;
    }

    p { margin-top: 0; margin-bottom: 0; }

    
</style>

<div class="content-wrapper" style="overflow:hidden">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Surat Tugas Pegawai
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>
    <?php if (validation_errors() != "") { ?>
               <div class="box-body">
             
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                <?php echo validation_errors(); ?>
              </div>
            </div>
            <?php } ?>
<?php  echo form_open('surat_tugas/create/', array('id'=>'form_create_st','method'=>'post')); ?>
<input type="hidden" name="wizard_id" id="wizard_id" value="<?php if(isset($wizard)){echo $wizard["surat_tugas_wizard_id"];}?>">
    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <div class="col-sm-12">
                <label>Judul</label>
                <input type="text" id="judul" name="judul" class="form-control pull-right" value="<?php if(isset($wizard)){echo $wizard["judul"];}?>">
                </div>  
            </div> 
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <div class="col-sm-12">
                <label>Pegawai</label>
                <select id="id_pegawai" name="id_pegawai[]" class="form-control" multiple="multiple"></select>
                </div>  
            </div> 
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <div class="col-sm-12" id="div_table_pegawai">
                    <table id="table_pegawai" class="table table-bordered table-striped">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Pangkat dan Golongan</th>
                            <th>Jabatan</th>
                        </tr>
                    </table>
                </div>
            </div>    
        </div>
    </div>

    <div class="row">
        <div class="form-group">
                <div class="col-md-12">
                        <div class="col-sm-5">
                            <label>Tanggal Awal</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" name="tanggal_awal" id="tanggal_awal" placeholder="Tanggal Awal" value="<?php if(isset($wizard)){echo date("m/d/Y", strtotime($wizard["tanggal_awal"]));}?>" >
                            </div>  
                        </div>
                </div> 
        </div>
    </div>

    <div class="row">
        <div class="form-group">
                <div class="col-md-12">
                        <div class="col-sm-5">
                        <label>Satu Hari</label>
                        <input style="margin-left:10px" type="checkbox" name="satu_hari" id="satu_hari" value="satu_hari" <?php if(isset($wizard)){ if($wizard["tanggal_awal"] == $wizard["tanggal_akhir"]){ echo "checked"; }}else{echo "checked";}?>  >
                        </div>  
                </div> 
        </div>
    </div>

    <div class="row">
        <div class="form-group">
                <div class="col-md-12">
                    <div class="col-sm-5">
                        <label>Tanggal Akhir</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" name="tanggal_akhir" id="tanggal_akhir" placeholder="Tanggal akhir" value="<?php if(isset($wizard)){echo date("m/d/Y", strtotime($wizard["tanggal_akhir"]));}?>"  <?php if(!isset($wizard)){echo "readonly";}?> >
                        </div>  
                    </div>  
                </div> 
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <div class="col-sm-12">
                <label>Pejabat Penandatangan</label>
                <select id="id_pejabat_ttd" name="id_pejabat_ttd" class="form-control"></select>
                </div>  
            </div> 
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <div class="col-sm-12">
                <button id="custom-button-save" type="button" class="btn btn-info ">Simpan</button>
                <?php if(isset($wizard)){ echo "<button  id=\"custom-button-pdf\" type=\"button\" class=\"btn btn-info\">Cetek</button>"; }?>
                </div>  
            </div> 
        </div>
    </div>
    <div class="row">
        <div class="form-group">
                <div class="col-md-12">
                        <div class="col-sm-12">
                            <label for="exampleInputEmail1">Konten Surat Tugas</label>
                                <input type="hidden" name="editorHiddenArea" id="editorHiddenArea" value="">
                                <div id="editor">
                                <?php if(isset($wizard)){echo $wizard["konten"];}else{?>
                                    <div style="margin-top:10px;text-align: center;">
                                      <img  src="<?php echo base_url(); ?>images/header_surat_new.jpg"  width="775" height="160"/>
                                    </div>    
                                    <p style="text-align: center;">SURAT TUGAS</p>
                                    <p style="text-align: center;">NOMOR</p>
                                    <p><br></p>
                                    <p>Surat tugas ini dibuat untuk dilaksanakan dengan penuh tanggung jawab dan membuat laporan.</p>
                                </div>
                                <?php } ?>
                        </div>  
                </div> 
            </div>
    </div>

    <?php 
        echo "</form>" ?>

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


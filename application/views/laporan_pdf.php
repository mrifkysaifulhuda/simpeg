
<?php
function getRomawi($bln){
                switch ($bln){
                    case 1: 
                        return "I";
                        break;
                    case 2:
                        return "II";
                        break;
                    case 3:
                        return "III";
                        break;
                    case 4:
                        return "IV";
                        break;
                    case 5:
                        return "V";
                        break;
                    case 6:
                        return "VI";
                        break;
                    case 7:
                        return "VII";
                        break;
                    case 8:
                        return "VIII";
                        break;
                    case 9:
                        return "IX";
                        break;
                    case 10:
                        return "X";
                        break;
                    case 11:
                        return "XI";
                        break;
                    case 12:
                        return "XII";
                        break;
                }
}
?>

<?php
$bulan = date('n');
$romawi = getRomawi($bulan);

?>

<style type="text/css">
*{margin:0;padding:0}
#table {
    display: table;
	width:95%;
    
	margin-left:55px;
}
.tr {
    display: table-row;
    
}
.td {
    display: table-cell;
}
.tdw {
    display: table-cell;
}
#center {  
text-align: center;  
}  

.float-container {
    
    margin-left: 70px;
}

.float-child {
    width: 50%;
    float: left;
    
   
}  

</style>
<pre>
<div id ="center">
<img style="margin-top:10px;" src="images/header_surat_new.jpg"  width="775" height="160"/>
</div>
</pre>
<div align="center" style="font-family: Calibri; font-size: 20px;">
<b> SURAT IZIN <?php echo strtoupper($cuti['jenis']); ?> </b>
</div>
<div align="center" style="font-family: Calibri; font-size: 15px;">
  NOMOR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/UN62/<?php echo $romawi ?>/<?php echo date("Y"); ?> 
</div>
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

function tgl_indo_2($tanggal){
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
 
	return $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[2];
}
 ?>
 



<div style="margin-top: 50px; margin-left:70px;">
	<?php if ($cuti['jenis'] == "Cuti Karena Alasan Penting") {?> 
		Diberikan <?php echo $cuti['jenis'] ?> dalam rangka <?php echo $cuti['keterangan'] ?> kepada <?php echo $pegawai['status']; ?> :
	<?php } else{ ?>
		Diberikan cuti tahunan untuk tahun <?php echo date("Y"); ?> kepada <?php echo $pegawai['status']; ?> :
	<?php } ?>
	
</div>
<table style="margin-left: 50px">
	<tr>
		<td>Nama</td>
		<td>:</td>
		<td><?php echo $pegawai['nama']; ?></td>
	</tr>
	<tr>
		<td>NIP/NIK</td>
		<td>:</td>
		<td><?php echo $pegawai['nip']; ?></td>
	</tr>
	<tr>
		<td>Pangkat/golongan ruang</td>
		<td>:</td>
		<td><?php echo $pegawai['pangkat']; ?>/<?php echo $pegawai['golongan']; ?></td>
	</tr>
	<tr>
		<td>Jabatan</td>
		<td>:</td>
		<td><?php echo $pegawai['jabatan']; ?></td>
	</tr>
	<tr>
		<td>Satuan Kerja</td>
		<td>:</td>
		<td><?php echo $pegawai['satker']; ?></td>
	</tr>
</table>
<div style="margin-left:70px; margin-top: 15px; max-width: 655px; text-align: justify;">Selama <?php echo $cuti['lama']; ?> hari kerja terhitung mulai tanggal <?php echo tgl_indo(date("d m Y",strtotime($cuti['tanggal_awal'])))?> sampai dengan tanggal <?php echo tgl_indo(date("d m Y",strtotime($cuti['tanggal_akhir'])))?> dengan ketentuan sebagai berikut :</div>
<br />
<div id="table" style="max-width: 670px; margin-right:50px;">
    <div class="tr" style="max-width: 500px;">
        <div class="td">a. </div>
        <div  style="max-width: 500px; text-align: justify;" class="tdw">Sebelum menjalankan <?php echo strtolower($cuti['jenis']); ?> wajib menyerahkan pekerjaannya kepada atasan langsungnya.</div>
      
    </div>
    <div class="tr" style="max-width: 500px;">
        <div class="td">b. </div>
        <div style="max-width: 500px; text-align: justify;" class="tdw">Setelah menjalankan <?php echo strtolower($cuti['jenis']); ?> wajib melaporkan diri kepada atasan langsungnya dan bekerja kembali sebagaimana mestinya.</div>
       
    </div>
</div>

<div style="margin-left:70px; margin-top: 15px; max-width: 655px; text-align: justify;">Demikian surat izin <?php echo strtolower($cuti['jenis']); ?> ini dibuat untuk dapat digunakan sebagaimana mestinya.</div>

<br />

<div style="margin-left:500px; margin-top:10px;">Yogyakarta, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo tgl_indo_2(date("d m Y"))?></div>

<?php if($penandatangan == 'warek_dua') { ?>
	<div style="margin-left:500px;">a.n. Rektor</div>
	<div style="margin-left:500px;">Wakil Rektor</div>
	<div style="margin-left:500px;">Bidang Umum dan Keuangan</div>
	<div style="margin-top:70px; margin-left:500px;">Dr. Drs. Susanta, M.Si</div>
	<div style="margin-left:500px;">NIP 19690331 199403 1 001</div>
<?php } ?>

<?php if($penandatangan == 'ka_biro') { ?>
	<div style="margin-left:500px;">a.n. Rektor</div>
	
	<div style="margin-left:500px;">Kepala Biro Umum dan Keuangan</div>
	<div style="margin-top:70px; margin-left:500px;">Drs. Setyo Budi Takarina, M.Pd.</div>
	<div style="margin-left:500px;">NIP 19660314 198603 1 002</div>
<?php } ?>

<div style="margin-left:70px; margin-bottom: 10px">Tembusan:</div>

<?php foreach ($tembusan as $key => $value) { ?>
	<div style="margin-left:70px;"><?php echo strval($key + 1) . "." ?> <?php echo $value ?></div>
<?php } ?>

<div style="margin-left:70px;">UPN "Veteran" Yogyakarta</div>

<div style="page-break-before: always;"></div>

<pre>
<div id ="center">
<img style="margin-top:10px;" src="images/header_surat_new.jpg"  width="775" height="160"/>
</div>
</pre>
<div align="center" style="font-family: Calibri; font-size: 20px;">
<b> SURAT IZIN <?php echo strtoupper($cuti['jenis']); ?> </b>
</div>
<div align="center" style="font-family: Calibri; font-size: 15px;">
  NOMOR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/UN62/<?php echo $romawi ?>/<?php echo date("Y"); ?> 
</div>


<div style="margin-top: 50px; margin-left:70px;">
	<?php if ($cuti['jenis'] == "Cuti Karena Alasan Penting") {?> 
		Diberikan <?php echo $cuti['jenis'] ?> dalam rangka <?php echo $cuti['keterangan'] ?> kepada <?php echo $pegawai['status']; ?> :
	<?php } else{ ?>
		Diberikan cuti tahunan untuk tahun <?php echo date("Y"); ?> kepada <?php echo $pegawai['status']; ?> :
	<?php } ?>
	
</div>
<table style="margin-left: 50px">
	<tr>
		<td>Nama</td>
		<td>:</td>
		<td><?php echo $pegawai['nama']; ?></td>
	</tr>
	<tr>
		<td>NIP/NIK</td>
		<td>:</td>
		<td><?php echo $pegawai['nip']; ?></td>
	</tr>
	<tr>
		<td>Pangkat/golongan ruang</td>
		<td>:</td>
		<td><?php echo $pegawai['pangkat']; ?>/<?php echo $pegawai['golongan']; ?></td>
	</tr>
	<tr>
		<td>Jabatan</td>
		<td>:</td>
		<td><?php echo $pegawai['jabatan']; ?></td>
	</tr>
	<tr>
		<td>Satuan Kerja</td>
		<td>:</td>
		<td><?php echo $pegawai['satker']; ?></td>
	</tr>
</table>
<div style="margin-left:70px; margin-top: 15px; max-width: 655px; text-align: justify;">Selama <?php echo $cuti['lama']; ?> hari kerja terhitung mulai tanggal <?php echo tgl_indo(date("d m Y",strtotime($cuti['tanggal_awal'])))?> sampai dengan tanggal <?php echo tgl_indo(date("d m Y",strtotime($cuti['tanggal_akhir'])))?> dengan ketentuan sebagai berikut :</div>
<br />
<div id="table" style="max-width: 670px; margin-right:50px;">
    <div class="tr" style="max-width: 500px;">
        <div class="td">a. </div>
        <div  style="max-width: 500px; text-align: justify;" class="tdw">Sebelum menjalankan <?php echo strtolower($cuti['jenis']); ?> wajib menyerahkan pekerjaannya kepada atasan langsungnya.</div>
      
    </div>
    <div class="tr" style="max-width: 500px;">
        <div class="td">b. </div>
        <div style="max-width: 500px; text-align: justify;" class="tdw">Setelah menjalankan <?php echo strtolower($cuti['jenis']); ?> wajib melaporkan diri kepada atasan langsungnya dan bekerja kembali sebagaimana mestinya.</div>
       
    </div>
</div>

<div style="margin-left:70px; margin-top: 15px; max-width: 655px; text-align: justify;">Demikian surat izin <?php echo strtolower($cuti['jenis']); ?> ini dibuat untuk dapat digunakan sebagaimana mestinya.</div>

<br />

<div style="margin-left:500px; margin-top:10px;">Yogyakarta, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo tgl_indo_2(date("d m Y"))?></div>

<?php if($penandatangan == 'warek_dua') { ?>
	<div style="margin-left:500px;">a.n. Rektor</div>
	<div style="margin-left:500px;">Wakil Rektor</div>
	<div style="margin-left:500px;">Bidang Umum dan Keuangan</div>
	<div style="margin-top:70px; margin-left:500px;">Dr. Drs. Susanta, M.Si</div>
	<div style="margin-left:500px;">NIP 19690331 199403 1 001</div>
<?php } ?>

<?php if($penandatangan == 'ka_biro') { ?>
	<div style="margin-left:500px;">a.n. Rektor</div>
	
	<div style="margin-left:500px;">Kepala Biro Umum dan Keuangan</div>
	<div style="margin-top:70px; margin-left:500px;">Drs. Setyo Budi Takarina, M.Pd.</div>
	<div style="margin-left:500px;">NIP 19660314 198603 1 002</div>
<?php } ?>

<div class="float-container">

  <div class="float-child">
    <div>Tembusan :</div>
    <?php foreach ($tembusan as $key => $value) { ?>
		<div ><?php echo strval($key + 1) . "." ?> <?php echo $value ?></div>
	<?php } ?>
  </div>
  
  <div class="float-child">
    <div style="margin-top:2px">Telah Diperiksa :</div>
    <table>
    	<tr><td>1. Karo Umum dan Keuangan</td><td>:</td><td>1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td></td></tr>
    	<tr><td>2. Koord Kepegawaian</td><td>:</td><td></td><td>2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
    </table>
  </div>
  
</div>

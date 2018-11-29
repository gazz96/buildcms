<?php 

function cuaca(){
	global $library;
	global $db;

	if(isset($_POST['delete'])){
		$delete = $db->delete("cuaca", array('id_cuaca="' . $_POST['id'] .'"'));
		if($delete){
			$library->message = "Data berhasil dihapus";
			$library->alert_class = "alert-success";
		}
		else{
			$library->message = "Data gagal dihapus";
			$library->alert_class = "alert-warning";
		}
	}

	$query_str = "SELECT * FROM cuaca ORDER BY tanggal_prediksi DESC";
	$data = $db->get_results($query_str);

	?>
	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Data Cuaca
			<a href="?module=add_cuaca" class="btn-add">Tambah Data</a>
		</h3> 
	</div>
	
	<div class="module-body">
		<table class="table table-bordered" id="table-cuaca">
			<thead>
				<tr>
					<th>Tanggal</th>
					<th>Pagi</th>
                	<th>Siang</th>
                	<th>Malam</th>
                	<th>Dini Hari</th>
                	<th>Suhu</th>
					<th>Kelembapan</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data as $d): ?>
					<tr>
						<td><?php echo $d['tanggal_prediksi']; ?></td>
						<td><?php echo $d['cuaca']; ?></td>
						<td><?php echo $d['siang']; ?></td>
						<td><?php echo $d['malam']; ?></td>
						<td><?php echo $d['dini_hari']; ?></td>
						<td><?php echo $d['suhu']; ?></td>
						<td><?php echo $d['kelembapan']; ?></td>
						<td>
							<a class="btn btn-warning btn-small" href="?module=edit_cuaca&id=<?php echo $d['id_cuaca']; ?>"><span class="fa fa-pencil"></span></a>
							<form method="POST" action="?module=cuaca" style="display: inline-block;">
								<input type="hidden" name="id" value="<?php echo $d['id_cuaca']; ?>">
								<button class="btn btn-danger btn-small" input="submit" name="delete">
									<span class="fa fa-trash"></span>
								</button>
							</form>
						</td>
					</tr>
				<?php  endforeach; ?>
			</tbody>
		</table>
	</div>

	<?php 
}

function add_cuaca(){
	global $db;
	global $library;

	if(isset($_POST['tambah'])){
    	$query_cari = "SELECT tanggal_prediksi FROM cuaca WHERE tanggal_prediksi='" . $_POST['tanggal_prediksi'] . "'";
    	$cari = $db->query($query_cari);
   		
		if($cari->num_rows > 0){
        	
        	$objects = array(
            	'cuaca' => $_POST['cuaca'],
            	'siang' => $_POST['siang'],
            	'malam' => $_POST['malam'],
            	'dini_hari' => $_POST['dini_hari'],
            	'suhu' => $_POST['suhu'],
            	'kelembapan' => $_POST['kelembapan'],
        	);
        
			$update = $db->update("cuaca", $objects, array('tanggal_prediksi', $_POST['tanggal_prediksi']));
        
			if($update){
				$library->message = "Berhasil memperbaharui data";
				$library->alert_class = "alert-success";
			}
			else{
				$library->message = "Gagal memperbaharui data";
				$library->alert_class = "alert-warning";
			}
        }else{
        	
        	$objects = array(
        		'tanggal_prediksi' => $_POST['tanggal_prediksi'],
            	'cuaca' =>$_POST['cuaca'],
            	'siang' => $_POST['siang'],
            	'malam' => $_POST['malam'],
            	'dini_hari' => $_POST['dini_hari'],
            	'suhu' => $_POST['suhu'],
            	'kelembapan' => $_POST['kelembapan'],
        	);
        
        	$save = $db->save("cuaca", $objects);
        	if($save){
            	$library->message = "Berhasil menambahkan data";
            	$library->alert_class = "alert-success";
         	}else{
            	$library->message = "Gagal menambahkan data";
            	$library->alert_class = "alert-warning";
         	}
        }
	}

	?>
	
	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Tambah cuaca</h3> 

	</div>

	<div class="module-body">
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Tanggal Prediksi</label>
						<input type="date" name="tanggal_prediksi" class="form-control" value="<?php echo date('Y-m-d'); ?>">
					</div>
                
                	<div class="form-group">
						<label>Pagi</label>
                    	<select name="cuaca" class="form-control">
                        	<option value="">Pilih</option>
                        	<option value="cerah">Cerah</option>
                        	<option value="panas">Panas</option>
                        	<option value="berawan">Berawan</option>
                        	<option value="sejuk">Sejuk</option>
                       		<option value="hujan">Hujan</option>
                        	<option value="berangin">Berangin</option>
                    	</select>
					</div>
                
                <div class="form-group">
                        <label>Siang</label>
                        <select name="siang" class="form-control">
                            <option value="">Pilih</option>
                            <option value="cerah">Cerah</option>
                            <option value="panas">Panas</option>
                            <option value="berawan">Berawan</option>
                            <option value="sejuk">Sejuk</option>
                            <option value="hujan">Hujan</option>
                            <option value="berangin">Berangin</option>
                        </select>
                    </div>
                	<div class="form-group">
                        <label>Malam</label>
                        <select name="malam" class="form-control">
                            <option value="">Pilih</option>
                            <option value="cerah">Cerah</option>
                            <option value="panas">Panas</option>
                            <option value="berawan">Berawan</option>
                            <option value="sejuk">Sejuk</option>
                            <option value="hujan">Hujan</option>
                            <option value="berangin">Berangin</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Dini Hari</label>
                        <select name="dini_hari" class="form-control">
                            <option value="">Pilih</option>
                            <option value="cerah">Cerah</option>
                            <option value="panas">Panas</option>
                            <option value="berawan">Berawan</option>
                            <option value="sejuk">Sejuk</option>
                            <option value="hujan">Hujan</option>
                            <option value="berangin">Berangin</option>
                        </select>
                    </div>
                
                	<div class="form-group">
						<label>Suhu</label>
						<input type="text" name="suhu" class="form-control">
                    	<small>Satuan dalam celcius</small>
					</div>
                
                	<div class="form-group">
						<label>Kelembapan</label>
						<input type="text" name="kelembapan" class="form-control">
                    	<small>Satuan dalam Persen(%)</small>
					</div>

					<button type="submit" name="tambah" class="btn-add btn-sm">Tambah Data</button>
				</div>
				<div class="clearfix"></div>
			</div>

		</form>
	</div>

	<?php 
}

function edit_cuaca(){
	global $db;
	global $library;

	$id = isset($_GET['id']) ? abs($_GET['id']) : false;

	$library->add_rule('tema', 'Tema', array('require'));
	if(isset($_POST['update'])){
    		$objects = array(
            	'cuaca' => $_POST['cuaca'],'siang' => $_POST['siang'],
            	'malam' => $_POST['malam'],
            	'dini_hari' => $_POST['dini_hari'],
            	'suhu' => $_POST['suhu'],
            	'kelembapan' => $_POST['kelembapan'],
        	);
    
			$update = $db->update("cuaca", $objects, array('tanggal_prediksi', $_POST['tanggal_prediksi']));
  
			if($update){
				$library->message = "Berhasil memperbaharui data";
				$library->alert_class = "alert-success";
			}
			else{
				$library->message = "Gagal memperbaharui data";
				$library->alert_class = "alert-warning";
			}
	}

	$query_str = "SELECT * FROM cuaca WHERE id_cuaca='" . $id . "'";
	$data = $db->get_results($query_str);

	$id = $data[0]['id_cuaca'];
	$tanggal_prediksi = $data[0]['tanggal_prediksi'];
	$cuaca = $data[0]['cuaca'];
	$siang = $data[0]['siang'];
	$malam = $data[0]['malam'];
	$dini_hari = $data[0]['dini_hari'];
	$suhu = $data[0]['suhu'];
	$kelembapan = $data[0]['kelembapan'];

	?>
	
	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Edit Cuaca</h3> 

	</div>

	<div class="module-body">
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Tanggal Prediksi</label>
						<input type="date" name="tanggal_prediksi" class="form-control" value="<?php echo $tanggal_prediksi; ?>" readonly>
					</div>
                
                	<div class="form-group">
						<label>Cuaca</label>
                    	<select name="cuaca" class="form-control">
                        	<option value="">Pilih</option>
                        	<option value="cerah" <?php if($cuaca == "cerah"){ echo "selected"; } ?>>Cerah</option>
                        	<option value="panas" <?php if($cuaca == "panas"){ echo "selected"; } ?>>Panas</option>
                        	<option value="berawan" <?php if($cuaca == "berawan"){ echo "selected"; } ?>>Berawan</option>
                        	<option value="sejuk" <?php if($cuaca == "sejuk"){ echo "selected"; } ?>>Sejuk</option>
                       		<option value="hujan" <?php if($cuaca == "hujan"){ echo "selected"; } ?>>Hujan</option>
                        	<option value="berangin" <?php if($cuaca == "berangin"){ echo "selected"; } ?>>Berangin</option>
                    	</select>
					</div>
                	
                	<div class="form-group">
						<label>Siang</label>
                    	<select name="siang" class="form-control">
                        	<option value="">Pilih</option>
                        	<option value="cerah" <?php if($siang == "cerah"){ echo "selected"; } ?>>Cerah</option>
                        	<option value="panas" <?php if($siang == "panas"){ echo "selected"; } ?>>Panas</option>
                        	<option value="berawan" <?php if($siang == "berawan"){ echo "selected"; } ?>>Berawan</option>
                        	<option value="sejuk" <?php if($siang == "sejuk"){ echo "selected"; } ?>>Sejuk</option>
                       		<option value="hujan" <?php if($siang == "hujan"){ echo "selected"; } ?>>Hujan</option>
                        	<option value="berangin" <?php if($siang == "berangin"){ echo "selected"; } ?>>Berangin</option>
                    	</select>
					</div>
                
                	<div class="form-group">
						<label>Malam</label>
                    	<select name="malam" class="form-control">
                        	<option value="">Pilih</option>
                        	<option value="cerah" <?php if($malam == "cerah"){ echo "selected"; } ?>>Cerah</option>
                        	<option value="panas" <?php if($malam == "panas"){ echo "selected"; } ?>>Panas</option>
                        	<option value="berawan" <?php if($malam == "berawan"){ echo "selected"; } ?>>Berawan</option>
                        	<option value="sejuk" <?php if($malam == "sejuk"){ echo "selected"; } ?>>Sejuk</option>
                       		<option value="hujan" <?php if($malam == "hujan"){ echo "selected"; } ?>>Hujan</option>
                        	<option value="berangin" <?php if($malam == "berangin"){ echo "selected"; } ?>>Berangin</option>
                    	</select>
					</div>
                
                <div class="form-group">
						<label>Dini hari</label>
                    	<select name="dini_hari" class="form-control">
                        	<option value="">Pilih</option>
                        	<option value="cerah" <?php if($dini_hari == "cerah"){ echo "selected"; } ?>>Cerah</option>
                        	<option value="panas" <?php if($dini_hari == "panas"){ echo "selected"; } ?>>Panas</option>
                        	<option value="berawan" <?php if($dini_hari == "berawan"){ echo "selected"; } ?>>Berawan</option>
                        	<option value="sejuk" <?php if($dini_hari == "sejuk"){ echo "selected"; } ?>>Sejuk</option>
                       		<option value="hujan" <?php if($dini_hari == "hujan"){ echo "selected"; } ?>>Hujan</option>
                        	<option value="berangin" <?php if($dini_hari == "berangin"){ echo "selected"; } ?>>Berangin</option>
                    	</select>
					</div>
                
                	<div class="form-group">
						<label>Cuaca</label>
                    	<select name="cuaca" class="form-control">
                        	<option value="">Pilih</option>
                        	<option value="cerah" <?php if($cuaca == "cerah"){ echo "selected"; } ?>>Cerah</option>
                        	<option value="panas" <?php if($cuaca == "panas"){ echo "selected"; } ?>>Panas</option>
                        	<option value="berawan" <?php if($cuaca == "berawan"){ echo "selected"; } ?>>Berawan</option>
                        	<option value="sejuk" <?php if($cuaca == "sejuk"){ echo "selected"; } ?>>Sejuk</option>
                       		<option value="hujan" <?php if($cuaca == "hujan"){ echo "selected"; } ?>>Hujan</option>
                        	<option value="berangin" <?php if($cuaca == "berangin"){ echo "selected"; } ?>>Berangin</option>
                    	</select>
					</div>
                
                	
                
                	<div class="form-group">
						<label>Suhu</label>
						<input type="text" name="suhu" class="form-control" value="<?php echo $suhu; ?>">
                    	<small>Satuan dalam celcius</small>
					</div>
                
                	<div class="form-group">
						<label>Kelembapan</label>
						<input type="text" name="kelembapan" class="form-control" value="<?php echo $kelembapan; ?>">
                    	<small>Satuan dalam Persen(%)</small>
					</div>

					<button type="submit" name="update" class="btn-add btn-sm">Update Data</button>
				</div>
				<div class="clearfix"></div>
			</div>

		</form>
	</div>


	<?php 
}
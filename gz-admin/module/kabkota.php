<?php 

function kab_kota_data(){
	global $db;
	global $library;
	if(isset($_POST['delete'])){
		$delete = $db->delete("kab_kota", array('id_kab_kota', $_POST['id']));
		if($delete){
			$library->message = "Data berhasil dihapus";
			$library->alert_class = "alert-success";
		}
		else{
			$library->message = "Data gagal dihapus";
			$library->alert_class = "alert-warning";
		}
		unset($_POST);
	}

	$query_str = "SELECT * FROM kab_kota ";
	$query = $db->query($query_str);
	?>

	<div class="module-header">
    	<?php echo $library->alert(); ?>
    	<h3 class="module-title">Kabupaten/Kota
        	<a href="?module=add_kab_kota" class="btn-add">Tambah Data</a>
    	</h3>
	</div>
	<div class="module-body">
    	<table class="table table-bordered" id="table-users">
        	<thead>
            	<tr>
                	<td>ID</td>
                	<td>Nama</td>
                	<td>Telp</td>
                	<td>Fax</td>
                	<td>Alamat</td>
                	<td>Kalaksa</td>
                	<td>Dasar hukum</td>
                	<td width="10%">Action</td>
            	</tr>
        	</thead>
        	<tbody>
            	<?php  while($data = $query->fetch_array()){ ?>
            	<tr>
                	<td><?php echo $data['id_kab_kota']; ?></td>
                	<td><?php echo $data['nama_kab']; ?></td>
                	<td><?php echo $data['telp']; ?></td>
                	<td><?php echo $data['fax']; ?></td>
                	<td><?php echo $data['alamat']; ?></td>
                	<td><?php echo $data['nama_kalaksa']; ?></td>
                	<td><?php echo $data['dasar_hukum']; ?></td>
                	<td>
                    	<a class="btn btn-warning btn-small" href="?module=edit_kab_kota&id=<?php echo $data['id_kab_kota']; ?>"><span class="fa fa-pencil"></span></a>
                    	<form action="<?php echo ADMIN_URL . 'dashboard.php'; ?>?module=kab_kota_data" method="POST" style="display: inline-block;">
                        	<input type="hidden" name="id" value="<?php echo $data['id_kab_kota']; ?>">
                        	<button class="btn btn-danger btn-small" input="submit" name="delete">
                            	<span class="fa fa-trash"></span>
                        	</button>
                    	</form>
                	</td>
            	</tr>
            	<?php } ?>
        	</tbody>
    	</table>
	</div>

	<?php 
}

function add_kab_kota(){
	global $db, $library;
	
	if(isset($_POST['tambah'])){
    	$library->add_rule('nama_kab', 'Nama Kabupaten', array('require'));
    	if($library->run()){
        	$objects = array(
            	'nama_kab' => $_POST['nama_kab'],
           		'alamat' => $_POST['alamat'],
            	'telp' => $_POST['telp'],
            	'fax' => $_POST['fax'],
            	'nama_kalaksa' => $_POST['nama_kalaksa'],
            	'dasar_hukum' => $_POST['dasar_hukum']
            );
        
        	$save = $db->save('kab_kota', $objects);
        	if($save){
            	$library->message = "Berhasil Menyimpan";
				$library->alert_class = "alert-success";
            }
        	else{
            	$library->message = "Gagal menyimpan";
				$library->alert_class = "alert-danger";
            }
        }else{
        	$library->message = "Data tidak boleh kosong";
			$library->alert_class = "alert-warning";
        }
    }
	
	?>
	
	<div class="module-header">
    	<?php $library->alert(); ?>
    	<h3 class="module-title">Tambah Data</h3>
	</div>
	<div class="module-body">
    	<form method="POST" action="">
        	<div class="row">
            	<div class="col-md-8">
                
                	<div class="form-group">
                    	<label>Nama Kabupaten</label>
                    	<input name="nama_kab" class="form-control">
                	</div>
                	
                	<div class="form-group">
                    	<label>Kalaksa</label>
                    	<input name="nama_kalaksa" class="form-control">
                    </div>
                
                	<div class="form-group">
                    	<label>Dasar Hukum</label>
                    	<input name="dasar_hukum" class="form-control">
                    </div>
                
                	<div class="form-group">
                    	<label>Alamat</label>
                    	<textarea name="alamat" class="form-control" rows="5"></textarea>
                	</div>
                
            	</div>
            	<div class="col-md-4">
                	<div id="terbitkan">
						<div class="widget">
							<div class="widget-header">
								<span class="widget-title">Terbitkan</span>
							</div>
							<div class="widget-body">
								<div class="form-group">
									<label for="">Telp.</label>
									<input name="telp" value="" class="form-control">
								</div>
							</div>
							<div class="widget-footer">
								<div class="widget-action pull-right">
									<button type="submit" name="tambah" class="btn-add btn-sm">Tambah Data</button>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
                
                	<div id="terbitkan">
						<div class="widget">
							<div class="widget-header">
								<span class="widget-title">Fax</span>
							</div>
							<div class="widget-body">
								<div class="form-group">
									<input name="fax" value="" class="form-control">
								</div>
							</div>
						</div>
					</div>
            	</div>
        	</div>
        </form>
	</div>
	
	<?php
}

function edit_kab_kota(){
	global $db, $library;
	
	$id = isset($_GET['id']) ? abs($_GET['id']) : false;
	
	if(isset($_POST['update'])){
    	$library->add_rule('nama_kab', 'Nama Kabupaten', array('require'));
    	if($library->run()){
        	$objects = array(
            	'nama_kab' => $_POST['nama_kab'],
           		'alamat' => $_POST['alamat'],
            	'telp' => $_POST['telp'],
            	'fax' => $_POST['fax'],
            	'nama_kalaksa' => $_POST['nama_kalaksa'],
            	'dasar_hukum' => $_POST['dasar_hukum']
            );
        
        	$update = $db->update('kab_kota', $objects, array('id_kab_kota', $_POST['id']));
        	if($update){
            	$library->message = "Berhasil Menyimpan";
				$library->alert_class = "alert-success";
            }
        	else{
            	$library->message = "Gagal menyimpan";
				$library->alert_class = "alert-danger";
            }
        }else{
        	$library->message = "Data tidak boleh kosong";
			$library->alert_class = "alert-warning";
        }
    }

	$query_str = "SELECT * FROM kab_kota WHERE id_kab_kota='{$id}' LIMIT 1";
	$query = $db->query($query_str);
	$data = $query->fetch_array();
	
	$nama_kab = isset($data['nama_kab']) ? $data['nama_kab'] : false;
	$nama_kalaksa = isset($data['nama_kalaksa']) ? $data['nama_kalaksa'] : false;
	$dasar_hukum = isset($data['dasar_hukum']) ? $data['dasar_hukum'] : false;
	$alamat = isset($data['alamat']) ? $data['alamat'] : false;
	$telp = isset($data['telp']) ? $data['telp'] : false;
	$fax = isset($data['fax']) ? $data['fax'] : false;
	
	?>
	
	<div class="module-header">
    	<?php $library->alert(); ?>
    	<h3 class="module-title">Edit Data</h3>
	</div>
	<div class="module-body">
    	<form method="POST" action="">
        	<input type="hidden" name="id" value="<?php echo $id ?>">
        	<div class="row">
            	<div class="col-md-8">

                	<div class="form-group">
                    	<label>Nama Kabupaten</label>
                    	<input name="nama_kab" class="form-control" value="<?php echo $nama_kab; ?>">
                	</div>
                	
                	<div class="form-group">
                    	<label>Kalaksa</label>
                    	<input name="nama_kalaksa" class="form-control" value="<?php echo $nama_kalaksa; ?>">
                    </div>
                
                	<div class="form-group">
                    	<label>Dasar Hukum</label>
                    	<input name="dasar_hukum" class="form-control" value="<?php echo $dasar_hukum; ?>">
                    </div>
                
                	<div class="form-group">
                    	<label>Alamat</label>
                    	<textarea name="alamat" class="form-control" rows="5"><?php echo $alamat ?></textarea>
                	</div>
                
            	</div>
            	<div class="col-md-4">
                	<div id="terbitkan">
						<div class="widget">
							<div class="widget-header">
								<span class="widget-title">Terbitkan</span>
							</div>
							<div class="widget-body">
								<div class="form-group">
									<label for="">Telp.</label>
									<input name="telp" class="form-control" value="<?php echo $telp ?>">
								</div>
							</div>
							<div class="widget-footer">
								<div class="widget-action pull-right">
									<button type="submit" name="update" class="btn-add btn-sm">Update Data</button>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
                
                	<div id="terbitkan">
						<div class="widget">
							<div class="widget-header">
								<span class="widget-title">Fax</span>
							</div>
							<div class="widget-body">
								<div class="form-group">
									<input name="fax" class="form-control" value="<?php echo $fax; ?>">
								</div>
							</div>
						</div>
					</div>
            	</div>
        	</div>
        </form>
	</div>
	
	<?php
}

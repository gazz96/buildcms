<?php 

function pegawai_data(){
	global $db;
	global $library;

	if(isset($_POST['delete'])){
		$delete = $db->delete("pegawai", array('id_pegawai', $_POST['id']));
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

	$query_str = "SELECT * FROM pegawai ORDER BY id_pegawai DESC";
	$query = $db->query($query_str);
	?>
	<div class="module-header">
    	<?php echo $library->alert(); ?>
    	<h3 class="module-title"> Data Pegawai
        	<a href="?module=add_pegawai" class="btn-add">Tambah Data</a>
        </h3>
	</div>

	<div class="module-body">
    	<table class="table table-bordered" id="table-users">
       		<thead>
            	<tr>
                	<td>ID</td>
                	<td>Nama</td>
                	<td>Jabatan</td>
                	<td>Keterangan</td>
                	<td>Action</td>
            	</tr>
            </thead>
        	<tbody>
            <?php while($data = $query->fetch_array()){ ?>
            	<tr>
                	<td><?php echo $data['id_pegawai']; ?></td>
                	<td><?php echo $data['nama']; ?></td>
                	<td><?php echo $data['jabatan']; ?></td>
                	<td><?php echo $data['keterangan']; ?></td>
                	<td>
                		<a class="btn btn-warning btn-small" href="?module=edit_pegawai&id=<?php echo $data['id_pegawai']; ?>"><span class="fa fa-pencil"></span></a>
                    	<form action="<?php echo ADMIN_URL . 'dashboard.php'; ?>?module=pegawai_data" method="POST" style="display: inline-block;">
                        	<input type="hidden" name="id" value="<?php echo $data['id_pegawai']; ?>">
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


function add_pegawai(){
	
	global $db, $library;
	
	if(isset($_POST['tambah'])){
    	$library->add_rule('nama', 'Nama Pegawai', array('require'));
    	if($library->run()){
        	//print_r($_POST);
        	$objects = array(
            	'nama' => $_POST['nama'],
           		'jabatan' => $_POST['jabatan'],
            	'keterangan' => $_POST['keterangan'],
            );
        
        	//print_r($objects);
        
        	$save = $db->save('pegawai', $objects);
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
                    	<label>Nama</label>
                    	<input name="nama" class="form-control">
                	</div>
                	
                	<div class="form-group">
                    	<label>Jabatan</label>
                    	<input name="jabatan" class="form-control">
                    </div>
                
                	<div class="form-group">
                    	<label>Keterangan</label>
                    	<textarea name="keterangan" class="form-control" rows="5"></textarea>
                	</div>
                	<button type="submit" name="tambah" class="btn-add btn-sm">Tambah Data</button>
            	</div>
        	</div>
        </form>
	</div>
	
	<?php
}

function edit_pegawai(){
	global $db, $library;
	
	$id = isset($_GET['id']) ? abs($_GET['id']) : false;
	
	if(isset($_POST['update'])){
    	$library->add_rule('nama', 'Nama Pegawai', array('require'));
    	if($library->run()){
        	$objects = array(
            	'nama' => $_POST['nama'],
           		'jabatan' => $_POST['jabatan'],
            	'keterangan' => $_POST['keterangan'],
            );
        
        	$update = $db->update('pegawai', $objects, array('id_pegawai', $_POST['id']));
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

	$query_str = "SELECT * FROM pegawai WHERE id_pegawai='{$id}' LIMIT 1";
	$query = $db->query($query_str);
	$data = $query->fetch_array();
	
	$nama = isset($data['nama']) ? $data['nama'] : false;
	$jabatan = isset($data['jabatan']) ? $data['jabatan'] : false;
	$keterangan = isset($data['keterangan']) ? $data['keterangan'] : false;
	
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
                    	<label>Nama Pegawai</label>
                    	<input name="nama" class="form-control" value="<?php echo $nama; ?>">
                	</div>
                	
                	<div class="form-group">
                    	<label>Jabatan</label>
                    	<input name="jabatan" class="form-control" value="<?php echo $jabatan; ?>">
                    </div>
   
                	<div class="form-group">
                    	<label>Keterangan</label>
                    	<textarea name="keterangan" class="form-control" rows="5"><?php echo $keterangan ?></textarea>
                	</div>
                	<button type="submit" name="update" class="btn-add btn-sm">Update Data</button>
                
            	</div>
        	</div>
        </form>
	</div>
	
	<?php
}

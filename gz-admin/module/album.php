<?php 

function album_data(){
	global $library;
	global $db;

	if(isset($_POST['delete'])){
		$delete = $db->delete("album", array('id_album="' . $_POST['id'] . '"'));
		if($delete){
			$library->message = "Data berhasil dihapus";
			$library->alert_class = "alert-success";
		}
		else{
			$library->message = "Data gagal dihapus";
			$library->alert_class = "alert-warning";
		}
	}

	$query_str = "SELECT * FROM album";
	$data = $db->get_results($query_str);

	?>

	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Data Album
			<a href="?module=add_album" class="btn-add">Tambah Data</a>
		</h3> 
	</div>
	
	<div class="module-body">
		<table class="table table-bordered" id="table-users">
			<thead>
				<tr>
					<th>ID</th>
					<th>Judul</th>
					<th>Slug</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data as $d): ?>
					<tr>
						<td><?php echo $d['id_album']; ?></td>
						<td><?php echo $d['jdl_album']; ?></td>
						<td><?php echo $d['slug_album']; ?></td>
						<td>
							<a class="btn btn-warning btn-small" href="?module=edit_album&id=<?php echo $d['id_album']; ?>"><span class="fa fa-pencil"></span></a>
							<a class="btn btn-info btn-small" href="?module=view_album&id=<?php echo $d['id_album']; ?>"><span class="fa fa-eye"></span></a>
							<form method="POST" action="?module=album_data" style="display: inline-block;">
								<input type="hidden" name="id" value="<?php echo $d['id_album']; ?>">
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

function add_album(){
	global $db;
	global $library;

	$library->add_rule('jdl_album', 'Judul Album', array('require'));
	$library->add_rule('aktif', 'Status', array('require'));
	if(isset($_POST['tambah'])){
		if($library->run()){
			$jdl_album  = $library->getPost('jdl_album');
			$slug_album = slug($jdl_album);
			$aktif 			= $library->getPost('aktif');
			$objects = array(
				'jdl_album' => $jdl_album,
				'slug_album' => slug($jdl_album),
				'aktif'			=> $aktif
			);
			$save = $db->save("album", $objects);
			if($save){
				$library->message = "Berhasil menambahkan data";
				$library->alert_class = "alert-success";
			}
			else{
				$library->message = "Gagal menambahkan data";
				$library->alert_class = "alert-warning";
			}
		}else{
			$library->message = "Data tidak boleh kosong";
			$library->alert_class = "alert-warning";
		}
	}

	?>
	
	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Tambah Album</h3> 
	</div>

	<div class="module-body">
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-4">
					<div id="terbitkan">
						<div class="widget">
							<div class="widget-header">
								<span class="widget-title">Simpan</span>
							</div>
							<div class="widget-body">
								<div class="form-group">
									<label for="">Judul Album</label>
									<input type="text" name="jdl_album" value="<?php echo $library->form_value('jdl_album') ?>" class="form-control">
								</div>
								<div class="form-group">
									<label for="">Aktif</label>
									<select name="aktif" id="" class="form-control">
										<option value="Y" <?php if($library->form_value('aktif') == "Y"){echo "selected"; } ?>>Ya</option>
										<option value="N" <?php if($library->form_value('aktif') == "N"){echo "selected"; } ?>>Tidak</option>
									</select>
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

				</div>
				<div class="clearfix"></div>
			</div>

		</form>
	</div>

	<?php 
}

function edit_album(){
	global $db;
	global $library;

	$id = isset($_GET['id']) ? abs($_GET['id']) : false;

	$library->add_rule('jdl_album', 'Judul Album', array('require'));
	$library->add_rule('aktif', 'Status', array('require'));
	if(isset($_POST['update'])){
		if($library->run()){
			$jdl_album  = $library->getPost('jdl_album');
			$slug_album = slug($jdl_album);
			$aktif 		= $library->getPost('aktif');
			$objects = array(
				'jdl_album' => $jdl_album,
				'slug_album' => slug($jdl_album),
				'aktif'			=> $aktif
			);
			$update = $db->update("album", $objects, array('id_album', $library->getPost('id')));
			if($update){
				$library->message = "Berhasil memperbaharui data";
				$library->alert_class = "alert-success";
			}
			else{
				$library->message = "Gagal memperbaharui data";
				$library->alert_class = "alert-warning";
			}
		}else{
			$library->message = "Data tidak boleh kosong";
			$library->alert_class = "alert-warning";
		}
	}

	$query_str = "SELECT * FROM album WHERE id_album='{$id}'";
	$data = $db->get_results($query_str);

	$id = $data[0]['id_album'];
	$jdl_album = $data[0]['jdl_album'];
	$aktif = $data[0]['aktif'];

	?>
	
	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Tambah Album</h3> 

	</div>

	<div class="module-body">
		<form action="" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $id; ?>">
			<div class="row">
				<div class="col-md-4">
					<div id="terbitkan">
						<div class="widget">
							<div class="widget-header">
								<span class="widget-title">Simpan</span>
							</div>
							<div class="widget-body">
								<div class="form-group">
									<label for="">Judul Album</label>
									<input type="text" name="jdl_album" value="<?php echo $jdl_album; ?>" class="form-control">
								</div>

								<div class="form-group">
									<label for="">Aktif</label>
									<select name="aktif" id="" class="form-control">
										<option value="Y" <?php if($aktif == "Y"){echo "selected"; } ?>>Ya</option>
										<option value="N" <?php if($aktif == "N"){echo "selected"; } ?>>Tidak</option>
									</select>
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

				</div>
				<div class="clearfix"></div>
			</div>

		</form>
	</div>

	<?php 
}

function view_album(){
	global $db;
	global $library;

	$id = isset($_GET['id']) ? abs($_GET['id']) : false;

	$library->add_rule('jdl_album', 'Judul Album', array('require'));
	$library->add_rule('aktif', 'Status', array('require'));
	if(isset($_POST['update'])){
		if($library->run()){
			$jdl_album  = $library->getPost('jdl_album');
			$slug_album = slug($jdl_album);
			$aktif 		= $library->getPost('aktif');
			$objects = array(
				'jdl_album' => $jdl_album,
				'slug_album' => slug($jdl_album),
				'aktif'			=> $aktif
			);
			$update = $db->update("album", $objects, array('id_album', $library->getPost('id')));
			if($update){
				$library->message = "Berhasil memperbaharui data";
				$library->alert_class = "alert-success";
			}
			else{
				$library->message = "Gagal memperbaharui data";
				$library->alert_class = "alert-warning";
			}
		}else{
			$library->message = "Data tidak boleh kosong";
			$library->alert_class = "alert-warning";
		}
	}

	$query_str = "SELECT * FROM gallery WHERE id_album='{$id}'";
	$data = $db->get_results($query_str);

	?>
	
	<div class="module-header">
		<div id="message-wrapper">
			<?php $library->alert(); ?>	
		</div>
		<h3 class="module-title">Edit Galeri</h3> 

	</div>

	<div class="module-body">
		<div class="row">
			<?php for($i=0; $i < count($data); $i++){ ?>
				<div class="col-md-3">
					<div class="img-wrapper" style="background-image: url('<?php echo $data[$i]['jdl_gallery']; ?>" alt="<?php echo $data[$i]['keterangan']; ?>')">
						<div class="img-header">
							<div class="header-action">
								<a href="<?php echo BASE_URL . 'gz-admin/ajax/galeri.ajax.php'; ?>" id="<?php echo $data[$i]['id_gallery']; ?>" class="btn btn-sm delete-gallery"><span class="fa fa-trash"></span></a>
								<a href="<?php echo BASE_URL . 'gz-admin/ajax/galeri.ajax.php'; ?>" id="<?php echo $data[$i]['id_gallery']; ?>" class="btn btn-sm update-gallery"><span class="fa fa-pencil"></span></a>
								<a href="<?php echo BASE_URL . 'gz-admin/ajax/galeri.ajax.php'; ?>" id="<?php echo $data[$i]['id_gallery']; ?>" class="btn btn-sm open-gallery-detail"><span class="fa fa-eye"></span></a>
							</div>
						</div>
						<div class="img-content">
							<textarea name="" id="" cols="30" rows="10" class="form-control"><?php echo $data[$i]['keterangan']; ?></textarea>
						</div>
						<!-- <div class="img-footer"></div> -->
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php 
}
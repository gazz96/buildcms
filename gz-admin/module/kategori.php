<?php 

function kategori_data(){
	global $library;
	global $db;

	if(isset($_POST['delete'])){
		$delete = $db->delete("kategori", array('id_kategori="' . $_POST['id'] .'" AND id_kategori != 1'));
		if($delete){
			$library->message = "Data berhasil dihapus";
			$library->alert_class = "alert-success";
		}
		else{
			$library->message = "Data gagal dihapus";
			$library->alert_class = "alert-warning";
		}
	}

	$query_str = "SELECT * FROM kategori";
	$data = $db->get_results($query_str);

	?>

	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Data Kategori
			<a href="?module=add_kategori" class="btn-add">Tambah Data</a>
		</h3> 
	</div>
	
	<div class="module-body">
		<table class="table table-bordered" id="table-users">
			<thead>
				<tr>
					<th>ID</th>
					<th>Kategori</th>
					<th>Slug</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data as $d): ?>
					<tr>
						<td><?php echo $d['id_kategori']; ?></td>
						<td><?php echo $d['nama_kategori']; ?></td>
						<td><?php echo $d['slug_kategori']; ?></td>
						<td>
							<a class="btn btn-warning btn-small" href="?module=edit_kategori&id=<?php echo $d['id_kategori']; ?>"><span class="fa fa-pencil"></span></a>
							<form method="POST" action="?module=kategori_data" style="display: inline-block;">
								<input type="hidden" name="id" value="<?php echo $d['id_kategori']; ?>">
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

function add_kategori(){
	global $db;
	global $library;

	$library->add_rule('nama_kategori', 'Kategori', array('require'));
	$library->add_rule('aktif', 'Status', array('require'));
	if(isset($_POST['tambah'])){
		if($library->run()){
			$nama_kategori  = $library->getPost('nama_kategori');
			$aktif 			= $library->getPost('aktif');
			$objects = array(
				'nama_kategori' => $nama_kategori,
				'slug_kategori' => slug($nama_kategori),
				'aktif'			=> $aktif
			);
			$save = $db->save("kategori", $objects);
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
		<h3 class="module-title">Tambah Kategori</h3> 

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
									<label for="">Kategori</label>
									<input type="text" name="nama_kategori" class="form-control" value="<?php echo $library->form_value('nama_kategori'); ?>">
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

function edit_kategori(){
	global $db;
	global $library;

	$id = isset($_GET['id']) ? abs($_GET['id']) : false;

	$library->add_rule('nama_kategori', 'Kategori', array('require'));
	$library->add_rule('aktif', 'Status', array('require'));
	if(isset($_POST['update'])){
		if($library->run()){
			$nama_kategori  = $library->getPost('nama_kategori');
			$aktif 			= $library->getPost('aktif');
			$objects = array(
				'nama_kategori' => $nama_kategori,
				'slug_kategori' => slug($nama_kategori),
				'aktif'			=> $aktif
			);
			$update = $db->update("kategori", $objects, array('id_kategori', $library->getPost('id')));
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

	$query_str = "SELECT * FROM kategori WHERE id_kategori='{$id}'";
	$data = $db->get_results($query_str);

	$id = $data[0]['id_kategori'];
	$nama_kategori = $data[0]['nama_kategori'];
	$aktif = $data[0]['aktif'];

	?>
	
	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Edit Kategori</h3> 

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
									<label for="">Kategori</label>
									<input type="text" name="nama_kategori" class="form-control" value="<?php echo $nama_kategori; ?>">
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
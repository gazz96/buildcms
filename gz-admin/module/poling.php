<?php 

function poling_data(){
	global $library;
	global $db;

	if(isset($_POST['delete'])){
		$delete = $db->delete("poling", array('id_poling="' . $_POST['id'] . '"'));
		if($delete){
			$library->message = "Data berhasil dihapus";
			$library->alert_class = "alert-success";
		}
		else{
			$library->message = "Data gagal dihapus";
			$library->alert_class = "alert-warning";
		}
	}

	$query_str = "SELECT * FROM poling";
	$data = $db->get_results($query_str);

	?>
	
	<div class="module-header">
		<h3 class="module-title">Data Poling
			<a href="?module=add_poling" class="btn btn-add">Tambah Data</a>
		</h3>
	</div>
	<div class="module-body">
		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered" id="table-users">
					<thead>
						<tr>
							<th>ID</th>
							<th>Pilihan</th>
							<th>Status</th>
							<th>Rating</th>
							<th>Aktif</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($data as $d): ?>
							<tr>
								<td><?php echo $d['id_poling']; ?></td>
								<td><?php echo $d['pilihan']; ?></td>
								<td><?php echo $d['status']; ?></td>
								<td><?php echo $d['rating']; ?></td>
								<td><?php echo $d['aktif']; ?></td>
								<td>
									<a class="btn btn-warning btn-small" href="?module=edit_poling&id=<?php echo $d['id_poling']; ?>"><span class="fa fa-pencil"></span></a>
									<?php if($d['status'] != "Pertanyaan"){ ?>
									<form method="POST" action="?module=poling_data" style="display: inline-block;">
										<input type="hidden" name="id" value="<?php echo $d['id_poling']; ?>">
										<button class="btn btn-danger btn-small" input="submit" name="delete">
											<span class="fa fa-trash"></span>
										</button>
									</form>
									<?php } ?>
								</td>
							</tr>
						<?php  endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<?php 
}

function add_poling(){
	global $db, $library;

	$library->add_rule('pilihan', 'Pilihan', array('require'));
	$library->add_rule('aktif', 'Status', array('require'));
	if(isset($_POST['tambah'])){
		if($library->run()){

			$objects = array(
				'pilihan' => $_POST['pilihan'],
				'aktif'			=> $_POST['aktif'],
				'rating' => 0,
				'status' => 'Jawaban'
			);
			$save = $db->save("poling", $objects);
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
		<h3 class="module-title">Tambah Jawaban</h3> 

	</div>

	<div class="module-body">
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-5">
					<div id="terbitkan">
						<div class="widget">
							<div class="widget-header">
								<span class="widget-title">Simpan</span>
							</div>
							<div class="widget-body">
								<div class="form-group">
									<label for="">Jawaban</label>
									<input type="text" name="pilihan" class="form-control" value="<?php echo $library->form_value('pilihan'); ?>">
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

function edit_poling(){
	global $db, $library;

	$library->add_rule('pilihan', 'Pilihan', array('require'));
	$library->add_rule('aktif', 'Status', array('require'));

	$id = isset($_GET['id']) ? abs($_GET['id']) : false;
	if(isset($_POST['update'])){

		if($library->run()){

			$objects = array(
				'pilihan' => $_POST['pilihan'],
				'aktif'			=> $_POST['aktif'],
			);
			$save = $db->update("poling", $objects, array('id_poling', $_POST['id']));
			if($save){
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

	$query_str = "SELECT * FROM poling WHERE id_poling='{$id}' LIMIT 1";
	$data = $db->get_results($query_str);

	$id = $data[0]['id_poling'];
	$pilihan = $data[0]['pilihan'];
	$aktif = $data[0]['aktif']

	?>

	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Edit Data</h3> 

	</div>

	<div class="module-body">
		<form action="" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $id; ?>">
			<div class="row">
				<div class="col-md-5">
					<div id="terbitkan">
						<div class="widget">
							<div class="widget-header">
								<span class="widget-title">Update</span>
							</div>
							<div class="widget-body">
								<div class="form-group">
									<label for="">Jawaban</label>
									<input type="text" name="pilihan" class="form-control" value="<?php echo $pilihan; ?>">
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
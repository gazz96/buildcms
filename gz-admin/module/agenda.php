<?php 

function agenda_data(){
	global $library;
	global $db;

	if(isset($_POST['delete'])){
		$delete = $db->delete("agenda", array('id_agenda="' . $_POST['id'] .'"'));
		if($delete){
			$library->message = "Data berhasil dihapus";
			$library->alert_class = "alert-success";
		}
		else{
			$library->message = "Data gagal dihapus";
			$library->alert_class = "alert-warning";
		}
	}

	$query_str = "SELECT * FROM agenda";
	$data = $db->get_results($query_str);

	?>

	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Data Agenda
			<a href="?module=add_agenda" class="btn-add">Tambah Data</a>
		</h3> 
	</div>
	
	<div class="module-body">
		<table class="table table-bordered" id="table-users">
			<thead>
				<tr>
					<th>ID</th>
					<th>tema</th>
					<th>Tanggal Mulai</th>
					<th>Tanggal Selesai</th>
					<th>Jam</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data as $d): ?>
					<tr>
						<td><?php echo $d['id_agenda']; ?></td>
						<td><?php echo $d['tema']; ?></td>
						<td><?php echo $d['tgl_mulai']; ?></td>
						<td><?php echo $d['tgl_selesai']; ?></td>
						<td><?php echo $d['jam']; ?></td>
						<td>
							<a class="btn btn-warning btn-small" href="?module=edit_agenda&id=<?php echo $d['id_agenda']; ?>"><span class="fa fa-pencil"></span></a>
							<form method="POST" action="?module=agenda_data" style="display: inline-block;">
								<input type="hidden" name="id" value="<?php echo $d['id_agenda']; ?>">
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

function add_agenda(){
	global $db;
	global $library;

	$library->add_rule('tema', 'Tema', array('require'));
	if(isset($_POST['tambah'])){
		if($library->run()){
			$objects = array(
				'tema' => $_POST['tema'],
				'tema_seo' => slug($_POST['tema']),
				'isi_agenda' => $_POST['isi_agenda'],
				'tgl_mulai' => $_POST['tgl_mulai'],
				'tgl_selesai' => $_POST['tgl_selesai'],
				'jam'	=> $_POST['jam'],
				'tgl_posting' => date('Y-m-d')

			);
			print_r($objects);
			$save = $db->save("agenda", $objects);
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
		<h3 class="module-title">Tambah Agenda</h3> 

	</div>

	<div class="module-body">
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label>Tema</label>
						<input type="text" name="tema" class="form-control">
					</div>

					<!-- <div class="form-group">
						<label>Isi Agenda</label>
						<textarea name="isi_agenda" class="form-control" rows="9" id="beritaContent"></textarea>
					</div> -->
				</div>
				<div class="col-md-4">
					<div id="terbitkan">
						<div class="widget">
							<div class="widget-header">
								<span class="widget-title">Simpan</span>
							</div>
							<div class="widget-body">
								<div class="form-group">
									<label for="">Tanggal Mulai</label>
									<input type="date" name="tgl_mulai" class="form-control" value="">
								</div>

								<div class="form-group">
									<label for="">Tanggal Selesai</label>
									<input type="date" name="tgl_selesai" class="form-control">
								</div>

								<div class="form-group">
									<label>Jam</label>
									<input type="text" name="jam" class="form-control" value="">
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
	<script>
		 tinymce.init({
		    selector: '#beritaContent',
		    height: 500,
		   	theme: 'modern',
  			plugins: [
		         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
		         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking spellchecker",
		         "table contextmenu directionality emoticons paste textcolor responsivefilemanager "
   			],
   			image_advtab: true,
  			external_filemanager_path : "<?php echo ASSETS_URL . 'tinymce/plugins/responsivefilemanager/filemanager'; ?>/",
  			toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
  			toolbar2: "| responsivefilemanager | image | media | link unlink anchor | print preview",
  			filemanager_title : 'responsive Filemanager',
  			external_plugins : { 'filemanager' : "<?php echo ASSETS_URL . 'tinymce/plugins/responsivefilemanager/filemanager/plugin.min.js'; ?>" }

		  });
	</script>

	<?php 
}

function edit_agenda(){
	global $db;
	global $library;

	$id = isset($_GET['id']) ? abs($_GET['id']) : false;

	$library->add_rule('tema', 'Tema', array('require'));
	if(isset($_POST['update'])){
		if($library->run()){
			$nama_kategori  = $library->getPost('nama_kategori');
			$aktif 			= $library->getPost('aktif');
			$objects = array(
				'tema' => $_POST['tema'],
				'tema_seo' => slug($_POST['tema']),
				'isi_agenda' => $_POST['isi_agenda'],
				'tgl_mulai' => $_POST['tgl_mulai'],
				'tgl_selesai' => $_POST['tgl_selesai'],
				'jam'	=> $_POST['jam'],
				'tgl_posting' => date('Y-m-d')
			);
			$update = $db->update("agenda", $objects, array('id_agenda', $library->getPost('id')));
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

	$query_str = "SELECT * FROM agenda WHERE id_agenda='{$id}'";
	$data = $db->get_results($query_str);

	$id = $data[0]['id_agenda'];
	$tema = $data[0]['tema'];
	$isi_agenda = $data[0]['isi_agenda'];
	$tgl_mulai = $data[0]['tgl_mulai'];
	$tgl_selesai = $data[0]['tgl_selesai'];
	$jam = $data[0]['jam'];

	?>
	
	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Edit Kategori</h3> 

	</div>

	<div class="module-body">
		<form action="" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $id; ?>">
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label>Tema</label>
						<input type="text" name="tema" class="form-control" value="<?php echo $tema; ?>">
					</div>

					<!-- <div class="form-group">
						<label>Isi Agenda</label>
						<textarea name="isi_agenda" class="form-control" rows="9" id="beritaContent"><?php echo $isi_agenda; ?></textarea>
					</div> -->
				</div>
				<div class="col-md-4">
					<div id="terbitkan">
						<div class="widget">
							<div class="widget-header">
								<span class="widget-title">Simpan</span>
							</div>
							<div class="widget-body">
								<div class="form-group">
									<label for="">Tanggal Mulai</label>
									<input type="date" name="tgl_mulai" class="form-control" value="<?php echo $tgl_mulai; ?>">
								</div>

								<div class="form-group">
									<label for="">Tanggal Selesai</label>
									<input type="date" name="tgl_selesai" class="form-control" value="<?php echo $tgl_selesai ?>">
								</div>

								<div class="form-group">
									<label>Jam</label>
									<input type="text" name="jam" class="form-control" value="<?php echo $jam; ?>">
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
	<script>
		 tinymce.init({
		    selector: '#beritaContent',
		    height: 500,
		   	theme: 'modern',
  			plugins: [
		         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
		         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking spellchecker",
		         "table contextmenu directionality emoticons paste textcolor responsivefilemanager "
   			],
   			image_advtab: true,
  			external_filemanager_path : "<?php echo ASSETS_URL . 'tinymce/plugins/responsivefilemanager/filemanager'; ?>/",
  			toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
  			toolbar2: "| responsivefilemanager | image | media | link unlink anchor | print preview",
  			filemanager_title : 'responsive Filemanager',
  			external_plugins : { 'filemanager' : "<?php echo ASSETS_URL . 'tinymce/plugins/responsivefilemanager/filemanager/plugin.min.js'; ?>" }

		  });
	</script>

	<?php 
}
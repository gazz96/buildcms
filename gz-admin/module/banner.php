<?php 

/** Users Data **/
function banner_data(){
	global $db;
	global $library;

	if(isset($_POST['delete'])){
		$delete = $db->delete("banner", array('id_banner', $_POST['id']));
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


	$query_str = "SELECT * FROM banner ORDER BY id_banner DESC";
	$data = $db->get_results($query_str);
	
	?>

	

	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Data Banner
			<a href="?module=add_banner" class="btn-add">Tambah Data</a>
		</h3> 

	</div>
	
	<div class="module-body">
		<table class="table table-bordered" id="table-banner">
			<thead>
				<tr>
					<th>ID</th>
					<th>Judul</th>
					<th>URL</th>
					<th>Tanggal di Post</th>
                	<th>Jenis</th>
					<th>Gambar</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data as $d): ?>
					<tr>
						<td><?php echo $d['id_banner']; ?></td>
						<td><?php echo $d['judul']; ?></td>
						<td><?php echo $d['url']; ?></td>
						<td><?php echo $d['tgl_posting']; ?></td>
                    	<td><?php echo $d['jenis']; ?></td>
						<td><img src="<?php echo $d['gambar']; ?>" alt="" width="150px"></td>
						<td>
							<a class="btn btn-warning btn-small" href="?module=edit_banner&id=<?php echo $d['id_banner']; ?>"><span class="fa fa-pencil"></span></a>
							<form action="<?php echo ADMIN_URL . 'dashboard.php'; ?>?module=banner_data" method="POST" style="display: inline-block;">
								<input type="hidden" name="id" value="<?php echo $d['id_banner']; ?>">
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

function add_banner(){
	global $uploads;
	global $db;
	global $library;

	$library->add_rule('judul', 'Username', array('require'));
	if(isset($_POST['tambah'])){
		if($library->run()){

			$imgInput = $library->getFile('imgInput');
			$tryto = $uploads->upload_file($_FILES['imgInput']);

			if($tryto){
				$objects = array(
					"judul" => $library->getPost('judul'),
					"url" => $library->getPost('url'),
					"deskripsi_banner" => $library->getPost('deskripsi_banner'),
					"tgl_posting" => date('Y-m-d'),
					"gambar" => $uploads->upload_data('path'),
					'jenis' => $_POST['jenis']
				);	
			}
			else{
				$objects = array(
					"judul" => $library->getPost('judul'),
					"url" => $library->getPost('url'),
					"deskripsi_banner" => $library->getPost('deskripsi_banner'),
					"tgl_posting" => date('Y-m-d'),
                	'jenis' => $_POST['jenis']
				);
			}
        
        	//print_r($objects);
			
			$save = $db->save("banner", $objects);
			if($save){	
				$library->message = "Berhasil menambahkan data";
				$library->alert_class = "alert-success";
			}else{
				$library->message = "Gagal menambahkan data";
				$library->alert_class = "alert-warning";
			}
		}
		else{
			$library->message = "Data tidak boleh kosong";
			$library->alert_class = "alert-warning";
		}
			
	}

	?>
	
	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Tambah Banner</h3> 

	</div>

	<div class="module-body">
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label for="">Judul</label>
						<input type="text" name="judul" class="form-control" value="<?php echo $library->form_value('judul'); ?>">
					</div>	
					<div class="form-group">
						<label>Jenis</label>
						<select class="form-control" name="jenis" >
							<option value="gambar">Gambar</option>
							<option value="video">Video</option>
						</select>
					</div>			
					

					<div class="form-group">
						<label for="">URL</label>
						<input type="text" name="url" class="form-control" value="<?php echo $library->form_value('url'); ?>">
					</div>

					<div class="form-group">
						<label for="">Deskripsi</label>
						<textarea name="deskripsi_banner" id="" cols="30" rows="10" class="form-control"><?php echo $library->form_value('username'); ?></textarea>
					</div>	
				</div>
				<div class="col-md-4">
					<div id="terbitkan">
						<div class="widget">
							<div class="widget-header">
								<span class="widget-title">Simpan</span>
							</div>
							<div class="widget-body">
								<div class="form-group">
									<label for="">Tanggal</label>
									<input type="text" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>
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

					<div id="foto-profile">
						<div class="widget">
							<div class="widget-header">
								<span class="widget-title">Profile</span>
							</div>
							<div class="widget-body">
								<input type="hidden" name="user_img">
								<input type="file" name="imgInput" class="imgInput" style="visibility: hidden;max-height: 0">
								<a href="" id="profilTrigger">Pilih Gambar</a>
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

function edit_banner(){
	global $uploads;
	global $db;
	global $library;

	$library->add_rule('judul', 'Username', array('require'));
	if(isset($_POST['update'])){
    	//print_r($_FILES);
		if($library->run()){

			$imgInput = $library->getFile('imgInput');
			$tryto = $uploads->upload_file($_FILES['imgInput']);

			if($tryto){
				$objects = array(
					"judul" => $library->getPost('judul'),
					"url" => $library->getPost('url'),
					"deskripsi_banner" => $library->getPost('deskripsi_banner'),
					"tgl_posting" => date('Y-m-d'),
					"gambar" => $uploads->upload_data('path'),
                	"jenis" => $_POST['jenis']
				);	
			}
			else{
				$objects = array(
					"judul" => $library->getPost('judul'),
					"url" => $library->getPost('url'),
					"deskripsi_banner" => $library->getPost('deskripsi_banner'),
					"tgl_posting" => date('Y-m-d'),
                	"jenis" => $_POST['jenis']
				);
			}
        
       		//print_r($objects);
			
			$update = $db->update('banner', $objects, array('id_banner',$_POST['id']));
			if($update){	
				$library->message = "Berhasil memperbaharui data";
				$library->alert_class = "alert-success";
			}else{
				$library->message = "Gagal memperbaharui data";
				$library->alert_class = "alert-warning";
			}
		}
		else{
			$library->message = "Data tidak boleh kosong";
			$library->alert_class = "alert-warning";
		}
			
	}

	$id = isset($_GET['id']) ? $db->esc_str($_GET['id']) : false;
	$data = $db->query("SELECT * FROM banner WHERE id_banner='{$id}'")->fetch_assoc();
	$judul = $data['judul'];
	$url = $data['url'];
	$deskripsi_banner = $data['deskripsi_banner'];
	$gambar = $data['gambar'];
	$jenis = $data['jenis'];
	?>
	
	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Edit Banner</h3> 

	</div>

	<div class="module-body">
		<form action="" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $id; ?>">
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label for="">Judul</label>
						<input type="text" name="judul" class="form-control" value="<?php echo $judul; ?>">
					</div>	

					<div class="form-group">
						<label>Jenis</label>
						<select class="form-control" name="jenis" >
							<option value="gambar" <?php if($jenis == "gambar"){ echo "selected"; } ?>>Gambar</option>
							<option value="video"  <?php if($jenis == "video"){ echo "selected"; } ?>>Video</option>
						</select>
					</div>		

					<div class="form-group">
						<label for="">URL</label>
						<input type="text" name="url" class="form-control" value="<?php echo $url ?>">
					</div>

					<div class="form-group">
						<label for="">Deskripsi</label>
						<textarea name="deskripsi_banner" id="" cols="30" rows="10" class="form-control"><?php echo $deskripsi_banner; ?></textarea>
					</div>	
				</div>
				<div class="col-md-4">
					<div id="terbitkan">
						<div class="widget">
							<div class="widget-header">
								<span class="widget-title">Simpan</span>
							</div>
							<div class="widget-body">
								<div class="form-group">
									<label for="">Tanggal di Posting</label>
									<input type="text" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>
								</div>
							</div>
							<div class="widget-footer">
								<div class="widget-action pull-right">
									<button type="submit" name="update" class="btn-add btn-sm">Update</button>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>

					<div id="foto-profile">
						<div class="widget">
							<div class="widget-header">
								<span class="widget-title">Profile</span>
							</div>
							<div class="widget-body">
								<input type="hidden" name="user_img">
								<input type="file" name="imgInput" class="imgInput" style="visibility: hidden;max-height: 0">
								<a href="" id="profilTrigger">
									<?php if(!empty(trim($gambar))){ ?>
										<img src="<?php echo $gambar; ?>" alt="" width="100%">
									<?php }else{ ?>
										Pilih Gambar
									<?php } ?>
								</a>
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

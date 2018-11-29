<?php 

function page_data(){
	global $db;
	global $library;

	if(isset($_POST['delete'])){
		$delete = $db->delete("berita", array('id_berita', $_POST['id']));
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


	$query_str = "SELECT * FROM berita";
	$data = $db->get_results($query_str);
	
	?>
	
	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Data Post
			<a href="?module=add_page" class="btn-add">Tambah Data</a>
		</h3> 

	</div>
	
	<div class="module-body">
		<table class="table table-bordered" id="table-users">
			<thead>
				<tr>
					<th>ID</th>
					<th>Judul</th>
					<th>Tanggal di Post</th>
					<th>Pemirsa</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data as $d): ?>
					<tr>
						<td><?php echo $d['id_berita']; ?></td>
						<td><?php echo $d['berita_title']; ?></td>
						<td><?php echo $d['berita_tanggal']; ?></td>
						<td><?php echo $d['berita_view']; ?></td>
						<td>
							<a class="btn btn-warning btn-small" href="?module=edit_post&id=<?php echo $d['id_berita']; ?>"><span class="fa fa-pencil"></span></a>
							<form action="<?php echo ADMIN_URL . 'dashboard.php'; ?>?module=post_data" method="POST" style="display: inline-block;">
								<input type="hidden" name="id" value="<?php echo $d['id_berita']; ?>">
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

function add_page(){
	global $db;
	global $library;
	global $uploads;

	$library->add_rule('berita_title', 'Judul', array('require'));
	$library->add_rule('berita_content', 'Isi Berita', array('require'));
	$library->add_rule('id_kategori','Kategori', array('require'));
	$library->add_rule('berita_status', 'Publish', array(''));

	if(isset($_POST['tambah'])){
		if($library->run()){
			$imgInput = $library->getFile('imgInput');
			$move = $uploads->upload_file($_FILES['imgInput']);
			
			$id_kategori = $library->getPost('id_kategori');
			$id_author = isset($_SESSION['username']) ? $_SESSION['username'] : "";
			$berita_title = $library->getPost('berita_title');
			$title_slug = slug($berita_title);
			$berita_content = addslashes($library->getPost('berita_content'));
			$berita_tanggal = tanggal();
			$berita_view = 0;
			$berita_status = $library->getPost('berita_status');

			if($move){
				$objects = array(
					'id_kategori'	=> $id_kategori,
					'id_author'		=> $id_author,
					'berita_title' 	=> $berita_title,
					'title_slug'	=> $title_slug,
					'berita_content'=> $berita_content,
					'berita_ntanggal'=> date('y-m-d'),
					'berita_tanggal'=> $berita_tanggal,
					'berita_img'	=> $uploads->upload_data('path'),
					'berita_view'	=> $berita_view,
					'berita_status'	=> $berita_status,
				);
			}
			else{
				$objects = array(
					'id_kategori'	=> $id_kategori,
					'id_author'		=> $id_author,
					'berita_title' 	=> $berita_title,
					'title_slug'	=> $title_slug,
					'berita_content'=> $berita_content,
					'berita_ntanggal'=> date('y-m-d'),
					'berita_tanggal'=> $berita_tanggal,
					'berita_view'	=> $berita_view,
					'berita_status'	=> $berita_status,
				);
			}

			$save = $db->save("berita", $objects);
			if($save){
				$tryto = $uploads->upload_file($_FILES['imgInput']);
				if($tryto){
					$library->message = "Berhasil menambahkan data";
					$library->alert_class = "alert-success";
				}
				else{
					$library->message = "Berhasil menambahkan data";
					$library->alert_class = "alert-success";	
				}
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
		<h3 class="module-title">Tambah Post</h3> 

	</div>

	<div class="module-body">
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label for="">Judul</label>
						<input type="text" name="berita_title" class="form-control" value="<?php echo $library->form_value('berita_title'); ?>">
					</div>	

					<div class="form-group">
						<label for="">Isi berita</label>
						<textarea name="berita_content" id="beritaContent" cols="30" rows="10" class="form-control"><?php echo $library->form_value('berita_content'); ?></textarea>
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
									<label for="">Aktif</label>
									<select name="berita_status" id="" class="form-control">
										<option value="Y">Y</option>
										<option value="N">N</option>
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

					<div id="foto-profile">
						<div class="widget">
							<div class="widget-header">
								<span class="widget-title">Gambar</span>
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
            external_plugins : { 'filemanager' : "<?php echo ASSETS_URL . 'tinymce/plugins/responsivefilemanager/filemanager/plugin.min.js'; ?>" },
			relative_urls : false,
            document_base_url: '<?php echo BASE_URL . '/gz-content/uploads/'; ?>',
          });
    </script>
	<?php 
}

function edit_page(){
	global $uploads;
	global $db;
	global $library;

	$library->add_rule('berita_title', 'Judul', array('require'));
	$library->add_rule('berita_content', 'Isi Berita', array('require'));
	$library->add_rule('id_kategori','Kategori', array('require'));
	$library->add_rule('berita_status', 'Publish', array(''));

	if(isset($_POST['update'])){
		if($library->run()){
			$imgInput = $library->getFile('imgInput');
			$move = $uploads->upload_file($_FILES['imgInput']);
			
	        $id_kategori = $library->getPost('id_kategori');
			$berita_title = $library->getPost('berita_title');
			$title_slug = slug($berita_title);
			$berita_content = addslashes($library->getPost('berita_content'));
			$berita_status = $library->getPost('berita_status');


			if($move){
				$objects = array(
					'id_kategori'	=> $id_kategori,
					'berita_title' 	=> $berita_title,
					'title_slug'	=> $title_slug,
					'berita_content'=> $berita_content,
					'berita_img'	=> $uploads->upload_data('path'),
					'berita_status'	=> $berita_status,
				);
			}
			else{
				$objects = array(
					'id_kategori'	=> $id_kategori,
					'berita_title' 	=> $berita_title,
					'title_slug'	=> $title_slug,
					'berita_content'=> $berita_content,
					'berita_status'	=> $berita_status,
				);
			}

			$update = $db->update('berita', $objects, array('id_berita',$_POST['id']));
			if($update){
				$library->message = "Berhasil memperbaharui data";
				$library->alert_class = "alert-success";
			}
			else{
				$library->message = "Gagal memperbaharui data";
				$library->alert_class = "alert-warning";
			}

		}
		
	}

	$id = isset($_GET['id']) ? $db->esc_str($_GET['id']) : false;
	$data = $db->query("SELECT * FROM berita WHERE id_berita='{$id}'")->fetch_assoc();

	$berita_title = $data['berita_title'];
	$berita_content = $data['berita_content'];
	$berita_status = $data['berita_status'];	
	$id_kategori = $data['id_kategori'];
	$berita_img = $data['berita_img'];

	?>
	
	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Edit Post</h3> 

	</div>

	<div class="module-body">
		<form action="" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $id; ?>">
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label for="">Judul</label>
						<input type="text" name="berita_title" class="form-control" value="<?php echo stripslashes($berita_title); ?>">
					</div>	

					<div class="form-group">
						<label for="">Isi berita</label>
						<textarea name="berita_content" id="beritaContent" cols="30" rows="10" class="form-control"><?php echo stripslashes($berita_content); ?></textarea>
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
									<label for="">Aktif</label>
									<select name="berita_status" id="" class="form-control">
										<option value="Y" <?php if($berita_status == "Y"){ echo "selected"; } ?>>Y</option>
										<option value="N" <?php if($berita_status == "N"){ echo "selected"; } ?>>N</option>
									</select>
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
								<span class="widget-title">Gambar</span>
							</div>
							<div class="widget-body">
								<input type="hidden" name="user_img">
								<input type="file" name="imgInput" class="imgInput" style="visibility: hidden;max-height: 0">
								<a href="" id="profilTrigger">

									<?php 
										if(!empty($berita_img)){
											echo "<img class='img-responsive' src='{$berita_img}'>";
										}
										else{
											echo "Pilih Gambar";
										}
									?>
									
								</a>
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
            external_plugins : { 'filemanager' : "<?php echo ASSETS_URL . 'tinymce/plugins/responsivefilemanager/filemanager/plugin.min.js'; ?>" },
			relative_urls : false,
            document_base_url: '<?php echo BASE_URL . '/gz-content/uploads/'; ?>',
          });
    </script>
	
	<?php } 

	

<?php 

function widget_data(){
	global $library;
	global $db;
	if(isset($_POST['add_widget'])){
		$library->add_rule('nama_widget', 'Nama Widget', array('require'));
		if($library->run()){
				$objects = array(
					'nama_widget' => $library->getPost('nama_widget'),
					'tipe_widget' => $library->getPost('tipe_widget'),
					'widget_area' => 'sidebar',
				);
				$save = $db->save("widget", $objects);
				if($save){
					$library->message = "Berhasil menambah widget";
					$library->alert_class = "alert-success";
				}else{
					$library->message = "Gagal menambahkan widget";
					$library->alert_class = "alert-warning";
				}
			}
			else{
				$library->message = "Data tidak boleh kosong";
				$library->alert_class = "alert-warning";
			}
	}

	if(isset($_POST['delete'])){
		$delete = $db->delete("widget", array('id_widget="' . $_POST['id'] . '"'));
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
	$data_kategori = $db->get_results($query_str);

	$query_galeri = "SELECT * FROM album";
	$data_album = $db->get_results($query_galeri);

	?>

	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Widget
			<!-- <a href="?module=add_kategori" class="btn-add">Tambah Data</a> -->
		</h3> 
	</div>
	
	<div class="module-body">
		<?php 
			$mainwidget_query = "SELECT * FROM widget WHERE widget_area='main'";
			$datamainwidget = $db->get_results($mainwidget_query);
			//print_r($datamainwidget);
		 ?>
		<div class="widget-wrapper" id="widget-wrapper">
			<div class="row">
				<div class="col-md-8">
					<div class="widget-element">
						<h3 class="widget-title">Main Content</h3>
					</div>
					
					<div class="widget-element">
						<div class="form-group">
							<label for="">Slider</label>
							<input type="text" value="Slider" value="" readonly="" class="form-control">
						</div>
					</div>	
					<div class="widget-element">
						<div class="form-group">
							<label for="">Berita Terbaru</label>
							<input type="text" value="Berita Terbaru" value="" readonly="" class="form-control">
						</div>
					</div>		

					<div class="row">
						<div class="col-md-6">
							<div class="widget-element">
								<form action="<?php echo BASE_URL . 'gz-admin/ajax/widget.ajax.php'; ?>" method="POST">
									<div class="form-group">
										<input type="hidden" name="id_widget" value="<?php echo $datamainwidget[0]['id_widget']; ?>">
										<label class=""><?php echo $datamainwidget[0]['nama_widget']; ?></label>
										<select name="id_kategori" id="" class="form-control on-change">
                                        	<option value=''>Pilih</option>
											<?php foreach ($data_kategori as $data_cat) { ?>
												<option value="<?php echo $data_cat['id_kategori'] ?>" <?php if($datamainwidget[0]['id_kategori'] == $data_cat['id_kategori']){ echo "selected"; } ?>><?php echo $data_cat['nama_kategori']; ?></option>
											<?php } ?>
											
										</select>	
									</div>
								</form>
							</div>	
						</div>
						<div class="col-md-6">
							<div class="widget-element">
								<form action="<?php echo BASE_URL . 'gz-admin/ajax/widget.ajax.php'; ?>" method="POST">
									<div class="form-group">
										<input type="hidden" name="id_widget" value="<?php echo $datamainwidget[1]['id_widget']; ?>">
										<label class=""><?php echo $datamainwidget[1]['nama_widget']; ?></label>
										<select name="id_kategori" id="" class="form-control on-change">
                                        	<option value=''>Pilih</option>
											<?php foreach ($data_kategori as $data_cat) { ?>
												<option value="<?php echo $data_cat['id_kategori'] ?>" <?php if($datamainwidget[1]['id_kategori'] == $data_cat['id_kategori']){ echo "selected"; } ?>><?php echo $data_cat['nama_kategori']; ?></option>
											<?php } ?>
											
										</select>	
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="widget-element">
								<form action="<?php echo BASE_URL . 'gz-admin/ajax/widget.ajax.php'; ?>" method="POST">
									<div class="form-group">
										<input type="hidden" name="id_widget" value="<?php echo $datamainwidget[2]['id_widget']; ?>">
										<label class=""><?php echo $datamainwidget[2]['nama_widget']; ?></label>
										<select name="id_kategori" id="" class="form-control on-change">
                                        	<option value=''>Pilih</option>
											<?php foreach ($data_kategori as $data_cat) { ?>
												<option value="<?php echo $data_cat['id_kategori'] ?>" <?php if($datamainwidget[2]['id_kategori'] == $data_cat['id_kategori']){ echo "selected"; } ?>><?php echo $data_cat['nama_kategori']; ?></option>
											<?php } ?>
											
										</select>	
									</div>
								</form>
							</div>		
						</div>
						<div class="col-md-6">
							<div class="widget-element">
								<form action="<?php echo BASE_URL . 'gz-admin/ajax/widget.ajax.php'; ?>" method="POST">
									<div class="form-group">
										<input type="hidden" name="id_widget" value="<?php echo $datamainwidget[3]['id_widget']; ?>">
										<label class=""><?php echo $datamainwidget[3]['nama_widget']; ?></label>
										<select name="id_kategori" id="" class="form-control on-change">
											<?php foreach ($data_kategori as $data_cat) { ?>
												<option value="<?php echo $data_cat['id_kategori'] ?>" <?php if($datamainwidget[3]['id_kategori'] == $data_cat['id_kategori']){ echo "selected"; } ?>><?php echo $data_cat['nama_kategori']; ?></option>
											<?php } ?>
											
										</select>	
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="widget-element">
						<div class="form-group">
							<form action="<?php echo BASE_URL . 'gz-admin/ajax/widget.ajax.php'; ?>" method="POST">
							<div class="form-group">
								<input type="hidden" name="id_widget" value="<?php echo $datamainwidget[4]['id_widget']; ?>">
								<label class="">Galeri</label>
								<select name="id_album" id="" class="form-control on-change">
                                	<option value=''>Pilih</option>
									<?php foreach ($data_album as $data_al) { ?>
										<option value="<?php echo $data_al['id_album'] ?>" <?php if($datamainwidget[4]['id_album'] == $data_al['id_album']){ echo "selected"; } ?>><?php echo $data_al['jdl_album']; ?></option>
									<?php } ?>
									
								</select>	
							</div>
						</form>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="widget-element">
						<div class="pull-left">
							<h3 class="widget-title" style="margin-top: 5px;">Sidebar</h3>
						</div>
						<div class="pull-right">
							<button id="add-widget" class="btn btn-default"><i class="fa fa-bars"></i></button>
						</div>
						<div class="clearfix"></div>
					</div>

					<div class="add-widget">
						
						<div class="add-widget-form">
							<form action="" method="POST" >
								<div class="form-group">
									<label>Nama Widget</label>
									<input type="text" name="nama_widget" class="form-control">
								</div>

								<div class="form-group">
									<label>Tipe Widget</label>
									<select name="tipe_widget" class="form-control">
										<option value="">Pilih</option>
										<option value="populer">Populer</option>
										<option value="terbaru">Terbaru</option>
										<option value="menu">Menu</option>
										<<!-- option option="galeri">Galeri</option> -->
										<option option="kategori">Kategori</option>
										<option option="banner">Banner</option>
										<option option="text">Text</option>
									</select>
								</div>
								<button type="submit" name="add_widget" class="btn-add btn-sm">Tambah</button>
							</form>
						</div>
					</div>

					<?php 
						$query_str = "SELECT * FROM widget WHERE widget_area='sidebar'";
						$dataWidget =  $db->get_results($query_str);
						//print_r($dataWidget);
						if(count($dataWidget) > 0){
							for($i = 0; $i < count($dataWidget); $i++){
								$widget_content_id = "";
								if($dataWidget[$i]['tipe_widget'] == "kategori"){
									$widget_content_id = $dataWidget[$i]['id_kategori'];
								}elseif($dataWidget[$i]['tipe_widget'] == "menu"){
									$widget_content_id = $dataWidget[$i]['id_area'];
								}elseif($dataWidget[$i]['tipe_widget'] == "banner"){
									$widget_content_id = $dataWidget[$i]['id_banner'];
								}elseif($dataWidget[$i]['tipe_widget'] == "galeri"){
									$widget_content_id = $dataWidget[$i]['id_album'];
								}elseif($dataWidget[$i]['tipe_widget'] == "text"){
									$widget_content_id = $dataWidget[$i]['id_widget'];
								}else{
									$widget_content_id = "";
								}
					?>

							<div class="widget-element">
								<div>
									<div class="pull-right">
										<form action="" method="POST">
											<input type="hidden" name="delete">
											<input type="hidden" name="id" value="<?php echo $dataWidget[$i]['id_widget']; ?>">
											<button type="submit" class="btn btn-sm " style="background: transparent;padding: 0;"><i class="fa fa-trash"></i></button>
										</form>
									</div>
								</div>
								<form action="<?php echo BASE_URL . 'gz-admin/ajax/widget.ajax.php'; ?>" method="POST" id="form-widget">
									<div class="form-group">
										<input type="hidden" name="id_widget" value="<?php echo $dataWidget[$i]['id_widget']; ?>">
										<label class="widget-title"><?php echo $dataWidget[$i]['nama_widget']; ?></label>
										<?php setFormWidget($dataWidget[$i]['tipe_widget'], $widget_content_id); ?>
									</div>
								</form>
							</div>

						<?php } ?>
					<?php } ?>

				</div>
			</div>
			
		</div>
	</div>

	<div class="toast" id="toast">Berhasil menyimpan perubahan</div>

	<?php 
}

<?php 

function menu_data(){
	global $db;
	global $library;

	if(isset($_POST['delete'])){
		$delete = $db->delete("mainmenu", array('id_main', $_POST['id']));
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

	$query_str = "SELECT * FROM mainmenu";
	$data_menu = $db->get_results($query_str);
	//echo count($data);
	//var_dump($data);
	?>

	<div class="module-header">
		<?php $library->alert(); ?>
		<div class="row">
			<div class="col-md-8">
				<h3 class="module-title">Data Menu
					<a href="?module=add_menu" class="btn-add">Tambah Data</a>
				</h3>	
			</div>
			<div class="col-md-4">
				<form action="" class="" role="form" style="margin-bottom: 40px">	
					
					<div class="form-group">
						<!-- <label class="" for="">Atur Menu</label> 
						<input type="hidden" name="module" value="get_menu">
						<select name="id" id="" class="form-control" onchange="this.form.submit()">
							<option value="">Atur Menu</option>
							<?php 
								$query = $db->query("SELECT * FROM menuarea");
								while ($data = $query->fetch_array()) {
							?>
								<option value="<?php echo $data['id_area'] ?>"><?php echo $data['nama_area']; ?></option>
							<?php } ?>
						</select>-->
					</div>
				</form>
			</div>
		</div>
		 
	</div>

	<div class="module-body">
		
			

		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered" id="table-menu">
					<thead>
						<tr>
							<th>ID</th>
							<th>Parent</th>
							<th>Tipe</th>
							<th>Berita</th>
							<th>Kategori</th>
							<th>Nama</th>
							<th>Aktif</th>
							<th>Position</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($data_menu as $d): ?>
							<tr>
								<td><?php echo $d['id_main']; ?></td>
								<td><?php echo $d['id_parent']; ?></td>
								<td><?php echo $d['type']; ?></td>
								<td><?php echo $d['id_berita']; ?></td>
								<td><?php echo $d['id_kategori']; ?></td>
								<td><?php echo $d['nama_menu']; ?></td>
								<td><?php echo $d['aktif']; ?></td>
								<td><?php echo $d['position']; ?></td>
								<td>
									<a class="btn btn-warning btn-small" href="?module=edit_menu&id=<?php echo $d['id_main']; ?>"><span class="fa fa-pencil"></span></a>
									<form action="<?php echo ADMIN_URL . 'dashboard.php'; ?>?module=menu_data" method="POST" style="display: inline-block;">
										<input type="hidden" name="id" value="<?php echo $d['id_main']; ?>">
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
		</div>
	</div>

	<?php 
}

function add_menu(){
	global $db, $library;

	// position
	$position = $db->query("SELECT MAX(position) as posisi FROM mainmenu")->fetch_assoc();
	
	// id area
	$id_area = isset($_GET['menuarea']) ? $_GET['menuarea'] : false;
	
	// query mm;
	$mm_query_str = "SELECT id_main, id_parent, nama_menu, id_kategori, id_halaman, id_berita, link, position, type, area FROM mainmenu WHERE area='$id_area' AND id_parent='0' ORDER BY position ASC";
	$mm_query = $db->query($mm_query_str);

	$parents = $mm_query->fetch_all(MYSQLI_ASSOC);
	$mm_query = $db->query($mm_query_str);
	?>

	
	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Tambah menu</h3>
		<form action="" method="get">
			<input type="hidden" name="module" value="add_menu">
			Select Menu	
			<select name="menuarea" class="menuarea">
				<option value="">Pilih</option>
				<?php 
					$query_str = "SELECT id_area, nama_area FROM menuarea";
					$query = $db->query($query_str);
					while( $menuarea = $query->fetch_assoc()) { ?>
						<option 
							value="<?php echo $menuarea['id_area']; ?>"
							<?php if($id_area == $menuarea['id_area']){ echo 'selected'; } ?>>
							<?php echo $menuarea['nama_area'] ?>
						</option>
				<?php } ?>
			</select>
			<button class="btn btn-sm">Pilih Menu</button>
		</form>
	</div>
	
	<div class="module-body">
		<input type="hidden" name="position" value="<?php echo $position['posisi']+1; ?>">
		<div class="row">
			<div class="col-md-4">
				<form 
					action="<?php echo BASE_URL . 'gz-admin/ajax/add-menu.php'; ?>" 
					method="post" 
					id="form-page">
					
					<div class="panel panel-default">
						<div class="panel-heading">
							Halaman
						</div>
						<div class="panel-body" id="toggle-page">
							<input type="hidden" name="menuarea" value="<?php echo $id_area; ?>">
							<input type="hidden" name="type" value="page">
							<input type="hidden" name="true_submit">
							<?php 
								$hal_query_str = "SELECT id_halaman, judul, slug FROM halaman WHERE publish='Y' ORDER BY id_halaman DESC LIMIT 5 ";
								$hal_query = $db->query( $hal_query_str );
								while( $hal = $hal_query->fetch_assoc()) {
							?>
								<div>
									
									<input 
										type="checkbox" 
										name="id[]" 
										value="<?php echo $hal['id_halaman']; ?>"
										id="label-<?php echo $hal['id_halaman']; ?>">
									<label for="label-<?php echo $hal['id_halaman']; ?>">
										<span  style="margin-left:5px;">
											<?php echo $hal['judul']; ?>
										</span>
									</label>
								</div>
							<?php } ?>
							<div class="text-center">
								<br>
								<button 
									data-page = "2"
									data-item = "halaman"
									data-order = "DESC"
									data-orderby = "id_halaman"
									class="btn btn-sm btn-default btn-block btn-load-page">Load</button>
							</div>
						</div>
						<div class="panel-footer">
							<button id="submit-form-page" class="btn btn-sm btn-primary pull-right">Tambah</button>
							<div class="clearfix"></div>
						</div>

					</div>
				</form>

				<form 
					action="<?php echo BASE_URL . 'gz-admin/ajax/add-menu.php'; ?>" 
					method="post" 
					id="form-kategori">
					
					<div class="panel panel-default">
						<div class="panel-heading">
							Kategori
						</div>
						<div class="panel-body" id="toggle-kategori">
							<input type="hidden" name="menuarea" value="<?php echo $id_area; ?>">
							<input type="hidden" name="type" value="kategori">
							<input type="hidden" name="true_submit">
							<?php 
								$query_str = "SELECT id_kategori, nama_kategori, slug_kategori FROM kategori ORDER BY id_kategori DESC LIMIT 5 ";
								$query = $db->query( $query_str );
								while( $d = $query->fetch_assoc()) {
							?>
								<div>
									
									<input 
										type="checkbox" 
										name="id[]" 
										value="<?php echo $d['id_kategori']; ?>"
										id="label-kategori-<?php echo $d['id_kategori']; ?>">
									<label for="label-kategori-<?php echo $d['id_kategori']; ?>">
										<span  style="margin-left:5px;">
											<?php echo substr($d['nama_kategori'], 0, 25); ?>
										</span>
									</label>
								</div>
							<?php } ?>
							<div class="text-center">
								<br>
								<button 
									data-page = "2"
									data-item = "kategori"
									data-order = "DESC"
									data-orderby = "id_kategori"
									class="btn btn-sm btn-default btn-block btn-load-kategori">Load</button>
							</div>
						</div>
						<div class="panel-footer">
							<button id="submit-form-kategori" class="btn btn-sm btn-primary pull-right">Tambah</button>
							<div class="clearfix"></div>
						</div>

					</div>
				</form>
			</div>
			<div class="col-md-4">
				<form 
					action="<?php echo BASE_URL . '/gz-admin/ajax/save-menu.php'; ?>" 
					method="POST" 
					id="form-menu">
					<input type="hidden" name="true_submit">
					<div class="panel panel-default">
						<div class="panel-heading" style="vertical-align: middle;">
							Simpan Menu
							<button 
								name="simpan" 
								class="btn btn-sm btn-primary pull-right"
								id="simpan-menu">Simpan</button>
							<div class="clearfix"></div>
						</div>

					</div>
					<?php while( $mm = $mm_query->fetch_assoc()) { ?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<a href="#panel<?php echo $mm['id_main'] ?>" data-toggle="collapse">
									<?php echo $mm['nama_menu']; ?>
								</a>
							</div>
							<div id="panel<?php echo $mm['id_main']; ?>" class="panel-body collapse">
								<!-- <form action="" id="form-panel-<?php echo $mm['id_main'] ?>">  -->
									<input type="hidden" name="id_main[]" value="<?php echo $mm['id_main'] ?>">
									<div class="form-group">
										<label for="">Nama Menu</label>
										<input type="text" name="nama_menu[]" class="form-control" value="<?php echo $mm['nama_menu']; ?>">
									</div>
									<div class="form-group">
										<label for="">Link</label>
										<input type="text" name="link[]" class="form-control" value="<?php echo $mm['link']; ?>">
									</div>
									<div class="form-group">
										<label for="">Parent</label>
										<select name="id_parent[]" class="form-control">
											<option value="0">Pilih</option>
											<?php foreach ($parents as $parent) { ?>
												<option 
													value="<?php echo $parent['id_main']; ?>"
													<?php if($mm['id_parent'] == $parent['id_main']){ echo 'selected'; } ?>><?php echo $parent['nama_menu'] ?></option>
											<?php } ?>
										</select>
									</div>
									<div>
										<button class="btn btn-sm btn-primary" onclick="saveCurrentMenu(<?php echo $mm['id_main']; ?>)">
											<span class="fa fa-save"></span>
										</button> 
										<button class="btn btn-sm btn-danger" onclick="delete CurrentMenu(<?php echo $mm['id_main'] ?>)">
											<span class="fa fa-trash"></span>
										</button>
									</div>
								<!-- </form> -->
							</div>
						</div>
						<?php
						
						$sm_query_str = "SELECT * FROM mainmenu WHERE area='$id_area' AND id_parent='" . $mm['id_main'] . "' ORDER BY position ASC";
						$sm_query = $db->query($sm_query_str);

						while( $sm = $sm_query->fetch_assoc() ) { ?>
							<div class="panel panel-default" style="margin-left: 40px;">
								<div class="panel-heading">
									<a href="#panel<?php echo $sm['id_main'] ?>" data-toggle="collapse">
										<?php echo $sm['nama_menu']; ?>
									</a>
								</div>
								<div id="panel<?php echo $sm['id_main']; ?>" class="panel-body collapse">
									<!-- <form action="" id="form-panel-<?php echo $sm['id_main'] ?>">  -->
										<input type="hidden" name="id_main[]" value="<?php echo $sm['id_main'] ?>">
										
										<div class="form-group">
											<label for="">Nama Menu</label>
											<input type="text" name="nama_menu[]" class="form-control" value="<?php echo $sm['nama_menu']; ?>">
										</div>
										<div class="form-group">
											<label for="">Link</label>
											<input type="text" name="link[]" class="form-control" value="<?php echo $sm['link']; ?>">
										</div>
										<div class="form-group">
											<label for="">Parent</label>
											<select name="id_parent[]" class="form-control">
												<option value="0">Pilih</option>
												<?php foreach ($parents as $parent) { ?>
													<option 
														value="<?php echo $parent['id_main']; ?>"
														<?php if($sm['id_parent'] == $parent['id_main']){ echo 'selected'; } ?>><?php echo $parent['nama_menu'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div>
											<button class="btn btn-sm btn-primary" onclick="saveCurrentMenu(<?php echo $sm['id_main']; ?>)">
												<span class="fa fa-save"></span>
											</button> 
											<button class="btn btn-sm btn-danger" onclick="delete CurrentMenu(<?php echo $sm['id_main'] ?>)">
												<span class="fa fa-trash"></span>
											</button>
										</div>
									<!-- </form> -->
								</div>
							</div>
						<?php } ?>

					<?php } ?>
				</form>
			</div>
			
		</div>
	</div>


	<?php 
}

function edit_menu(){
	global $db, $library;
	
	$id = isset($_GET['id']) ? $_GET['id'] : false;
	$objects = array();

	$library->add_rule('nama_menu', 'Nama Menu', array('require'));
	$library->add_rule('level', 'level', array('require'));
	
	if($library->getPost('level') == "submenu"){
		$library->add_rule('id_parent', 'Parent Menu', array('require'));
	}

	$library->add_rule('type', 'Tipe Menu', array('require'));
	if($library->getPost('type') == "single"){
		$library->add_rule('id_berita', 'Artikel', array('require'));
	}elseif($library->getPost('type') == "category"){
		$library->add_rule('id_kategori', 'Kategori', array('require'));
	}elseif($library->getPost('type') == "custom"){
		$library->add_rule('url', 'URL', array('require'));
	}

	if(isset($_POST['update'])){
		if($library->run()){

			$id_berita = $library->getPost('id_berita');
			$id_kategori = $library->getPost('id_kategori');
			$nama_menu = $library->getPost('nama_menu');
			$link = $library->getPost('link');
			$type = $library->getPost('type');
			$position = $library->getPost('position');
			$id_area = $library->getPost('id_area');
			$level = $library->getPost('level');
			$custom = $library->getPost('url');

			$id_parent = $library->getPost('id_parent');

			//echo $id_parent;

			if($type == "single"){
				$query_str = "SELECT * FROM berita WHERE id_berita='{$id_berita}' LIMIT 1";
				$d = $db->get_results($query_str);
				$link = $type . "/" . $d[0]['title_slug'];
			}
			elseif($type == "category"){
				$query_str = "SELECT * FROM kategori WHERE id_kategori='{$id_kategori}' LIMIT 1";
				$d = $db->get_results($query_str);
				$link = $type . "/" . $d[0]['slug_kategori'];
			}
			elseif($type == "archived"){
				$link = $type;
			}
			elseif($type == "custom"){
				$link = $custom;
			}


			$objects = array(	
				'id_berita' => $id_berita,
				'id_kategori' => $id_kategori,
				'nama_menu' => $nama_menu,
				'link'	=> $link,
				'type' => $type,
				'area'	=> $id_area,
				'aktif' => 'Y',
				'id_parent' => $id_parent
			);

			$save = $db->update("mainmenu", $objects,  array('id_main', $_POST['id']));
			if($save){

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
	$data = $db->query("SELECT * FROM mainmenu WHERE id_main='{$id}'")->fetch_assoc();

	$nama_menu = $data['nama_menu'];
	$id_parent = $data['id_parent'];
	$type = $data['type'];
	$id_berita = $data['id_berita'];
	$id_kategori = $data['id_kategori'];
	$area = $data['area'];
	$link = $data['link'];
	?>

	
	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Edit menu</h3>
	</div>
	<div class="module-body">
		<form action="" method="POST">
			<input type="hidden" name="id" value="<?php echo $id; ?>">
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label for="">Nama Menu</label>
						<input type="text" class="form-control" name="nama_menu" value="<?php echo $nama_menu; ?>">
					</div>

					<div class="form-group">
						<label for="">Level</label>
						<select name="level" id="menu-level" class="form-control">
							<option value="mainmenu" <?php if($id_parent == ""){ echo "selected"; } ?>>Main Menu</option>
							<option value="submenu" <?php if($id_parent != ""){ echo "selected"; } ?>>submenu</option>
						</select>
					</div>

					<div id="pilih-parent">
						<div class="form-group">
							<label for="">Menu</label>
							<select name="id_parent" id="id_parent" class="form-control">
								<option value="">Pilih</option>
								<?php 
									$query_str = "SELECT * FROM mainmenu ORDER by id_main DESC ";
									$data = $db->get_results($query_str);
									foreach ($data as $d) {		
								?>
									<option value="<?php echo $d['id_main'] ?>" <?php if($d['id_main'] == $id_parent){ echo "selected"; } ?>><?php echo $d['nama_menu']; ?></option>
								
								<?php }	?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="">Tipe</label>
						<select name="type" id="menu-type" class="form-control">
							<option value="">Pilih</option>
							<option value="single" <?php if($type == "single"){ echo "selected"; } ?>>Single Page</option>
							<option value="category" <?php if($type == "category"){ echo "selected"; } ?>>Kategori</option>
                        	<option value="custom" <?php if($type == "custom"){ echo "selected"; } ?>>Custom</option>
							<!-- <option value="archived">Archived</option>+ -->
						</select>
					</div>
					
					<div id="single">
						<div class="form-group">
							<label for="">Pilih Artikel</label>
							<select name="id_berita" id="id_berita" class="form-control">
								<option value="">Pilih</option>
								<?php 
									$query_str = "SELECT * FROM berita WHERE berita_status='Y' ORDER by id_berita DESC";
									$data = $db->get_results($query_str);
									foreach ($data as $d) {
								?>
									<option value="<?php echo $d['id_berita'] ?>" <?php if($d['id_berita'] == $id_berita){ echo "selected"; } ?>><?php echo $d['berita_title']; ?></option>
								<?php }	?>
							</select>
						</div>
					</div>

					<div id="category">
						<div class="form-group">
							<label for="">Pilih Kategori</label>
							<select name="id_kategori" id="id_kategori" class="form-control">
								<option value="">Pilih</option>
								<option value="all">Semua Kategori</option>
								<?php 
									$query_str = "SELECT * FROM kategori WHERE aktif='Y' ORDER by id_kategori DESC";
									$data = $db->get_results($query_str);
									foreach ($data as $d) {
								?>
									<option value="<?php echo $d['id_kategori'] ?>" <?php if($d['id_kategori'] == $id_kategori){ echo "selected"; } ?>><?php echo $d['nama_kategori']; ?></option>
								<?php }	?>
							</select>
						</div>
					</div>

					<div id="custom">
						<div class="form-group">
							<label for="">Masukan URL</label>
							<input type="text" name="url" value="<?php echo $link; ?>" class="form-control" id="input-url">
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="">
						<div class="widget">
							<div class="widget-header">
								<span class="widget-title">Area</span>
							</div>
							<div class="widget-body">
								<div class="form-group">
									<label for=""></label>
									<select name="id_area" id="" class="form-control">
										<?php 
											$query_str = "SELECT * FROM menuarea";
											$query = $db->query($query_str);
											while($data = $query->fetch_array()){
										?>
											<option value="<?php echo $data['id_area']; ?>" <?php if($data['id_area'] == $area){ echo "selected"; } ?>><?php echo $data['nama_area']; ?></option>
										<?php } ?>
										
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
			</div>
		</form>
	</div>


	<?php 
}

function get_menu(){
	global $library, $db;
	?>
	<div class="module-header">
		<div id="module-message"></div>
		<h3 class="module-title">Data Menu</h3> 
	</div>
	<div class="module-body">
		<div class="row">
			<div class="col-md-4">
				<ul class="menu-wrapper">
				<?php 
					
					$id = isset($_GET['id']) ? abs($_GET['id']) : false;
					
					$select = "";
					$query_str = "SELECT * FROM mainmenu WHERE area='{$id}' ORDER BY position ASC";
					
					$position = $db->query($query_str);
					while($p = $position->fetch_array()){
						$select .="<option value='{$p['position']}'>{$p['nama_menu']}</option>";
					}

					$query_str = "SELECT * FROM mainmenu WHERE area='{$id}' ORDER BY position ASC";
					$query = $db->query($query_str);
					while ($data = $query->fetch_array()) {
				?>	
					<li class="menu" id="<?php echo $data['position']; ?>">
						<form action="<?php echo BASE_URL .'gz-admin/ajax/menu.ajax.php'; ?>" method="POST">
							<div class="menu-header">
								<span class="pull-left">
								<a href="javascript:void(0)"><?php echo $data['nama_menu']; ?></a>
								</span>
								<span class="pull-right">
									<a href="javascript:void(0)" class="menu-trigger">Edit</a>
								</span>
								<div class="clearfix"></div>
							</div>
						
							<div class="menu-animate">
								<div class="menu-body">
									<div class="menu-data-<?php echo $data['id_main']; ?>">
										<input type="hidden" name="current_position" value="<?php echo $data['position']; ?>">
										<div class="form-group">
											<label for="">Pindah ke:</label>
											<select name="move" id="" class="form-control">
												<option value="">Pilih</option>
												<option value="up">Keatas</option>
												<option value="down">Kebawah</option>
											</select>
										</div>
									</div>
								</div>
								<div class="menu-footer">
									<a href="javascript:void(0)" class="btn btn-sm btn-default pull-right save-menu">Pindah</a>
									<div class="clearfix"></div>
								</div>
							</div>
						</form>
					</li>
				<?php } ?>
				</ol>		
			</div>
		</div>
		
	</div>
<?php }  ?>
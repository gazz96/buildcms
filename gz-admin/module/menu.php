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

					<?php if( isset($_GET['menuarea'])) { ?>
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
					<?php } ?>
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
										<button class="btn btn-sm btn-danger" onclick="return deleteCurrentMenu(event,<?php echo $mm['id_main'] ?>,'<?php echo BASE_URL . '/gz-admin/ajax/delete-menu.php' ?>','POST')">
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
											<button 
												class="btn btn-sm btn-danger" 
												onclick="return deleteCurrentMenu(event,<?php echo $sm['id_main'] ?>,'<?php echo BASE_URL . '/gz-admin/ajax/delete-menu.php' ?>','POST')">
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


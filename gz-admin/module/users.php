<?php 

/** Users Data **/
function users_data(){
	global $db;
	global $library;

	if(isset($_POST['delete'])){
		$delete = $db->delete("users", array('username', $_POST['id']));
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


	$query_str = "SELECT * FROM users";
	$data = $db->get_results($query_str);
	
	?>

	

	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Data Users
			<a href="?module=users_form" class="btn-add">Tambah Data</a>
		</h3> 

	</div>
	
	<div class="module-body">
		<table class="table table-bordered" id="table-users">
			<thead>
				<tr>
					<th>Username</th>
					<th>Nama</th>
					<th>Email</th>
					<th>Telp</th>
					<th>Level</th>
					<th>Blokir</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data as $d): ?>
					<tr>
						<td><?php echo $d['username']; ?></td>
						<td><?php echo $d['nama_lengkap']; ?></td>
						<td><?php echo $d['email']; ?></td>
						<td><?php echo $d['no_telp']; ?></td>
						<td><?php echo $d['level']; ?></td>
						<td><?php echo $d['blokir']; ?></td>
						<td>
							<a class="btn btn-warning btn-small" href="?module=users_edit&user=<?php echo $d['username']; ?>"><span class="fa fa-pencil"></span></a>
							<form action="<?php echo ADMIN_URL . 'dashboard.php'; ?>?module=users_data" method="POST" style="display: inline-block;">
								<input type="hidden" name="id" value="<?php echo $d['username']; ?>">
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

function users_form(){
	global $uploads;
	global $db;
	global $library;

	$library->add_rule('username', 'Username', array('require'));
	$library->add_rule('nama_lengkap', 'Nama', array('require'));
	$library->add_rule('email','Email', array('require'));
	$library->add_rule('no_telp', 'No Telp', array(''));
	$library->add_rule('blokir', 'blokir', array(''));
	if(isset($_POST['tambah'])){
		if($db->exists_user($library->getPost('username'))){
			if($library->run()){
				$objects = array(
					"username" => $library->getPost('username'),
					"nama_lengkap" => $library->getPost('nama_lengkap'),
					"email" => $library->getPost('email'),
					"no_telp" => $library->getPost('no_telp'),
					"blokir" => $library->getPost('blokir'),
					"password" => md5($library->getPost('password')),
					"user_img" => UPLOADS_URL . $library->getFile("imgInput"),
					"date_created" => date('Y-m-d')
				);
				$save = $db->save("users", $objects);
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
		else{
			$library->message = "User dengan nama " . $library->getPost('username') . " sudah ada";
			$library->alert_class = "alert-warning";
		}
		
	}

	?>
	
	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Tambah Users</h3> 

	</div>

	<div class="module-body">
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label for="">Username</label>
						<input type="text" name="username" class="form-control" value="<?php echo $library->form_value('username'); ?>">
					</div>	

					<div class="form-group">
						<label for="">Nama</label>
						<input type="text" name="nama_lengkap" class="form-control" value="<?php echo $library->form_value('nama_lengkap'); ?>">
					</div>

					<div class="form-group">
						<label for="">Email</label>
						<input type="text" name="email" class="form-control" value="<?php echo $library->form_value('email'); ?>"> 
					</div>

					<div class="form-group">
						<label for="">Telp.</label>
						<input type="text" name="no_telp" class="form-control" value="<?php echo $library->form_value('no_telp'); ?>"> 
					</div>

					<div class="form-group">
						<label for="">Password</label>
						<input type="password" name="password" class="form-control" value=""> 
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
									<label for="">Aktif</label>
									<select name="blokir" id="" class="form-control">
										<option value="N">Y</option>
										<option value="Y">N</option>
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

function users_edit(){
	global $uploads;
	global $db;
	global $library;

	$library->add_rule('username', 'Username', array('require'));
	$library->add_rule('nama_lengkap', 'Nama', array('require'));
	$library->add_rule('email','Email', array('require'));
	$library->add_rule('no_telp', 'No Telp', array(''));
	$library->add_rule('blokir', 'blokir', array(''));

	if(isset($_POST['update'])){
		if($library->run()){	
			$imgInput = $library->getFile('imgInput');
			$move = $uploads->upload_file($_FILES['imgInput']);
			if($move){
				if(!empty($_POST['password'])){
					$objects = array(
						"username" => $library->getPost('username'),
						"nama_lengkap" => $library->getPost('nama_lengkap'),
						"email" => $library->getPost('email'),
						"no_telp" => $library->getPost('no_telp'),
						"blokir" => $library->getPost('blokir'),
						"password" => md5($library->getPost('password')),
						"user_img" => $uploads->upload_data('path'),
					);	
				}else{
					$objects = array(
						"username" => $library->getPost('username'),
						"nama_lengkap" => $library->getPost('nama_lengkap'),
						"email" => $library->getPost('email'),
						"no_telp" => $library->getPost('no_telp'),
						"blokir" => $library->getPost('blokir'),
						"user_img" => $uploads->upload_data('path')	
					);
				}
				$update = $db->update('users', $objects, array('username',$_POST['username']));
				if($update){
					$library->message = "Berhasil memperbaharui data";
					$library->alert_class = "alert-success";
				}
				else{
					$library->message = "Gagal memperbaharui data";
					$library->alert_class = "alert-warning";
				}
			}
			else{
				if(!empty($_POST['password'])){
					$objects = array(
						"username" => $library->getPost('username'),
						"nama_lengkap" => $library->getPost('nama_lengkap'),
						"email" => $library->getPost('email'),
						"no_telp" => $library->getPost('no_telp'),
						"blokir" => $library->getPost('blokir'),
						"password" => md5($library->getPost('password')),
					);	
				}else{
					$objects = array(
						"username" => $library->getPost('username'),
						"nama_lengkap" => $library->getPost('nama_lengkap'),
						"email" => $library->getPost('email'),
						"no_telp" => $library->getPost('no_telp'),
						"blokir" => $library->getPost('blokir'),
					);
				}
				$update = $db->update('users', $objects, array('username',$_POST['username']));
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
		
	}

	$username = isset($_GET['user']) ? $db->esc_str($_GET['user']) : false;
	$data = $db->query("SELECT * FROM users WHERE username='{$username}'")->fetch_assoc();
	$nama_lengkap = $data['nama_lengkap'];
	$email = $data['email'];
	$no_telp = $data['no_telp'];
	$blokir = $data['blokir'];
	$user_img = $data['user_img'];
	?>
	
	<div class="module-header">
		<?php $library->alert(); ?>
		<h3 class="module-title">Edit Users</h3> 

	</div>

	<div class="module-body">
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label for="">Username</label>
						<input type="text" name="username" class="form-control" value="<?php echo $username ?>" readonly>
					</div>	

					<div class="form-group">
						<label for="">Nama</label>
						<input type="text" name="nama_lengkap" class="form-control" value="<?php echo $nama_lengkap; ?>">
					</div>

					<div class="form-group">
						<label for="">Email</label>
						<input type="text" name="email" class="form-control" value="<?php echo $email; ?>"> 
					</div>

					<div class="form-group">
						<label for="">Telp.</label>
						<input type="text" name="no_telp" class="form-control" value="<?php echo $no_telp; ?>"> 
					</div>

					<div class="form-group">
						<label for="">Password</label>
						<input type="password" name="password" class="form-control" value=""> 
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
									<label for="">Aktif</label>
									<select name="blokir" id="" class="form-control">
										<option value="N" <?php if($blokir == "N"){ echo "selected"; } ?>>Y</option>
										<option value="Y" <?php if($blokir == "Y"){ echo "selected"; } ?>>N</option>
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

					<div id="foto-profile">
						<div class="widget">
							<div class="widget-header">
								<span class="widget-title">Profile</span>
							</div>
							<div class="widget-body">
								<input type="hidden" name="user_img">
								<input type="hidden" name="oldImg" value="<?php echo $user_img; ?>">
								<input type="file" name="imgInput" class="imgInput" style="visibility: hidden;max-height: 0">
								<a href="" id="profilTrigger">
									<?php 

										if(!empty($user_img)){
											echo "<img class='img-responsive' src='{$user_img}'>";
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

	<?php 
}

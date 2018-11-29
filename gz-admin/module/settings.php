<?php 

function settings_form(){
	global $db;
	$query = $db->Query("SELECT * FROM settings");
	$jlh_data = $query->num_rows;
	$data = $query->fetch_array();

	$nama_situs = isset($data['nama_website']) ? $data['nama_website'] : false;
	$detail_situs = isset($data['detail_website']) ? $data['detail_website'] : false;
	$content_situs = isset($data['content_website']) ? $data['content_website'] : false;
	$logo = isset($data['logo']) ? $data['logo'] : false;
	$banner = isset($data['banner']) ? $data['banner'] : false;
	$banner_samping = isset($data['banner_samping']) ? $data['banner_samping'] : false;
	$alamat = isset($data['alamat']) ? $data['alamat'] : false;
	$peta = isset($data['maps']) ? $data['maps'] : false;
	$peta_bencana = isset($data['home_maps']) ? $data['home_maps'] : false;
	$peringatan = isset($data['peringatan']) ? $data['peringatan'] : false;
	$wa = isset($data['wa']) ? $data['wa'] : false;
	$fb = isset($data['fb']) ? $data['fb'] : false;
	$ig = isset($data['ig']) ? $data['ig'] : false;
	?>
	
	<div class="module-header">
		<div class="module-msg" id="module-message"></div>
		<h3 class="module-title">Settings</h3>
	</div>
	<div class="module-body">
		<form method="POST" action="<?php echo ADMIN_URL . 'ajax/settings.ajax.php'; ?>" id="update_settings">
			<div class="row">
				<div class="col-md-3">
					<h3>Basic Info</h3>
					<hr>
					<div class="form-group">
						<label>Nama Situs</label>
						<input type="text" name="nama_website" class="form-control" value="<?php echo $nama_situs; ?>">
					</div>

					<div class="form-group">
						<label>Detail</label>
						<textarea class="form-control" name="detail_website"><?php echo $detail_situs; ?></textarea>
					</div>

					<div class="form-group">
						<label>Konten</label>
						<textarea class="form-control" name="content_website"><?php echo $content_situs; ?></textarea>
					</div>
				</div>
				<div class="col-md-3">
					<h3>Logo & Banner</h3>
					<hr>

					<div class="form-group">
						<label>Logo</label>
						<div class="input-group">
							<input type="text" name="logo_url" class="form-control" id="url_logo" value="<?php echo $logo; ?>">
							<div class="input-group-addon"><a href="../gz-includes/assets/responsivefilemanager/filemanager/dialog.php?type=2&field_id=url_logo&relative_url=0" class="iframe-btn" type="button"><i class="fa  fa-mouse-pointer fa-fw"></i></a></div>
						</div>

						<label>Banner</label>
						<div class="input-group">
							<input type="text" name="banner_url" class="form-control" id="url_banner" value="<?php echo $banner; ?>">
							<div class="input-group-addon"><a href="../gz-includes/assets/responsivefilemanager/filemanager/dialog.php?type=2&field_id=url_banner&relative_url=0" class="iframe-btn" type="button"><i class="fa  fa-mouse-pointer fa-fw"></i></a></div>
						</div>
                    
                    <label>Banner Samping</label>
						<div class="input-group">
							<input type="text" name="banner_samping" class="form-control" id="banner_samping" value="<?php echo $banner_samping; ?>">
							<div class="input-group-addon"><a href="../gz-includes/assets/responsivefilemanager/filemanager/dialog.php?type=2&field_id=url_banner&relative_url=0" class="iframe-btn" type="button"><i class="fa  fa-mouse-pointer fa-fw"></i></a></div>
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<h3>Kontak</h3>
					<hr>
					<div class="form-group">
						<label>Alamat</label>
						<textarea name="alamat" rows="5" class="form-control"><?php echo $alamat; ?></textarea>
					</div>

					<div class="form-group">
						<label>Peta Lokasi</label>
						<textarea name="maps" rows="5" class="form-control"><?php echo $peta; ?></textarea>
					</div>
				</div>

				<div class="col-md-3">
					<h3>Peta Bencana</h3>
					<hr>
					<div class="form-group">
						<label>Peta</label>
						<textarea name="home_maps" rows="5" class="form-control"><?php echo $peta_bencana; ?></textarea>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<h3>Peringatan Dini</h3>
					<hr>
					<div class="form-group">
						<label>Peringatan</label>
						<textarea name="peringatan" rows="5" class="form-control"><?php echo $peringatan; ?></textarea>
					</div>	
				</div>
                <div class="col-md-4">
					<h3>Sosial Media</h3>
					<hr>
					<div class="form-group">
						<label>Whatsapp</label>
						<textarea name="wa" rows="2" class="form-control"><?php echo $wa; ?></textarea>
					</div>	
                    <div class="form-group">
						<label>Facebook</label>
						<textarea name="fb" rows="2" class="form-control"><?php echo $fb; ?></textarea>
					</div>
                    <div class="form-group">
						<label>Instagram</label>
						<textarea name="ig" rows="2" class="form-control"><?php echo $ig; ?></textarea>
					</div>	                                                     
				</div>
                                                        
			</div>



			<button name="update" id="btn-update-settings" class="btn btn-add">Update</button>
		</form>
	</div>
	<script type="text/javascript">
		var updateSettings = document.getElementById('btn-update-settings');
		updateSettings.addEventListener('click', function(e){
			e.preventDefault();
			var form = document.getElementById('update_settings');
			var data = new FormData(form);
			var action = form.action;
			var method = form.method;
			console.log(data, action, method);
			sendAjax(method, action, data, updateForm, false);	
		});

		function updateForm(response){
			var moduleMessage = document.getElementById("module-message");
			moduleMessage.innerHTML = response;
		}
	</script>
<?php 

}

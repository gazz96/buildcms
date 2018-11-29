<?php 

function slug($str){
	$str = strtolower($str);
	$str = preg_replace('/[^a-zA-Z0-9]+/', '-', $str);
	$str = preg_replace( '/[«»“”!?,.]+/', '', $str );
	return $str;
}

function is_login(){
	if(!isset($_SESSION['login']) or !isset($_SESSION['username']) or !isset($_SESSION['level'])){
		header('location: ' . BASE_URL . 'gz-admin');
	}
}

function fileManager($type = 2, $field=''){

	$anchor = "<a href='" . ASSETS_URL . "responsivefilemanager/filemanager/dialog.php?type={$type}&field_id={$field}" . "' class='iframe-btn'>Open</a>";
	return $anchor;
}

function setFormWidget($type = "", $id=""){
	global $db;
	switch ($type) {
		case 'kategori':
		?>
			<select name="id_kategori" class="form-control on-change">
				<?php
					$query_str = "SELECT * FROM kategori WHERE aktif='Y'";
					$query = $db->query($query_str);
					while($data = $query->fetch_array()){
				?>
					<option value="<?php echo $data['id_kategori'] ?>" <?php if($data['id_kategori'] == $id){ echo "selected"; } ?>><?php echo $data['nama_kategori']; ?></option>
				<?php } ?>
			</select>
		<?php 
			break;
		case 'banner':
		?>
			<select name="id_banner" class="form-control on-change">
            	<option value=''>Pilih</option>
				<?php
					$query_str = "SELECT * FROM banner";
					$query = $db->query($query_str);
					while($data = $query->fetch_array()){
				?>
					<option value="<?php echo $data['id_banner'] ?>" <?php if($data['id_banner'] == $id){ echo "selected"; } ?>><?php echo $data['judul']; ?></option>
				<?php } ?>
			</select>
		<?php 
		break; 
		case 'populer':
			?>
				<input type="text" value="Berita Terpopuler" class="form-control" readonly="">
			<?php 
			break;
		case 'menu':
		?>
			<select name="id_menu" class="form-control on-change">
				<?php
					$query_str = "SELECT * FROM menuarea";
					$query = $db->query($query_str);
					while($data = $query->fetch_array()){
				?>
					<option value="<?php echo $data['id_area'] ?>" <?php if($data['id_area'] == $id){ echo "selected"; } ?>><?php echo $data['nama_area']; ?></option>
				<?php } ?>
			</select>
		<?php 
			break;
		case 'text':
			$query_str = "SELECT * FROM widget WHERE id_widget='{$id}'";
			$query = $db->query($query_str);
			$data  = $query->fetch_array();
		?>
			<textarea name="widget_content" id="" rows="3" class="form-control on-keyup"><?php echo $data['widget_content']; ?></textarea>
		<?php	
			break;	
		default:
			# code...
			break;
	}
}
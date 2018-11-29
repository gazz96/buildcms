<?php 
require_once 'util.php';
$settings_row = $db->query("SELECT * FROM settings")->num_rows;

$objects = array(
	'nama_website' => $_POST['nama_website'],
	'detail_website' => $_POST['detail_website'],
	'content_website' => $_POST['content_website'],
	'logo' => $_POST['logo_url'],
	'banner' => $_POST['banner_url'],
	'banner_samping' $_POST['banner_samping'],
	'alamat' => $_POST['alamat'],
	'maps' => $_POST['maps'],
	'home_maps' => $_POST['home_maps'],
	'peringatan' => $_POST['peringatan'],
	'wa' => $_POST['wa'],
	'fb' => $_POST['fb'],
	'ig' => $_POST['ig']
);

if($settings_row == 0){
	$save = $db->save('settings', $objects);
	if($save){
		$lib->message = "Berhasil menambahkan data";
		$lib->alert_class = "alert-success";
	}else{
		$lib->message = "Gagal menambahkan data";
		$lib->alert_class = "alert-warning";
	}
}

if($settings_row == 1){
	$update = $db->update('settings', $objects, array('id_settings', '1'));
	if($update){
		$lib->message = "Berhasil memperbaharui data";
		$lib->alert_class = "alert-success";
	}else{
		$lib->message = "Gagal memperbaharui data";
		$lib->alert_class = "alert-warning";
	}
}

echo $lib->alert();



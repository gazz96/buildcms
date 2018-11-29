<?php 

require_once 'util.php';

if(isset($_POST['tambah'])){
	if(!empty(trim($_POST['id_album']))){
		for($i=0; $i < count($_POST['jdl_gallery']); $i++){
			if(!empty($_POST['jdl_gallery'][$i])){
				$object = array(
					'id_album' => $_POST['id_album'],
					'jdl_gallery' => $_POST['jdl_gallery'][$i],
					'keterangan' => $_POST['keterangan'][$i],
				);

				$save = $db->save('gallery', $object);
				if($save){
					$lib->message = "Berhasil menambahkan data";
					$lib->alert_class = "alert-success";
				}
				else{
					$lib->message = "Gagal menambahkan data";
					$lib->alert_class = "alert-danger";
				}
			}
			else{
				$lib->message = "Data tidak boleh kososng";
				$lib->alert_class = "alert-danger";
			}		
		}
	}
	else{
		$lib->message = "Pilih album terlebih dahulu";
		$lib->alert_class = "alert-warning";
	}
}

if(isset($_POST['update'])){
	if(!empty(trim($_POST['id']))){
		$object = array(
			'keterangan' => $_POST['keterangan'],
		);

		$update = $db->update('gallery', $object, array('id_gallery', $_POST['id']));
		if($update){
			$lib->message = "Berhasil memperbaharui data";
			$lib->alert_class = "alert-success";
		}
		else{
			$lib->message = "Gagal memperbaharui data";
			$lib->alert_class = "alert-danger";
		}
	}
	else{
		$lib->message = "Tidak dapat memperbaharui";
		$lib->alert_class = "alert-warning";
	}
}

if(isset($_POST['delete'])){
	if(!empty(trim($_POST['id']))){
		$delete = $db->delete('gallery', array('id_gallery', $_POST['id']));
		if($delete){
			$lib->message = "Berhasil menghapus data";
			$lib->alert_class = "alert-success";
		}
		else{
			$lib->message = "Gagal menghapus data";
			$lib->alert_class = "alert-danger";
		}
	}
	else{
		$lib->message = "Tidak dapat menghapus data";
		$lib->alert_class = "alert-warning";
	}
}

$lib->alert();
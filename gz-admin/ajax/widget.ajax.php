<?php 

require_once 'util.php';
//print_r($_POST);
$result = false;
$id = isset($_POST['id_widget']) ? abs($_POST['id_widget']) :  false;
if(isset($id)){
	if(isset($_POST['id_banner'])){
		$update = "UPDATE widget SET id_banner='" . $_POST['id_banner'] . "' WHERE id_widget='{$id}'";
		$query = $db->query($update);
		if($query){
			$result =  true;
		}
	}elseif(isset($_POST['id_kategori'])){
		$update = "UPDATE widget SET id_kategori='" . $_POST['id_kategori'] . "' WHERE id_widget='{$id}'";
		$query = $db->query($update);
		if($query){
			$result =  true;
		}
	}elseif(isset($_POST['id_menu'])){
		$update = "UPDATE widget SET id_area='" . $_POST['id_menu'] . "' WHERE id_widget='{$id}'";
		$query = $db->query($update);
		if($query){
			$result =  true;
		}
	}elseif(isset($_POST['id_banner'])){
		$update = "UPDATE widget SET id_banner='" . $_POST['id_banner'] . "' WHERE id_widget='{$id}'";
		$query = $db->query($update);
		if($query){
			$result =  true;
		}
	}elseif(isset($_POST['widget_content'])){
		$update = "UPDATE widget SET widget_content='" . $_POST['widget_content'] . "' WHERE id_widget='{$id}'";
		$query = $db->query($update);
		if($query){
			$result =  true;
		}
	}
	elseif(isset($_POST['id_album'])){
		$update = "UPDATE widget SET id_album='" . $_POST['id_album'] . "' WHERE id_widget='{$id}'";
		$query = $db->query($update);
		if($query){
			$result =  true;
		}
	}
}

echo json_encode($result);

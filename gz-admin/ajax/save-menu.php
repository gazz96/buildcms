<?php 

require_once 'util.php';

if( isset( $_POST['true_submit'] ) ) {
	print_r( $_POST );
	$ids = $_POST['id_main'];
	for($i = 0; $i < count($ids); $i++) {
		$id_main = $ids[$i];
		$nama_menu = $_POST['nama_menu'][$i];
		$link = $_POST['link'][$i];
		$id_parent = $_POST['id_parent'][$i];
		$query_str = "UPDATE mainmenu set nama_menu='$nama_menu', link='$link', id_parent='$id_parent' WHERE id_main='$id_main'";
		$db->query( $query_str );
	}
}
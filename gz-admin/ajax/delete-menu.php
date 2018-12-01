<?php

require_once 'util.php';
$result = [];
if(isset($_POST['true_submit'])) {
	$id_main = $_POST['id_main'];
	$query_str = "DELETE FROM mainmenu WHERE id_main='$id_main' LIMIT 1";
	echo $query_str;
	$query = $db->query($query_str);
	if($query) {
		$result = [
			'success' => true,
			'id'	=> $id_main
		];
	}
}

echo json_encode( $result );
<?php 
require_once 'util.php';

if(isset($_POST['move'])){
	$current_position = $_POST['lipos'];
	
	if($_POST['move'] == "up"){
		if($_POST['current_position'] == 1){
			return true;
		}
		else{
			$position = $_POST['prevpos'];
			$data = $db->get_results("SELECT * FROM mainmenu WHERE position >= {$position} and position <= {$current_position} ORDER BY position DESC");
			for($i = 0; $i < count($data); $i++){
				if($i == 0){
					$db->query("UPDATE mainmenu SET position='{$position}' WHERE id_main='" . $data[0]['id_main'] . "'");
				}
				else{
					$db->query("UPDATE mainmenu SET position='{$current_position}' WHERE id_main='" . $data[1]['id_main'] . "'");
				}
			}
			$lib->message = "Berhasil menambahkan data";
			$lib->alert_class = "alert-success";
		}
		
	}
	elseif ($_POST['move'] == "down") {
		/*if($_POST['current_position'] == 1){
			return true;
		}
		else{*/
			$position = $_POST['nextpos'];
			$query_down = "SELECT * FROM mainmenu WHERE position >= {$current_position} and position <= {$position} ORDER BY position DESC";
			echo $query_down;
			$data = $db->get_results($query_down);
			print_r($data);
			for($i = 0; $i < count($data); $i++){
				if($i == 0){
					$db->query("UPDATE mainmenu SET position='{$current_position}' WHERE id_main='" . $data[0]['id_main'] . "'");
				}
				else{
					$db->query("UPDATE mainmenu SET position='{$position}' WHERE id_main='" . $data[1]['id_main'] . "'");
				}
			}
			$lib->message = "Berhasil menambahkan data";
			$lib->alert_class = "alert-success";
		/*}*/
	}
}

echo $lib->alert();

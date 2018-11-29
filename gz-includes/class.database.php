<?php 

class database{

	public $mysql;

	function __construct(){
		//$this->mysql = new mysqli("bpbd.sumutprov.go.id", "root", "bpbdr00tp45w0rd", "mastah_bpbd");
		$this->mysql = new mysqli(HOST, USERDB, PASSDB, DB);
	}

	function esc_str($str){
		$str = trim($str);
		return $this->mysql->real_escape_string($str);
	}

	function query($query_str){
		return $this->mysql->query($query_str);
	}

	function get_results($query_str){
		$query = $this->mysql->query($query_str);
		$data = [];
		while($fetch_data = $query->fetch_assoc()){
			$data[] = $fetch_data;
		}
		return $data;
	}

	function save($table, $objects){
		$query_str = "INSERT INTO " . $table . " "; 
		$fields_arr = $values_arr = [];
		foreach ($objects as $field => $value) {
			$fields_arr[] = $field;
			$values_arr[] = "'" . $value . "'";
		}

		$fields_str = "(" . implode($fields_arr,',') . ")";
		$values_str = " VALUES (" . implode($values_arr,',') . ")";
		$query_str .= $fields_str . $values_str;
		//echo $query_str;
		$query = $this->query($query_str);
		if($query){
			return true;	
		}
		return false;
	}

	function update($table, $objects, $params = array()){
		$query_str = "UPDATE " . $table . " SET ";
		$values_arr = [];
		foreach ($objects as $field => $value) {
			$values_arr[] = $field."='" . $value . "'";
		}
		$values_str = implode($values_arr, ',');

		$query_str .= $values_str;
		if(!empty($params[0]) and !(empty($params[1]))){
			$query_str .= " WHERE " . $params[0] . "='" . $params[1] . "'";
		}
		elseif(!empty($params[0])){
			$query_str .= $params[0];
		}
		//echo $query_str;
		$query = $this->query($query_str);
		if($query){
			return true;	
		}
		return false;
	}

	function exists_user($username){
		$query_str = "SELECT username FROM users WHERE username='$username'";
		$query = $this->query($query_str);
		if($query->num_rows == 1){
			return false;
		}
		return true;
	}

	function cari($table = "", $param = []){
		$query_str = "SELECT " . $table . " FROM users WHERE " . $params[0] . "='" . $param[1] ."'";
		$query = $this->query($query_str);
		if($query->num_rows == 1){
			return false;
		}
		return true;
	}

	function delete($table = "", $params = []){
		$query_str = "DELETE FROM " . $table;
		if(!empty($params[0]) and !(empty($params[1]))){
			$query_str .= " WHERE " . $params[0] . "='" . $params[1] ."'";
		}
		else{
			$query_str .= " WHERE " . $params[0];
		}
		$delete = $this->query($query_str);
		if($delete){
			return true;
		}
		return false;
	}

	function get_cat_name($slug){
		$slug = $this->esc_str($slug);
		$query = $this->mysql->query("SELECT nama_kategori FROM kategori WHERE slug_kategori='{$slug}'");
		$data = $query->fetch_array();
		//var_dump($data);
		if($query->num_rows > 0){
			return $data['nama_kategori'];
		}
		return '';
	}


}
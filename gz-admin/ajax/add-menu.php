<?php 

require_once 'util.php';

if(isset($_POST['true_submit'])) {
	$id = isset($_POST['id']) ? $_POST['id'] : false;
	$type = isset( $_POST['type'] ) ? $_POST['type'] : false;
	$menuarea = $_POST['menuarea'];
	for($i = 0; $i < count($id); $i++) {
		
		$current_id = $id[$i];
		if( $type == 'page') {
			//echo $current_id;
			$query_str = "SELECT id_halaman, judul, slug FROM halaman WHERE id_halaman='$current_id'";
			//echo $query_str;
			$hal = $db->query( $query_str )->fetch_assoc();
			$pos = $db->query('SELECT max(position)+1 FROM mainmenu')->fetch_array()[0];

			$cari_str = "SELECT id_halaman FROM mainmenu WHERE id_halaman='$current_id' and  area='$menuarea'";
			$query_cari = $db->query( $cari_str )->num_rows;

			if( $query_cari == 0 ){
				$objects = [
					'id_halaman' 	=> $hal['id_halaman'],
					'nama_menu'		=> $hal['judul'],
					'link'			=> 'page/' . $hal['slug'],
					'area'			=> $menuarea,
					'position'		=> $pos,
					'type'			=> 'page',
					'aktif'			=> 'Y',
					'id_parent'		=> 0
				];

				$insert = $db->save('mainmenu', $objects);
			}
		}else if( $type == 'kategori') {
			//echo $current_id;
			$query_str = "SELECT id_kategori, nama_kategori, slug_kategori FROM kategori WHERE id_kategori='$current_id'";
			//echo $query_str;
			$d = $db->query( $query_str )->fetch_assoc();
			$pos = $db->query('SELECT max(position)+1 FROM mainmenu')->fetch_array()[0];

			$cari_str = "SELECT id_kategori FROM mainmenu WHERE id_kategori='$current_id' and area='$menuarea'";
			$query_cari = $db->query( $cari_str )->num_rows;

			if( $query_cari == 0 ){
				$objects = [
					'id_halaman' 	=> $d['id_kategori'],
					'nama_menu'		=> $d['nama_kategori'],
					'link'			=> 'category/' . $d['slug_kategori'],
					'area'			=> $menuarea,
					'position'		=> $pos,
					'type'			=> 'category',
					'aktif'			=> 'Y',
					'id_parent'		=> 0
				];

				$insert = $db->save('mainmenu', $objects);
			}
		}

	}
}

<?php 

//require_once 'class.routes.php';

$current_url = isset( $_GET['url'] ) ? rtrim($_GET['url'], '/') : false;
$exp_url = explode( '/', $current_url );
$page_name = isset($exp_url[0]) ? $exp_url[0] : false;

require_once $this->template_fullpath()  . '/function.php';



if(in_array($page_name, $page)) {
	$params = $this->get_params( $page_rule[$page_name]['params'], $exp_url); 
	extract($params);
	$slug = $this->mysql->escape_string( $slug );
	$query_str  = "";

	if( $slug ) {
		$query_str = "SELECT * FROM berita JOIN kategori JOIN berita.id_kategori=kategori.id_kategori 
						WHERE slug_kategori='$slug'" ;
	}else {
		$query_str = "SELECT nama_kategori, slug_kategori FROM kategori ORDER BY nama_kategori ASC";
	}

	require_once $this->template_fullpath() . '/' . $page_rule[$page_name]['file'];

}

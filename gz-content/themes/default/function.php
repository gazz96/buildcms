<?php 

$page = [
	'halaman',
	'single',
	'arsip',
	'cuaca',
	'kategori'
];

$page_rule = [
	'kategori' => [
		'file' => 'kategori.php',
		'params' => 'slug',
	]
];


$register_widget = [
	'right_sidebar' => [
		'id' 	=> 'right_sidebar',
		'title'	=> 'Sidebar Kanan',
		'desc'	=> 'sidebar kanan website'
	],
];

$register_widget_item = [
	'populer'		=> [
		'id'		=> 'populer',
		'title'		=> 'Populer',
		'desc'		=> 'Show Populer Post'
	],
	'related_post'	=> [
		'id'		=> 'related_post',
		'title'		=> 'Related Post',
		'desc'		=> 'Show Related Post'
	],
];
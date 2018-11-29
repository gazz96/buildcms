<?php 

//ini_set("display_errors", TRUE);1
session_start();
if(!isset($_SESSION['page_type']) or empty($_SESSION['page_type'])){
	$_SESSION['page_type'] = '';	
}

require_once 'config.php';
require_once 'gz-includes/inc.php';
require_once 'gz-includes/func.public.php';

$db = new database();
$template = new template();
$template->render();


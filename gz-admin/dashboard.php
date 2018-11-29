<?php 
	session_start();
	require_once '../gz-includes/class.database.php';
	require_once '../gz-includes/class.uploads.php';
	require_once '../gz-includes/class.library.php';
	require_once '../gz-includes/func.admin.php';
	require_once '../config.php';
	require_once 'module/module.php';
	require_once '../gz-includes/helper.php';
	$db = new database;
	$uploads = new uploads;
	$library = new library();

	is_login();
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Administrator Page</title>
	<link rel="stylesheet" href="<?php echo ADMIN_URL . 'css/dashboard.css'; ?>">
	<link rel="stylesheet" href="<?php echo ADMIN_URL . 'css/admin.css'; ?>">
	<link rel="stylesheet" href="<?php echo ASSETS_URL . 'css/font-awesome.min.css'; ?>">
	<link rel="stylesheet" href="<?php echo ASSETS_URL . 'css/bootstrap.min.css'; ?>">
	<link rel="stylesheet" href="<?php echo ASSETS_URL . 'css/dataTables.bootstrap.css' ?>">
	<link rel="stylesheet" href="<?php echo ASSETS_URL . 'fancybox/jquery.fancybox-1.3.4.css' ?>">
	<script src="<?php echo ADMIN_URL . 'js/jquery.min.js'; ?>"></script>
	<script src="<?php echo ASSETS_URL . 'tinymce/tinymce.min.js'; ?>"></script>
	<script src="<?php echo ASSETS_URL . 'fancybox/jquery.fancybox-1.3.4.pack.js'; ?>"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>
	<script>
    $(document).ready(function(){
    	$('.iframe-btn').fancybox({	
        	'width'		: 900,
        	'height'	: 600,
        	'type'		: 'iframe',
        	'autoScale'    	: false
    	});
    });
	</script>
</head>
<body>

<div class="body-wrapper">
	
	
	<div class="main-wrapper">
		<div class="sidebar-wrapper">
			<div class="sidebar-header">
				<div class="profile">
					<div class="profile-img">
						
					</div>
					<div class="profile-desc">
						<h3>Administrator Page</h3>
					</div>
				</div>
			</div>
			<div class="sidebar-body">
				<div class="sidebar-nav">
					<ul>
						<li><a href="dashboard.php" class="active"><span class="fa fa-home"></span> Dashboard</a></li>
						<li class="accordion">
							<a href="javascript:void(0)"><span class="fa fa-pencil"></span> Post</a>
							<ul class="accordion-menu">
								<li><a href="?module=add_post">Tambah baru</a></li>
								<li><a href="?module=post_data">Lihat Semua</a></li>
								<li><a href="?module=kategori_data">Kategori</a></li>
							</ul>
						</li>

						<li class="accordion">
							<a href="javascript:void(0)"><span class="fa fa-tag"></span> Halaman</a>
							<ul class="accordion-menu">
								<li><a href="?module=add_page">Tambah baru</a></li>
								<li><a href="?module=page_data">Lihat Semua</a></li>
							</ul>
						</li>

						<li class="accordion">
							<a href="javascript:void(0)"><span class="fa fa-users"></span> Users</a>
							<ul class="accordion-menu">
								<li><a href="?module=users_form">Tambah baru</a></li>
								<li><a href="?module=users_data">Lihat Semua</a></li>
							</ul>
						</li>
						
						<li><a href="?module=menu_data"><span class="fa fa-navicon"></span> Menus</a></li>
						<li class="accordion">
							<a href="javascript:void(0)"><span class="fa fa-image"></span> Galeri</a>
							<ul class="accordion-menu">
                            	
								<li><a href="?module=add_galeri">Tambah baru</a></li>
								<li><a href="?module=album_data">Album</a></li>
                            	<li><a href="?module=banner_data"><span class="fa fa-file-image-o "></span> Banner</a></li>
							</ul>
						</li>
                    	
                    	<li><a href="?module=agenda_data"><span class="fa fa-calendar"></span>Agenda</a></li>
                    
                    	<li><a href="?module=cuaca"><span class="fa fa-sun-o"></span>Cuaca</a></li>
						
                   		<li class="accordion">
                        	<a href="javascript:void(0)"><span class="fa fa-gears"></span> Settings</a>
                        	<ul class="accordion-menu">
                            	<li><a href="?module=settings_form"><span class="fa fa-gears"></span> Settings</a></li>
								<li><a href="?module=widget_data"><span class="fa fa-laptop"></span> Widget</a></li>
								<li><a href="?module=poling_data"><span class="fa fa-bullhorn"></span>Poling</a></li>
                            	<li><a href="?module=kab_kota_data"><span class="fa fa-map-o"></span> Kabupaten Kota</a></li>
                    			<li><a href="?module=pegawai_data"><span class="fa fa-user-o"></span>Pegawai</a></li>
                            	<li><a href="?module=pesan_data"><span class="fa fa-envelope"></span> Pesan</a></li>
                            	
							</ul>
                    	</li>
						
						<!-- <li><a href="javascript:void(0)"><span class="fa fa-eye"></span> Template</a></li> -->
					</ul>
					
					
					
					
					

				</div>
			</div>
		</div>
	
		<div class="module-wrapper">
			<!-- navbar -->
			<div class="navbar-wrapper">
				<div class="navbar">

					<div class="navbar-collapse">
                    	<ul class="nav">
							<!-- <li><a href=""><span class="fa fa-bell"></span></a></li> -->
							<li class="">
								<a href="javascript:void(0)" class="trigger-canvas"><span class="fa fa-bars"></span></a>
							</li>
						</ul>
						<ul class="nav navbar-right">
							<!-- <li><a href=""><span class="fa fa-bell"></span></a></li> -->
							<li class="dropdown">
								<a href="javascript:void(0)"><span class="fa fa-gear"></span></a>
								<ul class="dropdown-menu">
									<!-- <li><a href="">Profile</a></li> -->
									<li><a href="logout.php">Logout</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /navbar -->

			<!-- module -->
			<div class="module-box">
				<?php

					$module = isset($_GET['module']) ? $_GET['module'] : false;	
					if(function_exists($module)){
						$module();
					}
					else{
                    	home();
                    }
				?>
			</div>
			<!-- /module -->
		</div>
	</div>
</div>
<script src="<?php echo ASSETS_URL .'js/jquery-3.2.1.min.js'; ?>"></script>
<script src="<?php echo ASSETS_URL . 'js/bootstrap.js'; ?>"></script>
<script src="<?php echo ASSETS_URL . 'js/jquery.dataTables.min.js'; ?>"></script>
<script src="<?php echo ASSETS_URL . 'js/dataTables.bootstrap.min.js'; ?>"></script>
<script src="<?php echo ASSETS_URL . 'js/jquery-sortable.js'; ?>"></script>
<script src="<?php echo ADMIN_URL . 'js/adminUI.js'; ?>"></script>
<script>
	var j3 = $.noConflict(true);
</script>
<script>
	j3(function(){

		j3('#table-users').DataTable({
			"order" : [[0,'desc']]
		});

		j3("#table-menu").DataTable({
			"order" : [[0, 'desc']]
		});

		j3("#table-banner").DataTable({
			"order" : [[0, 'desc']]
		});
    
    	j3("#table-cuaca").DataTable({
			"order" : [[0, 'desc']]
		});
    
        


		var profilTrigger = document.getElementById("profilTrigger");
		var imgInput = document.getElementsByClassName('imgInput')[0];
		if(profilTrigger != null){
			profilTrigger.addEventListener('click', function(e){
				e.preventDefault();
				console.log(imgInput);
				imgInput.click();
			});	
		}
		
		if(imgInput != null){
			imgInput.addEventListener('change', function(){
				var reader = new FileReader();
			    reader.onload = function(e) {
			    	profilTrigger.innerHTML = "<img src='" + e.target.result +"' class='img-responsive'>";
			    }
			    reader.readAsDataURL(this.files[0]);
			});	
		}

	});

    function responsive_filemanager_callback(field_id){
		var url=$('#'+field_id).val();
	}
</script>
<script>
	
</script>
</body>
</html>
<?php 
	session_start();
	require_once '../gz-includes/class.database.php';
	require_once '../config.php';
	$db = new database;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Selamat Datang</title>
	<link rel="stylesheet" href="<?php echo ADMIN_URL . 'css/login.css'; ?>">
</head>
<body>

	<div class="wrapper">
		<div class="login-box">
			<div class="login-side login-side-bg"></div>
			<div class="login-side">
				<div class="login-header">
					<h3 class="login-title">Login</h3>
					<span>silahkan login untuk memulai</span>
				</div>

				<div class="login-body">
					<form action="" method="POST">
						<div class="form-control">
							<input type="text" class="form-element" name="username" autocomplete="off" placeholder="Username">
						</div>
						<div class="form-control">
							<input type="password" class="form-element" name="password" autocomplete="off" placeholder="Password">
						</div>

						<button type="submit" name="login" class="btn-login">Login</button>
					</form>
				</div>

				<div class="login-footer">
					
				</div>	
			</div>
			
		</div>
	</div>
	
</body>
</html>

<?php

	if(isset($_POST['login'])){

		if(!empty($_POST['username']) and !empty($_POST['password'])){
			print_r($_POST);
			$username = $db->esc_str($_POST['username']);
			$password = md5($db->esc_str($_POST['password']));

			$query_str = "SELECT username, password, role_name, priority 
							FROM users JOIN role ON role.id_role=users.id_role 
							WHERE username='$username' AND password='$password' AND blokir='N'";
			$query = $db->query($query_str);
			$rows = $query->num_rows;
			echo $rows;
			if($rows == 1){
				$data = $query->fetch_array();
				if($data['username'] == $username AND $data['password'] == $password){
					$_SESSION['username'] = $data['username'];
					$_SESSION['level'] = $data['role_name'];
					$_SESSION['priority'] = $data['priority'];
					$_SESSION['login']	= 1;
					header('location: dashboard.php' );
				} 	
			}	
		}	
	}

 ?>
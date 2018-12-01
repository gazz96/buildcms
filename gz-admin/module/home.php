	<?php 

function home(){
	global $db;

	$all_posts = $db->query("SELECT * FROM berita")->num_rows;
	$all_kategori = $db->query("SELECT * FROM kategori")->num_rows;
	$all_menu = $db->query("SELECT * FROM mainmenu")->num_rows;
	$all_widget = $db->query("SELECT * FROM widget")->num_rows;
	?>
	<div class="module-header">
		<h3 class="module-title">
			Selamat Datang
		</h3>
	</div>
	<div class="module-body">
		<div class="row">
			<div class="col-md-3">
				<div class="box">
					<div class="box-icon">
						<i class="fa fa-pencil"></i>
					</div>
					<div class="box-header">
						<span class="box-title">Posts</span>
						<span class="number"><?php echo $all_posts; ?></span>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="box">
					<div class="box-icon">
						<i class="fa fa-navicon"></i>
					</div>
					<div class="box-header">
						<span class="box-title">Menu</span>
						<span class="number"><?php echo $all_menu; ?></span>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="box">
					<div class="box-icon">
						<i class="fa fa-list"></i>
					</div>
					<div class="box-header">
						<span class="box-title">Kategori</span>
						<span class="number"><?php echo $all_kategori; ?></span>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="box">
					<div class="box-icon">
						<i class="fa fa-laptop"></i>
					</div>
					<div class="box-header">
						<span class="box-title">Widget</span>
						<span class="number"><?php echo $all_widget; ?></span>
					</div>
				</div>
			</div>
		</div>	

		<div class="row">
			<div class="col-md-12">
				<canvas id="chart" width="400px" height="125px" style="margin-top: 20px"></canvas>
			</div>
		</div>
	</div>
	<?php

		$query_statistik = "SELECT year(tanggal) tahun, monthname(tanggal) bulan, count(*) pengunjung FROM statistik WHERE year(tanggal)='" . date('Y') . "' GROUP BY bulan";
		$data = $db->query($query_statistik);
		$tahun = array();
		$nilai = array();
		//print_r($data);
		while($d = $data->fetch_array()) {
			$nilai[] = $d['pengunjung'];
		}
		$nilai = implode($nilai, ',');
		//echo $nilai;
	 ?>
	<!-- <script>
		var chart = document.getElementById('chart');
		var statsChart = new Chart(chart,{
			type :  'line',
			data : {
				labels : ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Aug','Sep','Okt','Nov','Des'],
				datasets : [{
					label : 'Pengunjung',
					data : [0, <?php echo $nilai; ?>],
					backgroundColor : [
						'rgba(86,117,189,0.3)',
					],
					borderColor : [
						'rgba(86,117,189,1)',
					]
				}] 
			}
		});
	</script> -->
	
	<?php 
}
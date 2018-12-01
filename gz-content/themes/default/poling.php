<div class="row">
	<div class="col-md-8">

	<?php 
		if(isset($_POST['poling'])){
			$pilihan = $db->esc_str($_POST['pilihan']);
			$query_str = "UPDATE poling SET rating=rating+1 WHERE id_poling='{$pilihan}' LIMIT 1";
			$query = $db->query($query_str);
			$pilihan = '';
		} 
		unset($_POST);
		$query_str = "SELECT * FROM poling ORDER by status DESC";
		$query = $db->query($query_str);
	?>
	<h3>Hasil Voting</h3>
	<table class="table table-bordered">
		<tr>
			<th>Pilihan</th>
			<th>Rating</th>
		</tr>
	
	<?php 
		while($data = $query->fetch_array()){
			if($data['status'] == "Jawaban"){
				?>
				<tr>
					<td><?php echo $data['pilihan']; ?></td>
					<td><?php echo $data['rating']; ?></td>
				</tr>
				<?php 
			}
		}
	?>
	</table>





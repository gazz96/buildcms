<div class="row">
	<div class="col-md-6">
		<div id="peta">
			<?php echo get_settings('peta'); ?>
		</div>
		<br>
		<div id="kontak">
			<h3>Alamat & Peta Lokasi</h3>
			<div>
				<?php echo get_settings('alamat'); ?>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<form action="" method="POST">
			
			<div class="form-group">
				<label>Nama</label>
				<input type="text" name="nama" class="form-control">
			</div>

			<div class="form-group">
				<label>Email</label>
				<input type="email" name="nama" class="form-control">
			</div>

			<div class="form-group">
				<label>Website</label>
				<input type="text" name="nama" class="form-control">
			</div>

			<div class="form-group">
				<label>Pesan</label>
				<textarea name="pesan" class="form-control" rows="5"></textarea>
			</div>
			<button class="btn btn-primary">Kirim</button>
		</form>
	</div>
</div>
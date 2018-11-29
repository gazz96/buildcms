<?php 

function add_galeri(){
	global $db;
	global $library;

	$library->add_rule('jdl_album', 'Judul Album', array('require'));
	$library->add_rule('aktif', 'Status', array('require'));
	if(isset($_POST['tambah'])){
		if($library->run()){
			$jdl_album  = $library->getPost('jdl_album');
			$slug_album = slug($jdl_album);
			$aktif 			= $library->getPost('aktif');
			$objects = array(
				'jdl_album' => $jdl_album,
				'slug_album' => slug($jdl_album),
				'aktif'			=> $aktif
			);
			$save = $db->save("album", $objects);
			if($save){
				$library->message = "Berhasil menambahkan data";
				$library->alert_class = "alert-success";
			}
			else{
				$library->message = "Gagal menambahkan data";
				$library->alert_class = "alert-warning";
			}
		}else{
			$library->message = "Data tidak boleh kosong";
			$library->alert_class = "alert-warning";
		}
	}

	?>
	
	<div class="module-header">
		<?php $library->alert(); ?>
		<div id="message-wrapper"></div>
		<h3 class="module-title">Tambah Galeri</h3> 
		
	</div>

	<div class="module-body">
		<form action="<?php echo BASE_URL . 'gz-admin/ajax/galeri.ajax.php'; ?>" method="POST" enctype="multipart/form-data" id=form-galeri>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label for="">Album</label>
						<select name="id_album" id="" class="form-control">
							<option value="">Pilih</option>
							<?php 

								$query_album = "SELECT * FROM album WHERE aktif='Y'";
								$query = $db->query($query_album);
								while($data = $query->fetch_array()){
							?>
								<option value="<?php echo $data['id_album']; ?>"><?php echo $data['jdl_album'] ?></option>
							<?php } ?>		
						</select>
					</div>
					<div id="input-wrapper">
						<div id="input-galery">
							<div class="form-group">
								<label for="">URL Gambar</label>
							
								<div class="input-group">
									<input type="text" name="jdl_gallery[]" class="form-control input-galeri" id="jdl_galleri_1" readonly="">
									<div class="input-group-addon" ><?php echo fileManager(2,'jdl_galleri_1'); ?></div>
								</div>
							</div>

							<div class="form-group">
								<label for="">Deskripsi</label>
								<textarea name="keterangan[]" id="" rows="5" class="form-control"></textarea>
							</div>
						</div>
					</div>
					<button id="add-input-galeri" class="btn btn-primary"><span class="fa fa-plus"></span></button>
				</div>
				<div class="col-md-4">
					<div id="terbitkan">
						<div class="widget">
							<div class="widget-header">
								<span class="widget-title">Simpan</span>
							</div>
							<div class="widget-body">
								<div class="form-group">
									<label for="">Tips</label>
									<textarea name="" id="" cols="30" rows="10" disabled="" class="form-control">Hitung gambar yang akan anda masukkan, lalu tekan '+' sebanyak jumlah gambar dikurang 1, misal anda akan memasukan 10 gambar makan anda haruus menenekan '+' sebanyak 9 kali, apabila anda mengisi terlebih dahulu lalu menekan tombol '+' maka data yang ada akan hilang</textarea>
								</div>
							</div>
							<div class="widget-footer">
								<div class="widget-action pull-right">
									<input type="hidden" name="tambah" value="tambah"> 
									<button type="submit" class="btn-add btn-sm" id="save-galeri">Tambah Data</button>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>

				</div>
				<div class="clearfix"></div>
			</div>

		</form>
	</div>

	<?php 
}

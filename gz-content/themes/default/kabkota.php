<div class="row">
<div class="col-md-8">
<div class="post-wrapper">
	<div class="post-header" style="margin-bottom: 20px;">
		<span class="post-category">Data</span>
		<h1 class="post-title">Wilayah</h1>
	</div>

	<div class="post-content">
    	<table class="table table-bordered" id="table-pegawai">
        	<thead>
            	<tr>
                	<td>No</td>
                	<td>Wilayah</td>
                	<td>Kalaksa</td>
                	<td>Telp</td>
                	<td>Fax</td>
                	<td>Alamat</td>
                	<td>Dasar hukum</td>
            	</tr>
            </thead>
        	<tbody>
            	<?php $no = 1; while($data = $query->fetch_array()){ ?>
            	<tr>
                	<td><?php echo $no; ?></td>
                	<td><?php echo $data['nama_kab']; ?></td>
                	<td><?php echo $data['nama_kalaksa']; ?></td>
                	<td><?php echo $data['telp']; ?></td>
                	<td><?php echo $data['fax']; ?></td>
                	<td><?php echo $data['alamat']; ?></td>
                	<td><?php echo $data['dasar_hukum']; ?></td>
                
                </tr>
            	<?php $no++;} ?>
        	</tbody>
    	</table>
	</div>
</div>



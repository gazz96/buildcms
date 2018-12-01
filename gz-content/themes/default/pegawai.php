<div class="row">
	<div class="col-md-8">
		<div class="post-wrapper">
    		<div class="post-header" style="margin-bottom: 20px;">
        	<span class="post-category">Data</span>
        	<h1 class="post-title">Pegawai</h1>
    	</div>		
        	
		<div class="post-content">
    		<div class="table-responsive">
        		<table class="table table-bordered" id="table-pegawai">
            		<thead>
                		<tr>
                    		<td>No</td>
                        	<td>Nama</td>
                            <td>Jabatan</td>
                            <td>Keterangan</td>
                        </tr>
                   	</thead>
                    <tbody>
                    	<?php $no = 1; while($data = $query->fetch_array()){ ?>
                        <tr>
                        	<td><?php echo $no; ?></td>
                            <td><?php echo $data['nama']; ?></td>
                            <td><?php echo $data['jabatan']; ?></td>
                            <td><?php echo $data['keterangan']; ?></td>
                        </tr>
                            <?php $no++;} ?>
                   	</tbody>
            	</table>
        	</div>
        </div>
    </div>




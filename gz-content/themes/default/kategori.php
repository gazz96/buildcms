<?php $this->get_header(); ?>
<div class="row">
	<div class="col-md-8">
		
		<div class="archive-wrapper">
			<div class="archive-header">
				<h1 class="archive-title"><span><?php echo ucfirst( $page_name ); ?></span></h1>
			</div>
			<div class="archive-body">
				<?php if(!empty($tahun_arsip) and empty($bulan_arsip)){ ?>
				<div class="archive-years">
					<ul>
						<?php while($data = $query->fetch_array()){ ?>
							<li><a href="<?php echo BASE_URL . 'arsip/' . $data['tahun'] . '/' . $data['bulan']; ?>"><?php echo $data['nama_bulan']; ?>(<?php echo $data['publish']; ?>)</a></li>
						<?php } ?>
					</ul>
				</div>
				<?php }elseif(!empty(trim($bulan_arsip) and !empty(trim($tahun_arsip)))){ ?>
					<?php while($data = $query->fetch_array()){ ?>
							<div>
								<h3><a href="<?php echo BASE_URL . 'single/' . $data['title_slug']; ?>"><?php echo $data['berita_title']; ?></a></h3>
								<?php echo cut_post(strip_tags($data['berita_content'])); ?>
							</div>
						<?php } ?>
				<?php }else{ ?>
					<ul>
						<?php while($data = $query->fetch_array()){ ?>
							<li><a href="<?php echo BASE_URL . 'arsip/' . $data['tahun']; ?>"><?php echo $data['tahun']; ?></a></li>
						<?php } ?>
					</ul>
				<?php } ?>
			</div>
			<div class="archive-footer">
				
			</div>
		</div>
		
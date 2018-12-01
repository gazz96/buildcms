<div class="row">
<div class="col-md-8">
<div class="category-wrapper">
	<div class="category-header">
		<div class="category-title">
			<span><?php echo $nama_kategori; ?></span>
		</div>
	</div>
	<div class="category-body">
		<?php if($rows > 0){ ?>
			<?php foreach ($category_data as $category) :  ?>		
				<div class="post-wrapper">
					<div class="post-category-content">
						<div class="post-thumbnail">
                        		<?php if(!empty($category['berita_img'])){ ?>
								<img src="<?php echo getImage($category['berita_img']); ?>" alt="<?php echo $category['berita_title']; ?>" class="img-responsive">	<?php } ?>
						</div>
						<div class="post-body">
							<div class="post-header">
								<h3 class="post-title">
									<a href="<?php echo BASE_URL . 'single/' . $category['title_slug']; ?>"><?php echo $category['berita_title']; ?></a>
								</h3>
								<div class="post-meta">By <b><?php echo $category['id_author'] ?></b> -  <?php echo $category['berita_tanggal']; ?></div>
									
							</div>
							
							<div class="post-content"><?php echo substr(strip_tags($category['berita_content']),0, 300) . ' . . . '; ?></div>
						</div>
							
						<div class="footer-post">
							<a href="<?php echo BASE_URL . 'single/' . $category['title_slug']; ?>" class="read-more">Baca Selengkapnya</a>
						</div>
					</div>
				</div>

			<?php endforeach ?>
			<?php }else{ echo "<h1>data tidak ada</h1></br>"; } ?>
			<?php echo pagination($url, $start, $all_rows); ?>
	</div>
</div>
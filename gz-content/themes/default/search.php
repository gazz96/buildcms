<div class="category-wrapper">
	<div class="category-header">
		<h1 class="category-title">
			Pencarian
		</h1>
	</div>
	<div class="category-body">
		<?php if($rows > 0){ ?>
			<?php foreach ($posts as $post) :  ?>		
				<div class="post-wrapper">
					<div class="post-category-content">
						<div class="post-thumbnail">
							<img src="<?php echo getImage($post['berita_img']); ?>" alt="<?php echo $post['berita_title']; ?>" class="img-responsive">
							<span class="category-name"><?php echo $post['nama_kategori']; ?></span>
						</div>
						<div class="post-body">
							<div class="post-header">
								
								<h3 class="post-title">
									<a href="<?php echo BASE_URL . 'single/' . $post['title_slug']; ?>"><?php echo $post['berita_title']; ?></a>
								</h3>
								<div class="post-meta">By <b><?php echo $post['id_author'] ?></b> -  <?php echo $post['berita_tanggal']; ?> </div>
									
							</div>
							
							<div class="post-content"><?php echo substr(strip_tags($post['berita_content']),0, 300) . ' . . . '; ?></div>
						</div>
							
						<div class="footer-post">
							<a href="<?php echo BASE_URL . 'single/' . $post['title_slug']; ?>" class="read-more">Baca Selengkapnya</a>
						</div>
					</div>
				</div>

			<?php endforeach ?>
			<?php }else{ echo "<h1>data tidak ada</h1></br>"; } ?>
			<?php echo pagination($url, $start, $all_rows); ?>
	</div>
</div>
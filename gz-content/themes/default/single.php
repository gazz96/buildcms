<div class="row">
	<div class="col-md-8">
<div class="post-wrapper">
	<div class="post-header">
		<span class="post-category"><?php echo $single[0]['nama_kategori']; ?></span>
		<h1 class="post-title"><?php echo $single[0]['berita_title']; ?></h1>
		<div class="meta-author">
			<div class="author-left">
				<div class="author-by">By</div>
				<div class="author-name">
					<a href="javascript:void(0)"><?php echo ucfirst($single[0]['id_author']); ?></a>
				</div>
				<div class="author-line">-</div>
				<div class="post-date"><?php echo $single[0]['berita_tanggal']; ?></div>	
			</div>
			<div class="author-right">
				<div class="post-view">
					<ul class="post-view-item">
						<li><i class="fa fa-eye"></i></li>
						<li><span><?php echo $single[0]['berita_view']; ?></span></li>
					</ul>
					 
				</div>
			</div>
		</div>
		<div class="social-media">
			<div id="share-buttons">
			 
			    <!-- Facebook -->
			    <a href="http://www.facebook.com/sharer.php?u=<?php echo BASE_URL . $page_type . "/" . $single[0]['title_slug']; ?>" target="_blank" class="facebook">
			       <span class="fa fa-facebook"></span>
			    </a>
			    
			    <!-- Google+ -->
			    <a href="https://plus.google.com/share?url=<?php echo BASE_URL . $page_type . "/" . $single[0]['title_slug']; ?>" target="_blank" class="gplus">
			        <span class="fa fa-google-plus"></span>
			    </a>
			     
			    <!-- Twitter -->
			    <a href="https://twitter.com/share?url=<?php echo BASE_URL . $page_type . "/" . $single[0]['title_slug']; ?>" target="_blank" class="twitter">
			    	<span class="fa fa-twitter"></span>
			    </a>
		

			</div>
		</div>

	</div>
	
	<?php if(!empty($single[0]['berita_img'])) { ?>
	<div class="post-thumnail">
		<img class="img-responsive" src="<?php echo getImage($single[0]['berita_img']); ?>">
	</div> 
	<?php } ?>

	<div class="post-content">
		<?php echo $single[0]['berita_content']; ?>
	</div>
</div>

<div class="related-post">
	<div class="content-panel">
		<div class="panel-header panel-black">
			<h3>
				<span>Related Post</span>
			</h3>
			<div class="panel-body">
				<?php artikel_terkail($id); ?>
			</div>
		</div>	
	</div>
	
	
</div>
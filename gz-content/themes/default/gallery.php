<?php
$numOfCols = 3;
$rowCount = 0;
$bootstrapColWidth = 12 / $numOfCols;
?>
<div class="post-wrapper">
	<div class="post-header">
		<span class="post-category"><?php echo $galleries[0]['jdl_album']; ?></span>
	</div>
	
	<div class="post-thumnail">
		<div class="row">
			<?php for ($i = 0;  $i < $jlh_data;$i++){ ?>  
        	<div class="col-md-<?php echo $bootstrapColWidth; ?>">
             	<img class="img-responsive" src="<?php echo getImage($galleries[$i]['jdl_gallery']); ?>">
        	</div>
			<?php     
     				$rowCount++;
    				if($rowCount % $numOfCols == 0) echo '</div><br/><div class="row">';
				}
			?>
		</div>
	</div>
</div>

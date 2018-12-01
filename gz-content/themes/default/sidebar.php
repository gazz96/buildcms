<?php if($_SESSION['page_type'] != "kontak"){ ?>
		</div>
        <!-- BEGIN .main-content-right -->
 <!--========= SIDEBAR ========================-->
        <div class="col-md-4">
            <?php call_widget(); ?>
        	<?php getArsip('Index Berita', 'red') ?>
        	<?php getPoling('blue'); ?>
        	<?php echo getSosmed(); ?>
        	<br>
            <?php statistik(); ?>
        	
        	
        </div>
        <!--========= AKHIR SIDEBAR =================-->
    </div>
<?php }else{ ?>
	
<?php } ?>
</div>
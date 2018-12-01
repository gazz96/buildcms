<!-- 

Credits by Mastahweb
Name : Bagas Topati
WA : 0815 3496 2418
FB : https://www.facebook.com/bgas.kurosaki
Email :  gazkintzz96@gmail.com

-->
<?php global $db; $template->get_header(); ?>

<div class="row">
    <div class="col-md-8">
        <div class="owl-carousel owl-theme">
          <?php echo getSlider(); ?>
        </div>   
    </div>
    <div class="col-md-4">
        <?php echo get_settings('banner_samping'); ?>
    </div>
</div>
<div class="row">
    <br>
    <div class="col-md-1"></div>
    <div class="col-md-5">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Cuaca</h3>
            </div>
            <div class="panel-body">
                 <a href="<?php echo BASE_URL . 'cuaca'; ?>">
                        <div class="cuaca-wrapper" style="background: #bfbfbf;color: #FFF;height: 206px;display: inline-block; width: 100%; vertical-align: middle;text-align: center;">
                           		<?php
									$query_str = "SELECT * FROM cuaca WHERE tanggal_prediksi='" . date('Y-m-d') . "'";
									$query = $db->query($query_str);
									$cuaca = $query->fetch_array();
                        		?>
                                <div class="row">
  
                                    <div class="col-md-12 text-center">
                                    	<h1>Cuaca hari ini</h1>
                                    	<h3><?php echo $cuaca['tanggal_prediksi']; ?></h3>
                                        <h3>
                                        	<?php
												$currentTime = time() + 3600;
												if( ((int) date('H' , $currentTime) >= 5) and ((int) date('H' , $currentTime)<= 10)) {
                                                	echo ucfirst($cuaca['cuaca']);
                                                }else if(((int) date('H' , $currentTime) > 10) and ((int) date('H' , $currentTime) <= 18)){
                                                	echo ucfirst($cuaca['siang']);
                                                }else if(((int) date('H' , $currentTime) > 18) and ((int) date('H' , $currentTime )<= 24)){
													echo ucfirst($cuaca['malam']);
                                                }else if(((int) date('H' , $currentTime) >= 0) and ((int) date('H' , $currentTime )< 5)){
													echo ucfirst($cuaca['dini_hari']);
                                                }
											?> 
                                    	</h3>
                                        <p><?php echo  'suhu : ' . $cuaca['suhu']  . '&deg' . ' Kemlembapan : ' . $cuaca['kelembapan'] ?> </p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                           
                        </div>
                     </a>      
            </div>
        </div>
       
    </div>
    <div class="col-md-5">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Peringatan Dini</h3>
            </div>
            <div class="panel-body">
               <marquee onmouseover="this.stop()" onmouseout="this.start()" scrollamount="3" direction="up" width="50%" height="200" align="center" behavior=”alternate”><?php echo get_settings('alert'); ?></marquee>
            </div>
        </div>
    </div>
    <div class="col-md-1"></div>
</div>
<?php if($_SESSION['page_type'] == "kontak"){ $col = "12"; }else{ $col = "8";} ?>
<div class="col-md-<?php echo $col; ?>">
    <div class="main-content-split">
        <div class="row">
            <div class="col-md-12">
                <div class="content-panel">
                    <div class="panel-header panel-red">
                        <h3><span>Berita Terbaru</span></h3>
                        <div class="top-right"><a href="<?php echo BASE_URL . 'category/all'; ?>">LIHAT SEMUA BERITA</a>
                        </div>
                    </div>
                    <div class="panel-content">
                        <?php getRecentPost(); ?>
                    </div>
                    <!-- END .content-panel -->
                </div>        
            </div>
        </div>
        
        
        <div class="row">
            <!-- BEGIN .content-panel -->
            <div class="col-md-12">
        
                <?php echo get_settings('peta_bencana') ?>  
            </div>
        </div>
        <div class="clear-float"></div>
     
       <?php getGaleri(10); ?>
    </div>
    <!-- END .main-content-left -->

        
 

<?php $template->get_sidebar(); ?>

<?php $template->get_footer(); ?>
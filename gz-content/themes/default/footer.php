                               <!--========= AKHIR KONTEN =================-->
                                <div class="clear-float"></div>
                                <!-- END .wrapper -->
                            </div>
                            <!-- BEGIN .content -->
                        </div>
                        <div class="footer">

                            <!-- BEGIN .wrapper -->
                            <div class="wrapper">


                                <!-- BEGIN .breaking-news -->
                                <!-- BEGIN .footer-content -->
                                <div class="footer-content">

                                    <div class="footer-menu">
                                        <ul>

                                        </ul>
                                    </div>


                                    <!-- END .footer-content -->
                                </div>


                                <!-- END .wrapper -->
                            </div>
                            <div class="bawah">

                                <div class="left"> | Peta Situs
                                    <br>

                                </div>



                                <div class="clear-float"></div>

                            </div>

                            <!-- END .footer -->
                        </div>

                        <!-- END .boxed -->
                    </div>
                    <!-- <script type="text/javascript" src="<?php echo $template->get_directory_uri(); ?>/js/orange-themes-responsive.js"></script> -->				   <script type="text/javascript" src="<?php echo ASSETS_URL; ?>js/bootstrap.js"></script>
                    <script src="<?php echo ASSETS_URL . '/js/owl.carousel.min.js'; ?>"></script>
                    <script type="text/javascript" src="<?php echo $template->get_directory_uri(); ?>/js/scripts.js"></script>
                    <script type="text/javascript" src="<?php echo $template->get_directory_uri(); ?>/js/jquery-ui.min.js"></script>
                    <!-- <script src="$template->get_directory_uri(); ?>/js/jquery.totemticker.js" type="text/javascript"></script>
                    <script src="$template->get_directory_uri(); ?>/js/jquery.totemticker.min.js" type="text/javascript"></script> -->
					<script src="<?php echo ASSETS_URL . 'js/jquery.dataTables.min.js'; ?>"></script>
					<script src="<?php echo ASSETS_URL . 'js/dataTables.bootstrap.min.js'; ?>"></script>
                   	<script>
                    	var styleCss = document.getElementById("styleCss");
                    	if(window.innerWidth <= 1100){
                        	styleCss.href = '<?php echo $template->get_directory_uri(); ?>/css/phonevertical.css';
                        }
                    	window.addEventListener('resize', function(){
                        	if(window.innerWidth <= 1100){
                            	styleCss.href = '<?php echo $template->get_directory_uri(); ?>/css/phonevertical.css';
                            }else{
                            	styleCss.href = '';
                            }
                        });
                    
                    	$("#table-pegawai").DataTable();
					</script>

                    <!-- END body -->
</body>
<!-- END html -->

</html>
   
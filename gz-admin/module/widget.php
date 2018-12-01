<?php 

function widget_data () {
	/*
	 * Page to manage widget
	 * 
	 */
	
	// parse db variable
	global $db;

	// initialize
	$register_widget = [];

	// get current active themes
	$template_query_str = "SELECT judul FROM templates WHERE aktif='Y' LIMIT 1";
	$template_query = $db->query( $template_query_str )->fetch_assoc();
	$theme = isset( $template_query['judul'] ) ? $template_query['judul'] : false;

	// require function in theme
	$func_path = '../' . THEME_PATH . $theme . '/function.php';

	// check if function.php exist
	if( file_exists( $func_path )) {
		require_once $func_path;
	} 

	?>

	<div class="module-header">
		<h3 class="module-title">Widget</h3> 
	</div>
	
	<div class="module-body">
		<?php 
			$mainwidget_query = "SELECT * FROM widget WHERE widget_area='main'";
			$datamainwidget = $db->get_results($mainwidget_query);
			//print_r($datamainwidget);
		 ?>
		<script>
			 $('.btn-add-widget').click(function(e) {
			 	e.preventDefault();
			 	let widgetID = $( this ).data( 'widget' );
			 	console.log( widgetID );
			 });
		</script>
		<div class="widget-wrapper" id="widget-wrapper">
			<div class="row">
				<div class="col-md-8">
					<?php foreach( $register_widget_item as $rwi) { ?>
						<div class="mini-widget widget-<?php echo $rwi['id']; ?>">
							<div class="widget-header">
								<span class="widget-title"><?php echo $rwi['title']; ?></span>
							</div>
							<div class="widget-body" >
								<?php echo $rwi['desc'] ?>
							</div>
							<div class="action">
								<select name="select_widget_place" class="form-control">
									<option value="">Pilih</option>
									<?php foreach ($register_widget as $rw ) { ?>
										<option value="<?php echo $rw['id']; ?>"><?php echo $rw['title']; ?></option>
									<?php } ?>
								</select>
								<button class="btn btn-primary btn-sm btn-block btn-add-widget" data-widget="<?php echo $rwi['id']; ?>">Add</button>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="col-md-4">
					<?php foreach ($register_widget as $rw ) { ?>
						<div class="widget widget-<?php echo $rw['id']; ?>">
							<div class="widget-header">
								<h3 class="widget-title"><?php echo $rw['title']; ?></h3>
							</div>
							<div class="widget-body" style="min-height: 100px">
							
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>


<?php }

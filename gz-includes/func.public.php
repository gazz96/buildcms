<?php 

function get_menu($area = "main", $ulClass = "", $submenuClass = "sub-menu", $openTag='<span>', $closeTag ="</span>"){
	global $db;
	$link = "";
	$menu = "";
	$menu .= "<ul class='{$ulClass}'>";
	$query_mainmenu = "SELECT * FROM mainmenu WHERE area='{$area}' AND id_parent='' AND aktif='Y' ORDER BY position ASC";
	$query = $db->query($query_mainmenu);
	while($mainmenu = $query->fetch_array()){
		$menu .= "<li>
					<a href='" . BASE_URL . $mainmenu['link'] . "'>{$openTag}" . $mainmenu['nama_menu'] . "{$closeTag}</a>";
					$query_submenu = "SELECT * FROM mainmenu WHERE area='{$area}' AND id_parent='" . $mainmenu['id_main'] . "' AND aktif='Y'";
					$query_sub = $db->query($query_submenu);
					if($query_sub->num_rows > 0){
						$menu .= "<ul class='{$submenuClass}'>";
							while($submenu = $query_sub->fetch_array()){
								$menu .= "<li><a href='" . BASE_URL . $submenu['link'] . "'>{$openTag}" . $submenu['nama_menu'] . "{$closeTag}</a>"; 

								$query_submenu_2 = "SELECT * FROM mainmenu WHERE area='{$area}' AND id_parent='" . $submenu['id_main'] . "' AND aktif='Y'";
								$query_sub_2 = $db->query($query_submenu_2);
								if($query_sub_2->num_rows > 0){
									$menu .= "<ul class='{$submenuClass}'>";
										while($submenu_2 = $query_sub_2->fetch_array()){
											$menu .= "<li><a href='" . BASE_URL . $submenu_2['link'] . "'>{$openTag}" . $submenu_2['nama_menu'] . "{$closeTag}</a>"; 

												$query_submenu_3 = "SELECT * FROM mainmenu WHERE area='{$area}' AND id_parent='" . $submenu_2['id_main'] . "' AND aktif='Y'";
												$query_sub_3 = $db->query($query_submenu_3);
												if($query_sub_3->num_rows > 0){
													$menu .= "<ul class='{$submenuClass}'>";
														while($submenu_3 = $query_sub_3->fetch_array()){
															$menu .= "<li><a href='" . BASE_URL . $submenu_3['link'] . "'>{$openTag}" . $submenu_3['nama_menu'] . "{$closeTag}</a></li>"; 
														}
													$menu .="</ul>";
												}
												$menu .="</li>";
										}
									$menu .="</ul>";
								}
								$menu .="</li>";
							}
						$menu .="</ul>";
					}
		$menu .= "</li>";
	}
	$menu .= "</ul>";
	return $menu;
}

function route($segement = 2){
	global $template;
	global $db;
	$url = $_SERVER['REQUEST_URI'];
	$explode_url = explode('/', $url);
	//print_r($explode_url);
	$start = isset($explode_url[$segement+3]) ? $explode_url[$segement+3] : 1;
	if(count($explode_url) > $segement){
		$page_type = isset($explode_url[$segement+1]) ? $explode_url[$segement+1] : false;
    	if(isset($_SESSION['page_type'])){
        	$_SESSION['page_type'] = '';
            $_SESSION['page_type'] = $page_type;
        }
		if(!empty(trim($page_type))){
			switch ($page_type) {
            	case 'peta-bencana';
            		require $template->template_fullpath() . '/peta-bencana.php';
            	break;
				case 'single':
					$id = isset($explode_url[$segement+2]) ? $db->esc_str($explode_url[$segement+2]) : false;
					//echo $id;
					$query_single = "SELECT * FROM berita JOIN kategori ON berita.id_kategori=kategori.id_kategori AND berita.berita_status='Y' AND kategori.aktif='Y' AND berita.title_slug='{$id}' LIMIT 1";
					//echo $query_single;

					$single = $db->get_results($query_single);
					$db->query("UPDATE berita SET berita_view='" . ($single[0]['berita_view']+1) . "' WHERE title_slug='{$id}'");
					$jlh_data = count($single);
					/*var_dump($single);*/
					if(file_exists($template->template_fullpath() . '/single.php')){
						if($jlh_data > 0){
							require_once $template->template_fullpath() . '/single.php';
						}
					}
					break;
				case 'category':
					$limit = 5;
					$step = 5;
					if($start <= 1){
						$step = 0;
					}elseif($start > 1){
						$step = $step * ($start-1);
					}
					//echo $limit . ', ' . $step;
					$id = isset($explode_url[$segement+2]) ? $db->esc_str($explode_url[$segement+2]) : false;

					$all_category = "SELECT * FROM berita JOIN kategori ON berita.id_kategori=kategori.id_kategori AND berita.berita_status='Y' and kategori.aktif='Y' AND kategori.slug_kategori='{$id}' ORDER BY berita_ntanggal DESC ";

					if($id == "all"){
						$all_category = "SELECT * FROM kateogri WHERE status='Y' ";
					}
					$query_category = $all_category . " LIMIT {$step}, {$limit}";
					//echo $query_category;

					if($id == "all"){
						if(file_exists($template->template_fullpath() . '/category.php')){
							require_once $template->template_fullpath() . '/category.php';
						}
					}else{
						$category_data = $db->get_results($query_category);
						$rows = count($category_data);
						$nama_kategori = $db->get_cat_name($id);
						$all_rows = count($db->get_results($all_category));
						$url = BASE_URL . $page_type . '/' . $id . '/';
						if(file_exists($template->template_fullpath() . '/page.php')){
							require_once $template->template_fullpath() . '/page.php';
						}
					}
					
					break;
				case 'arsip':
					$tahun_arsip = isset($explode_url[$segement+2]) ? $db->esc_str($explode_url[$segement+2]) : false;
					$bulan_arsip = isset($explode_url[$segement+3]) ? $db->esc_str($explode_url[$segement+3]) : false;
            		//print_r($explode_url);
					//echo $bulan_arsip;
            		//echo $tahub_arsip;
					if(empty(trim($tahun_arsip)) and empty(trim($bulan_arsip))){
						$query_str = "SELECT year(berita_ntanggal) as tahun, monthname(berita_ntanggal) as nama_bulan, count(*) as publish FROM berita GROUP BY tahun";
						$query = $db->query($query_str);
						
					}elseif(!empty(trim($tahun_arsip)) and !empty(trim($bulan_arsip))){
						$query_str = "SELECT berita_title, title_slug, berita_content, year(berita_ntanggal) as tahun, month(berita_ntanggal) as bulan, monthname(berita_ntanggal) as nama_bulan FROM berita WHERE year(berita_ntanggal) = '" . $tahun_arsip ."' AND month(berita_ntanggal)='" . $bulan_arsip ."'";
						$query = $db->query($query_str);
					}elseif(!empty($tahun_arsip) and empty($bulan_arsip)){
						$query_str = "SELECT year(berita_ntanggal) as tahun, month(berita_ntanggal) as bulan, monthname(berita_ntanggal) as nama_bulan, count(*) as publish FROM berita WHERE year(berita_ntanggal) = '" . $tahun_arsip ."' GROUP by month(berita_ntanggal)";
						$query = $db->query($query_str);
					}
					//print_r($archive_years);
					if(file_exists($template->template_fullpath() . '/archived.php')){
						require_once $template->template_fullpath() . '/archived.php';
					}
					break;
				case 'search':
					$keyword = isset($_GET['s']) ? $db->esc_str($_GET['s']) : '';
					$start = isset($explode_url[$segement+1]) ? $explode_url[$segement+1] : 1;
					$limit = 5;
					$step = 5;
					if($start <= 1){
						$step = 0;
					}elseif($start > 1){
						$step = $step * ($start-1);
					}
					//echo $limit . ', ' . $step;
					$id = isset($explode_url[$segement+1]) ? $db->esc_str($explode_url[$segement+1]) : false;
					
					$all_data = "SELECT * FROM berita JOIN kategori ON berita.id_kategori=kategori.id_kategori AND berita.berita_status='Y' AND kategori.aktif='Y' "; 
					if(!empty(trim($keyword))){
						$all_data .= " WHERE berita.berita_title LIKE '%{$keyword}%' or kategori.nama_kategori LIKE '%{$keyword}%' ORDER BY berita_ntanggal DESC ";
					}
					

					if($id == "all"){
						$all_data = "SELECT * FROM berita WHERE status='Y' ";
					}

					$query_posts = $all_data . " LIMIT {$step}, {$limit}";
					if(file_exists($template->template_fullpath() . '/search.php')){
						$posts = $db->get_results($query_posts);
						$rows = count($posts);	
						$all_rows = count($db->get_results($all_data));
						$url = BASE_URL . $page_type . '/';
						require_once $template->template_fullpath() . '/search.php';
					}

					break;
				case 'gallery':
					$id = isset($explode_url[$segement+2]) ? $db->esc_str($explode_url[$segement+2]) : false;
					$all_gallery = "SELECT * FROM album JOIN gallery ON album.id_album=gallery.id_album WHERE slug_album='{$id}' AND aktif='Y'";

					$galleries = $db->get_results($all_gallery);
					$jlh_data = count($galleries);
					if($jlh_data > 0){
						if(file_exists($template->template_fullpath() . '/gallery.php')){
							require_once $template->template_fullpath() . '/gallery.php';
						}
					}
					break;
            	case 'pegawai';
            		$query_str = "SELECT * FROM pegawai ORDER BY id_pegawai DESC";
            		$query = $db->query($query_str);
            		$jlh_data = $query->num_rows;
                    if($jlh_data > 0){
						if(file_exists($template->template_fullpath() . '/pegawai.php')){
							require_once $template->template_fullpath() . '/pegawai.php';
						}
					}
            		break;
            	case 'kabkota';
            		$query_str = "SELECT * FROM kab_kota ORDER BY id_kab_kota DESC";
            		$query = $db->query($query_str);
            		$jlh_data = $query->num_rows;
                    if($jlh_data > 0){
						if(file_exists($template->template_fullpath() . '/kabkota.php')){
							require_once $template->template_fullpath() . '/kabkota.php';
						}
					}
            		break;
            	case 'kontak':
					if(file_exists($template->template_fullpath() . '/kontak.php')){
						require_once $template->template_fullpath() . '/kontak.php';
					}
					break;
				case 'agenda':
					$query_str = "SELECT * FROM agenda";
					$data = $db->get_results($query_str);
					if(file_exists($template->template_fullpath() . '/agenda.php')){
						require_once $template->template_fullpath() . '/agenda.php';
					}
					break;
				case 'cuaca':
					if(file_exists($template->template_fullpath() . '/cuaca.php')){
						require_once $template->template_fullpath() . '/cuaca.php';
					}
					break;
				default:
					require_once $template->template_fullpath() . '/home.php';
					break;
			}
		}else{
			require_once $template->template_fullpath() . '/home.php';
		}

	}
	elseif(count($explode_url) == $segement){
		require_once $template->template_fullpath() . '/home.php';
	}
	
}

function artikel_terkail($id){
	global $db;
	// batas threshold 40%
    $threshold = 40;
    // jumlah maksimum artikel terkait yg ditampilkan 3 buah
    $maksArtikel = 3;

    // array yang nantinya diisi judul artikel terkait
    $listArtikel = Array();

    // membaca judul artikel dari ID tertentu (ID artikel acuan)
    // judul ini nanti akan dicek kemiripannya dengan artikel yang lain
    $query = "SELECT berita_title FROM berita WHERE title_slug = '$id'";
    $hasil = $db->query($query);
    $data  = $hasil->fetch_array();
    $judul = $data['berita_title'];

    // membaca semua data artikel selain ID artikel acuan
    $query = "SELECT id_berita, berita_title, title_slug FROM berita WHERE title_slug <> '$id'";
    $hasil = $db->query($query);
    while ($data = $hasil->fetch_array())
    {
        // cek similaritas judul artikel acuan dengan judul artikel lainnya
        similar_text($judul, $data['berita_title'], $percent);
        if ($percent >= $threshold)
        {
            // jika prosentase kemiripan judul di atas threshold
            if (count($listArtikel) <= $maksArtikel)
            {
               // jika jumlah artikel belum sampai batas maksimum, tambahkan ke dalam array
               $listArtikel[] = "<li><a href='" . BASE_URL . 'single/' . $data['title_slug'] . "'>".$data['berita_title']."</a></li>";
            }
        }
    } 

    // jika array listartikel tidak kosong, tampilkan listnya
    // jika kosong, maka tampilkan 'tidak ada artikel terkait'
    if (count($listArtikel) > 0)
    {
        echo "<ul>";
        for ($i=0; $i<=count($listArtikel)-1; $i++)
        {
            echo $listArtikel[$i];
        }
        echo "</ul>";
    }
    else echo "<p>Tidak ada artikel terkait</p>";
}

function cut_post($str = "", $number = 200){
	return substr(strip_tags($str, 0, $number) . '...');
}

function pagination($url, $number, $total_rows, $wrapper_class = "pagination-wrapper"){
	global $db;
	$keyword = isset($_GET['s']) ? '?s=' . $db->esc_str($_GET['s']) : '';
	$total_rows = $total_rows + 1;
	$pagination = "<div class={$wrapper_class}>";
		$pagination .= "<ul class='pagination'>";
		$limit = 5;
		$links = 7;
		$all_page = ceil($total_rows/$limit);
		$begin = ( ( $number - $links ) > 0 ) ? $number - $links : 1;
		$end = ( ( $number + $links ) < $all_page ) ? $number + $links : $all_page;
		
		$i = $begin;

		while($i < $end){
			if($i == $number){
				$active = "active";
			}
			else{
				$active = "";
			}	
			$pagination .= "<li class='{$active}'><a href='$url$i/$keyword'>{$i}</a></li>";
			$i++;
		}
		$j = $number;	
		$pagination .= "</ul>";
	$pagination .= "</div>";
	return $pagination;
}

function getSlider(){
	global $db;
	$query_str = "SELECT * FROM berita WHERE berita_status='Y' ORDER BY berita_ntanggal DESC LIMIT 5";
	$data = $db->get_results($query_str);
	$slider = "";
	//var_dump($data);
	for ($i=0; $i < count($data); $i++) { 
		?>
			<div>
				<a href="<?php echo BASE_URL . 'single/' . $data[$i]['title_slug']; ?>">
					<img src="<?php echo getImage($data[$i]['berita_img']); ?>" alt="" width="600px" height="400px">
				</a>
			</div>
		<?php 
	}
}

function getRecentPost(){
	global $db;
	$query_str = "SELECT * FROM berita WHERE berita_status='Y' ORDER BY berita_ntanggal DESC LIMIT 5";
	$data = $db->get_results($query_str);
	$jlh_data = count($data);
	?>
	<div class="row">
		<div class="col-md-6">
	        <div class="big-post">
	            <div class="post-thumbnail" style="background-image: url('<?php echo getImage($data[0]['berita_img']); ?>')"></div>
	            <div class="post-header">
	                <h3 class="post-title"><a href="<?php echo BASE_URL.'single/' . $data[0]['title_slug']; ?>"><?php echo $data[0]['berita_title']; ?></a></h3>
	                <div class="post-meta"></div>
	            </div>
	            <div class="post-body">
	                <?php echo cut_post($data[0]['berita_content']); ?>
	            </div>
	        </div>
	    </div>
	    <div class="col-md-6">
	    	<?php for ($i=1; $i < $jlh_data; $i++) { ?>
		        <div class="litle-post">
		            <div class="post-thumbnail" style="background-image: url('<?php echo getImage($data[$i]['berita_img']); ?>')"></div>
		            <h3 class="post-title"><a href="<?php echo BASE_URL.'single/' . $data[$i]['title_slug']; ?>"><?php echo $data[$i]['berita_title']; ?></a></h3>
		            <div class="post-meta"><?php echo $data[$i]['berita_tanggal']; ?></div>
		        </div>
			<?php } ?>
	    </div>
    </div>


	<?php 
}

 function getImage($str){
	$str = trim($str);
	if(!empty($str)){
		return $str;	
	}
	return ASSETS_URL . 'images/placeholder.png';
}

function setWidget($id, $nama, $type){
	global $db;
	$query_str = "";
	if($type == "kategori"){
	$query_str = "SELECT * FROM widget WHERE tipe_widget='kategori'";
	}
}

function setWidgetKategori($id='1', $color = 'black', $layout='blog', $allpage = true){
	global $db;
	$query_str = "SELECT * FROM widget JOIN berita ON widget.id_kategori=berita.id_kategori JOIN kategori ON widget.id_kategori=kategori.id_kategori WHERE widget.id_widget='{$id}' AND kategori.aktif='Y' AND berita.berita_status='Y' ORDER BY berita.berita_ntanggal DESC LIMIT 5";
	$data = $db->get_results($query_str);
	$jlh_data = count($data);
	if($jlh_data == 0){
		return '';	
	}
	?>

		<div class="content-panel">
	        <div class="panel-header panel-<?php echo $color ?>">
	            <h3><span><?php echo ucfirst($data[0]['nama_kategori']); ?></span></h3>
	            <div class="top-right">
	            	<?php if($allpage == true){ ?>
	            	<a href="<?php echo BASE_URL . 'category/' . $data[0]['slug_kategori']; ?>">
	            	Lihat Semua <?php echo ucfirst($data[0]['nama_kategori']); ?></a>
	            	<?php }?>
	            </div>
	        </div>
	       
	        <div class="panel-content">
	        	<?php if($layout == 'blog'){ ?>
		            <div class="article-big-block">
		                <div class='article-photo'>
		                    <span class='image-hover'>
			                    <span class='drop-icons'>
				                    <span class='icon-block'><a href='<?php echo BASE_URL.'single/' . $data[0]['title_slug'] ?>' title='<?php echo $data[0]['berita_title']; ?>' class='icon-link legatus-tooltip'><div class="fa fa-chain"></div></a>
				                    </span>
			                    </span>
			                    <a href='<?php echo BASE_URL.'single/' . $data[0]['title_slug'] ?>'><img src='<?php echo getImage($data[0]['berita_img']) ?>' width='330' alt='<?php echo $data[0]['berita_title']; ?>'>
			                    </a>
		                    </span>
		                </div>
		                <div class='article-header'>
		                    <h3><a href='<?php echo BASE_URL.'single/' . $data[0]['title_slug'] ?>'><?php echo strtoupper($data[0]['berita_title']); ?></a></h3>
		                </div>
		                <div class='article-content'>
		                    <?php echo cut_post($data[0]['berita_content']); ?>
		                </div>
		                <div class='article-links'>
		                    <a href='<?php echo BASE_URL.'single/' . $data[0]['title_slug'] ?>' class='article-icon-link'><span class='icon-text'></span><?php echo $data[0]['berita_view']; ?>x dibaca</a>
		                    <a class='article-icon-link'>
		                        <span class='icon-text'></span><?php echo $data[0]['berita_tanggal']; ?>
		                    </a>
		                    
		                </div>
		            </div>
		            <ul class='article-array content-category'>
		            	<?php for ($i=1; $i < $jlh_data; $i++) { ?>
			            	<li>
			            		<a href='<?php echo BASE_URL . 'single/'. $data[$i]['title_slug'] ?>'><?php echo $data[$i]['berita_title']; ?></a>
			            		<br>
			            		<a href='' class='comment-icon'><?php echo $data[$i]['berita_view']; ?>x dibaca</a>
			            		<a href='' class='comment-icon'><?php echo $data[$i]['berita_tanggal']; ?></a>
			           		</li>
		            	<?php } ?>
		            </ul>
	            <?php }elseif ($layout == 'list') { ?>
	           		<ul class="article-array content-category">
	           			<?php for($i=0; $i < $jlh_data; $i++){ ?>
							<li><a href="<?php echo BASE_URL . 'single/'. $data[$i]['title_slug']; ?>"><?php echo $data[$i]['berita_title']; ?></a></li>
	           			<?php } ?>
	           		</ul>
	            <?php } ?>
	        </div>

	    </div>
	<?php 
}

function getPopularPost($color = 'black', $layout = 'blog', $allpage = false){
	global $db;

	$query_str = "SELECT * FROM berita JOIN kategori ON berita.id_kategori=kategori.id_kategori WHERE berita.berita_status='Y' AND kategori.aktif='Y' ORDER BY berita.berita_view DESC LIMIT 5";
	$data = $db->get_results($query_str);
	$jlh_data = count($data);
	if($jlh_data == 0){
		return '';	
	}
	?>

		<div class="content-panel">
	        <div class="panel-header panel-<?php echo $color ?>">
	            <h3><span><?php echo ucfirst('Berita Populer'); ?></span></h3>
	            <div class="top-right">
	            	<?php if($allpage == true){ ?>
	            	<a href="<?php echo BASE_URL . 'category/' . $data[0]['slug_kategori']; ?>">
	            	Lihat Semua <?php echo ucfirst($data[0]['nama_kategori']); ?></a>
	            	<?php }?>
	            </div>
	        </div>
	       
	        <div class="panel-content">
	        	<?php if($layout == 'blog'){ ?>
		            <div class="article-big-block">
		                <div class='article-photo'>
		                    <span class='image-hover'>
		                    <span class='drop-icons'>
		                    <span class='icon-block'><a href='<?php echo BASE_URL.'single/' . $data[0]['title_slug'] ?>' title='<?php echo $data[0]['berita_title']; ?>' class='icon-link legatus-tooltip'><div class="fa fa-chain"></div></a>
		                    </span>
		                    </span>
		                    <a href='<?php echo BASE_URL.'single/' . $data[0]['title_slug'] ?>'><img src='<?php echo getImage($data[0]['berita_img']) ?>' width='330' alt='<?php echo $data[0]['berita_title']; ?>'>
		                    </a>
		                    </span>
		                </div>
		                <div class='article-header'>
		                    <h3><a href='<?php echo BASE_URL.'single/' . $data[0]['title_slug'] ?>'><?php echo strtoupper($data[0]['berita_title']); ?></a></h3>
		                </div>
		                <div class='article-content'>
		                    <?php echo cut_post($data[0]['berita_content']); ?>
		                </div>
		                <div class='article-links'>
		                    <a href='<?php echo BASE_URL.'single/' . $data[0]['title_slug'] ?>' class='article-icon-link'><span class='icon-text'></span><?php echo $data[0]['berita_view']; ?>x dibaca</a>
		                    <a class='article-icon-link'>
		                        <span class='icon-text'></span><?php echo $data[0]['berita_tanggal']; ?>
		                </div>
		            </div>
		            <ul class='article-array content-category'>
		            	<?php for ($i=1; $i < $jlh_data; $i++) { ?>
			            	<li>
			            		<a href='<?php echo BASE_URL . 'single/'. $data[$i]['title_slug'] ?>'><?php echo $data[$i]['berita_title']; ?></a>
			            		<br>
			            		<a href='' class='comment-icon'><?php echo $data[$i]['berita_view']; ?>x dibaca</a>
			            		<a href='' class='comment-icon'><?php echo $data[$i]['berita_tanggal']; ?></a>
			           		</li>
		            	<?php } ?>
		            </ul>
	            <?php }elseif ($layout == 'list') { ?>
	           		<ul class="article-array content-category">
	           			<?php for($i=0; $i < $jlh_data; $i++){ ?>
							<li><a href="<?php echo BASE_URL . 'single/'. $data[$i]['title_slug']; ?>"><?php echo $data[$i]['berita_title']; ?></a></li>
	           			<?php } ?>
	           		</ul>
	            <?php } ?>
	        </div>

	    </div>
	<?php 
}

function setBanner($id){
	global $db;
	$html = "";
	$query_str = "SELECT * FROM widget JOIN banner ON widget.id_banner=banner.id_banner WHERE widget.id_widget='{$id}' LIMIT 1";
	$data = $db->get_results($query_str);
	//var_dump($data);
	$jlh_data = count($data);
	if($jlh_data == 0){
		return '';	
	}
	$url = $data[0]['url'];
	$gambar = $data[0]['gambar'];
	$judul = $data[0]['judul'];

	if($data[0]['jenis'] == "gambar"){
		$html = "<a href='" . $url . "' target='_blank'><img src='" . $gambar . "' alt='" . $judul . "' class='img-responsive'></a>";
	}
	if($data[0]['jenis'] == "video"){
		$html = "<iframe id='ytplayer' type='text/html' width='100%' height='300' src='https://www.youtube.com/embed/" . $data[0]['url'] . "' frameborder='0'></iframe>";
	}
	
	return $html;
}


function setMenuSidebar($id, $color){
	global $db;
	$query_str = "SELECT * FROM widget WHERE id_widget='{$id}' AND tipe_widget='menu' LIMIT 1";
	$data = $db->get_results($query_str);
	$id_area = $data[0]['id_area'];
	$nama = $data[0]['nama_widget'];
	$query_str = "SELECT * FROM mainmenu JOIN menuarea ON mainmenu.area=menuarea.id_area WHERE mainmenu.area='{$id_area}' AND mainmenu.aktif='Y' ORDER BY mainmenu.id_main DESC";
	$data = $db->get_results($query_str);
	$jlh_data = count($data);

	?>

	<div class="content-panel">
        <div class="panel-header panel-<?php echo $color; ?>">
            <h3><span><?php echo ucfirst($nama); ?></span></h3>
        </div>
       
        <div class="panel-content">
        	<ul class="article-array content-category">
        		<?php for($i = 0; $i < $jlh_data; $i++){ ?>
        			<li><a href="<?php echo $data[$i]['link']; ?>"><?php echo $data[$i]['nama_menu']; ?></a></li>
        		<?php } ?>
        	</ul>
        </div>

    </div>
<?php
}


function getGaleri($id){
	global $db;
	$query_str = "SELECT * FROM album JOIN gallery ON album.id_album=gallery.id_album JOIN widget ON widget.id_album=album.id_album WHERE widget.id_widget='{$id}'LIMIT 5";
	$data = $db->get_results($query_str);
	$jlh_data = count($data);
	if($jlh_data == 0){
		return '';	
	}

	$nama_album = $data[0]['jdl_album'];
	$slug_album = $data[0]['slug_album'];
	$judul = $data[0]['jdl_gallery'];
	?>

	<div class="content-panel">
	    <div class="panel-header panel-black">
	        <h3><span><?php echo $nama_album; ?></span></h3>
	        <div class="top-right"><a href="<?php echo BASE_URL . 'gallery/' . $slug_album; ?>">Lihat Semua <?php echo $nama_album; ?></a>
	        </div>
	    </div>
	  	<div class="video-left">
	  		<?php for($i = 0; $i < $jlh_data; $i++){ ?>
		  		<a href="">
					<img src="<?php echo getImage($data[$i]['jdl_gallery']); ?>" style="width: 100%;" alt="<?php echo $data[$i]['jdl_gallery']; ?>">
				</a>
			<?php } ?>
	  	</div>
	</div>

	<?php 
}

function customText($id, $color=""){
	global $db;
	$query_str = "SELECT * FROM widget WHERE id_widget='{$id}'";
	$data = $db->get_results($query_str);
	$jlh_data = count($data);
	if($jlh_data == 0){
		return '';	
	}

	?>

	<div class="content-panel">
	    <div class="panel-header panel-<?php echo $color ?>">
	        <h3><span><?php echo $data[0]['nama_widget']; ?></span></h3>
	    </div>
	  	<div>
	  		<p><?php echo $data[0]['widget_content']; ?></p>
	  	</div>
	</div>

	<?php 
}

function call_widget(){
	global $db;
	$query_str = "SELECT * FROM widget WHERE widget_area='sidebar'";
	$query = $db->query($query_str);
	if($query->num_rows > 0){
		
		while ($data = $query->fetch_array()) {
			$color = array('blue', 'red', '', 'orange', 'green', 'black', 'gray');
			if($data['tipe_widget'] == "banner"){
				echo setBanner($data['id_widget']);
			}
			elseif($data['tipe_widget'] == "kategori"){
				setWidgetKategori($data['id_widget'], $color[mt_rand(0,6)], 'list', false); 
			}
			elseif($data['tipe_widget'] == "populer"){
				getPopularPost($color[mt_rand(0,6-1)]); 
			}
			elseif($data['tipe_widget'] == "menu"){
				setMenuSidebar($data['id_widget'], $color[mt_rand(0,6)]);
			}
			elseif($data['tipe_widget'] == "text"){
				customText($data['id_widget'], $color[mt_rand(0,6)]);
			}
		}
	}
	
}

function statistik(){
	global $db;
	 $ip      = $_SERVER['REMOTE_ADDR']; // Mendapatkan IP komputer user
	 $tanggal = date("Ymd"); // Mendapatkan tanggal sekarang
	 $waktu   = time(); //
	  
	 // Mencek berdasarkan IPnya, apakah user sudah pernah mengakses hari ini
	 $s = $db->query("SELECT * FROM statistik WHERE ip='$ip' AND tanggal='$tanggal'");
	 
	 // Kalau belum ada, simpan data user tersebut ke database
	 if($s->num_rows == 0){
	     $db->query("INSERT INTO statistik(ip, tanggal, hits, online) VALUES('$ip','$tanggal','1','$waktu')");
	 }
	 // Jika sudah ada, update
	 else{
	     $db->query("UPDATE statistik SET hits=hits+1, online='$waktu' WHERE ip='$ip' AND tanggal='$tanggal'");
	 }
	 
	 $pengunjung       = $db->query("SELECT * FROM statistik WHERE tanggal='$tanggal' GROUP BY ip")->num_rows; // Hitung jumlah pengunjung
	 $query_total_pengunjung  = $db->query("SELECT COUNT(hits) as counter FROM statistik")->fetch_array();
	 $totalpengunjung = $query_total_pengunjung['counter'];
	 $bataswaktu       = time() - 300;
	 $pengunjungonline = $db->query("SELECT * FROM statistik WHERE online > '$bataswaktu'")->num_rows; // hitung pengunjung online
	 $hits             = $db->query("SELECT SUM(hits) as hitstoday FROM statistik WHERE tanggal='$tanggal' GROUP BY tanggal")->fetch_assoc(); 
  	$totalhits        = $db->query("SELECT SUM(hits) as total_hits FROM statistik")->fetch_assoc(); 
	?>
		<div class="content-panel">
			<div class="panel-header panel-">
				<h3><span>Statistik</span></h3>
			</div>
			<div>
				<table class="table no-border">
					<tr>
						<td>Hari ini</td>
						<td>:</td>
						<td><?php echo $pengunjung; ?></td>
					</tr>
					<tr>
						<td>Total</td>
						<td>:</td>
						<td><?php echo $totalpengunjung ?></td>
					</tr>
					<tr>
						<td>Hits hari ini</td>
						<td>:</td>
						<td><?php echo $hits['hitstoday']; ?></td>
					</tr>
					<tr>
						<td>Total hits</td>
						<td>:</td>
						<td><?php echo $totalhits['total_hits']; ?></td>
					</tr>
					<tr>
						<td>Pengunjung online</td>
						<td>:</td>
						<td><?php echo $pengunjungonline; ?></td>
					</tr>
				</table>
			</div>
			
		</div>
	<?php 
}


function get_settings($type = ""){
	global $db;
	$query = $db->query("SELECT * from settings");
	$row = $query->num_rows;
	if($row > 0){
		$data = $query->fetch_array();
		switch ($type) {
			case 'nama':
				return $data['nama_website'];
				break;
			case 'alamat':
				return '<pre>' . $data['alamat'] . '</pre>';
				break;
			case 'desc':
				return $data['detail_website'];
				break;
			case 'content':
				return $data['content_website'];
				break;
			case 'peta':
				return $data['maps'];
				break;
			case 'peta_bencana':
				return $data['home_maps'];
				break;
			case 'alert':
				return $data['peringatan'];
				break;
			case 'wa':
				return $data['wa'];
				break;
			case 'fb':
				return $data['fb'];
				break;
			case 'ig':
				return $data['ig'];
				break;
        	case 'logo':
        		$html = "";
        		if(!empty($data['logo'])){
        			$html .= "<a href='#'><img src='" .  $data['logo'] . "'/></a>";
                }
        		return $html;
      
				break;
			case 'banner':
				return $data['banner'];
				break;
        case 'banner_samping':
        		return $data['banner_samping'];
        		break;
			default:
				return $data['nama_website'];
				break;
		}
	}
	return '';
}

function petaBencana($url = 'https://magma.vsi.esdm.go.id/dist/plugins/fpmap.html'){
	
	$data = curl_init();
  	curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
  	curl_setopt($data, CURLOPT_URL, $url);
  	/*curl_setopt($data, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");*/
  	$hasil = curl_exec($data);
	curl_close($data);
	echo $hasil;
	//$pecah = explode('<body>',$hasil);
	//var_dump($pecah);

}

function getArsip($judul = "Index Berita", $color =""){
	global $db;
	$query_str = "SELECT year(berita_ntanggal) as tahun, month(berita_ntanggal) as bulan, monthname(berita_ntanggal) as nama_bulan, count(*) as publish FROM berita WHERE year(berita_ntanggal) = '" . date('Y') ."' GROUP by month(berita_ntanggal)";
	$query = $db->query($query_str);
	//var_dump($query->fetch_array());
	?>
	<div class="content-panel">
		<div class="panel-header panel-<?php echo $color; ?>">
			<h3>
				<span><?php echo $judul; ?></span>
			</h3>
		</div>
		<div class="panel-content">
			<ul class="article-array content-category">
				<?php while($data = $query->fetch_array()){ ?>
					<li><a href="<?php echo BASE_URL . 'arsip/' . $data['tahun'] . '/' . $data['bulan']; ?>"><?php echo $data['nama_bulan']; ?> (<?php echo $data['publish']; ?>)</a></li>
				<?php } ?>
			</ul>		
		</div>
	</div>

	
	<?php 
}

function getPoling($color = ""){
	global $db;
	$query_str = "SELECT * FROM poling ORDER by status DESC";
	$query = $db->query($query_str);
	?>
	<div class="content-panel">
		<div class="panel-header panel-<?php echo $color ?>">
			<h3>
				<span>Poling</span>
			</h3>
		</div>
		<div class="panel-content">
			<form method="POST" action="<?php echo BASE_URL . 'poling'; ?>">
				<?php while($data = $query->fetch_array()){ ?>
					<?php if($data['status'] == "Pertanyaan"){ ?>
						<p><?php echo $data['pilihan']; ?></p>
					<?php }else{ ?>
						<input type="radio" name="pilihan" value="<?php echo $data['id_poling'] ?>"> <span><?php echo $data['pilihan'] ?></span><br>
					<?php } ?>
				<?php } ?><br>
				<button type="submit" name="poling" class="btn btn-sm btn-primary">Vote</button>
			</form>
		</div>
	</div>
	<?php 
}

function getSosmed(){
	?>
	<div class="sosmed">
		<ul>
			<li><a href="https://api.whatsapp.com/send?text=<?php echo urlencode(get_settings('wa')); ?>" target='_blank' style="color: #25D366;"><span class="fa fa-3x fa-whatsapp"></span></a></li>
			<li><a href="<?php echo get_settings('ig'); ?>" target='_blank' style="color: #e4405f";><span class="fa fa-3x fa-instagram"></span></a></li>
			<li><a href="<?php echo get_settings('fb'); ?>" target='_blank' style="color: #3b5999";><span class="fa fa-3x fa-facebook"></span></a></li>
		</ul>
	</div>
	<?php
}

function getPartner(){
	?>
	<div class="row">
		<div class="col-md-4">
			<img src="" class="img-responsive">
		</div>
		<div class="col-md-4" class="img-responsive">
			
		</div>
		<div class="col-md-4" class="img-responsive">
			
		</div>
	</div>
	<?php 
}


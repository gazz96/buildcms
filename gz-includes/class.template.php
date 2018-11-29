<?php 

class template extends  database{

	function template_name(){
		$query_str = "SELECT folder FROM templates WHERE aktif='Y'";
		$query = $this->mysql->query($query_str);
		$data = $query->fetch_array();
		return $data['folder'];
	}

	function template_path(){
		return 'gz-content/themes/';
	}

	function template_fullpath(){
		return $this->template_path() . $this->template_name();
	}

	function get_template(){
		global $template;
		require_once $this->template_fullpath() . '/index.php';
	}

	function get_header(){
		global $template;
		require_once $this->template_fullpath() . '/header.php';
	}

	function get_footer(){
		global $template;
		require_once $this->template_fullpath() . '/footer.php';
	}

	function get_sidebar(){
		global $template;
		require_once template_fullpath() . '/sidebar.php';
	}

	function get_directory_uri(){
		return BASE_URL . $this->template_path() . $this->template_name();
	}

	function render() {
		require_once 'template.php';
	}

	function run(){
    	return '';
    }

    function get_params( $params, $url) {
    	$results = [];
    	$i = 1;
    	if( is_array($params) ) {
    		foreach ($params as $p) {
    			$results[$p] = isset( $url[$i] ) ? $url[$i]  : false;
    			$i++;
    		}
    		
    	}else {
    		$results[$params] = isset( $url[1] ) ? $url[1]  : false;
    	}
    	return $results;
    }

    function get_query( $query ) {
    	
    }
}
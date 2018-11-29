<?php 

class routes {

	public $routes;


	function add( $routes, $params ) {
		$this->routes[$routes] = $params;
		return $this;
	}	

	function dump_routes() {
		var_dump( $this->routes );
	}

	function matches($page, $params) {
		echo $page . '/'
	}

	function params( $current_url ) {
		
	}

	function do() {

	}

}
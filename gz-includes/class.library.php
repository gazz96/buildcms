<?php 

class library{

	private $form_validation = true;
	public $field_rules;
	public $field;
	public $form_label;
	private $form_errors = array();
	private $form_value = array();
	public $message;
	public $alert_class;

	public function add_rule($fieldname= "", $label = "",$rule = array()){
		$this->form_errors[$fieldname][] = "";
		$getRule = $rule[0];
		$getField = $this->getPost($fieldname);
		$this->form_value[$fieldname] = $getField;
		switch ($getRule) {
			case 'require':
				$getField = trim($getField);
				if(empty($getField)){
					$this->insert_errors($fieldname, $label . " Tidak Boleh Kososng");
				}
				break;
			case 'min-length':
				if(strlen($getField) < $rule[1]){
					$this->insert_errors($fieldname, $label . " Kurang dari " . $rule[1] . ' karakter');
				}
				break;
			case 'max-length':
				if(strlen($getField) > $rule[1]){
					$this->insert_errors($fieldname, $label . " Panjang karakter harus lebih kecil dari " . $rule[1] . ' karakter');
				}
				break;
			default:
				# code...
				break;
		}
	}

	public function insert_errors($fieldname, $message){
		$this->form_validation = false;
		$this->form_errors[$fieldname][] = $message;
	}

	public function form_error($fieldname = ""){
		foreach ($this->form_errors[$fieldname] as $form_error) {
			echo "<p>" . $form_error ."</p>";
		}
	}

	public function form_value($str = ""){
		if($this->form_validation == true){
			return "";	
		}
		else{
			if(isset($this->form_value[$str])){
			 return $this->form_value[$str];
			}
		}
		return '';
	}

	public function run(){
		return $this->form_validation;
	}

	function getPost($str ,$else = ""){
		return isset($_POST[$str]) ? $_POST[$str] : $else;
	}

	function getFile($str ,$else = ""){
		return (isset($_FILES[$str]['name']) and !empty(trim($_FILES[$str]['name'])))	 ? $_FILES[$str]['name'] : $else;
	}

	function set_alert($messsage, $class){
		$this->message = $message;
		$this->alert_class = $class;
	}

	function alert(){
		if(!empty($this->message)){
			$html = '<div class="alert ' . $this->alert_class . '">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>' . $this->message . '</strong>
			</div>';
			echo $html;	
		}

	}

}
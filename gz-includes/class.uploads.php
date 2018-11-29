<?php 

class uploads{	

	private $upload_errors = array();
	public $upload_data = [];

	function upload_file($file = "", $settings = ['upload_path' => '../gz-content/uploads/']){
		$upload_path = $settings['upload_path'];
		if(!empty($file['tmp_name'])){
			$file['name'] = str_replace(" ", "-", $file['name']);
			$full = "../gz-content/uploads/" . $file['name'];
			$pathinfo = pathinfo("../gz-content/uploads/" . $file['name']);
			//var_dump($pathinfo);
			$i = 1;
			while(file_exists($full)){
				$full = '../' . UPLOADS_PATH . $pathinfo['filename'] . '_' . $i . '.' . $pathinfo['extension'];
				$i++;
			}
        //echo $full;
			$file['name'] = $full;
        	
			$this->upload_data['name'] = $file['name'];
			$this->upload_data['path'] 	= UPLOADS_URL . substr($full, 22,strlen($full)-22);
			$move = move_uploaded_file($file['tmp_name'], $full);
			if($move){
            	return true;
			}
			$this->upload_errors = "Gagal Mengupload File";
			//return false;
		}
		$this->upload_errors = "Pilih File";
		return false;
	}

	function upload_errors(){
		return $this->upload_errors;
	}

	function upload_data($str = ""){
		if(!empty($this->upload_data[$str])){ 
			return $this->upload_data[$str]; 
		}
    	return $this->upload_data;
	}

}
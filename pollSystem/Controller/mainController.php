<?php

class MainController extends Acontroller{
	
	
	public function insertComment() {
		echo "in contr";
		print_r($_POST);die;
		$this->loadModel("commentModel");
	}
	
	public function registerUser($registerVal) {
		$userObj = $this->loadModel('User');
		$returnValue = $userObj->register($registerVal);
		if($returnValue) {
			
		}
	}
}


?>
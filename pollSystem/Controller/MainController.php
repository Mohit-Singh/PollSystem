<?php

class MainController extends Acontroller{
	
	
	public function insertComment() {
		//echo "in contr";
		//print_r($_POST);
		//$userName=$_SESSION['username'];
		$userName="abc";
		$ob=$this->loadModel("commentModel");
		$ob->addComment($userName,$_POST['comment']);
		$commentAr=array($userName,$_POST['comment']);
		echo json_encode($commentAr);
	}
	public function getComment() {
		
		
		$ob=$this->loadModel("commentModel");
		$ob->getComments("1");
		
	}
}


?>
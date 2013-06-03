<?php
require_once 'Acontroller.php';

class mainController extends Acontroller{
	
	public function start() {
	/*	if((isset($_REQUEST['request']))&&($_REQUEST['request']=="")) {
			$this->functn();
		}*/
	}
}

$ob=new mainController();
$ob->start();
?>
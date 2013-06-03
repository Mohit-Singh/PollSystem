<?php
abstract class Acontroller
{
	function loadModel($modelName="")
	{
		include SITE_PATH .'/Model/'.$modelName . '.php';
	}
	
	function loadView($viewName="")
	{
		include SITE_PATH .'/View/'.$viewName . '.php';
	}
	function test()
	{
		echo "test pass";
		die;
	}
}
<?php

class MainController extends Acontroller{
	
	
	public function insertComment() {
		echo "in contr";
		print_r($_POST);die;
		$this->loadModel("commentModel");
		
	}
	public function login(){
	    $userName = $_POST['userName'];
	    $password = $_POST['password'];
	
	    $data['columns'] = array(
	        'username',
	        'password'
	    );
	    $data['tables'] = 'login';
	    $data['conditions'] = array(
	        array(
	            'username = "' . $userName . '"'
	        ),
	        true
	    );
	    $userObj = $this->loadModel('User');
	    $result = $userObj->login($data);
	    //print_r($result);
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // print_r($row);
            // print($password);
            // print(md5($password));
            if ($row['username'] == $userName) {
                if ($row['password'] == md5($password)) {
                    //print("ok");
                    $_SESSION['username'] = $userName;
                    $this->loadView('poll');
                } else {
                    echo json_encode("Password does not match");
                }
            } else {
                echo json_encode("error : Account Does not exist");
            }
        }
    }
}

// $ob=new mainController();
// $ob->start();
?>
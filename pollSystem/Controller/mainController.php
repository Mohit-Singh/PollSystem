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
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
        {
            // print_r($row);
            // print($password);
            // print(md5($password));
            if ($row['username'] == $userName) {
            	//print($password);
                if ($row['password'] == md5($password)) {
                   // print(md5($password));
                    $_SESSION['username'] = $userName;
                    $this->loadView('poll');
                }
                else 
              {
                   echo json_encode("Password does not match");
                }
            } 
            else 
           {
               echo json_encode("error : Account Does not exist");
            }
        }
    }
    
    
    public function registerUser() {
    	$userObj = $this->loadModel('User');
    	$returnValue = $userObj->register($_POST);
    	if($returnValue) {
    		die("true");
    	}
    	else {
    		die("false");
    	}
    }
    
    public function AddQuestion() {
    	$obj = $this->loadModel("Question");
    	$obj->insertQuestion();
    }
    public function viewPreviousPolls()
    {
    	    	 
    	$userObj = $this->loadModel('User');
    	$result = $userObj->viewPreviousPolls();
    	
    	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    	
    		echo $row['text'];
    		die;
    	}
    	
//     	 print_r($result);
//     	 die;
    	 
    	 
    }
    
    
}

// $ob=new mainController();
// $ob->start();
?>
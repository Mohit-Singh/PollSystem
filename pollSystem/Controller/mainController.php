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
	

	    $userObj = $this->loadModel('User');
	    $result = $userObj->login($userName);
		if(count($result)) {
            if ($result[0]['username'] == $userName) 
            {
                if ($result[0]['password'] == md5($password)) 
                {
                    $_SESSION['username'] = $userName;
                    $_SESSION['userId'] = $result[0]['id'];
                    $this->loadView('poll');
                }
                else 
             	{
                   echo "Password does not match";
                }
            } 
            else 
           {
               echo "Account Does not exist";
           }
        }
        else
        {
        	echo "Account Does not exist";
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
    
    public function loadAllPoll(){
    	$userObj = $this->loadModel('User');
    	$result = $userObj->getAllPolls();
   		echo json_encode($result);
    } 
    
    
    public function viewPreviousPolls()
    {
    	    	 
    	$userObj = $this->loadModel('User');
    	$result = $userObj->viewPreviousPolls();
    	
    	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    	
    		$str="id:".$row['id']."Question:".$row['question']."<button onclick='showOpinions(".$row['id'].");'>Show Opinions</button></br>";
    		echo $str;
    		
    	}  	 
    	 
    }
    
    public function loadPreviousPoll()
    {
    	return $this->loadView('previouspoll'); 
    }
    
    public function showOpinions()
    {
    	$id=$_POST['questionid'];
    	$userObj = $this->loadModel('User');
    	$result = $userObj->showOpinions($id);
    	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    		 
    		$str[] = "OPTION:".$row['options'];
    	}
    	$str[] = 	"<img id=\"activityReportIMG\" alt=\"userActivityReport\"
    		        . src=\"index.php?controller=PollGraph&method=createGraph"
    		        ."&question=".$id
    		        ."&raw=".microtime()."\" width=\"220\" height=\"200\">";
    	echo json_encode($str);
    	$userObj->getTotalPoll(1);
    }
    
    function userLogOut()
    {
    	session_destroy();
    }
    
    public function pollLoad(){
    	$objPollLoad=$this->loadModel("PolledBy");
    	$que=$objPollLoad->selectPoll($_POST['queId']);
    	print_r($que);
    	return $que;
    }
    
}

?>
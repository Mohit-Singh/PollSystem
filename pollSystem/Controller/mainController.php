<?php

class MainController extends Acontroller{
	
	
	
	
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
        $question_id = $_GET['question']; 
    	$userObj = $this->loadModel('User');
    	$result = $userObj->viewPreviousPolls($question_id);    	 
    	echo json_encode($result);
    }
    
    public function loadPreviousPoll()
    {
    	return $this->loadView('previouspoll'); 
    }
    
    public function showOpinions()
    {
    	$id=$_GET['question'];
    	$userObj = $this->loadModel('User');
    	$result = $userObj->showOpinions($id);
    	
    	foreach($result as $key => $value){
    		 
    		$str[] = "OPTION:".$value;
    	}
    	$str[] = 	"<img id=\"activityReportIMG\" alt=\"userActivityReport\"
    		        . src=\"index.php?controller=PollGraph&method=createGraph"
    		        ."&question=".$id
    		        ."&raw=".microtime()."\" width=\"220\" height=\"200\">";
    	
    	echo json_encode($str);
    	
    	//$userObj->getTotalPoll(1);
    }
    
    function userLogOut()
    {
    	session_destroy();
    }
    
    public function pollLoad(){
    	$objPollLoad=$this->loadModel("PolledBy");
    	$que=$objPollLoad->selectPoll($_POST['queId']);
    		return $que;
    }
    
    public function pollNow()
    {
    	$objPollLoad=$this->loadModel("PolledBy");
    	$poll=$objPollLoad->chkPoll($_POST['LoginUsername'],$_POST['QuestionId']);
    	if(count($poll) ==0 )
    	{
    		$objPollLoad->makePoll($_POST);
    	}
    	else 
    	{
    		$objPollLoad->updatePoll($_POST);
    	}
    	
    }
    public function getOption()
    {
    	$objPollLoad=$this->loadModel("PolledBy");
    	$poll=$objPollLoad->chkPoll($_POST['LoginUsername'],$_POST['QuestionId']);
    	if(count($poll) ==0 )
    	{
    		echo "0";
    	}
    	else
    	{
    		echo $poll[0]['options_id'];
    	}
    }
    
    public  function graphData()
    {
    	$objPollLoad=$this->loadModel("Question");
    	$result['options']=$objPollLoad->getOption($_POST['QuestionId']);
    	$objVoteCount=$this->loadModel("PolledBy");
    	$count=0;
    	foreach ($result['options'] as $key => $val)
    	{
    		
    		$result['votes'][$val['id']]=$objVoteCount->getOptCount($val['id']);
    		$count+=$result['votes'][$val['id']];  		
    	}
    	$result['totalVote']=$count;
    	//print_r($result);
    	echo json_encode($result);  	
    } 
    
    public function insertComment() {
		//echo "in contr";
		//print_r($_POST);
		//$userName=$_SESSION['username'];
		$userName="abc";
		$ob=$this->loadModel("commentModel");
		$ob->addComment($userName,$_POST['comment']);
		$commentAr=array($userName,$_POST['comment']);
		//rsort($commentAr);
		echo json_encode($commentAr);
	}
	
	public function getComment() {


		$ob=$this->loadModel("commentModel");
		$ob->getComments("1");

	}
}

?>
<?php
class User extends DBConnection {
	private $_firstName;
	private $_lastName;
	private $_userName; // email of user
	private $_password;
	private $_status;




	/**
	 * @return the $_firstName
	 */
	public function getFirstName() {
		return $this->_firstName;
	}

	/**
	 * @return the $_lastName
	 */
	public function getLastName() {
		return $this->_lastName;
	}

	/**
	 * @return the $_userName
	 */
	public function getUserName() {
		return $this->_userName;
	}

	/**
	 * @return the $_password
	 */
	public function getPassword() {
		return $this->_password;
	}

	/**
	 * @return the $_status
	 */
	public function getStatus() {
		return $this->_status;
	}

	/**
	 * @param field_type $_firstName
	 */
	public function setFirstName($_firstName) {
		$this->_firstName = $_firstName;
	}

	/**
	 * @param field_type $_lastName
	 */
	public function setLastName($_lastName) {
		$this->_lastName = $_lastName;
	}

	/**
	 * @param field_type $_userName
	 */
	public function setUserName($_userName) {
		$this->_userName = $_userName;
	}

	/**
	 * @param field_type $_password
	 */
	public function setPassword($_password) {
		$this->_password = $_password;
	}

	/**
	 * @param field_type $_status
	 */
	public function setStatus($_status) {
		$this->_status = $_status;
	}

	public function register($arr) {
		$this->setUserName($arr['email']);
		$this->setStatus('true');
		$data['columns'] ='username';
		$data['tables'] = 'login';
		$data['conditions'] = array(array('username = "'.$this->getUserName().'" AND status = "'.$this->getStatus().'"'),true);
		$result = $this->_db->select($data);
		if(($row=$result->fetch(PDO::FETCH_ASSOC))) {
			return false;
		}
		else {
			$this->setFirstName($arr['firstName']);
			$this->setLastName($arr['lastName']);
			$this->setPassword($arr['password']);
				
			$insertValues = array('first_name'=>$this->getFirstName(),
					'last_name'=>$this->getLastName(),
					'username'=>$this->getUserName(),
					'password'=>md5($this->getPassword()),
					'status'=>$this->getStatus()
			);
			$this->_db->insert($data['tables'],$insertValues);
			return true;
		}
	}
	
	public function login($userName){

		$data['tables'] = 'login';
		$data['conditions'] = array(
				array(
						'username = "' . $userName . '"'
				),
				true
		);
	    $result=$this->_db->select($data);
	    $myResult=array();
	    while ($row = $result->fetch(PDO::FETCH_ASSOC))
	    {
	    	$myResult[]=$row;
	    }
	    return $myResult;
	    
	}
	public function viewPreviousPolls($question_id)
	{
		$data['tables'] = 'question';
		$data['conditions'] = array(array("id=".$question_id." AND status='TRUE'"),true);
		$result = $this->_db->select($data);
		$row = $result->fetchAll(PDO::FETCH_ASSOC); 
		return $row;
		
	}
	
	public function showOpinions($id)
	{
		$data['tables'] = 'options';
		$data['conditions'] = array('question_id' => $id);
		
		$result = $this->_db->select($data);		
		$row = $result->fetchAll(PDO::FETCH_ASSOC); 
		return $row;
		
	}
	public function getOption($questionID){
	    $data['columns'] =array("poll","options");
	    $data['tables'] = 'options';
	    $data['conditions'] = array(array('question_id = "'.$questionID.'" AND status = "TRUE"'),true);
	
	    $result = $this->_db->select($data);
	    return $result;
	}
	public function getTotalPoll($question_id){
	    $data['columns'] =array("count(*) count");
	    $data['tables'] = 'polled_by';
	    $data['conditions'] = array(array('question_id = "'.$question_id.'"'),true);
	    $data['group_by'] = array('options_id');
	    
	    $result = $this->_db->select($data);
	    $row = $result->fetchAll(PDO::FETCH_ASSOC);
//  	    print_r ($row);
//  	    die;
	    return $row;
	}
	
	
	public function getAllPolls()
	{
		$data['columns'] =array("question.id",
				"login.first_name",
				"login.username",
				"login.last_name",
				"question.question",
				"count(distinct(comment.id)) as comment",
				"count(distinct(polled_by.login_id)) as votes");
		$data['tables'] = 'question';
		
		$data['joins'][] = array(
				'table' => 'comment',
				'type'	=> 'left',
				'conditions' => array('question.id' => 'comment.question_id')
		);
		
		$data['joins'][] = array(
				'table' => 'polled_by',
				'type'	=> 'left',
				'conditions' => array('question.id' => 'polled_by.question_id')
		);
		
		$data['joins'][] = array(
				'table' => 'login',
				'type'	=> 'inner',
				'conditions' => array('question.login_id' => 'login.id')
		);
		$data['group'] = array('question.id');
		$data['conditions'] = array(array('question.status = "TRUE"'),true);	
		$result = $this->_db->select($data);
		
		$myResult=array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$myResult[]=$row;
		}
		return  $myResult;		
	}
}
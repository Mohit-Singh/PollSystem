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
	
	public function login($data){
	    return $this->_db->select($data);
	    
	}
	public function viewPreviousPolls()
	{
		$data['columns']=array('text','id');
		$data['tables'] = 'question';
		
		$result = $this->_db->select($data);
		return $result;
		
	}
	
	public function showOpinions($id)
	{

		$data['columns']=array('text');
		$data['tables'] = 'options';
		$data['conditions'] = array('question_id' => $id);
		
		
		$result = $this->_db->select($data);
		return $result;
		
	}
	public function getOption($questionID){
	    $data['columns'] =array("poll","text");
	    $data['tables'] = 'options';
	    $data['conditions'] = array(array('question_id = "'.$questionID.'" AND status = "TRUE"'),true);
	
	    $result = $this->_db->select($data);
	    return $result;
	}	
}
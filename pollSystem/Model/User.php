<?php
class User extends DBConnection {
	private $_firstName;
	private $_lastName;
	private $_userName; // email of user
	private $_password;
	private $_status;



	/**
	 * @return the $lastName
	 */
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * @param field_type $lastName
	 */
	public function setLastName($lastName) {
		$this->lastName = $lastName;
	}

	/**
	 * @return the $userName
	 */
	public function getUserName() {
		return $this->userName;
	}

	/**
	 * @param field_type $userName
	 */
	public function setUserName($userName) {
		$this->userName = $userName;
	}

	/**
	 * @return the $firstName
	 */
	public function getFirstName() {
		return $this->firstName;
	}



	/**
	 * @return the $password
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @return the $status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @param field_type $firstName
	 */
	public function setFirstName($firstName) {
		$this->firstName = $firstName;
	}




	/**
	 * @param field_type $password
	 */
	public function setPassword($password) {
		$this->password = $password;
	}

	/**
	 * @param field_type $status
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	public function registerUser($arr = array()) {
		$this->setUserName($arr['email']);
		$this->setStatus('true');
		$data['coloums'] ='email';
		$data['tables'] = 'login';
		$data['conditions'] = array('email = '."'$this->getUserName()'".' AND status = '."'$this->getStatus()'");
		$result = $this->_db->select($data);
		if(mysql_num_rows($result->fetch(PDO::FETCH_ASSOC))) {
			return("user alredy exists");
		}
		else {
			$this->setFirstName($arr['firstName']);
			$this->setLastName($arr['lastName']);
			$this->setPassword($arr['password']);
				
			$insertValues = array('first_name'=>$this->getFirstName(),
					'last_name'=>$this->getLastName(),
					'user_name'=>$this->getUserName(),
					'password'=>$this->getPassword(),
					'status'=>$this->getStatus()
			);
			$this->_db->insert($data['tables'],$insertValue);
			return true;
		}
	}
}
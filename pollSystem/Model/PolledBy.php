<?php
class PolledBy extends DBConnection {
	private $_QuestionId;
	private $_OptionId;
	private $_LoginUsername;
	/**
	 * @return the $_QuestionId
	 */
	public function getQuestionId() {
		return $this->_QuestionId;
	}

	/**
	 * @return the $_OptionId
	 */
	public function getOptionId() {
		return $this->_OptionId;
	}

	/**
	 * @return the $_LoginUsername
	 */
	public function getLoginUsername() {
		return $this->_LoginUsername;
	}

	/**
	 * @param field_type $_QuestionId
	 */
	public function setQuestionId($_QuestionId) {
		$this->_QuestionId = $_QuestionId;
	}

	/**
	 * @param field_type $_OptionId
	 */
	public function setOptionId($_OptionId) {
		$this->_OptionId = $_OptionId;
	}

	/**
	 * @param field_type $_LoginUsername
	 */
	public function setLoginUsername($_LoginUsername) {
		$this->_LoginUsername = $_LoginUsername;
	}
	public function makePoll($arrPollValue){
		$field=array();
		$this->setLoginUsername($arrPollValue['LoginUsername']);
		$this->setOptionId($arrPollValue['OptionId']);
		$this->setQuestionId($arrPollValue['QuestionId']);
		$field['question_id']=$this->getQuestionId();
		$field['options_id']=$this->getOptionId();
		$field['login_username']=$this->getLoginUsername();
		$result=$this->_db->insert('polled_by',$field);
	}
	

}
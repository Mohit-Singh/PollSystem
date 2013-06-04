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
	public function updatePoll($arrPollValue){
		$field=array();
		$this->setLoginUsername($arrPollValue['LoginUsername']);
		$this->setOptionId($arrPollValue['OptionId']);
		$this->setQuestionId($arrPollValue['QuestionId']);
		$field['question_id']=$this->getQuestionId();
		$field['options_id']=$this->getOptionId();
		$field['login_id']=$this->getLoginUsername();
		$where = array('login_id' => $this->getLoginUsername(),'question_id' =>$this->getQuestionId());
		$result=$this->_db->update('polled_by',$field,$where);
	}
	public function makePoll($arrPollValue){
		$field=array();
		$this->setLoginUsername($arrPollValue['LoginUsername']);
		$this->setOptionId($arrPollValue['OptionId']);
		$this->setQuestionId($arrPollValue['QuestionId']);
		$field['question_id']=$this->getQuestionId();
		$field['options_id']=$this->getOptionId();
		$field['login_id']=$this->getLoginUsername();
		$result=$this->_db->insert('polled_by',$field);
	}
	public function chkPoll($uId,$qId)
	{
		$data['tables']=array('polled_by');
		$data['conditions']=array(array('question_id ="'.$qId.'" AND login_id ='.$uId),true);
		$result=$this->_db->select($data);
		
		$myResult=array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$myResult[]=$row;
		}
		return  $myResult;
	}
	
	public function getOptCount($optId)
	{
		$data['columns']=array('count(distinct(id)) as vote');
		$data['tables']=array('polled_by');
		$data['conditions']=array(array('options_id ='.$optId),true);
		$result=$this->_db->select($data);
		
		$myResult=0;
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$myResult=$row['vote'];
		}
		return  $myResult;
	}
	
	public function selectPoll($queId){
		$data['columns']	= array('question.question','options','options.id as optId','question.id as qId');
		$data['tables']=array('question');
		
		$data['joins'][] = array(
				'table' => 'options',
				'type'	=> 'inner',
				'conditions' => array('question.id' => 'options.question_id'));
		
		$data['conditions']=array(array('question.id ="'.$queId.'" AND question.status ="TRUE"'),true);
		$result=$this->_db->select($data);
		
		$myResult=array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$myResult[]=$row;
		}
		return  $myResult;
	}
}
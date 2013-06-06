<?php
class Question extends DBConnection {
	private $_Id;
	private $_Text;
	/**
	 * @return the $_Id
	 */
	public function getId() {
		return $this->_Id;
	}

	/**
	 * @return the $_Text
	 */
	public function getText() {
		return $this->_Text;
	}

	/**
	 * @param field_type $_Id
	 */
	public function setId($_Id) {
		$this->_Id = $_Id;
	}

	/**
	 * @param field_type $_Text
	 */
	public function setText($_Text) {
		$this->_Text = $_Text;
	}
	
	public function insertQuestion() {
		
		$this->_db->insert("question",array('question'=>$_POST['question'],'login_id'=>$_SESSION["userId"]));
		$id = $this->_db->getLastInsertId();
		unset($_POST['question']);

		$value = array('question_id'=>$id,
				'options'=>''
				
		);
		
		foreach ($_POST as $key => $val) {
			$value['options'] = $_POST[$key];
			$this->_db->insert("options",$value);
		}
		
		
	}
	
	public function getOption($qId)
	{
		$data['tables']=array('options');
		$data['conditions']=array(array('question_id ='.$qId),true);
		$result=$this->_db->select($data);
		
		$myResult=array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$myResult[]=$row;
		}
		return  $myResult;
	}
	public function delPoll($questionID){
	    $field=array();
	    $field['status']="FALSE";	    
	    $where = array('id' => $questionID);	    
	    $result=$this->_db->update('question',$field,$where);
	}

}
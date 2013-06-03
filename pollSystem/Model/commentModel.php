<?php

class commentModel extends DBConnection {
	private $_userid;
	
	public function addComment($userName,$comment) {
		//echo ("in model");
		$_userid=$userName;
		$userName="abc";
		$data = array('question_id'=>'1','text'=>$comment,'login_username'=>$userName,'date_time'=>date('Y-m-d h:i:s', time()),'status'=>'TRUE');
		//$result = $this->_db->select($data);
		$this->_db->insert("comment",$data);
		
	}
	public function getComments($qid) {
		//echo ("in model");
		$data['columns']	= array('text', 'login_username');
		$data['tables']		= 'comment';
		$data['conditions']		= array('question_id' => $qid);
		$result = $this->_db->select($data);
		
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$ar[]=($row);
			//print_r($row);
		}	
		echo json_encode($ar);
	}
	
	
}
?>
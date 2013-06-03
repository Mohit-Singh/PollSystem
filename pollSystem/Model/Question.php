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
	
	public function insert() {
		echo "hello";
		echo "</br>";
		print_r($_POST);
	}

}
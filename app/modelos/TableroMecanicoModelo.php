<?php  

class TableroMecanicoModelo {
	private $db="";
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}
}

?>
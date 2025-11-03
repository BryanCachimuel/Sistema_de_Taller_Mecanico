<?php  
/**
 * 
 */
class TableroModelo
{
	private $db="";
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}
}

?>
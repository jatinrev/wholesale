<?php 

/**
* 
*/
class common
{
	public $mysqlDbOb;
	function __construct()
	{
		global $mysqlDbOb;
		$this->mysqlDbOb = $mysqlDbOb;
	}
}

?>
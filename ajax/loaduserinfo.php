<?php 

	require("../lib/blog_lib.php");
	require("../lib/mysql_lib.php");
	
	$mysql = new mysql_lib();
	
	$mysql->connectToDatabase();

	if(isset($_POST['userid'])) {
		$id = $_POST['userid'];
		getUserInfo($mysql->getConnection(), $id);
	}
?>
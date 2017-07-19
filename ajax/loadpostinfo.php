<?php 

	require("../lib/blog_lib.php");
	require("../lib/mysql_lib.php");
	
	$mysql = new mysql_lib();
	
	$mysql->connectToDatabase();

	if(isset($_POST['postid'])) {
		$id = $_POST['postid'];
		getPostInfo($mysql->getConnection(), $id);
	}
?>
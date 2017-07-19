<?php 

	require("../lib/blog_lib.php");
	require("../lib/mysql_lib.php");
	
	$mysql = new mysql_lib();
	
	$mysql->connectToDatabase();

	if(isset($_POST['userid'])) {
		$userid = $_POST['userid'];
		for($x = 1; $x < 7; $x++) {
			if($x != 6) {
				if(hasPermission($mysql->getConnection(), $userid, $x))
					echo "true;";
				else
					echo "false;";
			} else {
				if(hasPermission($mysql->getConnection(), $userid, $x))
					echo "true";
				else
					echo "false";
			}
		}
	}
?>
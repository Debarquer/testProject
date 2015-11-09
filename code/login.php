<?php namespace login;

function login()
{
	$_POST["login"] = "NULL";
		
		$sql = "SELECT pk, username, password, type FROM users WHERE username = '$_POST[username]' && password = '$_POST[password]'";

		$result = $_SESSION["conn"]->query($sql);

		if ($result->num_rows > 0) 
		{		
			$row = $result->fetch_assoc();
			
			$_SESSION["pk"] = (int)$row["pk"];
			$_SESSION["loggedin"] = "true";
			$_SESSION["username"] = $_POST["username"];
			$_SESSION["type"] = $row["type"];
		} 	
}

?>
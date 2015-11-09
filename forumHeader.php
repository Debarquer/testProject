<?php namespace forumHeader;

function printHeader()
{
	echo '<div id="header">';
	
	if(isset($_SESSION["loggedin"]))
	{
		if($_SESSION["loggedin"] == "false")
		{
			echo'
				<br><br>
				<div id="form">
				<form method="POST">
				<legend>Login:</legend>
				Username:<br>
				<input type="text" name="username">
				<br>
				Password:<br>
				<input type="password" name="password">
				<br><br>
				<input type="submit" name="login" value="Log in">
				</form>
				</div>
				<br>';
		}
		else
		{
			echo 'Hello ' . $_SESSION["username"] . '<br>';	

			echo'
				<br><br>
			
				<form method="POST">
				<input type="submit" name="logout" value="Log out">
				</form>';
		}
	}
	else{
		echo'
			<br><br>
			<div id="form">
			<form method="POST">
			<legend>Login:</legend>
			Username:<br>
			<input type="text" name="username">
			<br>
			Password:<br>
			<input type="text" name="password">
			<br><br>
			<input type="submit" name="login" value="Log in">
			</form>
			</div>
			<br>';
	}
	echo '<a href="http://localhost:8080/forum/index.php?page=front">Front page</a>';
	echo '</div>';
}

?>
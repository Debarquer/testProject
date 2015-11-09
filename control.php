<?php namespace control;

function checkForInput()
{
	if(isset($_POST['login']))
	{
		\login\login();
	}
	else if (isset($_POST['logout'])) 
	{
		$_POST["logout"] = "NULL";
		
		$_SESSION["loggedin"] = "false";
		$_SESSION["username"] = "";	
		$_SESSION["pk"] = "";
		$_SESSION["type"] = "";
	}
	if(isset($_GET['thread']))
		$_SESSION['thread'] = $_GET['thread'];
	if(isset($_GET['category']))
		$_SESSION['category'] = $_GET['category'];
	
	function deleteThread()
	{
		$_SESSION['thread'] = 'false';
		$_GET['thread'] = '';
		
		$sql = "delete from posts where thread='$_POST[deleteThread]'";
		$result = $_SESSION["conn"]->query($sql);
		
		$sql = "delete from threads where pk='$_POST[deleteThread]'";
		$result = $_SESSION["conn"]->query($sql);
	}
	
	if(isset($_POST['deleteThread']))
	{
		deleteThread();
	}
	if(isset($_POST['deleteCategory']))
	{
		$_SESSION['category'] = 'false';
		$_GET['category'] = '';
		
		$sql = "delete from categories where pk='$_POST[deleteCategory]'";
		$result = $_SESSION["conn"]->query($sql);
		
		$sql = "select * from threads where category='$_POST[deleteCategory]'";
		$result = $_SESSION["conn"]->query($sql);
		
		if ($result->num_rows > 0) 
		{	
			while($row = $result->fetch_assoc())
			{
				$_POST['deleteThread'] = $row['pk'];
			}
		}
	}	
}

?>
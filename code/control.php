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

	if(isset($_POST['deleteThread']))
	{
		if(isset($_SESSION['type']))
		{
			if($_SESSION['type'] == 'admin')
			{
				$_SESSION['thread'] = 'false';
				$_GET['thread'] = '';

				$sql = "delete from posts where thread='$_POST[deleteThread]'";
				$result = $_SESSION["conn"]->query($sql);

				$sql = "delete from threads where pk='$_POST[deleteThread]'";
				$result = $_SESSION["conn"]->query($sql);
			}
		}
	}
	if(isset($_POST['deleteCategory']))
	{
		if(isset($_SESSION['type']))
		{
			if($_SESSION['type'] == 'admin')
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
						//wont actually delete threads, need to call "delete thread" function (that doesnt exist yet)
						$_POST['deleteThread'] = $row['pk'];
					}
				}
			}
		}
	}
	if(isset($_POST["content"]))
	{
		$sql = "insert into categories (name) values ('$_POST[content]')";

		$result = $_SESSION["conn"]->query($sql);
	}
	if(isset($_POST["content"]) && isset($_SESSION['category']))
	{
		if($_POST["content"] != 'false' && $_SESSION["category"] != 'false')
		{
			$sql = "insert into threads (name, category) values ('$_POST[content]', '$_SESSION[category]')";
			$result = $_SESSION["conn"]->query($sql);
		}
	}
}

?>

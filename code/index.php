<meta charset="utf-8">

<html>
<head>
<link rel="stylesheet" href="..\styles\style.css">
</head>
<body>

<?php
session_start();

require 'category.php';
require 'thread.php';
require 'login.php';
require 'control.php';
require 'forumHeader.php';
require 'categories.php';
require 'profile.php';

$_SESSION["conn"] = new mysqli("localhost", "root", NULL, "test");

if ($_SESSION["conn"]->connect_error) {
    die("Connection failed: " . $_SESSION["conn"]->connect_error);
} 

\control\checkForInput();
\forumHeader\printHeader();

if(isset($_GET["page"]))
{
	if($_GET["page"] == "front")
	{
		$_SESSION["thread"] = "false";
		$_SESSION["category"] = "false";
		\categories\printCategories();
	}
	else
	{
		if(isset($_GET["user"]))
		{
			if($_GET["user"] != "false")
			{
				\profile\printProfile();
			}
			else
			{
				if(isset($_SESSION['category']))
				{
					if($_SESSION['category'] != 'false')
					{
						if(isset($_SESSION["thread"]))
						{
							if($_SESSION["thread"] != "false")
							{
								\thread\thread();
							}
							else
							{
								\category\printCategory();
							}
						}
						else
						{
							\category\printCategory();
						}
					}
					else
					{
						\categories\printCategories();
					}
				}
			}
		}
		else
		{
			if(isset($_SESSION['category']))
			{
				if($_SESSION['category'] != 'false')
				{
					if(isset($_SESSION["thread"]))
					{
						if($_SESSION["thread"] != "false")
						{
							\thread\thread();
						}
						else
						{
							\category\printCategory();
						}
					}
					else
					{
						\category\printCategory();
					}
				}
				else
				{
					\categories\printCategories();
				}
			}	
		}
	}
}
else
{
	if(isset($_GET["user"]))
	{
		if($_GET["user"] != "false")
		{
			\profile\printProfile();
		}
		else
		{
			if(isset($_SESSION['category']))
			{
				if($_SESSION['category'] != 'false')
				{
					if(isset($_SESSION["thread"]))
					{
						if($_SESSION["thread"] != "false")
						{
							\thread\thread();
						}
						else
						{
							\category\printCategory();
						}
					}
					else
					{
						\category\printCategory();
					}
				}
				else
				{
					\categories\printCategories();
				}
			}
		}
	}
	else
	{
		if(isset($_SESSION['category']))
		{
			if($_SESSION['category'] != 'false')
			{
				if(isset($_SESSION["thread"]))
				{
					if($_SESSION["thread"] != "false")
					{
						\thread\thread();
					}
					else
					{
						\category\printCategory();
					}
				}
				else
				{
					\category\printCategory();
				}
			}
			else
			{
				\categories\printCategories();
			}
		}
		else
		{
			\categories\printCategories();
		}		
	}
}

?>

</body>
</html>
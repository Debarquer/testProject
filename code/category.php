<?php namespace category;

function printCategory()
{
	if(isset($_POST["content"]) && isset($_SESSION['category']))
	{
		if($_POST["content"] != 'false' && $_SESSION["category"] != 'false')
		{
			$sql = "insert into threads (name, category) values ('$_POST[content]', '$_SESSION[category]')";
			$result = $_SESSION["conn"]->query($sql);	
		}
	}
	
	if(isset($_SESSION["loggedin"]))
	{
		if($_SESSION["loggedin"] == "true")
		{
			echo '<br>
				Add thread: <br>
				<form method="POST">
					<input type="text" name="content">
					<input type="submit">
				</form>
				';
		}
	}
	
	echo '<form method="GET">
					<button name="category" value="false">Leave category</button>
				</form>		
		';
	
	$sql = "SELECT * FROM threads WHERE category='$_SESSION[category]'";
	$result = $_SESSION["conn"]->query($sql);
	
	$sqlCategory = "select * from categories where pk='$_SESSION[category]'";
	$resultCategory = $_SESSION["conn"]->query($sqlCategory);
	$rowCategory = $resultCategory->fetch_assoc();
	
	echo '<div id="threads">
		<center>' . $rowCategory["name"] . '</center>';
	
	if ($result->num_rows > 0) 
	{	
		while($row = $result->fetch_assoc())
		{
			//$thread;// = "select * FROM posts WHERE thread='$row[pk]'";
			if (!mysqli_query($_SESSION["conn"],"select * FROM posts WHERE thread='$row[pk]'"))
		    {
			  echo("Error description: " . mysqli_error($con));
			}
			$thread2 = mysqli_query($_SESSION["conn"],"select * FROM posts WHERE thread='$row[pk]'");
			$threadResult = $thread2->fetch_assoc();
			$numPosts = $thread2->num_rows;
			
			$hasChanged = false;
			$thread = mysqli_query($_SESSION["conn"],"select * FROM posts WHERE thread='$row[pk]'");
			for($i = 0; $rowThread = $thread->fetch_assoc(); $i++)
			{
				if($i == $numPosts - 1)
				{
					$poster = $rowThread["poster"];
					$date = $rowThread["date"];
					$hasChanged = true;
				}
			}
			if(!isset($poster))
				$poster = "";
					
			$username = mysqli_query($_SESSION["conn"], "select * FROM users WHERE pk='$poster'");
			$rowUsername = $username->fetch_assoc();
			
			if(!$hasChanged)
			{
				$poserName = "No posts";
				$date = "";
			}
			else
			{
				$poserName = $rowUsername["username"];
			}
			
			//$db = $thread["date"];
			//$timestamp = strtotime($db);
			//echo date("m-d-Y", $timestamp);
			
			//echo '<div class="leftCategory"><button value=' . $row["pk"] . ' name="thread">' . $row["name"] . '	</button></form></div><div class="rightCategory"><form class="deleteThread" method="post"><button value=' . $row["pk"] . ' name="deleteThread">Delete thread</button></form></div>';			 
			echo '
			<div class="leftCategory">
				<a href="http://localhost:8080/forum/code/index.php?thread=' . $row["pk"] . '">' . $row["name"] . '</a>
				<br><br> Amount of posts: ' . $numPosts . '&nbsp&nbsp&nbsp&nbsp&nbsp Last post ' . $date . ' by <a href="http://localhost:8080/forum/index.php?user=' . $poster . '">' . $poserName . '</a>
			</div>
			<div class="rightCategory">
				<form class="deleteThread" method="post"><button value=' . $row["pk"] . ' name="deleteThread">Delete thread</button></form>
			</div>';
		}
		echo '</table>';
	}
	
	echo '</div>';
}

?>
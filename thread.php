<?php namespace thread;

function thread()
{
	if(isset($_POST["content"]))
	{
		$sql = "insert into posts (thread,content, poster) values ('$_SESSION[thread]', '$_POST[content]', '$_SESSION[pk]')";
		
		$result = $_SESSION["conn"]->query($sql);
	}
	if(isset($_POST["delete"]))
	{		
		$sql = "delete from posts where pk='$_POST[delete]'";
	
		$result = $_SESSION["conn"]->query($sql);
	}

	echo '<form method="GET">
					<button name="thread" value="false">Leave thread</button>
				</form>		
		';
	if(isset($_SESSION["type"]))
	{
		if($_SESSION["type"] == "admin")
		{
			echo '<br>
				<form method="POST">
					<button name="deleteThread" value=' . $_SESSION["thread"] . '>Delete thread</button>
				</form>';		
		}
	}
		
	$sql = "SELECT * FROM posts WHERE thread='$_SESSION[thread]'";

	$result = $_SESSION["conn"]->query($sql);

	if ($result->num_rows >= 0) 
	{	

		$id2 = (int)$_SESSION["thread"];
		$sql3 = 'select * from threads where pk=' . $id2;	
		$result3 = $_SESSION["conn"]->query($sql3);
		$row3 = $result3->fetch_assoc();
		
		echo '<div class="threadContainer">';
			echo '<div class="title"> Thread: ' . $row3['name'] . '</div>';
				
			while($row = $result->fetch_assoc())
			{
				$id = (int)$row["poster"];
				$sql2 = 'select * from users where pk=' . $id;	
				$result2 = $_SESSION["conn"]->query($sql2);
				$row2 = $result2->fetch_assoc();
				 
				 echo '<div class="postContainer">';
					echo '<div class="left">
							<img src="image.jpg"></img>
							<br>
							Username <br><a href="http://localhost:8080/forum/index.php?user=' . $row["poster"] . '">' . $row2["username"] . '</a>
							<br> Date: <br>' . $row["date"] . '
						</div>';
					echo '<div class="middle">
							' . nl2br(str_replace(' ', '&nbsp', $row["content"])) . '
						</div>';
					echo '<div class="right">
							<form method="POST">
								<button type="submit" name="delete" value="' . $row["pk"] . ']">Delete</button></form>
						</div>';
				echo '</div>';		 
			}
			echo '<div class="postContainer"><div class="left"></div><div class="middle">';
				if(isset($_SESSION["loggedin"]))
				{
					if($_SESSION["loggedin"] == "true")
					{
						echo '
							Add post:
							<form method="POST">
								<textarea class="submitPost" type="text" name="content"></textarea>
								<input type="submit">
							</form>';		
					}
				}
		echo '</div><div class="right"></div></div></div>´';
	}	
}
?>
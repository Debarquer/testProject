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
		if(isset($_SESSION['username']))
		{
			if($_SESSION['type'] == 'admin')
			{
				echo "is admin";
				$sql = "delete from posts where pk='$_POST[delete]'";

				$result = $_SESSION["conn"]->query($sql);
			}
		}
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

	if(isset($_GET['firstPost'])){
		if($_GET['firstPost'] != ""){
			$var = $_GET['firstPost'] * 10;
			$sql = "SELECT * FROM posts WHERE thread='$_SESSION[thread]' LIMIT 10 OFFSET $var";
		} else{
			$sql = "SELECT * FROM posts WHERE thread='$_SESSION[thread]' LIMIT 10";
		}
	} else{
		$sql = "SELECT * FROM posts WHERE thread='$_SESSION[thread]' LIMIT 10";
	}

	$result = $_SESSION["conn"]->query($sql);

	if ($result->num_rows >= 0)
	{

		$id2 = (int)$_SESSION["thread"];
		$sql3 = 'select * from threads where pk=' . $id2;
		$result3 = $_SESSION["conn"]->query($sql3);
		$row3 = $result3->fetch_assoc();
		echo '<div class="threads">';
		echo '<div class="title"> Thread: ' . $row3['name'];
		echo '</div>';

		//prints the page numbers on the top of the thread
		if(!isset($_GET['firstPost'])){
				echo '
				<br>Current page:' . 'First page' . ' Choose page:
				<a href=index.php?thread=' . $id2 . '&firstPost=0>0</a>
				<a href=index.php?thread=' . $id2 . '&firstPost=1>1</a>
				<a href=index.php?thread=' . $id2 . '&firstPost=2>2</a>';
		} else{
			if($_GET['firstPost'] == ""){
				echo '<br> Current page:' . 'First page' . ' Choose page:';
				echo '<a href=index.php?thread=' . $id2 . '&firstPost=0>0</a>';
				echo '<a href=index.php?thread=' . $id2 . '&firstPost=1>1</a>';
				echo '<a href=index.php?thread=' . $id2 . '&firstPost=2>2</a>';
			}else{
				$var = $_GET['firstPost'];
				echo'<br>Current page:' . $_GET['firstPost'] . ' Choose page:';

				$goal = 2;
				$currPage = $_GET['firstPost'];
				if($currPage - 2 < 0){
					$goal += ($currPage-2)*(-1);
				}

				for($i = -$goal; $i <= $goal; $i++){
					$tmp = $var + $i;
					$tmpO = $tmp+1;
					if($tmp >= 0){
						echo "<a href=index.php?thread=$id2&firstPost=$tmp>$tmpO</a>";
					}
				}
			}
		}

			while($row = $result->fetch_assoc())
			{
				$id = (int)$row["poster"];
				$sql2 = 'select * from users where pk=' . $id;
				$result2 = $_SESSION["conn"]->query($sql2);
				$row2 = $result2->fetch_assoc();

				 echo '<div class="postContainer">';
					echo '<div class="left">
							<img src="..\resources\image.jpg"></img>
							<br>
							Username <br><a href="http://localhost:8080/forum/code/index.php?user=' . $row["poster"] . '">' . $row2["username"] . '</a>
							<br> Date: <br>' . $row["date"] . '
						</div>';
					echo '<div class="middle">
							' . nl2br(str_replace(' ', '&nbsp', $row["content"])) . '
						</div>';
						if(isset($_SESSION["type"]))
						{
							if($_SESSION["type"] == "admin")
							{
								echo '<div class="right">
										<form method="POST">
										<button type="submit" name="delete" value="' . $row["pk"] . ']">Delete</button></form>
									</div>';
							}
						}
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
		echo '</div>';
		if(isset($_SESSION["type"]))
		{
			if($_SESSION["type"] == "admin")
			{
				echo '<div class="right"></div></div></div>';
			}
		}
	}
}
?>

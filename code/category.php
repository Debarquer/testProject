<?php namespace category;

function printCategory()
{
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

	echo '<div class="threads">
		<center>' . $rowCategory["name"] . '</center>';

	if ($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			if (!mysqli_query($_SESSION["conn"],"SELECT * FROM test.posts WHERE date = (SELECT MAX(date) FROM test.posts WHERE thread='$row[pk]')"))
		    {
			  echo("Error description: " . mysqli_error($_SESSION["conn"]	));
			}
			$threadResult = mysqli_query($_SESSION["conn"],"SELECT * FROM test.posts WHERE date = (SELECT MAX(date) FROM test.posts WHERE thread='$row[pk]')");

			$count = $_SESSION["conn"]->query("SELECT COUNT(*) FROM test.posts WHERE thread='$row[pk]'");
			$countRow = $count->fetch_row();
			$nrOfPosts = $countRow[0];

			$poster = "";
			$date = "";
			$noPoster = true;
			while($threadRow = $threadResult->fetch_assoc()){
				$noPoster = false;
				$poster = $threadRow["poster"];
				$date = $threadRow["date"];
			}

			if($noPoster){
				$posterName = "No posts";
				$date = "";
			} else{
				$username = mysqli_query($_SESSION["conn"], "select * FROM users WHERE pk='$poster'");
				$rowUsername = $username->fetch_assoc();

				$posterName = $rowUsername["username"];
			}

			//echo '<div class="leftCategory"><button value=' . $row["pk"] . ' name="thread">' . $row["name"] . '	</button></form></div><div class="rightCategory"><form class="deleteThread" method="post"><button value=' . $row["pk"] . ' name="deleteThread">Delete thread</button></form></div>';
			echo '
			<div class="leftCategory">
				<a href="http://localhost:8080/forum/code/index.php?thread=' . $row["pk"] . '">' . $row['name'] . '</a>';
				if($noPoster){
					echo '<br><br>No posts';
				} else{
					echo '<br><br>Number of posts: ' . $nrOfPosts . '&nbsp&nbsp&nbsp&nbsp&nbsp Last post ' . $date . ' by <a href="http://localhost:8080/forum/code/index.php?user=' . $poster . '">' . $posterName . '</a>';
				}
			echo '</div>';
			if(isset($_SESSION["type"]))
			{
				if($_SESSION["type"] == "admin")
				{
					echo '
					<div class="rightCategory">
						<form class="deleteThread" method="post"><button value=' . $row["pk"] . ' name="deleteThread">Delete thread</button></form>
					</div>';
				}
			}
		}
		echo '</table>';
	}

	echo '</div>';
}

?>

<?php namespace profile;

function printProfile()
{
	$sqlUser = "select * from users where pk='$_GET[user]'";
	$resultUser = $_SESSION["conn"]->query($sqlUser);
	
	while($rowUser = $resultUser->fetch_assoc())
	{
		echo "<center>Welcome to " . $rowUser['username'] . "'s profile!</center>";
		
		$sqlPosts = "select * from posts where poster='$_GET[user]'";
		$resultPosts = $_SESSION["conn"]->query($sqlPosts);
		
		echo '<div class="threadContainer">';
			echo '<center>Post history:</center>';
			while($rowPosts = $resultPosts->fetch_assoc())
			{
				$sqlThread = "select * from threads where pk='$rowPosts[thread]'";
				$resultThread = $_SESSION["conn"]->query($sqlThread);
				$rowThread = $resultThread->fetch_assoc();
				
				echo '<div class="postContainer">';
					echo '<div class="left">';
						echo '<a href="http://localhost:8080/forum/code/index.php?thread=' . $rowPosts["thread"] . '">' . $rowThread["name"] . '</a>';
						echo '<br>Date: ' . $rowPosts["date"];
					echo '</div>';
					echo '<div class="middle">';
						echo $rowPosts["content"];
					echo '</div>';
					echo '<div class="right"></div>';
				echo '</div>';
			}
		echo '</div>';
	}
}

?>
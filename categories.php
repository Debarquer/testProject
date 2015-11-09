<?php namespace categories;

function printCategories()
{
	if(isset($_POST["content"]))
	{
		$sql = "insert into categories (name) values ('$_POST[content]')";
		
		$result = $_SESSION["conn"]->query($sql);
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
	
	$sql = "SELECT * FROM categories";

	$result = $_SESSION["conn"]->query($sql);
	
	echo '<div id="threads">Categories:';
	
	if ($result->num_rows > 0) 
	{	
		echo '<div id="leftCategory">Category</div><div id="rightCategory">Delete</div>';
		while($row = $result->fetch_assoc())
		{
			echo '<div id="leftCategory"><form class="category" method="get"><button value=' . $row["pk"] . ' name="category">' . $row["name"] . '	</button></form></div>';
			echo '<div id="rightCategory"><form class="deleteCategory" method="post"><button value=' . $row["pk"] . ' name="deleteCategory">Delete category</button></form></div>';			 
		}
	}
	echo '</div>';
}

?>
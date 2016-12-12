<?php namespace categories;

function printCategories()
{

	if(isset($_SESSION["type"]))
	{
		if($_SESSION["type"] == "admin")
		{
			echo '<br>
				Add category: <br>
				<form method="POST">
					<input type="text" name="content">
					<input type="submit">
				</form>
				';
		}
	}

	$sql = "SELECT * FROM categories";

	$result = $_SESSION["conn"]->query($sql);

	echo '<div class="threads">Categories:';

	if ($result->num_rows > 0)
	{
		echo '<div class="leftCategory">Category</div>';
		if(isset($_SESSION["type"]))
		{
			if($_SESSION["type"] == "admin")
			{
				echo'<div class="rightCategory">Delete</div>';
			}
		}
		while($row = $result->fetch_assoc())
		{
			echo '<div class="leftCategory"><form class="category" method="get"><button value=' . $row["pk"] . ' name="category">' . $row["name"] . '	</button></form></div>';
			if(isset($_SESSION["type"]))
			{
				if($_SESSION["type"] == "admin")
				{
					echo '<div class="rightCategory"><form class="deleteCategory" method="post"><button value=' . $row["pk"] . ' name="deleteCategory">Delete category</button></form></div>';
				}
			}
		}
	}
	echo '</div>';
}

?>

<?php
	include "../includes/db_common.php";

	$ord = 1;
	$err = false;
	foreach($_POST['m'] as $mid)
	{
		$sql = "UPDATE movie_channel SET weight=" . sanitize($ord) . " WHERE mid=" . sanitize($mid);
		if (!mysqli_query($con,$sql))
		{
			echo 'Update movie error: ' . mysqli_error($con) . "<br />";
			$err = true;
		}
		$ord++;
	}

	if($err)
	{
		echo "fail";
	}
	else
	{
		echo "success";
	}
?>
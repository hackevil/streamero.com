<?php
	include "../includes/db_common.php";

	$mid= intval($_GET['mid']);
	$cid=0;
	if(!empty($_GET['cid']))
	{
		$cid= intval($_GET['cid']);
	}

  //if this movie is in a channel
	if($cid > 1)
	{
		$sql = "DELETE FROM movie_channel WHERE mid=" . sanitize($mid) . " AND cid=" . sanitize($cid);
		if (!mysqli_query($con,$sql))
		{
			echo 'Unable to delete: ' . mysqli_error($con);
		}
		else
		{
			echo "success";
		}
	}
	else
	{
		//if channel is not defined, then permanently delete movie
		$arrSql[0] = "DELETE FROM movie WHERE mid=" . sanitize($mid);
		$arrSql[1] = "DELETE FROM movie_channel WHERE mid=" . sanitize($mid);
		if(transactionSQL($arrSql))
		{
			echo "success";
		}
	}
?>
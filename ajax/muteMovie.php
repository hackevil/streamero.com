<?php
	include "../includes/db_common.php";

	$mid= intval($_GET['mid']);
	$cid= intval($_GET['cid']);
	$mute= intval($_GET['mute']);

	$sql = "UPDATE movie_channel SET mute = " . sanitize($mute);
	$sql .= " WHERE mid = " . sanitize($mid) . " AND cid = " . sanitize($cid);

	if (!mysqli_query($con,$sql))
	{
		echo 'mute=' . $mute  .  ' --- error: ' . mysqli_error($con);
	}
	else
	{
		echo "success";
	}
?>
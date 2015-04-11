<?php
	include "../includes/db_common.php";

	$currentMovieId = $_GET['mid'];

	// Create connection
	$con=mysqli_connect("mysql10.websitesource.net","marklar_admin","k4t4m4r4n","marklar_main");

	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	if(!$loggedIn)
	{
		//TODO: randomize this
		$movUID = 1;
	}
	else
	{
		$movUID = $loggedInUid;
	}

	$sql = "SELECT movie_code, mtid, movie.mid, movie.title FROM movie ";
	$sql .= " INNER JOIN movie_channel mChan on mChan.mid=movie.mid ";
	$sql .= " WHERE movie.uid=" . sanitize($movUID) . " AND mChan.mute = 0 AND mChan.cid=1 ORDER by mChan.weight, date_added DESC ";

	$arrMovie = array();
	$result = mysqli_query($con,$sql);

	if($result === false)
	{
		echo 'Error: ' . mysqli_error($con) . "<br />";
	}


	$arrMovie['prevCode'] = "";
	$arrMovie['prevType'] = "";
	$arrMovie['prevMid'] = "";
	$arrMovie['prevTitle'] = "";
	$arrMovie['nextCode'] = "";
	$arrMovie['nextType'] = "";
	$arrMovie['nextMid'] = "";
	$arrMovie['nextTitle'] = "";
	$movieFound=false;
	$nextApplied=false;
	while($row = mysqli_fetch_array($result))
	{
		if($row['mid'] == $currentMovieId)
		{
			$movieFound=true;
		}
		else
		{
			if(!$movieFound)
			{
				//if we have not found a movie, then continue applying the previous values
				//once it is found, the most recent previous movie will be saved
				$arrMovie['prevCode'] = $row['movie_code'];
				$arrMovie['prevType'] = $row['mtid'];
				$arrMovie['prevMid'] = $row['mid'];
				$arrMovie['prevTitle'] = $row['title'];
			}
			else
			{
				if(!$nextApplied)
				{
					//if movie was found but next was not applied, then this is the next movie
					$nextApplied=true;
					$arrMovie['nextCode'] = $row['movie_code'];
					$arrMovie['nextType'] = $row['mtid'];
					$arrMovie['nextMid'] = $row['mid'];
					$arrMovie['nextTitle'] = $row['title'];
				}
			}
		}
	}

	mysqli_close($con);
	echo json_encode($arrMovie);
?>
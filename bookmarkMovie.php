<?php
  //this file accepts input from the bookmarklet to save a movie
	include "includes/db_common.php";
	include "includes/processLink.php";

	if(!empty($_GET["link"]))
	{
		if(!$loggedIn)
		{
			echo "<script>alert('you must be logged in to streamero.com to save videos.  please go to streamero.com and log into your account.  you can then come back to this site and this bookmark will work correctly.');</script>";
		}
		else
		{
			$mType = "";
			$mLink = sanitize(urldecode($_GET["link"]));

			$movieCode = getMovieCode($mLink, &$mType);
			$title = getMovieTitle($mLink, $mType, $movieCode);

			if(strlen($movieCode) < 1 || strlen($title) < 1)
			{
				echo "<script>alert('this video cannot be saved');</script>";

			}
			else
			{
				saveMovie($loggedInUid, $mType, $mLink, $movieCode, $title);
				echo "<script>alert('\"$title\" was saved');</script>";
			}

		}
	}


?>
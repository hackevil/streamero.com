<?php

	$loggedIn = false;
	$loggedInUser = "";

	if(isset($_COOKIE['uname']))
	{
	  unset($_COOKIE['uname']);
	  setcookie('uname', '', time() - 3600, "/", "streamero.com"); // empty value and old timestamp
	}
	if(isset($_COOKIE['uid']))
	{
	  unset($_COOKIE['uid']);
	  setcookie('uid', '', time() - 3600, "/", "streamero.com"); // empty value and old timestamp
	}

	header("Location: http://streamero.com");


?>
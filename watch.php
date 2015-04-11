<?php
	$page_class="watch_page";
	include "pageTop.php";
	$noMovie = "<p>Movie not loaded</p>";
	$setMovieAsWatched = false;

	if(!$loggedIn)
	{
		//TODO: randomize the user id for non-loggedin users to get movies from a random account, not just mine
		$userID = 1;
	}
	else
	{
		//if we are watching another user's stream
		if(!empty($_GET["uid"]))
		{
			$userID = $_GET["uid"];
		}
		else
		{
			//we are watching the logged in user's stream, mark the movie as watched
			$setMovieAsWatched = true;
			$userID = $loggedInUid;
		}
	}

	$sql = "SELECT movie.mid, movie_code, mtid, mChan.cid, movie.title FROM movie ";
	$sql .= " INNER JOIN movie_channel mChan on mChan.mid=movie.mid ";

	if(!empty($_GET["mid"]))
	{
		//if movie id is set, get a specific movie
		$sql .= " WHERE movie.mid=" . sanitize($_GET["mid"]);
	}
	else
	{
		//if movie id is not set then get the lastest movie based upon the user id
		$sql .= " WHERE movie.uid=" . sanitize($userID) . " AND mChan.mute = 0 AND mChan.cid=1 ORDER by mChan.weight, date_added DESC LIMIT 0, 1";
	}
	$arrMovie = array();
	if(!$result = mysqli_query($con,$sql))
	{
		echo 'Error: ' . mysqli_error($con) . "<br />";
	}
	
	if(mysqli_num_rows($result) < 1)
	{
		$noMovie = "<p class='error'>We were unable to load this movie.<br >Please <a href='/'>Please click here to select another</a></p>";
	}
	else
	{
		while($row = mysqli_fetch_array($result))
		{
	
			$arrMovie['mCode'] = $row['movie_code'];
			$arrMovie['mType'] = $row['mtid'];
			$arrMovie['mid'] = $row['mid'];
			$arrMovie['title'] = $row['title'];
		}
	}
	
	if($setMovieAsWatched)
	{
		$sql = "UPDATE movie SET watched = 1 WHERE mid = " . sanitize($arrMovie['mid']);
		if (!mysqli_query($con,$sql))
		{
			echo 'error setting watched state.  mid=' . $arrMovie['mid'];
		}
	}

?>

<div id="watch_container">

	<div id="watch_menu" onmouseover="showWatchMenu()" onmouseout="hideWatchMenu()">
		<div id="indicator">&bull; &bull; &bull; &bull; &bull;</div>
		<div id="watch_menu_items">
			<div id="watch_title"><?php echo $arrMovie['title']; ?></div>
			<a class="black_button spacer" href="javascript:void(0)" id="prev_movie_on" onclick="loadPrevMovie()"><< previous video</a>
			<span class="spacer" id="prev_movie_off" style="display:none"><< previous video</span>
			<a href="/" class="spacer black_button">back to browse</a>
			<?php
				if($loggedIn)
				{ ?>
					<a href="javascript:void(0)" id="watch_mute" class="spacer black_button" >mute video</a>
					<a href="javascript:void(0)" id="watch_delete" class="spacer black_button" >delete video</a>
				<?php
				} ?>
			<a class="black_button" href="javascript:void(0)" onclick="loadNextMovie()" id="next_movie_on">next video >></a>
			<span  id="next_movie_off" style="display:none">next video >></span>
		</div>
		<div id="watch_menu_spinner">&#160;</div>
	</div>

	<div id="watcher">
      <?= $noMovie ?>
    </div>
    <div id="watchervim">
      <?= $noMovie ?>
    </div>

    <script>
	    loadMovie("<?php echo $arrMovie['mCode'] ?>",<?php echo $arrMovie['mType'] ?>, <?=$arrMovie['mid']?>, '<?=$arrMovie['title']?>');
    </script>
</div>

<?php
	include "pageBottom.php"
?>













<?php
	include "pageTop.php";

	$arrMovies = array();

	if(!empty($loggedInUid)) {
		$sql = " SELECT movie.mid, movie_code, mtid, title, mute FROM movie ";
		$sql .= " INNER JOIN movie_channel mchan on movie.mid=mchan.mid ";
		$sql .= " WHERE movie.uid=" . sanitize($loggedInUid) . " AND mchan.cid=1 ORDER BY weight, date_added DESC ";

		$arrMovie = array();
		$result = mysqli_query($con,$sql);

		if($result === false) {
			echo 'Error: ' . mysqli_error($con) . "<br />";
		}

		while($row = mysqli_fetch_array($result)) {
			$arrMovie['mCode'] = $row['movie_code'];
			$arrMovie['mType'] = $row['mtid'];
			$arrMovie['title'] = $row['title'];
			$arrMovie['mid'] = $row['mid'];
			$arrMovie['mute'] = $row['mute'];
			array_push($arrMovies, $arrMovie);
		}
	}
?>

<div id="home_container">
	<div class="big_bubble">
		<?php
			if($loggedIn) {
				if(empty($arrMovies)) {
					echo "<h2>welcome $loggedInUser</h2>";
					echo "You currently have no videos saved.  You can:<ul><li><a href='addMovie.php'> add a video</a></li><li><a href='channels.php?all=1'>watch another user's channel</a></li><li><a href='watch.php?rand=1'>or just start watching stuff</a></li></ul>";
				}
				else {
					echo "<h2>$loggedInUser's Channel</h2>";
					echo "<ul class='movie_list'>";

					$mCounter=0;
					foreach ($arrMovies as $movie) {
						$muted="";
						if($movie["mute"] == 1) {
							$muted="muted";
						}
						echo "<li class='movie_block clearfix $muted' id='m_" . $movie['mid'] . "'><span class='arrow_handle green1'>R</span> <span class='movie_title'>" . cleanForDisplay($movie['title']) . "</span>";
						echo "	<div class='funcs'>";
						echo "	<span class='watch_links'>";
						echo " 		<a class='small_button' href='watch.php?mid=" . $movie['mid'] . "'>watch</a>";
						echo " 		<a class='small_button' href='javascript:void(0)' onclick='muteMovie(this," . $movie['mid'] . ", 1, 1)'>mute</a>";
						echo "	</span>";
						echo " 	<a class='mute_link small_button' href='javascript:void(0)' onclick='muteMovie(this, " . $movie['mid'] . ", 1, 0)'>un-mute</a>";
						echo " 	<a title='move to bottom' class='movie_arrow_rev move_to_bottom' href='javascript:void(0)' >E</a>";
						echo " 	<a title='move to top' class='movie_arrow move_to_top' href='javascript:void(0)' >E</a>";
						echo "	<a class='small_button' href='javascript:void(0)' onclick='deleteMovie(this," . $movie['mid'] . ", 1)'>delete</a></div>";
						echo "</li>";
						$mCounter++;
					}
					echo "</ul>";
				}

			}
			else {
				echo "<h2>welcome to streamero</h2> You can:";
				echo "<ul><li><a href='login.php'>login</a></li><li><a href='register.php'>register</a></li><li><a href='watch.php'>watch a random channel</a></li>";
				echo "</ul>";
			}
		?>
	</div>
</div>

<?php include "pageBottom.php" ?>













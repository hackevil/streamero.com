<?php
	include "pageTop.php";
	include "includes/processLink.php";

  //setup some vars for use later
	$title="";
	$mType=0;
	$movieCode="";
	$mLink  = "";

	if(!empty($_POST["link"])) {
		$mLink = filter_var($_POST["link"], FILTER_SANITIZE_URL);
		$movieCode = getMovieCode($mLink, $mType);

		if(empty($movieCode)) {
			$errMssg = "We were unable to save this movie";
		}
		else {
			//get movie title
			if(empty($_POST["title"])) {
				$title = getMovieTitle($mLink, $mType, $movieCode);
			}
      else {
				$title = sanitize($_POST["title"]);
			}
			saveMovie($loggedInUid, $mType, $mLink, $movieCode, $title);
		}
	}
?>

<div class="big_bubble">
  <h3>add a video</h3>
  <?php if(!empty($title)) {
 		echo "<h4><i class='green2'>" . cleanForDisplay($title) . "</i> was saved</h4>";
 	}
 	//display any user errors generated
 	if(!empty($errMssg)) {
	 	echo "<h4 class='error'>$errMssg</h4>";
 	}

 	if(!$loggedIn) {
	 	echo "You must be <a href='login.php'>logged in</a> to save videos";
 	}
 	else {
  ?>
    <form method="post" id="vid_form">
      <label for="title">Title</label>
      <br />
      <input type="text" name="title" id="title" placeholder="title will be automatically generated if left empty" class="longtext" />
      <br />
      <label for="link">Link</label>
      <br />
      <input type="text" name="link" id="link" placeholder="link to video (required) " class="midtext" />
      <br />
      <input type="submit" value="add video" class="button" />
    </form>
    <?php } ?>
</div>
<p>
  You can use our bookmarklet to make saving videos even easier. Make sure your bookmarks toolbar is visible, then drag the "save 2 streamero" button to your toolbar.  
  Now anytime you are on vimeo.com or youtube.com you can just click on this button in your toolbar to save the video.
</p>
<p>
  <a class="button" href='javascript:strLoc=String(window.location);if(strLoc.indexOf("https")==0){alert("We have to reload to save this video. Please click the bookmark again when the page reloads.");window.location=strLoc.replace("https","http");}strId="streamero_frame";saveURL="http://streamero.com/bookmarkMovie.php?link="+encodeURIComponent(strLoc);if(document.getElementById(strId)){fframe=document.getElementById(strId);fframe.parentNode.removeChild(fframe);}objIFRAME=document.createElement("iframe");objIFRAME.id=strId;objIFRAME.src=saveURL;document.body.appendChild(objIFRAME);void(0);' >save 2 streamero</a>
<p>You must be logged into streamero.com for this bookmark to work; although, once you log in, you do not need to keep streamero.com open in your browser (you will stay logged in).
<?php include "pageBottom.php" ?>


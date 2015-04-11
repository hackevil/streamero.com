<?php include "pageTop.php"; ?>
<div id="home_container">
	<div class="big_bubble">
		<h2>about streamero</h2>
		<p>
			The best thing about Streamero is that you can just click "<a href="watch.php">watch</a>" and start watching.  If you want more detail, continue reading.
		</p>
		<p>
			Streamero is a video bookmarking and viewing site.  Streamero allow you to easily save videos from youtube.com and vimeo.com.  When you click on "watch", streamero continuously plays your bookmarked videos one after the other.  If you are not logged in, it will select a random channel to show videos from.
		</p>
		<p>
			To save a video, go to the <a href="addMovie.php">add videos</a> page.  You can enter the link to your youtube or vimeo page in the form; or, you can use our bookmarklet to make saving even easier.  See the <a href="addMovie.php">add videos</a> page for more details.  <?php if(!$loggedIn){?>You must be <a href="register.php">registered</a> and <a href="login.php">logged in</a> to save videos.<?php } ?>
		</p>
		<p>
			I came up with streamero after I cancelled my cable subscription.  I connected a laptop to my tv and that's how I watch tv.  I can watch network videos; but, I soon realized what I really wanted to watch was content sent to me by my friends.  Since I am usually too busy during the day to view these videos, I wanted a way to save them and watch them easily later.
		</p>
		<p>
			Upcoming features include tagging and channels as well as profile photos.
		</p>
	</div>
</div>
<?php include "pageBottom.php"; ?>
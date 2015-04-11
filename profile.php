<?php
	$checkLogged="in";
	include "pageTop.php";
	$objUser = new User($loggedInUid);
?>

<div id="home_container">
	<div class="big_bubble">
		<?php
			echo "<h2>$loggedInUser's Profile</h2>";
			echo "<p><b>name</b><br />" . $objUser->getFirstName() . " " . $objUser->getMiddleName() . " " . $objUser->getLastName() . "</p> ";
			echo "<p><b>about " . $objUser->getUserName()  . "</b><br />" . $objUser->getAboutMe() . "</p> ";
			echo "<p><a href='editProfile.php'>edit profile</a></p>";
			echo "<p><a href='changePassword.php'>change password</a></p>";
			//echo "<p><a href='managePhotos.php'>manage photos</a></p>";
		?>
	</div>
</div>




<?php include "pageBottom.php" ?>













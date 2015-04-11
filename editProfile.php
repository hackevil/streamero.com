<?php
	$checkLogged="in";
	include "pageTop.php";

	if(!empty($_POST['email'])) {
		//process
		$uName=sanitize($_POST['username']);
		$email=sanitize($_POST['email']);
		$first=sanitize($_POST['firstname']);
		$last=sanitize($_POST['lastname']);
		$middle=sanitize($_POST['middlename']);
		$aboutMe=sanitize($_POST['aboutme']);

		//TODO: server-side validation
		$sql = "UPDATE `user` SET username = '$uName', email = '$email', firstname = '$first', middlename = '$middle', lastname = '$last', aboutme = '$aboutMe' WHERE uid = $loggedInUid ";

		if (!mysqli_query($con,$sql)) {
			echo 'Register Error: ' . mysqli_error($con) . "<br />";
			//TODO: remove this sql output
			echo "SQL: $sql";
		}
	}

	$objUser = new User($loggedInUid);
?>

<h3>edit profile</h3>

<div class="big_bubble">
	<form method="post" id="reg_form" onsubmit="return checkReg()">
		<label for="username">username</label>
		<br />
		<input type="text" name="username" id="username" class="midtext" placeholder="required" value="<?= $objUser->getUserName() ?>"/>
		<span class="error" id="uname_error" ></span>
		<br />
		<label for="email">email</label>
		<br />
		<input type="text" name="email" id="email" class="midtext" placeholder="required" onblur="checkEmail()" value="<?= $objUser->getEmail() ?>" />
		<span class="error" id="email_error" ></span>
		<br />
		<table border="0" cellpadding="0" cellspacing="0" class="field_table">
			<tr>
				<td><label for="firstname">First Name</label></td>
				<td><label for="middlename">Middle Name</label></td>
				<td><label for="lastname">Last Name</label></td>
			</tr>
			<tr>
				<td><input type="text" name="firstname" id="firstname" class="shorttext" placeholder="optional" value="<?= $objUser->getFirstName() ?>" /></td>
				<td><input type="text" name="middlename" id="middlename" class="shorttext" placeholder="optional" value="<?= $objUser->getMiddleName() ?>" /></td>
				<td><input type="text" name="lastname" id="lastname" class="shorttext" placeholder="optional" value="<?= $objUser->getLastName() ?>" /></td>
			</tr>
		</table>
		<label for="aboutme">about me</label>
		<br />
		<textarea id="aboutme" name="aboutme" placeholder="optional" class="midtext"><?= $objUser->getAboutMe() ?></textarea>
		<br />
		<input type="submit" value="update profile" class="button" />
	</form>
</div>

<?php include "pageBottom.php" ?>
<?php
	$checkLogged="out";
	include "pageTop.php";

	if(!empty($_POST['email']))
	{
		//process
		$uName=sanitize($_POST['username']);
		$passw=sanitize($_POST['password1']);
		$email=sanitize($_POST['email']);
		$first=sanitize($_POST['firstname']);
		$last=sanitize($_POST['lastname']);
		$middle=sanitize($_POST['middlename']);
		$aboutMe=sanitize($_POST['aboutme']);

		//TODO: server-side validationr
		$sql = "insert into `user` (username, passw, email, firstname, middlename, lastname, aboutme) values ";
		$sql .= " ('$uName','$passw','$email','$first','$middle','$last','$aboutMe') ";
		if (!mysqli_query($con,$sql))
		{
			echo 'Register Error: ' . mysqli_error($con) . "<br />";
		}
		else
		{
			//log user in
			$objUser = new User();
			$objUser->setUsername($uName);
			$objUser->setUid(mysqli_insert_id($con));
			logUserIn($objUser);
			header("Location: http://streamero.com");
		}

	}
?>

<h3>register</h3>

<div class="big_bubble">
	<form method="post" id="reg_form" onsubmit="return checkReg()">
		<label for="username">username</label>
		<br />
		<input type="text" name="username" id="username" class="midtext" placeholder="required" />
		<span class="error" id="uname_error" ></span>
		<br />
		<label for="password1">password</label>
		<br />
		<input type="password" name="password1" id="password1" class="midtext" placeholder="required" onblur="checkPasswords()" />
		<span class="error" id="p1_error" ></span>
		<br />
		<label for="password2">password (again)</label>
		<br />
		<input type="password" name="password2" id="password2" class="midtext" placeholder="required" onblur="checkPasswords()" />
		<span class="error" id="p2_error" ></span>
		<br />
		<label for="email">email</label>
		<br />
		<input type="text" name="email" id="email" class="midtext" placeholder="required" onblur="checkEmail()" />
		<span class="error" id="email_error" ></span>
		<br />
		<table border="0" cellpadding="0" cellspacing="0" class="field_table">
			<tr>
				<td><label for="firstname">First Name</label></td>
				<td><label for="middlename">Middle Name</label></td>
				<td><label for="lastname">Last Name</label></td>
			</tr>
			<tr>
				<td><input type="text" name="firstname" id="firstname" class="shorttext" placeholder="optional" /></td>
				<td><input type="text" name="middlename" id="middlename" class="shorttext" placeholder="optional" /></td>
				<td><input type="text" name="lastname" id="lastname" class="shorttext" placeholder="optional" /></td>
			</tr>
		</table>
		<label for="aboutme">about me</label>
		<br />
		<textarea id="aboutme" name="aboutme" placeholder="optional" class="midtext"></textarea>
		<br />
		<input type="submit" value="register" class="button" />
	</form>
	<p>
			<a href="login.php">already have an account?</a>
		</p>
</div>

<?php include "pageBottom.php" ?>
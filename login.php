<?php
	$checkLogged="out";
	$email = "";
	include "pageTop.php";
?>

<h3>login</h3>
<div class="big_bubble">
	<div>
		<div class="error">
		<?php
			if(!empty($_POST['email']))
			{
				//process
				$passw=sanitize($_POST['password']);
				$email=sanitize($_POST['email']);
				//TODO: server-side validation and add a link for technical support

				switch(checkCredentials($email,$passw))
				{
					case "success":
						header("Location: http://streamero.com");
					break;
					case "bad user":
						echo "<i>$email</i> was not found in our system.  Would you like to <a href='register.php'>register</a>?";
					break;
					case "bad pass":
						echo "This is the incorrect password for <i>$email</i>";
					break;
					case "db error":
						echo "There was a problem with our system.  Please try again later or contact technical support";
					break;
					default:
						echo "On no! It didn't work!  Please try again later or contact technical support";
					break;
				}
			}
		?>
		</div>
	</div>
	<form method="post" id="reg_form" onsubmit="return checkLogin()">
		<label for="email">email</label>
		<br />
		<input type="text" name="email" id="email" class="midtext" placeholder="required" onblur="checkEmail()" value="<?= $email ?>"/>
		<span class="error" id="email_error" ></span>
		<br />
		<label for="password">password</label>
		<br />
		<input type="password" name="password" id="password" class="midtext" placeholder="required" />
		<span class="error" id="pass_error" ></span>
		<br />
		<input type="submit" value="login" class="button"/>
		<p>
			<a href="changePassword.php">forgot password?</a>
		</p>
		<p>
			<a href="register.php">need to create an account?</a>
		</p>
	</form>
</div>

<?php include "pageBottom.php" ?>
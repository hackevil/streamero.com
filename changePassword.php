<?php
	include "pageTop.php";
	$errorMssg = "";
	$userEmail="";
	$showForm=false;

	if($loggedIn)
	{
		$objUser = new User($loggedInUid);
		$userEmail = $objUser->getEmail();
	}
?>

<h3>change password</h3>

<div class="big_bubble">
<?php

if(!empty($_POST['email']))
{
	$semail = $_POST['email'];
	$sql = "SELECT uid FROM user where email = '" . sanitize($semail) . "'";
	if(!$result = mysqli_query($con,$sql))
	{
		echo 'change pass error. password not reset!  <br /> ' . mysqli_error($con) . "<br />";
	}
	else
	{
		$row = mysqli_fetch_array($result);
		if(is_null($row))
		{
			echo "<span class='error'>The email address: " . $semail . " was not found in our system.</span>";
			$showForm=true;
		}
		else
		{
			$uid = $row["uid"];
			$guid = uniqid();
			$sql = "INSERT INTO resetPassword (uid,guid) VALUES ($uid, '$guid') ON DUPLICATE KEY UPDATE guid='$guid' ";
			if (!mysqli_query($con,$sql))
			{
				echo 'change pass error. password not reset!  <br /> ' . mysqli_error($con) . "<br />";
				//TODO: remove this sql output
				echo "SQL: $sql";
			}
			else
			{
				$strMssg = "Reset password was selected from Streamero.com<br />";
				$strMssg .= "If you would like to reset your password, click here: <a href='http://www.streamero.com/changePassword2.php?token=$guid'>reset password</a><br /><br />";
				$strMssg .= "If you do not want to reset your password, just disregard this email";

				// Always set content-type when sending HTML email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
				//
				mail($_POST['email'],'Streamero: password reset ',$strMssg,$headers);
			}
			?>
				<p>Please check your email for our password reset email.</p>
			<?php
		}
	}
}
else
{
	$showForm=true;
}

if($showForm)
{
	?>
		<p>Please enter your email address and we will send instructions for updating your password</p>
			<form method="post" id="reg_form" onsubmit="return checkReg()">
				<label for="email">email</label>
				<br />
				<input type="text" name="email" id="email" class="midtext" placeholder="required" onblur="checkEmail()" value="<?= $userEmail ?>" />
				<span class="error" id="email_error" ></span>
				<br />
				<input type="submit" value="email me" class="button" />
			</form>
		</p>
	<?php

}
?>
</div>

<?php include "pageBottom.php" ?>
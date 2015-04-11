<?php
	include "pageTop.php";
	$errorMssg = "";
?>

<h3>change password</h3>

<div class="big_bubble">
<?php

if(!empty($_GET['token']))
{
	$guid = uniqid();
	$sql = "SELECT uid FROM resetPassword WHERE guid = '" . sanitize($_GET['token']) . "'";
	if(!$result = mysqli_query($con,$sql))
	{
		echo 'change pass error. password not reset!  <br /> ' . mysqli_error($con) . "<br />";
	}
	else
	{
		$row = mysqli_fetch_array($result);
		if(is_null($row))
		{
			echo "This link is expired and, for security reasons, cannot be used to reset your email.";
		}
		else
		{
			if(!empty($_POST['password1']))
			{
				//TODO: server side validation
				$uid = $row["uid"];
				$sql = "UPDATE user set passw = '" . sanitize($_POST['password1']) . "' WHERE uid=$uid";
				if(!mysqli_query($con,$sql))
				{
					echo 'change pass error. password not reset!  <br /> ' . mysqli_error($con) . "<br />";
				}
				else
				{

					$objUser = new User($uid);
					logUserIn($objUser);
					//TODO delete guid from table
					//TODO refresh page so logged in status shows - countdown to login
					echo "Your password was reset. ";
					if(!$loggedIn)
					{
						echo "<a href='/'>login</a>";
					}
				}
			}
			else
			{
				?>
					<p>Please enter your new password</p>
						<form method="post" id="reg_form" onsubmit="return checkReg()">
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
							<input type="submit" value="change password" class="button" />
						</form>
					</p>
				<?php
			}
		}
	}
}
?>
</div>

<?php include "pageBottom.php" ?>
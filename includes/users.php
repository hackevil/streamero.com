<?php

	$loggedIn = false;
	$loggedInUser = "";
	$userId=0;
	$loggedInUid=0;
	if(!empty($_COOKIE["uname"])) {
		$loggedIn = true;
		$loggedInUser = $_COOKIE["uname"];
		if(!empty($_COOKIE["uname"])) {
			$loggedInUid = $_COOKIE["uid"];
		}
	}
	//check logged in state of pages
	if(!empty($checkLogged)) {
		switch($checkLogged) {
			case "in":
				if (!$loggedIn) {
					header("Location: http://streamero.com");
				}
			break;
			case "out":
				if ($loggedIn) {
					header("Location: http://streamero.com/profile.php");
				}
			break;
		}
	}

	function checkCredentials($email,$pass) {
		global $con;

		$email = sanitize($email);
		$pass = sanitize($pass);
		$sql = "SELECT uid, username, passw FROM user WHERE email = '$email'";
		if($result = mysqli_query($con,$sql)) {
			$row = mysqli_fetch_array($result);
			$username = $row["username"];
			$password = $row["passw"];
			$uid = $row["uid"];

			if(strlen($username)>0) {
				if($password == $pass) {
					$objUser = new User();
					$objUser->setUsername($username);
					$objUser->setUid($uid);
					$objUser->setEmail($email);
					logUserIn($objUser);
					return "success";
				}
				else {
					return "bad pass";
				}
			}
			else {
				return "bad user";
			}
		}
		else {
			return "db error";
		}
	}


	function logUserIn($objUser) {
		global $loggedIn;
		$forever = 2000000000;
		setcookie("uname",$objUser->getUsername(),$forever,"/","streamero.com");
		setcookie("uid",$objUser->getUid(),$forever,"/","streamero.com");
	}


	class User {
	  private $username;
    private $uid;
    private $email;
    private $firstname;
    private $middlename;
    private $lastname;
    private $aboutme;
    private $password;

    public function __construct($uid=0) {
    	if($uid>0) {
    		global $con;

    		$sql = "SELECT username, email, firstname, middlename, lastname, aboutme, passw FROM user WHERE uid= " . sanitize($uid);
    		$result = mysqli_query($con,$sql);
    		if($result === false) {
					echo 'Error: ' . mysqli_error($con) . "<br />";
				}

				while($row = mysqli_fetch_array($result)) {
					$this->username= $row['username'];
					$this->email= $row['email'];
					$this->firstname= $row['firstname'];
					$this->middlename= $row['middlename'];
					$this->lastname= $row['lastname'];
					$this->aboutme= $row['aboutme'];
					$this->password= $row['passw'];

					$this->uid= $uid;
				}
    	}
    }

    public function setUserName($uname) {
    	$this->username=$uname;
    }
    public function getUserName() {
    	return $this->username;
    }
    //
    public function setUid($uid) {
    	$this->uid=$uid;
    }
    public function getUid() {
    	return $this->uid;
    }
    //
    public function setEmail($email) {
    	$this->email=$email;
    }
    public function getEmail() {
    	return $this->email;
    }
    //
    public function setFirstName($firstname) {
    	$this->firstname=$firstname;
    }
    public function getFirstName() {
    	return $this->firstname;
    }
    //
    public function setMiddleName($mname) {
    	$this->middlename=$mname;
    }
    public function getMiddleName() {
    	return $this->middlename;
    }
    //
    public function setLastName($lastnamel) {
    	$this->lastname=$lastname;
    }
    public function getLastName() {
    	return $this->lastname;
    }
	  //
    public function setAboutMe($aboutme) {
    	$this->aboutme=$aboutme;
    }
    public function getAboutMe() {
    	return $this->aboutme;
    }
    //
    public function setPassword($pass) {
    	$this->password=$pass;
    }
    public function getPassword() {
    	return $this->password;
    }
	}
?>
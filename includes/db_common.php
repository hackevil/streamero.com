<?php
	// Create connection
	$con=mysqli_connect("mysql10.websitesource.net","marklar_admin","k4t4m4r4n","marklar_main");

	// Check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	include "users.php";
	
	function transactionSQL($arrSql) {
		global $con;

		$transSuccess = true;
		if (!mysqli_query($con,"START TRANSACTION")) {
			echo 'Transaction Error: ' . mysqli_error($con) . "<br />";
		}
		else {
			foreach($arrSql as $sql) {
				if (!mysqli_query($con,$sql)) {
					echo 'sql loop error: ' . mysqli_error($con) . "<br />";
					$transSuccess = false;
				}
			}
		}
		if($transSuccess) {
			if (!mysqli_query($con,"COMMIT")) {
				echo 'commit Error: ' . mysqli_error($con) . "<br />";
				$transSuccess=false;
			}
		}
		else {
			if (!mysqli_query($con,"ROLLBACK")) {
				echo 'Rollback Error: ' . mysqli_error($con) . "<br />";
			}
			else {
				echo "Rollback executed <br />";
			};
		}
		return $transSuccess;
	}

	function sanitize($value) {
		//mysql real excape string vals
		$search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
		$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
		$value = str_replace($search, $replace, $value);

		return $value;

		//second version for multi byte chars
		//TODO: get this working
		/*
		$return = '';
    for($i = 0; $i < strlen($value); ++$i)
    {
        $char = $value[$i];
        $ord = ord($char);
        if($char !== "'" && $char !== "\"" && $char !== '\\' && $ord >= 32 && $ord <= 126)
            $return .= $char;
        else
            $return .= '\\x' . dechex($ord);
    }
    return $return;
    */
	}

	function cleanForDisplay($txt)
	{
		$txt = str_replace("\\\\\\", "", $txt);
		return $txt;
	}
?>
<?php

	function getMovieCode($mLink, &$mType) {
		$movieCode = "";
		//get movie code
		if(strpos($mLink, "youtube") !== false ) {
			$mType = 1;
			$movieCode = getQval($mLink, "v");
		}
		if(strpos($mLink, "http://youtu.be/") !== false ) {
			$mType = 1;
			$movieCode = str_replace("http://youtu.be/", "", $mLink);
		}
		if(strpos($mLink, "https://vimeo.com/") !== false ) {
			$mType = 2;
			$movieCode = str_replace("https://vimeo.com/", "", $mLink);
		}
		if(strpos($mLink, "http://vimeo.com/") !== false ) {
			$mType = 2;
			$movieCode = str_replace("http://vimeo.com/", "", $mLink);
		}
		return $movieCode;
	}

	function getMovieTitle($mLink, $mType, $movieCode) {
		$title="";
		if($mType==1) {
			$arrYTVals = get_youtube($mLink);
			$title= sanitize($arrYTVals["title"]);
		}
		if($mType==2) {
			$arrVimVals = get_vimeo($movieCode);
			$title= sanitize($arrVimVals[0]["title"]);
		}

		return $title;
	}

	function saveMovie($uid, $mType, $mLink, $movieCode, $title) {
		$arrSql[0] = "INSERT INTO movie (uid,mtid,link, movie_code, title) VALUES (" . sanitize($uid) . ", " . sanitize($mType) . ",'" . sanitize($mLink) . "', '" . sanitize($movieCode) . "', '" . sanitize($title) . "')";
		$arrSql[1] = "INSERT INTO movie_channel (mid, cid, uid, weight, mute) VALUES (LAST_INSERT_ID(), 1, 1, 0, 0)";

		transactionSQL($arrSql);
	}

	function getQval($url, $name) {
		$arrQstring = parse_url ($url, PHP_URL_QUERY);
		$arrQnamePairs = split("&", $arrQstring);
		$arrVals =  array();  //querystring values keyed by querystring names

		foreach ($arrQnamePairs as $namePair) {
			$arrTemp = split("=",$namePair);
			$arrVals[$arrTemp[0]] = $arrTemp[1];
		}

		return $arrVals[$name];
	}

	function get_youtube($url) {
		 $youtube = "http://www.youtube.com/oembed?url=". $url ."&format=json";

		 $curl = curl_init($youtube);
		 curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		 $return = curl_exec($curl);
		 curl_close($curl);
		 return json_decode($return, true);
	}

	function get_vimeo($movieCode){
		$vUrl = "http://vimeo.com/api/v2/video/$movieCode.json";

		$curl = curl_init($vUrl);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$return = curl_exec($curl);
		curl_close($curl);
		return json_decode($return, true);
	}


	?>
//alert('js loaded');

window.mCounter=0;

window.nextMovie = new sMovie();
window.currentMovie = new sMovie();
window.previousMovie = new sMovie();

window.vimeoReady = false;

function sMovie() {
	this.mid="";
	this.code="";
	this.type="";
	this.title="";
}


function loadMovie(movieCode, movieType, movieID, movieTitle) {
	$("#watch_menu_spinner").show();
	$("#watch_menu_items").hide();
	console.log('loadMovie called  movieCode: ' + movieCode + ' movieType= ' + movieType + ' movieid=' + movieID + ' title=' + movieTitle);

	$("#watch_title").html(movieTitle);

	//assign video buttons
	$("#watch_delete").unbind("click");
	$("#watch_mute").unbind("click");
	$("#watch_mute").removeClass("black_button_activated");
	$("#watch_delete").removeClass("black_button_activated");


	$("#watch_delete").click(function() {
      eval("deleteMovieWatch(" + movieID + ",1)");
   });

   $("#watch_mute").click(function() {
      eval("muteMovieWatch(" + movieID + ",1,1)");
   });

	//854x480
	//640x360
	winHeight = $(window).height() - 30;
	winWidth = $(window).width() - 30;
	//console.log("height: " +  $(window).height());

	if(movieType == 1) {
		$('#watchervim').hide();
		$('#watcher').show();

		swfUrl = "http://www.youtube.com/v/" + movieCode  + "?enablejsapi=1&playerapiid=watcher";
		swfobject.embedSWF(swfUrl, 'watcher', winWidth, winHeight, '9.0.0"', null, null,
	        { allowScriptAccess: 'always', wmode: 'opaque', allowfullscreen: 'true' },
	        { id: "watcher", name: "watcher" }
	    );
	}
	if(movieType == 2) {
		$('#watchervim').show();
		$('#watcher').hide();

		swfUrl = "<iframe id='vimeoplayer' src='//player.vimeo.com/video/" + movieCode  + "?api=1&player_id=vimeoplayer' width='" + winWidth + "' height='" + winHeight + "' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";

		$('#watchervim').html(swfUrl);

		iframe = $('#vimeoplayer')[0];
		player = $f(iframe);
		player.addEvent('ready', function() {
		    player.api('play');
		    player.addEvent('finish', loadNextMovie);
		});
	}

	//show the previous play button if there was a movie before this one
	if(window.nextMovie.code.length>0) {
		$('#prev_movie_on').show();
		$('#prev_movie_off').hide();
	}

  getNextPrevMovie(movieID);

}



function getNextPrevMovie(movieID) {
	window.mCounter++;

	//reset
	window.nextMovie = new sMovie();
	window.currentMovie = new sMovie();
	window.previousMovie = new sMovie();


	nUrl = "/ajax/nextPrevMovie.php?mid=" + movieID;
	$.get(nUrl, function(data) {
		nmvy = jQuery.parseJSON(data);
		window.nextMovie.code = nmvy.nextCode;
		window.nextMovie.type = nmvy.nextType;
		window.nextMovie.mid = nmvy.nextMid;
		window.nextMovie.title = nmvy.nextTitle;
		window.previousMovie.code = nmvy.prevCode;
		window.previousMovie.type = nmvy.prevType;
		window.previousMovie.mid = nmvy.prevMid;
		window.previousMovie.title = nmvy.prevTitle;

		//hide the next movie if this is the last one
		if(nmvy.nextCode == "") {
			$('#next_movie_on').hide();
			$('#next_movie_off').show();
		}
		if(nmvy.prevCode == "") {
			$('#prev_movie_on').hide();
			$('#prev_movie_off').show();
		}

		$("#watch_menu_spinner").hide();
		$("#watch_menu_items").show();
	});
}

function loadNextMovie() {
	nmCode = window.nextMovie.code;
    nmType = window.nextMovie.type;
    nmId = window.nextMovie.mid;
    nmTitle = window.nextMovie.title;

    loadMovie(nmCode,nmType,nmId,nmTitle);
}

function loadPrevMovie() {
	nmCode = window.previousMovie.code;
    nmType = window.previousMovie.type;
    nmId = window.previousMovie.mid;
    nmTitle = window.previousMovie.title;

    loadMovie(nmCode,nmType,nmId,nmTitle);
}




// add youtube api handlers
window.onYouTubePlayerReady = function(playerId) {
    //alert('ready');
    var mPlayer = document.getElementById(playerId);
    mPlayer.addEventListener('onStateChange', 'onytplayerStateChange');
    mPlayer.playVideo();

    var requestFullScreen = playerElement.requestFullScreen || playerElement.mozRequestFullScreen || playerElement.webkitRequestFullScreen;
	  if (requestFullScreen) {
	    requestFullScreen.bind(mPlayer)();
	  }
	  else {
	  	alert('no full');
	  }
}
window.onytplayerStateChange = function(newState){
  switch (newState) {
    case 0:
      nmCode = window.nextMovie.code;
      nmType = window.nextMovie.type;
      nmId = window.nextMovie.mid;
      nmTitle = window.nextMovie.title;

      //console.log("playerStateChange send to 'loadNewMovie()' - mCounter=" + mCounter + " code=" + nmCode + " title=" + nmTitle);

      loadMovie(nmCode,nmType,nmId, nmTitle);
      break;
    case 1:
      //console.log('playing');
      break;
    case 2:
      //log('paused');
      break;
    case 3:
      //log('buffering');
      break;
    }
}



function loadPlayer(blockID, videoID) {
  swfobject.embedSWF('http://www.youtube.com/v/'+videoID+'?autostart=0&enablejsapi=1&playerapiid='+blockID, blockID, '320', '200', '8', null, null,
    { allowScriptAccess: 'always', wmode: 'transparent' },
    { id: blockID, name: blockID }
  );
}

window.onYouTubePlayerReady - function(playerid) {
	alert('player ready');
	vPlayer = document.getElementById("watcher");
	vPlayer.playVideo()
}

function muteMovie(objThis,mid,cid,mute) {
	nUrl = "/ajax/muteMovie.php?mid=" + mid + "&cid=" + cid + "&mute=" + mute;
	$.get(nUrl, function(data) {
		if(data == "success") {
			objBlock = $(objThis).closest(".movie_block");
			if(mute == 0) {
				objBlock.removeClass("muted");
			}
			else {
				objBlock.addClass("muted");
			}
		}
	});
}

function muteMovieWatch(mid,cid,mute)
{

	//console.log("mute= " + mute);

	nUrl = "/ajax/muteMovie.php?mid=" + mid + "&cid=" + cid + "&mute=" + mute;
	$.get(nUrl, function(data) {
		if(data == "success") {
			$("#watch_mute").addClass("black_button_activated");
			//alert('video was muted');
		}
	});
}

function deleteMovie(objThis, mid, cid) {
	var conf=confirm("Are you sure you wish to delete this video?");
	if (conf) {
		nUrl = "/ajax/deleteMovie.php?mid=" + mid + "&cid=" + cid;
		$.get(nUrl, function(data) {
		  //console.log("return from data: " + data);
			if(data == "success") {
				objBlock = $(objThis).closest(".movie_block");
				objBlock.hide();
			}
		});
	}
}

function deleteMovieWatch(mid, cid) {
	var conf=confirm("Are you sure you wish to delete this video?");
	if (conf) {
		nUrl = "/ajax/deleteMovie.php?mid=" + mid + "&cid=" + cid;
		$.get(nUrl, function(data) {
			if(data == "success") {
				//black_button_activated
				$("#watch_delete").addClass("black_button_activated");
				$("#watch_mute").addClass("black_button_activated");
				//alert('video was deleted');
			}
		});
	}
}

function showWatchMenu() {
	$("#watch_menu").height("80");
	console.log("show menu");
}

function hideWatchMenu() {
	$("#watch_menu").height("10");
	console.log("hide menu");
}

function checkReg() {
	//reset errors
	$(".error").html("");

	//set vals
	isValid=true;
	hasPass=true;
	uName = $("#username").val();
	pass1 = $("#password1").val();
	pass2 = $("#password2").val();
	email = $("#email").val();
	$("#username").removeClass("error");
	$("#password1").removeClass("error");
	$("#password2").removeClass("error");
	$("#email").removeClass("error");

	//do validation
	if(uName.length<1) {
		$("#uname_error").html("Please enter a username");
		$("#username").addClass("error");
		isValid=false;
	}
	if(pass1.length<1) {
		$("#p1_error").html("Please enter a password");
		$("#password1").addClass("error");
		isValid=false;
		hasPass=false;
	}
	if(pass2.length<1) {
		$("#p2_error").html("Please enter a password");
		$("#password2").addClass("error");
		isValid=false;
		hasPass=false;
	}
	if(hasPass) {
		if(pass1 != pass2) {
			$("#p2_error").html("the passwords do not match");
			$("#password1").addClass("error");
			$("#password2").addClass("error");
			isValid=false;
		}
	}
	if(email.length<1) {
		$("#email_error").html("Please enter an email address");
		$("#email").addClass("error");
		isValid=false;
	}
	else {
		if(!validateEmail($("#email").val())) {
			//console.log('not pass email');
			$("#email_error").html("please use a valid email");
			$("#email").addClass("error");
			isValid=false;
		}
	}
	return isValid;
}

function checkLogin() {
	$("#email_error").html("");
	$("#pass_error").html("");
	$("#email").removeClass("error");
	$("#password").removeClass("error");
	//sET VALS
	isValid=true;
	email=$("#email").val();
	passw=$("#password").val();
	//validate
	if(email.length<1) {
		$("#email_error").html("Please enter your email address");
		$("#email").addClass("error");
		isValid=false;
	}
	else {
		if(!validateEmail($("#email").val()))
		{
			$("#email_error").html("Please enter a valid email address");
			$("#email").addClass("error");
			isValid=false;
		}
	}
	if(passw.length<1) {
		$("#pass_error").html("Please enter a password");
		$("#password").addClass("error");
		isValid=false;
	}

	return isValid;

}

function checkPasswords() {
	//reset
	$("#p1_error").html("");
	$("#p2_error").html("");
	$("#password1").removeClass("error");
	$("#password2").removeClass("error");
	//GET VALS
	email1=$("#password1").val();
	email2=$("#password2").val();

	if(email1.length>0 && email2.length>0) {
		if(email1 != email2) {
			$("#p2_error").html("the passwords do not match");
			$("#password1").addClass("error");
			$("#password2").addClass("error");
		}
	}
}

function checkEmail() {
	//reset
	$("#email_error").html("");
	$("#email").removeClass("error");
	email=$("#email").val();
	if(email.length>0  && !validateEmail($("#email").val())) {
		$("#email_error").html("please use a valid email");
		$("#email").addClass("error");
	}
}


function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function moveToTop(){
	alert('not implemented yet');
}


function moveToBottom() {
	alert('not implemented yet');
}



















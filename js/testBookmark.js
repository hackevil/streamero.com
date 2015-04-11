
javascript:strId="streamero_frame";saveURL="http://www.streamero.com/bookmarkMovie.php?link="+encodeURIComponent(window.location);if(document.getElementById(strId)){fframe=document.getElementById(strId);fframe.parentNode.removeChild(fframe);}objIFRAME=document.createElement("iframe");objIFRAME.id=strId;objIFRAME.src=saveURL;document.body.appendChild(objIFRAME);void(0);

javascript:strId="streamero_frame";objIFRAME=document.createElement("iframe");objIFRAME.id=strId;saveURL="http://www.streamero.com/bookmarkMovie.php?link="+encodeURIComponent(window.location);objIFRAME.src=saveURL;document.body.appendChild(objIFRAME);void(0);


function testBookmark() {
	//alert(window.location);

	strId = "streamero_frame";

	testFrame =

	//remove frame if it exists
	if($(document).find(strId).length > 0) {
		$(document).remove(strId);
	}

	var objIFRAME=document.createElement("iframe");
	objIFRAME.id=strId;

	saveURL = "http://www.streamero.com/bookmarkMovie.php?link=" + encodeURIComponent(window.location);

	objIFRAME.src= saveURL;

	objIFRAME.onload=function() {
		//this.style.visibility="visible"
		//alert('frame loaded');
	};

	document.body.appendChild(objIFRAME);
}



document.getElementById(strId).length


javascript:strId="streamero_frame";saveURL="http://www.streamero.com/bookmarkMovie.php?link="+encodeURIComponent(window.location);if(document.getElementById(strId)){alert('frame is here');}objIFRAME=document.createElement("iframe");objIFRAME.id=strId;objIFRAME.src=saveURL;document.body.appendChild(objIFRAME);void(0);


javascript:strId="streamero_frame";saveURL="http://www.streamero.com/bookmarkMovie.php?link="+encodeURIComponent(window.location);if(document.getElementById(strId)){fframe=document.getElementById(strId);fframe.parentNode.removeChild(fframe);}objIFRAME=document.createElement("iframe");objIFRAME.id=strId;objIFRAME.src=saveURL;document.body.appendChild(objIFRAME);void(0);



javascript:strId="streamero_frame";saveURL="http://www.streamero.com/bookmarkMovie.php?link="+encodeURIComponent(window.location);if(document.getElementById(strId)){document.removeChild(document.getElementById(strId));}objIFRAME=document.createElement("iframe");objIFRAME.id=strId;objIFRAME.src=saveURL;document.body.appendChild(objIFRAME);void(0);


strId="streamero_frame";document.removeChild(document.getElementById(strId));

fframe=document.getElementById(strId);fframe.parentNode.removeChild(strId);

.parentNode.removeChild(frameid);




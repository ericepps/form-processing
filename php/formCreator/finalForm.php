<?php
foreach($_POST as $key=>$value) {
	if (is_array($value)) {
		foreach($value as $key2=>$value2) {
			$clean[$key][$key2]=htmlspecialchars($value2);
		}
	} else {
		$clean[$key]=htmlspecialchars($value);
	}
}

$fullForm = $clean['fullForm'];
$fullFormPreview = str_replace('<\/textarea>','</textarea>',str_replace('&gt;','>',str_replace('&lt;','<',str_replace('&quot;','"',$clean['fullForm']))));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Form Creator - Complete Form</title>
<link type="text/css" rel="stylesheet" href="http://www.svcc.edu/css/forms.css" />
<style type="text/css">
ol>fieldset { margin-top:15px; }
html, body { font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif; font-size:12px; }
iframe#frame_fullForm { position:absolute; }
body { margin: 0px; padding: .25%; }
</style>
<script language="javascript" type="text/javascript" src="/~eppse/edit_area/edit_area_full.js"></script>
<script type="text/javascript">
function showElement(elName) {
	document.getElementById(elName).style.display = 'block';
	window.location.hash=elName;
}
function showElementInline(elName) {
	document.getElementById(elName).style.display = 'inline';
}
function hideElement(elName) {
	document.getElementById(elName).style.display = 'none';
}
function toggleElementB(elName) {
	var currentState = document.getElementById(elName).style.display;
	if (currentState == 'block') {
		hideElement(elName);	
	} else if (currentState == 'none') {
		showElement(elName);
	}
}
function toggleElementI(elName) {
	var currentState = document.getElementById(elName).style.display;
	if (currentState == 'inline') {
		hideElement(elName);	
	} else if (currentState == 'none') {
		showElementInline(elName);
	}
}
function jsHide() {
	var jsHide = getElementsByClassName(document,'li','jsHide');
	for (var i=0;i<jsHide.length;i++) {
		jsHide[i].style.display = 'none';
	}
}
function jsShow() {
	var jsShow = getElementsByClassName(document,'li','jsShow');
	for (var i=0;i<jsShow.length;i++) {
		jsShow[i].style.display = 'block';
	}
}
/*
	Written by Jonathan Snook, http://www.snook.ca/jonathan
	Add-ons by Robert Nyman, http://www.robertnyman.com
*/
function getElementsByClassName(oElm, strTagName, strClassName)
{
	var arrElements = (strTagName == "*" && oElm.all)? oElm.all : oElm.getElementsByTagName(strTagName);
	var arrReturnElements = new Array();
	strClassName = strClassName.replace(/\-/g, "\\-");
	var oRegExp = new RegExp("(^|\\s)" + strClassName + "(\\s|$)");
	var oElement;
	for(var i=0; i<arrElements.length; i++){
		oElement = arrElements[i];
		if(oRegExp.test(oElement.className)){
			arrReturnElements.push(oElement);
		}
	}
	return (arrReturnElements)
}
function finishForm() {
	var finishedForm = document.getElementById('previousQuestions').value;
	finishedForm = finishedForm + '<li class="submitButton"><input type="submit" /></li></ol></fieldset></form>';
	document.getElementById('formContents').value = finishedForm;
}
// initialize code coloring
// http://www.cdolivet.com/index.php?page=editArea
editAreaLoader.init({ id : "fullForm", syntax: "html", start_highlight: true, allow_toggle: false });
</script>
<link href="http://www.svcc.edu/css/forms.css" rel="stylesheet" type="text/css">
</head>

<body>
<form method="post" action="finalForm.php">
<ol class="nobullet nopadding">
<textarea name="fullForm" id="fullForm" style="width:99.5%;height:45%;display:block;top:0px;position:absolute;"><?php echo $fullForm; ?></textarea>
<li class="submitButton" style="top:48%;display:block;position:absolute;""><input type="submit" value=" Finish Form > " /></li>
</form>
<div style="width:98.5%;height:45%; padding:.5%; background-color:#ddd; overflow:scroll;position:absolute;bottom:0px;"><h2>Preview:</h2><?php echo $fullFormPreview; ?></div>
<script type="text/javascript">jsHide();</script>
</body>
</html>
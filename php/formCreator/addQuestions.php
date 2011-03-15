<?php
if (is_numeric($_POST['qNum'])) {
	$questionNumber = $_POST['namePrefix'] . "q" . $_POST['qNum'];
} else {
	$questionNumber = $_POST['namePrefix'] . $_POST['qNum'];
}
$required = '';
$validation = '';
if ($_POST['qRequired'] == 'Y') $required = ' required';
if ($_POST['qvEmailAddress'] == 'Y') $validation = 'onblur="validateEmail(this);"';
if ($_POST['qvPhoneNumber'] == 'Y') $validation = 'onblur="formatPhoneNum(this);"';
if ($_POST['qvSSN'] == 'Y') $validation = 'onblur="validateSSN(this);"';
if ($_POST['qvZip'] == 'Y') $validation = 'onblur="formatZip(this);"';
if ($_POST['qvnDecimal'] != 'N') $validation = 'onblur="'.$_POST['qvnDecimal'].'(this,'.$_POST['qvnMinimum'].','.$_POST['qvnMaximum'].','.$_POST['qvnExact'].');"';

$tfQuestion = trim($_POST['tfQuestion']);
$tfQuestionCode = str_replace('"',"'",$tfQuestion);
$laQuestion = trim($_POST['laQuestion']);
$laQuestionCode = str_replace('"',"'",$laQuestion);
$saQuestion = trim($_POST['saQuestion']);
$saQuestionCode = str_replace('"',"'",$saQuestion);
$mcQuestion = trim($_POST['mcQuestion']);
$mcQuestionCode = str_replace('"',"'",$mcQuestion);
$mcQ = "\n\n";

if ($tfQuestion != '') {
	$mcQ .= '<li><fieldset id="' . $questionNumber . '" class="trueFalse">' . "\n  " . '<legend>' . $tfQuestion . '</legend>' . "\n  " . '<div class="nopadding"><ol>' . "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 't" name="' . $questionNumber . '" title="' . $tfQuestionCode . '" value="True" type="radio" '.$validation.'/><label class="besideRight" for="' . $questionNumber . 't">True</label></li>' . "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 'f" name="' . $questionNumber . '" title="' . $tfQuestionCode . '" value="False" type="radio" /><label class="besideRight" for="' . $questionNumber . 'f">False</label></li>' . "\n" . '</ol></div></fieldset></li>';
}

if ($laQuestion != '') {
	$mcQ .= '<li class="">' . "\n  " . '<label for="' . $questionNumber . '">' . $laQuestion . '</label>' . "\n  " . '<textarea id="' . $questionNumber . '" name="' . $questionNumber . '" title="' . $laQuestionCode . '" cols="' . $_POST['laColumns'] . '" rows="' . $_POST['laRows'] . '" class="' . $required . '"><\/textarea>' . "\n" . '</li>';
}

if ($saQuestion != '') {
	$maxlength = '';
	if (is_numeric($_POST['saMaxLength'])) $maxlength = ' maxlength="'.$_POST['saMaxLength'].'"';
	$mcQ .= '<li class="">' . "\n  " . '<label for="' . $questionNumber . '">' . $saQuestion . '</label>' . "\n  " . '<input class="' . $required . '" id="' . $questionNumber . '" name="' . $questionNumber . '"'.$maxlength.' title="' . $saQuestionCode . '" type="text" '.$validation.'/>' . "\n" . '</li>';
}

if ($mcQuestion != '') {
	$mcQ .= '<li><fieldset id="' . $questionNumber . '" class="multipleChoice">' . "\n  " . '<legend>' . $mcQuestion . '</legend>' . "\n  " . '<div class="nopadding"><ol>';
    if ($_POST['answerA'] != '') {
        $mcQ .= "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 'a" name="' . $questionNumber . '" title="' . $mcQuestionCode . '" value="a" type="radio" /><label class="besideRight" for="' . $questionNumber . 'a">' . $_POST['answerA'] . '</label></li>'; 
    }
    if ($_POST['answerB'] != '') {
        $mcQ .= "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 'b" name="' . $questionNumber . '" title="' . $mcQuestionCode . '" value="b" type="radio" /><label class="besideRight" for="' . $questionNumber . 'b">' . $_POST['answerB'] . '</label></li>'; 
    }
    if ($_POST['answerC'] != '') {
        $mcQ .= "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 'c" name="' . $questionNumber . '" title="' . $mcQuestionCode . '" value="c" type="radio" /><label class="besideRight" for="' . $questionNumber . 'c">' . $_POST['answerC'] . '</label></li>'; 
    }
    if ($_POST['answerD'] != '') {
        $mcQ .= "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 'd" name="' . $questionNumber . '" title="' . $mcQuestionCode . '" value="d" type="radio" /><label class="besideRight" for="' . $questionNumber . 'd">' . $_POST['answerD'] . '</label></li>'; 
    }
    if ($_POST['answerE'] != '') {
        $mcQ .= "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 'e" name="' . $questionNumber . '" title="' . $mcQuestionCode . '" value="e" type="radio" /><label class="besideRight" for="' . $questionNumber . 'e">' . $_POST['answerE'] . '</label></li>'; 
    }
    if ($_POST['answerF'] != '') {
        $mcQ .= "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 'f" name="' . $questionNumber . '" title="' . $mcQuestionCode . '" value="f" type="radio" /><label class="besideRight" for="' . $questionNumber . 'f">' . $_POST['answerF'] . '</label></li>';
    }
    if ($_POST['answerG'] != '') {
        $mcQ .= "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 'g" name="' . $questionNumber . '" title="' . $mcQuestionCode . '" value="g" type="radio" /><label class="besideRight" for="' . $questionNumber . 'g">' . $_POST['answerG'] . '</label></li>'; 
    }
    if ($_POST['answerH'] != '') {
        $mcQ .= "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 'h" name="' . $questionNumber . '" title="' . $mcQuestionCode . '" value="h" type="radio" /><label class="besideRight" for="' . $questionNumber . 'h">' . $_POST['answerH'] . '</label></li>';
    }
	$mcQ .= "\n" . '</ol></div></fieldset></li>'; 
}

$fullForm = $_POST['previousQuestions'] . str_replace('class=" ','class="',str_replace(' class=""','',$mcQ));
$namePrefix = $_POST['namePrefix'];
if ($_POST['qNum'] < 1) { $qNum = 1; } else { $qNum = $_POST['qNum'] + 1; }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Form Creator</title>
<link type="text/css" rel="stylesheet" href="http://www.svcc.edu/css/forms.css" />
<style type="text/css">
ol>fieldset { margin-top:15px; }
</style>
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
</script>
</head>

<body>
<form method="post" action="addQuestions.php">
<textarea name="previousQuestions" style="width:99.5%;" rows="10" wrap="off">
<?php echo $fullForm; ?>
</textarea>
<ol class="nobullet nopadding">
<fieldset title="Question Options">
<legend>Question Options</legend>
    <li class="floatLeft">
        <label for="namePrefix">Name Prefix <span class="entryExample">(section number, etc.)</span></label>
        <input class="xsWidth" id="namePrefix" name="namePrefix" title="Name Prefix" value="<?php echo $namePrefix; ?>" type="text" />
    </li>
    <li class="floatLeft">
        <label for="qNum">Question Number <span class="entryExample">(or name, combined with Prefix if applicable)</span></label>
        <input type="text" name="qNum" value="<?php echo $qNum; ?>" id="qNum" />
    </li>
    <li class="clearLeft">
        <input id="qRequired" name="qRequired" title="Required?" value="Y" type="checkbox" />
        <label class="besideRight" for="qRequired"><strong>Is this question required?</strong></label>
    </li>
</fieldset>

<!--  SHORT ANSWER  -->
<fieldset title="Short Answer">
<legend><a href="javascript:toggleElementB('shortAnswer');">Short Answer</a></legend>
<li class="jsHide" id="shortAnswer">
    <label for="saQuestion">Question</label>
    <input class="xlWidth" id="saQuestion" name="saQuestion" title="Short Answer Question" type="text" /><br />
    <ul class="nopadding">
    <li>
	    <label for="saMaxLength">Maximum Length</label>
    	<input maxlength="3" class="xsWidth" id="saMaxLength" name="saMaxLength" title="Maximum Length" type="text" />
	</li>
    <fieldset title="Validation">
        <legend>Validation</legend>
        <li>
            <fieldset title="Presets">
            <legend>Presets</legend>
            <ol>
                <li><input id="qvEmailAddress" name="qValidation" title="Email Address" value="Y" type="radio" />
                <label class="besideRight" for="qvEmailAddress">Email Address</label></li>
                <li><input id="qvPhoneNumber" name="qValidation" title="Phone Number" value="Y" type="radio" />
                <label class="besideRight" for="qvPhoneNumber">Phone Number</label></li>
                <li><input id="qvSSN" name="qValidation" title="SSN" value="Y" type="radio" />
                <label class="besideRight" for="qvSSN">SSN</label></li>
                <li><input id="qvZip" name="qValidation" title="Zip Code (5-digit)" value="Y" type="radio" />
                <label class="besideRight" for="qvZip">Zip Code</label></li>
            </ol>
            </fieldset>
        </li>
            <fieldset title="Numbers">
            <legend>Numbers</legend>
                <li>
                    <fieldset title="Require Numeric Input?">
                        <legend>Require Numeric Input?</legend>
                        <div class="nopadding">
                            <ol>
                                <li><input id="qvnNumericD" name="qvnDecimal" title="Yes, with decimals" value="validateDecNumber" type="radio" />
                                <label class="besideRight" for="qvnNumericD">Yes, with decimals</label></li>
                                <li><input id="qvnDecimalY" name="qvnDecimal" title="Yes, without decimals" value="validateNumber" type="radio" />
                                <label class="besideRight" for="qvnDecimalY">Yes, without decimals</label></li>
                                <li><input id="qvnDecimalN" name="qvnDecimal" title="No" value="N" type="radio" checked="checked" />
                                <label class="besideRight" for="qvnDecimalN">No</label></li>
                            </ol>
                        </div>
                    </fieldset>
                </li>
                <li class="floatLeft">
                    <label for="qvnMinimum">Minimum Characters <span class="entryExample">(0 to ignore)</span></label>
                    <input class="" id="qvnMinimum" name="qvnMinimum" title="Minimum Characters" type="text" value="0" />
                </li>
                <li class="floatLeft">
                    <label for="qvnMaximum">Maximum Characters <span class="entryExample">(0 to ignore)</span></label>
                    <input class="" id="qvnMaximum" name="qvnMaximum" title="Maximum  Characters" type="text" value="0" />
                </li>
                <li class="floatLeft">
                    <label for="qvnExact">Exact Characters <span class="entryExample">(0 to ignore)</span></label>
                    <input class="" id="qvnExact" name="qvnExact" title="Exact Characters" type="text" value="0" />
                </li>
            </fieldset>
    </fieldset>
    </ul>
</li>
</fieldset>

<!--  MULTIPLE CHOICE  -->
<fieldset title="Multiple Choice">
<legend><a href="javascript:toggleElementB('multipleChoice');">Multiple Choice</a></legend>
<li class="jsHide" id="multipleChoice">
    <label for="mcQuestion">Question</label>
    <input class="xlWidth" id="mcQuestion" name="mcQuestion" title="Multiple Choice Question" type="text" />
    <ol type="A">
        <li>
            <label for="">Answer A</label>
            <input class="xlWidth" id="answerA" name="answerA" title="Answer A" type="text" />
        </li>
        <li>
            <label for="">Answer B</label>
            <input class="xlWidth" id="answerB" name="answerB" title="Answer B" type="text" />
        </li>
        <li>
            <label for="">Answer C</label>
            <input class="xlWidth" id="answerC" name="answerC" title="Answer C" type="text" />
        </li>
        <li>
            <label for="">Answer D</label>
            <input class="xlWidth" id="answerD" name="answerD" title="Answer D" type="text" />
        </li>
        <li>
            <label for="">Answer E</label>
            <input class="xlWidth" id="answerE" name="answerE" title="Answer E" type="text" />
        </li>
        <li>
            <label for="">Answer F</label>
            <input class="xlWidth" id="answerF" name="answerF" title="Answer F" type="text" />
        </li>
        <li>
            <label for="">Answer G</label>
            <input class="xlWidth" id="answerG" name="answerG" title="Answer G" type="text" />
        </li>
        <li>
            <label for="">Answer H</label>
            <input class="xlWidth" id="answerH" name="answerH" title="Answer H" type="text" />
        </li>
    </ol>
</li>
</fieldset>

<!--  TRUE/FALSE  -->
<fieldset title="True/False">
<legend><a href="javascript:toggleElementB('trueFalse');">True/False</a></legend>
<li class="jsHide" id="trueFalse">
    <label for="tfQuestion">Question</label>
    <input class="xlWidth" id="tfQuestion" name="tfQuestion" title="True/False Question" type="text" />
</li>
</fieldset>

<!--  LONG ANSWER  -->
<fieldset title="Long Answer">
<legend><a href="javascript:toggleElementB('longAnswer');">Long Answer</a></legend>
<li class="jsHide" id="longAnswer">
    <label for="laQuestion">Question</label>
    <input class="xlWidth" id="laQuestion" name="laQuestion" title="Long Answer Question" type="text" />
    <ol>
        <li class="">
            <label for="laRows">Rows</label>
            <input class="xsWidth" id="laRows" name="laRows" title="Rows" type="text" />
        </li>
        <li class="">
            <label for="laColumns">Columns</label>
            <input class="xsWidth" id="laColumns" name="laColumns" title="Columns" type="text" />
        </li>
    </ol>
</li>
</fieldset>
<li class="submitButton" style="text-align:center; clear:left;"><input type="submit" /></li>
</ol>
</form>
<script type="text/javascript">jsHide();</script>
</body>
</html>
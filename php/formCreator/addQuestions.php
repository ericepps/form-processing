<?php
if (is_numeric($_POST['qNum'])) {
	$questionNumber = $_POST['namePrefix'] . "q" . $_POST['qNum'];
} else {
	$questionNumber = $_POST['namePrefix'] . $_POST['qNum'];
}
$required = '';
$validation = '';
if ($_POST['qHelp'] != '') $helptext = '<span class="entryExample">'.$_POST['qHelp'].'</span>';
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
$cbQuestion = trim($_POST['cbQuestion']);
$cbQuestionCode = str_replace('"',"'",$cbQuestion);
$mcQ = "\n\n";

// TRUE/FALSE
if ($tfQuestion != '') {
	$mcQ .= '<li><fieldset id="' . $questionNumber . '" class="trueFalse">' . "\n  " . '<legend>' . $tfQuestion . ' ' . $helptext . '</legend>' . "\n  " . '<div class="nopadding"><ol>' . "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 't" name="' . $questionNumber . '" title="' . $tfQuestionCode . '" value="True" type="radio" '.$validation.'/><label class="besideRight" for="' . $questionNumber . 't">True</label></li>' . "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 'f" name="' . $questionNumber . '" title="' . $tfQuestionCode . '" value="False" type="radio" /><label class="besideRight" for="' . $questionNumber . 'f">False</label></li>' . "\n" . '</ol></div></fieldset></li>';
}

// LONG ANSWER
if ($laQuestion != '') {
	$mcQ .= '<li class="">' . "\n  " . '<label for="' . $questionNumber . '">' . $laQuestion . ' ' . $helptext . '</label>' . "\n  " . '<textarea id="' . $questionNumber . '" name="' . $questionNumber . '" title="' . $laQuestionCode . '" cols="' . $_POST['laColumns'] . '" rows="' . $_POST['laRows'] . '" class="' . $required . '"><\/textarea>' . "\n" . '</li>';
}

// SHORT ANSWER
if ($saQuestion != '') {
	$maxlength = '';
	if (is_numeric($_POST['saMaxLength'])) $maxlength = ' maxlength="'.$_POST['saMaxLength'].'"';
	$mcQ .= '<li class="">' . "\n  " . '<label for="' . $questionNumber . '">' . $saQuestion . ' ' . $helptext . '</label>' . "\n  " . '<input class="' . $required . '" id="' . $questionNumber . '" name="' . $questionNumber . '"'.$maxlength.' title="' . $saQuestionCode . '" type="text" '.$validation.'/>' . "\n" . '</li>';
}

// MULTIPLE CHOICE
if ($mcQuestion != '') {
	if ($_POST['mcType'] == 'checkbox') {
		$questionNumber2 = $questionNumber . '[]';
		$questionType = 'checkbox';
	} else {
		$questionNumber2 = $questionNumber . '[]';
		$questionType = 'radio';
	}
	if ($_POST['mcType'] == 'select') {
		$mcQ .= '<li class="">' . "\n  " . '<label for="' . $questionNumber . '">' . $mcQuestion . ' ' . $helptext . '</label>' . "\n  " . '<select class="" id="' . $questionNumber . '" name="' . $questionNumber . '" title="' . $mcQuestion . '">';
		if ($_POST['answerA'] != '') {
			$mcValueCode = str_replace('"',"'",$_POST['valueA']);
			$mcQ .=  "\n    " . '<option value="'.$mcValueCode.'">' . $_POST['answerA'] . '</option>';
		}
		if ($_POST['answerB'] != '') {
			$mcValueCode = str_replace('"',"'",$_POST['valueB']);
			$mcQ .=  "\n    " . '<option value="'.$mcValueCode.'">' . $_POST['answerB'] . '</option>';
		}
		if ($_POST['answerC'] != '') {
			$mcValueCode = str_replace('"',"'",$_POST['valueC']);
			$mcQ .=  "\n    " . '<option value="'.$mcValueCode.'">' . $_POST['answerC'] . '</option>';
		}
		if ($_POST['answerD'] != '') {
			$mcValueCode = str_replace('"',"'",$_POST['valueD']);
			$mcQ .=  "\n    " . '<option value="'.$mcValueCode.'">' . $_POST['answerD'] . '</option>';
		}
		if ($_POST['answerE'] != '') {
			$mcValueCode = str_replace('"',"'",$_POST['valueE']);
			$mcQ .=  "\n    " . '<option value="'.$mcValueCode.'">' . $_POST['answerE'] . '</option>';
		}
		if ($_POST['answerF'] != '') {
			$mcValueCode = str_replace('"',"'",$_POST['valueF']);
			$mcQ .=  "\n    " . '<option value="'.$mcValueCode.'">' . $_POST['answerF'] . '</option>';
		}
		if ($_POST['answerG'] != '') {
			$mcValueCode = str_replace('"',"'",$_POST['valueG']);
			$mcQ .=  "\n    " . '<option value="'.$mcValueCode.'">' . $_POST['answerG'] . '</option>';
		}
		if ($_POST['answerH'] != '') {
			$mcValueCode = str_replace('"',"'",$_POST['valueH']);
			$mcQ .=  "\n    " . '<option value="'.$mcValueCode.'">' . $_POST['answerH'] . '</option>';
		}
		$mcQ .= "\n  </select></li>";
	} else {
		// either a radio or checkbox grouping
		$mcQ .= '<li><fieldset id="' . $questionNumber . '" class="multipleChoice">' . "\n  " . '<legend>' . $mcQuestion . ' ' . $helptext . '</legend>' . "\n  " . '<ol>';
		if ($_POST['answerA'] != '') {
			$mcValueCode = str_replace('"',"'",$_POST['valueA']);
			$mcQ .= "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 'A" name="' . $questionNumber2 . '" title="' . $mcQuestionCode . '" value="' . $mcValueCode . '" type="' . $questionType . '" /><label class="besideRight" for="' . $questionNumber . 'A">' . $_POST['answerA'] . '</label></li>'; 
		}
		if ($_POST['answerB'] != '') {
			$mcValueCode = str_replace('"',"'",$_POST['valueB']);
			$mcQ .= "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 'b" name="' . $questionNumber2 . '" title="' . $mcQuestionCode . '" value="' . $mcValueCode . '" type="' . $questionType . '" /><label class="besideRight" for="' . $questionNumber . 'b">' . $_POST['answerB'] . '</label></li>'; 
		}
		if ($_POST['answerC'] != '') {
			$mcValueCode = str_replace('"',"'",$_POST['valueC']);
			$mcQ .= "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 'c" name="' . $questionNumber2 . '" title="' . $mcQuestionCode . '" value="' . $mcValueCode . '" type="' . $questionType . '" /><label class="besideRight" for="' . $questionNumber . 'c">' . $_POST['answerC'] . '</label></li>'; 
		}
		if ($_POST['answerD'] != '') {
			$mcValueCode = str_replace('"',"'",$_POST['valueD']);
			$mcQ .= "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 'd" name="' . $questionNumber2 . '" title="' . $mcQuestionCode . '" value="' . $mcValueCode . '" type="' . $questionType . '" /><label class="besideRight" for="' . $questionNumber . 'd">' . $_POST['answerD'] . '</label></li>'; 
		}
		if ($_POST['answerE'] != '') {
			$mcValueCode = str_replace('"',"'",$_POST['valueE']);
			$mcQ .= "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 'e" name="' . $questionNumber2 . '" title="' . $mcQuestionCode . '" value="' . $mcValueCode . '" type="' . $questionType . '" /><label class="besideRight" for="' . $questionNumber . 'e">' . $_POST['answerE'] . '</label></li>'; 
		}
		if ($_POST['answerF'] != '') {
			$mcValueCode = str_replace('"',"'",$_POST['valueF']);
			$mcQ .= "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 'f" name="' . $questionNumber2 . '" title="' . $mcQuestionCode . '" value="' . $mcValueCode . '" type="' . $questionType . '" /><label class="besideRight" for="' . $questionNumber . 'f">' . $_POST['answerF'] . '</label></li>';
		}
		if ($_POST['answerG'] != '') {
			$mcValueCode = str_replace('"',"'",$_POST['valueG']);
			$mcQ .= "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 'g" name="' . $questionNumber2 . '" title="' . $mcQuestionCode . '" value="' . $mcValueCode . '" type="' . $questionType . '" /><label class="besideRight" for="' . $questionNumber . 'g">' . $_POST['answerG'] . '</label></li>'; 
		}
		if ($_POST['answerH'] != '') {
			$mcValueCode = str_replace('"',"'",$_POST['valueH']);
			$mcQ .= "\n    " . '<li><input class="' . $required . '" id="' . $questionNumber . 'h" name="' . $questionNumber2 . '" title="' . $mcQuestionCode . '" value="' . $mcValueCode . '" type="' . $questionType . '" /><label class="besideRight" for="' . $questionNumber . 'h">' . $_POST['answerH'] . '</label></li>';
		}
		$mcQ .= "\n" . '</ol></fieldset></li>'; 
	}
}

// SINGLE CHECKBOX
if ($cbQuestion != '') {
	$mcQ .= '<li class="">' . "\n  " . '<label class="besideRight" for="' . $questionNumber . '">' . "\n  " . '<input class="' . $required . '" id="' . $questionNumber . '" name="' . $questionNumber . '"'.$maxlength.' title="' . $cbQuestionCode . '" value="Y" type="checkbox" />' . $cbQuestion . ' ' . $helptext . '</label>' . "\n" . '</li>';
}

$fullForm = $_POST['previousQuestions'] . str_replace('class=" ','class="',str_replace(' class=""','',$mcQ));
$namePrefix = $_POST['namePrefix'];
if ($_POST['qNum'] < 1) { $qNum = 1; } else { $qNum = $_POST['qNum'] + 1; }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Form Creator - Add Questions</title>
<link type="text/css" rel="stylesheet" href="http://www.svcc.edu/css/forms.css" />
<style type="text/css">
ol>fieldset { margin-top:15px; }
html, body { font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif; font-size:12px; }
</style>
<script language="javascript" type="text/javascript" src="editarea/edit_area/edit_area_full.js"></script>
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
// initialize code coloring
// http://www.cdolivet.com/index.php?page=editArea
editAreaLoader.init({ id : "previousQuestions", syntax: "html", start_highlight: true, allow_toggle: false });
</script>
</head>

<body>
<form method="post" action="addQuestions.php">
<textarea name="previousQuestions" id="previousQuestions" style="width:99.5%;" rows="8" wrap="off">
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
    <li>
        <label for="qHelp">Help Text</label>
        <input type="text" name="qHelp" id="qHelp" class="xlWidth" />
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
<ol class="nobullet nopadding">
<li>
    <fieldset id="mcType" class="multipleChoice">
    <legend>Selection Type </legend>
    <ol>
        <li>
            <input id="mcTypeRadio" name="mcType" title="Selection Type" value="radio" type="radio" checked="checked" />
            <label class="besideRight" for="mcTypeRadio">Radio (select one)</label>
        </li>
        <li>
            <input id="mcTypeCheckbox" name="mcType" title="Selection Type" value="checkbox" type="radio" />
            <label class="besideRight" for="mcTypeCheckbox">Checkbox (select more than one)</label>
        </li>
        <li>
            <input id="mcTypeSelect" name="mcType" title="Selection Type" value="select" type="radio" />
            <label class="besideRight" for="mcTypeSelect">Select (drop-down, select one)</label>
        </li>
    </ol>
    </fieldset>
</li>
<li>
    <label for="mcQuestion">Question</label>
    <input class="xlWidth" id="mcQuestion" name="mcQuestion" title="Multiple Choice Question" type="text" />
    <ol type="A">
        <li>
            <label for="mcValueA" class="floatLeft" style="margin-right:1em;">Value A<br/>
            <input class="sWidth" id="mcValueA" name="valueA" title="Value A" type="text" value="a" />
            </label>
            <label for="answerA">Display A</label>
            <input class="xlWidth" id="answerA" name="answerA" title="Answer A" type="text" />
        </li>
        <li>
            <label for="mcValueB" class="floatLeft" style="margin-right:1em;">Value B<br/>
            <input class="sWidth" id="mcValueB" name="valueB" title="Value B" type="text" value="b" />
            </label>
            <label for="answerB">Display B</label>
            <input class="xlWidth" id="answerB" name="answerB" title="Answer B" type="text" />
        </li>
        <li>
            <label for="mcValueC" class="floatLeft" style="margin-right:1em;">Value C<br/>
            <input class="sWidth" id="mcValueC" name="valueC" title="Value C" type="text" value="c" />
            </label>
            <label for="answerC">Display C</label>
            <input class="xlWidth" id="answerC" name="answerC" title="Answer C" type="text" />
        </li>
        <li>
            <label for="mcValueD" class="floatLeft" style="margin-right:1em;">Value D<br/>
            <input class="sWidth" id="mcValueD" name="valueD" title="Value D" type="text" value="d" />
            </label>
            <label for="answerD">Display D</label>
            <input class="xlWidth" id="answerD" name="answerD" title="Answer D" type="text" />
        </li>
        <li>
            <label for="mcValueE" class="floatLeft" style="margin-right:1em;">Value E<br/>
            <input class="sWidth" id="mcValueE" name="valueE" title="Value E" type="text" value="e" />
            </label>
            <label for="answerE">Display E</label>
            <input class="xlWidth" id="answerE" name="answerE" title="Answer E" type="text" />
        </li>
        <li>
            <label for="mcValueF" class="floatLeft" style="margin-right:1em;">Value F<br/>
            <input class="sWidth" id="mcValueF" name="valueF" title="Value F" type="text" value="f" />
            </label>
            <label for="answerF">Display F</label>
            <input class="xlWidth" id="answerF" name="answerF" title="Answer F" type="text" />
        </li>
        <li>
            <label for="mcValueG" class="floatLeft" style="margin-right:1em;">Value G<br/>
            <input class="sWidth" id="mcValueG" name="valueG" title="Value G" type="text" value="g" />
            </label>
            <label for="answerG">Display G</label>
            <input class="xlWidth" id="answerG" name="answerG" title="Answer G" type="text" />
        </li>
        <li>
            <label for="mcValueH" class="floatLeft" style="margin-right:1em;">Value H<br/>
            <input class="sWidth" id="mcValueH" name="valueH" title="Value H" type="text" value="h" />
            </label>
            <label for="answerH">Display H</label>
            <input class="xlWidth" id="answerH" name="answerH" title="Answer H" type="text" />
        </li>
    </ol>
</li></ol>
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

<!--  SINGLE CHECKBOX  -->
<fieldset title="Single Checkbox">
<legend><a href="javascript:toggleElementB('singleCheckbox');">Single Checkbox</a></legend>
<li class="jsHide" id="singleCheckbox">
    <label for="cbQuestion">Question</label>
    <input class="xlWidth" id="cbQuestion" name="cbQuestion" title="Single Checkbox Question" type="text" />
</li>
</fieldset>

<li class="submitButton"><input type="submit" /></li>
</ol>
</form>
<script type="text/javascript">jsHide();</script>
</body>
</html>
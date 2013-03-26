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
$mySQLCreate = $clean['mySQLCreate'] . "\n";

// Coming from initial form setup page? Then set up initial form fields.
if ($clean['isInitial'] == 'Y') {
	$fullForm = '<form action="#" id="'.$clean['formShortName'].'" method="post" onsubmit="return checkRequired();">' . "\n  " . '<input name="formName" type="hidden" value="'.$clean['formShortName'].'"/>' . "\n  " . '<input name="isSubmitted" type="hidden" value="Y"/>' . "\n  ";
	if ($clean['formEmailSend'] == 'Y') {
		$fullForm .= '<input id="emailSend" name="emailSend" type="hidden" value="Y"/>' . "\n  ";
		$fullForm .= '<input id="emailRecipients" name="emailRecipients" type="hidden" value="'.$clean['formEmailRecipients'].'"/>' . "\n  ";
		$fullForm .= '<input id="emailSubject" name="emailSubject" type="hidden" value="'.$clean['formName'].'"/>' . "\n  ";
	}
	if ($clean['formEmailNotify'] == 'Y') {
		$fullForm .= '<input id="emailNotify" name="emailNotify" type="hidden" value="Y"/>' . "\n  ";
		$fullForm .= '<input id="emailNRecipients" name="emailNRecipients" type="hidden" value="'.$clean['formEmailNRecipients'].'"/>' . "\n  ";
		$fullForm .= '<input id="emailNotifyMessage" name="emailNotifyMessage" type="hidden" value="'.$clean['formNMessage'].'"/>' . "\n  ";
		$fullForm .= '<input id="emailNotifyHTML" name="emailNotifyHTML" type="hidden" value="'.$clean['formNHTML'].'" />' . "\n  ";
		$fullForm .= '<input id="emailSubject" name="emailSubject" type="hidden" value="'.$clean['formName'].'"/>' . "\n  ";
	}
	if ($clean['formDBInsert'] == 'Y') {
		$fullForm .= '<input id="dbInsert" name="dbInsert" type="hidden" value="Y"/>' . "\n  ";
		$mySQLCreate = "CREATE TABLE ".$clean['formShortName']." (\nid int(11) NOT NULL AUTO_INCREMENT,\n";
	}
	if ($clean['formDelimited'] == 'Y') {
		$fullForm .= '<input id="delimFile" name="delimFile" type="hidden" value="Y"/>' . "\n  ";
		$fullForm .= '<input id="delimType" name="delimType" type="hidden" value="'.$clean['formDelimType'][0].'"/>' . "\n  ";
	}
	$fullForm .= '<input id="formRedirect" name="formRedirect" type="hidden" value="'.$clean['formRedirect'].'"/>' . "\n  ";
	$fullForm .= '<fieldset><legend>'.$clean['formName'].'</legend>' . "\n  ";
	$fullForm .= '<ol class="nobullet">' . "\n  ";
}

if (is_numeric($clean['qNum'])) {
	$questionNumber = $clean['namePrefix'] . "q" . $clean['qNum'];
} else {
	$questionNumber = $clean['namePrefix'] . $clean['qNum'];
}
$classNames = '';
$liClassNames = '';
$validation = '';
if ($clean['qHelp'] != '') $helptext = '<span class="entryExample">'.$clean['qHelp'].'</span>';
if ($clean['qRequired'] == 'Y') $classNames = ' required ';
if ($clean['qWidth'] != '') $classNames .= $clean['qWidth'] . ' ';
if ($clean['qWrap'] != '') $liClassNames .= $clean['qWrap'] . ' ';
if ($clean['qEncrypt'] == 'Y') $classNames .= 'encrypt ';
if ($clean['qvEmailAddress'] == 'Y') $validation = 'onblur="validateEmail(this);"';
if ($clean['qvPhoneNumber'] == 'Y') $validation = 'onblur="formatPhoneNum(this);"';
if ($clean['qvSSN'] == 'Y') $validation = 'onblur="validateSSN(this);"';
if ($clean['qvZip'] == 'Y') $validation = 'onblur="formatZip(this);"';
if ($clean['qvnDecimal'] != 'N') $validation = 'onblur="'.$clean['qvnDecimal'].'(this,'.$clean['qvnMinimum'].','.$clean['qvnMaximum'].','.$clean['qvnExact'].');"';

$tfQuestion = trim($clean['tfQuestion']);
$tfQuestionCode = str_replace('"',"'",$tfQuestion);
$laQuestion = trim($clean['laQuestion']);
$laQuestionCode = str_replace('"',"'",$laQuestion);
$saQuestion = trim($clean['saQuestion']);
$saQuestionCode = str_replace('"',"'",$saQuestion);
$mcQuestion = trim($clean['mcQuestion']);
$mcQuestionCode = str_replace('"',"'",$mcQuestion);
$cbQuestion = trim($clean['cbQuestion']);
$cbQuestionCode = str_replace('"',"'",$cbQuestion);
$mcQ = "\n\n";

// TRUE/FALSE
if ($tfQuestion != '') {
	$tfFormat = $clean['tfFormat'][0];
	if ($tfFormat == 'YN') {
		$tfFormatShortT = 'Y';
		$tfFormatShortF = 'N';
		$tfFormatLongT = 'Yes';
		$tfFormatLongF = 'No';
	} else {
		$tfFormatShortT = 'T';
		$tfFormatShortF = 'F';
		$tfFormatLongT = 'True';
		$tfFormatLongF = 'False';
	}
	$mcQ .= '<li id="par-' . $questionNumber . '" class="' . $liClassNames . '"><fieldset id="' . $questionNumber . '" class="trueFalse">' . "\n  " . '<legend>' . $tfQuestion . ' ' . $helptext . '</legend>' . "\n  " . '<div class="nopadding"><ol>' . "\n    " . '<li><input class="' . $classNames . '" id="' . $questionNumber . $tfFormatShortT . '" name="' . $questionNumber . '[]" title="' . $tfQuestionCode . '" value="'. $tfFormatLongT . '" type="radio" '.$validation.'/><label class="besideRight" for="' . $questionNumber . $tfFormatShortT . '">'. $tfFormatLongT . '</label></li>' . "\n    " . '<li><input class="' . $classNames . '" id="' . $questionNumber . $tfFormatShortF . '" name="' . $questionNumber . '[]" title="' . $tfQuestionCode . '" value="'. $tfFormatLongF . '" type="radio" /><label class="besideRight" for="' . $questionNumber . $tfFormatShortF . '">'. $tfFormatLongF . '</label></li>' . "\n" . '</ol></div></fieldset></li>';
	if(trim($mySQLCreate) != '') $mySQLCreate .= ' ' . $questionNumber . ' VARCHAR(1) DEFAULT NULL,';
}

// LONG ANSWER
if ($laQuestion != '') {
	$mcQ .= '<li id="par-' . $questionNumber . '" class="' . $liClassNames . '">' . "\n  " . '<label for="' . $questionNumber . '">' . $laQuestion . ' ' . $helptext . '</label>' . "\n  " . '<textarea id="' . $questionNumber . '" name="' . $questionNumber . '" title="' . $laQuestionCode . '" cols="' . $clean['laColumns'] . '" rows="' . $clean['laRows'] . '" class="' . $classNames . '"><\/textarea>' . "\n" . '</li>';
	if(trim($mySQLCreate) != '') $mySQLCreate .= ' ' . $questionNumber . ' TEXT DEFAULT NULL,';
}

// SHORT ANSWER
if ($saQuestion != '') {
	$maxlength = '';
	if (is_numeric($clean['saMaxLength'])) $maxlength = ' maxlength="'.$clean['saMaxLength'].'"';
	$mcQ .= '<li id="par-' . $questionNumber . '" class="' . $liClassNames . '">' . "\n  " . '<label for="' . $questionNumber . '">' . $saQuestion . ' ' . $helptext . '</label>' . "\n  " . '<input class="' . $classNames . '" id="' . $questionNumber . '" name="' . $questionNumber . '"'.$maxlength.' title="' . $saQuestionCode . '" type="text" '.$validation.'/>' . "\n" . '</li>';
	if(trim($mySQLCreate) != '') {
		if ($maxlength == '') {
			$varchar = 100;
		} else {
			$varchar = $clean['saMaxLength'];
		}
		$mySQLCreate .= ' ' . $questionNumber . ' VARCHAR('.$varchar.') DEFAULT NULL,';
	}
}

// MULTIPLE CHOICE
if ($mcQuestion != '') {
	if ($clean['mcType'] == 'checkbox') {
		$questionNumber2 = $questionNumber . '[]';
		$questionType = 'checkbox';
	} else {
		$questionNumber2 = $questionNumber . '[]';
		$questionType = 'radio';
	}
	if ($clean['mcType'] == 'select') {
		$mcQ .= '<li id="par-' . $questionNumber . '" class="' . $liClassNames . '">' . "\n  " . '<label for="' . $questionNumber . '">' . $mcQuestion . ' ' . $helptext . '</label>' . "\n  " . '<select class="" id="' . $questionNumber . '" name="' . $questionNumber . '" title="' . $mcQuestion . '">';
		if ($clean['answerA'] != '') {
			$mcValueCode = str_replace('"',"'",$clean['valueA']);
			$mcQ .=  "\n    " . '<option value="'.$mcValueCode.'">' . $clean['answerA'] . '</option>';
		}
		if ($clean['answerB'] != '') {
			$mcValueCode = str_replace('"',"'",$clean['valueB']);
			$mcQ .=  "\n    " . '<option value="'.$mcValueCode.'">' . $clean['answerB'] . '</option>';
		}
		if ($clean['answerC'] != '') {
			$mcValueCode = str_replace('"',"'",$clean['valueC']);
			$mcQ .=  "\n    " . '<option value="'.$mcValueCode.'">' . $clean['answerC'] . '</option>';
		}
		if ($clean['answerD'] != '') {
			$mcValueCode = str_replace('"',"'",$clean['valueD']);
			$mcQ .=  "\n    " . '<option value="'.$mcValueCode.'">' . $clean['answerD'] . '</option>';
		}
		if ($clean['answerE'] != '') {
			$mcValueCode = str_replace('"',"'",$clean['valueE']);
			$mcQ .=  "\n    " . '<option value="'.$mcValueCode.'">' . $clean['answerE'] . '</option>';
		}
		if ($clean['answerF'] != '') {
			$mcValueCode = str_replace('"',"'",$clean['valueF']);
			$mcQ .=  "\n    " . '<option value="'.$mcValueCode.'">' . $clean['answerF'] . '</option>';
		}
		if ($clean['answerG'] != '') {
			$mcValueCode = str_replace('"',"'",$clean['valueG']);
			$mcQ .=  "\n    " . '<option value="'.$mcValueCode.'">' . $clean['answerG'] . '</option>';
		}
		if ($clean['answerH'] != '') {
			$mcValueCode = str_replace('"',"'",$clean['valueH']);
			$mcQ .=  "\n    " . '<option value="'.$mcValueCode.'">' . $clean['answerH'] . '</option>';
		}
		$mcQ .= "\n  </select></li>";
	} else {
		// either a radio or checkbox grouping
		$mcQ .= '<li id="par-' . $questionNumber . '" class="' . $liClassNames . '"><fieldset id="' . $questionNumber . '" class="multipleChoice">' . "\n  " . '<legend>' . $mcQuestion . ' ' . $helptext . '</legend>' . "\n  " . '<ol>';
		if ($clean['answerA'] != '') {
			$mcValueCode = str_replace('"',"'",$clean['valueA']);
			$mcQ .= "\n    " . '<li><input class="' . $classNames . '" id="' . $questionNumber . 'A" name="' . $questionNumber2 . '" title="' . $mcQuestionCode . '" value="' . $mcValueCode . '" type="' . $questionType . '" /><label class="besideRight" for="' . $questionNumber . 'A">' . $clean['answerA'] . '</label></li>'; 
		}
		if ($clean['answerB'] != '') {
			$mcValueCode = str_replace('"',"'",$clean['valueB']);
			$mcQ .= "\n    " . '<li><input class="' . $classNames . '" id="' . $questionNumber . 'B" name="' . $questionNumber2 . '" title="' . $mcQuestionCode . '" value="' . $mcValueCode . '" type="' . $questionType . '" /><label class="besideRight" for="' . $questionNumber . 'B">' . $clean['answerB'] . '</label></li>'; 
		}
		if ($clean['answerC'] != '') {
			$mcValueCode = str_replace('"',"'",$clean['valueC']);
			$mcQ .= "\n    " . '<li><input class="' . $classNames . '" id="' . $questionNumber . 'C" name="' . $questionNumber2 . '" title="' . $mcQuestionCode . '" value="' . $mcValueCode . '" type="' . $questionType . '" /><label class="besideRight" for="' . $questionNumber . 'C">' . $clean['answerC'] . '</label></li>'; 
		}
		if ($clean['answerD'] != '') {
			$mcValueCode = str_replace('"',"'",$clean['valueD']);
			$mcQ .= "\n    " . '<li><input class="' . $classNames . '" id="' . $questionNumber . 'D" name="' . $questionNumber2 . '" title="' . $mcQuestionCode . '" value="' . $mcValueCode . '" type="' . $questionType . '" /><label class="besideRight" for="' . $questionNumber . 'D">' . $clean['answerD'] . '</label></li>'; 
		}
		if ($clean['answerE'] != '') {
			$mcValueCode = str_replace('"',"'",$clean['valueE']);
			$mcQ .= "\n    " . '<li><input class="' . $classNames . '" id="' . $questionNumber . 'E" name="' . $questionNumber2 . '" title="' . $mcQuestionCode . '" value="' . $mcValueCode . '" type="' . $questionType . '" /><label class="besideRight" for="' . $questionNumber . 'E">' . $clean['answerE'] . '</label></li>'; 
		}
		if ($clean['answerF'] != '') {
			$mcValueCode = str_replace('"',"'",$clean['valueF']);
			$mcQ .= "\n    " . '<li><input class="' . $classNames . '" id="' . $questionNumber . 'F" name="' . $questionNumber2 . '" title="' . $mcQuestionCode . '" value="' . $mcValueCode . '" type="' . $questionType . '" /><label class="besideRight" for="' . $questionNumber . 'F">' . $clean['answerF'] . '</label></li>';
		}
		if ($clean['answerG'] != '') {
			$mcValueCode = str_replace('"',"'",$clean['valueG']);
			$mcQ .= "\n    " . '<li><input class="' . $classNames . '" id="' . $questionNumber . 'G" name="' . $questionNumber2 . '" title="' . $mcQuestionCode . '" value="' . $mcValueCode . '" type="' . $questionType . '" /><label class="besideRight" for="' . $questionNumber . 'g">' . $clean['answerG'] . '</label></li>'; 
		}
		if ($clean['answerH'] != '') {
			$mcValueCode = str_replace('"',"'",$clean['valueH']);
			$mcQ .= "\n    " . '<li><input class="' . $classNames . '" id="' . $questionNumber . 'H" name="' . $questionNumber2 . '" title="' . $mcQuestionCode . '" value="' . $mcValueCode . '" type="' . $questionType . '" /><label class="besideRight" for="' . $questionNumber . 'h">' . $clean['answerH'] . '</label></li>';
		}
		$mcQ .= "\n" . '</ol></fieldset></li>'; 
	}
	if(trim($mySQLCreate) != '') {
		$varchar = max(strlen($clean['valueA']),strlen($clean['valueB']),strlen($clean['valueC']),strlen($clean['valueD']),strlen($clean['valueE']),strlen($clean['valueF']),strlen($clean['valueG']),strlen($clean['valueH']))+1;
		$mySQLCreate .= ' ' . $questionNumber . ' VARCHAR('.$varchar.') DEFAULT NULL,';
	}
}

// SINGLE CHECKBOX
if ($cbQuestion != '') {
	$mcQ .= '<li id="par-' . $questionNumber . '" class="' . $liClassNames . '">' . "\n  " . '<label class="besideRight" for="' . $questionNumber . '">' . "\n  " . '<input class="' . $classNames . '" id="' . $questionNumber . '" name="' . $questionNumber . '"'.$maxlength.' title="' . $cbQuestionCode . '" value="Y" type="checkbox" />' . $cbQuestion . ' ' . $helptext . '</label>' . "\n" . '</li>';
	if(trim($mySQLCreate) != '') $mySQLCreate .= ' ' . $questionNumber . ' VARCHAR(1) DEFAULT NULL,';
}

$fullForm .= $clean['previousQuestions'] . str_replace('class=" ','class="',str_replace(' class=""','',$mcQ));
$namePrefix = $clean['namePrefix'];
if ($clean['qNum'] < 1) { $qNum = 1; } else { $qNum = $clean['qNum'] + 1; }
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
	document.getElementById('fullForm').value = finishedForm;
	var finishedMySQL = document.getElementById('prevMySQLCreate').value;
	if (finishedMySQL.trim() != '') {
		finishedMySQL = finishedMySQL + '\n' + ' PRIMARY KEY (id), UNIQUE KEY id_UNIQUE (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8';
		document.getElementById('mySQLCreate').value = finishedMySQL;
	}
}
// initialize code coloring
// http://www.cdolivet.com/index.php?page=editArea
editAreaLoader.init({ id : "previousQuestions", syntax: "html", start_highlight: true, allow_toggle: false });
</script>
</head>

<body>
<form method="post" action="finalForm.php" onsubmit="return finishForm()">
<ol class="nobullet nopadding">
<textarea name="fullForm" id="fullForm" style="position:absolute;width:10px;height:10px;left:-100px;top:-100px;"></textarea>
<textarea name="mySQLCreate" id="mySQLCreate" style="position:absolute;width:10px;height:10px;left:-100px;top:-100px;"></textarea>
<li class="submitButton"><input type="submit" value=" Finish Form > " /></li>
</ol>
</form>
<form method="post" action="addQuestions.php">
<textarea name="previousQuestions" id="previousQuestions" style="width:99.5%;" rows="12" wrap="off">
<?php echo $fullForm; ?>
</textarea>
<textarea name="mySQLCreate" id="prevMySQLCreate" style="width:99.5%;<?php echo (trim($mySQLCreate)==""?'display:none;':''); ?>" rows="5">
<?php echo $mySQLCreate; ?>
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
    <li>
        <label for="qWrap">Wrapping</label>
        <select name="qWrap" id="qWrap" size="3" multiple="multiple">
        	<option value="floatLeft">Wrap to Right (float:left)</option>
        	<option value="floatRight">Wrap to Left (float:right)</option>
        	<option value="floatNone">No Wrapping (float:none)</option>
        	<option value="clearLeft">Stop Wrap to Right (clear:left)</option>
        	<option value="clearRight">Stop Wrap to Left (clear:right)</option>
        	<option value="hide">Hidden</option>
		</select>
    </li>
    <li>
        <label for="qWidth">Width</label>
        <select name="qWidth" id="qWidth">
        	<option value=""></option>
            <option value="xxlWidth">XXL</option>
            <option value="xlWidth">XL</option>
            <option value="lWidth">L</option>
            <option value="mWidth">M</option>
            <option value="sWidth">S</option>
            <option value="xsWidth">XS</option>
            <option value="xxsWidth">XXS</option>
        </select>
	</li>
    <li class="clearLeft">
        <input id="qEncrypt" name="qEncrypt" title="Encrypt contents? (database)" value="Y" type="checkbox" />
        <label class="besideRight" for="qEncrypt">Encrypt contents? (database)</label>
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
            <label for="answerA">Display A<br />
            <input class="xlWidth" id="answerA" name="answerA" title="Answer A" type="text" />
            </label>
        </li>
        <li class="clearLeft">
            <label for="mcValueB" class="floatLeft" style="margin-right:1em;">Value B<br/>
            <input class="sWidth" id="mcValueB" name="valueB" title="Value B" type="text" value="b" />
            </label>
            <label for="answerB">Display B<br />
            <input class="xlWidth" id="answerB" name="answerB" title="Answer B" type="text" />
            </label>
        </li>
        <li class="clearLeft">
            <label for="mcValueC" class="floatLeft" style="margin-right:1em;">Value C<br/>
            <input class="sWidth" id="mcValueC" name="valueC" title="Value C" type="text" value="c" />
            </label>
            <label for="answerC">Display C<br />
            <input class="xlWidth" id="answerC" name="answerC" title="Answer C" type="text" />
            </label>
        </li>
        <li class="clearLeft">
            <label for="mcValueD" class="floatLeft" style="margin-right:1em;">Value D<br/>
            <input class="sWidth" id="mcValueD" name="valueD" title="Value D" type="text" value="d" />
            </label>
            <label for="answerD">Display D<br />
            <input class="xlWidth" id="answerD" name="answerD" title="Answer D" type="text" />
            </label>
        </li>
        <li class="clearLeft">
            <label for="mcValueE" class="floatLeft" style="margin-right:1em;">Value E<br/>
            <input class="sWidth" id="mcValueE" name="valueE" title="Value E" type="text" value="e" />
            </label>
            <label for="answerE">Display E<br />
            <input class="xlWidth" id="answerE" name="answerE" title="Answer E" type="text" />
            </label>
        </li>
        <li class="clearLeft">
            <label for="mcValueF" class="floatLeft" style="margin-right:1em;">Value F<br/>
            <input class="sWidth" id="mcValueF" name="valueF" title="Value F" type="text" value="f" />
            </label>
            <label for="answerF">Display F<br />
            <input class="xlWidth" id="answerF" name="answerF" title="Answer F" type="text" />
            </label>
        </li>
        <li class="clearLeft">
            <label for="mcValueG" class="floatLeft" style="margin-right:1em;">Value G<br/>
            <input class="sWidth" id="mcValueG" name="valueG" title="Value G" type="text" value="g" />
            </label>
            <label for="answerG">Display G<br />
            <input class="xlWidth" id="answerG" name="answerG" title="Answer G" type="text" />
            </label>
        </li>
        <li class="clearLeft">
            <label for="mcValueH" class="floatLeft" style="margin-right:1em;">Value H<br/>
            <input class="sWidth" id="mcValueH" name="valueH" title="Value H" type="text" value="h" />
            </label>
            <label for="answerH">Display H<br />
            <input class="xlWidth" id="answerH" name="answerH" title="Answer H" type="text" />
            </label>
        </li>
    </ol>
</li></ol>
</fieldset>

<!--  TRUE/FALSE  -->
<fieldset title="True/False">
<legend><a href="javascript:toggleElementB('trueFalse');">True/False or Yes/No</a></legend>
<li class="jsHide" id="trueFalse">
<ol class="nobullet nopadding">
<li>
    <label for="tfQuestion">Question</label>
    <input class="xlWidth" id="tfQuestion" name="tfQuestion" title="True/False Question" type="text" />
</li>
<li><fieldset id="tfFormat" class="multipleChoice">
  <legend>Format </legend>
  <ol>
    <li><input id="tfFormatA" name="tfFormat[]" title="Format" value="YN" type="radio" /><label class="besideRight" for="tfFormatYN">Yes/No</label></li>
    <li><input id="tfFormatb" name="tfFormat[]" title="Format" value="TF" type="radio" /><label class="besideRight" for="tfFormatTF">True/False</label></li>
</ol></fieldset></li>
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

<li class="submitButton"><input type="submit" value=" Add Question ^ " /></li>
</ol>
</form>
<script type="text/javascript">jsHide();</script>
</body>
</html>
<?php
$fbFArray = array('F1','F2','F3','F4','F5','F6','F7','F8','F9','F10','F11','F12','F13','F14','F15','F16','F17','F18','F19','F20');
$fbFieldArray = array('FBField1','FBField2','FBField3','FBField4','FBField5','FBField6','FBField7','FBField8','FBField9','FBField10','FBField11','FBField12','FBField13','FBField14','FBField15','FBField16','FBField17','FBField18','FBField19','FBField20');
$fbFileName = "";
$message = '<!DOCTYPE html><html lang="en-us"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><link href="http://www.svcc.edu/css/svcc.css" rel="stylesheet" type="text/css" /><link href="http://www.svcc.edu/css/fbforms.css" rel="stylesheet" type="text/css" /></head><body><dl>';
$arrayList = "";
foreach($_POST as $key=>$value) {
	foreach($sendingFormElement as $key2=>$value2) {
		$value2 = str_replace('[]','',$value2);
		if (strpos(substr(getStringByStartEnd($value2,'class="','"'),7,strlen(getStringByStartEnd($value2,'class="','"'))-8),'exclude') === FALSE && strpos(substr(getStringByStartEnd($value2,'type="','"'),6,strlen(getStringByStartEnd($value2,'type="','"'))-7),'hidden') === FALSE && strpos(substr(getStringByStartEnd($value2,'type="','"'),6,strlen(getStringByStartEnd($value2,'type="','"'))-7),'submit') === FALSE) {
			if (substr(getStringByStartEnd($value2,'name="','"'),6,strlen(getStringByStartEnd($value2,'name="','"'))-7) == $key) {
				$currentFormElementName = substr(getStringByStartEnd($value2,'title="','"'),7,strlen(getStringByStartEnd($value2,'title="','"'))-8);
				if (strpos($arrayList, $currentFormElementName) === false) {
					$message .= "<dt><strong>".substr(getStringByStartEnd($value2,'title="','"'),7,strlen(getStringByStartEnd($value2,'title="','"'))-8)."</strong>&nbsp;</dt>";
					if (is_array($value)) {
						foreach($value as $value3) {
							$message .= "<dd>".$value3."&nbsp;</dd>";
						}
						$arrayList .= $currentFormElementName.",";
					} else {
						$message .= "<dd>".nl2br($value)."&nbsp;</dd>";
					}
				}
			}
		}
	}
}
$message .= "</dl></body></html>";
foreach($fbFieldArray as $value) {
	if (!in_array($_POST[$value],$fbFArray)) {
		$formField = $_POST[$value];
		$fbFileName .= '~' . $_POST[$formField];
	}
}
// added to help combat spam submits
if ($spam == false) {
	$fp = fopen($attachDir.$uniqueFormID.$fbFileName.".htm", 'x');
	$resultWrite = fwrite($fp, $message);
	fclose($fp);
}
?>
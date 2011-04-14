<?php
// include the file that contains all the server-specific defaults
include('formDefaults.php');

if ($debugForms) { ini_set('display_errors','on'); }

if (isset($_POST['isSubmitted'])) {
if ($_POST['isSubmitted'] == 'Y') {

$uniqueFormID = htmlspecialchars($_POST['formName']).'-'.date('YzHis').'-'.rand(0,9999);

if (isset($_SERVER['HTTPS'])) {
	$protocol = 'https://';
} else {
	$protocol = 'http://';
}

if (substr($_SERVER['HTTP_REFERER'],strlen($_SERVER['HTTP_REFERER'])-1) == '/') {
	$uriFileName = $_SERVER['DOCUMENT_ROOT'].str_replace($protocol.$_SERVER['HTTP_HOST'],'',$_SERVER['HTTP_REFERER']).'index.html'; 
} else {
	$uriFileName = $_SERVER['DOCUMENT_ROOT'].str_replace($protocol.$_SERVER['HTTP_HOST'],'',$_SERVER['HTTP_REFERER']);
}

/*********************************************************************************************
*                                   getStringByStartEnd()                                    *
**********************************************************************************************

	This is the heart of the script: a function that returns a substring that's between a 
	start and an end string. For example, if you give it a $startString of '<form' and an 
	$endString of '</form>', it will return the entire form.                                */

function getStringByStartEnd($haystack='',$startString='',$endString='',$offset=0) {
	$startPos = strpos($haystack,$startString,$offset);
	if ($startPos !== FALSE) {
		$haystackSub = $startString.substr($haystack,$startPos+strlen($startString),strpos(substr($haystack,$startPos+strlen($startString)),$endString)+strlen($endString));
	} else {
		$haystackSub = '';
	}
	return $haystackSub;
}

function getAttributeValue($haystack='',$needle='') {
	return substr(getStringByStartEnd($haystack,$needle.'="','"'),strlen($needle)+2,strlen(getStringByStartEnd($haystack,$needle.'="','"'))-(strlen($needle)+3));
}

/*********************************************************************************************
*                                 replaceWithFieldValues()                                   *
**********************************************************************************************

	This funtion will replace any occurrences of a field name in the form [fieldName] 
	in a block of text with a value from the POST                                          	*/
	
function replaceWithFieldValues($text) {
	if (strpos($text,'[') !== false) {
		$getField = getStringByStartEnd($text,'[',']');
		$getFieldValue = htmlspecialchars($_POST[str_replace('[','',str_replace(']','',$getField))]);
		$text = str_replace($getField,$getFieldValue,$text);
		$text = replaceWithFieldValues($text);
	}
	return $text;
}

/**
 * strposall
 *
 * Find all occurrences of a needle in a haystack
 *
 * @param string $haystack
 * @param string $needle
 * @return array or false
 */
function strposall($haystack,$needle){
   
    $s=0;
    $i=0;
   
    while (is_integer($i)){
       
        $i = strpos($haystack,$needle,$s);
       
        if (is_integer($i)) {
            $aStrPos[] = $i;
            $s = $i+strlen($needle);
        }
    }
    if (isset($aStrPos)) {
        return $aStrPos;
    }
    else {
        return false;
    }
}


/*********************************************************************************************
*                        Some Attempts at Combatting Form Spam                               *
*********************************************************************************************/
 
$spam=false;
// check for links in fields
if ((count(strposall(implode($_POST), "http:"))/count($_POST)) > .2) {
    $spam=true;
}
// check for wrong referrers
if((isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST']) === false)) {
    $spam=true;
}

/*********************************************************************************************
*                                    COLLECT FORM INFO                                       *
**********************************************************************************************
	
	First, we have to look back at the refering form to find all the form fields and put them
	into an array called sendingFormElement. We'll use this later to determine which fields
	are required and what acceptable input is for those fields.                             */


$sendingFile = file_get_contents($uriFileName);
$formName = strpos($sendingFile,'id="'.htmlspecialchars($_POST['formName']).'"');
while (substr($sendingFile,$formName,1) !== "<") {
	$formName=$formName-1;
}
$formName=$formName-1;
$startForm = strpos($sendingFile,'<form');
$endForm = strpos($sendingFile,'</form>');
$sendingForm = getStringByStartEnd($sendingFile,'<form','</form>',$formName);

$sendingFormElement = array();

$sendingFormSub = $sendingForm;
$filePosition = 0;
do {
	$filePosition = strpos($sendingFormSub,'<input');
	if ($filePosition !== FALSE) {
		$singleElement = getStringByStartEnd($sendingFormSub,'<input','/>');
		$sendingFormSub = substr($sendingFormSub,$filePosition+strlen($singleElement)-1);
		$sendingFormElement[] = $singleElement;
	}
} while ($filePosition > 0);

$sendingFormSub = $sendingForm;
$filePosition = 0;
do {
	$filePosition = strpos($sendingFormSub,'<select');
	if ($filePosition !== FALSE) {
		$singleElement = getStringByStartEnd($sendingFormSub,'<select','</select>');
		$sendingFormSub = substr($sendingFormSub,$filePosition+strlen($singleElement)-1);
		$sendingFormElement[] = $singleElement;
	}
} while ($filePosition > 0);

$sendingFormSub = $sendingForm;
$filePosition = 0;
do {
	$filePosition = strpos($sendingFormSub,'<textarea');
	if ($filePosition !== FALSE) {
		$singleElement = getStringByStartEnd($sendingFormSub,'<textarea','</textarea>');
		$sendingFormSub = substr($sendingFormSub,$filePosition+strlen($singleElement)-1);
		$sendingFormElement[] = $singleElement;
	}
} while ($filePosition > 0);

/*********************************************************************************************
*                                     START VALIDATION                                       *
**********************************************************************************************

	OK, now that we have an array with all the form element tags, we can start checking the
	form data. To start out, we have a BOOLEAN formError variable. We'll start out FALSE and
	set to TRUE if we come across any errors. We'll also add an explanation in a list to be
	displayed at the end if any errors are found.                                           */
$formError = FALSE;
/*                                     BLANK FIELDS
	Start by checking for any fields with a class attribute of 'required' that are blank. 
	formMissing will hold the explanation list for any fields we find missing. It will read
	the title attribute and add it to the list.                                             */
$formMissing = "<ul>";
foreach($sendingFormElement as $key=>$value) {
	$checkRequired = getStringByStartEnd($value,'class="','"');

	if (strpos($checkRequired,'required') !== FALSE) {
		$formElementName = getStringByStartEnd($value,'name="','"');
		$formElementName = substr($formElementName,6,strlen($formElementName)-7);
		$formElementTitle = getStringByStartEnd($value,'title="','"');
		$formElementTitle = substr($formElementTitle,7,strlen($formElementTitle)-8);
		if ($_POST[str_replace('[]','',$formElementName)] == '') {
			$formError = TRUE;
			$formMissing .= "<li>".$formElementTitle."</li>";
		}
	}
}
$formMissing .= "</ul>";

/*                                 FORMAT/VALIDATE FIELDS
	Here's where it gets fun--using regex and the like--like email addresses, phone numbers, 
	etc.                                                                                    */
$formInvalid = "<ul>";

$formInvalid .= "</ul>";

/*********************************************************************************************
*                                    RETURN TO BROWSER                                       *
**********************************************************************************************

	If there were any errors, return the list of errors to the browser and stop all further
	processing. If no errors were found, include the email processing (if specified) and 
	forward to the redirect page specified in the form.                                     */
$errorText = '';
if ($formError) {
	echo "<html><head></head><body><h1>Form Error</h1><p>There were some problems with your submission. Please use the back button in your browser to go back to the form and correct the errors.</p>";
	echo "<h2>The following required fields were left blank:</h2>".$formMissing;
	echo "</body></html>";
	die();
}
$attachErrors = include('formAttachedFiles.php');
// for the upload files capabilities, add the following code to the confirmation page
//  if ($attachErrors != 1) {
//	  echo $attachErrors;
//  }

// import into FileBound
$eFormError = false;
if (htmlspecialchars($_POST['formName']) == 'employmentApp') include('form2EForm-HR.php');
if ((isset($_POST['EFormID']) || isset($_POST['FBEFormID'])) && htmlspecialchars($_POST['formName']) != 'employmentApp') include('form2EForm.php');
if ($eFormError) { die(); }
// end import into FileBound

// create delimited file
if (isset($_POST['delimFile']) && $_POST['delimFile'] == 'Y') include('form2Delimited.php');
// insert into database
if (isset($_POST['dbInsert']) && $_POST['dbInsert'] == 'Y') include('form2MySQL.php');
// send results as email
if (isset($_POST['emailSend']) && $_POST['emailSend'] == 'Y') include('form2Email.php');
// send email notification
if (isset($_POST['emailNotify']) && $_POST['emailNotify'] == 'Y') include('formEmailNotify.php');

if ($debugForms) {
    $recipient = $errorEmail;
	$subject = '[FORM DEBUG] '. $_SERVER['HTTP_REFERER'];
	$message = $result.'<br/><br/>';
	
	$message .= '<h2>Array</h2><pre>'.var_export($sendingFormElement, TRUE).'</pre>';
	$message .= '<h2>Form</h2><pre>'.$sendingForm.'</pre>';
	$message .= '<h2>POST</h2><pre>'.var_export($_POST, TRUE).'</pre>';

	require_once $swiftFolder."Swift.php";
	require_once $swiftFolder."Swift/Connection/SMTP.php";
	$swift =& new Swift(new Swift_Connection_SMTP($smtpServer));
	$message .= "<br/>--------------<br/><br/>Requesting IP: ".$_SERVER['REMOTE_ADDR'];
	$message .= "<br/>Web User Agent: ".$_SERVER['HTTP_USER_AGENT'];
	$message .= "<br/>Referring Site: ".$_SERVER['HTTP_REFERER'];
	$message .= "<br/>Script Name: ".$_SERVER['SCRIPT_FILENAME'];
	
	$recipients =& new Swift_RecipientList();
	if (strpos($recipient,",") !== false) {
		$recipientList = split(",", htmlspecialchars($recipient)); 
		foreach($recipientList as $recKey=>$recValue) {
			$recipients->addTo(trim($recValue));
		}
	} else {
		$recipients->addTo(htmlspecialchars($recipient));
	}
	
	$swiftMessage =& new Swift_Message($subject, $message, "text/html");
	if ($swift->batchSend($swiftMessage, $recipients, $smtpFrom)) { 
	} else {
		echo "<p style=\"color:red; text-align:center;\">There was a problem and the error notification email was not sent.</p>";
	}
}

if (isset($_POST['formRedirect'])) {
	include(str_replace("//","/",$_SERVER['DOCUMENT_ROOT'].$_POST['formRedirect']));
	die();
}
// close the if statement at the beginning (was the form submitted?)
}
}
?>
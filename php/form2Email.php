<?php
require_once $swiftFolder."Swift.php";
require_once $swiftFolder."Swift/Connection/SMTP.php";
$swift =& new Swift(new Swift_Connection_SMTP($smtpServer));

$message = "<dl>";
$nameList = "";
$arrayList = "";
foreach($_POST as $key=>$value) {
	foreach($sendingFormElement as $key2=>$value2) {
		$value2 = str_replace('[]','',$value2);
		if (strpos(getAttributeValue($value2,'class'),'exclude') === FALSE && strpos(getAttributeValue($value2,'type'),'hidden') === FALSE && strpos(getAttributeValue($value2,'type'),'submit') === FALSE) {
			if (getAttributeValue($value2,'name') == $key) {
				$currentFormElementName = getAttributeValue($value2,'title');
				if (strpos($arrayList, $currentFormElementName) === false && strpos($nameList, getAttributeValue($value2,'name').",") === false) {
					$message .= "<dt><strong>".getAttributeValue($value2,'title')."</strong>&nbsp;</dt>";
					if (is_array($value)) {
						foreach($value as $value3) {
							$message .= "<dd>".$value3."&nbsp;</dd>";
						}
						$arrayList .= $currentFormElementName.",";
					} else {
						$message .= "<dd>".nl2br($value)."&nbsp;</dd>";
					}
					$nameList .= getAttributeValue($value2,'name').",";
				}
			}
		}
	}
}
$message .= "</dl>";

// added to help combat spam submits
$message .= "<br/>--------------<br/><br/>Requesting IP: ".$_SERVER['REMOTE_ADDR'];
$message .= "<br/>Web User Agent: ".$_SERVER['HTTP_USER_AGENT'];
$message .= "<br/>Referring Site: ".$_SERVER['HTTP_REFERER'];
$message .= "<br/>Script Name: ".$_SERVER['SCRIPT_FILENAME'];

$subject = htmlspecialchars($_POST['emailSubject']);
$recipients =& new Swift_RecipientList();
if ($spam) {
	$recipients->addTo($errorEmail);
	$subject = '[FORMSPAM] '.$subject;
} else {
	if (strpos($_POST['emailRecipients'],",") !== false) {
		$recipientList = split(",", htmlspecialchars($_POST['emailRecipients'])); 
		foreach($recipientList as $recKey=>$recValue) {
			$recipients->addTo(trim($recValue));
		}
	} else {
		$recipients->addTo(htmlspecialchars($_POST['emailRecipients']));
	}
	if (isset($_POST['emailCC']) && $_POST['emailCC'] !== '') {
		if (strpos($_POST['emailCC'],",") !== false) {
			$ccList = split(",", htmlspecialchars($_POST['emailCC'])); 
			foreach($ccList as $recKey=>$recValue) {
				$recipients->addTo(trim($recValue));
			}
		} else {
			$recipients->addTo(htmlspecialchars($_POST['emailCC']));
		}
	}
}

$swiftMessage =& new Swift_Message($subject, $message, "text/html");
if (isset($_POST['emailReply']) && $_POST['emailReply'] !== '') {
	$swiftMessage->setReplyTo(htmlspecialchars($_POST['emailReply']));
}

if ($swift->batchSend($swiftMessage, $recipients, $smtpFrom)) { 
} else {
	echo "<p style=\"color:red; text-align:center;\">There was a problem and the email was not sent.</p>";
}
?>
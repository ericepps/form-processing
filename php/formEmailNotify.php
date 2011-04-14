<?php
require_once $swiftFolder."Swift.php";
require_once $swiftFolder."Swift/Connection/SMTP.php";
$swift =& new Swift(new Swift_Connection_SMTP($smtpServer));
$message = '';
if (isset($_POST['emailNotifyMessage'])) {
	$message .= replaceWithFieldValues(htmlspecialchars($_POST['emailNotifyMessage']));
} else if (isset($_POST['emailNotifyHTML'])) {
	$fileName = $_SERVER['DOCUMENT_ROOT'].$_POST['emailNotifyHTML'];
	if (is_file($fileName)) {
		ob_start();
		include $fileName;
		$message .= ob_get_contents();
		ob_end_clean();
	}
} else {
	$message .= "A " . htmlspecialchars($_POST['emailSubject']) . " form was completed and the results have been omitted for security reasons.";
}

$subject = replaceWithFieldValues(htmlspecialchars($_POST['emailSubject']));

$swiftMessage =& new Swift_Message($subject, $message, "text/html");
if (isset($_POST['emailReply']) && $_POST['emailReply'] !== '') {
	$swiftMessage->setReplyTo(htmlspecialchars($_POST['emailReply']));
}
$recipients =& new Swift_RecipientList();
if ($spam == true) {
	$recipients->addTo($errorEmail);
	$subject = '[FORMSPAM] '.$subject;
} else {
	if (strpos($_POST['emailNRecipients'],",") !== false) {
		$recipientList = split(",", htmlspecialchars($_POST['emailNRecipients'])); 
		foreach($recipientList as $recKey=>$recValue) {
			$recipients->addTo(trim($recValue));
		}
	} else {
		$recipients->addTo(htmlspecialchars($_POST['emailNRecipients']));
	}
	if (isset($_POST['emailNCC']) && $_POST['emailNCC'] !== '') {
		if (strpos($_POST['emailNCC'],",") !== false) {
			$ccList = split(",", htmlspecialchars($_POST['emailNCC'])); 
			foreach($ccList as $recKey=>$recValue) {
				$recipients->addCC(trim($recValue));
			}
		} else {
			$recipients->addCC(htmlspecialchars($_POST['emailNCC']));
		}
	}
}

if ($swift->batchSend($swiftMessage, $recipients, $smtpFrom)) { 
} else {
	echo "<p style=\"color:red; text-align:center;\">There was a problem and the email (".$message.") to <".$_POST['emailNRecipients']."> was not sent.</p>";
	$subjectErr = '[FORM ERROR] '. $_SERVER['HTTP_REFERER'];
	$messageErr = '<p>Here is the form input.</p>';
	
	$messageErr .= '<pre>'.var_export($_POST, TRUE).'</pre>';
	
	$swiftErr =& new Swift(new Swift_Connection_SMTP($smtpServer));
	$messageErr .= "<br/>--------------<br/><br/>Requesting IP: ".$_SERVER['REMOTE_ADDR'];
	$messageErr .= "<br/>Web User Agent: ".$_SERVER['HTTP_USER_AGENT'];
	$messageErr .= "<br/>Referring Site: ".$_SERVER['HTTP_REFERER'];
	$messageErr .= "<br/>Script Name: ".$_SERVER['SCRIPT_FILENAME'];
	$recipientsErr =& new Swift_RecipientList();
	$recipientsErr->addTo($errorEmail);
	
	$swiftMessageErr =& new Swift_Message($subjectErr, $messageErr, "text/html");
	if ($swiftErr->batchSend($swiftMessageErr, $recipientsErr, $smtpFrom)) { 
		echo "<p>error email sent</p>";
	} else {
		echo "<p style=\"color:red; text-align:center;\">There was a problem and the error notification email was not sent.</p>";
	}
}
?>
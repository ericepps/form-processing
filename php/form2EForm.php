<?php
$fields_string = '';
$result = '';
//url-ify the data for the POST  
foreach($_POST as $key=>$value) {
	$fields_string .= $key.'=';
	if (is_array($value)) {
		$subValues = '';
		foreach ($value as $subValue) {
			$subValues .= $subValue.',';
		}
		rtrim($subValues,',');
		$fields_string .= urlencode($subValues);
	} else {
		$fields_string .= urlencode($value);
	}
 	$fields_string .= '&';
}  
$fields_string .= 'F20='.$_POST['F20'];
//substr($fields_string,0,strlen($fields_string)-1));

//open connection  
$ch = curl_init();  
  
//set the url, number of POST vars, POST data  
curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
curl_setopt($ch,CURLOPT_URL,$fileBoundURL);  
curl_setopt($ch,CURLOPT_POST,TRUE); 
curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);  

//execute post  
$result = curl_exec($ch);  
  
//close connection  
curl_close($ch);

//blow up on error
if (trim($result) != 'Eform successfully added.') {
	$eFormError = true;
    $recipient = $errorEmail;
	$subject = '[FORM ERROR] '. $_SERVER['HTTP_REFERER'];
	$message = $result.'<br/><br/>';
	
	$message .= '<pre>'.var_export($_POST, TRUE).'</pre>';
	
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
	echo '<html><head></head><body><h1>Error</h1><p>There was an error adding the E-Form. The system administrator has been notified.</p><p style="color:red;">'.$result.'</p></body></html>';
	die();
}
?>
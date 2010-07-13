<?php
if ($spam == false) {
	$okExt = ',doc,pdf,rtf,htm,html,txt';
	if (count($_FILES) > 0) {
	$fileNumber = 1;
	foreach ($_FILES['file']['name'] as $key => $value) {
		$uploadDir = $attachDir;
		$path_parts = pathinfo($value);
		$uploadFile = $attachDir . $uniqueFormID. "-f". $fileNumber.".".$path_parts['extension'];
		
		if ($path_parts['extension'] <> '') {
			if (strpos($okExt,$path_parts['extension'])) {
				if (move_uploaded_file($_FILES['file']['tmp_name'][$key], $uploadFile)) {
				} else { 
					$errorText .= "<strong>".$value."</strong>";
					switch ($_FILES['file']['error'][$key])
						 {
							case 1:
								   $errorText .= " was not uploaded because it is too big. Files must be 2MB or smaller. [1]";
								   break;
							case 2:
								   $errorText .= " was not uploaded because it is too big. Files must be 2MB or smaller. [2]";
								   break;
							case 3:
								   $errorText .= " was not uploaded because of an unknown error [3].";
								   break;
							case 4:
								   $errorText .= " was not uploaded because of an unknown error [4].";
								   break;
						 }
						 $errorText .= "<br />";
				}
			} else {
				$errorText = $value." was not uploaded. <strong>$path_parts[extension]</strong> is not an acceptable file type.";
				$errorText .= "<br />";
			}
		}
		$fileNumber = $fileNumber + 1;
	}
	if (trim($errorText) !== '') return "<h2>Problems were detected with the following attached files:</h2>".$errorText;
	}
}
?>

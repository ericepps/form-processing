<?php
if ($_POST['delimType'] == 'comma') {
	$delimiter = ',';
	$extension = '.csv';
} elseif ($_POST['delimType'] == 'tab') {
	$delimiter = chr(9);
	$extension = '.tsv';
}
$header = '';
$line = '';
$arrayList = '';
foreach($_POST as $key=>$value) {
	foreach($sendingFormElement as $key2=>$value2) {
		$value2 = str_replace('[]','',$value2);
		if (strpos(substr(getStringByStartEnd($value2,'class="','"'),7,strlen(getStringByStartEnd($value2,'class="','"'))-8),'exclude') === FALSE && strpos(substr(getStringByStartEnd($value2,'type="','"'),6,strlen(getStringByStartEnd($value2,'type="','"'))-7),'hidden') === FALSE && strpos(substr(getStringByStartEnd($value2,'type="','"'),6,strlen(getStringByStartEnd($value2,'type="','"'))-7),'submit') === FALSE) {
			if (substr(getStringByStartEnd($value2,'name="','"'),6,strlen(getStringByStartEnd($value2,'name="','"'))-7) == $key) {
				$currentFormElementName = substr(getStringByStartEnd($value2,'name="','"'),6,strlen(getStringByStartEnd($value2,'name="','"'))-7);
				if (strpos($arrayList, $currentFormElementName) === false) {
					$header .= "\"".substr(getStringByStartEnd($value2,'name="','"'),6,strlen(getStringByStartEnd($value2,'name="','"'))-7)."\"".$delimiter;
					if (is_array($value)) {
						$line .= "\"";
						$value3iter = 0;
						foreach($value as $value3) {
							$line .= $value3;
							$value3iter = $value3iter + 1;
							if ($value3iter < count($value)) {
								$line .= " | ";
							}
						}
						$line .= "\"".$delimiter;
						$arrayList .= $currentFormElementName.",";
					} else {
						$line .= "\"".nl2br($value)."\"".$delimiter;
					}
				}
			}
		}
	}
}

$fp = fopen($absoluteDir.$uniqueFormID.$extension, 'x');
fwrite($fp, $header.chr(10).$line);
fclose($fp);
?>
<?php
$delimiter = ',';
$extension = '.csv';
$header = '';
$line = '';
$arrayList = '';
$databName = split('-',$uniqueFormID);

foreach($_POST as $key=>$value) {
	foreach($sendingFormElement as $key2=>$value2) {
		$value2 = str_replace('[]','',$value2);
		if (strpos(getAttributeValue($value2,'class'),'exclude') === FALSE && strpos(getAttributeValue($value2,'type'),'hidden') === FALSE && strpos(getAttributeValue($value2,'type'),'submit') === FALSE) {
			if (getAttributeValue($value2,'name') == $key) {
				$currentFormElementName = getAttributeValue($value2,'title');
				if (strpos($arrayList, $currentFormElementName) === false && strpos($nameList, getAttributeValue($value2,'name').",") === false) {
					$header .= "".substr(getStringByStartEnd($value2,'name="','"'),6,strlen(getStringByStartEnd($value2,'name="','"'))-7)."".$delimiter;
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
						if (strpos(getAttributeValue($value2,'class'),'encrypt') === FALSE) {
							$line .= "\"".nl2br(htmlspecialchars($value))."\"".$delimiter;
						} else {
							$line .= "AES_ENCRYPT('".nl2br(htmlspecialchars($value))."','".$mySQLAESKeyStr."')".$delimiter;
						}
					}
					$nameList .= getAttributeValue($value2,'name').",";
				}
			}
		}
	}
}


$link = mysql_connect($mySQLServer, $mySQLUsername, $mySQLPassword) or die('Could not connect: ' . mysql_error());
mysql_select_db($mySQLSchema) or die('Could not select database');

$query = str_replace(',)',')','INSERT INTO '.$databName[0].' ('.$header.') VALUES ('.$line.')');
$result = mysql_query($query) or die('query error '.mysql_error());
?>
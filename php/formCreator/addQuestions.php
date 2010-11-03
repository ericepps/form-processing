<?php
$questionNumber = $_POST['namePrefix'] . "q" . $_POST['qNum'];
if ($_POST['tfQuestion'] != '') {
	$mcQ = '<li><fieldset id="' . $questionNumber . '" class="trueFalse"><legend>' . $_POST['tfQuestion'] . '</legend><div class="nopadding"><ol><li><input id="' . $questionNumber . 't" name="' . $questionNumber . '" title="' . $_POST['tfQuestion'] . '" value="True" type="radio" /><label class="besideRight" for="' . $questionNumber . 't">True</label></li><li><input id="' . $questionNumber . 'f" name="' . $questionNumber . '" title="' . $_POST['tfQuestion'] . '" value="False" type="radio" /><label class="besideRight" for="' . $questionNumber . 'f">False</label></li></ol></div></fieldset></li>';
}

if ($_POST['laQuestion'] != '') {
	$mcQ = '<li class=""><label for="' . $questionNumber . '">' . $_POST['laQuestion'] . '</label><textarea id="' . $questionNumber . '" name="' . $questionNumber . '" title="' . $_POST['laQuestion'] . '" cols="' . $_POST['laColumns'] . '" rows="' . $_POST['laRows'] . '" class=""><\/textarea></li>';
}

if ($_POST['saQuestion'] != '') {
	$mcQ = '<li class=""><label for="' . $questionNumber . '">' . $_POST['saQuestion'] . '</label><input class="" id="' . $questionNumber . '" name="' . $questionNumber . '" title="' . $_POST['saQuestion'] . '" type="text" /></li>';
}

if ($_POST['mcQuestion'] != '') {
	$mcQ = '<li><fieldset id="' . $questionNumber . '" class="multipleChoice"><legend>' . $_POST['mcQuestion'] . '</legend><div class="nopadding"><ol>';
    if ($_POST['answerA'] != '') {
        $mcQ .= '<li><input id="' . $questionNumber . 'a" name="' . $questionNumber . '" title="' . $_POST['mcQuestion'] . '" value="' . $_POST['answerA'] . '" type="radio" /><label class="besideRight" for="' . $questionNumber . 'a">' . $_POST['answerA'] . '</label></li>'; 
    }
    if ($_POST['answerB'] != '') {
        $mcQ .= '<li><input id="' . $questionNumber . 'b" name="' . $questionNumber . '" title="' . $_POST['mcQuestion'] . '" value="' . $_POST['answerB'] . '" type="radio" /><label class="besideRight" for="' . $questionNumber . 'b">' . $_POST['answerB'] . '</label></li>'; 
    }
    if ($_POST['answerC'] != '') {
        $mcQ .= '<li><input id="' . $questionNumber . 'c" name="' . $questionNumber . '" title="' . $_POST['mcQuestion'] . '" value="' . $_POST['answerC'] . '" type="radio" /><label class="besideRight" for="' . $questionNumber . 'c">' . $_POST['answerC'] . '</label></li>'; 
    }
    if ($_POST['answerD'] != '') {
        $mcQ .= '<li><input id="' . $questionNumber . 'd" name="' . $questionNumber . '" title="' . $_POST['mcQuestion'] . '" value="' . $_POST['answerD'] . '" type="radio" /><label class="besideRight" for="' . $questionNumber . 'd">' . $_POST['answerD'] . '</label></li>'; 
    }
    if ($_POST['answerE'] != '') {
        $mcQ .= '<li><input id="' . $questionNumber . 'e" name="' . $questionNumber . '" title="' . $_POST['mcQuestion'] . '" value="' . $_POST['answerE'] . '" type="radio" /><label class="besideRight" for="' . $questionNumber . 'e">' . $_POST['answerE'] . '</label></li>'; 
    }
    if ($_POST['answerF'] != '') {
        $mcQ .= '<li><input id="' . $questionNumber . 'f" name="' . $questionNumber . '" title="' . $_POST['mcQuestion'] . '" value="' . $_POST['answerF'] . '" type="radio" /><label class="besideRight" for="' . $questionNumber . 'f">' . $_POST['answerF'] . '</label></li>';
    }
    if ($_POST['answerG'] != '') {
        $mcQ .= '<li><input id="' . $questionNumber . 'g" name="' . $questionNumber . '" title="' . $_POST['mcQuestion'] . '" value="' . $_POST['answerG'] . '" type="radio" /><label class="besideRight" for="' . $questionNumber . 'g">' . $_POST['answerG'] . '</label></li>'; 
    }
    if ($_POST['answerH'] != '') {
        $mcQ .= '<li><input id="' . $questionNumber . 'h" name="' . $questionNumber . '" title="' . $_POST['mcQuestion'] . '" value="' . $_POST['answerH'] . '" type="radio" /><label class="besideRight" for="' . $questionNumber . 'h">' . $_POST['answerH'] . '</label></li>';
    }
	$mcQ .= '</ol></div></fieldset></li>'; 
}

$fullForm = $_POST['previousQuestions'] . $mcQ;
$namePrefix = $_POST['namePrefix'];
if ($_POST['qNum'] < 1) { $qNum = 1; } else { $qNum = $_POST['qNum'] + 1; }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link type="text/css" rel="stylesheet" href="http://www.svcc.edu/css/forms.css" />

</head>

<body>
<form method="post" action="../../../../../Documents/Websites/www.svcc.edu-eppse/formCreator.php">
<textarea name="previousQuestions" cols="80" rows="20">
<?php echo $fullForm; ?>
</textarea>
<ol class="nobullet">
<li>
    <label for="qNum">Question Number</label>
	<input type="text" name="qNum" value="<?php echo $qNum; ?>" id="qNum" />
</li>
<li>
    <label for="namePrefix">Name Prefix (section number, etc.)</label>
    <input class="xsWidth" id="namePrefix" name="namePrefix" title="Name Prefix" value="<?php echo $namePrefix; ?>" type="text" />
</li>
<fieldset title="Multiple Choice" id="multipleChoice"><legend>Multiple Choice</legend>
<li>
    <label for="mcQuestion">Question</label>
    <input class="xlWidth" id="mcQuestion" name="mcQuestion" title="Multiple Choice Question" type="text" />
</li>
<fieldset>
<li>
    <label for="">Answer A</label>
    <input class="xlWidth" id="answerA" name="answerA" title="Answer A" type="text" />
</li>
<li>
    <label for="">Answer B</label>
    <input class="xlWidth" id="answerB" name="answerB" title="Answer B" type="text" />
</li>
<li>
    <label for="">Answer C</label>
    <input class="xlWidth" id="answerC" name="answerC" title="Answer C" type="text" />
</li>
<li>
    <label for="">Answer D</label>
    <input class="xlWidth" id="answerD" name="answerD" title="Answer D" type="text" />
</li>
<li>
    <label for="">Answer E</label>
    <input class="xlWidth" id="answerE" name="answerE" title="Answer E" type="text" />
</li>
<li>
    <label for="">Answer F</label>
    <input class="xlWidth" id="answerF" name="answerF" title="Answer F" type="text" />
</li>
<li>
    <label for="">Answer G</label>
    <input class="xlWidth" id="answerG" name="answerG" title="Answer G" type="text" />
</li>
<li>
    <label for="">Answer H</label>
    <input class="xlWidth" id="answerH" name="answerH" title="Answer H" type="text" />
</li>
</fieldset>
</fieldset>
<fieldset title="True/False" id="trueFalse"><legend>True/False</legend>
<li>
    <label for="tfQuestion">Question</label>
    <input class="xlWidth" id="tfQuestion" name="tfQuestion" title="True/False Question" type="text" />
</li>
</fieldset>
<fieldset title="Long Answer" id="longAnswer"><legend>Long Answer</legend>
<li>
    <label for="laQuestion">Question</label>
    <input class="xlWidth" id="laQuestion" name="laQuestion" title="Long Answer Question" type="text" />
</li>
<li class="">
    <label for="laRows">Rows</label>
    <input class="xsWidth" id="laRows" name="laRows" title="Rows" type="text" />
</li>
<li class="">
    <label for="laColumns">Columns</label>
    <input class="xsWidth" id="laColumns" name="laColumns" title="Columns" type="text" />
</li>
</fieldset>
<fieldset title="Short Answer" id="shortAnswer"><legend>Short Answer</legend>
<li>
    <label for="saQuestion">Question</label>
    <input class="xlWidth" id="saQuestion" name="saQuestion" title="Short Answer Question" type="text" />
</li>
</fieldset>
</ol>
<input type="submit" />
</form>
</body>
</html>

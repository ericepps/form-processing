<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Form Creator - Form Basics</title>
<link type="text/css" rel="stylesheet" href="http://www.svcc.edu/css/forms.css" />
<style type="text/css">
ol>fieldset { margin-top:10px; }
html, body { font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif; font-size:12px; }
</style>
</head>

<body>
<form method="post" action="addQuestions.php">
<input name="isInitial" type="hidden" value="Y"/>
<fieldset><legend>Form Options</legend>
<ol class="nobullet nopadding">
<li>
  <label for="formShortName">Form Short Name <span class="entryExample">(no spaces or special characters)</span></label>
  <input class="mWidth " id="formShortName" name="formShortName" title="Form Short Name" type="text" />
</li>
<li>
  <label for="formName">Form Name <span class="entryExample">(also used for email subject, if applicable)</span></label>
  <input class="xlWidth " id="formName" name="formName" title="Form Name" type="text" />
</li>
<li>
  <label for="formRedirect">Confirmation URL <span class="entryExample">(relative root URL - /directory/filename.html)</span></label>
  <input class="xlWidth " id="formRedirect" name="formRedirect" title="Confirmation URL" type="text" />
</li>
<fieldset>
<legend>Email Contents</legend>
<li>
  <label class="besideRight" for="formEmailSend">
  <input id="formEmailSend" name="formEmailSend" title="Send contents via email?" value="Y" type="checkbox" />Send contents via email? </label>
</li>
<li>
  <label for="formEmailRecipients">Recipient(s) <span class="entryExample">(comma separated list)</span></label>
  <input class="lWidth " id="formEmailRecipients" name="formEmailRecipients" title="Recipients" type="text" />
</li>
</fieldset>
<fieldset>
<legend>Email Notifications</legend>
<li>
  <label class="besideRight" for="formEmailNotify">
  <input id="formEmailNotify" name="formEmailNotify" title="Send notification via email?" value="Y" type="checkbox" />Send notification via email? </label>
</li>
<li>
  <label for="formEmailNRecipients">Recipient(s) <span class="entryExample">(comma separated list)</span></label>
  <input class="lWidth " id="formEmailNRecipients" name="formEmailNRecipients" title="Recipient(s)" type="text" />
</li>
<li>
  <label for="formNMessage">Notification Message </label>
  <textarea id="formNMessage" name="formNMessage" title="Notification Message" cols="50" rows="5"></textarea>
</li>
<li>
  <label for="formNHTML">HTML Email Contents <span class="entryExample">(relative root URL - /directory/filename.html)</span></label>
  <input class="xlWidth " id="formNHTML" name="formNHTML" title="HTML Email Contents" type="text" />
</li>
</fieldset>
<fieldset>
<legend>Database</legend>
<li>
  <label class="besideRight" for="formDBInsert">
  <input id="formDBInsert" name="formDBInsert" title="Insert into MySQL database?" value="Y" type="checkbox" />Insert into MySQL database? </label>
</li>
</fieldset>
<fieldset>
<legend>Delimited File</legend>
<li>
  <label class="besideRight" for="formDelimited">
  <input id="formDelimited" name="formDelimited" title="Save delimited file?" value="Y" type="checkbox" />Save delimited file? </label>
</li>
<li>
  <fieldset id="formDelimType" class="multipleChoice">
  <legend>Delimiter Type </legend>
  <ol>
    <li><input id="formDelimTypeT" name="formDelimType[]" title="Delimiter Type" value="tab" type="radio" /><label class="besideRight" for="formDelimTypeT">Tab-Separated</label></li>
    <li><input id="formDelimTypeC" name="formDelimType[]" title="Delimiter Type" value="comma" type="radio" /><label class="besideRight" for="formDelimTypeC">Comma-Separated</label></li>
  </ol>
  </fieldset>
</li>
</fieldset>
  <li class="submitButton"><input type="submit" value=" Submit "/></li>
</ol>
</fieldset>
</form>
</body>
</html>
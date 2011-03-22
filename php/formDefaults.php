<?php
// set defaults (file locations, SMTP servers, etc) in this file

/*********************************************************************************************
*                                   form2Email DEFAULTS                                      *
*********************************************************************************************/
// absolute path (on the server, not "http://") to the swiftmailer class (www.swiftmailer.org, these scripts use version 3.3.2)
$swiftFolder = "";
// your SMTP server, for example, "mail.yourdomain.com"
$smtpServer = "";
// the email address to send the message from
$smtpFrom = "";
// email address to catch all debugging and/or error emails
$errorEmail = "";

/*********************************************************************************************
*                                 form2Delimited DEFAULTS                                    *
*********************************************************************************************/
// absolute path (on the server, not "http://") to the directory where delimited files (.CSV/.TSV) will be delivered
$absoluteDir = '';

/*********************************************************************************************
*                               formAttachedFiles DEFAULTS                                   *
*********************************************************************************************/
// absolute path (on the server, not "http://") to the directory where attached files will be delivered
$attachDir = '';

/*********************************************************************************************
*                                   form2MySQL DEFAULTS                                      *
*********************************************************************************************/
// MySQL connection variables
$mySQLServer = '';
$mySQLUsername = '';
$mySQLPassword = '';
$mySQLSchema = '';

/*********************************************************************************************
*                                  form2Eform DEFAULTS                                       *
*********************************************************************************************/
// URL for FileBound forms
$fileBoundURL = '';

?>
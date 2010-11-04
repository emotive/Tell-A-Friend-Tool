<?php
/*********************************************************
		This Free Script was downloaded at			
		Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
			With this script!						
		NOTE: Linkback is not required, 
	but its more of a show of appreciation to us.					
*********************************************************/

//Site Options and configuration

//Require user to enter their email -> 1=yes,2=no
$REQUIRE_EMAIL = 1;

//Require user to enter a message -> 1=yes,2=no
$REQUIRE_MESS = 1;

//Allow Multiple emails be sent -> 1=yes,2=no
//Multiple emails separated comma
$MULTIPLE_EMAILS = 1;

//Send current page in email -> 1=yes,2=no
$CUR_PAGE = 1;

//Site title
$EMAIL_OPTIONS['TITLE'] = $_POST['first_name'].' '.$_POST['last_name'];
//Site URL
$EMAIL_OPTIONS['URL'] = 'http://www.RobPortman.com';
//Main email
$EMAIL_OPTIONS['FROM'] = $_POST['email'];
//Charset 
$EMAIL_OPTIONS['CHARSET'] = 'utf-8';
//Type -> HTML=text/html | Text = text/plain
$EMAIL_OPTIONS['TYPE'] = 'text/html';
//Email subjects
$EMAIL_OPTIONS['EMAIL_SUBJECT'] = 'Join me and Vote for Rob Portman';

/*
For Templates you can use the following variables:
	$+name+$ -> User Name Sending Contact
	$+page_send+$ -> Page user is comming from
	$+message_text+$ -> Contact Message
*/

//EMAIL Template

$EMAIL_TEMPLATE = '<html><head><title>Rob Portman for US Senate</title></head><body><p>Please join me in taking a pledge to vote on November 2, 2010.</p><p>Ohio is in trouble, and Columbus and Washington just don\'t get it. Ohio has had enough of Lee Fisher\'s failed policies. We must do everything possible to make sure our message reaches every voter. That is why I need your help, especially now, in this home stretch. Ohio needs someone who will focus on jobs for Ohioans, not the politics that are leading us down the wrong track. This election is about helping real Ohioans; about getting Ohio back on a path to prosperity. That is why I am voting for Rob Portman.</p><p>Please visit http://www.RobPortman.com to join me and sign up for voting information. Help spread the news to your friends and family by following this link http://www.RobPortman.com/.</p></body></html>';

/* +++++++++++++++++++++++++++++++++++++
		END FILE CONFIGURATION
---------------------------------------*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" dir="ltr">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<head>
<script type="text/javascript" src="https://www.plaxo.com/css/m/js/util.js"></script>
<script type="text/javascript" src="https://www.plaxo.com/css/m/js/basic.js"></script>
<script type="text/javascript" src="https://www.plaxo.com/css/m/js/abc_launcher.js"></script>
<title>Join Team Portman | Rob Portman for U.S. Senate</title>
<meta name="description" content=" The Official Site of Rob Portman for Senate | Ohio 2010">
<meta name="keywords" content=" Rob Portman, U.S. Senate, Portman for Senate, Ohio 2010, Senate 2010, Portman Campaign, Ohio Senate,Join Team Portman">
<meta name="reply-to" content="contact@robportman.com">
<meta name="copyright" content="Copyright 2010">
<meta http-equiv="content-language" content="en">
<meta name="rating" content="General">
<meta name="verify-v1" content="" />
<meta name="robots" content="index, follow">
<meta name="robots" content="archive" />
<meta name="googlebot" content="archive">
<title>Pledge to Vote</title>
<style type="text/css">
body {
background:url("../images/bg.jpg") repeat-x scroll center top #006699;
}
#splash {
	background:url(portman_splash_bg.png);
	width:901px;
	height:635px;
	margin:0 auto;
	font-family:Arial, Helvetica, sans-serif;
	font-size:16px;
}
.splash_header {
	width:901px;
	margin-bottom:20px;
}
.splashlogo {
	width:344px;
	float:left;
	display:inline;
	padding-top:15px;
	text-align:right;
}
.splashtitle {
	padding-top:21px;
	padding-left:31px;
	width:500px;
	float:left;
	display:inline;
}
.splashcontent {
	padding:81px 42px;
}
.splashtitle h1 {
	margin:0;
	font-size:21px;
	color:#06699b;
}
.splashinput {
	width:155px;
	height:32px;
	margin-right:8px;
	border:1px solid black;
	font-size:20px;
	/*padding:22px 20px;*/
}
.splashemail {
	margin-top:10px;
	width:350px;
	height:32px;
	border:1px solid black;
	font-size:20px;
}
textarea {
	width:300px;
	border:none;
	height:100px;
	padding:12px 20px;
	border:3px solid #ccc;
}
.splashinvite {
	background:url(invite.png);
	background-repeat:no-repeat;
	width:387px;
	height:68px;
	border:none;
	cursor:pointer;
	margin-top:10px;
}
#skip_link {
color:white;	
}
</style>
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

//Include configuration file and function file
//(default location is in the same directory)
include_once('config.php');

//Function to check for valid email
function is_valid_email($string) {
	return preg_match('/^[.\w-]+@([\w-]+\.)+[a-zA-Z]{2,6}$/', $string);
}

//Check cur page
if($_POST['this_page'] == NULL){$_POST['this_page'] = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];}

//If contact is being sent:
if($_POST['submit_id'] == 1){
  
  	//Check name entered
	if($_POST['first_name'] == NULL){ $alert_text = 'Please enter your first name.';}
	if($_POST['last_name'] == NULL){ $alert_text = 'Please enter your last name.';}
	
	//check if email is enetered
	if($alert_text == NULL && $REQUIRE_EMAIL == 1 && is_valid_email($_POST['email']) == false ){ $alert_text = 'Please enter a valid email address.';}
	
	//check if message is entered
	if($alert_text == NULL && $REQUIRE_MESS == 1 && $_POST['message_text'] == NULL){ $alert_text = 'Please enter a comment.';}	
	
	//check to send emails
	if($alert_text == NULL)
	{
	if($MULTIPLE_EMAILS == 1){
		//multiple emails
		$valid_emails = array();
		$emails = explode(',',$_POST['toemails']);

		foreach($emails as $email){
			$email = trim($email);
			if($email != NULL){
				if(is_valid_email($email) == false ){ 
					$temp_message .= '<br/>We couldn\'t send and email to: <font color="#0000FF">'.$email.'</font> because it is not valid.';
				} else {
					array_push($valid_emails,$email);
				}
			}
		}
		if(count($valid_emails) <=0 ){
			$alert_text = 'Please enter at least one email to send message to.';
		}
	} else {
		//one email
		if(is_valid_email($_POST['toemails']) == false ){ $alert_text = 'Please enter a valid friend\'s email.';}
	}
	}
	//End verifications, start processing
	if($alert_text == NULL){
		//compose user message templates replaces
		$do_search = array('$+name+$','$+page_send+$','$+message_text+$','$+message+$');
		$do_replace = array($_POST['first_name'],$_POST['this_page'],$_POST['message_text'],$_POST['message']);
		$subject = str_replace($do_search,$do_replace,$EMAIL_TEMPLATE);
	
		//Set Headers
		$headers = "Return-Path: ".$EMAIL_OPTIONS['TITLE']." <".$EMAIL_OPTIONS['FROM'].">\r\n"; 
		$headers .= "From: ".$EMAIL_OPTIONS['TITLE']." <".$EMAIL_OPTIONS['FROM'].">\r\n";
		$headers .= "Content-Type: ".$EMAIL_OPTIONS['TYPE']."; charset=".$EMAIL_OPTIONS['CHARSET'].";\n\n\r\n"; 
		
		
		if($MULTIPLE_EMAILS == 1){		
			foreach($valid_emails as $this_email){
				mail ($this_email,$EMAIL_OPTIONS['EMAIL_SUBJECT'],$subject,$headers);	
				$one_pass = true;
				
			}
		} else {
			mail ($_POST['toemails'],$EMAIL_OPTIONS['EMAIL_SUBJECT'],$subject,$headers);
			
		}
		$alert_text = 'Your email(s) have been sent, thank you.';
		$alert_text .= $temp_message;
		$_POST = NULL;
	}
}
?>
</head>
<body>
<div id="splash">
<div class="splash_header">
  <div class="splashtitle">
    <h1>Join Me and Pledge to Vote on Election Day</h1>
  </div>
  <div class="splashlogo"><a href="#"><img src="portman_splash_logo.png" width="144" height="46" border="0" /></a></div>
</div>
<div class="splashcontent">
<p>Help Rob Portman send Ohio in a new direction.  Please <strong>invite as many friends as possible</strong> to the polls on November 2nd to vote.   Click the <strong>&quot;Add Your Friends&quot;</strong> button to access your address book and send  a message to remind your friends, family, and neighbors to vote in this critical election.</p>
<p>Thank you for your support. </p>
<?php
if($alert_text != NULL){
?>
<table width="100%"  border="0" cellpadding="5" cellspacing="0" bgcolor="">
  <tr>
    <td style="color:#ff0000; background:#ff9999;" class="Alert" bgcolor="#fddadd"><font color="#003366"><strong>
      <?=$alert_text;?>
      </strong></font></td>
  </tr>
</table>
<?php } ?>
  <form name="signup" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <table width="846" cellpadding="10" cellspacing="0" border="0" align="center">
      <tr>
        <td width="50%" valign="top"><a title="Click here to invite your friends" href="#" onclick="showPlaxoABChooser('toemails', '/splash/plaxo_cb.html'); return false"><img src="addbutton.jpg" width="343" height="138" border="0" /></a>
          <h3>Or type their email addresses in the box below:</h3>
          <textarea style="margin:0;" name="toemails" id="toemails" cols="30" rows="7"></textarea></td>
        <td valign="top" style="padding-left:40px;"><input name="first_name" type="text" value="First Name" class="splashinput" onblur="if(this.value=='')this.value='First Name'" onfocus="if(this.value=='First Name')this.value=''" />
          <input name="last_name" type="text" value="Last Name" class="splashinput" onblur="if(this.value=='')this.value='Last Name'" onfocus="if(this.value=='Last Name')this.value=''" />
          <input name="email" type="text" value="Email Address" class="splashemail" onblur="if(this.value=='')this.value='Email Address'" onfocus="if(this.value=='Email Address')this.value=''" />
          <h3>Below is the message that will be sent to your friend(s)</h3>
          <textarea name="message_text" cols="30" rows="7" readonly="readonly">Please join me in taking a pledge to vote on November 2, 2010.

Ohio is in trouble, and Columbus and Washington just don't get it. Ohio has had enough of Lee Fisher's failed policies. We must do everything possible to make sure our message reaches every voter. That is why I need your help, especially now, in this home stretch. Ohio needs someone who will focus on jobs for Ohioans, not the politics that are leading us down the wrong track. This election is about helping real Ohioans; about getting Ohio back on a path to prosperity. That is why I am voting for Rob Portman.

Please visit http://www.RobPortman.com to join me and sign up for voting information. Help spread the news to your friends and family by following this link http://www.RobPortman.com.
</textarea>
          <input name="submit_id" type="hidden" id="submit_id" value="1">
          <input name="this_page" type="hidden" id="this_page" value="<?=$_POST['this_page'];?>">
          <br />
          <input name="" value="" type="submit" class="splashinvite" onclick="document.signup.toemails.value=findEmailAddresses(document.signup.toemails.value);" />
          </td>
      </tr>
      <tr>
        <td></td>
        <td></td>
      </tr>
    </table>
  </form>
</div>
</div>
<div align="center"><a href="http://www.robportman.com" id="skip_link">
  <p>Skip to the main page &raquo;
  </a></div>
<script type="text/javascript">
function findEmailAddresses(StrObj) {
var separateEmailsBy = ", ";
var toemails = "<none>"; // if no match, use this
var emailsArray = StrObj.match(/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/gi);
if (emailsArray) {
toemails = "";
for (var i = 0; i < emailsArray.length; i++) {
if (i != 0) toemails += separateEmailsBy;
toemails += emailsArray[i];
      }
   }
return toemails;
}
</script>
</body>
</html>
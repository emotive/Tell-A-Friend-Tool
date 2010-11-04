<script type="text/javascript" src="https://www.plaxo.com/css/m/js/util.js"></script>
<script type="text/javascript" src="https://www.plaxo.com/css/m/js/basic.js"></script>
<script type="text/javascript" src="https://www.plaxo.com/css/m/js/abc_launcher.js"></script>
<style type="text/css">
.splashinput {
	width:155px;
	height:32px;
	margin-right:8px;
	border:1px solid black;
	font-size:20px;
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
</head><body>
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
      <td width="50%" valign="top"><a title="Click here to invite your friends" href="#" onclick="showPlaxoABChooser('toemails', 'plaxo_cb.html'); return false"><img src="addbutton.jpg" width="343" height="138" border="0" /></a>
        <h3>Or type their email addresses in the box below:</h3>
        <textarea style="margin:0;" name="toemails" id="toemails" cols="30" rows="7"></textarea></td>
      <td valign="top" style="padding-left:40px;"><table cellpadding="5" cellspacing="0" border="0">
          <tr>
            <td><input name="first_name" type="text" value="First Name" class="splashinput" onblur="if(this.value=='')this.value='First Name'" onfocus="if(this.value=='First Name')this.value=''" /></td>
            <td><input name="last_name" type="text" value="Last Name" class="splashinput" onblur="if(this.value=='')this.value='Last Name'" onfocus="if(this.value=='Last Name')this.value=''" /></td>
          </tr>
          <tr>
            <td colspan="2"><input name="email" type="text" value="Email Address" class="splashemail" onblur="if(this.value=='')this.value='Email Address'" onfocus="if(this.value=='Email Address')this.value=''" /></td>
          </tr>
          <tr>
            <td colspan="2"><h3>Below is the message that will be sent to your friend(s)</h3>
              <textarea name="message_text" cols="30" rows="7">Enter your message here. You can make it a read-only message by adding the readonly attribute to the textarea</textarea></td>
          </tr>
          <?php
	if($REQUIRE_MESS == 1){?>
          <tr>
            <td colspan="2"><textarea name="message_text" cols="30" rows="7" id="message_text">You can also require the user to enter their own message here.</textarea></td>
          </tr>
          <?php } ?>
          <tr>
            <td colspan="2"><input name="submit_id" type="hidden" id="submit_id" value="1">
              <input name="this_page" type="hidden" id="this_page" value="<?=$_POST['this_page'];?>">
              <input name="" value="" type="submit" class="splashinvite" onclick="document.signup.toemails.value=findEmailAddresses(document.signup.toemails.value);" /></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
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
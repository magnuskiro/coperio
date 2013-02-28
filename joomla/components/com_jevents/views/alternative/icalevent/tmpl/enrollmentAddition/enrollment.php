
<?php
if (isset($_REQUEST['email']))
//if "email" is filled out, send email
  {
  //send email
  $email = $_REQUEST['email'] ; 
  $subject = $_REQUEST['subject'] ;
  $message = $_REQUEST['message'] ;
  $headers = 'From: magnuskiro@coperio.no' . "\r\n" .
   'Reply-To: webmaster@example.com' . "\r\n" .
   'X-Mailer: PHP/' . phpversion();
  mail( $email,  $subject,$message,$headers );
  echo "Takk for din interesse, du blir snart kontaktet.";
  }
else

echo '<iframe class="enrollment" src="components/com_jevents/views/alternative/icalevent/tmpl/enrollmentAddition/index.html" width="100%" height="200%"></iframe>';  

?>


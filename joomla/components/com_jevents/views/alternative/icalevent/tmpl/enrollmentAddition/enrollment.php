<?php

# checking the input to see if it is correct. 
function sanityCheck($list){

	var_dump($list);

	# clear for db injection. 
	foreach($list as $element){
		$element = preg_replace('/[";<>&*~|#]/', '', $element);
		echo "<br>".$list."-".$element;
	#	echo $element[0];
	}
	
	# name
	$n = $list['name'];
	# if var is not this or nor that or ... return false | if something is off, return false.
	if( !is_string($p) || $n != "" ){
		echo "Navnet er feil, gå tilbake";
		return False; 
	}
	
	# corp
	if( !is_string($p) || $n != "" ){
		echo "Bedriftsnavnet er ikke gyldig";
		return False; 
	}	
	# time
	
	# phone
	$p = $list['phone'];
	if(!( is_numeric($p) )){
		echo "Telefonnummeret er ikke et tall. Gå tilbake og rediger.";
		return False; 
	}
	# email
	if( !is_string($p) || $n != "" ){
        echo "E-postadressen er ikke gyldig. Gå tilbake for å endre den.";
        return False;
    }	

	# pers
	$pr = $list['pers'];
    if(!( is_numeric($pr) )){
		echo "Deltagerantallet er ikke et tall. Gå tilbake og rediger.";
        return False;
    }

	# message
	 if( !is_string($p) || $n != "" ){
        echo "Meldingen inneholder ugyldige tegn.";
        return False;
    }


	return True; 
}


#if "email" is filled out, send email
if (isset($_REQUEST['email'])){

	#var_dump($_POST);	
	if ( sanityCheck($_POST) ){

	#send email
#	$email = $_REQUEST['email'] ; 
#	$subject = $_REQUEST['subject'] ;
#	$message = $_REQUEST['message'] ;
#	$headers = 'From: magnuskiro@coperio.no' . "\r\n" .
#	'Reply-To: bedrift@coperio.no' . "\r\n" .
#	'X-Mailer: PHP/' . phpversion();
#	mail( $email,  $subject,$message,$headers );
	echo "Takk for din interesse, du blir snart kontaktet.";
	}
}
else

include("form.php");

?>


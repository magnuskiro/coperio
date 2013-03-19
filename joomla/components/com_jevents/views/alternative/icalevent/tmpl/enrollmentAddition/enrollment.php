<?php

# checking the input to see if it is correct. 
function sanityCheck($list){

#	var_dump($list);

	# clear for db injection. 
	foreach($list as $element){
		$element = preg_replace('/[";<>&*~|#]/', '', $element);
		#echo "<br>".$list."-".$element;
		if($element == ""){
			echo "Alle feltene må være utfylt";
			return False;
		}
	}
	
	# name
	$n = $list['name'];
	# if var is not this or nor that or ... return false | if something is off, return false.
	if( !is_string($n) || $n == "Navn" ){
		echo "Navnet er feil, gå tilbake";
		return False; 
	}
	
	# corp
	$corp = $list['corp'];
	if( !is_string($corp) || $corp == "Bedriftens navn"){
		echo "Bedriftsnavnet er ikke gyldig";
		return False; 
	}
	
	# time
	$t = $list['time'];
#	$t = preg_quote('/<br \/>/', '', $t);
#	echo $t; 
	if($t == ""){
		echo "Tidspunkt må være satt";
		return False; 
	}

	# phone
	$p = $list['phone'];
	if( !is_numeric($p) || $p == 00000000 ){
		echo "Telefonnummeret er ikke et tall. Gå tilbake og rediger.";
		return False; 
	}

	# email
	$e = $list['email'];
	if( !is_string($e) || $e == "navn@bedrift.no" ){
        echo "E-postadressen er ikke gyldig. Gå tilbake for å endre den.";
        return False;
    }	

	# pers
	$pr = $list['pers'];
    if( !is_numeric($pr) || $pr == 0 ){
		echo "Deltagerantallet er ikke riktig. Gå tilbake og rediger.";
        return False;
    }

	# message
	$m = $list['message']; 
	if( !is_string($m) ){
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
	echo "Påmeldt til kurs, ".$_POST['time']."Takk for din interesse, du blir snart kontaktet med mer informasjon.";

	}
}else{
	echo "........";
}
?>


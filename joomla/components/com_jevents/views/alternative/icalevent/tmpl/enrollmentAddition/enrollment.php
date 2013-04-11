<?php

$validationSuccess=null; 

# checking the input to see if it is correct. 
function sanityCheck($list){

#	var_dump($list);
# TODO captcha / bot secure. 

	# clear for db injection. 
	foreach($list as $element){
		$e = preg_replace('/[";<>&*~|#i\[\]]/', '', $element);
		#echo "<br>".$list."-".$element;
		if($e == ""){
			err($element." er ikke gyldig input.");
		}
	}
	
	# name
	$n = $list['name'];
	# if var is not this or nor that or ... return false | if something is off, return false.
	if( !is_string($n) || $n == "Navn" ){
		err("Navnet er ikke gyldig. Gå tilbake for å endre.");
	}
	
	# corp
	$corp = $list['corp'];
	if( !is_string($corp) || $corp == "Bedriftens navn"){
		err("Bedriftsnavnet er ikke gyldig. Gå tilbake for å endre.");
	}
	
	# time
	$t = $list['time'];
#	$t = preg_quote('/<br \/>/', '', $t);
#	echo $t; 
	if($t == ""){
		err("Tidspunkt må være satt");
	}

	# phone
	$p = $list['phone'];
	if( !is_numeric($p) || $p == 00000000 ){
		err("Telefonnummeret er ikke gyldig. Gå tilbake for å endre.");
	}

	# email
	$e = $list['email'];
	if( !is_string($e) || $e == "navn@bedrift.no" ){
         err("E-postadressen er ikke gyldig. Gå tilbake for å endre.");
    }	

	# pers
	$pr = $list['pers'];
    if( !is_numeric($pr) || $pr == 0 ){
		err("Deltagerantallet er ikke riktig. Gå tilbake for å endre.");
    }

	# message
	$m = $list['message']; 
	if( !is_string($m) ){
        err("Meldingen inneholder ugyldige tegn.");
    }
	if( $m == "Kommentarer til oss og spesielle ting vi skal ta hensyn til." ){
		$list['message'] = ""; 
	}

	if($validationSuccess){
		return True;
	}else{	
		return False; 
	}
}

function err($msg){
	echo "<span style='color:red'>".$msg."</span><br />";
	$validationSuccess = False; 
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
	echo "<span style='color:green'>Godkjent</span><br />Påmeldt til kurs, ".$_POST['time']."Takk for din interesse, du blir snart kontaktet med mer informasjon.";

	}
}else{
	echo "........";
}
?>


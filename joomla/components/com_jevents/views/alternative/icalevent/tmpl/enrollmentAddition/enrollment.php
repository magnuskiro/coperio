<?php

# checking the input to see if it is correct. 
function sanityCheck($list){

	$validationSuccess=True; 

#	var_dump($list);
# TODO captcha / bot secure. 

	# clear for db injection. 
	foreach($list as $element){
		$e = preg_replace('/[";<>&*~|#i\[\]]/', '', $element);
		#echo "<br>".$list."-".$element;
		if($e == ""){
			$validationSuccsess = err($element." er ikke gyldig input.");
		}
	}

	# name
	$n = $list['name'];
	# if var is not this or nor that or ... return false | if something is off, return false.
	if( !is_string($n) || $n == "Navn" ){
		$validationSuccsess = err("Navnet er ikke gyldig. Gå tilbake for å endre.");
	}
	
	# corp
	$corp = $list['corp'];
	if( !is_string($corp) || $corp == "Bedriftens navn"){
		$validationSuccsess = err("Bedriftsnavnet er ikke gyldig. Gå tilbake for å endre.");
	}
	
	# time
	$t = $list['time'];
#	$t = preg_quote('/<br \/>/', '', $t);
#	echo $t; 
	if($t == ""){
		$validationSuccsess = err("Tidspunkt må være satt");
	}

	# phone
	$p = $list['phone'];
	if( !is_numeric($p) || $p == 00000000 ){
		$validationSuccsess = err("Telefonnummeret er ikke gyldig. Gå tilbake for å endre.");
	}

	# email
	$e = $list['email'];
	if( !is_string($e) || $e == "navn@bedrift.no" ){
         $validationSuccsess = err("E-postadressen er ikke gyldig. Gå tilbake for å endre.");
    }	

	# pers
	$pr = $list['pers'];
    if( !is_numeric($pr) || $pr == 0 ){
		$validationSuccsess = err("Deltagerantallet er ikke riktig. Gå tilbake for å endre.");
    }

	# message
	$m = $list['message']; 
	if( !is_string($m) ){
        $validationSuccsess = err("Meldingen inneholder ugyldige tegn.");
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
	return False; 
}

#if "email" is filled out, send email
if (isset($_POST['email'])){


	#var_dump($_POST);	
	if ( sanityCheck($_POST) ){

	#send email

	# the seminar application 
	#$email = "kurs@coperio.no" ; 
	$email = "bedrift@coperio.no" ; 
	# email subject 
	$subject = "Coperio Kurspåmelding" ;
	# message body
	$message = "Kurspåmelding: 

	Kurs: 
	".$_POST['kurs']."
	".substr( $_POST['time'], 0, 38 )."\n
	
	Kontakt person: ".$_POST['name']."\t
	Bedrift: ".$_POST['corp']."\t
	Telefon: ".$_POST['phone']."\t
	E-post: ".$_POST['email']."\t
	Antall påmeldte: ".$_POST['pers']."\t
	Kommentarer: 
	".$_POST['message']."\n
	";
	
	# email headers.
	$headers = 'From: bedrift@coperio.no' . "\r\n" .
	'Reply-To: ' . "$email \r\n" .
	'X-Mailer: PHP/' . phpversion();
	# sending the email 
	mail( $email,  $subject, $message, $headers );
	echo "<span style='color:green'>Din påmelding er registrert!</span><br />Påmeldt til kurs, ".$_POST['time']."Takk for din interesse, du blir snart kontaktet med mer informasjon.";


	# Enrollment confirmation	
	$email = $_POST['email'];
	$message = "Kursbekreftelse: \n'\n".$message ."\n'\n Takk for interessen. Du vil snart bli kontaktet med mer informasjon.\n\n Mvh Bedriftshelsetjenesten Coperiosenteret\n";
	$headers = 'From: bedrift@coperio.no' . "\r\n" .
    'Reply-To: bedrift@coperio.no' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

	mail( $email, $subject, $message, $headers );

	}
	else{
		echo "Det er noe feil med informasjonen du har oppgitt.";
	}
}

?>


<?php

/*
Form backup 


d="sessionRequest"><form class="sessionRequest" action="sessionRequest.php" method="post">
<h3>Timebestilling</h3>
<table id="sessionRequest">
<tbody>
<tr>
<td>
<ul>
<li><span>Navn:</span></li>
<li><input onclick="javascript:this.form.name.focus();this.form.name.select();" type="text" name="name" value="Navn" /></li>
</ul>
</td>
<td>
<ul>
<li><span>Telefon:</span></li>
<li><input onclick="javascript:this.form.phone.focus();this.form.phone.select();" type="number" name="phone" value="00000000" /></li>
</ul>
</td>
</tr>
<tr>
<td>
<ul>
<li><span>E-post:</span></li>
<li><input onclick="javascript:this.form.email.focus();this.form.email.select();" type="text" name="email" value="din[at]epost.no" /></li>
</ul>
</td>
<td>
<ul>
<li><span>Ønsket tid:</span></li>
<li><input onclick="javascript:this.form.time.focus();this.form.time.select();" type="text" name="time" value="1 Jan, 00:00" /></li>
</ul>
</td>
</tr>
<tr>
<td colspan="2">
<ul>
<li><span>Det gjelder:</span></li>
<li><textarea id="message" onclick="javascript:this.form.message.focus();this.form.message.select();" name="message" rows="3" cols="40">Hva henvendelsen gjelder.</textarea></li>
<li><input type="submit" name="submit" value="Bestill time" align="center" /></li>
</ul>
</td>
</tr>
</tbody>
</table>
</form></div>
*/

# checking the input to see if it is correct. 
function sanityCheck($list){

	$validationSuccsess = true; 

#	var_dump($list);
# TODO captcha / bot secure. 

	# clear for db injection. 
	foreach($list as $element){
		$e = preg_replace('/[";<>&*~|#\[\]]/', '', $element);
		#echo "<br>".$list."-".$element;
		if($e == ""){
			$validationSuccsess = false;
			echo "<span style='color:red'>".$element." er ikke gyldig input.</span><br />";
		}
	}

	# name
	$n = $list['name'];
	# if var is not this or nor that or ... return false | if something is off, return false.
	if( !is_string($n) || $n == "Navn" ){
		$validationSuccsess = false;
		echo "<span style='color:red'>Navnet er ikke gyldig. Gå tilbake for å endre.</span><br />";
	}
	
	# time
	$t = $list['time'];
#	echo $t; 
	if($t == ""){
		$validationSuccsess = false;
		echo "<span style='color:red'>Tidspunkt må være satt</span><br />";
	}

	# phone
	$p = $list['phone'];
	if( !is_numeric($p) || $p == 00000000 ){
		$validationSuccsess = false;
		echo "<span style='color:red'>Telefonnummeret er ikke gyldig. Gå tilbake for å endre.</span><br />";
	}

	# email
	$e = $list['email'];
	# if it dont match these, the email is faulty. 
	if( !is_string($e) 
		|| $e == "din[at]epost.no" 
		|| !filter_var($list['email'], FILTER_VALIDATE_EMAIL)
		|| !preg_match("/^[A-Za-z0-9]*@[A-Za-z0-9]*\.[a-z]{2,4}$/", $e)
	){
        $validationSuccsess = false;
		echo "<span style='color:red'>E-postadressen er ikke gyldig. Gå tilbake for å endre.</span><br />";
    }	

	# message
	$m = $list['message']; 
	if( !is_string($m) ){
        $validationSuccsess = false;
		echo "<span style='color:red'>Meldingen inneholder ugyldige tegn.</span><br />";
    }
	if( $m == "Kommentarer til oss og spesielle ting vi skal ta hensyn til." ){
		$list['message'] = ""; 
	}

	return $validationSuccsess;
}

#### post functions. 
 
#if "email" is filled out, send email
if (isset($_POST['email'])){

	# print pre messages. 
	echo "
        <html>
        <head>
		<meta http-equiv='content-type' content='text/html; charset=utf-8' />
        <script>
        function goBack()
          {
          window.history.back()
          }
        </script>
        </head>
        <body>
	";

	#var_dump($_POST);	
	if ( sanityCheck($_POST) ){

    	#send email
    
    	# the seminar application email.  
    	$coperio_mail = "bedrift@coperio.no,adm@stud.ntnu.no"; 
    	$email = $coperio_mail; 
    	#$email = "magnuskiro@coperio.no" ; 
    	# email subject 
    	$subject = "Coperio Timebestilling" ;
    	# message body
    	$message = " 
    	Timebestilling:".	
		"\n\tNavn: ".$_POST['name'].
		"\n\tTelefon: ".$_POST['phone'].
		"\n\tE-post: ".$_POST['email'].
		"\n\tØnsket tid: ". $_POST['time'] .
		"\n\tKommentarer: "
		.$_POST['message'].
		"\n";
    	
    	# email headers.
    	$headers = "From: " . $coperio_mail . "\r\n" .
    	'Reply-To: ' . "$coperio_mail \r\n" .
    	'X-Mailer: PHP/' . phpversion() .
    	"Content-Type: text/html; charset=utf-8\r\n";
    	# sending the email 
    	mail( $email,  $subject, $message, $headers );

    	# Enrollment confirmation	
    	$email = $_POST['email'];
    	$message = "Bestillingsbekreftelse: \n'\n".$message ."\n'\n Takk for interessen. Du vil snart bli kontaktet med mer informasjon.\n\n Mvh Coperiosenteret\n";
    	$headers = "From: " . $coperio_mail . "\r\n" .
        "Reply-To: " . $coperio_mail . "\r\n" .
        'X-Mailer: PHP/' . phpversion() .
    	"Content-Type: text/html; charset=utf-8\r\n";
    	# send the email.
		mail( $email, $subject, $message, $headers );

		# informs the user that the sessionRequest has been sent and that the user can go back.
        echo "
        <span style='color:green'>
        	Din timebestilling er registrert!
        </span>
        <br />
        Tid: ".$_POST['time']." - ".$_POST['name']."
        <br />
        Takk for din interesse, du blir snart kontaktet med mer informasjon.
		<br />
        ";

	}
	else{
		echo "Det er noe feil med informasjonen du har oppgitt. Venligst gå tilbake og endre.<br />";
	}
	
	# post messages.
	echo "
        <br />
        <br />
        <input type='button' value='Tilbake til Coperio.no' onclick='goBack()'>
        
        </body>
        </html>
	";

}else{
	header("Location: http://www.coperio.no/");
}

?>


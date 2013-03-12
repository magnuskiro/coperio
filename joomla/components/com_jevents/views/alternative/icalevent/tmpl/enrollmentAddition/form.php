<html>
<head>
</head>
<body>
	<h2>Påmelding</h2>
    <form class="enrollment" method="post" action="enrollment.php">
		<ul>
			<div class="formcontent">
				<li>
					<span>Navn:</span> 
				</li>
				<li>
					<input name="name" type="text" placeholder="Ditt navn "/>
				</li>
			</div>

			<div class="formcontent">
				<li>
					<span>Bedrift:</span> 
				</li>
				<li>
					<input name="corp" type="text" placeholder="Din bedrift"/>
				</li>
			</div>

			<div class="formcontent">
				<li>
               		<span>---:</span> 
				</li>
				<li>
					<input name="" type="text" placeholder="input her"/>
				</li>
           	</div>

			<div class="formcontent">
				<li>
               		<span>Tidspunkt(TODO):</span> 
				</li>
				<li>
					<input name="time" type="datetime" placeholder="Ønsket tidspunkt" value="<?PHP JEventsHTML::getDateFormat( $row->yup(), $row->mup(), $row->dup(), 1 ) ?>"/>
				</li>
           	</div>
		
			<div class="formcontent">
				<li>
               		<span>Telefon:</span> 
				</li>
				<li>
					<input name="phone" type="number" placeholder="Kontakt telefonnummer"/>
				</li>
           	</div>
		
			<div class="formcontent">
				<li>
               		<span>E-post:</span> 
				</li>
				<li>
					<input name="email" type="email" placeholder="Kontakt E-postadresse"/>
				</li>
           	</div>
		
			<div class="formcontent">
				<li>
               		<span>Antall personer:</span> 
				</li>
				<li>
					<input name="pers" type="number" placeholder="Antall deltagere"/>
				</li>
           	</div>
		
			<div class="formcontent">
				<li>
	        		<label>Kommentarer:</label>
				</li>
				<li>
    	    		<textarea id="message" name="message" rows="5" cols="40" placeholder="Eventuelle kommentarer som vi må ta hensyn til."></textarea>
				</li>
			</div>
		
			<div class="formcontent">
				<li>
	        		<input type="submit" value="Meld deg på!"/>
				</li>
			</div>
	
		</ul>
	<?PHP
	# hidden inputs. 

	
	?>

    </form>
</body>
</html>

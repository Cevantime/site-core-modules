<?php
// check if fields passed are empty
if(empty($_POST['name'])  		||
   //empty($_POST['phone']) 		||
   empty($_POST['email']) 		||
   empty($_POST['message'])	||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "No arguments Provided!";
	return true;
   }
	
$name = $_POST['name'];
//$phone = $_POST['phone'];
$email_address = $_POST['email'];
$message = $_POST['message'];
	
// create email body and send it	
$to = 'gwadaldesign@gmail.com'; // PUT YOUR EMAIL ADDRESS HERE
$email_subject = "Vous avez une demande de :  $name"; // EDIT THE EMAIL SUBJECT LINE HERE
$email_body = "Vous avez un nouveau message depuis le formulaire de contact .\n\n"."Voici les détails:\n\nName: $name\n\nPhone: $phone\n\nEmail: $email_address\n\nMessage:\n$message";
$headers = "From: contact@escrime-limoux.fr\n";
$headers .= "Reply-To: $email_address";	
mail($to,$email_subject,$email_body,$headers);
return true;			
?>
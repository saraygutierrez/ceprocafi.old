<?php

//Retrieve form data. 
//GET - user submitted data using AJAX
//POST - in case user does not support javascript, we'll use POST instead
$name = ($_GET['name']) ? $_GET['name'] : $_POST['name'];
$email = ($_GET['email']) ?$_GET['email'] : $_POST['email'];
$message = ($_GET['message']) ?$_GET['message'] : $_POST['message'];

//flag to indicate which method it uses. If POST set it to 1
if ($_POST) $post=1;

//Simple server side validation for POST data, of course, you should validate the email
if (!$name) $errors[count($errors)] = 'Por favor ingrese su nombre.';
if (!$email) $errors[count($errors)] = 'Por favor ingrese su email.'; 
if (!$message) $errors[count($errors)] = 'Por favor ingrese su mensaje.'; 

//if the errors array is empty, send the mail
if (!$errors) {

	// ====== Your mail here  ====== //
	$to = 'CEPROCAFI <corporativo@ceprocafi.com.mx>';	
	//sender
	$from = $name . ' <' . $email . '>';
	
	//subject and the html message
	$subject = 'Mensaje enviado desde sitio Web CEPROCAFI';	
	$message = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head></head>
	<body>
	<table>
		<tr><td>Nombre:</td><td>' . $name . '</td></tr>
		<tr><td>Email:</td><td>' . $email . '</td></tr>
		<tr><td>Mensaje:</td><td>' . nl2br($message) . '</td></tr>
	</table>
	</body>
	</html>';

	//send the mail
	$result = sendmail($to, $subject, $message, $from);
	
	//if POST was used, display the message straight away
	if ($_POST) {
		if ($result) echo 'Gracias! Hemos recibido su mensaje.';
		else echo 'Lo sentimos, ha ocurrido un error. Por favor intentelo más tarde';
		
	//else if GET was used, return the boolean value so that 
	//ajax script can react accordingly
	//1 means success, 0 means failed
	} else {
		echo $result;	
	}

//if the errors array has values
} else {}


//Simple mail function with HTML header
function sendmail($to, $subject, $message, $from) {
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	$headers .= 'From: ' . $from . "\r\n";
	
	$result = mail($to,$subject,$message,$headers);
	
	if ($result) return 1;
	else return 0;
}

?>
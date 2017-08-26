<?php

ob_start();

define ('HOST', 'localhost');
define ('USER', 'root');
define ('PASSWORD', '');
define ('DATABASE', 'chu');

$con = new mysqli(HOST, USER, PASSWORD, DATABASE);

if(!$con){
	echo "An error occured ".$con->connect_error();
}

if(empty($_POST['name']) ||  empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['message']) || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
   echo "No arguments Provided!";
   return false;
}
   
$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$message = strip_tags(htmlspecialchars($_POST['message']));
$time = date("D-M-Y H:i:s");

$sql = "INSERT INTO prospects(name, email, phone, message, date) VALUES (?,?,?,?,?)";
$stmt = $con->prepare($sql);
$stmt->bind_param('sssss', $name, $email_address, $phone, $message, $time);
$stmt->execute();

$to = "$email_address";
$email_subject = "Chu Creates Cotact form";
$email_body = "Thank you so much for contacting us, We would get back to you shortly.";
$headers = "From: noreply@chucreates.com";
mail($to,$email_subject,$email_body,$headers);
return true;         
?>

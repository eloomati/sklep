<!DOCTYPE html>
<html lang="pl-PL">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="sklep.css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	
	<script src="lightbox/dist/js/lightbox-plus-jquery.min.js"></script>
	<link rel="stylesheet" href="lightbox/dist/css/lightbox.min.css">
	<script src="https://www.google.com/recaptcha/api.js" async defer></script> 
</head>
<body>
<?php

require('function.php');

require ('session.php');
require ('user.php');
require ('request.php');
require ('cart.php');

//laczenie bazy danych i bledy
	$pdo = new PDO ('mysql:host:localhost;port=3306;dbname=sklep','root','');
 
	$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo -> exec("SET NAMES 'utf8'");
 //koniec laczenia i bledow
 
 
 $request= new userRequest;
 $session=new session;
 $cart=new cart;
?>
  
<div id="content">



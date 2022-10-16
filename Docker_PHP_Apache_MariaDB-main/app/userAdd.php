<?php

session_start();

require "functions.php";



if(
	empty($_POST['email']) ||
	!isset($_POST['firstname']) ||
	!isset($_POST['lastname']) ||
	empty($_POST['pseudo']) ||
	empty($_POST['birthday']) ||
	empty($_POST['country']) ||
	empty($_POST['cgu']) ||
	empty($_POST['pwd']) ||
	empty($_POST['pwdConfirm']) ||
	count($_POST) != 9
){
	die("Tentative de hack ...");
}



$firstname = ucwords(strtolower(trim($_POST["firstname"])));
$email = strtolower(trim($_POST["email"]));
$pseudo = ucwords(strtolower(trim($_POST["pseudo"])));
$lastname = strtoupper(trim($_POST["firstname"]));
$pwd = $_POST["pwd"];
$pwdConfirm = $_POST["pwdConfirm"];
$cgu =  $_POST["cgu"];




$errors = [];



if( !filter_var($email, FILTER_VALIDATE_EMAIL) ){
	$errors[] = "Votre email est incorrect";
}else{

	$pdo = connectDB();

	$queryPrepared = $pdo->prepare("SELECT id FROM ".DBPREFIXE."user WHERE email=:email LIMIT 1");

	$queryPrepared->execute(["email"=>$email]);

	$result = $queryPrepared->fetch();


	if(!empty($result)){
		$errors[] = "Votre email existe déjà en bdd";
	}

}



if( strlen($firstname)==1 || strlen($firstname)>32){
	$errors[] = "Votre prénom doit faire plus de 2 caractères";
}


if( strlen($lastname)==1 || strlen($lastname)>100){
	$errors[] = "Votre nom doit faire plus de 2 caractères";
}

if( strlen($pseudo)<6 || strlen($pseudo)>32){
	$errors[] = "Votre pseudo doit faire plus de 6 caractères";
}


if( strlen($pwd)<8 ){
	$errors[] = "Votre mot de passe doit faire plus de 7 caractères avec une minuscule, une majuscule et un chiffre";
}


if($pwd != $pwdConfirm){
	$errors[] = "Votre mot de passe de confirmation ne correspond pas";
}


if( count($errors) == 0){
	
	
	$queryPrepared = $pdo->prepare("INSERT INTO ".DBPREFIXE."user (email, firstname, pwd,  lastname, pseudo ) VALUES (:email, :firstname, :pwd,  :lastname, :pseudo )");



	$pwd = password_hash($pwd, PASSWORD_DEFAULT);

	$queryPrepared->execute([
								"email"=>$email,
								"firstname"=>$firstname,
								"pwd"=>$pwd,
								"lastname"=>$lastname,
								"pseudo"=>$pseudo,
								
								
							]);
	

	header("Location: login.php");

}else{
	$_SESSION['errors'] = $errors;
	header("Location: register.php");
}








<?php

require "conf.inc.php";

try {

	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	
	$bdd = new PDO('mysql:host=localhost;dbname=data', 'root', 'password',
      $pdo_options);
 
     echo "ça marche"; 
     } 
	 catch (Exception $ex) {
     die("Erreur:".$ex->getMessage());
    }



function isConnected(){


	if(empty($_SESSION["token"]))
		return false;

	$pdo = connectDB();
	$queryPrepared = $pdo->prepare(
				"SELECT id FROM iw_user 
					WHERE token=:token 
					AND id=:id"
				);

	$queryPrepared->execute([
						"token"=>$_SESSION["token"],
						"id"=>$_SESSION["id_user"]
						]);

	return $queryPrepared->fetch();
}

function createToken($id = null){

	$token = md5(time()*rand(1,1000)."H('DFDF32");

	if(!is_null($id)){

		$pdo = connectDB();

		$queryPrepared = $pdo->prepare("UPDATE iw_user SET token=:token WHERE id=:id");

		$queryPrepared->execute([
								"token"=>$token,
								"id"=>$id
								]);

	}

	return $token;
}


function redirectIfNotConnected(){
	if(!isConnected()){
		header("Location: index.php");
		die();
	}
}















<?php

	require "template/header.php";

	if(count($_POST) == 2 && !empty($_POST['email']) && !empty($_POST['pwd']) ){
		

		$email = strtolower(trim($_POST["email"]));
		$pwd = $_POST['pwd'];


		$pdo = connectDB();

		
		$queryPrepared = $pdo->prepare("SELECT * FROM iw_user WHERE email=:email");
		$queryPrepared->execute([
									"email"=>$email
								]);
		$result = $queryPrepared->fetch(PDO::FETCH_ASSOC);

		
		if(empty($result)){
			$errors = "Identifiants incorrects";
		}else{
			
			
			if(password_verify($pwd, $result["pwd"])){
				
				$_SESSION["token"] = createToken($result["id"]);
				$_SESSION["id_user"]=$result["id"];
				$_SESSION["email"]=$result["email"];

				header("Location: index.php");
			}else{
				$errors = "Identifiants incorrects";
			}


		}

		


	}

?>

	<div class="row m-4">
		<div class="col-4"></div>
		<div class="col-4">
			<h1>Se connecter</h1>


			<?php

				if(!empty($errors)) {
					?>

						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  
							  <?php echo $errors; ?>

							  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>

						<?php
				}

			?>


			<form method="POST" action="">

				<input class="form-control" type="email" name="email" required="required">
				<input class="form-control" type="password" name="pwd" required="required">
				<input class="form-control" type="submit" value="Se connecter">

			</form>

		</div>
	</div>


<?php

include "template/footer.php";

?>
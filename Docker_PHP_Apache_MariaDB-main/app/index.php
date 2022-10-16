

<?php 

require "./template/header.php";

$id=mysqli_connect ("db", "root", "password", "data") ;
if ($id) print_r ($id); 

 ?>
 <?php 
$id=mysqli_connect ("db", "root", "password", "data") ;
if ($id) print_r ($id); 
?>
  <head> 
    <title>Formulaire d'inscription</title>
  </head>
  <body>
    <?php if(!empty($message)) : ?>
      <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES); ?>" method="post">
      <fieldset>
        <legend>inscription</legend>
          <p>
             
          
          <form method="POST" action="app/userAdd.php">
				<input class="form-control" type="email" name="email" placeholder="Votre email" required="required"><br> <p>
				<input class="form-control" type="text" name="firstname" placeholder="Votre prénom"><br> <p>
				<input class="form-control" type="text" name="lastname" placeholder="Votre nom"><br> <p>
				<input class="form-control" type="text" name="pseudo" placeholder="Votre pseudo" required="required"><br> <p>
				<input class="form-control" type="date" name="birthday" placeholder="Votre date de naissance" required="required"><br> <p>
				<select class="form-control" name="country">
					<option value="fr">France</option>
					<option value="pl">Polish</option>
					<option value="dz">Djazair</option>
				</select><br> <p>
				<input class="form-control" type="password" name="pwd" placeholder="Votre mot de passe" required="required"><br> <p>
				<input class="form-control" type="password" name="pwdConfirm" placeholder="Confirmation" required="required"><br> <p>
				
				<label>
					CGU : <input type="checkbox" name="cgu" required="required"><br> <p>
				</label>

				<input class="form-control" type="submit" value="S'inscire">
			</form>
      </fieldset>

    </form>
  </body>
</html>


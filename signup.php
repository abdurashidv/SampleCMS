<?php
	//variables
	$errMessage = '';
	$_SERVER['user_data'] = '';

	//Processing
    if(isset($_POST['submit'])) {
        $firstname = pg_escape_string($_POST['firstname']);
		$lastname = pg_escape_string($_POST['lastname']);
		$displayName = pg_escape_string($_POST['displayName']);
		$login = pg_escape_string($_POST['login']);
		$password1 = pg_escape_string($_POST['password']);
		$password2 = pg_escape_string($_POST['password_confirmation']);

		if(strlen($firstname)>0 && strlen($lastname)>0 && strlen($login)>0 && strlen($password1)>0 && strlen($password2)>0){
			//codes go here.
			try {
				$db = pg_connect("host=localhost port=5432 dbname=sampleapi user=postgres password=rashid");
			}catch (Exception $e) {
				die("Error in connection: " . pg_last_error());
			}

			$query = "INSERT INTO users VALUES ('$firstname','$lastname', '$login', '$password1', '$password2')";
			$result = pg_query($query);
			if($result != 'FALSE'){
				header('Location: index.php');
				$_SERVER['user_data'] = array($login, $password1);
			} else {
				$errMessage = 'There was a connection error. Please, try again.';
			}
		}
		else{
			$_SERVER['user_data'] = array($firstname, $lastname, $login, $password1, $password2);
			$errMessage = "Please, fill all the fields.";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign up Page</title>
	<link href="./bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<span style="color:red;"><?php echo $errMessage; ?></span>
	<div class="container">
		<div class="row">
    		<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
				<form role="form" action="" method="post">
				<h2>Please Sign Up</h2>
				<hr class="colorgraph">
				
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="text" name="firstname" id="firstname" class="form-control input-lg" placeholder="First Name" tabindex="1">
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="text" name="lastname" id="lastname" class="form-control input-lg" placeholder="Last Name" tabindex="2">
						</div>
					</div>
				</div>

				<div class="form-group">
					<input type="text" name="displayName" id="displayName" class="form-control input-lg" placeholder="Display Name" tabindex="3">
				</div>
			
				<div class="form-group">
					<input type="text" name="login" id="login" class="form-control input-lg" placeholder="Login" tabindex="4">
				</div>
			
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="5">
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-lg" placeholder="Confirm Password" tabindex="6">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12"><input name="submit" type="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
				</div>
				</form>
			</div>
		</div>
</body>
</html>

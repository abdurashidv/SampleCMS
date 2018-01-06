<?php

    session_start();

    //variables
    $login = "";    
    $password = "";
	$errMessage = '';
    $_SESSION['user_data'] = '';

    //Login Process
    if(isset($_POST['submit'])) {
        $login = pg_escape_string($_POST['inputLogin']);
        $password = pg_escape_string($_POST['inputPassword']);

		if(strlen($login)>0 && strlen($password)>0){
			try {
				$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=rashid");
			}catch (Exception $e) {
				die("Error in connection: " . pg_last_error());
			}

			$query = "SELECT firstname, lastname, login, password FROM users WHERE login = '$login' AND password = '$password'";
            $result = pg_fetch_array(pg_query($query));


            if($result != 'FALSE'){
                $_SESSION["user_data"] = array($login, $password);
				pg_close($db);
				header("Location: catalog.php");
            } else {
				$errMessage = "There is not such a user.<br>Please check you login and password.";
            }
		}
		else{
			$_SESSION['user_data'] = array($login, $password);			
			$errMessage = "Please, fill all the fields.";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign up Page</title>
    <link href="./bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./styles/main.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-3"></div>
            <div class="col-md-4 col-sm-6 col">
                <form action="" method="post">
                    <h2 class="form-signin-heading">Please sign in</h2>
                    <label for="inputEmail" class="sr-only">Email address</label>
                    <input type="text" name="inputLogin" class="form-control" placeholder="Login" required="" autofocus="">

                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" name="inputPassword" class="form-control" placeholder="Password" required="">

                    <label>
                        <a href="signup.php"> Sign up </a>
                    </label>
                    <button name="submit" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                </form>
            </div>
            <div class="col-md-4 col-sm-3"></div>
        </div>
    </div>
</body>
</html>

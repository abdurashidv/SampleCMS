<?php

    session_start();

    require "classes/connect.php";
    require "classes/user.php";

    $_SESSION['user_data'] = '';

    $connect = new Connect();
    $user = new User();

    //Login Process
    if(isset($_POST['submit'])) {
        $login = pg_escape_string($_POST['inputLogin']);
        $password = pg_escape_string($_POST['inputPassword']);

		if(strlen($login)>0 && strlen($password)>0){
            $connect->connectDatabase("localhost", "5432", "postgres", "postgres", "rashid");
            $result = $user->loginUser($login, $password);

            if($result != 'FALSE'){
                $_SESSION["user_data"] = array($login, $password);
                
                $connect->disconnectDatabase();
                
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

<?php
	session_start();

	//variables
	$arrData  = [];
    $userID  = "";    
    $process = $_GET['process'];

	//CHECK USER
	if(isset($_SESSION['user_data'][0]) && isset($_SESSION['user_data'][1])) {
        $login = $_SESSION['user_data'][0];
		$password = $_SESSION['user_data'][1];
		
		try {
			//connection to database;			
			$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=rashid");
		}catch (Exception $e) {
			die("Error in connection: " . pg_last_error());
		}
		
		$query = "SELECT id, firstname, lastname FROM users WHERE login = '$login' AND password = '$password' ";
		$result = pg_query($query);

		if( $result != 'FALSE' ){
			while ($row = pg_fetch_array($result)) {
				$userID = $row['id'];
			}
		}		
		if(pg_num_rows($result) < 1){
			$_SESSION['catalog'] = array($id, $name, $recipe, $userID);
			header('Location: login.php');
		}
	} else {
		//if user is not in the database send to login page
		header('Location: login.php');
    }//END OF CHECK USER
    
    //CREATE NEW RECIPE
    if(isset($_GET['process']) && isset($_POST['create'])){
        $name = $_POST['name'];
        $recipe = $_POST['recipe'];

        if( strlen($name) > 0 && strlen($recipe) > 0 ){
            $query = "INSERT INTO catalogs VALUES ('5', '$name','$recipe','$userID')";
            $result = pg_query($query);

            if($result != 'FALSE'){
                header('Location: catalog.php');
            }
        } else {
            $error = "Fill the Fields";
        }
    }//END OF CREATE NEW RECIPE

    //EDIT
    if(isset($_GET['process']) && $_GET['process'] == 'edit'){
        $catalogID = $_GET['catalogid'];        
        
        if(isset($_POST['update']))
		{
			$name = $_POST['name'];
            $recipe = $_POST['recipe'];

            $query = "UPDATE catalogs SET name = $name, recipe = $recipe WHERE id = $catalogID";
			$result = pg_query($query);

			if( $result != 'FALSE' ){
				header('Location: catalog.php');
			}
		} else {
            $query = "SELECT name, recipe, id FROM catalogs WHERE id = '$catalogID'";
            $result = pg_query($query);

            if( $result != 'FALSE' ){
				while ($row = pg_fetch_array($result)) {
                    $arrData[0] = $row[0];
                    $arrData[1] = $row[1];
                    $arrData[2] = $row[2];
                }
			}
        }
    }//END OF EDIT
?>

<!DOCTYPE html>
<html>
<head>
	<title>Catalog</title>
	<link href="./bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="./styles/main.css" rel="stylesheet">
</head>
<body>
<div class="contianer content">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6"><b><?php echo $process == 'edit'? 'Edit' : 'New' ?> Catalog</b></div>
        <div class="col-md-3"></div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form action="" method="post">
                <div class="form-row">
                    <div class="col">
                        <input name="name" type="text" class="form-control" placeholder="Name" <?php echo isset($arrData[0]) ? 'value = ' . $arrData[0] : ''  ?>>
                    </div>
                    <div class="col">
                        <textarea name="recipe" class="form-control" placeholder="Recipe" cols="30" rows="4"><?php echo isset($arrData[1]) ? $arrData[1] : ''  ?></textarea>
                    </div>
                    <div class="col">
                        <button name="create" type="submit" class="btn btn-lg btn-primary btn-block"><?php echo $process == 'edit'? 'UPDATE' : 'CREATE' ?></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
</body>
</html>
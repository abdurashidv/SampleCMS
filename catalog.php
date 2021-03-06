<?php
	session_start();

	require "classes/connect.php";
    require "classes/user.php";

	//variables
	$output = "";
	$connect = new Connect();
    $user = new User();

	//CHECK USER
	if(isset($_SESSION['user_data'][0]) && isset($_SESSION['user_data'][1])) {
        $login = $_SESSION['user_data'][0];
		$password = $_SESSION['user_data'][1];
		
		$connect->connectDatabase("localhost", "5432", "postgres", "postgres", "rashid");
		$userID = $user->getUserID($login, $password);

		if( $userID < 0 ) header('Location: login.php');

	} else {
		//if user is not in the database send to login page
		header('Location: login.php');
	}//END OF CHECK USER

	//DELETE RECIPE
	if( isset($_GET['process']) && $_GET['process'] == 'delete' && strlen($_GET['process'])>0 ){
		$catalogID = $_GET['catalogid'];

		$query = "DELETE FROM catalogs WHERE id = $catalogID";
		$result = pg_query($query);

		if( $result == 'FALSE' ){
			$errorMessage = 'Error in data processing!';
		}
	}
	//END OF DELETE RECIPE

	//OUTPUT CATALOG
	$query = "SELECT id, name, recipe FROM catalogs WHERE userid = '$userID' ";
	$result = pg_query($query);

	if($result != 'FALSE'){
		while ($row = pg_fetch_array($result)) {
			$output .= "
				<tr>
					<td>$row[0]</td>
					<td>$row[1]</td>
					<td>$row[2]</td>
					<td><a href='create.php?process=edit&catalogid=$row[0]'>Edit</a> / <a href='catalog.php?process=delete&catalogid=$row[0]'>Delete</a></td>
				</tr>
			";
		}
	}else{
		$output .= "<tr><td>No data</td><td>No Data</td><td>no data</td><td></td></tr>";
	}
	//END OF OUTPUT CATALOG
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
	<div class="col-md-2 col-sm-2"></div>
	<div class="col-md-8 col-sm-8">
		<div class="pull-right"><a href='create.php?process=create'>Create New Catalog</a></div>
	</div>
	<div class="col-md-2 col-sm-2"></div>
	</div>
	<div class="row">
		<div class="col-md-2 col-sm-2"></div>
		<div class="col-md-8 col-sm-8">
			<table class="table table-striped">
    			<thead>
        		<tr>
            		<th>Row</th>
            		<th>Name</th>
            		<th>Recipe</th>
            		<th></th>
        		</tr>
    			</thead>
				<tbody>
				<?php
					echo $output;
				?>
				</tbody>
			</table>
		</div>
		<div class="col-md-2 col-sm-2"></div>
	</div>
</div>
</body>
</html>
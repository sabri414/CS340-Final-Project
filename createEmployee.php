<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$Playlist_id = $Playlist_name = $User_id = "";
$Playlist_id_err = $Playlist_name_err = $User_id_err = "" ;
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate Playlist name
    $Playlist_name = trim($_POST["Playlist_name"]);
    if(empty($Playlist_name)){
        $Playlist_name_err = "Please enter a Playlist name.";
    } elseif(!filter_var($Playlist_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $Playlist_name_err = "Please enter a valid Playlist name.";
    } 
 
    // Validate Playlist id
    $Playlist_id = trim($_POST["Playlist_id"]);
    if(empty($Playlist_id)){
        $Playlist_id_err = "Please enter a Playlist id.";     
    } elseif(!ctype_digit($Playlist_id)){
        $Playlist_id_err = "Please enter a positive integer value for Playlist id.";
    } 

    // Validate User id
    $User_id = trim($_POST["User_id"]);
    if(empty($User_id)){
        $User_id_err = "Please enter a User id.";     
    } elseif(!ctype_digit($User_id)){
        $User_id_err = "Please enter a positive integer value for User id.";
    } 
    
    // Check input errors before inserting in database
    if(empty($Playlist_name_err) && empty($Playlist_id_err) && empty($User_id_err) ){
        // Prepare an insert statement
        $sql = "INSERT INTO Playlist (Playlist_id, Playlist_name, User_id) 
		        VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isi", $param_pid, $param_pname, $param_uid);
            
            // Set parameters
			$param_pid = $Playlist_id;
            $param_pname = $Playlist_name;
			$param_uid = $User_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
				    header("location: index.php");
					exit();
            } else{
                echo "<center><h4>Error while creating new playlist</h4></center>";
				$Playlist_id_err = "Enter a unique Playlist id.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Playlist</h2>
                    </div>
                    <p>Please fill this form and submit to add a Playlist.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="form-group <?php echo (!empty($Playlist_id_err)) ? 'has-error' : ''; ?>">
                            <label>Playlist id</label>
                            <input type="text" name="Playlist_id" class="form-control" value="<?php echo $Playlist_id; ?>">
                            <span class="help-block"><?php echo $Playlist_id_err;?></span>
                        </div>
                 
						<div class="form-group <?php echo (!empty($Playlist_name_err)) ? 'has-error' : ''; ?>">
                            <label>Playlist Name</label>
                            <input type="text" name="Playlist_name" class="form-control" value="<?php echo $Playlist_name; ?>">
                            <span class="help-block"><?php echo $Playlist_name_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($Lname_err)) ? 'has-error' : ''; ?>">
                            <label>User id</label>
                            <input type="text" name="User_id" class="form-control" value="<?php echo $User_id; ?>">
                            <span class="help-block"><?php echo $User_id_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
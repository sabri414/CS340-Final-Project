<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$Song_id = $Song_title = $Record = $Artist = $Language = $Category = $Duration = $Artist_id = "";
$Song_id_err = $Song_title_err = $Record_err = $Artist_err = $Language_err = $Category_err = $Duration_err = $Artist_id_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate Song id
    $Song_id = trim($_POST["Song_id"]);
    if(empty($Song_id)){
        $Song_id_err = "Please enter a Song id.";     
    } elseif(!ctype_digit($Song_id)){
        $Song_id_err = "Please enter a positive integer value for Song id.";
    } 

    // Validate Song name
    $Song_title = trim($_POST["Song_Title"]);
    if(empty($Song_title)){
        $Song_title_err = "Please enter a Song title.";
    }

    // Validate Record label
    $Record = trim($_POST["Record_Label"]);
    if(empty($Record)){
        $Record_err = "Please enter a Record Label.";
    }

    // Validate Song name
    $Artist = trim($_POST["Artist"]);
    if(empty($Artist)){
        $Artist_err = "Please enter an Artist name.";
    } elseif(!filter_var($Artist, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $Artist_err = "Please enter a valid Artist name.";
    } 

    // Validate Language
    $Language = trim($_POST["Language"]);
    if(empty($Language)){
        $Language_err = "Please enter a Language.";
    } elseif(!filter_var($Language, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $Language_err = "Please enter a valid Language.";
    } 

    // Validate Category
    $Category = trim($_POST["Category"]);
    if(empty($Category)){
        $Category_err = "Please enter an Category.";
    } elseif(!filter_var($Artist, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $Category_err = "Please enter a valid Category.";
    } 

    // Validate Duration
    $Duration = trim($_POST["Duration"]);
    if(empty($Duration)){
        $Duration_err = "Please enter a Duration.";     
    } elseif(!ctype_digit($Duration)){
        $Duration_err = "Please enter a positive integer value for Duration.";
    }
 
    // Validate Artist id
    $Artist_id = trim($_POST["Artist_id"]);
    if(empty($Artist_id)){
        $Artist_id_err = "Please enter an Artist id.";     
    } elseif(!ctype_digit($Artist_id)){
        $Artist_id_err = "Please enter a positive integer value for Artist id.";
    } 
    
    // Check input errors before inserting in database
    if(empty($Song_id_err)  && empty($Song_title_err) && empty($Artist_err) && empty($Record_err) && empty($Category_err) && empty($Language_err) && empty($Duration_err) && empty($Artist_id_err)){
        // Prepare an insert statement
        $sql = "UPDATE Song SET Song_Title = ?, Record_Label = ?, Artist = ?, Language = ?, Category = ?, Duration = ?, Artist_id = ? 
		        WHERE Song_id = ?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssiii", $param_sname, $param_rl, $param_a, $param_l, $param_cat, $param_dur, $param_aid, $param_sid);
            
            // Set parameters
			$param_sid = $Song_id;
            $param_sname = $Song_title;
            $param_rl = $Record;
            $param_a = $Artist;
            $param_l = $Language;
            $param_cat = $Category;
            $param_dur = $Duration;
            $param_aid = $Artist_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
				    header("location: index.php");
					exit();
            } else{
                echo "<center><h4>Error while creating new playlist</h4></center>";
				$Playlist_id_err = "Enter a valid Playlist id.";
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
                        <h2>Add Song to Playlist</h2>
                    </div>
                    <p>Please fill this form and submit to add a Song to Playlist.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="form-group <?php echo (!empty($Song_id_err)) ? 'has-error' : ''; ?>">
                            <label>Song id</label>
                            <input type="text" name="Song_id" class="form-control" value="<?php echo $Song_id; ?>">
                            <span class="help-block"><?php echo $Song_id_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Song_title_err)) ? 'has-error' : ''; ?>">
                            <label>Song Title</label>
                            <input type="text" name="Song_Title" class="form-control" value="<?php echo $Song_title; ?>">
                            <span class="help-block"><?php echo $Song_title_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Record_err)) ? 'has-error' : ''; ?>">
                            <label>Record Label</label>
                            <input type="text" name="Record_Label" class="form-control" value="<?php echo $Record; ?>">
                            <span class="help-block"><?php echo $Record_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Artist_err)) ? 'has-error' : ''; ?>">
                            <label>Artist</label>
                            <input type="text" name="Artist" class="form-control" value="<?php echo $Artist; ?>">
                            <span class="help-block"><?php echo $Artist_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Language_err)) ? 'has-error' : ''; ?>">
                            <label>Language</label>
                            <input type="text" name="Language" class="form-control" value="<?php echo $Language; ?>">
                            <span class="help-block"><?php echo $Language_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Category_err)) ? 'has-error' : ''; ?>">
                            <label>Category</label>
                            <input type="text" name="Category" class="form-control" value="<?php echo $Category; ?>">
                            <span class="help-block"><?php echo $Category_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Duration_err)) ? 'has-error' : ''; ?>">
                            <label>Duration (seconds)</label>
                            <input type="text" name="Duration" class="form-control" value="<?php echo $Duration; ?>">
                            <span class="help-block"><?php echo $Duration_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Artist_id_err)) ? 'has-error' : ''; ?>">
                            <label>Artist id</label>
                            <input type="text" name="Artist_id" class="form-control" value="<?php echo $Artist_id; ?>">
                            <span class="help-block"><?php echo $Artist_id_err;?></span>
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
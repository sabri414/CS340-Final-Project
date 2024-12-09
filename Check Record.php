<!-- 
 Names:
Isabella Mann
Dennis Aguilar
Sabri Abounozha 
Hunter McCoy
Date: 12/8/2024 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Record Label</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper {
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
                        <h2>Search Record Label</h2>
                    </div>
                    <p>Please fill this form to search for songs by record label.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($Record_err)) ? 'has-error' : ''; ?>">
                            <label>Record Label</label>
                            <input type="text" name="Record" class="form-control" value="<?php echo $Record; ?>">
                            <span class="help-block"><?php echo $Record_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Return</a>
                    </form>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Define variables and initialize with empty values
                    $Record = "";
                    $Record_err = "";
                    
                    // Processing form data when form is submitted
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Validate Record Label
                        $Record = trim($_POST["Record"]);
                        if (empty($Record)) {
                            $Record_err = "Please enter a Record Label.";
                        } 
                        
                        // Check input errors before querying the database
                        if (empty($Record_err)) {
                            // Prepare a call to the stored procedure
                            $sql = "CALL CheckRecord(?)";
                            
                            if ($stmt = mysqli_prepare($link, $sql)) {
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt, "s", $param_rec);
                                
                                // Set parameters
                                $param_rec = $Record;
                                
                                // Attempt to execute the prepared statement
                                if (mysqli_stmt_execute($stmt)) {
                                    // Store result
                                    mysqli_stmt_store_result($stmt);
                                    
                                    // Bind result variables
                                    mysqli_stmt_bind_result($stmt, $song_title);
                                    
                                    // Check if any rows are returned
                                    if (mysqli_stmt_num_rows($stmt) > 0) {
                                        echo "<table class='table table-bordered table-striped'>";
                                            echo "<thead>";
                                                echo "<tr>";
                                                    echo "<th width=10%>Song_Title</th>";
                                                echo "</tr>";
                                            echo "</thead>";
                                            echo "<tbody>";
                                            while (mysqli_stmt_fetch($stmt)) {
                                                echo "<tr>";
                                                    echo "<td>" . htmlspecialchars($song_title) . "</td>";
                                                echo "</tr>";
                                            }
                                            echo "</tbody>";
                                        echo "</table>";
                                    } else {
                                        echo "<p class='lead'><em>No records were found.</em></p>";
                                    }
                                } else {
                                    echo "<center><h4>Error while searching for record label</h4></center>";
                                }
                            }
                            
                            // Close statement
                            mysqli_stmt_close($stmt);
                        }

                        // Close connection
                        mysqli_close($link);
                    }
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
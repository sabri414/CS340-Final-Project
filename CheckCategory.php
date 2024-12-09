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
    <title>Search Category Label</title>
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
                        <h2>Search Category Label</h2>
                    </div>
                    <p>Please fill this form to search for songs by Category label.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($Category_err)) ? 'has-error' : ''; ?>">
                            <label>Category Label</label>
                            <input type="text" name="Category" class="form-control" value="<?php echo $Category; ?>">
                            <span class="help-block"><?php echo $Category_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Return</a>
                    </form>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Define variables and initialize with empty values
                    $Category = "";
                    $Category_err = "";
                    
                    // Processing form data when form is submitted
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Validate Category Label
                        $Category = trim($_POST["Category"]);
                        if (empty($Category)) {
                            $Category_err = "Please enter a Category Label.";
                        } 
                        
                        // Check input errors before querying the database
                        if (empty($Category_err)) {
                            // Prepare a call to the stored procedure
                            $sql = "CALL CheckCategory(?)";
                            
                            if ($stmt = mysqli_prepare($link, $sql)) {
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt, "s", $param_cat);
                                
                                // Set parameters
                                $param_cat = $Category;
                                
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
                                        echo "<p class='lead'><em>No songs were found.</em></p>";
                                    }
                                } else {
                                    echo "<center><h4>Error while searching for Category label</h4></center>";
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
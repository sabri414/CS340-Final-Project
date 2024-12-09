<!-- 
 Names:
Isabella Mann
Dennis Aguilar
Sabri Abounozha 
Hunter McCoy
Date: 12/8/2024 -->
<?php
session_start();

if (isset($_GET["Ssn"]) && !empty(trim($_GET["Ssn"]))) {
    $_SESSION["Ssn"] = trim($_GET["Ssn"]);
} else {
    // URL doesn't contain Ssn parameter. Redirect to error page
    header("location: error.php");
    exit();
}

require_once "config.php";

// Delete an Song's Playlist after confirmation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["Ssn"]) && !empty($_SESSION["Ssn"])) {
        $Ssn = $_SESSION["Ssn"];

        // Prepare a delete statement
        $sql = "DELETE FROM SONG WHERE Ssn = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_Ssn);

            // Set parameters
            $param_Ssn = $Ssn;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records deleted successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Error deleting the song.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing the statement.";
        }
    } else {
        echo "Error: Ssn not set in session.";
    }

    // Close connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>
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
                        <h1>Delete Record</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="Ssn" value="<?php echo htmlspecialchars($_SESSION["Ssn"]); ?>"/>
                            <p>Are you sure you want to delete the record for <?php echo htmlspecialchars($_SESSION["Ssn"]); ?>?</p><br>
                            <input type="submit" value="Yes" class="btn btn-danger">
                            <a href="index.php" class="btn btn-default">No</a>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>